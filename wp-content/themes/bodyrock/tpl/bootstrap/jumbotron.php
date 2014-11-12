<div class="jumbotron">
    <div class="container">
        <h1>Partage <span>de tendances</span></h1>
        <p>
         <?php $args = array(
    'smallest'                  => 14, 
    'largest'                   => 32,
    'unit'                      => 'pt', 
    'number'                    => 45,  
    'format'                    => 'flat',
    'separator'                 => " &nbsp; ",
    'orderby'                   => 'id', 
    'order'                     => 'DESC',
    'exclude'                   => '1,36,107,7,81,37', 
    'include'                   => '', 
    'link'                      => 'view', 
    'taxonomy'                  => 'category',
    'echo'                      => true ); ?> 
    
     <?php wp_tag_cloud( $args ); ?>
     </p>
    </div>
</div>