<?php

// DEBUG Backend /////////////////////////////////////////////

/*//**//**//**//*//**//**//**//*//**//**//**//*//**//**//**/
// Fonctions utiles au développement.
/*//**//**//**//*//**//**//**//*//**//**//**//*//**//**//**/


// VARDUMP ///////////////////////////////////////////// 
// Fait un affichage propre de var_dump()
function vardump($v) {
	echo '<pre>';
	var_dump($v);
	echo '</pre>';
}

function deprecated($oldfunction,$newfunction) {
	if (current_user_can('list-users')) {
		echo '<pre> • <strong>AVERTISSEMENT</strong> <strong>Fonction dépréciée</strong> Remplacer <em>'.$oldfunction.'</em> par <em>'.$newfunction.'</em></pre>';
	}
}