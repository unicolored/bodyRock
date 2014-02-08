<?php
// Si le visiteur a vu un post avant d'arriver sur cette page,
// je récupère par SESSIONS via single.php, les tags et les catégories de ce post pour faire des recommandations ici-même.
/*TOFIX : Translate this page*/

get_header();

$args = array(
	'before_widget' => '<aside class="widget">',
	'after_widget' => "<hr class='clearfix'></aside>",
	'before_title' => '<h1>',
	'after_title' => '</h1>'
);
$args_section = array(
	'before_widget' => '<section class="widget">',
	'after_widget' => "<hr class='clearfix'></section>",
	'before_title' => '<h1>',
	'after_title' => '</h1>'
);

/************** HTML START **************/

echo a('section.content');
	echo a('div.galaxie');
	
		if ( have_posts() ) :
			$titre = __("Articles récents", "bodyrock");
			if(is_category()) {
				$cat = get_query_var('cat');
				$active_categorie = get_category ($cat);
				$titre = ucfirst(str_replace('<br>','',$active_categorie->name));
			}
			the_widget('br_widgetsBodyloop',array('titre'=>$titre,'name'=>'home-widget-first','titre_icone'=>$active_categorie->slug,'apparence_disposition'=>'wallpin','filtres_off'=>'on','filtres_combien'),$args_section);
			// Previous/next post navigation.
			echo '<div class="visible-lg">';
			br_paging_nav();
			echo '</div>';
		endif;
	
	echo z('div');
echo z('section');
/*
echo a('section.content');
	echo a('div.galaxie');
		
		//MODULE:: RECOMMANDATIONS basées sur les CATEGORIES 
		if (isset($_SESSION['lastpost_cats']) && $_SESSION['lastpost_cats']!=false) {
			echo a('section.categories_recommandees'); // Classe définie dans less/structure/sections				
			the_widget('br_widgetsBodyloop',$instance_recommandations_categories,$args_section);
			echo z('/section');
		}
		
		//MODULE:: RECOMMANDATIONS basées sur les TAGS 
		if (isset($_SESSION['lastpost_tags']) && $_SESSION['lastpost_tags']!=false) {
			// Uniquement si un post contenant des tags a été visité avant cette page
			the_widget('br_widgetsBodyloop',$instance_recommandations_tags,$args_section);
		}
	
	echo z('div');
echo z('section');
*/
get_template_part(TPL_SIDEBAR_PATH.'sidebar','left');

get_footer();


?>