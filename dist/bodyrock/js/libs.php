
<?php
//header('Content-Description: File Transfer');
header('Content-Type: application/javascript');
//header('Content-Disposition: attachment; filename='.basename($file));
header('Expires: 0');
//header('Cache-Control: must-revalidate');
header('Pragma: public');
//header('Content-Length: ' . filesize($file));

?>



jQuery.getScript('http://senzu.fr/bodyrock/js/unid.js?v=1.0.1', function() { }, true);

// Chargement des scripts supplémentaires

var path_to_theme = sc_val.path_to_theme;	
jQuery.getScript(path_to_theme+'assets/js/libs/video-js/video.js?ver=4.3.0', function() { }, true);

jQuery.getScript('//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js?ver=3.0.1', function() { }, true);	

jQuery.getScript('https://s7.addthis.com/js/300/addthis_widget.js?ver=3.8#pubid=unicolored', function() { }, true);

var path_to_child_theme = sc_val.path_to_child_theme;
jQuery.getScript(path_to_child_theme+'js/script.js?ver=1.0.0', function() { }, true);
