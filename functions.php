<?php

$version = wp_get_theme()->get('Version');
// $version = rand(111,9999); //For development (Reload css)

//Theme support
function ashad_theme_support() {
    //Add dynamic title tag support
    add_theme_support('title-tag');

    $logo_defaults = array(
        'height'               => 40,
        'width'                => 120,
        'flex-height'          => true,
        'flex-width'           => true,
        'header-text'          => array( 'site-title', 'site-description' ),
        'unlink-homepage-logo' => true, 
    );
    add_theme_support('custom-logo', $logo_defaults);

    // add_theme_support( 'custom-header' );
    
    add_theme_support('post-thumbnails');
    add_image_size( 'hero-thumb', 760, 400, true );
    add_image_size( 'archive-thumb', 380, 200, true );
    add_image_size( 'language-thumb', 200, 200, true );
}

add_action('after_setup_theme', 'ashad_theme_support');


//Menu
function ashad_menus() {
    $locations = array(
        'primary' => "Main Menu",
        'footer' => "Footer Menu"
    );

    register_nav_menus($locations);
}

add_action('init', 'ashad_menus');

//Stylesheets
function ashad_register_styles(){
    // wp_enqueue_style('ashad-style', get_template_directory_uri() . "/style.css", array(), $version, 'all');
    wp_enqueue_style('ashad-style', get_template_directory_uri() . "/build/style-index.css", array(), $version, 'all');
    wp_enqueue_style('ashad-style2', get_template_directory_uri(array('ashad-style')) . "/assets/css/style2.css", array(), $version/*rand(111,9999)*/, 'all');
    wp_enqueue_style('ashad-font', '//fonts.googleapis.com/css?family=Titillium+Web:300,400,700', array(), '1.0', 'all');
}

add_action('wp_enqueue_scripts', 'ashad_register_styles');

//JavaScripts
function ashad_register_scripts(){
    $params = array(
        'root_url' => get_site_url(),
        'assets_url' => get_template_directory_uri() . '/assets',
        'fetchURL' => admin_url('admin-ajax.php')
    );
    // wp_enqueue_script('ashad-main', get_template_directory_uri() . "/assets/js/scripts.min.js", array(), '1', true);
    wp_enqueue_script('ashad-main', get_template_directory_uri() . "/build/index.js", array(), $version, true);
    wp_localize_script( 'ashad-main', 'ashad', $params);
}

add_action('wp_enqueue_scripts', 'ashad_register_scripts');

//Widgets
require_once get_stylesheet_directory() . '/inc/widgets.php';

//Customizer
require_once get_stylesheet_directory() . '/inc/ashad-customizer.php';
new Ashad_Customizer();

//Custom Post Type
require_once get_stylesheet_directory() . '/inc/code_snippet.php';

//User Custom Fileds
require_once get_stylesheet_directory() . '/inc/custom-user-fileds.php';

//Custom API for Search
require_once get_stylesheet_directory() . '/inc/search-route.php';

//AJAX Search
require_once get_stylesheet_directory() . '/inc/ajax-search.php';

//Redirect subscriber account from admin panel to website home
function ashadRedirectSubscriber() {
    $currentUser = wp_get_current_user();

    if(count($currentUser->roles) == 1 AND $currentUser->roles[0] == 'subscriber') {
        wp_redirect(site_url('/'));
        exit();
    }
}
add_action('admin_init', 'ashadRedirectSubscriber');

function ashadFeed_request($qv) {
    if (isset($qv['feed']) && !isset($qv['post_type']))
        $qv['post_type'] = array('code_snippets', 'post');
    return $qv;
}
add_filter('request', 'ashadFeed_request');

//Hide admin top bar from subscriber account in website home
function ashadHideSubscriberAdminBar() {
    $currentUser = wp_get_current_user();

    if(count($currentUser->roles) == 1 AND $currentUser->roles[0] == 'subscriber') {
        show_admin_bar(false);
    }
}
add_action('wp_loaded', 'ashadHideSubscriberAdminBar');

//Get default thumbnail url
if (!function_exists('get_default_ashad_thumbnail')) {
    function get_default_ashad_thumbnail() {
        echo get_template_directory_uri() . '/assets/img/default_thumbnail.jpg';
    }
}
if (!function_exists('get_default_ashad_thumbnail_url')) {
    function get_default_ashad_thumbnail_url() {
        get_template_directory_uri() . '/assets/img/default_thumbnail.jpg';
    }
}

if (!function_exists('get_default_ashad_language_thumbnail')) {
    function get_default_ashad_language_thumbnail() {
        return get_template_directory_uri() . '/assets/img/language_thumbnail.png';
    }
}
//Reading Time calculation
if (!function_exists('get_reading_time')) :
    function get_reading_time($post_id) {
      $content = apply_filters('the_content', get_post_field('post_content', $post_id));
      $read_words = esc_attr(get_theme_mod('global_show_min_read_number','100'));
      $decode_content = html_entity_decode($content);
      $filter_shortcode = do_shortcode($decode_content);
      $strip_tags = wp_strip_all_tags($filter_shortcode, true);
      $count = str_word_count($strip_tags);
      $word_per_min = (absint($count) / $read_words);
      $word_per_min = ceil($word_per_min);

      if ( absint($word_per_min) > 0) {
        if ('post' == get_post_type($post_id)):
            echo $word_per_min;
        endif;            
      }
      if ( absint($word_per_min) == Null) {
        echo '0';
      }
    }
endif;

// Custom feed SVG
function add_custom_feed() {
    add_feed( 'svg.svg', 'render_custom_feed' );
}
add_action( 'init', 'add_custom_feed' );
 
function render_custom_feed() {
    header( 'Content-Type: application/svg+xml' );
    echo '<svg xmlns="http://www.w3.org/2000/svg" height="90" width="200"><text x="10" y="20" style="fill:red;">Hello<tspan x="10" y="45">{{name}}</tspan></text></svg>';
}


?>