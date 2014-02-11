<?php
load_theme_textdomain('uni', get_stylesheet_directory().'/languages');

function br_getPageIcon($id = false) {
	/* br_function OVERRIDE */
	/* Récupérer l'icône d'une page d'après un identifiant texte. */
	// Actuellement si l'identifiant est un chiffre, la fonction retourne l'icone 'align-left'
	
	$ICONES[$id] = $id; // Par défaut, l'icône appellé est chargé sans traduction

	/*ICONS*/
	$ICONES['recommandation'] = "bullhorn";
	$ICONES['search'] = "search";
	/*FORMATS*/
	$ICONES['image'] = $ICONES['gallery'] = "picture";
	$ICONES['video'] = "film";
	$ICONES['audio'] = "music";
	
	/*CATEGORIES*/
	$ICONES['puce1'] = "chevron-circle-right";
	$ICONES['collections'] = "folder";
	$ICONES['evenements'] = "calendar";
	$ICONES['blog'] = "file";
	$ICONES['web'] = "globe";
	$ICONES['cinema'] = "film";
	$ICONES['inspiration'] = "leaf";
	$ICONES['musique'] = "music";
	$ICONES['photographie'] = "camera";
	$ICONES['redchoice'] = "star";
	$ICONES['ressources'] = "files-o";
	$ICONES['style'] = "rocket";
	$ICONES['videos'] = "film";
	$ICONES['insolite'] = "tint";
	$ICONES['image-de-la-semaine'] = "camera";
	/*PAGES*/
	$ICONES['accueil'] = $ICONES['home'] = "home";
	$ICONES['discussions'] = "comments";
	$ICONES['404'] = "exclamation-circle";
	
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


function gh_getPostsPeriod($query) {
	// Récupère les années + récentes ['tod'] et + anciennes ['yes'] d'une requête donnée
	$today = new WP_Query($query); 
	$today->the_post();
	$period['tod'] = get_the_date('Y');
	wp_reset_query();
	
	$yesterday = new WP_Query($query.'&order=ASC' ); 
	$yesterday->the_post();
	$period['yes'] = get_the_date('Y');
	wp_reset_query();
	
	return $period;
}

function gh_getPagination($the_query,$cat=false) {
	// Génère la pagination par défaut
	$urlcat = esc_url(get_category_link( $cat ));            
	$maxpages = $the_query->max_num_pages;
	$next_posts_link = ($paged+1)<=$maxpages ? $urlcat.'page/'.($paged+1) : false;
	$PAGINATION['previous_posts_link'] = ($paged-2)>0 ? $urlcat.'page/'.($paged+1) : false;
	$PAGINATION['previous_posts_link'] = ($paged-1)>0 ? $urlcat.'' : $previous_posts_link;
	
	$PAGINATION['li']="";
	$nbelements = 5;
	$nbpg = $maxpages<$nbelements ? $maxpages : $nbelements;

	for($i=1;$i<=$nbpg;$i++) {
		$class= $i == $paged ? "active" : false;
		if ($i==1) $PAGINATION['li'] .= '<li class="'.$class.'"><a href="'.$urlcat.'">'.$i.'</a></li>';
		else $PAGINATION['li'] .= '<li class="'.$class.'"><a href="'.$urlcat.'page/'.$i.'">'.$i.'</a></li>';
	}
	if ( $nbpg>$nbelements ) {
		$PAGINATION['li'] .= '<li class="disabled"><a href="#">...</a></li>';
		$PAGINATION['li'] .= '<li><a href="#">'.$maxpages.'</a></li>';
	}

	$R = 	'<ul class="pagination pagination-lg pull-right">';
	$R .= 	'<li '.($PAGINATION['previous_posts_link'] == false ? 'class="disabled"' : false).'><a href="'.$PAGINATION['previous_posts_link'].'">&laquo;</a></li>';
	$R .=	$PAGINATION['li'];
	$R .=	'<li '.($PAGINATION['next_posts_link'] == false ? 'class="disabled"' : false).' ><a href="'.$PAGINATION['next_posts_link'].'">&raquo;</a></li>';
	$R .= 	'</ul>';
	
	return $R;
}
?>