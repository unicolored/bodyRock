<?php

// INTERFACE /////////////////////////////////////////////

/*//**//**//**//*//**//**//**//*//**//**//**//*//**//**//**/
// Génération d'éléments Html utiles au thème.
// Ces fonctions sont "overridable" par le thème enfant.
/*//**//**//**//*//**//**//**//*//**//**//**//*//**//**//**/


// MENU DEFAULT /////////////////////////////////////////////
// Affiche un menu simple par défaut lorsque le thème n'a pas de menu déclaré
if(!function_exists('br_menu_default')) { // Permet l'override par le thème child
	function br_menu_default() {
		// Utilisé dans la navbar
		echo '<ul class="nav navbar-nav">';
		echo '<li><a href="/">Home</a></li>';
		echo '</ul>';
	}
}

// GET PAGE ICON /////////////////////////////////////////////
// Récupérer l'icône d'une page d'après un identifiant texte
if(!function_exists('br_getPageIcon')) { // Permet l'override par le thème child
	function br_getPageIcon($id = false) { // Actuellement si l'identifiant est un chiffre, la fonction retourne l'icone 'align-left'	
	
		$ICONES[$id] = $id; // Par défaut, l'icône appellé est chargé sans traduction
		
		// Traduction d'identifiant en icônes
		/*ICONS*/
		$ICONES['recommandation'] = "bullhorn";
		$ICONES['search'] = "search";
		$ICONES['stats'] = "stats";
		$ICONES['user'] = "user";
		$ICONES['plus'] = "plus";
		$ICONES['comment'] = "comment";
		$ICONES['article'] = "file";
		$ICONES['warning'] = "exclamation-sign";
		$ICONES['carousel-control-left'] = "circle-arrow-left";
		$ICONES['carousel-control-right'] = "circle-arrow-right";
		/*FORMATS*/
		$ICONES['image'] = $ICONES['gallery'] = "picture";
		$ICONES['video'] = "film";
		$ICONES['audio'] = "music";
		/*CATEGORIES*/
		$ICONES['blog'] = "file";
		/*PAGES*/
		$ICONES['accueil'] = $ICONES['home'] = "home";
		
		if($id != false) {
			if(is_int($id)) {
				$icon = 'align-left';	
			}
			else {
				$icon = $ICONES[$id];
			}
		}
		else $icon = $id;
		
		return $icon;
	}
}

// GET ICON /////////////////////////////////////////////
// Affiche l'icône choisie en fonction de la police (Glyphicons, Font-Awesome, Elusive)
if(!function_exists('br_getIcon')) { // Permet l'override par le thème child
	function br_getIcon($id = false) {
		switch(BR_ICON_SET) {
			default : 
				return "<b class='myicon myicon-".$id."'></b>";
			break;
			case 'disabled' : 
				return true;
			break;
			case 'glyphicon' :
				return "<span class='glyphicon glyphicon-".br_getPageIcon($id)."'></span>";
			break;
			
			case 'font-awesome' :
				return "<i class='fa fa-".br_getPageIcon($id)."'></i>";
			break;
			
			case 'elusive';
				return "<span class='el-icon-".br_getPageIcon($id)."'></span>";
			break;
		}
	}
}
function br_Icon($id = false) { echo br_getIcon($id); }

// GET SECTION CLASS /////////////////////////////////////////////
// Définit la classe générale de section dans le header en fonction de la page chargée
if(!function_exists('br_getSectionClass')) { // Permet l'override par le thème child
	function br_getSectionClass($id = 'defaut') {
		$page['default'] = 'int-page';
		$page['front-page'] = 'int-page';
		$page['single'] = 'int-single';
		$page['category'] = 'int-category';
		$page['search'] = $page['tag'] = 'int-column-right';
		$page['404'] = 'int-page';
		$page['home'] = 'int-home';
		
		return $page[$id];
	}
}
    
?>
