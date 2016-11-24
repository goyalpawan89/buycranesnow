
$(document).ready(function ($) {

	// ancho del div pushobj 
	//var sidebar = $('.levelHolderClass').width() + 45;
	var sidebarWidth = 245;
    var windowWidth = $(window).width();
    $("#pushobj").width(windowWidth - sidebarWidth);	


	// TOOLTIPS 
	$( ".tooltip" ).tooltip({
  		tooltipClass: "info-tooltip"
	});

	// fechas con Jquery
  	$(function() {
    	$( ".datepicker" ).datepicker();
  	});

	// ancho del div pushobj cambio de pantalla
  	$(window).resize(function() {
        var sidebarWidthResize = $('.levelHolderClass').width() + 45;
        var windowWidth = $(window).width();
        $("#pushobj").width(windowWidth - sidebarWidthResize);
		
    });

    //completar el tamaño del div#pushobj con la pantalla
  	var windowWidth = $(window).width();
	$('.fa-reorder').click(function(){
	     $("#pushobj").toggleClass('completo');
	 });

    //conteo automatico.
    function count($this){
        var current = parseInt($this.html(), 10);
        current = current + 5; /* Where 1 is increment */
    
        $this.html(++current);
        if(current > $this.data('count')){
            $this.html($this.data('count'));
        } else {    
            setTimeout(function(){count($this)}, 50);
        }
    }
    
    jQuery(".stat-count").each(function() {
      jQuery(this).data('count', parseInt(jQuery(this).html(), 10));
      jQuery(this).html('0');
      count(jQuery(this));
    });

	
});	    


// esconder y mostrar buscador

$('ul#menu_bar li.searchit').click(function() {
    $(this).addClass('search');
    $('.searchbox').fadeIn();
    $('ul#menu_bar li .searchicon').hide();
});


$('ul#menu_bar li.searchit img.closesearch').click(function(e) {
    e.stopPropagation();
    $('.searchbox').hide();
    $('ul#menu_bar li').removeClass('search');
});
$(document).click(function (e)
{
    var container = $(".searchit");

    if (!container.is(e.target)
        && container.has(e.target).length === 0) 
    {
         $('.searchbox').hide();
    $('ul#menu_bar li').removeClass('search');
$('ul#menu_bar li .searchicon').show();    }
});



$(window).load(function() { 


    $(".ajax-file-upload-statusbar").click(function() { 
        $(this).fadeOut("fast");
    });



    $('body').addClass('show');

});


// scroll top
window.onscroll=function () {
    // esconder #menu_bar notificaciones cuando se baja el scroll (el div tiene posision fixed, toca esconderlo)
    var top = window.pageXOffset ? window.pageXOffset : document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop;
    if(top > 20){ 
    		$("#menu_bar").fadeOut('slow');
    } else {
        	$("#menu_bar").fadeIn('slow');
    }
};