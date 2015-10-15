<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
  <meta charset="<?php echo get_bloginfo( 'charset' ) ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <title><?php wp_title('|', true, 'right'); ?></title>


  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries. All other JS at the end of file. -->
  <!-- [if lt IE 9]>
  <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js"></script>
  <![endif]-->

  <?php
  wp_head();

  // TOFIX: passer la meta auteur via functions.php dans le wp_head()
  print '<meta name="author" content="Gilles Hoarau">';

  // TOFIX: passer le favicon via functions.php dans le wp_head()
  print '<link rel="shortcut icon" href="'.get_stylesheet_directory_uri().'/img/ico/favicon.ico">';
  ?>
</head>

<body <?php body_class( array('rock') ); ?>>

  <header id="Header">
    <div class="br_header">
      <?php get_template_part('templates/navbar'); ?>
      <hr>
    </div>
  </header>

  <section id="Section">
    <div class="br_section">
