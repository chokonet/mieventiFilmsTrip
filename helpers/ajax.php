<?php define('PATH_MIEVENTO', dirname(dirname(__FILE__)));
session_start();

include(PATH_MIEVENTO.'/helpers/functions.php');
include(PATH_MIEVENTO.'/models/model.MiEvento.php');

if(isset( $_POST['action']) AND $_POST['action'] == 'save_image_event') get_save_image_event($_POST);
if(isset( $_POST['action']) AND $_POST['action'] == 'delete_img_event') elimina_imagen_evento($_POST);
if(isset( $_POST['action']) AND $_POST['action'] == 'data-compare-user') get_data_user();
if(isset( $_POST['action']) AND $_POST['action'] == 'data-compare-event') get_data_evento();




function get_save_image_event($datos){
	$nombre_img  = isset($datos['name_img']) ? $datos['name_img'] : '';
	$event_id    = isset($datos['event_id']) ? $datos['event_id'] : '';
	$imagen_data = isset($datos['image_data']) ? $datos['image_data'] : '';

	$result = save_image_attachment( $imagen_data, $nombre_img, $event_id );

	echo json_encode($result);
	exit();
}

/**
 * MANDA GUARDAR LA IMAGEN A LA BASE
 */
function set_SaveDataImage($event_id, $imagen_name){
	$model = new mMiEvento();
	$result = $model->set_saveImageData($event_id, $imagen_name);
	if ($result == true) return $model->ultimaImagenUploads();

	return false;
}

/**
 * ELIMINA IMAGEN
 */
function elimina_imagen_evento($datos){
	$catch     = isset($datos['cath']) ? $datos['cath'] : false;
	$id_imagen = isset($datos['id_img']) ? $datos['id_img'] : false;
	$id_evento = isset($datos['id_evento']) ? $datos['id_evento'] : false;
	$name_img  = isset($datos['name_img']) ? $datos['name_img'] : false;

	if (isset($_SESSION["authenticated"]) && $_SESSION["authenticated"] == true):
		if ($catch != false AND $id_imagen != false AND $id_evento != false AND $name_img != false) :
			$cifrado = 'mi-foto-alex'.$id_imagen.'-delete'.$id_evento;
			$crip_s = md5($cifrado);

			if ($catch == $crip_s) :
				$model = new mMiEvento();
				$resp = $model->set_deleteImageUploads($id_imagen, $id_evento);
				if ($resp == true) delete_image_folder($id_imagen, $id_evento, $name_img);

				echo $resp;
				exit();
			endif;
		endif;
	endif;

}


/**
 * ELIMINA LA IMAGEN DE LA CARPETA
 */
function delete_image_folder($id_imagen, $id_evento, $name_img){
	$file_img = PATH_MIEVENTO.'/uploads/evento-'.$id_evento.'/'.$name_img.'.jpg';
	$file_img2 = PATH_MIEVENTO.'/uploads/evento-'.$id_evento.'/'.$name_img.'-resize.jpg';
	$file_img3 = PATH_MIEVENTO.'/uploads/evento-'.$id_evento.'/'.$name_img.'-300x169.jpg';

	@unlink($file_img);
	@unlink($file_img2);
	@unlink($file_img3);

	return true;
}

/**
 * DATA COMPARE USER
 */
function get_data_user(){
	$model = new mMiEvento();
	$resp = $model->get_users_element('usu_nick');

	$result = array();
	foreach ($resp as $key => $value) {
		$result[] = $value->usu_nick;
	}

	echo json_encode($result);
	exit();
}

/**
 * DATA COMPARE EVENTO
 */
function get_data_evento(){
	$model = new mMiEvento();
	$resp = $model->get_eventos_element('eve_slug');
	file_put_contents(
		'/Users/maquilador4/Desktop/php.txt',
		var_export( $resp, true )
	);

	$result = array();
	foreach ($resp as $key => $value) {
		$result[] = $value->eve_slug;
	}

	echo json_encode($result);
	exit();
}