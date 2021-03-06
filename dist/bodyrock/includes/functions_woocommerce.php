<?php
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action( 'woocommerce_before_main_content','woocommerce_breadcrumb', 20, 0);
remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar',10);
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

add_action('woocommerce_before_main_content', 'my_theme_wrapper_start', 10);
add_action('woocommerce_after_main_content', 'my_theme_wrapper_end', 10);

add_action('wp_footer', 'custom_demo_store', 10);

/*
add_filter( 'woocommerce_product_single_add_to_cart_text', 'woo_custom_cart_button_text' );
function woo_custom_cart_button_text() {
return __( 'Add to cart', 'woocommerce' );
}
*/
if ( !function_exists( 'my_theme_wrapper_start' ) ) {
  function my_theme_wrapper_start() {
    //echo '<section id="main">';
  }
}
if ( !function_exists( 'my_theme_wrapper_end' ) ) {
  function my_theme_wrapper_end() {
    //echo '</section>';
  }
}

add_action( 'after_setup_theme', 'woocommerce_support' );
if ( !function_exists( 'woocommerce_support' ) ) {
  function woocommerce_support() {
    add_theme_support( 'woocommerce' );
  }
}
if ( !function_exists( 'woocommerce_demo_store' ) ) {
  function woocommerce_demo_store() {
    return;
  }
}
if ( !function_exists( 'custom_demo_store' ) ) {
  function custom_demo_store() {
    if ( !is_store_notice_showing() )
    return;

    $notice = get_option( 'woocommerce_demo_store_notice' );
    if ( empty( $notice ) )
    $notice = __( 'This is a demo store for testing purposes &mdash; no orders shall be fulfilled.', 'woocommerce' );

    echo apply_filters( 'woocommerce_demo_store', '<p class="alert alert-warning text-center" style="margin:0; position:absolute; top:0; width:100%; height:50px;">' . $notice . '</p><style>body { padding-top:50px !important; }</style>'  );
  }
}
