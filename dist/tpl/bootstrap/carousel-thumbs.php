<?php
global $the_query;

$j=0;
					while ( $the_query->have_posts() ) :
						$the_query->the_post();
						echo '<div class="col-lg-3">';
						echo '<li class="controlcarousel" data-target="#carousel-example-generic" data-slide-to="'.$j.'">'.get_template_part('tpl/content/wallsans').'</li>';
						echo '</div>';
						$j++;
					endwhile;
?>