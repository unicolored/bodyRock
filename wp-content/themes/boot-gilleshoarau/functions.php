<?php
require_once('types/projets-type.php');

add_image_size( 'carousel', 850, 570, true );
add_image_size( 'projet-thumb', 370, 171, true );
add_image_size( 'projet-thumbsquare', 100, 100, true );
add_image_size( 'projet-medium', 488, 366, true );
add_image_size( 'projet-large', 850, 570, false );

require_once '_myconfig.php';  // 

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

auto_compile_less(dirname(__FILE__).'/less/style.less', dirname(__FILE__).'/css/style.css');
auto_compile_less(dirname(__FILE__).'/less/responsive.less', dirname(__FILE__).'/css/responsive.css');
auto_compile_less(dirname(__FILE__).'/less/wheel.less', dirname(__FILE__).'/css/wheel.css');

function bootstrap_comment($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment; ?>
   <li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
     <div id="comment-<?php comment_ID(); ?>">
      <div class="comment-author vcard">
         <?php echo get_avatar($comment,$size='48',$default='<path_to_url>' ); ?>

         <?php printf(__('<cite class="fn">%s</cite>'), get_comment_author_link()) ?> | 
		 <a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php printf(__('%1$s at %2$s'), get_comment_date(),  get_comment_time()) ?></a><?php edit_comment_link(__('(Edit)'),'  ','') ?>
      </div>
      <?php if ($comment->comment_approved == '0') : ?>
         <em><?php _e('Your comment is awaiting moderation.') ?></em>
         <br />
      <?php endif; ?>

      <?php comment_text() ?>

      <div class="reply">
         <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
      </div>
     </div>
<?php
}
?>