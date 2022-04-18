<?php

add_action( 'init',  function() {
    add_rewrite_rule( 'ashad-thumbnail/([a-z0-9-]+)[/]?$', 'index.php?ashad-thumbnail=$matches[1]', 'top' );
} );

add_filter( 'query_vars', function( $query_vars ) {
    $query_vars[] = 'ashad-thumbnail';
    return $query_vars;
} );

add_action( 'template_include', function( $template ) {
    if ( get_query_var( 'ashad-thumbnail' ) == false || get_query_var( 'ashad-thumbnail' ) == '' ) {
        return $template;
    }

    $post_id = get_query_var('ashad-thumbnail');
    $post_type = get_post_type_object(get_post_type($post_id))->name;

    /*
    ✔ post
    page
    ✔ attachment
    revision
    nav_menu_item
    custom_css
    customize_changeset
    oembed_cache
    user_request
    wp_block
    wp_template
    wp_template_part
    wp_global_styles
    wp_navigation
    wpcf7_contact_form
    ✔ code_snippets
    */
    // return get_template_directory() . '/templates/opengraph-image/test.php';

    switch ($post_type) {
        case 'code_snippets':
            return get_template_directory() . '/templates/opengraph-image/code_snippet.php';
            break;
        
        case 'attachment':
            return get_template_directory() . '/templates/opengraph-image/attachment.php';
            break;
        
        default:
            return get_template_directory() . '/templates/opengraph-image/default.php';
            break;
    }
} );

?>