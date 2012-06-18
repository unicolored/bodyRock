<?php
require_once('bodyrock-metabox-save.php');

// Creating the Custom Field Box
add_action("admin_init", "videoCode_meta_box");   

function videoCode_meta_box(){
    add_meta_box("videoCode-meta", "Options", "videoCode_meta_options", "post", "side", "high");
}  

function videoCode_meta_options(){
        global $post;
		global $wpdb;
        if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return $post_id;
        $custom = get_post_custom($post->ID);
        $videoCode = $custom["videoCode"][0];
        $videoType = $custom["videoType"][0];
?>
<?php wp_nonce_field( 'ai1ec', AI1EC_POST_TYPE ); ?>
    <label>Code :</label><input name="videoCode" value="<?php echo $videoCode; ?>" />
    <br>
    <label>Type :</label><input name="videoType" value="<?php echo $videoType; ?>" />
    <br>
<?php
$size="&w=930&h=431&q=100&s=1";
$title=str_replace(' ','-',str_replace("'","",str_replace('-','',trim(get_the_title()))));
			
			switch($videoType) {
			case 'vim':
				$hash = unserialize(file_get_contents("http://vimeo.com/api/v2/video/$videoCode.php"));
				//echo '<img class="attachment-small-feature wp-post-image" src="/wp-content/themes/_config/inc/timthumb.php?src='.$hash[0]['thumbnail_large'].''.$size.'">';
				echo '<a href="'.$hash[0]['thumbnail_large'].'"'.$size.'">'.$title.'</a> <input name="title" value="'.$title.'" />'; break;
			case 'you':
			//echo '<img class="attachment-small-feature wp-post-image" src="/wp-content/themes/_config/inc/timthumb.php?src=http://img.youtube.com/vi/'.$videoCode.'/0.jpg'.$size.'">';
			echo '<a href="http://img.youtube.com/vi/'.$videoCode.'/0.jpg'.$size.'">'.$title.'</a>';
			break;
}
?> 
		
        <?php
    }

?>