<?php get_header('main'); ?>
<section class="content">
    <main class="home" id="post" role="main">
        <h1 class="title-category"><?php wp_title() ?></h1>
        <div id="grid" class="row flex-grid">
            
        <?php
            if(have_posts()) {
                while (have_posts()) {
                    the_post();
                    get_template_part('template-parts/content', 'archive');
                }
            }
        ?>
                
        </div>
    </main>
</section>
<?php get_footer(); ?>