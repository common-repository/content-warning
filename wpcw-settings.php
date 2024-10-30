<?php
// Setting page for WP-DOOR
// Uninstall
if(isset($_POST['wpcw_action']))
{
	if($_POST['wpcw_action'] == 'uninstall')
	{
		delete_option('wpcw_enabled');
		delete_option('wpcw_cookie_expire');
		delete_option('wpcw_msg_title');
		delete_option('wpcw_msg_message');
		delete_option('wpcw_msg_exit_text');
		delete_option('wpcw_msg_exit_url');
		delete_option('wpcw_msg_enter_text');
		
		echo '<div class="updated"><p><strong>Settings Removed</strong>... You may now Deactivate this Plugin</p></div>';
	}
}
?>
<div class="wrap">

	<h2>Content Warning Settings</h2>
	
	<form method="post" action="options.php">
	<?php wp_nonce_field('update-options'); ?>
	<table class="form-table">
	<tbody>
		<tr>
			<th><label for="">Enable</label></th>
			<td><input type="checkbox" name="wpcw_enabled" value="1" <?php if(get_option('wpcw_enabled') == '1'){echo ' checked="checked"';} ?> /> Enable Content Warning</td>
		</tr>
		<tr>
			<th><label for="">Cookie Expiry Time</label></th>
			<td><input type="text" name="wpcw_cookie_expire" value="<?php echo get_option('wpcw_cookie_expire'); ?>" size="5" /> Seconds <small>[ 0 = Cookie Loggin Disabled | -1 = Cookie Expire in 10 Years ]</small></td>
		</tr>
	</tbody>
	</table>
	
	<div id="" style="border:1px dotted #ccc; background-color:#fff;padding:10px">
	<h3>Display Message</h3>
	<table class="form-table">
	<tbody>
		<tr>
			<th><label for="">Message Title</label></th>
			<td><input type="text" name="wpcw_msg_title" value="<?php echo get_option('wpcw_msg_title'); ?>" size="35" /> <small>Will be Displayed within H1</small></td>
		</tr>
		<tr>
			<th><label for="">Message</label><br /><small>You may use HTML</small></th>
			<td><textarea name="wpcw_msg_message" rows="8" style="width:90%"><?php echo get_option('wpcw_msg_message'); ?></textarea></td>
		</tr>
		<tr>
			<th><label for="">EXIT Link</label><br /></th>
			<td>Text: <input type="text" name="wpcw_msg_exit_text" value="<?php echo get_option('wpcw_msg_exit_text'); ?>" size="20" /> URL: <input type="text" name="wpcw_msg_exit_url" value="<?php echo get_option('wpcw_msg_exit_url'); ?>" size="35" /></td>
		</tr>
		<tr>
			<th><label for="">ENTER Link</label><br /></th>
			<td>Text: <input type="text" name="wpcw_msg_enter_text" value="<?php echo get_option('wpcw_msg_enter_text'); ?>" size="20" /> URL: <small>N/A</small></td>
		</tr>
	</tbody>
	</table>
	</div>
	
	
	<p class="submit">
		<input type="submit" name="submit" value="Save Changes" class="button-primary" />
	</p>
	<input type="hidden" name="action" value="update" />
	<input type="hidden" name="page_options" value="wpcw_enabled,wpcw_cookie_expire,wpcw_msg_title,wpcw_msg_message,wpcw_msg_exit_text,wpcw_msg_exit_url,wpcw_msg_enter_text" />
	<?php settings_fields( 'wpcw-group' ); ?>
	</form>
	
	<div>
		<h3>Uninstall ?</h3>
		
		<p>Uninstall / Remove this version variables from Database?</p>
		<form method="post" action="">
			<p class=""><input type="submit" name="submit" value="Uninstall" class="button" /></p>
			<input type="hidden" name="wpcw_action" value="uninstall" />
		</form>
		
		<div style="display:none"><p>Have you used wp-door plugin before moving to Ajax Version? Please click Unstall Beta to Remove it's contents from your Database.</p>
		<form method="post" action="">
			<p class=""><input type="submit" name="submit" value="Uninstall Beta" class="button" /></p>
		</form></div>
		
	</div>

</div>