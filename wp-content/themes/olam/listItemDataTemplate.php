<?
$args = array_map('json_encode', $_POST["dataArgs"]);

$paged = json_decode($args["paged"]);
$olam_show_cats = json_decode($args["olam_show_cats"]);
$atts = json_decode($args["atts"], true);
$listingItemClass = json_decode($args["listingItemClass"]);


$query = json_decode(json_encode($_POST["query"]), true);
$query["paged"] = $paged;
$the_query = new WP_Query( $query );
?>

<?php if ($the_query->have_posts()) : ?>
    <?php while ($the_query->have_posts()) : $the_query->the_post(); ?>
        <div class="<?php echo $listingItemClass; ?> <?php echo esc_html($atts['listingcolumn']); ?>">
            <div class="edd_download_inner">
                <div class="thumb">
                    <?
                        $video_url = get_post_meta(get_the_ID(), "video_url", true);
                    ?>
                    <? if( !empty($video_url)) : ?>
                        <? var_dump($video_url) ?>
                        <div class="video-button" data-video='<? echo $video_url ?>'></div>
                    <? endif ?>
                    <?php
                    $thumbID = get_post_thumbnail_id(get_the_ID());
                    $featImage = wp_get_attachment_image_src($thumbID, 'olam-product-thumb');
                    $featImage = $featImage[0];
                    $alt = get_post_meta($thumbID, '_wp_attachment_image_alt', true);

                    $square_img = get_post_meta(get_the_ID(), "download_item_square_img");

                    // feat vid code start
                    $videoCode = get_post_meta(get_the_ID(), "download_item_video_id");
                    $audioCode = get_post_meta(get_the_ID(), "download_item_audio_id");
                    $itemSet = null;
                    $featFlag = null;
                    $videoFlag = null;
                    if (isset($videoCode[0]) && (strlen($videoCode[0]) > 0)) {
                        $itemSet = 1;
                        $videoUrl = $videoCode[0];
                        //$videoUrl=wp_get_attachment_url($videoCode[0]); 

                        $videoFlag = 1; ?>
                        <div class="media-thumb">
                            <?php echo do_shortcode("[video src='" . $videoUrl . "']"); ?>
                        </div> <?php
                            } else if (!empty($square_img) && strlen($square_img[0]) > 0) {
                                $featFlag = 1; ?>
                        <a href="<?php the_permalink(); ?>">
                            <span><i class="demo-icons icon-link"></i></span>
                            <img src="<?php echo esc_url($square_img[0]); ?>" />
                        </a> <?php
                            } else if ((isset($featImage)) && (strlen($featImage) > 0)) {
                                $featFlag = 1;
                                $alt = get_post_meta($thumbID, '_wp_attachment_image_alt', true); ?>
                        <a href="<?php the_permalink(); ?>">
                            <span><i class="demo-icons icon-link"></i></span>
                            <img src="<?php echo esc_url($featImage); ?>" alt="<?php echo esc_attr($alt); ?>">
                        </a><?php
                        }
                        if (!isset($videoFlag)) {
                            if (isset($audioCode[0]) && (strlen($audioCode[0]) > 0)) {
                                $itemSet = 1;
                                $audioUrl = wp_get_attachment_url($audioCode[0]);
                                ?>
                            <div class="media-thumb">
                                <?php echo do_shortcode("[audio src='" . $audioUrl . "']"); ?>
                            </div> <?php
                                }
                            } ?>
                    <?php if (!(isset($featFlag))) { ?>
                        <a href="<?php the_permalink(); ?>">
                            <span><i class="demo-icons icon-link"></i></span>
                            <img src="<?php echo get_template_directory_uri(); ?>/img/preview-image-default.jpg" alt="<?php echo esc_attr($alt); ?>">
                        </a>
                    <?php } ?>

                </div>
                <div class="product-details">
                    <div class="product-name"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></div>
                    <div class="product-price"><?php edd_price(get_the_ID()); ?></div>
                    Автор:<a style="padding-top:10px;" href="<?php echo esc_url(add_query_arg('author_downloads', 'true', get_author_posts_url(get_the_author_meta('ID')))); ?>"><?php esc_html_e("", "olam"); ?> <?php the_author(); ?></a>
                    <div class="details-bottom">
                        <div class="product-options">
                            <? if (is_user_logged_in()) : ?>
                                <a href="#" data-id="<? echo get_the_ID(); ?>" class="post-save" title="<?php esc_attr_e('Сохранить', 'olam'); ?> "><i class="demo-icons icon-like"></i><i class="posts-count"><? echo get_saved_posts_count(get_the_ID()) ?></i></a>
                            <? else : ?>
                                <a href="#" data-id="<? echo get_the_ID(); ?>" class="noLoggedUser" title="<?php esc_attr_e('Сохранить', 'olam'); ?> "><i class="demo-icons icon-like"></i></a>
                            <? endif ?>
                            <?php if (!olam_check_if_added_to_cart(get_the_ID())) {
                                $eddOptionAddtocart = edd_get_option('add_to_cart_text');
                                $addCartText = (isset($eddOptionAddtocart) && $eddOptionAddtocart  != '') ? $eddOptionAddtocart : esc_html__("Добавить в корзину", "olam");
                                if (edd_has_variable_prices(get_the_ID())) {

                                    $defaultPriceID = edd_get_default_variable_price(get_the_ID());
                                    $downloadArray = array('edd_action' => 'add_to_cart', 'download_id' => get_the_ID(), 'edd_options[price_id]' => $defaultPriceID);
                                } else {
                                    $downloadArray = array('edd_action' => 'add_to_cart', 'download_id' => get_the_ID());
                                }
                                ?>
                                <? if (is_user_logged_in()) : ?>
                                    <a href="<?php echo esc_url(add_query_arg($downloadArray, edd_get_checkout_uri())); ?>" title="<?php esc_attr_e('Купить сейчас', 'olam'); ?>"><i class="demo-icons icon-download"></i></a>
                                <? else : ?>
                                    <a href="#" class="noLoggedUser" title="<?php esc_attr_e('Купить сейчас', 'olam'); ?>"><i class="demo-icons icon-download"></i></a>
                                <? endif ?>
                                <a href="<?php echo esc_url(add_query_arg($downloadArray, olam_get_current_page_url())); ?>" title="<?php echo esc_html($addCartText); ?>"><i class="demo-icons icon-cart"></i></a>
                            <?php } else { ?>
                                <a class="cart-added" href="<?php echo esc_url(edd_get_checkout_uri()); ?>" title="<?php esc_attr_e('Checkout', 'olam'); ?> "><i class="fa fa-check"></i></a>
                            <?php } ?>
                        </div>
                        <? $olamct = $olam_show_cats; ?>
                        <? if (isset($olamct) && $olamct == "1") : ?>
                            <?
                                $cat = wp_get_post_terms(get_the_ID(), 'download_category');
                                //$mlink = get_term_link($cat[0]->slug, );
                            ?>
                            <div class="product-author"><a href="<?php echo $mlink; ?>"><?php echo ($cat[0]->name); ?></a></div>
                        <? else : ?>
                            <div class="product-author"><a href="<?php echo esc_url(add_query_arg('author_downloads', 'true', get_author_posts_url(get_the_author_meta('ID')))); ?>"><?php esc_html_e("Автор", "olam"); ?>: <?php the_author(); ?></a></div>
                        <? endif ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endwhile; ?>
    <?php wp_reset_postdata(); ?>
<?php else : ?>

<?php endif; ?>