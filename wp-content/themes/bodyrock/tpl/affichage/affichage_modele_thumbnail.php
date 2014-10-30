<?php
echo a('article.article.affichage.mod-thumbnail', "#post-" . get_the_ID());

echo a('div.thumbnail');

if ($instance['vignette_masquer'] == false) {
    echo Get_thumbnail($instance);
}

echo a('div.caption');

if ($instance['contenu_header_masquer'] == false) {
    echo a('header.art-header');
    if($instance['edit_article_titre']!=false)  {
        $titre = $instance['edit_article_titre'](get_the_title());
    }
        else $titre = get_the_title();
    echo '<h1 itemprop="name"><a href="' . get_permalink() . '" itemprop="url">' . $titre . '</a></h1>';
    echo z('header');
}

$br_excerpt = Get_excerpt($instance, a('section.art-content'), z('section'), $excerpt[$i]);
if (isset($instance['contenu_excerpt']) && $instance['contenu_excerpt'] == 'on' && $br_excerpt != false) {
    echo "<div itemprop='description'>" . $br_excerpt . "</div>";
}

echo Get_artfooter($instance);

echo z('/div');
echo '<hr class="clearfix">';
echo z('/div');

echo z('article');
