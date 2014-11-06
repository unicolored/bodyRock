<nav id="navbartop" class="navbar navbar-default navbar-fixed-top" role="navigation">
      <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse">
                  <span class="sr-only">Toggle navigation</span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">
                  <span>Gilles Hoarau</span>
            </a>
      </div>
    
      <div class="collapse navbar-collapse" id="navbar-collapse">
            <?php
            wp_nav_menu( array(
            'theme_location' => 'primary',
            'container'  => false,
            'menu_class' => 'nav navbar-nav',
            'depth'=>2,
            'fallback_cb'=>'default_menu',
            'walker'=>new wp_bootstrap_navwalker()
            ));
            
             ?>
      </div>
</nav>

