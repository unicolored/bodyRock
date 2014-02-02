<?php
get_header();

// Sélection du Template $tpl
$tpl = $post->post_type;
$tpl = (is_archive()) ? 'archive' : $tpl;
$tpl = (is_author()) ? 'author' : $tpl;
$tpl = (is_category()) ? 'category' : $tpl;
$tpl = (is_home()) ? 'home' : $tpl;
$tpl = (is_search()) ? 'search' : $tpl;
$tpl = (is_tag()) ? 'tag' : $tpl;

/************** HTML START **************/

echo a('section.content');

// BARRE DE RECHERCHE SUR search AND tag
if ( is_search() || is_tag() ) {
	echo '<div class="column">';
	if ( is_search() ) {
		echo '	<h1>'.__('Trouver','bodyrock').' <span class="red"><em>'.get_query_var('s').'</em></span></h1>';
	}
	elseif ( is_tag() ) {
		echo '	<h1>'.__('Trouver','bodyrock').' <span class="red"><em>'.get_query_var('tag').'</em></span></h1>';
	}
	get_search_form();
	echo '</div>';
}
echo a('div.galaxie');
the_widget('br_widgetsBodyloop',array('apparence'=>'carousel','template'=>'articles'));
echo z('div');

echo a('div.galaxie');
if ( have_posts() ) :

	while ( have_posts() ) :
	
		the_post();

		get_template_part(TPL_PATH.'index', $tpl); // Template $tpl sélectionnée dans les premières lignes de ce fichier
	   
	endwhile;
	
else:

	echo '<p>'.__('Aucun article ne correspond à vos critères.', 'bodyrock').'</p>';
	
endif;
echo z('/div');

echo z('section');

get_template_part(TPL_SIDEBAR_PATH.'sidebar','left');

get_footer();
?>
