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
	//ù.makeAlert('Bienvenue sur votre bureau');
	Deskbar=ù.makeDeskbar('Desktopbar');
	Panel=ù.makePanel('Panel');
	Desktop=ù.makeDesk('Desktop').append(Panel).append(Deskbar);
	ù.resize(Desktop);
	
	$.ajax({
		type: "POST",
		url: "/?action=load_moves",
		success: function(msg)
		{
			Result=msg;
			b=Result.split('::');
			for(x in b)
			{
				var a=b[x].split(',');

				if (a!=false)
				{
					var id=a[0];
					var pos_top=a[1];
					var pos_left=a[2];
					var name=a[3];
					var url=a[4];
					var loading=a[5];
					var type=a[6];
					var icon=a[7];
					
					Desktop.prepend(ù.makeIcone(id,pos_top,pos_left,name,icon,url,loading,type));
	//				$("#Desktop").append('<div id="icone'+a[0]+'" class="icone"><b class="icon arrow_out"></b><a class="icone'+a[0]+'" href="'+a[4]+'"><p></p><span>'+a[3]+'</span></a></div>');

					if (loading>0)	{ $("#tabs").append(ù.makeTab(id,type)); Desktop.append(ù.openWindow(parseFloat(id),parseFloat(type),parseFloat(loading)).hide()); }
					if (loading==2) { $("#window_"+id).show(); }
				}
			}
		}
	});
	
	$('body').prepend(Desktop);
	
	// EVENTS
	$(window).bind('resize', function() { ù.resize(Desktop); });
	
	// ICONES
	$(".icone a").live('click',function(){
		//
		$("#load").show();
		loading=$(this).attr('class').replace('load','');
		id=$(this).parent('div').attr('id').replace('icone','');
		type=$(this).data('type');

		if (loading==0)	{  $("#tabs").has("p#icone"+id).length ? false : $("#tabs").append(ù.makeTab(id,type)); }
	
		if ($('#window_'+id).length>0) { $('#window_'+id).show(); $("p#icone"+id).addClass('active');  }
		else { if ($('#tabs p#icone'+id).length==0) $("#tabs").append(ù.makeTab(id,type)); $("p#icone"+id).addClass('active'); Desktop.append(ù.openWindow(id,type,loading)); }
		
		$.ajax({
			type: "POST",
			url: "/?action=window_loading",
			data: "id="+id,
			success: function(msg) { $("#load").hide(); }
		 });

		return false;
	});
	
	// DESKBAR
	$("#start")
	.live('click',function()
	{
		$("#Panel").show();
		$("#load").show();
		$(".icone").show();
		$('.window').hide();
		$.ajax({
			type: "POST",
			url: "/?action=window_loading",
			success: function(msg) { $("#load").hide(); }
		});
		$("#tabs p").removeClass('active');
		return false;
	});
	$("#Desktop")
	.live('click',function()
	{
		$("#Panel").hide();
		return false;
	});
	
	// WINDOWS
	$('.close').live('click', function() { $(this).parents('div.window').hide(); var ide=$(this).parents('div.window').attr('id'); ù.closeWindow(ide); });
	
	//icones=ù.makeIcone(1,20,20,'myFirstIcone','http://here.com','0','0');
});