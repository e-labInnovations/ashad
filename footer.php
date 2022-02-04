<footer>
    <p>
      <?php if(get_theme_mod('ashad_github', '') != '') { ?>
        <a href="https://github.com/<?php echo get_theme_mod('ashad_github') ?>" title="Github">
          <svg><use xlink:href="#icon-github"></use></svg>
        </a>
      <?php } if(get_theme_mod('ashad_facebook', '') != '') { ?>
        <a href="https://www.facebook.com/<?php echo get_theme_mod('ashad_facebook') ?>" title="Facebook">
          <svg><use xlink:href="#icon-facebook"></use></svg>
        </a>
      <?php } if(get_theme_mod('ashad_twitter', '') != '') { ?>
        <a href="https://twitter.com/<?php echo get_theme_mod('ashad_twitter') ?>" title="Twitter">
          <svg><use xlink:href="#icon-twitter"></use></svg>
        </a>
      <?php } if(get_theme_mod('ashad_medium', '') != '') { ?>
        <a href="https://medium.com/@<?php echo get_theme_mod('ashad_medium') ?>" title="Medium">
          <svg><use xlink:href="#icon-medium"></use></svg>
        </a>
      <?php } if(get_theme_mod('ashad_instagram', '') != '') { ?>
        <a href="https://www.instagram.com/<?php echo get_theme_mod('ashad_instagram') ?>" title="Instagram">
          <svg><use xlink:href="#icon-instagram"></use></svg>
        </a>
      <?php } if(get_theme_mod('ashad_linkedin', '') != '') { ?>
        <a href="https://www.linkedin.com/in/<?php echo get_theme_mod('ashad_linkedin') ?>" title="LinkedIn">
          <svg><use xlink:href="#icon-linkedin"></use></svg>
        </a>
      <?php } if(get_theme_mod('ashad_youtube', '') != '') { ?>
        <a href="https://www.youtube.com/c/<?php echo get_theme_mod('ashad_youtube') ?>" title="Youtube">
          <svg><use xlink:href="#icon-youtube"></use></svg>
        </a>
      <?php } ?>
    </p>

    <?php
      wp_nav_menu(
          array(
              'menu' => 'footer',
              'container' => '',
              'theme_location' => 'footer',
              'items_wrap' => '<ul id="" class="">%3$s</ul>'
          )
      );
    ?>

    <?php dynamic_sidebar('footer-1') ?>

    <p>
      <span><?php echo get_theme_mod('ashad-footer-credt-text', get_bloginfo('title')) ?></span> <?php echo date('Y'); ?> <svg class="love"><use xlink:href="#icon-heart"></use></svg> by <a href="<?php echo get_theme_mod('ashad-footer-author-link', '') ?>" target="_blank" class="creator"><?php echo get_theme_mod('ashad-footer-author-text', '') ?></a>
    </p>
</footer>

<script type="application/ld+json">
{
  "@context": "http://schema.org",
  "@type": "Organization",
  "name": "<?php bloginfo('name'); ?>",
  "description": "<?php bloginfo('description'); ?>",
  "url": "<?php bloginfo('url'); ?>",
  "logo": {
      "@type": "ImageObject",
      "url": "<?php echo get_template_directory_uri() . '/assets/img/blog-image.png' ?>",
      "width": "600",
      "height": "315"
  },
  "sameAs": [
            <?php echo get_theme_mod('ashad_github', '') != ''? '"https://github.com/' . get_theme_mod('ashad_github') . '",' :'' ?>
            <?php echo get_theme_mod('ashad_facebook', '') != ''? '"https://www.facebook.com/' . get_theme_mod('ashad_facebook') . '",' :'' ?>
            <?php echo get_theme_mod('ashad_twitter', '') != ''? '"https://twitter.com/' . get_theme_mod('ashad_twitter') . '",' :'' ?>
            <?php echo get_theme_mod('ashad_medium', '') != ''? '"https://medium.com/@' . get_theme_mod('ashad_medium') . '",' :'' ?>
            <?php echo get_theme_mod('ashad_instagram', '') != ''? '"https://www.instagram.com/' . get_theme_mod('ashad_instagram') . '",' :'' ?>
            <?php echo get_theme_mod('ashad_linkedin', '') != ''? '"https://www.linkedin.com/in/' . get_theme_mod('ashad_linkedin') . '"' :'' ?>
        ]
}
</script>



<?php wp_footer(); ?>