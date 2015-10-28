<?php get_header(); ?>

<?php /* The Loop */
if ( have_posts() ) {
  while ( have_posts() ) {
    the_post();
    if (is_singular()) {
      if (is_single('post')) {
        get_template_part( 'templates/article','post');
        comments_template();
      }
      else {
        get_template_part( 'templates/article','page');
      }
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
