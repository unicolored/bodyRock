<?php

// DEPRECATED :: Fonctions dépréciées /////////////////////////////////////////////

/*//**//**//**//*//**//**//**//*//**//**//**//*//**//**//**/
// Fonctions qui ont changé de nom
/*//**//**//**//*//**//**//**//*//**//**//**//*//**//**//**/

/*

Exemple :
Votre ancienne fonction br_nomdufichier_oldmethod() ne s'appelle plus correctement.
Mais plusieurs de vos thèmes enfants utilisent cette fonction. Il faut donc conserver son nom et appeller la nouvelle fonction.

On copiera dans ce fichier :

function br_nomdufichier_oldmethod() {
return br_nomdufichier_newmethod();
}

Note : concerne principalement les fonctions br_ qui peuvent être utilisée par un thème enfant qui mettrait à jour le thème parent.

*/
if(!function_exists('bitly_url')) {
	function bitly_url() {
		deprecated(__FUNCTION__,'br_backend_filesWrite_videoimg');
		//br_backend_filesWrite_videoimg();
	}
}

function br_generateVideoImg() {
	deprecated(__FUNCTION__,'br_backend_filesWrite_videoimg');
	br_backend_filesWrite_videoimg();
}

function auto_compile_less($less_fname, $css_fname) {
	deprecated(__FUNCTION__,'backend_filesWrite_less');
	backend_filesWrite_less($less_fname, $css_fname);
}

function bodyrock_posted_on($sep=false) {
	deprecated(__FUNCTION__,'br_content_textesGet_posted_on');
	br_content_textesGet_posted_on($sep=false);
}

function br_setLastViews() {
	deprecated(__FUNCTION__,'br_modules_lastviewsSet');
	br_modules_lastviewsSet();
}


/*//**//**//**//*//**//**//**//*//**//**//**//*//**//**//**/
// Gère l'affichage de la bodyloop sur post page
/*//**//**//**//*//**//**//**//*//**//**//**//*//**//**//**/

function add_post_content($post) {
    //vardump($post);

    if (isset($post -> queried_object -> ID)) {
        $instance = getDefaultLoop();
        $instance = get_post_meta($post -> queried_object -> ID);
        foreach ($instance as $K => $V) {
            $instance[$K] = $V[0];
        }
        $instance['filtres_off'] = false;
        $instance['aftercontent'] = true;
        $instance['ajax'] = false;

        $form = new br_widgetsBodyloop();
        //vardump($form -> widget(false, $instance));
        echo $form -> widget(false, $instance);
    }
}
if(!is_admin() && is_page()) {
    //add_filter('loop_start', 'add_post_content');
}

// GET EMBED AUDIO /////////////////////////////////////////////
// Afficher l'iframe correspondant au code d'un post audio
function br_getEmbedAudio($array) {
	switch($array['type']) {
		default:
		return '<iframe width="100%" height="450" scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/tracks/'.$array['track'].'&amp;auto_play=false&amp;hide_related=false&amp;visual=true"></iframe>';
			break;
		}
	}
	function br_EmbedAudio($array) { echo br_getEmbedAudio($array); }

////// WP_NAV_MENU /////////////////////////////////////////////
////// Fonction fallback_cb pour un menu si il est vide.
// Fonction appellée en paramètre de wp_nav_menu(array('fallback_cb'=>'default_menu'))
// Ci-desso
function default_menu($args) {
      echo '
      <ul class="nav navbar-nav">
        <li'.(is_home() ? ' class="active"' : false).'><a href="/">Home</a></li>
      </ul>
      ';
      return true;
}

if ( !function_exists( 'portfolio_posts_per_page' ) ) {
	function portfolio_posts_per_page( $query ) {
		if ( isset($query->query_vars['post_type']) && $query->query_vars['post_type'] == 'portfolio' ) $query->query_vars['posts_per_page'] = 1;
		return $query;
	}
}
if ( !is_admin() ) add_filter( 'pre_get_posts', 'portfolio_posts_per_page' );

/*
if ( !function_exists( 'portfolio_thumbnail_url' ) ) {
	function portfolio_thumbnail_url($pid){
		$image_id = get_post_thumbnail_id($pid);
		$image_url = wp_get_attachment_image_src($image_id,'screen-shot');
		return  $image_url[0];
	}
}
*/

// ADD EDITOR STYLE /////////////////////////////////////////////
// Permet d'associer les styles définis pour le FrontOffice à l'éditeur tinymce du BackOffice
function add_editor_styles() {
    add_editor_style('css/editor-style.css');
}

// MY CUSTOM ADMIN LOGO /////////////////////////////////////////////
// Remplace le logo de Wordpress sur la page admin.

function my_custom_admin_logo()
{
	echo '<style type="text/css">#wp-admin-bar-wp-logo .ab-item span.ab-icon { background: url('.get_template_directory_uri().'/img/logo_admin_unid.png) !important; }</style>';
}

// CHANGE WP LOGIN URL /////////////////////////////////////////////
// Remplace le lien sur le logo de la page login.
function change_wp_login_url() { return 'http://bodyrock.fromscratch.xyz/'; }

// CHANGE WP LOGIN TITLE /////////////////////////////////////////////
function change_wp_login_title() { return 'bodyRock | Solid WP'; }

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
	'title' => __('bodyRock','bodyrock'),
	'href' => $customerSupportURL
	));

	// Add a new sub-menu to the link above
	// Here we add a link to our contact us web page
	$contactUsURL = 'http://bodyrock.fromscratch.xyz/';
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
/*
function formatIcon($format=false) {
  if($format != false) {
    $Icons = array(
      'audio' => 'feed',
      'aside' => 'road',
      'chat' => 'bubbles',
      'gallery' => 'images',
      'image' => 'images',
      'link' => 'attachment',
      'quote' => 'quotes-left',
      'status' => 'user2',
      'video' => 'film',
    );
    return $Icons[$format];
  }
  else {
    return 'libreoffice';
  }
}

function formatLabel($format=false) {
  if($format != false) {
    $Icons = array(
      'audio' => 'Podcast',
      'aside' => 'En bref',
      'chat' => 'Question',
      'gallery' => 'Album',
      'image' => 'Image',
      'link' => 'Lien',
      'quote' => 'Citation',
      'status' => 'Quoi de neuf ?',
      'video' => 'Vidéo',
    );
    return $Icons[$format];
  }
  else {
    return 'Article';
  }
}*/
