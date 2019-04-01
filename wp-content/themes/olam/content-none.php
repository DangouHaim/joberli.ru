<?php
/**
 * The template for displaying No posts results.
 *
 * @package Olam
 */
?>

<div class="text-center">
<h3><?php esc_html_e('Sorry,','olam'); ?></h3> <h5><?php esc_html_e('but nothing matched your search terms.','olam'); ?><br><?php esc_html_e('Please try again with some different keywords.','olam'); ?></h5>
	<?php get_search_form(); ?>
</div>