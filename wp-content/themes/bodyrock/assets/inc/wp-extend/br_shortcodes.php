<?php


// CHESS EMBEDDED //////////////////////////////////////////////////
// Se charge uniquement si embed-chessboard est trouvé dans la liste des plugins activés
$plugins = get_option('active_plugins');
foreach($plugins as $k=>$v) {
	$plugin = explode('/',$v);
	if(!in_array($plugin[0],array('embed-chessboard'))) {
		require_once 'shortcodes/chess_embedded.php'; // On charge le shortcodes qui permet d'ajouter ses pgn dans les pages
	}
}

// LINKS EMBEDDED //////////////////////////////////////////////////
require_once 'shortcodes/links_embedded.php';     // shortcodes

// TEMPLATE1 EMBEDDED //////////////////////////////////////////////////
require_once 'shortcodes/template1_embedded.php';     // shortcodes

// SOUND EMBEDDED //////////////////////////////////////////////////
require_once 'shortcodes/sounds_embedded.php';     // shortcodes

// VIDEOS EMBEDDED //////////////////////////////////////////////////
require_once 'shortcodes/videos_embedded.php';     // shortcodes
?>