<?php

class bodyrock_relatedposts extends WP_Widget {

  function bodyrock_relatedposts() {
    $widget_ops = array('description' => 'Display Related Posts');
    parent::WP_Widget(false, __('Bodyrock: RelatedPosts', 'bodyrock'), $widget_ops);
  }

  function widget($args, $instance) {
	if(is_single()) {
    extract($args);
    extract($instance);
	global $post;
	$type=get_post_type( $post );
	$type=($type=='post' || $type==false ? 'post' : 'type');
	
	$tags = wp_get_post_tags($post->ID);
	if ($tags) {
    echo $before_widget;
    if ($title) {
      echo $before_title, $title, $after_title;
    }
  ?>
    <div class="relatedposts row">
      <?php		
			$tag_ids = array();
			foreach($tags as $individual_tag) $tag_ids[] = $individual_tag->term_id;
			
			$args=array(
			'tag__in' => $tag_ids,
			'post__not_in' => array($post->ID),
			'showposts'=>4,  // Number of related posts that will be shown.
			'caller_get_posts'=>1
			);
			
			$my_query = new wp_query($args);
			if( $my_query->have_posts() ) {
			echo '<h3>Recommandations</h3><ul class="thumbnails">';
			while ($my_query->have_posts()) {
			$my_query->the_post();
			?>
			
			<?php
			if ( has_post_thumbnail() && $thumbnail!=='' ) { ?>
			<li class="span2"><a class="thumbnail" href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_post_thumbnail($thumbnail); ?> <h5><?php the_title(); ?></h5></a></li>
			<?php } 
			elseif(get_post_format()=='video') {
				$size="&w=150&h=150&q=90&s=1";
				$videoCode = get_post_meta(get_the_ID(), 'videoCode', true);
				$videoType = get_post_meta(get_the_ID(), 'videoType', true);
					
							switch($videoType) {
										case 'vim':
											$hash = unserialize(file_get_contents("http://vimeo.com/api/v2/video/$videoCode.php"));
											$img='<img class="attachment-small-feature wp-post-image" src="/wp-content/themes/_config/inc/timthumb.php?src='.$hash[0]['thumbnail_large'].''.$size.'">'; break;
										case 'you': $img='<img class="attachment-small-feature wp-post-image" src="/wp-content/themes/_config/inc/timthumb.php?src=http://img.youtube.com/vi/'.$videoCode.'/0.jpg'.$size.'"> <?php the_title(); ?>'; break;
							}
				?>
				<li class="span2"><a class="thumbnail" href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php echo $img; ?> <h5><?php the_title(); ?></h5></a></li>
				<?php
			}
			else { ?>
			<li class="span2"><a class="thumbnail" href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></li>
			<?php }
			?>
			
			<?php
			}
			echo '</ul>';
			}
		
	  ?>
    </div>
    <?php
      echo $after_widget;
	  }
		$post = $backup;
		wp_reset_query();
	}
  }

  function update($new_instance, $old_instance) {
    return $new_instance;
  }

  function form($instance) {
  ?>
    <p>
      <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title (optional):', 'bodyrock'); ?></label>
      <input type="text" name="<?php echo $this->get_field_name('title'); ?>" value="<?php if (isset($instance['title'])) { echo esc_attr($instance['title']); } ?>" class="widefat" id="<?php if (isset($instance['title'])) { echo $this->get_field_id('title'); } ?>" />
    </p>
    <p>
      <label for="<?php echo $this->get_field_id('thumbnail'); ?>"><?php _e('Thumbnail :', 'bodyrock'); ?></label>
      <input type="text" name="<?php echo $this->get_field_name('thumbnail'); ?>" value="<?php if (isset($instance['thumbnail'])) { echo esc_attr($instance['thumbnail']); } ?>" class="widefat" id="<?php if (isset($instance['thumbnail'])) { echo $this->get_field_id('thumbnail'); } ?>" />
    </p>
  <?php
  }
}

register_widget('bodyrock_relatedposts');

?>