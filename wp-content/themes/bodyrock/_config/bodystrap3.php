<?php

if(!is_child_theme()) :

	$custom_types_to_activate = array('custom','evenements','lieux');
	
	$styles_css=array(
					'/wp-content/themes/bodystrap3/style-important.css'=>1,
					'http://fonts.googleapis.com/css?family=Londrina+Solid'=>0,
					'http://fonts.googleapis.com/css?family=Open+Sans+Condensed:700'=>0,
					'/wp-content/themes/bodystrap3/css/reset.css'=>0,
					'/wp-content/themes/bodystrap3/style.css'=>0,
					'/wp-content/themes/bodystrap3/style2.css'=>0,
					'/wp-content/themes/bodystrap3/css/smartphone.css'=>0,
					'/wp-content/themes/bodystrap3/css/tablette.css'=>0,
					'/wp-content/themes/bodystrap3/css/ecran.css'=>0,
					'/wp-content/themes/bodystrap3/css/ecranlarge.css'=>0,
					'/wp-content/themes/bodystrap3/less/style.css'=>1,
					'/wp-content/themes/bodystrap3/less/responsive.css'=>1,
					'/wp-content/themes/bodystrap3/css/helpers.css'=>0,
					'/wp-content/themes/bodystrap3/css/print.css'=>0,
					'/wp-content/themes/_config/js/libs/prettify/prettify.css'=>1,
//					get_stylesheet_uri()=>1,
					);
					
	$styles_less=array(
						'/wp-content/themes/bodystrap3/less/style.less'=>0
						);
					
	$scripts_js=array(
						'/wp-content/themes/_config/js/libs/less-1.3.0.min.js'=>0,
						'/wp-content/themes/_config/js/libs/modernizr-2.5.3-respond-1.1.0.min.js'=>0, // activer uniquement en production
						);
	
	
						
	$scripts_js_footer=array(
						'http://platform.twitter.com/widgets.js'=>1,
						'/wp-content/themes/_config/js/libs/jquery-1.7.1.min.js'=>1,
						'/wp-content/themes/_config/js/libs/prettify/prettify.js'=>1,
						'/wp-content/themes/_config/js/libs/bootstrap/bootstrap-transition.js'=>1,
						'/wp-content/themes/_config/js/libs/bootstrap/bootstrap-alert.js'=>1,
						'/wp-content/themes/_config/js/libs/bootstrap/bootstrap-modal.js'=>1,
						'/wp-content/themes/_config/js/libs/bootstrap/bootstrap-dropdown.js'=>1,
						'/wp-content/themes/_config/js/libs/bootstrap/bootstrap-scrollspy.js'=>1,
						'/wp-content/themes/_config/js/libs/bootstrap/bootstrap-tab.js'=>1,
						'/wp-content/themes/_config/js/libs/bootstrap/bootstrap-tooltip.js'=>1,
						'/wp-content/themes/_config/js/libs/bootstrap/bootstrap-popover.js'=>1,
						'/wp-content/themes/_config/js/libs/bootstrap/bootstrap-button.js'=>1,
						'/wp-content/themes/_config/js/libs/bootstrap/bootstrap-collapse.js'=>1,
						'/wp-content/themes/_config/js/libs/bootstrap/bootstrap-carousel.js'=>1,
						'/wp-content/themes/_config/js/libs/bootstrap/bootstrap-typeahead.js'=>1,
						'/wp-content/themes/_config/js/libs/bootstrap/application.js'=>1,
						'/wp-content/themes/bodystrap3/js/script.js'=>1
						);
					
require '_load.php';

require 'inc/libs/metabox.class.php';
require 'inc/bodyrock-metabox.php';
	
endif;
?>