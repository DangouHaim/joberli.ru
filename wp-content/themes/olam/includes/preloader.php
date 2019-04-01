<!-- Preloader -->
<style type="text/css" scoped>
    .preloader-wrapper  {position: fixed; top: 0; left: 0; background: #fff; height: 100%; width: 100%; z-index: 999999999}
    .preloader-contents {position: absolute; left: 0; top: 0; bottom: 0; right: 0; height: 64px; margin: auto; text-align: center; width: 100%;}
</style>
<?php 
$preloader_img	= get_theme_mod('olam_theme_preloader_img');
$preloader_img	= olam_replace_site_url($preloader_img);
if (!isset($preloader_img) || strlen($preloader_img)<1) { $preloader_img = get_template_directory_uri().'/img/grid.svg'; } ?>


<div class="preloader-wrapper">
    <div class="preloader-contents">
        <div class="preloader-loader">
            <img src="<?php echo esc_url($preloader_img); ?>" alt="Loading">
        </div>
    </div>
</div>
<!-- Preloader -->