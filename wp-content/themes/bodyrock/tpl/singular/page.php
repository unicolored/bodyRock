
    <article id="post-<?php the_ID(); ?>" <?php post_class('single'); ?>>
    
        <header>
            <?php get_template_part('tpl/parts/page', 'header') ?>
        </header>
        
        <div class="caption">
          	<p class="text-center"><?php the_post_thumbnail('large'); ?></p>
            <?php // get_template_part('tpl/parts/article', 'share') ?>
            <hr class="margin">
            <?php
            the_content(false,1);
            ?> 
        </div>
        
    </article>