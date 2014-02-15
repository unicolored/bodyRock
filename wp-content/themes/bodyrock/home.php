<?php
// Si le visiteur a vu un post avant d'arriver sur cette page,
// je récupère par SESSIONS via single.php, les tags et les catégories de ce post pour faire des recommandations ici-même.
/*TOFIX : Translate this page*/

br_ajaxWidgetInstance(isset($_GET['instance']) ? $_GET['instance'] : false);

get_header();

$args_section = array(
	'before_widget' => '<section class="widget">',
	'after_widget' => "</section>",
	'before_title' => '<h1>',
	'after_title' => '</h1>'
);

/************** HTML START **************/

echo a('section.content');

	if(get_query_var('paged')<2) {
			
		//MODULE:: RECOMMANDATIONS basées sur les CATEGORIES 
		if (isset($_SESSION['lastpost_cats']) && $_SESSION['lastpost_cats']!=false) {
			// QUERY
			$CAT = explode(',',$_SESSION['lastpost_cats']);
		
			$i=0;
			foreach($CAT as $IDCAT) {
				if($IDCAT!=false && $i<=1) {
					$category = get_category($IDCAT);
					
					if($i>0) {
						$ignore_posts = explode(',',$_SESSION['wposts_'.$category_name[$i-1]]);
						$ignore_posts[] = $_SESSION['lastpost_id'];
					}
					
					$category_name[$i] = 'recommandations_cats_'.$category->slug;
					
					$instance_recommandations_categories = array(
					'titre' => ucfirst($category->name),
					'titre_icone' => "star",
					'name' => $category_name[$i],
					'class' => 'recommandations',
					'contenu_excerpt' => false,
					'filtres_combien' => 6,
					'contenu_footer_date' => "on",
					'vignette_background' => 'on',
					'filtres_similaires_selon' => 'cats',
					'filtres_categories_'.$IDCAT => true
					);
					
					$instance_recommandations_categories['filtres_ignoreposts'] = serialize($ignore_posts);
					
					the_widget('br_widgetsBodyloop',$instance_recommandations_categories,$args_section);
					
					$i++;						
				}
			}	
		}
		
		echo '<hr class="clearfix">';
	}
	
	if ( have_posts() ) {
		
		$instance_articles_recents = array(
			'titre'=>'Articles récents',
			'titre_icone'=>'bookmark',
			'name'=>'articlesrecents',
			'class' => 'recommandations',
			
			'contenu_footer_date' => "on",
			
			'filtres_off'=>'on',
			'ajax'=>false
		);

		if($_SESSION['lastpost_id']!=false) {
			$instance_articles_recents['ajax'] = "on";
		}
		$_SESSION['lastpost_id'] = false;
		
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