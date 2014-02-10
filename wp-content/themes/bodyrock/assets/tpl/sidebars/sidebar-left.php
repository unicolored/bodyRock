<?php
$defaults = array(
	'theme_location'  => 'primary',
	'menu'            => 'Top',
/*	'container'       => 'div',
	'container_class' => '',
	'container_id'    => '',
	'menu_class'      => 'menu',
	'menu_id'         => '',*/
	'echo'            => true,
/*	'fallback_cb'     => 'wp_page_menu',
	'before'          => '',
	'after'           => '',
	'link_before'     => '',
	'link_after'      => '',*/
	'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
	'depth'           => 2,
	'walker'          => false
);

/* Html START */

echo a('aside.aside');
echo a('div.galaxie');

echo '

<div class="panel-group" id="guide">
  <div class="panel panel-default" style="overflow:visible;">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#guide" href="#collapseOne">
          Guide
        </a>
      </h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse in">
      <div class="panel-footer">';
wp_nav_menu( $defaults );
echo '</div>
    </div>
  </div>

';


dynamic_sidebar('sidebar-left');

/* AJOUT */

?>
<h6><i class="fa fa-chevron-circle-right"></i> Guide</h6>
<?php get_template_part('tpl/bootstrap/breadcrumb', 'sidebar'); ?>

<p>
<?php
$_SESSION['lastpost_id'] .= ''.get_the_ID().',';

$posttags = get_the_tags();
if ($posttags) {
$i=0;
foreach($posttags as $tag) {
$i++;
echo '#'.ucfirst($tag->name).'<br>' ;  
}
}

$categories = get_the_category();
if ($categories) {
$i=0;
foreach($categories as $categorie) {
$i++;
echo '#'.ucfirst($categorie->name).'<br>' ;
}
}
?>
</p>



<?php
// QUERY - Récupération de l'image de la semaine
$cat = get_term_by('slug', 'image-de-la-semaine', 'category');
$args['posts_per_page'] = 1;
$args['cat'] = $cat->term_id;

$the_query = new WP_Query( $args );
if ( $the_query->have_posts() ) :

echo '<hr>';
echo '<h6><i class="fa fa-picture-o"></i> Image de la semaine</h6>';
echo '<section class="">';
while ( $the_query->have_posts() ) :

$the_query->the_post();
get_template_part('tpl/content/item'); // Affichage d'un résultat

endwhile;
echo '</section>';
endif;
/*FIN DE LAJOUT*/

echo z('div');
echo z('aside');
?>