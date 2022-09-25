<?php
//Source: https://wpmudev.com/blog/wordpress-admin-tables/

if ( ! class_exists( 'WP_List_Table' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class contacts_List_Table extends WP_List_Table {
    /**
     * Get a list of columns.
     *
     * @return array
     */
    public function get_columns() {
        return array(
            'cb'        => '<input type="checkbox" />', // to display the checkbox.
            'read'      => 'Read',
		    'name'      => 'Name',
            'email'     => 'Email',
            'subject'   => 'Subject',
            'message'   => 'Message',
            'date'      => 'Date',
        );
    }
    public function no_items() {
        _e( 'No messages avaliable.', 'ashad' );
    }

    public function fetch_table_data() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'ashad_contacts';		
        $orderby = ( isset( $_GET['orderby'] ) ) ? esc_sql( $_GET['orderby'] ) : 'time';
        $order = ( isset( $_GET['order'] ) ) ? esc_sql( $_GET['order'] ) : 'DESC';
        $message_status = isset($_GET['message_status'])?$_GET['message_status']:'all';
        if($message_status) {
            if($message_status == 'all') {
                $where_status = "status != 'trash' AND status != 'spam'";
            } else if($message_status == 'spam') {
                $where_status = "status = 'spam'";
            } else if($message_status == 'trash') {
                $where_status = "status = 'trash'";
            }
        } else {
            $where_status = "status != 'trash' AND status != 'spam'";
        }

        $message_query = "SELECT 
                            *
                        FROM 
                            $table_name 
                        WHERE
                            $where_status
                        ORDER BY $orderby $order";

        // query output_type will be an associative array with ARRAY_A.
        $query_results = $wpdb->get_results( $message_query, ARRAY_A  );
        
        // return result array to prepare_items.
        return $query_results;	
    }
    /**
     * Prepares the list of items for displaying.
     */
    public function prepare_items() {
        $columns  = $this->get_columns();
        $sortable = $this->get_sortable_columns();
        $hidden   = array();
        $this->get_bulk_actions();
        $table_data = $this->fetch_table_data();
        $total_messages = count( $table_data );
        // $message = get_current_message_id();
        // $screen = get_current_screen();
        // $option = $screen->get_option('per_page', 'option'); 
        // $perpage = get_user_meta($message, $option, true);
        $this->_column_headers = array($columns,$hidden,$sortable);
	    
        //used by WordPress to build and fetch the _column_headers property
        $this->_column_headers = $this->get_column_info();		      
            
        // code to handle data operations like sorting and filtering
        // check if a search was performed.
        $user_search_key = isset( $_REQUEST['s'] ) ? wp_unslash( trim( $_REQUEST['s'] ) ) : '';
        
        $this->_column_headers = $this->get_column_info();
        
        // check and process any actions such as bulk actions.
        $this->handle_table_actions();

        // fetch the table data
        $table_data = $this->fetch_table_data();
        // filter the data in case of a search
        if( $user_search_key ) {
            $table_data = $this->filter_table_data( $table_data, $user_search_key );
        }	
        // rest of the code
            
        // start by assigning your data to the items variable
        $this->items = $table_data;	
            
        // code to handle pagination
        $messages_per_page = 10;//$this->get_items_per_page( 'messages_per_page' );
        $table_page = $this->get_pagenum();

        // provide the ordered data to the List Table
        // we need to manually slice the data based on the current pagination
        $this->items = array_slice( $table_data, ( ( $table_page - 1 ) * $messages_per_page ), $messages_per_page );

        // set the pagination arguments		
        $this->set_pagination_args( array (
            'total_items' => $total_messages,
            'per_page'    => $messages_per_page,
            'total_pages' => ceil( $total_messages/$messages_per_page )
        ) );
    }

    /**
     * Generates content for a single row of the table.
     * 
     * @param object $item The current item.
     * @param string $column_name The current column name.
     */
    protected function column_default( $item, $column_name ) {
        switch ( $column_name ) {
            case 'name':
                return esc_html( $item['name'] );
                case 'read':
                    return $item['status'] == 1? '<span class="dashicons dashicons-visibility"></span>': '<span class="dashicons dashicons-saved"></span>';
            case 'email':
                return sprintf('<a href="mailto:%s">%s</a>', esc_html($item['email']), esc_html($item['email']));
            case 'subject':
                return esc_html( $item['subject'] );
            case 'message':
                return sprintf('<a href="?page=%s&action=view&message_id=%s">%s</a>', $_GET['page'], $item['id'], esc_html( wp_trim_words($item['message'], 10) ));
            case 'date':
                return esc_html(date('m-d-Y h:i A', strtotime($item['time'])));
            return 'Unknown';
        }
    }

    /**
    * Decide which columns to activate the sorting functionality on
    * @return array $sortable, the array of columns that can be sorted by the user
    */
    public function get_sortable_columns() {
        $sortable_columns = array(
            'date'     => array('time',true),
            'name' => array('name',true) ); 
        return $sortable_columns;
    }

    // filter the table data based on the search key
    public function filter_table_data( $table_data, $search_key ) {
        $filtered_table_data = array_values( array_filter( $table_data, function( $row ) use( $search_key ) {
            foreach( $row as $row_val ) {
                if( stripos( $row_val, $search_key ) !== false ) {
                    return true;
                }				
            }
        } ) );

        return $filtered_table_data;
    }

    protected function get_views() { 
        $message_status = isset($_GET['message_status'])?$_GET['message_status']:'all';
        $status_links = array(
            "all"       => ($message_status == 'all' || !$message_status)?'All':"<a href='?page=".$_GET['page']."&message_status=all'>All</a>",
            "spam" => $message_status == 'spam'?'Spam':"<a href='?page=".$_GET['page']."&message_status=spam'>Spam</a>",
            "trash"   => $message_status == 'trash'?'Trash':"<a href='?page=".$_GET['page']."&message_status=trash'>Trash</a>"
        );
        return $status_links;
    }

    /**
     * [OPTIONAL] this is example, how to render column with actions,
     * when you hover row "Edit | Delete" links showed
     *
     * @param $item - row (key, value array)
     * @return HTML
     */

    function column_name($item) {
        // create a nonce
        $action_nonce = wp_create_nonce( 'action_nonce' );
        $avatar = get_avatar_url($item['email'], ['size' => '32']);
        if($avatar == 'http://0.gravatar.com/avatar/92b35c463af18efdda2fa2db1161a47c?s=32&d=mm&r=g') {
            $email_md5 = md5($item['email']);
            $avatar = "https://www.gravatar.com/avatar/" . $email_md5 . ".jpg?s=32";
        }
        $title = sprintf('<img src="%s" class="avatar avatar-32 photo" height="32" width="32" loading="lazy" /><strong><a href="?page=%s&action=view&message_id=%s">%s</a></strong>', $avatar, $_GET['page'], $item['id'], $item['name']);

        $item_message_status = isset($item['message_status'])?$item['message_status']:'spam';
        $actions = array(
            'restore'   => sprintf('<a href="?page=%s&action=restore&message_id=%s&message_status=%s&_wpnonce=%s">Restore</a>', $_GET['page'], $item['id'], $item_message_status, $action_nonce),
            'trash'     => sprintf('<a href="?page=%s&action=trash&message_id=%s&message_status=%s&_wpnonce=%s">Trash</a>', $_GET['page'], $item['id'], $item_message_status, $action_nonce),
            'spam'      => sprintf('<a href="?page=%s&action=spam&message_id=%s&message_status=%s&_wpnonce=%s">Spam</a>', $_GET['page'], $item['id'], $item_message_status, $action_nonce),
        );

        $message_status = isset($_GET['message_status'])?$_GET['message_status']:'all';
        if($message_status) {
            if($message_status == 'all') {
                unset($actions["restore"]);
            } else if($message_status == 'spam') {
                unset($actions["spam"]);
            } else if($message_status == 'trash') {
                unset($actions["trash"]);
            }
        } else {
            unset($actions["restore"]);
        }

        return sprintf('%1$s %2$s', $title, $this->row_actions($actions) );
    
    }

    /**
     * Get value for checkbox column.
     *
     * @param object $item  A row's data.
     * @return string Text to be placed inside the column <td>.
     */
    protected function column_cb( $item ) {
        return sprintf('<input type="checkbox" name="message_ids[]" value="%s" />', $item['id']);
    }

    /**
    * Returns an associative array containing the bulk action
    *
    * @return array
    */
    public function get_bulk_actions() {
        $actions = array(
            'restore'   => 'Restore',
            'spam'      => 'Mark as spam',
            'trash'     => 'Move to Trash'
        );

        $message_status = isset($_GET['message_status'])?$_GET['message_status']:'all';
        if($message_status) {
            if($message_status == 'all') {
                unset($actions["restore"]);
            } else if($message_status == 'spam') {
                unset($actions["spam"]);
            } else if($message_status == 'trash') {
                unset($actions["trash"]);
            }
        } else {
            unset($actions["restore"]);
        }

        return $actions;
    }

    public function handle_table_actions() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'ashad_contacts';
        $action = isset($_GET['action'])? trim($_GET['action']) : "";
        $message_id = isset($_GET['message_id'])? intval($_GET['message_id']) : "";
        $nonce = esc_attr(isset($_REQUEST['_wpnonce']));

        // If the single action is triggered
        if(($action === 'trash' || $action === 'spam' || $action === 'restore') && $message_id) {
            if ( ! wp_verify_nonce( $nonce, 'action_nonce' ) ) {
                die( 'Go get a life script kiddies' );
            } else {
                if ($action === 'trash') {
                    $wpdb->query("update $table_name set status='trash' WHERE id = $message_id");
                } else if ($action === 'spam') {
                    $wpdb->query("update $table_name set status='spam' WHERE id = $message_id");
                } else if ($action === 'restore') {
                    $wpdb->query("update $table_name set status='read' WHERE id = $message_id");
                }
            }
        }

        // If the bulk action is triggered
        if ( ( isset( $_GET['action'] ) && $_GET['action'] == 'trash' )
            && ( isset( $_GET['action2'] ) && $_GET['action2'] == 'trash' )) {
            $message_ids = esc_sql( $_GET['message_ids'] );

            foreach ( $message_ids as $id ) {
                $wpdb->query("update $table_name set status='trash' WHERE id = $id");
            }
        } else if ( ( isset( $_GET['action'] ) && $_GET['action'] == 'spam' )
            && ( isset( $_GET['action2'] ) && $_GET['action2'] == 'spam' )) {
            $message_ids = esc_sql( $_GET['message_ids'] );

            foreach ( $message_ids as $id ) {
                $wpdb->query("update $table_name set status='spam' WHERE id = $id");
            }
        } else if ( ( isset( $_GET['action'] ) && $_GET['action'] == 'restore' )
            && ( isset( $_GET['action2'] ) && $_GET['action2'] == 'restore' )) {
            $message_ids = esc_sql( $_GET['message_ids'] );

            foreach ( $message_ids as $id ) {
                $wpdb->query("update $table_name set status='read' WHERE id = $id");
            }
        }
    }
}