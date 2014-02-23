<?php
echo a('article.article.affichage.mod-liste',"#post-".get_the_ID());

if(isset($instance['contenu_header_masquer']) && $instance['contenu_header_masquer']==false) {
	echo a('header.art-header');
	echo '<a href="'.get_permalink().'" rel="bookmark" title="'.the_title_attribute( 'echo=0' ).'" class="post-title" itemprop="name">'.get_the_title().'</a>';
	echo z('header');
}

$br_excerpt = Get_excerpt($instance,false,false,$excerpt[$i]);
if (isset($instance['contenu_excerpt']) && $instance['contenu_excerpt']=='on' && $instance['affichage_liste_type'] != 'dl-dt-dd' && $br_excerpt!=false) {
	echo a('section.art-content');
		echo $br_excerpt;
	echo z('section');
}

if(isset($instance['vignette_masquer']) && $instance['vignette_masquer'] == false) {
	echo Get_thumbnail($instance);
}

echo Get_artfooter($instance);

echo z('article');
?>