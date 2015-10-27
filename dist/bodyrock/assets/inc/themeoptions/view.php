<?php

// VIEW Theme options /////////////////////////////////////////////

/*//**//**//**//*//**//**//**//*//**//**//**//*//**//**//**/
// Rendu de la page des options du thème via Wordpress.
/*//**//**//**//*//**//**//**//*//**//**//**//*//**//**//**/

 
// RENDER PAGE /////////////////////////////////////////////
function themeoptions_viewRender_page() {

	// Régénère le .htaccess afin de prendre en compte les éventuels changement de custom types.
//	flush_rewrite_rules();

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
		echo '<h2>'.__('Bodyrock .talc', 'bodyrock').'</h2>';

		echo '<form method="post" action="options.php">';

			settings_errors();

			settings_fields( 'brthemeoptionsfields' );
			do_settings_sections( 'brthemeoptions' );

			// Recommandations
			echo '<h2>Recommandations</h2>';
			echo '<table class="form-table">';
				echo '<tr valign="top">';
				echo '<td width="300">';

				echo '<h3>Activés</h3>';
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
				echo '<td>';

				echo '<h3>Autres extensions recommandées</h3>';
				foreach($recommended_plugins as $k=>$v) {
					if(!in_array($v,$p)) {
					echo ''.$v.'<br>';
					}
				}
				echo '</td>';
				echo '</tr>';

			echo '</table>';

			submit_button();

		echo '</form>';
	echo '</div>';

}


?>
