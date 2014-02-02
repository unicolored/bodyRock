<?php
// Le <footer> et sa classe .footer
echo '<footer class="footer">';
get_template_part('tpl/bootstrap/navbars', 'footer');
echo '</footer>';
		
// Termine la section qui commence dans le header.php
echo '</section> <!-- end section int-'.$main_section_class.' -->';
	
wp_footer(); // Indispensable pour le bon fonctionnement de Wordpress et des plugins

// br_generateVideoImg(); // Sur les -post video-, cette fonction génère les images d'après la source et les enregistre sur le serveur

echo '</body>';
echo '</html>';

?>