<?php

function bodyrock_admin_enqueue_scripts($hook_suffix) {
  if ($hook_suffix !== 'appearance_page_theme_options')
    return;

  wp_enqueue_style('bodyrock-theme-options', get_template_directory_uri() . '/inc/css/theme-options.css');
  wp_enqueue_script('bodyrock-theme-options', get_template_directory_uri() . '/inc/js/theme-options.js');
}
add_action('admin_enqueue_scripts', 'bodyrock_admin_enqueue_scripts');

function bodyrock_theme_options_init() {
  if (false === bodyrock_get_theme_options())
    add_option('bodyrock_theme_options', bodyrock_get_default_theme_options());

  register_setting(
    'bodyrock_options',
    'bodyrock_theme_options',
    'bodyrock_theme_options_validate'
  );
}
add_action('admin_init', 'bodyrock_theme_options_init');

function bodyrock_option_page_capability($capability) {
  return 'edit_theme_options';
}
add_filter('option_page_capability_bodyrock_options', 'bodyrock_option_page_capability');

function bodyrock_theme_options_add_page() {
  $theme_page = add_theme_page(
    __('Theme Options', 'bodyrock'),
    __('Theme Options', 'bodyrock'),
    'edit_theme_options',
    'theme_options',
    'bodyrock_theme_options_render_page'
  );

  if (!$theme_page)
    return;
}
add_action('admin_menu', 'bodyrock_theme_options_add_page');

function bodyrock_admin_bar_render() {
  global $wp_admin_bar;

  $wp_admin_bar->add_menu(array(
    'parent' => 'appearance',
    'id' => 'theme_options',
    'title' => __('Theme Options', 'bodyrock'),
    'href' => admin_url( 'themes.php?page=theme_options')
  ));
}
add_action('wp_before_admin_bar_render', 'bodyrock_admin_bar_render');

?>