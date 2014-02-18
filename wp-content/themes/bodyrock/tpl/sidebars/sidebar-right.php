<?php
echo a('aside.aside-right');
echo 'qsdsd';
echo a('div.galaxie');
/*MODULE : Affichage de l'article en cours sur article single*/
if (is_single()) {
	the_post(get_the_ID());
	echo '<h1 class="widget-title"><i class="fa fa-eye"></i> '.__("Vous êtes ici","uni").'</h1>';
	echo '<div class="thumbnail">';
	echo br_getPostThumbnail('medium');
	echo '</div>';
	
	echo '<div class="btn-group btn-group-justified" role="navigation">';
		previous_post_link( '%link', __( '<div class="btn-group"><button type="button" class="btn btn-default">&laquo;</button></div>', 'bodyrock' ) );
		next_post_link( '%link', __( '<div class="btn-group"><button type="button" class="btn btn-default">&raquo;</button></div>', 'bodyrock' ) );
	echo '</div>';
	echo '<hr class="clearfix">';
}

dynamic_sidebar('sidebar-right');
echo z('div');
echo z('aside');
?>