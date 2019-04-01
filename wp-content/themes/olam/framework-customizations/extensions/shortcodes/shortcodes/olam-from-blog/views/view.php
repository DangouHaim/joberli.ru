<?php if (!defined('FW')) die('Forbidden');
/**
 * @var $atts The shortcode attributes
 */
?>
<?php
$opt_recentpostscount=(isset($atts['noposts']))?(int)$atts['noposts']:5; ?>
<div class="slider-wrapper">
    <?php $args = array(
        'post_type' => 'post',
        'status'=>'publish',
        'showposts'=>$opt_recentpostscount
        );
        $wp_query = new WP_Query( $args );  ?>
        <div class="recent-slider demo-test">
            <?php  if ($wp_query->have_posts()) :?>
            <div class="row">
                <?php while ($wp_query->have_posts()) : $wp_query->the_post(); ?>

                <div class="post-item col-sm-4">
                    <div class="rp">
                        <div class="rp-thumb">
                            <div class="image-holder">
                                 <?php
                                 $url=get_template_directory_uri()."/img/rp-default.jpg";        
                                 $img= wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()),'full'); 

                                 if($img){   
                                    $url=    $img[0];
                                }  ?>
                                <a href="<?php the_permalink();?>">
                                    <img src="<?php echo esc_url($url); ?>" alt="recent post">
                                </a>
                            </div>
                        </div>
                        <div class="rp-content-area">
                            <div class="rp-title"><a href="<?php the_permalink();?>"><?php the_title();?></a></div>
                            <!-- <div class="rp-details">
                                <span><?php //the_author(); ?></span> / 
                                <span><?php //comments_number(); ?></span> / 
                                <span><?php //echo get_the_date('D J Y'); ?></span>
                            </div> -->
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    <?php endif; ?>
    </div>
    <!-- <div class="slider-nav">
        <div class="nav-left"><i class="demo-icon icon-left"></i></div>
        <div class="nav-right"><i class="demo-icon icon-right"></i></div>
    </div> -->
</div>