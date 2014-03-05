<?php

// EXTRALOOP Modules /////////////////////////////////////////////

/*//**//**//**//*//**//**//**//*//**//**//**//*//**//**//**/
// Gère l'affichage de la bodyloop sur post page
/*//**//**//**//*//**//**//**//*//**//**//**//*//**//**//**/

function add_post_content($content) {

    global $post;

    $instance = getDefaultLoop();
    $instance = get_post_meta(get_the_ID());
    foreach ($instance as $K => $V) {
        $instance[$K] = $V[0];
    }
    $instance['filtres_off'] = false;
    $instance['aftercontent'] = true;
    $instance['ajax'] = false;    

    $form = new br_widgetsBodyloop();
    $content .= '<hr>' . $form -> widget(false, $instance) . '';

    return $content;
}

add_filter('the_content', 'add_post_content');
