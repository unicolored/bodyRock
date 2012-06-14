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
				<?php if ( ! empty( $post->post_parent ) ) : ?>
					<p class="page-title"><a href="<?php echo get_permalink( $post->post_parent ); ?>" title="<?php esc_attr( printf( __( 'Return to %s', 'bodyrock' ), get_the_title( $post->post_parent ) ) ); ?>" rel="gallery"><?php
						/* translators: %s - title of parent post */
						printf( __( '<span class="meta-nav">&larr;</span> %s', 'bodyrock' ), get_the_title( $post->post_parent ) );
					?></a></p>
				<?php endif; ?>

				<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<h2 class="entry-title"><?php the_title(); ?></h2>

					<div class="entry-meta">
						<?php
							printf( __( '<span class="%1$s">By</span> %2$s', 'bodyrock' ),
								'meta-prep meta-prep-author',
								sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s">%3$s</a></span>',
									get_author_posts_url( get_the_author_meta( 'ID' ) ),
									sprintf( esc_attr__( 'View all posts by %s', 'bodyrock' ), get_the_author() ),
									get_the_author()
								)
							);
						?>
						<span class="meta-sep">|</span>
						<?php
							printf( __( '<span class="%1$s">Published</span> %2$s', 'bodyrock' ),
								'meta-prep meta-prep-entry-date',
								sprintf( '<span class="entry-date"><abbr class="published" title="%1$s">%2$s</abbr></span>',
									esc_attr( get_the_time() ),
									get_the_date()
								)
							);
							if ( wp_attachment_is_image() ) {
								echo ' <span class="meta-sep">|</span> ';
								$metadata = wp_get_attachment_metadata();
								printf( __( 'Full size is %s pixels', 'bodyrock' ),
									sprintf( '<a href="%1$s" title="%2$s">%3$s &times; %4$s</a>',
										wp_get_attachment_url(),
										esc_attr( __( 'Link to full-size image', 'bodyrock' ) ),
										$metadata['width'],
										$metadata['height']
									)
								);
							}
						?>
						<?php edit_post_link( __( 'Edit', 'bodyrock' ), '<span class="meta-sep">|</span> <span class="edit-link">', '</span>' ); ?>
					</div><!-- .entry-meta -->

					<div class="entry-content">
						<div class="entry-attachment">
							<?php if ( wp_attachment_is_image() ) :
								$attachments = array_values( get_children( array( 'post_parent' => $post->post_parent, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'ASC', 'orderby' => 'menu_order ID' ) ) );
								foreach ( $attachments as $k => $attachment ) {
									if ( $attachment->ID == $post->ID )
										break;
								}
								$k++;
								// If there is more than 1 image attachment in a gallery
								if ( count( $attachments ) > 1 ) {
									if ( isset( $attachments[ $k ] ) )
										// get the URL of the next image attachment
										$next_attachment_url = get_attachment_link( $attachments[ $k ]->ID );
									else
										// or get the URL of the first image attachment
										$next_attachment_url = get_attachment_link( $attachments[ 0 ]->ID );
								} else {
									// or, if there's only 1 image attachment, get the URL of the image
									$next_attachment_url = wp_get_attachment_url();
								}
								?>
								<p class="attachment"><a href="<?php echo $next_attachment_url; ?>" title="<?php echo esc_attr( get_the_title() ); ?>" rel="attachment"><?php
									$attachment_width  = apply_filters( 'bodyrock_attachment_size', 900 );
									$attachment_height = apply_filters( 'bodyrock_attachment_height', 900 );
									echo wp_get_attachment_image( $post->ID, array( $attachment_width, $attachment_height ) ); // filterable image width with, essentially, no limit for image height.
								?></a></p>
	
								<div id="nav-below" class="navigation">
									<div class="nav-previous"><?php previous_image_link( false ); ?></div>
									<div class="nav-next"><?php next_image_link( false ); ?></div>
								</div><!-- #nav-below -->
							<?php else : ?>
								<a href="<?php echo wp_get_attachment_url(); ?>" title="<?php echo esc_attr( get_the_title() ); ?>" rel="attachment"><?php echo basename( get_permalink() ); ?></a>
							<?php endif; ?>
						</div><!-- .entry-attachment -->
						<div class="entry-caption"><?php if ( !empty( $post->post_excerpt ) ) the_excerpt(); ?></div>

						<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'bodyrock' ) ); ?>
						<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'bodyrock' ), 'after' => '</div>' ) ); ?>

					</div><!-- .entry-content -->

					<div class="entry-utility">
						<?php //bodyrock_posted_in(); ?>
						<?php edit_post_link( __( 'Edit', 'bodyrock' ), ' <span class="edit-link">', '</span>' ); ?>
					</div><!-- .entry-utility -->
				</div><!-- #post-## -->
				
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