<?php
// Wordpress Theme Configuration, Modifications

//////// CONFIGURATION DES EMPLACEMENTS DE MENUS
register_nav_menu( 'primary', __( 'Menu principal (primary)', 'bodyrock' ) );
register_nav_menu( 'secondary', __( 'Menu secondaire (secondary)', 'bodyrock' ) );
register_nav_menu( 'sidebar', __( 'Menu latéral (sidebar)', 'bodyrock' ) );
register_nav_menu( 'footer', __( 'Menu de bas de page (footer)', 'bodyrock' ) );
///////////////////////////////////////////////////////////////////////////////////////

//////// CONFIGURATION DES TAILLES POUR LES MEDIAS
// Ces tailles de vignettes sont entrées manuellement
// Ici je n'utilise pas (encore) l'option du thème BR_IMAGE_SIZES
// Medias par défaut : 180x180 crop, 512x512 proportional, 800x800 proportional
//add_image_size( 'vignette', 324, 224, true ); // 1.44
//add_image_size( 'twitter', 1024, 512, true ); // 2
//add_image_size( 'carre', 400, 400, true ); // 2
//add_image_size( 'vertical', 533, 800, true ); // 2
//add_image_size( 'hd', 1280, 720, true ); // 1.77
//add_image_size( 'bg', 1366, 768, true ); // 1.77
//add_image_size( 'facebook', 1200, 628, true ); // 1.91
//add_image_size( 'linkedin', 800, 800, true ); // 1
//add_image_size( 'google', 800, 1200, true ); // 0.66
//add_image_size( 'pinterest', 735, 1102, true ); // 0.66
set_post_thumbnail_size( 280, 210, true ); // Normal post thumbnails
add_image_size( 'screen-shot', 720, 540 ); // Full size screen
$options = get_option('brthemeoptions', themeoptionsGet_default());

if ( $options['image_sizes'] != false ) {
	$IS = explode(';',$options['image_sizes']);
	foreach ($IS as $I) {
		$S = explode(',',$I);
		add_image_size( $S[0], $S[1], $S[2], $S[3] == 1 ? true : false );
	}
}

///////////////////////////////////////////////////////////////////////////////////////

// AJOUTS RELATIFS à THEME CHECK
if ( ! isset( $content_width ) ) $content_width = 900;

///////////////////////////////////////////////////////////////////////////////////////

// THEME SUPPORT : add or remove
/*
'post-formats'
'post-thumbnails'
'custom-background'
'custom-header'
'automatic-feed-links'
'html5'
'title-tag'
'menus'
*/

add_theme_support( "custom-background", false );
add_theme_support( "custom-header", false );
add_theme_support( "html5", array( 'search-form' ) );
add_theme_support( "post-formats", array('aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat'));
add_theme_support( 'post-thumbnails' );
add_theme_support( "title-tag" );
if (defined(AUTOMATICFEEDLINKS)) {
  add_theme_support( 'automatic-feed-links' );
}
else {
  remove_theme_support( 'automatic-feed-links' );
}

 ?>
