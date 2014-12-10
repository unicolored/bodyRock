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
extract( $args );		
extract( $instance );

////////// 0. ETENDUE DU WIDGET
// Gestion de l'affichage en fonction de l'environnement Wordpress
// Si les conditions ne sont pas remplies, il n'y aura pas d'affichage du widget.

if($instance['etendue_masquer'] == true ) {
	if($instance['etendue_site_front_page'] == false && is_front_page()) { return false; }
	if($instance['etendue_site_home'] == false && is_home()) { return false; }
	if($instance['etendue_site_category'] == false && is_category()) { return false; }
	if($instance['etendue_site_404'] == false && is_404()) { return false; }
	if($instance['etendue_site_search'] == false && is_search()) { return false; }
	if($instance['etendue_site_tag'] == false && is_tag()) { return false; }
	if($instance['etendue_site_page'] == false && is_page()) { return false; }
	if($instance['etendue_site_single'] == false && is_single()) { return false; }
	if($instance['etendue_site_attachment'] == false && is_attachment()) { return false; }
}

if($instance['affichage_modele']=='affichage_modele_listemedias') {
	$instance['affichage_liste_type'] = "ul-li";
}

////////// 1. TRAITEMENT ET CONVERSION DES VARIABLES
// 		
if ( $affichage_liste_horizontale == true ) {
	$classe_horizontale = ($instance['affichage_liste_type'] == "dl-dt-dd" ? ".dl-horizontal" : ".list-inline");
}
$classe_unstyled = ($affichage_liste_unstyled == true ? ".list-unstyled" : false);

// Statiques
$modele_liste_group_start['ul-li'] = a('ul'.$classe_horizontale.$classe_unstyled);
$modele_liste_group_start['ol-li'] = a('ol'.$classe_horizontale.$classe_unstyled);
$modele_liste_group_start['dl-dt-dd'] = a('dl'.$classe_horizontale);

$modele_liste_group_end['ul-li'] = z('ul');
$modele_liste_group_end['ol-li'] = z('ol');
$modele_liste_group_end['dl-dt-dd'] = z('dl');

if($instance['affichage_listegroup_unlink']==false) {
	$disposition_group_start['affichage_modele_listegroup'] = a('div.list-group');
}
else {
	$disposition_group_start['affichage_modele_listegroup'] = a('ul.list-group');
}
$disposition_group_start['affichage_modele_listemedias'] = a('ul.media-list');
$disposition_group_start['affichage_modele_liste'] = $modele_liste_group_start[$instance['affichage_modele_liste']];	

if($instance['affichage_listegroup_unlink']==false) {
	$disposition_group_end['affichage_modele_listegroup'] = z('div');
}
else {
	$disposition_group_end['affichage_modele_listegroup'] = z('ul');
}
$disposition_group_end['affichage_modele_listemedias'] = z('ul');
$disposition_group_end['affichage_modele_liste'] = $modele_liste_group_end[$instance['affichage_modele_liste']];	

$liste_type_item_start['ul-li'] = a('li'.($instance['affichage_modele']=='affichage_modele_listemedias' ? '.media' : false));
$liste_type_item_start['ol-li'] = a('li'.($instance['affichage_modele']=='affichage_modele_listemedias' ? '.media' : false));
$liste_type_item_start['ol-li'] = a('dt');

$liste_type_item_end['ul-li'] = z('li');
$liste_type_item_end['ol-li'] = z('li');
$liste_type_item_end['ol-li'] = z('dt');		

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

// AFFICHAGE DU WIDGET
if(isset($instance['name']) && $instance['name']!=false) {
	$before_widget = a('div.'.$instance['name']).$before_widget;
	$after_widget = z('div').$after_widget;
}
$Widget_START = $before_widget.(isset($instance['titre']) ? a($instance['titre_format']).$instance['titre'].z($instance['titre_format']) : false);

$Widget_END = $after_widget;


////////// 3. ENCADREMENT DU GROUPE D'ITEMS
// $group_start,$group_end

$Group_START['blog'] = $disposition_group_start[$instance['affichage_modele']];
$Group_END['blog'] = $disposition_group_end[$instance['affichage_modele']];
$Wrapper_START['carousel'] = a('div.bodyloop-carousel.slide').a('div.carousel-inner');
$Wrapper_END['carousel'] = z('div').z('div').$carousel_javascript;

////////// 4. ENCADREMENT D'UN ITEM
// $item_start,$item_end

$Item_START['carousel'] = "<div class=\"item %1$s\">"; // '<div class="item '.($c==1?'active':false).'">'
$Item_END['carousel'] = z('div');

$Item_START['affichage_modele_liste'] = $liste_type_item_start[$instance['affichage_liste_type']];
$Item_END['affichage_modele_liste'] = $liste_type_item_end[$instance['affichage_liste_type']];

$Item_START['affichage_modele_listemedias'] = $liste_type_item_start[$instance['affichage_liste_type']];
$Item_END['affichage_modele_listemedias'] = $liste_type_item_end[$instance['affichage_liste_type']];

if($instance['affichage_listegroup_unlink']==true) {
	$Item_START['affichage_modele_listegroup'] = a('li.list-group-item');
	$Item_END['affichage_modele_listegroup'] = z('li');
}

////////// 5. CONSTRUCTION DE LA REQUETE
// $args[]

if($instance['filtres_off']==false) {
	// CREATION D'UNE LOOP AUX PARAMETRES PERSONNALISES :: filtres_off = off :: les filtres sont activés
	wp_reset_query();
	// $FILTRES_TYPES
	$types_options = array("type_post"=>"post","type_page"=>"page","type_attachment"=>"attachment");
	$query_args['post_type'] = $types_options[$filtres_type];
	
	// $FILTRES_COMBIEN
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
	
	// $FILTRES_CATSIN
	$filtres_catsin = "";
	$i=1;
	foreach($instance as $label=>$value) {
	//			echo preg_replace("/filtres_categories_/","",$label).'<br>';
		if ( preg_match("/filtres_categories_/",$label,$cat)==1 ) {
			$cat = preg_replace("/filtres_categories_/","",$label);
			$filtres_catsin .= ($i>1?",":false).$cat;
			$i++;
		}
	}
	if ($filtres_catsin!=false) $query_args['category__'.$instance['filtres_catsinornot']] = "".$filtres_catsin."";

	// SELON LES CATEGORIES
	if($instance['filtres_similaires_selon']=='both' || $instance['filtres_similaires_selon']=='cats') {
		// Articles similaires
		// aux catégories du single
		$pc = wp_get_post_categories( get_the_ID() );
		$cats = array();
		$param_cat = "";
		foreach($pc as $c) {
			$cat = get_category( $c );
			$cats[] = array(
			"name" => $cat->name,
			"slug" => $cat->slug
			);
			$param_cat .= $cat->cat_ID.",";
		}
		$query_args['category__in'] = $param_cat;
	}
	
	// SELON LES TAGS
	if($instance['filtres_similaires_selon']=='both' || $instance['filtres_similaires_selon']=='tags') {
		// Articles similaires
		// aux tags du single
		if(is_singular()) {
			$tags = wp_get_post_tags(get_the_ID());
			foreach($tags as $individual_tag) {
				$tag_ids[] = $individual_tag->term_id;
			}
		}
		$query_args['tag__in'] = $tag_ids;
	}
	
	// post__not_in
	if($instance['filtres_ignoreposts']==true) {
		// Ne pas inclure l\'article single
		if(is_singular()) {
			$posts_notin = get_the_ID();
		}
		$query_args['post__not_in'] = array($posts_notin);
	}

	// posts_per_page
	$query_args['posts_per_page'] = $filtres_combien;	
	// WP_QUERY
	$QUERY = new WP_Query($query_args);			
}
elseif($instance['calldata']!=false) {
// Rarement utilisé
	$QUERY = $instance['calldata'];
}
else {
	// UTILISATION DE LA LOOP GLOBALE :: filtres_off = on :: les filtres sont éteints
	global $wp_query;
	$wp_query->posts__per_page=6;
//	vardump($wp_query);
	$QUERY = $wp_query;
}

////////// 6. LA BOUCLE	
$c=1;
// Paramètres Wallpin
$a='a';
$COLS = explode('/',($instance['apparence_wallpin_colonnes']!=false ? $instance['apparence_wallpin_colonnes'] : getDefaultLoop('apparence_wallpin_colonnes'))); // Uniquement dans le cas Wallpin
for($z=0;$z<=(count($COLS)-1);$z++) {
$counter[$COLS[$z]]=1;
}
$n = $counter['a'];

////////////////////////////////////////////////////////////////////////////////////////////////////////

// WIDGET_START
echo $Widget_START;
$separators = array('hr','br');
echo (in_array($instance['titre_separator'],$separators) ? a($instance['titre_separator']) : false);
// WRAPPER_START
echo $Wrapper_START[$instance['apparence_disposition']];		
// GROUP_START
echo $Group_START[$instance['apparence_disposition']];

// Loop
if ( $QUERY->have_posts() ) {
	while ( $QUERY->have_posts() ) {
		$QUERY->the_post();
	
		if($apparence_disposition=='wallpin') { // Dans le cas Wallpin, la boucle enregistre les données dans $articles[$a][$n] et l'affichage se fait hors boucle.
			global $post;
			$articles[$a][$n]=$post;
			$articles[$a][$n]->exxcerpt=get_the_excerpt();
			for($z=0;$z<=(count($COLS)-1);$z++) {
				if($z==(count($COLS)-1)) { $a=$COLS[0]; $counter[$COLS[$z]]++; $n=$counter[$COLS[0]]; break; }
				elseif($a==$COLS[$z]) { $a=$COLS[$z+1]; $counter[$COLS[$z]]++; $n=$counter[$COLS[$z+1]]; break; }
			}
			$nombrecolumns = (count($COLS)-1);
		}
		else { // Rendus des modes d'affichages Blog et Carousel
		
			// WRAPPER_START
			echo str_replace('%1',($c==1 ? 'active' : false),$Item_START[$instance['apparence_disposition']]);
			
			// ITEM_START
			echo $Item_START[$instance['affichage_modele']];
			
			// ITEM_CONTENT
			/*BIMBIM : Ici, transcription de toutes les variables de la loop au format wallpin*/
			
			$loop_permalink = get_permalink();
			
			$instance['affichage_modele'] = $instance['affichage_modele']!=false ? $instance['affichage_modele'] : getDefaultLoop('affichage_modele');
			switch($instance['affichage_modele']) {
				default: return 'Item invalide.'; break;
				
				case 'affichage_modele_liste' :
					echo '<a href="'.get_permalink().'" rel="bookmark" title="'.the_title_attribute( 'echo=0' ).'" class="post-title">'.get_the_title().'</a>';
												
					if ( $instance['contenu_excerpt']=='on' && $instance['affichage_liste_type'] != 'dl-dt-dd' ) {
						echo Get_excerpt($instance);
					}
				break;
				
				case 'affichage_modele_listemedias':
					if($instance['vignette_masquer'] == false && has_post_thumbnail()) {
						$image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), $vignette_dimensions);
						if ( $instance['vignette_dimensions_force']!=false ) {
							$S = explode( 'x' , $instance['vignette_dimensions_force'] );
							$wh = 'width="'.$S[0].'" height="'.$S[1].'"';
						}
						else $wh = 'width="'.$image_url[1].'" height="'.$image_url[2].'"';
						
						$align=array("gauche"=>"pull-left","droite"=>"pull-right","center"=>"center-block","aucun"=>false);
						
						if($instance['affichage_listemedias_unlink']==false) {
							echo '<a class="'.$align[$instance['vignette_alignement']].'" href="'.get_permalink().'">';
						}
						echo '<img class="media-object" src="'.$image_url[0].'" '.$wh.' alt="'.get_the_title().'">';
						if($instance['affichage_listemedias_unlink_img']==false) {
							echo '</a>';
						}
					}
					echo '<div class="media-body">';
					echo '<h4 class="media-heading">'.get_the_title().'</h4>';
					echo Get_excerpt($instance,a('p'),z('p'));
					echo '</div>';	
				break;
				
				case 'affichage_modele_listegroup':
					if($instance['affichage_listegroup_unlink']==false) {
						echo '<a href="'.get_permalink().'" class="list-group-item '.(get_the_ID()==$active_single_id && is_single() ? 'active' : false).'">';
					}
					echo '<h4 class="list-group-item-heading">'.get_the_title().'</h4>';
					if ($instance['affichage_liste_type'] != 'dl-dt-dd' ) {
		//							$instance['contenu_lirelasuite']=false; // On force le paramètre contenu_lirelasuite car le lien est déjà affiché ici
						echo Get_excerpt($instance,a('p.list-group-item-text'),z('p'));
					}
					if($instance['affichage_listegroup_unlink']==false) {
						echo '</a>';
					}
				break;
				
				case 'affichage_modele_thumbnail':
					include(locate_template('assets/tpl/affichage/modele-thumbnail.php'));
				break;
				case 'affichage_modele_article':
					include(locate_template('assets/tpl/affichage/modele-article.php'));
				break;
			}
			$c++;
			
			// ITEM_END
			echo $Item_END[$instance['affichage_modele']];
			
			// Enfin, on affiche la description dans la balise dd si la liste est de type dl-dt-dd
			if ( $instance['contenu_excerpt']=='on' && $instance['affichage_liste_type'] == 'dl-dt-dd' ) {
				echo a('dd');
					echo Get_thumbnail($instance);
					echo Get_excerpt($instance);
				echo z('dd');
			}
			
			$separators = array('hr','br');
			echo (in_array($instance['articles_separator'],$separators) ? a($instance['articles_separator']) : false);
			
			echo $Item_END[$instance['apparence_disposition']];
		}
	}
}
else { // Si aucun résultat;
	echo 'yo, ya pas de résultat';
}

// GROUP_START
echo $Group_END[$instance['apparence_disposition']];
	
// WALLPIN RESULTS
if($instance['apparence_disposition']=='wallpin') {
//echo a('div.galaxie');		
foreach($COLS as $ID) {
	$x = 12/count($COLS);
	echo '<div class="col-lg-'.$x.'">';
	for ( $i=1;isset($articles[$ID][$i]);$i++ ) {
		$post=$articles[$ID][$i];
		$excerpt = $post->exxcerpt;
		
		switch($instance['affichage_modele']) {
			case 'affichage_modele_thumbnail':
				include(locate_template('assets/tpl/affichage/modele-thumbnail.php'));
			break;
			case 'affichage_modele_article':
				include(locate_template('assets/tpl/affichage/modele-article.php'));
			break;
		}
	}
	echo '</div>';
}
//echo z('/div');	
}		

// WRAPPER_END
echo $Wrapper_END[$instance['apparence_disposition']];

echo $Widget_END;

wp_reset_query();

?>