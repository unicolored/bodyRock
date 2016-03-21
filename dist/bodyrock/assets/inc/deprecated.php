<?php

// DEPRECATED :: Fonctions dépréciées /////////////////////////////////////////////

/*//**//**//**//*//**//**//**//*//**//**//**//*//**//**//**/
// Fonctions qui ont changé de nom
/*//**//**//**//*//**//**//**//*//**//**//**//*//**//**//**/

/*

Exemple :
Votre ancienne fonction br_nomdufichier_oldmethod() ne s'appelle plus correctement.
Mais plusieurs de vos thèmes enfants utilisent cette fonction. Il faut donc conserver son nom et appeller la nouvelle fonction.

On copiera dans ce fichier :

function br_nomdufichier_oldmethod() {
	return br_nomdufichier_newmethod();
}

Note : concerne principalement les fonctions br_ qui peuvent être utilisée par un thème enfant qui mettrait à jour le thème parent.

*/
if(!function_exists('bitly_url')) {
function bitly_url() {
	deprecated(__FUNCTION__,'br_backend_filesWrite_videoimg');
	//br_backend_filesWrite_videoimg();
}
}

function br_generateVideoImg() {
	deprecated(__FUNCTION__,'br_backend_filesWrite_videoimg');
	br_backend_filesWrite_videoimg();
}

function auto_compile_less($less_fname, $css_fname) {
	deprecated(__FUNCTION__,'backend_filesWrite_less');
	backend_filesWrite_less($less_fname, $css_fname);
}

function bodyrock_posted_on($sep=false) {
	deprecated(__FUNCTION__,'br_content_textesGet_posted_on');
	br_content_textesGet_posted_on($sep=false);
}

function br_setLastViews() {
	deprecated(__FUNCTION__,'br_modules_lastviewsSet');
	br_modules_lastviewsSet();
}
?>
