<?php
/**
* @package Skeleton WordPress Theme Framework
* @subpackage skeleton
* @author Simple Themes - www.simplethemes.com
*/

// Do not delete these lines
	if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');

	if ( post_password_required() ) { ?>
		<p class="nocomments"><?php _e('This post is password protected. Enter the password to view comments.');?></p>
	<?php
		return;
	}
?>

<!-- You can start editing here. -->
		<div id="comments">
			<?php if ( have_comments() ) : ?>
				<h2>	
					<?php
					$nbcommentaires=get_comments_number();
					echo $nbcommentaires.' commentaire'.($nbcommentaires>1?'s':false); ?>
				</h2>			
				
				<ul class="commentlist">
					<?php $args = array(
				    'walker'            => null,
				    'max_depth'         => '',
				    'style'             => 'ul',
				    'callback'          => 'bootstrap_comment',
				    'end-callback'      => null,
				    'type'              => 'all',
				    'page'              => '',
				    'per_page'          => '',
				    'avatar_size'       => 48,
				    'reverse_top_level' => null,
				    'reverse_children'  => '' ); ?> 
					<?php wp_list_comments($args); ?>
				</ul>
			
				<div class="navigation">
					<div class="alignleft"><?php previous_comments_link() ?></div>
					<div class="alignright"><?php next_comments_link() ?></div>
				</div>
	
 			<?php else : // this is displayed if there are no comments so far ?>

	
			<?php endif; ?>
		</div>
		
		<?php if ( comments_open() ) : ?>
			<div id="respond">
				<h3 id="reply-title"><?php comment_form_title( _e('Laisser un commentaire','smpl')); ?></h3>
				<div class="cancel-comment-reply">
					<small><?php cancel_comment_reply_link(); ?></small>
				</div>

				<?php if ( get_option('comment_registration') && !is_user_logged_in() ) : ?>
					<p> <a href="<?php echo wp_login_url( get_permalink() ); ?>"><?php _e('You must be logged in to post a comment.','smpl');?></a> </p>
				<?php else : ?>
					<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
						<?php if ( is_user_logged_in() ) : ?>
							<p><?php _e('Connecté en tant que ','smpl').' '?><a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="<?php _e('Log out','smpl');?>"><?php _e('Se déconnecter ?','smpl');?></a></p>							
						<?php else : ?>
							<p>
							<label for="author"><small><?php _e('Name','smpl');?> <?php if ($req) _e('required','smpl'); ?></small></label>
							<input type="text" name="author" id="author" value="<?php /*echo esc_attr($comment_author); */ echo esc_attr($comment_author);?>" size="22" tabindex="1" <?php if ($req) echo "aria-required='true'"; ?> />
							</p>
							
							<p>
							<label for="email"><small><?php _e('Email','smpl'); _e('(will not be published)','smpl'); if ($req) _e('(required)','smpl'); ?></small></label>
							<input type="text" name="email" id="email" value="<?php echo esc_attr($comment_author_email); ?>" size="22" tabindex="2" <?php if ($req) echo "aria-required='true'"; ?> />
							</p>
							
							<p>
							<label for="url"><small><?php _e('Website','smpl');?></small></label>
							<input type="text" name="url" id="url" value="<?php echo esc_attr($comment_author_url); ?>" size="22" tabindex="3" />
							</p>
						<?php endif; ?>
						<!--<p><small><strong>XHTML:</strong> You can use these tags: <code><?php echo allowed_tags(); ?></code></small></p>-->
						
						<p class="comment-form-contact"><textarea name="comment" id="comment" cols="58" rows="10" tabindex="4"></textarea></p>
						
						<p><input name="submit" type="submit" id="submit" tabindex="5" value="<?php _e('Soumettre le commentaire','smpl');?>" />
						<?php comment_id_fields(); ?>
						</p>
						<?php do_action('comment_form', $post->ID); ?>
					</form>
				<?php endif; // If registration required and not logged in ?>
			</div>

		<?php endif; // if you delete this the sky will fall on your head ?>
