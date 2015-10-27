<?php
// functions.php /////////////////////////////////////////////
/*//**//**//**//*//**//**//**//*//**//**//**//*//**//**//**/
// Le fichier de fonctions de Wordpress.
/*//**//**//**//*//**//**//**//*//**//**//**//*//**//**//**/
/*

 Toutes les fonctions PHP de Bodyrock sont liées à ce fichier.
 La référence des noms commence au dossier assets/inc/.

 Un nom de fonction peut comporter des lettres, des chiffres et les caractères _ et & (les espaces ne sont pas autorisés).
 Le nom de la fonction, comme celui des variables est sensible à la casse (différenciation entre les minuscules et majuscules).

 Si une fonction doit changer de nom, on doit conserver l'ancienne fonction appellant la nouvelle.

 Les fonctions sont rangées par ordre alphabétique par sections par fichiers, dès que possible avec une priorité sur les fonctions br_

 Nomenclature des fonctions :
 ----------------------------
 prefix ::
 br_ : Optionnel :devant la fonction lorsqu'elle peut être appelé depuis vos templates ou des thèmes enfants.
 sousdossier_ :: nom du sous-dossier
 nomdufichier : nom du fichier php qui héberge la fonction (ne s'applique pas aux fonctions déclarées dans functions.php).

 Method ::
 init : initialisation de composant
 get : récupération de valeur (et affichage)
 set : définit (et enregistrer une valeur) etc...

 _suffix ::
 _* : spécificité dela fonction
 ----------------------------
 exemples :
 br_nomdufichierMethod() : destinée à être appellée depuis les templates, elle se trouve dans le fichier assets/inc/nomdufichier.php
 themeoptionsInit() se trouve dans le fichier (assets/inc/)themes-options.php
 br_themeoptionsGet_default() se trouve dans le fichier (assets/inc/)themes-options.php, elle récupère les options par défaut.

 */
//////////////////////////////////////////////////////////////////////////////

define('THEME_PATH', 'wp-content/themes/bodyrock/');
define('BR_PATH', ABSPATH . THEME_PATH); // Liens absolus.
define('ASSETS_PATH', BR_PATH . 'assets/');
define('INC_PATH', ASSETS_PATH . 'inc/');
define('JS_PATH', '/' . THEME_PATH . 'assets/js/');
define('BR_CSS_PATH', BR_PATH . 'css/');

// Attention ici, pour la fonction get_template_part(), il faut utiliser des liens relatifs.
define('TPL_PATH', 'tpl/');
define('TPL_SIDEBAR_PATH', TPL_PATH . 'sidebars/');
define('TPL_BOOTSTRAP_PATH', TPL_PATH . 'bootstrap/');
define('TPL_SINGULAR_PATH', TPL_PATH . 'singular/');

// LOAD PHP /////////////////////////////////////////////
require 'includes/__debug.php';
//require 'includes/functions__deprecated.php';
// Inclusions des extensions de fonctionnalités
// TODO : remettre dans un même dossier, simplifier les includes
require_once INC_PATH . 'br_themeoptions.php'; // Les options du thème accessibles via Wordpress.
require_once INC_PATH . 'br_icones.php'; // Génération d'éléments relatifs aux icônes
require_once INC_PATH . 'br_images.php'; // Tout ce qui concerne les paramètres liés aux images.
require_once INC_PATH . 'br_textes.php'; // Tout ce qui concerne les paramètres liés aux textes.

require 'includes/functions__hook.php';
require 'includes/functions_customize.php';
require 'includes/functions_extend.php';

////// WALKERS /////////////////////////////////////////////
////// Chargement des différents walkers personnalisés
/*
Un 'walker' parcoure les éléments du menu et permet de personnaliser la sortie Html.
Les différents walkers ci-dessous servent à reproduire les composants Bootstrap.
*/
require_once(INC_PATH.'wp-extend/walkers/navbar_walker.php');
require_once(INC_PATH.'wp-extend/walkers/listgroup_walker.php');
require_once(INC_PATH.'wp-extend/walkers/listgroupCat_walker.php');
require_once(INC_PATH.'wp-extend/walkers/listgroupPage_walker.php');
require_once(INC_PATH.'wp-extend/walkers/listgroupcustom_walker.php');
require_once(INC_PATH.'wp-extend/walkers/navpills_walker.php');
require_once(INC_PATH.'wp-extend/walkers/tabs_walker.php');

////// METABOX /////////////////////////////////////////////
// TODO : revoir l'utilisation des metabox !!!
//require_once INC_PATH.'wp-extend/br_metabox.php'; // metaboxs

////// _TMP /////////////////////////////////////////////
//require_once 'br_types.php'; // custom posts types
//require_once 'br_shortcodes.php'; // widgets
//require_once 'plugins/nextpost_plus.php'; // widgets


?>
