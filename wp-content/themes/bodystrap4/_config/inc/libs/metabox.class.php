<?php 
/**
 * @Author	Anonymous
 * @link http://www.redrokk.com
 * @Package Wordpress
 * @SubPackage RedRokk Library
 * @copyright  Copyright (C) 2011+ Redrokk Interactive Media
 * 
 * @version 2.0
 */

//security
defined('ABSPATH') or die('You\'re not supposed to be here.');

/**
 * 
 * 
 * @author Anonymous
 * @example

	$gallery = redrokk_metabox_class::getInstance('gallery', array(
		     'title'		=> 'My first metabox',
		     '_object_types'	=> 'page',
		     'priority'		=> 'default',
		     
		     //this combination allows you to include the metabox on a single post, 
		     //or exclude a single post
			'include_exclude' => true,
			'object_ids'	=> 306,
			
		));
	$gallery->set('_fields', array(
					array(
						'name' 	=> 'New Image',
						'type' 	=> 'title',
					),
					array(
						'name' 	=> 'Image Title',
						'id' 	=> $this->_id.'_post_title',
						'type' 	=> 'text',
					),
					array(
						'name' 	=> 'Description',
						'id' 	=> $this->_id.'_post_content',
						'type' 	=> 'textarea',
					),
					array(
						'name' 	=> 'Image File',
						'id' 	=> $this->_id.'_image',
						'type' 	=> 'image',
					),
					array(
						'name' 	=> 'Save Image',
						'type' 	=> 'submit',
					),
				));
 */
class redrokk_metabox_class
{
	/**
	 * HTML 'id' attribute of the edit screen section
	 * 
	 * @var string
	 */
	var $_id;
	
	/**
	 * used in conjunction with the includes parameter
	 * 
	 * @var array
	 */
	var $object_ids;
	
	/**
	 * true		will include this metabox only for the given object ids
	 * false	will exclude
	 * 
	 * @var boolean
	 */
	var $include_exclude;
	
	/**
	 * Save the form fields here that will be displayed to the user
	 * 
	 * @var array
	 */
	var $_fields;
	
	/**
	 * Title of the edit screen section, visible to user
	 * Default: None
	 * 
	 * @var string
	 */
	var $title;
	
	/**
	 * 
	 * 
	 * @var string
	 */
	var $description;
	
	/**
	 * Function that prints out the HTML for the edit screen section. Pass 
	 * function name as a string. Within a class, you can instead pass an 
	 * array to call one of the class's methods. See the second example under 
	 * Example below.
	 * Default: None
	 * 
	 * @var callback
	 */
	var $callback = null;
	
	/**
	 * The part of the page where the edit screen section should be shown 
	 * ('normal', 'advanced', or 'side'). (Note that 'side' doesn't exist before 2.7)
	 * Default: 'advanced'
	 * 
	 * @var string
	 */
	var $context = 'advanced';
	
	/**
	 * The priority within the context where the boxes should show 
	 * ('high', 'core', 'default' or 'low')
	 * Default: 'default'
	 * 
	 * @var string
	 */
	var $priority = 'default';
	
	/**
	 * Arguments to pass into your callback function. The callback will receive the 
	 * $post object and whatever parameters are passed through this variable.
	 * Default: null
	 * 
	 * @var array
	 */
	var $callback_args;
	
	/**
	 * Prebuilt metaboxes can be activated by using this type
	 * Default: default
	 * 
	 * (options:)
	 * default
	 * images
	 * 
	 * @var string
	 */
	var $_type;
	
	/**
	 * 
	 * @var unknown_type
	 */
	var $_category_name;
	
	/**
	 * The type of Write screen on which to show the edit screen section 
	 * ('post', 'page', 'link', or 'custom_post_type' where custom_post_type 
	 * is the custom post type slug)
	 * Default: None
	 * 
	 * @var array
	 */
	var $_object_types = array();
	
	/**
	 * Constructor.
	 * 
	 */
	function __construct( $options = array() )
	{
		//initializing
		$this->setProperties($options);
		if (!$this->callback) {
			$this->callback = array(&$this, 'show');
		}
		if (!$this->title) {
			$this->title = ucfirst($this->_id);
		}
		
		//registering this metabox
		add_action( 'add_meta_boxes', array(&$this, '_register') );
		add_action( 'plugins_loaded', array(&$this, 'setType') );
		
		// backwards compatible (before WP 3.0)
		// add_action( 'admin_init', array($this, '_register'), 1 );
		
		add_action( 'save_post', array(&$this, '_save') );
		add_filter( 'wp_redirect', array(&$this, '_redirectIntervention'), 40, 1 );
	}
	
	/**
	 * Method will save the posted content as an image attachment
	 * 
	 */
	function saveAsAttachment( $source, $post_id )
	{
		if (empty($_FILES) || !isset($_REQUEST[$this->_id.'files'])) return false;
		
		// initializing
		$property = $_REQUEST[$this->_id.'files'];
		$post_data = array();
		
		if (isset($source[$this->_id.'_post_title'])) {
			$post_data['post_title'] = $source[$this->_id.'_post_title'];
		}
			
		if (isset($source[$this->_id.'_post_content'])) {
			$post_data['post_content'] = $source[$this->_id.'_post_content'];
		}
		
		$id = media_handle_upload($property, $post_id, $post_data);
		
		$type = 'post';
		if (!$this->getCurrentPostType()) {
			$type = $this->_table;
		}
		
		//saving the attachment ID to the taxonomy
		if ($type != 'post') {
			$old = get_metadata($type, $post_id, $property, true);
			if ($id && $id != $old) {
				wp_delete_attachment( $old, true );
	    		update_metadata($type, $post_id, $property, $id);
	    	}
		}
    	
		foreach ((array)$source as $property => $new)
		{
			//skip everything but the specially prefixed
			if (strpos($property, $this->_id) !== 0) continue;
			if (in_array($property, array(
					$this->_id.'_post_title',
					$this->_id.'_post_content',
				))) continue;
			
			$old = get_metadata($type, $id, $property, true);
			if ($new && $new != $old) {
    			update_metadata($type, $id, $property, $new);
    		}
    		elseif (!$new) {
    			delete_metadata($type, $id, $property, $old);
    		}
		}
		
		return true;
	}
	
	/**
	 * Method saves the data provided as post meta values
	 * 
	 * @param array $source
	 * @param integer $post_id
	 */
	function saveAsPostMeta( $source, $post_id )
	{
		$type = 'post';
		if (!$this->getCurrentPostType()) {
			$type = $this->_table;
		}
		
		//save as a file
		//if there's no FILES then we save as a meta
		if (!$this->saveAsAttachment( $source, $post_id )) {
			
			//get the ID of this meta set
			if (isset($source[$this->_id.'_metaid']) && $source[$this->_id.'_metaid']) {
				$id = $source[$this->_id.'_metaid'];
			}
			else {
				if (!$id = get_metadata($type, $post_id, '_metaidlast', true)) {
					$id = 0;
				}
				$id++;
				update_metadata($type, $post_id, '_metaidlast', $id);
			}
			
			foreach ((array)$source as $property => $new)
			{
				//skip everything but the specially prefixed
				if (strpos($property, $this->_id) !== 0) continue;
				
				//each meta set has it's own ID
				$property = str_replace($this->_id, $this->_category_name.'_'.$id, $property);
				
				$old = get_metadata($type, $post_id, $property, true);
				if ($new && $new != $old) {
	    			update_metadata($type, $post_id, $property, $new);
	    		}
	    		elseif (!$new) {
	    			delete_metadata($type, $post_id, $property, $old);
	    		}
			}
		}
		
		foreach ((array)$source as $property => $new)
		{
			//skip special properties that are prefixed with the id
			if (strpos($property, $this->_id) === 0) continue;
			
			$old = get_metadata($type, $post_id, $property, true);
			if ($new && $new != $old) {
    			update_metadata($type, $post_id, $property, $new);
    		}
    		elseif (!$new) {
    			delete_metadata($type, $post_id, $property, $old);
    		}
		}
		return true;
	}
	
	/**
	 * Do something with the data entered
	 * 
	 * @param integer $post_id
	 */
	function _save( $post_id )
	{
		//initializing
		$post = get_post($post_id);
		
		// verify if this is an auto save routine. 
		// If it is our form has not been submitted, so we dont want to do anything
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
			return;
		
		// verify this came from the our screen and with proper authorization,
		// because save_post can be triggered at other times
		if ( !isset($_REQUEST[ get_class().$this->_id ]) )
			return;
		
		if ( !wp_verify_nonce( $_REQUEST[ get_class().$this->_id ], plugin_basename( __FILE__ ) ) )
			return;
			
		// this metabox is to be displayed for a certain object type only
		if ( !in_array($post->post_type, $this->_object_types) )
			return;
		
		// Check permissions
		if ( 'page' == $post->post_type ) 
		{
			if ( !current_user_can( 'edit_page', $post->ID ) )
				return;
		}
		else
		{
			if ( !current_user_can( 'edit_post', $post->ID ) )
				return;
		}
		
		//saving the request data
		do_action('metabox-save-'.$this->_id, $this->getRequestPostMetas(), $post->ID );
		return true;
	}
	
	/**
	 * Display the inner contents of the metabox
	 * 
	 * @param object $post
	 */
	function show( $post )
	{
		// Use nonce for verification
  		wp_nonce_field( plugin_basename( __FILE__ ), get_class().$this->_id );
  		do_action('metabox-show-'.$this->_id, $this->_fields, $this);
	}
	
	/**
	 * Method displays a list of attached images
	 * 
	 */
	function _renderListImageAttachments()
	{
		global $post, $current_screen;
		$images =& get_children( "post_parent=$post->ID&post_type=attachment&post_mime_type=image" );
		
		// no images to render
		if (empty($images)) {
			?><p>No images have been saved.</p><?php 
			
		// rendering the images
		} else {
			
			?>
		<table class="wp-list-table  form-table widefat" style="border:none;">
			<?php foreach ((array)$images as $post_id => $image): ?>
			<?php $image_attributes = wp_get_attachment_image_src( $image->ID, 'thumbnail' ); ?>
			<tbody id="the-list">
			<tr>
				<th scope="row" style="width: 140px">
					<div style="padding:10px;background:whiteSmoke;">
						<img src="<?php echo wp_get_attachment_thumb_url( $image->ID ); ?>" /></div>
				</th>
				<td>
					<b><?php echo $image->post_title; ?></b>
					<p><?php echo get_the_content($image->ID); ?></p>
					
					<div class="row-actions">
						<span class="inline">
							<a href="<?php echo wp_nonce_url( 
												"media.php?attachment_id=$image->ID"
												."&action=edit&_redirect="
												.urlencode( $this->_currentPageURL() )
												); ?>">
							Edit</a> |
						</span>
						<span class="trash">
							<a 	class="submitdelete" 
								onclick="return showNotice.warn();"
								href="<?php echo wp_nonce_url( 
												"post.php?action=delete&_redirect="
												.urlencode( $this->_currentPageURL() )
												."&amp;post=$image->ID", 
												'delete-attachment_' . $image->ID ); ?>">
							Delete Permanently</a> |
						</span>
						<span class="inline">
							<a 	target="_blank" 
								href="<?php echo get_attachment_link($image->ID); ?>">
							View</a>
						</span>
					</div>
					</td>
			</tr>
			</tbody>
			<?php endforeach; ?>
		</table>
			<?php 
		}
		return;
	}
	
	/**
	 * Function removes a specific category meta
	 * 
	 * @param string $category
	 * $param string $meta_id
	 * $param object $post
	 */
	public static function deleteMetaListing( $category, $meta_id, $post = null )
	{
		// initializing
		if ($post === NULL) {
			global $post;
		}
		$listings = redrokk_metabox_class::getMetaListings( $category, $post );
		if (!isset($listings[$meta_id])) return false;
		
		$type = 'post';
		
		foreach((array)$listings[$meta_id] as $property => $value) {
			$pro = $category.'_'.$meta_id.'_'.$property;
			delete_metadata($type, $post->ID, $pro, $value[0]); 
		}
		return true;
	}
	
	/**
	 * Method displays a list of meta attachments
	 *  
	 */
	function _renderListAttachments()
	{
		global $post;
		
		//delete action prior to pulling new listings
		if (isset($_REQUEST['redrokkdelete']) && $_REQUEST['redrokkdelete']) {
			redrokk_metabox_class::deleteMetaListing($this->_category_name, $_REQUEST['redrokkdelete'], $post);
		}
		
		//pull new listings
		$metaListings = redrokk_metabox_class::getMetaListings($this->_category_name, $post);
		
		if (!empty($metaListings)) {
		?>
		<table class="wp-list-table form-table widefat" style="border:none;">
			<tbody id="the-list">
			<?php foreach ((array)$metaListings as $meta_id => $video): ?>
			<?php $video = apply_filters('redrokk_metabox_class::_renderListAttachments', $video, $meta_id);?>
			
			<tr id="<?php echo $this->_category_name; ?>_<?php echo $meta_id; ?>">
				<th scope="row" style="width: 140px">
					<div style="padding:10px;background:whiteSmoke;">
						<?php if(isset($video['link'])) echo $video['link'][0]; ?>
					</div>
				</th>
				<td> 
					<b><?php if(isset($video['post_title'])) echo $video['post_title'][0]; ?></b>
					<p><?php if(isset($video['post_content'])) echo $video['post_content'][0]; ?></p>
					
					<div class="row-actions">
						<span class="inline"> 
							<a href="#" id="edit_<?php echo $this->_category_name; ?>_<?php echo $meta_id; ?>">
							Edit</a> |
						</span>
						<span class="trash">
							<a class="submitdelete" 
								onclick="return showNotice.warn();"
								href="<?php echo site_url( "wp-admin/post.php?post={$post->ID}"
												."&action=edit"
												."&redrokkdelete=$meta_id"
												); ?>">
							Delete Permanently</a>
						</span>
					</div>
<script>
jQuery('#edit_<?php echo $this->_category_name; ?>_<?php echo $meta_id; ?>').click(function(){
	var data = {
	<?php 
		$data = array();
		
		//making sure all fields will be cleared
		foreach ((array)$this->_fields as $field) {
			if (!isset($field['id']) || !isset($field['type'])) continue; 
			if (!in_array($field['type'], array('text','file','image','textarea','hidden')))
				continue;
			
			$id = str_replace($this->_id.'_', '', $field['id']);
			$data[$id] = "'$id':''";
		}
		
		//adding our values to the array
		foreach((array)$video as $vp => $vv)
		{
			if (isset($vv[0])) $vv = $vv[0];
			$data[$vp] = "'$vp':'$vv'";
		}
		
		//adding the meta ID to the array
		$data[$id] = "'metaid':'$meta_id'";
		
		echo implode(',',$data);
	?>
	};
	
	jQuery.each(data, function(key, value){
		jQuery('#<?php echo $this->_id; ?>_'+key).val( value );
	});
	return false;
});
</script>
				</td>
				<?php do_action('redrokk_metabox_class::_renderListAttachments::rows', $video, $meta_id, $this); ?>
			</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
		<?php 
		}
		
	}
	
	/**
	 * Method displays a list of attached videos
	 *  
	 */
	function _renderListVideoAttachments()
	{
		global $post;
		
		//pull new listings
		$videos =& get_children( "post_parent=$post->ID&post_type=attachment&post_mime_type=video/mp4" );
		
		// no images to render
		if (!empty($videos)) {
		?>
		<table class="wp-list-table form-table widefat" style="border:none;">
			<tbody id="the-list">
			<?php foreach ((array)$videos as $post_id => $video): ?>
			<?php $image_attributes = wp_get_attachment_link( $video->ID ); ?>
			<tr>
				<th scope="row" style="width: 140px">
					<div style="padding:10px;background:whiteSmoke;">
						<?php echo $image_attributes; ?>
					</div>
				</th>
				<td>
					<b><?php echo $video->post_title; ?></b>
					<p><?php echo get_the_content($video->ID); ?></p>
					
					<div class="row-actions">
						<span class="inline">
							<a href="<?php echo wp_nonce_url( 
												"media.php?attachment_id=$meta_id"
												."&action=edit&_redirect="
												.urlencode( $this->_currentPageURL() )
												); ?>">
							Edit</a> |
						</span>
						<span class="trash">
							<a class="submitdelete" 
								onclick="return showNotice.warn();"
								href="<?php echo wp_nonce_url( 
												"post.php?action=delete&_redirect="
												.urlencode( $this->_currentPageURL() )
												."&amp;post=$video->ID", 
												'delete-attachment_' . $video->ID ); ?>">
							Delete Permanently</a>
						</span>
					</div>
					</td>
			</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
		<?php 
		}
	}
	
	/**
	 * Method renders the form from any source
	 * 
	 * @param array $fields
	 */
	function _renderForm( $fields = array() )
	{
		//initializing
		global $post;
		$defaults = array(
			'name' 	=> '',
			'desc' 	=> '',
			'id' 	=> '',
			'type' 	=> 'text',
			'options'=> array(),
			'default'=> '',
			'value'=> '',
			'class'=> '',
			'multiple'=> '',
		);
		
		
		// no fields to render
		if (empty($fields)) {
			?>
		<p>No form fields have been defined. Use <pre>
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
		));</pre>
		</p>
			<?php 
			
		// rendering the fields
		} else {
		?>
		<table class="form-table">
			<?php if ($this->description): ?>
			<tr id="metabox_description">
				<th scope="row" colspan=2>
					<p class="description"><?php echo $this->description; ?></p>
				</th>
			</tr>
			<?php endif; ?>
			
			<?php foreach ((array)$fields as $field): ?>
			
			<?php extract(wp_parse_args($field, $defaults)); ?>
			<?php $id = sanitize_title($id); ?>
			<?php $meta = get_post_meta($post->ID, $id, true); ?>
			
			<?php switch ($type){ default: ?>
			<?php case 'text': ?>
			<tr id="row_<?php echo $id; ?>">
				<th scope="row" style="width: 140px">
					<label for="<?php echo $id; ?>"><?php echo $name; ?></label></th>
				<td><input 
					id="<?php echo $id; ?>" 
					value="<?php echo $meta ?$meta :$default; ?>" 
					type="<?php echo $type; ?>" 
					name="<?php echo $id; ?>" 
					class="text large-text <?php echo $class; ?>" />
					<span class="description"><?php echo $desc; ?></span>
					</td>
			</tr>
			<?php break; ?>
			<?php case 'submit': ?>
			<?php case 'button': ?>
			<tr id="row_<?php echo $id; ?>">
				<td colspan="2"><input 
					id="<?php echo $id; ?>" 
					value="<?php echo $name; ?>" 
					type="submit" 
					name="submit" 
					class="button-primary <?php echo $class; ?>" />
					<span class="description"><?php echo $desc; ?></span>
					</td>
			</tr>
			<?php break; ?>
			<?php case 'file': ?>
			<?php case 'image': ?>
			<tr id="row_<?php echo $id; ?>">
				<th scope="row" style="width: 140px">
					<label for="<?php echo $id; ?>"><?php echo $name; ?></label></th>
				<td>
				<input type="hidden" name="<?php echo $this->_id; ?>files" value="<?php echo $id; ?>" />
				<!-- first hidden input forces this item to be submitted when it is not checked -->
				<input 
					id="<?php echo $id; ?>" 
					type="file" 
					name="<?php echo $id; ?>" 
					onChange="document.getElementById('post').enctype = 'multipart/form-data';"
					class="<?php echo $class; ?>" />
					<span class="description"><?php echo $desc; ?></span>
					</td>
			</tr>
			<?php break; ?>
			<?php case 'title': ?>
			<tr id="row_<?php echo sanitize_title($name); ?>">
				<th colspan="2" scope="row">
					<h3 style="border: 1px solid #ddd;
						padding: 10px;
						background: #eee;
						border-radius: 2px;
						color: #666;
						margin: 0;"><?php echo $name; ?></h3>
					<p><?php echo $desc; ?></p>
				</th>
			</tr>
			<?php break; ?>
			<?php case 'checkbox': ?>
			<?php $value = ($value) ?$value :'on'; ?>
			<tr id="row_<?php echo $id; ?>">
				<th scope="row" style="width: 140px">
					<label for="<?php echo $id; ?>"><?php echo $name; ?></label></th>
				<td>
				<input type="hidden" name="<?php echo $id; ?>" value="" />
				<!-- first hidden input forces this item to be submitted when it is not checked -->
				<input 
					value="<?php echo $value; ?>" 
					type="<?php echo $type; ?>" 
					name="<?php echo $id; ?>" 
					<?php echo $meta && $meta == $value || (!$meta && $default) ?'checked="checked"' :''; ?>
					class="<?php echo trim($id.' '.$class); ?>" />
					<span class="description"><?php echo $desc; ?></span>
					</td>
			</tr>
			<?php break; ?>
			<?php case 'radio': ?>
			<?php $value = ($value) ?$value :'on'; ?>
			<tr id="row_<?php echo $id; ?>">
				<th scope="row" style="width: 140px">
					<label for="<?php echo $id; ?>"><?php echo $name; ?></label></th>
				<td><input 
					value="<?php echo $value; ?>" 
					type="<?php echo $type; ?>" 
					name="<?php echo $id; ?>" 
					<?php echo $meta && $meta == $value || (!$meta && $default) ?'checked="checked"' :''; ?>
					class="<?php echo trim($id.' '.$class); ?>" />
					<span class="description"><?php echo $desc; ?></span>
					</td>
			</tr>
			<?php break; ?>
			<?php case 'textarea': ?>
			<tr id="row_<?php echo $id; ?>">
				<th scope="row" style="width: 140px">
					<label for="<?php echo $id; ?>"><?php echo $name; ?></label></th>
				<td><textarea 
					id="<?php echo $id; ?>" 
					name="<?php echo $id; ?>" 
					class="large-text <?php echo $class; ?>"
					><?php echo $meta ?$meta :$default; ?></textarea>
					<span class="description"><?php echo $desc; ?></span>
					</td>
			</tr>
			<?php break; ?>
			<?php case 'select': ?>
			<?php case 'currency': ?>
			<?php case 'country': ?>
			<?php case 'state': ?>
			<?php case 'states': ?>
			<?php case 'role': ?>
			<?php case 'roles': ?>
			<?php case 'page': ?>
			<?php case 'pages': ?>
			<?php case 'category': ?>
			<?php case 'post_type': ?>
			<?php case 'post_types': ?>
			<?php case 'post_status': ?>
			<?php case 'post_statuses': ?>
			<tr id="row_<?php echo $id; ?>">
				<th scope="row" style="width: 140px">
					<label for="<?php echo $id; ?>"><?php echo $name; ?></label>
				</th>
				<td>
				<?php if ($type == 'category'): ?>
					<?php 
					$defaults = array(
					    'show_option_all'    => 'All',
					    'show_option_none'   => 'None',
					    'orderby'            => 'ID', 
					    'order'              => 'ASC',
					    'show_count'         => 0,
					    'hide_empty'         => 0, 
					    'child_of'           => 0,
					    'exclude'            => '',
					    'echo'               => 1,
					    'selected'           => $meta?$meta:'',
					    'hierarchical'       => true, 
					    'name'               => $id,
					    'id'                 => $id,
					    'class'              => $class,
					    'depth'              => 0,
					    'tab_index'          => 1,
					    'taxonomy'           => 'category',
					    'hide_if_empty'      => false
					);
					if (!isset($args)) $args = array();
					$args = wp_parse_args($args, $defaults);
					
					wp_dropdown_categories($args);
					
					?>
				<?php else: ?>
					<select 
					id="<?php echo $id; ?>" 
					name="<?php echo $id; ?>" 
					class="<?php echo $class; ?>"
					<?php echo $multiple ?"MULTIPLE SIZE='$multiple'" :''; ?>>
					
					<?php if ($type == 'role' || $type == 'roles') $options = $this->getRoleOptions(); ?>
					<?php if ($type == 'post_type' || $type == 'post_types') $options = $this->getPostTypes(); ?>
					<?php if ($type == 'post_status' || $type == 'post_statuses') $options = $this->getPostTypeStatuses(); ?>
					<?php if ($type == 'country') $options = $this->getCountryOptions(); ?>
					<?php if ($type == 'currency') $options = $this->getCurrencyOptions(); ?>
					<?php if ($type == 'page' || $type == 'pages') $options = $this->getPageOptions(); ?>
					<?php if ($type == 'state' || $type == 'states') $options = $this->getStateOptions(); ?>
					
					<?php if (is_callable($options)) $options = $options(); ?>
					<?php if (is_string($options)): echo $options; ?>
					<?php else: foreach ((array)$options as $_value => $_name): ?>
					
						<option 
							value="<?php echo $_value; ?>"
							<?php echo $meta == $_value || (!$meta && $_value == $default) ?' selected="selected"' :''; ?>
							><?php echo $_name; ?></option>
						
					<?php endforeach; endif; ?></select>
				<?php endif; //$type == 'category' ?>
					<span class="description"><?php echo $desc; ?></span>
				</td>
			</tr>
			<?php break; ?>
			<?php case 'hidden': ?>
			<tr id="row_<?php echo $id; ?>">
				<td colspan="2">
				<input 
					id="<?php echo $id; ?>" 
					value="<?php echo $meta ?$meta :$default; ?>" 
					type="<?php echo $type; ?>" 
					name="<?php echo $id; ?>" 
					style="visibility:hidden;" />
				</td>
			</tr>
			<?php } ?>
			<?php endforeach; ?>
		</table>
		<?php 
		}
		return $this;
	}
	
	/**
	 * Adds a box to the main column on the Post and Page edit screens
	 * 
	 */
	function _register()
	{
		// this metabox is to be displayed for a certain object type only
		if ( !in_array($this->getCurrentPostType(), $this->_object_types) )
			return;
			
		if ( $this->object_ids && $this->include_exclude ) {
			$id_match = in_array($this->getCurrentPostID(), $this->getObjectIds());
			$include = $this->include_exclude;
			
			//exclude
			if ($id_match && !$include) return;
			//include
			if (!$id_match && $include) return;
		}
		
		if (!is_array($this->callback_args)) {
			$this->callback_args = array();
		}
		$this->callback_args[] = $this;
		
		add_meta_box( 
			$this->_id, 
			$this->title, 
			$this->callback, 
			$this->getCurrentPostType(), 
			$this->context, 
			$this->priority, 
			$this->callback_args
		);
	}
	
	/**
	 * Method properly prepares the metabox type by binding the necessary hooks
	 * 
	 * @param mixed $value
	 */
	function setType( $value = 'default' )
	{
		if (isset($this->_setType)) return false;
		
		// initializing
		$this->_setType = true;
		$this->_type = $value;
		
		switch ($this->_type)
		{
			default:
			case 'default':
				add_action('metabox-show-'.$this->_id, array(&$this, '_renderForm'), 20, 1 );
				add_action('metabox-save-'.$this->_id, array(&$this, 'saveAsPostMeta'), 1, 2);
				break;
			case 'image':
			case 'images':
				$this->_fields = array(
					array(
						'name' 	=> 'New Image',
						'type' 	=> 'title',
					),
					array(
						'name' 	=> 'Image Title',
						'id' 	=> $this->_id.'_post_title',
						'type' 	=> 'text',
					),
					array(
						'name' 	=> 'Description',
						'id' 	=> $this->_id.'_post_content',
						'type' 	=> 'textarea',
					),
					array(
						'name' 	=> 'Image File',
						'id' 	=> $this->_id.'_image',
						'type' 	=> 'image',
					),
					array(
						'name' 	=> 'Save Image',
						'type' 	=> 'submit',
					),
				);
				add_action('metabox-show-'.$this->_id, array(&$this, '_renderListImageAttachments'), 20, 1 );
				add_action('metabox-show-'.$this->_id, array(&$this, '_renderForm'), 20, 1 );
				add_action('metabox-save-'.$this->_id, array(&$this, 'saveAsAttachment'), 1, 2);
				break;
			case 'video':
			case 'videos':
				$this->_fields = array(
					array(
						'name' 	=> 'New Video',
						'type' 	=> 'title',
					),
					array(
						'name' 	=> 'Video Title',
						'id' 	=> $this->_id.'_post_title',
						'type' 	=> 'text',
					),
					array(
						'name' 	=> 'Description',
						'id' 	=> $this->_id.'_post_content',
						'type' 	=> 'textarea',
					),
					array(
						'name' 	=> 'Video File',
						'id' 	=> $this->_id.'_image',
						'type' 	=> 'image',
					),
					array(
						'name' 	=> 'Video Link',
						'id' 	=> $this->_id.'_link',
						'type' 	=> 'text',
					),
					array(
						'name' 	=> '_videocat',
						'id' 	=> $this->_id.'_videocat',
						'default'=>$this->getCategory(),
						'type' 	=> 'hidden',
					),
					array(
						'name' 	=> '_metaid',
						'id' 	=> $this->_id.'_metaid',
						'type' 	=> 'hidden',
					),
					array(
						'name' 	=> 'Save Video',
						'type' 	=> 'submit',
					),
				);
				add_action('metabox-show-'.$this->_id, array(&$this, '_renderListAttachments'), 20, 1 );
				add_action('metabox-show-'.$this->_id, array(&$this, '_renderListVideoAttachments'), 20, 1 );
				add_action('metabox-show-'.$this->_id, array(&$this, '_renderForm'), 20, 1 );
				add_action('metabox-save-'.$this->_id, array(&$this, 'saveAsPostMeta'), 1, 2);
				break;
		}
	}
	
	/**
	 * Method properly inturprets the given parameter and sets it accordingly
	 * 
	 * @param string|object $value
	 */
	function setObjectTypes( $value )
	{
		if (is_a($value, 'redrokk_post_class')) {
			$value = $value->_post_type;
		}
		
		if (is_a($value, 'redrokk_admin_class')) {
			$value = $value->_post_type;
		}
		
		$this->_object_types[] = $value;
		return $this;
	}
	
	/**
	 * function returns this as an array
	 */
	function getObjectIds()
	{
		if (is_array($this->object_ids))
			return $this->object_ids;
		
		$this->object_ids = explode(',',$this->object_ids);
		if (!is_array($this->object_ids))
			$this->object_ids = array($this->object_ids);
		
		return $this->object_ids;
	}
	
	/**
	 * 
	 */
	function getCountryOptions()
	{
		return array (
			'AX' => 'Aland Islands',
			'AL' => 'Albania',
			'DZ' => 'Algeria *',
			'AS' => 'American Samoa',
			'AD' => 'Andorra',
			'AI' => 'Anguilla',
			'AQ' => 'Antarctica *',
			'AG' => 'Antigua And Barbuda',
			'AR' => 'Argentina',
			'AM' => 'Armenia',
			'AW' => 'Aruba',
			'AU' => 'Australia',
			'AT' => 'Austria',
			'AZ' => 'Azerbaidjan',
			'BS' => 'Bahamas',
			'BH' => 'Bahrain',
			'BD' => 'Bangladesh',
			'BB' => 'Barbados',
			'BE' => 'Belgium',
			'BZ' => 'Belize',
			'BJ' => 'Benin',
			'BM' => 'Bermuda',
			'BT' => 'Bhutan',
			'BA' => 'Bosnia-herzegovina',
			'BW' => 'Botswana',
			'BV' => 'Bouvet Island *',
			'BR' => 'Brazil',
			'IO' => 'British Indian Ocean Territory *',
			'BN' => 'Brunei Darussalam',
			'BG' => 'Bulgaria',
			'BF' => 'Burkina Faso',
			'CA' => 'Canada',
			'CV' => 'Cape Verde',
			'KY' => 'Cayman Islands',
			'CF' => 'Central African Republic *',
			'CL' => 'Chile',
			'CN' => 'China',
			'CX' => 'Christmas Island *',
			'CC' => 'Cocos (keeling) Islands',
			'CO' => 'Colombia',
			'CK' => 'Cook Islands',
			'CR' => 'Costa Rica',
			'CY' => 'Cyprus',
			'CZ' => 'Czech Republic',
			'DK' => 'Denmark',
			'DJ' => 'Djibouti',
			'DM' => 'Dominica',
			'DO' => 'Dominican Republic',
			'EC' => 'Ecuador',
			'EG' => 'Egypt',
			'SV' => 'El Salvador',
			'EE' => 'Estonia',
			'FK' => 'Falkland Islands (malvinas)',
			'FO' => 'Faroe Islands',
			'FJ' => 'Fiji',
			'FI' => 'Finland',
			'FR' => 'France',
			'GF' => 'French Guiana',
			'PF' => 'French Polynesia',
			'TF' => 'French Southern Territories',
			'GA' => 'Gabon',
			'GM' => 'Gambia',
			'GE' => 'Georgia',
			'DE' => 'Germany',
			'GH' => 'Ghana',
			'GI' => 'Gibraltar',
			'GR' => 'Greece',
			'GL' => 'Greenland',
			'GD' => 'Grenada',
			'GP' => 'Guadeloupe',
			'GU' => 'Guam',
			'CG' => 'Guernsey',
			'GY' => 'Guyana',
			'HM' => 'Heard Island And Mcdonald Islands *',
			'VA' => 'Holy See (vatican City State)',
			'HN' => 'Honduras',
			'HK' => 'Hong Kong',
			'HU' => 'Hungary',
			'IS' => 'Iceland',
			'IN' => 'India',
			'ID' => 'Indonesia',
			'IE' => 'Ireland',
			'IM' => 'Isle Of Man',
			'IL' => 'Israel',
			'IT' => 'Italy',
			'JM' => 'Jamaica',
			'JP' => 'Japan',
			'JE' => 'Jersey',
			'JO' => 'Jordan',
			'KZ' => 'Kazakhstan',
			'KI' => 'Kiribati',
			'KR' => 'Korea, Republic Of',
			'KW' => 'Kuwait',
			'KG' => 'Kyrgyzstan',
			'LV' => 'Latvia',
			'LS' => 'Lesotho',
			'LI' => 'Liechtenstein',
			'LT' => 'Lithuania',
			'LU' => 'Luxembourg',
			'MO' => 'Macao',
			'MK' => 'Macedonia',
			'MG' => 'Madagascar',
			'MW' => 'Malawi',
			'MY' => 'Malaysia',
			'MT' => 'Malta',
			'MH' => 'Marshall Islands',
			'MQ' => 'Martinique',
			'MR' => 'Mauritania',
			'MU' => 'Mauritius',
			'YT' => 'Mayotte',
			'MX' => 'Mexico',
			'FM' => 'Micronesia, Federated States Of',
			'MD' => 'Moldova, Republic Of',
			'MC' => 'Monaco',
			'MN' => 'Mongolia',
			'ME' => 'Montenegro',
			'MS' => 'Montserrat',
			'MA' => 'Morocco',
			'MZ' => 'Mozambique',
			'NA' => 'Namibia',
			'NR' => 'Nauru',
			'NP' => 'Nepal *',
			'NL' => 'Netherlands',
			'AN' => 'Netherlands Antilles',
			'NC' => 'New Caledonia',
			'NZ' => 'New Zealand',
			'NI' => 'Nicaragua',
			'NE' => 'Niger',
			'NU' => 'Niue',
			'NF' => 'Norfolk Island',
			'MP' => 'Northern Mariana Islands',
			'NO' => 'Norway',
			'OM' => 'Oman',
			'PW' => 'Palau',
			'PS' => 'Palestine',
			'PA' => 'Panama',
			'PY' => 'Paraguay',
			'PE' => 'Peru',
			'PH' => 'Philippines',
			'PN' => 'Pitcairn',
			'PL' => 'Poland',
			'PT' => 'Portugal',
			'PR' => 'Puerto Rico',
			'QA' => 'Qatar',
			'RE' => 'Reunion',
			'RO' => 'Romania',
			'RU' => 'Russian Federation',
			'RW' => 'Rwanda',
			'SH' => 'Saint Helena',
			'KN' => 'Saint Kitts And Nevis',
			'LC' => 'Saint Lucia',
			'PM' => 'Saint Pierre And Miquelon',
			'VC' => 'Saint Vincent And The Grenadines',
			'WS' => 'Samoa',
			'SM' => 'San Marino',
			'ST' => 'Sao Tome And Principe *',
			'SA' => 'Saudi Arabia',
			'SN' => 'Senegal',
			'RS' => 'Serbia',
			'SC' => 'Seychelles',
			'SG' => 'Singapore',
			'SK' => 'Slovakia',
			'SI' => 'Slovenia',
			'SB' => 'Solomon Islands',
			'ZA' => 'South Africa',
			'GS' => 'South Georgia And The South Sandwich Islands',
			'ES' => 'Spain',
			'SR' => 'Suriname',
			'SJ' => 'Svalbard And Jan Mayen',
			'SZ' => 'Swaziland',
			'SE' => 'Sweden',
			'CH' => 'Switzerland',
			'TW' => 'Taiwan, Province Of China',
			'TZ' => 'Tanzania, United Republic Of',
			'TH' => 'Thailand',
			'TL' => 'Timor-leste',
			'TG' => 'Togo',
			'TK' => 'Tokelau',
			'TO' => 'Tonga',
			'TT' => 'Trinidad And Tobago',
			'TN' => 'Tunisia',
			'TR' => 'Turkey',
			'TM' => 'Turkmenistan',
			'TC' => 'Turks And Caicos Islands',
			'TV' => 'Tuvalu',
			'UG' => 'Uganda',
			'UA' => 'Ukraine',
			'AE' => 'United Arab Emirates',
			'GB' => 'United Kingdom',
			'US' => 'United States',
			'UM' => 'United States Minor Outlying Islands',
			'UY' => 'Uruguay',
			'UZ' => 'Uzbekistan',
			'VU' => 'Vanuatu',
			'VE' => 'Venezuela',
			'VN' => 'Viet Nam',
			'VG' => 'Virgin Islands, British',
			'VI' => 'Virgin Islands, U.s.',
			'WF' => 'Wallis And Futuna',
			'EH' => 'Western Sahara',
			'ZM' => 'Zambia',
		);
	}
	
	/**
	 * 
	 */
	function getCurrencyOptions()
	{
		return apply_filters('paypal_currenct_codes', array(
			'USD' => 'U.S. Dollar',
			'AUD' => 'Australian Dollar',
			'CAD' => 'Canadian Dollar',
			'CZK' => 'Czech Koruna',
			'DKK' => 'Danish Krone',
			'EUR' => 'Euro',
			'HUF' => 'Hungarian Forint',
			'JPY' => 'Japanese Yen',
			'NOK' => 'Norwegian Krone',
			'NZD' => 'New Zealand Dollar',
			'PLN' => 'Polish Zloty',
			'GBP' => 'Pound Sterling',
			'SGD' => 'Singapore Dollar',
			'SEK' => 'Swedish Krona',
			'CHF' => 'Swiss Franc',
		));
	}
	
	/**
	 * 
	 */
	function getPageOptions()
	{
		// initializing
		$pages = array();
		$args = array(
			'child_of' => 0,
			'sort_order' => 'ASC',
			'sort_column' => 'post_title',
			'hierarchical' => 1,
			//'number' => ,
			'post_type' => 'page',
			'post_status' => 'publish'
		);
		
		// building a clean options array
		foreach (get_pages($args) as $page)
		{
			$pages[$page->ID] = $page->post_title;
		}
		
		return $pages;
	}
	
	/**
	 * 
	 */
	function getStateOptions()
	{
		return array(
			'AL' => "Alabama",
			'AK' => "Alaska",  
			'AZ' => "Arizona",  
			'AR' => "Arkansas",  
			'CA' => "California",  
			'CO' => "Colorado",  
			'CT' => "Connecticut",  
			'DE' => "Delaware",  
			'DC' => "District Of Columbia",  
			'FL' => "Florida",  
			'GA' => "Georgia",  
			'HI' => "Hawaii",  
			'ID' => "Idaho",  
			'IL' => "Illinois",  
			'IN' => "Indiana",  
			'IA' => "Iowa",  
			'KS' => "Kansas",  
			'KY' => "Kentucky",  
			'LA' => "Louisiana",  
			'ME' => "Maine",  
			'MD' => "Maryland",  
			'MA' => "Massachusetts",  
			'MI' => "Michigan",  
			'MN' => "Minnesota",  
			'MS' => "Mississippi",  
			'MO' => "Missouri",  
			'MT' => "Montana",
			'NE' => "Nebraska",
			'NV' => "Nevada",
			'NH' => "New Hampshire",
			'NJ' => "New Jersey",
			'NM' => "New Mexico",
			'NY' => "New York",
			'NC' => "North Carolina",
			'ND' => "North Dakota",
			'OH' => "Ohio",  
			'OK' => "Oklahoma",  
			'OR' => "Oregon",  
			'PA' => "Pennsylvania",  
			'RI' => "Rhode Island",  
			'SC' => "South Carolina",  
			'SD' => "South Dakota",
			'TN' => "Tennessee",  
			'TX' => "Texas",  
			'UT' => "Utah",  
			'VT' => "Vermont",  
			'VA' => "Virginia",  
			'WA' => "Washington",  
			'WV' => "West Virginia",  
			'WI' => "Wisconsin",  
			'WY' => "Wyoming"
		);
	}
	
	/**
	 * Function returns an array of post statuses
	 * 
	 * @return array
	 */
	function getPostTypeStatuses()
	{
		// initializing
		global $wp_post_statuses;
		$ignore = array('inherit','auto-draft','future');
		
		// building array
		$statuses = array();
		foreach ($wp_post_statuses as $slug => $status)
		{
			if (in_array($slug, $ignore)) continue;
			$statuses[$slug] = $status->label;
		}
		
		//including the any option
		$statuses['any'] = 'Any';
		
		return $statuses;
	}
	
	/**
	 * Function returns an array of post types for the select options
	 * 
	 * @return array
	 */
	function getPostTypes()
	{
		$types = get_post_types(array('public' => true), 'names', 'and');
		$types = array_flip($types);
		
		foreach ($types as $slug)
		{
			$tmp = get_post_type_object($slug);
			$types[$slug] = $tmp->labels->name;
		}
		
		//including the any option
		$types['any'] = 'Any';
		
		return $types;
	}
	
	/**
	 * Function returns an array of roles for the select options
	 * 
	 * @return array
	 */
	function getRoleOptions()
	{
		global $wp_roles;

		if ( ! isset( $wp_roles ) )
			$wp_roles = new WP_Roles();
		
		$roles = array();
		foreach ($wp_roles->roles as $slug => $role)
		{
			$roles[$slug] = $role['name'];
		}
		$roles = array_reverse($roles);
		return $roles;
	}
	
	/**
	 * Returns the category to use
	 */
	function getCategory()
	{
		return isset($this->_category_name)
			? $this->_category_name
			: '_videocat';
	}
	
	/**
	 * Function returns the current post id
	 */
	function getCurrentPostID()
	{
		if (!isset($this->object_id)){
			if (isset($_GET['post']) && $_GET['post'] && get_post($_GET['post']))
				$this->object_id = $_GET['post'];
		}
		
		return $this->object_id;
	}
	
	/**
	 * Method is designed to return the currently visible post type
	 */
	function getCurrentPostType()
	{
		$post_type = false;
		if (isset($_REQUEST['post_type'])) {
			$post_type = $_REQUEST['post_type'];
		}
		if (isset($_REQUEST['post'])) {
			$post = get_post($_REQUEST['post']);
			$post_type = $post->post_type;
		}
		
		if (!$post_type) {
			global $post;
			$post_type = $post->post_type;
		}
		
		return $post_type;
	}
	
	/**
	 * Return a clean list of meta listings created by this system
	 * 
	 * @param string $category
	 * $param object $post
	 */
	public static function getMetaListings( $category, $post = null )
	{
		// initializing
		if ($post === NULL) {
			global $post;
		} 
		$custom = get_post_custom($post->ID);
		$return = array();
		
		//looping all values to build our return array
		foreach((array)$custom as $property => $value)
		{
			$parts = explode('_',$property);
			if (!isset($parts[0]) || !isset($parts[1]) || !isset($parts[2])) continue;
			if ($parts[0] != $category) continue;
			
			$pro = str_replace($parts[0].'_'.$parts[1].'_', '', $property);
			$return[$parts[1]][$pro] = $value;
		}
		
		return $return;
	}
	
	/**
	 * Method returns the post meta
	 * 
	 */
	function getRequestPostMetas()
	{
		$ignores = array('post_title', 'post_name', 'post_content', 'post_excerpt', 'post',
		'post_status', 'post_type', 'post_author', 'ping_status', 'post_parent', 'message',
		'post_category', 'comment_status', 'menu_order', 'to_ping', 'pinged', 'post_password', 
		'guid', 'post_content_filtered', 'import_id', 'post_date', 'post_date_gmt', 'tags_input',
		'action');
		
		$fields = array();
		foreach ((array)$this->_fields as $field) {
			if (!isset($field['id'])) continue;
			$fields[] = $field['id'];
		}
		
		$requests = $_REQUEST;
		foreach ((array)$requests as $k => $request)
		{
			if (($fields && !in_array($k, $fields))
			|| (in_array($k, $ignores) || strpos($k, 'nounce')!==false))
			{
				unset($requests[$k]);
			}
		}

		return apply_filters('metabox-requests-'.$this->_id, $requests);
	}
	
	/**
	 * Method redirects the user if we have added a request redirect
	 * in the url
	 * 
	 * @param string $location
	 */
	function _redirectIntervention( $location )
	{
		if (isset($_GET['_redirect'])) {
			$location = urldecode($_GET['_redirect']);
		}
		return $location;
	}
	
	/**
	 * Get the current page url
	 */
	function _currentPageURL()
	{
		$pageURL = 'http';
		if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
		$pageURL .= "://";
		if ($_SERVER["SERVER_PORT"] != "80") {
			$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
		} else {
			$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		}
		return $pageURL;
	}
	
	/**
	 * Method to bind an associative array or object to the JTable instance.This
	 * method only binds properties that are publicly accessible and optionally
	 * takes an array of properties to ignore when binding.
	 *
	 * @param   mixed  $src	 An associative array or object to bind to the JTable instance.
	 * @param   mixed  $ignore  An optional array or space separated list of properties to ignore while binding.
	 *
	 * @return  boolean  True on success.
	 *
	 * @link	http://docs.joomla.org/JTable/bind
	 * @since   11.1
	 */
	public function bind($src, $ignore = array())
	{
		// If the source value is not an array or object return false.
		if (!is_object($src) && !is_array($src))
		{
			trigger_error('Bind failed as the provided source is not an array.');
			return false;
		}

		// If the source value is an object, get its accessible properties.
		if (is_object($src))
		{
			$src = get_object_vars($src);
		}

		// If the ignore value is a string, explode it over spaces.
		if (!is_array($ignore))
		{
			$ignore = explode(' ', $ignore);
		}

		// Bind the source value, excluding the ignored fields.
		foreach ($this->getProperties() as $k => $v)
		{
			// Only process fields not in the ignore array.
			if (!in_array($k, $ignore))
			{
				if (isset($src[$k]))
				{
					$this->$k = $src[$k];
				}
			}
		}

		return true;
	}
	
	/**
	 * Set the object properties based on a named array/hash.
	 *
	 * @param   mixed  $properties  Either an associative array or another object.
	 *
	 * @return  boolean
	 *
	 * @since   11.1
	 *
	 * @see	 set() 
	 */
	public function setProperties($properties)
	{
		if (is_array($properties) || is_object($properties))
		{
			foreach ((array) $properties as $k => $v)
			{
				// Use the set function which might be overridden.
				$this->set($k, $v);
			}
			return true;
		}

		return false;
	}
	
	/**
	 * Modifies a property of the object, creating it if it does not already exist.
	 *
	 * @param   string  $property  The name of the property.
	 * @param   mixed   $value	 The value of the property to set.
	 *
	 * @return  mixed  Previous value of the property.
	 *
	 * @since   11.1
	 */
	public function set($property, $value = null)
	{
		$_property = 'set'.str_replace(' ', '', ucwords(str_replace('_', ' ', $property)));
		if (method_exists($this, $_property)) {
			return $this->$_property($value);
		}
		
		$previous = isset($this->$property) ? $this->$property : null;
		$this->$property = $value;
		return $previous;
	}
	
	/**
	 * Returns an associative array of object properties.
	 *
	 * @param   boolean  $public  If true, returns only the public properties.
	 *
	 * @return  array 
	 *
	 * @see	 get()
	 */
	public function getProperties($public = true)
	{
		$vars = get_object_vars($this);
		if ($public)
		{
			foreach ($vars as $key => $value)
			{
				if ('_' == substr($key, 0, 1))
				{
					unset($vars[$key]);
				}
			}
		}

		return $vars;
	}
	
	/**
	 * 
	 * contains the current instance of this class
	 * @var object
	 */
	static $_instances = null;
	
	/**
	 * Method is called when we need to instantiate this class
	 * 
	 * @param array $options
	 */
	public static function getInstance( $_id, $options = array() )
	{
		if (!isset(self::$_instances[$_id]))
		{
			$options['_id'] = $_id;
			$class = get_class();
			self::$_instances[$_id] =& new $class($options);
		}
		return self::$_instances[$_id];
	}
}