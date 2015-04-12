<section class="br_footer">
  <!-- Placer le code Html ci-dessous -->
  <?php get_template_part('tpl/bs_navbar','bottom'); ?>

  <?php if( !is_page('contact') ) { ?>
    <section class="citation paddit">
      <?php get_template_part('tpl/footer_section','contact'); ?>
    </section>
    <?php } ?>

    <!-- Placer le code Html ci-dessus -->
  </section>

  <section class="br_widgets">
    <div class="container">
      <hr>
      <div class="widget1 col-xs-4">
        <?php dynamic_sidebar('sidebar-left'); ?>
      </div>
      <div class="widget2 col-xs-4">
        <?php dynamic_sidebar('sidebar-middle'); ?>
      </div>
      <div class="widget3 col-xs-4">
        <?php dynamic_sidebar('sidebar-right'); ?>
      </div>
    </div>
  </section>

  <?php wp_footer(); ?>

  <?php
  if ( BR_GOOGLE_ANALYTICS != false ) {
    ?>
    <script type="text/javascript">
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
    ga('create', <?php echo BR_GOOGLE_ANALYTICS ?>, 'auto');
    ga('send', 'pageview');
    </script>
    <?php
  }
  ?>
</body>
</html>
