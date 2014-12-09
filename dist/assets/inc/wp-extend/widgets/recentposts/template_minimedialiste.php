<?php  if ($instance["thumb"] &&
                                        function_exists('the_post_thumbnail') &&
                                        current_theme_supports("post-thumbnails") &&
                                        has_post_thumbnail()
                                    ) {
                                      $thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID),$instance["thumb"]);
                                      $url = 'http://senzu.fr/gh'.$thumbnail[0];
                                      $plugin_dir = 'advanced-recent-posts-widget'; 
                                    ?>
                                    <?php $thethumb = '<span class="thethumb" style="display:block; width:'.$instance['thumb_w'].'px; height:'.$instance['thumb_h'].'px;"><img src="'.$url.'" style="width:'.$thumbnail[1].'px; height='.$thumbnail[2].'px" width="'.$thumbnail[1].'" height="'.$thumbnail[2].'" alt="'.get_the_title($post->ID).'" /></span>' ?>
                                <?php } else $thethumb=false; ?>

<?php
/*
if ($instance["thumb"] && has_post_thumbnail()) {
  $thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID),$instance["imagesize"]);
  $url = ''.$thumbnail[0];
  $plugin_dir = 'advanced-recent-posts-widget';
  $thethumb = '<span class="thethumb" style="display:block; width:'.$instance['thumb_w'].'px; height:'.$instance['thumb_h'].'px;"><img style="width:'.$thumbnail[1].'px; height='.$thumbnail[2].'px" width="'.$thumbnail[1].'" height="'.$thumbnail[2].'" alt="'.get_the_title().'" src="'.$url.'" alt="'.get_the_title($post->ID).'" /></span>';
} else $thethumb=false;
*/

?>

        <li class="media recent-post-item">
            <a class="<?php echo $instance['thumb_pull']!='aucun' ? 'pull-'.$instance['thumb_pull'] : false ?>" href="#">
                <?php echo $thethumb; ?>
            </a>
            <div class="media-body">
                <h4 class="media-heading"><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>" class="post-title"><?php the_title(); ?></a></h4>
                <?php if ( $instance['date'] ) : ?>
                    <p class="post-date"><strong><?php the_time("j M Y"); ?></strong></p>
                <?php endif; ?>
                <?php if ( $instance['readmore'] ) : $linkmore = ' <a href="'.get_permalink().'" class="more-link">'.$excerpt_readmore.'</a>'; else: $linkmore =''; endif; ?>
                <p><?php echo $linkmore; ?> </p>
                <?php if ( $instance['comment_num'] ) : ?>
                    <p class="comment-num">(<?php comments_number(); ?>)</p>
                <?php endif; ?>
            </div>
        </li>
