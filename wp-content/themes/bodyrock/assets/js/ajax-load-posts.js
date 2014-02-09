// Thanks to http://www.problogdesign.com/wordpress/load-next-wordpress-posts-with-ajax/
// By Michael Martin

jQuery(document).ready(function($) {

	// The number of the next page to load (/page/x/).
	var pageNum = parseInt(pbd_alp.startPage) + 1;
	
	// The maximum number of pages the current query can return.
	var max = parseInt(pbd_alp.maxPages);
	
	// The link of the next page of posts.
	var nextLink = pbd_alp.nextLink;
	
	var loadBtn = pbd_alp.loadBtn;
	var loadText = pbd_alp.loadText;
	var loadNomore = pbd_alp.loadNomore;
	
	/**
	 * Replace the traditional navigation with our own,
	 * but only if there is at least one page of new posts to load.
	 */
	if(pageNum <= max) {
		// Insert the "More Posts" link.
		$('section.content')
			.append('<div class="pbd-alp-placeholder-'+ pageNum +'"></div>')
			.append('<button id="pbd-alp-load-posts" class="btn btn-sm btn-default visible-xs">'+loadBtn+'</button>');
	}
	
	
	/**
	 * Load new posts when the link is clicked.
	 */
	$('#pbd-alp-load-posts').click(function() {
	
		// Are there more posts to load?
		if(pageNum <= max) {
		
			// Show that we're working.
			$(this).text(loadText);
			alert(nextLink);
			$('.pbd-alp-placeholder-'+ pageNum).load(nextLink + ' .col-lg-3',
				function() {
					// Update page number and nextLink.
					pageNum++;
					nextLink = nextLink.replace(/\/page\/[0-9]?/, '/page/'+ pageNum);
					
					// Add a new placeholder, for when user clicks again.
					$('#pbd-alp-load-posts')
						.before('<div class="pbd-alp-placeholder-'+ pageNum +'"></div>')
					
					// Update the button message.
					if(pageNum <= max) {
						$('#pbd-alp-load-posts').text(loadBtn);
					} else {
						$('#pbd-alp-load-posts').text(loadNomore);
					}
				}
			);
		} else {
			$('#pbd-alp-load-posts a').append('.');
		}	
		
		return false;
	});
});