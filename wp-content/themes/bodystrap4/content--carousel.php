<a class="thumbnail" href="<?php echo the_permalink() ?>">
<?php
$thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'large-feature' );
global $blog_id;
$url = theImgSrc($blog_id, $thumb['0']);
//echo $url;
?>
<img class="thumb" src="/wp-content/themes/_config/inc/timthumb.php?src=<?php echo $url?>&w=790&h=366&q=90&s=1" alt="<?php the_title(); ?>" />


<h2 class="h2carousel"><?php the_title() ?></h2></a>