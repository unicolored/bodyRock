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
{
/* JQUERY UI */
	
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
	
	$(".savepos").click( function()
	{
		s=$(this);
		$(".posmod").addClass('saved');
		$.ajax({
			type: "GET",
			url: "index.php",
			data: "action=modules_changepos&idmod="+s.attr("id")+"&position="+$('#'+s.attr("id")).val()+"&idpage="+$('.idpage').val(),
			success: function(msg) { $(".posmod").removeClass('saved'); }
		});
		return false;
	});	
	
	// GESTION DES COMBOBOX
	(function( $ ) {
	$.widget( "ui.combobox", {
		_create: function() {
			var self = this,
				select = this.element.hide(),
				selected = select.children( ":selected" ),
				value = selected.val() ? selected.text() : "";
			var input = this.input = $( "<input>" )
				.insertAfter( select )
				.val( value )
				.autocomplete({
					delay: 0,
					minLength: 0,
					source: function( request, response ) {
						var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
						response( select.children( "option" ).map(function() {
							var text = $( this ).text();
							if ( this.value && ( !request.term || matcher.test(text) ) )
								return {
									label: text.replace(
										new RegExp(
											"(?![^&;]+;)(?!<[^<>]*)(" +
											$.ui.autocomplete.escapeRegex(request.term) +
											")(?![^<>]*>)(?![^&;]+;)", "gi"
										), "$1" ),
									value: text,
									option: this
								};
						}) );
					},
					select: function( event, ui ) {
						ui.item.option.selected = true;
						self._trigger( "selected", event, {
							item: ui.item.option
						});
					},
					change: function( event, ui ) {
						if ( !ui.item ) {
							var matcher = new RegExp( "^" + $.ui.autocomplete.escapeRegex( $(this).val() ) + "$", "i" ),
								valid = false;
							select.children( "option" ).each(function() {
								if ( $( this ).text().match( matcher ) ) {
									this.selected = valid = true;
									return false;
								}
							});
							if ( !valid ) {
								// remove invalid value, as it didn't match anything
								$( this ).val( "" );
								select.val( "" );
								input.data( "autocomplete" ).term = "";
								return false;
							}
						}
					}
				})
				.addClass( "ui-widget ui-widget-content ui-corner-left" );

			input.data( "autocomplete" )._renderItem = function( ul, item ) {
				return $( "<li></li>" )
					.data( "item.autocomplete", item )
					.append( "<a>" + item.label + "</a>" )
					.appendTo( ul );
			};

			this.button = $( "<button type='button'>&nbsp;</button>" )
				.attr( "tabIndex", -1 )
				.attr( "title", "Montrer tous" )
				.insertAfter( input )
				.button({
					icons: {
						primary: "ui-icon-triangle-1-s"
					},
					text: false
				})
				.removeClass( "ui-corner-all" )
				.addClass( "ui-corner-right ui-button-icon" )
				.click(function() {
					// close if already visible
					if ( input.autocomplete( "widget" ).is( ":visible" ) ) {
						input.autocomplete( "close" );
						return;
					}

					// work around a bug (likely same cause as #5265)
					$( this ).blur();

					// pass empty string as value to search for, displaying all results
					input.autocomplete( "search", "" );
					input.focus();
				});
		},

		destroy: function() {
			this.input.remove();
			this.button.remove();
			this.element.show();
			$.Widget.prototype.destroy.call( this );
		}
	});
})( jQuery );
});