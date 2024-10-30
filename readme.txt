=== Content Warning ===
Contributors: rajeevan
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=rajeevanuk%40gmail%2ecom&item_name=WP%20Plugin&no_shipping=0&no_note=1&tax=0&currency_code=GBP&lc=GB&bn=PP%2dDonationsBF&charset=UTF%2d8
Tags: warning, message, lading page, front page, enter page, adult contents, consent, age verification, validation
Requires at least: 2.8
Tested up to: 2.9
Stable tag: 1.0

This plugin uses AJAX & Thickbox to Display Dialog based Content Warning to Users. This act as Landing page to show message.

== Description ==

Using Ajax & Thickbox, content warring shows message to user with option to leave the site. This plugin is useful for users using wordpress to host mature contents and others where user should go though a landing page.

At any point of entry, Users will be asked to confirm to message once per session or interval specified in settings (Could be one a day, week or whatever time you give).

Message and Message title can be edited via admin Interface. Colours and style have to be edited Manually by Editing "wpcw.css" file.

*   "No additional Library" Plugin use jQuery and Thickbox Library comes with Wordpress.
*   "Developed using 2.8" Developed using Wordpress 2.8, I cannot support anything below that!
*   "Tested up to" This plugin tested in 2.9 and working!

= Based on wp-door Plugin =
* This plugin is driven from `wp-door` Plugin, wp-door plugin used to Redirect used to landing age If no session or Cookie found. This caused problem with search engine bots. Content warning uses Ajax & Thickbox to show message without redirecting user to different page.

== Installation ==

1. Upload `content-warning` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. `Enable` and update `title`, `contents`, `links`  in "Settings > Content warning setting"

== Frequently Asked Questions ==

= Flash Conflict With Thickbox =

Unfortunately, I can't do much. You will have t make sure that Flash have the following Param to make it Transparent. otherwise Flash will overlap Thickbox!

To Fix: 
* Add ` <param name="wmode" value="transparent">`  to your object tag
* Set `wmode="transparent"` in the embed tag

= How to edit Colours,Styles & sizes? =
You will have to open the CSS file and Edit to change Colours, Sizes and Styles. Open `content-warning/assets/wpcw.css` to Make changes.

== Screenshots ==

1. Preview of Thick box showing Message to End-user.
2. Admin Settings Preview

== Changelog ==

= 1.0 =
First version...
