<?php get_header('main'); ?>
<section class="content">
    <main class="home" id="post" role="main">
        <!-- <h1 class="title-category"><?php the_archive_title() ?></h1> -->
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

        <?php if(false): ?>
        <div class="pagination pagination-home">
            <a href="" class="previous">
                <svg><use xlink:href="#icon-arrow-right"></use></svg>
            </a>
            <a href="" class="page_number ">1</a>
            <a href="" class="page_number ">2</a>
            <a href="" class="next">
                <svg><use xlink:href="#icon-arrow-right"></use></svg>
            </a>
        </div>
        <?php endif; ?>

        <?php the_posts_pagination(array(
            'mid_size' => 2
        )) ?>
    </main>
</section>
<?php get_footer(); ?>