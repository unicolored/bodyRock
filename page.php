<?php
// Ajouter des scripts supplémentaires ci-dessous
// ...

// HEADER
get_header();

the_post();
?>
<section class="br_bonjour page">
<?php // Placer le code Html ci-dessous ?>


    <section>
        <div class="container">
              <h1><?php the_title() ?></h1>
              <?php echo the_content(); ?>
        </div>
    </section>


<?php // Placer le code Html ci-dessus ?>
</section>
<?php get_footer();?>