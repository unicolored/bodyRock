<div class="column">
<h6><i class="fa fa-bullhorn"></i> Recommandations</h6>
<?php the_widget( 'bodyrock_relatedposts' ); ?>
</div>
<hr>

<h6><i class="fa fa-chevron-circle-right"></i> PARTENAIRES</h6>
<?php
// set the "paged" parameter (use 'page' if the query is on a static front page)
$paged = ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1;
$the_query = new WP_Query('paged='.$paged.'&posts_per_page=4&cat=36&order_by=rand&post_status=publish&post_type=post' ); 

$a='a';
$n=$i=$j=$k=$l=1;
if ( $the_query->have_posts() ) {
	while ( $the_query->have_posts() ) {
		$the_query->the_post();
		?>
		<div class="col-lg-6">
		<?php
		get_template_part('/tpl/content/promo');
		?>
		</div>
		<?php
	}
}
wp_reset_query();
?>