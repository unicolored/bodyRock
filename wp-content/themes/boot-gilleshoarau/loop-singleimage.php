<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
	<div class="container-fluid designed">
		<div id="noPlayer" class="row-fluid">
			<div class="span2 sidebardesigned">
				<div class="navigation3">
					<?php wp_list_categories('orderby=name&use_desc_for_title=0&title_li=&hide_empty=0'); ?>
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
			<div id="contentsingle" class="span6">		
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
				<?php comment_form(); ?> 
				<?php wp_list_comments(array('style' => 'div')); ?>
			</div>
		
			<div class="span4">
				<?php
				$args = array(
				'post_type' => 'attachment',
				'numberposts' => -1,
				'post_status' => null,
				'post_parent' => $post->ID
				);
				
				$attachments = get_posts( $args );
				if ( $attachments ) {
					foreach ( $attachments as $attachment ) {
						echo '<p>';
						$image_src=wp_get_attachment_image_src( $attachment->ID, 'projet-large' );
						echo '<a class="" href="'.str_replace("files","wp-content/blogs.dir/9/files",$image_src[0]).'" style="background:url('.str_replace("files","wp-content/blogs.dir/9/files",$image_src[0]).') center center no-repeat; padding:0em; float:left; width:100%; height:570px; position:relative; margin:1em; display:block;" title="'.trim(strip_tags( $attachment->post_title )).'"></a>';
						//echo apply_filters( 'the_title', $attachment->post_title );
						echo '</p>';
					}
				}
				?>
			</div>
		</div>
		
		<span class="overlay"></span>
	</div>
<?php endwhile; // end of the loop. ?>