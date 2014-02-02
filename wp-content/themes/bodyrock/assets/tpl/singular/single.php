<?php
global $urlfinale, $videoType, $videoCode;

echo a('article.article','#post-'.get_the_ID());

echo a('header.art-header');
echo '		<h1>'.get_the_title().'</h1>';
echo '		<p>'.br_content_textesGet_posted_on(' • ').'</p>';
echo z('/header');
	
if (current_user_can('list-users')) {
	echo '<div class="column">';
	echo '<a href="/wp-admin/post.php?post='.get_the_ID().'&action=edit"><button class="btn btn-xs btn-success">Modifier</button></a>';
	echo '</div>';
}

if( get_post_format()=='video' ) {
	echo '<div id="singlevideo'.$videoType.'" class="code_'.$videoCode.'"></div>';
}


if( has_post_thumbnail() ) {
	echo '<div class="art-vignette">';
	the_post_thumbnail('large',array('class'=>'img-responsive'));
	echo '</div>';
}

if( get_post_format()=='audio' ) {
	br_EmbedAudio(array('type' => 'soundcloud', 'track'=> get_post_meta(get_the_ID(), 'soundCode', true), 'class' => "col-lg-12",'auto_play' => "true", 'color' => "db0000", 'width' => "", 'height' => "166", 'show_artwork' => "true"));
} ?>
	
	<div class="column">	
		<?php get_template_part('tpl/parts/article', 'share') ?>
		<hr class="margin">
		<a class="addthis_button_facebook_like" fb:like:layout="standard"></a> 
		<br>
		<a class="addthis_button_google_plusone" g:plusone:size="medium"></a>
		<p>Lien court :
		<?php
			$ch = curl_init('http://api.bitly.com/v3/shorten?login=unicolored&apiKey=R_8de9dc884a5f6e6ba8831909df65d03c&longUrl='.get_permalink());
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			 
			$result = curl_exec($ch);
			$R = json_decode($result);
		?>
		<input type="text" value="<?php echo $R->data->url ?>" class="form-control">
		</p>
	</div>
	<hr class="clearfix">
	<div class="column">
		<?php
		/*MODULE:: Affichage des attachments */
		$args = array(
		'post_type' => 'attachment',
		'numberposts' => -1,
		'post__not_in' => array(get_post_thumbnail_id( get_the_ID() )),
		'post_status' => null,
		'post_parent' => $post->ID,
		'orderby'         => 'menu_order',
		'order'           => 'ASC'
		);
		
		$attachments = get_posts( $args );
		$nb_att=count($attachments);
		
		if ( $attachments ) { ?>
			<section class="art-attachments">
				<?php
				foreach ( $attachments as $attachment ) {
					//vardump($attachment);
					$image_src=wp_get_attachment_image_src( $attachment->ID, 'large' );

					echo '<article class="article">';
					echo '<section class="art-vignette">';
					echo '<img class="img-responsive" src="'.$image_src[0].'" alt="'.trim(strip_tags( $attachment->post_title )).'">';
					echo '</section';
					echo '<header class="art-header">';
					echo '<h1>'.$attachment->post_title.' <small>'.$attachment->post_excerpt.'</small></h1>';
					echo '<p>'.$attachment->post_content.'</p>';
					echo '</header>';
					echo '</article>';
					echo '<hr>';
				}
				?>
				<hr class="clearfix" />
			</section>
			<?php
		}
		?> 
	</div>
	<section class="art-content">
		<?php
		the_content(false,1);
		?>
	</section>
	<hr>
	<footer class="art-footer">
		<div class="column">
			<h5>A propos de l'auteur</h5>
			<h5><?php $auteur = get_the_author(); echo get_avatar( get_the_author_email(), '60' ); echo ' <i class="fa fa-user"></i> '.$auteur;	?></h5>
		</div>
	</footer>
	<hr>
	<hr class="margin2">
	
	<div class="col-lg-10 col-lg-offset-2">
		<h1 class="int-h"><i class="fa fa-comment"></i> Laisser un commentaire</h1>
		<hr class="margin">
		<?php comments_template( '', true ); ?>
	</div>

</article>
