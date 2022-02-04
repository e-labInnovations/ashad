<?php

$version = wp_get_theme()->get('Version');
// $version = rand(111,9999);

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
function ashad_widget_areas() {
    //Sidebar Widget
    register_sidebar(
        array(
            'before_title' => '<h2>',
            'after_title' => '</h2>',
            'before_widget' => '',
            'after_widget' => '',
            'name' => 'Sidebar Widgets',
            'id' => 'sidebar-1',
            'descriptions' => 'Sidebar Widgets Area'
        )
    );

    //Footer Widget
    register_sidebar(
        array(
            'before_title' => '<h2>',
            'after_title' => '</h2>',
            'before_widget' => '',
            'after_widget' => '',
            'name' => 'Footer Widgets',
            'id' => 'footer-1',
            'descriptions' => 'Footer Widgets Area'
        )
    );
}

add_action('widgets_init', 'ashad_widget_areas');

//Customizer
require get_stylesheet_directory() . '/inc/ashad-customizer.php';
new Ashad_Customizer();

//Custom Post Type
require get_stylesheet_directory() . '/inc/code_snippet.php';

//User Custom Fileds
require get_stylesheet_directory() . '/inc/custom_user_fileds.php';

//Custom API for Search
require get_theme_file_path('/inc/search-route.php');

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

// add the ajax fetch js
add_action( 'wp_footer', 'ajax_fetch' );
function ajax_fetch() {
?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<?php
}

// the ajax function
function data_fetch(){
    $the_query = new WP_Query( array( 'posts_per_page' => -1, 's' => esc_attr( $_POST['keyword'] ), 'post_type' => 'post' ) );
    if( $the_query->have_posts() ) :
        while( $the_query->have_posts() ): $the_query->the_post(); ?>
            <li>
                <article>
                    <a href="<?php echo esc_url( post_permalink() ); ?>">
                        <span class="entry-category"><?php $category = get_the_category(); echo $category? $category[0]->cat_name : ''; ?></span> 
                        <?php the_title();?>
                        <span class="entry-date">
                            <time datetime="<?php the_date();?>"><?php the_date();?></time>
                        </span>
                    </a>
                </article>
            </li>

        <?php endwhile;
        wp_reset_postdata();  
    endif;

    die();
}
add_action('wp_ajax_data_fetch' , 'data_fetch');
add_action('wp_ajax_nopriv_data_fetch','data_fetch');


?>