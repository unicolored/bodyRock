/*
 * UniD, Websites Management System
 *
 * (C) Copyright 2009-2011 Unicolored
 *    	                Gilles Hoarau
 *
 * createadmin.js 28/12/2009 21:12
 *
 */
$(document).ready(function()
{//Actions pour l'administration
	$("#addsup").click(function(){ $(".intro").slideUp(); $("#formulaire").slideDown(); });
	$("#readhelp").click(function(){ $(".intro").show(); $("#formulaire").hide(); });

});