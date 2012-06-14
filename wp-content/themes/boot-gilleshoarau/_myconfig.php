<?php


//	$custom_types_to_activate = array('projet');
	
	$styles_css=array(
					'/wp-content/themes/boot-gilleshoarau/style-important.css'=>0,
					'http://fonts.googleapis.com/css?family=Russo+One'=>0, // Sans serif
					'http://fonts.googleapis.com/css?family=Righteous'=>1, // Cursive
					'/wp-content/themes/boot-gilleshoarau/css/style.css'=>1,
					'/wp-content/themes/boot-gilleshoarau/css/style-suite.css'=>1,
					'/wp-content/themes/boot-gilleshoarau/css/responsive.css'=>1,
					'/wp-content/themes/boot-gilleshoarau/_config/js/libs/prettify/prettify.css'=>0,
//					get_stylesheet_uri()=>1,
					);
					
	$styles_less=array(
						'/wp-content/themes/bodystrap4/less/style.less'=>0
						);
					
	$scripts_js=array(
						'/wp-content/themes/bodystrap4/_config/js/libs/less-1.3.0.min.js'=>0,
						'/wp-content/themes/bodystrap4/_config/js/libs/modernizr-2.5.3-respond-1.1.0.min.js'=>0, // activer uniquement en production
						);
	
	
						
	$scripts_js_footer=array(
						'http://platform.twitter.com/widgets.js'=>0,
						'/wp-content/themes/bodystrap4/_config/js/libs/jquery-1.7.1.min.js'=>1,
						'/wp-content/themes/bodystrap4/_config/js/libs/prettify/prettify.js'=>0,
						'/wp-content/themes/bodystrap4/_config/js/libs/bootstrap/bootstrap-transition.js'=>1,
						'/wp-content/themes/bodystrap4/_config/js/libs/bootstrap/bootstrap-alert.js'=>0,
						'/wp-content/themes/bodystrap4/_config/js/libs/bootstrap/bootstrap-modal.js'=>0,
						'/wp-content/themes/bodystrap4/_config/js/libs/bootstrap/bootstrap-dropdown.js'=>0,
						'/wp-content/themes/bodystrap4/_config/js/libs/bootstrap/bootstrap-scrollspy.js'=>0,
						'/wp-content/themes/bodystrap4/_config/js/libs/bootstrap/bootstrap-tab.js'=>0,
						'/wp-content/themes/bodystrap4/_config/js/libs/bootstrap/bootstrap-tooltip.js'=>0,
						'/wp-content/themes/bodystrap4/_config/js/libs/bootstrap/bootstrap-popover.js'=>0,
						'/wp-content/themes/bodystrap4/_config/js/libs/bootstrap/bootstrap-button.js'=>0,
						'/wp-content/themes/bodystrap4/_config/js/libs/bootstrap/bootstrap-collapse.js'=>0,
						'/wp-content/themes/bodystrap4/_config/js/libs/bootstrap/bootstrap-carousel.js'=>1,
						'/wp-content/themes/bodystrap4/_config/js/libs/bootstrap/bootstrap-typeahead.js'=>0,
						'/wp-content/themes/bodystrap4/_config/js/libs/bootstrap/application.js'=>0,
						'/wp-content/themes/bodystrap4/js/colorbox/jquery.colorbox-min.js'=>1,
						'/wp-content/themes/bodystrap4/js/jQueryRotate.2.2.js'=>1,
						'/wp-content/themes/boot-gilleshoarau/js/script.js'=>1,
						'/wp-content/themes/boot-gilleshoarau/js/wheel.js'=>1
						);

require ABSPATH.'/wp-content/themes/'.get_template().'/_config/_load.php';

require ABSPATH.'/wp-content/themes/'.get_template().'/_config/inc/libs/metabox.class.php';
require ABSPATH.'/wp-content/themes/'.get_template().'/_config/inc/bodyrock-metabox.php';
	
?>