<?php
// Si le visiteur a vu un post avant d'arriver sur cette page,
// je récupère par SESSIONS via single.php, les tags et les catégories de ce post pour faire des recommandations ici-même.
/*TOFIX : Translate this page*/

br_ajaxWidgetInstance(isset($_GET['instance']) ? $_GET['instance'] : false);

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

if (isset($_SESSION['lastpost_cats']) && $_SESSION['lastpost_cats']!=false) {
	// QUERY
	$exclude = explode(',',$posts_recommande);
	
	$instance_recommandations_categories = array(
	'titre' => "Recommandations",
	'titre_icone' => "star",
	'name' => 'recommandations_cats',
	'class' => 'recommandations',
	'contenu_excerpt' => false,
	'apparence_disposition' => 'wallpin',
	'apparence_wallpin_colonnes' => 'a/b/c/d/e/f',
	'affichage_modele' => 'affichage_modele_thumbnail',
	'filtres_combien' => 6,
	'vignette_background' => 'on',
	'filtres_similaires_selon' => 'cats',
	'filtres_ignoreposts' => array($_SESSION['lastpost_id']),
	'ajax'=>'on'
	);
	
	$categories_recommandees = $_SESSION['lastpost_cats'];				

	$c = explode(',',$categories_recommandees);
	foreach ($c as $k => $id_cat) {
		if ($id_cat>0) {
			$instance_recommandations_categories['filtres_categories_'.$id_cat]=true;
		}
	}	
}
if (isset($_SESSION['lastpost_tags']) && $_SESSION['lastpost_tags']!=false) {
	// Uniquement si un post contenant des tags a été visité avant cette page		

	$ignore_posts = explode(',',$_SESSION['wposts_recommandations_cats']);
	$ignore_posts[] = $_SESSION['lastpost_id'];

	$instance_recommandations_tags = array(
		'titre_masquer' => false,
		'name' => 'recommandations_tags',
		'class' => 'recommandations',
		'edit_article_titre' => 'replace_br',		
		'contenu_excerpt' => false,
		'apparence_disposition' => 'wallpin',
		'apparence_wallpin_colonnes' => 'a/b/c/d/e/f',
		'affichage_modele' => 'affichage_modele_thumbnail',
		'filtres_combien' => 6,
		'vignette_background' => 'on',
//		'contenu_header_masquer' => 'on',
		'filtres_similaires_selon' => 'tags',
		'filtres_article_reference' => $_SESSION['lastpost_id'],
//		'filtres_tags' => $_SESSION['lastpost_tags']!=false ? $_SESSION['lastpost_tags'] : false,
		'filtres_ignoreposts' => serialize($ignore_posts),
		'ajax'=>'on'
	);
}
/************** HTML START **************/

echo a('section.content');

	if(get_query_var('paged')<2) {
		echo a('div.galaxie');
			
			//MODULE:: RECOMMANDATIONS basées sur les CATEGORIES 
			if (isset($_SESSION['lastpost_cats']) && $_SESSION['lastpost_cats']!=false) {
				the_widget('br_widgetsBodyloop',$instance_recommandations_categories,$args_section);
			}
			
			//MODULE:: RECOMMANDATIONS basées sur les TAGS 
			if (isset($_SESSION['lastpost_tags']) && $_SESSION['lastpost_tags']!=false) {
				// Uniquement si un post contenant des tags a été visité avant cette page
				the_widget('br_widgetsBodyloop',$instance_recommandations_tags,$args_section);
			}
		
		echo z('div');
		
		echo '<hr class="clearfix">';
	}
	
	if ( have_posts() ) {
		
		$instance_articles_recents = array(
			'titre'=>'Articles récents',
			'class' => 'home-widget-first',
			'name'=>'articlesrecents',
			'titre_icone'=>'bookmark',
			'apparence_disposition' => 'wallpin',
			'apparence_wallpin_colonnes' => 'a/b/c/d/e/f',
			'vignette_background' => 'on',
			'affichage_modele' => 'affichage_modele_thumbnail',
			'contenu_footer_masquer' => 'on',
			'filtres_off'=>'on',
			'ajax'=>false
		);
		
		if(get_query_var('paged')>1) {
			$instance_articles_recents['titre'] = "Médiathèque";
		}
		
		the_widget('br_widgetsBodyloop',$instance_articles_recents,$args_section);
				
		// Previous/next post navigation.
		echo '<div class="col-ff visible-lg">';
		br_paging_nav();
		echo '</div>';	
	}
echo z('section');


get_template_part(TPL_SIDEBAR_PATH.'sidebar','left');


get_footer();


?>