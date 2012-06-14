<?php
/**
 * The loop that displays a single post.
 *
 * The loop displays the posts and the post content.  See
 * http://codex.wordpress.org/The_Loop to understand it and
 * http://codex.wordpress.org/Template_Tags to understand
 * the tags used in it.
 *
 * This can be overridden in child themes with loop-single.php.
 *
 * @package Skeleton WordPress Theme Framework
 * @subpackage bodyrock
 * @author Simple Themes - www.simplethemes.com
 */
?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
<div class="container-fluid" style="background:#000;">
<div class="container" style="background:#fff;">
<article class="single">
<header>
<h2><?php the_title() ?></h2>					
</header>
</article>
</div>
<div class="container-fluid">

	<div class="row-fluid">
	<div id="contentsingle" class="span3">		
				<section>
					<?php the_content() ?>
					<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'bodyrock' ), 'after' => '</div>' ) ); ?>
				</section>
				
				<footer>
					<div class="entry-utility">
						<div class="entry-meta">
							<?php bodyrock_posted_on(); ?>
							<br>
							<?php
							echo get_the_tag_list('<p>Tags: ',', ','</p>');
							?>
						</div><!-- .entry-meta -->	
					</div><!-- .entry-utility -->
				</footer>
				
				
			</div>
			
				<div class="unislider span7">
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
							$input = array("1", "-1", "2", "-2", "3", "-3");
							$rand_keys = array_rand($input);
							echo '<a class="group3" href="'.str_replace("files","wp-content/blogs.dir/9/files",$image_src[0]).'" style="background:url('.str_replace("files","wp-content/blogs.dir/9/files",$image_src[0]).') center center no-repeat; padding:0em; float:left; width:171px; height:20em; width:17em; position:relative; margin:1em; display:block;" title="'.trim(strip_tags( $attachment->post_title )).'"><span>'.trim(strip_tags( $attachment->post_title )).'</span></a>';
							//echo apply_filters( 'the_title', $attachment->post_title );
							echo '</p>';
						}
					}
					?>
				</div>
				
				<div class="span2">
					<?php comment_form(); ?> 
					<?php wp_list_comments(array('style' => 'div')); ?>
				</div>
				
			</div>
<div class="row">
	<article id="post-<?php the_ID(); ?>" <?php post_class('single'); ?>>
		
		<div class="span8">
			<?php get_sidebar('right'); ?>
		</div>
		<div class="span4">
			<?php // primary widget area
			if ( is_active_sidebar( 'sidebar-single' ) ) : ?>
				<div id="sidebarsingle">
					<?php dynamic_sidebar( 'sidebar-single' ); ?>
				</div>
			<?php endif; // end primary widget area ?>
		</div>
	</article>			
</div>				
</div>
</div>
<?php endwhile; // end of the loop. ?>