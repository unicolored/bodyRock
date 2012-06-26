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
?>
