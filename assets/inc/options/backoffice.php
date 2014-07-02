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
	
	$section = 'intro';
	add_settings_section($brto.'_'.$section, 'Options du thème', $brto_Callback.'_sectiontext_'.$section, $brto);	

	$section = 'cssjs';
	add_settings_section($brto.'_'.$section, 'CSS &amp; JS', $brto_Callback.'_sectiontext_'.$section, $brto);	
		add_settings_field($brto.'_compilationless', 'Compilation Less', $brto_Callback.'_compilationless', $brto, $brto.'_'.$section);
		add_settings_field($brto.'_iconset', 'Set d\'icônes', $brto_Callback.'_iconset', $brto, $brto.'_'.$section);
		add_settings_field($brto.'_bootstrapjs', 'Boostrap Javascript', $brto_Callback.'_bootstrapjs', $brto, $brto.'_'.$section);
	
	$section = 'layout';
	add_settings_section($brto.'_'.$section, 'Structure', $brto_Callback.'_sectiontext_'.$section, $brto);
		add_settings_field($brto.'_layout_width', 'Désactiver le .container', $brto_Callback.'_layout_width', $brto, $brto.'_'.$section);
		add_settings_field($brto.'_noresponsive', 'Désactiver le "responsive"', $brto_Callback.'_noresponsive', $brto, $brto.'_'.$section);

	$section = 'fonts';
	add_settings_section($brto.'_'.$section, 'Polices', $brto_Callback.'_sectiontext_'.$section, $brto);	
		add_settings_field($brto.'_fonts_google', 'Google Fonts chargée par Webfont', $brto_Callback.'_fonts_google', $brto, $brto.'_'.$section);
		
	$section = 'colors';	
	add_settings_section($brto.'_'.$section, 'Couleurs', $brto_Callback.'_sectiontext_'.$section, $brto);
		add_settings_field($brto.'_color_bodybg', 'Couleur du body', $brto_Callback.'_color_bodybg', $brto, $brto.'_'.$section);
		
	$section = 'image';
	add_settings_section($brto.'_'.$section, 'Image', $brto_Callback.'_sectiontext_'.$section, $brto);
		add_settings_field($brto.'_image_sizes', 'Tailles d\'image', $brto_Callback.'_image_sizes', $brto, $brto.'_'.$section);
	
	$section = 'video';
	add_settings_section($brto.'_'.$section, 'Vidéo', $brto_Callback.'_sectiontext_'.$section, $brto);
		add_settings_field($brto.'_video_autoplay', 'Lecture automatique', $brto_Callback.'_video_autoplay', $brto, $brto.'_'.$section);
		add_settings_field($brto.'_video_height', 'Hauteur de l\'iframe', $brto_Callback.'_video_height', $brto, $brto.'_'.$section);
		
	$section = 'audio';
	add_settings_section($brto.'_'.$section, 'Audio', $brto_Callback.'_sectiontext_'.$section, $brto);
		add_settings_field($brto.'_audio_height', 'Hauteur de l\'iframe', $brto_Callback.'_audio_height', $brto, $brto.'_'.$section);
		
	$section = 'customtypes';
	add_settings_section($brto.'_'.$section, 'Vidéo', $brto_Callback.'_sectiontext_'.$section, $brto);
		add_settings_field($brto.'_type_clients', 'Type Clients', $brto_Callback.'_type_clients', $brto, $brto.'_'.$section);
		add_settings_field($brto.'_type_lieux', 'Type Lieux', $brto_Callback.'_type_lieux', $brto, $brto.'_'.$section);
		add_settings_field($brto.'_type_evenements', 'Type Evènements', $brto_Callback.'_type_evenements', $brto, $brto.'_'.$section);
		
	$section = 'seo';
	add_settings_section($brto.'_'.$section, 'Référencement', $brto_Callback.'_sectiontext_'.$section, $brto);
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
function brthemeoptions_backofficeCallback_sectiontext_audio() {
	echo '<p>Les options pour articles de format audio.</p>';
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
		echo (isset($S['url']) ? ' '.$S['url'] : false);
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
	echo '<input type="checkbox" value="1" name="brthemeoptions[layout_width]" id="brthemeoptions_layout_width" '.(isset($options['layout_width']) ? checked( $options['layout_width'], true, false ) : false).' /> '.__('Remplace .container par .fluidwith<br><small>Entrer ensuite vos propres règles CSS pour .fluidwith. Par exemple : .fluidwith { width:940px; margin:0 auto; }</small>', 'bodyrock').'';
}
function brthemeoptions_backofficeCallback_noresponsive() {
	$options = get_option('brthemeoptions', themeoptionsGet_default());
	echo '<input type="checkbox" value="1" name="brthemeoptions[noresponsive]" id="brthemeoptions_noresponsive" '.(isset($options['noresponsive']) ? checked( $options['noresponsive'], true, false ) : false).' /> '.__('Désactiver le "responsive".<br><small>Désactive la balise &lt;meta name="viewport" content="width=device-width, initial-scale=1.0"&gt;</small>', 'bodyrock').'';
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
	echo '<input type="checkbox" value="1" name="brthemeoptions[video_autoplay]" id="brthemeoptions_video_height" '.(isset($options['video_autoplay']) ? checked( $options['video_autoplay'], true, false ) : false).' /> '.__('Lecture automatique de la vidéo au chargement de la page', 'bodyrock').'';
}
function brthemeoptions_backofficeCallback_video_height() {
	$options = get_option('brthemeoptions', themeoptionsGet_default());
	echo '<input name="brthemeoptions[video_height]" value="'.esc_attr($options['video_height']).'" size="5" type="text" id="brthemeoptions_video_height" /> px';
}
function brthemeoptions_backofficeCallback_audio_height() {
	$options = get_option('brthemeoptions', themeoptionsGet_default());
	echo '<input name="brthemeoptions[audio_height]" value="'.esc_attr($options['audio_height']).'" size="5" type="text" id="brthemeoptions_audio_height" /> px';
}
function brthemeoptions_backofficeCallback_type_clients() {
	$options = get_option('brthemeoptions', themeoptionsGet_default());
	echo '<input type="checkbox" value="1" name="brthemeoptions[type_clients]" id="brthemeoptions_type_clients" '.(isset($options['type_clients']) ? checked( $options['type_clients'], true, false ) : false).' /> '.__('Activer', 'bodyrock').'';
}
function brthemeoptions_backofficeCallback_type_lieux() {
	$options = get_option('brthemeoptions', themeoptionsGet_default());
	echo '<input type="checkbox" value="1" name="brthemeoptions[type_lieux]" id="brthemeoptions_type_lieux" '.(isset($options['type_lieux']) ? checked( $options['type_lieux'], true, false ) : false).' /> '.__('Activer', 'bodyrock').'';
}
function brthemeoptions_backofficeCallback_type_evenements() {
	$options = get_option('brthemeoptions', themeoptionsGet_default());
	echo '<input type="checkbox" value="1" name="brthemeoptions[type_evenements]" id="brthemeoptions_type_evenements" '.(isset($options['type_evenements']) ? checked( $options['type_evenements'], true, false ) : false).' /> '.__('Activer', 'bodyrock').'';
}
function brthemeoptions_backofficeCallback_googleanalyticsid() {
	$options = get_option('brthemeoptions', themeoptionsGet_default());
	echo '<input name="brthemeoptions[google_analytics_id]" value="'.esc_attr($options['google_analytics_id']).'" type="text" id="brthemeoptions_seo" />';
	echo '<br><small class="description">'.__('Entrer votre identifiant UA-XXXXX-X', 'bodyrock').'</small>';
}
?>

