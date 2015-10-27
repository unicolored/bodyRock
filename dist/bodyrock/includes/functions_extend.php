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
