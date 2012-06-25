<?php

// redirect /?s to /search/
// http://txfx.net/wordpress-plugins/nice-search/
function bodyrock_nice_search_redirect() {
  if (is_search() && strpos($_SERVER['REQUEST_URI'], '/wp-admin/') === false && strpos($_SERVER['REQUEST_URI'], '/search/') === false) {
    wp_redirect(home_url('/search/' . str_replace(array(' ', '%20'), array('+', '+'), urlencode(get_query_var( 's' )))), 301);
      exit();
  }
}
add_action('template_redirect', 'bodyrock_nice_search_redirect');

function bodyrock_search_query($escaped = true) {
  $query = apply_filters('bodyrock_search_query', get_query_var('s'));
  if ($escaped) {
      $query = esc_attr($query);
  }
  return urldecode($query);
}
add_filter('get_search_query', 'bodyrock_search_query');

// fix for empty search query
// http://wordpress.org/support/topic/blank-search-sends-you-to-the-homepage#post-1772565
function bodyrock_request_filter($query_vars) {
  if (isset($_GET['s']) && empty($_GET['s'])) {
    $query_vars['s'] = " ";
  }
  return $query_vars;
}
add_filter('request', 'bodyrock_request_filter');

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

$bodyrock_options = bodyrock_get_theme_options();
if (!is_admin() && !in_array($GLOBALS['pagenow'], array('wp-login.php', 'wp-register.php')) && $bodyrock_options['root_relative_urls']) {
  add_filter('bloginfo_url', 'bodyrock_root_relative_url');
  add_filter('theme_root_uri', 'bodyrock_root_relative_url');
  add_filter('stylesheet_directory_uri', 'bodyrock_root_relative_url');
  add_filter('template_directory_uri', 'bodyrock_root_relative_url');
  add_filter('script_loader_src', 'bodyrock_fix_duplicate_subfolder_urls');
  add_filter('style_loader_src', 'bodyrock_fix_duplicate_subfolder_urls');
  add_filter('plugins_url', 'bodyrock_root_relative_url');
  add_filter('the_permalink', 'bodyrock_root_relative_url');
  add_filter('wp_list_pages', 'bodyrock_root_relative_url');
  add_filter('wp_list_categories', 'bodyrock_root_relative_url');
  add_filter('wp_nav_menu', 'bodyrock_root_relative_url');
  add_filter('the_content_more_link', 'bodyrock_root_relative_url');
  add_filter('the_tags', 'bodyrock_root_relative_url');
  add_filter('get_pagenum_link', 'bodyrock_root_relative_url');
  add_filter('get_comment_link', 'bodyrock_root_relative_url');
  add_filter('month_link', 'bodyrock_root_relative_url');
  add_filter('day_link', 'bodyrock_root_relative_url');
  add_filter('year_link', 'bodyrock_root_relative_url');
  add_filter('tag_link', 'bodyrock_root_relative_url');
  add_filter('the_author_posts_link', 'bodyrock_root_relative_url');
}

// remove root relative URLs on any attachments in the feed
function bodyrock_root_relative_attachment_urls() {
  $bodyrock_options = bodyrock_get_theme_options();
  if (!is_feed() && $bodyrock_options['root_relative_urls']) {
    add_filter('wp_get_attachment_url', 'bodyrock_root_relative_url');
    add_filter('wp_get_attachment_link', 'bodyrock_root_relative_url');
  }
}
add_action('pre_get_posts', 'bodyrock_root_relative_attachment_urls');

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
add_filter('language_attributes', 'bodyrock_language_attributes');

// remove WordPress version from RSS feed
function bodyrock_no_generator() { return ''; }
add_filter('the_generator', 'bodyrock_no_generator');

// cleanup wp_head
function bodyrock_noindex() {
  if (get_option('blog_public') === '0') {
    echo '<meta name="robots" content="noindex,nofollow">', "\n";
  }
}

function bodyrock_rel_canonical() {
  if (!is_singular()) {
    return;
  }

  global $wp_the_query;
  if (!$id = $wp_the_query->get_queried_object_id()) {
    return;
  }

  $link = get_permalink($id);
  echo "\t<link rel=\"canonical\" href=\"$link\">\n";
}

// remove CSS from recent comments widget
function bodyrock_remove_recent_comments_style() {
  global $wp_widget_factory;
  if (isset($wp_widget_factory->widgets['WP_Widget_Recent_Comments'])) {
    remove_action('wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style'));
  }
}

// remove CSS from gallery
function bodyrock_gallery_style($css) {
  return preg_replace("!<style type='text/css'>(.*?)</style>!s", '', $css);
}

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
add_action('init', 'bodyrock_head_cleanup');

// cleanup gallery_shortcode()
function bodyrock_gallery_shortcode($attr) {
  global $post, $wp_locale;

  static $instance = 0;
  $instance++;

  // Allow plugins/themes to override the default gallery template.
  $output = apply_filters('post_gallery', '', $attr);
  if ( $output != '' )
    return $output;

  // We're trusting author input, so let's at least make sure it looks like a valid orderby statement
  if ( isset( $attr['orderby'] ) ) {
    $attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
    if ( !$attr['orderby'] )
      unset( $attr['orderby'] );
  }

  extract(shortcode_atts(array(
    'order'      => 'ASC',
    'orderby'    => 'menu_order ID',
    'id'         => $post->ID,
    'icontag'    => 'figure',
    'captiontag' => 'figcaption',
    'columns'    => 3,
    'size'       => 'thumbnail',
    'include'    => '',
    'exclude'    => ''
  ), $attr));

  $id = intval($id);
  if ( 'RAND' == $order )
    $orderby = 'none';

  if ( !empty($include) ) {
    $include = preg_replace( '/[^0-9,]+/', '', $include );
    $_attachments = get_posts( array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );

    $attachments = array();
    foreach ( $_attachments as $key => $val ) {
      $attachments[$val->ID] = $_attachments[$key];
    }
  } elseif ( !empty($exclude) ) {
    $exclude = preg_replace( '/[^0-9,]+/', '', $exclude );
    $attachments = get_children( array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
  } else {
    $attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
  }

  if ( empty($attachments) )
    return '';

  if ( is_feed() ) {
    $output = "\n";
    foreach ( $attachments as $att_id => $attachment )
      $output .= wp_get_attachment_link($att_id, $size, true) . "\n";
    return $output;
  }

  $captiontag = tag_escape($captiontag);
  $columns = intval($columns);
  $itemwidth = $columns > 0 ? floor(100/$columns) : 100;
  $float = is_rtl() ? 'right' : 'left';

  $selector = "gallery-{$instance}";

  $gallery_style = $gallery_div = '';
  if ( apply_filters( 'use_default_gallery_style', true ) )
    $gallery_style = "";
  $size_class = sanitize_html_class( $size );
  $gallery_div = "<section id='$selector' class='clearfix gallery galleryid-{$id} gallery-columns-{$columns} gallery-size-{$size_class}'>";
  $output = apply_filters( 'gallery_style', $gallery_style . "\n\t\t" . $gallery_div );

  $i = 0;
  foreach ( $attachments as $id => $attachment ) {
    // make the gallery link to the file by default instead of the attachment
    // thanks to Matt Price (countingrows.com)
    $link = isset($attr['link']) && $attr['link'] === 'attachment' ?
      wp_get_attachment_link($id, $size, true, false) :
      wp_get_attachment_link($id, $size, false, false);
    $output .= "
      <{$icontag} class=\"gallery-item\">
        $link
      ";
    if ( $captiontag && trim($attachment->post_excerpt) ) {
      $output .= "
        <{$captiontag} class=\"gallery-caption\">
        " . wptexturize($attachment->post_excerpt) . "
        </{$captiontag}>";
    }
    $output .= "</{$icontag}>";
    if ( $columns > 0 && ++$i % $columns == 0 )
      $output .= '';
  }

  $output .= "</section>\n";

  return $output;
}

remove_shortcode('gallery');
add_shortcode('gallery', 'bodyrock_gallery_shortcode');

// http://www.deluxeblogtips.com/2011/01/remove-dashboard-widgets-in-wordpress.html
function bodyrock_remove_dashboard_widgets() {
  remove_meta_box('dashboard_incoming_links', 'dashboard', 'normal');
  remove_meta_box('dashboard_plugins', 'dashboard', 'normal');
  remove_meta_box('dashboard_primary', 'dashboard', 'normal');
  remove_meta_box('dashboard_secondary', 'dashboard', 'normal');
}

add_action('admin_init', 'bodyrock_remove_dashboard_widgets');

// remove container from menus

function bodyrock_nav_menu_args($args = '') {
            
	$args['theme_location'] = $args['theme_location'];
	$args['menu'] = 'nav';
	$args['container_class'] = 'nav';
	$args['menu_class'] = 'nav';
	//$options['items_wrap'] = '<ul id="%1$s" class="nav">%3$s</ul>';
//	if (get_option('wp_css_menu_jclass')) : $options['menu_class'] = get_option('wp_css_menu_jclass'); endif;
	//print_r($options);
	
	//if (function_exists('wp_nav_menu')) : wp_nav_menu($options); endif;// Now using the Wordpress nav menu builder
			
/*  $args['container'] = '';
  $args['menu_class'] = 'crotte';
  $args['items_wrap'] = '<ul id="%1$s" class="nav">%3$s</ul>';*/
  return $args;
}
add_filter('wp_nav_menu_args', 'bodyrock_nav_menu_args');

function bodyrock_check_current($val) {
  return preg_match('/current-menu/', $val);
}

// add to robots.txt
// http://codex.wordpress.org/Search_Engine_Optimization_for_WordPress#Robots.txt_Optimization
function bodyrock_robots() {
  echo "Disallow: /cgi-bin\n";
  echo "Disallow: /wp-admin\n";
  echo "Disallow: /wp-includes\n";
  echo "Disallow: /wp-content/plugins\n";
  echo "Disallow: /plugins\n";
  echo "Disallow: /wp-content/cache\n";
  echo "Disallow: /wp-content/themes\n";
  echo "Disallow: /trackback\n";
  echo "Disallow: /feed\n";
  echo "Disallow: /comments\n";
  echo "Disallow: /category/*/*\n";
  echo "Disallow: */trackback\n";
  echo "Disallow: */feed\n";
  echo "Disallow: */comments\n";
  echo "Disallow: /*?*\n";
  echo "Disallow: /*?\n";
  echo "Allow: /wp-content/uploads\n";
  echo "Allow: /assets";
}

add_action('do_robots', 'bodyrock_robots');

// we don't need to self-close these tags in html5:
// <img>, <input>
function bodyrock_remove_self_closing_tags($input) {
  return str_replace(' />', '>', $input);
}

add_filter('get_avatar', 'bodyrock_remove_self_closing_tags');
add_filter('comment_id_fields', 'bodyrock_remove_self_closing_tags');
add_filter('post_thumbnail_html', 'bodyrock_remove_self_closing_tags');

// check to see if the tagline is set to default
// show an admin notice to update if it hasn't been changed
// you want to change this or remove it because it's used as the description in the RSS feed
function bodyrock_notice_tagline() {
    global $current_user;
  $user_id = $current_user->ID;
    if (!get_user_meta($user_id, 'ignore_tagline_notice')) {
    echo '<div class="error">';
    echo '<p>', sprintf(__('Please update your <a href="%s">site tagline</a> <a href="%s" style="float: right;">Hide Notice</a>', 'bodyrock'), admin_url('options-general.php'), '?tagline_notice_ignore=0'), '</p>';
    echo '</div>';
    }
}
if (get_option('blogdescription') === 'Just another WordPress site') {
  add_action('admin_notices', 'bodyrock_notice_tagline');
}

function bodyrock_notice_tagline_ignore() {
  global $current_user;
  $user_id = $current_user->ID;
  if (isset($_GET['tagline_notice_ignore']) && '0' == $_GET['tagline_notice_ignore']) {
    add_user_meta($user_id, 'ignore_tagline_notice', 'true', true);
    }
}
add_action('admin_init', 'bodyrock_notice_tagline_ignore');

// set the post revisions to 5 unless the constant
// was set in wp-config.php to avoid DB bloat
if (!defined('WP_POST_REVISIONS')) define('WP_POST_REVISIONS', 5);

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
add_filter('tiny_mce_before_init', 'bodyrock_change_mce_options');

//clean up the default WordPress style tags
add_filter('style_loader_tag', 'bodyrock_clean_style_tag');

function bodyrock_clean_style_tag($input) {
  preg_match_all("!<link rel='stylesheet'\s?(id='[^']+')?\s+href='(.*)' type='text/css' media='(.*)' />!", $input, $matches);
  //only display media if it's print
  $media = $matches[3][0] === 'print' ? ' media="print"' : '';
  return '<link rel="stylesheet" href="' . $matches[2][0] . '"' . $media . '>' . "\n";
}

function bodyrock_body_class() {
  $term = get_queried_object();
  if (is_single())
    $cat = get_the_category();
  if(!empty($cat))
    return $cat[0]->slug;
  elseif(isset($term->slug))
    return $term->slug;
  elseif(isset($term->page_name))
    return $term->page_name;
  elseif(isset($term->post_name))
    return $term->post_name;
  else
    return;
}

// first and last classes for widgets
// http://wordpress.org/support/topic/how-to-first-and-last-css-classes-for-sidebar-widgets
function bodyrock_widget_first_last_classes($params) {
  global $my_widget_num;
  $this_id = $params[0]['id'];
  $arr_registered_widgets = wp_get_sidebars_widgets();

  if (!$my_widget_num) {
    $my_widget_num = array();
  }

  if (!isset($arr_registered_widgets[$this_id]) || !is_array($arr_registered_widgets[$this_id])) {
    return $params;
  }

  if (isset($my_widget_num[$this_id])) {
    $my_widget_num[$this_id] ++;
  } else {
    $my_widget_num[$this_id] = 1;
  }

  $class = 'class="widget-' . $my_widget_num[$this_id] . ' ';

  if ($my_widget_num[$this_id] == 1) {
    $class .= 'widget-first ';
  } elseif ($my_widget_num[$this_id] == count($arr_registered_widgets[$this_id])) {
    $class .= 'widget-last ';
  }

  $params[0]['before_widget'] = str_replace('class="', $class, $params[0]['before_widget']);

  return $params;

}
add_filter('dynamic_sidebar_params', 'bodyrock_widget_first_last_classes');

?>
