<div class="span4">
	<?php // primary widget area
	if ( is_active_sidebar( 'sidebar-left' ) ) : ?>
	<article class="sidebar">
			<?php dynamic_sidebar( 'sidebar-left' ); ?>
	</article>
	<?php endif; // end primary widget area ?>
</div>