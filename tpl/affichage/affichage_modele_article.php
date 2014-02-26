<?php

echo a('article.article.affichage.mod-article','#post-'.get_the_ID());

if($instance['contenu_header_masquer']==false) {
	echo a('header.art-header');
	echo '<h1 itemprop="name"><a href="'.get_permalink().'">'.get_the_title().'</a></h1>';
	echo z('/header');
}
	
if($instance['vignette_masquer'] == false) {
	echo Get_thumbnail($instance);
}

$br_excerpt = Get_excerpt($instance,false,false,$excerpt[$i]);
if ($br_excerpt!=false && $instance['contenu_excerpt']=='on') {
	echo a('section.art-content');
		echo $br_excerpt;
	echo z('/section');
}

echo Get_artfooter($instance);

echo z('article');

