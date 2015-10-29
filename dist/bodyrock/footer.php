    </div>
  </main>
  <hr class="clearfix">
  <footer id="Footer">
    <div class="br_footer">
      <hr>A
      <?php get_template_part( 'widget', 'footer' );  ?>
      A
      <hr>
      <ul class="list-inline">
        <?php
        wp_nav_menu(array('container'=>false,'items_wrap' => '%3$s','theme_location'=>'footer','fallback_cb'=>false));
        ?>
      </ul>
      <p class="bottomline"><small><strong><?php bloginfo('title') ?></strong> &nbsp; <?php bloginfo('description') ?></small></p>
    </div>
  </footer>
</div>
  <?php
  wp_footer();
  ?>
  </body>
</html>
