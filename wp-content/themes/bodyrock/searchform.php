<form class="navbar-form navbar-left" role="search" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<div class="hidden-xs">
		<div class="form-group">
			<input type="text" class="form-control input-sm" name="s" id="s" placeholder="<?php esc_attr_e( 'Search', 'bodyrock' ); ?>" value="<?php if(isset($_GET['s'])) echo $_GET['s']; ?>" />
		</div>
		<button type="submit" class="btn btn-default btn-xs"><?php br_Icon('search') ?> <?php _e('Search','bodyrock'); ?></button>
	</div>
	<div class="visible-xs">
		<div class="form-group">
			<input type="text" class="form-control" name="s" id="s" placeholder="<?php esc_attr_e( 'Search', 'bodyrock' ); ?>" value="<?php if(isset($_GET['s'])) echo $_GET['s']; ?>" />
		</div>
		<button type="submit" class="btn btn-default btn-block"><?php br_Icon('search') ?> <?php _e('Search','bodyrock'); ?></button>
	</div>
</form>