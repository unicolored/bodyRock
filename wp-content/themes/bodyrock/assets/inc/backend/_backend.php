<?php

// WP EXTEND /////////////////////////////////////////////

/*//**//**//**//*//**//**//**//*//**//**//**//*//**//**//**/
// Chargement des fonctions en arrière plan.
/*//**//**//**//*//**//**//**//*//**//**//**//*//**//**//**/


require_once 'activation.php';  	// Fonctions lancées lors de l'activation du thème via le menu Apparence.
require_once 'debug.php';  			// Fonctions utiles au développement.
require_once 'files.php';  			// Génération de fichiers.
require_once 'htaccess.php';    	// Génération du fichier .htaccess.

add_action('do_robots', 					'robots');
add_filter('the_generator',					'no_generator');

// add to robots.txt
// http://codex.wordpress.org/Search_Engine_Optimization_for_WordPress#Robots.txt_Optimization
function robots() {
  echo "Disallow: /cgi-bin\n";
  echo "Disallow: /wp-admin\n";
  echo "Disallow: /wp-includes\n";
  echo "Disallow: /wp-content/plugins\n";
  echo "Disallow: /plugins\n";
  echo "Disallow: /wp-content/cache\n";
  echo "Disallow: /wp-content/themes\n";
  echo "Disallow: /trackback\n";
  echo "Disallow: /feed\n";
  echo "Disallow: /comments\n";
  echo "Disallow: /category/*/*\n";
  echo "Disallow: */trackback\n";
  echo "Disallow: */feed\n";
  echo "Disallow: */comments\n";
  echo "Disallow: /*?*\n";
  echo "Disallow: /*?\n";
  echo "Allow: /wp-content/uploads\n";
  echo "Allow: /assets";
}

// remove WordPress version from RSS feed
function no_generator() { return ''; }



?>