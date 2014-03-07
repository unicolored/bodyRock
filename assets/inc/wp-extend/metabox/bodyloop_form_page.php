<?php

// BODYLOOP form page /////////////////////////////////////////////

/*//**//**//**//*//**//**//**//*//**//**//**//*//**//**//**/
//
/*//**//**//**//*//**//**//**//*//**//**//**//*//**//**//**/

$instance = getDefaultLoop();
$instance = get_post_meta(get_the_ID());
foreach ($instance as $K => $V) {
    $instance[$K] = $V[0];
}
$instance['filtres_off'] = false;

$args = false;
$instance_show = $instance;
if ($instance['contenu_excerpt'] == false) {
    $instance_show['contenu_excerpt_nbmots'] = false;
}

if ($instance['contenu_lirelasuite'] == false) {
    $instance_show['contenu_lirelasuite'] = 'false';
    $instance_show['contenu_lirelasuite_btn'] = false;
    $instance_show['contenu_lirelasuite_btncolor'] = false;
    $instance_show['contenu_lirelasuite_txt'] = false;
}

if ($instance['titre_masquer'] == true) {
    $instance_show['titre'] = false;
    $instance_show['titre_format'] = false;
    $instance_show['titre_icone'] = false;
    $instance_show['titre_separator'] = false;
}

if ($instance['etendue_masquer'] == false) {
    $wordpress_pages = array("front_page", "home", "category", "404", "search", "tag", "page", "single", "attachment");
    foreach ($wordpress_pages as $P) {
        $instance_show['etendue_site_' . $P] = false;
    }
}

// $FILTRES_TYPES
$types_options = array("type_post" => "post", "type_page" => "page", "type_attachment" => "attachment");
$args['post_type'] = $types_options[$instance['filtres_type']];

// $FILTRES_COMBIEN
$args['posts_per_page'] = $instance['filtres_combien'];

// $FILTRES_ORDERBY // $FILTRES_ORDER
$query_meta_key = false;
$orderby_options = array("orderby_date" => "date", "orderby_dateedition" => "modified", "orderby_titre" => "title", "orderby_comment" => "comment_count", "orderby_nombredevue" => "meta_value");
$args['orderby'] = isset($orderby_options[$instance['filtres_orderby']]) ? $orderby_options[$instance['filtres_orderby']] : false;
switch($instance['filtres_orderby']) {
    case 'orderby_nombredevue' :
        $args['meta_key'] = "post_views_count";
        break;
}
// meta_key=post_views_count
$args['order'] = $instance['filtres_order'];

// $FILTRES_OFFSET
$args['offset'] = $instance['filtres_offset'];

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
    $args['category__' . $instance['filtres_catsinornot']] = '$category_in';
}

// SINON ON FILTRE SELON L'ARTICLE EN COURS
if ($instance['filtres_resultats_lies'] == 'resultats_similaires') {
    // SELON LES CATEGORIES
    if ($instance['filtres_similaires_selon'] == 'both' || $instance['filtres_similaires_selon'] == 'cats') {
        $args['category__in'] = '$category_in';
    }
    // SELON LES TAGS
    if ($instance['filtres_similaires_selon'] == 'both' || $instance['filtres_similaires_selon'] == 'tags') {
        $args['tag__in'] = '$tag_ids';
    }
}

// post__not_in
if ($instance['filtres_ignoreposts'] == true) {
    $args['post__not_in'] = 'array($posts_notin)';
    $preargs[$args['post__not_in']] = '
// Ne pas inclure l\'article single
if(is_singular()) {' . "\n" . '$posts_notin = get_the_ID();' . "\n" . '}
';
}

echo a('div.ofthewidget');

echo a('hr');

apply_filters('widget_title', isset($instance['title']) ? $instance['title'] : 'Sans-titre');

echo a('style');
echo '
            .ofthewidget fieldset {
                border-bottom:1px dotted #333; margin:1em 0; padding:1em 0;
				border:2px solid #ddd;
				padding:10px;
            }
            .ofthewidget fieldset legend {
                color:#aaa; background:#ddd; display:block; width:auto; padding:0em 1em;
            }
            .ofthewidget fieldset p.tabulate {
                padding:0; padding-left:2em; margin:0;
            }
            .ofthewidget article {
                border:1px solid #aaa; padding:5px; margin:2px;
            }
            table.table td { width:25%; }
            table.table tr, table.table td, table.table { vertical-align:top; }
		';
echo z('style');

echo a('script');
echo '
            jQuery(".widgets-sortables .widget-inside").css({"display":"block"});
		';
echo z('script');
echo "<link rel='stylesheet' id='style-prettify-css'  href='http://bodyrock.gilleshoarau.com/wp-content/themes/bodyrock/assets/js/libs/prettify/prettify.css?ver=mar13' type='text/css' media='' />";
echo "<script type='text/javascript' src='http://bodyrock.gilleshoarau.com/wp-content/themes/bodyrock/assets/js/libs/prettify/run_prettify.js?ver=3.8'></script>";

echo '<table class="table">';
echo '<tbody>';
echo '<tr>';
echo '<td>';
echo '<fieldset>';
echo '<legend>' . __('Aperçu', 'bodyrock') . '</legend>';
// EXEMPLE ///////////////////
// Affichage test de la loop
wp_reset_query();
$form = new br_widgetsBodyloop();
$instance_preview = $instance;
$instance_preview['ajax'] = false;
$instance_preview['apparence_disposition'] = 'blog';
$instance_preview['affichage_modele'] = 'affichage_modele_admin';
$instance_preview['vignette_masquer'] = 'on';
$instance_preview['contenu_header_masquer'] = false;
$instance_preview['contenu_footer_date'] = 'on';
$instance_preview['filtres_combien'] = 6;

$widget_preview = $form -> widget(array(), $instance_preview);
echo $widget_preview;
wp_reset_query();
echo '</fieldset>';
echo '</td>';

echo '<td valign="top">';

// TITRE ///////////////////
echo a('fieldset');
echo '<legend>Configuration</legend>';
echo '<h1>Widget</h1>';
echo doFormInput("Position,position:r:", $instance, "Désactiver,pos0;Dessus,pos1;Dessous,pos2;Remplacement,pos3", '<br><br>');
echo doFormInput("Nom identifiant,name", $instance, false, '<br>');
echo doFormInput("Classe du widget,class", $instance, false, '');
echo a('fieldset.titre');
echo '<legend><h4>' . doFormInput("Masquer le titre,titre_masquer?", $instance, false, '') . '</h4></legend>';
echo '<h4>' . doFormInput("Titre,titre", $instance, false, '') . ' ' . doFormInput("h,titre_format::", $instance, "1,h1;2,h2;3,h3;4,h4;5,h5;6,h6", '<br>') . ' ' . doFormInput("Sép.,titre_separator::", $instance, "Aucun,span.brsep;hr,hr;br,br", '') . '</h4>';
if ($instance['titre_masquer'] == false) {
    echo doFormInput("Icône,titre_icone", $instance, false, '<br>');
}
echo z('fieldset');
// TOFIX : Ajouter un footer au widget : lien, bouton

// APPARENCE ///////////////////
//          echo $form->doFormInput("ONE",$instance,false,'<br>');
echo '<h1>Apparence</h1>';
echo doFormInput("Disposition,apparence_disposition::", $instance, "Blog,blog;Carousel,carousel;Wallpin,wallpin", '<br>');
if ($instance['apparence_disposition'] == "blog") {
    echo '<p>Les résultats apparaissent les uns après les autres.</p>';
} elseif ($instance['apparence_disposition'] == "carousel") {
    echo '<h4>Options du Carousel</h4>';
    echo doFormInput("Afficher indicators,apparence_carousel_indicators?", $instance, false, '<br>');
    echo doFormInput("Afficher controls,apparence_carousel_controls?", $instance, false, '<br>');
    echo doFormInput("Positionner les controls sous le carousel,apparence_carousel_controlsbas?", $instance, false, '<br>');
    echo doFormInput("Hauteur du carousel,apparence_carousel_hauteur09", $instance, false, '<br>');
} elseif ($instance['apparence_disposition'] == "wallpin") {
    echo '<h4>Options du Wallpin</h4>';
    echo doFormInput("Nombre de colonnes,apparence_wallpin_colonnes::", $instance, "2 colonnes,a/b;3 colonnes,a/b/c;4 colonnes,a/b/c/d;6 colonnes,a/b/c/d/e/f", '<br>');
    echo doFormInput("Utiliser les classes Bootstrap,apparence_wallpin_bootstrap?", $instance, false, '<br>');
}

// AFFICHAGE ///////////////////
//          echo $form->doFormInput("ONE",$instance,false,'<br>');
echo '<h1>Affichage</h1>';
echo doFormInput("Modèle,affichage_modele::", $instance, "Liste,affichage_modele_liste;Liste group,affichage_modele_listegroup;Médias,affichage_modele_listemedias;Thumbnails,affichage_modele_thumbnail;Articles,affichage_modele_article", '<br>');
if ($instance['affichage_modele'] == "affichage_modele_liste") {
    echo '<h4>Options de Liste</h4>';
    echo doFormInput("Type,affichage_liste_type::", $instance, "ul/li,ul-li;ol/li,ol-li;dl/dt/dd,dl-dt-dd", '<br>');
    echo doFormInput("Masquer les puces,affichage_liste_unstyled?", $instance, false, '<br>');
    echo doFormInput("Horizontale,affichage_liste_horizontale?", $instance, false, '<br>');
}
if ($instance['affichage_modele'] == "affichage_modele_listemedias") {
    echo '<h4>Options de <a href="http://getbootstrap.com/components/#media" target="_blank">#media</a></h4>';
    echo doFormInput("Supprimer le lien de l'image,affichage_listemedias_unlink_img?", $instance, "", '<br>');
}
if ($instance['affichage_modele'] == "affichage_modele_listegroup") {
    echo '<h4>Options de <a href="http://getbootstrap.com/components/#list-group" target="_blank">#list-group</a></h4>';
    echo doFormInput("Supprimer le lien par défaut,affichage_listegroup_unlink?", $instance, "", '<br>');
}

echo z('fieldset');
echo '</td>';
echo '<td>';
// FILTRES ///////////////////
//			echo $form->doFormInput("ONE",$instance,false,'<br>');
echo a('fieldset.filtres');
echo '<legend>Boucle</legend>';
//echo '<legend><h4>' . doFormInput("Désactiver les filtres,filtres_off?", $instance, false, '') . '</h4></legend>';
echo doFormInput("posts_per_page,filtres_combien09", $instance, false, '');
echo doFormInput("<span title='Ignorer les x premiers articles'>offset</span>,filtres_offset09", $instance, false, '<br>');
echo doFormInput("post_type,filtres_type::", $instance, "Articles,type_post;Pages,type_page;Médias,type_attachment", '<br>');
echo doFormInput("orderby,filtres_orderby::", $instance, "date,orderby_date;title,orderby_titre;comment_count,orderby_comment;post_views_count,orderby_nombredevue", '<br>');
echo doFormInput("&nbsp;,filtres_order::", $instance, "DESCendant,DESC;ASCendant,ASC", '<br>');
echo '<h1>Catégories</h1>';
echo doFormInput("Il faut,filtres_catsinornot::", $instance, "uniquement inclure,in;uniquement exclure,not_in", '<br>');
echo doFormInput("category__" . $instance['filtres_catsinornot'] . ",filtres_categories()?", $instance, false, '<hr>');
echo '<h1>Tags</h1>';
echo doFormInput("Il faut,filtres_tagsinornot::", $instance, "uniquement inclure,in;uniquement exclure,not_in", '<br>');
echo doFormInput("tags__" . $instance['filtres_tagsinornot'] . ",filtres_tags", $instance, false, '<hr>');
echo doFormInput("Sur page single,filtres_resultats_lies::", $instance, "ne rien changer,resultats_select;résultats similaires,resultats_similaires", '<br>');
if ($instance['filtres_resultats_lies'] == "resultats_similaires") {
    echo doFormInput("...selon,filtres_similaires_selon::", $instance, "---,---;Catégories,cats;Tags,tags;Les deux,both", '<br>');
}
echo doFormInput("Ne pas inclure l'article single,filtres_ignoreposts?", $instance, false, '<br>');

echo z('fieldset');
echo '</td>';
echo '</td>';
echo '<td>';
echo a('fieldset');
echo '<legend>article</legend>';
// CONTENU ///////////////////
//          echo $form->doFormInput("ONE",$instance,false,'<br>');
echo a('fieldset.contenu');
echo '<legend><h4>' . doFormInput("Masquer le .art-header,contenu_header_masquer?", $instance, false, '<br>') . '</h4></legend>';
echo z('fieldset');
echo a('fieldset');
echo '<legend>'.doFormInput("Inclure un extrait .art-content,contenu_excerpt?", $instance, false, '<br>').'</legend>';
if ($instance['contenu_excerpt'] == true) {
    echo doFormInput("Nombre de mots,contenu_excerpt_nbmots09", $instance, false, '<br>');
}
echo doFormInput("Inclure un lien -Lire la suite-,contenu_lirelasuite?", $instance, false, '<br>');
if ($instance['contenu_lirelasuite'] == "on") {
    echo doFormInput("Sous forme de bouton,contenu_lirelasuite_btn?", $instance, false, '<br>');
    echo doFormInput("Couleur du bouton,contenu_lirelasuite_btncolor::", $instance, "Défaut,default;Primaire,primary;Infos,info;Succès,success;Avertissement,warning;Danger,danger", '<br>');
    echo doFormInput("Label -Lire la suite-,contenu_lirelasuite_txt", $instance, false, '<br>');
}
echo z('fieldset');
echo a('fieldset');
echo '<legend><h4>' . doFormInput("Masquer le .art-footer,contenu_footer_masquer?", $instance, false, '<br>') . '</h4></legend>';
if ($instance['contenu_footer_masquer'] == false) {
    echo doFormInput("Afficher la date,contenu_footer_date?", $instance, false, '<br>');
    echo doFormInput("Afficher l'auteur,contenu_footer_auteur?", $instance, false, '<br>');
    echo doFormInput("Afficher le nombre de commentaires,contenu_footer_commentaires?", $instance, false, '<br>');
    echo doFormInput("Afficher le nombre de vues,contenu_footer_vues?", $instance, false, '<br>');
    echo doFormInput("Afficher le footer,contenu_footer_separateur", $instance, false, '<br>');
}
echo doFormInput("Séparateur entre les articles,articles_separator::", $instance, "Aucun,span.brsep;hr,hr;br,br", '<br>');
echo z('fieldset');
// VIGNETTE ///////////////////
echo a('fieldset');
echo '<legend><h4>' . doFormInput("Masquer la .art-vignette,vignette_masquer?", $instance, false, '<br>') . '</h4></legend>';
if ($instance['vignette_masquer'] == false) {
    echo doFormInput("Dimensions,vignette_dimensions::", $instance, "Thumbnail,thumbnail;Medium,medium;Large,large;Custom,custom_*", '<br>');
    echo doFormInput("Image en background + .art-vignette-bg,vignette_background?", $instance, false, '<br>');
    echo doFormInput("Forcer ces dimensions,vignette_dimensions_force", $instance, false, '<br>');
    echo doFormInput("Alignement de l'image,vignette_alignement::", $instance, "Gauche,gauche;Droite,droite;Centre,centre;Aucun,aucun", '<br>');
    echo doFormInput("Style de l'image,vignette_style::", $instance, "Aucun,---;Cercle,style_cercle;Arrondi,style_arrondi;Thumbnail,style_thumbnail", '<br>');
    echo doFormInput("Image non responsive,vignette_nonresponsive?", $instance, false, '<br>');
}
echo z('fieldset');

echo z('fieldset');
echo '</td>';

echo '</tr>';
echo '</tbody>';
echo '</table>';
echo z('div');
