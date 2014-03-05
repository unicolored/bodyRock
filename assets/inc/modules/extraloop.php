<?php

// EXTRALOOP Modules /////////////////////////////////////////////

/*//**//**//**//*//**//**//**//*//**//**//**//*//**//**//**/
// Gère l'affichage de la bodyloop sur post page
/*//**//**//**//*//**//**//**//*//**//**//**//*//**//**//**/


add_action( 'get_template_part_content', 'getExtraLoop' );

function getExtraLoop()
{

        echo 'tasoeur';
        global $post;
        echo $post->ID;

}

function add_post_content($content) {

        global $post;
        echo $post->post_ID;
        
        $form = new br_widgetsBodyloop();
        $content .= '<hr><p>'.$form -> widget(array(), $instance).'::'.$post->post_ID.'::</p>';
    
    return $content;
}
add_filter('the_content', 'add_post_content');