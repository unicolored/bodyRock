	
	
<!-- Footer
      ================================================== -->
	  <div class="container">
      <footer class="footer span12">
	  	<div class="row">
        <p class="pull-right"><a href="#">Back to top</a></p>
			  </div>
		<!-- Navbar ================================================== -->
		<div class="row">
    <div class="navbar">
      <div class="navbar-inner">
        <div class="container">
          
  			<div class="nav-collapse">
			
		  	<?php wp_nav_menu( array( 'theme_location' => 'footer', 'walker' => new mainnav_walker() ) ); ?>
          </div>
		  
        </div>
      </div>
    </div>
	</div>
      </footer>

</div>

  </body>
</html>


<?php wp_footer(); ?>

<?php bodyrock_javascripts_footer(); ?>
<?php bodyrock_analytics(); ?>

</body>
</html>
