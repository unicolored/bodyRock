<?php
global $urlfinale, $videoType, $videoCode;

echo a('article.article','#post-'.get_the_ID());

require_once INC_PATH.'_libs/soundcloudphp/Soundcloud.php';

// create a client object with your app credentials
$client = new Services_Soundcloud('5a725ad30c035ffa4003a2870f85aad2', 'cbe36c1104bf03e67f516885795910ff');
$client->setCurlOptions(array(CURLOPT_FOLLOWLOCATION => 1));



if( get_post_format()=='video' ) {
	// La hauteur de la vidéo est définie d'abord dans les options du thème
	// puis par article, il est possible de spécifier une taille distincte
	$custom = get_post_custom($post->ID);

	$videoCode = isset($custom["videoCode"][0]) ? $custom["videoCode"][0] : false;
	$videoType = isset($custom["videoType"][0]) ? $custom["videoType"][0] : false;
	$videoHeight = isset($custom["videoHeight"][0]) && $custom["videoHeight"][0]!=false ? $custom["videoHeight"][0] : BR_VIDEO_HEIGHT;

	// Pour les vidéos Youtube, on charge le lecteur html5
	// Pour vimeo, il ne semble pas possible de trouver le lien du mp4 même via l'api.
	if($videoType=='you') {
		require(INC_PATH.'_libs/youtubedownloader/curl.php');
		require(INC_PATH.'_libs/youtubedownloader/youtube.php');

		$tube = new youtube();

		$links = $tube->get('http://www.youtube.com/watch?v='.$videoCode);

		if($links) {
//		vardump($links);
			foreach($links as $k=>$v) {
				$videolink[$k]['ext']=$v['ext'];
				$videolink[$k]['type']=$v['type'];
				$videolink[$k]['url']=$v['url'];
			}
			$path_name = str_replace('http://','',strtolower(get_home_url()));
			echo '
				<video id="example_video_1" class="video-js vjs-default-skin" controls preload="none" width="100%" height="500"
				poster="/senzu/'.$path_name.'/images/videos/'.$videoType.'/'.$videoCode.'.jpg"
				data-setup="{}">';

			foreach($videolink as $V) {
				echo '<source src="'.$V['url'].'" type="video/'.$V['ext'].'" data-quality="'.$V['type'].'" />'."\n";
				/*		<source src="http://video-js.zencoder.com/oceans-clip.webm" type="video/webm" />
				<source src="http://video-js.zencoder.com/oceans-clip.ogv" type="video/ogg" />*/
			}
			/*	<track kind="captions" src="demo.captions.vtt" srclang="en" label="English"></track><!-- Tracks need an ending tag thanks to IE9 -->
			<track kind="subtitles" src="demo.captions.vtt" srclang="en" label="English"></track><!-- Tracks need an ending tag thanks to IE9 -->*/
			echo '</video>';
			echo a('div.scripts_video').z('div');
		}
		else {
			echo $tube->error;
			echo '<div id="singlevideo'.$videoType.'" class="code_'.$videoCode.'"></div>';

			// Spécifique aux formats video
			// Chargement des objets vidéos
			/*
			echo "<script>\n";
			echo 'jQuery(document).ready(function(){'."\n";
			echo "// AFFICHAGE DES VIDEOS Si le conteneur identifié est trouvé\n"."\n"."\n";

			echo '
				jQuery(\'#singlevideoyou\').html(\'<iframe width="100%" height="'.$videoHeight.'" src="//www.youtube.com/embed/\'+(jQuery(\'#singlevideoyou\').attr(\'class\').replace(\'code_\', \'\'))+\'?rel=0&amp;autoplay='.BR_VIDEO_AUTOPLAY.'&related=0" frameborder="0" allowfullscreen></iframe>\');
				jQuery(\'#singlevideovim\').html(\'<iframe src="//player.vimeo.com/video/\'+(jQuery(\'#singlevideovim\').attr(\'class\').replace(\'code_\', \'\'))+\'?badge=0&amp;color=db0000&amp;autoplay='.BR_VIDEO_AUTOPLAY.'" width="100%" height="'.BR_VIDEO_HEIGHT.'" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>\');
			';

			echo '});'."\n";
			echo "</script>\n";*/
		}


	}
	elseif($videoType=='vim') {
		echo '<div id="singlevideo'.$videoType.'" class="code_'.$videoCode.'"></div>';

		// Spécifique aux formats video
		// Chargement des objets vidéos
		echo "<script>\n";
		echo 'jQuery(document).ready(function(){'."\n";
		echo "// AFFICHAGE DES VIDEOS Si le conteneur identifié est trouvé\n"."\n"."\n";

		echo '
			//if(jQuery(\'#singlevideoyou\').length>0) { // Youtube
				//jQuery(\'#singlevideoyou\').html(\'<iframe width="100%" height="'.$videoHeight.'" src="//www.youtube.com/embed/\'+(jQuery(\'#singlevideoyou\').attr(\'class\').replace(\'code_\', \'\'))+\'?rel=0&amp;autoplay='.BR_VIDEO_AUTOPLAY.'&related=0" frameborder="0" allowfullscreen></iframe>\');
			//}
			jQuery(\'#singlevideovim\').html(\'<iframe src="//player.vimeo.com/video/\'+(jQuery(\'#singlevideovim\').attr(\'class\').replace(\'code_\', \'\'))+\'?badge=0&amp;color=db0000&amp;autoplay='.BR_VIDEO_AUTOPLAY.'" width="100%" height="'.BR_VIDEO_HEIGHT.'" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>\');
		';

		echo '});'."\n";
		echo "</script>\n";
	}
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
echo '<h1>'.strip_tags(get_the_title()).'</h1>';
echo z('/header');

?>



	<div class="col-ff">
		<div class="col-f">
			<a class="addthis_button_facebook_like" fb:like:layout="standard"></a>
			<br>
			<a class="addthis_button_google_plusone" g:plusone:size="medium"></a>

			<p>Lien court :
			<?php
			/*
				$ch = curl_init('http://api.bitly.com/v3/shorten?login=unicolored&apiKey=R_8de9dc884a5f6e6ba8831909df65d03c&longUrl='.get_permalink());
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

				$result = curl_exec($ch);
				$R = json_decode($result);
				*/
			?>
			<input type="text" value="<?php echo $R->data->url ?>" class="form-control">
			</p>
		</div>
		<div class="col-f">
			<?php get_template_part('tpl/parts/article', 'share') ?>
		</div>
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
	$instance_footer['contenu_footer_masquer']=false;
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

<section class="art-comments">
<?php comments_template( '', true ); ?>
</section>
