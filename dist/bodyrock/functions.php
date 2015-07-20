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
 // AJOUTS RELATIFS à THEME CHECK
if ( ! isset( $content_width ) ) $content_width = 900;
add_theme_support( "title-tag" );
$args = false;
add_theme_support( "custom-header", $args );
add_theme_support( "custom-background", $args );
 //////////

//add_image_size( 'article', 960, 320, 1 ); Obsolète ! Inutile de faire une déclaration supplémentaire pour le thème Bodyrorck parent
add_theme_support('post-formats', array('aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat'));
//add_action('wp_footer', 'getImgVideo', 100);
add_theme_support( 'automatic-feed-links' );
// Retire une partie des variables disqus non utiles à mon avis.
// Evite notamment l'inclusion de code sur les pages qui ne comportent pas de commentaires.
//remove_action('wp_footer', 'dsq_output_footer_comment_js');

define('THEME_PATH', 'wp-content/themes/bodyrock/');
// Liens absolus.
define('BR_PATH', ABSPATH . THEME_PATH);
// Liens absolus.
define('ASSETS_PATH', BR_PATH . 'assets/');
define('INC_PATH', ASSETS_PATH . 'inc/');
define('LESS_PATH', THEME_PATH . 'assets/less/');
define('JS_PATH', '/' . THEME_PATH . 'assets/js/');

define('BR_CSS_PATH', BR_PATH . 'css/');

// Attention ici, pour la fonction get_template_part(), il faut utiliser des liens relatifs.
define('TPL_PATH', 'tpl/');
define('TPL_SIDEBAR_PATH', TPL_PATH . 'sidebars/');
define('TPL_BOOTSTRAP_PATH', TPL_PATH . 'bootstrap/');
define('TPL_SINGULAR_PATH', TPL_PATH . 'singular/');

// LOAD PHP /////////////////////////////////////////////
// Inclusions des extensions de fonctionnalités

// Personnalisation de Wordpress.
require_once INC_PATH . 'customize.php';
// Les options du thème accessibles via Wordpress.
require_once INC_PATH . 'themeoptions.php';
// Génération d'éléments Html utiles au thème.
require_once INC_PATH . 'br_interface.php';
// Chargement des fonctions en arrière plan.
require_once INC_PATH . 'backend/_backend.php';
// Tout ce qui concerne l'inclusion de contenus.
require_once INC_PATH . 'content/_content.php';
// Tout ce qui concerne l'inclusion de modules.
require_once INC_PATH . 'modules/_modules.php';
// Chargement des fonctions qui étendent la gamme d'éléments de Wordpress.
require_once 'assets/inc/wp-extend/_wp-extend.php';

// DEFINE /////////////////////////////////////////////
// Assignation des options du thème à des constantes.
// Les options sont converties en constantes pour être accessible dans tout le code.
$options = br_themeoptionsGet();
// Sélection du set d'icône parmis Glyphicon, Font-Awesome, Elusive, etc...
define('BR_ICON_SET', $options['iconset']);
// Fonts chargées par Google
define('BR_FONTS', $options['fonts_google']);
// Active la compilation .less en .css (utile si les .less ont été modifiés)
// Charge tous les scripts .js de bootstrap
define('BR_ALLBSJS', $options['allbsjs']);
// Charge les ailles des images - sous la forme : nomdelataille,width,height; nomdelataille2,width2,height2; ...
define('BR_IMAGE_SIZES', $options['image_sizes']);
// L'identifiant du compte Anakytics
if(isset($options['google_analytics_id'])) {
  define('BR_GOOGLE_ANALYTICS', $options['google_analytics_id']);
}


// BODYROCK /////////////////////////////////////////////
//////// CHARGEMENT DES FEUILLES .CSS ET .JS
/* /!\ Ne pas inclure de numéro de version en paramètre car cela empêche la mise en cache du fichier */
add_action('wp_enqueue_scripts', 'head_scripts');

function head_scripts() {
      // CSS
      switch ( BR_ICON_SET ) {
            case 'elusive' :
                  wp_enqueue_style('icon_set-elusive', get_template_directory_uri() . '/assets/icon_set/elusive-webfont.css', array(), null, false);
                  break;
            case 'font-awesome' :
                  wp_enqueue_style('icon_set-fontawesome', '//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css', array(), null, false);
                  break;
            case 'glyphicon' :
                  wp_enqueue_style('icon_set-glyphicon', get_template_directory_uri() . '/assets/icon_set/glyphicons.css', array(), null, false);
                  break;
      }

      if (!is_child_theme()) {
            wp_enqueue_style('style', get_template_directory_uri() . '/style.css', false, null, 'all');
      } else {
            // CHILD /////////////////////////////////////////////
            //wp_enqueue_style('style-child', get_stylesheet_directory_uri() . '/style.css', false, null, 'all');
            //wp_enqueue_style('bootstrap', '//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css', false, null, 'all');

      }

      // JAVASCRIPT
      // Bootstrap Javascript
      if (BR_ALLBSJS != NULL) {
            //wp_enqueue_script('bootstrap-min-default', '//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js', array('jquery'), null, 1);
      }

      global $options;

      $FG = explode(',', BR_FONTS);
      $i = 0;
      $families = '';
      foreach ($FG as $F) {
            $families .= ($i > 0 ? ',' : false) . "'" . $F . "'";
            $i++;
      }

      // Envoi de valeurs php dans le javascript
      wp_localize_script('script', 'sc_val', array('domaine' => stripslashes(str_replace('http://', '', esc_url( get_home_url() )))));
}

// FONCTIONS SUPPLEMENTAIRES /////////////////////////////////////////////
// CREATION de la meta <link rel=shortlink href=""> via bitly
/*
function bitly_url($login = "unicolored", $apiKey = "R_8de9dc884a5f6e6ba8831909df65d03c", $longUrl = false) {
      $longUrl = ($longUrl == false ? get_permalink() : false);

      if ($longUrl != false) {
            // Meta Shortlink Bitly
            $bitlyurl = false;
            $ch = curl_init('http://api.bitly.com/v3/shorten?login=' . $login . '&apiKey=' . $apiKey . '&longUrl=' . $longUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $result = curl_exec($ch);
            $R = json_decode($result);
            $bitlyurl = '<link rel="shortlink" href="' . $R -> data -> url . '" />';
            echo $bitlyurl;
            return true;
      }
}
*/

function formatIcon($format=false) {
  if($format != false) {
    $Icons = array(
      'audio' => 'feed',
      'aside' => 'road',
      'chat' => 'bubbles',
      'gallery' => 'images',
      'image' => 'images',
      'link' => 'attachment',
      'quote' => 'quotes-left',
      'status' => 'user2',
      'video' => 'film',
    );
    return $Icons[$format];
  }
  else {
    return 'libreoffice';
  }
}

function formatLabel($format=false) {
  if($format != false) {
    $Icons = array(
      'audio' => 'Podcast',
      'aside' => 'En bref',
      'chat' => 'Question',
      'gallery' => 'Album',
      'image' => 'Image',
      'link' => 'Lien',
      'quote' => 'Citation',
      'status' => 'Quoi de neuf ?',
      'video' => 'Vidéo',
    );
    return $Icons[$format];
  }
  else {
    return 'Article';
  }
}
?>
