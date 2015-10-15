<?php
$current = array(
  'frontpage'=>false,
  'services'=>false,
  'portfolio'=>false,
  'blog'=>false,
  'apropos'=>false,
  'contact'=>false
);
$bodyClass = getBodyClass();
$name=false;
$name = "";
if(!is_front_page()){
  $name = " Gilles Hoarau";
}
if(is_front_page()){
  $current['frontpage']='active';
}
elseif($bodyClass['parent'] == 'portfolio') {
  $current['portfolio']='active';
}
elseif(is_home() || $bodyClass['parent'] == 'blog') {
  $current['blog']='active';
}
elseif(is_page('a-propos') || is_page('cv') || is_page('bio')) {
  $current['apropos']='active';
}
elseif(is_page('contact')) {
  $current['contact']='active';
}
?>

<nav id="navbartop" class="navbar navbar-default" role="navigation">
  <div class="br_container">
    <div class="br_wrapper">

      <div class="navbar-header">
        <button class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse-top">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>

        <a class="navbar-brand" href="/"><span class="icon icon-gh"></span><span class="name"><?php print $name ?></span></a>
        <p class="navbar-text hide" href="/">Créatif très averti</span></p>
      </div>

      <div class="collapse navbar-collapse" id="navbar-collapse-top">
        <ul id="menu-top-pro" class="nav navbar-nav navbar-right">
          <li id="menu-item-1234" class="hide menu-item menu-item-1234 <?php print $current['services'] ?>"><a data-instant data-body="class-services-communication-web" title="Services" href="http://www.gilleshoarau.com/services-communication-web/">Services</a></li>
          <li id="menu-item-3333" class="menu-item menu-item-3333 <?php print $current['blog'] ?>"><a data-instant data-body="class-blog" title="Blog" href="http://www.gilleshoarau.com/blog-web-design/">Blog</a></li>
          <li id="menu-item-8888" class="hide menu-item menu-item-8888 <?php print $current['references'] ?>"><a data-instant data-body="class-references" title="Références" href="http://www.gilleshoarau.com/communication/references/">Références</a></li>
          <li id="menu-item-8888" class="menu-item menu-item-8888 <?php print $current['portfolio'] ?>"><a data-instant data-body="class-portfolio" title="Portfolio" href="http://www.gilleshoarau.com/communication/portfolio/">Portfolio</a></li>
          <li id="menu-item-1337" class="hide menu-item menu-item-1337 <?php print $current['apropos'] ?>"><a data-instant data-body="class-a-propos" title="A propos" href="http://www.gilleshoarau.com/a-propos/">A propos</a></li>
          <li id="menu-item-3210" class="menu-item menu-item-3210 <?php print $current['contact'] ?>"><a data-instant data-body="class-contact" title="Contact" href="http://www.gilleshoarau.com/contact/">Contact</a></li>
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
  </div>
</nav>
