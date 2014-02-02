<?php

// AUDIO Content /////////////////////////////////////////////

/*//**//**//**//*//**//**//**//*//**//**//**//*//**//**//**/


// GET EMBED AUDIO /////////////////////////////////////////////
// Afficher l'iframe correspondant au code d'un post audio
function br_getEmbedAudio($array) {
	switch($array['type']) {
		default:
			// Soundcloud
			return '<iframe class="" src="https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/tracks/'.$array['track'].'&amp;color='.$array['color'].'&amp;auto_play='.$array['autoplay'].'&amp;show_artwork='.$array['show_artwork'].'" width="'.$array['width'].'" height="'.$array['height'].'" scrolling="no" frameborder="no"></iframe>';
		break;		
	}
}
function br_EmbedAudio($array) { echo br_getEmbedAudio($array); }