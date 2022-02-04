<?php
/**
 * Plugin class
 * ReadMe https://pluginrepublic.com/adding-an-image-upload-field-to-categories/
 **/
if ( ! class_exists( 'CT_TAX_META' ) ) {

class CT_TAX_META {

  public function __construct() {
    //
  }
 
 /*
  * Initialize the class and start calling our hooks and filters
  * @since 1.0.0
 */
 public function init() {
   add_action( 'code_languages_add_form_fields', array ( $this, 'add_code_languages_image' ), 10, 2 );
   add_action( 'created_code_languages', array ( $this, 'save_code_languages_image' ), 10, 2 );
   add_action( 'code_languages_edit_form_fields', array ( $this, 'update_code_languages_image' ), 10, 2 );
   add_action( 'edited_code_languages', array ( $this, 'updated_code_languages_image' ), 10, 2 );
   add_action( 'admin_enqueue_scripts', array( $this, 'load_media' ) );
   add_action( 'admin_footer', array ( $this, 'add_script' ) );
 }

public function load_media() {
 wp_enqueue_media();
}
 
 /*
  * Add a form field in the new code_languages page
  * @since 1.0.0
 */
 public function add_code_languages_image ( $taxonomy ) { ?>
   <div class="form-field term-group">
     <label for="code_languages-image-id"><?php _e('Image', 'ashad'); ?></label>
     <input type="hidden" id="code_languages-image-id" name="code_languages-image-id" class="custom_media_url" value="">
     <div id="code_languages-image-wrapper"></div>
     <p>
       <input type="button" class="button button-secondary ct_tax_media_button" id="ct_tax_media_button" name="ct_tax_media_button" value="<?php _e( 'Add Image', 'ashad' ); ?>" />
       <input type="button" class="button button-secondary ct_tax_media_remove" id="ct_tax_media_remove" name="ct_tax_media_remove" value="<?php _e( 'Remove Image', 'ashad' ); ?>" />
    </p>
    <p class="description">Choose a image of size 00x00px</p>
   </div>
 <?php
 }
 
 /*
  * Save the form field
  * @since 1.0.0
 */
 public function save_code_languages_image ( $term_id, $tt_id ) {
   if( isset( $_POST['code_languages-image-id'] ) && '' !== $_POST['code_languages-image-id'] ){
     $image = $_POST['code_languages-image-id'];
     add_term_meta( $term_id, 'code_languages-image-id', $image, true );
   }
 }
 
 /*
  * Edit the form field
  * @since 1.0.0
 */
 public function update_code_languages_image ( $term, $taxonomy ) { ?>
   <tr class="form-field term-group-wrap">
     <th scope="row">
       <label for="code_languages-image-id"><?php _e( 'Image', 'ashad' ); ?></label>
     </th>
     <td>
       <?php $image_id = get_term_meta ( $term -> term_id, 'code_languages-image-id', true ); ?>
       <input type="hidden" id="code_languages-image-id" name="code_languages-image-id" value="<?php echo $image_id; ?>">
       <div id="code_languages-image-wrapper">
         <?php if ( $image_id ) { ?>
           <?php echo wp_get_attachment_image ( $image_id, 'thumbnail' ); ?>
         <?php } ?>
       </div>
       <p>
         <input type="button" class="button button-secondary ct_tax_media_button" id="ct_tax_media_button" name="ct_tax_media_button" value="<?php _e( 'Add Image', 'ashad' ); ?>" />
         <input type="button" class="button button-secondary ct_tax_media_remove" id="ct_tax_media_remove" name="ct_tax_media_remove" value="<?php _e( 'Remove Image', 'ashad' ); ?>" />
       </p>
        <p class="description">Choose a image of size 00x00px</p>
     </td>
   </tr>
 <?php
 }

/*
 * Update the form field value
 * @since 1.0.0
 */
 public function updated_code_languages_image ( $term_id, $tt_id ) {
   if( isset( $_POST['code_languages-image-id'] ) && '' !== $_POST['code_languages-image-id'] ){
     $image = $_POST['code_languages-image-id'];
     update_term_meta ( $term_id, 'code_languages-image-id', $image );
   } else {
     update_term_meta ( $term_id, 'code_languages-image-id', '' );
   }
 }

/*
 * Add script
 * @since 1.0.0
 */
 public function add_script() { ?>
   <script>
     jQuery(document).ready( function($) {
       function ct_media_upload(button_class) {
         var _custom_media = true,
         _orig_send_attachment = wp.media.editor.send.attachment;
         $('body').on('click', button_class, function(e) {
           var button_id = '#'+$(this).attr('id');
           var send_attachment_bkp = wp.media.editor.send.attachment;
           var button = $(button_id);
           _custom_media = true;
           wp.media.editor.send.attachment = function(props, attachment){
             if ( _custom_media ) {
               $('#code_languages-image-id').val(attachment.id);
               $('#code_languages-image-wrapper').html('<img class="custom_media_image" src="" style="margin:0;padding:0;max-height:100px;float:none;" />');
               $('#code_languages-image-wrapper .custom_media_image').attr('src',attachment.url).css('display','block');
             } else {
               return _orig_send_attachment.apply( button_id, [props, attachment] );
             }
            }
         wp.media.editor.open(button);
         return false;
       });
     }
     ct_media_upload('.ct_tax_media_button.button'); 
     $('body').on('click','.ct_tax_media_remove',function(){
       $('#code_languages-image-id').val('');
       $('#code_languages-image-wrapper').html('<img class="custom_media_image" src="" style="margin:0;padding:0;max-height:100px;float:none;" />');
     });
     // Thanks: http://stackoverflow.com/questions/15281995/wordpress-create-code_languages-ajax-response
     $(document).ajaxComplete(function(event, xhr, settings) {
       var queryStringArr = settings.data.split('&');
       if( $.inArray('action=add-tag', queryStringArr) !== -1 ){
         var xml = xhr.responseXML;
         $response = $(xml).find('term_id').text();
         if($response!=""){
           // Clear the thumb image
           $('#code_languages-image-wrapper').html('');
         }
       }
     });
   });
 </script>
 <?php }

  }
 
$CT_TAX_META = new CT_TAX_META();
$CT_TAX_META -> init();
 
}

?>