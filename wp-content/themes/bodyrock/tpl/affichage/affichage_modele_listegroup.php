<?php

echo a('article.article.affichage.mod-listegroup',"#post-".get_the_ID());

	if($instance['affichage_listegroup_unlink']==false) {
		echo '<a href="'.get_permalink().'" class="list-group-item '.(get_the_ID()==$active_single_id && is_single() ? 'active' : false).'">';
	}
		
		if($instance['contenu_header_masquer']==false) {
			echo a('header.art-header');
				echo '<h4 class="list-group-item-heading" itemprop="name">'.get_the_title().'</h4>';
			echo z('header');
		}
		
		echo a('p.list-group-item-text');
		if($instance['vignette_masquer'] == false) {
			echo Get_thumbnail($instance);
		}
		
		$br_excerpt = Get_excerpt($instance,false,false,$excerpt[$i]);
		if ($instance['affichage_liste_type'] != 'dl-dt-dd' && $br_excerpt!=false) {	
			if ( $instance['contenu_excerpt']=='on' ) {
				echo a('section.art-content');
					echo $br_excerpt;
				echo z('section');
			}
			
			echo Get_artfooter($instance);
		}
		echo z('p');
	
	if($instance['affichage_listegroup_unlink']==false) {
		echo '</a>';
	}
	
echo z('article');