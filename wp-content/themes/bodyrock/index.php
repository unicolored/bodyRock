<?php get_header(); ?>

<div class="container">
	<header>
		<h1>Base CSS</h1>
		<p class="lead">On top of the scaffolding, basic HTML elements are styled and enhanced with extensible classes to provide a fresh, consistent look and feel.</p>
		<div class="subnav">
			<ul class="nav nav-pills">
				<li><a href="#typography">Typography</a></li>
				<li><a href="#code">Code</a></li>
				<li><a href="#tables">Tables</a></li>
				<li><a href="#forms">Forms</a></li>
				<li><a href="#buttons">Buttons</a></li>
				<li><a href="#icons">Icons by Glyphicons</a></li>
			</ul>
		</div>
	</header>

	<div class="row">		
		<div class="span8">
			<i class="icon-search"></i> qsdqsd
			<i class="icon-star icon-white"></i>
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
		<?php get_sidebar('left'); ?>
	</div>
	
	<div class="row">
		<div class="span12">
			
			<h1>Typography <small>Headings, paragraphs, lists, and other inline type elements</small></h1>
			<p class="lead">Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor. Duis mollis, est non commodo luctus.</p>
			<p>Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor. Duis mollis, est non commodo luctus.</p>
			<div>
				<div>
					<h1>h1. Heading 1</h1>
					<h2>h2. Heading 2</h2>
					<h3>h3. Heading 3</h3>
					<h4>h4. Heading 4</h4>
					<h5>h5. Heading 5</h5>
					<h6>h6. Heading 6</h6>
				</div>
			</div>
			<p>&nbsp;</p>
		</div>
	</div>
</div>
<?php get_footer();?>