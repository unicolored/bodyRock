<?php
get_header();

/************** HTML START **************/

echo a('div.galaxie');
echo a('section.content');

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

	$instance_articles_recents = array(
		'titre_icone'=>'bookmark',
		'name'=>'articlesrecents',
		'class' => 'recommandations',
		
		'filtres_type' => 'evenements',
		
		'apparence_disposition' => 'carousel',
		'affichage_modele' => 'affichage_modele_thumbnail',
		
		'vignette_background' => 'on',

		'contenu_footer_masquer' => true,
		
		'filtres_off'=>false,
		'ajax'=>false
	);

	if($_SESSION['lastpost_id']!=false) {
		$instance_articles_recents['ajax'] = "on";
	}
	$_SESSION['lastpost_id'] = false;
	
	if(get_query_var('paged')>1) {
		$instance_articles_recents['titre'] = "Médiathèque";
	}
	
	the_widget('br_widgetsBodyloop',$instance_articles_recents,$args_section);


	echo '<hr class="margin">';
	if ( have_posts() ) :
	
		while ( have_posts() ) :
		
			the_post();
			setPostViews(get_the_ID());	
			get_template_part(TPL_SINGULAR_PATH.'lieu', get_post_format());
			
		endwhile;
		
	else:
	
		echo '<p>'.__('Sorry, no posts matched your criteria.').'</p>';
		
	endif;
	
echo z('section');
	
get_template_part(TPL_SIDEBAR_PATH.'sidebar','left');

get_template_part(TPL_SIDEBAR_PATH.'sidebar','right');

echo z('div');
	
get_footer();
?>