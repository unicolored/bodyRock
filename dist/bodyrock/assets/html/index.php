<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="fr-FR"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="fr-FR"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="fr-FR"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="fr_FR">
<!--<![endif]-->

<head prefix="og: http://ogp.me/ns# article: http://ogp.me/ns/article# profile: http://ogp.me/ns/profile#">
  <meta charset="bloginfo("charset")" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <base href="/">

  <!-- WPHEAD START -->
  <?php require 'includes/wp_head.php' ?>
  <!-- WPHEAD END -->

</head>

<body class="body_class()">

  <div id="Bonjour" class="container-fluid">
    <div class="wrap_Bonjour">

      <header id="Header">
        <div class="wrap_Header">
          <code>header#Header &gt; .wrap_Header</code><br>
          <code>get_template_part( "templates/__Header")</code>
        </div>
      </header>

      <section id="BeforeMain" class="section">
        <div class="wrap_BeforeMain_section">
          <code>section#BeforeMain.section &gt; .wrap_BeforeMain_section</code><br>
          <code>get_template_part( "templates/_BeforeMain")</code>
        </div>
      </section>
      <hr class="clear">

      <main id="Main">
        <div class="wrap_Main">
          <code>main#Main &gt; .wrap_Main</code><br>
          <!-- HEADER END -->

          <!-- Insert -->
          <code>// Insertion de la page</code><br>

          <!-- FOOTER START -->


          <footer id="mainFooter">
            <div class="br_footer">
              <code>footer#mainFooter &gt; .br_footer</code><br>
              <code>get_template_part( 'templates/__Main','Footer')</code>
            </div>
          </footer>

        </div><!-- /.wrap_Main -->
      </main><!-- /Main -->

      <aside id="Aside">
        <div class="wrap_aside">
          <code>aside#Aside &gt; .wrap_aside</code><br>
          <code>get_template_part( 'templates/__Aside')</code>
        </div>
      </aside>

      <footer id="Footer">
        <div class="br_footer">
          <code>footer#Footer &gt; .br_footer</code><br>
          <code>get_template_part( 'templates/__Footer')</code>
        </div>
      </footer>

    </div><!-- /.wrap_Bonjour -->
  </div><!-- /Bonjour -->



  <!-- WPFOOTER START -->
  <?php require 'includes/wp_footer.php' ?>
  <!-- WPFOOTER END -->

  <script type="text/javascript">
  /* <![CDATA[ */
  var generated =
  '<?php echo (substr((microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"]),0,4)*1000) ?>';
  //exported version
  var version = function() {
    'use strict';
    return '<?php echo wp_get_theme()->Version ?>';

  };
  jQuery('.generated').text(generated+'ms');
  jQuery('.version').text(version());
  /* ]]> */
  </script>

</body>
</html>
