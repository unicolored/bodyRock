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

	add_settings_section('brthemeoptions_intro', 'Options du thème', 'brthemeoptions_backofficeCallback_sectiontext_intro', 'brthemeoptions');	
	add_settings_section('brthemeoptions_cssjs', 'CSS &amp; JS', 'brthemeoptions_backofficeCallback_sectiontext_cssjs', 'brthemeoptions');
	add_settings_section('brthemeoptions_layout', 'Structure', 'brthemeoptions_backofficeCallback_sectiontext_layout', 'brthemeoptions');
	add_settings_section('brthemeoptions_fonts', 'Polices', 'brthemeoptions_backofficeCallback_sectiontext_fonts', 'brthemeoptions');
	add_settings_section('brthemeoptions_colors', 'Couleurs', 'brthemeoptions_backofficeCallback_sectiontext_colors', 'brthemeoptions');
	add_settings_section('brthemeoptions_image', 'Vidéo', 'brthemeoptions_backofficeCallback_sectiontext_image', 'brthemeoptions');
	add_settings_section('brthemeoptions_video', 'Vidéo', 'brthemeoptions_backofficeCallback_sectiontext_video', 'brthemeoptions');
	add_settings_section('brthemeoptions_customtypes', 'Vidéo', 'brthemeoptions_backofficeCallback_sectiontext_customtypes', 'brthemeoptions');
	add_settings_section('brthemeoptions_seo', 'Référencement', 'brthemeoptions_backofficeCallback_sectiontext_seo', 'brthemeoptions');
	/*	
	This creates a “section” of settings.
	The first argument is simply a unique id for the section.
	The second argument is the title or name of the section (to be output on the page).
	The third is a function callback to display the guts of the section itself.
	The fourth is a page name. This needs to match the text we gave to the do_settings_sections function call.
	
	To add a new section, you:
	1. Do a new add_settings_section call.
	2. Make the function to display any descriptive text about it.
	3. Add settings fields to it as above.
	
	*/
	
	add_settings_field('brthemeoptions_compilationless', 'Compilation Less', 'brthemeoptions_backofficeCallback_compilationless', 'brthemeoptions', 'brthemeoptions_cssjs');
	add_settings_field('brthemeoptions_iconset', 'Set d\'icônes', 'brthemeoptions_backofficeCallback_iconset', 'brthemeoptions', 'brthemeoptions_cssjs');
	add_settings_field('brthemeoptions_bootstrapjs', 'Boostrap Javascript', 'brthemeoptions_backofficeCallback_bootstrapjs', 'brthemeoptions', 'brthemeoptions_cssjs');
	add_settings_field('brthemeoptions_layout_width', 'Largeur du container', 'brthemeoptions_backofficeCallback_layout_width', 'brthemeoptions', 'brthemeoptions_layout');
	add_settings_field('brthemeoptions_fonts_google', 'Google Fonts chargée par Webfont', 'brthemeoptions_backofficeCallback_fonts_google', 'brthemeoptions', 'brthemeoptions_fonts');
	add_settings_field('brthemeoptions_color_bodybg', 'Couleur du body', 'brthemeoptions_backofficeCallback_color_bodybg', 'brthemeoptions', 'brthemeoptions_colors');
	add_settings_field('brthemeoptions_image_sizes', 'Tailles d\'image', 'brthemeoptions_backofficeCallback_image_sizes', 'brthemeoptions', 'brthemeoptions_image');
	add_settings_field('brthemeoptions_video_autoplay', 'Lecture automatique', 'brthemeoptions_backofficeCallback_video_autoplay', 'brthemeoptions', 'brthemeoptions_video');
	add_settings_field('brthemeoptions_video_height', 'Hauteur de l\'iframe', 'brthemeoptions_backofficeCallback_video_height', 'brthemeoptions', 'brthemeoptions_video');
	add_settings_field('brthemeoptions_type_lieux', 'Type Lieux', 'brthemeoptions_backofficeCallback_type_lieux', 'brthemeoptions', 'brthemeoptions_customtypes');
	add_settings_field('brthemeoptions_type_evenements', 'Type Evènements', 'brthemeoptions_backofficeCallback_type_evenements', 'brthemeoptions', 'brthemeoptions_customtypes');
	add_settings_field('brthemeoptions_googleanalyticsid', 'Google Analytics ID', 'brthemeoptions_backofficeCallback_googleanalyticsid', 'brthemeoptions', 'brthemeoptions_seo');
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

// DESCRIPTION DES SECTIONS
function brthemeoptions_backofficeCallback_sectiontext_intro() {
	echo '<table class="form-table">';			
		echo '<tr valign="top">';
		echo '<td width="300"><img src="/wp-content/themes/bodyrock/screenshot.png" alt="BODYROCK .talc" width="300" height="225"></td>';
		echo '<td>';
		echo '<h4><small>Date de version : jan. 2014</small></h4>';
		echo '<p><strong>'.__('Site Web du thème', 'bodyrock').'</strong> : <a href="http://bodyrock.gilleshoarau.com/">Page officielle Bodyrock</a></p>';
		echo '<p><strong>'.__('Auteur', 'bodyrock').'</strong> : Gilles Hoarau (<a href="http://gilleshoarau.com/">'.__('Site Web', 'bodyrock').'</a>)</p>';
		echo '<hr>';
		echo '<p>Body<em>rock</em> est un thème <strong>orienté développeurs</strong>. Il utilise les composants <strong>Bootstrap</strong> et la compilation <strong>Less</strong>.</p>';
		echo '</td>';
		echo '</tr>';
	echo '</table>';
}
function brthemeoptions_backofficeCallback_sectiontext_cssjs() {
	echo '<p>Les options  concernant la CSS et le JS.</p>';
}
function brthemeoptions_backofficeCallback_sectiontext_layout() {
	echo '<p>Les options pour la structure du site.</p>';
}
function brthemeoptions_backofficeCallback_sectiontext_fonts() {
	echo '<p>Les options pour les polices à utiliser.</p>';
}
function brthemeoptions_backofficeCallback_sectiontext_colors() {
	echo '<p>Les options pour les couleurs du thème.</p>';
}
function brthemeoptions_backofficeCallback_sectiontext_image() {
	echo '<p>Les options pour articles de format image.</p>';
}
function brthemeoptions_backofficeCallback_sectiontext_video() {
	echo '<p>Les options pour articles de format vidéo.</p>';
}
function brthemeoptions_backofficeCallback_sectiontext_customtypes() {
	echo '<p>Activation des custom types.</p>';
}
function brthemeoptions_backofficeCallback_sectiontext_seo() {
	echo '<p>Les options concernant le référencement.</p>';
}

// HTML DES CHAMPS DE FORMULAIRES /////////////////////////////////////
function brthemeoptions_backofficeCallback_compilationless() {
	$options = get_option('brthemeoptions', themeoptionsGet_default());
	echo '<input '.checked( $options['compileless_on'], true, false ).' name="brthemeoptions[compileless_on]" type="checkbox" value="1" id="brthemeoptions_compilationless" /> '.__('Active la compilation less', 'bodyrock').'';
	echo '<br><small class="description">'.__('Indispensable en développement CSS', 'bodyrock').'</small>';
}
function brthemeoptions_backofficeCallback_iconset() {
	$options = get_option('brthemeoptions', themeoptionsGet_default());
	$sets = array(
		array('id'=>'disabled','label'=>'Désactivé'),
		array('id'=>'myicon','label'=>'Manuel (.myicon)'),
		array('id'=>'glyphicon','label'=>'Glyphicon','url'=>'<a href="http://getbootstrap.com/components/#glyphicons" target="_blank">afficher</a>'),
		array('id'=>'font-awesome','label'=>'Font-Awesome','url'=>'<a href="http://fortawesome.github.io/Font-Awesome/icons/" target="_blank">afficher</a>'),
		array('id'=>'elusive','label'=>'Elusive','url'=>'<a href="http://shoestrap.org/downloads/elusive-icons-webfont/" target="_blank">afficher</a>')
		);
		
	foreach ($sets as $S) {
		echo '<input '.checked( $options['iconset'], $S['id'] , false).' name="brthemeoptions[iconset]" type="radio" value="'.$S['id'].'" id="brthemeoptions[iconset]" /> '.$S['label'];
		echo ' '.$S['url'];
		echo '<br>';
	}
}
function brthemeoptions_backofficeCallback_bootstrapjs() {
	$options = get_option('brthemeoptions', themeoptionsGet_default());
	echo '<input '.checked( $options['allbsjs'], true, false ).' name="brthemeoptions[allbsjs]" type="checkbox" value="1" id="brthemeoptions_compilationless" /> '.__('Activer les <a href="http://getbootstrap.com/javascript/" target="_blank">composants JS de Bootstrap</a>', 'bodyrock').'';
	echo '<br><small>affix, alert, button, carousel, collapse, dropdown, modal, popover, scrollspy, tab, tooltip, transition, typeahead</small>';
}
function brthemeoptions_backofficeCallback_layout_width() {
	$options = get_option('brthemeoptions', themeoptionsGet_default());
	echo '<input type="checkbox" value="1" name="brthemeoptions[layout_width]" id="brthemeoptions_layout_width" '.checked( $options['layout_width'], true, false ).' /> '.__('Fluidifier le container', 'bodyrock').'';
}
function brthemeoptions_backofficeCallback_fonts_google() {
	$options = get_option('brthemeoptions', themeoptionsGet_default());
	echo '<input name="brthemeoptions[fonts_google]" value="'.esc_attr($options['fonts_google']).'" size="80" type="text" id="brthemeoptions_fonts_google" />';
}
function brthemeoptions_backofficeCallback_color_bodybg() {
	$options = get_option('brthemeoptions', themeoptionsGet_default());
	echo '<input name="brthemeoptions[color_bodybg]" value="'.esc_attr($options['color_bodybg']).'" size="10" type="text" id="brthemeoptions_color_bodybg" />';
}
function brthemeoptions_backofficeCallback_image_sizes() {
	$options = get_option('brthemeoptions', themeoptionsGet_default());
	echo '<input name="brthemeoptions[image_sizes]" value="'.esc_attr($options['image_sizes']).'" size="80" type="text" id="brthemeoptions_image_sizes" />';
}
function brthemeoptions_backofficeCallback_video_autoplay() {
	$options = get_option('brthemeoptions', themeoptionsGet_default());
	echo '<input type="checkbox" value="1" name="brthemeoptions[video_autoplay]" id="brthemeoptions_video_height" '.checked( $options['video_autoplay'], true, false ).' /> '.__('Lecture automatique de la vidéo au chargement de la page', 'bodyrock').'';
}
function brthemeoptions_backofficeCallback_video_height() {
	$options = get_option('brthemeoptions', themeoptionsGet_default());
	echo '<input name="brthemeoptions[video_height]" value="'.esc_attr($options['video_height']).'" size="5" type="text" id="brthemeoptions_video_height" /> px';
}
function brthemeoptions_backofficeCallback_type_lieux() {
	$options = get_option('brthemeoptions', themeoptionsGet_default());
	echo '<input type="checkbox" value="1" name="brthemeoptions[type_lieux]" id="brthemeoptions_type_lieux" '.checked( $options['type_lieux'], true, false ).' /> '.__('Activer', 'bodyrock').'';
}
function brthemeoptions_backofficeCallback_type_evenements() {
	$options = get_option('brthemeoptions', themeoptionsGet_default());
	echo '<input type="checkbox" value="1" name="brthemeoptions[type_evenements]" id="brthemeoptions_type_evenements" '.checked( $options['type_evenements'], true, false ).' /> '.__('Activer', 'bodyrock').'';
}
function brthemeoptions_backofficeCallback_googleanalyticsid() {
	$options = get_option('brthemeoptions', themeoptionsGet_default());
	echo '<input name="brthemeoptions[google_analytics_id]" value="'.esc_attr($options['google_analytics_id']).'" type="text" id="brthemeoptions_seo" />';
	echo '<br><small class="description">'.__('Entrer votre identifiant UA-XXXXX-X', 'bodyrock').'</small>';
}
?>

