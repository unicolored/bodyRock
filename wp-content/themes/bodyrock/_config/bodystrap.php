<?php

if(!is_child_theme()) :

	$custom_types_to_activate = array('custom','evenements','lieux');
	
	$styles_css=array(
					'http://fonts.googleapis.com/css?family=Londrina+Solid'=>0,
					'http://fonts.googleapis.com/css?family=Open+Sans+Condensed:700'=>0,
					'/wp-content/themes/bodystrap/css/reset.css'=>0,
					'/wp-content/themes/bodystrap/style.css'=>0,
					'/wp-content/themes/bodystrap/style2.css'=>0,
					'/wp-content/themes/bodystrap/css/smartphone.css'=>0,
					'/wp-content/themes/bodystrap/css/tablette.css'=>0,
					'/wp-content/themes/bodystrap/css/ecran.css'=>0,
					'/wp-content/themes/bodystrap/css/ecranlarge.css'=>0,
					'/wp-content/themes/bodystrap/less/style.css'=>1,
					'/wp-content/themes/bodystrap/css/helpers.css'=>0,
					'/wp-content/themes/bodystrap/css/print.css'=>0,
//					get_stylesheet_uri()=>1,
					);
					
	$styles_less=array(
						'/wp-content/themes/bodystrap/less/style.less'=>0
						);
					
	$scripts_js=array(
						'/wp-content/themes/_config/js/libs/less-1.3.0.min.js'=>0,
						'/wp-content/themes/_config/js/libs/modernizr-2.5.3-respond-1.1.0.min.js'=>0, // activer uniquement en production
						);
					
require '_load.php';
	
endif;
?>