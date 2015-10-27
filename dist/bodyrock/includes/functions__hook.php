<?php
// Wordpress Theme Configuration, Modifications

///////////////////////////////////////////////////////////////////////////////////////
add_filter('body_class', 'extend_body_classes'); // Ajoute des classes au body
add_filter('excerpt_length', 'my_excerpt_length',999); // Modifie la longueur de l'excerpt par défaut.
add_filter('excerpt_more', 'new_excerpt_more'); // Remplace le lien Read more
add_filter('wp_handle_upload_prefilter', 'sanitize_file_uploads'); // Modifie le nom des images uploadées afin d'enlever les caractères interdits et les accents.
add_filter( 'jetpack_implode_frontend_css', '__return_false' ); // Supprime la feuille de style jetpack_implode_frontend_css
add_filter ( 'wp_page_menu', 'br_page_menu', 100 ); // MODIFICATION DU MENU wp_page_menu pour une intégration dans la navbar
add_filter('the_generator',					'no_generator');
add_filter('dynamic_sidebar_params', 'first_last_classes'); // Ajoute une classe spécifique au premier et au dernier widget de la sidebar

# SEARCH
add_filter( 'posts_join', 'custom_posts_join', 10, 2 ); /* Send in the filters / Use posts_join filter to perform an INNER JOIN of the terms, term_relationship, and term_taxonomy tables on the posts table. */
add_filter( 'posts_where', 'custom_posts_where', 10, 2 ); /* To include a clause to search the text being search, the posts_where filter is available to append an extra where clause. */
add_filter( 'posts_groupby', 'custom_posts_groupby', 10, 2 );
###

/*
##         ## ##      ######## #### ##       ######## ######## ########   ######
##         ## ##      ##        ##  ##          ##    ##       ##     ## ##    ##
##       #########    ##        ##  ##          ##    ##       ##     ## ##
##         ## ##      ######    ##  ##          ##    ######   ########   ######
##       #########    ##        ##  ##          ##    ##       ##   ##         ##
##         ## ##      ##        ##  ##          ##    ##       ##    ##  ##    ##
########   ## ##      ##       #### ########    ##    ######## ##     ##  ######
*/
if ( !function_exists( 'extend_body_classes' ) ) {
  function extend_body_classes($classes) {
    $bodyClass = getBodyClass();
    // 'class-'.$bodyClass['parent'].' '.$bodyClass['child'].' bg-'.$bodyClass['parent']
    $classes[] = 'class-'.$bodyClass['parent'];
    $classes[] = $bodyClass['child'];
    $classes[] = 'bg-'.$bodyClass['parent'];
    $classes[] = 'cat-'.br_mainCategory();
    ////////////////
    return $classes;
  }
}
if ( !function_exists( 'my_excerpt_length' ) ) {
  function my_excerpt_length() {
    return 40;
  }
}
if ( !function_exists( 'sanitize_file_uploads' ) ) {
  function sanitize_file_uploads( $file ) {
    $file['name'] = sanitize_file_name($file['name']);
    $file['name'] = preg_replace("/[^a-zA-Z0-9\.\-]/", "", $file['name']);
    $file['name'] = strtolower($file['name']);
    add_filter('sanitize_file_name', 'remove_accents');
    return $file;
  }
}

if ( !function_exists( 'custom_posts_join' ) ) {
  function custom_posts_join( $join, $query ) {
    global $wpdb;

    //* if main query and search...
    if( is_main_query() && is_search() )
    {
      //* join term_relationships, term_taxonomy, and terms into the current SQL where clause
      $join .= "
      LEFT JOIN
      (
      {$wpdb->term_relationships} a
      INNER JOIN
      {$wpdb->term_taxonomy} b ON b.term_taxonomy_id = a.term_taxonomy_id
      INNER JOIN
      {$wpdb->terms} c ON c.term_id = b.term_id
      )
      ON {$wpdb->posts}.ID = a.object_id ";
    }

    return $join;
  }
}

/**
* Get a where clause dependent on the current user's status.
*
* @uses get_current_user_id()
* @link http://codex.wordpress.org/Function_Reference/get_current_user_id
*
* @return string The user where clause.
*/
if ( !function_exists( 'get_user_posts_where' ) ) {
  function get_user_posts_where()
  {
    global $wpdb;

    $user_id = get_current_user_id();
    $sql     = '';
    $status  = array( "'publish'" );

    if( 0 !== $user_id )
    {
      $status[] = "'private'";

      $sql .= " AND {$wpdb->posts}.post_author = " . absint( $user_id );
    }

    $sql .= " AND {$wpdb->posts}.post_status IN( " . implode( ',', $status ) . " ) ";

    return $sql;
  }
}

if ( !function_exists( 'custom_posts_where' ) ) {
  function custom_posts_where( $where, $query ) {
    global $wpdb;

    if( is_main_query() && is_search() )
    {
      //* get additional where clause for the user
      $user_where = get_user_posts_where();

      $where .= " OR (
      b.taxonomy IN( 'category', 'post_tag' )
      AND
      c.name LIKE '%" . esc_sql( get_query_var( 's' ) ) . "%'
      {$user_where}
      )";
    }

    return $where;
  }
}

if ( !function_exists( 'custom_posts_groupby' ) ) {
  function custom_posts_groupby( $groupby, $query ) {
    global $wpdb;

    //* if is main query and a search...
    if( is_main_query() && is_search() )
    {
      //* assign the GROUPBY
      $groupby = "{$wpdb->posts}.ID";
    }

    return $groupby;
  }
}

if ( !function_exists( 'new_excerpt_more' ) ) {
  function new_excerpt_more($text){

    return ' &hellip; <a href="' . get_permalink() . '">' . __( 'suite...', 'bodyrock' ) . '</a>';

  }
}
if ( !function_exists( 'br_page_menu' ) ) {
  function br_page_menu($menu) {
    /*
    ORIGINAL : "<div class="menu"><ul><li class="page_item page-item-2"><a href="http://emailing.fromscratch.xyz/page-d-exemple/">Page d&rsquo;exemple</a></li></ul></div>"
    */
    $menu = str_replace('<div class="menu">','',$menu);
    $menu = str_replace('</div>','',$menu);
    $menu = str_replace('<ul>','<ul class="nav navbar-nav">',$menu);
    return $menu;
  }
}
if ( !function_exists( 'no_generator' ) ) {
  // remove WordPress version from RSS feed
  function no_generator() { return ''; }
}
if ( !function_exists( 'first_last_classes' ) ) {
  function first_last_classes($params) {
    // http://wordpress.org/support/topic/how-to-first-and-last-css-classes-for-sidebar-widgets
    global $my_widget_num;
    $this_id = $params[0]['id'];
    $arr_registered_widgets = wp_get_sidebars_widgets();

    if (!$my_widget_num) {
      $my_widget_num = array();
    }

    if (!isset($arr_registered_widgets[$this_id]) || !is_array($arr_registered_widgets[$this_id])) {
      return $params;
    }

    if (isset($my_widget_num[$this_id])) {
      $my_widget_num[$this_id] ++;
    } else {
      $my_widget_num[$this_id] = 1;
    }

    $class = 'class="widget-' . $my_widget_num[$this_id] . ' ';

    if ($my_widget_num[$this_id] == 1) {
      $class .= 'widget-first ';
    } elseif ($my_widget_num[$this_id] == count($arr_registered_widgets[$this_id])) {
      $class .= 'widget-last ';
    }

    $params[0]['before_widget'] = str_replace('class="', $class, $params[0]['before_widget']);

    return $params;

  }
}

///////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////
// HEAD
// On retire les liens xml vers les fichiers permettant l'édition par Live Writer
remove_action('wp_head', 'wp_shortlink_wp_head');
remove_action( 'wp_head', 'feed_links_extra', 3 ); // Display the links to the extra feeds such as category feeds
remove_action( 'wp_head', 'feed_links', 2 ); // Display the links to the general feeds: Post and Comment Feed
remove_action( 'wp_head', 'rsd_link' ); // Display the link to the Really Simple Discovery service endpoint, EditURI link
remove_action( 'wp_head', 'wlwmanifest_link' ); // Display the link to the Windows Live Writer manifest file.
remove_action( 'wp_head', 'index_rel_link' ); // index link
remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 ); // prev link
remove_action( 'wp_head', 'start_post_rel_link', 10, 0 ); // start link
remove_action( 'wp_head', 'adjacent_posts_rel_link', 10, 0 ); // Display relational links for the posts adjacent to the current post.
remove_action( 'wp_head', 'wp_generator' ); // Display the XHTML generator that is generated on the wp_head hook, WP version

/* Remove EMOJI */
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );

add_action('wp_head','base_css'); // Ajoute les styles minimum dans le head
add_action('wp_head','oldIEBrowserSupport'); // Ajoute les scripts pour les anciens IE // DESACTIVE car déjà présent ! Peut-être déjà chargé par BodyRock
add_action('wp_enqueue_scripts', YESWEARE=="dev" ? 'ScriptsLocaux' : 'ScriptsProd');
add_action('wp_enqueue_scripts', 'head_scripts');
add_action('login_head', 'custom_login_css'); // Ajoute une feuille de style pour la page de connexion
add_action('wp_footer', 'removeJetpackScripts',0); // Supprime les scripts Jetpack
add_action('wp_print_styles', 'removeJetpackStyle',999); // Supprime la feuille de style Jetpack
add_action( 'wp_print_scripts', 'wpdocs_dequeue_script', 100 );
add_action( 'widgets_init', 'twentyten_remove_recent_comments_style' );
add_action('wp_head','meta_author');
add_action('wp_head','link_shortcut_icon');

// ADMIN BACKEND
add_action( 'login_enqueue_scripts', 'my_custom_login_logo' );
add_action('do_robots', 					'robots');
add_action('wp_dashboard_setup', 'my_custom_dashboard_widgets'); // AJOUT D'UN WIDGET DANS SUR LA DASHBOARD WORDPRESS
//add_action( 'widgets_init', 'br_register_widgets' ); // Ajout de widgets personnalisés
add_action( 'widgets_init', 'br_register_sidebars' ); // Ajout de sidebars pour l'insertion des widgets
///////////////////////////////////////////////////////////////////////////////////////

/*
##         ## ##         ###     ######  ######## ####  #######  ##    ##  ######
##         ## ##        ## ##   ##    ##    ##     ##  ##     ## ###   ## ##    ##
##       #########     ##   ##  ##          ##     ##  ##     ## ####  ## ##
##         ## ##      ##     ## ##          ##     ##  ##     ## ## ## ##  ######
##       #########    ######### ##          ##     ##  ##     ## ##  ####       ##
##         ## ##      ##     ## ##    ##    ##     ##  ##     ## ##   ### ##    ##
########   ## ##      ##     ##  ######     ##    ####  #######  ##    ##  ######
*/
if ( !function_exists( 'base_css' ) ) {
  function base_css() {
    $output="
    <style type=\"text/css\">
    html { background:#fff; }
    body { color:#000; }
    </style>";
    echo $output;
  }
}
if ( !function_exists( 'oldIEBrowserSupport' ) ) {
  function oldIEBrowserSupport() {
    $output="
    <!-- [if lt IE 9]>
    <script src=\"https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js\"></script>
    <script src=\"//cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js\"></script>
    <![endif]-->";
    echo $output;
  }
}
if ( !function_exists( 'ScriptsLocaux' ) ) {
  function ScriptsLocaux() {
    // SCRIPTS ET CSS EN DEVELOPPEMENT LOCAL
    // CSS
    // TODO : rendre plus générales ces fonctions copiées de gilleshoarau.com
    //wp_enqueue_style('style-style', get_stylesheet_directory_uri().'/style.css', false, null, 'all');
    // JS
    //wp_enqueue_script('bower_concat', get_stylesheet_directory_uri().'/js/tmp/bower_concat.js', false,null,true);
  }
}
if ( !function_exists( 'ScriptsProd' ) ) {
  function ScriptsProd() {
    // SCRIPTS EN PRODUCTION
    // CSS
    // TODO : rendre plus générales ces fonctions copiées de gilleshoarau.com
    //wp_enqueue_style('style-child', get_stylesheet_directory_uri() . '/style.'.wp_get_theme('rock-gilleshoarau')->Version.'.css', false, null, 'all');
    // JS
    //wp_enqueue_script('myjquery', "https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js", false, null, true);
    //wp_enqueue_script('scriptsglobaux', get_stylesheet_directory_uri() . "/js/scripts.".wp_get_theme('rock-gilleshoarau')->Version.".min.js", false, null, true);
  }
}
if ( !function_exists( 'head_scripts' ) ) {
  function head_scripts() {
    // CSS
    switch ( BR_ICON_SET ) {
      case 'elusive' :
      wp_enqueue_style('icon_set-elusive', get_template_directory_uri() . '/assets/icon_set/elusive-webfont.css', array(), null, false);
      break;
      case 'font-awesome' :
      wp_enqueue_style('icon_set-fontawesome', '//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css', array(), null, false);
      break;
      case 'glyphicon' :
      wp_enqueue_style('icon_set-glyphicon', get_template_directory_uri() . '/assets/icon_set/glyphicons.css', array(), null, false);
      break;
    }

    if (!is_child_theme()) {
      wp_enqueue_style('style', get_template_directory_uri() . '/style.css', false, null, 'all');
    } else {
      // CHILD /////////////////////////////////////////////
      //wp_enqueue_style('style-child', get_stylesheet_directory_uri() . '/style.css', false, null, 'all');
      //wp_enqueue_style('bootstrap', '//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css', false, null, 'all');

    }

    // JAVASCRIPT
    // Bootstrap Javascript
    if (BR_ALLBSJS != NULL) {
      //wp_enqueue_script('bootstrap-min-default', '//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js', array('jquery'), null, 1);
    }

    global $options;

    $FG = explode(',', BR_FONTS);
    $i = 0;
    $families = '';
    foreach ($FG as $F) {
      $families .= ($i > 0 ? ',' : false) . "'" . $F . "'";
      $i++;
    }

    // Envoi de valeurs php dans le javascript
    wp_localize_script('script', 'sc_val', array('domaine' => stripslashes(str_replace('http://', '', esc_url( get_home_url() )))));
  }
}
if ( !function_exists( 'custom_login_css' ) ) {
  function custom_login_css() {
    wp_enqueue_style('mystyles', '/css/styles-login.css', false, null, 'all');
  }
}
if ( !function_exists( 'removeJetpackScripts' ) ) {
  function removeJetpackScripts() {
    wp_dequeue_script( 'devicepx' );
  }
}
if ( !function_exists( 'removeJetpackStyle' ) ) {
  function removeJetpackStyle() {
    wp_deregister_style('jetpack_css');
  }
}
if ( !function_exists( 'wpdocs_dequeue_script' ) ) {
  function wpdocs_dequeue_script() {
    // FIXME : Décharger le script disqus si le plugin est installé et si la page/post autorise les commentaires
    /*if (!is_single() || !is_page('a-propos')) {
    wp_dequeue_script('dsq_count_script');
  }*/
}
}
if ( !function_exists( 'twentyten_remove_recent_comments_style' ) ) {
  function twentyten_remove_recent_comments_style() {
    global $wp_widget_factory;
    remove_action( 'wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ) );
  }
}
if ( !function_exists( 'meta_author' ) ) {
  function meta_author() {
    $output="\t".'<meta name="author" content="Gilles Hoarau">'."\n";
    echo $output;
  }
}
if ( !function_exists( 'link_shortcut_icon' ) ) {
  function link_shortcut_icon() {
    $output="\t".'<link rel="shortcut icon" href="'.get_stylesheet_directory_uri().'/img/ico/favicon.ico">'."\n"."\n";
    echo $output;
  }
}
if ( !function_exists( 'my_custom_login_logo' ) ) {
  // MY CUSTOM LOGIN LOGO /////////////////////////////////////////////
  // Remplace le logo de Wordpress sur la page login.
  function my_custom_login_logo()
  {
    echo '<style  type="text/css">body.login div#login h1 a {  background-image:url('.get_template_directory_uri().'/assets/images/logo_login_bodyrock.png)  !important; } </style>';
  }
}
if ( !function_exists( 'robots' ) ) {
  // add to robots.txt
  // http://codex.wordpress.org/Search_Engine_Optimization_for_WordPress#Robots.txt_Optimization
  function robots() {
    echo "Disallow: /cgi-bin\n";
    echo "Disallow: /wp-admin\n";
    echo "Disallow: /wp-includes\n";
    echo "Disallow: /wp-content/plugins\n";
    echo "Disallow: /plugins\n";
    echo "Disallow: /wp-content/cache\n";
    echo "Disallow: /wp-content/themes\n";
    echo "Disallow: /trackback\n";
    echo "Disallow: /feed\n";
    echo "Disallow: /comments\n";
    echo "Disallow: /category/*/*\n";
    echo "Disallow: */trackback\n";
    echo "Disallow: */feed\n";
    echo "Disallow: */comments\n";
    echo "Disallow: /*?*\n";
    echo "Disallow: /*?\n";
    echo "Allow: /wp-content/uploads\n";
    echo "Allow: /assets";
  }
}
if ( !function_exists( 'my_custom_dashboard_widgets' ) ) {
  function my_custom_dashboard_widgets() {
    global $wp_meta_boxes;

    wp_add_dashboard_widget('welcome_bodyrock', 'Bodyrock', 'call_widgetDashboard_welcome');
  }
}
if ( !function_exists( 'call_widgetDashboard_welcome' ) ) {
  function call_widgetDashboard_welcome() {
    echo '<p>Bienvenue sur Wordpress propulsé par Bodyrock.</p>';
  }
}
/*
// TODO : supprimer définitivement les fichiers des widgets
if ( !function_exists( 'br_register_widgets' ) ) {
  function br_register_widgets() {

    require_once INC_PATH.'wp-extend/widgets/carousel.php';  // basics
    register_widget('bodyrock_carousel');

    require_once INC_PATH.'wp-extend/widgets/categories.php';  // basics
    register_widget('bodyrock_categories');

    require_once INC_PATH.'wp-extend/widgets/recentposts.php';  // basics
    register_widget('bodyrock_recentposts');
  }
}
*/
if ( !function_exists( 'br_register_sidebars' ) ) {
  function br_register_sidebars() {
    register_sidebar( array(
      'name' => __( 'Dummy', 'bodyrock' ),
      'id' => 'Dummy',
      'before_widget' => '<aside class="hidden">',
      'after_widget' => "</aside>",
      'before_title' => '',
      'after_title' => '',
      )
    );

    register_sidebar( array(
      'name' => __( 'Sidebar Left', 'bodyrock' ),
      'id' => 'sidebar-left',
      'before_widget' => '<section class="widget %2$s" id="%1$s">',
      'after_widget' => "</section>",
      'before_title' => '<h1>',
      'after_title' => '</h1>',
      )
    );

    register_sidebar( array(
      'name' => __( 'Sidebar Right', 'bodyrock' ),
      'id' => 'sidebar-right',
      'before_widget' => '<section id="%1$s" class="widget %2$s">',
      'after_widget' => "</section>",
      'before_title' => '<h1>',
      'after_title' => '</h1>',
      )
    );
  }
}
