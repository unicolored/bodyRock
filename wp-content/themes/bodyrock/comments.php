<?php

// COMMENTAIRES /////////////////////////////////////////////

/*//**//**//**//*//**//**//**//*//**//**//**//*//**//**//**/
// Personnalise l'apparence par défaut des commentaires et du formulaire.
/*//**//**//**//*//**//**//**//*//**//**//**//*//**//**//**/


// Do not delete these lines
	if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');

	if ( post_password_required() ) {
		echo '<p class="nocomments">'.__('This post is protected by password. Enter the password to view the comments..').'</p>';
		return;
	}
?>

<!-- You can start editing here. -->
		
<?php
if ( have_comments() ) :
	echo '<section class="comments">';
	
	echo '<h2>';
	printf(
		_n( 'An answer to %2$s', '%1$s Answers to %2$s', get_comments_number(), 'bodyrock' ),
		number_format_i18n( get_comments_number() ),
		'<span class="normal">&quot;'.get_the_title().'&quot;</span>'
	);
	echo '</h2>';

	echo '<ul class="commentlist">';
	wp_list_comments();
	echo '</ul>';

	echo '<div class="navigation">';
		echo '<div class="alignleft">';
			previous_comments_link();
		echo '</div>';
		echo '<div class="alignright">';
			next_comments_link();
		echo '</div>';
	echo '</div>';
	
	echo '</section>';
endif;

if ( comments_open() ) :
	echo '<div id="respond">';
	
	echo '<h3 id="reply-title">'.comment_form_title( br_getIcon('comment').' '.__('Leave a comment','bodyrock')).'</h3>';
	echo '<div class="cancel-comment-reply">';
	echo '<small>'.cancel_comment_reply_link().'</small>';
	echo '</div>';

	if ( get_option('comment_registration') && !is_user_logged_in() ) :
		echo '<p> <a href="'.wp_login_url( get_permalink() ).'">'.__('You have to be logged to add a comment.','bodyrock').'</a> </p>';
	else :
		echo '<form action="'.get_option('siteurl').'/wp-comments-post.php" method="post" id="commentform">';
		if ( is_user_logged_in() ) :
			echo '<p>'.__('Logged as :','bodyrock').' <a href="'.get_option('siteurl').'/wp-admin/profile.php">'.$user_identity.'</a>. <a href="'.wp_logout_url(get_permalink()).'" title="'.__('Logout','bodyrock').'">'.__('Logout','bodyrock').'</a></p>';
		else :
			echo '<p>';
			echo '<label for="author"><small>'.__('Nom','bodyrock').' '.($req != false ? __('required','bodyrock') : false).'</small></label>';
			echo '<input class="form-control" type="text" name="author" id="author" value="'.esc_attr($comment_author).'" size="22" tabindex="1" '.($req != false ? "aria-required='true'" : false).' />';
			echo '</p>';
			echo '<p>';
			echo '<label for="email"><small>'.__('Email','bodyrock').' '.__('(will not be publish)','bodyrock').' '.($req != false ? __('required','bodyrock') : false).'</small></label>';
			echo '<input class="form-control" type="text" name="email" id="email" value="'.esc_attr($comment_author_email).'" size="22" tabindex="2" '.($req != false ? "aria-required='true'" : false).' />';
			echo '</p>';
			echo '<p>';
			echo '<label for="url"><small>'.__('Site web','bodyrock').'</small></label>';
			echo '<input class="form-control" type="text" name="url" id="url" value="'.esc_attr($comment_author_url).'" size="22" tabindex="3" />';
			echo '</p>';
		endif;
		
		echo '<!--<p><small><strong>XHTML:</strong> You can use these tags: <code>'.allowed_tags().'</code></small></p>-->';

		echo '<p><textarea class="form-control" name="comment" id="comment" rows="10" tabindex="4"></textarea></p>';

		echo '<p><button class="btn btn-default btn-block" type="submit" id="submit" tabindex="5">'.br_getIcon('plus').' '.__('Post comment','bodyrock').'</button>';
		comment_id_fields();
		echo '</p>';
		do_action('comment_form', $post->ID);
		echo '</form>';
	endif; // If registration required and not logged in
	
	echo '</div>';
endif; // if you delete this the sky will fall on your head ?>