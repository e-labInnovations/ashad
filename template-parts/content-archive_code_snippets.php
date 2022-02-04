
<article class="box-item shown">
    <div class="box-body">
        <a class="cover" href="<?php the_permalink() ?>">
            <?php get_template_part('/template-parts/parts/loader') ?>

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
            <img src="<?php echo $language_image_url; ?>" width="60%" data-url="<?php echo $language_image_url; ?>" class="preload">
            <noscript>
                <img src="<?php echo $language_image_url; ?>" width="60%">
            </noscript>
            
            <?php get_template_part('/template-parts/parts/read-icon') ?>
        </a>
        
        <div class="box-info">
            <time datetime="2021-10-31T18:30:24+00:00" class="date">  <?php the_date() ?>  </time>
            <a class="post-link" href="<?php the_permalink() ?>">
                <h2 class="post-title"> <?php the_title() ?> </h2>
            </a>
            <a class="post-link" href="<?php the_permalink() ?>">
                <p class="description"><?php the_excerpt() ?></p>
            </a>
            <div class="tags">
                <?php the_tags('', '', '') ?>
            </div>
        </div>
    </div>
</article>