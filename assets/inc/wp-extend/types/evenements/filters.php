<?php
// Filtres pour le type

function br_DateWord($date) {
	$dateword = $date;
	$datetime = strtotime($date);
	$today = date("Y-m-d");
	switch($date) {
		default:
			$dateword = date("l jS F", $datetime); 
			$dateword = br_DateTranslate($dateword);
			if ( date("Y", $datetime) < date("Y") ) {
				$dateword .= ' '.date("Y", $datetime);
			}
		break;
		case $today:
			$dateword = __("Aujourd'hui","bodyrock");
		break;
	}
	return ucfirst(strtolower($dateword));
}

function br_DateFull($date) {
	$dateword = $date;
	$datetime = strtotime($date);
	$today = date("Y-m-d");
	switch($date) {
		default:
			$dateword = date("l jS F", $datetime); 
			$dateword = br_DateTranslate($dateword);
			if ( date("Y", $datetime) < date("Y") ) {
				$dateword .= ' '.date("Y", $datetime);
			}
		break;
	}
	return ucfirst(strtolower($dateword));
}

function br_DateTranslate($date) {
	
	// DAYS
	
	$patterns = array();
	$patterns[0] = '/Sunday/';
	$patterns[1] = '/Monday/';
	$patterns[2] = '/Tuesday/';
	$patterns[3] = '/Wednesday/';
	$patterns[4] = '/Thursday/';
	$patterns[5] = '/Friday/';
	$patterns[6] = '/Saturday/';
	
	$replacements = array();
	$replacements[0] = 'Dimanche';
	$replacements[1] = 'Lundi';
	$replacements[2] = 'Mardi';
	$replacements[3] = 'Mercredi';
	$replacements[4] = 'Jeudi';
	$replacements[5] = 'Vendredi';
	$replacements[6] = 'Samedi';
	
	// MONTHS
	
	$patterns_month = array();
	$patterns_month[1] = '/January/';
	$patterns_month[2] = '/February/';
	$patterns_month[3] = '/March/';
	$patterns_month[4] = '/April/';
	$patterns_month[5] = '/May/';
	$patterns_month[6] = '/June/';
	$patterns_month[7] = '/July/';
	$patterns_month[8] = '/August/';
	$patterns_month[9] = '/September/';
	$patterns_month[10] = '/October/';
	$patterns_month[11] = '/November/';
	$patterns_month[12] = '/December/';
	
	$replacements_month = array();
	$replacements_month[1] = 'Janvier';
	$replacements_month[2] = 'Février';
	$replacements_month[3] = 'Mars';
	$replacements_month[4] = 'Avril';
	$replacements_month[5] = 'Mai';
	$replacements_month[6] = 'Juin';
	$replacements_month[7] = 'Juillet';
	$replacements_month[8] = 'Août';
	$replacements_month[9] = 'Septembre';
	$replacements_month[10] = 'Octobre';
	$replacements_month[11] = 'Novembre';
	$replacements_month[12] = 'Décembre';
	
	// st,th,rd
	
	$patterns_suffix = array();
	$patterns_suffix[1] = '/th/';
	$patterns_suffix[2] = '/rd/';
	$patterns_suffix[3] = '/st/';
	
	$replacements_suffix = array();
	$replacements_suffix[1] = '';
	$replacements_suffix[2] = '';
	$replacements_suffix[3] = '<sup>er</sup>';
	
	$date = preg_replace($patterns, $replacements, $date);
	$date = preg_replace($patterns_month, $replacements_month, $date);
	$date = preg_replace($patterns_suffix, $replacements_suffix, $date);
	return $date;
}