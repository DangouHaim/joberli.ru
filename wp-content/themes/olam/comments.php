<?php
/**
 * Comment Template
 * @package Olam
 */ 
?>

<?php  
if(have_comments()){?>
	<h3><?php esc_html_e("Коментарии","olam"); ?></h3>
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
			<?php previous_comments_link( esc_html__( 'Старые коментарии', 'olam' ) ); ?>
			<?php next_comments_link( esc_html__( 'Новые коментарии', 'olam' ) ); ?>
		</div>
	<?php endif; // check for comment navigation ?>
	<?php if ( comments_open() ) : ?>
		<?php comment_form(); ?>
	<?php endif; ?>