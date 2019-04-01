<?php

if(!olam_check_edd_exists()){
	return;
}

add_action('widgets_init', 'olam_cart_count_widget');

function olam_cart_count_widget()
{
	register_widget('olam_cart_count_widget');
}

class olam_cart_count_widget extends WP_Widget {

	function __construct()
	{
		$widget_ops = array('classname' => 'olam_cart_count_widget', 'description' => esc_html__('Displays the cart count. Used in Single Download Sidebar','olam'));
		$control_ops = array('id_base' => 'olam_cart_count_widget');
		parent::__construct('olam_cart_count_widget', esc_html__('Olam Cart Count','olam'), $widget_ops, $control_ops);
		
	}

	function widget($args, $instance)
	{
		extract($args);
		$title = $instance['title'];
		echo $before_widget;
		?>
		<div class="sidebar-item">
			<div class="cart-sidebar-widget">
				<div class="cw-title"><?php echo esc_html($title); ?></div>
				<div class="cw-item-count"><i class="demo-icons icon-cart"></i><span class="olam-cart-count"><?php echo edd_get_cart_quantity(); ?></span> <?php esc_html_e("Items","olam"); ?></div>
			</div>
		</div>
		<?php
		echo $after_widget;
	}

	function update($new_instance, $old_instance)
	{
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		return $instance;
	}
	
	function form($instance)
	{
		$defaults = array('title' => esc_html__('Your Cart','olam') );
		$instance = wp_parse_args((array) $instance, $defaults); ?>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title','olam');?>:</label>
			<input id="<?php echo esc_attr($this->get_field_id('title')); ?>" class="widefat" name="<?php echo esc_attr($this->get_field_name('title')); ?>" value="<?php echo esc_attr($instance['title']); ?>" />
		</p>
		<?php }
	}