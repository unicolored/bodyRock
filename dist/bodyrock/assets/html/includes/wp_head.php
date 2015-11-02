<?php
/**
 * Génération du wp_head()
 *
 * VARIABLES
 * @param string $title Rendez votre Communication plus efficace - Gilles Hoarau
 * @param string $description Bienvenue, je suis Gilles ! J’ai le privilège d’apprendre et de travailler en freelance. Je partage mes conseils en Création visuelle et Développement Web, mes astuces et mes outils favoris. J’aimerais vous aider à développer votre activité sur Internet.
 * @param string $home http://www.gilleshoarau.com/
 * @param string $permalink http://www.gilleshoarau.com/
 * STATIQUES
 * SEO
 * @param string $GoogleProfil https://plus.google.com/+GillesHoarau1337
 * @param string $GooglePage https://plus.google.com/+Unicolored
 * Social - Facebook
 *
 */
?>
<?php
print '<title>'.$title.'</title>';

// <!-- This site is optimized with the Yoast SEO plugin v2.3.5 - https://yoast.com/wordpress/plugins/seo/ -->
print '<meta name="description" content="'.$description.'"/>';
print '<link rel="canonical" href="'.$permalink.'" />';
print '<link rel="author" href="'.$GoogleProfil.'"/>';
print '<link rel="publisher" href="'.$GooglePage.'"/>';
?>

<meta property="og:locale" content="fr_FR" />
<meta property="og:locale:alternate" content="en_US" />
<meta property="og:type" content="profile" />
<meta property="og:profile:first_name" content="Gilles" />
<meta property="og:profile:last_name" content="Hoarau" />
<meta property="og:profile:username" content="unicolored" />
<meta property="og:title" content="Rendez votre Communication plus efficace - Gilles Hoarau" />
<meta property="og:description" content="'.$description.'" />
<meta property="og:url" content="http://www.gilleshoarau.com/" />
<meta property="og:site_name" content="Création Visuelle et Développement Web" />

<meta name="twitter:title" content="Rendez votre Communication plus efficace - Gilles Hoarau"/>
<meta name="twitter:description" content="Bienvenue, je suis Gilles ! J’ai le privilège d’apprendre et de travailler en freelance. Je partage mes conseils en Création visuelle et Développement Web, mes astuces et mes outils favoris. J’aimerais vous aider à développer votre activité sur Internet."/>
<meta name="twitter:card" content="summary_large_image"/>
<meta name="twitter:site" content="@gilleshoarau"/>
<meta name="twitter:creator" content="@gilleshoarau"/>

<script type='application/ld+json'>{"@context":"http:\/\/schema.org","@type":"WebSite","url":"http:\/\/www.gilleshoarau.com\/","name":"Cr\u00e9ation Visuelle et D\u00e9veloppement Web","alternateName":"Gilles Hoarau","potentialAction":{"@type":"SearchAction","target":"http:\/\/www.gilleshoarau.com\/?s={search_term_string}","query-input":"required name=search_term_string"}}</script>
<script type='application/ld+json'>{"@context":"http:\/\/schema.org","@type":"Person","url":"http:\/\/www.gilleshoarau.com\/","sameAs":["https:\/\/www.facebook.com\/gilles.wonder.hoarau","https:\/\/fr.linkedin.com\/in\/gilleshoarau","https:\/\/twitter.com\/gilleshoarau"],"name":"Gilles Hoarau"}</script>
<!-- / Yoast SEO plugin. -->

<link rel='stylesheet' id='mailchimp-for-wp-checkbox-css'  href='http://www.gilleshoarau.com/da/wp-content/plugins/mailchimp-for-wp/assets/css/checkbox.min.css?ver=2.3.17' type='text/css' media='all' />

<link rel='stylesheet' id='style-style-css'  href='http://www.gilleshoarau.com/da/wp-content/themes/rock-gilleshoarau/style.css' type='text/css' media='all' />

<style type='text/css'>
</style>

<style type="text/css">
html { background:#081217; }
body { color:#081217; }
</style>

<meta name="author" content="Gilles Hoarau">
<link rel="shortcut icon" href="http://www.gilleshoarau.com/da/wp-content/themes/rock-gilleshoarau/img/ico/favicon.ico">

<style type="text/css">
.broken_link, a.broken_link {
  text-decoration: line-through;
}
</style>
