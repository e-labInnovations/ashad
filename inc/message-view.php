<?php
global $wpdb;
$table_name = $wpdb->prefix . 'ashad_contacts';

$message_query = "SELECT * FROM $table_name WHERE id = $message_id";
$message_data = $wpdb->get_results($message_query)[0];
$wpdb->query("update $table_name set status='read' WHERE id IN($message_id)");

?>
<div class="wrap">    
    <h2><?php echo $message_data->subject ?></h2>
    <p><b>Name: </b> <?php echo $message_data->name ?></p>
    <p><b>Email: </b> <a href="mailto:<?php echo $message_data->email ?>"><?php echo $message_data->email ?></a></p>
    <p><b>Subject: </b> <?php echo $message_data->subject ?></p>
    <p><b>Date: </b> <?php echo date('m-d-Y h:i A', strtotime($message_data->time)) ?></p>
    <p><b>Message: </b> <br> <?php echo $message_data->message ?></p>

    <p>
        <a href="<?php echo '?page='.$_GET['page'] ?>" class="button">Back</a>
        <a href="<?php echo '?page='.$_GET['page'].'&action=trash&message_id='.$message_data->id ?>" class="button">Trash</a>
        <a href="<?php echo '?page='.$_GET['page'].'&action=spam&message_id='.$message_data->id ?>" class="button">Spam</a>
    </p>
</div>