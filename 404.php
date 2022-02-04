<?php get_header(); ?>
    <section class="content">
        <style type="text/css" media="screen">
        .container {
            margin: 0px auto;
            max-width: 600px;
            text-align: center;
            padding-top: 60px;
        }
        </style>

        <div class="container">
        <img src="<?php echo get_template_directory_uri() ?>/assets/img/404.gif" width="100%" alt="404 - Page not found">
        <p><strong>Page not found :(</strong></p>
        <p>I'm sorry. We couldn't find the page you are looking for.</p>
        <?php get_search_form() ?>
        </div>
    </section>
<?php get_footer(); ?>