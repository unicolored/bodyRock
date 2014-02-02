<?php
/*
// Customizing Admin Columns
add_filter("manage_evenements_posts_columns", "evenements_edit_columns");   

function evenements_edit_columns($columns){

	$new_columns = array(
		'publisher' => __('Publisher', 'ThemeName'),
		'book_author' => __('Book Author', 'ThemeName'),
	);
    return array_merge($columns, $new_columns);
}

add_action("manage_evenements_posts_custom_column",  "evenement_custom_columns"); 

function evenement_custom_columns($column){
        global $post;
        switch ($column)
        {
            case "description":
                the_excerpt();
                break;
            case "date":
                $custom = get_post_custom();
                echo $custom["eventDate"][0];
                break;
            case "type":
                echo get_the_term_list($post->ID, 'event-type', '', ', ','');
                break;
        }
}  
*/
?>