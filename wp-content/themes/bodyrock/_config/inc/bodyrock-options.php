<?php

require_once('ini/options.php');

global $bodyrock_css_frameworks;
$bodyrock_css_frameworks = array(
  'bodyrock' => array(
    'name'     => 'bodyrock',
    'label'     => __('Skeleton CSS', 'bodyrock')
    )
);

function bodyrock_get_default_theme_options($default_framework = '') {
  global $bodyrock_css_frameworks;
  if ($default_framework == '') { $default_framework = apply_filters('bodyrock_default_css_framework', 'blueprint'); }
  $default_framework_settings = $bodyrock_css_frameworks[$default_framework];
  $default_theme_options = array(
    'css_framework'     => $default_framework,
    'google_analytics_id' => '',
    'root_relative_urls'  => true,
    'clean_menu'      => true,
    'jquery_on'      => false,
    'jqueryui_on'      => false,
    'customsrc'      => false
  );

  return apply_filters('bodyrock_default_theme_options', $default_theme_options);
}

function bodyrock_get_theme_options() {
  return get_option('bodyrock_theme_options', bodyrock_get_default_theme_options());
}

function bodyrock_theme_options_render_page() {
  global $bodyrock_css_frameworks;
  ?>
  <div class="wrap">
    <?php screen_icon(); ?>
    <h2><?php printf(__('%s Theme Options', 'bodyrock'), get_current_theme()); ?></h2>
    <?php settings_errors(); ?>

    <form method="post" action="options.php">
      <?php
        settings_fields('bodyrock_options');
        $bodyrock_options = bodyrock_get_theme_options();
        $bodyrock_default_options = bodyrock_get_default_theme_options($bodyrock_options['css_framework']);
      ?>

      <table class="form-table">

        <tr valign="top" class="radio-option"><th scope="row"><?php _e('CSS Grid Framework', 'bodyrock'); ?></th>
          <td>
            <fieldset class="bodyrock_css_frameworks"><legend class="screen-reader-text"><span><?php _e('CSS Grid Framework', 'bodyrock'); ?></span></legend>
              <select name="bodyrock_theme_options[css_framework]" id="bodyrock_theme_options[css_framework]">
              <?php foreach ($bodyrock_css_frameworks as $css_framework) { ?>
                <option value="<?php echo esc_attr($css_framework['name']); ?>" <?php selected($bodyrock_options['css_framework'], $css_framework['name']); ?>><?php echo $css_framework['label']; ?></option>
              <?php } ?>
              </select>
            </fieldset>
          </td>
        </tr>
        
        <tr valign="top"><th scope="row"><?php _e('Google Analytics ID', 'bodyrock'); ?></th>
          <td>
            <fieldset><legend class="screen-reader-text"><span><?php _e('Google Analytics ID', 'bodyrock'); ?></span></legend>
              <input type="text" name="bodyrock_theme_options[google_analytics_id]" id="google_analytics_id" value="<?php echo esc_attr($bodyrock_options['google_analytics_id']); ?>" />
              <br />
              <small class="description"><?php printf(__('Enter your UA-XXXXX-X ID', 'bodyrock')); ?></small>
            </fieldset>
          </td>
        </tr>

        <tr valign="top"><th scope="row"><?php _e('Enable Root Relative URLs', 'bodyrock'); ?></th>
          <td>
            <fieldset><legend class="screen-reader-text"><span><?php _e('Enable Root Relative URLs', 'bodyrock'); ?></span></legend>
              <select name="bodyrock_theme_options[root_relative_urls]" id="bodyrock_theme_options[root_relative_urls]">
                <option value="yes" <?php selected($bodyrock_options['root_relative_urls'], true); ?>><?php echo _e('Yes', 'bodyrock'); ?></option>
                <option value="no" <?php selected($bodyrock_options['root_relative_urls'], false); ?>><?php echo _e('No', 'bodyrock'); ?></option>
              </select>
            </fieldset>
          </td>
        </tr>

        <tr valign="top"><th scope="row"><?php _e('Cleanup Menu Output', 'bodyrock'); ?></th>
          <td>
            <fieldset><legend class="screen-reader-text"><span><?php _e('Cleanup Menu Output', 'bodyrock'); ?></span></legend>
              <select name="bodyrock_theme_options[clean_menu]" id="bodyrock_theme_options[clean_menu]">
                <option value="yes" <?php selected($bodyrock_options['clean_menu'], true); ?>><?php echo _e('Yes', 'bodyrock'); ?></option>
                <option value="no" <?php selected($bodyrock_options['clean_menu'], false); ?>><?php echo _e('No', 'bodyrock'); ?></option>
              </select>
            </fieldset>
          </td>
        </tr>
		<tr>
		<td><hr></td>
		</tr>
<!--
        <tr valign="top"><th scope="row"><?php _e('Activer jQuery', 'bodyrock'); ?></th>
          <td>
            <fieldset><legend class="screen-reader-text"><span><?php _e('Activer jQuery', 'bodyrock'); ?></span></legend>
              <select name="bodyrock_theme_options[jquery_on]" id="bodyrock_theme_options[jquery_on]">
                <option value="yes" <?php selected($bodyrock_options['jquery_on'], true); ?>><?php echo _e('Yes', 'bodyrock'); ?></option>
                <option value="no" <?php selected($bodyrock_options['jquery_on'], false); ?>><?php echo _e('No', 'bodyrock'); ?></option>
              </select>
            </fieldset>
          </td>
        </tr>
		
		<tr valign="top"><th scope="row"><?php _e('Activer jQuery UI', 'bodyrock'); ?></th>
          <td>
            <fieldset><legend class="screen-reader-text"><span><?php _e('Activer jQuery UI', 'bodyrock'); ?></span></legend>
              <select name="bodyrock_theme_options[jqueryui_on]" id="bodyrock_theme_options[jqueryui_on]">
                <option value="yes" <?php selected($bodyrock_options['jqueryui_on'], true); ?>><?php echo _e('Yes', 'bodyrock'); ?></option>
                <option value="no" <?php selected($bodyrock_options['jqueryui_on'], false); ?>><?php echo _e('No', 'bodyrock'); ?></option>
              </select>
            </fieldset>
          </td>
        </tr>
		
		<tr valign="top"><th scope="row"><?php _e('Activer custom script', 'bodyrock'); ?></th>
          <td>
            <fieldset><legend class="screen-reader-text"><span><?php _e('Activer custom script', 'bodyrock'); ?></span></legend>
              <select name="bodyrock_theme_options[customsrc]" id="bodyrock_theme_options[customsrc]">
                <option value="yes" <?php selected($bodyrock_options['customsrc'], true); ?>><?php echo _e('Yes', 'bodyrock'); ?></option>
                <option value="no" <?php selected($bodyrock_options['customsrc'], false); ?>><?php echo _e('No', 'bodyrock'); ?></option>
              </select>
			<p>/js/customscr.js</p>
            </fieldset>
          </td>
        </tr>
-->
      </table>

      <?php submit_button(); ?>
    </form>
  </div>

  <?php
}

function bodyrock_theme_options_validate($input) {
  global $bodyrock_css_frameworks;
  $output = $defaults = bodyrock_get_default_theme_options();

  if (isset($input['css_framework']) && array_key_exists($input['css_framework'], $bodyrock_css_frameworks))
    $output['css_framework'] = $input['css_framework'];

  if (isset($input['google_analytics_id'])) {
    if (preg_match('/^ua-\d{4,9}-\d{1,4}$/i', $input['google_analytics_id'])) {
      $output['google_analytics_id'] = $input['google_analytics_id'];
    }
  }

  if (isset($input['root_relative_urls'])) {
    if ($input['root_relative_urls'] === 'yes') {
      $input['root_relative_urls'] = true;
    }
    if ($input['root_relative_urls'] === 'no') {
      $input['root_relative_urls'] = false;
    }
    $output['root_relative_urls'] = $input['root_relative_urls'];
  }

  if (isset($input['clean_menu'])) {
    if ($input['clean_menu'] === 'yes') {
      $input['clean_menu'] = true;
    }
    if ($input['clean_menu'] === 'no') {
      $input['clean_menu'] = false;
    }
    $output['clean_menu'] = $input['clean_menu'];
  }
  
  if (isset($input['jquery_on'])) {
    if ($input['jquery_on'] === 'yes') {
      $input['jquery_on'] = true;
    }
    if ($input['jquery_on'] === 'no') {
      $input['jquery_on'] = false;
    }
    $output['jquery_on'] = $input['jquery_on'];
  }
  
  if (isset($input['jqueryui_on'])) {
    if ($input['jqueryui_on'] === 'yes') {
      $input['jqueryui_on'] = true;
    }
    if ($input['jqueryui_on'] === 'no') {
      $input['jqueryui_on'] = false;
    }
    $output['jqueryui_on'] = $input['jqueryui_on'];
  }
  
  if (isset($input['customsrc'])) {
    if ($input['customsrc'] === 'yes') {
      $input['customsrc'] = true;
    }
    if ($input['customsrc'] === 'no') {
      $input['customsrc'] = false;
    }
    $output['customsrc'] = $input['customsrc'];
  }

  return apply_filters('bodyrock_theme_options_validate', $output, $input, $defaults);
}

?>
