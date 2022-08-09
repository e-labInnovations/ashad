<?php

function ashad_wp_new_user_notification_email( $wp_new_user_notification_email, $user, $blogname ) {
    global $wpcargo;
    $user_url = stripslashes( $user->user_url );
    $user_login = stripslashes( $user->user_login );
    $user_email = stripslashes( $user->user_email );
    $user_firstname = stripslashes( $user->user_firstname );
    $user_last_name = stripslashes( $user->user_last_name );
    $user_pass = stripslashes( $user->user_pass );
    ob_start();
    include( locate_template( '../templates/mail/new-user-notification-email.php' )); // This path may vary depending on your setup.
    $wp_new_user_notification_email['message'] = ob_get_clean();
    $wp_new_user_notification_email['subject'] = sprintf( '[%s] Welcome.', $blogname );
    $wp_new_user_notification_email['headers'] = array('Content-Type: text/html; charset=UTF-8');
    return $wp_new_user_notification_email;
}
add_filter( 'wp_new_user_notification_email', 'ashad_wp_new_user_notification_email', 10, 3 );