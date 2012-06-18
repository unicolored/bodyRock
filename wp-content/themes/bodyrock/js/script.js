/* Author: */

$(document).ready(function(){
	$('ul.sub-menu').addClass('dropdown-menu'); // hack js du wp_nav_menu pour la compatibilité de la class avec le système bootstrap
	$('ul.sub-menu').parent().addClass('dropdown'); // hack js du wp_nav_menu pour la compatibilité de la class avec le système bootstrap
	$('li.dropdown').find('a:first').append(' <b class="caret"></b>').addClass('dropdown-toggle').attr('href',"#").attr('data-toggle',"dropdown"); // hack js du wp_nav_menu pour la compatibilité de la class avec le système bootstrap
	$('.dropdown-toggle').dropdown();
	
	var thumbnailsHeight=$("ul.thumbnails").height();
	$(".navbefore").height(thumbnailsHeight);
	$(".navafter").height(thumbnailsHeight);
	
	$('footer .nav').addClass('pull-right');
	$('footer ul.nav').append('<li class="navbar-text"> © uniD MagaZine </li>');
	
	$('.carousel').carousel({
//	  interval: 2000
	})
});