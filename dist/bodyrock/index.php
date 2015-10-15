<?php get_header(); ?>

<header class="header">
  <div class="jumbotron">
    <h1><?php bloginfo('title') ?></h1>
    <h2><?php bloginfo('description') ?></h2>
  </div>
</header>

<section class="section">
  <?php /* The Loop */
  if ( have_posts() ) {
    while ( have_posts() ) {
      the_post();
      get_template_part( 'templates/article');
    }
  } else {
    get_template_part( 'templates/_nocontent');
  }
  ?>
</section>

<aside class="aside">
  <?php dynamic_sidebar('sidebar-left'); ?>
</aside>


<?php get_footer();?>
