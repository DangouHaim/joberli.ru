<?php

if(!olam_check_edd_exists()){
	return;
}

add_action('widgets_init', 'olam_download_performance_details_widget');

function olam_download_performance_details_widget()
{
	register_widget('olam_download_performance_details_widget');
}

class olam_download_performance_details_widget extends WP_Widget {
	
	function __construct()
	{
		$widget_ops = array('classname' => 'olam_download_performance_details_widget', 'description' => esc_html__('Displays download item peformance details widget. Used in Single Download Sidebar','olam'));
		$control_ops = array('id_base' => 'olam_download_performance_details_widget');
		parent::__construct('olam_download_performance_details_widget', esc_html__('Olam download peformance details','olam'), $widget_ops, $control_ops);

	}
	
	function widget($args, $instance)
	{
		extract($args);
		echo $before_widget;
		?>
		<?php global $wp_query;
		$postID = $wp_query->post->ID;
		$starRating=null;
		if(function_exists("fw_ext_feedback_stars_get_post_rating")){
			$starRating=fw_ext_feedback_stars_get_post_rating($postID);
			$starRating=$starRating['average'];
			$starRating=(round($starRating*2))*10;
		}
		else{
			if( class_exists( 'EDD_Reviews' ) ) {
				$starRating = edd_reviews()->average_rating(false);
				$starRating=(round($starRating*2))*10;
			}
		}

		?>
		<ul class="milestones">
			<li><i class="demo-icons icon-cart"></i><?php echo olam_get_edd_sale_count($postID); ?><span> <?php esc_html_e("Продажи","olam"); ?></span></li>
			<li><i class="demo-icons icon-comment-alt"></i><?php echo olam_get_comment_count($postID); ?><span> <?php esc_html_e("Коментарии","olam"); ?></span></li>
			<li>
				<div title="<?php echo esc_attr($starRating/20);?> <?php esc_html_e("из 5","olam");?>" class="download-rating">
					<div class="wrap-rating listing">
						<div class="rating">
							<span class="fa fa-star" data-vote="1"></span>
							<span class="fa fa-star" data-vote="2"></span>
							<span class="fa fa-star" data-vote="3"></span>
							<span class="fa fa-star" data-vote="4"></span>
							<span class="fa fa-star" data-vote="5"></span>					
						</div>
						<div class="rated" style="width:<?php echo esc_html($starRating);?>%">
							<div class="rating">
								<span class="fa fa-star" data-vote="1"></span>
								<span class="fa fa-star" data-vote="2"></span>
								<span class="fa fa-star" data-vote="3"></span>
								<span class="fa fa-star" data-vote="4"></span>
								<span class="fa fa-star" data-vote="5"></span>					
							</div>
						</div>
						<span class="clearfix"></span>
					</div>
				</div>
			</li>
		</ul>
		<?php
		echo $after_widget;
	}
}