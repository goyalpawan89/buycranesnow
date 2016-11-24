// banner principal


$(document).ready(function() {

      //carousel

      if($('.slider4').length || $('.slider3').length) {

      $('.slider4, .slider3').bxSlider({
        slideWidth: 385,
        minSlides: 2,
        maxSlides: 5,
        moveSlides: 1,
        slideMargin: 0,
        pager: false,
        responsive:true,
        nextText: '',
        prevText: '',
      });

     /*carousel de logos homepages
      $('.slider3').bxSlider({
        slideWidth: 200,
        minSlides: 3,
        maxSlides: 5,
        auto:true,
        moveSlides: 1,
        slideMargin: 0,
        controls: false,
      });
      */

    }


    //before requrireds
    var label = $('input[required=requrired]').parent().find('label');
    label.addClass('tooltip');

    $('input[required=requrired]').each(function() {
        var placeholder = $(this).attr("placeholder");  
        (this).attr('placeholder', placeholder + ' *');
    });

    // TOOLTIPS 
    $( ".tooltip" ).tooltip({
      tooltipClass: "info-tooltip"
    });

    // hover y opaciddad del cabezote
    $( "header .nav > li" ).hover(function() {
        $('#header').addClass('opacity', 0);
        $( "header .nav > li a" ).css('color', '#FFF');
    });

    // cuando se actualiza desde otro punto de la página referente al top
    if ($(document).scrollTop() > 100) {
            $("header").addClass("opacity"); 
    } 

    //menu responsive
    $( "label.mobile_menu" ).click(function() {
        $('header ul.nav').toggleClass('show fondo1');
        $( "label.mobile_menu span i" ).toggleClass('color1');

    });

     /******* menu responsive ********/

        //menu
        $( ".dropdown .principal-main" ).click(function() {
            $(this).parent().toggleClass('open');

            var ancho = $( window ).width();
            if(ancho <= 800) {

                return false;
            }

        });

        $('.item-1 .principal-main').removeAttr('href');

        //buscador
        $( "label.mobile_menu_search" ).click(function() {
            $('.buscador').toggleClass('show');
            $( "label.mobile_menu_search span i" ).toggleClass('color1');      
        });

        //chat
        $( "label.mobile_menu_chat" ).click(function() {
            $('#search_header').toggleClass('show');
            $(this).find('i').toggleClass('color1');

            var a =  $(this).find('a');
            var link = a.attr('href');
            var onclic = a.attr('onclick');
            var closeChat = 'javascript:Mibew.Utils.closeChatPopup();';
            var cambioLink;

            if(a.attr('href') != closeChat) {
                a.attr('href', closeChat);
                a.removeAttr('onclick');
            } else {
                a.attr('href', link);
                a.attr('onclick', onclick);
            }
            

        });


    //ocultar mostrar mapá
    $( ".show-map" ).click(function() {
    $('#mapa').toggleClass( "completo" );
    return false;
    });

 
      //registrarme
      $('.registrarme, .close-register').click(function() {
          $('.mensaje-alert.registered').toggleClass( "show" );
          $('.loginbox-register').fadeToggle('slow');
          $('.close-register').fadeIn('slow');
          return false;
      });


});
  

      

      $(window).bind('scroll', function(e) {
            var wintop = $(window).scrollTop(), docheight = $(document).height(), winheight = $(window).height(), winWidth = $(document).width(),
                showTrigger = '50',
                hideTrigger = '50';
                //aparece el background del header y achica el logo.
                
                    if (wintop > showTrigger) { $("header").addClass("opacity");  }  else { $("header").removeClass("opacity");  }
      });


      $(window).load(function() { 
          //desaparecer mensaje cookies
          //setTimeout(function(){ $('.cookies_acept').fadeOut() }, 5000);

          $( ".user_cookies_acept" ).click(function() {
              $('.cookies_acept').fadeOut('fast');
              localStorage.cookies = 1;
          });

          $('.close').click(function() {
            $('.mensaje-alert').fadeOut( "slow" );
          });


      });


      $( window ).resize(function() {
        
        var ancho  = $( window ).width();
        if(ancho > 1100) {
            $('#menu .nav').removeClass('show fondo1');
        }

      });


