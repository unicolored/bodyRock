<?php

/**
* Class Name: wp_bootstrap_navwalker
* GitHub URI: https://github.com/twittem/wp-bootstrap-navwalker
* Description: A custom WordPress nav walker class to implement the Twitter Bootstrap 2.3.2 navigation style in a custom theme using the WordPress built in menu manager.
* Version: 2.0.2
* Author: Edward McIntyre - @twittem
* License: GPL-2.0+
* License URI: http://www.gnu.org/licenses/gpl-2.0.txt
*/

class wp_bootstrap_navwalker extends Walker_Nav_Menu {

    
	/**
	* @see Walker::start_el()
	* @since 3.0.0
	*
	* @param string $output Passed by reference. Used to append additional content.
	* @param object $item Menu item data object.
	* @param int $depth Depth of menu item. Used for padding.
	* @param int $current_page Menu item ID.
	* @param object $args
	*/
	
    function start_el( &$output, $item, $depth, $args ) {
        $class_names = $value = '';     
        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;
        
        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );

        $active = false;
        if(in_array('current-menu-item', $classes)) { $active = ' current'; }
        
        $class_names = ' class="' . esc_attr( $class_names ) . '"';
        
        $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
        $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';
        
        //$output .= $indent . '<li' . $id . $value . $class_names .'>';
        $output .= $indent . '<li' . $id . $value .'>';
        
        
        // CREATION DES ATTRIBUTS
       //var_dump($item);
        $atts = array();
        $atts['title'] = ! empty( $item->title ) ? $item->title : '';
        $atts['target'] = ! empty( $item->target ) ? $item->target : '';
        $atts['rel'] = ! empty( $item->xfn ) ? $item->xfn : '';
        //$atts['class'] = 'list-group-item '.$active;
        $atts['class'] = $active;
        $atts['href'] = ! empty( $item->url ) ? $item->url : '';
        
        // APPLICATION DES ATTRIBUTS
        $atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args );
        
        $attributes = '';
        foreach ( $atts as $attr => $value ) {
            if ( ! empty( $value ) ) {
                $value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }
        //var_dump($item);
        //$item_output = $args->before;
            $item_output .= '<a'. $attributes .'>';
              $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
            $item_output .= ($args->has_children && $depth === 0) ? ' <span class="caret"></span></a>' : '</a>';
        //$item_output .= $args->after;
        
        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
        
        
    }

	/**
	* Traverse elements to create list from elements.
	*
	* Display one element if the element doesn't have any children otherwise,
	* display the element and its children. Will only traverse up to the max
	* depth and no ignore elements under that depth.
	*
	* This method shouldn't be called directly, use the walk() method instead.
	*
	* @see Walker::start_el()
	* @since 2.5.0
	*
	* @param object $element Data object
	* @param array $children_elements List of elements to continue traversing.
	* @param int $max_depth Max depth to traverse.
	* @param int $depth Depth of current element.
	* @param array $args
	* @param string $output Passed by reference. Used to append additional content.
	* @return null Null on failure with no changes to parameters.
	*/
/*
	function display_element( $element, &$children_elements, $max_depth, $depth, $args, &$output ) {
        if ( !$element ) {
            return;
        }
        
        $id_field = $this->db_fields['id'];

        //display this element
        if ( is_object( $args[0] ) ) {
           $args[0]->has_children = ! empty( $children_elements[$element->$id_field] );
        }
        parent::display_element($element, $children_elements, $max_depth, $depth, $args, $output);
    }
*/
}

?>