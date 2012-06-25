<?php

	// Larger images will be auto-cropped to fit, smaller ones will be ignored. See header.php.
	set_post_thumbnail_size( 930, 430, true );
	//add_image_size( 'large-feature', 930, 430, true );
	add_image_size( 'small-feature', 465, 215 );

if(!is_child_theme()) :

	$custom_types_to_activate = false;
	
	$styles_css=array(
					'/wp-content/themes/bodyrock/style-important.css'=>0,
					'http://fonts.googleapis.com/css?family=Russo+One'=>0,
					'/wp-content/themes/bodyrock/css/style.css'=>1,
					'/wp-content/themes/bodyrock/css/responsive.css'=>1,
					'/wp-content/themes/bodyrock/_config/js/libs/prettify/prettify.css'=>0
					);
					
	$scripts_js=array(
						'/wp-content/themes/bodyrock/_config/js/libs/less-1.3.0.min.js'=>0,
						'/wp-content/themes/bodyrock/_config/js/libs/modernizr-2.5.3-respond-1.1.0.min.js'=>0, // activer uniquement en production
						);
	
	
						
	$scripts_js_footer=array(
						'http://platform.twitter.com/widgets.js'=>0,
						'/wp-content/themes/bodyrock/_config/js/libs/jquery-1.7.1.min.js'=>0,
						'/wp-content/themes/bodyrock/_config/js/libs/prettify/prettify.js'=>0,
						'/wp-content/themes/bodyrock/_config/js/libs/bootstrap/bootstrap-transition.js'=>0,
						'/wp-content/themes/bodyrock/_config/js/libs/bootstrap/bootstrap-alert.js'=>0,
						'/wp-content/themes/bodyrock/_config/js/libs/bootstrap/bootstrap-modal.js'=>0,
						'/wp-content/themes/bodyrock/_config/js/libs/bootstrap/bootstrap-dropdown.js'=>0,
						'/wp-content/themes/bodyrock/_config/js/libs/bootstrap/bootstrap-scrollspy.js'=>0,
						'/wp-content/themes/bodyrock/_config/js/libs/bootstrap/bootstrap-tab.js'=>0,
						'/wp-content/themes/bodyrock/_config/js/libs/bootstrap/bootstrap-tooltip.js'=>0,
						'/wp-content/themes/bodyrock/_config/js/libs/bootstrap/bootstrap-popover.js'=>0,
						'/wp-content/themes/bodyrock/_config/js/libs/bootstrap/bootstrap-button.js'=>0,
						'/wp-content/themes/bodyrock/_config/js/libs/bootstrap/bootstrap-collapse.js'=>0,
						'/wp-content/themes/bodyrock/_config/js/libs/bootstrap/bootstrap-carousel.js'=>0,
						'/wp-content/themes/bodyrock/_config/js/libs/bootstrap/bootstrap-typeahead.js'=>0,
						'/wp-content/themes/bodyrock/_config/js/libs/bootstrap/application.js'=>0,
						'/wp-content/themes/bodyrock/js/script.js'=>0
						);


require '_config/_load.php';

require '_config/inc/libs/metabox.class.php';
require '_config/inc/bodyrock-metabox.php';
endif;	

?>