<?php

class bodyrock_carousel extends WP_Widget {

  function bodyrock_carousel() {
    $widget_ops = array('description' => 'Display a carousel of thumbnail of selected posts');
	
    parent::WP_Widget(false, __('Bodyrock: Carousel', 'bodyrock'), $widget_ops);
  }

	function widget($args, $instance) {
		// Valeurs par défaut qui sont éventuellement ecrasées par l'extract de $instance ensuite.
		$thumbnail = 'medium';
		$number_of_posts = 4;
		  
		extract($args);
		extract($instance);
		
        echo $before_widget;
		echo isset($title) ? $before_title.$title.$after_title : false;
		
		echo '
		<div id="carousel-example-generic" class="carousel slide">
			<div class="carousel-inner">';
		
				$the_query2 = new WP_Query('posts_per_page='.$number_of_posts.'&post_status=publish&post_type=post' ); 
				$i=0;
				$indicators = '';
				if ( $the_query2->have_posts() ) :
					while ( $the_query2->have_posts() ) :
						$the_query2->the_post();
						
						$thumb[0] = false;
						$thumb = wp_get_attachment_image_src( get_post_thumbnail_id(), $thumbnail );
						if (has_post_thumbnail()) {
						echo '<div class="item '.($i==0 ? 'active' : false).'">';
						/*								echo '<article class="article" id="post-'.get_the_ID().'" class="single carousel video">';
						echo '<header class="art-header">';
						echo '<h4><a href="'.get_permalink().'">'.get_the_title().'</a></h4>';
						echo '</header>';
						
						echo '<section class="art-vignette" style="height:'.$instance['thumb_height'].'px; background:url('.$thumb[0].') center center no-repeat; '.($instance['thumb_fullsize']==1 ? 'background-size:100%;' : false).' ">';
						echo '</section>';
						echo '</article>';
						*/
						echo '
						<img src="'.$thumb[0].'" class="img-responsive img-rounded center-block" width="'.$thumb[1].'" height="'.$thumb[0].'">
						<div class="carousel-caption">
						<a href="'.get_permalink().'">'.get_the_title().'</a>
						</div>
						';
						echo '</div>';
						
						$indicators .= '<li data-target="#carousel-example-generic" data-slide-to="'.$i.'" '.($i==0?'class="active"':false).'></li>';
						$i++;
						}
					endwhile;
				endif;
		
		echo '</div>
		
		<!-- Controls -->
		<a class="left widget-carousel-control" href="#carousel-example-generic" data-slide="prev">
		<span class="icon-prev"></span>
		</a>
		<a class="right widget-carousel-control" href="#carousel-example-generic" data-slide="next">
		<span class="icon-next"></span>
		</a>
		';
		
		// Indicators
		echo '<ol class="carousel-indicators">';
		echo $indicators;
		echo '</ol>';
		
		//					echo '<a style="height:'.$instance['thumb_height'].'px" class="left carousel-control" href="#carousel-example-generic" data-slide="prev">'.br_getIcon('carousel-control-left').'</a>';
		//					echo '<a style="height:'.$instance['thumb_height'].'px" class="right carousel-control" href="#carousel-example-generic" data-slide="next">'.br_getIcon('carousel-control-right').'</a>';
		echo '		</div>';
		echo "
		<script>
		// CAROUSEL
		if(jQuery('.widget-carousel').length>0) {
			jQuery('.widget-carousel').carousel({
			  interval: 4000
			});
			jQuery('.widget-carousel-control').show();
		}
		</script>
		";
		
		echo $after_widget;
  	}

	function update($new_instance, $old_instance) {
		return $new_instance;
	}

	function form($instance) {
		echo '<p><label for="'.$this->get_field_id('title').'">'.__("Titre (optionnel):", 'bodyrock').'</label>';
		echo '<input name="'.$this->get_field_name('title').'" value="'.$instance['title'].'" type="text" class="widefat" id="'.$this->get_field_id('title').'" /></p>';
		  
		echo '<p><label for="'.$this->get_field_id('number_of_posts').'">'.__("Nombre d'articles à charger", 'bodyrock').'</label>';
		echo '<input name="'.$this->get_field_name('number_of_posts').'" value="'.$instance['number_of_posts'].'" type="text" class="widefat" id="'.$this->get_field_id('number_of_posts').'" /></p>';
		
		echo '<p><label for="'.$this->get_field_id('thumbnail').'">'.__("Taille de l'image", 'bodyrock').'</label>';
		echo '<input name="'.$this->get_field_name('thumbnail').'" value="'.$instance['thumbnail'].'" type="text" class="widefat" id="'.$this->get_field_id('thumbnail').'" /></p>';
	}
}

?>