<?php
global $urlfinale, $videoType, $videoCode;

echo a('article.article','#post-'.get_the_ID());



if( get_post_format()=='video' ) {
	echo '<div id="singlevideo'.$videoType.'" class="code_'.$videoCode.'"></div>';
}


if( has_post_thumbnail() ) {
	echo '<section class="art-vignette">';
	the_post_thumbnail('large',array('class'=>'img-responsive'));
	echo '</section>';
}

if( get_post_format()=='audio' ) {
	br_EmbedAudio(array('type' => 'soundcloud', 'track'=> get_post_meta(get_the_ID(), 'audioCode', true), 'class' => "col-ff",'autoplay' => "false", 'color' => "db0000", 'width' => "100%", 'height' => "450", 'show_artwork' => "true"));
}

echo a('header.art-header');
echo '<h1>'.get_the_title().'</h1>';
//echo '<p>'.br_content_textesGet_posted_on(' • ').'</p>';
echo z('/header');

?>


	
	<div class="col-ff">	
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
	
	<div class="col-ff">
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

	<?php
	$instance_footer['contenu_footer_afficher']=true;
	$instance_footer['contenu_footer_separateur']=" | ";
	$instance_footer['contenu_footer_date']=true;
	$instance_footer['contenu_footer_vues']=true;
	echo Get_artfooter($instance_footer);
	?>
	
	<div class="media vcard">
	  <a class="pull-left" href="#">
	  <span class="thumbnail">
		<?php echo get_avatar( get_the_author_meta('email'), '60' ); ?>
	</span>
	  </a>
	  <div class="media-body">
		<h4 class="media-heading">A propos de l'auteur</h4>
		<?php $auteur = get_the_author(); echo ' <i class="fa fa-user"></i> '.$auteur;	?>
	  </div>
	</div>
</article>

<?php comments_template( '', true ); ?>
