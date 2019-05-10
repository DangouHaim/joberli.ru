<?php

if(!olam_check_edd_exists()){
	return;
}
add_action('widgets_init', 'olam_downloads_author_widget');

function olam_downloads_author_widget()

{

	register_widget('olam_downloads_author_widget');

}

class olam_downloads_author_widget extends WP_Widget {
	

	function __construct()

	{

		$widget_ops = array('classname' => 'olam_downloads_author_widget', 'description' => esc_html__('Displays the author download items. Used in Single Download Sidebar','olam'));
		$control_ops = array('id_base' => 'olam_downloads_author_widget');
		parent::__construct('olam_downloads_author_widget', esc_html__('Olam author downloads','olam'), $widget_ops, $control_ops);

	}

	function widget($args, $instance)

	{

		extract($args);

		$title = $instance['title'];
		$subtitle = $instance['sub_title'];
		$enableVendorContactForm = isset($instance['enable_vendor_contact_form'])?$instance['enable_vendor_contact_form']:null;
		$sendMessageText = isset($instance['send_message_text'])?$instance['send_message_text']:null;
		echo $before_widget;
		global $post;
		$author = $post->post_author;
		?>

		<div class="sidebar-title"><i class="demo-icons icon-user"></i><?php echo esc_html($title); ?></div>                                             
		<div class="user-info">
			<?php 	$avatarCustom=get_the_author_meta('authorbanner', $author);
			$avatarFES=get_the_author_meta('user_avatar', $author);
			if(isset($avatarCustom) && (strlen($avatarCustom)>0) ){
				$avatarUrl=$avatarCustom;
			}
			else if(isset($avatarFES) && (strlen($avatarFES)>0) ){
				$avatarUrl=$avatarFES;
			}
			else if(isset($author->user_email)&&olam_validate_gravatar($author->user_email)){
				$avatarUrl=get_avatar_url($author);
			}
			if( isset($avatarUrl) && (strlen($avatarUrl)>0) ) { ?>  <div class="author-pic"><img src="<?php echo esc_url($avatarUrl) ?>" alt=""></div><?php } ?>			
			<div class="author-details"><?php echo esc_html($subtitle); ?>
				<?php
				$authorID= get_the_author_meta( 'ID' );
				$authorPostsUrl=olam_build_author_url($authorID);
				$authorChatUrl=olam_build_author_chat_url($authorID, true);
				?>
				<strong><a href="<?php echo esc_url($authorPostsUrl); ?>"><?php the_author(); ?></a></strong>
				<strong><a href="<?php echo esc_url($authorChatUrl); ?>">Написать</a></strong>
			</div>
			<ul class="user-badges">

				<?php $args=array("post_type"=>"download","status"=>"publish","author"=> $authorID,'showposts'=>3);
				$postsArray= get_posts($args); 
				foreach ($postsArray as $postsArraykey => $postsvalue) { ?>
				<?php
				$featImage=null;
				$theDownloadImage=get_post_meta($postsvalue->ID,'download_item_thumbnail_id'); 
				if(is_array($theDownloadImage) && (count($theDownloadImage)>0) ){
					$thumbID=$theDownloadImage[0];
					$featImage=wp_get_attachment_image_src($thumbID,'olam-product-thumb-small');
					$featImage=$featImage[0];
				}
				else{
					$thumbID=get_post_thumbnail_id($postsvalue->ID);
					$featImage=wp_get_attachment_image_src($thumbID,'thumbnail');
					$featImage=$featImage[0];
				}						
				?>
				<li><a href="<?php echo get_permalink($postsvalue); ?>"><?php if(isset($featImage)){ ?><img src="<?php echo esc_url($featImage); ?>" alt="author download image"><?php } else { ?> <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/thumbnail.png" alt="author download image"><?php } ?></a></li>
				<?php 	} ?>

			</ul>
			<?php
			if ($enableVendorContactForm == 'on')
				{ ?>
			<div class="author-contactform">
				<div class="author-contact-form">

					<?php 
					if(is_author()){ 
						$author_id = get_user_by( 'id', get_query_var( 'author' ) );
						$author_id=$author_id->ID;

					}
					else if(is_singular('download')){
						global $post;
						$author_id=$post->post_author;


					}
					else{
						return;
					}
					?>
					<a href="#" class="author-contact-button btn btn-primary btn-sm"><?php echo esc_html($sendMessageText); ?></a>
				</div>

				<!-- Author contact popup -->
				<div id="authorContact" class="lightbox-wrapper">
					<div class="lightbox-content">
						<div class="lightbox-area">
							<div class="lightbox">
								<div class="boxed">
									<div class="lightbox-close">
										<div class="close-btn">
											<span class="close-icon">
												<i class="demo-icon icon-cancel"></i>
											</span>
										</div>
									</div>
									<div class="boxed-body author-contact-area">
										<?php echo do_shortcode( '[fes_vendor_contact_form id="'.$author_id.'"]' );  ?>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="lightbox-overlay"></div>
				</div>
			</div>
			<?php
		}
		?>
	</div>

	<?php

	echo $after_widget;

}

function update($new_instance, $old_instance)

{

	$instance = $old_instance;
	$instance['title'] = strip_tags($new_instance['title']);
	$instance['sub_title'] =strip_tags($new_instance['sub_title']);	
	$instance['enable_vendor_contact_form'] =strip_tags($new_instance['enable_vendor_contact_form']);
	$instance['send_message_text'] =strip_tags($new_instance['send_message_text']);

	return $instance;

}

function form($instance)

{

	$defaults = array('title' => esc_html__('Author','olam'), 'sub_title' => esc_html__('Копирайт 2015','olam'),'enable_vendor_contact_form'=>esc_html__('on','olam'),'send_message_text'=>esc_html__('Отправить сообщение','olam'));

	$instance = wp_parse_args((array) $instance, $defaults); ?>

	<p>
		<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Заголовок','olam');?>:</label>
		<input id="<?php echo esc_attr($this->get_field_id('title')); ?>" class="widefat" name="<?php echo esc_attr($this->get_field_name('title')); ?>" value="<?php echo esc_attr($instance['title']); ?>" />

	</p>
	<p>
		<label for="<?php echo esc_attr($this->get_field_id('sub_title')); ?>"><?php esc_html_e('Подзаголовок','olam');?>:</label>
		<input  id="<?php echo esc_attr($this->get_field_id('sub_title')); ?>" class="widefat" name="<?php echo esc_attr($this->get_field_name('sub_title')); ?>" value="<?php echo esc_attr($instance['sub_title']); ?>" />
	</p>
	<p>
		<input  type="checkbox"  <?php checked( $instance[ 'enable_vendor_contact_form' ], 'on' ); ?> id="<?php echo esc_attr($this->get_field_id('enable_vendor_contact_form')); ?>" class="widefat" name="<?php echo esc_attr($this->get_field_name('enable_vendor_contact_form')); ?>"  />
		<label for="<?php echo esc_attr($this->get_field_id('enable_vendor_contact_form')); ?>"><?php esc_html_e('Включить форму продавца','olam');?>:</label>

	</p>
	<p>
		<label for="<?php echo esc_attr($this->get_field_id('send_message_text')); ?>"><?php esc_html_e('Отправить сообщение','olam');?>:</label>
		<input  id="<?php echo esc_attr($this->get_field_id('send_message_text')); ?>" class="widefat" name="<?php echo esc_attr($this->get_field_name('send_message_text')); ?>" value="<?php echo esc_attr($instance['send_message_text']); ?>" />

	</p>

	<?php }
}