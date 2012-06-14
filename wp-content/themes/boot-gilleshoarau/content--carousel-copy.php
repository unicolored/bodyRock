<a class="thumbnail" href="<?php echo the_permalink() ?>">
<?php
$thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'carousel' );
global $blog_id;
$url = theImgSrc($blog_id, $thumb['0']);
//echo $url;
?>
<img class="thumb" src="<?php echo $url?>" alt="<?php the_title(); ?>" />


<h2 class="h2carousel"><?php the_title() ?></h2></a>