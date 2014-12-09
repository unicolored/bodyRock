<?php
// Ajouter des scripts supplémentaires ci-dessous
//...

// HEADER *********************************************************
get_header(); ?>
<section class="br_bonjour category">
<?php // Placer le code Html ci-dessous ?>
    
    
    <section class="intro">
        <div class="conteneur">
            <blockquote>
                <h1><small>Catégorie</small> <em><?php br_Icon('folder') ?> <?php echo ucfirst(get_cat_name( get_query_var('cat') )) ?></em></h1>
            </blockquote>
        </div>
    </section>
    
    <section class="portfolio cadre-inverse">
        <div class="container">    
            <?php   
            // The Loop
            $id_current = get_the_ID();
            if ( have_posts() ) {
                while ( have_posts() ) {
                    the_post();
                    $thumb = wp_get_attachment_image_src( get_post_thumbnail_id(), 'vignette');
                    $thumb_large = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large');
                    
                    $args = array(
                        'post_type' => 'attachment',
                        'numberposts' => -1,
                        'post_status' => null,
                        'post_parent' => get_the_ID(),
                        'orderby'         => 'menu_order',
                        'order'           => 'ASC',
                        'exclude' => get_post_thumbnail_id()
                    );
                    $attachments = get_posts( $args );
                    $image_src2=wp_get_attachment_image_src( $attachments[0]->ID, 'large' );
                    
                    /************************************************************************/
                    // Chargement du template
                    get_template_part('tpl/article','thumbnail');
                }
            } else {
            // no posts found
            }
            ?>
        </div>
    </section>
    
    
<?php // Placer le code Html ci-dessus ?>
</section>
<?php get_footer();?>