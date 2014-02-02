/*
 * UniD, Js Framework Model
 *
 * (C) Copyright 2009-2013 Unicolored
 *    	                Gilles Hoarau
 *
 * unid.js 04/01/2014 23:43
 *
 */

// Création du framework UniDmyDesK ù.();
(function (){
	var variable=0;

	var Unid = {
		elems :[],
		makeAlert: function(txt){ alert(txt); },			
		// Création du bureau
		makeDesk: function(name)
		{
			return $('<div/>', { id: name, css: { height: $(window).height()-tabsbarheight+'px' } }).addClass("backcenter").show();
		}
	};

	if(!window.ù){window.ù=Unid;} //Nous créons un raccourci pour notre framework, nous pouvons appeler les méthodes par ù.method ();
})();