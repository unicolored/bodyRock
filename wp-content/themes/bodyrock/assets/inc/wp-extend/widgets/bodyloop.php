<?php

// BODYLOOP Widget /////////////////////////////////////////////

/*//**//**//**//*//**//**//**//*//**//**//**//*//**//**//**/
// Widget de création d'affichage de contenus.
// Permet de filtrer l'ensemble des résultats, de choisir une template pour l'affichage et de personnaliser les données affichées.
/*//**//**//**//*//**//**//**//*//**//**//**//*//**//**//**/


class br_widgetsBodyloop extends WP_Widget {
	
	function br_widgetsBodyloop() {		
		$widget_ops = array(
		'description' => __('Création de loop pour afficher les articles de votre choix en composants prédéfinis et personnalisables.','bodyrock')
		);
    	parent::WP_Widget(false, __('BR Bodyloop', 'bodyrock'), $widget_ops);
	}

	function widget($args, $instance) {
		// Statiques
		$modele_liste_group_start['ul-li'] = a('ul'.$classe_horizontale.$classe_unstyled);
		$modele_liste_group_start['ol-li'] = a('ol'.$classe_horizontale.$classe_unstyled);
		$modele_liste_group_start['dl-dt-dd'] = a('dl'.$classe_horizontale);
		
		$disposition_group_start['affichage_modele_listegroup'] = a('div.list-group');
		$disposition_group_start['affichage_modele_listemedias'] = a('ul.media-list');
		$disposition_group_start['affichage_modele_liste'] = $modele_liste_group_start[$instance['affichage_modele_liste']];	
		
		$modele_liste_group_end['ul-li'] = z('ul');
		$modele_liste_group_end['ol-li'] = z('ol');
		$modele_liste_group_end['dl-dt-dd'] = z('dl');
		
		$disposition_group_end['affichage_modele_listegroup'] = z('div');
		$disposition_group_end['affichage_modele_listemedias'] = z('ul');
		$disposition_group_end['affichage_modele_liste'] = $modele_liste_group_end[$instance['affichage_modele_liste']];	
		
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

		
		// Variables externes
		$active_single_id = get_the_ID(); // On récupère avant la boucle, l'identifiant de l'article ou de la page en cours. On pourra ainsi savoir dans la boucle si un élément est "active"
		$active_single_type = get_post_type();
		
		// Variables du widget
        extract( $args );		
		extract( $instance );
		
////////// 0. ETENDUE DU WIDGET
// Gestion de l'affichage en fonction de l'environnement Wordpress
// Si les conditions ne sont pas remplies, il n'y aura pas d'affichage du widget.
		
		if($instance['etendue_masquer'] == true ) {
			if($instance['etendue_site_frontpage'] == false && is_front_page()) { return false; }
			if($instance['etendue_site_home'] == false && is_home()) { return false; }
			if($instance['etendue_site_category'] == false && is_category()) { return false; }
			if($instance['etendue_site_404'] == false && is_404()) { return false; }
			if($instance['etendue_site_search'] == false && is_search()) { return false; }
			if($instance['etendue_site_tag'] == false && is_tag()) { return false; }
			if($instance['etendue_site_page'] == false && is_page()) { return false; }
			if($instance['etendue_site_single'] == false && is_single()) { return false; }
			if($instance['etendue_site_attachment'] == false && is_attachment()) { return false; }
		}
		
////////// 1. TRAITEMENT ET CONVERSION DES VARIABLES
// 		
		if ( $affichage_liste_horizontale == true ) {
			$classe_horizontale = ($instance['affichage_liste_type'] == "dl-dt-dd" ? ".dl-horizontal" : ".list-inline");
		}
		$classe_unstyled = ($affichage_liste_unstyled == true ? ".list-unstyled" : false);
		
		$COLS = explode('/',$instance['apparence_wallpin_colonnes']); // Uniquement dans le cas Wallpin
		
////////// 2. ENCADREMENT DU WIDGET
// $widget_start,$widget_end

		// AFFICHAGE DU WIDGET
		$Widget_START = $before_widget.(isset($title) ? $before_title.$title.$after_title : false);
		
		$Widget_END = $after_widget;		
		

////////// 3. ENCADREMENT DU GROUPE D'ITEMS
// $group_start,$group_end
	
		$Group_START['blog'] = $disposition_group_start[$instance['affichage_modele']];
		$Group_END['blog'] = $disposition_group_end[$instance['affichage_modele']];
		$Group_START['carousel'] = a('div.bodyloop-carousel.slide').a('div.carousel-inner');
		$Group_END['carousel'] = z('div').z('div').$carousel_javascript;

////////// 4. ENCADREMENT D'UN ITEM
// $item_start,$item_end

		$Item_START['carousel'] = "<div class=\"item %1$s\">"; // '<div class="item '.($c==1?'active':false).'">'
		$Item_END['carousel'] = z('div');
		
////////// 5. CONSTRUCTION DE LA REQUETE
// $args[]
        $default_sort_orders = array('date', 'title', 'comment_count', 'rand');	        
        if ( in_array($instance['filtres_orderby'], $default_sort_orders) ) {
			$sort_by = $instance['filtres_orderby'];
			$sort_order = (bool) $instance['asc_sort_order'] ? 'ASC' : 'DESC';
        } else {
			$sort_by = 'date';			
			$sort_order = 'DESC';			
        }
        
		// LA REQUETE
        $my_args=array(						   
            'posts_per_page' => $filtres_combien+$instance['jump'],
            'category__in'=> $cats,			
            'orderby' => $sort_by,			
            'order' => $sort_order,				
            'post_type' => $show_type				
            );
        
        $adv_recent_posts = null;
        $adv_recent_posts = new WP_Query($my_args);			
		

		
		// LA BOUCLE	
        $c=1;
		$a='a';
//		$n=$i=$j=$k=$l=1;
		for($z=0;$z<=(count($COLS)-1);$z++) {
			$counter[$COLS[$z]]=1;
		}
		$n = $counter['a'];

        while ( $adv_recent_posts->have_posts() )
        {
            $adv_recent_posts->the_post();
			
			if($apparence_disposition=='wallpin') {
				global $post;
				$articles[$a][$n]=$post;
				for($z=0;$z<=(count($COLS)-1);$z++) {
					if($z==(count($COLS)-1)) { $a=$COLS[0]; $counter[$COLS[$z]]++; $n=$counter[$COLS[0]]; break; }
					elseif($a==$COLS[$z]) { $a=$COLS[$z+1]; $counter[$COLS[$z]]++; $n=$counter[$COLS[$z+1]]; break; }
				}
				$nombrecolumns = (count($COLS)-1);
			}
			else {
				// AVANT l'ELEMENT
				echo $Item_START[$instance['apparence_disposition']];
				
				if($c>$instance['filtres_offset']) {
					switch($instance['affichage_modele']) {
						default :
						case 'affichage_modele_liste' :
						case 'affichage_modele_listemedias':
						
							switch ($affichage_liste_type) {
								default: echo a('li'.($affichage_modele=='affichage_modele_listemedias' ? '.media' : false)); break;
								case 'dl-dt-dd': echo a('dt'); break;
							}
							
							// ITEM //////////////
							if($affichage_modele == 'affichage_modele_listemedias') {
								if($vignette_afficher == true && has_post_thumbnail()) {
									$image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), $vignette_dimensions);
									if ( $vignette_dimensions_force!=false ) {
										$S = explode( 'x' , $vignette_dimensions_force );
										$wh = 'width="'.$S[0].'" height="'.$S[1].'"';
									}
									else $wh = 'width="'.$image_url[1].'" height="'.$image_url[2].'"';
									
									$align=array("gauche"=>"pull-left","droite"=>"pull-right","center"=>"center-block","aucun"=>false);
									echo '<a class="'.$align['vignette_alignement'].'" href="'.get_permalink().'">';
									echo '<img class="media-object" src="'.$image_url[0].'" '.$wh.' alt="'.get_the_title().'">';
									echo '</a>';
								}
								echo '<div class="media-body">';
								echo '<h4 class="media-heading">'.get_the_title().'</h4>';
								echo bodyloopGet_excerpt($instance,a('p'),z('p'));
								echo '</div>';
							}
							else {						
								echo '<a href="'.get_permalink().'" rel="bookmark" title="'.the_title_attribute( 'echo=0' ).'" class="post-title">'.$thethumb.' '.get_the_title().'</a>';
															
								if ( $instance['contenu_excerpt']=='on' && $instance['affichage_liste_type'] != 'dl-dt-dd' ) {
									echo bodyloopGet_excerpt($instance);
								}
								
							}	
								
							// ITEM //////////////
							switch ($affichage_liste_type) {
								default: echo z('li'); break;
								case 'dl-dt-dd': echo z('dt'); break;
							}
							
							// Enfin, on affiche la description dans la balise dd si la liste est de type dl-dt-dd
							if ( $instance['contenu_excerpt']=='on' && $instance['affichage_liste_type'] == 'dl-dt-dd' ) {
								echo a('dd');
									echo Get_thumbnail($instance);
									echo Get_excerpt($instance);
								echo z('dd');
							}
							
						break;
						
						case 'affichage_modele_listegroup':
						
							echo '
									<a href="'.get_permalink().'" class="list-group-item '.(get_the_ID()==$active_single_id && is_single() ? 'active' : false).'">
									<h4 class="list-group-item-heading">'.get_the_title().'</h4>
									';
									
										if ($affichage_liste_type != 'dl-dt-dd' ) {
										echo bodyloopGet_excerpt($instance,a('p.list-group-item-text'),z('p'));
										}
									echo ' </a>
	
							';
						break;
						
						case 'affichage_modele_thumbnail':
							include(locate_template('assets/tpl/bodyloop/thumbnails.php'));
						break;
						/*case 'articles':
							include(locate_template('assets/tpl/index-home.php'));
						break;*/
					}
				}
				$c++;
				
				echo $Item_END[$instance['apparence_disposition']];
			}
        }
		
        echo $Group_END[$instance['apparence_disposition']];
				
		// WALLPIN RESULTS
		if($apparence_disposition=='wallpin') {
			echo a('div.galaxie');		
			foreach($COLS as $ID) {
				$x = 12/count($COLS);
				echo '<div class="col-lg-'.$x.'">';
				for ( $i=1;isset($articles[$ID][$i]);$i++ ) {
					$post=$articles[$ID][$i];
					include(locate_template('assets/tpl/bodyloop/thumbnails.php'));
		//			get_template_part( 'tpl/content/item', get_post_format() );
				}
				echo '</div>';
			}
			echo z('/div');	
		}		
            
        echo $after_widget;
        wp_reset_query();
	}
	
	// ENREGISTREMENT DES DONNEES DU WIDGET	///////////////////////////////////////////
	function update($new_instance, $old_instance) {
		return $new_instance;
	}	

	
	// FORMULAIRE D'EDITION DU WIDGET	///////////////////////////////////////////
	function form( $instance ) {
		extract($instance);
		
		// $FILTRES_TYPES
		$types_options = array("type_post"=>"post","type_page"=>"page","type_attachment"=>"attachment");
		$args['post_type'] = $types_options[$filtres_type];

		// $FILTRES_COMBIEN
		$args['posts_per_page'] = $filtres_combien;
		
		// $FILTRES_ORDERBY // $FILTRES_ORDER
		$query_meta_key = false;
		$orderby_options = array("orderby_date"=>"date","orderby_dateedition"=>"modified","orderby_titre"=>"title","orderby_comment"=>"comment_count","orderby_nombredevue"=>"meta_value");
		$args['orderby'] = $orderby_options[$filtres_orderby];
		switch($filtres_orderby) {
			case 'orderby_nombredevue':
				$args['meta_key'] = "post_views_count";
			break;
		}
		// meta_key=post_views_count
		$args['order'] = (bool) $instance['filtres_order'] ? 'ASC' : 'DESC';
		
		// $FILTRES_OFFSET
		$args['offset'] = $filtres_offset;
		
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
		$args['cat'] = "'".$filtres_catsin."'";
		
		// AFFICHAGE DE LA REQUETE
		echo a('fieldset.requete');
			echo '<legend><h3>Requête</h3></legend>';
//			echo a('pre');
			$theargs = "";
			foreach($args as $A=>$val) {
				$theargs .= ($val!=false ? "'".$A."' => ".$val.",\n" : false);
			}
			echo("
<pre>
".'$args'." = array(\n"
.$theargs.
"\n);</pre>
			"
			);
//			echo z('pre');
		echo z('fieldset');
		echo a('hr');
		
        apply_filters( 'widget_title', $title);
		
		echo a('style');
		echo '
            .ofthewidget fieldset {
                border-bottom:1px dotted #333; margin:1em 0; padding:1em 0;
            }
            .ofthewidget fieldset legend {
                color:#ddd; background:#333; display:block; width:auto; padding:0.2em 1em;
            }
            .ofthewidget fieldset p.tabulate {
                padding:0; padding-left:2em; margin:0;
            }
		';
		echo z('style');
		
		echo a('script');
		echo '
            jQuery(".widgets-sortables .widget-inside").css({"display":"block"});
		';
		echo z('script');
		
		// FILTRES ///////////////////
//			echo $this->doFormInput("ONE",$instance,false,'<br>');
		echo a('fieldset.filtres');
			echo '<legend><h3>Filtres</h3></legend>';
			echo $this->doFormInput("Désactiver les filtres et se baser sur la boucle en cours,filtres_off?",$instance,false,'<hr>');
			if($instance['filtres_off']==false) {
				echo $this->doFormInput("Types d'articles,filtres_type::",$instance,"Articles,type_post;Pages,type_page;Médias,type_attachment",'<br>');
				echo $this->doFormInput("Nombre d'élément à afficher,filtres_combien09",$instance,false,'<br>');
				echo $this->doFormInput("Trier par,filtres_orderby::",$instance,"Date,orderby_date;Titre,orderby_titre;Commentaires,orderby_comment;Nombre de vues,orderby_nombredevue",'<br>');
				echo $this->doFormInput("Inverser l'ordre,filtres_order?",$instance,false,'<br>');
				echo $this->doFormInput("Ignorer les x premiers articles,filtres_offset09",$instance,false,'<hr>');
				echo $this->doFormInput("Résultat liés,filtres_resultats_lies::",$instance,"aux tags et/ou catégories suivantes,resultats_select;aux tags et catégories de l'article en cours",'<br>');
				if($instance['filtres_resultats_lies']=="resultats_select") {
					echo $this->doFormInput("Les tags,filtres_tags",$instance,false,'<br>');
					echo $this->doFormInput("Les catégories,filtres_categories()?",$instance,false,'<hr>');
				}
				echo $this->doFormInput("Ne pas inclure l'article en cours,filtres_ignoresingle?",$instance,false,'<br>');
			}
		echo z('fieldset');
		echo a('hr');
		
		// TITRE ///////////////////
		echo a('fieldset.titre');
			echo '<legend><h3>Titre</h3></legend>';
			echo $this->doFormInput("Titre,titre",$instance,false,'<br>');
			echo $this->doFormInput("Masquer le titre,titre_masquer?",$instance,false,'<br>');
			echo $this->doFormInput("Icône,titre_icone",$instance,false,'<br>');
		echo z('fieldset');
		echo a('hr');
		
		// APPARENCE ///////////////////
//			echo $this->doFormInput("ONE",$instance,false,'<br>');
		echo a('fieldset.apparence');
			echo '<legend><h3>Apparence</h3></legend>';
			echo $this->doFormInput("Disposition,apparence_disposition::",$instance,"Blog,blog;Carousel,carousel;Wallpin,wallpin",'<br>');
			if($instance['apparence_disposition']=="blog") {
				echo '<p>Pas d\'options pour cette apparence.</p>';
			}
			elseif($instance['apparence_disposition']=="carousel") {
				echo '<h4>Options du Carousel</h4>';
				echo $this->doFormInput("Afficher indicators,apparence_carousel_indicators?",$instance,false,'<br>');
				echo $this->doFormInput("Afficher controls,apparence_carousel_controls?",$instance,false,'<br>');
				echo $this->doFormInput("Positionner les controls sous le carousel,apparence_carousel_controlsbas?",$instance,false,'<br>');
				echo $this->doFormInput("Hauteur du carousel,apparence_carousel_hauteur09",$instance,false,'<br>');
			}
			elseif($instance['apparence_disposition']=="wallpin") {
				echo '<h4>Options du Wallpin</h4>';
				echo $this->doFormInput("Nombre de colonnes,apparence_wallpin_colonnes::",$instance,"2 colonnes,a/b;3 colonnes,a/b/c;4 colonnes,a/b/c/d;6 colonnes,a/b/c/d/e/f",'<br>');
				echo $this->doFormInput("Utiliser les classes Bootstrap,apparence_wallpin_bootstrap?",$instance,false,'<br>');
			}
		echo z('fieldset');
		echo a('hr');
		
		// AFFICHAGE ///////////////////
//			echo $this->doFormInput("ONE",$instance,false,'<br>');
		echo a('fieldset.affichage');
			echo '<legend><h3>Affichage</h3></legend>';
			echo $this->doFormInput("Modèle,affichage_modele::",$instance,"Liste,affichage_modele_liste;Liste group,affichage_modele_listegroup;Liste médias,affichage_modele_listemedias;Thumbnails,affichage_modele_thumbnail",'<br>');
			if($instance['affichage_modele']=="affichage_modele_liste") {
				echo '<h4>Options de Liste</h4>';
				echo $this->doFormInput("Type,affichage_liste_type::",$instance,"ul/li,ul-li;ol/li,ol-li;dl/dt/dd,dl-dt-dd",'<br>');
				echo $this->doFormInput("Masquer les puces,affichage_liste_unstyled?",$instance,false,'<br>');
				echo $this->doFormInput("Horizontale,affichage_liste_horizontale?",$instance,false,'<br>');
			}
		echo z('fieldset');
		echo a('hr');
			
		// CONTENU ///////////////////
//			echo $this->doFormInput("ONE",$instance,false,'<br>');
		echo a('fieldset.contenu');
			echo '<legend><h3>Contenu</h3></legend>';
			echo $this->doFormInput("Inclure un extrait,contenu_excerpt?",$instance,false,'<br>');
			if($instance['contenu_excerpt']=="on") {
				echo '<h4>Options d\'extrait</h4>';
				echo $this->doFormInput("Nombre de mots,contenu_excerpt_nbmots09",$instance,false,'<br>');
				echo $this->doFormInput("Inclure un lien -Lire la suite-,contenu_lirelasuite?",$instance,false,'<br>');
				echo $this->doFormInput("Sous forme de bouton,contenu_lirelasuite_btn?",$instance,false,'<br>');
				echo $this->doFormInput("Couleur du bouton,contenu_lirelasuite_btncolor",$instance,false,'<br>');
				echo $this->doFormInput("Label -Lire la suite-,contenu_lirelasuite_txt",$instance,false,'<br>');
			}
			echo $this->doFormInput("Afficher le footer,contenu_footer_afficher?",$instance,false,'<br>');
			if($instance['contenu_footer_afficher']=="on") {
				echo '<h4>Options de Footer</h4>';
				echo $this->doFormInput("Afficher la date,contenu_footer_date?",$instance,false,'<br>');
				echo $this->doFormInput("Afficher l'auteur,contenu_footer_auteur?",$instance,false,'<br>');
				echo $this->doFormInput("Afficher le nombre de commentaires,contenu_footer_commentaires?",$instance,false,'<br>');
				echo $this->doFormInput("Afficher le nombre de vues,contenu_footer_vues",$instance,false,'<br>');
			}
		echo a('hr');
		
		// VIGNETTE ///////////////////
//			echo $this->doFormInput("ONE",$instance,false,'<br>');
			echo '<legend><h3>Vignette</h3></legend>';
			echo $this->doFormInput("Afficher la vignette,vignette_afficher?",$instance,false,'<br>');
			if($instance['vignette_afficher']=="on") {
				echo '<h4>Options de Vignette</h4>';
				echo $this->doFormInput("Dimensions,vignette_dimensions::",$instance,"Thumbnail,thumbnail;Medium,medium;Large,large;Custom,custom_*",'<br>');
				echo $this->doFormInput("Forcer ces dimensions,vignette_dimensions_force",$instance,false,'<br>');
				echo $this->doFormInput("Alignement de l'image,vignette_alignement::",$instance,"Gauche,gauche;Droite,droite;Centre,centre;Aucun,aucun",'<br>');
				echo $this->doFormInput("Style de l'image,vignette_style::",$instance,"Cercle,style_cercle;Arrondi,style_arrondi;Thumbnail,style_thumbnail;",'<br>');
				echo $this->doFormInput("Image responsive,vignette_responsive?",$instance,false,'<br>');
			}
		echo z('fieldset');
				
		// ETENDUE ///////////////////
		echo a('fieldset.etendue');
			echo '<legend><h3>Etendue</h3></legend>';
			echo $this->doFormInput("Masquer le widget sauf sur les pages cochées suivantes,etendue_masquer?",$instance,false,'<br>');
			echo $this->doFormInput("Page home,etendue_site_home?",$instance,false,'<br>');
			echo $this->doFormInput("Page frontpage,etendue_site_frontpage?",$instance,false,'<br>');
			echo $this->doFormInput("Page category,etendue_site_category?",$instance,false,'<br>');
			echo $this->doFormInput("Page 404,etendue_site_404?",$instance,false,'<br>');
			echo $this->doFormInput("Page search,etendue_site_search?",$instance,false,'<br>');
			echo $this->doFormInput("Page tag,etendue_site_tag?",$instance,false,'<br>');
			echo $this->doFormInput("Page single,etendue_site_single?",$instance,false,'<br>');
			echo $this->doFormInput("Page page,etendue_site_page?",$instance,false,'<br>');
			echo $this->doFormInput("Page attachment,etendue_site_attachment?",$instance,false,'<br>');
		echo z('fieldset');
		echo a('hr');
			
	}
	
	function getOptions($which) {
		switch($which) {
			default: return array(); break;
			case 'filtres_categories':
				return get_categories();
			break;
		}
	}
	
	function doFormInput($string,$instance=false,$options=false,$after=false) { // 'Afficher un titre,afficher_titre ?'
	// Création de formulaire en parallèle avec bodyloop.php, le widget
		include 'bodyloop/bodyloop_functions.php';
		return $form_item.$after;
	}
} // Fin de la classe

// Fonctions supplémentaires
	function Get_thumbnail($instance) {
		if($instance['vignette_afficher'] == true && has_post_thumbnail()) {
			$image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), $instance['vignette_dimensions']);
			if ( $instance['vignette_dimensions_force']!=false ) {
				$S = explode( 'x' , $instance['vignette_dimensions_force'] );
				$wh = 'width="'.$S[0].'" height="'.$S[1].'"';
			}
			else $wh = 'width="'.$image_url[1].'" height="'.$image_url[2].'"';
			
			$res = '';
			$res .= '<a href="'.get_permalink().'">';
			$res .= '<img class="'.$instance['vignette_style'].' '.($instance['vignette_responsive']==true ? 'img-responsive' : false).'" src="'.$image_url[0].'" '.$wh.' alt="'.get_the_title().'">';
			$res .= '</a>';
			
			return $res;
		}
	}
	
	function Get_excerpt($instance,$before=false,$after=false) {
		if($instance['contenu_excerpt']=='on') {
			if ( $instance['contenu_lirelasuite'] ) {
				if( $instance['contenu_lirelasuite_btn'] ) {
					$linkmore = '<br><a href="'.get_permalink().'" class="btn btn-'.$instance['contenu_lirelasuite_btncolor'].' more-link" role="button">'.$instance['contenu_lirelasuite_txt'].'</a>';
				}
				else {
					$linkmore = ' <a href="'.get_permalink().'" class="more-link">'.$contenu_lirelasuite_txt.'</a>';
				}
			}
			else {
				$linkmore ='';
			}
		
			return $before.get_the_excerpt() .'&hellip;' . $linkmore .$after;
		}
	}
?>