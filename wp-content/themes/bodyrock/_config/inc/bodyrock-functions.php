<?php
	
	function br_query($variables) {
		$query='';
		foreach ($variables as $key=>$val) {
			$query.='&'.$key.'='.$val;
		}
		return $query;
	}
	
	function br_customsidebar($sidebar_name='',$classname='') {
		if ( $sidebar_name!='' && is_active_sidebar( $sidebar_name )) : ?>
			<div class="<?php echo $classname; ?>">
				<?php dynamic_sidebar( $sidebar_name ); ?>
			</div>
		<?php endif;
	}
	
	function bodyrock_getTplContent($cat,$tpl_content="blog") {
		global $categories_templates;

		if(is_array($categories_templates))
		{
			if(isset($categories_templates[$cat])) $tpl_content = $categories_templates[$cat]; // blog, gallery, complet
		}
		return '/'.$tpl_content;
	}
?>
