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

jQuery(document).ready(function(){
	
	// ICONS DE LA NAVBAR
	jQuery('.link_item').tooltip();

});