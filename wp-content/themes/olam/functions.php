<?php
/**
 * Olam functions
 *
 * @package Olam
 */

define('INC_PATH', get_template_directory() . '/includes/');
require_once ('edd_templates/includes/widgets/widgets.php');
require_once (INC_PATH . 'Walker_Comments.php');                  // Theme actions & user defined hooks
require_once (get_template_directory().'/admin/index.php');   // SMOF options

require_once (get_template_directory().'/edd_templates/functions-template.php'); //EDD functions

require_once (get_template_directory()."/up_templates/up_sdk/account.php"); // account and payment operations

if ( file_exists( dirname( __FILE__ ) . '/admin/cmb/init.php' ) ) {
  require_once dirname( __FILE__ ) . '/admin/cmb/init.php';
}


/* -- Custom Thumbnail sizes -- */
// Enabling product gallery features (zoom, swipe, lightbox) in woocommerce 3.0.0 (here enabling lightbox)
add_theme_support( 'wc-product-gallery-lightbox' );


if (function_exists('add_theme_support')) {
  add_theme_support('post-thumbnails');
  add_image_size('olam-product-thumb', 870, 9999, false);
  add_image_size('olam-product-thumb-small', 170, 170, true);
  add_image_size('olam-preview-image', 1180, 999, false);
  add_theme_support( 'custom-header' );
  add_theme_support( 'custom-background');
  add_theme_support( "title-tag" );
  add_theme_support( 'automatic-feed-links');
}

add_action( 'cmb2_admin_init', 'olam_register_download_metafields' );

/**
 * Olam Theme Functions - Register meta fields.
 * Registering meta fields to download post type.
**/

function olam_register_download_metafields() {
  $prefix = 'olam';
  /**
   * Sample metabox to demonstrate each field type included
   */
  $cmb_demo = new_cmb2_box( array(
    'id'            => $prefix . 'metabox',
    'title'         => esc_html__( 'Download Options', 'olam' ),
    'object_types'  => array( 'download')
    ) );

  $cmb_demo->add_field( array(
    'name'       => esc_html__( 'Preview Url', 'olam' ),
    'desc'       => esc_html__( 'Preview Url to show in single download page', 'olam' ),
    'id'         => 'preview_url',
    'type'       => 'text',
    ));
  $cmb_demo->add_field( array(
    'name'       => esc_html__( 'Subheading', 'olam' ),
    'desc'       => esc_html__( 'Subheading for the item', 'olam' ),
    'id'         => 'subheading',
    'type'       => 'text',

    ) );
  $cmb_demo->add_field( array(
    'name'       => esc_html__( 'Downloads Thumbnail', 'olam' ),
    'desc'       => esc_html__( 'Download item thumbnail to show in different sections', 'olam' ),
    'id'         => 'download_item_thumbnail',
    'type'       => 'file',
    'options'    =>array(
      'url'     =>false,
      )
    ) );
  $cmb_demo->add_field( array(
    'name'       => esc_html__( 'Square Images', 'olam' ),
    'desc'       => esc_html__( 'Download item square image to show in different sections(shop, category, archives and shortcodes instead of featured image.)', 'olam' ),
    'id'         => 'download_item_square_img',
    'type'       => 'file',
    'options'    =>array(
      'url'     =>false,
      )
    ) );
  $cmb_demo->add_field( array(
    'name'       => esc_html__( 'Audio URL', 'olam' ),
    'desc'       => esc_html__( 'Upload the audio file for the audio player', 'olam' ),
    'id'         => 'download_item_audio_id',
    'type'       => 'file',
    'options'    =>array(
      'url'     =>false,
      )
    )
  );
  // $cmb_demo->add_field( array(
  //   'name'       => esc_html__( 'Video URL', 'olam' ),
  //   'desc'       => esc_html__( 'Upload the video file to display in video player', 'olam' ),
  //   'id'         => 'download_item_video_id',
  //   'type'       => 'file',
  //   'options'    =>array(
  //     'url'     =>false,
  //     )
  //   )
  // );
  $cmb_demo->add_field( array(
    'name'       => esc_html__( 'Video URL', 'olam' ),
    'desc'       => esc_html__( 'Upload the video url to display in video player', 'olam' ),
    'id'         => 'download_item_video_id',
    'type'       => 'text',
    )
  );

}

if ( ! isset( $content_width ) ) $content_width = 1180;

//Add Custom Widgets
$widgets_dir = WP_CONTENT_DIR . "/themes/".get_option('template')."/includes/widgets/";

if (@is_dir($widgets_dir)) {
  $widgets_dh = opendir($widgets_dir);
  while (($widgets_file = readdir($widgets_dh)) !== false) {

    if(strpos($widgets_file,'.php') && $widgets_file != "widget-blank.php") {
      include_once($widgets_dir . $widgets_file);
      
    }
  }
  closedir($widgets_dh);
}


/**
 * Olam Theme Functions - Add Editor Styles.
 * Adding styles to WP editor.
**/

function olam_add_editor_styles() {
  add_editor_style( 'css/editor-style.css' );
}
add_action( 'admin_init', 'olam_add_editor_styles' );

/**
 * Olam Theme Functions - Theme Setup.
 * Olam theme setup.
 * Loading text domain
**/

if( ! function_exists( 'olam_theme_setup' ) ){
  function olam_theme_setup(){
    load_theme_textdomain('olam', get_template_directory() . '/languages');
    add_theme_support( 'woocommerce' );
  }
}
add_action('after_setup_theme', 'olam_theme_setup');



/**
 * Olam Theme Functions - Registering Sidebars.
 * Registering the required sidebars.
**/

if( ! function_exists( 'olam_register_sidebars' ) ){
  function olam_register_sidebars(){
    if (function_exists('register_sidebar')) {

     register_sidebar(array(
      'name' => esc_html__('Single Download Sidebar','olam'),
      'id'   => 'olam-single-download',
      'description'   => esc_html__('Single Download Page Sidebar','olam'),
      'before_widget' => '<div class="sidebar-item">',
      'after_widget'  => '</div>',
      'before_title'  => '<div class="sidebar-title"><i class="demo-icons icon-cart"></i>',
      'after_title'   => '</div>'
      ));
     register_sidebar(
      array(
        'name' => esc_html__('Download Category Sidebar','olam'),
        'id'   => 'olam-download-category-sidebar',
        'description'   => esc_html__('Download Category Sidebar','olam'),
        'before_widget' => '<div class="sidebar-item">',
        'after_widget'  => '</div>',
        'before_title'  => '<div class="sidebar-title"><i class="demo-icons icon-folder"></i>',
        'after_title'   => '</div>'
        )
      );
     register_sidebar(
      array(
        'name' => esc_html__('Author Downloads Sidebar','olam'),
        'id'   => 'olam-author-sidebar',
        'description'   => esc_html__('Sidebar used in author downloads page','olam'),
        'before_title'  => '<div class="sidebar-title"><i class="demo-icons icon-folder"></i>',
        'after_title'   => '</div>',
        'before_widget' => '<div class="sidebar-item">',
        'after_widget'  => '</div>',
        )
      );
     register_sidebar(
      array(
        'name' => esc_html__('Blog Page Sidebar','olam'),
        'id'   => 'olam-blog-page-sidebar',
        'description'   => esc_html__('Blog Page Sidebar','olam'),
        'before_widget' => '<div class="sidebar-item">',
        'after_widget'  => '</div>',
        'before_title'  => '<div class="sidebar-title"><i class="demo-icons icon-folder"></i>',
        'after_title'   => '</div>'
        )
      );
     register_sidebar(
      array(
        'name' => esc_html__('Page Sidebar','olam'),
        'id'   => 'olam-page-sidebar',
        'description'   => esc_html__('Page Sidebar','olam'),
        'before_widget' => '<div class="sidebar-item">',
        'after_widget'  => '</div>',
        'before_title'  => '<div class="sidebar-title"><i class="demo-icons icon-folder"></i>',
        'after_title'   => '</div>'
        )
      );
     register_sidebar(
      array(
        'name' => esc_html__('Footer 1','olam'),
        'id'   => 'olam-footer-area-1',
        'description'   => esc_html__('Footer Area 1','olam'),
        'before_widget' => '<div class="footer-widget">',
        'after_widget'  => '</div>',
        )
      );
     register_sidebar(
      array(
        'name' => esc_html__('Footer 2','olam'),
        'id'   => 'olam-footer-area-2',
        'description'   => esc_html__('Footer Area 2','olam'),
        'before_widget' => '<div class="footer-widget">',
        'after_widget'  => '</div>',
        'before_title'  => '<h5>',
        'after_title'   => '</h5>'
        )
      );
     register_sidebar(array(
      'name' => esc_html__('Woocommerce Sidebar','olam'),
      'id'   => 'olam-woocommerce-sidebar',
      'description'   => esc_html__('Woocommerce Sidebar','olam'),
      'before_widget' => '<div class="sidebar-item %2$s">',
      'after_widget'  => '</div>',
      'before_title'  => '<div class="sidebar-title"><i class="demo-icons icon-cart"></i>',
      'after_title'   => '</div>'
      ));
   }
 }
}

add_action( 'widgets_init', 'olam_register_sidebars');

/**
 * Olam Theme Functions - Check EDD exists.
 * Checking if EDD is installed.
**/

function olam_check_edd_exists() {

 if( class_exists( 'Easy_Digital_Downloads' ) ) {
  return true;
}
return false;
}


/**
 * Olam Theme Functions - Register Menud.
 * Registering Menus.
**/

if( ! function_exists( 'olam_register_menus' ) ){
  function olam_register_menus() {
    register_nav_menus(
      array(
        'header-top-menu' => esc_html__('Header Menu','olam'),
        )
      );
  }
}
add_action('init', 'olam_register_menus');


/**
 * Olam Theme Functions - Register styles and scripts.
 * Loading theme scripts and styles.
**/

if( ! function_exists( 'olam_register_styles_scripts' ) ){
  function olam_register_styles_scripts(){
    $protocol  = is_ssl() ? 'https' : 'http';
    $loadedFonts=olam_load_googlefont_styles();
    wp_enqueue_style('header', get_template_directory_uri() . '/inc/css/header.css',array(),'1.0');
    wp_enqueue_style('jquery-ui', get_template_directory_uri() . '/css/jquery-ui.css',array(),'1.0');
    wp_enqueue_style('sprite', get_template_directory_uri() . '/inc/css/sprite.css',array(),'1.0');
    wp_enqueue_style('main', get_template_directory_uri() . '/inc/css/main.css',array(),'1.0');
    wp_enqueue_style('normalize', get_template_directory_uri() . '/css/normalize.min.css',array(),'3.0.2');
    wp_enqueue_style('olam-bootstrap', get_template_directory_uri() . '/css/bootstrap.css',array(),'1.0');
    wp_enqueue_style('olam-style', get_template_directory_uri() . '/css/style.css',array(),'1.0');
    wp_enqueue_style('owl-carousel', get_template_directory_uri() .  '/css/owl.carousel.css',array(),'2.0');
    wp_enqueue_style('woocommerce-style', get_template_directory_uri() .  '/css/woocommerce-style.css');
    wp_enqueue_style('woocommerce', get_template_directory_uri() .  '/css/woocommerce.css');
    wp_enqueue_style('olam-color', get_template_directory_uri().'/css/color.css.php',array(),'1.0');
    if( get_theme_mod('olam_dark_style') == 1 ) {
      wp_enqueue_style('dark-style', get_template_directory_uri() .  '/css/dark-style.css');
    }
    if(isset($loadedFonts) && (strlen($loadedFonts) >0 ) ) {
      wp_enqueue_style('olam-google-fonts',"{$protocol}://fonts.googleapis.com/css?family=".$loadedFonts);
    }
    wp_enqueue_script('main', get_template_directory_uri().'/inc/js/main.js',array('jquery'),'1.0');
    wp_enqueue_script('jqueryui', get_template_directory_uri().'/js/jqueryui.js',array('jquery'),'1.0');
    wp_enqueue_script('modernizr', get_template_directory_uri().'/js/vendor/modernizr-2.8.3-respond-1.4.2.min.js',array('jquery'),'2.8.3');
    wp_enqueue_script('jquery-easypiechart', get_template_directory_uri().'/js/jquery.easypiechart.min.js',array('jquery'),'2.1.5', true);
    wp_enqueue_script('olam-bootstrap-js', get_template_directory_uri().'/js/bootstrap.min.js',array('jquery'),'1.0', true);
    wp_enqueue_script('sly', get_template_directory_uri().'/js/sly.min.js',array(),'1.5.1', true);
    wp_enqueue_script('owl-carousel', get_template_directory_uri().'/js/owl.carousel.min.js',array('jquery'),'2.0', true);
    //wp_enqueue_script('pretty-photo', get_template_directory_uri().'/js/jquery.prettyPhoto.js',array('jquery'),'3.1.6', true);
    wp_enqueue_script('appear', get_template_directory_uri().'/js/appear.js',array(),'1.0', true);
    wp_enqueue_script('easing', get_template_directory_uri().'/js/easing.js',array('jquery'),'1.3', true);
    wp_enqueue_script('jquery-parallax', get_template_directory_uri().'/js/jquery.parallax-1.1.3.js',array('jquery'),'1.1.3', true);
    if(isset($data['theme_retina']) && $data['theme_retina']==1){
      wp_enqueue_script('retina', get_template_directory_uri().'/js/retina.min.js',array(),'1.0',true);
    }
    wp_enqueue_script('olam-main', get_template_directory_uri().'/js/olam-main.js',array('jquery'),'1.0', true);

    if ( is_singular(array('post')) && comments_open() ){
      wp_enqueue_script('comment-reply');
    } 

    $ajax_url =(function_exists('edd_get_ajax_url'))?edd_get_ajax_url():admin_url( 'admin-ajax.php' );
    wp_localize_script(
      'olam-main',
      'olam_main_ajax',
      array(
        'ajaxurl' => $ajax_url,
        'nonce' => wp_create_nonce('olam_main'),
        'piecolor'=>get_theme_mod('olam_theme_pri_color'),
        )
      );

    // Body specs
    $bodyspecscolor=get_theme_mod('olam_bodycolor');
    $bodyspecsfont=get_theme_mod('olam_bodyfont');
    $bodyspecssize=get_theme_mod('olam_bodysize');
    $bodySpecs_color=(isset($bodyspecscolor))?$bodyspecscolor:null;
    $bodySpecs_font=(isset($bodyspecsfont))?$bodyspecsfont:null;
    $bodySpecs_size=(isset($bodyspecssize))?$bodyspecssize:null;
    $color = get_theme_mod( 'my-custom-color' ); //E.g. #FF0000

    $inner_page_heading = olam_get_page_option(get_the_ID(),"olam_disable_inner_page_heading");

        $custom_css = "
                body {
                  font-family : {$bodySpecs_font}, Arial, Helvetica;
                  color : {$bodySpecs_color};
                  font-size : {$bodySpecs_size}px;
                  }
        ";

        if($inner_page_heading){
          $custom_css.= "  .inner-page-heading{ display:none; }  ";
        }

        wp_add_inline_style( 'olam-color', $custom_css );
  }
}
add_action('wp_enqueue_scripts', 'olam_register_styles_scripts');


/**
 *  olam lightbox Function
 *  PRETTY PHOTO 
 *    Prettyphoto (not Fancybox) will continue to be registered but not enqueued, since woocommerse update 2.7
 */
if(class_exists('WooCommerce')){
  add_action( 'wp_enqueue_scripts', 'olam_lightbox' );
  function olam_lightbox() {
    global $woocommerce;
    $suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
    {
    wp_enqueue_script( 'prettyPhoto', esc_url( $woocommerce->plugin_url() ) . '/assets/js/prettyPhoto/jquery.prettyPhoto' . $suffix . '.js', array( 'jquery' ), $woocommerce->version, true );
    wp_enqueue_script( 'prettyPhoto-init', esc_url( $woocommerce->plugin_url() ) . '/assets/js/prettyPhoto/jquery.prettyPhoto.init' . $suffix . '.js', array( 'jquery' ), $woocommerce->version, true );
    wp_enqueue_style( 'woocommerce_prettyPhoto_css', esc_url( $woocommerce->plugin_url() ) . '/assets/css/prettyPhoto.css' );
    }
  }
}

/**
 * Olam Theme Function - Load admin styles
 * Loading admin styles.
**/

if( ! function_exists( 'olam_load_custom_wp_admin_style' ) ){
  function olam_load_custom_wp_admin_style() {
    wp_enqueue_style( 'olam-admin-styles', get_template_directory_uri() . '/css/admin-styles.css');
  }
}
add_action( 'admin_enqueue_scripts', 'olam_load_custom_wp_admin_style' );

/**
 * Olam Theme Function - Old IE Fixes
 * Fixes for old IE versions.
**/

if( ! function_exists( 'olam_old_ie_fixes' ) ){
  function olam_old_ie_fixes() {
    global $is_IE;
    if ( $is_IE ) {
      echo '<!--[if lt IE 9]>';
      echo '<script src="' . get_template_directory_uri() . '/assets/js/css3-mediaqueries.js" type="text/javascript"></script>';
      echo '<script src="' . get_template_directory_uri() . '/assets/js/html5shiv.js" type="text/javascript"></script>';
      echo '<script src="' . get_template_directory_uri() . '/assets/js/respond.min.js" type="text/javascript"></script>';
      echo '<script src="' . get_template_directory_uri() . '/assets/js/placeholders.min.js" type="text/javascript"></script>';
      echo '<![endif]-->';
    }
  }
}

add_action( 'wp_head', 'olam_old_ie_fixes' );


/**
 * Olam Function - Pagination.
 *
 * This function sets the pagination for post pages.
 */

if( ! function_exists( 'olam_pagination' ) ){
  function olam_pagination($pages = '', $range = 4, $ordinary=null) {

    // The Custom Pagination

    if(!isset($ordinary)){
      $showitems = ($range * 2) + 1;
      global $paged;
      if (empty($paged))
        $paged = 1;
      if ($pages == '') {
        global $wp_query;
        $pages = $wp_query->max_num_pages;
        if (!$pages) {
          $pages = 1;
        }
      }   
      if (1 != $pages) {
        echo "<div class=\"pagination\"><ul>";
        if ($paged > 2 && $paged > $range + 1 && $showitems < $pages)
          echo "<a href='" . get_pagenum_link(1) . "'>&laquo; ".esc_html__('First','olam')."</a>";
        if ($paged > 1 && $showitems < $pages)
          echo "<a href='" . get_pagenum_link($paged - 1) . "'>&lsaquo; ".esc_html__('Previous','olam')."</a>";
        echo "<li>".get_previous_posts_link('<i class="demo-icons icon-left"></i>')."</li>";
        for ($i = 1; $i <= $pages; $i++) {
          if (1 != $pages && (!($i >= $paged + $range + 1 || $i <= $paged - $range - 1) || $pages <= $showitems )) {
            echo ($paged == $i) ? "<li class=\"active\"><a href='#'>" . $i . "</a></li>" : "<li><a href='" . get_pagenum_link($i) . "' >" . $i . "</a></li>";
          }
        }
        echo "<li>".get_next_posts_link('<i class="demo-icon icon-right"></i>')."</li>";
        if ($paged < $pages && $showitems < $pages)
          echo "<a href=\"" . get_pagenum_link($paged + 1) . "\">".esc_html__('Next','olam')." &rsaquo;</a>";
        if ($paged < $pages - 1 && $paged + $range - 1 < $pages && $showitems < $pages)
          echo "<a href='" . get_pagenum_link($pages) . "'>".esc_html__('Last','olam')." &raquo;</a>";
        echo "</ul></div>";
      }}
    else{ // The default wp pagination.
      if( get_next_posts_link() || get_previous_posts_link() ) { 
        echo '<div class="pagination-centered">
        <ul class="pagination pagination-lg">
          <li>'.get_previous_posts_link('&laquo; '.esc_html__("Previous Entries","olam").'').'</li>
          <li>'.get_next_posts_link(''.esc_html__("Next Entries","olam").' &raquo;').'</li>
        </ul>
      </div>';
    }
  }
}
}

/**
 * Olam Function - Quick Contact Action.
 *
 * This function sets the quick contact ajax action.
 */

if( ! function_exists( 'olam_quickcontact_action' ) ){
  function  olam_quickcontact_action(){

    $admin_email=get_option("admin_email");
    $fromemail=get_theme_mod('olam_from_email');
    $to = "$admin_email";
    $cname=$_POST['qc-name'];
    $cemail=$_POST['qc-email'];
    $cmessage=$_POST['message'];
    $subject = $cname.esc_html__(" sends you a contact message","olam");
    $msg = "<table width=100% border=1 cellspacing=0 cellpadding=5><tr><td>&nbsp;".esc_html__('Name','olam')."</td><td>&nbsp;$cname</td></tr><tr><td>&nbsp;".esc_html__('Email','olam')."</td><td>&nbsp;$cemail</td></tr><tr><td>&nbsp;".esc_html__('Message','olam')."</td><td>&nbsp;$cmessage</td></tr></table>";
    if(isset($fromemail) && strlen($fromemail)>0){
      $headers = "From: $subject <$fromemail>" . "\r\n" ."Content-type: text/html; charset=iso-8859-1\r\n".
      "Reply-To: $c_name" . "\r\n" .
      "X-Mailer: PHP/" . phpversion();
    }
    else {
      $headers = "Content-type: text/html; charset=iso-8859-1\r\n".
      "Reply-To: $c_name" . "\r\n" .
      "X-Mailer: PHP/" . phpversion();
    }
    if(wp_mail ($to, $subject, $msg, $headers)){
      esc_html_e("Contact Form Submitted Successfully","olam");
      die;
    }

  }
}

add_action( 'wp_ajax_olam_quickcontact_action',  'olam_quickcontact_action');
add_action( 'wp_ajax_nopriv_olam_quickcontact_action',  'olam_quickcontact_action');

/**
 * Olam Function - Contact Action.
 *
 * This function sets the contact form ajax action.
 */

if( ! function_exists( 'olam_contact_action' ) ){
  function  olam_contact_action(){

    $admin_email=get_option("admin_email");
    $admin_email = (isset($admin_email))?$admin_email:null;
    $fromemail=get_theme_mod('olam_from_email');
    $to = "$admin_email";
    $cname=$_POST['c-name'];
    $cemail=$_POST['c-email'];
    $cmessage=$_POST['c-message'];
    $subject = $cname.esc_html__(" sends you a contact message","olam");
    $msg = "<table width=100% border=1 cellspacing=0 cellpadding=5><tr><td>&nbsp;".esc_html__('Name','olam')."</td><td>&nbsp;$cname</td></tr><tr><td>&nbsp;".esc_html__('Email','olam')."</td><td>&nbsp;$cemail</td></tr><tr><td>&nbsp;".esc_html__('Message','olam')."</td><td>&nbsp;$cmessage</td></tr></table>";
    if(isset($fromemail) && strlen($fromemail)>0){
      $headers = 'From: $cname <$fromemail>' . "\r\n".
      "Content-type: text/html; charset=iso-8859-1\r\n".
      "Reply-To: $cname" . "\r\n" .
      "X-Mailer: PHP/" . phpversion();
    }
    else {
      $headers = "Content-type: text/html; charset=iso-8859-1\r\n".
      "Reply-To: $cname" . "\r\n" .
      "X-Mailer: PHP/" . phpversion();
    }
    if(isset($to) && strlen($to)>0){
      if(wp_mail ($to, $subject, $msg, $headers)){
        esc_html_e("Contact Form Submitted Successfully","olam");
        die;
      }
    }
    else
    {
      esc_html_e("Please set your Admin Email","olam");
      die;
    }

  }
}

add_action( 'wp_ajax_olam_contact_action',  'olam_contact_action');
add_action( 'wp_ajax_nopriv_olam_contact_action',  'olam_contact_action');

/**
 * Olam Function - ajax url.
 *
 * This function sets the ajaxurl.
 */

if( ! function_exists( 'olam_ajaxurl' ) ){
  function olam_ajaxurl() {
    ?>
    <script type="text/javascript">
      var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
    </script>
    <?php
  }
}
add_action('wp_head','olam_ajaxurl');

/**
 * Olam Function - Get Author Tags.
 *
 * This function gets the author posts tags.
 */

if( ! function_exists( 'olam_get_author_tags' ) ){
  function olam_get_author_tags($id) {
    $user_tags = array();
    $query = new WP_Query(array(
      'posts_per_page' => -1,
      'author' => $id,
      'post_type'=>'download'
      ) );
    while ($query->have_posts()) {
      $query->the_post();
      $tags = wp_get_object_terms( get_the_ID(), 'download_tag');
      foreach ($tags as $key => $val) {
        if ($val->term_id > 0) {
          if (!array_key_exists($val->term_id, $user_tags)) {
            $user_tags[$val->term_id] = $val;
          }
        }
      }
    }
    return $user_tags;
  }
}

/**
 * Olam Function - Get page options.
 *
 * This function gets the page meta options.
 */

if( ! function_exists( 'olam_get_page_option' ) ){
  function olam_get_page_option($pageID,$pageOption){

    $allOptions= get_post_meta($pageID,'fw_options');
    $pageOptionData=(isset($allOptions[0][$pageOption]))?$allOptions[0][$pageOption]:false;
    return $pageOptionData;

  }
}

/**
 * Olam Function - EDD Sale Count.
 *
 * This function gets the edd sale count.
 */

if( ! function_exists( 'olam_get_edd_sale_count' ) ){
  function olam_get_edd_sale_count($postID){
   return get_post_meta( $postID, '_edd_download_sales', true ); 
 }
}

/**
 * Olam Function -  Get Comments.
 *
 * This function gets downloads comment count.
 */

if( ! function_exists( 'olam_get_comment_count' ) ){
  function olam_get_comment_count($postID){
    $itemComments=get_comments(
      array (
        // post ID
        'post_id' => $postID,
        // return just the total number
        'count'   => TRUE
        )
      );
    return $itemComments;
  }
}

/**
 * Olam Function - Authorization init.
 *
 * Initializing the authorisation.
 */

if( ! function_exists( 'olam_authorisation_init' ) ){
  function olam_authorisation_init(){
    $loginRedirect=home_url();
    wp_enqueue_script('olam-register-login', get_template_directory_uri().'/js/olam-register-login.js', array('jquery'));
    wp_localize_script( 'olam-register-login', 'ajax_auth_object', array(
      'ajaxurl'     => admin_url( 'admin-ajax.php' ),
      'redirecturl'   => isset($loginRedirect) ? $loginRedirect : home_url(),
      'loadingmessage'  => esc_html__('Sending user info, please wait...','olam')
      ));
    add_action( 'wp_ajax_olam_ajaxlogin', 'olam_ajaxlogin' );
    add_action( 'wp_ajax_nopriv_olam_ajaxlogin', 'olam_ajaxlogin' );
    add_action( 'wp_ajax_nopriv_olam_ajaxregister','olam_ajax_register' );
    add_action( 'wp_ajax_olam_ajaxregister', 'olam_ajax_register' );
  }
}
add_action('init', 'olam_authorisation_init');

/**
 * Olam Function - Ajax Login.
 *
 * Ajax popup login actions.
 */

if( ! function_exists( 'olam_ajaxlogin' ) ){
  function olam_ajaxlogin(){

    // First check the nonce, if it fails the function will break
    check_ajax_referer( 'ajax-login-nonce', 'security' );

    // Nonce is checked, get the POST data and sign user on
    // Call auth_user_login
    olam_auth_user_login($_POST['username'], $_POST['password'], 'Login'); 
    
    die();
  }
}

/**
 * Olam Function - Ajax Register.
 *
 * Ajax popup register actions.
 */

if( ! function_exists( 'olam_ajax_register' ) ){
  function olam_ajax_register(){

   global $options; $options = get_option('olam_register_login');

    // First check the nonce, if it fails the function will break
   check_ajax_referer( 'ajax-register-nonce', 'security' );

    // Nonce is checked, get the POST data and sign user on
   $info = array();
   $info['user_nicename'] = $info['nickname'] = $info['display_name'] = $info['first_name'] = $info['user_login'] = sanitize_user($_POST['username']) ;
   $info['user_pass'] = sanitize_text_field($_POST['password']);
   $info['user_email'] = sanitize_email( $_POST['email']);

  // Register the user

   if(!is_email($info['user_email']) ){
    echo json_encode(array('loggedin'=>false, 'message'=>esc_html__("Please enter a valid email address","olam")));
    die();
  }
  if(sanitize_text_field($_POST['password2'])!=$info['user_pass']){
    echo json_encode(array('loggedin'=>false, 'message'=>esc_html__("Please enter same password in both fields","olam")));
    die();
  }
  if(!isset($info['user_pass'])|| !(strlen($info['user_pass']) >0 ) ){
    echo json_encode(array('loggedin'=>false, 'message'=>esc_html__("Password fields cannot be blank","olam")));
    die();
  }

  $user_register = wp_insert_user( $info );
  if ( is_wp_error($user_register) ){ 
    $error  = $user_register->get_error_codes() ;

    if(in_array('empty_user_login', $error))
      echo json_encode(array('loggedin'=>false, 'message'=>$user_register->get_error_message('empty_user_login')));
    elseif(in_array('existing_user_login',$error))
      echo json_encode(array('loggedin'=>false, 'message'=>esc_html__('This username is already registered.','olam')));
    elseif(in_array('existing_user_email',$error))
      echo json_encode(array('loggedin'=>false, 'message'=>esc_html__('This email address is already registered.','olam')));
  } else {
    registerPartner($user_register);
    olam_auth_user_login($info['nickname'], $info['user_pass'], 'Registration');
  }

  
}
}

/**
 * Olam Function - Auth user login.
 *
 * Authenticating the popup login user.
 */

if( ! function_exists( 'olam_auth_user_login' ) ){
  function olam_auth_user_login($user_login, $password, $login)
  { 
    $info = array();
    $info['user_login'] = $user_login;
    $info['user_password'] = $password;
    $info['remember'] = true;
    
    $user_signon = wp_signon( $info, false );
    if ( is_wp_error($user_signon) ){
      echo json_encode(array('loggedin'=>false, 'message'=>esc_html__('Wrong username or password.','olam')));
    } else {
      wp_set_current_user($user_signon->ID); 
      if($login=="Login"){
       echo json_encode(array('loggedin'=>true, 'message'=>esc_html__('Login successful, redirecting...','olam')));
     }
     else{
       echo json_encode(array('loggedin'=>true, 'message'=>esc_html__('Registration successful, redirecting...','olam')));
     }
     
   }
   
   die();
 }
}

/**
 * Olam Function - Printing the current user name.
 *
 * Displays the currently logged in user name.
 */

if( ! function_exists( 'olam_print_current_user_name' ) ){
  function olam_print_current_user_name(){
    $current_user = wp_get_current_user();
    echo esc_html($current_user->user_login);
  }
}
add_action( 'wp_ajax_olam_main_ajax',  'olam_main_ajax' );
add_action( 'wp_ajax_nopriv_olam_main_ajax','olam_main_ajax');

/**
 * Olam Function - Main Ajax,mini cart.
 *
 * Mini cart main ajax action.
 */

if( ! function_exists( 'olam_main_ajax' ) ){
  function olam_main_ajax(){
    if(isset($_GET['cart_count']) && ($_GET['cart_count']==1) ){
      echo edd_get_cart_quantity();
    }
    else{
      olam_print_mini_cart();
    }
    die();
  }
}

/**
 * Olam Function - Remove Item Url
 * Returns the URL to remove an item from the cart (Used in Mini cart)
 *
 * parameters   => int    - $cart_key   - Cart item key
 *                 int    - $cart_key_id- Cart item Post ID
 * return value => string - $remove_url - URL to remove the cart item
 */

if( ! function_exists( 'olam_remove_item_url' ) ){
  function olam_remove_item_url( $cart_key, $cart_key_id ) {
    if ( defined( 'DOING_AJAX' ) ) {
      $current_page = edd_get_current_page_url();
    } else {
      $current_page = edd_get_current_page_url();
    }

    $remove_url = edd_add_cache_busting( add_query_arg( array( 'cart_item' => $cart_key, 'edd_action' => 'remove' ), $current_page ) );
    return apply_filters( 'edd_remove_item_url', $remove_url );
  }
}


/**
 * Olam Function - Print Mini Cart
 *
 * Displays the header minicart widget
 */

if( ! function_exists( 'olam_print_mini_cart' ) ){
  function olam_print_mini_cart(){ 
    if(!olam_check_edd_exists()){
      return; 
    }
    ?>
    <div class="cart-widget">
      <span class="cart-btn">
        <i class="demo-icon icon-cart"></i>
        <span> <?php echo edd_get_cart_quantity();?> <?php esc_html_e("","olam"); ?></span>
      </span>
      <!-- Cart widget -->
      <div class="dd-cart">
        <div class="inner-scroll">
          <ul class="cart_list product_list_widget ">
            <?php $cartContents=edd_get_cart_contents();                    
            if($cartContents){
              foreach ($cartContents as $cartContentsKey => $cartContentsValue) { 
                ?>
                <li>
                  <a href="<?php echo esc_url( wp_nonce_url( edd_remove_item_url( $cartContentsKey ), 'edd-remove-from-cart-' . $cartContentsKey, 'edd_remove_from_cart_nonce' ) ); ?>" class="remove-item edd_cart_remove_item_btn" title="<?php esc_attr_e('Remove this item','olam');?>">x</a>                                                    
                  <a href="<?php echo get_permalink($cartContentsValue['id']); ?>">
                    <?php
                    $featImage=null;
                    $theDownloadImage=get_post_meta($cartContentsValue['id'],'download_item_thumbnail_id'); 
                    if(is_array($theDownloadImage) && (count($theDownloadImage)>0) ){
                      $thumbID=$theDownloadImage[0];
                      $featImage=wp_get_attachment_image_src($thumbID,'olam-product-thumb-small');
                      $featImage=$featImage[0];
                    }
                    else{
                      $thumbID=get_post_thumbnail_id($cartContentsValue['id']);
                      $featImage=wp_get_attachment_image_src($thumbID,'olam-product-thumb-small');
                      $featImage=$featImage[0];
                    }           
                    ?>
                    <?php if(isset($featImage)&&strlen($featImage)>0) { 
                      $alt = get_post_meta($thumbID, '_wp_attachment_image_alt', true);
                      ?> 
                      <img src="<?php echo esc_url($featImage);  ?>" class="attachment-shop_thumbnail wp-post-image" alt="<?php echo esc_attr($alt); ?>">
                      <?php } ?>
                      <?php echo esc_html(get_the_title($cartContentsValue['id'])); ?>
                    </a>
                    <span class="quantity">
                      <?php echo esc_html($cartContentsValue['quantity']); ?> x <span class="amount"><?php 
                      if(count($cartContentsValue['options'])>0){ 
                        echo edd_cart_item_price( $cartContentsValue['id'], $cartContentsValue['options']);
                      }
                      else{
                       edd_price($cartContentsValue['id']); 
                     }
                     ?></span>
                   </span>
                   <span class="clearfix"></span>
                 </li>
                 <?php  } ?>
               </ul><!-- end product list -->
               <p class="total"><strong><?php esc_html_e("Итого:","olam"); ?></strong> <span class="amount"><?php edd_cart_total(); ?></span></p>
               <p class="buttons">
                <a href="<?php echo edd_get_checkout_uri(); ?>"><?php esc_html_e("Перейти к оплате","olam"); ?></a>
              </p>
              <?php } else { ?>
              <li>
                <div class="empty-cart text-center">
                  <div class="cart-icon"><i class="demo-icon icon-cart"></i></div>
                  <span class="edd_empty_cart"><?php esc_html_e("Корзина пуста!","olam"); ?></span>
                </div>
              </li>
            </ul>
            <?php } ?>
          </div>
        </div>                        
      </div>
      <?php  }
    }


/**
 * Olam Function - Is Default Editor Only.
 *
 * Check whether the page is using the default WordPress editor only
 * not the unyson shortcodes or pagebuilder .
 */

if( ! function_exists( 'olam_is_default_editor_only' ) ){
  function olam_is_default_editor_only(){
    $pageMeta=get_post_meta(get_the_ID(),'fw_options');
    if(isset($pageMeta[0]['page-builder']['builder_active'])){
      if($pageMeta[0]['page-builder']['builder_active']==1){
        return false;
      }
    }
    return true;
  }
}

/**
 * Olam Function - Get Avatar Url.
 *
 * Getting the avatar url.
 */

if( ! function_exists( 'olam_get_avatar_url' ) ){
  function olam_get_avatar_url($get_avatar){
    preg_match("/src='(.*?)'/i", $get_avatar, $matches);
    return $matches[1];
  }
}
/**
 * Olam Function - Build author url.
 *
 * Returns the author downloads page url for author link
 * displayed the downloads lists pages.
 */

if( ! function_exists( 'olam_build_author_url' ) ){
  function olam_build_author_url($author) {
    //https://joberli.ru/author/admin/?author_downloads=true
    return get_site_url() . "/author/" . get_the_author_meta( "user_login", $author ) . "/?author_downloads=true";
  }
  function olam_build_author_chat_url($author, $chat = false) {
    $openChat = "";
    if($chat) {
      $openChat = "&tab=chat";
    }
    return add_query_arg( 'author_downloads', 'true', get_author_posts_url($author) ) . $openChat;
  }
}

/* Adding Image Upload and other Fields in author page */
add_action( 'show_user_profile', 'olam_extra_profile_fields' );
add_action( 'edit_user_profile', 'olam_extra_profile_fields' );

/**
 * Olam Function - Extra Profile Fields.
 *
 * Adding extra fields to author profile,displayed in author archive for downloads.
 */

if( ! function_exists( 'olam_extra_profile_fields' ) ){
  function olam_extra_profile_fields( $user ) 
  { 
    ?>

    <h3><?php esc_html_e("Author Download Page Fields","olam"); ?></h3>
    <table class="form-table fh-profile-upload-options">
      <tr>
        <th>
          <label for="author_page_title"><?php esc_html_e("Author Downloads Page Title","olam"); ?></label>
        </th>
        <td>
          <input type="text" name="author_page_title" id="author_page_title" value="<?php echo esc_attr( get_the_author_meta( 'author_page_title', $user->ID ) ); ?>" class="regular-text" />      
          <span class="description"><?php esc_html_e("Please input Author Page Title.","olam"); ?></span>
        </td>
      </tr>
      <tr>
        <th>
          <label for="author_page_subtitle"><?php esc_html_e("Author Downloads Page Subtitle","olam"); ?></label>
        </th>
        <td>
          <input type="text" name="author_page_subtitle" id="author_page_subtitle" value="<?php echo esc_attr( get_the_author_meta( 'author_page_subtitle', $user->ID ) ); ?>" class="regular-text" />      
          <span class="description"><?php esc_html_e("Please input Author Subtitle.","olam"); ?></span>
        </td>
      </tr>
    </table>
    <table class="form-table fh-profile-upload-options">
      <tr>
        <th>
          <label for="authorbanner"><?php esc_html_e("Author Profile Picture","olam"); ?></label>
        </th>
        <td>
          <img class="user-preview-image" src="<?php echo esc_attr( get_the_author_meta( 'authorbanner', $user->ID ) ); ?>">
          <input type="text" name="authorbanner" id="authorbanner" value="<?php echo esc_attr( get_the_author_meta( 'authorbanner', $user->ID ) ); ?>" class="regular-text" />
          <input type='button' class="button-primary" value="<?php esc_html_e("Upload Image","olam"); ?>" id="authorbannerUploadimage"/><br />
          <span class="description"><?php esc_html_e("Please upload your author profile picture(square).","olam"); ?></span>
        </td>
      </tr>
    </table>
    <h3><?php esc_html_e("Social Media","olam"); ?></h3>
    <table class="form-table fh-profile-upload-options">
      <tr>
        <th>
          <label for="author_fb_url"><?php esc_html_e("Facebook Url","olam"); ?></label>
        </th>
        <td>
          <input type="text" name="author_fb_url" id="author_fb_url" value="<?php echo esc_attr( get_the_author_meta( 'author_fb_url', $user->ID ) ); ?>" class="regular-text" />      
          <span class="description"><?php esc_html_e("Please input facebook url.","olam"); ?></span>
        </td>
      </tr>
      <tr>
        <th>
          <label for="author_youtube_url"><?php esc_html_e("Youtube Url","olam"); ?></label>
        </th>
        <td>
          <input type="text" name="author_youtube_url" id="author_youtube_url" value="<?php echo esc_attr( get_the_author_meta( 'author_youtube_url', $user->ID ) ); ?>" class="regular-text" />      
          <span class="description"><?php esc_html_e("Please input youtube url.","olam"); ?></span>
        </td>
      </tr>
      <tr>
        <th>
          <label for="author_twitter_url"><?php esc_html_e("Twitter Url","olam"); ?></label>
        </th>
        <td>
          <input type="text" name="author_twitter_url" id="author_twitter_url" value="<?php echo esc_attr( get_the_author_meta( 'author_twitter_url', $user->ID ) ); ?>" class="regular-text" />
          <span class="description"><?php esc_html_e("Please input twitter url.","olam"); ?></span>
        </td>
      </tr>
      <tr>
        <th>
          <label for="author_linkedin_url"><?php esc_html_e("LinkedIn Url","olam"); ?></label>
        </th>
        <td>
          <input type="text" name="author_linkedin_url" id="author_linkedin_url" value="<?php echo esc_attr( get_the_author_meta( 'author_linkedin_url', $user->ID ) ); ?>" class="regular-text" />    
          <span class="description"><?php esc_html_e("Please input linked in url.","olam"); ?></span>
        </td>
      </tr>
      <tr>
        <th>
          <label for="author_gplus_url"><?php esc_html_e("Google Plus Url","olam"); ?></label>
        </th>
        <td>
          <input type="text" name="author_gplus_url" id="author_gplus_url" value="<?php echo esc_attr( get_the_author_meta( 'author_gplus_url', $user->ID ) ); ?>" class="regular-text" />
          <span class="description"><?php esc_html_e("Please input google plus url.","olam"); ?></span>
        </td>
      </tr>

      <tr>
        <th>
          <label for="author_instagram_url"><?php esc_html_e("Instagram Url","olam"); ?></label>
        </th>
        <td>
          <input type="text" name="author_instagram_url" id="author_instagram_url" value="<?php echo esc_attr( get_the_author_meta( 'author_instagram_url', $user->ID ) ); ?>" class="regular-text" />
          <span class="description"><?php esc_html_e("Please input Instagram url.","olam"); ?></span>
        </td>
      </tr>
    </table>
    <script type="text/javascript">
      (function( $ ) {

        $( 'input#authorbannerUploadimage' ).on('click', function() {
          tb_show('', 'media-upload.php?type=image&TB_iframe=true');

          window.send_to_editor = function( html ) 
          {
            imgurl = $( 'img', html ).attr( 'src' );
            $( '#authorbanner' ).val(imgurl);
            tb_remove();
          }

          return false;
        });
      })(jQuery);
    </script>

    <?php 
  }
}

add_action( 'personal_options_update', 'olam_save_extra_profile_fields' );
add_action( 'edit_user_profile_update', 'olam_save_extra_profile_fields' );

/**
 * Olam Function - Save Extra Profile Fields.
 *
 * Saving  extra fields in author profile page in admin.
 */

if( ! function_exists( 'olam_save_extra_profile_fields' ) ){
  function olam_save_extra_profile_fields( $user_id ) {

    if ( !current_user_can( 'edit_user', $user_id ) )
    {
      return false;
    }

    update_user_meta( $user_id, 'authorbanner', wp_kses_post($_POST[ 'authorbanner' ]) );
    update_user_meta( $user_id, 'author_fb_url', wp_kses_post($_POST[ 'author_fb_url' ]) );
    update_user_meta( $user_id, 'author_youtube_url', wp_kses_post($_POST[ 'author_youtube_url' ] ));
    update_user_meta( $user_id, 'author_linkedin_url', wp_kses_post($_POST[ 'author_linkedin_url' ]) );
    update_user_meta( $user_id, 'author_twitter_url', wp_kses_post($_POST[ 'author_twitter_url' ]) );
    update_user_meta( $user_id, 'author_gplus_url', wp_kses_post($_POST[ 'author_gplus_url' ]) );
    update_user_meta( $user_id, 'author_instagram_url', wp_kses_post($_POST[ 'author_instagram_url' ]) );
    update_user_meta( $user_id, 'author_page_title', wp_kses_post($_POST[ 'author_page_title' ]) );
    update_user_meta( $user_id, 'author_page_subtitle', wp_kses_post($_POST[ 'author_page_subtitle' ]) );
  }
}

/**
 * Olam Function - Enqueue Admin scripts.
 *
 * Enqueing admin page scripts.
 */

if( ! function_exists( 'olam_enqueue_admin' ) ){
  function olam_enqueue_admin()
  {
    wp_enqueue_script( 'thickbox' );
    wp_enqueue_style('thickbox');
    wp_enqueue_script('media-upload');
  }
}
add_action( 'admin_enqueue_scripts', 'olam_enqueue_admin' );

/**
 * Olam Function - Load google font styles.
 *
 * Returning user selected google fonts .
 */

if( ! function_exists( 'olam_load_googlefont_styles' ) ){
  function olam_load_googlefont_styles(){
    $olambodyfont=get_theme_mod('olam_bodyfont');
    $olamheadfont=get_theme_mod('olam_headfont');
    $bodyFont=(isset($olambodyfont))?$olambodyfont:null;
    $headFont=(isset($olamheadfont))?$olamheadfont:null;
    $bodyFont=olam_check_system_fonts($bodyFont);
    $headFont=olam_check_system_fonts($headFont);
    $fontArray=array($bodyFont,$headFont);
    $fontArray=array_filter(array_unique($fontArray));
    if($needleKey=array_search('none', $fontArray)){
      unset($fontArray[$needleKey]);
    }
    $finalFontArray=array();
    foreach ($fontArray as $fontKey => $fontValue) {
      $finalFontArray[]=olam_font_weights($fontValue);     
    }
    $implodedGoogleFonts=implode("|", $finalFontArray);
    return $implodedGoogleFonts;

  }
}

/**
 * Olam Function - Font weights.
 *
 * Loading Font weights for predefined fonts.
 */

if( ! function_exists( 'olam_font_weights' ) ){
  function olam_font_weights($tempFont){

   $presetFonts=array(
    "Open+Sans"=>array(300,400,600,700),
    "Roboto"  =>array(100,300,400,500,700),
    "Roboto Condensed" =>array(300,400,700),
    "Roboto Slab" => array(100,300,400,700),
    "Lato"    => array(100,300,400,700),
    "Oswald"  => array(300,400,700),
    "Raleway"   => array(100,300,400,500,700),
    "Droid Sans"=> array(400,700),
    "Ubuntu"  =>   array(300,400,500,700),
    "Montserrat" => array(400,700)
    );

   if(array_key_exists($tempFont, $presetFonts)){
     $tempFont=str_replace(' ','+', $tempFont);
     if(is_array($presetFonts[$tempFont])){
       $theFinalFont=$tempFont.":".implode(",", $presetFonts[$tempFont]);
     }
   }
   else{
    $gFile = INC_PATH . '/googlefonts.php';
    $gFonts= include $gFile;
    if(array_key_exists($tempFont, $gFonts)){
      $tempFsize=array();
      foreach ($gFonts[$tempFont]['variants'] as $tempFkey => $tempFvalue) {
        $tempFsize[]=$tempFvalue['id'];
      }
      $finalSizeArray=array_map("olam_array_filter",$tempFsize);
      $finalSize=array_filter($finalSizeArray);
      $tempFont=str_replace(' ','+', $tempFont);
      if(is_array($finalSize)){
        $theFinalFont=$tempFont.":".implode(",", $finalSize);
      }
    }
    else{
      $tempFont=str_replace(' ','+', $tempFont); 
      $theFinalFont=$tempFont;
    }

  }
  return $theFinalFont;

}
}

/**
 * Olam Function - Array Filter.
 *
 * Custom array filter for google font size .
 */

if( ! function_exists( 'olam_array_filter' ) ){
  function olam_array_filter($item){

    $array=array("300","400","700");
    if(in_array($item, $array)){
      return $item;
    }

  }
}
/**
 * Olam Function - Check System Fonts.
 *
 * Checking if a particular fonts is a system font .
 */

if( ! function_exists( 'olam_check_system_fonts' ) ){
  function olam_check_system_fonts($font){

    $systemFonts=array(
      "arial",
      "verdana",
      "trebuchet",
      "trebuchet ms",
      "georgia",
      "times",
      "tahoma",
      "helvetica"
      );
    if(!in_array($font, $systemFonts)){
      return $font;
    }
    return null;
  }
}


/**
 * Olam Function - Get RevSliders
 * This function gets the saved revolution sliders.
 */

if( ! function_exists( 'olam_get_rev_sliders' ) ){
  function olam_get_rev_sliders (){
    if(!class_exists('RevSlider')){
     return false;
   }
   else{

     $theslider     = new RevSlider();
     $arrSliders = $theslider->getArrSliders();
     $arrA     = array();
     $arrT     = array();
     foreach($arrSliders as $slider){
      $arrA[]     = $slider->getAlias();
      $arrT[]     = $slider->getTitle();
    }
    if($arrA && $arrT){
      $result = array_combine($arrA, $arrT);
    }
    else
    {
      $result = false;
    }
    return $result;
  }
}
}
/**
 * Olam Function - Get Current page url.
 *
 * Returning current page url .
 */

if( ! function_exists( 'olam_get_current_page_url' ) ){
  function olam_get_current_page_url(){

    return$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; 
  }
}
add_action('admin_init','olam_checkRetinaDisplay');


/**
 * Olam Function - Check Retina Display.
 * This function check whether the retina display is enabled in the theme settings.
 */

if( ! function_exists( 'olam_checkRetinaDisplay' ) ){
  function olam_checkRetinaDisplay(){

    $olamOptions=of_get_options();
    if(isset($olamOptions['theme_retina']) && $olamOptions['theme_retina']==1){
      add_filter( 'wp_generate_attachment_metadata', 'olam_retinaAttachmentMeta', 10, 2 );
      add_filter( 'delete_attachment', 'olam_deleteRetinaImages' );
    }

  }
}

/**
 * Olam function - Retina images.
 *
 * This function is attached to the 'wp_generate_attachment_metadata' filter hook.
 */

if( ! function_exists( 'olam_retinaAttachmentMeta' ) ){
  function olam_retinaAttachmentMeta( $metadata, $attachment_id ) {

    foreach ( $metadata as $key => $value ) {
      if ( is_array( $value ) ) {
        foreach ( $value as $image => $attr ) {
          if ( is_array( $attr ) && (count($attr)>0) ){
            olam_createRetinaImages( get_attached_file( $attachment_id ), $attr['width'], $attr['height'], true );
          }
        }

      }

    }

    return $metadata;

  }
}

/**
 * Olam Function - Create retina-ready images.
 *
 * Referenced via olam_retinaAttachmentMeta().
 */

if( ! function_exists( 'olam_createRetinaImages' ) ){
  function olam_createRetinaImages( $file, $width, $height, $crop = false ) {

    if ( $width || $height ) {

      $resized_file = wp_get_image_editor( $file );
      if ( ! is_wp_error( $resized_file ) ) {
        $filename = $resized_file->generate_filename( $width . 'x' . $height . '@2x' );
        $resized_file->resize( $width * 2, $height * 2, $crop );
        $resized_file->save( $filename );
        $info = $resized_file->get_size();

        return array(
          'file' => wp_basename( $filename ),

          'width' => $info['width'],

          'height' => $info['height'],

          );
      }

    }

    return false;

  }
}

/**
 * Olam Function - Delete retina-ready images.
 *
 * This function is attached to the 'delete_attachment' filter hook.
 */

if( ! function_exists( 'olam_deleteRetinaImages' ) ){
  function olam_deleteRetinaImages( $attachment_id ) {

    $meta = wp_get_attachment_metadata( $attachment_id );
    $upload_dir = wp_upload_dir();
    $path = (isset($meta['file']))?pathinfo( $meta['file'] ):null;
    if((is_array($meta)) && count($meta)>0){
      foreach ( $meta as $key => $value ) {
        if ( 'sizes' === $key ) {
          foreach ( $value as $sizes => $size ) {
            $original_filename = $upload_dir['basedir'] . '/' . $path['dirname'] . '/' . $size['file'];
            $retina_filename = substr_replace( $original_filename, '@2x.', strrpos( $original_filename, '.' ), strlen( '.' ) );
            if ( file_exists( $retina_filename ) )
              unlink( $retina_filename );
          }
        }
      }
    }
  }
}

/**
 * Olam Function - Check if added to cart.
 *
 * Check if an item exists or is added to cart already.
 */

if( ! function_exists( 'olam_check_if_added_to_cart' ) ){
  function olam_check_if_added_to_cart( $itemID ) {

    $cartItems=edd_get_cart_contents();
    $cartIDs=olam_get_cart_IDs($cartItems);
    if(in_array($itemID, $cartIDs)){
      return true;
    }
    return false;
  }
}

/**
 * Olam Function - Get cart item ids.
 *
 * Getting the cart item ids.
 */

if( ! function_exists( 'olam_get_cart_IDs' ) ){
  function olam_get_cart_IDs( $cartItems ) {

    $cartIDs=array();
    if(is_array($cartItems)){
      foreach ($cartItems as $cartItemkey => $cartItemvalue) {
        $cartIDs[]=$cartItemvalue['id'];
      }
    }
    return $cartIDs;
  }
}



// =========== TGM_Plugin =============

  /**
   * This file represents an example of the code that themes would use to register
   * the required plugins.
   *
   * It is expected that theme authors would copy and paste this code into their
   * functions.php file, and amend to suit.
   *
   * @see http://tgmpluginactivation.com/configuration/ for detailed documentation.
   *
   * @package    TGM-Plugin-Activation
   * @subpackage Example
   * @version    2.6.1
   * @author     Thomas Griffin, Gary Jones, Juliette Reinders Folmer
   * @copyright  Copyright (c) 2011, Thomas Griffin
   * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
   * @link       https://github.com/TGMPA/TGM-Plugin-Activation
   */

  /**
   * Include the TGM_Plugin_Activation class.
   *
   * Depending on your implementation, you may want to change the include call:
   *
   * Parent Theme:
   * require_once get_template_directory() . '/path/to/class-tgm-plugin-activation.php';
   *
   * Child Theme:
   * require_once get_stylesheet_directory() . '/path/to/class-tgm-plugin-activation.php';
   *
   * Plugin:
   * require_once dirname( __FILE__ ) . '/path/to/class-tgm-plugin-activation.php'; // change "dirname( __FILE__ )" to "get_template_directory()" for Themeforest standards.
   */
  require_once get_template_directory() . '/admin/class-tgm-plugin-activation.php';

  add_action( 'tgmpa_register', 'olam_register_required_plugins' );

  /**
   * Register the required plugins for this theme.
   *
   * In this example, we register five plugins:
   * - one included with the TGMPA library
   * - two from an external source, one from an arbitrary source, one from a GitHub repository
   * - two from the .org repo, where one demonstrates the use of the `is_callable` argument
   *
   * The variables passed to the `tgmpa()` function should be:
   * - an array of plugin arrays;
   * - optionally a configuration array.
   * If you are not changing anything in the configuration array, you can remove the array and remove the
   * variable from the function call: `tgmpa( $plugins );`.
   * In that case, the TGMPA default settings will be used.
   *
   * This function is hooked into `tgmpa_register`, which is fired on the WP `init` action on priority 10.
   */
  function olam_register_required_plugins() {
    /*
     * Array of plugin arrays. Required keys are name and slug.
     * If the source is NOT from the .org repo, then source is also required.
     */
    $plugins = array(

      // This is an example of how to include a plugin bundled with a theme.
      array(
        'name'               => esc_html__( 'Olam Edd Fes', 'olam' ), // The plugin name.
        'slug'               => 'olam-edd-fes-meta-fields', // The plugin slug (typically the folder name).
        'source'             => esc_url( get_template_directory_uri() . '/admin/plugins/olam-edd-fes-meta-fields.zip' ), // The plugin source.
        'required'           => false, // If false, the plugin is only 'recommended' instead of required.
        ),
      array(
        'name'               => esc_html__( 'Olam Muliple Images', 'olam' ),
        'slug'               => 'olam-multiple-images',
        'source'             => esc_url( get_template_directory_uri() . '/admin/plugins/olam-multiple-images.zip' ),
        'required'           => true,
        'version'            => '1.1',
        ),
      array(
        'name'               => esc_html__( 'Layero - EDD Related Downloads', 'olam' ),
        'slug'               => 'layero-edd-related-downloads',
        'source'             => esc_url( get_template_directory_uri() . '/admin/plugins/layero-edd-related-downloads.zip' ),
        'required'           => false,
        'version'            => '1',
        ),
      // This is an example of how to include a plugin from the WordPress Plugin Repository.
      array(
        'name'      => esc_html__( 'Unyson', 'olam' ),
        'slug'      => 'unyson',
        'required'  => true,
        ),
      array(
        'name'      => esc_html__( 'Easy Digital Downloads', 'olam' ),
        'slug'      => 'easy-digital-downloads',
        'required'  => false,
        ),

    );

    /*
     * Array of configuration settings. Amend each line as needed.
     *
     * TGMPA will start providing localized text strings soon. If you already have translations of our standard
     * strings available, please help us make TGMPA even better by giving us access to these translations or by
     * sending in a pull-request with .po file(s) with the translations.
     *
     * Only uncomment the strings in the config array if you want to customize the strings.
     */
    $config = array(
      'id'           => 'olam',                 // Unique ID for hashing notices for multiple instances of TGMPA.
      'default_path' => '',                      // Default absolute path to bundled plugins.
      'menu'         => 'tgmpa-install-plugins', // Menu slug.
      'parent_slug'  => 'themes.php',            // Parent menu slug.
      'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
      'has_notices'  => true,                    // Show admin notices or not.
      'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
      'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
      'is_automatic' => false,                   // Automatically activate plugins after installation or not.
      'message'      => '',                      // Message to output right before the plugins table.

    );

    tgmpa( $plugins, $config );
  }

// =========== _/\_ TGM section ends _/\_ =============



/* Adding featured download meta box */

add_action( 'add_meta_boxes', 'olam_meta_box_add' );
if( ! function_exists( 'olam_meta_box_add' ) )
{
  function olam_meta_box_add()
  {
    add_meta_box( 'olam-meta-box-featured', esc_html__('Featured Download','olam'), 'olam_meta_box_cb', 'download', 'side');
  }
}


/**
 * Olam Function - Meta box CB.
 *
 * Adding a new meta box.
 */

if( ! function_exists( 'olam_meta_box_cb' ) )
{
  function olam_meta_box_cb( $post )
  {
    $values = get_post_custom( $post->ID );
    $selected = isset( $values['olam_box_select'] ) ? esc_attr( $values['olam_box_select'][0] ) : '';
    wp_nonce_field( 'olam_meta_box_nonce_value', 'olam_box_nonce' );
    ?>    
    <p>
      <label for="olam_box_select"><?php esc_html_e("Is this a featured download","olam"); ?></label>
      <select name="olam_box_select" id="olam_box_select">
        <option value="no" <?php selected( $selected, 'no' ); ?>><?php esc_html_e("No","olam"); ?></option>
        <option value="yes" <?php selected( $selected, 'yes' ); ?>><?php esc_html_e("Yes","olam"); ?></option>
      </select>
    </p>
    <?php    
  }
}


add_action( 'save_post', 'olam_meta_box_save' );


/**
 * Olam Function - Save meta box.
 *
 * Saving the meta box values.
 */

if( ! function_exists( 'olam_meta_box_save' ) )
{
  function olam_meta_box_save( $post_id )
  {
    // Bail if we're doing an auto save
    if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ){ return; }

    // if our nonce isn't there, or we can't verify it, bail
    if( !isset( $_POST['olam_box_nonce'] ) || !wp_verify_nonce( $_POST['olam_box_nonce'], 'olam_meta_box_nonce_value' ) ) { return; }
    
    // if our current user can't edit this post, bail
    if( !current_user_can( 'edit_post',$post_id ) ){ return;  }

    if( isset( $_POST['olam_box_select'] ) ){
      update_post_meta( $post_id, 'olam_box_select', esc_attr( $_POST['olam_box_select'] ) );
    }

  }
}


/**
 * Olam Function - Retina Logo.
 *
 * Olam retina logo implementation.
 */

if( ! function_exists( 'olam_retina_logo' ) )
{
  function olam_retina_logo()
  {
   $olamOptions=of_get_options();
   if( isset($olamOptions['olam_theme_retina_logo']) && (strlen($olamOptions['olam_theme_retina_logo'])>0) ){
    echo '<script>'."\n";
    echo '//<![CDATA['."\n";
    echo 'jQuery(window).load(function(){'."\n";
    echo 'var retina = window.devicePixelRatio > 1 ? true : false;';
    echo 'if( retina ){';

    if( $olamOptions['olam_theme_retina_logo'] ){
      echo 'var retinaEl = jQuery(".logo img.site-logo");';
      echo 'var retinaLogoW = retinaEl.width();';
      echo 'var retinaLogoH = retinaEl.height();';
      echo 'retinaEl';
      echo '.attr( "src", "'. esc_js(esc_url($olamOptions['olam_theme_retina_logo'])) .'" )';
      echo '.width( retinaLogoW )';
      echo '.height( retinaLogoH );';
    }                
    echo '}';
    echo '});'."\n";
    echo '//]]>'."\n";
    echo '</script>'."\n";
  }

}
}
add_action('wp_head', 'olam_retina_logo');

// Fixing the edd schema
add_filter( 'edd_add_schema_microdata', '__return_false' );
remove_filter( 'the_title', 'edd_microdata_title');


/**
 * Olam Function - Olam Excerpt
 *
 * More tag to excerpt.
 */

if( ! function_exists( 'olam_new_excerpt_more' ) )
{
  function olam_new_excerpt_more($more) {
   global $post;
   return '... <a class="moretag" href="'. get_permalink($post->ID) . '"><span class="space">&nbsp;&nbsp;</span>&nbsp;'.esc_html__("read more","olam").'&nbsp;</a>';
 }
}
add_filter('excerpt_more', 'olam_new_excerpt_more');

add_filter('edd_cart_item','olam_edd_cart_item',10, 2);

/**
 * Olam Function - Olam Edd Cart Item
 *
 * Adding image to edd cart.
 */

if( ! function_exists( 'olam_edd_cart_item' ) )
{
  function olam_edd_cart_item($item,$id){

    $featImage=null;
    $theDownloadImage=get_post_meta($id,'download_item_thumbnail_id'); 
    if(is_array($theDownloadImage) && (count($theDownloadImage)>0) ){
      $thumbID=$theDownloadImage[0];
      $featImage=wp_get_attachment_image_src($thumbID,'olam-product-thumb-small');
      $featImage=$featImage[0];
    }
    else{
      $thumbID=get_post_thumbnail_id($id);
      $featImage=wp_get_attachment_image_src($thumbID,'olam-product-thumb-small');
      $featImage=$featImage[0];
    }                 

    if(isset($featImage)){
      $item = str_replace( '{item_image_url}', $featImage, $item );
    }
    return $item;
  }

}

add_filter('edd_empty_cart_message','olam_modify_empty_cart_message');

/**
 * Olam Function - Edd Empty Cart Message modify
 *
 *  Modifying the empty cart message style
 */

if( ! function_exists( 'olam_modify_empty_cart_message' ) )
{
  function olam_modify_empty_cart_message($message){

    $message='<div class="empty-cart text-center"><div class="cart-icon"><i class="demo-icon icon-cart"></i></div><div><span class="edd_empty_cart">' . esc_html__( 'Your cart is empty.', 'olam' ) . '</span><h5 class="primary">'.esc_html__('Please add a product','olam').'</h5></div></div>';
    return $message;
  }
}

/**
 * Olam Function - Custom excerpt length
 *
 *  Modifying the excerpt length
 */

if( ! function_exists( 'olam_custom_excerpt_length' ) )
{
  function olam_custom_excerpt_length( $length ) {
    return 150;
  }
}

add_filter( 'excerpt_length', 'olam_custom_excerpt_length', 999 );


//Disable WordPress sanitization to allow more than just $allowedtags from /wp-includes/kses.php
remove_filter('pre_user_description', 'wp_filter_kses');

//Add sanitization for WordPress posts
add_filter( 'pre_user_description', 'wp_filter_post_kses');

/**
 * Olam Function - Replace Site Url
 *
 *  Replacing the theme options siteurl with actual protocols.
 */

function olam_replace_site_url($url){
  if (is_string($url)) {
    $data = str_replace(
      array(
        '[site_url]', 
        '[site_url_secure]',
        ),
      array(
        site_url('', 'http'),
        site_url('', 'https'),
        ),
      $url
      );
  }
  return $data;
}



/**
 * Olam Function - Price Filter
 *
 *  Removing the id(to fix duplicate id issue) from price displayed.
 */

add_filter("edd_download_price_after_html","olam_edd_price_filter",10, 3);

function olam_edd_price_filter($pricehtml,$id,$price){

  $newpricehtml='<span class="edd_price" >'.$price.'</span>';
  return  $newpricehtml;
}

/**
 * Olam Function - Check for comments/pingbacks
 *
 *  Removing the id(to fix duplicate id issue) from price displayed.
 */

function olam_post_has( $type, $post_id ) {

  $comments = get_comments('status=approve&type=' . $type . '&post_id=' . $post_id );
  $comments = separate_comments( $comments );
  return 0 < count( $comments[ $type ] );

}


/**
 * Olam Function - Validate gravatar
 *
 *  Validating gravatar from email.
 */

function olam_validate_gravatar($email) {
  //print_r($email); die;
  // Craft a potential url and test its headers
  $hash = md5(strtolower(trim($email)));
  $uri = 'http://www.gravatar.com/avatar/' . $hash . '?d=404';
  $headers = @get_headers($uri);
  if (!preg_match("|200|", $headers[0])) {
    $has_valid_avatar = FALSE;
  } else {
    $has_valid_avatar = TRUE;
  }
  return $has_valid_avatar;
}

/**
 * Olam Function - Get terms dropdown
 *
 *  Adding the download category filter.
 */

function olam_get_terms_dropdown($taxonomies, $args){
  $myterms = get_terms($taxonomies, $args);

  $output ="<div class='download_cat_filter'><select name='download_cat'>";
  $output.= "<option value='all'>".esc_html__("Все","olam")."</option>";
  foreach($myterms as $term){
    $term_name =$term->name;
    $slug =$term->slug;
    $output .="<option value='".$slug."'>".$term_name."</option>";
  }
  $output .="</select></div>";
  return $output;
}

/**
 * Olam Function - posts_where Filter edit for search (custom post type = download)
 *
 */

function olam_search_where($where){
  global $wpdb;

  if( is_search() ){

    $where .= "OR (t.name LIKE '%".get_search_query()."%' AND {$wpdb->posts}.post_status = 'publish' )";
    return $where;

  }
}

function olam_search_join($join){
  global $wpdb;

  if( is_search()){
    $join .= "LEFT JOIN {$wpdb->term_relationships} tr ON {$wpdb->posts}.ID = tr.object_id INNER JOIN {$wpdb->term_taxonomy} tt ON tt.term_taxonomy_id=tr.term_taxonomy_id INNER JOIN {$wpdb->terms} t ON t.term_id = tt.term_id";
    return $join;
  }
}

function olam_search_groupby($groupby){
  global $wpdb;

  // we need to group on post ID
  $groupby_id = "{$wpdb->posts}.ID";
  if(!is_search() || strpos($groupby, $groupby_id) !== false) return $groupby;

  // groupby was empty, use ours
  if(!strlen(trim($groupby))) return $groupby_id;

  // wasn't empty, append ours
  return $groupby.", ".$groupby_id;
}

 // add_filter('posts_where','olam_search_where');
  //add_filter('posts_join', 'olam_search_join');
  //add_filter('posts_groupby', 'olam_search_groupby');


/**
 * Do not include php tag
 */ 
add_filter( 'posts_join', 'olam_custom_posts_join', 10, 2 );
/**
 * Callback for WordPress 'posts_join' filter.'
 * 
 * @global $wpdb
 * @see https://codex.wordpress.org/Class_Reference/wpdb
 * 
 * @link https://codex.wordpress.org/Plugin_API/Filter_Reference/posts_join
 * 
 * @param  string   $join     The sql JOIN clause.
 * @param  WP_Query $wp_query The current WP_Query instance.
 * @return string   $join     The sql JOIN clause.
 */
function olam_custom_posts_join( $join, $query ) {

  global $wpdb;
    //* if main query and search...
  if ( is_main_query() && is_search() ) {

        //* join term_relationships, term_taxonomy, and terms into the current SQL where clause
    $join .= "
    LEFT JOIN 
    ( 
    {$wpdb->term_relationships}
    INNER JOIN 
    {$wpdb->term_taxonomy} ON {$wpdb->term_taxonomy}.term_taxonomy_id = {$wpdb->term_relationships}.term_taxonomy_id 
    INNER JOIN 
    {$wpdb->terms} ON {$wpdb->terms}.term_id = {$wpdb->term_taxonomy}.term_id 
    ) 
    ON {$wpdb->posts}.ID = {$wpdb->term_relationships}.object_id ";

  }
  return $join;

}




/**
 * Do not include php tags
 */ 
add_filter( 'posts_where', 'olam_custom_posts_where', 10, 2 );
/**
 * Callback for WordPress 'posts_where' filter.
 * 
 * Modify the where clause to include searches against a WordPress taxonomy.
 * 
 * @see https://codex.wordpress.org/Plugin_API/Filter_Reference/posts_where
 * 
 * @param  string   $where The where clause.
 * @param  WP_Query $query The current WP_Query.
 * @return string          The where clause.
 */ 
function olam_custom_posts_where( $where, $query ) {

  global $wpdb;
  if ( is_main_query() && is_search() ) {

        //* get additional where clause for the user
    $user_where = olam_get_user_posts_where();

    $where .= " OR (
    {$wpdb->term_taxonomy}.taxonomy IN( 'category', 'post_tag' ) 
    AND
    {$wpdb->terms}.name LIKE '%" . esc_sql( get_query_var( 's' ) ) . "%'
    {$user_where}
    )";

  }
  return $where;

}
/**
 * Get a where clause dependent on the current user's status.
 *
 * @global $wpdb
 * @see https://codex.wordpress.org/Class_Reference/wpdb
 * 
 * @uses get_current_user_id()
 * @see http://codex.wordpress.org/Function_Reference/get_current_user_id
 * 
 * @return string The user where clause.
 */
function olam_get_user_posts_where() {

  global $wpdb;
  $user_id = get_current_user_id();
  $sql     = '';
  $status  = array( "'publish'" );
  if ( 0 !== $user_id ) {

    $status[] = "'private'";

    $sql .= " AND {$wpdb->posts}.post_author = " . absint( $user_id );

  }
  $sql .= " AND {$wpdb->posts}.post_status IN( " . implode( ',', $status ) . " ) ";

  return $sql;

}


/**
 * Do not include php tags
 */ 
add_filter( 'posts_groupby', 'olam_custom_posts_groupby', 10, 2 );
/**
 * Callback for WordPress 'posts_groupby' filter.
 * 
 * Set the GROUP BY clause to post IDs.
 * 
 * @global $wpdb
 * @see https://codex.wordpress.org/Class_Reference/wpdb
 * 
 * @param  string   $groupby The GROUPBY caluse.
 * @param  WP_Query $query   The current WP_Query object.
 * @return string            The GROUPBY clause.
 */ 

function olam_custom_posts_groupby( $groupby, $query ) {

  global $wpdb;
    //* if is main query and a search...
  if ( is_main_query() && is_search() ) {
    $groupby = "{$wpdb->posts}.ID";
  }
  return $groupby;
}


/**
 * Remove item link  EDD WISH LISTS
 *
 * @since  1.0.2
 * @param  [type] $item_id [description]
 * @param  [type] $key     [description]
 * @param  [type] $list_id [description]
 * @param  array  $args    [description]
 * @return [type]          [description]
 */
function olam_edd_wl_item_remove_link( $item_id, $key, $list_id, $args = array() ) {

  if ( ! edd_wl_is_users_list( $list_id ) )
    return;

  $defaults = apply_filters( 'edd_wl_item_remove_link_defaults',
    array(
      'text'      => __( 'Remove', 'edd-wish-lists' ),
      'wrapper_class' => '',
      'wrapper'     => 'span',
      'class'     => ''
    )
  );

  $args = wp_parse_args( $args, $defaults );
  extract( $args, EXTR_SKIP );

  // add our default class
  $default_wrapper_class = ' edd-wl-item-remove';
  $wrapper_class .= $wrapper_class ? $default_wrapper_class : trim( $default_wrapper_class );

  $default_class = ' edd-remove-from-wish-list';
  $class .= $class ? $default_class : trim( $default_class );

  ob_start();

  $html = '';

  $label = $text ? '<span class="hide-text">' . $text . '</span>' : '';

  $link = '<a href="#" data-cart-item="' . $key . '" data-download-id="' . $item_id . '" data-list-id="' . $list_id . '" data-action="edd_remove_from_wish_list" class="' . $class . '" title="' . $text . '">
  <i class="fa fa-remove"></i>' . $label . '</a>';

  if ( $wrapper )
    $html = '<' . $wrapper . ' class="' . $wrapper_class . '"' . '>' . $link .'</' . $wrapper . '>';
  else
    $html .= $link;

  echo $html;

  $html = ob_get_clean();

  return apply_filters( 'edd_wl_item_remove_link', $html );
}


// ===========  Theme Demo data installation

/**
 * @param FW_Ext_Backups_Demo[] $demos
 * @return FW_Ext_Backups_Demo[]
 */
function olam_filter_theme_fw_ext_backups_demos($demos) {
    $demos_array = array(
        'olam_demo_1_2' => array(
            'title'        => esc_html__('demo1,2-Main', 'olam'),
            'screenshot'   => 'http://themes.layero.com/olamwp/demo-data/demo12-main/screenshot.png',
            'preview_link' => 'http://themes.layero.com/olamwp/',
        ),
        'olam_demo_3' => array(
            'title'        => esc_html__('demo3-Services', 'olam'),
            'screenshot'   => 'http://themes.layero.com/olamwp/demo-data/demo3-services/screenshot.png',
            'preview_link' => 'http://themes.layero.com/olamwp3/',
        ),
        'olam_demo_4' => array(
            'title'        => esc_html__('demo4-Booking', 'olam'),
            'screenshot'   => 'http://themes.layero.com/olamwp/demo-data/demo4-booking/screenshot.png',
            'preview_link' => 'http://themes.layero.com/olamwp4/',
        ),
    );

    $download_url = 'http://themes.layero.com/olamwp/demo-data/index.php';

    foreach ($demos_array as $id => $data) {
        $demo = new FW_Ext_Backups_Demo($id, 'piecemeal', array(
            'url' => $download_url,
            'file_id' => $id,
        ));
        $demo->set_title($data['title']);
        $demo->set_screenshot($data['screenshot']);
        $demo->set_preview_link($data['preview_link']);

        $demos[ $demo->get_id() ] = $demo;

        unset($demo);
    }

    return $demos;
}
add_filter('fw:ext:backups-demo:demos', 'olam_filter_theme_fw_ext_backups_demos');


// Remove WP Version From Styles  
add_filter( 'style_loader_src', 'sdt_remove_ver_css_js', 9999 );
// Remove WP Version From Scripts
add_filter( 'script_loader_src', 'sdt_remove_ver_css_js', 9999 );

// Function to remove version numbers
function sdt_remove_ver_css_js( $src ) {
  if ( strpos( $src, 'ver=' ) )
    $src = remove_query_arg( 'ver', $src );
  return $src;
}

function the_user_link() {
  if(isset($_GET["user"])) {
    $authorID= $_GET["user"];
  } else {
    $authorID= get_current_user_id();
  }
  $authorPostsUrl=olam_build_author_url($authorID);
  return $authorPostsUrl;
}

function user_link($atts) {
  if(isset($_GET["user"])) {
    $authorID= $_GET["user"];
  } else {
    $authorID= get_current_user_id();
  }
  $authorPostsUrl=olam_build_author_url($authorID);
    ?>
      <a class='fes-cmt-submit-form button' href='<? echo $authorPostsUrl; ?>'>Каталог</a>
    <?
}
add_shortcode('user-link', 'user_link');

//Called by Ajax from App - list the contents of the folder so they can be downloaded and stored locally

function is_user_id() {
    //wp_send_json("data");
    wp_send_json($_POST["uid"] == get_current_user_id());

    die();
}

add_action('wp_ajax_isUserId', 'is_user_id');
add_action('wp_ajax_nopriv_isUserId', 'is_user_id');

function the_messages_count() {
  wp_send_json(messages_count(null));
  die();
}

add_action('wp_ajax_messagesCount', 'the_messages_count');
add_action('wp_ajax_nopriv_messagesCount', 'the_messages_count');

function is_post_saved() {
  if(isset($_POST["postId"])) {

    $postId = $_POST["postId"];
    $uid = get_current_user_id();

    if($uid) {
      global $wpdb;

      $results = $wpdb->get_results("SELECT postId FROM user_posts WHERE userId = " . $uid . " AND postId = " . $postId);

      if(isset($results[0])) {
        wp_send_json( true );
      }
    }

  }
  wp_send_json( false );
  die();
}

add_action('wp_ajax_isPostAdded', 'is_post_saved');
add_action('wp_ajax_nopriv_isPostAdded', 'is_post_saved');

function save_post() {
  if(isset($_POST["postId"])) {
    $postId = $_POST["postId"];
    $uid = get_current_user_id();

    if($uid) {
      global $wpdb;

      $results = $wpdb->get_results("SELECT postId FROM user_posts WHERE userId = " . $uid . " AND postId = " . $postId);

      if(!isset($results[0])) {
        $wpdb->insert(
          'user_posts',
          array(
            'userId' => $uid,
            'postId' => $postId
          ),
          array(
            '%d'
          )
        );
      }
    }
  }
  die();
}

add_action('wp_ajax_savePost', 'save_post');
add_action('wp_ajax_nopriv_savePost', 'save_post');

function remove_post() {
  if(isset($_POST["postId"])) {
    $postId = $_POST["postId"];
    $uid = get_current_user_id();

    if($uid) {
      global $wpdb;
      $wpdb->delete(
        "user_posts",
        array( 
          'userId' => $uid,
          'postId' => $postId
          )
      );
    }
  }
  die();
}

add_action('wp_ajax_removePost', 'remove_post');
add_action('wp_ajax_nopriv_removePost', 'remove_post');

function messages_count($atts) {
  try {
      if(!function_exists("rcl_chat_noread_messages_amount")) {
          return 0;
      }
      return rcl_chat_noread_messages_amount(get_current_user_id());
  } catch(Exception $e) {
      return 0;
  }
}

add_shortcode('messages-count', 'messages_count');
add_shortcode("unitpay-account", "getAccount");

function get_saved_posts() {
  ob_start();
  get_template_part('get_saved_posts');
  return ob_get_clean();   
} 
add_shortcode( 'get_saved_posts', 'get_saved_posts' );

function get_partner_statistics() {
  ob_start();
  get_template_part('get_partner_statistics');
  return ob_get_clean();   
} 
add_shortcode( 'get_partner_statistics', 'get_partner_statistics' );

function members_only_shortcode( $atts, $content = null ) 
{
  if ( is_user_logged_in() && !empty( $content ) && !is_feed() )
  {
    return $content;
  }
  return 'Для просмотра этой страницы, вы должны авторизоваться.';
}
add_shortcode( 'members_only', 'members_only_shortcode' );

function get_user_online($userId) {
  global $wpdb;
  $date = date("Y-m-d h:i");
  return $wpdb->get_results("SELECT online_date FROM wp_users WHERE ID = " . $userId)[0]->online_date == $date;
}

function is_online() {
  if(isset($_POST["uid"])) {
    update_users_online();
    global $wpdb;
    $date = date("Y-m-d h:i");
    wp_send_json( $wpdb->get_results("SELECT online_date FROM wp_users WHERE ID = " . $_POST["uid"])[0]->online_date == $date );
  }
}
add_action('wp_ajax_isOnline', 'is_online');
add_action('wp_ajax_nopriv_isOnline', 'is_online');

function update_users_online() {
  global $wpdb;
  $date = date("Y-m-d h:i");
  $wpdb->get_results( "UPDATE wp_users SET online_date='' WHERE NOT(online_date='" . $date . "')" );
}

function update_online() {
  if(is_user_logged_in()) {
    $uid = get_current_user_id();
    if($uid) {
      global $wpdb;
      $date = date("Y-m-d h:i");
      $wpdb->get_results( "UPDATE wp_users SET online_date='" . $date . "' WHERE ID=" . $uid);
    }
  }
}
add_action('wp_ajax_updateOnline', 'update_online');
add_action('wp_ajax_nopriv_updateOnline', 'update_online');

update_users_online();

function escape_htcml_for_float($value) {
  // Strip HTML Tags
  $clear = strip_tags($value);
  // Clean up things like &amp;
  $clear = html_entity_decode($clear);
  // Strip out any url-encoded stuff
  $clear = urldecode($clear);
  // Replace non-AlNum characters with space
  $clear = preg_replace('/[^0-9.]/', ' ', $clear);
  // Replace Multiple spaces with single space
  $clear = preg_replace('/ +/', ' ', $clear);
  // Trim the string of leading/trailing space
  $clear = trim($clear);
  return $clear;
}

// DASHBOARD TABS
// add the dashboard tab item
function dashboard_menu( $menu_items ) {
	$menu_items['contact_form'] = array(
		"icon" => "envelope-square",
		"task" => array( 'contact_form', '' ),
		"name" => __( 'Контакты', 'edd_fes' ),
  );
  $menu_items['partner_link'] = array(
		"icon" => "envelope-square",
		"task" => array( 'partner_link', '' ),
		"name" => __( 'Партнёрам', 'edd_fes' ),
	);
	return $menu_items;
}
add_filter( 'fes_vendor_dashboard_menu', 'dashboard_menu' );

function tabs_response( $custom, $task ) {
	if ( $task == 'contact_form' ) {
		$custom = 'contact_form';
  }
  if ( $task == 'partner_link' ) {
		$custom = 'partner_link';
	}
	return $custom;
}
add_filter( 'fes_signal_custom_task', 'tabs_response', 10, 2 );

function contact_form_tab_content() {
	?>
	<a class="fes-cmt-submit-form button center" href="<? echo get_site_url(null, 'messages');?>">Перейти к сообщениям</a>
	<?
}
add_action( 'fes_custom_task_contact_form','contact_form_tab_content' );

function partner_link_tab_content() {
  ?>
  <div class="center">
    <span>Ваша партнёрская ссылка: </span><a class="fes-cmt-submit-form" href="<? echo getPartnerLink();?>"><? echo getPartnerLink();?></a>
    <a class="fes-cmt-submit-form button center" href="<? echo get_site_url(null, 'statistics');?>">Перейти к статистике</a>
  </div>
	<?
}
add_action( 'fes_custom_task_partner_link','partner_link_tab_content' );

// auto approve new users
$wpdb->get_results( "UPDATE wp_fes_vendors SET status='approved' WHERE status='pending'" );