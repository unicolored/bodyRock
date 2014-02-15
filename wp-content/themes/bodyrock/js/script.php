<?php
session_start();
//header('Content-Description: File Transfer');
header('Content-Type: application/javascript');
//header('Content-Disposition: attachment; filename='.basename($file));
header('Expires: 0');
//header('Cache-Control: must-revalidate');
header('Pragma: public');
//header('Content-Length: ' . filesize($file));

?>

// CHARGEMENT DES FONTS
	WebFontConfig = {
		google: {
		  families: [ 'Doppio+One::latin', 'Roboto+Slab::latin', 'Open+Sans::latin', 'Ubuntu::latin' ]
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

//Réécriture de getscript pour activer le cache des fichiers chargés.
// cache = true pour activation
jQuery.getScript = function(url, callback, cache){
  jQuery.ajax({
    type: "GET",
    url: url,
    success: callback,
    dataType: "script",
    cache: cache
  });
};

jQuery(document).ready(function(){

	var myLoader = 'http://unicolored.com/wp-content/themes/bodyrock/assets/tpl/parts/loader-progressbar.php';
	
	jQuery
	.get(myLoader, function(loader) {
	
		jQuery('<div id="loader" class="hidden">').html(loader).appendTo(".loader");
		
		<?php
		$S = explode('//',$_SESSION['ajax-widgets']);
		
		foreach($S as $A) {
			if($A!=false) {
			?>
			
			// The link of the next page of posts.
			var nextLink = 'http://unicolored.com/?instance=<?php echo $_SESSION[$A] ?>&args=<?php echo $_SESSION['args-'.$A] ?>';
			
		<?php // echo '.holder-'.$A; ?>
//			jQuery('.holder-<?php echo $A; ?>').hide();
			jQuery('.holder-<?php echo $A; ?>').html(loader).load(nextLink + " #<?php echo str_replace('ajax-widget-','',$A); ?>",
				function(response, status, xhr) {
			
					
					jQuery('#<?php echo str_replace('ajax-widget-','',$A); ?>').hide().fadeIn(500);
				}
			);
			
			<?php
			}
		} ?>
		
	})		
	.done(function() { 					jQuery(".progress-bar").css("width","25%").animate({'width' : '100%'},200,function(){ jQuery(this).parent().fadeOut(1000) });  })
	.fail(function() {  })
	.always(function() {  });
	/*
	jQuery.get( "ajax/test.html", function( data ) {
		jQuery( ".result" ).html( data );
		alert( "Load was performed." );
	});*/

	jQuery.getScript('http://senzu.fr/bodyrock/js/unid.js?v=1.0.1', function() { }, true);

	// Chargement des scripts supplémentaires

	var path_to_theme = sc_val.path_to_theme;	
	jQuery.getScript(path_to_theme+'assets/js/libs/video-js/video.js?ver=4.3.0', function() { }, true);
	
//	jQuery.getScript('//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js?ver=3.0.1', function() { }, true);	
	
	jQuery.getScript('https://s7.addthis.com/js/300/addthis_widget.js?ver=3.8#pubid=unicolored', function() { }, true);
	
	var path_to_child_theme = sc_val.path_to_child_theme;
	jQuery.getScript(path_to_child_theme+'js/script.js?ver=1.0.0', function() { }, true);


	
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