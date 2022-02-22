<?php

$code_languages = get_the_terms($post->ID, 'code_languages');
        
if ($code_languages) {
    $language_id = $code_languages[0]->term_id;
    $language_image_id = get_term_meta( $language_id, 'code_languages-image-id', true );
    $language_image_url = wp_get_attachment_image_url( $language_image_id, 'language-thumb' );
    if ($language_image_url == '') {
        $language_image_url = get_default_ashad_language_thumbnail();
    }
} else {
    $language_image_url = get_default_ashad_language_thumbnail();
}

?>

<div class="code-snippet-card">
    <a class="post-link" href="<?php the_permalink(); ?>">
        <img class="code-snippet-card-img" src="<?php echo $language_image_url; ?>">
    </a>
    <div class="code-snippet-card-info-wrapper">
        <a href="<?php the_permalink(); ?>">
            <h3><?php the_title(); ?></h3>
            <time datetime="<?php echo get_the_date(); ?>" class="date">  <?php echo get_the_date(); ?>  </time>
            <p class="code-snippet-card-text">
                <?php if (has_excerpt()) {
                    echo get_the_excerpt();
                } else {
                    echo wp_trim_words(get_the_content(), 10);
                } ?>
            </p>
        </a>
    </div>
</div>