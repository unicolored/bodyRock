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
	function br_getPostThumbnail($size='thumbnail',$echoimg=true,$id=false) {
		$array_sizes = array('thumbnail','medium','large'); // TOFIX : ajouter les tailles personnalisées
		$size = in_array($size,$array_sizes) ? $size : 'thumbnail';
		$classvideo = false;

		if($id==false) $id = get_the_ID();
		$format = get_post_format($id);

		if ($format=='video') {
			$videoCode = get_post_meta($id, 'videoCode', true);
			$videoType = get_post_meta($id, 'videoType', true);
			$classvideo = ' img-video-'.$videoType;		
			$attr['src'] = CDN_PATH.'images/videos/'.$videoType.'/'.$videoCode.br_getImgVideoSize($size).'.jpg';

			if(!file_exists($attr['src'])) {
				$attr['src']='/senzu/'.strtolower(get_bloginfo('name')).'/images/videos/'.$videoType.'/'.$videoCode.br_getImgVideoSize($size).'.jpg';
			}
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
		$array['large'] = '-1024xh';
		return $array[$size];
	}
}

function getImgVideo() {
	$path_name = strtolower(get_bloginfo('name'));
	if ( get_post_format() == 'video' ) {
    $videoCode = get_post_meta(get_the_ID(), 'videoCode', true);
    $videoType = get_post_meta(get_the_ID(), 'videoType', true);
    
    $destination = 'senzu/'.$path_name.'/images/videos/'.$videoType.'/'.$videoCode.'.jpg';
    if (!file_exists(ABSPATH.$destination)) {
        switch($videoType) {
            case 'vim':
                $hash = unserialize(file_get_contents("http://vimeo.com/api/v2/video/$videoCode.php"));
                $urlimg = $hash[0]['thumbnail_large'];
                break;
            case 'you':
                $urlimg = 'http://img.youtube.com/vi/'.$videoCode.'/hqdefault.jpg';
            break;
        }            
        copy($urlimg , ABSPATH.$destination);
    }
    if (!file_exists(ABSPATH.'senzu/'.$path_name.'/images/videos/'.$videoType.'/'.$videoCode.'-1024xh.jpg')
    || !file_exists(ABSPATH.'senzu/'.$path_name.'/images/videos/'.$videoType.'/'.$videoCode.'-200x200.jpg')) {
        $img = wp_get_image_editor( ABSPATH.$destination );
        if ( ! is_wp_error( $img ) ) {
            $img->set_quality( 100 );
            $size = $img->get_size();
    
            $sizes_array = 	array(
                array ('width' => 200, 'height' => 200, 'crop' => true)
            );                
            $resize = $img->multi_resize( $sizes_array );
            
            $img->crop( 0, 0, $size['width'], $size['height'], 1024, ($size['height']*(1024/$size['width'])));
            $filename = $img->generate_filename( '1024xh', ABSPATH.'senzu/'.$path_name.'/images/videos/'.$videoType.'/', 'jpg' );
            $img->save($filename);
        }
    }
    if (!file_exists(ABSPATH.'senzu/unicolored/images/videos/'.$videoType.'/'.$videoCode.'-320xh.jpg')) {
        $img2 = wp_get_image_editor( ABSPATH.'senzu/'.$path_name.'/images/videos/'.$videoType.'/'.$videoCode.'-1024xh.jpg' );
        if ( ! is_wp_error( $img2 ) ) {
            $img2->set_quality( 100 );
            $size = $img2->get_size();
            $resize = $img2->resize( 320, ($size['height']*(320/$size['height'])) );
            $filename = $img2->generate_filename( '320xh', ABSPATH.'senzu/'.$path_name.'/images/videos/'.$videoType.'/', 'jpg' );
            $img2->save(str_replace('-1024xh','',$filename));
        }
    }
}
}


?>