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

alert('<?php echo $_SESSION['instance'] ?>');
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

	/*var myLoader = 'http://unicolored.com/wp-content/themes/bodyrock/assets/tpl/parts/loader.php';
	jQuery.get(myLoader, function(loader)
	{
	   jQuery('<div class="loader">')
		  .html(loader)
		  .appendTo("aside.aside");
	});*/

	jQuery.getScript('http://unicolored.com/wp-content/themes/bodyrock/assets/js/libs/unid.js?v=1.0.0', function() { });

	// Chargement des scripts supplémentaires
	var myVideoJsStyle = 'http://unicolored.com/wp-content/themes/bodyrock/assets/js/libs/video-js/video-js.css?ver=3.8';

	jQuery('<link rel="stylesheet" type="text/css" href="'+myVideoJsStyle+'" >').appendTo("head");
	
	jQuery.getScript('http://unicolored.com/wp-content/themes/bodyrock/assets/js/libs/video-js/video.js?ver=4.3.0', function() { });
	
	jQuery.getScript('//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js?ver=3.0.0', function() { });	
	
	jQuery.getScript('https://s7.addthis.com/js/300/addthis_widget.js?ver=3.8#pubid=unicolored', function() { });
	
	jQuery.getScript('http://unicolored.com/wp-content/themes/rock-unicolored/js/script.js?ver=1.0.0', function() { });


	
	// Chargement des lecteurs vidéos par défaut
	// AFFICHAGE DES VIDEOS Si le conteneur identifié est trouvé
	if(jQuery('#singlevideoyou').length>0) { // Youtube
        jQuery('#singlevideoyou').html('<iframe width="100%" height="500" style="height:500px" class="img-responsive" src="//www.youtube.com/embed/'+(jQuery('#singlevideoyou').attr('class').replace('code_', ''))+'?rel=0&amp;autoplay=0&related=0" frameborder="0" allowfullscreen></iframe>');
    }
	if(jQuery('#singlevideovim').length>0) { // Vimeo
        jQuery('#singlevideovim').html('<iframe src="//player.vimeo.com/video/'+(jQuery('#singlevideovim').attr('class').replace('code_', ''))+'?badge=0&amp;color=db0000&amp;autoplay=0" class="col-lg-12" height="500" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>');
    }
	
	// ICONS DE LA NAVBAR
	if(jQuery('.link_item').length>0) {
		jQuery('.link_item').tooltip();
	}
});