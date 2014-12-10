<?php  if ($instance["thumb"] &&
            function_exists('the_post_thumbnail') &&
            current_theme_supports("post-thumbnails") &&
            has_post_thumbnail()
        ) {
            if($$instance["thumbnail"]==false) $instance["thumbnail"]='thumbnail';
          $thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID),$instance["thumbnail"]);
          $url = 'http://senzu.fr/gh'.$thumbnail[0];
          $plugin_dir = 'advanced-recent-posts-widget'; 
        ?>
        <?php $thethumb = '<span class="thethumb" style="display:block;"><img class="media-object" src="'.$url.'" style="width:'.$thumbnail[1].'px; height='.$thumbnail[2].'px" width="'.$thumbnail[1].'" height="'.$thumbnail[2].'" alt="'.get_the_title($post->ID).'" /></span>' ?>
    <?php } else $thethumb=false; ?>

        <li class="media recent-post-item">
            <?php if ($instance["thumb"]) : ?>
            <a class="<?php echo $instance['thumb_pull']!='aucun' ? 'pull-'.$instance['thumb_pull'] : false ?>" href="#">
                <?php echo $thethumb; ?>
            </a>
            <?php endif; ?>
            <div class="media-body">
                <h4 class="media-heading"><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>" class="post-title"><?php the_title(); ?></a></h4>
                <?php if ( $instance['date'] ) : ?>
                    <p class="post-date"><strong><?php the_time("j M Y"); ?></strong></p>
                <?php endif; ?>
                <?php if ( $instance['readmore'] ) : $linkmore = ' <a href="'.get_permalink().'" class="more-link">'.$excerpt_readmore.'</a>'; else: $linkmore =''; endif; ?>
                <?php if ( $instance['excerpt'] ) : ?>
                    <p><?php echo get_the_excerpt(); ?> </p>
                <?php endif; ?>
                <?php echo $linkmore; ?>
                <?php if ( $instance['comment_num'] ) : ?>
                    <p class="comment-num">(<?php comments_number(); ?>)</p>
                <?php endif; ?>
            </div>
        </li>
