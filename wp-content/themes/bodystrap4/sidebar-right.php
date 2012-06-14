	<?php // primary widget area
	if ( is_active_sidebar( 'main-right' ) ) : ?>
	<article class="sidebar">
			<?php dynamic_sidebar( 'main-right' ); ?>
	</article>
	<?php endif; // end primary widget area ?>