<?php

add_action('bodyrock_google_analytics', 'bodyrock_google_analytics');
add_action('bodyrock_stylesheets', 'bodyrock_get_stylesheets');
add_action('bodyrock_lesssheets', 'bodyrock_get_lesssheets');
add_action('bodyrock_javascripts', 'bodyrock_get_javascripts');
add_action('bodyrock_javascripts_footer', 'bodyrock_get_javascripts_footer');
add_action('bodyrock_post_inside_before', 'bodyrock_page_breadcrumb');

function bodyrock_google_analytics() {
  global $bodyrock_options;
  if($bodyrock_options) :
	  $bodyrock_google_analytics_id = $bodyrock_options['google_analytics_id'];
	  $get_bodyrock_google_analytics_id = esc_attr($bodyrock_options['google_analytics_id']);
	  if ($bodyrock_google_analytics_id !== '') {
		echo "\n\t<script>\n";
		echo "\t\tvar _gaq=[['_setAccount','$get_bodyrock_google_analytics_id'],['_trackPageview'],['_trackPageLoadTime']];\n";
		echo "\t\t(function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];\n";
		echo "\t\tg.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';\n";
		echo "\t\ts.parentNode.insertBefore(g,s)}(document,'script'));\n";
		echo "\t</script>\n";
	  }
	endif;
}
if(!function_exists('bodyrock_get_stylesheets')) :
function bodyrock_get_stylesheets() {
  $styles = '';
	global $styles_css;
	if($styles_css) :
	  if (is_child_theme()) {
		foreach($styles_css as $key=>$val) {
			if($val==1) {
				$styles .= "<link rel=\"stylesheet\" href=\"".$key."\">\n\t";
			}
		}
	  } else {
		foreach($styles_css as $key=>$val) {
			if($val==1) {
				$styles .= "<link rel=\"stylesheet\" href=\"".$key."\">\n\t";
			}
		}
	  }
	
	  echo $styles;
	endif;
}
endif;

if(!function_exists('bodyrock_get_lesssheets')) :
function bodyrock_get_lesssheets() {
  $styles = '';
	global $styles_less;
	if($styles_less) :
	  if (is_child_theme()) {
		foreach($styles_less as $key=>$val) {
			if($val==1) {
				$styles .= "<link rel=\"stylesheet/less\" href=\"".$key."\">\n\t";
			}
		}
	  } else {
		foreach($styles_less as $key=>$val) {
			if($val==1) {
				$styles .= "<link rel=\"stylesheet/less\" href=\"".$key."\">\n\t";
			}
		}
	  }
	
	  echo $styles;
	endif;
}
endif;

function bodyrock_get_javascripts() {
	$scripts = '';
	global $scripts_js;
	if($scripts_js) :
	  if (is_child_theme()) {
		foreach($scripts_js as $key=>$val) {
			if($val==1) {
				$scripts .= script_link_tag($key);
			}
		}
	  } else {
		foreach($scripts_js as $key=>$val) {
			if($val==1) {
				$scripts .= script_link_tag($key);
			}
		}
	  }
	
	  echo $scripts;
	endif;
}
function bodyrock_get_javascripts_footer() {
	$scripts = '';
	global $scripts_js_footer;
	if($scripts_js_footer) :
		if (is_child_theme()) {
			foreach($scripts_js_footer as $key=>$val) {
				if($val==1) {
					$scripts .= script_link_tag($key);
				}
			}
		}
		else {
			foreach($scripts_js_footer as $key=>$val) {
				if($val==1) {
					$scripts .= script_link_tag($key);
				}
			}
		}
	echo $scripts;
		
	endif;
}

function stylesheet_link_tag($file, $tabs = 0, $newline = true) {
  $indent = str_repeat("\t", $tabs);
  return $indent . '<link rel="stylesheet" href="' . get_template_directory_uri() . '/css' . $file . '">' . ($newline ? "\n" : "");
}

function script_link_tag($file, $tabs = 0, $newline = true) {
  $indent = str_repeat("\t", $tabs);
  return $indent . '<script src="' . $file . '"></script>' . ($newline ? "\n" : "");
}

function bodyrock_page_breadcrumb() {
  global $post;
  if (function_exists('yoast_breadcrumb')) {
    if (is_page() && $post->post_parent) {
      yoast_breadcrumb('<p id="breadcrumbs">','</p>');
    }
  }
}

/*FRONT ADD POST*/
function __update_post_meta( $post_id, $field_name, $value = '' )
{
	if ( empty( $value ) OR ! $value )
	{
		delete_post_meta( $post_id, $field_name );
	}
	elseif ( ! get_post_meta( $post_id, $field_name ) )
	{
		add_post_meta( $post_id, $field_name, $value );
	}
	else
	{
		update_post_meta( $post_id, $field_name, $value );
	}
}

?>
