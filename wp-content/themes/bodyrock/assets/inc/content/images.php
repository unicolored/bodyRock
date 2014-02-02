<?php

// IMAGE Content /////////////////////////////////////////////

/*//**//**//**//*//**//**//**//*//**//**//**//*//**//**//**/
// Tout ce qui concerne les paramètres liés aux images.
/*//**//**//**//*//**//**//**//*//**//**//**//*//**//**//**/


// ADD THEME SUPPORT /////////////////////////////////////////////
// Ajoute la gestion des images de couverture.
add_theme_support( 'post-thumbnails' );


$options = get_option('brthemeoptions', themeoptionsGet_default());

$IS = explode(';',$options['image_sizes']);
foreach ($IS as $I) {
	$S = explode(',',$I);
	add_image_size( $S[0], $S[1], $S[2], $S[3] == 1 ? true : false );
}

// GET POST THUMBNAIL ///////////////////////////////////////////// CONTENT
// Récupère l'image de tous posts dans un format générique
if(!function_exists('br_getPostThumbnail')) { // Permet l'override par le fichier functions.php du thème child
	function br_getPostThumbnail($size='thumbnail',$echoimg=true) {
		$array_sizes = array('thumbnail','medium','large'); // TOFIX : ajouter les tailles personnalisées
		$size = in_array($size,$array_sizes) ? $size : 'thumbnail';
		
		if($id==false) $id = get_the_ID();
		$format = get_post_format($id);

		if ($format=='video') {
			$videoCode = get_post_meta($id, 'videoCode', true);
			$videoType = get_post_meta($id, 'videoType', true);
			$classvideo = ' img-video-'.$videoType;		
			$attr['src'] = CDN_PATH.'/images/videos/'.$videoType.'/'.$videoCode.br_getImgVideoSize($size).'.jpg';
		}
		else {
			if (has_post_thumbnail($id)) {
				$thumb = wp_get_attachment_image_src(get_post_thumbnail_id($id),$size);
				$attr['src'] = $thumb[0];
				$attr['width'] = $thumb[1];
				$attr['height'] = $thumb[2];
			}
			else return false; //'<span class="label label-default">'.__('No image').'</span>';
		}
		
		$attr['alt'] = strip_tags(get_the_title());
		$attr['class'] = 'image img-responsive img'.$format.''.$classvideo;
		
		if ($echoimg == true) {
			$thumbnail = '<img src="'.$attr['src'].'" class="'.$attr['class'].'" alt="'.$attr['alt'].'" width="'.$attr['width'].'" height="'.$attr['height'].'" />';
			return $thumbnail;
		}
		else {
			return $attr;
		}
	}
}

// GET IMG VIDEO SIZE ///////////////////////////////////////////// BODYROCK
// Tailles d'images de vidéos en correspondance avec les tailles d'images personnalisées
if(!function_exists('br_getImgVideoSize')) { // Permet l'override par le fichier functions.php du thème child
	function br_getImgVideoSize($size='default') {
		$array['default'] = $array['thumbnail'] = '-200x200';
		$array['medium'] = '-320xh';
		$array['medium2'] = '';
		$array['large'] = '-1024xh';
		return $array[$size];
	}
}




?>