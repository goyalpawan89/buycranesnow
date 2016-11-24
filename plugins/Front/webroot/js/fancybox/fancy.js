		$(document).ready(function() {

			//fancybox iframe
			$(".fancy_iframe").fancybox({
				maxWidth	: 700,
				maxHeight	: 400,
				fitToView	: false,
				width		: '85%',
				height		: '85%',
				autoSize	: false,
				closeClick	: false,
				openEffect	: 'none',
				closeEffect	: 'none'
			});


			$(".fancy_company").fancybox({
				width    	: 700,  
				height      : 'auto',
				autoSize    : false,
				closeClick  : false, 
				fitToView   : false, 
				openEffect  : 'none', 
				closeEffect : 'none', 
			});


			$(".offer_iframe").fancybox({
				width    	: 355,  
				height      : 'auto',
				autoSize    : false,
				closeClick  : false, 
				fitToView   : false, 
				openEffect  : 'none', 
				closeEffect : 'none', 
				type : 'iframe'
			});

			//fancybox normal
			$(".fancybox").fancybox({
				openEffect	: 'none',
				closeEffect	: 'none'
			});


			//videos
			$('.fancybox-media').fancybox({
				openEffect  : 'none',
				closeEffect : 'none',
				helpers : {
					media : {}
				}
			});


});


