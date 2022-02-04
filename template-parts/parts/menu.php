<aside class="sidebar" id="sidebar">
    <nav id="navigation">
        <h2>Menu</h2>
        <?php
            wp_nav_menu(
                array(
                    'menu' => 'primary',
                    'container' => '',
                    'theme_location' => 'primary',
                    'items_wrap' => '<ul id="" class="">%3$s</ul>'
                )
            );
        ?>

    </nav>
</aside>