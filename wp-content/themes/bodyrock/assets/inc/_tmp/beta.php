<?php

// BETA :: Fonctions pas encore utilisées ///////////////////////////////////////////// 

/*//**//**//**//*//**//**//**//*//**//**//**//*//**//**//**/
// Fonctions betas, en développement.
/*//**//**//**//*//**//**//**//*//**//**//**//*//**//**//**/


function cleanCut($string,$length,$cutString = '...')
{
	if(strlen($string) <= $length)
	{
		return $string;
	}
	$str = substr($string,0,$length-strlen($cutString)+1);
	return substr($str,0,strrpos($str,' ')).$cutString;
}

// GOOGLE ANALYTICS ///////////////////////////////////////////// INTERFACE
// Insère l'ID Google Analytics des options du thème.
// TOFIX : Il faudrait le placer dans le hook footer
function bodyrock_google_analytics() {
  global $bodyrock_options;
  //settings_fields('bodyrock_options');
  $bodyrock_options = bodyrock_get_theme_options();
  $name = str_replace('http://','',get_bloginfo('url'));
  if($bodyrock_options) :
	  $bodyrock_google_analytics_id = $bodyrock_options['google_analytics_id'];
	  $get_bodyrock_google_analytics_id = esc_attr($bodyrock_options['google_analytics_id']);
	  if ($bodyrock_google_analytics_id !== '') {
		echo "
		<script type='text/javascript'>
		  var _gaq = _gaq || [];
		  _gaq.push(['_setAccount', '".$bodyrock_google_analytics_id."']);
		  _gaq.push(['_setDomainName', '".$name."']);
		  _gaq.push(['_trackPageview']);
		
		  (function() {
			var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
			ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		  })();
		
		</script>
		";
	  }
	endif;
}

// REPORT ///////////////////////////////////////////// BACKEND
// Activation des customs types sélectionnés dans les options du thème.
function ghReport($msg,$titre='Notification',$type='mail') {
	// TOFIX : utiliser la fonction wp_mail() 
	// http://codex.wordpress.org/Function_Reference/wp_mail
	switch($type) {
		case 'mail':
			mail(get_bloginfo('admin_email'), $titre, stripslashes("Message : \n\n".$msg), "From:nepasrepondre@gilleshoarau.com\n");
		break;
		case 'echo':
			$_SESSION['ghReport'] .= '<br><br>'.$titre.' : '.$msg;
		break;
	}
}

// GET CATEGORY TAGS ///////////////////////////////////////////// CONTENT
// Retourne les tags d'une catégorie.
function get_category_tags($args) {
	global $wpdb;
	$tags = $wpdb->get_results
	("
		SELECT DISTINCT terms2.term_id as tag_id, terms2.name as tag_name, null as tag_link
		FROM
			wp_posts as p1
			LEFT JOIN wp_term_relationships as r1 ON p1.ID = r1.object_ID
			LEFT JOIN wp_term_taxonomy as t1 ON r1.term_taxonomy_id = t1.term_taxonomy_id
			LEFT JOIN wp_terms as terms1 ON t1.term_id = terms1.term_id,

			wp_posts as p2
			LEFT JOIN wp_term_relationships as r2 ON p2.ID = r2.object_ID
			LEFT JOIN wp_term_taxonomy as t2 ON r2.term_taxonomy_id = t2.term_taxonomy_id
			LEFT JOIN wp_terms as terms2 ON t2.term_id = terms2.term_id
		WHERE
			t1.taxonomy = 'category' AND p1.post_status = 'publish' AND terms1.term_id IN (".$args['categories'].") AND
			t2.taxonomy = 'post_tag' AND p2.post_status = 'publish'
			AND p1.ID = p2.ID
		ORDER by tag_name
	");
	$count = 0;
	foreach ($tags as $tag) {
		$tags[$count]->tag_link = get_tag_link($tag->tag_id);
		$count++;
	}
	return $tags;
}
	
// UPDATE POST META ///////////////////////////////////////////// WP EXTEND
// Mise à jour d'un post ajouter à partir du FrontOffice.
function __update_post_meta( $post_id, $field_name, $value = '' )
{
	if ( empty( $value ) OR ! $value )
	{
		delete_post_meta( $post_id, $field_name );
	}
	elseif ( ! get_post_meta( $post_id, $field_name ) )
	{
		add_post_meta( $post_id, $field_name, $value );
	}
	else
	{
		update_post_meta( $post_id, $field_name, $value );
	}
}

// GET COLORS IMG ///////////////////////////////////////////// WP EXTEND
// Récupérer les couleurs d'une image
function getColorsImg($source_file) {
	// TOFIX : Enregistrer la couleur si possible
	$average = array('red'=>0,'green'=>0,'blue'=>0);
	
	if(file_exists($source_file)) {
		$im = ImageCreateFromJpeg($source_file); 
		
		$imgw = imagesx($im);
		$imgh = imagesy($im);
		
		// n = total number or pixels
		
		$n = $imgw*$imgh;
		
		$histo = array();
		
		for ($i=0; $i<$imgw; $i++)
		{
			for ($j=0; $j<$imgh; $j++)
			{        
				// get the rgb value for current pixel            
				$rgb = ImageColorAt($im, $i, $j);             
				// extract each value for r, g, b            
				$r = ($rgb >> 16) & 0xFF;
				$g = ($rgb >> 8) & 0xFF;
				$b = $rgb & 0xFF;
				
				// get the Value from the RGB value            
				$V = round(($r + $g + $b) / 3);            
				$rTotal += $r;
				$gTotal += $g;
				$bTotal += $b;
				$total++;
				
				// add the point to the histogram            
				$histo[$V] += $V / $n;        
			}
		}    
		$average['red'] = round($rTotal/$total);    
		$average['green'] = round($gTotal/$total);    
		$average['blue'] = round($bTotal/$total);
	}
	return $average;
}