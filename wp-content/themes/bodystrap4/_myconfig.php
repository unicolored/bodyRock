<?php

if(!is_child_theme()) :

	$custom_types_to_activate = array('custom','evenements','lieux');
	
	$styles_css=array(
					'/wp-content/themes/bodystrap4/style-important.css'=>1,
					'http://fonts.googleapis.com/css?family=Russo+One'=>1,
					'/wp-content/themes/bodystrap4/less/style.css'=>1,
					'/wp-content/themes/bodystrap4/less/responsive.css'=>1,
					'/wp-content/themes/bodystrap4/_config/js/libs/prettify/prettify.css'=>1,
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
						'/wp-content/themes/bodystrap4/_config/js/libs/prettify/prettify.js'=>1,
						'/wp-content/themes/bodystrap4/_config/js/libs/bootstrap/bootstrap-transition.js'=>1,
						'/wp-content/themes/bodystrap4/_config/js/libs/bootstrap/bootstrap-alert.js'=>1,
						'/wp-content/themes/bodystrap4/_config/js/libs/bootstrap/bootstrap-modal.js'=>1,
						'/wp-content/themes/bodystrap4/_config/js/libs/bootstrap/bootstrap-dropdown.js'=>1,
						'/wp-content/themes/bodystrap4/_config/js/libs/bootstrap/bootstrap-scrollspy.js'=>1,
						'/wp-content/themes/bodystrap4/_config/js/libs/bootstrap/bootstrap-tab.js'=>1,
						'/wp-content/themes/bodystrap4/_config/js/libs/bootstrap/bootstrap-tooltip.js'=>1,
						'/wp-content/themes/bodystrap4/_config/js/libs/bootstrap/bootstrap-popover.js'=>1,
						'/wp-content/themes/bodystrap4/_config/js/libs/bootstrap/bootstrap-button.js'=>1,
						'/wp-content/themes/bodystrap4/_config/js/libs/bootstrap/bootstrap-collapse.js'=>1,
						'/wp-content/themes/bodystrap4/_config/js/libs/bootstrap/bootstrap-carousel.js'=>1,
						'/wp-content/themes/bodystrap4/_config/js/libs/bootstrap/bootstrap-typeahead.js'=>1,
						'/wp-content/themes/bodystrap4/_config/js/libs/bootstrap/application.js'=>1,
						'/wp-content/themes/bodystrap4/js/script.js'=>0,
						'/wp-content/themes/bodystrap4/js/script.js'=>1
						);


require '_config/_load.php';

require '_config/inc/libs/metabox.class.php';
require '_config/inc/bodyrock-metabox.php';
endif;	

?>