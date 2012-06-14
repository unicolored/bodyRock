/* Author: */

$(document).ready(function(){
	
	var thumbnailsHeight=$("ul.thumbnails").height();
	$(".navbefore").height(thumbnailsHeight);
	$(".navafter").height(thumbnailsHeight);
	
	$('footer .nav').addClass('pull-right');
	$('footer ul.nav').append('<li class="navbar-text"> © uniD MagaZine </li>');
	
	$('.carousel').carousel({ pause:'false' });
	
	$(document).ready(function() {
	var diaporama=$('.diaporama')
	
/*	function letsshow(theitem) {
		var alignvertical=(diaporama.height()-theitem.height())/2;
		$(theitem).css("position","relative").css("top",alignvertical+"px").css("visibility","visible");
	}*/
	
/*	var theitem=$("#gallery-1 .gallery-item:first");
	letsshow(theitem);*/

	/*
	var countall=$(".diaporama .gallery-item").size();
	var i=0;
	var theitem=[];
	var alignvertical=[];
	$('#gallery-1 .gallery-item').each(function(index) {
		i++;
		theitem[i]=$(this);
		alignvertical[i]=(diaporama.height()-theitem[i].height())/2;
	});

	for (i=1; i<=countall; i++){
//		alert('go');
	//	document.write(theitem[i]);
		theitem[i].css("position","relative").css("top",alignvertical[i]+"px").css("visibility","visible").delay(8000).fadeOut(400);
//		theitem[i].delay(5000).hide();
	} 
	*/
	
		var defaults = {
			delay: 4,
			animationSpeed: "0",
			controls:false
		};
				
		var options = $.extend(defaults, options);
		
//	$(".group3").colorbox({rel:false, slideshow:true, transition:'fade'});
//	$(".group3").click(function(){ $('span.overlay').show(); $("#diaporamaPlayer").show().prepend('<div id="cboxOverlay" style="background:url('+$(this).attr('href')+') center center no-repeat; height:570px; position:relative;"></div>'); $('#noPlayer').hide(); return false; });
	$(".group3").click(function(){
		$('span.overlay').show();
//		var showthat = '<div id="cboxOverlay" style="background:url('+$(this).attr('href')+') center center no-repeat; height:570px; position:relative;"></div>';
		var title = $(this).attr('title');
		var permalink = $(this).find('.imgpermalink').text();
		var imgurl = $(this).attr('href');
		var showthat = '<div id="cboxOverlay" style="text-align:center; position:relative;"><article><header><h1><a href="'+permalink+'">'+title+'</a> <a href="'+permalink+'"><span>permalink</span></a></h1></header> <img src="'+imgurl+'" /></article></div>';
		$("#diaporamaPlayer").show().prepend(showthat);
		$('#noPlayer').hide();
		$('#myCarousel').hide();
		return false;
	});
	$(".size-thumbnail").click(function(){ $('span.overlay').show(); $("#diaporamaPlayer").show().prepend('<div id="cboxOverlay" style="background:url('+$('.unislider b[title="'+$(this).attr('title')+'"]').attr('href')+') center center no-repeat; height:570px; position:relative;"></div>'); $('#noPlayer').hide(); return false; });
	$("body").click(function(){ $('span.overlay').hide(); $("#cboxOverlay").remove("#cboxOverlay"); $("#diaporamaPlayer").hide(); $("#myCarousel").removeClass('carousel'); $('#noPlayer').show(); });
	http://dev.gilleshoarau.com/a-la-decouverte-de-paris/22-20051026184831/
	$(".playDiaporama").click(function(){ $('#myCarousel').show(); $('#noPlayer').hide(); $('span.overlay').show(); $('.carousel').carousel({ pause:'false' }); $("#myCarousel").addClass('carousel'); $('.carousel').carousel({ pause:'false' }); $("#diaporamaPlayer").show(); return false; });
	
	$('#gallery-1').each(function(){
		
			var obj = $(this);
			
			if($(obj).find("div").length > 1){
				var inter = setInterval(function(){nextElt(options)}, (options.delay*1000));
				var sens = "right";
				var pause = false;
				$(obj).find("br").remove();				
				$(obj).find("div.gallery-item").hide();
				
				var theitem=$(obj).find("div.gallery-item span.gallery-icon a b");
//				alert(theitem.attr('height'));
				var alignvertical=(diaporama.height()-theitem.attr('height'))/2;
				theitem.css("position","absolute").css("top",alignvertical+"px").css("left","0px");
				
				$(obj).find("div:first-child").addClass("active").show();
				
				// Controls
				
				if(options.controls)
				{
					$(obj).after("<div class='diaporama_controls'><div class='btns'>&nbsp;<a href='#' class='prev'>Prec.</a> <a href='#' class='pause'>Pause</a> <a href='#' class='next'>Suiv.</a></div></div>");
					
					$(obj).siblings().find(".prev").click(function(){
						clearInterval(inter);
						prevElt(options);
						if(!pause)
							inter = setInterval(function(){prevElt(options)}, (options.delay*1000));
						sens = "left";
					});
					
					$(obj).siblings().find(".next").click(function(){
						clearInterval(inter);
						nextElt(options);
						if(!pause)
							inter = setInterval(function(){nextElt(options)}, (options.delay*1000));
						sens = "right";
					});
													
					$(obj).siblings().find(".pause").toggle(
						function(){
							$(this).removeClass("pause").addClass("play");
							clearInterval(inter);
							pause = true;
						},
						function(){
							$(this).removeClass("play").addClass("pause");
							inter = setInterval(function(){ (sens == "right")?nextElt(options):prevElt(options)}, (options.delay*1000));
							pause = false;
						}
					);
				}
				
				// Affiche l'élément suivant
				
				function nextElt(options)
				{
					$(obj).find("div.active").fadeOut(2000);
					
					if(!$(obj).find("div.active").is(":last-child"))
					{
						var theitem=$(obj).find("div.active").next('div').find("span.gallery-icon a b");
//						alert(theitem.attr('height'));
						var alignvertical=(diaporama.height()-theitem.attr('height'))/2;
						theitem.css("position","absolute").css("top",alignvertical+"px").css("left","0px");
						
						
						$(obj).find("div.active").next('div').addClass("active").prev('.active').removeClass("active");
						$(obj).find("div.active").fadeIn(1000).prev('div').fadeOut(2000);						
						
					}
					else
					{
						$(obj).find("div:first-child").addClass("active").fadeIn(options.animationSpeed);
						$(obj).find("div:last-child").removeClass("active");
					}
				}
				
				// Affiche l'élément précédent
				
				function prevElt(options)
				{
					$(obj).find("div.active").fadeOut(options.animationSpeed);
					
					if(!$(obj).find("div.active").is(":first-child"))
					{
						$(obj).find("div.active").prev().addClass("active").next().removeClass("active");
						$(obj).find("div.active").fadeIn(options.animationSpeed);
						
					}
					else
					{
						$(obj).find("div:last-child").addClass("active").fadeIn(options.animationSpeed);
						$(obj).find("div:first-child").removeClass("active");
					}
				}
			}
		});
});


});