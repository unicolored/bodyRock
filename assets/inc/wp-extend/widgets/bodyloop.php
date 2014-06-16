<?php

// BODYLOOP Widget /////////////////////////////////////////////

/*//**//**//**//*//**//**//**//*//**//**//**//*//**//**//**/
// Widget de création d'affichage de contenus.
// Permet de filtrer l'ensemble des résultats, de choisir une template pour l'affichage et de personnaliser les données affichées.
/*//**//**//**//*//**//**//**//*//**//**//**//*//**//**//**/

class br_widgetsBodyloop extends WP_Widget {

    function br_widgetsBodyloop() {
        $widget_ops = array('description' => __('Création de loop pour afficher les articles de votre choix en composants prédéfinis et personnalisables.', 'bodyrock'));
        parent::WP_Widget(false, __('BR Bodyloop', 'bodyrock'), $widget_ops);
    }

    function widget($args, $instance) {
        ob_start();

        include 'bodyloop/bodyloop_widget.php';
        $widget = ob_get_contents();
        ob_end_clean();
        
        if (isset($instance['aftercontent']) && $instance['aftercontent']==true) {
            return $widget;
        }
        else echo $widget;
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    // ENREGISTREMENT DES DONNEES DU WIDGET	///////////////////////////////////////////
    function update($new_instance, $old_instance) {
        if ($new_instance['affichage_modele'] == 'affichage_modele_listemedias') {
            $new_instance['affichage_liste_type'] = "ul-li";
        }

        return $new_instance;
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    // FORMULAIRE D'EDITION DU WIDGET	///////////////////////////////////////////
    function form($instance) {
        include 'bodyloop/bodyloop_form.php';
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //// METHODES SUPPLEMENTAIRES
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    function getOptions($which) {
        switch($which) {
            default :
                return array();
                break;
            case 'filtres_categories' :
                return get_categories();
                break;
        }
    }

    function doFormInput($string, $instance = false, $options = false, $after = false) {// 'Afficher un titre,afficher_titre ?'
        // Création de formulaire en parallèle avec bodyloop.php, le widget
        include 'bodyloop/bodyloop_functions.php';
        return $form_item . $after;
    }

}// Fin de la classe

// Fonctions supplémentaires
function Get_thumbnail($instance) {
    if($instance['edit_article_titre']!=false)  {
        $titre = $instance['edit_article_titre'](get_the_title());
    }
    else $titre = get_the_title();
    
    if (has_post_thumbnail() || get_post_format() == "video") {
        $attrs = false;
        $vignette_dimensions = (isset($instance['vignette_dimensions']) ? $instance['vignette_dimensions'] : getDefaultLoop('vignette_dimensions'));
		
        $attrs = br_getPostThumbnail($vignette_dimensions, false);

        //$image_url = $attrs['src'];
        $wh = false;
        if (isset($instance['vignette_dimensions_force']) && $instance['vignette_dimensions_force'] != 0) {
            $S = explode('x', $instance['vignette_dimensions_force']);
            $wh = 'width="' . $S[0] . '" height="' . $S[1] . '"';
        } elseif (isset($attrs['width']) && isset($attrs['height'])) {
            $wh = 'width="' . $attrs['width'] . '" height="' . $attrs['height'] . '"';
        }

        $icon_item = false;
        if (get_post_format() == "video") {
            //$icon_item = '<p class="icon_item">'.br_getIcon('play').'</p>';
        }
		
        //////////////
        $res = '';
        if ($instance['vignette_background'] == "on") {            
            $addimg = ($instance['vignette_background_addimg'] == "on") ? '<img src="' . $attrs['src'] . '" itemprop="thumbnailUrl">' : false;
            $res .= '
				<section class="art-vignette-bg" style="background-image:url(' . $attrs['src'] . ');">
				<h1><a href="' . get_permalink() . '">'.$addimg.' ' . $icon_item . '<span>' . $titre . '</span></a></h1>
				</section>';

        } else {
            $res = '';
            $styles = array('style_cercle' => 'img-circle', 'style_thumbnail' => 'img-thumbnail', 'style_arrondi' => 'img-rounded');
            $align = array("gauche" => "pull-left", "droite" => "pull-right", "centre" => "center-block", "aucun" => false);

            $res .= a('section.art-vignette');
            if ($instance['affichage_listemedias_unlink_img'] == false) {
                $res .= '<a class="' . $align[$instance['vignette_alignement']] . '" href="' . get_permalink() . '">';
            }

            $res .= '<img src="' . $attrs['src'] . '" ' . $wh . ' alt="' . $titre . '" itemprop="thumbnailUrl" class="media-object ' . (isset($styles[$instance['vignette_style']]) ? $styles[$instance['vignette_style']] : false) . ' ' . ($instance['vignette_nonresponsive'] == false ? 'img-responsive' : false) . '">';

            if ($instance['affichage_listemedias_unlink_img'] == false) {
                $res .= '<span class="hover"></span></a>';
            }
            $res .= z('section');
        }

        return $res;
    } elseif (get_post_format() == 'audio') {
        $res .= '
			<section class="art-vignette-bg">
			<h1><a href="' . get_permalink() . '"><p class="icon_item">' . br_getIcon('music') . '</p><span>' . $titre . '</span></a></h1>
			</section>';

        return $res;
    }
}

function Get_excerpt($instance, $before = false, $after = false, $excerpt = false) {
    if (isset($instance['contenu_lirelasuite']) && $instance['contenu_lirelasuite'] == 'on') {
        if ($instance['contenu_lirelasuite_btn'] == true) {
            $linkmore = '<br><a href="' . get_permalink() . '" class="btn btn-' . $instance['contenu_lirelasuite_btncolor'] . ' more-link" role="button">' . $instance['contenu_lirelasuite_txt'] . '</a>';
        } else {
            $linkmore = '<a href="' . get_permalink() . '" class="more-link">' . $instance['contenu_lirelasuite_txt'] . '</a>';
        }
    } else {
        $linkmore = '';
    }
    if ($excerpt != false) {
        return $before . $excerpt . $linkmore . $after;
    } else
        return false;
}

function Get_artfooter($instance) {
    if (isset($instance['contenu_footer_masquer']) && $instance['contenu_footer_masquer'] == false) {
        if (isset($instance['contenu_footer_date']) && $instance['contenu_footer_date'] == "on" || $instance['contenu_footer_auteur'] == "on" || $instance['contenu_footer_commentaires'] == false || $instance['contenu_footer_vues'] == "on") {
            echo a('footer.art-footer');
            //echo a('div.well.well-sm');

            $sep = (isset($instance['contenu_footer_separateur']) ? $instance['contenu_footer_separateur'] : getDefaultLoop('contenu_footer_separateur'));

            $i = 0;
            if ($instance['contenu_footer_vues'] == "on") {
                if ($i == 1)
                    echo $sep;
                echo br_getIcon('signal') . '&nbsp;' . getPostViews(get_the_ID());
                $i = 1;
            }
            if ($instance['contenu_footer_date'] == "on") {
                if ($i == 1)
                    echo $sep;
                echo br_getIcon('calendar') . '&nbsp;' . __('Posté le', 'bodyrock') . ' <time class="entry-date" datetime="' . esc_attr(get_the_date('c')) . '" pubdate>' . esc_html(get_the_date()) . '</time>';
                $i = 1;
            }
            if ($instance['contenu_footer_auteur'] == "on") {
                if ($i == 1)
                    echo $sep;
                echo br_getIcon('user') . '&nbsp;' . __('par', 'bodyrock') . ' <a href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '" title="' . esc_attr(sprintf(__('Voir tous les articles de %s', 'bodyrock'), get_the_author())) . '">' . get_the_author() . '</a>';
                $i = 1;
            }
            if ($instance['contenu_footer_commentaires'] == "on") {
                if (get_comments_number() > 0) {
                    if ($i == 1)
                        echo $sep;
                    echo $sep . br_getPageIcon('comment') . "&nbsp;" . get_comments_number() . " " . __('commentaire(s)', 'bodyrock');
                    $i = 1;
                }
            }
			// TOFIX : Ajout de l'affichage des categories et des tags en option (à configurer)
			if ($instance['contenu_footer_categories'] == "on") {
                if ( in_array( 'category', get_object_taxonomies( get_post_type() ) ) ) :
					echo $sep ."<span class='cat-links'>".get_the_category_list( _x( ', ', 'Used between list items, there is a space after the comma.', 'bodyrock' ) )."</span>";
				endif;
            }
			if ($instance['contenu_footer_tags'] == "on") {
				$tags = wp_get_post_tags(get_the_ID());
				foreach($tags as $tag) {
					echo $sep.'<a href="'.get_tag_link($tag->term_id).'">'.$tag->name.'</a> ';
				}
            }
            if ($instance['contenu_footer_edit'] == "on" && current_user_can('list-users')) {
                if ($i == 1)
                    echo $sep;
                echo '<a href="/wp-admin/post.php?post=' . get_the_ID() . '&action=edit" class="editpost">' . br_getIcon('edit') . '&nbsp;Editer</a>';
                $i = 1;
            }
            //echo z('/div');
            echo z('/footer');
        }
    }
}

function getRefreshBtn($label) {
    echo a('div.widget-control-actions') . a('div.alignleft') . '<input name="savewidget" id="widget-br_widgetsbodyloop-2-savewidget" class="button button-primary widget-control-save right" value="' . $label . '" type="submit"><span style="display: none;" class="spinner"></span>' . z('div') . a('br.clear') . z('div');
}

function getDefaultLoop($val = false) {
    $default['position'] = 'pos0';
    $default['ajax'] = false;

    $default['filtres_off'] = "on";
    $default['filtres_type'] = false;
    $default['filtres_combien'] = false;
    $default['filtres_orderby'] = "orderby_date";
    $default['filtres_order'] = "DESC";
    $default['filtres_offset'] = 0;
    $default['filtres_catsinornot'] = "in";
    $default['filtres_categories'] = false;
    $default['filtres_tagsinornot'] = "in";
    $default['filtres_tags'] = false;
    $default['filtres_resultats_lies'] = "resultats_select";
    $default['filtres_similaires_selon'] = "both";
    $default['filtres_ignoreposts'] = false;

    $default['apparence_disposition'] = "blog";
    $default['apparence_carousel_indicators'] = false;
    $default['apparence_carousel_controls'] = "on";
    $default['apparence_carousel_controlsbas'] = false;
    $default['apparence_carousel_duration'] = 4000;
    $default['apparence_carousel_hauteur'] = 0;
    $default['apparence_wallpin_colonnes'] = "a/b/c/d";
	$default['apparence_wallpin_class'] = "wallpinthumbnail";
    $default['apparence_wallpin_bootstrap'] = "on";

    $default['affichage_modele'] = "affichage_modele_article";
    $default['affichage_liste_type'] = "dl-dt-dd";
    $default['affichage_liste_unstyled'] = false;
    $default['affichage_liste_horizontale'] = false;
    $default['affichage_listemedias_unlink_img'] = false;
    $default['affichage_listegroup_unlink'] = false;

    $default['contenu_header_masquer'] = false;
    $default['contenu_excerpt'] = false;
    $default['contenu_excerpt_nbmots'] = 0;
    $default['contenu_lirelasuite'] = "on";
    $default['contenu_lirelasuite_btn'] = false;
    $default['contenu_lirelasuite_btncolor'] = "primary";
    $default['contenu_lirelasuite_txt'] = "Lire la suite";
    $default['contenu_footer_masquer'] = false;
    $default['contenu_footer_date'] = false;
    $default['contenu_footer_auteur'] = false;
    $default['contenu_footer_commentaires'] = false;
    $default['contenu_footer_vues'] = false;
    $default['contenu_footer_categories'] = false;
	$default['contenu_footer_tags'] = false;
	$default['contenu_footer_edit'] = false;
    $default['contenu_footer_separateur'] = " | ";

    $default['articles_separator'] = "span.brsep";

    $default['vignette_masquer'] = false;
    $default['vignette_dimensions'] = "medium";
    $default['vignette_background'] = false;
	$default['vignette_background_addimg'] = false;
    $default['vignette_dimensions_force'] = false;
    $default['vignette_alignement'] = "aucun";
    $default['vignette_style'] = "---";
    // Aucun,---;Cercle,style_cercle;Arrondi,style_arrondi;Thumbnail,style_thumbnail
    $default['vignette_nonresponsive'] = false;

    $default['etendue_masquer'] = false;
    // $default['etendue_site_*'] = false;
    $default['calldata'] = false;
    // Permet d'appeller une fonction qui récupère les donénes

    $random_titres = array("Ma nouvelle Loop", "Une super requête", "Un widget d'enfer", "Mes articles préférés", "Ceci n'est pas un titre", "Tititre et raw minet");
    $default['titre'] = $random_titres[rand(0, (count($random_titres) - 1))];
    $default['titre_format'] = "h1";
    $default['titre_separator'] = "span.brsep";
    $default['titre_masquer'] = false;
    $random_icone = br_getAvailableIcones();
    $default['titre_icone'] = $random_icone[rand(0, (count($random_icone) - 1))];
    $default['edit_article_titre'] = false;
    // Fonction qui édite le titre avant son affichage. Exemple : replace_br()
    $random_name = array("verycool", "pasmal", "sympathique", "jeanlouis", "jaimebien", "nomsympa", "whynot");
    $default['name'] = $random_name[rand(0, (count($random_name) - 1))];
    $default['class'] = false;

    if ($val != false) {
        return $default[$val];
    } else
        return $default;
}

// edit_article_titre parameters
function replace_br($txt) {
    $txt = str_replace("<br />", "", $txt);
    $txt = str_replace("<br/>", "", $txt);
    return str_replace("<br>", "", $txt);
}

// FONCTIONS qui convertissent les variables pour l'affichage du widget
function TypeQuery($filtres_type = false) {
    if ($filtres_type != false) {
        $types_options = array("type_post" => "post", "type_page" => "page", "type_attachment" => "attachment");
        $type = isset($types_options[$filtres_type]) ? $types_options[$filtres_type] : $filtres_type;
        return $type;
    } else
        return getDefaultLoop('filtres_type');
}

function PostsPerPageQuery($filtres_combien = false) {
    if ($filtres_combien != false) {
        return $filtres_combien;
    } else
        return getDefaultLoop('filtres_combien');
}
?>