/*!
 * 
 * Copyright 2010, 2015 diseño y desarollo web T&T Interactiva
 * http://interactiva.net.co/
 *
 * Date: 2015-03-03 
 */

// selector multiple checkbox para las imagenes de la galería
$(document).ready(function() {
	
	// selector MULTIPLE checkbox para la imagen destacada


	// selector único checkbox para la imagen destacada (POSTS PAGES Y CATEGORIAS)
	/*$(".select-thumbnail .checkbox-select").click(
		function(event) {
			event.preventDefault();
			$(this).parent().addClass("selected fondo3");
			$(this).parent().find(":checkbox").attr("checked","checked");
			$('.thumblist li').not($(this).parent()).removeClass("selected fondo3");
			$('.thumblist input').not($(this).parent().find(":checkbox")).removeAttr("checked");
			var fondo = $(this).attr("data-image");
			$('#fileuploader').css('backgroundImage','url(' + fondo + ')'); // cambia el fondo de la imagen destacada
		

			//Cerrar Automaticamente al momento de seleccionar la imagen destacada.
			$("#menu, .linea").toggleClass('hidden');
		  	$("#pushobj").toggleClass('static');
			$('#featured_image, #gallery_images').fadeToggle('fast');
		}
	);*/

	


	/*// selector único checkbox para el logo de la empresa
	$(".select-logo .checkbox-select").click(
		function(event) {
			event.preventDefault();
			$(this).parent().addClass("selected fondo3");
			$(this).parent().find(":checkbox").attr("checked","checked");
			$('.thumblist li').not($(this).parent()).removeClass("selected fondo3");
			$('.thumblist input').not($(this).parent().find(":checkbox")).removeAttr("checked");
			var fondo = $(this).attr("data-image");
			$('#fileuploader.logo-uploader').css('backgroundImage','url(' + fondo + ')'); // cambia el fondo de la imagen destacada
		}
	);

	// selector único checkbox para el icono de la empresa
	$(".select-favicon .checkbox-select").click(
		function(event) {
			event.preventDefault();
			$(this).parent().addClass("selected fondo3");
			$(this).parent().find(":checkbox").attr("checked","checked");
			$('.thumblist li').not($(this).parent()).removeClass("selected fondo3");
			$('.thumblist input').not($(this).parent().find(":checkbox")).removeAttr("checked");
			var fondo = $(this).attr("data-image");
			$('#fileuploader.favicon-uploader').css('backgroundImage','url(' + fondo + ')'); // cambia el fondo de la imagen destacada
		}
	);		

	
	

	//cerrar divs con el overlay
	$(".overThumbnails").click(function() {
		  $('#see_all_files, #featured_image, .overThumbnails').fadeOut('fast');
		  $("#menu, .linea").toggleClass('hidden');
		  $("#pushobj").toggleClass('static');
	});

	*/

});