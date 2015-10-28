<?php

// ICONES /////////////////////////////////////////////

/*//**//**//**//*//**//**//**//*//**//**//**//*//**//**//**/
// Génération d'éléments Html utiles au thème.
// Ces fonctions sont "overridable" par le thème enfant.
/*//**//**//**//*//**//**//**//*//**//**//**//*//**//**//**/



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
		switch(BR_ICONSET) {
			default :
				return "<span class='glyphicon glyphicon-".br_getPageIcon($id)."'></span>";
			break;
			case 'fontawesome' :
				return "<i class='fa fa-".br_getPageIcon($id)."'></i>";
			break;
			case 'linearicons';
				return "<span class='lnr lnr-".br_getPageIcon($id)."'></span>";
			break;
			case 'octicons';
				return "<span class='octicon octicon-".br_getPageIcon($id)."'></span>";
			break;
		}
	}
}
function br_Icon($id = false) { echo br_getIcon($id); }

function br_getAvailableIcones() {
	// Liste des icones dont les appellations sont similaires entres Glyphicons, Font-Awesome, ...
	return array(
			"home",
			"adjust","align-center","align-left","align-right","align-justify","bold","text-height","text-width","font","italic",
			"th","th-large","th-list","tag","tags","tasks","list","list-alt",
			"arrow-down","arrow-left","arrow-right","arrow-up",
			"refresh","retweet",
			"step-backward","step-forward","play","stop","pause","play-circle","random","repeat","fast-backward","fast-forward","forward",
			"volume-down","volume-off","volume-up",
			"chevron-down","chevron-up","chevron-left","chevron-right","asterisk","calendar","camera","bell","book","briefcase","bullhorn",
			"barcode","bookmark","certificate","cloud","cog","credit-card","leaf",
			"envelope","inbox",
			"film","fire",
			"file","flag","gbp","usd",
			"gift","glass","globe","headphones","heart","link","lock","magnet","map-marker","plus","minus",
			"music","pencil","phone","qrcode","road",
			"shopping-cart","signal","star",
			"thumbs-down","thumbs-up","tint",
			"upload","user","dashboard","wrench","edit","filter",
			"check","download","eject","comment","print","share","search","folder-open",
			"plane"
			);
}

?>
