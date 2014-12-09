<?php

class br_googleplus_addtocircles extends WP_Widget {

  function br_googleplus_addtocircles() {
    $widget_ops = array('description' => 'Google+ Add to circles Button');
    parent::WP_Widget(false, __('BR: Google+ Add Button', 'bodyrock'), $widget_ops);
  }

  function widget($args, $instance) {
    extract($args);
    extract($instance);
    echo $before_widget;
    if ($title) {
      echo $before_title, $title, $after_title;
    }
  ?>
    <!-- Place this tag in your head or just before your close body tag. -->
    <script type="text/javascript" src="https://apis.google.com/js/plusone.js">
    {lang: 'fr'}
    </script>
    
    <!-- Place this tag where you want the badge to render. -->
    <div class="g-plus" data-width="180" data-height="69" data-href="//plus.google.com/115465751132951623841" data-rel="author"></div>
    <?php
      echo $after_widget;
  }

  function update($new_instance, $old_instance) {
    return $new_instance;
  }

  function form($instance) {
  ?>
    <p>Pas de paramètres (pour le moment).</p>
  <?php
  }
}

register_widget('br_googleplus_addtocircles');

?>