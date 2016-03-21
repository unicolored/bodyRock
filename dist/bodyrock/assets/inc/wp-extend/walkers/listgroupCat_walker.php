<?php

/**
* Class Name: wp_bootstrap_listgroupwalker
* GitHub URI: https://github.com/twittem/wp-bootstrap-navwalker
* Description: A custom WordPress nav walker class to implement the Twitter Bootstrap 2.3.2 navigation style in a custom theme using the WordPress built in menu manager.
* Version: 2.0.2
* Author: Edward McIntyre - @twittem
* License: GPL-2.0+
* License URI: http://www.gnu.org/licenses/gpl-2.0.txt
*/

class wp_bootstrap_listgroupCatwalker extends Walker {
	/**
	* What the class handles.
	*
	* @see Walker::$tree_type
	* @since 2.1.0
	* @var string
	*/
	public $tree_type = 'category';

	/**
	* Database fields to use.
	*
	* @see Walker::$db_fields
	* @since 2.1.0
	* @todo Decouple this
	* @var array
	*/
	public $db_fields = array ('parent' => 'parent', 'id' => 'term_id');



	/**
	* Start the element output.
	*
	* @see Walker::start_el()
	*
	* @since 2.1.0
	*
	* @param string $output   Passed by reference. Used to append additional content.
	* @param object $category Category data object.
	* @param int    $depth    Depth of category in reference to parents. Default 0.
	* @param array  $args     An array of arguments. @see wp_list_categories()
	* @param int    $id       ID of the current category.
	*/
	public function start_el( &$output, $category, $depth = 0, $args = array(), $id = 0 ) {
		/** This filter is documented in wp-includes/category-template.php */
		$cat_name = apply_filters(
			'list_cats',
			esc_attr( $category->name ),
			$category
		);

		// Don't generate an element if the category name is empty.
		if ( ! $cat_name ) {
			return;
		}
		$active = ($category->term_id == get_query_var('cat') ? 'active' : false);
		$link = '<a class="list-group-item '.$active.'" href="' . esc_url( get_term_link( $category ) ) . '" ';
		if ( $args['use_desc_for_title'] && ! empty( $category->description ) ) {
			/**
			* Filter the category description for display.
			*
			* @since 1.2.0
			*
			* @param string $description Category description.
			* @param object $category    Category object.
			*/
			$link .= 'title="' . esc_attr( strip_tags( apply_filters( 'category_description', $category->description, $category ) ) ) . '"';
		}

		$link .= '>';
		$link .= $cat_name . '</a>';


		if ( ! empty( $args['show_count'] ) ) {
			$link .= ' (' . number_format_i18n( $category->count ) . ')';
		}
		if ( 'list' == $args['style'] ) {
			$output .= "\t<li";
			$css_classes = array(
				'cat-item',
				'cat-item-' . $category->term_id,
			);

			if ( ! empty( $args['current_category'] ) ) {
				$_current_category = get_term( $args['current_category'], $category->taxonomy );
				if ( $category->term_id == $args['current_category'] ) {
					$css_classes[] = 'current-cat';
				} elseif ( $category->term_id == $_current_category->parent ) {
					$css_classes[] = 'current-cat-parent';
				}
			}

			/**
			* Filter the list of CSS classes to include with each category in the list.
			*
			* @since 4.2.0
			*
			* @see wp_list_categories()
			*
			* @param array  $css_classes An array of CSS classes to be applied to each list item.
			* @param object $category    Category data object.
			* @param int    $depth       Depth of page, used for padding.
			* @param array  $args        An array of wp_list_categories() arguments.
			*/
			$css_classes = implode( ' ', apply_filters( 'category_css_class', $css_classes, $category, $depth, $args ) );

			$output .=  ' class="' . $css_classes . '"';
			$output .= ">$link\n";
		} else {
			$output .= "\t$link\n";
		}
	}

	/**
	* Ends the element output, if needed.
	*
	* @see Walker::end_el()
	*
	* @since 2.1.0
	*
	* @param string $output Passed by reference. Used to append additional content.
	* @param object $page   Not used.
	* @param int    $depth  Depth of category. Not used.
	* @param array  $args   An array of arguments. Only uses 'list' for whether should append to output. @see wp_list_categories()
	*/
	public function end_el( &$output, $page, $depth = 0, $args = array() ) {
		if ( 'list' != $args['style'] )
			return;

		$output .= "</li>\n";
	}
}

?>
