<?php

global $wp;
$title = wp_title( '|', false, 'right' ) . get_bloginfo('name');
$description = get_bloginfo('name') . " - " . get_bloginfo('description');
$keywords = '';
$image = get_site_icon_url();
$url = home_url($wp->request);
$tags;

if ( is_single() ) {
  $title = get_the_title();
  $description = has_excerpt()?get_the_excerpt():wp_trim_words(get_the_content(), 10);
  $tags = get_the_tags();
  if(has_post_thumbnail()) {
    $image = get_the_post_thumbnail_url(get_the_ID(), 'archive-thumb');
  } else {
    $image = get_default_ashad_thumbnail_url();
  }
  $url = get_permalink(); 
}

if($tags) {
  foreach( $tags as $tag ) {
    $keywords = $keywords . $tag->name . ', '; 
  }
}

?>

<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
  <head>
    <meta charset="<?php bloginfo('charset') ?>" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    
    <meta name="title" content="<?php echo $title ?>">
    <meta name="description" content="<?php echo $description ?>" />
    <meta name="keywords" content="<?php print_r($keywords) ?>" />
    <!-- <meta
      name="google-site-verification"
      content="80eGnNcWzNvy0RmLtJsYExtOQ2yM0tRpduAE6DTte7g"
    /> -->


    <!-- Social: Twitter -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="<?php echo $title ?>" />
    <meta name="twitter:description" content="<?php echo $description ?>" />
    <meta property="twitter:image:src" content="<?php echo $image ?>" />
    <?php if(get_theme_mod('ashad_twitter', '') != '') { ?>
      <meta name="twitter:site" content="@<?php echo get_theme_mod('ashad_twitter') ?>" />
    <?php } ?>

    <!-- Social: Facebook / Open Graph -->
    <meta property="og:url" content="<?php echo $url ?>" />
    <meta property="og:title" content="<?php echo $title ?>" />
    <meta property="og:image" content="<?php echo $image ?>" />
    <meta property="og:description" content="<?php echo $description ?>" />
    <meta property="og:site_name" content="<?php echo get_bloginfo('name') ?>" />

    <!-- Favicon -->

    <?php
      wp_head();
    ?>

    <!-- <link rel="canonical" href="{{ url }}" /> -->
    <!-- <link
      rel="alternate"
      type="application/rss+xml"
      title="{{ site.title }}"
      href="{{ '/feed.xml' | prepend: site.baseurl | prepend: site.url }}"
    /> -->
    <!-- <link rel="manifest" href="{{ site.baseurl }}/manifest.json"> -->

    <!-- JavaScript enabled/disabled -->
    <script>
      document.querySelector('html').classList.remove('no-js');
    </script>
  </head>
