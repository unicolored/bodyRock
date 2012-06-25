<?php

// Make theme available for translation
// Translations can be filed in the /languages/ directory
/*load_theme_textdomain( 'bodyrock', TEMPLATEPATH . '/languages' );
Lire ça d'abord : http://www.catswhocode.com/blog/how-to-make-a-translatable-wordpress-theme*/

// This theme styles the visual editor with editor-style.css to match the theme style.
//add_editor_style(); // == add_editor_style('editor-style.css');

add_theme_support( 'automatic-feed-links' );

// CUSTOM ADMIN LOGIN HEADER LOGO

function my_custom_login_logo()
{
	echo '<style  type="text/css"> h1 a {  background-image:url('.get_bloginfo('template_directory').'/images/logo_admin.png)  !important; } </style>';
}
add_action('login_head',  'my_custom_login_logo');

/*In earlier example, we used add_action and in above example we used add_filter. What's the difference? Well both are WordPress hooks,
only difference is that we used add_action for large functions and add_filter to modify text before its sent to the database or the browser.*/

// CUSTOM ADMIN LOGIN LOGO LINK

function change_wp_login_url()
{
	echo bloginfo('url');  // OR ECHO YOUR OWN URL
}add_filter('login_headerurl', 'change_wp_login_url');

// CUSTOM ADMIN LOGIN LOGO & ALT TEXT

function change_wp_login_title()
{
	echo get_option('blogname'); // OR ECHO YOUR OWN ALT TEXT
}
add_filter('login_headertitle', 'change_wp_login_title');

// CUSTOM ADMIN DASHBOARD HEADER LOGO

function custom_admin_logo() {
	echo '<style type="text/css">#header-logo { background-image: url('.get_bloginfo('template_directory').'/images/logo_admin_dashboard.png) !important; }</style>';
}
add_action('admin_head', 'custom_admin_logo');

// REMOVE META BOXES FROM WORDPRESS DASHBOARD FOR ALL USERS

function example_remove_dashboard_widgets() {	// Globalize the metaboxes array, this holds all the widgets for wp-admin	global $wp_meta_boxes;	
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);} add_action('wp_dashboard_setup', 'example_remove_dashboard_widgets' );

?>