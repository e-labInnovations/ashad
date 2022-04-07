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
            'cb'		=> '<input type="checkbox" />', // to display the checkbox.			 
		    'name'      => 'Name',
            'email'   => 'Email',
            'subject'   => 'Subject',
            'message'   => 'Message',
            'date'   => 'Date',
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

        $user_query = "SELECT 
                            *
                        FROM 
                            $table_name 
                        ORDER BY $orderby $order";

        // query output_type will be an associative array with ARRAY_A.
        $query_results = $wpdb->get_results( $user_query, ARRAY_A  );
        
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
            case 'email':
                return esc_html( $item['email'] );
            case 'subject':
                return esc_html( $item['subject'] );
            case 'message':
                return esc_html( wp_trim_words($item['message'], 10) );
            case 'date':
                return esc_html( $item['time'] );
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

    /**
     * [OPTIONAL] this is example, how to render column with actions,
     * when you hover row "Edit | Delete" links showed
     *
     * @param $item - row (key, value array)
     * @return HTML
     */

    function first_column_name($item) {
        $actions = array(
            'edit'      => sprintf('<a href="?page=custom_detail_page&user=%s">Edit</a>',$item['id']),
            'trash'    => sprintf('<a href="?page=custom_list_page&action=trash&user=%s">Trash</a>',$item['id']),
            );
        return sprintf('%1$s %2$s', $item['name'], $this->row_actions($actions) );
    
    }

    // Returns an associative array containing the bulk action.
    public function get_bulk_actions() {
        /*
        * on hitting apply in bulk actions the url paramas are set as
        * ?action=bulk-download&paged=1&action2=-1
        * 
        * action and action2 are set based on the triggers above and below the table		 		    
        */
        $actions = array(
            'download' => 'Download messages',
            'trash' => 'Move to Trash' 
        );
        return $actions;
    }

    public function process_bulk_action() {  
        global $wpdb;
        $table_name = $wpdb->prefix . 'ashad_contacts';

        $nonce = wp_unslash( $_REQUEST['_wpnonce'] );
        if ( ! wp_verify_nonce( $nonce, 'bulk-messages' ) ) { // verify the nonce.
            $this->invalid_nonce_redirect();
        }
        else {
            if ('trash' === $this->current_action()) {
                if (isset($_GET['messages'])) {
                    if (is_array($_GET['messages'])){
                        foreach ($_GET['messages'] as $id) {
                            if(!empty($id)) {
                                $wpdb->query("update $table_name set status='trash' WHERE id IN($id)");
                            }
                        }
                    } else {
                        if (!empty($_GET['messages'])) {  
                            $id=$_GET['messages'];
                            $wpdb->query("update $table_name set status='trash' WHERE id =$id");  
                        }
                    }
                }
            }
            
            $this->graceful_exit();
        }
    }

    // public function handle_table_actions() {	
    //     /*
    //      * Note: Table bulk_actions can be identified by checking $_REQUEST['action'] and $_REQUEST['action2']
    //      * action - is set if checkbox from top-most select-all is set, otherwise returns -1
    //      * action2 - is set if checkbox the bottom-most select-all checkbox is set, otherwise returns -1
    //      */    
    //     if ( ( isset( $_REQUEST['action'] ) && $_REQUEST['action'] === 'bulk-download' ) || ( isset( $_REQUEST['action2'] ) && $_REQUEST['action2'] === 'bulk-download' ) ) {
    
    //         $nonce = wp_unslash( $_REQUEST['_wpnonce'] );	
    //         /*
    //          * Note: the nonce field is set by the parent class
    //          * wp_nonce_field( 'bulk-' . $this->_args['plural'] );	 
    //          */
    //         if ( ! wp_verify_nonce( $nonce, 'bulk-messages' ) ) { // verify the nonce.
    //             $this->invalid_nonce_redirect();
    //         }
    //         else {
    //             include_once( 'messages-bulk-download.php' );
    //             $this->graceful_exit();
    //         }
    //     }
    // }

    /**
     * Get value for checkbox column.
     *
     * @param object $item  A row's data.
     * @return string Text to be placed inside the column <td>.
     */
    protected function column_cb( $item ) {
        return sprintf(		
        '<label class="screen-reader-text" for="message_' . $item['id'] . '">' . sprintf( __( 'Select %s' ), $item['name'] ) . '</label>'
        . "<input type='checkbox' name='messages[]' id='message_{$item['id']}' value='{$item['id']}' />"					
        );
    }
}