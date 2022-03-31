<?php

//Contact page template
add_filter('template_include', 'loadContactPageTemplate', 99);
function loadContactPageTemplate($template) {
    if (is_page('contact')) {
        return plugin_dir_path(__FILE__) . '../templates/contact-page.php';
    }
    return $template;
}

//Create DB
add_action("after_switch_theme", "ashad_create_contact_db");
function ashad_create_contact_db() {
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

	global $wpdb;
	$charset_collate = $wpdb->get_charset_collate();
	$table_name = $wpdb->prefix . 'ashad_contacts';

	$sql = "CREATE TABLE $table_name (
		id mediumint(9) unsigned NOT NULL AUTO_INCREMENT,
		time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
        name varchar(60) NOT NULL DEFAULT '',
        email varchar(60) NOT NULL DEFAULT '',
        subject varchar(60) NOT NULL DEFAULT '',
        message longtext COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
        status varchar(20) NOT NULL DEFAULT '1',
		UNIQUE KEY id (id)
	) $charset_collate;";

	dbDelta( $sql );
}

//Add Admin Menu
add_action('admin_menu', 'ashadContactsMenu');
function ashadContactsMenu() {
    add_menu_page( 'Contacts', 'Contacts', 'manage_options', 'ashad-contacts', 'contactsHTML', 'dashicons-email', 100 );
}

function contactsHTML() {
    if ( ! class_exists( 'WP_List_Table' ) ) {
        require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
    }
    global $wpdb;
	$table_name = $wpdb->prefix . 'ashad_contacts';
    $query = $wpdb->prepare("SELECT * FROM $table_name LIMIT 100");
    $contacts = $wpdb->get_results($query);
?>
<h1>Hello</h1>
<p><?php var_dump($contacts); ?></p>
<?php
}


//Set Message send template
add_action( 'init',  function() {
    add_rewrite_rule( 'message-send', 'index.php?message-send=true', 'top' );
} );

add_filter( 'query_vars', function( $query_vars ) {
    $query_vars[] = 'message-send';
    return $query_vars;
} );

add_action( 'template_include', function( $template ) {
    if ( get_query_var( 'message-send' ) == false) {
        return $template;
    }
 
    return get_template_directory() . '../templates/message-send.php';
} );


//Test
// add_action('admin_head', 'onAdminRefresh');
function onAdminRefresh() {
	global $wpdb;
	$table_name = $wpdb->prefix . 'ashad_contacts';

    $now = new DateTime();

    $wpdb->insert($table_name, array(
        'time' => $now->format('Y-m-d H:i:s'),
        'name' => 'Ashad',
        'email' => 'ashad@elabins.com',
        'subject' => 'Help',
        'message' => 'Hi Sir',
        'status' => '1'
    ));
}

?>