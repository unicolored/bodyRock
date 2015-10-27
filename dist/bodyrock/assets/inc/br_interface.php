<?php

// INTERFACE /////////////////////////////////////////////

/*//**//**//**//*//**//**//**//*//**//**//**//*//**//**//**/
// Génération d'éléments Html utiles au thème.
// Ces fonctions sont "overridable" par le thème enfant.
/*//**//**//**//*//**//**//**//*//**//**//**//*//**//**//**/



////// WP_NAV_MENU /////////////////////////////////////////////
////// Fonction fallback_cb pour un menu si il est vide.
// Fonction appellée en paramètre de wp_nav_menu(array('fallback_cb'=>'default_menu'))
// Ci-desso
function default_menu($args) {
      echo '
      <ul class="nav navbar-nav">
        <li'.(is_home() ? ' class="active"' : false).'><a href="/">Home</a></li>
      </ul>
      ';
      return true;
}

function br_paging_nav() {
	// Copie de la fonction twentyfourteen_paging_nav()
	// Don't print empty markup if there's only one page.
	if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
		return;
	}

	$paged        = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
	$pagenum_link = html_entity_decode( get_pagenum_link() );
	$query_args   = array();
	$url_parts    = explode( '?', $pagenum_link );

	if ( isset( $url_parts[1] ) ) {
		wp_parse_str( $url_parts[1], $query_args );
	}

	$pagenum_link = remove_query_arg( array_keys( $query_args ), $pagenum_link );
	$pagenum_link = trailingslashit( $pagenum_link ) . '%_%';

	$format  = $GLOBALS['wp_rewrite']->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
	$format .= $GLOBALS['wp_rewrite']->using_permalinks() ? user_trailingslashit( 'page/%#%', 'paged' ) : '?paged=%#%';

	// Set up paginated links.
	$links = paginate_links( array(
		'base'     => $pagenum_link,
		'format'   => $format,
		'total'    => $GLOBALS['wp_query']->max_num_pages,
		'current'  => $paged,
		'mid_size' => 2,
		'add_args' => array_map( 'urlencode', $query_args ),
		'prev_text' => __( '&laquo;', 'bodyrock' ),
		'next_text' => __( '&raquo;', 'bodyrock' ),
		'type' => 'list'
	) );

	if ( $links ) :
	?>
	<ul class="pagination pagination-lg" role="navigation">
		<h1 class="sr-only"><?php _e( 'Posts navigation', 'bodyrock' ); ?></h1>
		<?php
		$links = str_replace("<ul class='page-numbers'>","",$links);
		$links = str_replace('</ul>',"",$links);
		$links = str_replace(" class='page-numbers'","",$links);
		$links = str_replace("><span class='page-numbers current'>" , " class='active'><span>" , $links);
		$links = str_replace('><span class="page-numbers dots">' , " class='disabled'><span>" , $links);
		echo $links;
		?>
	</ul><!-- .navigation -->

	<?php
	endif;
}

?>
