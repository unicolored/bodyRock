<a class="thumbnail" href="<?php echo the_permalink() ?>">







<?php
$size="&w=790&h=366&q=90&s=1";
$videoCode = get_post_meta(get_the_ID(), 'videoCode', true);
$videoType = get_post_meta(get_the_ID(), 'videoType', true);
			
			switch($videoType) {
			case 'vim':
				$hash = unserialize(file_get_contents("http://vimeo.com/api/v2/video/$videoCode.php"));
				echo '<img class="attachment-small-feature wp-post-image" src="/wp-content/themes/_config/inc/timthumb.php?src='.$hash[0]['thumbnail_large'].''.$size.'">'; break;
			case 'you': echo '<img class="attachment-small-feature wp-post-image" src="/wp-content/themes/_config/inc/timthumb.php?src=http://img.youtube.com/vi/'.$videoCode.'/0.jpg'.$size.'">'; break;
}
?> 


<h2 class="h2carousel"><?php the_title() ?></h2></a>