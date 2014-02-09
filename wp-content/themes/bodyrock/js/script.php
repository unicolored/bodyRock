<?php
require_once("../../../../wp-load.php");

//header('Content-Description: File Transfer');
header('Content-Type: application/javascript');
//header('Content-Disposition: attachment; filename='.basename($file));
header('Expires: 0');
//header('Cache-Control: must-revalidate');
header('Pragma: public');
//header('Content-Length: ' . filesize($file));

$options = get_option('brthemeoptions');

$FG = explode(';',$options['fonts_google']);
$i=0;
$families = '';
foreach ($FG as $F) {
	$families .= ($i>0 ? ', ' : false)."'".$F."'";
	$i++;
}
?>


// CHARGEMENT DES FONTS
	WebFontConfig = {
		google: {
		  families: [ <?php echo $families; ?> ]
		}
	};
	
	(function() {
		var wf = document.createElement('script');
		wf.src = ('https:' == document.location.protocol ? 'https' : 'http') +
			'://ajax.googleapis.com/ajax/libs/webfont/1.5.0/webfont.js';
		wf.type = 'text/javascript';
		wf.async = 'true';
		var s = document.getElementsByTagName('script')[0];
		s.parentNode.insertBefore(wf, s);
	})();


/* Author: Gilles Hoarau */

jQuery(document).ready(function(){
	
	// ICONS DE LA NAVBAR
	jQuery('.link_item').tooltip();

});

// VIDEO JS FallBack : active le lecteur flash si le html5 n'est pas utilisé
videojs.options.flash.swf = "/wp-content/themes/bodyrock/assets/js/video-js/video-js.swf";