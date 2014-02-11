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
//vardump($_SESSION['lastpost_cats']);
//vardump($_SESSION['lastpost_tags']);
if (isset($_SESSION['lastpost_cats']) && $_SESSION['lastpost_cats']!=false) {
	// QUERY
	$exclude = explode(',',$posts_recommande);
	
	$instance_recommandations_categories = array(
	'titre' => "Recommandations",
	'titre_icone' => "star",
	'name' => 'recommandations_categories',
	'vignette_masquer' => "on",
	'contenu_excerpt' => false,
	);
	
	$categories_recommandees = $_SESSION['lastpost_cats'];				
	$c = explode(',',$categories_recommandees);
	foreach ($c as $id_cat) {
		if ($id_cat>0) {
			$instance_recommandations_categories['filtres_categories_'.$cat->term_id];
		}
	}			
}
if (isset($_SESSION['lastpost_tags']) && $_SESSION['lastpost_tags']!=false) {
	// Uniquement si un post contenant des tags a été visité avant cette page		

	$instance_recommandations_tags = array(
		'titre_masquer' => "on",
		'name' => 'recommandations_tags',
		'filtres_off' => 'on',
		'edit_article_titre' => 'replace_br',
		'vignette_masquer' => "on",
		
		'contenu_excerpt' => false,
		'filtres_tags' => $_SESSION['lastpost_tags']!=false ? $_SESSION['lastpost_tags'] : false,
		'filtres_ignoresingle' => array($_SESSION['lastpost_id'])
	);
}
/************** HTML START **************/

if ( have_posts() ) :
echo a('section.content');
	echo a('div.galaxie');
			the_widget('br_widgetsBodyloop',array('titre'=>'Articles récents','name'=>'home-widget-first','titre_icone'=>'bookmark','apparence_disposition'=>'wallpin','apparence_wallpin_colonnes'=>'a/b/c/d/e/f','filtres_off'=>'on'),$args_section);
	echo z('div');
	// Previous/next post navigation.
	echo '<div class="col-ff visible-lg">';
	br_paging_nav();
	echo '</div>';
echo z('section');
endif;
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