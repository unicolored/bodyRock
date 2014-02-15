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

$titre_content = __("Articles récents", "bodyrock");

if(is_category()) {
	$cat = get_query_var('cat');
	$active_categorie = get_category ($cat);
	$titre_content = ucfirst(str_replace('<br>','',$active_categorie->name));
}

/************** HTML START **************/

echo a('section.content');
	echo a('div.galaxie');
	
		// TITRE DE LA PAGE
		if ( is_search() || is_tag() ) {
			echo '<div class="column">';
			if ( is_search() ) {
				echo '	<h1>Trouver <span class="red"><em>'.get_query_var('s').'</em></span></h1>';
			}
			elseif ( is_tag() ) {
				echo '	<h1>Trouver <span class="red"><em>'.get_query_var('tag').'</em></span></h1>';
			}
			get_search_form();
			echo '</div>';
			echo '<hr class="clearfix">';
			
			$titre_content = "<h1>Résultats</h1>";
		}
	
		if ( have_posts() ) :
			
			the_widget('br_widgetsBodyloop',array(
				'titre'=>$titre_content,
				'class'=>'recommandations',
				'name'=>'home-widget-first',
				'titre_icone'=>$active_categorie->slug,
				'apparence_disposition' => 'wallpin',
				'apparence_wallpin_colonnes' => 'a/b/c/d/e/f',
				'vignette_background' => 'on',
				'affichage_modele' => 'affichage_modele_thumbnail',
				'contenu_footer_date' => "on",
				'filtres_off'=>'on',
				'ajax'=>false
				),$args_section);
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