<?php
  $defaults_pro = array(
    'theme_location'  => 'topmenu',
    'container'       => false,
    'items_wrap'      => '%3$s',
    'walker'          => new wp_bootstrap_navwalker()
  );
  ?>

  <div id="brand">
    <h1><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo('name') ?></a></h1>
    <h2><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo('description') ?></a> <a href="https://twitter.com/gilleshoarau" target="_blank"><span class="icon icon-star-full rotation"></span></span></a></h2>
  </div>
  <div class="container">
    <nav class="cool">
      <ul>
        <?php
        wp_nav_menu($defaults_pro);
        ?>
        <li>
          <form role="search" action="<?php echo esc_url( home_url( '/' )); ?>" id="searchform" class="formsearch" method="get">
            <label for="s">
              <i class="icon-search"></i>
            </label>
            <input type="text" name="s" id="s" placeholder="<?php esc_attr_e( 'Rechercher', 'rock-gilleshoarau' ); ?>" value="<?php if(isset($_GET['s'])) echo sanitize_text_field($_GET['s']); ?>" />
          </form>
        </li>
      </ul>
    </nav>
  </div>
