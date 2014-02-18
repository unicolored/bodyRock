<?php

// BODYLOOP form /////////////////////////////////////////////

/*//**//**//**//*//**//**//**//*//**//**//**//*//**//**//**/
// 
/*//**//**//**//*//**//**//**//*//**//**//**//*//**//**//**/


		/*$default_instance = getDefaultLoop();
		foreach($default_instance as $k => $val) {
			//echo $k.'::'.$val.'<br>';
			
			if(!isset($instance[$k])) {
				$instance[$k] = $val;
			}
		}*/
//		the_widget('br_widgetsBodyloop',$instance);

		$args = false;
		$instance_show = $instance;		
		if($instance['contenu_excerpt']==false) {			
			$instance_show['contenu_excerpt_nbmots'] =false;
		}
		
		if($instance['contenu_lirelasuite']==false) {		
			$instance_show['contenu_lirelasuite'] ='false';	
			$instance_show['contenu_lirelasuite_btn'] =false;
			$instance_show['contenu_lirelasuite_btncolor'] =false;
			$instance_show['contenu_lirelasuite_txt'] =false;			
		}
		
		if($instance['titre_masquer']==true) {			
			$instance_show['titre'] =false;
			$instance_show['titre_format'] =false;
			$instance_show['titre_icone'] =false;
			$instance_show['titre_separator'] =false;
		}
		
		if($instance['etendue_masquer']==false) {
			$wordpress_pages = array("front_page","home","category","404","search","tag","page","single","attachment");
			foreach($wordpress_pages as $P) {
				$instance_show['etendue_site_'.$P] =false;
			}
		}
		
		if($instance['filtres_off']==true) {
			$instance_show['filtres_type']=false;
			$instance_show['filtres_combien']=false;
			$instance_show['filtres_orderby']=false;
			$instance_show['filtres_order']=false;
			$instance_show['filtres_resultats_lies']=false;
			$instance_show['offset']=false;
			$instance_show['false']=false;
			$instance_show['filtres_catsinornot']=false;
		}
		else {
			// $FILTRES_TYPES
			$types_options = array("type_post"=>"post","type_page"=>"page","type_attachment"=>"attachment");
			$args['post_type'] = $types_options[$instance['filtres_type']];
	
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
			$args['order'] = $instance['filtres_order'];
			
			// $FILTRES_OFFSET
			$args['offset'] = $filtres_offset;
			

			
			// $FILTRES_CATSIN
			//if($instance['filtres_resultats_lies']=='resultats_select') {
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
	//		$args['category__in'] = "'".$filtres_catsin."'";
			
			if($filtres_catsin!=false) {
				$args['category__'.$instance['filtres_catsinornot']] = '$category_in';
				$preargs[$args['category__in1']] = '
// Articles filtré par catégories
$category_in = '.($filtres_catsin!=false ? "'".$filtres_catsin."'" : "false").';
';
			}
			//}
			// SINON ON FILTRE SELON L'ARTICLE EN COURS
			if($instance['filtres_resultats_lies']=='resultats_similaires') {
				// SELON LES CATEGORIES
				if($instance['filtres_similaires_selon']=='both' || $instance['filtres_similaires_selon']=='cats') {
					$args['category__in'] = '$category_in';
					$preargs[$args['category__in']] = '
// Articles similaires
// aux catégories du single
if(is_singular()) {
$pc = wp_get_post_categories( get_the_ID() );
$cats = array();
$param_cat = "";
foreach($pc as $c) {
	$cat = get_category( $c );
	$cats[] = array(
		"name" => $cat->name,
		"slug" => $cat->slug
	);
	$category_in .= $cat->cat_ID.",";
}
}
';
				}
				// SELON LES TAGS
				if($instance['filtres_similaires_selon']=='both' || $instance['filtres_similaires_selon']=='tags') {
					$args['tag__in'] = '$tag_ids';
					$preargs[$args['tag__in']] = '
// Articles similaires
// aux tags du single
if(is_singular()) {
$tags = wp_get_post_tags($post->ID);
foreach($tags as $individual_tag) {
	$tag_ids[] = $individual_tag->term_id;
}
}
';
				}
			}
			
			// post__not_in
			if($instance['filtres_ignoreposts']==true) {
				$args['post__not_in'] = 'array($posts_notin)';
				$preargs[$args['post__not_in']] = '
// Ne pas inclure l\'article single
if(is_singular()) {'."\n".'$posts_notin = get_the_ID();'."\n".'}
';
			}
		}
		
		echo a('div.ofthewidget');
		
		if($instance['filtres_off']==false) {
			// AFFICHAGE DE LA REQUETE
			$theargs = "";
			$thepreargs = "";
			if($args!=false) {
				$c=1;
				if(is_array($preargs)) {
				foreach($preargs as $A=>$val) {
					$thepreargs .= $val;
				}
				}
				foreach($args as $A=>$val) {
					$virgule = $c>1 ? ",\n" : false;
					if($val!=getDefaultLoop($A) && $val != false) {
	//					echo $A.'::&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.getDefaultLoop($A).' / '.$instance[$A].'<br>';
						$theargs .= $virgule."'".$A."' => ".($val=="false" ? "false" : "'".$val."'");
						$c++;
					}
				}
				$theargs = $theargs=="" ? "// Tous les paramètres sont par défaut." : $theargs;
				echo("
	<pre  class='prettyprint'>
	".$thepreargs."\n
	".'$args'." = array(\n"
	.$theargs.
	"\n);\n
	".'$query_posts'." = new Wp_Query(".'$args'.")</pre>
				"
				);
			}
			else {
				echo("
	<pre  class='prettyprint linenums'>
	".'$query_posts'." = new Wp_Query()</pre>
				"
				);
			}
				getRefreshBtn('Rafraîchir $args');		
			echo a('hr');
		}
		
        apply_filters( 'widget_title', $title);
		
		echo a('style');
		echo '
            .ofthewidget fieldset {
                border-bottom:1px dotted #333; margin:1em 0; padding:1em 0;
				border:2px solid #ddd;
				padding:10px;
            }
            .ofthewidget fieldset legend {
                color:#aaa; background:#ddd; display:block; width:auto; padding:0em 1em;
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
		echo "<link rel='stylesheet' id='style-prettify-css'  href='http://bodyrock.gilleshoarau.com/wp-content/themes/bodyrock/assets/js/libs/prettify/prettify.css?ver=mar13' type='text/css' media='' />";
		echo "<script type='text/javascript' src='http://bodyrock.gilleshoarau.com/wp-content/themes/bodyrock/assets/js/libs/prettify/run_prettify.js?ver=3.8'></script>";
		
		// FILTRES ///////////////////
//			echo $this->doFormInput("ONE",$instance,false,'<br>');
		echo a('fieldset.filtres');
			echo '<legend><h4>'.$this->doFormInput("Désactiver les filtres,filtres_off?",$instance,false,'').'</h4></legend>';
			if($instance['filtres_off']==false) {
				echo $this->doFormInput("post_type,filtres_type::",$instance,"Articles,type_post;Pages,type_page;Médias,type_attachment",'<br>');
				echo $this->doFormInput("orderby,filtres_orderby::",$instance,"date,orderby_date;title,orderby_titre;comment_count,orderby_comment;post_views_count,orderby_nombredevue",'');
				echo $this->doFormInput("order,filtres_order::",$instance,"DESCendant,DESC;ASCendant,ASC",'<br>');
				echo $this->doFormInput("posts_per_page,filtres_combien09",$instance,false,'<br><small>Si vide, se base sur la valeur définie dans <a href="/wp-admin/options-reading.php">Réglages/Lecture</a></small><br>');
				echo $this->doFormInput("<span title='Ignorer les x premiers articles'>offset</span>,filtres_offset09",$instance,false,'<br>');
				echo $this->doFormInput("Il faut,filtres_catsinornot::",$instance,"uniquement inclure,in;uniquement exclure,not_in",'<br>');
				echo $this->doFormInput("category__".$instance['filtres_catsinornot'].",filtres_categories()?",$instance,false,'<hr>');
				echo $this->doFormInput("Il faut,filtres_tagsinornot::",$instance,"uniquement inclure,in;uniquement exclure,not_in",'<br>');
				echo $this->doFormInput("tags__".$instance['filtres_tagsinornot'].",filtres_tags",$instance,false,'<hr>');
				echo $this->doFormInput("Sur page single,filtres_resultats_lies::",$instance,"ne rien changer,resultats_select;résultats similaires,resultats_similaires",'<br>');
				if($instance['filtres_resultats_lies']=="resultats_similaires") {
					echo $this->doFormInput("...selon,filtres_similaires_selon::",$instance,"---,---;Catégories,cats;Tags,tags;Les deux,both",'<br>');
				}
				echo $this->doFormInput("Ne pas inclure l'article single,filtres_ignoreposts?",$instance,false,'<br>');
			}
			else {
				echo '<p>Le widget se base sur la loop $wp_query globale lorsque tous les filtres sont activés.</p>';
				echo '<p>Activer les filtres pour générer des requêtes de filtrages de votre contenu.</p>';
				echo '<p>Le code ci-dessous intégré dans une template, chargera le contenu basée sur la requête globale.</p>';
			}
		echo z('fieldset');
		echo a('hr');
		
		// AFFICHAGE DE L'INSTANCE
		$theinstance = "";
		$c=1;
		foreach($instance_show as $A=>$val) {
			$virgule = $c>1 ? ",\n" : false;
			if($A!=false) {
//				echo $A.'::&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.getDefaultLoop($A).' / '.$instance[$A].'<br>';
				if($val!=getDefaultLoop($A) && $val != false) {
//					echo $A.'::&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.getDefaultLoop($A).' / '.$instance[$A].'<br>';

					$theinstance .= $virgule."'".$A."' => ".($val=="false" ? "false" : "'".$val."'");
					$c++;
				}
			}
		}
		if($theinstance=="") {
			echo("
<pre  class='prettyprint'>
the_widget('br_widgetsBodyloop');
</pre>
		"
			);
		}
		else {
			echo("
<pre  class='prettyprint'>
".'$instance'." = array(\n"
.$theinstance.
"\n);\n
the_widget('br_widgetsBodyloop',".'$instance'.");
</pre>
		"
			);
		}
		getRefreshBtn('Rafraîchir $instance');	
		echo a('hr');
		
		// TITRE ///////////////////
		echo a('fieldset.titre');
			echo '<legend><h4>'.$this->doFormInput("Titre,titre",$instance,false,'').' '.$this->doFormInput("h,titre_format::",$instance,"1,h1;2,h2;3,h3;4,h4;5,h5;6,h6",'<br>').' '.$this->doFormInput("Sép.,titre_separator::",$instance,"Aucun,span.brsep;hr,hr;br,br",'').' '.$this->doFormInput("Masquer le titre,titre_masquer?",$instance,false,'<br>').'</h4></legend>';
			if($instance['titre_masquer']==false) {
				echo $this->doFormInput("Icône,titre_icone",$instance,false,'<br>');
			}
			echo $this->doFormInput("Nom identifiant,name",$instance,false,'');
			echo $this->doFormInput("Classe du widget,class",$instance,false,'');
			// TOFIX : Ajouter un footer au widget : lien, bouton	
			
		echo z('fieldset');		
		
		// APPARENCE ///////////////////
//			echo $this->doFormInput("ONE",$instance,false,'<br>');
		echo a('fieldset.apparence');
			echo '<legend><h4>'.$this->doFormInput("Apparence,apparence_disposition::",$instance,"Blog,blog;Carousel,carousel;Wallpin,wallpin",'<br>').'</h4></legend>';
			if($instance['apparence_disposition']=="blog") {
				echo '<p>Les résultats apparaissent les uns après les autres.</p>';
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

		// AFFICHAGE ///////////////////
//			echo $this->doFormInput("ONE",$instance,false,'<br>');
		echo a('fieldset.affichage');
			echo '<legend><h3>Affichage</h3></legend>';
			echo $this->doFormInput("Modèle,affichage_modele::",$instance,"Liste,affichage_modele_liste;Liste group,affichage_modele_listegroup;Médias,affichage_modele_listemedias;Thumbnails,affichage_modele_thumbnail;Articles,affichage_modele_article",'<br>');
			if($instance['affichage_modele']=="affichage_modele_liste") {
				echo '<h4>Options de Liste</h4>';
				echo $this->doFormInput("Type,affichage_liste_type::",$instance,"ul/li,ul-li;ol/li,ol-li;dl/dt/dd,dl-dt-dd",'<br>');
				echo $this->doFormInput("Masquer les puces,affichage_liste_unstyled?",$instance,false,'<br>');
				echo $this->doFormInput("Horizontale,affichage_liste_horizontale?",$instance,false,'<br>');
			}
			if($instance['affichage_modele']=="affichage_modele_listemedias") {
				echo '<h4>Options de <a href="http://getbootstrap.com/components/#media" target="_blank">#media</a></h4>';
				echo $this->doFormInput("Supprimer le lien de l'image,affichage_listemedias_unlink_img?",$instance,"",'<br>');
			}
			if($instance['affichage_modele']=="affichage_modele_listegroup") {
				echo '<h4>Options de <a href="http://getbootstrap.com/components/#list-group" target="_blank">#list-group</a></h4>';
				echo $this->doFormInput("Supprimer le lien par défaut,affichage_listegroup_unlink?",$instance,"",'<br>');
			}
		echo z('fieldset');
			
		// CONTENU ///////////////////
//			echo $this->doFormInput("ONE",$instance,false,'<br>');
		echo a('fieldset.contenu');
			echo '<legend><h4>'.$this->doFormInput("Masquer le header,contenu_header_masquer?",$instance,false,'<br>').'</h4></legend>';
			echo $this->doFormInput("Inclure un extrait,contenu_excerpt?",$instance,false,'<br>');
			if($instance['contenu_excerpt']==true) {
				echo $this->doFormInput("Nombre de mots,contenu_excerpt_nbmots09",$instance,false,'<br>');
			}
			echo $this->doFormInput("Inclure un lien -Lire la suite-,contenu_lirelasuite?",$instance,false,'<br>');
			if($instance['contenu_lirelasuite']=="on") {
				echo $this->doFormInput("Sous forme de bouton,contenu_lirelasuite_btn?",$instance,false,'<br>');
				echo $this->doFormInput("Couleur du bouton,contenu_lirelasuite_btncolor::",$instance,"Défaut,default;Primaire,primary;Infos,info;Succès,success;Avertissement,warning;Danger,danger",'<br>');
				echo $this->doFormInput("Label -Lire la suite-,contenu_lirelasuite_txt",$instance,false,'<br>');
			}
			echo $this->doFormInput("Masquer le footer,contenu_footer_masquer?",$instance,false,'<br>');
			if($instance['contenu_footer_masquer']==false) {
				echo '<h4>Options de Footer</h4>';
				echo $this->doFormInput("Afficher la date,contenu_footer_date?",$instance,false,'<br>');
				echo $this->doFormInput("Afficher l'auteur,contenu_footer_auteur?",$instance,false,'<br>');
				echo $this->doFormInput("Afficher le nombre de commentaires,contenu_footer_commentaires?",$instance,false,'<br>');
				echo $this->doFormInput("Afficher le nombre de vues,contenu_footer_vues?",$instance,false,'<br>');
				echo $this->doFormInput("Afficher le footer,contenu_footer_separateur",$instance,false,'<br>');
			}
			echo $this->doFormInput("Séparateur entre les articles,articles_separator::",$instance,"Aucun,span.brsep;hr,hr;br,br",'<br>');
		echo a('hr');
		
		// VIGNETTE ///////////////////
//			echo $this->doFormInput("ONE",$instance,false,'<br>');
			echo '<legend><h4>'.$this->doFormInput("Masquer la vignette,vignette_masquer?",$instance,false,'<br>').'</h4></legend>';
			if($instance['vignette_masquer']==false) {
				echo '<h4>Options de Vignette</h4>';
				echo $this->doFormInput("Dimensions,vignette_dimensions::",$instance,"Thumbnail,thumbnail;Medium,medium;Large,large;Custom,custom_*",'<br>');
				echo $this->doFormInput("Image en background,vignette_background?",$instance,false,'<br>');
				echo $this->doFormInput("Forcer ces dimensions,vignette_dimensions_force",$instance,false,'<br>');
				echo $this->doFormInput("Alignement de l'image,vignette_alignement::",$instance,"Gauche,gauche;Droite,droite;Centre,centre;Aucun,aucun",'<br>');
				echo $this->doFormInput("Style de l'image,vignette_style::",$instance,"Aucun,---;Cercle,style_cercle;Arrondi,style_arrondi;Thumbnail,style_thumbnail",'<br>');
				echo $this->doFormInput("Image non responsive,vignette_nonresponsive?",$instance,false,'<br>');
			}
		echo z('fieldset');
		
		// ETENDUE ///////////////////
		echo a('fieldset.etendue');
			echo '<legend><h4>'.$this->doFormInput("Masquer le widget sauf sur certaines pages,etendue_masquer?",$instance,false,'').'</h4></legend>';
			if($instance['etendue_masquer']==true) {
				echo $this->doFormInput("Page home,etendue_site_home?",$instance,false,'<br>');
				echo $this->doFormInput("Page frontpage,etendue_site_front_page?",$instance,false,'<br>');
				echo $this->doFormInput("Page category,etendue_site_category?",$instance,false,'<br>');
				echo $this->doFormInput("Page 404,etendue_site_404?",$instance,false,'<br>');
				echo $this->doFormInput("Page search,etendue_site_search?",$instance,false,'<br>');
				echo $this->doFormInput("Page tag,etendue_site_tag?",$instance,false,'<br>');
				echo $this->doFormInput("Page single,etendue_site_single?",$instance,false,'<br>');
				echo $this->doFormInput("Page page,etendue_site_page?",$instance,false,'<br>');
				echo $this->doFormInput("Page attachment,etendue_site_attachment?",$instance,false,'<br>');
			}
		echo z('fieldset');
		
		echo z('div');
		