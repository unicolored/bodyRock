<div class="span4">
	<?php // primary widget area
	if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
	<article class="sidebar">
			<?php dynamic_sidebar( 'sidebar-1' ); ?>
	</article>
	<?php endif; // end primary widget area ?>
</div>