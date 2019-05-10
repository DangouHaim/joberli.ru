<?php
if(!olam_check_edd_exists()){
	return;
}
add_action('widgets_init', 'olam_vendor_contactform_widget');
function olam_vendor_contactform_widget()
{ register_widget('olam_vendor_contactform_widget'); }
class olam_vendor_contactform_widget extends WP_Widget {
	function __construct() {
		$widget_ops = array('classname' => 'olam_vendor_contactform_widget', 'description' => esc_html__('Vendor Contact Form widget. Used in Author Downloads Page. ','olam'));
		$control_ops = array('id_base' => 'olam_vendor_contactform_widget');
		parent::__construct('olam_vendor_contactform_widget', esc_html__('Olam Vendor Contact Form widget','olam'), $widget_ops, $control_ops);
	} function widget($args, $instance)	{
		extract($args);		
		$title = $instance['title'];
		echo $before_widget;
		?>
		<div class="author-contactform">
			<?php if(isset($title)&& (strlen($title)>0) ) { ?><div class="sidebar-title"><?php echo esc_html($title); ?> </div> <?php } ?>
			<div class="author-contact-form">
				<?php 
				if(is_author()){
					$author_id = get_user_by( 'id', get_query_var( 'author' ) );
					$author_id=$author_id->ID;
				}
				else if(is_singular('download')){
					global $post;$author_id=$post->post_author;
					
				}
				else{
					return;
				}
				?>
				<a href="#" class="author-contact-button btn btn-primary btn-sm"><?php esc_html_e("Отправить сообщение","olam"); ?></a>
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
		echo $after_widget;
	}
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		return $instance;
	} function form($instance) {
		$defaults = array('title' => esc_html__('Форма связи с продавцом',"olam"));
		$instance = wp_parse_args((array) $instance, $defaults); ?>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Заголовок','olam');?>:</label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" value="<?php echo esc_attr($instance['title']); ?>" />
		</p>
		<?php }
	}