<?php
get_header();
?>
<div class="container">
<div class="row">
	<?php get_sidebar('left'); ?>
	<div class="span8">
		<h1><?php _e( 'Not Found', 'bodyrock' ); ?></h1>
		<p><?php _e( 'Apologies, but the page you requested could not be found. Perhaps searching will help.', 'bodyrock' ); ?></p>
		<?php get_search_form(); ?>
		
		<script type="text/javascript">
			// focus on search field after it has loaded
			document.getElementById('s') && document.getElementById('s').focus();
		</script>
		</div>	
</div>				
</div>
<?php
get_footer();
?>