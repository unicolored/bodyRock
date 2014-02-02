<?php
session_start();

$_SESSION['br_lastviews'] = br_modules_lastviewsSet();
?>

<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" <?php language_attributes();?>> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" <?php language_attributes();?>> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" <?php language_attributes();?>> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" <?php language_attributes();?>>
<!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php wp_title('|', true, 'right'); ?></title>    
<meta name="author" content="Gilles Hoarau">
<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
  <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
<![endif]-->
<link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri() ?>/img/ico/favicon.ico">
<link rel="apple-touch-icon-precomposed" sizes="144x114" href="<?php echo get_stylesheet_directory_uri() ?>/img/ico/apple-touch-icon-144-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo get_stylesheet_directory_uri() ?>/img/ico/apple-touch-icon-114-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo get_stylesheet_directory_uri() ?>/img/ico/apple-touch-icon-72-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="57x57" href="<?php echo get_stylesheet_directory_uri() ?>/img/ico/apple-touch-icon-57-precomposed.png">

<?php wp_head(); ?>
<?php
if ( get_post_format() == 'video' ) {
$videoCode = get_post_meta(get_the_ID(), 'videoCode', true);
$videoType = get_post_meta(get_the_ID(), 'videoType', true);

$urlfinale = CDN_PATH.'images/videos/'.$videoType.'/'.$videoCode.br_getImgVideoSize('medium').'.jpg';	
?>
<meta property="og:image" content="<?php echo $urlfinale; ?>" />
<?php } ?>
</head>

<body data-spy="scroll" data-target=".subnav" data-offset="50" <?php body_class(); ?>>
    <a href="#content" class="sr-only">Skip to content</a>
	<div class="container"><div class="galaxie"><div class="col-xs-12"><noscript><div class="alert alert-warning"><?php br_Icon('warning') ?> Activer Javascript dans votre navigateur pour profiter de toutes les fonctionnalités du site.</div></noscript></div></div></div>
	
	<?php
	$options = get_option('brthemeoptions', themeoptionsGet_default());
	?>
	
	<div class="<?php echo $options['layout_width']==1 ? 'fluidifier' : 'container' ?>">
	
		<header class="header">
			<?php get_template_part(TPL_BOOTSTRAP_PATH.'navbars'); ?> 
		</header>
		
		<div class="column">
			<?php get_template_part(TPL_BOOTSTRAP_PATH.'breadcrumb'); ?> 
		</div>
	
		<?php
		global $main_section_class;
		$ide = 'defaut';
		$column = 'nomargin';
		if ( is_home() ) $ide = 'home';
		elseif ( is_front_page() ) $ide = 'front-page';
		elseif ( is_single() ) { $ide = 'single'; }
		elseif ( is_category() ) { $ide = 'category'; }
		elseif ( is_search() || is_tag() ) { $ide = 'search'; }
		elseif ( is_404() ) { $ide = '404'; }
		$main_section_class = br_getSectionClass($ide);
	
		?>
	
		<div class="<?php echo $column; ?>">
			<section class="<?php echo $main_section_class ?>">
