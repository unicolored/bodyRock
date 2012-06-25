<a class="thumbnail" href="<?php echo the_permalink() ?>">
<?php
$thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'large-feature' );
global $blog_id;
$url = theImgSrc($blog_id, $thumb['0']);
//echo $url;
?>
<img class="thumb attachment-small-feature wp-post-image" src="/wp-content/themes/_config/inc/timthumb.php?src=<?php echo $url?>&w=274&h=366q=90&s=1" alt="<?php the_title(); ?>" />


<?php the_title() ?></a>