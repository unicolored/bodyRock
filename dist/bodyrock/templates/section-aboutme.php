
<section class="aboutme">
	<div class="galaxie">
		<?php
		if ( is_front_page() ) {
			?>
			<div class="margeUp">
				<div class="media">
					<div class="media-left">
						<a href="#">
							<img class="media-object img-circle hide" src="/img/ico/Gilles_Hoarau.<?php print wp_get_theme()->get( 'Version' ) ?>.jpg" alt="Gilles Hoarau">
							<img class="media-object img-circle" src="/da/wp-content/themes/rock-gilleshoarau/img/ico/Gilles-Hoarau-120.png" alt="Gilles Hoarau" width="120" height="120">
						</a>
					</div>
					<div class="media-body">
						<h4 class="media-heading">Bienvenue, je suis Gilles !</h4>
						<p>
							J'ai le privilège d'apprendre et de travailler en freelance pour <a href="http://unicolored.com/">Unicolored</a> et avec <a href="http://coelis.fr/">Coelis</a>.<br>
							Ici je partage mes <strong>conseils en Création visuelle et Développement Web</strong>, mes astuces et mes outils favoris.
							J'aimerais vous aider à développer votre activité sur Internet.
						</p>
					</div>
				</div>
			</div>
			<?php
		}
		else {
			?>

			<h6 class="separateur"><b>A propos de l'auteur</b> <span class="border"></span></h6>
			<!-- TOFIX : Penser à filter le profil Author selon la catégorie de l'article -->
			<div class="media">
				<div class="pull-left">
					<a href="<?php print get_author_posts_url(get_the_author_meta('ID')) ?>">
						<?php
						switch ( get_the_author_meta('user_nicename') ) {

							// Gilles Hoarau
							case 'gilleshoarau':
							?>
							<img class="media-object img-responsive img-circle" src="img/ico/Gilles-Hoarau-80.png" alt="Gilles Hoarau" width="80" height="80">
							<?php
							break;

							// Unicolored
							case 'unicolored':
							?>
							<img class="media-object img-responsive img-circle" src="img/ico/unicolored-80.png" alt="unicolored" width="80" height="80">
							<?php
							break;
						}
						?>
					</a>
				</div>
				<div class="media-body">
					<h5 class="media-heading">Publié par <a href="<?php print get_author_posts_url(get_the_author_meta('ID')) ?>"><?php print get_the_author() ?></a></h5>
					<?php
					switch ( get_the_author_meta('user_nicename') ) {

						// Gilles Hoarau
						case 'gilleshoarau':
						print '<p>&nbsp;</p>';
						?>
						<p>
							<a href="https://twitter.com/GillesHoarau" class="twitter-follow-button" data-show-count="true">Follow @GillesHoarau</a>
						</p>
						<?php
						break;

						// Unicolored
						case 'unicolored':
						print '<p>&nbsp;</p>';
						?>
						<p>
							<a href="https://twitter.com/unicolored" class="twitter-follow-button" data-show-count="true">Follow @unicolored</a>
						</p>
						<?php
						break;
					}
					?>
					<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
				</div>
			</div>

			<?php
		}
		?>

	</div>
</section>
