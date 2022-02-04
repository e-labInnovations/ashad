<?php

add_action('rest_api_init', 'ashadRegisterSearch');
function ashadRegisterSearch() {
    register_rest_route('ashad/v1', 'search', array(
        'methods' => WP_REST_SERVER::READABLE,
        'callback' => 'ashadSearchResults',

    ));
}

function ashadSearchResults($data) {
    $results = array(
        'posts' => array(),
        'code_snippets' => array()
    );

    $mainQuery = new WP_Query(array(
        'post_type' => array('post', 'code_snippets'),
        's' => sanitize_text_field($data['s'])
    ));

    while ($mainQuery->have_posts()) {
        $mainQuery->the_post();

        if(get_post_type() == 'post') {
            $categories = array();
    
            foreach(get_the_category() as $category) {
                array_push($categories, $category->name);
            }

            array_push($results['posts'], array(
                'title' => get_the_title(),
                'date' => get_the_date(),
                'url' => get_the_permalink(),
                'categories' => $categories
            ));
        } else {
            $languages = array();
            $taxonomyLanguages = get_the_terms(get_the_ID(), 'code_languages');

            if($taxonomyLanguages) {
                foreach($taxonomyLanguages as $language) {
                    $language_id = $code_languages[0]->term_id;
                    $language_image_id = get_term_meta( $language_id, 'code_languages-image-id', true );
                    $language_image_url = wp_get_attachment_image_url( $language_image_id, 'language-thumb' );
                    if ($language_image_url == '') {
                        $language_image_url = get_default_ashad_language_thumbnail();
                    }

                    array_push($languages, array(
                        'name' => $language->name,
                        'thumbnail' => $language_image_url
                    ));

                }
            } else {
                array_push($languages, array(
                    'name' => 'Uncategorised',
                    'thumbnail' => $language_image_url
                ));
            }

            array_push($results['code_snippets'], array(
                'title' => get_the_title(),
                'date' => get_the_date(),
                'url' => get_the_permalink(),
                'languages' => $languages
            ));
        }
        
    }

    return $results;
}