<article>
	<header>
		<a class="thumbnail" href="<?php echo the_permalink() ?>"><?php the_title() ?></a>
	</header>
	<section>
		<?php
		$url= false;
		$i=0;
		$thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'projet-thumbsquare' );
		global $blog_id;
		$url[$i] = theImgSrc($blog_id, $thumb['0']);
		if ($url[$i]!=NULL) {
			$thethumb = '<a class="" style="float:left; margin-right:1em;" href="'.get_permalink().'"><img class="thumb" src="'.$url[$i].'" alt="'.get_the_title().'" /></a>';
		}
		else $thethumb=false;
		$i++;
		?>
		<?php echo $thethumb ?>
		<?php the_excerpt() ?>
	</section>
</article>