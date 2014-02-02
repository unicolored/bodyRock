<?php

class br_widgetsBodyloop extends WP_Widget {
	
	// INIT	///////////////////////////////////////////
	function br_widgetsBodyloop() {		
		$widget_ops = array(
		'description' => __('Création de loop pour afficher les articles de votre choix en composants prédéfinis et personnalisables.','bodyrock')
		);
    	parent::WP_Widget(false, __('BR Bodyloop', 'bodyrock'), $widget_ops);
	}

	// AFFICHAGE DU WIDGET SUR LE FRONT-OFFICE	///////////////////////////////////////////
	function widget($args, $instance) {
        extract( $args );
		extract( $instance );
		
		$PRECONFIG['recentposts']['widget_title'] = __('Articles récents','bodyrock');
		$PRECONFIG['recentposts']['number'] = 5;
    
		
        if ( ! $number = absint( $instance['number'] ) ) $number = 5;			
        if ( ! $excerpt_length = absint( $instance['excerpt_length'] ) ) $excerpt_length = 5;			
        if( ! $cats = $instance["cats"] )  $cats='';			
        if( ! $show_type = $instance["show_type"] )  $show_type='post';			
        if( ! $thumb_h =  absint($instance["thumb_h"] ))  $thumb_h=50;			
        if( ! $thumb_w =  absint($instance["thumb_w"] ))  $thumb_w=50;			
        if( ! $excerpt_readmore = $instance["excerpt_readmore"] )  $excerpt_readmore='Read more &rarr;';			
        $default_sort_orders = array('date', 'title', 'comment_count', 'rand');			
        
        if ( in_array($instance['sort_by'], $default_sort_orders) ) {			
        $sort_by = $instance['sort_by'];			
        $sort_order = (bool) $instance['asc_sort_order'] ? 'ASC' : 'DESC';			
        } else {			
        // by default, display latest first			
        $sort_by = 'date';			
        $sort_order = 'DESC';			
        }
        
        //Excerpt more filter
        $new_excerpt_more= create_function('$more', 'return " ";');	
        add_filter('excerpt_more', $new_excerpt_more);
        
        // Excerpt length filter
        $new_excerpt_length = create_function('$length', "return " . $excerpt_length . ";");
        
        if ( $instance["excerpt_length"] > 0 ) add_filter('excerpt_length', $new_excerpt_length);
                    
        // post info array.
		
		$active_single_id = get_the_ID(); // On récupère avant la boucle, l'identifiant de l'article ou de la page en cours. On pourra ainsi savoir dans la boucle si un élément est "active"
		$active_single_type = get_post_type();
        
        $my_args=array(						   
            'showposts' => $number+$instance['jump'],
            'category__in'=> $cats,			
            'orderby' => $sort_by,			
            'order' => $sort_order,				
            'post_type' => $show_type				
            );
        
        $adv_recent_posts = null;			
        $adv_recent_posts = new WP_Query($my_args);			


        echo $before_widget;
		echo isset($title) ? $before_title.$title.$after_title : false;
		
		$classe_horizontale = ($liste_horizontale == true ? ".list-inline" : false);
		$classe_unstyled = ($liste_unstyled == true ? ".list-unstyled" : false);
		
		// AVANT LA BOUCLE				
		switch ($apparence) {
			case 'carousel':
				echo '
					<div class="bodyloop-carousel slide">


					<div class="carousel-inner">
				';
			break;
			
			case 'blog':
				switch ($template) {			
					case 'liste-group':	echo a('div.list-group'); break;
					case 'liste-media':	echo a('ul.media-list'); break;
				}
				
				switch ($liste_type) {
					case 'ul-li': echo a('ul'.$classe_horizontale.$classe_unstyled); break;
					case 'ol-li': echo a('ol'.$classe_horizontale.$classe_unstyled); break;
					case 'dl-dt-dd':
						$classe_horizontale = ($liste_horizontale == true ? ".dl-horizontal" : false);
						echo a('dl'.$classe_horizontale);
					break;
				}
			break;
			
			case 'wallpin':
				// WALLPIN
				$COLS = explode(',',$colnumber);
			break;
		}
		
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
			
			if($apparence=='wallpin') {
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
				switch ($apparence) {
					case 'carousel':
						echo '
							<div class="item '.($c==1?'active':false).'">
						';
					break;
				}
				
				if($c>$instance['jump']) {
					switch($instance['template']) {
						default :
						case 'liste' :
						case 'liste-media':
						
							switch ($liste_type) {
								default: echo a('li'.($template=='liste-media' ? '.media' : false)); break;
								case 'dl-dt-dd': echo a('dt'); break;
							}
							
							// ITEM //////////////
							if($template == 'liste-media') {
								if($thumb == true && has_post_thumbnail()) {
									$image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), $imagesize);
									if ( $forcesize!=false ) {
										$S = explode( 'x' , $forcesize );
										$wh = 'width="'.$S[0].'" height="'.$S[1].'"';
									}
									else $wh = 'width="'.$image_url[1].'" height="'.$image_url[2].'"';
									
									echo '<a class="'.$thumb_pull.'" href="'.get_permalink().'">';
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
															
								if ( $instance['excerpt']=='on' && $instance['liste_type'] != 'dl-dt-dd' ) {
									echo bodyloopGet_excerpt($instance);
								}
								
							}	
								
							// ITEM //////////////
							switch ($liste_type) {
								default: echo z('li'); break;
								case 'dl-dt-dd': echo z('dt'); break;
							}
							
							// Enfin, on affiche la description dans la balise dd si la liste est de type dl-dt-dd
							if ( $instance['excerpt']=='on' && $instance['liste_type'] == 'dl-dt-dd' ) {
								echo a('dd');
									echo bodyloopGet_thumbnail($instance);
									echo bodyloopGet_excerpt($instance);
								echo z('dd');
							}
							
						break;
						
						case 'liste-group':
						
							echo '
									<a href="'.get_permalink().'" class="list-group-item '.(get_the_ID()==$active_single_id && is_single() ? 'active' : false).'">
									<h4 class="list-group-item-heading">'.get_the_title().'</h4>
									';
									
										if ($liste_type != 'dl-dt-dd' ) {
										echo bodyloopGet_excerpt($instance,a('p.list-group-item-text'),z('p'));
										}
									echo ' </a>
	
							';
						break;
						
						case 'thumbnails':
							include(locate_template('assets/tpl/bodyloop/thumbnails.php'));
						break;
						case 'articles':
							include(locate_template('assets/tpl/index-home.php'));
						break;
					}
				}
				$c++;
				
				// APRES L'ITEM
				switch ($apparence) {
					case 'carousel':
						echo '
							</div>
						';
					break;
				}
			}
        }
		
		// APRES LA BOUCLE LA BOUCLE		
		switch ($apparence) {
			case 'carousel':
				echo '
					</div>
					</div>
				';
				
				echo "
				<script type='application/x-javascript'>
				// CAROUSEL
				if(jQuery('.bodyloop-carousel').length>0) {
					jQuery('.bodyloop-carousel').carousel({
					  interval: 4000
					});
					jQuery('.bodyloop-carousel-control').show();
				}
				</script>
				";
			break;
			
			case 'blog':
				switch ($liste_type) {
					default: echo z('ul'); break;
					case 'ol-li': echo z('ol'); break;
					case 'dl-dt-dd': echo z('dl'); break;
				}
				
				switch ($template) {
					case 'liste-group': echo z('div'); break;
					case 'liste-media':	echo z('ul'); break;
				}
			break;
		}
		
//		global $the_query, $cat, $articles, $a,$n,$i,$j,$k,$l, $nopagination;;
		
		// WALLPIN RESULTS
		if($apparence=='wallpin') {
			echo a('div.galaxie');		
			foreach($COLS as $ID) {
				$x = 12/count($COLS);
				echo '<div class="col-lg-'.$x.'">';
				for ( $i=1;isset($articles[$ID][$i]);$i++ ) {
					$post=$articles[$ID][$i];
					include(locate_template('assets/tpl/bootstrap/thumbnails.php'));
		//			get_template_part( 'tpl/content/item', get_post_format() );
				}
				echo '</div>';
			}
			echo z('/div');	
		}
		
        wp_reset_query();
		
            
        echo $after_widget;
                
		remove_filter('excerpt_length', $new_excerpt_length);
        remove_filter('excerpt_more', $new_excerpt_more);
	}
	
	// ENREGISTREMENT DES DONNEES DU WIDGET	///////////////////////////////////////////
	function update($new_instance, $old_instance) {
		return $new_instance;
	}	

	
	// FORMULAIRE D'EDITION DU WIDGET	///////////////////////////////////////////
	function form( $instance ) {
		extract($instance);
		
		
        apply_filters( 'widget_title', $title);
		
		$title = isset($instance['title']) ? esc_attr($instance['title']) : 'Recent Posts';
		$number = isset($instance['number']) ? absint($instance['number']) : 5;
		$thumb_h = isset($instance['thumb_h']) ? absint($instance['thumb_h']) : 50;
		$thumb_w = isset($instance['thumb_w']) ? absint($instance['thumb_w']) : 50;
		$show_type = isset($instance['show_type']) ? esc_attr($instance['show_type']) : 'post';
		$excerpt_length = isset($instance['excerpt_length']) ? absint($instance['excerpt_length']) : 5;
		$excerpt_readmore = isset($instance['excerpt_readmore']) ? esc_attr($instance['excerpt_readmore']) : 'Read more &rarr;';

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
		
		// TITRE ///////////////////
		echo a('fieldset.titre');
			echo '<legend><h3>Titre</h3></legend>';
			
			echo '<label for="'.$this->get_field_id('title').'">'.__("Titre du widget").'</label> ';
			echo '<input id="'.$this->get_field_id('title').'" name="'.$this->get_field_name('title').'" type="text" value="'.$title.'" />';
			echo a('br');
			echo '<label for="'.$this->get_field_id('class').'">'.__("Classe").'</label> ';
			echo '<input id="'.$this->get_field_id('class').'" name="'.$this->get_field_name('class').'" type="text" value="'.$class.'" />';		
		echo z('fieldset');
		echo a('hr');
		
		// APPARENCE ///////////////////
		echo a('fieldset.apparence');
			echo '<legend><h3>Apparence</h3></legend>';
			// Carousel Blog WallPin
			echo '<select name="'.$this->get_field_name("apparence").'" id="'.$this->get_field_id("apparence").'">';
				echo '<option value="blog" '.selected( $instance["apparence"], "blog",false ).'>Blog</option>';
				echo '<option value="carousel" '.selected( $instance["apparence"], "carousel",false ).'>Carousel</option>';
				echo '<option value="wallpin" '.selected( $instance["apparence"], "wallpin",false ).'>Wallpin</option>';
			echo '</select>';
			echo a('br');
			echo '<label for="'.$this->get_field_id('colnumber').'">'.__("Nombre de colonnes du Wallpin").'</label> ';
			echo '<select name="'.$this->get_field_name("colnumber").'" id="'.$this->get_field_id("colnumber").'">';
				echo '<option value="a,b" '.selected( $instance["colnumber"], "a,b",false ).'>2 colonnes</option>';
				echo '<option value="a,b,c" '.selected( $instance["colnumber"], "a,b,c",false ).'>3 colonnes</option>';
				echo '<option value="a,b,c,d" '.selected( $instance["colnumber"], "a,b,c,d",false ).'>4 colonnes</option>';
				echo '<option value="a,b,c,d,e,f" '.selected( $instance["colnumber"], "a,b,c,d,e,f",false ).'>6 colonnes</option>';
			echo '</select>';
		echo z('fieldset');
		echo a('hr');

		// TRI ///////////////////
		echo a('fieldset.tri');
			echo '<legend><h3>Filtres</h3></legend>';
			
			echo '<label for="'.$this->get_field_id('show_type').'">'.__("Afficher uniquement le type d'élements suivant").'</label> ';
			echo '<select name="'.$this->get_field_name("show_type").'" id="'.$this->get_field_id("show_type").'">';
				global $wp_post_types;
				foreach($wp_post_types as $k=>$sa) {
					if($sa->exclude_from_search) continue;
					echo '<option value="' . $k . '"' . selected($k,$show_type,false) . '>' . $sa->labels->name . '</option>';
				}
			echo '</select>';
			echo a('br');
			echo '<label for="'.$this->get_field_id('number').'">'.__("Nombre d'élément à afficher").'</label> ';
			echo '<input id="'.$this->get_field_id('number').'" name="'.$this->get_field_name('number').'" type="text" value="'.$number.'" size="5" />';
			echo a('br');
			echo '<label for="'.$this->get_field_id('sort_by').'">'.__("Trier par").'</label> ';
			echo '<select name="'.$this->get_field_name("sort_by").'" id="'.$this->get_field_id("sort_by").'">';
				echo '<option value="date" '.selected( $instance["sort_by"], "date",false ).'>Date</option>';
				echo '<option value="title" '.selected( $instance["sort_by"], "title",false ).'>Title</option>';
				echo '<option value="comment_count" '.selected( $instance["sort_by"], "comment_count",false ).'>Number of comments</option>';
				echo '<option value="rand" '.selected( $instance["sort_by"], "rand",false ).'>Random</option>';
			echo '</select>';
			echo a('br');
			echo '<input type="checkbox" class="checkbox" id="'.$this->get_field_id("asc_sort_order").'" name="'.$this->get_field_name("asc_sort_order").'" '.checked( (bool) $instance["asc_sort_order"], true,false ).' />';
			echo '<label for="'.$this->get_field_id('asc_sort_order').'">'.__("Inverser l'ordre").'</label> ';
			echo a('br');
			echo '<label for="'.$this->get_field_id('jump').'">'.__("Ignorer les x premiers articles ou x =").'</label> ';
			echo '<input id="'.$this->get_field_id('jump').'" name="'.$this->get_field_name('jump').'" type="text" value="'.$jump.'" size="5" />';
			echo a('br');
			echo '<h4>Catégories</h4>';
			
			$categories=  get_categories('hide_empty=0');
			foreach ($categories as $cat) {
				$option='<input type="checkbox" id="'. $this->get_field_id( 'cats' ) .'[]" name="'. $this->get_field_name( 'cats' ) .'[]"';
				if (is_array($instance['cats'])) {
					foreach ($instance['cats'] as $cats) {
						if($cats==$cat->term_id) {
							 $option=$option.' checked="checked"';
						}
					}
				}
				$option .= ' value="'.$cat->term_id.'" />';			
				$option .= $cat->cat_name;			
				$option .= '<br>';
				echo $option;
			}
		echo z('fieldset');
		echo a('hr');	
			
		// AFFICHAGE ///////////////////
		echo a('fieldset.affichage');
			echo '<legend><h3>Affichage</h3></legend>';
			
			// Modèle : template
			echo '<label for="'.$this->get_field_id('template').'">'.__("Modèle").'</label> ';
			echo '<select name="'.$this->get_field_name("template").'" id="'.$this->get_field_id("template").'">';
				echo '<option value="liste" '.selected( $instance["template"], "liste",false ).'>Liste</option>';
				echo '<option value="liste-group" '.selected( $instance["template"], "liste-group",false ).'>BR Liste groupe</option>';
				echo '<option value="liste-media" '.selected( $instance["template"], "liste-media",false ).'>BR Liste medias</option>';
				echo '<option value="thumbnails" '.selected( $instance["template"], "thumbnails",false ).'>BR Thumbnails</option>';
			echo '</select>';
			echo a('br');
			// Concernant le modèle Liste : liste_type
			echo '<label for="'.$this->get_field_id('liste_type').'">'.__("Concernant le modèle Liste").'</label> ';
			echo '<select name="'.$this->get_field_name("liste_type").'" id="'.$this->get_field_id("liste_type").'">';
				echo '<option value="ul-li" '.selected( $instance["liste_type"], "ul-li",false ).'>ul / li</option>';
				echo '<option value="ul-li" '.selected( $instance["liste_type"], "ol-li",false ).'>ol / li</option>';
				echo '<option value="dl-dt-dd" '.selected( $instance["liste_type"], "dl-dt-dd",false ).'>dl / dt / dd</option>';
			echo '</select>';
			echo a('br');
			echo a('br');
			// Retirer les puces : liste_unstyled
			echo '<input type="checkbox" class="checkbox" id="'.$this->get_field_id("liste_unstyled").'" name="'.$this->get_field_name("liste_unstyled").'" '.checked( (bool) $instance["liste_unstyled"], true,false ).' />';
			echo '<label for="'.$this->get_field_id('liste_unstyled').'">'.__("Retirer les puces").'</label> ';
			echo a('br');
			// Liste horizontale : liste_horizontale
			echo '<input type="checkbox" class="checkbox" id="'.$this->get_field_id("liste_horizontale").'" name="'.$this->get_field_name("liste_horizontale").'" '.checked( (bool) $instance["liste_horizontale"], true,false ).' />';
			echo '<label for="'.$this->get_field_id('liste_horizontale').'">'.__("Liste horizontale").'</label> ';
			echo a('br');
			// Enveloppe CSS (optionnel) : wrapper
			echo '<label for="'.$this->get_field_id('wrapper').'">'.__("Enveloppe CSS (optionnel)").'</label> ';
			echo '<input id="'.$this->get_field_id('wrapper').'" name="'.$this->get_field_name('wrapper').'" type="text" value="'.$wrapper.'" />';
			echo '<br><small>N\'est pas utilisée par les modèles <em>Liste</em> et <em>Media Liste</em></small>';
			echo a('br');
			// Inclure un extrait : excerpt
			echo '<input type="checkbox" class="checkbox" id="'.$this->get_field_id("excerpt").'" name="'.$this->get_field_name("excerpt").'" '.checked( (bool) $instance["excerpt"], true,false ).' />';
			echo '<label for="'.$this->get_field_id('excerpt').'">'.__("Inclure un extrait").'</label> ';
			echo a('br');
			// Si oui, nombre de mots : excerpt_length
			echo '<label for="'.$this->get_field_id('excerpt_length').'">'.__("Si oui, nombre de mots").'</label> ';
			echo '<input id="'.$this->get_field_id('excerpt_length').'" name="'.$this->get_field_name('excerpt_length').'" type="text" value="'.$excerpt_length.'" size="5" />';
			echo a('br');
			// Inclure un lien -Lire la suite- : readmore
			echo '<input type="checkbox" class="checkbox" id="'.$this->get_field_id("readmore").'" name="'.$this->get_field_name("readmore").'" '.checked( (bool) $instance["readmore"], true,false ).' />';
			echo '<label for="'.$this->get_field_id('readmore').'">'.__("Inclure un lien -Lire la suite-").'</label> ';
			echo a('br');
			// Sous forme de bouton : readmore_btn
			echo '<input type="checkbox" class="checkbox" id="'.$this->get_field_id("readmore_btn").'" name="'.$this->get_field_name("readmore_btn").'" '.checked( (bool) $instance["readmore_btn"], true,false ).' />';
			echo '<label for="'.$this->get_field_id('readmore_btn').'">'.__("Sous forme de bouton").'</label> ';
			echo a('br');
			// Sous forme de bouton : readmore_btn_color
			echo '<label for="'.$this->get_field_id('readmore_btn_color').'">'.__("Couleur du bouton").'</label> ';
			echo '<select name="'.$this->get_field_name("readmore_btn_color").'" id="'.$this->get_field_id("readmore_btn_color").'">';
				echo '<option value="default" '.selected( $instance["readmore_btn_color"], "default",false ).'>default</option>';
				echo '<option value="primary" '.selected( $instance["readmore_btn_color"], "primary",false ).'>primary</option>';
				echo '<option value="success" '.selected( $instance["readmore_btn_color"], "success",false ).'>success</option>';
				echo '<option value="info" '.selected( $instance["readmore_btn_color"], "info",false ).'>info</option>';
				echo '<option value="danger" '.selected( $instance["readmore_btn_color"], "danger",false ).'>danger</option>';
				echo '<option value="warning" '.selected( $instance["readmore_btn_color"], "warning",false ).'>warning</option>';
			echo '</select>';
			echo a('br');
			// Si oui, label -Lire la suite- : excerpt_readmore
			echo '<label for="'.$this->get_field_id('excerpt_readmore').'">'.__("Si oui, label -Lire la suite-").'</label> ';
			echo '<input id="'.$this->get_field_id('excerpt_readmore').'" name="'.$this->get_field_name('excerpt_readmore').'" type="text" value="'.$excerpt_readmore.'" />';
			echo a('br');
			// Afficher la date : date
			echo '<input type="checkbox" class="checkbox" id="'.$this->get_field_id("date").'" name="'.$this->get_field_name("date").'" '.checked( (bool) $instance["date"], true,false ).' />';
			echo '<label for="'.$this->get_field_id('date').'">'.__("Afficher la date").'</label> ';
			echo a('br');
			// Afficher le nombre de commentaires : comment_num
			echo '<input type="checkbox" class="checkbox" id="'.$this->get_field_id("comment_num").'" name="'.$this->get_field_name("comment_num").'" '.checked( (bool) $instance["comment_num"], true,false ).' />';
			echo '<label for="'.$this->get_field_id('comment_num').'">'.__("Afficher le nombre de commentaires").'</label> ';
		echo z('fieldset');
		echo a('hr');
		
		//if($template != 'liste') { // Pas de vignettes en mode Liste, c'est ainsi.
			// VIGNETTE ///////////////////
			echo a('fieldset.vignette');
				echo '<legend><h3>Vignette</h3></legend>';
				
				echo '<input type="checkbox" class="checkbox" id="'.$this->get_field_id("thumb").'" name="'.$this->get_field_name("thumb").'" '.checked( (bool) $instance["thumb"], true,false ).' />';
				echo '<label for="'.$this->get_field_id('thumb').'">'.__("Afficher la vignette").'</label> ';
				echo a('br');
				echo '<label for="'.$this->get_field_id('imagesize').'">'.__("Dimensions").'</label> ';
				echo '<select name="'.$this->get_field_name("imagesize").'" id="'.$this->get_field_id("imagesize").'">';
					$images_sizes = get_intermediate_image_sizes();
					foreach($images_sizes as $k=>$sa) {
						echo '<option value="' . $sa . '"' . selected($sa,$imagesize,false) . '>' . $sa . ' :: '.get_option( $sa.'_size_w' ).'x'.get_option( $sa.'_size_h' ).'px</option>';
					}
				echo '</select>';
				echo a('br');
				echo '<label for="'.$this->get_field_id('forcesize').'">'.__("Forcer les dimensions").'</label> ';
				echo '<input id="'.$this->get_field_id('forcesize').'" name="'.$this->get_field_name('forcesize').'" type="text" value="'.$forcesize.'" size="10" />';
				echo '<br><small>Force la taille de l\'image dans la balise img. Exemple : 50x50.</small>';
				echo a('br');
				echo '<label for="'.$this->get_field_id('thumb_pull').'">'.__("Alignement de l'image").'</label> ';
				echo '<select name="'.$this->get_field_name("thumb_pull").'" id="'.$this->get_field_id("thumb_pull").'">';
					echo '<option value="nopull" '.selected( $instance["thumb_pull"], "nopull",false ).'>Aucun</option>';
					echo '<option value="pull-left" '.selected( $instance["thumb_pull"], "pull-left",false ).'>Gauche</option>';
					echo '<option value="pull-right" '.selected( $instance["thumb_pull"], "pull-right",false ).'>Droite</option>';
				echo '</select>';
				echo a('br');
				echo '<label for="'.$this->get_field_id('imgstyle').'">'.__("Style de l'image").'</label> ';
				echo '<select name="'.$this->get_field_name("imgstyle").'" id="'.$this->get_field_id("imgstyle").'">';
					echo '<option value="img-nostyle" '.selected( $instance["imgstyle"], "img-nostyle",false ).'>Aucun</option>';
					echo '<option value="img-thumbnail" '.selected( $instance["imgstyle"], "img-thumbnail",false ).'>Thumbnail</option>';
					echo '<option value="img-rounded" '.selected( $instance["imgstyle"], "img-rounded",false ).'>Rounded</option>';
					echo '<option value="img-circle" '.selected( $instance["imgstyle"], "img-circle",false ).'>Circle</option>';
				echo '</select>';
				echo a('br');
				echo '<input type="checkbox" class="checkbox" id="'.$this->get_field_id("imgresponsive").'" name="'.$this->get_field_name("imgresponsive").'" '.checked( (bool) $instance["imgresponsive"], true,false ).' />';
				echo '<label for="'.$this->get_field_id('imgresponsive').'">'.__("Image responsive").' ('.__("recommandé").')</label> ';
			echo z('fieldset');
			echo a('hr');
		/*}
		else {
			echo a('fieldset.vignette');
				echo '<legend><h4>Pas de vignette disponible dans ce modèle d\'affichage.</h4></legend>';
			echo z('fieldset');
			echo a('hr');
		}*/
			
	}
}

?>