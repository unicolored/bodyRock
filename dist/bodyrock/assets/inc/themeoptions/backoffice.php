<?php

// BACKOFFICE Theme options /////////////////////////////////////////////

/*//**//**//**//*//**//**//**//*//**//**//**//*//**//**//**/
// Rendu de la page des options du thème via Wordpress.
/*//**//**//**//*//**//**//**//*//**//**//**//*//**//**//**/


// ADD PAGE /////////////////////////////////////////////
// Ajout du menu Options dans la rubrique Apparence
function themeoptions_backofficeAdd_page() {
	// Add sub menu page to the Appearance menu.
	$theme_page = add_theme_page(__('Configurer BodyRock', 'bodyrock'),	__('Options du thème', 'bodyrock'),	themeoptions_backofficeCapability(), 'brthemeoptions', 'themeoptions_viewRender_page' );

  if (!$theme_page)
    return;
}

// BAR RENDER /////////////////////////////////////////////
// Ajout du menu Options dans le menu déroulant en FrontOffice
function themeoptions_backofficeBar_render() {
  global $wp_admin_bar;

  $wp_admin_bar->add_menu(array(
    'parent' => 'appearance',
    'id' => 'brthemeoptions',
    'title' => __('Options du thème', 'bodyrock'),
    'href' => admin_url( 'themes.php?page=brthemeoptions')
  ));
}

// CAPABILITY /////////////////////////////////////////////
// C'est ici que l'on définit la permission nécessaire à l'édition de la page.
// Autrement dit, faut-il être administrateur, éditeur, auteur, etc...
// http://codex.wordpress.org/Roles_and_Capabilities
function themeoptions_backofficeCapability() {
  return 'edit_theme_options';
}

// ADMIN ENQUEUE SCRIPTS /////////////////////////////////////////////
// Chargement des CSS et JS de la page options du thème
///wp-admin/themes.php?page=theme_options
function themeoptions_backofficeEnqueue_scripts($hook_suffix) {
	if ($hook_suffix !== 'appearance_page_theme_options') return;

	wp_enqueue_style('css_themeoptions', get_template_directory_uri() . '/css/theme-options.css');
	wp_enqueue_script('js_themeoptions', get_template_directory_uri() . '/js/theme-options.js');
}

// REGISTER /////////////////////////////////////////////
// Initialisation des variables d'options
function themeoptions_backofficeRegister() {

	register_setting('brthemeoptionsfields', 'brthemeoptions', 'themeoptions_validation');
	/*
	First, we register the settings. In my case, I’m going to store all my settings in one options field, as an array.
	This is usually the recommended way. The first argument is a group, which needs to be the same as what you used in the settings_fields function call.
	The second argument is the name of the options. If we were doing more than one, we’d have to call this over and over for each separate setting.
	The final arguement is a function name that will validate your options. Basically perform checking on them, to make sure they make sense.
	*/

	/*
	This creates a “section” of settings.
	The first argument is simply a unique id for the section.
	The second argument is the title or name of the section (to be output on the page).
	The third is a function callback to display the guts of the section itself.
	The fourth is a page name. This needs to match the text we gave to the do_settings_sections function call.

	To add a new section, you:
	1. Do a new add_settings_section call.
	2. Make the function to display any descriptive text about it.
	3. Add settings fields to it as below.

	*/
	$brto = 'brthemeoptions';
	$brto_Callback = $brto.'_backofficeCallback';

	$section = 'cssjs';
	add_settings_section($brto.'_'.$section, '<hr><h2>CSS &amp; JS</h2>', $brto_Callback.'_sectiontext_'.$section, $brto);
		add_settings_field($brto.'_bootswatch', 'Bootswatch', $brto_Callback.'_bootswatch', $brto, $brto.'_'.$section);
		add_settings_field($brto.'_iconset', 'Set d\'icônes', $brto_Callback.'_iconset', $brto, $brto.'_'.$section);
		add_settings_field($brto.'_container', 'Container', $brto_Callback.'_container', $brto, $brto.'_'.$section);
		add_settings_field($brto.'_navbartopfixed', 'Navbar Top', $brto_Callback.'_navbartopfixed', $brto, $brto.'_'.$section);
		add_settings_field($brto.'_jquery', 'jQuery', $brto_Callback.'_jquery', $brto, $brto.'_'.$section);
		add_settings_field($brto.'_bootstrapjs', 'Boostrap JS', $brto_Callback.'_bootstrapjs', $brto, $brto.'_'.$section);

	$section = 'seo';
	add_settings_section($brto.'_'.$section, '<hr><h2>Référencement</h2>', $brto_Callback.'_sectiontext_'.$section, $brto);
		add_settings_field($brto.'_breadcrumb', 'Breadcrumb', $brto_Callback.'_breadcrumb', $brto, $brto.'_'.$section);
		add_settings_field($brto.'_googleanalyticsid', 'Google Analytics ID', $brto_Callback.'_googleanalyticsid', $brto, $brto.'_'.$section);

	/*
	The first argument is simply a unique id for the field.
	The second is a title for the field.
	The third is a function callback, to display the input box.
	The fourth is the page name that this is attached to (same as the do_settings_sections function call).
	The fifth is the id of the settings section that this goes into (same as the first argument to add_settings_section).

	For each option to add we:
	1. Do a new add_settings_field call.
	2. Make the function to display that particular input.
	3. Add code to validate it when it comes back to us from the user.
	*/

}
/////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////
// DESCRIPTION DES SECTIONS
function brthemeoptions_backofficeCallback_sectiontext_cssjs() {
	echo '<p>Les options  concernant la CSS et le JS.</p>';
}
function brthemeoptions_backofficeCallback_sectiontext_seo() {
	echo '<p>Les options concernant le référencement.</p>';
}

/////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////
// HTML DES CHAMPS DE FORMULAIRES
function brthemeoptions_backofficeCallback_iconset() {
	$options = get_option('brthemeoptions', themeoptionsGet_default());
	$sets = array(
		array('id'=>'glyphicon','label'=>'Glyphicon <em>(par défaut)</em>','url'=>'http://getbootstrap.com/components/#glyphicons'),
		array('id'=>'fontawesome','label'=>'Font-Awesome','url'=>'http://fontawesome.io/icons/'),
		array('id'=>'linearicons','label'=>'Linearicons','url'=>'https://linearicons.com/free'),
		array('id'=>'octicons','label'=>'Octicons','url'=>'https://octicons.github.com/')
		);

	foreach ($sets as $S) {
		echo '<input '.checked( $options['iconset'], $S['id'] , false).' name="brthemeoptions[iconset]" type="radio" value="'.$S['id'].'" id="brthemeoptions[iconset]" /> '.$S['label'];
		echo (isset($S['url']) ? ' <a href="'.$S['url'].'" target="_blank"><small>site web</small></a>' : false);
		echo '<br>';
	}
}
function brthemeoptions_backofficeCallback_bootswatch() {
	$options = get_option('brthemeoptions', themeoptionsGet_default());
	$sets = array(
		array('id'=>'aucun'),
		array('id'=>'cerulean'),
		array('id'=>'cosmo'),
		array('id'=>'cyborg'),
		array('id'=>'darkly'),
		array('id'=>'flatly'),
		array('id'=>'journal'),
		array('id'=>'lumen'),
		array('id'=>'paper'),
		array('id'=>'readable'),
		array('id'=>'sandstone'),
		array('id'=>'simplex'),
		array('id'=>'slate'),
		array('id'=>'spacelab'),
		array('id'=>'superhero'),
		array('id'=>'united'),
		array('id'=>'yeti')
		);
		print '<select name="brthemeoptions[bootswatch]">';
	foreach ($sets as $S) {
		echo '<option '.selected( $options['bootswatch'], $S['id'] , false).' value="'.$S['id'].'" id="brthemeoptions[bootswatch]">'.ucfirst($S['id']).'</option>';
	}
	print '</select>';
}
function brthemeoptions_backofficeCallback_container() {
	$options = get_option('brthemeoptions', themeoptionsGet_default());
	echo '<input '.checked( $options['container'], true, false ).' name="brthemeoptions[container]" type="checkbox" value="1" id="brthemeoptions_container" /> '.__('Préférer le .container-fluid', 'bodyrock').'';
	echo '<br><small>Par défaut : .container fixe</small>';
}
function brthemeoptions_backofficeCallback_navbartopfixed() {
	$options = get_option('brthemeoptions', themeoptionsGet_default());
	echo '<input '.checked( $options['navbartopfixed'], true, false ).' name="brthemeoptions[navbartopfixed]" type="checkbox" value="1" id="brthemeoptions_navbartopfixed" /> '.__('Préférer la navbar top fixed .navbar-fixed-top', 'bodyrock').'';
	echo '<br><small>Par défaut : navbar top scroll</small>';
}
function brthemeoptions_backofficeCallback_jquery() {
	$options = get_option('brthemeoptions', themeoptionsGet_default());
	echo '<input '.checked( $options['jquery'], true, false ).' name="brthemeoptions[jquery]" type="checkbox" value="1" id="brthemeoptions_jquery" /> '.__('Activer <a href="https://developers.google.com/speed/libraries/#jquery" target="_blank">jQuery</a>', 'bodyrock').'';
	echo '<br><small>https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js</small>';
}
function brthemeoptions_backofficeCallback_bootstrapjs() {
	$options = get_option('brthemeoptions', themeoptionsGet_default());
	echo '<input '.checked( $options['allbsjs'], true, false ).' name="brthemeoptions[allbsjs]" type="checkbox" value="1" id="brthemeoptions_allbsjs" /> '.__('Activer les <a href="http://getbootstrap.com/javascript/" target="_blank">composants JS de Bootstrap</a>', 'bodyrock').'';
	echo '<br><small>https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js</small>';
}
function brthemeoptions_backofficeCallback_googleanalyticsid() {
	$options = get_option('brthemeoptions', themeoptionsGet_default());
	echo '<input name="brthemeoptions[googleanalyticsid]" value="'.esc_attr($options['googleanalyticsid']).'" type="text" id="brthemeoptions_seo" />';
	echo '<br><small class="description">'.__('Entrer votre identifiant UA-XXXXX-X', 'bodyrock').'</small>';
}
function brthemeoptions_backofficeCallback_breadcrumb() {
	$options = get_option('brthemeoptions', themeoptionsGet_default());
	echo '<input '.checked( $options['breadcrumb'], true, false ).' name="brthemeoptions[breadcrumb]" type="checkbox" value="1" id="brthemeoptions_breadcrumb" /> '.__('Activer', 'bodyrock').'';
	echo '<br><small>Désactivé par défaut</small>';
}
?>
