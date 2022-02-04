<?php $next_post = get_next_post();
    if ( is_a( $next_post , 'WP_Post' ) ) : ?>
    <div class="recommendation">
        <div class="message">
            <strong>Why don't you read something next?</strong>
            <div>
                <button>
                    <svg><use xlink:href="#icon-arrow-right"></use></svg>
                    <span>Go back to top</span>
                </button>
            </div>
        </div>
        <a href="<?php echo get_permalink( $next_post->ID ); ?>" class="post-preview">
            <div class="image">
                <?php if(has_post_thumbnail($next_post->ID)) { ?>
                    <img src="<?php echo get_the_post_thumbnail_url( $next_post->ID, 'archive-thumb'); ?>">
                <?php } else { ?>
                    <img src="<?php get_default_ashad_thumbnail(); ?>">
                <?php } ?>
            </div>
            <h3 class="title"> <?php echo get_the_title( $next_post->ID); ?> </h3>
        </a>
    </div>
<?php
    endif;
    wp_reset_postdata();
?>