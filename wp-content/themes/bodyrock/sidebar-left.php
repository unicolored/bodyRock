<div class="span4">
	<?php // primary widget area
	if ( is_active_sidebar( 'main-left' ) ) : ?>
	<article class="sidebar">
			<?php dynamic_sidebar( 'main-left' ); ?>
	</article>
	<?php endif; // end primary widget area ?>
</div>