<?php
// ------------------------------------------
// Global define for theme
// ------------------------------------------
defined( 'NRG_PREMIUM_URI' )    or define( 'NRG_PREMIUM_URI',    get_template_directory_uri() );
defined( 'NRG_PREMIUM_T_PATH' ) or define( 'NRG_PREMIUM_T_PATH', get_template_directory() );
defined( 'NRG_PREMIUM_F_PATH' ) or define( 'NRG_PREMIUM_F_PATH', NRG_PREMIUM_T_PATH . '/include' );

// ------------------------------------------
// Framework integration
// ------------------------------------------
// Include all styles and scripts.
// require_once NRG_PREMIUM_F_PATH.'/custom/post-type.php';
require_once NRG_PREMIUM_F_PATH.'/custom/action-config.php';
require_once NRG_PREMIUM_F_PATH.'/custom/helper-functions.php';
require_once NRG_PREMIUM_F_PATH.'/custom/class-Aq_Resize.php';
// Theme like.
require_once NRG_PREMIUM_F_PATH.'/custom/post-like.php';
// Plugin activation class.
require_once NRG_PREMIUM_F_PATH.'/plugins/class-tgm-plugin-activation.php';
require_once NRG_PREMIUM_T_PATH.'/envato_setup/envato_setup.php';

// ------------------------------------------
// Setting theme after setup
// ------------------------------------------
if ( ! function_exists( 'nrg_premium_after_setup' ) ) {
    function nrg_premium_after_setup(){
        load_theme_textdomain( 'nrg_premium', NRG_PREMIUM_T_PATH .'/languages' );

        register_nav_menus(
            array(
                'primary-menu'      => esc_html__( 'Primary menu', 'nrg_premium' ),
                'footer-menu'       => esc_html__( 'Footer menu', 'nrg_premium' ),
                'photography-menu'  => esc_html__( 'Photography menu', 'nrg_premium' ),
                'onepage-menu_1'    => esc_html__( 'Onepage menu 1', 'nrg_premium' ),
                'onepage-menu_2'    => esc_html__( 'Onepage menu 2', 'nrg_premium' ),
                'onepage-menu_3'    => esc_html__( 'Onepage menu 3', 'nrg_premium' ),
                'mag-menu_3'        => esc_html__( 'Magazine menu 3', 'nrg_premium' ),
            )
        );

        add_theme_support( 'post-formats', array('video', 'gallery', 'audio', 'quote','image','status','aside') );
        add_theme_support( 'custom-header' );
        add_theme_support( 'woocommerce' );
        add_theme_support( 'custom-background' );
        add_theme_support( 'automatic-feed-links' );
        add_theme_support( 'html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption') );
        add_theme_support( 'post-thumbnails' );
        add_theme_support( 'title-tag' );
    }
}
add_action( 'after_setup_theme', 'nrg_premium_after_setup' );
if ( ! isset( $content_width ) ) $content_width = 900;

function nrg_premium_add_menuclass($atts, $item, $args) {
    if ( $args->theme_location == 'footer-menu' && in_array('current-page-ancestor', $item->classes) || in_array('current-menu-item', $item->classes) ){
        $atts['class'] = 'active';
    }
    return $atts;
}
add_filter('nav_menu_link_attributes','nrg_premium_add_menuclass', 0,3);

function nrg_premium_body_class( $classes ) {
    $classes[] = 'animsition';
    return $classes;
}
add_filter( 'body_class', 'nrg_premium_body_class' );

function nrg_premium_set_post_views($postID) {
    $count_key = 'wpb_post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    }else{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);

function nrg_premium_track_post_views ($post_id) {
    if ( !is_single() ) return;
    if ( empty ( $post_id) ) {
        global $post;
        $post_id = $post->ID;    
    }
    nrg_premium_set_post_views($post_id);
}
add_action( 'wp_head', 'nrg_premium_track_post_views');

function nrg_premium_get_post_views($postID){
    $count_key = 'wpb_post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return "0";
    }
    return $count;
}

//--add to cart ajax--//
add_action('wp_ajax_prod_add_to_cart', 'nrg_premium_prod_add_to_cart');
add_action('wp_ajax_nopriv_prod_add_to_cart', 'nrg_premium_prod_add_to_cart');
function nrg_premium_prod_add_to_cart(){
    $ProdId = ( $_POST['ProdId'] ? $_POST['ProdId'] : '' );
    $ProdQ  = ( $_POST['ProdQ'] ? $_POST['ProdQ'] : '' );
    global $woocommerce;
    if( $woocommerce->cart->add_to_cart( $ProdId, $ProdQ ) ) {
        $data['result'] = 'true';
    } else {
        $data['result'] = 'false';
    }
    $data['cart_count'] = $woocommerce->cart->cart_contents_count;
    print json_encode( $data );
    die();
}