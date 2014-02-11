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

jQuery(document).ready(function() {    

	// ICONS DE LA NAVBAR
	jQuery('.link_item').tooltip();

    // Edition du breadcrumb
/*    jQuery('.breadcrumb li:last').remove();
    var lastli_text = jQuery('.breadcrumb li:last a').text();

    if(lastli_text.length=0) { jQuery('.breadcrumb li:last').addClass('active').find('a').remove(); }
    jQuery('.breadcrumb li.active').text(lastli_text);*/

	// AFFICHAGE DES VIDEOS Si le conteneur identifié est trouvé
	if(jQuery('#singlevideoyou').length>0) { // Youtube
        jQuery('#singlevideoyou').html('<iframe width="100%" height="500" style="height:500px" class="img-responsive" src="//www.youtube.com/embed/'+(jQuery('#singlevideoyou').attr('class').replace('code_', ''))+'?rel=0&amp;autoplay=1&related=0" frameborder="0" allowfullscreen></iframe>');
    }
	if(jQuery('#singlevideovim').length>0) { // Vimeo
        jQuery('#singlevideovim').html('<iframe src="//player.vimeo.com/video/'+(jQuery('#singlevideovim').attr('class').replace('code_', ''))+'?badge=0&amp;color=db0000&amp;autoplay=1" class="col-lg-12" height="500" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>');
    }
	
	if(jQuery('article.home-aside').length>0) {
        jQuery('article.home-aside').mouseover(function() { jQuery(this).find('header').removeClass('hide') }).mouseleave(function() { jQuery(this).find('header').addClass('hide') });
    }
    
	// MAILCHIMP FORM
	if(jQuery('input.mc_input').length>0) {
        jQuery('input.mc_input').addClass('form-control');
    }
	if(jQuery('input#mc_signup_submit').length>0) {
        jQuery('input#mc_signup_submit').addClass('btn btn-primary');
    }
	
	// CAROUSEL
	if(jQuery('.carousel').length>0) {
		jQuery('.carousel').carousel({
		  interval: 4000
		});
        jQuery('.carousel-control').show();
    }	
});

// ADDTHIS
  var addthis_config = {"data_track_addressbar":false,"ui_use_css":true};
  
  var addthis_share = {
		 url_transforms : {
			  shorten: {
				   twitter: 'bitly',
				   facebook: 'bitly',
				   google: 'bitly',
				   pinterest: 'bitly'
			  }
		 }, 
		 shorteners : {
			  bitly : {} 
		 }
	}
	
// ANALYTICS

var _gaq = _gaq || [];
_gaq.push(['_setAccount', 'UA-67465-18']);
_gaq.push(['_setDomainName', 'unicolored.com']);
_gaq.push(['_trackPageview']);

(function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
})();
		