<?php

add_action('init', 'unid_add_default_boxes');
function unid_add_default_boxes($custom_types_to_activate=false) {
	if($custom_types_to_activate!=false) {
	foreach($custom_types_to_activate as $key=>$val) {
	    register_taxonomy_for_object_type('post_tag', $val);
	}
	}
}

?>