<?php

if(!olam_check_edd_exists()){
	return;
}

add_action('widgets_init', 'olam_fes_fields_widget');

function olam_fes_fields_widget()
{
	register_widget('olam_fes_fields_widget');
}

class olam_fes_fields_widget extends WP_Widget {

	function __construct()
	{
		$widget_ops = array('classname' => 'olam_fes_fields_widget', 'description' => esc_html__('Displays Product Specifications when using EDD FES extension, used in Single Download Sidebar','olam'));
		$control_ops = array('id_base' => 'olam_fes_fields_widget');
		parent::__construct('olam_fes_fields_widget', esc_html__('Olam FES поля','olam'), $widget_ops, $control_ops);
		
	}

	function widget($args, $instance)
	{
		extract($args);
		$title = $instance['title'];
		echo $before_widget;

		$features = get_post_meta(get_the_ID(),"download_features");
		if (!empty($features)) { ?>
			<div class="sidebar-item">
				<div class="sidebar-title"><?php echo esc_html($title); ?></div>
				<div class="details-table">
					<ul>
						<?php foreach ($features as $feature => $values) {
							foreach ($values as $value) { ?>
								<li>
									<span><?php echo $value[0]; ?></span>
									<span><?php echo $value[1]; ?></span>
								</li>
							<?php }
						}	?>
					</ul>
				</div>
			</div>
		<?php }
		
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
		$defaults = array('title' => esc_html__('Детали','olam') );
		$instance = wp_parse_args((array) $instance, $defaults); ?>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Заголовок','olam');?>:</label>
			<input id="<?php echo esc_attr($this->get_field_id('title')); ?>" class="widefat" name="<?php echo esc_attr($this->get_field_name('title')); ?>" value="<?php echo esc_attr($instance['title']); ?>" />
		</p>
	<?php }
}