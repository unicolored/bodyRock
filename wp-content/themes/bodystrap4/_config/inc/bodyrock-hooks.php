<?php

// header.php
function bodyrock_analytics() { do_action('bodyrock_google_analytics'); }
function bodyrock_stylesheets() { do_action('bodyrock_stylesheets'); }
function bodyrock_lesssheets() { do_action('bodyrock_lesssheets'); }
function bodyrock_javascripts() { do_action('bodyrock_javascripts'); }
function bodyrock_javascripts_footer() { do_action('bodyrock_javascripts_footer'); }

// 404.php, archive.php, front-page.php, index.php, loop-page.php, loop-search.php, loop-single.php, loop.php
// page-custom.php, page-full.php, page-sitemap.php, page-subpages.php, page.php, search.php, single.php
function bodyrock_content_before() { do_action('bodyrock_content_before'); }
function bodyrock_content_after() { do_action('bodyrock_content_after'); }
function bodyrock_main_before() { do_action('bodyrock_main_before'); }
function bodyrock_main_after() { do_action('bodyrock_main_after'); }
function bodyrock_post_before() { do_action('bodyrock_post_before'); }
function bodyrock_post_after() { do_action('bodyrock_post_after'); }
function bodyrock_post_inside_before() { do_action('bodyrock_post_inside_before'); }
function bodyrock_post_inside_after() { do_action('bodyrock_post_inside_after'); }
function bodyrock_loop_before() { do_action('bodyrock_loop_before'); }
function bodyrock_loop_after() { do_action('bodyrock_loop_after'); }
function bodyrock_sidebar_before() { do_action('bodyrock_sidebar_before'); }
function bodyrock_sidebar_inside_before() { do_action('bodyrock_sidebar_inside_before'); }
function bodyrock_sidebar_inside_after() { do_action('bodyrock_sidebar_inside_after'); }
function bodyrock_sidebar_after() { do_action('bodyrock_sidebar_after'); }

// footer.php
function bodyrock_footer() { do_action('bodyrock_footer'); }

?>
