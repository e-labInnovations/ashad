<?php get_header(); ?>

<section class="post <?php echo get_theme_mod('ashad_sidebar_display') == 'No' ? 'one-column' : 'two-columns' ?>">
    <article role="article" class="post-content">
        <p class="post-info">
            <svg class="icon-calendar" id="date"><use xlink:href="#icon-calendar"></use></svg>
            <time class="date" datetime="<?php echo get_the_date(); ?>">
                <?php echo get_the_date(); ?>
            </time>
            <svg id="clock" class="icon-clock"><use xlink:href="#icon-clock"></use></svg>
            <span><?php get_reading_time(get_the_ID()); ?> min to read</span>
        </p>
        <h1 class="post-title"><?php the_title(); ?></h1>
        <?php if(has_post_thumbnail()) { ?>
            <img src="<?php the_post_thumbnail_url(); ?>" alt="Featured image" class="post-cover">
        <?php } ?>
        <?php the_content(); ?>
    </article>

    <?php if(get_theme_mod('ashad_sidebar_display') == 'Yes') { ?>
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
<?php //get_template_part('/template-parts/parts/time-bar') ?>
<?php //get_template_part('/template-parts/parts/recommendation') ?>

<!-- Show modal before user leaves the page -->
<?php /* get_template_part('/template-parts/parts/modal', null, array(
    'title' => 'Don\'t go yet!',
    'subtitle' => 'You may also like...',
    'closed' => true,
    'showOnExit' => true
)) */ ?>

<?php get_template_part('/template-parts/parts/share') ?>
<?php get_template_part('/template-parts/parts/author') ?>
<?php comments_template() ?>


<script type="application/ld+json">
{
    "@context": "http://schema.org",
    "@type": "BlogPosting",
    "name": "<?php the_title() ?>",
    "description": "<?php echo get_the_excerpt() ?>",
    "image": "<?php the_post_thumbnail_url(); ?>",
    "url": "<?php the_permalink(); ?>",
    "articleBody": "",
    "wordcount": "",
    "inLanguage": "<?php bloginfo('language') ?>",
    "dateCreated": "{{ page.date | date: '%Y-%m-%d/' }}",
    "datePublished": "{{ page.date | date: '%Y-%m-%d/' }}",
    "dateModified": "{{ page.date | date: '%Y-%m-%d/' }}",
    "author": {
        "@type": "Person",
        "name": "{{ author.display_name }}",
        {% if author.photo %}
        "image": "{{ author.photo }}",
        {% else %}
        "image": {{ "/assets/img/user.jpg" | prepend: site.baseurl | prepend: site.url }},
        {% endif %}
        "jobTitle": "{{ author.position }}",
        "url": "{{ author.url | prepend: site.baseurl | prepend: site.url }}",
        "sameAs": [
            {{ author_urls | split: "," | join: "," }}
        ]
    },
    "publisher": {
        "@type": "Organization",
        "name": "{{ site.name }}",
        "url": "{{ site.url }}{{site.baseurl}}/",
        "logo": {
            "@type": "ImageObject",
            "url": "{{ site.url }}{{site.baseurl}}/assets/img/blog-image.png",
            "width": "600",
            "height": "315"
        }
    },
    "mainEntityOfPage": "True",
    "genre": "{{ page.category }}",
    "articleSection": "{{ page.category }}",
    "keywords": [{{ page.tags | join: '","' | append: '"' | prepend: '"' }}]
}
</script>

<?php get_footer(); ?>