<?php global $i;

if(get_post_format()=='video') {
	$videoCode = get_post_meta(get_the_ID(), 'videoCode', true);
	$videoType = get_post_meta(get_the_ID(), 'videoType', true);
	
	$urlfinale = CDN_PATH.'/images/videos/'.$videoType.'/'.$videoCode.'-1024xh.jpg';
//	$thethumb = '<img class="img-responsive" height="450" alt="'.get_the_title().'" src="'.$urlfinale.'" alt="'.strip_tags(get_the_title()).'">';
}
else {
			$src = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large', false, '' );
			$urlfinale = $src[0];
}
//echo $urlfinale;
?>

<div class="item <?php echo ($i==0 ? 'active' : false); ?>">
    <article class="article" id="post-<?php the_ID(); ?>" <?php post_class('single carousel video'); ?>>
		<header class="art-header text-center">
			<h1><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h1>
		</header>    
    
        <section class="art-vignette" style="height:320px; background:url(<?php echo $urlfinale; ?>) center center no-repeat; background-size:100%; ">
        </section>    
    </article>    
</div>