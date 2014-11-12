<?php

// Creating a New Post Type

add_action('init', 'customtype_register');  

function customtype_register() {
    $args = array(
        'label' => __('TypesPersos'),
        'singular_label' => __('TypePerso'),
        'public' => true,
        'show_ui' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'rewrite' => false,
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'comments')//, 'comments', 'author', )
       );  

    register_post_type( 'customtype' , $args );
}

// Adding a Custom Taxonomy

register_taxonomy("customtype-file-type", array("customtype"), array("hierarchical" => true, "label" => "Catégories de customtype", "singular_label" => "Catégorie de customtype", "rewrite" => true));
register_taxonomy("customtype-file-tag", array("customtype"), array("hierarchical" => false, "label" => "Tags de customtype", "singular_label" => "Tag de customtype", "rewrite" => true));

// Creating the Custom Field Box

add_action("admin_init", "customtype_meta_box");   

function customtype_meta_box(){
    add_meta_box("projInfo-meta", "Options du customtype", "customtype_meta_options", "customtype", "side", "low");
}  

function customtype_meta_options(){
        global $post;
        if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return $post_id;
        $custom = get_post_custom($post->ID);
        $link = $custom["customtypedata"][0];
?>
    <label>Link:</label><input name="customtypedata" value="<?php echo $link; ?>" />
<?php
    }

// Saving the Custom Data

add_action('save_post', 'save_customtype_customdata'); 

function save_customtype_customdata(){
    global $post;  

    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ){
		return $post_id;
	}else{
    	update_post_meta($post->ID, "customtypedata", $_POST["customtypedata"]);
    }
}

// Customizing Admin Columns

add_filter("manage_edit-customtype_columns", "customtype_edit_columns");   

function customtype_edit_columns($columns){
        $columns = array(
            "cb" => "<input type=\"checkbox\" />",
            "title" => "Nom du customtype",
            "description" => "Description",
            "customdata" => "Customdata",
            "type" => "Catégorie de customtype",
        );  

        return $columns;
}  

add_action("manage_posts_custom_column",  "customtype_custom_columns"); 

function customtype_custom_columns($column){
        global $post;
        switch ($column)
        {
            case "description":
                the_excerpt();
                break;
            case "customdata":
                $custom = get_post_custom();
                echo $custom["customtypedata"][0];
                break;
            case "type":
                echo get_the_term_list($post->ID, 'customtype-file-type', '', ', ','');
                break;
        }
}  




?>