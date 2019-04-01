<?php
/**
 * Comment Template
 * @package Olam
 */ 
?>

<?php  
if(have_comments()){?>
	<h3><?php esc_html_e("Comments","olam"); ?></h3>
	<?php

	wp_list_comments( array(
		'walker' => new Olam_Walker_Comment,
		'style' => 'ul',
		'type' => 'all',
		'avatar_size' => 100
		) ); 

	} ?>
	<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<div class="comments-nav">
			<?php previous_comments_link( esc_html__( 'Older Comments', 'olam' ) ); ?>
			<?php next_comments_link( esc_html__( 'Newer Comments', 'olam' ) ); ?>
		</div>
	<?php endif; // check for comment navigation ?>
	<?php if ( comments_open() ) : ?>
		<?php comment_form(); ?>
	<?php endif; ?>