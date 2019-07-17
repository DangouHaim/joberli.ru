<?php
/*
Plugin Name: Layero - EDD Related Downloads
Plugin URI: http://layero.com
Description: Show related downloads by tag or category when using Easy Digital Downloads plugin.
Version: 1.1
Author: Layero.com
License: GPL2
Text Domain: layero-edd-related-downloads
Domain Path: languages

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as 
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
if(!class_exists('Layero_EDD_Related_Downloads')) {
class Layero_EDD_Related_Downloads{

	private static $instance = null;

	public static function layero_rltd_dwn_get_instance() {
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
		return self::$instance;
	}

	private function __construct() {
		add_action( 'edd_after_download_content', array( $this, 'layero_rltd_dwn_after_download_content' ), 120 );
		add_action( 'wp_enqueue_scripts', array( $this, 'layero_rltd_dwn_enqueue' ) );
		add_action( 'init', array( $this, 'load_textdomain' ) );
		add_filter( 'edd_settings_extensions', array( $this, 'layero_rltd_dwn_eddrd_add_settings' ) );
		add_action( 'widgets_init', array( $this, 'layero_rltd_dwn_register_widgets' ) );
		//add_filter('plugin_row_meta', array( $this, 'layero_rltd_dwn_docs_link' ), 10, 2);

		if( ! defined( 'EDDRD_PLUGIN_DIR' ) )
			define( 'EDDRD_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
		require_once EDDRD_PLUGIN_DIR . 'widget-layero-edd-related.php';
    }

   	function layero_rltd_dwn_enqueue() {
		if ( is_singular( 'download' ) ) {
            wp_register_style('layero-edd-related-downloads', plugins_url('/layero-edd-related-downloads.css', __FILE__));
            wp_enqueue_style('layero-edd-related-downloads');
		}
	}

	function load_textdomain() {
		load_plugin_textdomain( 'layero-edd-related-downloads', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
	}

	/**
	 * Add settings to the "Easy Digital Downloads > Settings > Misc" section
	 * @since 1.0
	 */
	function layero_rltd_dwn_eddrd_add_settings( $settings ) {
	
		$layero_eddrd_settings = array(
			array(
				'id' => 'layero_eddrd_settings',
				'name' => '<h3 class="title">'. esc_html__('Related Downloads Settings', 'layero-edd-related-downloads') . '</h3>',
				'desc' => esc_html__( 'Settings for EDD Related Downloads Plugin.', 'layero-edd-related-downloads'),
				'type' => 'header'
			),
			array(
				'id' => 'related_filter_by_cat',
				'name' => esc_html__('Filter related downloads by category:', 'layero-edd-related-downloads'), 
				'desc' => esc_html__( 'Check this to filter by category. By default, downloads are related by tag.', 'layero-edd-related-downloads'),
				'type' => 'checkbox'
			),
			array(
				'id' => 'related_dl_only_image',
				'name' => esc_html__('Show only image:', 'layero-edd-related-downloads'), 
				'desc' => esc_html__( 'Check this to show only the related download image without the title.', 'layero-edd-related-downloads'),
				'type' => 'checkbox'
			),
			array(
				'id' => 'related_showposts_num',
				'name' => esc_html__('How many related items to show:', 'layero-edd-related-downloads'), 
				'desc' => esc_html__( 'Enter a decent number, like between 1 and 7. Default is 3.', 'layero-edd-related-downloads'),
				'type' => 'text',
			),
			array(
				'id' => 'related_dl_title',
				'name' => esc_html__('Custom Related Downloads Title:', 'layero-edd-related-downloads'), 
				'desc' => esc_html__( 'This appears above the related items. Default is, "You May Also Like".', 'layero-edd-related-downloads'),
				'type' => 'text'
			),
			array(
				'id' => 'disable_related_in_content',
				'name' => esc_html__('Disable Related Downloads Added To Content:', 'layero-edd-related-downloads'), 
				'desc' => esc_html__( 'Check this to stop the them from being added to the bottom of the single download content. Useful if you are using the sidebar widget instead. Or you could leave this in, set to category, and the widget set to tags, or vice-versa.', 'layero-edd-related-downloads'),
				'type' => 'checkbox'
			),
			array(
				'id' => 'related_dl_orderby',
				'name' => esc_html__('Change The Default Method of Sorting (Orderby)', 'layero-edd-related-downloads'), 
				'desc' => esc_html__( 'Choose what the related downloads are sorted by. Default is by "date".', 'layero-edd-related-downloads'),
				'type' => 'select',
				'options' => array('date' => 'date','ID' => 'ID','author' => 'author','title' => 'title','name' => 'name (post slug)','modified' => 'modified (last modified date)','parent' => 'parent','rand' => 'random','comment_count' => 'comment_count')
			),
array(
				'id' => 'related_dl_order',
				'name' => esc_html__('Change The Default Sort Order', 'layero-edd-related-downloads'), 
				'desc' => esc_html__( 'Choose the default sort order for the related downloads. Default is "DESC".', 'layero-edd-related-downloads'),
				'type' => 'select',
				'options' => array('DESC' => 'DESC','ASC' => 'ASC')
			),
		);
	
		/* Merge plugin settings with original EDD settings */
		return array_merge( $settings, $layero_eddrd_settings );
	}

	/**
	 * Adds related items on the single download page, underneath content
	 * @since 0.1
	 */

	function layero_rltd_dwn_after_download_content() {
	    global $post, $data, $edd_options;
	// Compatibility fix for EDD Hide Download: save the current download's post id, in order to exclude it later
		$exclude_post_id = $post->ID;
		$taxchoice = isset( $edd_options['related_filter_by_cat'] ) ? 'download_category' : 'download_tag';
		$custom_taxterms = wp_get_object_terms( $post->ID, $taxchoice, array('fields' => 'ids') );

		$howmany = ( 
						isset( $edd_options['related_showposts_num'] ) && 
						! empty( $edd_options['related_showposts_num'] )
					)
					? $edd_options['related_showposts_num'] : 3;

		$related_dl_title = (
								isset( $edd_options['related_dl_title'] ) && 
								( '' != $edd_options['related_dl_title'] )
							)
							? $edd_options['related_dl_title'] : esc_html__('Вам также может понравиться', 'layero-edd-related-downloads');					

		$loop_orderby = isset( $edd_options['related_dl_orderby'] ) ? $edd_options['related_dl_orderby'] : 'date';
		$loop_order = isset( $edd_options['related_dl_order'] ) ? $edd_options['related_dl_order'] : 'DESC';
		
		if ( ! empty($custom_taxterms) ) {
			$args = array(
					'post_type' => 'download',
					'post__not_in' => array($post->ID),
					'showposts' => $howmany,
					'tax_query' => array(
							array(
								'taxonomy' => $taxchoice,
								'field' => 'id',
								'terms' => $custom_taxterms
							)
						),
					'orderby' => $loop_orderby,
					'order' => $loop_order
			);
	 
			$eddrd_query = new WP_Query($args);
			$go = isset( $edd_options['disable_related_in_content'] ) ? '' : 'go';
           
			if( $eddrd_query->have_posts() && $go  ) { ?>
				<div id="layero-related-downloads">
					<h3><?php echo $related_dl_title; ?></h3>
					<div id="edd-related-items-wrapper" class="edd-rp-single">
						<?php $countRow = 1; // Editted: for creating 3 item rows
						while ($eddrd_query->have_posts()) {
								$eddrd_query->the_post();
								if ($post->ID == $exclude_post_id) continue;

								if ($countRow%3 == 1) { // Editted: for creating 3 item rows
									echo "<div class='row'>";
								}	?>
					                <div class="col-md-4">
						                <div class="edd_download_inner">
											<div class="thumb">
												<?php
												$thumbID=get_post_thumbnail_id(get_the_ID());
												$featImage=wp_get_attachment_image_src($thumbID,'olam-product-thumb');
												$featImage=$featImage[0]; 
												$alt = get_post_meta($thumbID, '_wp_attachment_image_alt', true);

												$square_img = get_post_meta(get_the_ID(),"download_item_square_img");

											// feat vid code start
												$videoCode=get_post_meta(get_the_ID(),"download_item_video_id"); 
												$audioCode=get_post_meta(get_the_ID(),"download_item_audio_id");		
												$itemSet=null;		
												$featFlag=null;	
												$videoFlag=null;				
												if(isset($videoCode[0]) && (strlen($videoCode[0])>0) ){
													$itemSet=1;	
													$videoUrl=$videoCode[0];
													//$videoUrl=wp_get_attachment_url($videoCode[0]); 
													
													$videoFlag=1; ?>
													<div class="media-thumb">
														<?php echo do_shortcode("[video src='".$videoUrl."']"); ?>
													</div> <?php
												}
												else if (!empty($square_img) && strlen($square_img[0])>0) {
													$featFlag=1; ?>
							               		    <a href="<?php the_permalink(); ?>">
														<span><i class="demo-icons icon-link"></i></span>
														<img src="<?php echo esc_url($square_img[0]); ?>" />
													</a> <?php
							                 	}
												else if((isset($featImage))&&(strlen($featImage)>0)){
													$featFlag=1;
													$alt = get_post_meta($thumbID, '_wp_attachment_image_alt', true); ?>
													<a href="<?php the_permalink(); ?>">
														<span><i class="demo-icons icon-link"></i></span>
														<img src="<?php echo esc_url($featImage); ?>" alt="<?php echo esc_attr($alt); ?>">
													</a><?php
												}
												if(!isset($videoFlag)){ 
													if(isset($audioCode[0]) && (strlen($audioCode[0])>0) ){
														$itemSet=1;
														$audioUrl=wp_get_attachment_url($audioCode[0]);
														?>
														<div class="media-thumb">
															<?php echo do_shortcode("[audio src='".$audioUrl."']"); ?>
														</div> <?php
													}

												} ?>
												<?php if(!(isset($featFlag))){ ?>
												<a href="<?php the_permalink(); ?>">
													<span><i class="demo-icons icon-link"></i></span>
													<img src="<?php echo get_template_directory_uri(); ?>/img/preview-image-default.jpg" alt="<?php echo esc_attr($alt); ?>">
												</a>
												<?php } ?>

											</div>
											<div class="product-details">
											<div class="product-name"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></div>
											<div class="product-price"><?php edd_price(get_the_ID()); ?></div>
											<?php if ( has_excerpt() ) : // Only show custom excerpts not autoexcerpts ?>
												<p class="olam-custom-excerpt"><?php echo get_the_excerpt(); ?></p>
											<?php endif; ?>
											Автор:<a style="padding-top:10px;" href="<?php echo esc_url(add_query_arg( 'author_downloads', 'true', get_author_posts_url( get_the_author_meta('ID')) )); ?>"><?php esc_html_e("","olam"); ?> <?php the_author(); ?></a>
											<div class="details-bottom">
												<div class="product-options">	
												<?if(is_user_logged_in()):?>
												<a href="#" data-id="<? echo get_the_ID(); ?>" class="post-save" title="<?php esc_attr_e('Сохранить','olam'); ?> "><i class="demo-icons icon-like"></i></a>  
												<?else:?>
												<a href="#" data-id="<? echo get_the_ID(); ?>" class="noLoggedUser" title="<?php esc_attr_e('Сохранить','olam'); ?> "><i class="demo-icons icon-like"></i></a>
												<?endif?>   
													<?php if(!olam_check_if_added_to_cart(get_the_ID())){ 
														$eddOptionAddtocart=edd_get_option( 'add_to_cart_text' );
														$addCartText=(isset($eddOptionAddtocart) && $eddOptionAddtocart  != '') ?$eddOptionAddtocart:esc_html__("Добавить в корзину","olam");
														if(edd_has_variable_prices(get_the_ID())){														
															$defaultPriceID=edd_get_default_variable_price( get_the_ID() );
															$downloadArray=array('edd_action'=>'ade_to_cart','download_id'=>get_the_ID(),'edd_options[price_id]'=>$defaultPriceID);
														}
														else{
															$downloadArray=array('edd_action'=>'ade_to_cart','download_id'=>get_the_ID());
														}	
														?>
																													<?if(is_user_logged_in()):?>
													<a href="<?php echo esc_url(add_query_arg($downloadArray,edd_get_checkout_uri())); ?>" title="<?php esc_attr_e('Купить сейчас','olam'); ?>"><i class="demo-icons icon-download"></i></a>
													<?else:?>
													<a href="#" class="noLoggedUser"  title="<?php esc_attr_e('Купить сейчас','olam'); ?>"><i class="demo-icons icon-download"></i></a>
													<?endif?>
														<a href="<?php echo esc_url(add_query_arg($downloadArray,olam_get_current_page_url())); ?>" title="<?php echo esc_html($addCartText); ?>"><i class="demo-icons icon-cart"></i></a>   
														<?php } else { ?>
														<a class="cart-added" href="<?php echo esc_url(edd_get_checkout_uri()); ?>" title="<?php esc_attr_e('Checkout','olam'); ?> "><i class="fa fa-check"></i></a>    
														<?php } ?>
													</div>
													<?php $olamct=get_theme_mod('olam_show_cats');
															if(isset($olamct)&& $olamct==1 ){

														$cat = wp_get_post_terms(get_the_ID(),'download_category');
														$mlink = get_term_link($cat[0]->slug, 'download_category');
														?><div class="product-author"><a href="<?php echo $mlink; ?>"><?php echo($cat[0]->name); ?></a></div><?php
														}
														else{
														?> <div class="product-author"><a href="<?php echo esc_url(add_query_arg( 'author_downloads', 'true', get_author_posts_url( get_the_author_meta('ID')) )); ?>"><?php esc_html_e("By","olam"); ?>: <?php the_author(); ?></a></div><?php
														}
														?>
													</div>
												</div>
											</div>
									</div>

								<?php if ($countRow%3 == 0) { // Editted: for creating 3 item rows
									echo "</div>";
								}
								$countRow++; ?>
						<?php } ?>
						<?php if ($countRow%3 != 1) echo "</div>"; // Editted: for creating 3 item rows
					// This is to ensure there is no open div if the number of elements is not a multiple of 3 ?>
				</div>
			</div>
				<?php wp_reset_query();
			}
		}
	}
	
	/** 
	 * Registers the EDD Related Downloads Widget.
	 * @since 1.3
	 */
	function layero_rltd_dwn_register_widgets() {
		register_widget( 'layero_edd_related_downloads_widget' );
	}

	
}
}
$Layero_EDD_Related_Downloads = Layero_EDD_Related_Downloads::layero_rltd_dwn_get_instance();

/**
 * Check if an item exists or is added to cart already.
 */
if( ! function_exists( 'layero_rltd_dwn_check_if_added_to_cart' ) ){
  function layero_rltd_dwn_check_if_added_to_cart( $itemID ) {

    $cartItems=edd_get_cart_contents();
    $cartIDs=layero_rltd_dwn_get_cart_IDs($cartItems);
    if(in_array($itemID, $cartIDs)){
      return true;
    }
    return false;
  }
}
/**
 * Getting the cart item ids.
 */
if( ! function_exists( 'layero_rltd_dwn_get_cart_IDs' ) ){
  function layero_rltd_dwn_get_cart_IDs( $cartItems ) {

    $cartIDs=array();
    if(is_array($cartItems)){
      foreach ($cartItems as $cartItemkey => $cartItemvalue) {
        $cartIDs[]=$cartItemvalue['id'];
      }
    }
    return $cartIDs;
  }
}