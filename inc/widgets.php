<?php
//Widgets
function ashad_widget_areas() {
    //Sidebar Widget
    register_sidebar(
        array(
            'before_title' => '<h2>',
            'after_title' => '</h2>',
            'before_widget' => '',
            'after_widget' => '',
            'name' => 'Sidebar Widgets',
            'id' => 'sidebar-1',
            'descriptions' => 'Sidebar Widgets Area'
        )
    );

    //Footer Widget
    register_sidebar(
        array(
            'before_title' => '<h2>',
            'after_title' => '</h2>',
            'before_widget' => '',
            'after_widget' => '',
            'name' => 'Footer Widgets',
            'id' => 'footer-1',
            'descriptions' => 'Footer Widgets Area'
        )
    );
}

add_action('widgets_init', 'ashad_widget_areas');