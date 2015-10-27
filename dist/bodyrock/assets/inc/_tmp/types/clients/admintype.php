<?php

// Customizing Admin Columns
add_filter("manage_clients_posts_columns", "clients_edit_columns");   
add_filter("request", "clients_date_column_orderby" );

function clients_edit_columns($columns){

	if($_GET['order']=='desc' && $_GET['orderby']=='clientstartDate') {
		$col_clientstartDate = '<a href="http://unicolored.com/wp-admin/edit.php?post_type=clients&amp;orderby=clientstartDate&amp;order=asc"><span>StartDate</span><span class="sorting-indicator"></span></a>';
	}
	else $col_clientstartDate = '<a href="http://unicolored.com/wp-admin/edit.php?post_type=clients&amp;orderby=clientstartDate&amp;order=desc"><span>StartDate</span><span class="sorting-indicator"></span></a>';
	$columns['clientstartDate'] = $col_clientstartDate;

	if($_GET['order']=='desc' && $_GET['orderby']=='clientendDate') {
		$col_clientendDate = '<a href="http://unicolored.com/wp-admin/edit.php?post_type=clients&amp;orderby=clientendDate&amp;order=asc"><span>EndDate</span><span class="sorting-indicator"></span></a>';
	}
	else $col_clientendDate = '<a href="http://unicolored.com/wp-admin/edit.php?post_type=clients&amp;orderby=clientendDate&amp;order=desc"><span>EndDate</span><span class="sorting-indicator"></span></a>';
	$columns['clientendDate'] = $col_clientendDate;
	
	
	unset($columns['tags']);
	
    return $columns;
}

add_action("manage_clients_posts_custom_column",  "client_custom_columns"); 

function client_custom_columns($column){
        global $post;
        switch ($column)
        {
            case "clientstartDate":
                $custom = get_post_custom();
                echo $custom["clientstartDate"][0];
                break;
			case "clientendDate":
                $custom = get_post_custom();
                echo $custom["clientendDate"][0];
                break;
        }
}  

function clients_date_column_orderby( $vars ) {
    if ( isset( $vars['orderby'] ) && 'clientstartDate' == $vars['orderby'] ) {
        $vars = array_merge( $vars, array(
            'meta_key' => 'clientstartDate',
            'orderby' => 'meta_value_num'
        ) );
    }
	if ( isset( $vars['orderby'] ) && 'clientendDate' == $vars['orderby'] ) {
        $vars = array_merge( $vars, array(
            'meta_key' => 'clientendDate',
            'orderby' => 'meta_value_num'
        ) );
    }
    return $vars;
}

/*
add_filter("manage_edit-clients_sortable_columns", "client_date_column_register_sortable");
add_filter("request", "client_date_column_orderby" );

function client_date_column_register_sortable( $columns ) {
        $columns['clientstartDate'] = 'clientstartDate';
        return $columns;
}

function client_date_column_orderby( $vars ) {
    if ( isset( $vars['orderby'] ) && 'clientstartDate' == $vars['orderby'] ) {
        $vars = array_merge( $vars, array(
            'meta_key' => 'clientstartDate',
            'orderby' => 'meta_value_num'
        ) );
    }
    return $vars;
}
*/
?>