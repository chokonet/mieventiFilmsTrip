<?php define('PATH_MIEVENTO', dirname(dirname(__FILE__)));

include(PATH_MIEVENTO.'/helpers/functions.php');
include(PATH_MIEVENTO.'/models/model.MiEvento.php');

if(isset( $_POST['action']) AND $_POST['action'] == 'save_image_event') get_save_image_event($_POST);

function get_save_image_event($datos){
	$nombre_img  = isset($datos['name_img']) ? $datos['name_img'] : '';
	$event_id    = isset($datos['event_id']) ? $datos['event_id'] : '';
	$imagen_data = isset($datos['image_data']) ? $datos['image_data'] : '';

	$url_imagen = save_image_attachment( $imagen_data, $nombre_img, $event_id );

	echo $url_imagen;
	exit();
}

/**
 * MANDA GUARDAR LA IMAGEN A LA BASE
 */
function set_SaveDataImage($event_id, $imagen_name){
	$model = new mMiEvento();
	$model->set_saveImageData($event_id, $imagen_name);
}