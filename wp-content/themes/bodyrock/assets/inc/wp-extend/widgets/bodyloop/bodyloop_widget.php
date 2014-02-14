<?php

// BODYLOOP Widget /////////////////////////////////////////////

/*//**//**//**//*//**//**//**//*//**//**//**//*//**//**//**/
// Widget de création d'affichage de contenus.
// Permet de filtrer l'ensemble des résultats, de choisir une template pour l'affichage et de personnaliser les données affichées.
/*//**//**//**//*//**//**//**//*//**//**//**//*//**//**//**/


// Variables externes
$active_single_id = get_the_ID(); // On récupère avant la boucle, l'identifiant de l'article ou de la page en cours. On pourra ainsi savoir dans la boucle si un élément est "active"
$active_single_type = get_post_type();

// Suppression de l'ajout du "suite" par défaut qui s'ajoute à l'excerpt lors de l'apperl à get_excerpt()
$new_excerpt_more= create_function('$more', 'return " ";');	
//add_filter('excerpt_more', $new_excerpt_more);

// Variables du widget
extract( $args ); // Les paramètres du widget liés à la sidebar : $before_widget, $after_widget, $before_title, $after_title

////////// 0. ETENDUE DU WIDGET
// Gestion de l'affichage en fonction de l'environnement Wordpress
// Si les conditions ne sont pas remplies, il n'y aura pas d'affichage du widget.

// Par défaut, le widget s'affiche sur toutes les pages sauf si l'option etendue_masque est activée, il faut alors avoir activée l'étendue sur les sous pages.
/*if($instance['etendue_masquer'] == true ) {
	$wordpress_pages = array("front_page","home","category","404","search","tag","page","single","attachment");
	foreach($wordpress_pages as $P) {
		if(isset($instance['etendue_site_'.$P]) && $instance['etendue_site_'.$P] == false && is_.$P()) { return false; }
	}
}*/

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

////////// 1. TRAITEMENT ET CONVERSION DES VARIABLES
// 	
// Liste Horizontale
	$classe_horizontale = false;	
	if($instance['affichage_liste_horizontale'] == true ) {
		$classe_horizontale = ($instance['affichage_liste_type'] == "dl-dt-dd" ? ".dl-horizontal" : ".list-inline");
	}
	
// Liste sans puce
	$classe_unstyled = ($instance['affichage_liste_unstyled'] == true ? ".list-unstyled" : false);

// Group_start et Item_start en fonction de affichage_liste_type
	$modele_liste_type_group_start['ul-li'] = a('ul'.$classe_horizontale.$classe_unstyled);
	$modele_liste_type_group_end['ul-li'] = z('ul');
	$modele_item_start['ul-li'] = a('li'.($instance['affichage_modele']=='affichage_modele_listemedias' ? '.media' : false));
	
	$modele_liste_type_group_start['ol-li'] = a('ol'.$classe_horizontale.$classe_unstyled);
	$modele_liste_type_group_end['ol-li'] = z('ol');
	$modele_item_start['ol-li'] = a('li'.($instance['affichage_modele']=='affichage_modele_listemedias' ? '.media' : false));
	
	$modele_liste_type_group_start['dl-dt-dd'] = a('dl'.$classe_horizontale);
	$modele_liste_type_group_end['dl-dt-dd'] = z('dl');
	$modele_item_start['dl-dt-dd'] = a('dt');

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// Group_start en fonction de affichage_modele
// _thumbnail et _article n'utilisent pas de group_
	// _liste
	$disposition_group_start['affichage_modele_liste'] = $modele_liste_type_group_start[$instance['affichage_liste_type']];
	$disposition_group_end['affichage_modele_liste'] = $modele_liste_type_group_end[$instance['affichage_liste_type']];	

	// _listegroup
	if($instance['affichage_listegroup_unlink']==false) {
		$disposition_group_start['affichage_modele_listegroup'] = a('div.list-group');
	}
	else {
		$disposition_group_start['affichage_modele_listegroup'] = a('ul.list-group');
	}
	if($instance['affichage_listegroup_unlink']==false) {
		$disposition_group_end['affichage_modele_listegroup'] = z('div');
	}
	else {
		$disposition_group_end['affichage_modele_listegroup'] = z('ul');
	}

	// _listemedias
	$disposition_group_start['affichage_modele_listemedias'] = a('ul.media-list');
	$disposition_group_end['affichage_modele_listemedias'] = z('ul');

// Item_start en fonction de affichage_modele et de affichage_liste_type
	// _liste
	$modele_item_start['affichage_modele_liste'] = $modele_item_start[$instance['affichage_liste_type']];
	$modele_item_end['affichage_modele_liste'] = $modele_item_start[$instance['affichage_liste_type']];	

	// _listegroup
	if($instance['affichage_listegroup_unlink']==false) {
		$modele_item_start['affichage_modele_listegroup'] = '<a href="getpermalink()" class="liste-group-item active">';
	}
	else {
		$modele_item_start['affichage_modele_listegroup'] = a('li.list-group-item');
	}
	if($instance['affichage_listegroup_unlink']==false) {
		$modele_item_end['affichage_modele_listegroup'] = z('a');
	}
	else {
		$modele_item_end['affichage_modele_listegroup'] = z('li');
	}
	// _liste
	$modele_item_start['affichage_modele_listemedias'] = $modele_item_start[$instance['affichage_liste_type']];
	$modele_item_end['affichage_modele_listemedias'] = $modele_item_start[$instance['affichage_liste_type']];	


$modele_item_end['ul-li'] = z('li');
$modele_item_end['ol-li'] = z('li');
$modele_item_end['ol-li'] = z('dt');		

$carousel_javascript = "
	<script type='application/x-javascript'>
	// CAROUSEL // TOFIX : changer la classe en fonction de l'identifiant du widget + mettre en option l'intervalle de temps
	if(jQuery('.bodyloop-carousel').length>0) {
		jQuery('.bodyloop-carousel').carousel({
		  interval: 4000
		});
		jQuery('.bodyloop-carousel-control').show();
	}
	</script>
	";

////////// 2. ENCADREMENT DU WIDGET
// $widget_start,$widget_end

// Widget_
	if(isset($instance['class']) && $instance['class']!=false) {
		$before_widget = a('div.'.$instance['class'],"#".$instance['name']).$before_widget;
		$after_widget = $after_widget.z('div');
	}
	// Création de Widget_START
	$icone_widget = (isset($instance['titre_icone']) ? br_getIcon($instance['titre_icone']).'&nbsp;' : false);
	$titre_format = (isset($instance['titre_format']) ? $instance['titre_format'] : getDefaultLoop('titre_format'));
	$titre_widget = ($instance['titre_masquer']==false && isset($instance['titre']) ? a($titre_format.'.widget-title').$icone_widget.$instance['titre'].z($titre_format) : false);
	$Widget_START = $before_widget.$titre_widget;

	// Création de Widget_END
	$Widget_END = $after_widget;
	

////////// 3. ENCADREMENT DU GROUPE D'ITEMS
// 
		

// First_
	$First_START['carousel'] = a('div.bodyloop-carousel.slide');
	$First_END['carousel'] = z('div');
	$First_START['wallpin'] = a('div.galaxie');
	$First_END['wallpin'] = z('div');

// Wrapper_
	$Wrapper_START['carousel'] = a('div.carousel-inner');
	$Wrapper_END['carousel'] = z('div').$carousel_javascript;
	$Wrapper_START['wallpin'] = a('div.wallpin');
	$Wrapper_END['wallpin'] = z('div');

// Group_
	$Group_START = isset($disposition_group_start[$instance['affichage_modele']]) ? $disposition_group_start[$instance['affichage_modele']] : false;
	$Group_END = isset($disposition_group_end[$instance['affichage_modele']]) ? $disposition_group_end[$instance['affichage_modele']] : false;
	
// Colonne_
//	$Colonne_START['wallpin'] = a('div.col-lg-%s').a('div.galaxie'); // '<div class="item '.($c==1?'active':false).'">'
//	$Colonne_END['wallpin'] = z('div').z('div');
	$Colonne_START['wallpin'] = a('div.col-xs-12.col-lg-%s'); // '<div class="item '.($c==1?'active':false).'">'
	$Colonne_END['wallpin'] = z('div');
	
////////// 4. ENCADREMENT D'UN ITEM
// $item_start,$item_end

	$WIrapper_START['carousel'] = '<div class="item %s">'; // '<div class="item '.($c==1?'active':false).'">'
	$WIrapper_END['carousel'] = z('div');
	$WIrapper_START['wallpin'] = '<div class="galaxie">'; // '<div class="item '.($c==1?'active':false).'">'
	$WIrapper_END['wallpin'] = z('div');
	
	$Item_START = isset($modele_item_start[$instance['affichage_liste_type']]) ? $modele_item_start[$instance['affichage_liste_type']] : false;
	$Item_END = isset($modele_item_end[$instance['affichage_liste_type']]) ? $modele_item_end[$instance['affichage_liste_type']] : false;

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


////////// 5. CONSTRUCTION DE LA REQUETE
// $args[]

if($instance['filtres_off']==false) {
	// CREATION D'UNE LOOP AUX PARAMETRES PERSONNALISES :: filtres_off = off :: les filtres sont activés
	wp_reset_query();
	// $FILTRES_TYPES
	$types_options = array("type_post"=>"post","type_page"=>"page","type_attachment"=>"attachment");
	$query_args['post_type'] = $types_options[$filtres_type];
	
	// $FILTRES_COMBIEN
//	$query_args['posts_per_page'] = ($instance['filtres_combien']!=false ? $instance['filtres_combien'] : getDefaultLoop('filtres_combien'));
	$query_args['posts_per_page'] = $instance['filtres_combien'];
	
	// $FILTRES_ORDERBY // $FILTRES_ORDER
	$query_meta_key = false;
	$orderby_options = array("orderby_date"=>"date","orderby_dateedition"=>"modified","orderby_titre"=>"title","orderby_comment"=>"comment_count","orderby_nombredevue"=>"meta_value_num");
	
	$query_args['orderby'] = $orderby_options[$instance['filtres_orderby']];
	
	switch($instance['filtres_orderby']) {
		case 'orderby_nombredevue':
			$query_args['meta_key'] = "post_views_count";
		break;
	}
	// meta_key=post_views_count
	$query_args['order'] = $instance['filtres_order'];
	
	// $FILTRES_OFFSET
	if ($instance['filtres_offset']!=false) $query_args['offset'] = $instance['filtres_offset'];

	// SELON LES CATEGORIES
	if($instance['filtres_similaires_selon']=='cats') {

		// $FILTRES_CATSIN
		$filtres_catsin = "";
		$i=1;
		foreach($instance as $label=>$value) {
			if ( preg_match("/filtres_categories_/",$label,$cat)==1 ) {
				
				$cat = preg_replace("/filtres_categories_/","",$label);
				$filtres_catsin .= ($i>1?",":false).$cat;
				$i++;
			}
		}
		if ($filtres_catsin!=false) $query_args['category__'.(isset($instance['filtres_catsinornot']) ? $instance['filtres_catsinornot'] : getDefaultLoop('filtres_catsinornot'))] = "".$filtres_catsin."";
	}
	
	// SELON LES TAGS
	if($instance['filtres_similaires_selon']=='tags') {
		// Articles similaires
		// aux tags du single
		$tags = wp_get_post_tags($instance['filtres_article_reference']);
		foreach($tags as $individual_tag) {
			$tag_ids[] = $individual_tag->term_id;
		}
		$query_args['tag__in'] = $tag_ids;
	}
	
	// post__not_in
	if($instance['filtres_ignoreposts']==true) {
		// Ne pas inclure l\'article single

		if(is_array($instance['filtres_ignoreposts'])) {
			$query_args['post__not_in'] = $instance['filtres_ignoreposts'];
		}
		else
			$query_args['post__not_in'] = unserialize($instance['filtres_ignoreposts']);
	}
	vardump($query_args['post__not_in']);

	// posts_per_page
	// WP_QUERY
	if($instance['ajax']==false) {
		$QUERY = new WP_Query($query_args);
	}
}
elseif($instance['calldata']!=false) {
// Rarement utilisé
	$QUERY = $instance['calldata'];
}
else {
	// EDITION DE LA LOOP GLOBALE :: filtres_off = on :: les filtres sont éteints par défaut
	if($instance['ajax']==false) {	
		global $wp_query; // Récupération de la boucle globale avant execution
		
		query_posts('paged='.get_query_var('paged').'&cat='.get_query_var( 'cat' ).'&s='.get_query_var('s')); // Modification de la loop en cours
		
		$QUERY = $wp_query;
	}
}

////////// 6. LA BOUCLE	
$c=1;
// Paramètres Wallpin
$a='a';

if($instance['apparence_disposition']!="wallpin") {  // Mode Blog et Carousel : une seule colonne
	$instance['apparence_wallpin_colonnes']=false;
	$COLS = array("a");
	for($z=0;$z<=(count($COLS)-1);$z++) {
		$counter[$COLS[$z]]=1;
	}
	$n = $counter['a'];
}
else { // Apparence Wallpin : // Seul ce mode permet d'afficher des colonnes de résultats pour le moment. Il faudra le proposer pour Blog (ajouter un wrapper à l'item avec une classe colonne.)
	$COLS = explode('/',($instance['apparence_wallpin_colonnes']!=false ? $instance['apparence_wallpin_colonnes'] : getDefaultLoop('apparence_wallpin_colonnes'))); // Uniquement dans le cas Wallpin

	for($z=0;$z<=(count($COLS)-1);$z++) {
		$counter[$COLS[$z]]=1;
	}
	$n = $counter['a'];
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if($instance['ajax']==true) {

	echo a('div.holder-ajax-widget-'.$instance['name']).z('div');
	
	//wp_enqueue_script( 'ajax-widget-'.$instance['class'], JS_PATH.'ajax-widget-load-posts.js', array('jquery'), 'fev14' );
	// Enregistrer le script ci-dessous en session et charger l'ensemble des widgets ajax à part de script.php
	$_SESSION['ajax-widget-'.$instance['name']] = urlencode(json_encode($instance));
	
	$_SESSION['args-ajax-widget-'.$instance['name']] = urlencode(json_encode($args));
	$_SESSION['ajax-widgets'] .= 'ajax-widget-'.$instance['name'].'//';
	
}
else {

	// WIDGET_START
	echo $Widget_START;
	
	$separators = array('hr','br');
	echo (in_array($instance['titre_separator'],$separators) ? a($instance['titre_separator']) : false);
	
	$_SESSION['widget_posts'] = false;
	
	
	if ( $QUERY->have_posts() ) {
		
		// Loop
		while ( $QUERY->have_posts() ) {
			$QUERY->the_post();
		
			global $post;
			$articles[$a][$n]=$post;
			$_SESSION['wposts_'.$instance['name']] .= $post->ID.',';
			
			if(get_the_excerpt()) {
				$articles[$a][$n]->exxcerpt=get_the_excerpt();
			}
			else $articles[$a][$n]->exxcerpt = false;
	
			// Ici, on sort de la boucle et on change de colonne.
			for($z=0;$z<=(count($COLS)-1);$z++) {
				if($z==(count($COLS)-1)) { $a=$COLS[0]; $counter[$COLS[$z]]++; $n=$counter[$COLS[0]]; break; }
				elseif($a==$COLS[$z]) { $a=$COLS[$z+1]; $counter[$COLS[$z]]++; $n=$counter[$COLS[$z+1]]; break; }
			}
			$nombrecolumns = (count($COLS)-1);
		}
		/*
		// Ajax load more
		// Add code to index pages.
		if( !is_singular() ) { 		
			wp_enqueue_script( 'script-ajax-load-posts', JS_PATH.'ajax-load-posts.js', array('jquery'), 'fev14' );
		
			// What page are we on? And what is the pages limit?
			$max = $QUERY->max_num_pages;
			$paged = ( get_query_var('paged') > 1 ) ? get_query_var('paged') : 1;
			
			// Add some parameters for the JS.
			wp_localize_script(
			'script-ajax-load-posts',
			'pbd_alp',
			array(
			'startPage' => $paged,
			'maxPages' => $max,
			'nextLink' => next_posts($max, false),
			'loadBtn' => __("Afficher plus de résultats","bodyrock"),
			'loadText' => __("Chargement des articles...","bodyrock"),
			'loadNomore' => __("Plus aucun résultat","bodyrock")
			)
			);
		}
		add_action('template_redirect', 'pbd_alp_init');*/
	
		if(isset($First_START[$instance['apparence_disposition']])) {
			// F FIRST_START
			echo $First_START[$instance['apparence_disposition']];
		}	
		if(isset($Wrapper_START[$instance['apparence_disposition']])) {
			// W WRAPPER_START
			echo $Wrapper_START[$instance['apparence_disposition']];
		}
		if(isset($Group_START)) {
			// G GROUP_START
			echo $Group_START;
		}
	
			// BOUCLE START
			$largeur_colonne = 12/count($COLS); // Largeur d'une colonne
	
			foreach($COLS as $ID) {
				
				if(isset($Colonne_START[$instance['apparence_disposition']])) {
					// C COLONNE_START
					printf ( $Colonne_START[$instance['apparence_disposition']] , $largeur_colonne );
				}
				
				for ( $i=1;isset($articles[$ID][$i]);$i++ ) { // $i = ligne de résultat
					$post=$articles[$ID][$i];
					$excerpt[$i] = $articles[$ID][$i]->exxcerpt;
					
					if(isset($WIrapper_START[$instance['apparence_disposition']])) {
						// WI WIRAPPER_START
						printf ( $WIrapper_START[$instance['apparence_disposition']] , ($i==1 ? 'active' : false) );
					}
		
						if(isset($Item_START[$instance['affichage_modele']])) {
							// I ITEM_START
							echo $Item_START[$instance['affichage_modele']];
						}				
						
							// CONTENT
							$instance['affichage_modele'] = $instance['affichage_modele']!=false ? $instance['affichage_modele'] : getDefaultLoop('affichage_modele');					
							include(locate_template('assets/tpl/affichage/'.$instance['affichage_modele'].'.php'));
							
						
						if(isset($Item_END[$instance['affichage_modele']])) {
							// ITEM_END
							echo $Item_END[$instance['affichage_modele']];
						}
						
						// Enfin, on affiche la description dans la balise dd si la liste est de type dl-dt-dd
						if ( $instance['contenu_excerpt']=='on' && $instance['affichage_modele']=='liste' && $instance['affichage_liste_type'] == 'dl-dt-dd' ) {
							echo a('dd');
								echo Get_thumbnail($instance);
								echo Get_excerpt($instance);
								echo Get_artfooter($instance);
							echo z('dd');
						}
						
						$separators = array('hr','br');
						echo (in_array($instance['articles_separator'],$separators) ? a($instance['articles_separator']) : false);
					
					if(isset($WIrapper_END[$instance['apparence_disposition']])) {
						// WI WIRAPPER_START
						echo $WIrapper_END[$instance['apparence_disposition']];
					}
				}
				
				if(isset($Colonne_END[$instance['apparence_disposition']])) {
					// C COLONNE_END
					echo $Colonne_END[$instance['apparence_disposition']];
				}
				
			}
			// BOUCLE FIN
		
		if ( isset($Group_END) ) {
			// GROUP_END
			echo $Group_END;
		}	
		if ( isset($Wrapper_END[$instance['apparence_disposition']]) ) {
			// WRAPPER_END
			echo $Wrapper_END[$instance['apparence_disposition']];
		}
		if(isset($First_END[$instance['apparence_disposition']])) {
			// F FIRST_START
			echo $First_END[$instance['apparence_disposition']];
		}
	}
	else { // Si aucun résultat;
		echo __('Aucun résultat.','bodyrock');
	}
	
	echo $Widget_END;

	wp_reset_query();
}

?>