<?php

function ashad_contact_messages_settings_html() {
    $contact_page_data = get_option('ashad_contactpage_data',array(
        'sitekey'   => '',
        'secretkey' => ''
    ));
?>
    <div class="wrap">    
        <h2>Contact Page Settings</h2>
        <?php
            if(isset($_POST['justsubmitted'])?$_POST['justsubmitted']:false == 'true') {
                if(wp_verify_nonce($_POST['acpsNonce'], 'save_ashad_contactpage_settings') && current_user_can('manage_options')) {
                    $contact_page_data['sitekey'] = $_POST['recaptcha_sitekey'];
                    $contact_page_data['secretkey']   = $_POST['recaptcha_secretkey'];
                    
                    update_option('ashad_contactpage_data', $contact_page_data);
                    ?>
                    <div class="notice notice-success is-dismissible"> 
                        <p><strong>Settings saved.</strong></p>
                        <button type="button" class="notice-dismiss">
                            <span class="screen-reader-text">Dismiss this notice.</span>
                        </button>
                    </div>
                    <?php
                } else {
                    ?>
                    <div class="notice notice-error is-dismissible"> 
                        <p><strong>Sorry you don't have permission to perform that apache_get_version</strong></p>
                        <button type="button" class="notice-dismiss">
                            <span class="screen-reader-text">Dismiss this notice.</span>
                        </button>
                    </div>
                    <?php
                }
            }
        ?>
        <form method="post">
            <input type="hidden" name="justsubmitted" value="true">
            <?php wp_nonce_field('save_ashad_contactpage_settings', 'acpsNonce') ?>
            <h2 class="title">reCAPTCHA Keys</h2>
            <table class="form-table">
                <tr>
                    <th><label for="recaptcha_sitekey">Site Key</label></th>
                    <td>
                        <input type="text"
                        id="recaptcha_sitekey"
                        name="recaptcha_sitekey"
                        value="<?php echo $contact_page_data['sitekey'] ?>"
                        class="regular-text"
                        />
                    </td>
                </tr>
                <tr>
                    <th><label for="recaptcha_secretkey">Secret Key</label></th>
                    <td>
                        <input type="text"
                        id="recaptcha_secretkey"
                        name="recaptcha_secretkey"
                        value="<?php echo $contact_page_data['secretkey'] ?>"
                        class="regular-text"
                        />
                    </td>
                </tr>
            </table>

            <input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes">
        </form>
    </div>
<?php
}