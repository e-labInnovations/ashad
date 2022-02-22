<?php get_header('main'); ?>
<section class="content">
    <main class="home" id="post" role="main">
        <h1 class="archive-title">
            <svg class="icon-title"><use xlink:href="#icon-code"></use></svg>
        Code Snippets</h1>
        <sction>
            <div class="code-snippet-cards">
            
            <?php
                if(have_posts()) {
                    while (have_posts()) {
                        the_post();
                        get_template_part('template-parts/content', 'archive_code_snippets');
                    }
                }
            ?>
                    
            </div>
            
            <?php the_posts_pagination(array(
                'mid_size' => 2
            )) ?>
        </sction>
    </main>
</section>
<?php get_footer(); ?>