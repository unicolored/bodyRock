<?php
// TOFIX: Ici il faut créer un include spécifique à cette template article
// qui est utilisée pour afficher plusieurs articles sur une même page
//require( ABSPATH.'/wp-content/themes/rock-gilleshoarau/includes/wp_single.php');
?>
<article itemscope="" itemtype="https://schema.org/CreativeWork">
  <header class="artHeader">
    <div class="wrap_artHeader">
      <div class="head cat-default">
        <h1 itemprop="name"><a href="<?php the_permalink() ?>"><?php echo get_the_title() ?> <small><?php print $cats ?></small></a></h1>
      </div>
    </div>
  </header>

  <?php
  if(has_post_thumbnail()) {
    ?>
    <div class="thumbnail">
      <?php the_post_thumbnail(); ?>
      <div class="caption">

      </div>
    </div>
    <?php
  }
  ?>

  <section class="artSection">
    <div class="wrap_artSection">
      <?php the_content(false); ?>
    </div>
  </section>

  <footer class="artFooter">
    <div class="wrap_artFooter">
      <p>
        <a href="<?php print get_author_posts_url(get_the_author_meta('ID')) ?>"><small>Par <?php print get_the_author() ?></small></a>
        <small class="date"><?php echo get_the_date(); ?></small>
      </p>
    </div>
  </footer>
</article>
