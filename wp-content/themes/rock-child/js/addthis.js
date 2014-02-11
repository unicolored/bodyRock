
  /*addthis.layers({
    'theme' : 'transparent',
    'share' : {
      'position' : 'left',
      'numPreferredServices' : 5
    }, 
    'follow' : {
      'services' : [
        {'service': 'twitter', 'id': 'unicolored'}
      ]
    },  
    'whatsnext' : {},  
    'recommended' : {} 
  });
  */
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