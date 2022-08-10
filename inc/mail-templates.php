<?php

//New user welcome email
function ashad_wp_new_user_notification_email( $wp_new_user_notification_email, $user, $blogname ) {
    $user_url = stripslashes( $user->user_url );
    $user_login = stripslashes( $user->user_login );
    $user_email = stripslashes( $user->user_email );
    $user_firstname = stripslashes( $user->user_firstname );
    $user_last_name = stripslashes( $user->user_last_name );
    $user_pass = stripslashes( $user->user_pass );
    ob_start();
    include(get_stylesheet_directory() .  '/templates/mail/new-user-notification-email.php');
    $wp_new_user_notification_email['message'] = ob_get_clean();
    $wp_new_user_notification_email['subject'] = sprintf( '[%s] Welcome.', $blogname );
    $wp_new_user_notification_email['headers'] = array('Content-Type: text/html; charset=UTF-8');
    return $wp_new_user_notification_email;
}
add_filter('wp_new_user_notification_email', 'ashad_wp_new_user_notification_email', 10, 3);

//Password reset email (Setting email as html email)
function ashad_retrieve_password_notification_email($defaults) {
    $defaults['headers'] = array('Content-Type: text/html; charset=UTF-8');
    return $defaults;
}
add_filter('retrieve_password_notification_email', 'ashad_retrieve_password_notification_email', 10, 3);

//Password reset email (Setting html message content)
function ashad_reset_password_message($message, $key, $user_login, $user_data )    {
    $user_fullname = $user_data->user_firstname . ' ' . $user_data->user_last_name;
    $blog_name = get_bloginfo('name');
    $reset_url = network_site_url("wp-login.php?action=rp&key=$key&login=" . rawurlencode($user_login), 'login');
    ob_start();
    include(get_stylesheet_directory() .  '/templates/mail/password-change.php');
    $message = ob_get_clean();
    return $message;
}
add_filter("retrieve_password_message", "ashad_reset_password_message", 99, 4);


//Template testing purpose
/*
add_action( 'init',  function() {
    add_rewrite_rule( 'password-change', 'index.php?password-change=true', 'top' );
} );

add_filter( 'query_vars', function( $query_vars ) {
    $query_vars[] = 'password-change';
    return $query_vars;
} );
add_action( 'template_include', function( $template ) {
    if ( get_query_var( 'password-change' ) == false) {
        return $template;
    }
 
    return get_template_directory() . '/templates/mail/password-change.php';
} );
*/