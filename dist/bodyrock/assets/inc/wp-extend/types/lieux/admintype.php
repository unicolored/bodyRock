<?php

// Customizing Admin Columns
add_filter("manage_edit-lieux_columns", "lieux_edit_columns");   

function lieux_edit_columns($columns){
        $columns = array(
            "cb" => "<input type=\"checkbox\" />",
            "title" => "Evènement",
            "description" => "Description",
            "date" => "Date",
            "type" => "Type of Project",
        );  

        return $columns;
}  

add_action("manage_posts_custom_column",  "lieux_custom_columns"); 

function lieux_custom_columns($column){
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

?>