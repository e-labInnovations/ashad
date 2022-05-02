<?php if(get_theme_mod('ashad_display_author_details', 1)) { 
    $author_id = get_the_author_meta( 'ID' );
    ?>

    <section class="author">
        <div class="details">
            <img class="img-rounded" src="<?php echo get_avatar_url( $author_id, ['size' => '180'] ); ?>" alt="<?php echo get_the_author_meta('display_name'); ?>">
            <p class="def">Author</p>
            <h3 class="name">
            <a href="<?php echo get_the_author_meta('user_url')?get_the_author_meta('user_url'):'/user/'.get_the_author_meta('user_login') ?>"> <?php echo get_the_author_meta('display_name'); ?> </a>
            </h3>
            <p class="desc"><?php echo get_the_author_meta('description'); ?></p>
            <p>
                <?php if(get_the_author_meta('github_username') != '') { ?>
                    <a href="https://github.com/<?php echo get_the_author_meta('github_username') ?>" title="Github">
                        <svg><use xlink:href="#icon-github"></use></svg>
                    </a>
                <?php } ?>
                <?php if(get_the_author_meta('facebook_username') != '') { ?>
                    <a href="https://www.facebook.com/<?php echo get_the_author_meta('facebook_username') ?>" title="Facebook">
                        <svg><use xlink:href="#icon-facebook"></use></svg>
                    </a>
                <?php } ?>
                <?php if(get_the_author_meta('twitter_username') != '') { ?>
                    <a href="https://twitter.com/<?php echo get_the_author_meta('twitter_username') ?>" title="Twitter">
                        <svg><use xlink:href="#icon-twitter"></use></svg>
                    </a>
                <?php } ?>
                <?php if(get_the_author_meta('medium_username') != '') { ?>
                    <a href="https://medium.com/@<?php echo get_the_author_meta('medium_username') ?>" title="Medium">
                        <svg><use xlink:href="#icon-medium"></use></svg>
                    </a>
                <?php } ?>
                <?php if(get_the_author_meta('instagram_username') != '') { ?>
                    <a href="https://www.instagram.com/<?php echo get_the_author_meta('instagram_username') ?>" title="Instagram">
                        <svg><use xlink:href="#icon-instagram"></use></svg>
                    </a>
                <?php } ?>
                <?php if(get_the_author_meta('linkedin_username') != '') { ?>
                    <a href="https://www.linkedin.com/in/<?php echo get_the_author_meta('linkedin_username') ?>" title="LinkedIn">
                        <svg><use xlink:href="#icon-linkedin"></use></svg>
                    </a>
                <?php } ?>
            </p>
        </div>
    </section>

    <script type="application/ld+json">
    {
        "@context": "http://schema.org",
        "@type": "Person",
        "name": "<?php echo get_the_author_meta('display_name'); ?>",
        "image": "<?php echo get_avatar_url( $author_id, 32 ); ?>",
        "jobTitle": "",
        "url": "<?php echo get_avatar_url( $author_id, 32 ); ?>",
        "sameAs": [
            <?php echo get_the_author_meta('github_username') != ''? '"https://github.com/' . get_the_author_meta('github_username') . '",' :'' ?>
            <?php echo get_the_author_meta('facebook_username') != ''? '"https://www.facebook.com/' . get_the_author_meta('facebook_username') . '",' :'' ?>
            <?php echo get_the_author_meta('twitter_username') != ''? '"https://twitter.com/' . get_the_author_meta('twitter_username') . '",' :'' ?>
            <?php echo get_the_author_meta('medium_username') != ''? '"https://medium.com/@' . get_the_author_meta('medium_username') . '",' :'' ?>
            <?php echo get_the_author_meta('instagram_username') != ''? '"https://www.instagram.com/' . get_the_author_meta('instagram_username') . '",' :'' ?>
            <?php echo get_the_author_meta('linkedin_username') != ''? '"https://www.linkedin.com/in/' . get_the_author_meta('linkedin_username') . '"' :'' ?>
        ]
    }
    </script>
<?php } ?>