<?php

class br_facebook_streamnfaces extends WP_Widget {

  function br_facebook_streamnfaces() {
    $widget_ops = array('description' => 'Facebook Stream&Faces');
    parent::WP_Widget(false, __('BR: Facebook Stream&Faces', 'bodyrock'), $widget_ops);
  }

  function widget($args, $instance) {
    extract($args);
    extract($instance);
    echo $before_widget;
    if ($title) {
      echo $before_title, $title, $after_title;
    }
    
    //Incluez le SDK JavaScript sur votre page, de préférence juste après la balise <body>
  ?>
    <div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/fr_FR/all.js#xfbml=1&appId=22832806554";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<div class="fb-like-box" data-href="http://www.facebook.com/GillesWonder" data-width="285" data-height="490" data-show-faces="true" data-stream="true" data-header="false"></div>

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

register_widget('br_facebook_streamnfaces');

?>