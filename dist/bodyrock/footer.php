</div>
</main>
<hr class="clearfix">
<footer id="Footer">
  <div class="br_footer">
    <?php get_template_part( 'templates/widget', 'footer' );  ?>
    <hr>
    <ul class="list-inline">
      <li><span class="date">&copy;<?php print date("Y") ?></span> <span class="bloginf_title"><strong><?php bloginfo('title') ?></strong> Tous droits réservés.</span></li>
      <?php
      wp_nav_menu(array('container'=>false,'items_wrap' => '%3$s','theme_location'=>'footer','fallback_cb'=>false));
      ?>
      <li class="pull-right"><a href="/?lang=en">Anglais</a> | <a href="/?lang=fr">Français</a></li>
    </ul>
  </div>
</footer>
</div>
<?php
wp_footer();
?>
</body>
</html>
