<?php
// Ajouter des scripts supplémentaires ci-dessous
// ...

// HEADER
get_header(); ?>
<section class="br_bonjour index">
<?php // Placer le code Html ci-dessous ?>


      <section class="intro">
            <div class="jumbotron">
		    <h1>Index.</h1>
		</div>
	</section>
	
      <section class="intro">
            <div class="well">
                <h1>Articles de la catégorie "featured"</h1>
            </div>
      </section>
    
    
    <section>
        <div class="container">
            <?php
            if ( get_category_by_slug('featured') != false ) {
                  $args='posts_per_page=12&post_status=publish&cat='.get_category_by_slug('featured')->term_id;
                  
                  // The Query
                  $the_query = new WP_Query( $args );
                  
                  // The Loop
                  if ( $the_query->have_posts() ) {
                      while ( $the_query->have_posts() ) {
                          $the_query->the_post();
                          get_template_part('tpl/article','thumbnail');
                      }
                  } else { ?>
                        <div class="alert alert-warning alert-dismissible" role="alert">
                          <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                          <strong>Warning!</strong> Better check yourself, you're not looking too good.
                        </div>
                        <?php    
                  }
                  /* Restore original Post Data */
                  wp_reset_postdata();
            } else { ?>
                  <div class="alert alert-warning alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <strong><?php br_Icon('warning'); ?> Aucun article trouvé</strong> Placez des articles dans la catégorie "featured" pour qu'ils apparaissent ici.
                  </div>
                  <?php    
            }
            ?>
        </div>
    </section>
    
    <section class="cadre">
        <div class="container">
            <?php // get_template_part('tpl/article','lorem'); ?>
        </div>
    </section>


<?php // Placer le code Html ci-dessus ?>
</section>
<?php get_footer();?>