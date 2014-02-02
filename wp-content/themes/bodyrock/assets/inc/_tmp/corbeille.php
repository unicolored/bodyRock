<?php

// CORBEILLE :: Fonctions devenues inutiles ///////////////////////////////////////////// 

/*//**//**//**//*//**//**//**//*//**//**//**//*//**//**//**/
// Corbeille des fonctions inutilisées.
/*//**//**//**//*//**//**//**//*//**//**//**//*//**//**//**/


// allow more tags in TinyMCE including iframes
function bodyrock_change_mce_options($options) {
  $ext = 'pre[id|name|class|style],iframe[align|longdesc|name|width|height|frameborder|scrolling|marginheight|marginwidth|src]';
  if (isset($initArray['extended_valid_elements'])) {
    $options['extended_valid_elements'] .= ',' . $ext;
  } else {
    $options['extended_valid_elements'] = $ext;
  }
  return $options;
}


// Terrible workaround to remove the duplicate subfolder in the src of JS/CSS tags
// Example: /subfolder/subfolder/css/style.css
function bodyrock_fix_duplicate_subfolder_urls($input) {
  $output = bodyrock_root_relative_url($input);
  preg_match_all('!([^/]+)/([^/]+)!', $output, $matches);
  if (isset($matches[1]) && isset($matches[2])) {
    if ($matches[1][0] === $matches[2][0]) {
      $output = substr($output, strlen($matches[1][0]) + 1);
    }
  }
  return $output;
}

// fix for empty search query
// http://wordpress.org/support/topic/blank-search-sends-you-to-the-homepage#post-1772565
function bodyrock_request_filter($query_vars) {
  if (isset($_GET['s']) && empty($_GET['s'])) {
    $query_vars['s'] = " ";
  }
  return $query_vars;
}

// set lang="en" as default (rather than en-US)
function bodyrock_language_attributes() {
  $attributes = array();
  $output = '';
  if (function_exists('is_rtl')) {
    if (is_rtl() == 'rtl') {
      $attributes[] = 'dir="rtl"';
    }
  }

  $lang = get_bloginfo('language');
  if ($lang && $lang !== 'en-US') {
    $attributes[] = "lang=\"$lang\"";
  } else {
    $attributes[] = 'lang="en"';
  }

  $output = implode(' ', $attributes);
  $output = apply_filters('bodyrock_language_attributes', $output);
  return $output;
}

function bodyrock_search_query($escaped = true) {
  $query = apply_filters('bodyrock_search_query', get_query_var('s'));
  if ($escaped) {
      $query = esc_attr($query);
  }
  return urldecode($query);
}

// redirect /?s to /search/
// http://txfx.net/wordpress-plugins/nice-search/
function bodyrock_nice_search_redirect() {
  if (is_search() && strpos($_SERVER['REQUEST_URI'], '/wp-admin/') === false && strpos($_SERVER['REQUEST_URI'], '/search/') === false) {
    wp_redirect(home_url('/search/' . str_replace(array(' ', '%20'), array('+', '+'), urlencode(get_query_var( 's' )))), 301);
      exit();
  }
}

// root relative URLs for everything
// inspired by http://www.456bereastreet.com/archive/201010/how_to_make_wordpress_urls_root_relative/
// thanks to Scott Walkinshaw (scottwalkinshaw.com)
// After doing that, each time you use the_permalink(); in your templates, the resulting URL will be root relative,
// i.e. instead of http://www.example.com/page-or-post-url/ you will get /page-or-post-url/. Much better.
function bodyrock_root_relative_url($input) {
  $output = preg_replace_callback(
    '!(https?://[^/|"]+)([^"]+)?!',
    create_function(
      '$matches',
      // if full URL is site_url, return a slash for relative root
      'if (isset($matches[0]) && $matches[0] === site_url()) { return "/";' .
      // if domain is equal to site_url, then make URL relative
      '} elseif (isset($matches[0]) && strpos($matches[0], site_url()) !== false) { return $matches[2];' .
      // if domain is not equal to site_url, do not make external link relative
      '} else { return $matches[0]; };'
    ),
    $input
  );
  return $output;
}

// remove root relative URLs on any attachments in the feed
function bodyrock_root_relative_attachment_urls() {
  $bodyrock_options = bodyrock_get_theme_options();
  if (!is_feed() && $bodyrock_options['root_relative_urls']) {
    add_filter('wp_get_attachment_url', 'bodyrock_root_relative_url');
    add_filter('wp_get_attachment_link', 'bodyrock_root_relative_url');
  }
}

// ADMIN_INIT
// check to see if the tagline is set to default
// show an admin notice to update if it hasn't been changed
// you want to change this or remove it because it's used as the description in the RSS feed
function bodyrock_notice_tagline() {
    global $current_user;
  $user_id = $current_user->ID;
    if (!get_user_meta($user_id, 'ignore_tagline_notice')) {
    echo '<div class="error">';
    echo '<p>', sprintf(__('Merci de mettre à jour <a href="%s">le slogan du site</a> <a href="%s" style="float: right;">Masquer</a>', 'bodyrock'), admin_url('options-general.php'), '?tagline_notice_ignore=0'), '</p>';
    echo '</div>';
    }
}

// INIT
function bodyrock_head_cleanup() {
  // http://wpengineer.com/1438/wordpress-header/
  remove_action('wp_head', 'feed_links', 2);
  remove_action('wp_head', 'feed_links_extra', 3);
  remove_action('wp_head', 'rsd_link');
  remove_action('wp_head', 'wlwmanifest_link');
  remove_action('wp_head', 'index_rel_link');
  remove_action('wp_head', 'parent_post_rel_link', 10, 0);
  remove_action('wp_head', 'start_post_rel_link', 10, 0);
  remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
  remove_action('wp_head', 'wp_generator');
  remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);
  remove_action('wp_head', 'noindex', 1);
  add_action('wp_head', 'bodyrock_noindex');
  remove_action('wp_head', 'rel_canonical');
  add_action('wp_head', 'bodyrock_rel_canonical');
  add_action('wp_head', 'bodyrock_remove_recent_comments_style', 1);
  add_filter('gallery_style', 'bodyrock_gallery_style');

  // stop Gravity Forms from outputting CSS since it's linked in header.php
  if (class_exists('RGForms')) {
    update_option('rg_gforms_disable_css', 1);
  }

  // deregister l10n.js (new since WordPress 3.1)
  // why you might want to keep it: http://wordpress.stackexchange.com/questions/5451/what-does-l10n-js-do-in-wordpress-3-1-and-how-do-i-remove-it/5484#5484
  // don't load jQuery through WordPress since it's linked in header.php
  if (!is_admin()) {
    wp_deregister_script('l10n');
    wp_deregister_script('jquery');
    wp_register_script('jquery', '', '', '', true);
  }
}

//clean up the default WordPress style tags
function bodyrock_clean_style_tag($input) {
  preg_match_all("!<link rel='stylesheet'\s?(id='[^']+')?\s+href='(.*)' type='text/css' media='(.*)' />!", $input, $matches);
  //only display media if it's print
  $media = $matches[3][0] === 'print' ? ' media="print"' : '';
  return '<link rel="stylesheet" href="' . $matches[2][0] . '"' . $media . '>' . "\n";
}

function bodyrock_notice_tagline_ignore() {
  global $current_user;
  $user_id = $current_user->ID;
  if (isset($_GET['tagline_notice_ignore']) && '0' == $_GET['tagline_notice_ignore']) {
    add_user_meta($user_id, 'ignore_tagline_notice', 'true', true);
    }
}


// set the post revisions to 5 unless the constant
// was set in wp-config.php to avoid DB bloat
if (!defined('WP_POST_REVISIONS')) define('WP_POST_REVISIONS', 5);

?>
