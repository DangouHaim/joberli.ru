<div class="section">
	<div class="container">
		<div class="page-head ">
			<h1><?php esc_html_e("Поиск по: ","olam"); echo get_search_query(); ?></h1>
		</div>
		<div class="row">
			<?php $downloadColumn=12; ?>
			<?php  if ( is_active_sidebar( 'olam-download-category-sidebar' )){
				$downloadColumn=9;
				?>
				<div class="col-md-3">
					<div class="sidebar">
						<?php dynamic_sidebar( 'olam-download-category-sidebar' ); ?>
					</div>
				</div>
			<?php } ?>
			<div class="col-md-<?php echo esc_attr($downloadColumn); ?>">
					<?php
					$taxQuery=array();
					if(isset($_GET['download_cat']) && $_GET['download_cat'] !== 'all'){
						$downloadcat = $_GET['download_cat'];

						$taxQuery =	array(
							array(
								'taxonomy' => 'download_category',
								'field'    => 'slug',
								'terms'    => $downloadcat
								)
							);
					}
					
					$paged=( get_query_var( 'paged')) ? get_query_var( 'paged') : 1;
					$posts_per_page_olam=get_theme_mod('olam_product_count');
					if ( ! isset( $wp_query->query['orderby'] ) ) {
						$args = array(
							's'			=> get_search_query(),
							'orderby' 	=> 'date',
							'order' 	=> 'DESC',
							'post_type' => 'download',
							'posts_per_page'=>$posts_per_page_olam,
							'paged' 	=> $paged,
							'tax_query' => $taxQuery
							);
					} else {
						switch ($wp_query->query['orderby']) {
							case 'date':
								$args = array(
									's'			=> get_search_query(),
									'orderby'	=> 'date',
									'order'		=> 'DESC',
									'post_type' => 'download',
									'posts_per_page'=>$posts_per_page_olam,
									'paged'		=> $paged,
									'tax_query' => $taxQuery
									);
							break;
							case 'sales':
								$args = array(
									's'			=> get_search_query(),
									'meta_key'	=> '_edd_download_sales',
									'order'		=> 'DESC',
									'orderby'	=> 'meta_value_num meta_value',
									'post_type' => 'download',
									'posts_per_page'=>$posts_per_page_olam,
									'paged'		=> $paged,
									'tax_query' => $taxQuery
									);
							break;
							case 'price':
								$args = array(
									's'			=> get_search_query(),
									'meta_key'	=> 'edd_price',
									'order'		=> 'ASC',
									'orderby'	=> 'meta_value_num meta_value ',
									'post_type' => 'download',
									'posts_per_page'=>$posts_per_page_olam,
									'paged'		=> $paged,
									'tax_query' => $taxQuery
									);
							break;
						}
					}

					$temp = $wp_query; $wp_query = null;
					$wp_query = new WP_Query(); $wp_query->query($args);
					
					if($wp_query->have_posts()){
						while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>
							<?php get_template_part('includes/loop-shop-listings'); ?>
						<?php endwhile; ?>
					<?php }
					else { ?>
						<h4><?php esc_html_e("Нет результатов","olam"); ?></h4>
					<?php } ?>

				<div class="pagination">
					<?php
					if (function_exists("olam_pagination")) {
						olam_pagination();
					}
					?>
				</div>
			</div>
		</div>
	</div>
</div>