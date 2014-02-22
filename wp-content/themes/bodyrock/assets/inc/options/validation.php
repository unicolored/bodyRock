<?php

// VALIDATION Theme options /////////////////////////////////////////////

/*//**//**//**//*//**//**//**//*//**//**//**//*//**//**//**/
// // Validation des données de formulaires
/*//**//**//**//*//**//**//**//*//**//**//**//*//**//**//**/


// THEME OPTIONS VALIDATE /////////////////////////////////////////////
function themeoptions_validation($input) {
	
	$options = get_option('brthemeoptions', themeoptionsGet_default());
	
	// REFERENCEMENT
	if (isset($input['google_analytics_id']) && $input['google_analytics_id']!='') {
		if (preg_match('/^ua-\d{4,9}-\d{1,4}$/i', $input['google_analytics_id'])) {
			$output['google_analytics_id'] = $input['google_analytics_id'];
		}
		else add_settings_error ( 'bodyrock_options', 'google_analytics_id', 'Votre ID Google Analytics doit être sous la forme UA-XXXXX-X', $type = 'error' );
	}
  
	// COMPILATION LESS
	$options['compileless_on'] = isset($input['compileless_on']) && $input['compileless_on']==1 ? true : false;
	
  	// ICON SET
	$options['iconset'] = isset($input['iconset']) ? $input['iconset'] : $defaults['iconset'];

  	// LAYOUT Width
	$options['layout_width'] = isset($input['layout_width']) ? $input['layout_width'] : $defaults['layout_width']; // 0 : fixed, 1 : fluid
	
  	// LAYOUT Noresponsive
	$options['noresponsive'] = isset($input['noresponsive']) ? $input['noresponsive'] : $defaults['noresponsive']; // 0 : fixed, 1 : fluid
	
  	// FONTS Google
	$options['fonts_google'] = isset($input['fonts_google']) ? $input['fonts_google'] : $defaults['fonts_google'];
	
  	// COLOR Bodybg
	$options['color_bodybg'] = isset($input['color_bodybg']) ? $input['color_bodybg'] : $defaults['color_bodybg']; // 0 : fixed, 1 : fluid
	
  	// IMAGE Sizes
	$options['image_sizes'] = isset($input['image_sizes']) ? $input['image_sizes'] : $defaults['image_sizes'];
	
	// VIDEO Autoplay
	$options['video_autoplay'] = isset($input['video_autoplay']) ? $input['video_autoplay'] : false;
	
	// VIDEO Height
	$options['video_height'] = isset($input['video_height']) ? $input['video_height'] : $defaults['video_height'];
	
	// AUDIO Height
	$options['audio_height'] = isset($input['audio_height']) ? $input['audio_height'] : $defaults['audio_height'];
	
	// TYPES Evenements
	$options['type_evenements'] = isset($input['type_evenements']) ? $input['type_evenements'] : $defaults['type_evenements'];
	
	// TYPES Lieux
	$options['type_lieux'] = isset($input['type_lieux']) ? $input['type_lieux'] : $defaults['type_lieux'];
	
	// ALL BS JS
	$options['allbsjs'] = isset($input['allbsjs']) && $input['allbsjs']==1 ? $input['allbsjs'] : false;
  
	return $options;
}