$(document).bind('mousemove', function(e){
//	alert(e.pageY-e.pageX);
	
    	
	//$('.wheel ul').css({
   //    left:  -e.pageX+525
/*       top:   e.pageY-70*/
   // });
   var bw=$("body").width();
   var bh=$("body").height();
   
   var cX=bw/2;
   var cY=bh/2;
   
   var maxdegree=(e.pageX*bw)/360;
   
   $(".pageX").remove();
   var pX=(e.pageX-cX)/(960/45);
   var pY=e.pageY-cY;
  // $("body").prepend('<h1 style="position:absolute;left:100px;" class="pageX">pX:'+pX+'</h1>')
   $(".pageY").remove();
   //$("body").prepend('<h1 style="position:absolute;left:0px;" class="pageY">pY:'+pY*-1+'</h1>')
   
   if(pX>0){
	   
		$('.wheel ul').animate({
	    //opacity: 0.25,
	    left: '+='+pX*10,
	    //height: 'toggle'
	  }, 5000, function() {
	    // Animation complete.
	  });
   }
   else {
	   var pXn=-1*pX;
	   $('.wheel ul').animate({
	    //opacity: 0.25,
	    right: '-='+pX*10,
	    //height: 'toggle'
	  }, 5000, function() {
	    // Animation complete.
	  });
   }

	var r=(e.pageX-584);
    $('.wheel').rotate(pX/2);
});