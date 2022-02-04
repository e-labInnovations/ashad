<article class="box-item shown">
    <span class="category">
        <a href="<?php $category = get_the_category(); echo $category? get_category_link($category[0]->term_id) : ''; ?>">
            <span><?php $category = get_the_category(); echo $category? $category[0]->cat_name : ''; ?></span>
        </a>
    </span>
    <div class="box-body">
        <a class="cover" href="<?php the_permalink() ?>">
            <?php get_template_part('/template-parts/parts/loader') ?>

            <?php if(has_post_thumbnail()) { ?>
                <img src="<?php the_post_thumbnail_url('archive-thumb'); ?>" width="100%" data-url="<?php the_post_thumbnail_url('archive-thumb'); ?>" class="preload">
                <noscript>
                    <img src="<?php the_post_thumbnail_url('archive-thumb'); ?>" width="100%">
                </noscript>
            <?php } else { ?>
                <img src="<?php get_default_ashad_thumbnail(); ?>" width="100%" data-url="<?php get_default_ashad_thumbnail(); ?>" class="preload">
                <noscript>
                    <img src="<?php get_default_ashad_thumbnail(); ?>" width="100%">
                </noscript>
            <?php } ?>
            
            <?php get_template_part('/template-parts/parts/new-post-tag'); ?>
            <?php get_template_part('/template-parts/parts/read-icon'); ?>
        </a>
        
        <div class="box-info">
            <time datetime="<?php echo get_the_date(); ?>" class="date">  <?php echo get_the_date(); ?>  </time>
            <a class="post-link" href="<?php the_permalink(); ?>">
                <h2 class="post-title"> <?php the_title(); ?> </h2>
            </a>
            <a class="post-link" href="<?php the_permalink(); ?>">
                <p class="description">
                    <?php if (has_excerpt()) {
                        echo get_the_excerpt();
                    } else {
                        echo wp_trim_words(get_the_content(), 10);
                    } ?>
                </p>
            </a>
            <div class="tags">
                <?php the_tags('', '', ''); ?>
            </div>
        </div>
    </div>
</article>