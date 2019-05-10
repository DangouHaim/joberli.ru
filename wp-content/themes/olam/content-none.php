<?php
/**
 * The template for displaying No posts results.
 *
 * @package Olam
 */
?>

<div class="text-center">
<h3><?php esc_html_e('Извините,','olam'); ?></h3> <h5><?php esc_html_e('но ничего не найдено.','olam'); ?><br><?php esc_html_e('Пожалуйста попробуйте другой запрос.','olam'); ?></h5>
	<?php get_search_form(); ?>
</div>