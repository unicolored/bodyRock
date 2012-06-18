<?php
// Creating a New Post Type
register_post_type(
'evenements',
array(
'label' => 'Evènements',
'description' => '',
'public' => true,
'show_ui' => true,
'show_in_menu' => true,
'capability_type' => 'post',
'hierarchical' => true,
'rewrite' => array('slug' => ''),
'query_var' => true,
'has_archive' => true,
'supports' => array('title','editor','excerpt','comments','revisions','thumbnail','author','page-attributes',),
'taxonomies' => array('category', 'post_tag'),

'labels' => array (
  'name' => 'Evènements',
  'singular_name' => 'Evènement',
  'menu_name' => 'Evènements',
  'add_new' => 'Add Evènement',
  'add_new_item' => 'Add New Evènement',
  'edit' => 'Edit',
  'edit_item' => 'Edit Evènement',
  'new_item' => 'New Evènement',
  'view' => 'View Evènement',
  'view_item' => 'View Evènement',
  'search_items' => 'Search Evènements',
  'not_found' => 'No Evènements Found',
  'not_found_in_trash' => 'No Evènements Found in Trash',
  'parent' => 'Parent Evènement',
),) );

?>