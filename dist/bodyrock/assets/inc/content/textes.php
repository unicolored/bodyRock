<?php

// TEXTES Content /////////////////////////////////////////////

/*//**//**//**//*//**//**//**//*//**//**//**//*//**//**//**/
// Tout ce qui concerne les paramètres liés aux textes.
/*//**//**//**//*//**//**//**//*//**//**//**//*//**//**//**/


// EXCERPT
add_filter('excerpt_length', 'content_textesSet_excerpt_length',500);
add_filter('excerpt_more', 'content_textesSet_excerpt_more',500);

// excerpt cleanup
if (!function_exists('content_textesSet_excerpt_length')) {
function content_textesSet_excerpt_length($length) {
  return 40;
}
}

if (!function_exists('content_textesSet_excerpt_more')) {
function content_textesSet_excerpt_more($more) {
  return ' &hellip; <a href="' . get_permalink() . '">' . __( 'suite...', 'bodyrock' ) . '</a>';
}
}


function br_content_textesGet_posted_on($sep=false) {
/*	printf( br_getIcon('stats').' %8$s'.$sep.br_getIcon('calendar').' '.__('Posté le ','bodyrock').' <time class="entry-date" datetime="%3$s" pubdate>%4$s</time>'.$sep.' '.br_getIcon('user').' '.__('Added by','bodyrock').' <a href="%5$s" title="%6$s">%7$s</a>',
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_attr( sprintf( __( 'Voir tous les articles de %s', 'bodyrock' ), get_the_author() ) ),
		get_the_author(),
		getPostViews(get_the_ID())
	);*/
	return
	br_getIcon('stats').' '.getPostViews(get_the_ID())
	.$sep.
	br_getIcon('calendar').' '.__('Posté le','bodyrock').' <time class="entry-date" datetime="'.esc_attr( get_the_date( 'c' ) ).'" pubdate>'.esc_html( get_the_date() ).'</time>'
	.$sep.
	br_getIcon('user').' '.__('Ajouté par','bodyrock').' <a href="'.esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ).'" title="'.esc_attr( sprintf( __( 'Voir tous les articles de %s', 'bodyrock' ), get_the_author() ) ).'">'.get_the_author().'</a>'
	.
	(get_comments_number()==0 ? false : $sep.br_getPageIcon('comment')." ".get_comments_number()." ".__('commentaire(s)','bodyrock'));
}


// Retourne la date sous la forme "il&nbsp;y&nbsp;a&nbsp;... ans, ... mois, ... jours, ec..."
function time_passed($timestamp){
    //type cast, current time, difference in timestamps
    $timestamp      = (int) $timestamp;
    $current_time   = time();
    $diff           = $current_time - $timestamp;
   
    //intervals in seconds
    $intervals      = array (
        'year' => 31556926, 'month' => 2629744, 'week' => 604800, 'day' => 86400, 'hour' => 3600, 'minute'=> 60
    );
   
    //now we just find the difference
    if ($diff == 0)
    {
        return 'à l\'instant';
    }   

    if ($diff < 60)
    {
        return $diff == 1 ? 'il&nbsp;y&nbsp;a&nbsp;' . $diff . '&nbsp;seconde' : 'il&nbsp;y&nbsp;a&nbsp;' . $diff . '&nbsp;secondes';
    }       

    if ($diff >= 60 && $diff < $intervals['hour'])
    {
        $diff = floor($diff/$intervals['minute']);
        return $diff == 1 ? 'il&nbsp;y&nbsp;a&nbsp;' . $diff . '&nbsp;minute' : 'il&nbsp;y&nbsp;a&nbsp;' . $diff . '&nbsp;minutes';
    }       

    if ($diff >= $intervals['hour'] && $diff < $intervals['day'])
    {
        $diff = floor($diff/$intervals['hour']);
        return $diff == 1 ? 'il&nbsp;y&nbsp;a&nbsp;' . $diff . '&nbsp;heure' : 'il&nbsp;y&nbsp;a&nbsp;' . $diff . '&nbsp;heures';
    }   

    if ($diff >= $intervals['day'] && $diff < $intervals['week'])
    {
        $diff = floor($diff/$intervals['day']);
        return $diff == 1 ? 'hier' : 'il&nbsp;y&nbsp;a&nbsp;' . $diff . '&nbsp;jours';
    }   

    if ($diff >= $intervals['week'] && $diff < $intervals['month'])
    {
        $diff = floor($diff/$intervals['week']);
        return $diff == 1 ? 'il&nbsp;y&nbsp;a&nbsp;' . $diff . '&nbsp;semaine' : 'il&nbsp;y&nbsp;a&nbsp;' . $diff . '&nbsp;semaines';
    }   

    if ($diff >= $intervals['month'] && $diff < $intervals['year'])
    {
        $diff = floor($diff/$intervals['month']);
        return $diff == 1 ? 'il&nbsp;y&nbsp;a&nbsp;' . $diff . '&nbsp;mois' : 'il&nbsp;y&nbsp;a&nbsp;' . $diff . '&nbsp;mois';
    }   

    if ($diff >= $intervals['year'])
    {
        $diff = floor($diff/$intervals['year']);
        return $diff == 1 ? 'il&nbsp;y&nbsp;a&nbsp;' . $diff . '&nbsp;an' : 'il&nbsp;y&nbsp;a&nbsp;' . $diff . '&nbsp;ans';
    }
}
?>