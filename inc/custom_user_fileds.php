<?php

/*
Plugin Name: Custom Profile Social Fields
Plugin URI:
Description:
Version: 0.1
Author: Mohammed Ashad
Author URI:
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
ReadMe: https://www.cssigniter.com/how-to-add-a-custom-user-field-in-wordpress/
*/

//Showing the user field
add_action( 'show_user_profile', 'ashad_social_profile_fields' );
add_action( 'edit_user_profile', 'ashad_social_profile_fields' );

function ashad_social_profile_fields( $user ) {
	$github_username = get_the_author_meta( 'github_username', $user->ID );
	$facebook_username = get_the_author_meta( 'facebook_username', $user->ID );
	$twitter_username = get_the_author_meta( 'twitter_username', $user->ID );
	$instagram_username = get_the_author_meta( 'instagram_username', $user->ID );
	$linkedin_username = get_the_author_meta( 'linkedin_username', $user->ID );
	$medium_username = get_the_author_meta( 'medium_username', $user->ID );
	?>
	<h3><?php esc_html_e( 'Social Information', 'ashad' ); ?></h3>

	<table class="form-table">
		<tr>
			<th><label for="github_username"><?php esc_html_e( 'GitHub Username', 'ashad' ); ?></label></th>
			<td>
				<input type="text"
			       id="github_username"
			       name="github_username"
			       value="<?php echo esc_attr( $github_username ); ?>"
			       class="regular-text"
				/>
			</td>
		</tr>
		<tr>
			<th><label for="facebook_username"><?php esc_html_e( 'Facebook Username', 'ashad' ); ?></label></th>
			<td>
				<input type="text"
			       id="facebook_username"
			       name="facebook_username"
			       value="<?php echo esc_attr( $facebook_username ); ?>"
			       class="regular-text"
				/>
			</td>
		</tr>
		<tr>
			<th><label for="twitter_username"><?php esc_html_e( 'Twitter Username', 'ashad' ); ?></label></th>
			<td>
				<input type="text"
			       id="twitter_username"
			       name="twitter_username"
			       value="<?php echo esc_attr( $twitter_username ); ?>"
			       class="regular-text"
				/>
			</td>
		</tr>
		<tr>
			<th><label for="instagram_username"><?php esc_html_e( 'Instagram Username', 'ashad' ); ?></label></th>
			<td>
				<input type="text"
			       id="instagram_username"
			       name="instagram_username"
			       value="<?php echo esc_attr( $instagram_username ); ?>"
			       class="regular-text"
				/>
			</td>
		</tr>
		<tr>
			<th><label for="linkedin_username"><?php esc_html_e( 'LinkedIn Username', 'ashad' ); ?></label></th>
			<td>
				<input type="text"
			       id="linkedin_username"
			       name="linkedin_username"
			       value="<?php echo esc_attr( $linkedin_username ); ?>"
			       class="regular-text"
				/>
			</td>
		</tr>
		<tr>
			<th><label for="medium_username"><?php esc_html_e( 'Medium Username', 'ashad' ); ?></label></th>
			<td>
				<input type="text"
			       id="medium_username"
			       name="medium_username"
			       value="<?php echo esc_attr( $medium_username ); ?>"
			       class="regular-text"
				/>
			</td>
		</tr>
	</table>
    <?php
}

//Validating the field
add_action( 'user_profile_update_errors', 'ashad_user_profile_update_errors', 10, 3 );
function ashad_user_profile_update_errors( $errors, $update, $user ) {
	if ( $update ) {
		return;
	}

	// if ( empty( $_POST['year_of_birth'] ) ) {
	// 	$errors->add( 'year_of_birth_error', __( '<strong>ERROR</strong>: Please enter your year of birth.', 'crf' ) );
	// }
}

//Saving the field
add_action( 'personal_options_update', 'ashad_update_profile_fields' );
add_action( 'edit_user_profile_update', 'ashad_update_profile_fields' );

function ashad_update_profile_fields( $user_id ) {
	if ( ! current_user_can( 'edit_user', $user_id ) ) {
		return false;
	}

    update_user_meta( $user_id, 'github_username', $_POST['github_username'] );
    update_user_meta( $user_id, 'facebook_username', $_POST['facebook_username'] );
    update_user_meta( $user_id, 'twitter_username', $_POST['twitter_username'] );
    update_user_meta( $user_id, 'instagram_username', $_POST['instagram_username'] );
    update_user_meta( $user_id, 'linkedin_username', $_POST['linkedin_username'] );
    update_user_meta( $user_id, 'medium_username', $_POST['medium_username'] );

	// if ( ! empty( $_POST['year_of_birth'] ) && intval( $_POST['year_of_birth'] ) >= 1900 ) {
	// 	update_user_meta( $user_id, 'year_of_birth', intval( $_POST['year_of_birth'] ) );
	// }
}

?>