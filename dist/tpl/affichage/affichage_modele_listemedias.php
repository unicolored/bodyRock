<?php

echo a('article.article.affichage.mod-listemedias',"#post-".get_the_ID());

if($instance['vignette_masquer'] == false) {
	echo Get_thumbnail($instance);
}

echo a('div.media-body');

	if($instance['contenu_header_masquer']==false) {
		echo a('header.art-header');
		echo '<h4 class="media-heading" itemprop="name">'.get_the_title().'</h4>';
		echo z('header');
	}

	$br_excerpt = Get_excerpt($instance,a('section.art-content').a('p'),z('p').z('section'),$excerpt[$i]);
	if ( $instance['contenu_excerpt']=='on' && $br_excerpt!=false) {	
		echo $br_excerpt!=false ? $br_excerpt : false;
	}
	
	echo Get_artfooter($instance);
	
echo z('/div');	

echo z('article');