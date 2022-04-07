<?php get_header(); ?>
<style type="text/css" media="screen">
  .container {
    margin: 0px auto;
    max-width: 600px;
    text-align: center;
    padding-top: 60px;
  }
</style>

<section class="content">
    <div class="container">
        <img src="<?php echo get_template_directory_uri() . '/assets/img/message.gif' ?>" width="540" alt="Message sent!">
        <p><strong>Message sent!</strong></p>
        <p>Thank you for sending me a message. I'm going to answer ASAP.</p>
        <a href="<?php bloginfo('wpurl'); ?>">Home</a>
    </div>
</section>

<?php get_footer(); ?>