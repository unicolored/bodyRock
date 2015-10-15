<?php
$categories = get_the_category();
$cats = "";
$i = 0;
foreach($categories as $cat) {
	if ($cat->term_id != get_category(get_category_by_slug('portfolio'))->term_id)
	if($cat->parent>0) {
		$cats .= ($i>0 ? ',' : false).$cat->term_id;
		$i++;
	}
}
$the_query = new WP_Query( array('cat'=>$cats,'orderby'=>'rand','order'=>'DESC','posts_per_page'=>3, 'post__not_in' => array(get_the_ID()) ));

$id_current = get_the_ID();
// The Loop
if ( $the_query->have_posts() ) {
	?>


	<aside class="similaires">
		<div class="br_artaside">
			<div class="page-header">
				<h1>Articles relatifs</h1>
			</div>

			<?php
			while ( $the_query->have_posts() ) {
				$the_query->the_post();
				?>
				<div class="artColonne">
					<?php get_template_part('templates/article','search'); ?>
				</div>
				<?php
			}
			?>
		</div>
	</aside>
	<?php

}
else {
	//get_template_part('templates/_nocontent','similaires');

}
// Passage du tableau d'images au javascript
//wp_localize_script( 'scriptsglobaux', 'imagesportfolio', $images );

/* Restore original Post Data */
wp_reset_postdata();
wp_reset_query();
?>
