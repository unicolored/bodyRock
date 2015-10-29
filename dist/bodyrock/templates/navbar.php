<nav id="navbartop" class="navbar navbar-default <?php print BR_NAVBARTOPFIXED ?>" role="navigation">
  <div class="<?php print BR_CONTAINER ?>">

    <div class="navbar-header">
      <button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target="#navbar-collapse-top">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>

      <a class="navbar-brand" href="/"><?php bloginfo('title') ?></a>
      <p class="navbar-text" href="/"><?php bloginfo('description') ?></span></p>
    </div>

    <div class="collapse navbar-collapse" id="navbar-collapse-top">
      <div class="container-fluid">
        <ul class="nav navbar-nav navbar-right">
          <?php
          wp_nav_menu(array('container'=>false,'items_wrap' => '%3$s','theme_location'=>'primary'));
          ?>
          <li>&nbsp;</li>
        </ul>
      </div>
    </div>
  </div>
</nav>
