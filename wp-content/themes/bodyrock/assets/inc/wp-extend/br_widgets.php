<?php

// WIDGETS Wp extend /////////////////////////////////////////////

/*//**//**//**//*//**//**//**//*//**//**//**//*//**//**//**/
// Chargement des Widgets Bodyrock
/*//**//**//**//*//**//**//**//*//**//**//**//*//**//**//**/


// AJOUT DES WIDGETS AU THEME
add_filter('dynamic_sidebar_params', 'first_last_classes');

function br_register_widgets() {
	require_once 'widgets/bodyloop.php';  // Display Related Posts
	register_widget('br_widgetsBodyloop'); // Tous les noms de widgets devraient suivrent cette nomenclature
	
	require_once 'widgets/carousel.php';  // basics
	register_widget('bodyrock_carousel');
	
	require_once 'widgets/categories.php';  // basics
	register_widget('bodyrock_categories');
	
	require_once 'widgets/recentposts.php';  // basics
	register_widget('bodyrock_recentposts');
}

// AJOUT D'UN WIDGET DANS SUR LA DASHBOARD WORDPRESS
add_action('wp_dashboard_setup', 'my_custom_dashboard_widgets');
 
function my_custom_dashboard_widgets() {
	global $wp_meta_boxes;
	
	wp_add_dashboard_widget('welcome_bodyrock', 'Bodyrock', 'call_widgetDashboard_welcome');
}

function call_widgetDashboard_welcome() {
echo '<p>Bienvenue sur Wordpress propulsé par Bodyrock.</p>';
}

// TOFIX : Temporairement désactivés
//require_once 'widgets/br_googleplus_addtocircles.php';  // Google+ Add to circles Button
//require_once 'widgets/br_twitter_fluxprofile.php';  // Twitter flux du profil.
//require_once 'widgets/br_facebook_streamnfaces.php';  // Twitter flux du profil.


// BODYROCK /////////////////////////////////////////////
// Ajoute une classe spécifique au premier et au dernier widget de la sidebar
// http://wordpress.org/support/topic/how-to-first-and-last-css-classes-for-sidebar-widgets
function first_last_classes($params) {
  global $my_widget_num;
  $this_id = $params[0]['id'];
  $arr_registered_widgets = wp_get_sidebars_widgets();

  if (!$my_widget_num) {
    $my_widget_num = array();
  }

  if (!isset($arr_registered_widgets[$this_id]) || !is_array($arr_registered_widgets[$this_id])) {
    return $params;
  }

  if (isset($my_widget_num[$this_id])) {
    $my_widget_num[$this_id] ++;
  } else {
    $my_widget_num[$this_id] = 1;
  }

  $class = 'class="widget-' . $my_widget_num[$this_id] . ' ';

  if ($my_widget_num[$this_id] == 1) {
    $class .= 'widget-first ';
  } elseif ($my_widget_num[$this_id] == count($arr_registered_widgets[$this_id])) {
    $class .= 'widget-last ';
  }

  $params[0]['before_widget'] = str_replace('class="', $class, $params[0]['before_widget']);

  return $params;

}

?>
