<?php
echo '

<hr class="clearfix">
<article class="article">
    <section class="art-vignette art-vignette-'.$videoType.'">
        <a href="'.get_permalink().'">'.br_getPostThumbnail('thumbnail').'</a>
    </section>

	<div class="enveloppe">
		<header class="art-header">
			<h1><a href="'.get_permalink().'">'.get_the_title().'</a></h1>
		</header>
		
		<section class="content">
			<p>'.get_the_excerpt().'</p>
		</section>
		
		<footer class="art-footer">
			<small>'.ucfirst(get_the_date('M. Y')).'</small>
		</footer>
	</div>
	<hr class="clearfix">
</article>

	';