<?php

class bodyrock_carousel extends WP_Widget {

  function bodyrock_carousel() {
    $widget_ops = array('description' => 'Display a carousel of thumbnail of selected posts');
    parent::WP_Widget(false, __('Bodyrock: Carousel', 'bodyrock'), $widget_ops);
  }

  function widget($args, $instance) {
    extract($args);
    extract($instance);
    echo $before_widget;
    if ($title) {
      echo $before_title, $title, $after_title;
    }
	?>
	<div id="myCarousel" class="carousel slide">
		<div class="carousel-inner">
			<?php
			global $post;
					// if(get_post_format()!='video') :
					$thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'large' );
					global $blog_id;
					$url = theImgSrc($blog_id, $thumb['0']);
					if($url!=NULL) {
						?>
						<div class='item'>
							<a href='<?php echo the_permalink() ?>' title='<?php the_title(); ?>'>
								<b class="img" style="height:570px; width:850px; display:block;
								background:url(<?php echo $url?>) center center no-repeat;"></b>
							</a>
							<span class="wp">Content--carousel</span>
						</div>									
						<?php
					}
			//wp_reset_query();
			?>
		</div>
	</div>
	<?php
    echo $after_widget;
  }

  function update($new_instance, $old_instance) {
    return $new_instance;
  }

  function form($instance) {
  ?>
    <p>
      <label for="<?php echo $this->get_field_id('posts'); ?>"><?php _e('Posts (ex: 1,12,20):', 'bodyrock'); ?></label>
      <input type="text" name="<?php echo $this->get_field_name('posts'); ?>" value="<?php if (isset($instance['posts'])) { echo esc_attr($instance['posts']); } ?>" class="widefat" id="<?php if (isset($instance['posts'])) { echo $this->get_field_id('posts'); } ?>" />
    </p>
  <?php
  }
}

register_widget('bodyrock_carousel');

?>