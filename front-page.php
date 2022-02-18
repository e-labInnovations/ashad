<?php get_header('main'); ?>
<section class="content">
    
    <main class="home no-padding" role="main">
        <!-- Hero -->
        <?php if(get_theme_mod('hero-display', 'static') != 'hide') {
            if (get_theme_mod('hero-display', 'static') == 'static') {
                $hero_heading = get_theme_mod('hero_heading', 'Welcome to <br>' . get_bloginfo('title'));
                $hero_subheading1 = get_theme_mod('hero_subheading1', 'From your_name_here');
                $hero_subheading2 = get_theme_mod('hero_subheading2', get_bloginfo('description'));
                $hero_bgimage = wp_get_attachment_image_url(get_theme_mod('hero_bgimage'));
                $hero_button_link = '';
            } else {
                $recent_posts = get_posts(array(
                    'numberposts' => 1, // Number of recent posts thumbnails to display
                    'post_status' => 'publish' // Show only the published posts
                ));
                $recent_post = $recent_posts[0];
                $hero_heading =$recent_post->post_title;
                $hero_subheading1 = $recent_post->post_date_gmt;
                $hero_subheading2 = $recent_post->post_excerpt;
                $hero_bgimage = get_the_post_thumbnail_url($recent_post->ID, 'hero-thumb');
                $hero_button_link = get_permalink( $recent_post->ID );
            }
            

        ?>
            <section class="hero" style="background-image: url('<?php echo $hero_bgimage ?>')">
                <div class="pixels" style="background-image:url(<?php echo get_template_directory_uri() . '/assets/img/pixels.png' ?>)"></div>
                <div class="gradient"></div>
                <div class="content">
                    <time datetime="2008-02-14 20:00" class="date">
                    <?php echo $hero_subheading1 ?>
                    </time>
                    <h1 class="title"><?php echo $hero_heading ?></h1>
                    <p class="description"><?php echo $hero_subheading2 ?></p>
                    <?php if($hero_button_link) { ?>
                        <div class="buttons">
                            <a href="<?php echo $hero_button_link ?>" role="button" class="button">
                                <svg><use xlink:href="#icon-read"></use></svg>
                                <span>Read Now</span>
                            </a>
                        </div>
                    <?php } ?>
                </div>
            </section>
        <?php } ?>
        
        <!-- Posts -->
        <section id="grid" class="row flex-grid">
            <?php
                $homepagePosts = new WP_Query(array(
                    'post_per_page' => 4
                ));

                while ($homepagePosts->have_posts()) {
                    $homepagePosts->the_post();
                    get_template_part('template-parts/content', 'archive');
                }

                wp_reset_postdata();
            ?>
            <div class="pagination pagination-home">
                <div class="buttons">
                    <a href="<?php echo get_post_type_archive_link('post') ?>" role="button" class="button">
                        <svg><use xlink:href="#icon-read"></use></svg>
                        <span>View All Blog Posts</span>
                    </a>
                </div>
            </div>
        </section>

        <!-- Code Snippets -->
        <sction>
            <div class="code-snippet-cards">
                <?php
                    $homepageCodeSnippets = new WP_Query(array(
                        'post_type' => 'code_snippets',
                        'post_per_page' => 8
                    ));

                    while ($homepageCodeSnippets->have_posts()) {
                        $homepageCodeSnippets->the_post();
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
                        } ?>
                        
                        <div class="code-snippet-card">
                            <a class="post-link" href="<?php the_permalink(); ?>">
                                <img class="code-snippet-card-img" src="<?php echo $language_image_url; ?>">
                            </a>
                            <div class="code-snippet-card-info-wrapper">
                                <a class="post-link" href="<?php the_permalink(); ?>">
                                    <h3 class="code-snippet-card-description"><?php the_title(); ?></h3>
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

                    <?php 
                    }

                    wp_reset_postdata();
                ?>

            </div>
        
            <div class="pagination pagination-home">
                <div class="buttons">
                    <a href="<?php echo get_post_type_archive_link('code_snippets') ?>" role="button" class="button">
                        <svg><use xlink:href="#icon-read"></use></svg>
                        <span>View All Code Snippets</span>
                    </a>
                </div>
            </div>
        </sction>

        <!-- Front Page Content -->
        <section class="content">
            <div class="post">
                
                <article class="home-content fullwidth">
                    <?php the_content() ?>
                </article>

            </div>
        </section>

    </main>

</section>
<?php get_footer(); ?>