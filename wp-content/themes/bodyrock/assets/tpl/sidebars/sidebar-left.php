<?php
$defaults = array(
	'theme_location'  => 'primary',
	'container_class' => 'list-group',
	'menu'            => 'Top',
	'depth'			  => 1,
	'items_wrap'	  => '%3$s',
	'walker'          => new wp_bootstrap_listgroupwalker()
);

/* Html START */

echo a('aside.aside');
echo a('div.galaxie');

wp_nav_menu( $defaults );

if(is_single()) {
	echo '
	<div class="panel-group" id="guide">
		<div class="panel panel-default" style="overflow:visible;">
			<div class="panel-heading">
				<h4 class="panel-title"><a data-toggle="collapse" data-parent="#guide" href="#collapseOne">'.br_getIcon('chevron-circle-right').' '.__('Guide','bodyrock').'</a></h4>
			</div>
			<div id="collapseOne" class="panel-collapse collapse">
				<div class="panel-body">';
					get_template_part('tpl/bootstrap/breadcrumb', 'sidebar');
					
					$_SESSION['lastpost_id'] = false;
					$_SESSION['lastpost_id'] .= ''.get_the_ID().'';
					$_SESSION['lastpost_tags'] = '';
					$_SESSION['lastpost_cats'] = '';

					$posttags = get_the_tags();
					if ($posttags) {
						$i=0;
						foreach($posttags as $tag) {
							$i++;
							echo '#'.ucfirst($tag->name).'<br>' ;  
							//vardump($_SESSION['lastpost_tags']);
							$_SESSION['lastpost_tags'] .= $tag->name.',';
						}
					}

					$categories = get_the_category();
					if ($categories) {
						$i=0;
						foreach($categories as $categorie) {
							$i++;
							echo '@'.ucfirst($categorie->name).'<br>' ;
							$_SESSION['lastpost_cats'] .= $categorie->term_id.',';
						}
					}
					
					echo '
				</div>
			</div>
		</div>
	</div>
	';
}	

dynamic_sidebar('sidebar-left');

echo '
<div class="panel-group" id="guideTwo">
	<div class="panel panel-default" style="overflow:visible;">
		<div class="panel-heading">
			<h4 class="panel-title"><a data-toggle="collapse" data-parent="#guideTwo" href="#collapseTwo">'.br_getIcon('camera').' '.__('Image de la semaine','bodyrock').'</a></h4>
		</div>
		<div id="collapseTwo" class="panel-collapse collapse in">';

			// QUERY - Récupération de l'image de la semaine
			$cat = get_term_by('slug', 'image-de-la-semaine', 'category');
			$args['posts_per_page'] = 1;
			$args['cat'] = $cat->term_id;

			$args_section = array(
				'before_widget' => '',
				'after_widget' => ""
			);

			the_widget('br_widgetsBodyloop',array('name'=>'aside-widget-picoftheweek','apparence_disposition'=>'blog','affichage_modele'=>'affichage_modele_liste','vignette_background'=>'on','filtres_combien'=>1,'contenu_header_masquer'=>'on'),$args_section);

			/*FIN DE LAJOUT*/
			echo '
		</div>
	</div>
</div>';



echo z('div');
echo z('aside');
?>