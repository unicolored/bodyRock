<nav id="navbartop" class="navbar navbar-default" role="navigation">
  <div class="br_navbar">

    <div class="navbar-header">
      <button class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse-top">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>

      <a class="navbar-brand" href="/"><?php bloginfo('title') ?></a>
      <p class="navbar-text" href="/"><?php bloginfo('description') ?></span></p>
    </div>

    <div class="collapse navbar-collapse" id="navbar-collapse-top">
      <ul id="menu-top-pro" class="nav navbar-nav">
        <?php
        wp_page_menu($args['wp_page_menu']);
        ?>
      </ul>
      <ul id="menu-top-pro2" class="nav navbar-nav navbar-right hide">
        <li id="menu-item-1234" class="menu-item menu-item-1234 <?php print $current['services'] ?>"><a data-instant data-body="class-services-communication-web" title="Services" href="http://www.gilleshoarau.com/services-communication-web/">Boutique</a></li>
        <li id="menu-item-1234" class="menu-item menu-item-1234 <?php print $current['services'] ?>"><a data-instant data-body="class-services-communication-web" title="Services" href="http://www.gilleshoarau.com/services-communication-web/">Création visuelle</a></li>
        <li id="menu-item-8888" class="menu-item menu-item-8888 <?php print $current['references'] ?>"><a data-instant data-body="class-references" title="Références" href="http://www.gilleshoarau.com/communication/references/">Développement Web</a></li>
        <li id="menu-item-3333" class="menu-item menu-item-3333 <?php print $current['blog'] ?>"><a data-instant data-body="class-blog" title="Blog" href="http://www.gilleshoarau.com/studio-modelisation-3d/">Studio 3D</a></li>
        <li id="menu-item-3333" class="menu-item menu-item-3333 <?php print $current['blog'] ?>"><a data-instant data-body="class-blog" title="Blog" href="http://www.gilleshoarau.com/blog-web-design/">Assistance</a></li>
        <li id="menu-item-3210" class="menu-item menu-item-3210 <?php print $current['contact'] ?>"><a data-instant data-body="class-contact" title="Contact" href="http://www.gilleshoarau.com/contact/"><span class="icon icon-phone"></span></a></li>
      </ul>
    </div>
  </div>
</nav>
