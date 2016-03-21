<?php

// VALIDATION Theme options /////////////////////////////////////////////

/*//**//**//**//*//**//**//**//*//**//**//**//*//**//**//**/
// // Validation des données de formulaires
/*//**//**//**//*//**//**//**//*//**//**//**//*//**//**//**/


// THEME OPTIONS VALIDATE /////////////////////////////////////////////
function themeoptions_validation($input) {

	$options = get_option('brthemeoptions', themeoptionsGet_default());

	$options['bootstrapcss'] = isset($input['bootstrapcss']) ? 1 : 0;
	$options['bootswatch'] = isset($input['bootswatch']) ? $input['bootswatch'] : $options['bootswatch'];
	$options['iconset'] = isset($input['iconset']) ? $input['iconset'] : $options['iconset'];
	$options['jquery'] = isset($input['jquery']) ? 1 : 0;
	$options['container'] = isset($input['container']) ? 1 : 0;
	$options['navbartopfixed'] = isset($input['navbartopfixed']) ? 1 : 0;
	$options['bootstrapjs'] = isset($input['bootstrapjs']) ? 1 : 0;
	$options['breadcrumb'] = isset($input['breadcrumb']) ? 1 : 0;
	$options['googleanalyticsid'] = isset($input['googleanalyticsid']) ? $input['googleanalyticsid'] : false;

	return $options;
}
