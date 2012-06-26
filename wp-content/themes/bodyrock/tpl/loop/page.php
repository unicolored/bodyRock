<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
<div class="container-fluid designed">
	<div class="container">
		<div class="row">
			<div id="contentsingle" class="span8">
				<div class="wrapped">
					<article id="post-<?php the_ID(); ?>" <?php post_class('single'); ?>>
						<header>
							<h1><?php the_title(); ?></h1>
						</header>
						<section>
							<?php the_content(); ?>
							<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'bodyrock' ), 'after' => '</div>' ) ); ?>
							<?php edit_post_link( __( 'Edit', 'bodyrock' ), '<span class="edit-link">', '</span>' ); ?>
						</section>
						<footer>
							<div class="entry-utility">
								<div class="entry-meta">
									<?php bodyrock_posted_on(); ?>
								</div><!-- .entry-meta -->	
							</div><!-- .entry-utility -->
						</footer>
						<?php comments_template( '', true ); ?>
					</article>	
				</div>
			</div>
			<div class="span4">
				<div class="sidebar sidebar-right">
					<?php get_sidebar(); ?>
				</div>
			</div>
		</div>		
	</div>
</div>
<?php endwhile; // end of the loop. ?>