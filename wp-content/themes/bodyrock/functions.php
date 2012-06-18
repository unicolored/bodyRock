<?php
require_once '_myconfig.php';  // 
if(!is_child_theme()) {
function auto_compile_less($less_fname, $css_fname) {
  // load the cache
  $cache_fname = $less_fname.".cache";
  if (file_exists($cache_fname)) {
    $cache = unserialize(file_get_contents($cache_fname));
  } else {
    $cache = $less_fname;
  }

  $new_cache = lessc::cexecute($cache);
  if (!is_array($cache) || $new_cache['updated'] > $cache['updated']) {
    file_put_contents($cache_fname, serialize($new_cache));
    file_put_contents($css_fname, $new_cache['compiled']);
  }
}

auto_compile_less(dirname(__FILE__).'/less/style.less', dirname(__FILE__).'/less/style.css');
auto_compile_less(dirname(__FILE__).'/less/responsive.less', dirname(__FILE__).'/less/responsive.css');
}

?>