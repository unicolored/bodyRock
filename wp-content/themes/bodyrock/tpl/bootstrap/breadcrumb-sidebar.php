<?php
global $active_categorie;
wp_reset_query();
?>
<ul>
	<?php
	// FRONT PAGE
	if(is_front_page()) { 
		echo '<li class="active"><h4><span class="label label-default">'.br_getIcon('home').' '.__('Home','gh').'</span></h4></li>';
	}
	else {
		echo '<li><h4><a href="/"><span class="label label-primary">'.br_getIcon('home').' '.__('Home','gh').'</span></a></h4></li>';
	}

	// HOME
	if(is_home()) {
		if(get_query_var('paged')==false || get_query_var('paged')==1) {
			echo '<li class="active">'.br_getIcon('bullhorn').' Portfolio</li>';
		}
		else {
			echo '<li><a href="/blog/">'.br_getIcon('bullhorn').' Portfolio</a></li>';
		}
	}
	
	if(is_home() && get_query_var('paged')>1) {
		echo '<li class="active">Page '.get_query_var('paged').'</li>';
	}
	
	// SINGLE
	if(is_single()) {
		$categories = get_the_category();
		if($categories){
			foreach($categories as $category) {
				$CATS[$category->parent] = '<li class="active"><a href="'.get_category_link( $category->term_id ).'">'.br_getIcon(br_getPageIcon($category->slug)).'&nbsp;'.$category->cat_name.'</a></li>';
			}
			asort($CATS);
			foreach($CATS as $C) {
				echo $C;
			}
		}
	}
	
	// PAGES
	if(is_page() && !is_front_page()) {
		$thispage = get_post(get_the_ID());
		if($thispage->post_parent>0) {
		  $thisparent = get_post($thispage->post_parent);
			echo '<li><a href="'.get_category_link( $thisparent->term_id ).'"><i class="fa fa-'.br_getPageIcon($thisparent->post_name).'"></i> '.$thisparent->post_title.'</a></li>';
		}
		echo '<li class="active">'.br_getPageIcon($thispage->post_name).' '.get_the_title(get_the_ID()).'</li>';		
	}

	// CATEGORY
	if(is_category()) {
		$thiscat = get_category(get_query_var('cat'),false);
			echo 'da'.$thiscat->parent;
		if($thiscat->parent>1) {
			$thiscatparent = get_category($thiscat->parent,false);
			//echo $thiscatparent->slug;
			echo '<li><a href="'.get_category_link( $thiscatparent->term_id ).'">'.br_getPageIcon($thiscatparent->slug).' '.str_replace('<br>','',$thiscatparent->name).'</a></li>';
		}
		echo '<li class="active">'.br_getPageIcon($active_categorie->slug).' '.str_replace('<br>','',$active_categorie->name).'</li>';
	}
	?>  
</ul>