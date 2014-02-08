<?php

echo a('article.article','#post-'.get_the_ID());

echo a('header.art-header');
echo '<h1><a href="'.get_permalink().'">'.get_the_title().'</a></h1>';
echo z('/header');

//echo a('div.galaxie');

	if (has_post_thumbnail()) {
		$attrs = br_getPostThumbnail('thumb',false);
		
		echo a('section.art-vignette');
		echo '<a href="'.get_permalink().'"><img src="'.$attrs['src'].'" class="img-responsive img-rounded" width="'.$attrs['width'].'" height="'.$attrs['height'].'" alt="'.get_the_title().'"></a>';
		echo z('/section');
	}
	
	echo a('section.art-content');
		echo get_the_excerpt();
	echo z('/section');
	
//echo z('/div');

echo a('footer.art-footer');
	echo a('div.well.well-sm');
	echo br_content_textesGet_posted_on(' • ');
	if (current_user_can('list-users')) {
		echo ' • <a href="/wp-admin/post.php?post='.get_the_ID().'&action=edit">'.br_getIcon('edit').' Editer</a>';
	}
	echo z('/div');
echo z('/footer');

echo z('article');

