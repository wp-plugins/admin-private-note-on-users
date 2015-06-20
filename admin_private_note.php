<?php
/*
Plugin Name: Admin Private Note on users
Plugin URI: http://wplizer.com
Description: Easily add hidden and private notes for your users and they will never see your notes about them!
Author: wplizer
Author URI: wplizer.com
Text Domain: admin-private-note
Domain Path: /languages/
Version: 1.0
*/


add_action('init', 'rsf_init');
function rsf_init()
{
	 if ( current_user_can( 'manage_options' ) && current_user_can( 'edit_users' ))
	 {
		add_action( 'show_user_profile', 'rsf_show_apn',99999 );
		add_action( 'edit_user_profile', 'rsf_show_apn',99999 );
		//add_action( 'personal_options_update', 'rsf_save_apn' );
		add_action( 'edit_user_profile_update', 'rsf_save_apn',99999 );
	 } 
}


function rsf_show_apn( $user ) { ?>

	<h3>Admin Private Notes</h3>
	<table class="form-table">
		<tr>
			<th><label for="rsf_admin_note">your private notes about this user:</label></th>
			<td>
			<?php wp_editor( 
			esc_attr( get_the_author_meta( 'rsf_admin_note', $user->ID ) ),
			'rsf_admin_note' ,
			array('teeny'=>true,'media_buttons'=>false,'textarea_rows'=>5));
			?>
				<span class="description">Users will never see your notes about them...</span>
			</td>
		</tr>
	</table>
<?php }

function rsf_save_apn( $user_id ) {
	if ( !current_user_can( 'edit_user', $user_id ) )
	{
		return false;
	}
	else
	{
		update_usermeta( $user_id, 'rsf_admin_note', $_POST['rsf_admin_note'] );
	}
}
?>