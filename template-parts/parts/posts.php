<section id="grid" class="row flex-grid">
    <?php
        if(have_posts()) {
            while (have_posts()) {
                the_post();
                get_template_part('template-parts/content', 'archive');
            }
        }
    ?>

    
</section>