<?php

//Add custom sections and settings to the Admin Customizer
class Ashad_Customizer {
    public function __construct() {
        add_action('customize_register', array($this, 'register_customize_sections'));
    }

    public function register_customize_sections($wp_customize) {
        //Init section
        $this->social_details_section($wp_customize);
        $this->posts_callout_section($wp_customize);
        $this->site_identity_section($wp_customize);
        $this->hero_section($wp_customize);
        $this->footer_section($wp_customize);
    }

    //Social Details Sections, Settings and Controls
    private function social_details_section($wp_customize) {

        //New Section Panel
        $wp_customize->add_section('ashad_social_details_section', array(
            'title' => 'Social Details',
            'priority' => 160,
            'description' => __('Add your social acoount usernames', 'ashad')
        ));

        //GitHub
        $wp_customize->add_setting('ashad_github', array(
            'default' => '',
            'sanitize_callback' => array($this, 'sanitize_custom_text')
        ));

        $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'ashad_github_control', array(
            'label' => 'GitHub Username',
            'section' => 'ashad_social_details_section',
            'settings' => 'ashad_github',
            'type' => 'text'
        )));

        //Facebook
        $wp_customize->add_setting('ashad_facebook', array(
            'default' => '',
            'sanitize_callback' => array($this, 'sanitize_custom_text')
        ));

        $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'ashad_facebook_control', array(
            'label' => 'Facebook Username',
            'section' => 'ashad_social_details_section',
            'settings' => 'ashad_facebook',
            'type' => 'text'
        )));

        //Twitter
        $wp_customize->add_setting('ashad_twitter', array(
            'default' => '',
            'sanitize_callback' => array($this, 'sanitize_custom_text')
        ));

        $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'ashad_twitter_control', array(
            'label' => 'Twitter Username',
            'section' => 'ashad_social_details_section',
            'settings' => 'ashad_twitter',
            'type' => 'text'
        )));

        //Medium
        $wp_customize->add_setting('ashad_medium', array(
            'default' => '',
            'sanitize_callback' => array($this, 'sanitize_custom_text')
        ));

        $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'ashad_medium_control', array(
            'label' => 'Medium Username',
            'section' => 'ashad_social_details_section',
            'settings' => 'ashad_medium',
            'type' => 'text'
        )));

        //Instagram
        $wp_customize->add_setting('ashad_instagram', array(
            'default' => '',
            'sanitize_callback' => array($this, 'sanitize_custom_text')
        ));

        $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'ashad_instagram_control', array(
            'label' => 'Instagram Username',
            'section' => 'ashad_social_details_section',
            'settings' => 'ashad_instagram',
            'type' => 'text'
        )));

        //LinkedIn
        $wp_customize->add_setting('ashad_linkedin', array(
            'default' => '',
            'sanitize_callback' => array($this, 'sanitize_custom_text')
        ));

        $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'ashad_linkedin_control', array(
            'label' => 'linkedIn Username',
            'section' => 'ashad_social_details_section',
            'settings' => 'ashad_linkedin',
            'type' => 'text'
        )));

        //Youtube
        $wp_customize->add_setting('ashad_youtube', array(
            'default' => '',
            'sanitize_callback' => array($this, 'sanitize_custom_text')
        ));

        $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'ashad_youtube_control', array(
            'label' => 'YouTube Username',
            'section' => 'ashad_social_details_section',
            'settings' => 'ashad_youtube',
            'type' => 'text'
        )));

    }

    private function posts_callout_section($wp_customize) {
        //Post Panel
        $wp_customize->add_panel( 'post_panel', array(
            'title' => __( 'Posts' ),
            'description' => esc_html__( 'Posts options' ), // Include html tags such as 
            'priority' => 160, // Not typically needed. Default is 160
            'capability' => 'edit_theme_options', // Not typically needed. Default is edit_theme_options
        ));
    
        /**
         * Add our Sample Section
         */
        $wp_customize->add_section( 'min_read_controls_section', array(
            'title' => __( 'Minutes to Read Controls' ),
            'description' => esc_html__( 'Minutes to read' ),
            'panel' => 'post_panel', // Only needed if adding your Section to a Panel
            'priority' => 160, // Not typically needed. Default is 160
            'capability' => 'edit_theme_options', // Not typically needed. Default is edit_theme_options
            'description_hidden' => 'false', // Rarely needed. Default is False
        ));
    
        //Minutes to read
        $wp_customize->add_setting('global_show_min_read_number', array(
            'default' => 100,
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'absint',
            ));
    
        $wp_customize->add_control('global_show_min_read_number', array(
            'label' => esc_html__('Number of Words per Minute Read', 'isha'),
            'section' => 'min_read_controls_section',
            'type' => 'number',
            'priority' => 130
        ));


        //Enable Sidebar
        $wp_customize->add_section( 'ashad_display_sections_section', array(
            'title' => __( 'Sections' ),
            'description' => esc_html__('Display diiferent sections on the blog post'),
            'panel' => 'post_panel', // Only needed if adding your Section to a Panel
            'priority' => 160, // Not typically needed. Default is 160
            'capability' => 'edit_theme_options', // Not typically needed. Default is edit_theme_options
            'description_hidden' => 'false', // Rarely needed. Default is False
        ));

        $wp_customize->add_setting('ashad_sidebar_display', array(
            'default' => true
        ));

        $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'ashad_sidebar_display_control', array(
            'label' => 'Display sidebar in blog post?',
            'section' => 'ashad_display_sections_section',
            'settings' => 'ashad_sidebar_display',
            'type' => 'checkbox',
        )));

        //Display Author Section
        $wp_customize->add_setting('ashad_display_author_details', array(
            'default' => true
        ));

        $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'ashad_display_author_details_control', array(
            'label' => 'Display author section?',
            'section' => 'ashad_display_sections_section',
            'settings' => 'ashad_display_author_details',
            'type' => 'checkbox'
        ))); 

        //Display Share Section
        $wp_customize->add_setting('ashad_display_share', array(
            'default' => true
        ));

        $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'ashad_display_share_control', array(
            'label' => 'Display Share section?',
            'section' => 'ashad_display_sections_section',
            'settings' => 'ashad_display_share',
            'type' => 'checkbox'
        ))); 

        //Show Modal On Finish Post
        $wp_customize->add_setting('ashad_display_finish_modal', array(
            'default' => true
        ));

        $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'ashad_display_finish_modal_control', array(
            'label' => 'Show Modal on finish post?',
            'section' => 'ashad_display_sections_section',
            'settings' => 'ashad_display_finish_modal',
            'type' => 'checkbox'
        ))); 

        //Show Timebar in post
        $wp_customize->add_setting('ashad_display_timebar', array(
            'default' => true
        ));

        $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'ashad_display_timebar_control', array(
            'label' => 'Show Timebar in posts?',
            'section' => 'ashad_display_sections_section',
            'settings' => 'ashad_display_timebar',
            'type' => 'checkbox'
        ))); 
    }

    //Site Identity Section
    private function site_identity_section($wp_customize) {
        //Site Version
        $wp_customize->add_setting('ashad_site_version', array(
            'default' => 'V1.0',
            'sanitize_callback' => array($this, 'sanitize_custom_text')
        ));

        $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'ashad_site_version', array(
            'label' => 'Site Version',
            'section' => 'title_tagline',
            'settings' => 'ashad_site_version',
            'type' => 'text'
        )));
    }

    //Site Hero Section
    private function hero_section($wp_customize) {
        //Hero Section Panel
        $wp_customize->add_section('hero-section', array(
            'title' => 'Hero',
            'priority' => 3,
            'description' => __('The Hero section is only on Home Page.', 'ashad')
        ));

        //Display static content, rescent post or not
        $wp_customize->add_setting('hero-display', array(
            'default' => 'static',
            'sanitize_callback' => array($this, 'sanitize_custom_text')
        ));

        $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'hero-display-control', array(
            'label' => 'Display this Section?',
            'section' => 'hero-section',
            'settings' => 'hero-display',
            'type' => 'select',
            'choices' => array('static' => 'Static Content', 'recent_post' => 'Recent Post', 'hide' => 'Hide')
        ))); 

        //Heading
        $wp_customize->add_setting('hero_heading', array(
            'default' => 'Welcome to <br>' . get_bloginfo('title')//,
            //'sanitize_callback' => array($this, 'sanitize_custom_text')
        ));

        $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'hero_heading-control', array(
            'label' => 'Heading',
            'section' => 'hero-section',
            'settings' => 'hero_heading',
            'type' => 'text'
        )));

        //Subheading1
        $wp_customize->add_setting('hero_subheading1', array(
            'default' => 'From your_name_here',
            'sanitize_callback' => array($this, 'sanitize_custom_text')
        ));

        $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'hero_subheading1-control', array(
            'label' => 'Subheading 1',
            'section' => 'hero-section',
            'settings' => 'hero_subheading1',
            'type' => 'text'
        )));

        //Subheading2
        $wp_customize->add_setting('hero_subheading2', array(
            'default' => get_bloginfo('description'),
            'sanitize_callback' => array($this, 'sanitize_custom_text')
        ));

        $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'hero_subheading2-control', array(
            'label' => 'Subheading 2',
            'section' => 'hero-section',
            'settings' => 'hero_subheading2',
            'type' => 'text'
        )));

        //Add Background Image
        $wp_customize->add_setting('hero_bgimage', array(
            'default' => '',
            'type' => 'theme_mod',
            'capabilty' => 'edit_theme_options',
            'sanitize_callback' => array($this, 'sanitize_custom_url')
        ));

        $wp_customize->add_control(new WP_Customize_Cropped_Image_Control($wp_customize, 'hero_bgimage-control', array(
            'label' => 'Background Image',
            'section' => 'hero-section',
            'settings' => 'hero_bgimage',
            'width' => 760,
            'height' => 400
        )));
    }

    //Footer Sections, Settings and Controls
    private function footer_section($wp_customize) {

        //New Section Panel
        $wp_customize->add_section('ashad-footer-section', array(
            'title' => 'Footer',
            'priority' => 160,
            'description' => __('The Footer section.', 'ashad')
        ));

        //Credit Text
        $wp_customize->add_setting('ashad-footer-credt-text', array(
            'default' => get_bloginfo('title'),
            'sanitize_callback' => array($this, 'sanitize_custom_text')
        ));

        $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'ashad-footer-credt-text-control', array(
            'label' => 'Credit Text',
            'section' => 'ashad-footer-section',
            'settings' => 'ashad-footer-credt-text',
            'type' => 'text'
        )));

        //Author Text
        $wp_customize->add_setting('ashad-footer-author-text', array(
            'default' => '',
            'sanitize_callback' => array($this, 'sanitize_custom_text')
        ));

        $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'ashad-footer-author-text-control', array(
            'label' => 'Author Text',
            'section' => 'ashad-footer-section',
            'settings' => 'ashad-footer-author-text',
            'type' => 'text'
        )));

        //Author Link
        $wp_customize->add_setting('ashad-footer-author-link', array(
            'default' => '',
            'sanitize_callback' => array($this, 'sanitize_custom_url')
        ));

        $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'ashad-footer-author-link-control', array(
            'label' => 'Author link',
            'section' => 'ashad-footer-section',
            'settings' => 'ashad-footer-author-link',
            'type' => 'text'
        )));

    }

    //Sanitize Functions
    public function sanitize_custom_option($input) {
        return ($input === "No") ? "No" : "Yes";
    }

    public function sanitize_custom_text($input) {
        return filter_var($input, FILTER_SANITIZE_STRING);
    }

    public function sanitize_custom_url($input) {
        return filter_var($input, FILTER_SANITIZE_URL);
    }
}
  

?>