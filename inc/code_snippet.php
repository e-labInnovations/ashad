<?php

//Custom Post Type - Code Snippets
function code_snippets_post_type() {
    register_post_type('code_snippets', array(
        'labels' => array(
            'name' => 'Code Snippets',
            'singular_name' => 'Code Snippet',
            'add_new_item' => 'Add New Code Snippet',
            'edit_item' => 'Edit Code Snippet',
            'all_items' => 'All Code Snippets'
        ),
        'hierarchical' => false, //if true, same as pages, else same as posts 
        'public' => true,
        'has_archive' => true,
        'supports' => array('title', 'editor', 'comments'),
        'menu_icon' => 'dashicons-editor-code',
        'show_in_rest' => true,
        // 'rewrite' => array( 'slug' => 'code_snippets/%code_languages%', 'with_front' => false ),
    ));
}
add_action('init', 'code_snippets_post_type');

//Custom Category - Language
function language_taxonomy() {

    register_taxonomy('code_languages', array('code_snippets'), array(
        'labels' => array(
            'name' => 'Languages',
            'singular_name' => 'Language'
        ),
        'hierarchical' => true, //if true, same as category, else same as tags 
        'public' => true,
        'has_archive' => true,
        'supports' => array('title', 'editor'),
        'menu_icon' => 'dashicons-editor-code',
        'show_in_rest' => true,
        'default_term' => array(
            'name' => 'Unspecified',
            'slug' => 'unspecified',
            'description' => ''
        ),
        // 'rewrite' => array( 'slug' => 'code_languages', 'with_front' => false ),
    ));
}
add_action('init', 'language_taxonomy');

//permalink change to /code_snippets/{language}/{title}
//https://stackoverflow.com/a/57853332/11409930
function code_snippets_permalinks( $post_link, $post ){
    if ( is_object( $post ) && $post->post_type == 'code_snippets' && $post_link != '' ){
        $terms = wp_get_object_terms( $post->ID, 'code_languages' );
        if( $terms ){
            return str_replace( '%code_languages%' , $terms[0]->slug , $post_link );
        }
    }
    return $post_link;
}
// add_filter( 'post_type_link', 'code_snippets_permalinks', 1, 2 );

//Code Languages Custom Image Field
require get_stylesheet_directory() . '/inc/code_languages-image_filed.php';

?>