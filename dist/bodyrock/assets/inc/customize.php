<?php

// CUSTOMIZE /////////////////////////////////////////////

/*//**//**//**//*//**//**//**//*//**//**//**//*//**//**//**/
// Personnalisation de Wordpress.
/*//**//**//**//*//**//**//**//*//**//**//**//*//**//**//**/


// On retire les liens xml vers les fichiers permettant l'édition par Live Writer
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wp_shortlink_wp_head');

add_action( 'login_enqueue_scripts', 'my_custom_login_logo' );


// ADD EDITOR STYLE /////////////////////////////////////////////
// Permet d'associer les styles définis pour le FrontOffice à l'éditeur tinymce du BackOffice
function add_editor_styles() {
    add_editor_style('css/editor-style.css');
}

// MY CUSTOM LOGIN LOGO /////////////////////////////////////////////
// Remplace le logo de Wordpress sur la page login.
function my_custom_login_logo()
{
	echo '<style  type="text/css">body.login div#login h1 a {  background-image:url('.get_template_directory_uri().'/assets/images/logo_login_bodyrock.png)  !important; } </style>';
}

// MY CUSTOM ADMIN LOGO /////////////////////////////////////////////
// Remplace le logo de Wordpress sur la page admin.
function my_custom_admin_logo()
{
	echo '<style type="text/css">#wp-admin-bar-wp-logo .ab-item span.ab-icon { background: url('.get_template_directory_uri().'/img/logo_admin_unid.png) !important; }</style>';
}

// CHANGE WP LOGIN URL /////////////////////////////////////////////
// Remplace le lien sur le logo de la page login.
function change_wp_login_url() { return 'http://bodyrock.gilleshoarau.com/'; }

// CHANGE WP LOGIN TITLE /////////////////////////////////////////////
function change_wp_login_title() { return 'BodyRock par Gilles Hoarau'; }

// ADMIN BAR RENDER /////////////////////////////////////////////
// Admin Bar Customisation
function admin_bar_render() {
	global $wp_admin_bar;

	// Remove an existing link using its $id
	// Here we remove the 'Updates' drop-down link
	$wp_admin_bar->remove_menu('updates');

	// Add a new top level menu link
	// Here we add a customer support URL link
	$customerSupportURL = '/wp-admin/themes.php?page=theme_options';
	$wp_admin_bar->add_menu( array(
	'parent' => false,
	'id' => 'bodyrock',
	'title' => __('BodyRock','bodyrock'),
	'href' => $customerSupportURL
	));

	// Add a new sub-menu to the link above
	// Here we add a link to our contact us web page
	$contactUsURL = 'http://bodyrock.gilleshoarau.com/';
	$wp_admin_bar->add_menu(array(
	'parent' => 'bodyrock',
	'id' => 'site',
	'title' => __('Site Officiel','bodyrock'),
	'href' => $contactUsURL
	));

	$contactUsURL = 'http://gilleshoarau.com/a-propos/';
	$wp_admin_bar->add_menu(array(
	'parent' => 'bodyrock',
	'id' => 'a-propos',
	'title' => __('A propos de l\'auteur'),
	'href' => $contactUsURL
	));
}

// ADMIN FOOTER MODIFICATION /////////////////////////////////////////////
// Admin footer modification
function replace_footer_admin ()
{
	echo '<span id="footer-thankyou">Developpé par <a href="http://gilleshoarau.com" target="_blank">Gilles Hoarau</a></span>';
}
?>
