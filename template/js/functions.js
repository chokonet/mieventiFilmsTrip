(function($){

	"use strict";

	$(function(){


		if($('#cont-imagenes').length >0){
			imagesLoaded( document.querySelector('#cont-imagenes'), function( instance ) {
				var container = document.querySelector('#cont-imagenes');

			  	window.msnry = new Masonry( container, {
			  		itemSelector: '.image',
			    	columnWidth: 0,
			    	gutter: 2
			  	});
			});
		}



		if ( $(".galeria_e").length ){
			$(".galeria_e").colorbox({
				rel:'galeria_e'
			});
		}
	});


})(jQuery);