<?php

if(!olam_check_edd_exists()){
	return;
}

/**
 * Olam Product Details Widget
 *
 */

add_action('widgets_init', 'olam_download_details_widget');

function olam_download_details_widget()
{
	register_widget('olam_download_details_widget');
}

class olam_download_details_widget extends WP_Widget {
	/** Constructor */
	public function __construct() {
		parent::__construct(
			'olam_download_details_widget',
			sprintf( esc_html__( 'Olam %s Детали', 'olam' ), edd_get_label_singular() ),
			array(
				'description' => sprintf( esc_html__( 'Показать детали конкретного %s', 'olam' ), edd_get_label_singular() ),
				)
			);
	}

	/** @see WP_Widget::widget */
	public function widget( $args, $instance ) {
		$args['id'] = ( isset( $args['id'] ) ) ? $args['id'] : 'edd_download_details_widget';
		if ( ! isset( $instance['download_id'] ) || ( 'current' == $instance['download_id'] && ! is_singular( 'download' ) ) ) {
			return;
		}
		// set correct download ID
		if ( 'current' == $instance['download_id'] && is_singular( 'download' ) ) {
			$download_id = get_the_ID();
		} else {
			$download_id = absint( $instance['download_id'] );
		}
		// Variables from widget settings
		$title              = apply_filters( 'widget_title', $instance['title'], $instance, $args['id'] );
		$download_title 	= $instance['download_title'] ? apply_filters( 'edd_product_details_widget_download_title', '<h3>' . get_the_title( $download_id ) . '</h3>', $download_id ) : '';
		$purchase_button = $instance['purchase_button'] ? apply_filters( 'edd_product_details_widget_purchase_button', edd_get_purchase_link( array( 'download_id' => $download_id ) ), $download_id ) : '';
		$categories 		= $instance['categories'] ? $instance['categories'] : '';
		$tags 				= $instance['tags'] ? $instance['tags'] : '';
		// Used by themes. Opens the widget
		echo $args['before_widget']; ?>
		<div class="cart-box">
			<?php if(isset($title)&&strlen($title)>0){ ?>
				<div class="sidebar-title"><?php echo esc_html($title); ?></div>
			<?php } ?>
			<div class="sw-price">
				<?php
				if(edd_has_variable_prices($download_id)){
					echo edd_price_range( $download_id );
				}
				else{
					edd_price($download_id);
				}
				?>
			</div>
			<?php
			do_action( 'edd_product_details_widget_before_title' , $instance , $download_id );
			do_action( 'edd_product_details_widget_before_purchase_button' , $instance , $download_id );
		// purchase button
			echo ($purchase_button);
			                    
		// categories and tags
			$category_list     = $categories ? get_the_term_list( $download_id, 'download_category', '', ', ' ) : '';
			$category_count    = count( get_the_terms( $download_id, 'download_category' ) );
			$category_labels   = edd_get_taxonomy_labels( 'download_category' );
			$category_label    = $category_count > 1 ? esc_html__('Категория','olam') : esc_html__('Категории','olam');
			$tag_list     = $tags ? get_the_term_list( $download_id, 'download_tag', '', ', ' ) : '';
			$tag_count    = count( get_the_terms( $download_id, 'download_tag' ) );
			$tag_taxonomy = edd_get_taxonomy_labels( 'download_tag' );
			$tag_label    = $tag_count > 1 ? esc_html__('Тег','olam') : esc_html__('Теги','olam');
			$text = ''; ?>
		</div>
		<?php if( $category_list || $tag_list ) {
			$text .= '<div class="edd-meta">';
			if( $category_list ) {
				$text .= '<div class="sidebar-item"><div class="sidebar-title"><i class="demo-icons icon-folder"></i> %1$s</div> <div class="categories">%2$s</div></div>';
			}
			if ( $tag_list ) {
				$text .= '<div class="sidebar-item"><div class="sidebar-title"><i class="fa fa-tag"></i> %3$s</div> <div class="tags">%4$s</div></div>';
			}
			$text .= '</div>';
		}
		do_action( 'edd_product_details_widget_before_categories_and_tags', $instance, $download_id );
		printf( $text, $category_label, $category_list, $tag_label, $tag_list );
		do_action( 'edd_product_details_widget_before_end', $instance, $download_id ); ?>
		<?php // Used by themes. Closes the widget
		echo $args['after_widget'];
	}
	
	/** @see WP_Widget::form */
	public function form( $instance ) {
		// Set up some default widget settings.
		$defaults = array(
			'title' 			=> sprintf( esc_html__( '%s Детали', 'olam' ), edd_get_label_singular() ),
			'display_type'    => 'current',
			'download_id'     => false,
			'download_title'  => 'on',
			'purchase_button' => 'on',
			'categories'      => 'on',
			'tags'            => 'on',
			);
			$instance = wp_parse_args( (array) $instance, $defaults ); ?>
			<!-- Title -->
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Заголовок:', 'olam' ) ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr($instance['title']); ?>" />
			</p>
			<!-- Download -->
			<?php
			$args = array(
				'post_type'      => 'download',
				'posts_per_page' => -1,
				'post_status'    => 'publish',
				);
			$downloads = get_posts( $args );
			?>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'download_id' ) ); ?>"><?php printf( esc_html__( '%s', 'olam' ), edd_get_label_singular() ); ?></label>
				<select class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'download_id' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'download_id' ) ); ?>">
					<option value="current"><?php esc_html_e( 'Текущий', 'olam' ); ?></option>
					<?php foreach ( $downloads as $download ) { ?>
					<option <?php selected( absint( $instance['download_id'] ), $download->ID ); ?> value="<?php echo esc_attr( $download->ID ); ?>"><?php echo esc_html($download->post_title); ?></option>
					<?php } ?>
				</select>
			</p>
			<!-- Download title -->
			<p>
				<input <?php checked( $instance['download_title'], 'on' ); ?> id="<?php echo esc_attr( $this->get_field_id( 'download_title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'download_title' ) ); ?>" type="checkbox" />
				<label for="<?php echo esc_attr( $this->get_field_id( 'download_title' ) ); ?>"><?php esc_html_e( 'Показать название', 'olam' ); ?></label>
			</p>
			<!-- Show purchase button -->
			<p>
				<input <?php checked( $instance['purchase_button'], 'on' ); ?> id="<?php echo esc_attr( $this->get_field_id( 'purchase_button' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'purchase_button' ) ); ?>" type="checkbox" />
				<label for="<?php echo esc_attr( $this->get_field_id( 'purchase_button' ) ); ?>"><?php esc_html_e( 'Показать кнопку покупки', 'olam' ); ?></label>
			</p>
			<!-- Show download categories -->
			<p>
				<?php $category_labels = edd_get_taxonomy_labels( 'download_category' ); ?>
				<input <?php checked( $instance['categories'], 'on' ); ?> id="<?php echo esc_attr( $this->get_field_id( 'categories' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'categories' ) ); ?>" type="checkbox" />
				<label for="<?php echo esc_attr( $this->get_field_id( 'categories' ) ); ?>"><?php printf( esc_html__( 'Показать %s', 'olam' ), $category_labels['name'] ); ?></label>
			</p>
			<!-- Show download tags -->
			<p>
				<?php $tag_labels = edd_get_taxonomy_labels( 'download_tag' ); ?>
				<input <?php checked( $instance['tags'], 'on' ); ?> id="<?php echo esc_attr( $this->get_field_id( 'tags' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'tags' ) ); ?>" type="checkbox" />
				<label for="<?php echo esc_attr( $this->get_field_id( 'tags' ) ); ?>"><?php printf( esc_html__( 'Показать %s', 'olam' ), $tag_labels['name'] ); ?></label>
			</p>
			<?php do_action( 'edd_product_details_widget_form' , $instance ); ?>
			<?php }
			/** @see WP_Widget::update */
			public function update( $new_instance, $old_instance ) {
				$instance = $old_instance;
				$instance['title']           = strip_tags( $new_instance['title'] );
				$instance['download_id']     = strip_tags( $new_instance['download_id'] );
				$instance['download_title']  = isset( $new_instance['download_title'] )  ? $new_instance['download_title']  : '';
				$instance['purchase_button'] = isset( $new_instance['purchase_button'] ) ? $new_instance['purchase_button'] : '';
				$instance['categories']      = isset( $new_instance['categories'] )      ? $new_instance['categories']      : '';
				$instance['tags']            = isset( $new_instance['tags'] )            ? $new_instance['tags']            : '';
				do_action( 'edd_product_details_widget_update', $instance );
				return $instance;
			}
		}