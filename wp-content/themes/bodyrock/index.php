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
			'contenu_footer_date' => "on",
			'filtres_off'=>'on',
			'ajax'=>false
			),$args_section);
		// Previous/next post navigation.
		echo '<div class="visible-lg">';
		br_paging_nav();
		echo '</div>';
	endif;
	
echo z('section');

get_template_part(TPL_SIDEBAR_PATH.'sidebar','left');

get_footer();


?>