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
 
    return get_template_directory() . '../templates/ashad-thumbnail.php';
} );

?>