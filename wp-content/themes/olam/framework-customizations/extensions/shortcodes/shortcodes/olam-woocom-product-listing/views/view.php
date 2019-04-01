<?php if ( ! defined( 'FW' ) ) {

    die( 'Forbidden' );

}
if ( ! class_exists( 'WooCommerce' ) ) {
    die( 'Forbidden - Install WooCommerce' );
}

$type=(isset($atts['producttype']))?$atts['producttype']:null;
$number=(isset($atts['productcount']))?$atts['productcount']:null;
echo do_shortcode( '['.$type.'_products number="'.$number.'"]' );
























