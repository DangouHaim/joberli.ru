<?php if (!defined('FW')) die('Forbidden');
/**
 * @var $atts The shortcode attributes
 */
?>
<div class="product-search">
	<div class="search-title">
		<?php if(isset($atts['title'])){ ?>  <h1><?php  echo wp_kses($atts['title'],array('span'=>array('class'=>array()))); ?></h1> <?php } ?>
		<?php if(isset($atts['description'])){ ?> <p> <?php echo esc_html($atts['description']); ?></p> <?php } ?>
	</div>
	<div class="product-search-form">
		<form method="GET" action="<?php echo home_url(); ?>">
			<?php if(isset($atts['enablecats']) & $atts['enablecats']==1){
				$taxonomies = array('download_category');
				$args = array('orderby'=>'count','hide_empty'=>true);
				echo olam_get_terms_dropdown($taxonomies, $args);
			} ?>
			<div class="search-fields" style="border-top-right-radius: 5px; border-bottom-right-radius: 5px;">
				<input name="s" value="<?php echo (isset($_GET['s']))?$_GET['s']: null; ?>" type="text" placeholder="<?php echo esc_attr($atts['searchtext']); ?>">
				<input type="hidden" name="post_type" value="download">
				<span class="search-btn"><input type="submit"></span>
			</div>
		</form>
	</div>
	<div class="product-search-bottom">
		<div class="counter">
			<?php if(isset($atts['counter1count']) && (strlen($atts['counter1count'])>0)){ ?>    <div class="countdown"><?php echo esc_html($atts['counter1count']); ?></div><?php } ?>
			<?php if(isset($atts['counter1title']) && (strlen($atts['counter1title'])>0)){ ?>   <span><?php echo esc_html($atts['counter1title']); ?></span> &nbsp; <?php } ?>
		</div>
		<div class="counter">
			<?php if(isset($atts['counter2count'])&& (strlen($atts['counter2count'])>0)){ ?>  <div class="countdown"><?php echo esc_html($atts['counter2count']); ?></div><?php } ?>
			<?php if(isset($atts['counter2title'])&& (strlen($atts['counter2title'])>0)){ ?>    <span><?php echo esc_html($atts['counter2title']); ?></span><?php } ?>
		</div>
	</div>
	<span class="clearfix"></span>
</div>
