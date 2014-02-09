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
	
get_template_part(TPL_SIDEBAR_PATH.'sidebar','left');

get_template_part(TPL_SIDEBAR_PATH.'sidebar','right');
	
get_footer();
?>