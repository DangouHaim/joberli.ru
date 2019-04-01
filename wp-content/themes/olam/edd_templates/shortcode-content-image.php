	<div class="edd_download_image thumb">
		<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
			<span><i class="demo-icons icon-link"></i></span>
			<?php if ( function_exists( 'has_post_thumbnail' ) && has_post_thumbnail( get_the_ID() ) ) : ?>
			<?php echo get_the_post_thumbnail( get_the_ID(), 'olam-product-thumb' ); ?>
			<?php else: ?>
				<?php  echo '<img alt="download-item" src="' . get_template_directory_uri(). '/img/thumbnail-default.jpg" />'; ?>
			<?php endif; ?>
		</a>
	</div>