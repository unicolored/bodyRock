<?php
// Ajouter des scripts supplémentaires ci-dessous
if (get_post_format()=='video') {
	// Spécifique aux formats video
	global $urlfinale, $videoType, $videoCode;

	$videoCode = get_post_meta(get_the_ID(), 'videoCode', true);
	$videoType = get_post_meta(get_the_ID(), 'videoType', true);

	$urlfinale = CDN_PATH.'images/videos/'.$videoType.'/'.$videoCode.br_getImgVideoSize('thumbnail').'.jpg';
}

// HEADER
get_header();
?>
<section class="br_bonjour page">
	<?php // Placer le code Html ci-dessous ?>
	<?php
	if (have_posts()) :
		the_post();
		?>
	<section class="br_head">
		<div class="container">
			<div class="jumbotron">
				<h1><?php the_title() ?></h1>
			</div>
		</div>
	</section>

	<section class="article">
		<div class="container">
			<?php the_content(); ?>
		</div>
	</section>

	<?php
	endif;
	?>
	<?php // Placer le code Html ci-dessus ?>
</section>
<?php get_footer();?>
