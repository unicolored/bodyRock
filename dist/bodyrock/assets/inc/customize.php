<?php

// CUSTOMIZE /////////////////////////////////////////////
require 'customize-backend.php';

///////////// FRONTEND :

// HEAD
// On retire les liens xml vers les fichiers permettant l'édition par Live Writer
remove_action('wp_head', 'wp_shortlink_wp_head');
remove_action( 'wp_head', 'feed_links_extra', 3 ); // Display the links to the extra feeds such as category feeds
remove_action( 'wp_head', 'feed_links', 2 ); // Display the links to the general feeds: Post and Comment Feed
remove_action( 'wp_head', 'rsd_link' ); // Display the link to the Really Simple Discovery service endpoint, EditURI link
remove_action( 'wp_head', 'wlwmanifest_link' ); // Display the link to the Windows Live Writer manifest file.
remove_action( 'wp_head', 'index_rel_link' ); // index link
remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 ); // prev link
remove_action( 'wp_head', 'start_post_rel_link', 10, 0 ); // start link
remove_action( 'wp_head', 'adjacent_posts_rel_link', 10, 0 ); // Display relational links for the posts adjacent to the current post.
remove_action( 'wp_head', 'wp_generator' ); // Display the XHTML generator that is generated on the wp_head hook, WP version

/* Remove EMOJI */
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );


function twentyten_remove_recent_comments_style() {
	global $wp_widget_factory;
	remove_action( 'wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ) );
}
add_action( 'widgets_init', 'twentyten_remove_recent_comments_style' );

add_action('wp_head','html5_shim_respond');
function html5_shim_respond() {
	$output="\t".'
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries. All other JS at the end of file. -->
  <!-- [if lt IE 9]>
  <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js"></script>
  <![endif]-->
  '."\n";
	echo $output;
}
add_action('wp_head','meta_author');
function meta_author() {
	$output="\t".'<meta name="author" content="Gilles Hoarau">'."\n";
	echo $output;
}
add_action('wp_head','link_shortcut_icon');
function link_shortcut_icon() {
	$output="\t".'<link rel="shortcut icon" href="'.get_stylesheet_directory_uri().'/img/ico/favicon.ico">'."\n"."\n";
	echo $output;
}


/*//**//**//**//*//**//**//**//*//**//**//**//*//**//**//**/
// Personnalisation de Wordpress.
/*//**//**//**//*//**//**//**//*//**//**//**//*//**//**//**/
// MODIFICATION DU MENU wp_page_menu pour une intégration dans la navbar
add_filter ( 'wp_page_menu', 'br_page_menu', 100 );
function br_page_menu($menu) {
  /*
  ORIGINAL : "<div class="menu"><ul><li class="page_item page-item-2"><a href="http://emailing.fromscratch.xyz/page-d-exemple/">Page d&rsquo;exemple</a></li></ul></div>"
  */
  $menu = str_replace('<div class="menu">','',$menu);
  $menu = str_replace('</div>','',$menu);
  $menu = str_replace('<ul>','<ul class="nav navbar-nav">',$menu);
  return $menu;
}




?>
