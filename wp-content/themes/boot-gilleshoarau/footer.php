	
	
<!-- Footer
      ================================================== -->
	  <div class="container">
	  	<?php // primary widget area
		if ( is_active_sidebar( 'sidebar-footer' ) && !is_tag() ) : ?>
	  	<div class="footer-tag-cloud">
			<div id="undercontent">
				<?php dynamic_sidebar( 'sidebar-footer' ); ?>
				<hr class="clear">
			</div>
		</div>
		<?php endif; // end primary widget area ?>
      <footer class="row">
	  <div class="span3">
	  <img src="/senzu/gilleshoarau/signature.png">
	  </div>
	  <div class="span5">
		<ul class="socialicons">
			<li><a rel="nofollow" href="https://www.facebook.com/pages/Gilles-Hoarau/277294672340104"><span class="icone facebook"></span></a></li>
			<li><a rel="nofollow" href="https://twitter.com/#!/unicolored"><span class="icone twitter"></span></a></li>
			<li><a rel="nofollow" href="http://unicolored.deviantart.com/gallery/"><span class="icone deviantart"></span></a></li>
			<li><a rel="nofollow" href="http://www.flickr.com/photos/unicomonde/"><span class="icone flickr"></span></a></li>
			<li><a rel="nofollow" href="http://www.youtube.com/user/unicolored"><span class="icone youtube"></span></a></li>
		</ul>
		</div>
		<div class="span4">
    		<a class="copyright" href="http://gilleshoarau.com/"><span>© Gilles Hoarau</span></a>
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
