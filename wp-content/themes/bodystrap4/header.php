<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" <?php language_attributes();?>> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" <?php language_attributes();?>> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" <?php language_attributes();?>> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" <?php language_attributes();?>> <!--<![endif]--><head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title><?php wp_title('|', true, 'right'); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="/wp-content/themes/_config/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="/wp-content/themes/_config/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="/wp-content/themes/_config/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="/wp-content/themes/_config/ico/apple-touch-icon-57-precomposed.png">
	
	<?php wp_head(); ?>
	<!--HOLA-->
	<?php bodyrock_stylesheets(); ?>
	<?php bodyrock_lesssheets(); ?>
	<?php bodyrock_javascripts(); ?>
  </head>

  <body data-spy="scroll" data-target=".subnav" data-offset="50">

<div class="container">
  <!-- Navbar ================================================== -->
    <div class="navbar">
      <div class="navbar-inner">
        <div class="container">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="<?php echo home_url( '/' ) ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ) ?>" rel="home"><b class="unid"><span><?php echo get_bloginfo( 'name' ) ?></span></b></a>
          
  			<div class="nav-collapse">
		  	<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
			<div class="pull-right">
            <?php get_search_form() ?>
			</div>
          </div>
		  
		  
        </div>
      </div>
    </div>
</div>
	<div class="container-fluid">