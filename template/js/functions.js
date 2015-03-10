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

		$(document).on('click','#cboxDownload', function (event) {
			event.preventDefault();
			var url_img = $(this).attr('data-id_img');
			window.location.href=url_img;
			// ventanaSecundaria(url_img);
		});

		function ventanaSecundaria(URL){
		   window.open(URL,"ventana1","width=120,height=300,scrollbars=NO")
		}
	});


})(jQuery);