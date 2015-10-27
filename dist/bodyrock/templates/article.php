<?php
// TOFIX: Ici il faut créer un include spécifique à cette template article
// qui est utilisée pour afficher plusieurs articles sur une même page
//require( ABSPATH.'/wp-content/themes/rock-gilleshoarau/includes/wp_single.php');
?>
<article itemscope="" itemtype="https://schema.org/CreativeWork">
  <header class="artHeader">
    <div class="br_artheader">
      <div class="head cat-default">
        <h1 itemprop="name"><a href="<?php the_permalink() ?>"><?php echo get_the_title() ?> <small><?php print $cats ?></small></a></h1>
      </div>
      <?php
      if ( get_post_format() == 'image' ) {
        ?>
        <div class="format-image">
          <a href="<?php the_permalink() ?>"><?php the_post_thumbnail('twitter',array('class'=>'img-responsive', 'alt'=>get_the_title())) ?></a>
        </div>
        <?php
      }
      ?>
    </div>
  </header>

  <aside class="artAside">
    <div class="br_artaside">
      <p>
        <a href="<?php print get_author_posts_url(get_the_author_meta('ID')) ?>"><small>Par <?php print get_the_author() ?></small></a>
        <small class="date"><?php echo get_the_date(); ?></small>
      </p>
    </div>
  </aside>

  <?php
  if(has_post_thumbnail()) {
    ?>
    <div class="introduction hide">
      <div class="galaxie">
        <span class="fullcolumnimg" fullcolumnimg data-height="<?php echo $thumb_src[2] ?>">
          <img itemprop="image" src="<?php echo $thumb_src[0] ?>" alt="<?php echo get_the_title() ?>" class="img-responsive"  />
        </span>
      </div>
    </div>
    <?php
  }
  ?>

  <section class="artContent">
    <div class="br_artcontent">
      <?php the_content(false); ?>
    </div>
  </section>

  <footer class="artFooter">
    <div class="br_artfooter">
      <a href="<?php the_permalink() ?>" class="readmore">Lire la suite <small><span class="icon icon-chevron-right"></span></small></a>
    </div>
  </footer>
</article>
