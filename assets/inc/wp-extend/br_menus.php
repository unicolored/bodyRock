<?php

// MENUS Wp extend ///////////////////////////////////////////// WP EXTEND

/*//**//**//**//*//**//**//**//*//**//**//**//*//**//**//**/


////// POSITIONS /////////////////////////////////////////////
////// Ajout de deux positions au thème
register_nav_menu( 'primary', __( 'Menu principal (primary)', 'bodyrock' ) );
register_nav_menu( 'footer', __( 'Menu de bas de page (footer)', 'bodyrock' ) );

/*

register_nav_menu( 'identifiant_du_menu', 'Titre du menu' );
:: Ajoute une position pour les menus personnalisés via Wordpress.
:: Utilisation dans une template :
wp_nav_menu( array(
	'menu'       => 'identifiant_du_menu',
	'theme_location' => 'identifiant_du_menu',
	'depth'      => 1,
	'container'  => false,
	'menu_class' => 'nav navbar-nav',
	'fallback_cb' => 'br_menu_default',
	'walker' => new walker_de_votre_choix())
)
:: wp_nav_menu() affiche le menu enregistré à la position 'identifiant_du_menu' via Wordpress.
:: Si aucun menu n'est enregistré à cette position, la fonction br_menu_default() est lancée.
:: Le rendu des éléments peut être personnalisé via une fonction 'walker'.

*/

////// WALKERS /////////////////////////////////////////////
////// Chargement des différents walkers personnalisés
require_once('walkers/navbar_walker.php');
require_once('walkers/listgroup_walker.php');
require_once('walkers/tabs_walker.php');

/*

Un 'walker' parcoure les éléments du menu et permet de personnaliser la sortie Html.
Les différents walkers ci-dessus servent à reproduire les composants Bootstrap.

*/