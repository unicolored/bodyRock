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
      <div id="wrap_navbar" class="<?php print BR_CONTAINER ?>">
      <?php if (get_header_image()) { print '<div id="Banner"><a href="/"><img src="'.get_header_image().'" class="img-responsive"></a></div>'; } ?>
        <?php get_template_part('templates/navbar'); ?>
      </div>
      <?php if (get_header_image()) { print '</div>'; } ?>
  </div>
</header>

<div class="<?php print BR_CONTAINER ?>">
  <?php if(BR_BREADCRUMB===1) bootstrap_breadcrumbs() ?>
  <main id="Main">
    <div class="br_main">
