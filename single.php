<?php
// Ajouter des scripts supplémentaires ci-dessous
if (get_post_format()=='video') {
	// Spécifique aux formats video
	global $urlfinale, $videoType, $videoCode;
	
	$videoCode = get_post_meta(get_the_ID(), 'videoCode', true);
	$videoType = get_post_meta(get_the_ID(), 'videoType', true);
	
	$urlfinale = CDN_PATH.'images/videos/'.$videoType.'/'.$videoCode.br_getImgVideoSize('thumbnail').'.jpg';
}

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
    
    <section class="article">
          <div class="container">
                <?php
                  if (have_posts()) :
            
                        while (have_posts()) :
            
                              the_post();
                              setPostViews(get_the_ID());
                              get_template_part(TPL_SINGULAR_PATH . 'single', get_post_format());
            
                        endwhile;
                  else :
            
                        echo '
            		<p>
            			' . __('Sorry, no posts matched your criteria.') . '
            		</p>';
            
                  endif;
                  ?>
            </div>
    </section>
    
    <aside>
          <div class="container">
                  <?php
                  get_template_part(TPL_SIDEBAR_PATH.'sidebar','left');
                  get_template_part(TPL_SIDEBAR_PATH.'sidebar','right');
                  ?>
            </div>
      </aside>
    </aside>


<?php // Placer le code Html ci-dessus ?>
</section>
<?php get_footer();?>