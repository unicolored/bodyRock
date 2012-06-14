<?php the_post(); ?>
<div class="container-fluid" style="background:#000;">
	<div class="container" style="background:#fff;">
		<div class="row">
			<div class="span12">
				<article id="post-<?php the_ID(); ?>" <?php post_class('single'); ?>>	
					<header>								
						<h1 class="entry-title"><?php the_title(); ?></h1>								
					</header>
					<div id="contentsingle">		
						<section>
							<?php the_content(); ?>
							<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'bodyrock' ), 'after' => '</div>' ) ); ?>
						</section>
					</div>
				</article>	
			</div>
		</div>				
	</div>
</div>