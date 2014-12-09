<?php
echo '

<article class="article">
    <section class="art-vignette art-vignette-'.$videoType.'">
        <a href="'.get_permalink().'">'.br_getPostThumbnail('medium').'</a>
    </section>

	<header class="art-header">
        <h1><a href="'.get_permalink().'">'.get_the_title().'</a></h1>
	</header>
	
	<footer class="art-footer hidden">
        <small>'.ucfirst(get_the_date('M. Y')).'</small>
	</footer>
</article>

	';