<?php get_template_part('/template-parts/parts/head') ?>
<body class="main-page has-push-menu">
    <?php get_template_part('/template-parts/parts/svg-icons') ?>
    <header class="bar-header">
        <a id="menu" role="button">
            <svg id="open" class="icon-menu"><use xlink:href="#icon-menu"></use></svg>
        </a>
        <h1 class="logo">
            <a href="<?php bloginfo('wpurl'); ?>">
                <?php
                    if(function_exists('the_custom_logo')) {
                        $custom_logo_id = get_theme_mod('custom_logo');
                        $logo = wp_get_attachment_image_src($custom_logo_id, 'full');
                    }

                    if (has_custom_logo()) {
                        echo '<img src="' . $logo[0] . '" alt="logo" style="height: 40px;" />';
                    } else {
                        echo get_bloginfo('name') . '<span class="version">' . get_theme_mod('ashad_site_version', 'V1.0') . '</span>';
                    }
                ?>
                
            </a>
        </h1>
        <?php if(is_user_logged_in()) { ?>
            <a href="<?php echo esc_url(site_url('/account')) ?>" class="avatar">
                <img src="<?php echo get_avatar_url(get_current_user_id(), ['size' => '40']); ?>" alt="Your Profile" class="img-rounded">
                
            </a>
        <?php } else { ?>
            <a href="<?php echo esc_url(site_url('/wp-signup.php')) ?>" class="avatar">
                <img src="<?php echo get_template_directory_uri() . '/assets/img/user-small.png'; ?>" alt="" >
            </a>
        <?php } ?>
        <a id="search" class="dosearch" role="button">
            <svg class="icon-search"><use xlink:href="#icon-search"></use></svg>
        </a>
    </header>

    <div id="mask" class="overlay"></div>

    <?php get_template_part('/template-parts/parts/menu') ?>
    <?php get_template_part('/template-parts/parts/search') ?>