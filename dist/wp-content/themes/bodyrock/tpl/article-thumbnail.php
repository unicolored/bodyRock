<article class="article">
    <div class="thumbnail">
		<?php the_post_thumbnail('medium',array('class'=>'img-rounded')) ?>
		<div class="caption">
			<h3><?php the_title() ?></h3>
			<p>
				<?php the_excerpt() ?>
			</p>
			<p><a href="<?php the_permalink() ?>" class="btn btn-primary" role="button">Afficher l'article</a></p>
		</div>
	</div>
</article>

