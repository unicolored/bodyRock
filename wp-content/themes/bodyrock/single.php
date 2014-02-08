<?php
get_header();

if (get_post_format()=='video') {
	// Spécifique aux formats video
	global $urlfinale, $videoType, $videoCode;
	
	$videoCode = get_post_meta(get_the_ID(), 'videoCode', true);
	$videoType = get_post_meta(get_the_ID(), 'videoType', true);
	
	$urlfinale = CDN_PATH.'images/videos/'.$videoType.'/'.$videoCode.br_getImgVideoSize('thumbnail').'.jpg';
}
/************** HTML START **************/

echo a('section.content');

	if ( have_posts() ) :
	
		while ( have_posts() ) :
		
			the_post();
			setPostViews(get_the_ID());	
			get_template_part(TPL_SINGULAR_PATH.'single', get_post_format());
			
		endwhile;
		
	else:
	
		echo '<p>'.__('Sorry, no posts matched your criteria.').'</p>';
		
	endif;
	
echo '</section>';

if (get_post_format()=='video') {
	// La hauteur de la vidéo est définie d'abord dans les options du thème
	// puis par article, il est possible de spécifier une taille distincte
	$custom = get_post_custom($post->ID);
	
	$videoCode = isset($custom["videoCode"][0]) ? $custom["videoCode"][0] : false;
	$videoType = isset($custom["videoType"][0]) ? $custom["videoType"][0] : false;
	$videoHeight = isset($custom["videoHeight"][0]) && $custom["videoHeight"][0]!=false ? $custom["videoHeight"][0] : BR_VIDEO_HEIGHT;
	
	// Spécifique aux formats video
	// Chargement des objets vidéos
	echo "<script>\n";
	echo 'jQuery(document).ready(function(){'."\n";
	echo "// AFFICHAGE DES VIDEOS Si le conteneur identifié est trouvé\n"."\n"."\n";
	
	echo '
		if(jQuery(\'#singlevideoyou\').length>0) { // Youtube
			jQuery(\'#singlevideoyou\').html(\'<iframe width="100%" height="'.$videoHeight.'" src="//www.youtube.com/embed/\'+(jQuery(\'#singlevideoyou\').attr(\'class\').replace(\'code_\', \'\'))+\'?rel=0&amp;autoplay='.BR_VIDEO_AUTOPLAY.'&related=0" frameborder="0" allowfullscreen></iframe>\');
		}
		if(jQuery(\'#singlevideovim\').length>0) { // Vimeo
			jQuery(\'#singlevideovim\').html(\'<iframe src="//player.vimeo.com/video/\'+(jQuery(\'#singlevideovim\').attr(\'class\').replace(\'code_\', \'\'))+\'?badge=0&amp;color=db0000&amp;autoplay='.BR_VIDEO_AUTOPLAY.'" width="100%" height="'.BR_VIDEO_HEIGHT.'" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>\');
		}
	';
	
	echo '});'."\n";
	echo "</script>\n";
}
	
get_template_part(TPL_SIDEBAR_PATH.'sidebar','left');

get_template_part(TPL_SIDEBAR_PATH.'sidebar','right');
	
get_footer();
?>