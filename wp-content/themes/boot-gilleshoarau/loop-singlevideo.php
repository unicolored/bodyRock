<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
	<div class="container-fluid designed">
		<div id="noPlayer" class="row-fluid">
			<div class="span2 sidebardesigned">
				<div class="navigation3">
					<?php wp_list_categories('orderby=name&use_desc_for_title=0&title_li=&hide_empty=1'); ?>
				</div>
				<div class=""><p><?php posts_nav_link(); ?></p></div>
				<?php get_sidebar('left'); ?>
				<?php // primary widget area
				if ( is_active_sidebar( 'sidebar-left' ) ) : ?>
				<div id="undercontent">
					<?php dynamic_sidebar( 'sidebar-left' ); ?>
					<hr class="clear">
				</div>
				<?php endif; // end primary widget area ?>
			</div>
			<div id="contentsingle" class="span4">
				<div class="wrapped">
					<article>
						<header>
							<h1><?php the_title() ?></h1>
							<?php bodyrock_posted_on(); ?> | 
							<?php echo get_the_tag_list('<span>',', ','</span>'); ?>
						</header>
						<section>
							<?php the_content() ?>
							<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'bodyrock' ), 'after' => '</div>' ) ); ?>
						</section>
			
						<footer>
							<div class="entry-utility">
								<div class="entry-meta">
									<?php
									echo get_the_tag_list('<p>Tags: ',', ','</p>');
									?>
								</div><!-- .entry-meta -->	
							</div><!-- .entry-utility -->
						</footer>
					</article>
					<nav id="nav-single">
						<span class="nav-previous"><?php previous_post_link( '%link', __( '<span class="meta-nav">&larr;</span> Précédent', 'twentyeleven' ) ); ?></span>
						<span class="nav-next"><?php next_post_link( '%link', __( 'Suivant <span class="meta-nav">&rarr;</span>', 'twentyeleven' ) ); ?></span>
					</nav><!-- #nav-single -->
					<?php comments_template( '', true ); ?>
				</div>
			</div>
	
			<div class="span6">
				
				<div style="text-align:center; margin-top:2em;">
					<?php // the_post_thumbnail('large') ?>
					<?php
					$videoCode = get_post_meta(get_the_ID(), 'videoCode', true);
					$videoType = get_post_meta(get_the_ID(), 'videoType', true);
					
					switch($videoType) {
						case 'vim': echo '<iframe src="http://player.vimeo.com/video/'.$videoCode.'" width="930" height="431" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';  break;
						case 'you': echo '<object type="text/html" data="http://www.youtube.com/embed/'.$videoCode.'" style="width:90%;height:431px;"></object>'; break;
					}
					?> 
					<!--<br>
					<div class="navigation"><div class=" navbefore"><?php previous_post_link( '%link', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'bodyrock' ) . '</span> %title' ); ?></div></div>
					<div class="navigation"><div class=" navafter"><?php next_post_link( '%link', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'bodyrock' ) . '</span>' ); ?></div></div>-->
				</div>
			</div>
		</div>
		
		<span class="overlay"></span>
		<div id="diaporamaPlayer">

			<div id="myCarousel" class="slide">
				<div class="carousel-inner">
					<?php
						if ( $attachments ) {
							foreach ( $attachments as $attachment ) {
								$image_src=wp_get_attachment_image_src( $attachment->ID, 'projet-large' );
								?>
									<div class='item'>
										<a href='<?php echo the_permalink() ?>' title='<?php the_title(); ?>'>
										<b class="img" style="height:570px; width:100%; display:block;
										background:url(<?php echo $image_src[0]?>) center center no-repeat;"></b>
										</a>
									</div>									
							<?php
							}
						}
					?>	
				</div>
			</div>
		</div>
	</div>
<?php endwhile; // end of the loop. ?>