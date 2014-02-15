<?php global $active_categorie; ?>
<div class="col-xs-6">
<ol class="breadcrumb">
  <li><a href="/"><?php br_Icon('home') ?></a></li>
  <?php if(is_single()) {
                            $categories = get_the_category();
                            $separator = ' ';
                            $output = '';
                            if($categories) {
                            foreach($categories as $category) {
//                            $output .= '<a href="'.get_category_link( $category->term_id ).'" title="' . esc_attr( sprintf( __( "View all posts in %s" ), $category->name ) ) . '"><span class="label label-primary">'.''.$category->cat_name.'</span></a>'.$separator;
                            $output .= '<li><a href="'.get_category_link( $category->term_id ).'" title="' . esc_attr( sprintf( __( "View all posts in %s" ), $category->name ) ) . '">'.ucfirst(str_replace('<br>','',$category->cat_name)).'</a></li>';
                            }
                            echo trim($output, $separator);
                            }
      ?>
  
  <?php } elseif(is_category(110) or is_category(8) or is_category(109)) {
	  if(!is_category(109)) { ?><li><a href="/communication/reponses-et-solutions/"><?php br_Icon('comments') ?> Discussions</a></li><?php } ?>
  <li class="active"><?php echo ucfirst(str_replace('<br>','',$active_categorie->name)) ?></li>
  <?php } elseif(is_category()) { ?>
  <li><a href="/communication/web/"><?php br_Icon('folder') ?> Collections</a></li>
  <!--<li class="active"><?php echo ucfirst(str_replace('<br>','',$active_categorie->name)) ?></li>-->
  <?php } else { ?>
    <li class="active">Page <?php echo get_query_var('page'); ?></li>
  <?php } ?>
</ol>
</div>