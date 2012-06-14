<!--<a href='<?php echo the_permalink() ?>' title='<?php the_title(); ?>'>
<?php
global $url;
global $input;
global $image_src;
global $rand_keys;
//echo $url;
?>
<img src="<?php echo $url?>">
</a>-->

<?php
							$url= false;
							$i=0;
							$thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'medium' );
							global $blog_id;
							$url[$i] = theImgSrc($blog_id, $thumb['0']);
							if ($url[$i]!=NULL) {
								$thethumb = '<a class="thumbnail" href="'.get_permalink().'"><img class="thumb" src="'.$url[$i].'" alt="'.get_the_title().'" /></a>';
							}
							else $thethumb=false;
							$i++;
							?>
							<?php echo $thethumb ?>