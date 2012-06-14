<?php
if(!is_child_theme()) :

	$custom_types_to_activate = array('custom','evenements','lieux');
	
	$styles_css=array(
						'/wp-content/themes/bodyrock/less/style.less'=>1,
						'/wp-content/themes/bodyrock/style.css'=>1
						);
						
	$scripts_js=array(
						'/wp-content/themes/bodyrock/js/libs/less-1.3.0.min.js'=>1,
						'/wp-content/themes/bodyrock/js/libs/modernizr-2.5.3-respond-1.1.0.min.js'=>0, // activer uniquement en production
						);
						
	$scripts_js_footer=array(
						'/wp-content/themes/bodyrock/js/libs/jquery-1.7.1.min.js'=>1,
						'https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js'=>0,
						'/wp-content/themes/bodyrock/js/script.js'=>1
						);
	
	require '_load.php';
	
endif;
?>