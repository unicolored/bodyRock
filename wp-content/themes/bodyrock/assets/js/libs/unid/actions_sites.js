/*
 * UniD, Websites Management System
 *
 * (C) Copyright 2009-2011 Unicolored
 *    	                Gilles Hoarau
 *
 * actions_sites.js 28/12/2009 21:13
 *
 */
$(document).ready(function()
{//Actions par défaut pour les sites

	$.fn.clearForm = function() {
	return this.each(function() {
	  var type = this.type, tag = this.tagName.toLowerCase();
	  if (tag == 'form')
		return $(':input',this).clearForm();
	  if (type == 'text' || type == 'password' || tag == 'textarea')
		this.value = '';
	  else if (type == 'checkbox' || type == 'radio')
		this.checked = false;
	  else if (tag == 'select')
		this.selectedIndex = -1;
	});
  };
  
  
  // SCRIPT DU FORMULAIRE DE CONTACT POUR L'ENVOI DE MAIL
	$("#submitsend").click( function()
	{
		$("#submitsend").addClass('saved');
		$.ajax({
			type: "GET",
			url: "index.php",
			data: "action=form_contact&nom="+$('#nom').val()+"&email="+$('#email').val()+"&sujet="+$('#sujet').val()+"&message="+$('#message').val(),
			success: function(msg) {
				if(msg!='nom' && msg!='sujet' && msg!='email' && msg!='message') { alert(msg); $('form').clearForm(); }
				$("form :input").removeClass('error'); $("form :textarea").removeClass('error');
				$("#"+msg).addClass('error');
				$("#submitsend").removeClass('saved');
			}
		});	
		return false;
	});
	
	
  // SCRIPT DU FORMULAIRE D'INSCRIPTION 
	$("#valide_inscription ").hide();
  
	$("#submitinscription").click( function()
	{
		$("#submitinscription").addClass('saved');
		$.ajax({
			type: "GET",
			url: "index.php",
			data: "action=inscription&identifiant="+$('#identifiant').val()+"&mail="+$('#mail').val()+"&pass="+$('#pass').val()+"&confirmationpass="+$('#confirmationpass').val()+"&urlnext="+$('#urlnext').val(),
			success: function(msg) {
				if (msg==1) { $("#valide_inscription ").fadeIn(); $("#form_inscription").hide(); }
				else $("#information").html(msg);
				/*if(msg!='nom' && msg!='sujet' && msg!='email' && msg!='message') { alert(msg); $('form').clearForm(); }
				$("form :input").removeClass('error'); $("form :textarea").removeClass('error');
				$("#"+msg).addClass('error');
				$("#submitsend").removeClass('saved');*/
			}
		});	
		return false;
	});
});