/*
 * UniD, Websites Management System
 *
 * (C) Copyright 2009-2011 Unicolored
 *    	                Gilles Hoarau
 *
 * actions.js 28/12/2009 21:12
 *
 */
$(document).ready(function()
{//Actions pour l'administration

	$("#sidebar h3").hover(
		function () {
		$(this).addClass("hover");
		},
		function () {
		$(this).removeClass("hover");
		}
	);

$("#confirmation").dialog({
	autoOpen: false,
	overlay: { backgroundColor: '#000', opacity: 0.5 },
	bgiframe:true
});

$(".confirm").click(function(e)
{
	e.preventDefault();
	var targetUrl = $(this).attr("href");
	
	$('#confirmation').dialog('option', 'buttons',
	{
		"Oui, continuer": function() { window.location.href = targetUrl; },
		"Annuler" : function() { $(this).dialog("close"); }
	});

	$('#confirmation').dialog('option', 'bgiframe', true);
	$('#confirmation').dialog('option', 'draggable', true);
	$('#confirmation').dialog('option', 'resizable', false);
	$('#confirmation').dialog('option', 'closeOnEscape', true);
	$('#confirmation').dialog('option', 'overlay', { backgroundColor: '#000', opacity: 0.5 });
	
	$("#confirmation").dialog("open");
});



$("#notsave").dialog({
	autoOpen: false,
	overlay: { backgroundColor: '#000', opacity: 0.5 },
	bgiframe:true
});

$(".notsave").click(function(e)
{
	e.preventDefault();
	var targetUrl = $(this).attr("href");
	
	$('#notsave').dialog('option', 'buttons',
	{
		"Oui, continuer": function() { window.location.href = targetUrl; },
		"Annuler" : function() { $(this).dialog("close"); }
	});

	$('#notsave').dialog('option', 'bgiframe', true);
	$('#notsave').dialog('option', 'draggable', true);
	$('#notsave').dialog('option', 'resizable', false);
	$('#notsave').dialog('option', 'closeOnEscape', true);
	$('#notsave').dialog('option', 'overlay', { backgroundColor: '#000', opacity: 0.5 });
	
	$("#notsave").dialog("open");
});



$("#denied").dialog({
	autoOpen: false,
	overlay: { backgroundColor: '#000', opacity: 0.5 },
	bgiframe:true
});

$(".denied").click(function(e)
{
	e.preventDefault();
	var targetUrl = $(this).attr("href");
	
	$('#denied').dialog('option', 'buttons',
	{
		"Fermer" : function() { $(this).dialog("close"); }
	});

	$('#denied').dialog('option', 'bgiframe', true);
	$('#denied').dialog('option', 'draggable', true);
	$('#denied').dialog('option', 'resizable', false);
	$('#denied').dialog('option', 'closeOnEscape', true);
	$('#denied').dialog('option', 'overlay', { backgroundColor: '#db0000', opacity: 0.5 });
	
	$("#denied").dialog("open");
});

$(".savepos").live('click', function()
		{
			$(".posmod").addClass('saved');
			
			$.ajax({
				type: "GET",
				url: "index.php",
				data: "action=modules_changepos&idmodule="+$(this).attr("id")+"&position="+$('#'+$(this).attr("id")).val()+"&idpage="+$('.idpage').val(),
				success: function(msg) { $(".posmod").removeClass('saved'); }
			});	
		});
});