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

		$('#cuser').on('submit', function (event) {
			event.preventDefault();
			var nombre = $('#usu_name').val();
			var nick = $('#usu_nick').val();
			var name = $('#usu_email').val();
			var password = $('#usu_password').val();

			if (nombre  == '' || nick  == '' || name  == '' || password  == '') {
				if (nombre  == ''){
					$('#usu_name').css({'background':'#FCE4E4'});
				}else if(nick  == ''){
					$('#usu_nick').css({'background':'#FCE4E4'});
				}else if(name  == ''){
					$('#usu_email').css({'background':'#FCE4E4'});
				}else if(password  == ''){
					$('#usu_password').css({'background':'#FCE4E4'});
				}

				$('.active_error_form').css({'display':'block'});
			}else{
				document.cevent.submit();
			};
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

			$('.loader-carga-img').fadeIn();

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
				var obj = jQuery.parseJSON(result);

				$('.loader-carga-img').fadeOut();
				var elems = [];

				var fragment = document.createDocumentFragment();

				var img = '<div class="item img-'+obj.id_img+'"><span class="boton eliminar-img" data-catch="'+obj.cath+'" data-id_img="'+obj.id_img+'" data-name="'+obj.name_i+'">Eliminar</span><img src="'+obj.url+'-resize.jpg"></div>';

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


		$(document).on('click', '.eliminar-img', function (event) {
			event.preventDefault();
			var cath = $(this).data('catch');
			var id_img = $(this).data('id_img');
			var name = $(this).data('name');
			var id_evento = $('#evento_id_edit').val();
			var base_url = $('#base_url').val();

			var r = confirm("Esta seguro de eliminar la imagen");
			if (r == true) {
			    delete_image_event(cath, id_img, id_evento, base_url, name);
			} else {

			}

		});

		function delete_image_event(cath, id_img, id_evento, base_url, name){
			$('.loader-carga-img').fadeIn();
			$.ajax({
			 	type: "POST",
			 	url: base_url+"helpers/ajax.php",
			 	data: {
			 		action    :'delete_img_event',
			 		cath      : cath,
			 		id_img    : id_img,
			 		id_evento : id_evento,
			 		name_img  : name

			 	}
			}).done(function(result) {
				$('.loader-carga-img').fadeOut();
				if (result) {
					$( ".img-"+id_img ).remove();
				};


				var elems = [];

				var fragment = document.createDocumentFragment();


				var img = '<div class="item"><img src="'+result+'-resize.jpg"></div>';
				var man = window.msnry;
				var $container 	= $('#'+man.element.id);

				imagesLoaded( $container, function( instance ) {
					man.reloadItems();
					man.layout();

				});
			});
		}

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