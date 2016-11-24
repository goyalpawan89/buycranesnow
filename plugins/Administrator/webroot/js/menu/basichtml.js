$(document).ready(function(){
	// HTML markup implementation, overlap mode


	$('#menu').multilevelpushmenu({

		containersToPush: [$( '#pushobj' )],
		/*
	    onItemClick: function() {
	        $item = arguments[2]
	        var URL = $item.find( 'a' ).attr("href");
	        window.load(URL,'_blank');
	    }*/
});


});