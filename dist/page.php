<?php
// Ajouter des scripts supplémentaires ci-dessous
// ...

// HEADER
get_header();

the_post();
?>
<section class="br_bonjour page">
<?php // Placer le code Html ci-dessous ?>


    <section class="paddit-top">
        <div class="container">
            <blockquote>
              <h1><?php the_title() ?></h1>
            </blockquote>
              <?php echo the_content(); ?>

        </div>
    </section>


<?php // Placer le code Html ci-dessus ?>
</section>
<?php get_footer();?>
