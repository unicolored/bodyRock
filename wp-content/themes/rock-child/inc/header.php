<?php
session_start();

/* Icones de la navbar footer */
$articles = (isset($_SESSION['post_id']) ? $_SESSION['post_id'] : array());
$articles = array_unique($articles);
$c = count($articles);
//echo $c;
if(is_page() || is_single()) {
	$key = array_search(get_the_ID(), $articles);
	if ( $key > 0 ) {
		unset($articles[$key]);
	}
	else {
		unset($articles[0]);
	}
	$articles = array_values($articles);
	$articles[] = get_the_ID();
}
elseif(is_tag()) {
	$key = array_search('tag:'.get_query_var('tag'), $articles);
	if ( $key > 0 ) {
		unset($articles[$key]);
	}
	else {
		unset($articles[0]);
	}
	$articles = array_values($articles);
	$articles[] = 'tag:'.get_query_var('tag');
}
elseif(is_search()) {
	$key = array_search('search:'.get_query_var('s'), $articles);
	if ( $key > 0 ) {
		unset($articles[$key]);
	}
	else {
		unset($articles[0]);
	}
	$articles = array_values($articles);
	$articles[] = 'search:'.get_query_var('s');
}
elseif(is_category()) {
	$key = array_search('cat:'.get_query_var('cat'), $articles);
	if ( $key > 0 ) {
		unset($articles[$key]);
	}
	else {
		unset($articles[0]);
	}
	$articles = array_values($articles);
	$articles[] = 'cat:'.get_query_var('cat');
}
for ($i=0;$i<=5;$i++) {
	$navbar_items[$i] = $articles[$i];
}
$_SESSION['post_id'] = array_values($navbar_items);
?>