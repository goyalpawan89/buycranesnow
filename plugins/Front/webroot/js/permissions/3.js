// permisos persona natural

//ocultar los divs que no se necesitan
$('.element-item').find( '#favorite-item' ).hide();
$('a[href="#sell_crane"], .download_list, .video, .video_thumbnail, .content-post_ofert').hide();

$('#fileuploader').addClass('sinbefore');

//agrega el enlace be_bussiness
var linkBeBussines = '#be_business';

$('.favorite, .alert_email').removeAttr('onclick').attr('href', linkBeBussines).addClass('fancybox').removeAttr('title');
$('.quote').attr('href', linkBeBussines).addClass('fancybox');


$(document).ready(function() {

 
  
});


$(window).load(function() {

});

