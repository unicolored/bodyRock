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

jQuery(document).ready(function(){


// CAROUSEL // TOFIX : changer la classe en fonction de l'identifiant du widget + mettre en option l'intervalle de temps
	var duration = sc_val.duration;	
	var carouselname = sc_val.carouselname;	
	if(jQuery('.'+carouselname).length>0) {
		jQuery('.'+carouselname).carousel({
		  interval: duration
		});
		jQuery('.'+carouselname+'-control').show();
	}
});