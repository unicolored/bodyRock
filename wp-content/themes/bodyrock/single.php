<?php

$tpl_content = '/single'; // /page

get_header();
?>
	<?php
	get_template_part( 'tpl/loop'.$tpl_content, get_post_format() );
	?>
	
<?php
get_footer();
?>