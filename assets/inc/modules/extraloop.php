<?php

// EXTRALOOP Modules /////////////////////////////////////////////

/*//**//**//**//*//**//**//**//*//**//**//**//*//**//**//**/
// Gère l'affichage de la bodyloop sur post page
/*//**//**//**//*//**//**//**//*//**//**//**//*//**//**//**/

function add_post_content($post) {
    //vardump($post);
    
    if (isset($post -> queried_object -> ID)) {
        $instance = getDefaultLoop();
        $instance = get_post_meta($post -> queried_object -> ID);
        foreach ($instance as $K => $V) {
            $instance[$K] = $V[0];
        }
        $instance['filtres_off'] = false;
        $instance['aftercontent'] = true;
        $instance['ajax'] = false;

        $form = new br_widgetsBodyloop();
        //vardump($form -> widget(false, $instance));
        echo $form -> widget(false, $instance);
    }
}
if(!is_admin() && is_page()) {
    add_filter('loop_start', 'add_post_content');
}

