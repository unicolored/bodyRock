<?php

// Creating a New Post Type

add_action('init', 'projet_register');  

function projet_register() {
    $args = array(
        'label' => __('Projets'),
        'singular_label' => __('Projet'),
        'public' => true,
        'show_ui' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'rewrite' => false,
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'comments')//, 'comments', 'author', )
       );  

    register_post_type( 'projet' , $args );
}

// Adding a Custom Taxonomy

register_taxonomy("projet-file-type", array("projet"), array("hierarchical" => true, "label" => "Catégories de projet", "singular_label" => "Catégorie de projet", "rewrite" => true));
register_taxonomy("projet-file-tag", array("projet"), array("hierarchical" => false, "label" => "Tags de projet", "singular_label" => "Tag de projet", "rewrite" => true));

// Creating the Custom Field Box

add_action("admin_init", "projet_meta_box");   

function projet_meta_box(){
    add_meta_box("projInfo-meta", "Options du projet", "projet_meta_options", "projet", "side", "low");
}  

function projet_meta_options(){
        global $post;
        if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return $post_id;
        $custom = get_post_custom($post->ID);
        $link = $custom["projLink"][0];
?>
    <label>Link:</label><input name="projLink" value="<?php echo $link; ?>" />
<?php
    }

// Saving the Custom Data

add_action('save_post', 'save_projet_link'); 

function save_projet_link(){
    global $post;  

    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ){
		return $post_id;
	}else{
    	update_post_meta($post->ID, "projLink", $_POST["projLink"]);
    }
}

// Customizing Admin Columns

add_filter("manage_edit-projet_columns", "projet_edit_columns");   

function projet_edit_columns($columns){
        $columns = array(
            "cb" => "<input type=\"checkbox\" />",
            "title" => "Nom du projet",
            "description" => "Description",
            "link" => "Link",
            "type" => "Catégorie de projet",
        );  

        return $columns;
}  

add_action("manage_posts_custom_column",  "projet_custom_columns"); 

function projet_custom_columns($column){
        global $post;
        switch ($column)
        {
            case "description":
                the_excerpt();
                break;
            case "link":
                $custom = get_post_custom();
                echo $custom["projLink"][0];
                break;
            case "type":
               // echo get_the_term_list($post->ID, 'project-type', '', ', ','');
                break;
        }
}  




?>