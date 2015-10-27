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

  <?php
  wp_head();
  ?>
</head>

<body <?php body_class( array('rock') ); ?>>

  <header id="Header">
    <div class="br_header">
      <?php get_template_part('templates/navbar'); ?>
    </div>
  </header>

  <main id="Main">
    <div class="br_main">
