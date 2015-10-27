<?php


echo a('article.article');

echo a('header.art-header');
the_title();
echo z('header');

echo a('section.art-content');

if ( ! is_user_logged_in() ) { // Display WordPress login form:
    $args = array(
        'redirect' => admin_url(),
        'form_id' => 'loginform-custom',
        'label_username' => __( 'Username custom text','bodyrock' ),
        'label_password' => __( 'Password custom text','bodyrock' ),
        'label_remember' => __( 'Remember Me custom text','bodyrock' ),
        'label_log_in' => __( 'Log In custom text','bodyrock' ),
        'remember' => true
    );
    wp_login_form( $args );
} else { // If logged in:
    wp_loginout( home_url() ); // Display "Log Out" link.
    echo " | ";
    wp_register('', ''); // Display "Site Admin" link.
}
echo z('section');

echo a('footer.art-footer');
echo z('footer');

echo z('article');

?>
