<?php /* Template Name: Sidebar Right */ ?>
<?php
/**
 * The Template for displaying cutom page with right sidebar.
 *
 * @package Olam
 */
get_header(); ?>
<?php
$beforeContent=null;
$afterContent=null;
$beforeComment=null;
$afterComment=null;
$innerPage="inner-page-heading";
if(olam_is_default_editor_only()){ 
	$beforeContent="<div class='section'><div class='fw-container'><div class='post-content'>";
	$afterContent="</div></div></div>";
	$innerPage=null;
} else {
	$beforeComment='<div class="section"><div class="fw-container">';
	$afterComment='</div></div>';
} ?>
<?php echo wp_kses($beforeContent,array('div'=>array('class'=>array()))); ?>
<?php if ( have_posts() ) : ?>
	<?php /* The loop */ ?>
	<?php while ( have_posts() ) : the_post(); ?>
		<?php  if(!is_front_page()){ ?>
			<div class="page-head <?php echo esc_attr($innerPage); ?>">
				<div class="fw-container">
					<h1>
						<?php 
						$altTitle=olam_get_page_option(get_the_ID(),"olam_page_alttitle"); 
						if(isset($altTitle) && (strlen($altTitle)>0 ) ) { 
							echo wp_kses($altTitle,array('span'=>array('class'=>array()))); 
						} else{
							the_title(); 
						}  
						?> 
					</h1>         
					<?php 
					$pageSubs=olam_get_page_option(get_the_ID(),"olam_page_subtitle"); 
					if(isset($pageSubs) && (strlen($pageSubs)>0 )) { 
						?>
						<div class="page_subtitle"> <?php  echo esc_html($pageSubs); ?></div>
						<?php } ?>
					</div>
				</div>
				<?php } ?>
				<div class="row">
					<div class="col-md-9">
						<div class="paper">    
							<?php the_content(); ?>
						</div>
						<?php if ( comments_open() ) : ?>
							<?php echo wp_kses($beforeComment,array('div'=>array('class'=>array()))); ?>
							<div class="paper">
								<div class="wp_comments comment-list">
									<?php comments_template( '', true ); ?>
								</div>
							</div>
							<?php echo wp_kses($afterComment,array('div'=>array('class'=>array()))); ?>
						<?php endif; ?>
					<?php endwhile; ?>
					<?php endif; ?>
				   	</div>
					<div class="col-md-3">
						<div class="sidebar blog-sidebar">
							<?php if (function_exists('dynamic_sidebar') && dynamic_sidebar('olam-page-sidebar') ) : else : ?>        
							<?php endif; ?> 
						</div>
					</div>
				</div>
<?php echo wp_kses($afterContent,array('div'=>array('class'=>array()))); ?>
	<?php get_footer(); ?>
