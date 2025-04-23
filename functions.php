<?php

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
    add_image_size( 's512', 512, 512, true );
	
	@ini_set( 'upload_max_size' , '256M' );
	@ini_set( 'post_max_size', '256M');
	@ini_set( 'max_execution_time', '300' );
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
    $version = wp_get_theme()->get('Version');
    // $version = rand(111,9999); //For development (Reload css)

    // wp_enqueue_style('ashad-style', get_template_directory_uri() . "/style.css", array(), $version, 'all');
    wp_enqueue_style('ashad-style', get_template_directory_uri() . "/build/style-index.css", array(), $version, 'all');
    wp_enqueue_style('ashad-style2', get_template_directory_uri(array('ashad-style')) . "/assets/css/style2.css", array(), $version/*rand(111,9999)*/, 'all');
    wp_enqueue_style('ashad-font', '//fonts.googleapis.com/css?family=Titillium+Web:300,400,700', array(), '1.0', 'all');
}

add_action('wp_enqueue_scripts', 'ashad_register_styles');

//JavaScripts
function ashad_register_scripts(){
    $version = wp_get_theme()->get('Version');
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

//Dynamic Open Graph Image
require_once get_stylesheet_directory() . '/inc/opengraph-image.php';

//Custom Contact Page
require_once get_stylesheet_directory() . '/inc/contact-page.php';

//Custom Email
require_once get_stylesheet_directory() . '/inc/mail-templates.php';

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

//Allow upload mime type
add_filter( 'upload_mimes', 'ashad_allow_upload_mime_types', 1, 1 );
function ashad_allow_upload_mime_types( $mime_types ) {
    $mime_types['ino'] = 'text/x-arduino';//Arduino ino file
	$mime_types['pcb'] = 'application/octet-stream';//CopperCAM pcb file
// 	$mime_types['bin'] = 'application/octet-stream';//ESP8266 or any firmware file
    return $mime_types;
}

//Dynamic SVG Image
add_action( 'init',  function() {
    add_rewrite_rule( 'customsvg/([a-z0-9-]+)[/]?$', 'index.php?customsvg=$matches[1]', 'top' );
} );

add_filter( 'query_vars', function( $query_vars ) {
    $query_vars[] = 'customsvg';
    return $query_vars;
} );

add_action( 'template_include', function( $template ) {
    if ( get_query_var( 'customsvg' ) == false || get_query_var( 'customsvg' ) == '' ) {
        return $template;
    }
 
    return get_template_directory() . '/svg.php';
} );













// UPLOAD ENABLE/DISABLE FEATURE
// Create a settings page
function my_upload_settings_menu() {
    add_options_page(
        'Upload Settings', // Page title
        'Upload Settings', // Menu title
        'manage_options',  // Capability
        'upload-settings', // Menu slug
        'my_upload_settings_page' // Callback function
    );
}
add_action('admin_menu', 'my_upload_settings_menu');

// Display the settings page
function my_upload_settings_page() {
    ?>
    <div class="wrap">
        <h1>Upload Settings</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('my_upload_settings_group');
            do_settings_sections('my_upload_settings_group');
            $upload_enabled = get_option('upload_enabled', '1'); // Default to enabled
            ?>
            <label for="upload_enabled">
                <input type="checkbox" id="upload_enabled" name="upload_enabled" value="1" <?php checked($upload_enabled, '1'); ?> />
                Enable File Uploads
            </label>
            <p class="description">Check this box to allow file uploads.</p>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

// Register the setting with sanitization
function my_upload_settings_init() {
    register_setting('my_upload_settings_group', 'upload_enabled', [
        'type' => 'string',
        'sanitize_callback' => function ($value) {
            return $value === '1' ? '1' : '0';
        },
        'default' => '1',
    ]);
}
add_action('admin_init', 'my_upload_settings_init');

// Set upload limit to zero if disabled
function my_limit_upload_size($file) {
    if (get_option('upload_enabled', '1') !== '1') {
        $file['error'] = 'File uploads are currently disabled.';
    }
    return $file;
}
add_filter('wp_handle_upload_prefilter', 'my_limit_upload_size');

// Show admin notice when uploads are disabled
function my_upload_admin_notice() {
    if (get_option('upload_enabled', '1') !== '1') {
        echo '<div class="notice notice-warning"><p><strong>Warning:</strong> File uploads are currently disabled in settings.</p></div>';
    }
}
add_action('admin_notices', 'my_upload_admin_notice');


/**
 * Register GitHub Profile API endpoint
 */
function register_github_profile_endpoint() {
    register_rest_route('elabins/v1', '/github-profile', array(
        'methods' => 'GET',
        'callback' => 'get_github_profile_data',
        'permission_callback' => '__return_true'
    ));
}
add_action('rest_api_init', 'register_github_profile_endpoint');

/**
 * Fetch GitHub profile data
 */
function get_github_profile_data() {
    $username = 'e-labInnovations';
    $api_url = "https://profile-summary-for-github.com/api/user/{$username}";
    
    // Set up the request arguments
    $args = array(
        'timeout' => 30,
        'headers' => array(
            'User-Agent' => 'WordPress/' . get_bloginfo('version')
        )
    );
    
    // Make the request
    $response = wp_remote_get($api_url, $args);
    
    // Check for errors
    if (is_wp_error($response)) {
        return new WP_Error('api_error', $response->get_error_message(), array('status' => 500));
    }
    
    // Get the response body
    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);
    
    // Check if the data is valid
    if (json_last_error() !== JSON_ERROR_NONE) {
        return new WP_Error('json_error', 'Invalid JSON response', array('status' => 500));
    }
    
    // Cache the response for 1 hour
    set_transient('github_profile_data', $data, HOUR_IN_SECONDS);
    
    return $data;
}

/**
 * Add CORS headers for the GitHub profile endpoint
 */
function add_cors_headers() {
    header('Access-Control-Allow-Origin: ' . get_site_url());
    header('Access-Control-Allow-Methods: GET');
    header('Access-Control-Allow-Credentials: true');
}
add_action('rest_api_init', function() {
    remove_filter('rest_pre_serve_request', 'rest_send_cors_headers');
    add_filter('rest_pre_serve_request', function($value) {
        add_cors_headers();
        return $value;
    });
}, 15);


?>
