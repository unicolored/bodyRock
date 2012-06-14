<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the wordpress construct of pages
 * and that other 'pages' on your wordpress site will use a
 * different template.
 *
 * @package Skeleton WordPress Theme Framework
 * @subpackage bodyrock
 * @author Simple Themes - www.simplethemes.com
 */
// You can override via functions.php conditionals or define:
// $columns = 'four';

get_header();
?>

<link rel="stylesheet" href="/wp-content/themes/boot-gilleshoarau/css/wheel.css">
<h1>Wheel</h1>
<div class="wheel">
	<div class="line">Horizon</div>
	<ul>
		<li><span></span></li>
		<li><span></span></li>
		<li><span></span></li>
		<li><span></span></li>
		<li><span></span></li>
		<li><span></span></li>
		<li><span></span></li>
		<li><span></span></li>
	</ul>
</div>
<?php
get_footer();
?>