    </div>
  </main>

  <footer id="Footer">
    <div class="br_footer">
      <hr>
      <ul class="list-inline">
        <?php
        wp_nav_menu(array('container'=>false,'items_wrap' => '%3$s','theme_location'=>'footer','fallback_cb'=>false));
        ?>
      </ul>
      <p class="text-uppercase"><small><strong><?php bloginfo('title') ?></strong> &nbsp; <?php bloginfo('description') ?></small></p>
    </div>
  </footer>
</div>
  <?php
  wp_footer();
  ?>
  </body>
</html>
