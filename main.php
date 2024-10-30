<?php
/*
Plugin Name: Content Warning
Plugin URI: http://rjeevan.com
Description: Based on wp-door, This plugin uses AJAX & Thickbox to Display Dialog based Content Warning to Users.
Version: 1.0
Author: Rajeevan
Author URI: http://rjeevan.com
*/?>
<?php

/* Plugin Loaded 
	This Function will Handle AJAX request and Prevent wordpress from showing pagecontents if required
*/
function wpcw_plugins_loaded()
{
	if(is_admin() || is_feed())
		return;
	
	$wpcw_request = (isset($_GET['wpcw']) && !empty($_GET['wpcw']) ) ? strtolower($_GET['wpcw']) : null;
	
	if(!$wpcw_request)
		return;
		
	// Switch Requests
	switch($wpcw_request)
	{
		case 'js':
				header('Content-type: application/x-javascript');
				//header('Content-type: application/octet-stream');
				//header('Content-Length: ' . filesize($file));
				
				header('Content-Disposition: inline; filename="wpcw.js"');
				
				// Echo PATH
				echo 'var wpcw_wpurl = "'.get_bloginfo('wpurl').'";'."\n";
				echo 'var wpcw_url = "'.WP_PLUGIN_URL.'/content-warning";'."\n";
				echo 'var tb_pathToImage = "'.get_bloginfo('wpurl').'/wp-includes/js/thickbox/loadingAnimation.gif";'."\n";
				echo 'var tb_closeImage = "'.get_bloginfo('wpurl').'/wp-includes/js/thickbox/tb-close.png";'."\n";
				
				exit;
			break;
		case 'message':
				wpcw_build_message();
			break;
		case 'log':
				wpcw_log();
			break;
		default: return;
	}
		
}
add_action('plugins_loaded', wpcw_plugins_loaded);

/* Init Method to Determine Showing Messages*/
function wpcw_init_method()
{

	if(is_admin() || is_feed())
		return;
	
	// Do need to Show Message?
	if(!wpcw_show_message())
		return;
	
	// Attach Script & CSS to Show Message
    wp_enqueue_script('thickbox');
    
	wp_enqueue_script('wpcw-js',
		WP_PLUGIN_URL . '/content-warning/assets/wpcw.js',
		array('jquery'),
		'1.0');
	
	wp_enqueue_script('wpcw-js-call',
		get_bloginfo('wpurl') . '/?wpcw=js',
		array('jquery'),
		'1.0', true);
		
	wp_enqueue_style( 'thickbox');
	
	wp_enqueue_style( 'wpcw', WP_PLUGIN_URL.'/content-warning/assets/wpcw.css' );
	
} 
add_action('init', wpcw_init_method);

// Show Users Message
function wpcw_build_message()
{
	// Read File
	$file = dirname(__FILE__).'/assets/message.html';
	$handle = fopen($file, "r"); 
    $output = fread($handle, filesize($file));
    fclose($handle); 
    
    // Get Contents
    $msg_title = get_option('wpcw_msg_title');
    $msg_title = empty($msg_title) ? 'Content Warning' : $msg_title;
    
    $msg_message = get_option('wpcw_msg_message');
    $msg_message = empty($msg_message) ? '<p>You are about to enter a website that may contain content of an adult nature. These pages are designed for ADULTS only and may include pictures and materials that some viewers may find offensive. If you are under the age of 18, if such material offends you or if it is illegal to view such material in your community please EXIT now.</p>' : $msg_message;
    
    $exit_text = get_option('wpcw_msg_exit_text');
    $exit_text = empty($exit_text) ? 'EXIT' : $exit_text;
    
    $exit_url = get_option('wpcw_msg_exit_url');
    $exit_url = empty($exit_url) ? 'http://www.google.com' : $exit_url;
    
    $enter_text = get_option('wpcw_msg_enter_text');
    $enter_text = empty($enter_text) ? 'ENTER' : $enter_text;
    
    header('Content-type: text/html');
    
    // Format Output
    $output = str_replace('[msg_title]', $msg_title, $output);
    $output = str_replace('[msg_message]', $msg_message, $output);
    $output = str_replace('[exit_text]', $exit_text, $output);
    $output = str_replace('[exit_url]', $exit_url, $output);
    $output = str_replace('[enter_text]', $enter_text, $output);
    
    echo $output;
    exit;
}

// LOG user in Session & Cookies
function wpcw_log()
{
	
	// Get Options
	$cookie_expire = intval(get_option('wpcw_cookie_expire'));
	
	// SET COOKIE and SESSION
	if($cookie_expire < 0)
		$expire = time() + (3600 * 24 * 3650); // Expire in 10 Yrs
	elseif($cookie_expire == 0 )
		$expire = 0; // Expire End of Session
	else
		$expire = time() + $cookie_expire; // Expire in Specified Time
	
	setcookie('wpcw_validated', '1', $expire, SITECOOKIEPATH, COOKIE_DOMAIN);

	// SET SESSION VARIABLE
	if("" == session_id())
		session_start();
		
	$_SESSION['wpcw_validated'] = '1';
	
	// Sent DONE message	
	header('Content-type: text/plain');
	
	echo 'Done';
	
	exit;
}

// Check Options, Session & Cookie
function wpcw_show_message()
{
	if("" == session_id())
		session_start();
	
	// Get Option to check Enabled?
	$enabled = get_option('wpcw_enabled');
	if($enabled != '1')
		return false; // No need to Continue!
	
	// Check Session
	if(isset($_SESSION['wpcw_validated']) && !empty($_SESSION['wpcw_validated']) && $_SESSION['wpcw_validated'] == '1')
		return false;
	
	// Check Cookie
	if(isset($_COOKIE['wpcw_validated']) && !empty($_COOKIE['wpcw_validated']) && $_COOKIE['wpcw_validated'] == '1')
		return false;
	
	// or Show Message Dialog
	return true;
	
}

// Admin menu
function wpcw_admin_menu()
{
	add_options_page("Content Warning", "Content Warning Settings", 'administrator', dirname(__FILE__).'/wpcw-settings.php');
}

function wpcw_register_mysettings()
{
	register_setting( 'wpcw-group', 'wpcw_enabled' );
	register_setting( 'wpcw-group', 'wpcw_cookie_expire' );
	register_setting( 'wpcw-group', 'wpcw_msg_title' );
	register_setting( 'wpcw-group', 'wpcw_msg_message' );
	register_setting( 'wpcw-group', 'wpcw_msg_exit_text' );
	register_setting( 'wpcw-group', 'wpcw_msg_exit_url' );
	register_setting( 'wpcw-group', 'wpcw_msg_enter_text' );
}

if(is_admin())
{
	add_action('admin_menu', wpcw_admin_menu);
	add_action( 'admin_init', 'wpcw_register_mysettings');
}

// Activation HOOCK
function wpcw_activate()
{
	// Setup Init Values
	if(get_option('wpcw_cookie_expire') == false)
		update_option('wpcw_cookie_expire', '0');
	
	if(get_option('wpcw_msg_title') == false)
		update_option('wpcw_msg_title', 'Content Warning');
	
	if(get_option('wpcw_msg_message') == false)
		update_option('wpcw_msg_message', '<p>You are about to enter a website that may contain content of an adult nature. These pages are designed for ADULTS only and may include pictures and materials that some viewers may find offensive. If you are under the age of 18, if such material offends you or if it is illegal to view such material in your community please EXIT now.</p>');
	
	if(get_option('wpcw_msg_exit_text') == false)
		update_option('wpcw_msg_exit_text','EXIT');
	
	if(get_option('wpcw_msg_exit_url') == false)
		update_option('wpcw_msg_exit_url','http://www.google.com');
	
	if(get_option('wpcw_msg_enter_text') == false)
		update_option('wpcw_msg_enter_text','ENTER');
	
}
register_activation_hook( __FILE__, 'wpcw_activate' );
?>
