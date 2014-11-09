<?php

// INTERFACE /////////////////////////////////////////////

/*//**//**//**//*//**//**//**//*//**//**//**//*//**//**//**/
// Génération d'éléments Html utiles au thème.
// Ces fonctions sont "overridable" par le thème enfant.
/*//**//**//**//*//**//**//**//*//**//**//**//*//**//**//**/


// MENU DEFAULT /////////////////////////////////////////////
// Affiche un menu simple par défaut lorsque le thème n'a pas de menu déclaré
if(!function_exists('br_menu_default')) { // Permet l'override par le thème child
	function br_menu_default() {
		// Utilisé dans la navbar
		echo '<ul class="nav navbar-nav">';
		echo '<li><a href="/">Home</a></li>';
		echo '</ul>';
	}
}

// DUMMYs ////////////////////////////////////////////////////
// Charge du contenu test dans les templates. Les fichiers sont situés dans tpl/dummy.
// Il s'agit d'un raccourci vers la fonction de Wordpress
if(!function_exists('br_dummy')) { // Permet l'override par le thème child
      function br_dummy($tpl) {
            get_template_part('tpl/dummy/'.$tpl);
      }
}

// GET PAGE ICON /////////////////////////////////////////////
// Récupérer l'icône d'une page d'après un identifiant texte
if(!function_exists('br_getPageIcon')) { // Permet l'override par le thème child
	function br_getPageIcon($id = false) { // Actuellement si l'identifiant est un chiffre, la fonction retourne l'icone 'align-left'	
	
		$ICONES[$id] = $id; // Par défaut, l'icône appellé est chargé sans traduction
		
		// Traduction d'identifiant en icônes
		/*ICONS*/
		$ICONES['recommandation'] = "bullhorn";
		$ICONES['search'] = "search";
		$ICONES['stats'] = "stats";
		$ICONES['user'] = "user";
		$ICONES['plus'] = "plus";
		$ICONES['comment'] = "comment";
		$ICONES['article'] = "file";
		$ICONES['warning'] = "exclamation-sign";
		$ICONES['carousel-control-left'] = "circle-arrow-left";
		$ICONES['carousel-control-right'] = "circle-arrow-right";
		/*FORMATS*/
		$ICONES['image'] = $ICONES['gallery'] = "picture";
		$ICONES['video'] = "film";
		$ICONES['audio'] = "music";
		/*CATEGORIES*/
		$ICONES['blog'] = "file";
		/*PAGES*/
		$ICONES['accueil'] = $ICONES['home'] = "home";
		
		if($id != false) {
			if(is_int($id)) {
				$icon = 'align-left';	
			}
			else {
				$icon = $ICONES[$id];
			}
		}
		else $icon = $id;
		
		return $icon;
	}
}

// GET ICON /////////////////////////////////////////////
// Affiche l'icône choisie en fonction de la police (Glyphicons, Font-Awesome, Elusive)
if(!function_exists('br_getIcon')) { // Permet l'override par le thème child
	function br_getIcon($id = false) {
		switch(BR_ICON_SET) {
			default : 
				return "<b class='myicon myicon-".$id."'></b>";
			break;
			case 'disabled' : 
				return true;
			break;
			case 'glyphicon' :
				return "<span class='glyphicon glyphicon-".br_getPageIcon($id)."'></span>";
			break;
			
			case 'font-awesome' :
				return "<i class='fa fa-".br_getPageIcon($id)."'></i>";
			break;
			
			case 'elusive';
				return "<span class='el-icon-".br_getPageIcon($id)."'></span>";
			break;
		}
	}
}
function br_Icon($id = false) { echo br_getIcon($id); }

function br_getAvailableIcones() {
	// Liste des icones dont les appellations sont similaires entres Glyphicons, Font-Awesome, Elusive.
	return array(
			"home",
			"adjust","align-center","align-left","align-right","align-justify","bold","text-height","text-width","font","italic",
			"th","th-large","th-list","tag","tags","tasks","list","list-alt",
			"arrow-down","arrow-left","arrow-right","arrow-up",
			"refresh","retweet",
			"step-backward","step-forward","play","stop","pause","play-circle","random","repeat","fast-backward","fast-forward","forward",
			"volume-down","volume-off","volume-up",
			"chevron-down","chevron-up","chevron-left","chevron-right","asterisk","calendar","camera","bell","book","briefcase","bullhorn",
			"barcode","bookmark","certificate","cloud","cog","credit-card","leaf",
			"envelope","inbox",
			"film","fire",
			"file","flag","gbp","usd",
			"gift","glass","globe","headphones","heart","link","lock","magnet","map-marker","plus","minus",
			"music","pencil","phone","qrcode","road",
			"shopping-cart","signal","star",
			"thumbs-down","thumbs-up","tint",
			"upload","user","dashboard","wrench","edit","filter",
			"check","download","eject","comment","print","share","search","folder-open",
			"plane"
			);
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
