<?php
	$styles_css=array(
					'http://fonts.googleapis.com/css?family=Londrina+Solid'=>1,
					'http://fonts.googleapis.com/css?family=Open+Sans+Condensed:700'=>1,
					'/wp-content/themes/ske-unid/css/reset.css'=>1,
					'/wp-content/themes/ske-unid/style.css'=>1,
					'/wp-content/themes/ske-unid/style2.css'=>0,
					'/wp-content/themes/ske-unid/css/smartphone.css'=>1,
					'/wp-content/themes/ske-unid/css/tablette.css'=>1,
					'/wp-content/themes/ske-unid/css/ecran.css'=>1,
					'/wp-content/themes/ske-unid/css/ecranlarge.css'=>1,
					'/wp-content/themes/ske-unid/css/helpers.css'=>1,
					'/wp-content/themes/ske-unid/css/print.css'=>1,
//					get_stylesheet_uri()=>1,
					);
					
	$styles_less=array(
						'/wp-content/themes/ske-unid/less/style-custom-light.less'=>1
						);
					
	$scripts_js=array(
						'/wp-content/themes/bodyrock/js/libs/less-1.3.0.min.js'=>1,
						'/wp-content/themes/bodyrock/js/libs/modernizr-2.5.3-respond-1.1.0.min.js'=>0, // activer uniquement en production
						);
					
require '_load.php';
?>