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
        'support' => array('title', 'editor'),
        'menu_icon' => 'dashicons-editor-code',
        'show_in_rest' => true,
        // 'rewrite' => array('slug' => 'codes-snippets')
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
        'support' => array('title', 'editor'),
        'menu_icon' => 'dashicons-editor-code',
        'show_in_rest' => true,
    ));
}
add_action('init', 'language_taxonomy');

//Code Languages Custom Image Field
require get_stylesheet_directory() . '/inc/code_languages-image_filed.php';

?>