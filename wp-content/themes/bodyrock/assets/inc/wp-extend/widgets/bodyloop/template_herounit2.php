<?php
if ($instance["thumb"]) {
    if (get_post_format()=='video') {
        $size="&w=274&h=366&q=100&s=1";
        $videoCode = get_post_meta(get_the_ID(), 'videoCode', true);
        $videoType = get_post_meta(get_the_ID(), 'videoType', true);
                
        switch($videoType) {
            case 'vim':
                $hash = unserialize(file_get_contents("http://vimeo.com/api/v2/video/$videoCode.php"));
                $img= '<img src="/wp-content/themes/bodyrock/inc/libs/timthumb/timthumb.php?src='.$hash[0]['thumbnail_large'].''.$size.'">'; break;
            case 'you': $img= '<img src="/wp-content/themes/bodyrock/inc/libs/timthumb/timthumb.php?src=http://img.youtube.com/vi/'.$videoCode.'/0.jpg'.$size.'">'; break;
        }
        
        $thethumb = '<a class="thumbnail" href="'.get_permalink().'">'.$img.'<hr class="clearfix margin"/>'.get_the_title().'</a>';
        $thethumb = '<span class="thethumb" style="display:block; width:'.$instance['thumb_w'].'px; height:'.$instance['thumb_h'].'px;">'.$img.'</span>';
    }
    elseif (has_post_thumbnail()) {
        $thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID),$instance["imagesize"]);
        $url = ''.$thumbnail[0];
        $plugin_dir = 'advanced-recent-posts-widget';
        $thethumb = '<span class="thethumb"><img src="'.$url.'" alt="'.get_the_title($post->ID).'" /></span>';
    }
}
else $thethumb=false;

if(isset($instance['wrapper'])) { ?>
    <div class="<?php echo $instance['wrapper']; ?>">
<?php } ?>

        <div class="hero-unit recent-post-item">
            <h1><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>" class="post-title"><?php the_title(); ?></a></h1>
            <?php if ( $instance['date'] ) : ?>
                <p class="post-date"><strong><?php the_time("j M Y"); ?></strong></p>
            <?php endif; ?>    
            
            <?php if ( $instance['excerpt'] ) : ?>
                <div class="media">
                    <a href="#">
                        <?php echo $thethumb; ?>
                    </a>
                    <div class="media-body">
                        <?php if ( $instance['readmore'] ) : $linkmore = ' <a href="'.get_permalink().'" class="btn btn-primary btn-large more-link">'.$excerpt_readmore.'</a>'; else: $linkmore =''; endif; ?>
                        <p><?php echo get_the_excerpt(); ?> </p>
                        <p><?php echo $linkmore; ?> </p>
                    </div>
                </div>
            <?php endif; ?>
        
            <?php if ( $instance['comment_num'] ) : ?>
                <p class="comment-num">(<?php comments_number(); ?>)</p>
            <?php endif; ?>
            
        </div>

<?php
if(isset($instance['wrapper'])) { ?>
    </div>
<?php } ?>