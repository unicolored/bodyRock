<?php
// Retourne les classes basées sur les types de pages Wordpress
if ( !function_exists( 'getBodyClass' ) ) {
  function getBodyClass() {
    $bodyClass['parent']  = 'default';
    $bodyClass['child']   = false;
    // FILTRES GERES PAR WORDPRESS
    if(is_front_page()) { // Page d'accueil
      $bodyClass['parent'] = 'frontpage';
    }
    elseif(is_page()) { // Pages
      $page_id = get_queried_object_id();
      $p = get_post($page_id);
      $bodyClass['parent'] = $p->post_name;
    }
    elseif(is_single()) { // Articles
      $bodyClass['parent'] = 'single';
    }
    elseif(is_home()) { // Articles
      $bodyClass['parent'] = 'blog';
    }
    elseif (is_category()) { // Catégories
      $currentCategoryID = get_query_var('cat');
      $currentCategory = get_category($currentCategoryID);
      $currentCategoryParent = $currentCategory->parent;
      ////////////////////////////////////////////////////////////////////////////////
      if ( $currentCategoryParent > 0 ) {
        $parentCatName = get_cat_name(get_ancestors($currentCategoryID,'category')[0]);
        $bodyClass['parent']  = sanitize_title($parentCatName);
        $bodyClass['child']   = 'cat-child-'.$currentCategory->slug;
      }
      else {
        $bodyClass['parent']  = $currentCategory->slug;
      }
    }
    return $bodyClass;
  }
}

// Retourne la classe Parente d'un article (qui n'appartient pas forcément à cette catégorie mais qui appartient à un enfant)
// Cette classe doit aussi être confronté à une liste de Catégories Principales et non pas à une catégorie qui sert de filtre
function br_getParentCatFromChild() {
  $CATEGORIES_DU_POST = wp_get_post_categories(get_the_ID());

  foreach ( $CATEGORIES_DU_POST as $CATEGORIE_DU_POST ) {
    //vardump( $CATEGORIE_DU_POST);
    //vardump( get_cat_name($CATEGORIE_DU_POST ));
    // ... on récupère SES ancêtres, ou SON ancêtre
    //// DEUX OPTIONS :
    // 1. Si cette Catégorie est déjà une Catégorie Principale
    $CATEGORIES_PARENTES_PRINCIPALES = getCategoriesParentesPrincipales();
    if(in_array($CATEGORIE_DU_POST,$CATEGORIES_PARENTES_PRINCIPALES)) {
      $CatParent = $CATEGORIE_DU_POST;
    }
    else {
      $ANCETRES_DE_CETTE_CATEGORIE = get_ancestors($CATEGORIE_DU_POST , 'category');
      foreach ( $ANCETRES_DE_CETTE_CATEGORIE as $ANCETRE ) {
        // Et si cet Ancêtre est une des Catégories Parentes Principales ...
        if(in_array($ANCETRE,$CATEGORIES_PARENTES_PRINCIPALES)) {
          $CatParent = $ANCETRE;
        }
      }
    }
  }
  return $CatParent;
}

if ( !function_exists( 'getCategoriesParentesPrincipales' ) ) {
  // Retourne la liste des Catégories Principales
  function getCategoriesParentesPrincipales() {
    return array();
  }
}

// Retourne la catégorie "Principale" utilisée par la page ou le Post
function br_mainCategory() {
  $mainCategory = 'Pas de Parent';
  if ( is_home() ) {
    // Je récupère la catégorie Prioritaire sur un article
    $categorie_Utile = get_category(1);
  }
  elseif ( is_single() ) {
    // Je récupère la catégorie Prioritaire sur un article
    $categorie_Utile = get_category(br_getParentCatFromChild());
  }
  elseif ( is_category() ) {
    // Je récupère la catégorie Affichée et donc Utile
    $categorie_Utile = get_category(get_query_var('cat'));
  }
  /////////
  $eventuelle_categorie_parente = $categorie_Utile->parent;
  if ($eventuelle_categorie_parente > 0) {
    // Cette catégorie possède un Parent, elle est donc Enfant
    $mainCategory = get_category($eventuelle_categorie_parente)->slug;
    // /$mainCategory['Child'] = $categorie_Utile->slug;
  }
  else {
    // La catégorie n'a pas de Parent, elle est donc Parent, pas d'enfant
    $mainCategory = $categorie_Utile->slug;
  }
  return $mainCategory;
}

// SET LAST VIEWS /////////////////////////////////////////////
// Enregistre les identifiants des derniers contenus vus en session.
function br_modules_lastviewsSet() {
  $articles = (isset($_SESSION['br_lastviews']) ? $_SESSION['br_lastviews'] : array());
  $articles = array_unique($articles);
  $c = count($articles);
  //echo $c;
  if(is_page() || is_single()) {
    $key = array_search(get_the_ID(), $articles);
    if ( $key > 0 ) {
      unset($articles[$key]);
    }
    else {
      unset($articles[0]);
    }
    $articles = array_values($articles);
    $articles[] = get_the_ID();
  }
  elseif(is_tag()) {
    $key = array_search('tag:'.get_query_var('tag'), $articles);
    if ( $key > 0 ) {
      unset($articles[$key]);
    }
    else {
      unset($articles[0]);
    }
    $articles = array_values($articles);
    $articles[] = 'tag:'.get_query_var('tag');
  }
  elseif(is_search()) {
    $key = array_search('search:'.get_query_var('s'), $articles);
    if ( $key > 0 ) {
      unset($articles[$key]);
    }
    else {
      unset($articles[0]);
    }
    $articles = array_values($articles);
    $articles[] = 'search:'.get_query_var('s');
  }
  elseif(is_category()) {
    $key = array_search('cat:'.get_query_var('cat'), $articles);
    if ( $key > 0 ) {
      unset($articles[$key]);
    }
    else {
      unset($articles[0]);
    }
    $articles = array_values($articles);
    $articles[] = 'cat:'.get_query_var('cat');
  }
  for ($i=0;$i<=5;$i++) {
    $navbar_items[$i] = (isset($articles[$i]) ? $articles[$i] : false);
  }
  return array_values($navbar_items);
}

// https://github.com/jubianchi/wp-bootstrap/blob/master/functions.php
function bootstrap_breadcrumbs() {
	global $post, $wp_query, $theme_config;

	//$delimiter = '<span class="divider">/</span>';
	$delimiter = false;
	$home      = br_getIcon('home').' '.__('Home');				// text for the 'Home' link
	$before    = '<li class="active">';		// tag before the current crumb
	$after     = '</li>';					// tag after the current crumb
	//if ($theme_config['show_breadcrumb'] > 0 && ($theme_config['show_breadcrumb'] == 1 || ($theme_config['show_breadcrumb'] == 2 && !is_home() && !is_front_page() || is_paged()))) {
		$homeLink = get_bloginfo('url');

		echo '<ol class="breadcrumb">';
		//echo '<li><a href="' . $homeLink . '">' . $home . '</a> ' . $delimiter . '</li> ';

		if (is_category()) {
			$cat_obj   = $wp_query -> get_queried_object();
			$thisCat   = $cat_obj -> term_id;
			$thisCat   = get_category($thisCat);
			$parentCat = get_category($thisCat -> parent);

			if($thisCat -> parent != 0) {
				echo(get_category_parents($parentCat, TRUE, ' ' . $delimiter . ' '));
			}

			echo $before . __('Archives de la catégorie', 'wpbootstrap') . ' "' . single_cat_title('', false) . '"' . $after;
		} elseif (is_day()) {
			echo '<li><a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . '</li> ';
			echo '<li><a href="' . get_month_link(get_the_time('Y'),get_the_time('m')) . '">' . get_the_time('F') . '</a> ' . $delimiter . '</li> ';
			echo $before . get_the_time('d') . $after;

		} elseif ( is_month() ) {
			echo '<li><a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . '</li> ';
			echo $before . get_the_time('F') . $after;

		} elseif ( is_year() ) {
			echo $before . get_the_time('Y') . $after;
		} elseif ( is_single() && !is_attachment() ) {
			if ( get_post_type() != 'post' ) {
				$post_type = get_post_type_object(get_post_type());
				$slug = $post_type->rewrite;
				echo '<li><a href="' . $homeLink . '/' . $slug['slug'] . '/">' . $post_type->labels->singular_name . '</a> ' . $delimiter . '</li> ';
				echo $before . get_the_title() . $after;
			} else {
				$cat = get_the_category(); $cat = $cat[0];
				echo '<li>' . get_category_parents($cat, TRUE, '</li>' . $delimiter . '<li>') . '</li>';
				echo $before . get_the_title() . $after;
			}
		} elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
			$post_type = get_post_type_object(get_post_type());
			echo $before . $post_type->labels->singular_name . $after;
		} elseif ( is_attachment() ) {
			$parent = get_post($post->post_parent);
			$cat = get_the_category($parent->ID); $cat = $cat[0];
			echo '<li>' . get_category_parents($cat, TRUE, ' ' . $delimiter . ' ') . '</li>';
			echo '<li><a href="' . get_permalink($parent) . '">' . $parent->post_title . '</a> ' . $delimiter . '</li> ';
			echo $before . get_the_title() . $after;
		} elseif ( is_page() && !$post->post_parent ) {
			echo $before . get_the_title() . $after;
		} elseif ( is_page() && $post->post_parent ) {
			$parent_id  = $post->post_parent;
			$breadcrumbs = array();

			while ($parent_id) {
				$page = get_page($parent_id);
				$breadcrumbs[] = '<li><a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a></li>';
				$parent_id  = $page->post_parent;
			}

			$breadcrumbs = array_reverse($breadcrumbs);
			foreach ($breadcrumbs as $crumb) {
				echo $crumb . ' ' . $delimiter . ' ';
			}
			echo $before . get_the_title() . $after;
		} elseif ( is_search() ) {
			echo $before . 'Search results for "' . get_search_query() . '"' . $after;
		} elseif ( is_tag() ) {
			echo $before . 'Posts tagged "' . single_tag_title('', false) . '"' . $after;
		} elseif ( is_author() ) {
			global $author;

			$userdata = get_userdata($author);
			echo $before . 'Articles postés par ' . $userdata->display_name . $after;
		} elseif ( is_404() ) {
			echo $before . 'Error 404' . $after;
		}

		if ( get_query_var('paged') ) {
			if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';
			echo __('Page') . ' ' . get_query_var('paged');
			if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
		}

		echo '</ol>';
	//}
}
