<?php

$tpl_content = '/single'; // /page

get_header();
?>
	<?php
	get_template_part( 'tpl/loop'.$tpl_content, get_post_format() );
	?>
<?php global $tpl_content; echo is_super_admin() ? '!!'.__FILE__.':'.$tpl_content.'!!' : false; ?>
<?php
get_footer();
?>