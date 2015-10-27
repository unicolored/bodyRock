<?php get_header(); ?>

<?php /* The Loop */
if ( have_posts() ) {
  while ( have_posts() ) {
    the_post();
    if (is_singular()) {
      get_template_part( 'templates/article','singular');
    }
    else {
      get_template_part( 'templates/article');
    }
  }
} else {
  get_template_part( 'templates/_nocontent');
}
?>

<?php get_footer();?>
