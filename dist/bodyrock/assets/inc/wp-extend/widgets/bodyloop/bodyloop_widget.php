<?php
// BODYLOOP Widget /////////////////////////////////////////////

/*//**//**//**//*//**//**//**//*//**//**//**//*//**//**//**/
// Widget de création d'affichage de contenus.
// Permet de filtrer l'ensemble des résultats, de choisir une template pour l'affichage et de personnaliser les données affichées.
/*//**//**//**//*//**//**//**//*//**//**//**//*//**//**//**/

// Variables externes
$active_single_id = get_the_ID();
// On récupère avant la boucle, l'identifiant de l'article ou de la page en cours. On pourra ainsi savoir dans la boucle si un élément est "active"
$active_single_type = get_post_type();

// Suppression de l'ajout du "suite" par défaut qui s'ajoute à l'excerpt lors de l'apperl à get_excerpt()
//$new_excerpt_more = create_function('$more', 'return " ";');
//add_filter('excerpt_more', $new_excerpt_more);

// Variables du widget
if (is_array($args)) {
    extract($args);
    // Les paramètres du widget liés à la sidebar : $before_widget, $after_widget, $before_title, $after_title
}

////////// 0. ETENDUE DU WIDGET
// Gestion de l'affichage en fonction de l'environnement Wordpress
// Si les conditions ne sont pas remplies, il n'y aura pas d'affichage du widget.

// Par défaut, le widget s'affiche sur toutes les pages sauf si l'option etendue_masque est activée, il faut alors avoir activée l'étendue sur les sous pages.
/*if($instance['etendue_masquer'] == true ) {
 $wordpress_pages = array("front_page","home","category","404","search","tag","page","single","attachment");
 foreach($wordpress_pages as $P) {
 if(isset($instance['etendue_site_'.$P]) && $instance['etendue_site_'.$P] == false && is_.$P()) { return false; }
 }
 }*/

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

////////// 1. TRAITEMENT ET CONVERSION DES VARIABLES
//
// Liste Horizontale
$classe_horizontale = false;
if (isset($instance['affichage_liste_horizontale']) && $instance['affichage_liste_horizontale'] == true) {
    $classe_horizontale = ($instance['affichage_liste_type'] == "dl-dt-dd" ? ".dl-horizontal" : ".list-inline");
}

// Liste sans puce
$classe_unstyled = (isset($instance['affichage_liste_unstyled']) && $instance['affichage_liste_unstyled'] == true ? ".list-unstyled" : false);

// Group_start et Item_start en fonction de affichage_liste_type
$modele_liste_type_group_start['ul-li'] = a('ul' . $classe_horizontale . $classe_unstyled);
$modele_liste_type_group_end['ul-li'] = z('ul');
$modele_item_start['ul-li'] = a('li' . ($instance['affichage_modele'] == 'affichage_modele_listemedias' ? '.media' : false));

$modele_liste_type_group_start['ol-li'] = a('ol' . $classe_horizontale . $classe_unstyled);
$modele_liste_type_group_end['ol-li'] = z('ol');
$modele_item_start['ol-li'] = a('li' . ($instance['affichage_modele'] == 'affichage_modele_listemedias' ? '.media' : false));

$modele_liste_type_group_start['dl-dt-dd'] = a('dl' . $classe_horizontale);
$modele_liste_type_group_end['dl-dt-dd'] = z('dl');
$modele_item_start['dl-dt-dd'] = a('dt');

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// Group_start en fonction de affichage_modele
// _thumbnail et _article n'utilisent pas de group_
// _liste
if (isset($instance['affichage_liste_type'])) {
    $disposition_group_start['affichage_modele_liste'] = isset($modele_liste_type_group_start[$instance['affichage_liste_type']]) ? $modele_liste_type_group_start[$instance['affichage_liste_type']] : false;
    $disposition_group_end['affichage_modele_liste'] = isset($modele_liste_type_group_end[$instance['affichage_liste_type']]) ? $modele_liste_type_group_end[$instance['affichage_liste_type']] : false;
}

// _listegroup
if (isset($instance['affichage_listegroup_unlink']) && $instance['affichage_listegroup_unlink'] == false) {
    $disposition_group_start['affichage_modele_listegroup'] = a('div.list-group');
} else {
    $disposition_group_start['affichage_modele_listegroup'] = a('ul.list-group');
}
if (isset($instance['affichage_listegroup_unlink']) && $instance['affichage_listegroup_unlink'] == false) {
    $disposition_group_end['affichage_modele_listegroup'] = z('div');
} else {
    $disposition_group_end['affichage_modele_listegroup'] = z('ul');
}

// _listemedias
$disposition_group_start['affichage_modele_listemedias'] = a('ul.media-list');
$disposition_group_end['affichage_modele_listemedias'] = z('ul');

// Item_start en fonction de affichage_modele et de affichage_liste_type
// _liste
if (isset($instance['affichage_liste_type'])) {
    $modele_item_start['affichage_modele_liste'] = isset($modele_item_start[$instance['affichage_liste_type']]) ? $modele_item_start[$instance['affichage_liste_type']] : false;
    $modele_item_end['affichage_modele_liste'] = isset($modele_item_start[$instance['affichage_liste_type']]) ? $modele_item_start[$instance['affichage_liste_type']] : false;
}

// _listegroup
if (isset($instance['affichage_listegroup_unlink']) && $instance['affichage_listegroup_unlink'] == false) {
    $modele_item_start['affichage_modele_listegroup'] = '<a href="getpermalink()" class="liste-group-item active">';
} else {
    $modele_item_start['affichage_modele_listegroup'] = a('li.list-group-item');
}
if (isset($instance['affichage_listegroup_unlink']) && $instance['affichage_listegroup_unlink'] == false) {
    $modele_item_end['affichage_modele_listegroup'] = z('a');
} else {
    $modele_item_end['affichage_modele_listegroup'] = z('li');
}
// _liste
if (isset($instance['affichage_liste_type'])) {
    $modele_item_start['affichage_modele_listemedias'] = isset($modele_item_start[$instance['affichage_liste_type']]) ? $modele_item_start[$instance['affichage_liste_type']] : false;
    $modele_item_end['affichage_modele_listemedias'] = isset($modele_item_start[$instance['affichage_liste_type']]) ? $modele_item_start[$instance['affichage_liste_type']] : false;
}

$modele_item_end['ul-li'] = z('li');
$modele_item_end['ol-li'] = z('li');
$modele_item_end['ol-li'] = z('dt');

$instance['name'] = (isset($instance['name']) ? $instance['name'] : getDefaultLoop('name'));

if (isset($instance['apparence_disposition']) && $instance['apparence_disposition'] == 'carousel') {

    wp_enqueue_script('script-carousel-' . $instance['name'], get_template_directory_uri() . '/js/carousel.php', array('script'), '1.0.1', false);
    // Add some parameters for the JS.
    $carouselname = 'br_carousel_' . $instance['name'];
    wp_localize_script('script-carousel-' . $instance['name'], 'sc_val', array('duration' => (isset($instance['apparence_carousel_duration']) ? $instance['apparence_carousel_duration'] : getDefaultLoop('apparence_carousel_duration')), 'carouselname' => $carouselname));
}

////////// 2. ENCADREMENT DU WIDGET
// $widget_start,$widget_end

// Widget_
if (isset($instance['class']) && $instance['class'] != false) {
    $before_widget = a('div.' . $instance['class'], "#" . $instance['name']) . $before_widget;
    $after_widget = $after_widget . z('div');
}
// Création de Widget_START
$icone_widget = (isset($instance['titre_icone']) ? br_getIcon($instance['titre_icone']) . '&nbsp;' : false);
$titre_format = (isset($instance['titre_format']) ? $instance['titre_format'] : getDefaultLoop('titre_format'));
$titre_widget = (isset($instance['titre_masquer']) && $instance['titre_masquer'] == false && isset($instance['titre']) ? a($titre_format . '.widget-title') . $icone_widget . $instance['titre'] . z($titre_format) : false);
$Widget_START = (isset($before_widget) ? $before_widget : false) . (isset($titre_widget) ? $titre_widget : false);

// Création de Widget_END
$Widget_END = isset($after_widget) ? $after_widget : false;

////////// 3. ENCADREMENT DU GROUPE D'ITEMS
//

// First_
$First_START['carousel'] = a('div.' . (isset($carouselname) ? $carouselname : 'carouseldefaultname') . '.slide');
$First_END['carousel'] = z('div');
$First_START['wallpin'] = a('div.galaxie');
$First_END['wallpin'] = z('div');

// Wrapper_
$Wrapper_START['carousel'] = a('div.carousel-inner');
$Wrapper_END['carousel'] = z('div');
$Wrapper_START['wallpin'] = a('div.wallpin');
$Wrapper_END['wallpin'] = z('div');

// Group_
$Group_START = isset($disposition_group_start[$instance['affichage_modele']]) ? $disposition_group_start[$instance['affichage_modele']] : false;
$Group_END = isset($disposition_group_end[$instance['affichage_modele']]) ? $disposition_group_end[$instance['affichage_modele']] : false;

// Colonne_
//	$Colonne_START['wallpin'] = a('div.col-lg-%s').a('div.galaxie'); // '<div class="item '.($c==1?'active':false).'">'
//	$Colonne_END['wallpin'] = z('div').z('div');
$Colonne_START['wallpin'] = a('div'.(isset($instance['apparence_wallpin_class']) && $instance['apparence_wallpin_class']!=false ? '.'.$instance['apparence_wallpin_class'] : '.'.getDefaultLoop('apparence_wallpin_class')));
// '<div class="item '.($c==1?'active':false).'">'
$Colonne_END['wallpin'] = z('div');

////////// 4. ENCADREMENT D'UN ITEM
// $item_start,$item_end

$WIrapper_START['carousel'] = '<div class="item %s">';
// '<div class="item '.($c==1?'active':false).'">'
$WIrapper_END['carousel'] = z('div');
$WIrapper_START['wallpin'] = '<div class="galaxie">';
// '<div class="item '.($c==1?'active':false).'">'
$WIrapper_END['wallpin'] = z('div');

if (isset($instance['affichage_liste_type'])) {
    $Item_START = isset($modele_item_start[$instance['affichage_liste_type']]) ? $modele_item_start[$instance['affichage_liste_type']] : false;
    $Item_END = isset($modele_item_end[$instance['affichage_liste_type']]) ? $modele_item_end[$instance['affichage_liste_type']] : false;
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

////////// 5. CONSTRUCTION DE LA REQUETE
// $args[]
$orderby_options = array("orderby_date" => "date", "orderby_dateedition" => "modified", "orderby_titre" => "title", "orderby_comment" => "comment_count", "orderby_nombredevue" => "meta_value_num");

if ($instance['filtres_off'] == false) {
    // CREATION D'UNE LOOP AUX PARAMETRES PERSONNALISES :: filtres_off = off :: les filtres sont activés
    wp_reset_query();
    // $FILTRES_TYPES
    if (isset($instance['filtres_type'])) {
        $query_args['post_type'] = TypeQuery($instance['filtres_type']);
    }

    // $FILTRES_COMBIEN
    //	$query_args['posts_per_page'] = ($instance['filtres_combien']!=false ? $instance['filtres_combien'] : getDefaultLoop('filtres_combien'));
    if (isset($instance['filtres_combien'])) {
        $query_args['posts_per_page'] = $instance['filtres_combien'];
    }

    // $FILTRES_ORDERBY // $FILTRES_ORDER
    $query_meta_key = false;
    if (isset($instance['filtres_orderby'])) {
        
        $query_args['orderby'] = $orderby_options[$instance['filtres_orderby']];
        switch($instance['filtres_orderby']) {
			default:
				$query_args['orderby'] = str_replace('orderby_','',$instance['filtres_orderby']);
			break;	
            case 'orderby_nombredevue' :
                $query_args['meta_key'] = "post_views_count";
                break;
        }
    }
    if (isset($instance['filtres_order'])) {
        // meta_key=post_views_count
        $query_args['order'] = $instance['filtres_order'];
    }

    // $FILTRES_OFFSET
    if (isset($instance['filtres_offset'])) {
        if ($instance['filtres_offset'] != false)
            $query_args['offset'] = $instance['filtres_offset'];
    }

    // SELON LES CATEGORIES
    //if (isset($instance['filtres_similaires_selon']) && $instance['filtres_similaires_selon'] == 'cats' || isset($instance['filtres_similaires_selon']) && $instance['filtres_similaires_selon'] == 'both') {

    // $FILTRES_CATSIN
    $filtres_catsin = "";
    $i = 1;
    foreach ($instance as $label => $value) {
        if (preg_match("/filtres_categories_/", $label, $cat) == 1) {

            $cat = preg_replace("/filtres_categories_/", "", $label);
            $filtres_catsin .= ($i > 1 ? "," : false) . $cat;
            $i++;
        }
    }
    if ($filtres_catsin != false)
        $query_args['category__' . (isset($instance['filtres_catsinornot']) ? $instance['filtres_catsinornot'] : getDefaultLoop('filtres_catsinornot'))] = "" . $filtres_catsin . "";
    //}

    // SELON LES TAGS
    if (isset($instance['filtres_similaires_selon']) && $instance['filtres_similaires_selon'] == 'tags' || isset($instance['filtres_similaires_selon']) && $instance['filtres_similaires_selon'] == 'both') {
        // Articles similaires
        // aux tags du single
        $tags = wp_get_post_tags($instance['filtres_article_reference']);
        foreach ($tags as $individual_tag) {
            $tag_ids[] = $individual_tag -> term_id;
        }
        if (isset($tag_ids)) {
            $query_args['tag__in'] = $tag_ids;
        }
    }

    // post__not_in
    if (isset($instance['filtres_ignoreposts'])) {
        // Ne pas inclure l\'article single

        if (is_array($instance['filtres_ignoreposts'])) {
            $query_args['post__not_in'] = $instance['filtres_ignoreposts'];
        }

    }
	
	//$query_args['paged'] = get_query_var('paged');
	
    //	vardump($query_args['post__not_in']);

    // posts_per_page
    // WP_QUERY
    if ($instance['ajax'] == false) {
        $QUERY = new WP_Query($query_args);
    }

} elseif (isset($instance['calldata']) && $instance['calldata'] != false) {
    // Rarement utilisé
    $QUERY = $instance['calldata'];
} else {
    // EDITION DE LA LOOP GLOBALE :: filtres_off = on :: les filtres sont éteints par défaut
    if (isset($instance['ajax']) && $instance['ajax'] == false) {
        global $wp_query;
        // Récupération de la boucle globale avant execution

        $myargs = array('cat' => get_query_var('cat'), 'paged' => get_query_var('paged'), 'orderby' => isset($instance['filtres_orderby']) ? $orderby_options[$instance['filtres_orderby']] : false, 'order' => isset($instance['filtres_order']) ? $instance['filtres_order'] : false, 'post_type' => isset($instance['filtres_type']) ? TypeQuery($instance['filtres_type']) : false, 'post_status' => 'publish', 's' => get_query_var('s'), 'posts_per_page' => isset($instance['filtres_combien']) ? PostsPerPageQuery($instance['filtres_combien']) : false, );
		/*
		// Gestion des filtres par catégorie
		// $FILTRES_CATSIN
	    $filtres_catsin = "";
	    $i = 1;
	    foreach ($instance as $label => $value) {
	        if (preg_match("/filtres_categories_/", $label, $cat) == 1) {
	
	            $cat = preg_replace("/filtres_categories_/", "", $label);
	            $filtres_catsin .= ($i > 1 ? "," : false) . $cat;
	            $i++;
	        }
	    }
	    if ($filtres_catsin != false) {
	        //$myargs['category__' . (isset($instance['filtres_catsinornot']) ? $instance['filtres_catsinornot'] : getDefaultLoop('filtres_catsinornot'))] = "" . $filtres_catsin . "";
			$myargs['cat'] = $filtres_catsin;
		}
		*/

        $args_query = array_merge($wp_query -> query_vars, $myargs);
		//  		vardump($args_query);
        query_posts($myargs);
        // Modification de la loop en cours

        $QUERY = $wp_query;
    }
}
//vardump($QUERY->request);
////////// 6. LA BOUCLE
$c = 1;
// Paramètres Wallpin
$a = 'a';

if (isset($instance['apparence_disposition']) && $instance['apparence_disposition'] != "wallpin") {// Mode Blog et Carousel : une seule colonne
    $instance['apparence_wallpin_colonnes'] = false;
    $COLS = array("a");
    for ($z = 0; $z <= (count($COLS) - 1); $z++) {
        $counter[$COLS[$z]] = 1;
    }
    $n = $counter['a'];
} else {// Apparence Wallpin : // Seul ce mode permet d'afficher des colonnes de résultats pour le moment. Il faudra le proposer pour Blog (ajouter un wrapper à l'item avec une classe colonne.)
    $COLS = explode('/', (isset($instance['apparence_wallpin_colonnes']) && $instance['apparence_wallpin_colonnes'] != false ? $instance['apparence_wallpin_colonnes'] : getDefaultLoop('apparence_wallpin_colonnes')));
    // Uniquement dans le cas Wallpin

    for ($z = 0; $z <= (count($COLS) - 1); $z++) {
        $counter[$COLS[$z]] = 1;
    }
    $n = $counter['a'];
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if (isset($instance['ajax']) && $instance['ajax'] == true) {

    echo a('div.holder-ajax-widget-' . $instance['name']) . z('div');

    //wp_enqueue_script( 'ajax-widget-'.$instance['class'], JS_PATH.'ajax-widget-load-posts.js', array('jquery'), 'fev14' );
    // Enregistrer le script ci-dessous en session et charger l'ensemble des widgets ajax à part de script.php
    $_SESSION['ajax-widget-' . $instance['name']] = urlencode(json_encode($instance));

    $_SESSION['args-ajax-widget-' . $instance['name']] = urlencode(json_encode($args));
    if (isset($_SESSION['ajax-widgets']))
        $_SESSION['ajax-widgets'] .= isset($instance['name']) ? 'ajax-widget-' . $instance['name'] . '//' : false;
    else
        $_SESSION['ajax-widgets'] = isset($instance['name']) ? 'ajax-widget-' . $instance['name'] . '//' : false;

} else {

    // WIDGET_START
    echo $Widget_START;

    if (isset($instance['titre_separator'])) {
        $separators = array('hr', 'br');
        echo(in_array($instance['titre_separator'], $separators) ? a($instance['titre_separator']) : false);
    }

    $_SESSION['widget_posts'] = false;

    if (isset($QUERY) && $QUERY -> have_posts()) {

        // Loop
        // Les ID de posts chargés par ce widget vont être stockés en session
        // Ces articles peuvent ainsi être filtrés par d'autres widgets avec filtres_ignoreposts par exemple.
        $_SESSION['wposts_' . $instance['name']] = false;

        while ($QUERY -> have_posts()) {
            $QUERY -> the_post();

            global $post;
            $articles[$a][$n] = $post;
            $_SESSION['wposts_' . $instance['name']] .= $post -> ID . ',';

            if (get_the_excerpt()) {
                $articles[$a][$n] -> exxcerpt = get_the_excerpt();
            } else
                $articles[$a][$n] -> exxcerpt = false;

            // Ici, on sort de la boucle et on change de colonne.
            for ($z = 0; $z <= (count($COLS) - 1); $z++) {
                if ($z == (count($COLS) - 1)) { $a = $COLS[0];
                    $counter[$COLS[$z]]++;
                    $n = $counter[$COLS[0]];
                    break;
                } elseif ($a == $COLS[$z]) { $a = $COLS[$z + 1];
                    $counter[$COLS[$z]]++;
                    $n = $counter[$COLS[$z + 1]];
                    break;
                }
            }
            $nombrecolumns = (count($COLS) - 1);
        }
        /*
         // Ajax load more
         // Add code to index pages.
         if( !is_singular() ) {
         wp_enqueue_script( 'script-ajax-load-posts', JS_PATH.'ajax-load-posts.js', array('jquery'), 'fev14' );

         // What page are we on? And what is the pages limit?
         $max = $QUERY->max_num_pages;
         $paged = ( get_query_var('paged') > 1 ) ? get_query_var('paged') : 1;

         // Add some parameters for the JS.
         wp_localize_script(
         'script-ajax-load-posts',
         'pbd_alp',
         array(
         'startPage' => $paged,
         'maxPages' => $max,
         'nextLink' => next_posts($max, false),
         'loadBtn' => __("Afficher plus de résultats","bodyrock"),
         'loadText' => __("Chargement des articles...","bodyrock"),
         'loadNomore' => __("Plus aucun résultat","bodyrock")
         )
         );
         }
         add_action('template_redirect', 'pbd_alp_init');*/

        if (isset($instance['apparence_disposition']) && isset($First_START[$instance['apparence_disposition']])) {
            // F FIRST_START
            echo $First_START[$instance['apparence_disposition']];
        }
        if (isset($instance['apparence_disposition']) && isset($Wrapper_START[$instance['apparence_disposition']])) {
            // W WRAPPER_START
            echo $Wrapper_START[$instance['apparence_disposition']];
        }
        if (isset($Group_START)) {
            // G GROUP_START
            echo $Group_START;
        }

        // BOUCLE START
        $largeur_colonne = 12 / count($COLS);
        // Largeur d'une colonne

        foreach ($COLS as $ID) {

            if (isset($instance['apparence_disposition']) && isset($Colonne_START[$instance['apparence_disposition']])) {
                // C COLONNE_START
                printf($Colonne_START[$instance['apparence_disposition']], $largeur_colonne);
            }

            for ($i = 1; isset($articles[$ID][$i]); $i++) {// $i = ligne de résultat
                $post = $articles[$ID][$i];
                $excerpt[$i] = $articles[$ID][$i] -> exxcerpt;

                if (isset($instance['apparence_disposition']) && isset($WIrapper_START[$instance['apparence_disposition']])) {
                    // WI WIRAPPER_START
                    printf($WIrapper_START[$instance['apparence_disposition']], ($i == 1 ? 'active' : false));
                }

                if (isset($Item_START[$instance['affichage_modele']])) {
                    // I ITEM_START
                    echo $Item_START[$instance['affichage_modele']];
                }

                // CONTENT
                $instance['affichage_modele'] = $instance['affichage_modele'] != false ? $instance['affichage_modele'] : getDefaultLoop('affichage_modele');
                include (locate_template('tpl/affichage/' . $instance['affichage_modele'] . '.php'));

                if (isset($Item_END[$instance['affichage_modele']])) {
                    // ITEM_END
                    echo $Item_END[$instance['affichage_modele']];
                }

                // Enfin, on affiche la description dans la balise dd si la liste est de type dl-dt-dd
                if (isset($instance['contenu_excerpt']) && $instance['contenu_excerpt'] == 'on' && $instance['affichage_modele'] == 'liste' && $instance['affichage_liste_type'] == 'dl-dt-dd') {
                    echo a('dd');
                    echo Get_thumbnail($instance);
                    echo Get_excerpt($instance);
                    echo Get_artfooter($instance);
                    echo z('dd');
                }

                $separators = array('hr', 'br');
                if (isset($instance['articles_separator'])) {
                    echo(in_array($instance['articles_separator'], $separators) ? a($instance['articles_separator']) : false);
                }

                if (isset($instance['apparence_disposition']) && isset($WIrapper_END[$instance['apparence_disposition']])) {
                    // WI WIRAPPER_START
                    echo $WIrapper_END[$instance['apparence_disposition']];
                }
            }

            if (isset($instance['apparence_disposition']) && isset($Colonne_END[$instance['apparence_disposition']])) {
                // C COLONNE_END
                echo $Colonne_END[$instance['apparence_disposition']];
            }

        }
        // BOUCLE FIN

        if (isset($Group_END)) {
            // GROUP_END
            echo $Group_END;
        }
        if (isset($instance['apparence_disposition']) && isset($Wrapper_END[$instance['apparence_disposition']])) {
            // WRAPPER_END
            echo $Wrapper_END[$instance['apparence_disposition']];
        }
        if (isset($instance['apparence_disposition']) && isset($First_END[$instance['apparence_disposition']])) {
            // F FIRST_START
            echo $First_END[$instance['apparence_disposition']];
        }
    } else {// Si aucun résultat;
        echo __('Aucun résultat.', 'bodyrock');
    }

    echo $Widget_END;

    //wp_reset_query();
}
?>