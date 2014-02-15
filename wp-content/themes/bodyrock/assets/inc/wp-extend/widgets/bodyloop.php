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
		include 'bodyloop/bodyloop_widget.php';
	}
	
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	// ENREGISTREMENT DES DONNEES DU WIDGET	///////////////////////////////////////////
	function update($new_instance, $old_instance) {
		if($new_instance['affichage_modele']=='affichage_modele_listemedias') {
			$new_instance['affichage_liste_type'] = "ul-li";
		}
		
		return $new_instance;
	}	

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	// FORMULAIRE D'EDITION DU WIDGET	///////////////////////////////////////////
	function form( $instance ) {		
		include 'bodyloop/bodyloop_form.php';			
	}
	
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//// METHODES SUPPLEMENTAIRES
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
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
		if(has_post_thumbnail() || get_post_format()=="video") {
			$attrs = false;
			$vignette_dimensions = 	(isset($instance['vignette_dimensions']) ? $instance['vignette_dimensions'] : getDefaultLoop('vignette_dimensions'));
			$attrs = br_getPostThumbnail($vignette_dimensions,false);

			$image_url = $attrs['src'];
			$wh = false;
			if ( $instance['vignette_dimensions_force']!=0 ) {
				$S = explode( 'x' , $instance['vignette_dimensions_force'] );
				$wh = 'width="'.$S[0].'" height="'.$S[1].'"';
			}
			elseif(isset($attrs['width']) && isset($attrs['height'])) {
				$wh = 'width="'.$attrs['width'].'" height="'.$attrs['height'].'"';
			}
			
			//////////////
			
			if($instance['vignette_background']=="on") {
				
				$res .= '<section class="vignette-bg" style="background-image:url('.$attrs['src'].');"><img src="'.$attrs['src'].'" class="hidden" itemprop="thumbnailUrl"><h1><a href="'.get_permalink().'"><span>'.get_the_title().'</span></a></h1></section>';
			
			}
			else {
				
				$align=array("gauche"=>"pull-left","droite"=>"pull-right","centre"=>"center-block","aucun"=>false);
				
				$res = '';
				if($instance['affichage_listemedias_unlink_img']==false) {
					$res .= '<a class="'.$align[$instance['vignette_alignement']].'" href="'.get_permalink().'">';
				}
				$styles=array('style_cercle'=>'img-circle','style_thumbnail'=>'img-thumbnail','style_arrondi'=>'img-rounded');
	
				$res .= '<img src="'.$attrs['src'].'" '.$wh.' alt="'.get_the_title().'" itemprop="thumbnailUrl" class="media-object '.(isset($styles[$instance['vignette_style']]) ? $styles[$instance['vignette_style']] : false).' '.($instance['vignette_nonresponsive']==false ? 'img-responsive' : false).'">';
				
				if($instance['affichage_listemedias_unlink_img']==false) {
					$res .= '<span class="hover"></span></a>';
				}
				
			}
			
			
			return $res;
		}
	}
	
	function Get_excerpt($instance,$before=false,$after=false,$excerpt=false) {
		if ( $instance['contenu_lirelasuite'] == true && $instance['affichage_listegroup_unlink'] == true ) {
			if( $instance['contenu_lirelasuite_btn'] == true ) {
				$linkmore = '<br><a href="'.get_permalink().'" class="btn btn-'.$instance['contenu_lirelasuite_btncolor'].' more-link" role="button">'.$instance['contenu_lirelasuite_txt'].'</a>';
			}
			else {
				$linkmore = '<a href="'.get_permalink().'" class="more-link">'.$instance['contenu_lirelasuite_txt'].'</a>';
			}
		}
		else {
			$linkmore ='';
		}
		if($excerpt!=false) {
			return $before.$excerpt.$linkmore.$after;
		}
		else return false;
	}
	
	function Get_artfooter($instance) {
		if($instance['contenu_footer_masquer']==false) {
			if($instance['contenu_footer_date']=="on" || $instance['contenu_footer_auteur']=="on" || $instance['contenu_footer_commentaires']==false || $instance['contenu_footer_vues']=="on") {
				echo a('footer.art-footer');
					//echo a('div.well.well-sm');
					
					$sep = (isset($instance['contenu_footer_separateur']) ? $instance['contenu_footer_separateur'] : getDefaultLoop('contenu_footer_separateur'));
					
					$i=0;
					if($instance['contenu_footer_vues']=="on") {
						if($i==1) echo $sep;
						echo br_getIcon('stats').'&nbsp;'.getPostViews(get_the_ID());
						$i=1;
					}
					if($instance['contenu_footer_date']=="on") {
						if($i==1) echo $sep;
						echo br_getIcon('calendar').'&nbsp;'.__('Posté le','bodyrock').' <time class="entry-date" datetime="'.esc_attr( get_the_date( 'c' ) ).'" pubdate>'.esc_html( get_the_date() ).'</time>';
						$i=1;
					}
					if($instance['contenu_footer_auteur']=="on") {
						if($i==1) echo $sep;
						echo br_getIcon('user').'&nbsp;'.__('Ajouté par','bodyrock').' <a href="'.esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ).'" title="'.esc_attr( sprintf( __( 'Voir tous les articles de %s', 'bodyrock' ), get_the_author() ) ).'">'.get_the_author().'</a>';
						$i=1;
					}
					if($instance['contenu_footer_commentaires']=="on") {
						if(get_comments_number()>0) {
							if($i==1) echo $sep;
							echo $sep.br_getPageIcon('comment')."&nbsp;".get_comments_number()." ".__('commentaire(s)','bodyrock');
							$i=1;
						}
					}
					if (current_user_can('list-users')) {
						if($i==1) echo $sep;
						echo '<a href="/wp-admin/post.php?post='.get_the_ID().'&action=edit" class="editpost">'.br_getIcon('edit').'&nbsp;Editer</a>';
						$i=1;
					}
					//echo z('/div');
				echo z('/footer');
			}
		}
	}
	
	function getRefreshBtn($label) {
		echo a('div.widget-control-actions').a('div.alignleft').'<input name="savewidget" id="widget-br_widgetsbodyloop-2-savewidget" class="button button-primary widget-control-save right" value="'.$label.'" type="submit"><span style="display: none;" class="spinner"></span>'.z('div').a('br.clear').z('div');
	}
	
	function getDefaultLoop($val=false) {
		$default['filtres_off'] = "on";
		$default['filtres_type'] = "post";
		$default['filtres_combien'] = 8;
		$default['filtres_orderby'] = "date";
		$default['filtres_order'] = "DESC";
		$default['filtres_offset'] = 0;
		$default['filtres_catsinornot'] = "in";
		$default['filtres_categories'] = false;
		$default['filtres_tagsinornot'] = "in";
		$default['filtres_tags'] = false;
		$default['filtres_resultats_lies'] = "resultats_select";
		$default['filtres_similaires_selon'] = "both";
		$default['filtres_ignoreposts'] = "on";
		
		$default['apparence_disposition'] = "blog";
		$default['apparence_carousel_indicators'] = false;
		$default['apparence_carousel_controls'] = "on";
		$default['apparence_carousel_controlsbas'] = false;
		$default['apparence_carousel_duration'] = 4000;
		$default['apparence_carousel_hauteur'] = 0;
		$default['apparence_wallpin_colonnes'] = "a/b/c/d";
		$default['apparence_wallpin_bootstrap'] = "on";
		
		$default['affichage_modele'] = "affichage_modele_article";
		$default['affichage_liste_type'] = "dl-dt-dd";
		$default['affichage_liste_unstyled'] = false;
		$default['affichage_liste_horizontale'] = false;
		$default['affichage_listemedias_unlink_img'] = false;
		$default['affichage_listegroup_unlink'] = false;
		
		$default['contenu_header_masquer'] = false;
		$default['contenu_excerpt'] = false;
		$default['contenu_excerpt_nbmots'] = 0;
		$default['contenu_lirelasuite'] = "on";
		$default['contenu_lirelasuite_btn'] = false;
		$default['contenu_lirelasuite_btncolor'] = "primary";
		$default['contenu_lirelasuite_txt'] = "Lire la suite";
		$default['contenu_footer_masquer'] = false;
		$default['contenu_footer_date'] = false;
		$default['contenu_footer_auteur'] = false;
		$default['contenu_footer_commentaires'] = false;
		$default['contenu_footer_vues'] = false;
		$default['contenu_footer_separateur'] = " | ";
		
		$default['articles_separator'] = "span.brsep";
		
		$default['vignette_masquer'] = false;
		$default['vignette_dimensions'] = "medium";
		$default['vignette_background'] = false;
		$default['vignette_dimensions_force'] = false;
		$default['vignette_alignement'] = "aucun";
		$default['vignette_style'] = "---"; // Aucun,---;Cercle,style_cercle;Arrondi,style_arrondi;Thumbnail,style_thumbnail
		$default['vignette_nonresponsive'] = false;
		
		$default['etendue_masquer'] = false;
		// $default['etendue_site_*'] = false;
		$default['calldata'] = false; // Permet d'appeller une fonction qui récupère les donénes
		
		$random_titres = array("Ma nouvelle Loop","Une super requête","Un widget d'enfer","Mes articles préférés","Ceci n'est pas un titre","Tititre et raw minet");
		$default['titre'] = $random_titres[rand(0,(count($random_titres)-1))];
		$default['titre_format'] = "h1";
		$default['titre_separator'] = "span.brsep";
		$default['titre_masquer'] = false;
		$random_icone = array(
		"adjust",
		"align-center","align-left","align-right","align-justify","bold",		
		"arrow-down","arrow-left","arrow-right","arrow-up",
		"chevron-down","chevron-up","chevron-left","chevron-right",		
		"asterisk",
		"calendar","camera","bell","book","briefcase","bullhorn",
		"barcode","bookmark","certificate","check",		
		"comment","edit",		
		"cloud","cog","credit-card","dashboard","download","eject","envelope",
		"fast-backward","fast-forward","file","film","filter","fire","flag","folder-open","font","forward",
		"gbp","usd",
		"gift","glass","globe","headphones","heart","home","inbox","italic","leaf","link","list","list-alt","lock","magnet","map-marker",
		"minus","music","pause","pencil","phone","plane","play","play-circle","plus","print","qrcode","random","refresh","repeat","retweet","road",
		"search","share","shopping-cart","signal","star","step-backward","step-forward","stop","tag","tags","tasks","text-height","text-width",
		"th","th-large","th-list","thumbs-down","thumbs-up","tint","upload","user","volume-down","volume-off","volume-up","wrench"
		);
		$default['titre_icone'] = $random_icone[rand(0,(count($random_icone)-1))];	
		$default['edit_article_titre'] = false; // Fonction qui édite le titre avant son affichage. Exemple : replace_br()
		$random_name = array("verycool","pasmal","sympathique","jeanlouis","jaimebien","nomsympa","whynot");
		$default['name'] = $random_name[rand(0,(count($random_name)-1))];
		$default['class'] = false;
		
		if($val!=false) {			
			return $default[$val];
		}
		else return $default;
	}
	
	// edit_article_titre parameters
	function replace_br($txt) {
		$txt = str_replace("<br />","",$txt);
		$txt = str_replace("<br/>","",$txt);
		return str_replace("<br>","",$txt);
	}
?>