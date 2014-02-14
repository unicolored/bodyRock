<?php

echo a('article.article.affichage.mod-thumbnail',"#post-".get_the_ID());

	echo a('div.thumbnail');

		if(has_post_thumbnail() || get_post_format()=="video") {
			echo a('section.art-vignette');
				echo Get_thumbnail($instance);
			echo z('section');
		}
		
		echo a('div.caption');
		
			if($instance['contenu_header_masquer']==false) {
				echo a('header.art-header');
				echo '<h1 itemprop="name"><a href="'.get_permalink().'" itemprop="url">'.get_the_title().'</a></h1>';
				echo z('header');
			}
			
			$br_excerpt = Get_excerpt($instance,a('section.art-content'),z('section'),$excerpt[$i]);
			if ( $instance['contenu_excerpt']=='on' && $br_excerpt!=false) {
				echo "<div itemprop='description'>".$br_excerpt."</div>";
			}
			
			echo Get_artfooter($instance);

			
		echo z('/div');
		echo '<hr class="clearfix">';
	echo z('/div');
	
echo z('article');	