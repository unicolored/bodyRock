<ul class="pagination pagination-lg">
              <li class="active"><a href="#">&laquo;</a></li>
              <li><a href="#">1</a></li>
              <li><a href="#">2</a></li>
              <li><a href="#">3</a></li>
              <li class="disabled"><a href="#">4</a></li>
              <li><a href="#">5</a></li>
              <li><a href="#">&raquo;</a></li>
            </ul>

			<ul class="pager">
              <li><a href="#">Previous</a></li>
              <li><a href="#">Next</a></li>
            </ul>
            <ul class="pager">
              <li class="previous disabled"><a href="#">&larr; Older</a></li>
              <li class="next"><a href="#">Newer &rarr;</a></li>
            </ul>
            
                    <div class="posts_navigation">
            <?php previous_post_link( '%link', __( '<button type="button" class="btn btn-primary btn-md pull-right">Précédent &raquo;</button>', 'twentyeleven' ) ); ?>
            <?php next_post_link( '%link', __( '<button type="button" class="btn btn-primary btn-md pull-left">&laquo; Suivant</button>', 'twentyeleven' ) ); ?>
        </div>	
        <ul class="pager">
                <li class="previous"><?php previous_post_link( '%link', __( '<span class="meta-nav">&larr;</span> Précédent', 'twentyeleven' ) ); ?></li>
                <li class="next"><?php next_post_link( '%link', __( 'Suivant <span class="meta-nav">&rarr;</span>', 'twentyeleven' ) ); ?></li>
            </ul><!-- #nav-single -->