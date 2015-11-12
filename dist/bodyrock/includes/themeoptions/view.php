<?php
// VIEW Theme options /////////////////////////////////////////////
/*//**//**//**//*//**//**//**//*//**//**//**//*//**//**//**/
// Rendu de la page des options du thème via Wordpress.
/*//**//**//**//*//**//**//**//*//**//**//**//*//**//**//**/

// RENDER PAGE /////////////////////////////////////////////
function themeoptions_viewRender_page() {

  $recommended_plugins = array(
    'cloudflare',
    'disqus-comment-system',
    'editorial-calendar',
    'force-regenerate-thumbnails',
    'wordpress-seo',
  );
  $plugins = get_option('active_plugins');

  // HTML Start
  echo '<div class="wrap">';
  echo '<h1>'.__('bodyRock <small>.gypse</small>', 'bodyrock').'</h1>';
  //echo '<h2 class="nav-tab-wrapper"><a href="http://champagne-demonstration.cave.grappe.xyz/wp-admin/nav-menus.php" class="nav-tab nav-tab-active">CSS &amp; JS</a></h2>';

  echo '<form method="post" action="options.php">';

  submit_button();
  settings_errors();

  settings_fields( 'brthemeoptionsfields' );
  do_settings_sections( 'brthemeoptions' );

  echo '</form>';

  print '<hr>';
  print '<hr>';
  print '<hr>';

  echo '<h3>Extensions</h3>';
  echo '<table class="form-table">';
  echo '<tr width="300">';
  echo '<th>';
  echo '<h4>Activés</h4>';
  echo '</th>';
  echo '<th>';
  echo '<h4>Recommandées</h4>';
  echo '</th>';
  echo '</tr>';
  echo '<tr width="300">';
  echo '<td valign="top">';
  $p=array();
  if($plugins) {
    foreach($plugins as $k=>$v) {
      $plugin = explode('/',$v);
      if(!in_array($plugin[0],$recommended_plugins)) {
        echo $plugin[0].'<br>';
      }
      else echo '<strong>'.$plugin[0].'</strong> <small>recommandé</small><br>';
      $p[] = $plugin[0];
    }
  }
  else {
    echo "Aucune extension n'est installée/activée.";
  }
  echo '</td>';
  echo '<td valign="top">';
  foreach($recommended_plugins as $k=>$v) {
    if(!in_array($v,$p)) {
      echo ''.$v.'<br>';
    }
  }
  echo '</td>';
  echo '</tr>';
  echo '</table>';

  print '<hr>';

  echo '<h3>Infos</h3>';
  echo '<p><small>Date de version : octobre 2015 | '.__('Auteur', 'bodyrock').' : <a href="http://www.gilleshoarau.com/"><strong>Gilles Hoarau</strong></a></small>';
  echo '<br><small>Body<em>rock</em> est un thème orienté développeurs. Il utilise les <a href="http://getbootstrap.com/components/" target="_blank">composants Bootstrap</a>.</small></p>';
  echo '</div>';

}


?>
