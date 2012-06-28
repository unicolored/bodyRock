	<div class="container">
		<div class="row">
			<footer class="br_footer">
				<div class="navbar">
					<div class="navbar-inner">
						<div class="container">						
							<div class="nav-collapse">							
								<?php wp_nav_menu( array( 'theme_location' => 'footer', 'walker' => new mainnav_walker() ) ); ?>
							</div>						
						</div>
					</div>
				</div>
			</footer>
		</div>	
	</div>
	
<?php wp_footer(); ?>

<?php bodyrock_javascripts_footer(); ?>
<?php bodyrock_analytics(); ?>

</body>
</html>