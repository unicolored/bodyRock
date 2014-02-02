<?php
// Widget
$title=isset($title) && $title!='' ? $title : false;

// Relatedposts basés sur les tags en priorité
$tag_ids = false;
foreach($tags as $individual_tag) $tag_ids[] = $individual_tag->term_id;
$showposts = $instance['number_of_posts']; // Nombre de posts à charger au total
if(is_array($tag_ids)) {
	$args=array(
		'post_type' => 'post',
		'tag__in' => $tag_ids,
		'post__not_in' => array($post->ID),
		'showposts'=>$showposts,  // Number of related posts that will be shown.
		'caller_get_posts'=>1,
		'orderdy' => 'date'
	);        
	$my_query = new Wp_Query($args);
}

$i=0;
$param_posts_not_in = array();

if(isset($my_query)) {            
	if( $my_query->have_posts() ) {

		while ($my_query->have_posts()) {
			$my_query->the_post();
			
			$RELATED[$i]['permalink'] = get_permalink();
			$RELATED[$i]['thumbnail'] = br_getPostThumbnail($instance['thumbnail']);
			$RELATED[$i]['title'] = get_the_title();
			$RELATED[$i]['author'] = get_the_author();
			if(has_post_thumbnail() || get_post_format()=="video") {
				$RELATED[$i]['hasthumbnail'] = 1;
			}

			$i++;
		}
	}
	wp_reset_query();
}

// Si le compte de posts n'est pas atteint
if ($i < $showposts) {
	// Identification de la catégorie de l'article
	$post_categories = wp_get_post_categories( get_the_ID() );
	$cats = array();

	$param_cat = '';
	
	foreach($post_categories as $c) {
		$cat = get_category( $c );
		$cats[] = array( 'name' => $cat->name, 'slug' => $cat->slug );
		$param_cat .= $cat->cat_ID.',';
	}
	
	$ppp = $showposts-$i;
	$param_posts_not_in[] = $post->ID;
	
	// On charge des articles de la même catégorie
	$args2=array(
		'post_type' => 'post',
		'orderby' => 'date',
		'cat' => $param_cat,
		'post__not_in' => $param_posts_not_in,
		'showposts'=>$ppp,  // Number of related posts that will be shown.
	);        
	$cat_query = new Wp_Query($args2);

	if( $cat_query->have_posts() ) {
		while ($cat_query->have_posts()) {
			$cat_query->the_post();
			$RELATED[$i]['permalink'] = get_permalink();
			$RELATED[$i]['thumbnail'] = br_getPostThumbnail($instance['thumbnail']);
			$RELATED[$i]['title'] = get_the_title();
			$RELATED[$i]['author'] = get_the_author();
			if(has_post_thumbnail() || get_post_format()=="video") {
				$RELATED[$i]['hasthumbnail'] = 1;
			}
			$i++;
		}
	}
}

// RESULTATS
for($i=0;$i<$showposts;$i++) {
	if(isset($RELATED[$i]['title'])) {
		echo '<article class="article">';
		
		if($RELATED[$i]['hasthumbnail']) {
			echo '<section class="art-vignette">';
			echo '<a href="'.$RELATED[$i]['permalink'].'">'.$RELATED[$i]['thumbnail'].'</a>';
			echo '</section>';
		}
		
		if($instance['thumbnail_only'] != 1) {
			echo '<header class="art-header">';
			echo '<a href="'.$RELATED[$i]['permalink'].'">'.$RELATED[$i]['title'].'</a>';
			echo '</header>';
			
			echo '<footer class="art-footer">';
			echo '<p><small>Proposé par '.$RELATED[$i]['author'].'</small></p>';
			echo '</footer>';
		}
		echo '</article>';
	}
}
?>