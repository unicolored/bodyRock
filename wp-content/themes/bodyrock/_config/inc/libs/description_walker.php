<?php # -*- coding: utf-8 -*-
/**
 * Create a nav menu with very basic markup.
 *
 * @author Thomas Scholz http://toscho.de
 * @version 1.0
 */
class description_walker extends Walker_Nav_Menu
{
      function start_el(&$output, $item, $depth, $args)
      {
           global $wp_query;
           $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

           $class_names = $value = '';

           $classes = empty( $item->classes ) ? array() : (array) $item->classes;

           $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
           $class_names = ' class="'. esc_attr( $class_names ) . '"';
		   $class_names = false;
		   
		   $page=get_page( $id );
		   $category_id = get_query_var('cat');
		   $type = get_post_type();
		   switch($item->ID) {
			   case 517 : /* Blog */
					$categories_concernees = array(1,52);
				   if(in_array($category_id,$categories_concernees)) { $class_names=' class="current-menu-item" '; }
				   
				   if($page->ID==508) { $class_names=' class="current-menu-item" '; }
			   break;
			   
			   case 37 : /* Life */
				   $categories_concernees = array(23,47);
				   if(in_array($category_id,$categories_concernees)) { $class_names=' class="current-menu-item" '; }
				   
				   if($page->ID==24 || is_home()) { $class_names=' class="current-menu-item" '; }
			   break;
			   
			   case 570 : /* Coding */				   
				   if($page->ID==547) { $class_names=' class="current-menu-item" '; }
			   break;
			   
			   case 518 : /* A propos */				   
				   if($page->ID==9) { $class_names=' class="current-menu-item" '; }
			   break;
			   
			   case 553 : /* A propos */				   
				   if($type=='projet' || $page->ID==57) { $class_names=' class="current-menu-item" '; }
			   break;
		   }

           $output .= $indent . '<li id="menu-item-'. $item->ID . '"' . $value . $class_names .'>';

           $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
           $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
           $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
           $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';

           $prepend = '<strong>';
           $append = '</strong>';
           $description  = ! empty( $item->description ) ? '<span>'.esc_attr( $item->description ).'</span>' : '';

          /* if($depth != 0)
           {*/
                     $description = $append = $prepend = "";
           /*}*/

            $item_output = $args->before;
            $item_output .= '<a'. $attributes .'>';
            $item_output .= $args->link_before .$prepend.apply_filters( 'the_title', $item->title, $item->ID ).$append;
            $item_output .= $description.$args->link_after;
            $item_output .= '</a>';
            $item_output .= $args->after;

            $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
            }
}