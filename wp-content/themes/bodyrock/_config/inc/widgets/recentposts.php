<?php
/*
Plugin Name: Advanced Recent Posts Widget
Plugin URI: http://www.safiweb.co.ke/plugins/safiweb-recent-posts-widget
Description: Adds a widget that can display recent posts from multiple categories or from custom post types.
Version: 1.1a
Author: Anthony Webbs
Author URI: http://www.safiweb.co.ke
*/
/*  Copyright 2011  Safiweb Interactive  (email : anthony@safiweb.co.ke/ukwelister@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

class bodyrock_recentposts extends WP_Widget {
	
	/** constructor */	
	function bodyrock_recentposts() {		
		$widget_ops = array(
		'description' => 'Display recent posts'
		//'classname' => 'nomdelaclasse'
		);
    	parent::WP_Widget(false, __('Bodyrock: Recent posts', 'bodyrock'), $widget_ops);
	}


	function widget($args, $instance) {
           

			extract( $args );

		
			$title = apply_filters( 'widget_title', empty($instance['title']) ? 'Recent Posts' : $instance['title'], $instance, $this->id_base);	
			
			if ( ! $number = absint( $instance['number'] ) ) $number = 5;
			
			if ( ! $excerpt_length = absint( $instance['excerpt_length'] ) ) $excerpt_length = 5;
			
			if( ! $cats = $instance["cats"] )  $cats='';
			
			if( ! $show_type = $instance["show_type"] )  $show_type='post';
			
			if( ! $thumb_h =  absint($instance["thumb_h"] ))  $thumb_h=50;
			
			if( ! $thumb_w =  absint($instance["thumb_w"] ))  $thumb_w=50;
			
			if( ! $excerpt_readmore = $instance["excerpt_readmore"] )  $excerpt_readmore='Read more &rarr;';
			
			$default_sort_orders = array('date', 'title', 'comment_count', 'rand');
			
			  if ( in_array($instance['sort_by'], $default_sort_orders) ) {
			
				$sort_by = $instance['sort_by'];
			
				$sort_order = (bool) $instance['asc_sort_order'] ? 'ASC' : 'DESC';
			
			  } else {
			
				// by default, display latest first
			
				$sort_by = 'date';
			
				$sort_order = 'DESC';
			
			  }
			
			
			
			
			
			//Excerpt more filter
            $new_excerpt_more= create_function('$more', 'return " ";');	
			add_filter('excerpt_more', $new_excerpt_more);
			
			
			
			// Excerpt length filter
			$new_excerpt_length = create_function('$length', "return " . $excerpt_length . ";");
			
			if ( $instance["excerpt_length"] > 0 ) add_filter('excerpt_length', $new_excerpt_length);
			
			
			// post info array.
			
			$my_args=array(
						   
				'showposts' => $number,
			
				'category__in'=> $cats,
			
				'orderby' => $sort_by,
			
				'order' => $sort_order,
				
				'post_type' => $show_type 
				
				);
			
			
			
			$adv_recent_posts = null;
			
			$adv_recent_posts = new WP_Query($my_args);
			
			
			
			echo $before_widget;
			
			
			
			// Widget title
			
			echo $before_title;
			
			echo $instance["title"];
			
			echo $after_title;
			
			
			
			// Post list
			
			echo "<ul>\n";
			
		

		while ( $adv_recent_posts->have_posts() )

		{

			$adv_recent_posts->the_post();

		?>

			<li class="recent-post-item">

				<a  href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent link to <?php the_title_attribute(); ?>" class="post-title"><?php the_title(); ?></a>

					<?php if ( $instance['date'] ) : ?>

				<p class="post-date"><?php the_time("j M Y"); ?></p>

				<?php endif; ?>
                <?php if ( $instance['excerpt'] || $instance["thumb"] ) : ?>
				<div class="post-entry">
				<?php

					if (

						function_exists('the_post_thumbnail') &&

						current_theme_supports("post-thumbnails") &&

						$instance["thumb"] &&

						has_post_thumbnail()

					) :
					
					  $thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID),'full');
					  $plugin_dir = 'advanced-recent-posts-widget';
				?>

					<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">

					<img src="<?php echo WP_PLUGIN_URL . '/' . $plugin_dir .'/'.'timthumb/thumb.php?src='. $thumbnail[0] .'&h='.$thumb_h.'&w='.$thumb_w.'&z=0'; ?>" alt="<?php the_title_attribute(); ?>" width="<?php echo $thumb_w; ?>" height="<?php echo $thumb_h; ?>" />

					</a>

				<?php endif; ?>



			

				

				<?php if ( $instance['excerpt'] ) : ?>
                <?php if ( $instance['readmore'] ) : $linkmore = ' <a href="'.get_permalink().'" class="more-link">'.$excerpt_readmore.'</a>'; else: $linkmore =''; endif; ?>
				<p><?php echo get_the_excerpt() . $linkmore; ?> </p>

				<?php endif; ?>
			  </div>
				<?php endif; ?>


				<?php if ( $instance['comment_num'] ) : ?>

				<p class="comment-num">(<?php comments_number(); ?>)</p>

				<?php endif; ?>

			</li>

		<?php

		}

		 wp_reset_query();

		echo "</ul>\n";

		

		echo $after_widget;


       
		remove_filter('excerpt_length', $new_excerpt_length);
        remove_filter('excerpt_more', $new_excerpt_more);
			

	}
	
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
        $instance['cats'] = $new_instance['cats'];
		$instance['sort_by'] = esc_attr($new_instance['sort_by']);
		$instance['show_type'] = esc_attr($new_instance['show_type']);
		$instance['asc_sort_order'] = esc_attr($new_instance['asc_sort_order']);
		$instance['number'] = absint($new_instance['number']);
		$instance["thumb"] = esc_attr($new_instance['thumb']);
        $instance['date'] =esc_attr($new_instance['date']);
        $instance['comment_num']=esc_attr($new_instance['comment_num']);
		$instance["excerpt_length"]=absint($new_instance["excerpt_length"]);
		$instance["excerpt_readmore"]=esc_attr($new_instance["excerpt_readmore"]);
		$instance["thumb_w"]=absint($new_instance["thumb_w"]);
		$instance["thumb_h"]=absint($new_instance["thumb_h"]);
		$instance["excerpt"]=esc_attr($new_instance["excerpt"]);
		$instance["readmore"]=esc_attr($new_instance["readmore"]);
		return $instance;
	}
	
	
	
	function form( $instance ) {
		$title = isset($instance['title']) ? esc_attr($instance['title']) : 'Recent Posts';
		$number = isset($instance['number']) ? absint($instance['number']) : 5;
		$thumb_h = isset($instance['thumb_h']) ? absint($instance['thumb_h']) : 50;
		$thumb_w = isset($instance['thumb_w']) ? absint($instance['thumb_w']) : 50;
		$show_type = isset($instance['show_type']) ? esc_attr($instance['show_type']) : 'post';
		$excerpt_length = isset($instance['excerpt_length']) ? absint($instance['excerpt_length']) : 5;
		$excerpt_readmore = isset($instance['excerpt_readmore']) ? esc_attr($instance['excerpt_readmore']) : 'Read more &rarr;';
?>
        <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>
        
        <p>
        
            <label for="<?php echo $this->get_field_id("sort_by"); ?>">
        
        <?php _e('Sort by');	 ?>:
        
        <select id="<?php echo $this->get_field_id("sort_by"); ?>" name="<?php echo $this->get_field_name("sort_by"); ?>">
        
          <option value="date"<?php selected( $instance["sort_by"], "date" ); ?>>Date</option>
        
          <option value="title"<?php selected( $instance["sort_by"], "title" ); ?>>Title</option>
        
          <option value="comment_count"<?php selected( $instance["sort_by"], "comment_count" ); ?>>Number of comments</option>
        
          <option value="rand"<?php selected( $instance["sort_by"], "rand" ); ?>>Random</option>
        
        </select>
        
            </label>
        
        </p>
        
        
        <p>
        
            <label for="<?php echo $this->get_field_id("asc_sort_order"); ?>">
        
        <input type="checkbox" class="checkbox" 
        
          id="<?php echo $this->get_field_id("asc_sort_order"); ?>" 
        
          name="<?php echo $this->get_field_name("asc_sort_order"); ?>"
        
          <?php checked( (bool) $instance["asc_sort_order"], true ); ?> />
        
                <?php _e( 'Reverse sort order (ascending)' ); ?>
        
            </label>
        
        </p>
        
        
        
        
        <p>
        
            <label for="<?php echo $this->get_field_id("excerpt"); ?>">
        
                <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id("excerpt"); ?>" name="<?php echo $this->get_field_name("excerpt"); ?>"<?php checked( (bool) $instance["excerpt"], true ); ?> />
        
                <?php _e( 'Include post excerpt' ); ?>
        
            </label>
        
        </p>
        
        
        
        <p>
        
            <label for="<?php echo $this->get_field_id("excerpt_length"); ?>">
        
                <?php _e( 'Excerpt length (in words):' ); ?>
        
            </label>
        
            <input style="text-align: center;" type="text" id="<?php echo $this->get_field_id("excerpt_length"); ?>" name="<?php echo $this->get_field_name("excerpt_length"); ?>" value="<?php echo $excerpt_length; ?>" size="3" />
        
        </p>
        
        <p>
        
            <label for="<?php echo $this->get_field_id("readmore"); ?>">
        
                <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id("readmore"); ?>" name="<?php echo $this->get_field_name("readmore"); ?>"<?php checked( (bool) $instance["readmore"], true ); ?> />
        
                <?php _e( 'Include read more link in excerpt' ); ?>
        
            </label>
        
        </p>
        
        <p>
        
            <label for="<?php echo $this->get_field_id("excerpt_readmore"); ?>">
        
                <?php _e( 'Excerpt read more text:' ); ?>
        
            </label>
        
            <input style="text-align: center;" type="text" id="<?php echo $this->get_field_id("excerpt_readmore"); ?>" name="<?php echo $this->get_field_name("excerpt_readmore"); ?>" value="<?php echo $excerpt_readmore; ?>" size="10" />
        
        </p>
        <p>
        
            <label for="<?php echo $this->get_field_id("date"); ?>">
        
                <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id("date"); ?>" name="<?php echo $this->get_field_name("date"); ?>"<?php checked( (bool) $instance["date"], true ); ?> />
        
                <?php _e( 'Include post date' ); ?>
        
            </label>
        
        </p>
        
        
        <p>
        
            <label for="<?php echo $this->get_field_id("comment_num"); ?>">
        
                <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id("comment_num"); ?>" name="<?php echo $this->get_field_name("comment_num"); ?>"<?php checked( (bool) $instance["comment_num"], true ); ?> />
        
                <?php _e( 'Show number of comments' ); ?>
        
            </label>
        
        </p>
        
        <p><label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of posts to show:'); ?></label>
        <input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>
        
        <?php if ( function_exists('the_post_thumbnail') && current_theme_supports("post-thumbnails") ) : ?>
        
        <p>
        
            <label for="<?php echo $this->get_field_id("thumb"); ?>">
        
                <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id("thumb"); ?>" name="<?php echo $this->get_field_name("thumb"); ?>"<?php checked( (bool) $instance["thumb"], true ); ?> />
        
                <?php _e( 'Show post thumbnail' ); ?>
        
            </label>
        
        </p>
        
        <p>
        
            <label>
        
                <?php _e('Thumbnail dimensions'); ?>:<br />
        
                <label for="<?php echo $this->get_field_id("thumb_w"); ?>">
        
                    W: <input class="widefat" style="width:40%;" type="text" id="<?php echo $this->get_field_id("thumb_w"); ?>" name="<?php echo $this->get_field_name("thumb_w"); ?>" value="<?php echo $thumb_w; ?>" />
        
                </label>
        
                
        
                <label for="<?php echo $this->get_field_id("thumb_h"); ?>">
        
                    H: <input class="widefat" style="width:40%;" type="text" id="<?php echo $this->get_field_id("thumb_h"); ?>" name="<?php echo $this->get_field_name("thumb_h"); ?>" value="<?php echo $thumb_h; ?>" />
        
                </label>
        
            </label>
        
        </p>
        
        <?php endif; ?>
        
         <p>
            <label for="<?php echo $this->get_field_id('cats'); ?>"><?php _e('Categories:');?> 
            
                <?php
                   $categories=  get_categories('hide_empty=0');
                     echo "<br/>";
                     foreach ($categories as $cat) {
                         $option='<input type="checkbox" id="'. $this->get_field_id( 'cats' ) .'[]" name="'. $this->get_field_name( 'cats' ) .'[]"';
                            if (is_array($instance['cats'])) {
                                foreach ($instance['cats'] as $cats) {
                                    if($cats==$cat->term_id) {
                                         $option=$option.' checked="checked"';
                                    }
                                }
                            }
                            $option .= ' value="'.$cat->term_id.'" />';
        
                            $option .= $cat->cat_name;
                            
                            $option .= '<br />';
                            echo $option;
                         }
                    
                    ?>
            </label>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('show_type'); ?>"><?php _e('Show Post Type:');?> 
                <select class="widefat" id="<?php echo $this->get_field_id('show_type'); ?>" name="<?php echo $this->get_field_name('show_type'); ?>">
                <?php
                    global $wp_post_types;
                    foreach($wp_post_types as $k=>$sa) {
                        if($sa->exclude_from_search) continue;
                        echo '<option value="' . $k . '"' . selected($k,$show_type,true) . '>' . $sa->labels->name . '</option>';
                    }
                ?>
                </select>
            </label>
        </p>
<?php
	}
}

// register bodyrock_recentposts widget
register_widget('bodyrock_recentposts');
?>