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

		// $('.imagen-op-gal').on('click', function (event) {
		// 	event.preventDefault();
		// 	var indent = $(this).data('indent');
		// 	var url_img = $(this).data('image');

		// 	if ($('#lightbox').length > 0) {

		// 		$('#content').html('<img src="' + url_img + '" />');

		// 		$('#lightbox').show();
		// 	}


		// });

		if ( $(".galeria_e").length ){
			$(".galeria_e").colorbox({
				rel:'galeria_e'
			});
		}
	});


})(jQuery);