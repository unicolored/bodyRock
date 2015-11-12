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
