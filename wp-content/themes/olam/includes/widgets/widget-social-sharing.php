<?php
if(!olam_check_edd_exists()){
	return;
}

add_action('widgets_init', 'olam_social_share_widget');

function olam_social_share_widget()
{
	register_widget('olam_social_share_widget');
}

class olam_social_share_widget extends WP_Widget {

	function __construct()
	{
		$widget_ops = array('classname' => 'olam_social_share_widget', 'description' => esc_html__('Social Share icons widget. Used in Single Download Sidebar	','olam'));
		$control_ops = array('id_base' => 'olam_social_share_widget');
		parent::__construct('olam_social_share_widget', esc_html__('Olam Social Share widget','olam'), $widget_ops, $control_ops);
	}
	function widget($args, $instance)
	{
		extract($args);
		
		$title = $instance['title'];
		echo $before_widget;
		?>
		<div class="sidebar-title"><i class="demo-icons icon-share"></i> <?php echo esc_html($title); ?> </div>
		<?php echo wp_kses_post($this->olam_get_social_share_buttons()); ?>
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
		$defaults = array('title' => esc_html__('Social Share',"olam"));
		$instance = wp_parse_args((array) $instance, $defaults); ?>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title','olam');?>:</label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" value="<?php echo esc_attr($instance['title']); ?>" />
		</p>
		<?php }
/**
 * Olam Function - Get Social Shares
 *
 * Get the social sharing buttons.
 * 
 */

function olam_get_social_share_buttons() {
	$url=get_permalink();
	$normal_url = $url;
	$url = urlencode( $url ); 
	$title = urlencode(get_the_title());
	$twitter_summary =  urlencode(get_the_title());
	$summary =urlencode(get_the_content());
	$imgProd=wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'thumbnail' );
	$imageurl =(isset($imgProd[0]))?urlencode($imgProd[0]):null;
	$html=null;
	$html .= '<ul class="social-icons">';
	$html .= '<li class="social-facebook"><a target="_blank" class="share-popup" href="https://www.facebook.com/sharer.php?t=' . $title . '&amp;u=' . $url . '" title="' . esc_html__( 'Facebook', 'olam' ) . '"><span class="icon"><i class="demo-icon icon-facebook"></i></span></a></li>'; 
	$html .= '<li class="social-twitter"><a target="_blank"  href="https://twitter.com/share?url=' . $url . '&amp;text=' . $twitter_summary . '" title="' . esc_html__( 'Twitter', 'olam' ) . '"><span class="icon"><i class="demo-icon icon-twitter"></i></span></a></li>'; 
	$html .= '<li class="social-pinterest"><a target="_blank" href="http://pinterest.com/pin/create/button/?url=' . $url . '&amp;description=' . $summary . '&media=' . $imageurl . '" onclick="window.open(this.href); return false;"><span class="icon"><i class="demo-icon icon-pinterest"></i></span></a></li>'; 
	$html .= '<li class="social-google"><a target="_blank" href="https://plus.google.com/share?url=' . $url . '&amp;title=' . $title . '" title="' . $title . '" onclick=\'javascript:window.open(this.href, "", "menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600");return false;\'><span class="icon"><i class="demo-icon icon-gplus"></i></span></a></li>'; 
	$html .= '<li class="social-linkedin"><a target="_blank"  href="http://www.linkedin.com/shareArticle?mini=true&url='.$url.'&title='.$title.'"><span class="icon"><i class="demo-icon icon-linkedin"></i></span></a></li>'; ; 
	$html .= '</ul>';
	return $html;
}
}