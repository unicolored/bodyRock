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

class wp_bootstrap_listgroupwalker extends Walker_Nav_Menu {

/**
* @see Walker::start_lvl()
* @since 3.0.0
*
* @param string $output Passed by reference. Used to append additional content.
* @param int $depth Depth of page. Used for padding.
*/
function start_lvl( &$output, $depth = 0, $args = array() ) {
$indent = str_repeat("\t", $depth);
$output = false;
}

function end_lvl( &$output, $depth = 0, $args = array() ) {
	$indent = str_repeat( "\t", $depth );
	$output = "\n";
}
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

function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

/**
* Dividers, Headers or Disabled
* =============================
* Determine whether the item is a Divider, Header, Disabled or regular
* menu item. To prevent errors we use the strcasecmp() function to so a
* comparison that is not case sensitive. The strcasecmp() function returns
* a 0 if the strings are equal.
*/


$classes = empty( $item->classes ) ? array() : (array) $item->classes;

$atts = array();
$atts['title'] = ! empty( $item->title ) ? $item->title : '';
$atts['target'] = ! empty( $item->target ) ? $item->target : '';
$atts['rel'] = ! empty( $item->xfn ) ? $item->xfn : '';
$atts['class'] = 'list-group-item '.(in_array('current-menu-item', $classes) ? ' active' : false);

//If item has_children add atts to a
if($args->has_children && $depth === 0) {
$atts['href'] = '#';
$atts['data-toggle']	= 'dropdown';
$atts['class']	= 'dropdown-toggle';
} else {
$atts['href'] = ! empty( $item->url ) ? $item->url : '';
}

$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args );

$attributes = '';
foreach ( $atts as $attr => $value ) {
if ( ! empty( $value ) ) {
$value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
$attributes .= ' ' . $attr . '="' . $value . '"';
}
}

//$item_output = $args->before;
$item_output = '';

/*
* Glyphicons
* ===========
* Since the the menu item is NOT a Divider or Header we check the see
* if there is a value in the attr_title property. If the attr_title
* property is NOT null we apply it as the class name for the glyphicon.
*/

if(! empty( $item->attr_title )){
$item_output .= '<a'. $attributes .'><span class="glyphicon ' . esc_attr( $item->attr_title ) . '"></span>&nbsp;';
} else {
$item_output .= '<a'. $attributes .'>';
}

//$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
$item_output .= apply_filters( 'the_title', $item->title, $item->ID ) ;
$item_output .= '</a>';
//$item_output .= $args->after;
//var_dump($item);
//return $item_output;
//$this->display_element($item_output,false);
$output .= $item_output;
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

function display_element( $element, &$children_elements, $max_depth, $depth, $args, &$output ) {
        if ( !$element ) {
            return;
        }

        $id_field = $this->db_fields['id'];

        //display this element
        if ( is_object( $args[0] ) ) {
           $args[0]->has_children = ! empty( $children_elements[$element->$id_field] );
        }
		$output=str_replace('</li>','',$output);
//		var_dump($children_elements);
        parent::display_element($element, $children_elements, $max_depth, $depth, $args, $output);
    }
}

?>