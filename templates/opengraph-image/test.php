<?php
    
$post_id = get_query_var('ashad-thumbnail');
// echo get_post_type_object(get_post_type($post_id))->name;


// $args = array();
  
// $output = 'names'; // 'names' or 'objects' (default: 'names')
// $operator = 'and'; // 'and' or 'or' (default: 'and')
  
// $post_types = get_post_types( $args, $output, $operator );
  
// if ( $post_types ) { // If there are any custom public post types.
  
//     echo '<ul>';
  
//     foreach ( $post_types  as $post_type ) {
//         echo '<li>' . $post_type . '</li>';
//     }
  
//     echo '<ul>';
// }

$code_languages = get_the_terms(90, 'code_languages');
            
    if ($code_languages) {
        $language_id = $code_languages[0]->term_id;
    } else {
        $language_id = "Unspecified";
    }

    // echo $language_id;
    function formatSizeUnits($bytes)  {
        if ($bytes >= 1073741824) {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        } elseif ($bytes > 1) {
            $bytes = $bytes . ' bytes';
        } elseif ($bytes == 1) {
            $bytes = $bytes . ' byte';
        } else
        {
            $bytes = '0 bytes';
        }

        return $bytes;
}

    var_dump(wp_get_attachment_image_src($post_id, 's512', true));
    // var_dump(explode("\n", wordwrap( 'IMG_2400_cropped', 26)));
    
?>