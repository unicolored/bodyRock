<?php get_header(); ?>
<section class="br_bonjour index">
  <?php // Placer le code Html ci-dessous ?>

  <section class="br_head">
    <div class="container">
      <div class="jumbotron">
        <h1><?php bloginfo('description') ?></h1>
      </div>
    </div>
  </section>

  <div class="container">
    <aside class="br_sidebarLeft">
      <?php dynamic_sidebar('sidebar-left'); ?>
    </aside>

    <section class="br_content">
      <?php /* The Loop */
      if ( have_posts() ) {
        while ( have_posts() ) {
          the_post();
          get_template_part( 'tpl/article', 'thumbnail');
        }
      } else { ?>
      <div class="alert alert-warning alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
        </button>
        <strong><?php br_Icon('warning'); ?> Aucun article trouvé</strong> Placez des articles dans la catégorie "featured" pour qu'ils apparaissent ici.
      </div>
      <?php } ?>
    </section>
  </div>

  <?php // Placer le code Html ci-dessus ?>
</section>
<?php get_footer();?>
