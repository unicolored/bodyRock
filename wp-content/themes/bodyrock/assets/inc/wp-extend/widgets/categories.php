<?php

class bodyrock_categories extends WP_Widget {

  function bodyrock_categories() {
    $widget_ops = array('description' => 'Display selected categories');
    parent::WP_Widget(false, __('Bodyrock: Categories', 'bodyrock'), $widget_ops);
  }

  function widget($args, $instance) {
    extract($args);
    extract($instance);
	
	echo $before_widget;
	echo isset($title) ? $before_title.$title.$after_title : false;
	//	wp_list_categories('include='.$categories.'&orderby=name&use_desc_for_title=0&title_li=&hide_empty=0');
		$args = array(
		'type'                     => 'post',
		'child_of'                 => 0,
		'parent'                   => $parent,
		'orderby'                  => 'category_count',
		'order'                    => 'ASC',
		'hide_empty'               => 0,
		'hierarchical'             => 1,
		'exclude'                  => '',
		'include'                  => '',
		'number'                   => '',
		'taxonomy'                 => 'category',
		'pad_counts'               => false 
	
	); 

	$categories = get_categories( $args );

    ?>
    <div class="list-group">
		<?php
		foreach ($categories as $C) {
			?>
			<a href="<?php echo get_category_link( $C->term_id ) ?>" class="list-group-item <?php echo $C->term_id == get_query_var('cat') ? 'active' : false; ?>"><span class="badge"><?php echo $C->category_count; ?></span> <?php echo $C->name; ?></a>
		<?php } ?>
	</div>
    <?php
    echo $after_widget;
  }

	function update($new_instance, $old_instance) {
		return $new_instance;
	}

  function form($instance) {
		echo '<p><label for="'.$this->get_field_id('title').'">'.__("Titre (optionnel):", 'bodyrock').'</label>';
		echo '<input name="'.$this->get_field_name('title').'" value="'.$instance['title'].'" type="text" class="widefat" id="'.$this->get_field_id('title').'" /></p>';
	  
  ?>
    <p>
      <label for="<?php echo $this->get_field_id('categories'); ?>"><?php _e('Catégories (ex: 1,12,20):', 'bodyrock'); ?></label>
      <input type="text" name="<?php echo $this->get_field_name('categories'); ?>" value="<?php if (isset($instance['categories'])) { echo esc_attr($instance['categories']); } ?>" class="widefat" id="<?php if (isset($instance['categories'])) { echo $this->get_field_id('categories'); } ?>" />
      <label for="<?php echo $this->get_field_id('parent'); ?>"><?php _e('Parent (ex: 12):', 'bodyrock'); ?></label>
      <input type="text" name="<?php echo $this->get_field_name('parent'); ?>" value="<?php if (isset($instance['parent'])) { echo esc_attr($instance['parent']); } ?>" class="widefat" id="<?php if (isset($instance['parent'])) { echo $this->get_field_id('parent'); } ?>" />
    </p>
  <?php
  }
}

?>