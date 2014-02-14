<?php

// FILES Backend /////////////////////////////////////////////

/*//**//**//**//*//**//**//**//*//**//**//**//*//**//**//**/
// Génération de fichiers.
/*//**//**//**//*//**//**//**//*//**//**//**//*//**//**//**/

require_once ABSPATH.THEME_PATH.'assets/inc/_libs/less/lessc040.inc.php';  // LESSCPHP

// WRITE VIDEO IMG /////////////////////////////////////////////
// Génère les images de vidéos et les enregistre dans senzu
function br_backend_filesWrite_videoimg() {
	if ( get_post_format() == 'video' ) {
		echo $videoCode;
		$videoCode = get_post_meta(get_the_ID(), 'videoCode', true);
		$videoType = get_post_meta(get_the_ID(), 'videoType', true);
		
		$destination = 'senzu/bodyrock/images/videos/'.$videoType.'/'.$videoCode.'.jpg';
		if (!file_exists(ABSPATH.$destination)) {
			switch($videoType) {
				case 'vim':
					$hash = unserialize(file_get_contents("https://vimeo.com/api/v2/video/$videoCode.php"));
					$urlimg = $hash[0]['thumbnail_large'];
					break;
				case 'you':
					$urlimg = 'https://img.youtube.com/vi/'.$videoCode.'/hqdefault.jpg';
				break;
			}            
			copy($urlimg , ABSPATH.$destination);
		}
		if (!file_exists(ABSPATH.'senzu/bodyrock/images/videos/'.$videoType.'/'.$videoCode.'-1024xh.jpg')
		|| !file_exists(ABSPATH.'senzu/bodyrock/images/videos/'.$videoType.'/'.$videoCode.'-200x200.jpg')) {
			$img = wp_get_image_editor( ABSPATH.$destination );
			if ( ! is_wp_error( $img ) ) {
				$img->set_quality( 100 );
				$size = $img->get_size();
		
				$sizes_array = 	array(
					array ('width' => 200, 'height' => 200, 'crop' => true)
				);                
				$resize = $img->multi_resize( $sizes_array );
				
				$img->crop( 0, 0, $size['width'], $size['height'], 1024, ($size['height']*(1024/$size['width'])));
				$filename = $img->generate_filename( '1024xh', ABSPATH.'senzu/bodyrock/images/videos/'.$videoType.'/', 'jpg' );
				$img->save($filename);
			}
		}
		if (!file_exists(ABSPATH.'senzu/bodyrock/images/videos/'.$videoType.'/'.$videoCode.'-320xh.jpg')) {
			$img2 = wp_get_image_editor( ABSPATH.'senzu/bodyrock/images/videos/'.$videoType.'/'.$videoCode.'-1024xh.jpg' );
			if ( ! is_wp_error( $img2 ) ) {
				$img2->set_quality( 100 );
				$size = $img2->get_size();
				$resize = $img2->resize( 320, ($size['height']*(320/$size['height'])) );
				$filename = $img2->generate_filename( '320xh', ABSPATH.'senzu/bodyrock/images/videos/'.$videoType.'/', 'jpg' );
				$img2->save(str_replace('-1024xh','',$filename));
			}
		}
	}
}

// AUTO COMPILE LESS /////////////////////////////////////////////
// Compilation des fichiers .less en fichier .css
function backend_filesWrite_less($less_fname, $css_fname) {
	// load the cache
	$cache_fname = $less_fname.".cache";
	if (file_exists($cache_fname)) {
		$cache = unserialize(file_get_contents($cache_fname));
	} else {
		$cache = $less_fname;
	}
	
	$new_cache = lessc::cexecute($cache);
	
	if (!is_array($cache) || $new_cache['updated'] > $cache['updated']) {
		file_put_contents($cache_fname, serialize($new_cache));
		file_put_contents($css_fname, $new_cache['compiled']);
	}
}