<div class="galaxie">
<nav class="navbar navbar-default" role="navigation">
	<!-- Brand and toggle get grouped for better mobile display -->
	<div class="navbar-header">
		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
		<a class="navbar-brand" href="<?php echo bloginfo('url') ?>"><?php echo bloginfo('name') ?></a>
	</div>
	
	<!-- Collect the nav links, forms, and other content for toggling -->
	<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		<?php 
		echo a('div.navbar-left.visible-xs');
		wp_nav_menu( array(
			'menu'       => 'primary',
			'theme_location' => 'primary',
			'depth'      => 2,
			'container'  => false,
			'menu_class' => 'nav navbar-nav',
			'fallback_cb' => 'br_menu_default',
			'walker' => new wp_bootstrap_navwalker())
		);
		echo z('/div');
		?>
		<?php if(!is_search() && !is_404()) { ?>
			<?php get_search_form(); ?>
		<?php } ?>
	</div><!-- /.navbar-collapse -->
</nav>
</div>