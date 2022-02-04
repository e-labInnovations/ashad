<div class="modal <?php echo $args['showOnExit']?'exit ':''; echo $args['closed']?'closed ':''; ?>">
    <div class="window">
        <svg class="close">
            <use xlink:href="#icon-close"></use>
        </svg>
        <div class="header">
            <h2><?php echo $args['title'] ?></h2>
            <p><?php echo $args['subtitle'] ?></p>
        </div>
        <div class="content">
            <ul>
                <?php
                    //Create WordPress Query with 'orderby' set to 'rand' (Random)
                    $the_query = new WP_Query( array ( 'orderby' => 'rand', 'posts_per_page' => '2' ) );
                    // output the random post
                    while ( $the_query->have_posts() ) : $the_query->the_post();
                ?>
                    <li>
                        <a href="<?php the_permalink(); ?>">
                            <figure>
                                <?php if(has_post_thumbnail()) { ?>
                                    <img src="<?php the_post_thumbnail_url('archive-thumb'); ?>">
                                <?php } else { ?>
                                    <img src="<?php get_default_ashad_thumbnail(); ?>">
                                <?php } ?>
                            </figure>
                            <h3><?php the_title(); ?></h3>
                            <?php if (has_excerpt()) {
                                echo get_the_excerpt();
                            } else {
                                echo wp_trim_words(get_the_content(), 10);
                                } ?>
                        </a>
                    </li>
                <?php
                    endwhile;
                    wp_reset_postdata();
                ?>
            </ul>
        </div>
    </div>
    <div class="mask"></div>
</div>
