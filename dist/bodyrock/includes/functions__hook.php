<?php
// Wordpress Theme Configuration, Modifications

///////////////////////////////////////////////////////////////////////////////////////
add_filter('body_class', 'extend_body_classes'); // Ajoute des classes au body
add_filter('body_class', 'extend_body_classes_layouts'); // Ajoute des classes de Layouts au body
add_filter('excerpt_length', 'my_excerpt_length',999); // Modifie la longueur de l'excerpt par défaut.
add_filter('excerpt_more', 'new_excerpt_more'); // Remplace le lien Read more
add_filter('wp_handle_upload_prefilter', 'sanitize_file_uploads'); // Modifie le nom des images uploadées afin d'enlever les caractères interdits et les accents.
add_filter( 'jetpack_implode_frontend_css', '__return_false' ); // Supprime la feuille de style jetpack_implode_frontend_css
add_filter('the_generator', 'no_generator');
add_filter('dynamic_sidebar_params', 'first_last_classes'); // Ajoute une classe spécifique au premier et au dernier widget de la sidebar
add_filter ( 'wp_page_menu', 'br_page_menu', 100 ); // MODIFICATION DU MENU wp_page_menu pour une intégration dans la navbar
add_filter ( 'wp_nav_menu', 'br_nav_menu', 100 ); // MODIFICATION DU MENU wp_nav_menu pour une intégration dans la navbar
add_filter('nav_menu_css_class' , 'special_nav_class' , 10 , 2); // Ajoute une classe au li qui possède le current_page_item
add_filter('page_menu_css_class' , 'special_page_class' , 10 , 2); // Ajoute une classe au li qui possède le current_page_item

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
if ( !function_exists( 'extend_body_classes_layouts' ) ) {
  function extend_body_classes_layouts($classes) {
    // Aucune action ici - à utiliser par un thème child pour ajouter des layouts de mise en forme selon les pages
    // Exemple $classes[] = 'layout-sidebarright';
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
    $menu = str_replace('<div class="menu">','',$menu);
    $menu = str_replace('</div>','',$menu);
    $menu = str_replace('<ul>','<ul class="nav navbar-nav">',$menu);
    return $menu;
  }
}
if ( !function_exists( 'br_nav_menu' ) ) {
  function br_nav_menu($menu) {
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
if ( !function_exists( 'special_nav_class' ) ) {
  function special_nav_class($classes, $item){
    if( in_array('current-menu-item', $classes) ){
      $classes[] = 'active';
    }
    return $classes;
  }
}
if ( !function_exists( 'special_page_class' ) ) {
  function special_page_class($classes, $item){
    if( in_array('current_page_item', $classes) ){
      $classes[] = 'active';
    }
    return $classes;
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

add_action('wp_enqueue_scripts', YESWEARE=="dev" ? 'ScriptsLocaux' : 'ScriptsProd');
add_action('wp_enqueue_scripts', 'stylesnscripts_options');
add_action('login_head', 'custom_login_css'); // Ajoute une feuille de style pour la page de connexion
add_action('wp_print_styles', 'removeJetpackStyle',999); // Supprime la feuille de style Jetpack
add_action( 'wp_print_scripts', 'wpdocs_dequeue_script', 100 );
add_action( 'widgets_init', 'twentyten_remove_recent_comments_style' );
add_action('init', 'modify_jquery');
add_action('wp_head','base_css'); // Ajoute les styles minimum dans le head
add_action('wp_head','oldIEBrowserSupport'); // Ajoute les scripts pour les anciens IE // DESACTIVE car déjà présent ! Peut-être déjà chargé par BodyRock
add_action('wp_head','meta_author');
add_action('wp_head','link_shortcut_icon');
add_action('wp_head','opengraph');
add_action('wp_footer', 'add_schemaorg',0); // Supprime les scripts Jetpack
add_action('wp_footer', 'removeJetpackScripts',0); // Supprime les scripts Jetpack
add_action('wp_footer', 'add_googleanalytics'); //ADDS GOOGLE ANALYTICS CODE TO FOOTER

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
if ( !function_exists( 'opengraph' ) ) {
  function opengraph() {
    // 1. Title
    $title = get_bloginfo('description');
    // 2. Description
    $description = get_post_meta(get_the_ID(),'SeoDescription',true);
    // 3. Url
    $url = get_bloginfo('url');
    // 4. Blog name
    $blogname = get_bloginfo('name');
    // 5. Blog description
    $blogdescription = $title;
    // 5. Content creator
    $administrator = get_users( 'who=administrator&role=administrator' );
    $user_login = get_the_author_meta('user_login',$administrator[0]->ID);

    $type = 'website';
    ////////////// ////////////// ////////////// ////////////// //////////////
    print "<!-- Structured Data -->\n";
    $META['twitter']['card'] = '<meta name="twitter:card" content="summary"/>';
    //$META['twitter']['creator'] = '<meta name="twitter:creator" content="@unicolored"/>';

    // CONDITIONNAL
    if (function_exists ('is_product') && is_product()) {

    }
    elseif (is_front_page()) {
      //$title = $blogname;
        $creator = '@'.$user_login;
    }
    elseif (is_home()) {
      $title = get_the_title( get_option('page_for_posts', true) );
    }
    elseif (is_single() || is_page()) {
      $description = get_post(get_the_ID())->post_content;
      if(is_single()) {
        $user_login = get_the_author_meta('user_login',get_post_field( 'post_author', get_the_ID() ));
        $creator = '@'.$user_login;
      }
      if (has_post_thumbnail()) {
        $image = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'twitter' )[0];
        $META['twitter']['card'] = '<meta name="twitter:card" content="summary_large_image"/>';
      }
      $url = get_the_permalink();
      $type = 'article';
    }
    elseif (is_author()) {
      $title = get_the_title( get_option('page_for_posts', true) );


      $first_name = get_the_author_meta('first_name',$administrator[0]->ID);
      $last_name = get_the_author_meta('last_name',$administrator[0]->ID);

      $type = 'profile';
      $META['OG']['first_name'] = '<meta property="og:profile:first_name" content="'.$first_name.'" />';
      $META['OG']['last_name'] = '<meta property="og:profile:last_name" content="'.$last_name.'" />';
      $META['OG']['username'] = '<meta property="og:profile:username" content="'.$user_login.'" />';
      $META['OG']['gender'] = '<meta property="og:profile:gender" content="male" />';
    }
    ////////////// ////////////// ////////////// ////////////// //////////////
    if ($title!="") {
      //$title = substr(htmlentities(strip_tags(preg_replace('/\s\s+/', '', $title),ENT_QUOTES),0,60))." ...";
      //$META['twitter']['title'] = '<meta name="twitter:title" content="'.$title.'" />';
      $META['OG']['title'] = '<meta property="og:title" content="'.$title.'" />';
    }
    if ($description!="") {
      $description = substr(htmlentities(strip_tags(preg_replace('/\s\s+/', '', $description)),ENT_QUOTES),0,190)." ...";
      // $META['twitter']['description'] = '<meta name="twitter:description" content="'.$description.'" />';
      $META['OG']['description'] = '<meta property="og:description" content="'.$description.'" />';
    }
    if ($image!="") {
      //$META['twitter']['image'] = '<meta name="twitter:image" content="'.$image.'" />';
      $META['OG']['image'] = '<meta property="og:image" content="'.$image.'" />';
    }
    if ($creator!="") {
      $META['twitter']['creator'] = '<meta name="twitter:creator" content="'.$creator.'" />';
    }
    $META['twitter']['site'] = '<meta name="twitter:site" content="@'.$user_login.'"/>';
    $META['OG']['type'] = '<meta property="og:type" content="'.$type.'" />';
    $META['OG']['site_name'] = '<meta property="og:site_name" content="'.$blogname.'" />';
    $META['OG']['url'] = '<meta property="og:url" content="'.$url.'" />';
    $META['OG']['locale'] = '<meta property="og:locale" content="fr_FR" />';
    $META['OG']['alternate'] = '<meta property="og:locale:alternate" content="en_US" />';

    // RESULTATS
    foreach ($META as $type => $k) {
      print "\n<!--".$type."-->\n";
      foreach ($k as $label) {
        print $label."\n";
      }
    }

    print "<!-- /Structured Data -->\n\n";
  }
}
if ( !function_exists( 'base_css' ) ) {
  function base_css() {
    $output="";
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
    // Fonction à placer dans un thème enfant pour les styles et scripts en développement
    return;
  }
}
if ( !function_exists( 'ScriptsProd' ) ) {
  function ScriptsProd() {
    // Fonction à placer dans un thème enfant pour les styles et scripts en production
    return;
  }
}
if ( !function_exists( 'stylesnscripts_options' ) ) {
  function stylesnscripts_options() {
    // Bootstrap CSS
    if (BR_BOOTSTRAPCSS === 1) {
      wp_enqueue_style('style-bootstrap', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css', false, null, 'all');
    }
    // Bootswatch
    if(BR_BOOTSWATCH != "aucun") {
      wp_enqueue_style('style-bootswatch', 'https://maxcdn.bootstrapcdn.com/bootswatch/3.3.5/'.BR_BOOTSWATCH.'/bootstrap.min.css', false, null, 'all');
    }
    // Set d'icônes
    switch ( BR_ICONSET ) {
      case 'fontawesome' :
      wp_enqueue_style('iconset-fontawesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css', array(), null, false);
      break;
      case 'linearicons' :
      wp_enqueue_style('iconset-linearicons', 'https://cdn.linearicons.com/free/1.0.0/icon-font.min.css', array(), null, false);
      break;
      case 'octicons' :
      wp_enqueue_style('iconset-octicons', 'https://cdnjs.cloudflare.com/ajax/libs/octicons/3.1.0/octicons.min.css', array(), null, false);
      break;
    }
    // jQuery
    if (BR_JQUERY === 1) {
      wp_enqueue_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js', array('jquery'), null, 1);
    }
    // Bootstrap JS
    if (BR_BOOTSTRAPJS === 1) {
      wp_enqueue_script('bootstrap-min-default', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js', array('jquery'), null, 0);
    }
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
if ( !function_exists( 'modify_jquery' ) ) {
  function modify_jquery() {
    if (!is_admin()) {
      // comment out the next two lines to load the local copy of jQuery
      wp_deregister_script('jquery');
      wp_register_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js', false, null, true);
      //wp_enqueue_script('jquery'); // Inutile de charger jquery directement s'il est appellé comme dépendance d'un autre script ou plugin
    }
  }
}
if ( !function_exists( 'br_register_sidebars' ) ) {
  function br_register_sidebars() {
    register_sidebar( array(
      'name' => __( 'Sidebar Left', 'bodyrock' ),
      'id' => 'sidebar-left',
      'before_widget' => '<section class="widget %2$s" id="%1$s">',
      'after_widget' => "</section>",
      'before_title' => '<h1 class="widget-title">',
      'after_title' => '</h1>',
      )
    );
    register_sidebar( array(
      'name' => __( 'Sidebar Right', 'bodyrock' ),
      'id' => 'sidebar-right',
      'before_widget' => '<section id="%1$s" class="widget %2$s">',
      'after_widget' => "</section>",
      'before_title' => '<h1 class="widget-title">',
      'after_title' => '</h1>',
      )
    );
    register_sidebar( array(
      'name' => __( 'Sidebar Rubrique', 'bodyrock' ),
      'id' => 'sidebar-rubrique',
      'before_widget' => '<section id="%1$s" class="widget %2$s">',
      'after_widget' => "</section>",
      'before_title' => '<h1 class="widget-title">',
      'after_title' => '</h1>',
      )
    );
  }
}
if ( !function_exists( 'add_googleanalytics' ) ) {
  function add_googleanalytics() {
    if ( BR_GOOGLE_ANALYTICS != false ) {
      print '
      <!-- Google Analytics -->
      ';
      ?>
      <script type="text/javascript">(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date(); a=s.createElement(o),m=s.getElementsByTagName(o)[0];a.async=1; a.src=g;m.parentNode.insertBefore(a,m)}) (window,document,'script','//www.google-analytics.com/analytics.js','ga'); ga('create', '<?php echo BR_GOOGLE_ANALYTICS ?>', 'auto'); ga('send', 'pageview');</script>
      <?php
    }
  }
}
if ( !function_exists( 'add_schemaorg' ) ) {
  function add_schemaorg() {
    /*print '
    <script type="application/ld+json">{ "@context": "https://schema.org", "@type": "WebSite", "url": "http://www.gilleshoarau.com/",
    "potentialAction": { "@type": "SearchAction", "target": "http://www.gilleshoarau.com/?s={search_term}",
    "query-input": "required name=search_term" } }</script>
    ';*/
    print '
    <!-- Schema.org -->
    <script type="application/ld+json">{ "@context": "https://schema.org", "@type": "WebSite", "url": "'.get_bloginfo('url').'/", "potentialAction": { "@type": "SearchAction", "target": "'.get_bloginfo('url').'/?s={search_term}", "query-input": "required name=search_term" } }</script>
    ';
  }
}
