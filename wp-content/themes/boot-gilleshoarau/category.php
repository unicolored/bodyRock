<?php get_header(); ?>
<div class="container-fluid designed">
	<div class="row-fluid">
		<div class="span2 sidebardesigned">
			<div class="navigation3">
				<?php wp_list_categories('orderby=name&use_desc_for_title=0&title_li=&hide_empty=1'); ?>
			</div>
			<div class=""><p><?php posts_nav_link(); ?></p></div>
		</div>
		
		<?php
		$category = get_the_category(); 
		switch ($category[0]->cat_ID) {
			case 23: echo "
		<div class='span3 categoriedesc'>
			<article>
				<header><h1>Capturer l'instant</h1></header>
				<section>
					<p>La photographie me fait voir le monde d'un nouvel oeil. La nature m'inspire beaucoup, j'aime les fleurs, les insectes. J'ai exposé en 2005 au -Bougnat des pouilles- à Troyes, mes photos sur le thème -Couleurs naturelles-. J'ai plus tard été attiré par la ville et ses contours, ses lumières et son architecture.</p>
					<p>Cette façon de capturer l'instant me permet ajourd'hui d'illustrer mes créations numériques ou simplement de mémoriser un présent aussitôt révolu. Et c'est encore plus vrai quand il s'agit de prendre en photo le mouvement des passants, de la circulation. Ce sont des instantannés de vie impérissables.</p>
				</section>
			</article>
		</div>
		<div class='span7'>"; break;
				default: echo "
		<div class='span10'>"; break;
			}
			
			if ( have_posts() ) : while ( have_posts() ) : the_post(); ?> 
				<div class="span4 imagesindex">
					<article>
						<header>
							<?php get_template_part( 'content', get_post_format() ); ?>
						</header>
					</article>
					<h1 class="target"><a href="<?php echo get_permalink() ?>"><?php the_title() ?></a></h1>
				</div>
			<?php endwhile; else: ?>
				<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
			<?php endif; ?>
		</div>
	</div>
</div>
<?php get_footer();?>