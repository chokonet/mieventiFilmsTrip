(function($){

	"use strict";

	$(function(){

		$(document).on('click','.caja-select', function (event) {
			event.preventDefault();

			if ($(this).hasClass('active')) {
				$('.caja-select').removeClass('active');
				$(this).next('.list-options').fadeOut('350');
			}else{
				$('.caja-select').removeClass('active');
				$(this).addClass('active');
				$('.list-options').fadeOut();
				$(this).next('.list-options').fadeIn('350');

			};
		});

		$('.c-option').on('click', function (event) {
			event.preventDefault();
			var id_element = $(this).data('id_sel');
			var tipo = $(this).data('tipo');
			var texto = $(this).text();
			$('.eve_'+tipo).attr('value', id_element);
			$('.caja-select_'+tipo).text(texto);
			$('.list-options').fadeOut();
		});

		$('#cevent').on('submit', function (event) {
			event.preventDefault();
			var nombre = $('#event_name').val();
			if (nombre  == '') {
				$('#event_name').css({'background':'#FCE4E4'});
				$('.active_error_form').css({'display':'block'});
			}else{
				document.cevent.submit();
			};
		});


		/*

		8888888888       888
		888              888
		888              888
		8888888  .d88b.  888888  .d88b.  .d8888b
		888     d88""88b 888    d88""88b 88K
		888     888  888 888    888  888 "Y8888b.
		888     Y88..88P Y88b.  Y88..88P      X88
		888      "Y88P"   "Y888  "Y88P"   88888P'

		 */

		if($('#manso-event').length >0){
			imagesLoaded( document.querySelector('#manso-event'), function( instance ) {
				var container = document.querySelector('#manso-event');

			  	window.msnry = new Masonry( container, {
			  		itemSelector: '.item',
			    	columnWidth: 0,
			    	gutter: 2
			  	});
			});
		}

		$('.bt-add-fotos').on('click', function () {
			$('#subir-fotos-evento').trigger('click');
		});

		function set_images_as_attachement(image_data, image_name) {
			var event_id = $('#evento_id_edit').val(),
				base_url = $('#base_url').val(),
				data    = image_data.split(','),
				image   = data[1];

			var man = window.msnry;
			var $container 	= $('#'+man.element.id);

			$.ajax({
			 	type: "POST",
			 	url: base_url+"helpers/ajax.php",
			 	data: {
			 		action     :'save_image_event',
			 		name_img   : 'img-'+palabras(),
			 		event_id   : event_id,
			 		image_data : image
			 	}
			}).done(function(result) {
				var elems = [];

				var fragment = document.createDocumentFragment();


				var img = '<img class="item" src="'+result+'-resize.jpg">';

				$container.append(img);
				imagesLoaded( $container, function( instance ) {
					man.reloadItems();
					man.layout();

				});
			});
		}

		function addPhotosEvento(files){
			for (var i = 0; i < files.length; i++){
				var name_img = files[i].name;
				var reader = new FileReader();
				reader.onload = function(e){
					set_images_as_attachement(e.target.result, e.total);
				}
				reader.readAsDataURL(files[i]);
			}
		}

		$('#subir-fotos-evento').on('change', function () {

			var files = $(this)[0].files;
			addPhotosEvento(files);

		});

		function palabras(){
			var respuesta = new Array ("af", "ab", "ac", "ad", "ae", "af", "ag", "ah", "ai", "aj", "ak", "al", "am", "an");
			var respuesta2 = new Array ("afs", "abd", "ac1", "add", "ae4", "af5", "ag6", "ah8", "ai0", "ajs", "akd", "als", "am", "an");
			var numeros = new Array ("1", "2", "3", "4", "5", "6", "7", "8", "9", "11", "22", "24", "65", "33")
	        var aleatorio=Math.floor((Math.random()*14));
	        var aleatorio2=Math.floor((Math.random()*14));
	        var aleatorio_n=Math.floor((Math.random()*14));
		        return respuesta[aleatorio]+respuesta2[aleatorio2]+respuesta[aleatorio2]+'-'+numeros[aleatorio_n];

		}



	});


})(jQuery);