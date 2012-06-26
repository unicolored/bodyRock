<?php

$tpl_content = '/page'; // /page

get_header();
?>
<?php
get_template_part( 'tpl/loop'.$tpl_content );
?>
<?php
get_footer();
?>