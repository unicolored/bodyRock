<?php

class br_twitter_fluxprofile extends WP_Widget {

  function br_twitter_fluxprofile() {
    $widget_ops = array('description' => 'Twitter flux du profil');
    parent::WP_Widget(false, __('BR: Twitter Profil', 'bodyrock'), $widget_ops);
  }

  function widget($args, $instance) {
    extract($args);
    extract($instance);
    echo $before_widget;
    if ($title) {
      echo $before_title, $title, $after_title;
    }
  ?>
    <a class="twitter-timeline"  href="https://twitter.com/unicolored"  data-widget-id="248113282966228992">Tweets de @unicolored</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>

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

register_widget('br_twitter_fluxprofile');

?>