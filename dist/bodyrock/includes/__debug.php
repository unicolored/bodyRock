<?php

// DEBUG Backend /////////////////////////////////////////////

/*//**//**//**//*//**//**//**//*//**//**//**//*//**//**//**/
// Fonctions utiles au développement.
/*//**//**//**//*//**//**//**//*//**//**//**//*//**//**//**/


// ADMINVIEW /////////////////////////////////////////////
// Fonction qui masque en CSS des blocs html en développement et donc visibles uniquement par l'admin
function AdminView() {
	// L'administrateur est validé par la vérification de la capacité 'list-users' qui fait partie des capacités d'admin uniquement.
	// http://codex.wordpress.org/Function_Reference/current_user_can
	// http://codex.wordpress.org/Roles_and_Capabilities#Capabilities
	// Les classes CSS sont définies dans css/less/parts/styles/mymixins.less
	echo !current_user_can('list_users') ? 'hideit' : 'mark';
}

// VARDUMP /////////////////////////////////////////////
// Fait un affichage propre de var_dump()
function vardump($v) {
	echo '<pre>';
	if(is_array($v) || is_object($v)) {
		var_dump($v);
	}
	else {
		var_dump(htmlentities($v));
	}
	echo '</pre>';
}

// DEPRECATED /////////////////////////////////////////////
// Renvoie un avertiseement concernant les fonctions périmées
function deprecated($oldfunction,$newfunction) {
	if (current_user_can('list-users')) {
		echo '<pre> • <strong>AVERTISSEMENT</strong> <strong>Fonction dépréciée</strong> Remplacer <em>'.$oldfunction.'</em> par <em>'.$newfunction.'</em></pre>';
	}
}

// IMG /////////////////////////////////////////////
// Retourne une image placeholder de dimensions égales aux configurations de wordpress : thumbnail, medium, large
function img($thumbnail="large",$class="img-rounded img-responsive") {
	if (is_int($thumbnail)) {
		return false;
	}
	foreach( get_intermediate_image_sizes() as $s ){
		$sizes[ $s ] = array( 0, 0 );
		if( in_array( $s, array( 'thumbnail', 'medium', 'large' ) ) ){
			$sizes[ $s ][0] = get_option( $s . '_size_w' );
			$sizes[ $s ][1] = get_option( $s . '_size_h' );
		}else{
			if( isset( $_wp_additional_image_sizes ) && isset( $_wp_additional_image_sizes[ $s ] ) )
				$sizes[ $s ] = array( $_wp_additional_image_sizes[ $s ]['width'], $_wp_additional_image_sizes[ $s ]['height'], );
		}
	}
	return "<img src='http://placehold.it/".$sizes[$thumbnail][0]."x".$sizes[$thumbnail][1]."' class='".$class."' width='".$sizes[$thumbnail][0]."' height='".$sizes[$thumbnail][1]."' alt='Image'>";
}

// DEBUGSTRUCTURE /////////////////////////////////////////////
// Retourne du html et une css qui permet d'identifier la structure des pages. La fonction peut être appellé de n'importe où dans le body.
function debugStructure() {
	if(WP_DEBUG==true) {
	?>
	<link rel='stylesheet' id='dashicons-css'  href='/wp-content/themes/bodyrock/css/debug.css' type='text/css' media='all' />

	<strong class="color-largecol">large col</strong>
	<strong class="color-smallcol">small col</strong>
	<strong class="color-galaxie">galaxie</strong>
	<strong class="color-section">section</strong>
	<strong class="color-sectioncontent">section.content</strong>
	<strong class="color-aside">aside.aside</strong>
	<strong class="color-asidewidget">aside.widget</strong>
	<strong class="color-sectionwidget">section.widget</strong>
	<strong class="color-article">article</strong>

	<div class="col-ff">
		<strong class="color-largecol">.col-ff</strong>
	</div>

	<div class="col-ff">
		<div class="galaxie">
			<strong class="color-largecol">.col-ff</strong> > <strong class="color-galaxie">.galaxie</strong>
		</div>
	</div>

	<div class="col-ff">
		<div class="galaxie">
			<div class="col-d"><strong class="color-smallcol">.col-ff</strong> > <strong class="color-galaxie">.galaxie</strong> > <strong class="color-smallcol">.col-d</strong></div>
			<div class="col-b"><strong class="color-smallcol">.col-ff</strong> > <strong class="color-galaxie">.galaxie</strong> > <strong class="color-smallcol">.col-b</strong></div>
			<div class="col-b"><div class="galaxie"><strong class="color-smallcol">.col-b</strong> > <strong class="color-galaxie">.galaxie</strong> > <strong class="color-smallcol">.col-b</strong> > <strong class="color-galaxie">.galaxie</strong></div></div>
		</div>
	</div>
	<hr class="clearfix">
<?php
	}
}

// Définition d'une constante YESWEARE qui indique que le site est en développement
// Je m'en sers pour charger les scripts js originaux et non concaténés ni minifiés
// Après la tâche grunt production(aka release), il faut tester la concaténation des fichiers / sur la branche release
$local_settings = get_stylesheet_directory() . '/dev/yesimlocal.php';
if (file_exists($local_settings)) {
  define("YESWEARE","dev");
}
else define("YESWEARE","");

function Debug($var,$text=false) {
  if (is_array($var)) {
    print '<pre>';
    print $text != false ? '<strong>'.$text.'</strong><br>' : false;
    print_r($var);
    print '</pre>';
  }
  else {
    vardump($var);
  }
}

function list_thumbnail_sizes() {
	// Liste les tailles d'images personnalisées des thèmes parent et enfant
	global $_wp_additional_image_sizes;
 	$sizes = array();
	foreach( get_intermediate_image_sizes() as $s ) {
		$sizes[ $s ] = array( 0, 0 );
		if( in_array( $s, array( 'thumbnail', 'medium', 'large' ) ) ) {
			$sizes[ $s ][0] = get_option( $s . '_size_w' );
			$sizes[ $s ][1] = get_option( $s . '_size_h' );
		}
		else {
			if( isset( $_wp_additional_image_sizes ) && isset( $_wp_additional_image_sizes[ $s ] ) ) {
				$sizes[ $s ] = array( $_wp_additional_image_sizes[ $s ]['width'], $_wp_additional_image_sizes[ $s ]['height'], );
			}
		}
	}

 	foreach( $sizes as $size => $atts ) {
 		echo $size . ' ' . implode( 'x', $atts ) . "<br>";
 	}
}
