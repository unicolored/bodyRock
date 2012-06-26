<?php

class bodyrock_pagination extends WP_Widget {

  function bodyrock_pagination() {
    $widget_ops = array('description' => 'Display nice navigation pagination');
    parent::WP_Widget(false, __('Bodyrock: Pagination', 'bodyrock'), $widget_ops);
  }

  function widget($args, $instance) {
    extract($args);
    extract($instance);
	echo '<div class="pagination">';
    echo $before_widget;
    if ($title) {
      echo $before_title, $title, $after_title;
    }
	
  	global $wp_query;
						
	$big = 999999999; // need an unlikely integer
	
	$nav = paginate_links( array(
	'base' => str_replace( $big, '%#%', get_pagenum_link( $big ) ),
	'format' => '?paged=%#%',
	'current' => max( 1, get_query_var('paged') ),
	'total' => $wp_query->max_num_pages,
	'type' => 'list'
	) );
	$nav = str_replace('<li><span ','<li class="active"><a href="#"><span ',$nav);
	$nav = str_replace('/span>','/span></a>',$nav);
	
	echo $nav;
	 echo $after_widget;
	 echo '</div>';
  }

  function update($new_instance, $old_instance) {
    return $new_instance;
  }

  function form($instance) {
  ?>
  	Pas d'options pour le moment.
    <!--<p>
      <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title (optional):', 'bodyrock'); ?></label>
      <input type="text" name="<?php echo $this->get_field_name('title'); ?>" value="<?php if (isset($instance['title'])) { echo esc_attr($instance['title']); } ?>" class="widefat" id="<?php if (isset($instance['title'])) { echo $this->get_field_id('title'); } ?>" />
    </p>-->
  <?php
  }
}

register_widget('bodyrock_pagination');

?>