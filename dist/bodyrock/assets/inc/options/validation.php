<?php

// VALIDATION Theme options /////////////////////////////////////////////

/*//**//**//**//*//**//**//**//*//**//**//**//*//**//**//**/
// // Validation des données de formulaires
/*//**//**//**//*//**//**//**//*//**//**//**//*//**//**//**/


// THEME OPTIONS VALIDATE /////////////////////////////////////////////
function themeoptions_validation($input) {

	$options = get_option('brthemeoptions', themeoptionsGet_default());

    // GOOGLE ANALYTICS ID
    $options['google_analytics_id'] = isset($input['google_analytics_id']) ? $input['google_analytics_id'] : $defaults['google_analytics_id'];

  	// ICON SET
	$options['iconset'] = isset($input['iconset']) ? $input['iconset'] : $defaults['iconset'];

  	// FONTS Google
	$options['fonts_google'] = isset($input['fonts_google']) ? $input['fonts_google'] : $defaults['fonts_google'];

  	// IMAGE Sizes
	$options['image_sizes'] = isset($input['image_sizes']) ? $input['image_sizes'] : $defaults['image_sizes'];

	// TYPES Clients
	$options['type_clients'] = isset($input['type_clients']) ? $input['type_clients'] : $defaults['type_clients'];

	// TYPES Evenements
	$options['type_evenements'] = isset($input['type_evenements']) ? $input['type_evenements'] : $defaults['type_evenements'];

	// TYPES Lieux
	$options['type_lieux'] = isset($input['type_lieux']) ? $input['type_lieux'] : $defaults['type_lieux'];

	// ALL BS JS
	$options['allbsjs'] = isset($input['allbsjs']) && $input['allbsjs']==1 ? $input['allbsjs'] : false;

	return $options;
}
