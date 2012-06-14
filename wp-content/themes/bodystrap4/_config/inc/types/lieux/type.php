<?php
// Creating a New Post Type
register_post_type(
'lieux',
array(
'label' => 'Lieux',
'description' => '',
'public' => true,
'show_ui' => true,
'show_in_menu' => true,
'capability_type' => 'post',
'hierarchical' => true,
'rewrite' => array('slug' => ''),
'query_var' => true,
'has_archive' => true,
'supports' => array('title','editor','excerpt','comments','revisions','thumbnail','author'),
'taxonomies' => array('category', 'post_tag'),

'labels' => array (
  'name' => 'Lieux',
  'singular_name' => 'Lieu',
  'menu_name' => 'Lieux',
  'add_new' => 'Add Lieu',
  'add_new_item' => 'Add New Lieu',
  'edit' => 'Edit',
  'edit_item' => 'Edit Lieu',
  'new_item' => 'New Lieu',
  'view' => 'View Lieu',
  'view_item' => 'View Lieu',
  'search_items' => 'Search Lieux',
  'not_found' => 'No Lieux Found',
  'not_found_in_trash' => 'No Lieux Found in Trash',
  'parent' => 'Parent Lieu',
),) );

?>