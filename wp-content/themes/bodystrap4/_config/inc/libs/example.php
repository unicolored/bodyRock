<?php

/*
  Here's a couple of metaboxes that I've recently created using this system
*/


$subpostings = redrokk_metabox_class::getInstance('subpostings', array(
	'title'			=> '(optional) Subscription for Postings',
	'description'	=> "As an optional feature, you have a complete api at your disposal which will allow you the ability to offer and manage member posts. In addition to these settings, you may need to create the associated pages for accepting posts from your frontend.",
	'_object_types'	=> 'page',
	'priority'		=> 'high',


		     //this combination allows you to include the metabox on a single post, 
		     //or exclude a single post
			'include_exclude' => false,
			'object_ids'	=> 306,
			

	'_fields'		=> array(
			array(
				'name' 	=> 'Maximum Posts',
				'id' 	=> 'max_posts',
				'type' 	=> 'text',
				'class'	=> 'small-text',
				'desc'	=> "The maximum number of posts that this subscriber is allowed to make.
						<br/>-1 allows an infinite number of posts
						<br/> 0 does not allow the subscriber to post",
				'default' => '0',
			),
		array(
			'name' 	=> 'New Posting Defaults',
			'type' 	=> 'title',
		),
			array(
				'name' 	=> 'New Post Email',
				'id' 	=> 'new_post_email',
				'type' 	=> 'checkbox',
				'desc'	=> "Would you like an email when a subscriber makes a new post?"
			),
			array(
				'name' 	=> 'Post Type',
				'id' 	=> 'postnew__post_type',
				'type' 	=> 'post_type',
			),
			array(
				'name' 	=> 'New Post Status',
				'id' 	=> 'postnew__post_status',
				'type' 	=> 'post_status',
				'desc'	=> "When a subscriber makes a new post it will have this status",
			),
			array(
				'name' 	=> 'Default Category',
				'id' 	=> 'postnew__post_category',
				'type' 	=> 'category',
			),
			array(
				'name' 	=> 'Tagged with',
				'id' 	=> 'postnew__tags_input',
				'type' 	=> 'text',
				'desc'	=> "Leave a comma deliminated list of tags to add to new member posts"
			),
		array(
			'name' 	=> 'Edit Posting Defaults',
			'type' 	=> 'title',
		),
			array(
				'name' 	=> 'Edit Post Email',
				'id' 	=> 'edit_post_email',
				'type' 	=> 'checkbox',
				'desc'	=> "Would you like an email when a subscriber makes an edit?"
			),
			array(
				'name' 	=> 'Can User Edit?',
				'id' 	=> 'can_user_edit',
				'type' 	=> 'checkbox',
				'desc'	=> "Leaving unchecked will not allow users to edit their posts"
			),
			array(
				'name' 	=> 'Edit Post Status',
				'id' 	=> 'postedit__post_status',
				'type' 	=> 'post_status',
				'desc'	=> "When a subscriber edits their posts, this will be the new status",
			),
			array(
				'name' 	=> 'Tagged with',
				'id' 	=> 'postedit__tags_input',
				'type' 	=> 'text',
				'desc'	=> "Leave a comma deliminated list of tags to add to new member posts"
			),
		)
	));

$subroles = redrokk_metabox_class::getInstance('subroles', array(
	'title'			=> '(optional) Role Management',
	'description'	=> "As an optional feature, you can use these settings to manage the users roles during certain subscription triggers.",
	'_object_types'	=> $sub,
	'priority'		=> 'high',
	'_fields'		=> array(
			array(
				'name' 	=> 'Role',
				'id' 	=> 'role',
				'type' 	=> 'role',
				'desc'	=> "New subscribers will be assigned to this role.",
			),
			array(
				'name' 	=> 'Expired to Role',
				'id' 	=> 'downgrade_role',
				'type' 	=> 'role',
				'desc'	=> "Terminated subscriptions will be assigned to this role.",
			),
		)
	));
	
$subdisplay = redrokk_metabox_class::getInstance('subdisplay', array(
	'title'			=> 'Subscription Listing Preview',
	'_object_types'	=> 'post',
	'priority'		=> 'default',
	'callback'		=> 'ms_subdisplay', //use a valid callback to display a custom template
	));
	
function ms_subdisplay() { echo 'da'; }

$metabox = new redrokk_metabox_class();
//some example fields to use in  your form
$metabox->set('_fields', array(
			array(
				'name' 	=> 'Title',
				'type' 	=> 'title',
			),
			array(
				'name' 	=> 'Title',
				'desc' 	=> '',
				'id' 	=> 'title',
				'type' 	=> 'text',
				'std' 	=> ''
			),
			array(
				'name' 	=> 'image',
				'desc' 	=> '',
				'id' 	=> 'imagefile',
				'type' 	=> 'image',
				'std' 	=> ''
			),
			array(
				'name' 	=> 'Textarea',
				'desc' 	=> 'Enter big text here',
				'id' 	=> 'textarea_id',
				'type' 	=> 'textarea',
				'std' 	=> 'Default value 2'
			),
			array(
				'name'  => 'Select box',
				'id'	=> 'select_id',
				'type'  => 'select',
				'options'=> array(
					'value1' => 'Value 1',
					'value2' => 'Value 2',
					'value3' => 'Value 3',
					'value4' => 'Value 4',
				)
			),
			array(
				'name' 	=> 'Radio',
				'id' 	=> 'radio_id',
				'type' 	=> 'radio',
				'value' => 'test',
				'desc' 	=> 'Check this box if you want its value saved',
			),
			array(
				'name' 	=> '',
				'id' 	=> 'radio_id', 
				'type' 	=> 'radio',
				'value' => 'test2',
				'desc' 	=> 'Check this box if you want its value saved',
			),
			array(
				'name' 	=> 'Checkbox',
				'id' 	=> 'checkbox_id',
				'type' 	=> 'checkbox',
				'desc' 	=> 'Check this box if you want its value saved',
			),
		));
		
