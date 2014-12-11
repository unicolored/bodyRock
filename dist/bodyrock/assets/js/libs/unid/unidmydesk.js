/*
 * UniD, Websites Management System
 *
 * (C) Copyright 2009-2011 Unicolored
 *    	                Gilles Hoarau
 *
 * unidmydesk.js 28/12/2009 21:12
 *
 */
 
 
$(document).ready(function()
{
	// Création du framework UniDmyDesK ù.();
	(function (){
		var tabsbarheight=46;
		var classwindow='.window';
		var classtodadd='backcenter';
		var starthref='/?admin=admin_home';

		var UniDmyDesK = {
			elems :[],
			makeAlert: function(txt){ alert(txt); },
			// DESKTOP / ICONES
			// Resize du Desktop / Viewport
			resize: function (objectresize)
			{
				var windowHeight = $(window).height()-tabsbarheight;
				Desktop.hide().height($(window).height()-tabsbarheight).width('100%').addClass(classtodadd).show();
				$(classwindow).height($(window).height()-tabsbarheight).width('100%');
			},			
			// Création du bureau
			makeDesk: function(name)
			{
				return $('<div/>', { id: name, css: { height: $(window).height()-tabsbarheight+'px' } }).addClass("backcenter").show();
			},
			// Création d'un icone
			makeIcone: function (id,pos_top,pos_left,name,icon,url,loading,type)
			{
				var balise_div=$('<div/>', {
					id: 'icone'+id,
					class: 'icone',
					css: { display: 'none' }
				});
			
				var balise_a=$('<a/>', { class: 'icone'+id, href: url }).data({ 'type':type });
				balise_p=$('<p/>', { class: 'load'+loading }).css({ background: 'url(/themes/img/icons/'+icon+'.png) center center no-repeat' });
				balise_span=$('<span/>', { html: name });
				balise_b=$('<b/>', { class: 'icone'+id+' icon arrow_out' });
				balise_a.append(balise_p);
				balise_a.append(balise_span);
				
				balise_div
				.append(balise_a)
				.append(balise_b)
				.bind('mouseover', function() {  $(this).find('b').css( { visibility:'visible' }); })
				.bind('mouseout', function() { $(this).find('b').css( { visibility:'hidden' }); })
				.css({'top' : pos_top+'px', 'left' : pos_left+'px'})
				.draggable({
					containment: 'parent',
					handle: 'b'
					,
					stop: function(event, ui)
					{
						$("#load").show();
						$.ajax({
							type: "POST",
							url: "/?action=save_move",
							data: "id="+$(this).attr('id')+"&top="+ui.position.top+"&left="+ui.position.left,			   
							success: function(msg) { $("#load").hide(); }
						 });
					}
				});
				return balise_div.show();
			},
			
			// DESKBAR / TABS
			// Création de la barre des tâches
			makeDeskbar: function(name)
			{
				/* Création de la DesktopBar / TabsBar */	
				Desktopbar=$('<div/>', { id: name }).css({ 'opacity': 0.7 }).show();
				start=$('<div/>', { id: 'start' }).append($('<a/>', { href: starthref }));
				tabs=$('<div/>', { id: 'tabs' });
				signature=$('<div/>', { id: 'signature' });
				Desktopbar.append(start,tabs,signature);
				return Desktopbar;
			},
			// Création d'un onglet dans la barre des tâches
			makeTab: function (id,type)
			{
				var new_tab=$('<p/>', {
					id: 'icone'+id,
					class: 'show',
					text: $("a.icone"+id).find('span').html(),
					click: function(){
						$("#load").show();
						$("#tabs p").removeClass('active');
						$(this).addClass('active');
						$('.icone').hide();
						$('.window').hide();
						//Desktop.append(openWindow(id,type));
						$("#load").show();
						$.ajax({
							type: "POST",
							url: "/?action=window_loading",
							data: "id="+$(this).attr('id').replace('icone',''),
							success: function(msg) { $("#load").hide(); }
						 });
						$('#window_'+$(this).attr('id').replace('icone','')).show();
						return false;
					},
					mouseover: function() {$(this).addClass('hover'); },
					mouseout: function() {$(this).removeClass('hover'); }
				});
				return new_tab;
			},
			
			// WINDOWS ACTIONS
			openWindow: function (id,type,loading)
			{
				var new_window=$('<div/>',
					{
						id: 'window_'+id,
						class: 'window show',
						css: { height:$(window).height()+'px' }
					}
				);
				
				var titlebar=$("a.icone"+id).text();
				var href=$("a.icone"+id).attr('href');

				switch(parseFloat(type))
				{
					case 2: new_window.html('<div class="topbar"><h1>'+titlebar+'</h1><span class="close icon cancel">Fermer</span></div><div class="menutop"></div>').load(href);	break;
					case 1: new_window.html('<div class="topbar"><h1>'+titlebar+'</h1><span class="close icon cancel">Fermer</span></div><div class="menutop"></div><iframe src="'+href+'"></iframe>');	break;
					case 0: new_window.html('<div class="topbar"><h1>'+titlebar+'</h1><span class="close icon cancel">Fermer</span></div><div class="menutop"></div>').load(href);	break;
					default: new_window.load(href+'&type='+type); break;
				}
				if(loading==2) $("p#icone"+id).addClass('active');
				$("#load").show();
				$.ajax({
					type: "POST",
					url: "/?action=window_loading",
					data: "id="+id,
					success: function(msg) { $("#load").hide(); }
				 });
				new_window.height($(window).height()-46).width($(window).width());
				
				return new_window;
			},
			closeWindow: function (ide)
			{
				$("#load").show();
				$.ajax({
					type: "POST",
					url: "/?action=window_unload",
					data: "id="+ide,
					success: function(msg) { $("#load").hide(); }
				 });
				$("#tabs #icone"+ide.replace('window_','')).hide().detach();
				$("#"+ide).detach();
				$(".icone").show();
			},
			
			// PANEL
			makePanel: function(name)
			{
				/* Création de la DesktopBar / TabsBar */	
				Panel=$('<div/>', { id: name }).css({ 'opacity': 0.7 }).append('<div id="innerPanel"><a href="/?action=logout">Quitter</a></div>').hide();
				return Panel;
			}
		};

		if(!window.ù){window.ù=UniDmyDesK;} //Nous créons un raccourci pour notre framework, nous pouvons appeler les méthodes par ù.method ();
	})();
	
});