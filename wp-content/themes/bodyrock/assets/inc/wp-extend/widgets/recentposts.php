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
		);
    	parent::WP_Widget(false, __('Bodyrock: Articles récents', 'bodyrock'), $widget_ops);
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
            'showposts' => $number+$instance['jump'],
            'category__in'=> $cats,			
            'orderby' => $sort_by,			
            'order' => $sort_order,				
            'post_type' => $show_type				
            );
        
        $adv_recent_posts = null;			
        $adv_recent_posts = new WP_Query($my_args);			



        if(isset($instance['class'])) { ?>
                <?php echo $instance['template']=='liste' || $instance['template']=='medialiste' || $instance['template']=='minimedialiste' ? '<ul' : '<div' ?> class="<?php echo $instance['template']=='medialiste' ? 'media-liste' : false; ?> <?php echo $instance['class']; ?>">
            <?php } 

        echo $before_widget;
		echo isset($title) ? $before_title.$title.$after_title : false;
		echo a('ul');
        // Post list			
        $c=1;
        while ( $adv_recent_posts->have_posts() )
        {
            $adv_recent_posts->the_post();
            if($c>$instance['jump']) {
                switch($instance['template']) {
                    default :
                    case 'liste' :
        
                         
                        ?>
                            <li>
                                <?php
                                if ($instance["thumb"] &&
                                        function_exists('the_post_thumbnail') &&
                                        current_theme_supports("post-thumbnails") &&
                                        has_post_thumbnail()
                                    ) {
                                      $thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID),$instance["thumb"]);
                                      $url = 'http://senzu.fr/gh'.$thumbnail[0];
                                      $plugin_dir = 'advanced-recent-posts-widget'; 
                                    ?>
                                    <?php $thethumb = '<span class="thethumb"><img src="'.$url.'" alt="'.get_the_title($post->ID).'" /></span>' ?>
                                <?php } else $thethumb=false; ?>
                            
                                <a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>" class="post-title"><?php echo $thethumb; the_title(); ?></a>
                                
                                <?php if ( $instance['date'] ) : ?>
                                    <p class="post-date"><?php the_time("j M Y"); ?></p>
                                <?php endif; ?>
                                
                                <?php if ( $instance['excerpt'] ) : ?>
                                    <div class="post-entry">
                                        <?php if ( $instance['readmore'] ) : $linkmore = ' <a href="'.get_permalink().'" class="more-link">'.$excerpt_readmore.'</a>'; else: $linkmore =''; endif; ?>
                                        <p><?php echo get_the_excerpt() . $linkmore; ?> </p>
                                    </div>
                                <?php endif; ?>
                
                                <?php if ( $instance['comment_num'] ) : ?>
                                    <p class="comment-num">(<?php comments_number(); ?>)</p>
                                <?php endif; ?>
                            </li>
                        <?php       
        
                    break;
                    
                    case 'herounit' : require 'recentposts/template_herounit.php'; break;
                    case 'media' : require 'recentposts/template_media.php'; break;
                    case 'medialiste' : require 'recentposts/template_medialiste.php'; break;
                    case 'minimedialiste' : require 'recentposts/template_minimedialiste.php'; break;
                }
            }
            $c++;
        }
		echo z('ul');
		
        wp_reset_query();
        
        if(isset($instance['class'])) { ?>
                <?php echo $instance['template']=='liste' || $instance['template']=='medialiste' || $instance['template']=='minimedialiste' ? '</ul>' : '</div>' ?>
            <?php }
            
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
		$instance["template"]=esc_attr($new_instance["template"]);
        $instance["thumb_pull"]=esc_attr($new_instance["thumb_pull"]);
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
        <style>
            .ofthewidget fieldset {
                border-bottom:1px dotted #333; margin:1em 0; padding:1em 0;
            }
            .ofthewidget fieldset legend {
                color:#ddd; background:#333; display:block; width:auto; padding:0.2em 1em;
            }
            .ofthewidget fieldset p.tabulate {
                padding:0; padding-left:2em; margin:0;
            }
        </style>
        <div class="ofthewidget">
        <fieldset>
            <p>
                <label for="<?php echo $this->get_field_id('title'); ?>">
                    <?php _e('Titre du widget'); ?>
                    <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
                </label>
            </p>
            <p>
                <label for="<?php echo $this->get_field_id("class"); ?>"><?php _e( 'Classe' ); ?></label>
                <input type="text" id="<?php echo $this->get_field_id("class"); ?>" name="<?php echo $this->get_field_name("class"); ?>" value="<?php echo $class; ?>" />
            <p>
        </fieldset>
        
        <fieldset><legend>Tri</legend>
            <p>
                <label for="<?php echo $this->get_field_id('number'); ?>">
                    <?php _e('Nombre d\'articles à afficher :'); ?>
                    <input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" size="3" />                
                    <?php if ( function_exists('the_post_thumbnail') && current_theme_supports("post-thumbnails") ) : ?>
                </label>
            </p>
        
            <p>
                <label for="<?php echo $this->get_field_id("sort_by"); ?>">
                    <?php _e('Trier par');?>
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
                    <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id("asc_sort_order"); ?>" name="<?php echo $this->get_field_name("asc_sort_order"); ?>" <?php checked( (bool) $instance["asc_sort_order"], true ); ?> />
                    <?php _e( 'Inverser l\'ordre (ascendant)' ); ?>
                </label>
            </p>
            
        </fieldset>        
        
        <fieldset><legend>Affichage</legend>
            <p>
                <label for="<?php echo $this->get_field_id("template"); ?>">                
                    <?php _e('Modèle');	 ?>:               
                    <select id="<?php echo $this->get_field_id("template"); ?>" name="<?php echo $this->get_field_name("template"); ?>">
                        <option value="liste"<?php selected( $instance["template"], "liste" ); ?>>Liste</option>
                        <option value="media"<?php selected( $instance["template"], "media" ); ?>>BS*Media</option>
                        <option value="medialiste"<?php selected( $instance["template"], "medialiste" ); ?>>BS*Media Liste</option>
                        <option value="herounit"<?php selected( $instance["template"], "herounit" ); ?>>BS*Hero Unit</option>
                    </select>
                </label>    
            </p>
            
            <p>
                <label for="<?php echo $this->get_field_id("wrapper"); ?>"><?php _e( 'Enveloppe' ); ?></label>
                <input type="text" id="<?php echo $this->get_field_id("wrapper"); ?>" name="<?php echo $this->get_field_name("wrapper"); ?>" value="<?php echo $wrapper; ?>" />
                <br />
                <small>Sauf templates <em>Liste</em> et <em>Media Liste</em></small>
            <p>
        
                <label for="<?php echo $this->get_field_id("excerpt"); ?>">
            
                    <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id("excerpt"); ?>" name="<?php echo $this->get_field_name("excerpt"); ?>"<?php checked( (bool) $instance["excerpt"], true ); ?> />
            
                    <?php _e( 'Inclure un extrait' ); ?>
            
                </label>
                
                <p class="tabulate">
                
                    <label for="<?php echo $this->get_field_id("excerpt_length"); ?>">
                
                        <?php _e( 'Nombre de mots :' ); ?>
                
                    </label>
                
                    <input style="text-align: center;" type="text" id="<?php echo $this->get_field_id("excerpt_length"); ?>" name="<?php echo $this->get_field_name("excerpt_length"); ?>" value="<?php echo $excerpt_length; ?>" size="3" />
                
                </p>
            </p>
            

        
            <p>
        
                <label for="<?php echo $this->get_field_id("readmore"); ?>">
            
                    <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id("readmore"); ?>" name="<?php echo $this->get_field_name("readmore"); ?>"<?php checked( (bool) $instance["readmore"], true ); ?> />
            
                    <?php _e( 'Inclure un lien "Lire la suite"' ); ?>
            
                </label>
            
                <p class="tabulate">
            
                    <label for="<?php echo $this->get_field_id("excerpt_readmore"); ?>">
                
                        <?php _e( 'Texte :' ); ?>
                
                    </label>
                
                    <input class="widefat" type="text" id="<?php echo $this->get_field_id("excerpt_readmore"); ?>" name="<?php echo $this->get_field_name("excerpt_readmore"); ?>" value="<?php echo $excerpt_readmore; ?>" size="10" />
                
                </p>
            
            </p>
        
        
            <p>
            
                <label for="<?php echo $this->get_field_id("date"); ?>">
            
                    <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id("date"); ?>" name="<?php echo $this->get_field_name("date"); ?>"<?php checked( (bool) $instance["date"], true ); ?> />
            
                    <?php _e( 'Afficher la date' ); ?>
            
                </label>
            
            </p>
        
        
            <p>
            
                <label for="<?php echo $this->get_field_id("comment_num"); ?>">
            
                    <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id("comment_num"); ?>" name="<?php echo $this->get_field_name("comment_num"); ?>"<?php checked( (bool) $instance["comment_num"], true ); ?> />
            
                    <?php _e( 'Afficher le nombre de commentaires' ); ?>
            
                </label>
            
            </p>
        </fieldset>
        <fieldset><legend>Vignette</legend>
        
            <p>
                <label for="<?php echo $this->get_field_id("thumb"); ?>">
            
                    <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id("thumb"); ?>" name="<?php echo $this->get_field_name("thumb"); ?>"<?php checked( (bool) $instance["thumb"], true ); ?> />
            
                    <?php _e( 'Afficher la vignette' ); ?>
            
                </label>
                <p class="tabulate">
                    <label for="<?php echo $this->get_field_id("thumb_pull"); ?>">                
                        <?php _e('Flottement');	 ?>:               
                        <select id="<?php echo $this->get_field_id("thumb_pull"); ?>" name="<?php echo $this->get_field_name("thumb_pull"); ?>">
                            <option value="aucun"<?php selected( $instance["thumb_pull"], "aucun" ); ?>>Aucun</option>
                            <option value="gauche"<?php selected( $instance["thumb_pull"], "gauche" ); ?>>Gauche</option>
                            <option value="droite"<?php selected( $instance["thumb_pull"], "droite" ); ?>>Droite</option>
                        </select>
                    </label>
                    <br />
                    <br />
                    <label>        
                        <?php _e('Dimensions'); ?>
                        <select class="widefat" id="<?php echo $this->get_field_id('imagesize'); ?>" name="<?php echo $this->get_field_name('imagesize'); ?>">
                        <?php
                            $images_sizes = get_intermediate_image_sizes();
                            foreach($images_sizes as $k=>$sa) {
                                echo $sa;
                                //if($sa->exclude_from_search) continue;
                                echo '<option value="' . $k . '"' . selected($k,$imagesize,true) . '>' . $sa . ' :: '.get_option( $sa.'_size_w' ).'x'.get_option( $sa.'_size_h' ).'px</option>';
                            }
                        ?>
                        </select>
                    </label>        
                </p>
        
            </p>
        
            <?php endif; ?>
        </fieldset>
        
        <fieldset><legend>Sélection</legend>
            <p>
                <label for="<?php echo $this->get_field_id("jump"); ?>"><?php _e( 'Jump' ); ?></label>
                <input type="text" id="<?php echo $this->get_field_id("jump"); ?>" name="<?php echo $this->get_field_name("jump"); ?>" value="<?php echo $jump; ?>" />
            <p>
        
            <p>
                <label for="<?php echo $this->get_field_id('show_type'); ?>"><?php _e('Afficher le type d\'article :');?> 
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
            <p>
                <label for="<?php echo $this->get_field_id('cats'); ?>"><?php _e('Catégories :');?> 
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
        </fieldset>
         
        </div>
<?php
	}
}
?>