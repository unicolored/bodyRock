<?php get_header(); ?>

<div class="container">
	<div class="row">
		<?php get_sidebar('left'); ?>
		<div class="span8">
			<div style="font-size: 24px;">
			    <i class="icon-search"></i> qsdqsd
				<i class="icon-star icon-white"></i>
		    </div>
			<div class="well">
				<p>Use Font Awesome icons in:</p>
				<ul class="icons">
				  <li><i class="icon-ok"></i>Bulleted lists (like this one)</li>
				  <li><i class="icon-ok"></i>Buttons</li>
				  <li><i class="icon-ok"></i>Button groups</li>
				  <li><i class="icon-ok"></i>Navigation</li>
				  <li><i class="icon-ok"></i>Prepended form inputs</li>
				  <li><i class="icon-ok"></i>And many more with Custom CSS</li>
				</ul>
			  </div>
			<div class="navigation"><p><?php posts_nav_link(); ?></p></div>
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				<article>
					<header>
						<h1><a href="<?php echo the_permalink() ?>"><?php the_title() ?></a></h1>
						<p class="center"><?php the_post_thumbnail('small-feature'); ?></p>
					</header>
					<section>
						<?php the_excerpt() ?>
					</section>
					<footer>
					</footer>
				</article>
			<?php endwhile; else: ?>
				<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
			<?php endif; ?>
			
		</div>
		<?php get_sidebar('right'); ?>
	</div>
</div>
<?php get_footer();?>