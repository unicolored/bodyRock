// Thanks to http://www.problogdesign.com/wordpress/load-next-wordpress-posts-with-ajax/
// By Michael Martin

jQuery(document).ready(function($) {


	var widgetclass = pbd_alp.widgetclass;
	var instance = pbd_alp.instance;
	// The link of the next page of posts.
	var nextLink = 'http://unicolored.com/?instance='+instance;
	
	var varhtml = jQuery('.loader').html();

	$('.widget-ajax-load').html(varhtml).load(nextLink + " ."+widgetclass+"",
		function() {
			
		}
	);
	
});