<?php get_header();
$code_languages = get_the_terms($post->ID, 'code_languages');

if ($code_languages) {
    $language_name = $code_languages[0]->name;
    $language_id = $code_languages[0]->term_id;
    $language_image_id = get_term_meta( $language_id, 'code_languages-image-id', true );
    $language_image_url = wp_get_attachment_image_url( $language_image_id, 'language-thumb' );
    if ($language_image_url == '') {
        $language_image_url = get_default_ashad_language_thumbnail();
    }
} else {
    $language_name = "Unspecified";
    $language_image_url = get_default_ashad_language_thumbnail();
} ?>
<section class="post <?php echo get_theme_mod('ashad_sidebar_display', 1)? 'two-columns' : 'one-column' ?>">
    <article role="article" class="post-content">
        <p class="post-info">
            <svg class="icon-calendar" id="date"><use xlink:href="#icon-calendar"></use></svg>
            <time class="date" datetime="<?php echo get_the_date('F j, Y'); ?>">
                <?php echo get_the_date(); ?>
            </time>
            <svg id="clock" class="icon-clock"><use xlink:href="#icon-code"></use></svg>
            <span><?php echo $language_name; ?></span>
        </p>
        <h1 class="post-title"><?php the_title(); ?></h1>
        <?php if(has_post_thumbnail()) { ?>
            <img src="<?php the_post_thumbnail_url(); ?>" alt="Featured image" class="post-cover">
        <?php } ?>
        <?php the_content(); ?>
    </article>

    <?php if(get_theme_mod('ashad_sidebar_display', 1)) { ?>
        <aside class="see-also">
            <h2>See also</h2>
            <ul>
                <?php
                    //Create WordPress Query with 'orderby' set to 'rand' (Random)
                    $the_query = new WP_Query( array ( 'orderby' => 'rand', 'posts_per_page' => '2' ) );
                    // output the random post
                    while ( $the_query->have_posts() ) : $the_query->the_post();
                ?>
                    <li>
                        <a href="<?php the_permalink(); ?>">
                            <?php if(has_post_thumbnail()) { ?>
                                <img src="<?php the_post_thumbnail_url('archive-thumb'); ?>">
                            <?php } else { ?>
                                <img src="<?php get_default_ashad_thumbnail(); ?>">
                            <?php } ?>
                            <h3><?php the_title(); ?></h3>
                        </a>
                    </li>
                <?php endwhile; ?>
            </ul>

            <?php dynamic_sidebar('sidebar-1') ?>
        </aside>
    <?php } ?>

</section>

<!-- Add time bar only for pages without pagination -->
<?php if(get_theme_mod('ashad_display_timebar', 1)) {
    // get_template_part('/template-parts/parts/time-bar');
    // get_template_part('/template-parts/parts/recommendation');
}?>

<!-- Show modal before user leaves the page -->
<?php if(get_theme_mod('ashad_display_finish_modal', 1)) {
    // get_template_part('/template-parts/parts/modal', null, array(
    //     'title' => 'Don\'t go yet!',
    //     'subtitle' => 'You may also like...',
    //     'closed' => true,
    //     'showOnExit' => true
    // ));
} ?>

<!-- Share -->
<?php get_template_part('/template-parts/parts/share') ?>
<!-- Author -->
<?php get_template_part('/template-parts/parts/author') ?>
<?php comments_template() ?>

<script type="application/ld+json">
{
    "@context": "http://schema.org",
    "@type": "BlogPosting",
    "name": "<?php the_title() ?>",
    "description": "<?php echo get_the_excerpt() ?>",
    "image": "<?php echo $language_image_url; ?>",
    "url": "<?php the_permalink(); ?>",
    "articleBody": "",
    "wordcount": "",
    "inLanguage": "<?php bloginfo('language') ?>",
    "dateCreated": "<?php echo get_the_date('y-m-d'); ?>",
    "datePublished": "<?php echo get_the_date('y-m-d'); ?>",
    "dateModified": "<?php echo get_the_modified_date('y-m-d'); ?>",
    "author": {
        "@type": "Person",
        "name": "<?php echo get_the_author_meta('display_name'); ?>",
        "image": "<?php echo get_avatar_url( get_the_author_meta( 'ID' ), 32 ); ?>",
        "jobTitle": "",
        "url": "<?php echo get_the_author_meta('url'); ?>",
        "sameAs": []
    },
    "publisher": {
        "@type": "Organization",
        "name": "<?php bloginfo('name') ?>",
        "url": "<?php bloginfo('url') ?>",
        "logo": {
            "@type": "ImageObject",
            "url": "<?php echo get_template_directory_uri() . '/assets/img/blog-image.png' ?>",
            "width": "600",
            "height": "315"
        }
    },
    "mainEntityOfPage": "True",
    "genre": "<?php $category = get_the_category(); echo $category? $category[0]->cat_name : ''; ?>",
    "articleSection": "<?php $category = get_the_category(); echo $category? $category[0]->cat_name : ''; ?>",
    "keywords": [<?php
        $my_tags = get_the_tags();
        if ( $my_tags ) {
            foreach ( $my_tags as $tag ) {
                $tag_names[] = $tag->name;
            }
            echo '"';
            echo implode( '", "', $tag_names );
            echo '"';
        }
    ?>]
}
</script>
<?php get_footer(); ?>