<?php

// TYPES Wp extend /////////////////////////////////////////////

/*//**//**//**//*//**//**//**//*//**//**//**//*//**//**//**/
// Gestion des custom types de posts.
/*//**//**//**//*//**//**//**//*//**//**//**//*//**//**//**/


// Charge les types d'articles personnalisés
// TOFIX : remplacer $available_custom_types par les constantes définies dans functions.php
global $available_custom_types;
$custom_types = false;
$available_custom_types = array('lieux','evenements');
$bodyrock_options = get_option('brthemeoptions');
foreach($available_custom_types as $k) {
	if($bodyrock_options['type_'.$k]==true) $custom_types[$k]=$k;
}
// activateCustomTypes(array('type1','type2',...));
// où type1 et type2 sont des dossiers distincts dans bodyrock/inc/types/bodyrock/inc/types/
activateCustomTypes($custom_types);


// ACTIVATE CUSTOM TYPES /////////////////////////////////////////////
// Activation des customs types sélectionnés dans les options du thème
function activateCustomTypes($custom_types_to_activate=false) {
	if($custom_types_to_activate!=false && is_array($custom_types_to_activate)) {
		$i=0;
		foreach($custom_types_to_activate as $key=>$val) {
			require_once('types/'.$val.'/main.php'); 
			$i++;
		}
		if($i>0) require_once('types/taxonomies.php');
	}
}