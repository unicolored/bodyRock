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
<meta name="author" content="Gilles Hoarau">
<link rel="image_src" href="/wp-content/themes/rock-gilleshoarau/img/avatar_gilleshoarau.jpg" />

<?php $SD = get_stylesheet_directory_uri() ?>
<link rel="shortcut icon" href="<?php echo $SD ?>/img/ico/favicon.ico">
<link rel="apple-touch-icon-precomposed" sizes="144x114" href="<?php echo $SD ?>/img/ico/144.png">
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo $SD ?>/img/ico/114.png">
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo $SD ?>/img/ico/72.png">
<link rel="apple-touch-icon-precomposed" sizes="57x57" href="<?php echo $SD ?>/img/ico/57.png">

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries. All other JS at the end of file. -->
<!-- [if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="//cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->

<?php wp_head(); ?>

<!-- shortlink -->
<?php bitly_url(); ?>
</head>

<body class="rock">

    <div class="preloader">
        <div class="spinner">
            <div class="bounce1"></div>
            <div class="bounce2"></div>
            <div class="bounce3"></div>
        </div>
    </div>

    <section class="br_header">
      <?php
      // Charge la barre de navigation principale
      get_template_part('tpl/bs_navbar','top');

      // Charge la barre de navibation en bas de page
      get_template_part('tpl/bs_navbar','bottom');
      ?>
      </section>
