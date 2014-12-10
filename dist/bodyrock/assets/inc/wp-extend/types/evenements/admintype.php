<?php

// Customizing Admin Columns
add_filter("manage_evenements_posts_columns", "evenements_edit_columns");   
add_filter("request", "evenements_date_column_orderby" );

function evenements_edit_columns($columns){

	if($_GET['order']=='desc' && $_GET['orderby']=='eventstartDate') {
		$col_eventstartDate = '<a href="http://unicolored.com/wp-admin/edit.php?post_type=evenements&amp;orderby=eventstartDate&amp;order=asc"><span>StartDate</span><span class="sorting-indicator"></span></a>';
	}
	else $col_eventstartDate = '<a href="http://unicolored.com/wp-admin/edit.php?post_type=evenements&amp;orderby=eventstartDate&amp;order=desc"><span>StartDate</span><span class="sorting-indicator"></span></a>';
	$columns['eventstartDate'] = $col_eventstartDate;

	if($_GET['order']=='desc' && $_GET['orderby']=='eventendDate') {
		$col_eventendDate = '<a href="http://unicolored.com/wp-admin/edit.php?post_type=evenements&amp;orderby=eventendDate&amp;order=asc"><span>EndDate</span><span class="sorting-indicator"></span></a>';
	}
	else $col_eventendDate = '<a href="http://unicolored.com/wp-admin/edit.php?post_type=evenements&amp;orderby=eventendDate&amp;order=desc"><span>EndDate</span><span class="sorting-indicator"></span></a>';
	$columns['eventendDate'] = $col_eventendDate;
	
	
	unset($columns['tags']);
	
    return $columns;
}

add_action("manage_evenements_posts_custom_column",  "evenement_custom_columns"); 

function evenement_custom_columns($column){
        global $post;
        switch ($column)
        {
            case "eventstartDate":
                $custom = get_post_custom();
                echo $custom["eventstartDate"][0];
                break;
			case "eventendDate":
                $custom = get_post_custom();
                echo $custom["eventendDate"][0];
                break;
        }
}  

function evenements_date_column_orderby( $vars ) {
    if ( isset( $vars['orderby'] ) && 'eventstartDate' == $vars['orderby'] ) {
        $vars = array_merge( $vars, array(
            'meta_key' => 'eventstartDate',
            'orderby' => 'meta_value_num'
        ) );
    }
	if ( isset( $vars['orderby'] ) && 'eventendDate' == $vars['orderby'] ) {
        $vars = array_merge( $vars, array(
            'meta_key' => 'eventendDate',
            'orderby' => 'meta_value_num'
        ) );
    }
    return $vars;
}

/*
add_filter("manage_edit-evenements_sortable_columns", "event_date_column_register_sortable");
add_filter("request", "event_date_column_orderby" );

function event_date_column_register_sortable( $columns ) {
        $columns['eventstartDate'] = 'eventstartDate';
        return $columns;
}

function event_date_column_orderby( $vars ) {
    if ( isset( $vars['orderby'] ) && 'eventstartDate' == $vars['orderby'] ) {
        $vars = array_merge( $vars, array(
            'meta_key' => 'eventstartDate',
            'orderby' => 'meta_value_num'
        ) );
    }
    return $vars;
}
*/
?>