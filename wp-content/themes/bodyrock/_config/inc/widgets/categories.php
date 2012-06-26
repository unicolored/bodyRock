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
    if ($title) {
      echo $before_title, $title, $after_title;
    }
	wp_list_categories('include='.$categories.'&orderby=name&use_desc_for_title=0&title_li=&hide_empty=0');
    echo $after_widget;
  }

  function update($new_instance, $old_instance) {
    return $new_instance;
  }

  function form($instance) {
  ?>
    <p>
      <label for="<?php echo $this->get_field_id('categories'); ?>"><?php _e('Catégories (ex: 1,12,20):', 'bodyrock'); ?></label>
      <input type="text" name="<?php echo $this->get_field_name('categories'); ?>" value="<?php if (isset($instance['categories'])) { echo esc_attr($instance['categories']); } ?>" class="widefat" id="<?php if (isset($instance['categories'])) { echo $this->get_field_id('categories'); } ?>" />
    </p>
  <?php
  }
}

register_widget('bodyrock_categories');

?>