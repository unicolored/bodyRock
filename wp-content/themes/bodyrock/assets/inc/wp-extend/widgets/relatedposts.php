<?php
global $post, $instance;

// Affiche des articles similaires au single en cours
// Basé sur les tags puis sur les catégories
class bodyrock_relatedposts extends WP_Widget {

	function bodyrock_relatedposts() {
		$widget_ops = array('description' => __("Affiche une liste d'articles similaires à l'article en cours sur 'single' uniquement.", 'bodyrock'));
		parent::WP_Widget(false, __('BR Articles similaires', 'bodyrock'), $widget_ops);
	}

	function widget($args, $instance) {
		if(is_single()) {
			// S'affiche uniquement sur 'single'
			extract($args);
			extract($instance);

			$type=get_post_type( $post );
			$type=($type=='post' || $type==false ? 'post' : $type);

			$tags = wp_get_post_tags($post->ID);

			echo $before_widget;
			if (isset($title)) {
				echo $before_title, $title, $after_title;
			}
			require 'relatedposts/default-view.php';
			echo $after_widget;
				
			wp_reset_query();
		}
	}

	function update($new_instance, $old_instance) {
		return $new_instance;
	}

	function form($instance) {
		echo '<h1>'.__("BR Articles similaires","bodyrock").'</h1>';
		echo '<p>';
		echo '<label for="'.$this->get_field_id('title').'">'._e('Titre <small>(optionnel)</small>:', 'bodyrock').'</label> ';
		echo '<input type="text" name="'.$this->get_field_name('title').'" value="'.(isset($instance['title']) ? esc_attr($instance['title']) : false).'" class="widefat" id="'.(isset($instance['title']) ? $this->get_field_id('title') : false).'" />';
		echo '<br><small>ex. Article similaires, Recommandations, ...</small>';
		echo '</p>';

		echo '<p>';
		echo '<label for="'.$this->get_field_id('number_of_posts').'">'._e('Nombre d\'articles à afficher :', 'bodyrock').'</label> ';
		echo '<input type="text" name="'.$this->get_field_name('number_of_posts').'" value="'.(isset($instance['number_of_posts']) ? esc_attr($instance['number_of_posts']) : false).'" class="widefat" id="'.(isset($instance['number_of_posts']) ? $this->get_field_id('number_of_posts') : false).'" />';
		echo '</p>';
		echo '<hr>';
		echo '<h2>'.__("Thumbnail","bodyrock").'</h2>';
		echo '<p>';
		echo '<label for="'.$this->get_field_id('thumbnail').'">'._e('Taille de la vignette :', 'bodyrock').'</label> ';
//		echo '<input type="text" name="'.$this->get_field_name('thumbnail').'" value="'.(isset($instance['thumbnail']) ? esc_attr($instance['thumbnail']) : false).'" class="widefat" id="'.(isset($instance['thumbnail']) ? $this->get_field_id('thumbnail') : false).'" />';		
		foreach( get_intermediate_image_sizes() as $s ){
 			$sizes[ $s ] = array( 0, 0 );
 			if( in_array( $s, array( 'thumbnail', 'medium', 'large' ) ) ){
 				$sizes[ $s ][0] = get_option( $s . '_size_w' );
 				$sizes[ $s ][1] = get_option( $s . '_size_h' );
 			}else{
 				if( isset( $_wp_additional_image_sizes ) && isset( $_wp_additional_image_sizes[ $s ] ) )
 					$sizes[ $s ] = array( $_wp_additional_image_sizes[ $s ]['width'], $_wp_additional_image_sizes[ $s ]['height'], );
 			}
 		} 		
		echo '<select name="'.$this->get_field_name('number_of_posts').'" value="'.(isset($instance['number_of_posts']) ? esc_attr($instance['number_of_posts']) : false).'">';
 		foreach( $sizes as $size => $atts ){
			echo '<option '.selected($instance['thumbnail'],$size).' name="'.$this->get_field_name('thumbnail').'" value="'.$size.'">'.$size.'</option>';
// 			echo $size . ' ' . implode( 'x', $atts ) . "\n";
 		}
		echo '</select>';
		echo '</p>';
		
		echo '<p>';
		echo '<input type="checkbox" name="'.$this->get_field_name('thumbnail_only').'" value="1" id="thumbnail_only" ';
		checked($instance['thumbnail_only'],1);
		echo ' /> ';
		echo '<label for="'.$this->get_field_id('thumbnail_only').'">'._e('Ne montrer que les articles qui possèdent une image de couverture.', 'bodyrock').'</label>';
		echo '<br><small>En cochant cette case vous filtrez le nombre de posts choisis plus haut.</small>';
		echo '</p>';
	}
}

?>