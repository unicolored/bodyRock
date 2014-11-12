<?php
if ($instance["thumb"]) {
    if (get_post_format()=='video') {
        $size="&w=480&h=320&q=100&s=1";
        $size="&w=880&h=400&q=100&s=1";
        $videoCode = get_post_meta(get_the_ID(), 'videoCode', true);
        $videoType = get_post_meta(get_the_ID(), 'videoType', true);
                
        switch($videoType) {
            case 'vim':
                $hash = unserialize(file_get_contents("http://vimeo.com/api/v2/video/$videoCode.php"));
                $pathtoimg='/wp-content/themes/bodyrock/inc/libs/timthumb/timthumb.php?src='.$hash[0]['thumbnail_large'].''.$size;
                $img= '<img src="/wp-content/themes/bodyrock/inc/libs/timthumb/timthumb.php?src='.$hash[0]['thumbnail_large'].''.$size.'">'; break;
            case 'you':
                $pathtoimg='/wp-content/themes/bodyrock/inc/libs/timthumb/timthumb.php?src=http://img.youtube.com/vi/'.$videoCode.'/0.jpg'.$size;
                $img= '<img src="/wp-content/themes/bodyrock/inc/libs/timthumb/timthumb.php?src=http://img.youtube.com/vi/'.$videoCode.'/0.jpg'.$size.'">'; break;
        }
        
        $thethumb = '<a class="thumbnail" href="'.get_permalink().'">'.$img.'<hr class="clearfix margin"/>'.get_the_title().'</a>';
        $thethumb = '<span class="thethumb" style="display:block; width:'.$instance['thumb_w'].'px; height:'.$instance['thumb_h'].'px;">'.$img.'</span>';
    }
    elseif (has_post_thumbnail()) {
        $thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID),$instance["imagesize"]);
        $pathtoimg = ''.$thumbnail[0];
        $plugin_dir = 'advanced-recent-posts-widget';
        $thethumb = '<span class="thethumb"><img src="'.$pathtoimg.'" alt="'.get_the_title($post->ID).'" /></span>';
    }
}
else $thethumb=false;
/************************************************************************/
$source_file = 'http://img.youtube.com/vi/'.$videoCode.'/0.jpg';

$im = ImageCreateFromJpeg($source_file); 

$imgw = imagesx($im);
$imgh = imagesy($im);

// n = total number or pixels

$n = $imgw*$imgh;

$histo = array();

for ($i=0; $i<$imgw; $i++)
{
        for ($j=0; $j<$imgh; $j++)
        {
        
            // get the rgb value for current pixel
            
            $rgb = ImageColorAt($im, $i, $j); 
            
            // extract each value for r, g, b
            
            $r = ($rgb >> 16) & 0xFF;
            $g = ($rgb >> 8) & 0xFF;
            $b = $rgb & 0xFF;
            
            // get the Value from the RGB value
            
            $V = round(($r + $g + $b) / 3);
            
            $rTotal += $r;

            $gTotal += $g;

            $bTotal += $b;

            $total++;
            
            // add the point to the histogram
            
            $histo[$V] += $V / $n;
        
        }
}

$rAverage = round($rTotal/$total);

$gAverage = round($gTotal/$total);

$bAverage = round($bTotal/$total);

//echo $rAverage.','.$gAverage.','.$bAverage;

/************************************************************************/

if(isset($instance['wrapper'])) { ?>
    <div class="<?php echo $instance['wrapper']; ?>">
<?php } ?>

        <div class="hero-unit recent-post-item" style=" background-image:url(<?php echo $pathtoimg; ?>); border:1px solid #222; border-color: rgba(<?php echo $rAverage; ?>, <?php echo $gAverage; ?>, <?php echo $bAverage; ?>, 0.5); background-position: center center; background-repeat: no-repeat; position:relative; height:200px; overflow:hidden; margin-bottom:0;">
            
        </div>
        <div class="hero-unit recent-post-item" style=" padding:0.5em 2em; margin:0 auto; border:1px solid #222; border-color: rgba(<?php echo $rAverage; ?>, <?php echo $gAverage; ?>, <?php echo $bAverage; ?>, 0.5);">
        <h1 style="margin:0;"><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>" class="post-title"><?php the_title(); ?></a></h1>
        <?php if ( $instance['date'] ) : ?>
            <p class="post-date"><strong><?php the_time("j M Y"); ?></strong></p>
        <?php endif; ?>    
        
        <?php if ( $instance['excerpt'] ) : ?>
            <div class="">
                <!--<a href="#">
                    <?php echo $thethumb; ?>
                </a>-->
                <div class="">
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