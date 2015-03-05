<?php global $info_replase;
global $info_vew;
$info_replase = get_info_pats();


require_once(PATH_MIEVENTO.'/models/model.Login.php');

// resive $_POST

if (isset($_POST)) :
	if (isset($_POST['action']) AND $_POST['action'] == 'login-user') set_login_user($_POST);
endif;

if (isset($_SESSION["authenticated"]) && $_SESSION["authenticated"] == true):
	Login::time_session_inactive();

	// check_user_permisos();
	check_user_permisos_admin($_GET);
endif;



/**
 * URL SITIO
 */
function base_url(){
	$carpeta =  basename(dirname(dirname(__FILE__)));
	if ($_SERVER["HTTP_HOST"] == 'localhost') {
		return $baseurl = "http://" . $_SERVER["HTTP_HOST"] ."/".$carpeta."/";
	}elseif($_SERVER["HTTP_HOST"] == 'filmstrip.com' || $_SERVER["HTTP_HOST"] == 'www.filmstrip.com') {
		return $baseurl = "http://" . $_SERVER["HTTP_HOST"] ."/".$carpeta."/";
	}else{
		return $baseurl = "http://" . $_SERVER["HTTP_HOST"] ."/";
	}
}


function url_active(){
	$url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	return $url;
}


function set_login_user($datos){

	$nuevoSingleton = Login::singleton_login();

	if(isset($datos['nick']))
	{
	    $nick = $datos['nick'];
	    $password = $datos['password'];
	    //accedemos al método usuarios y los mostramos

	    $password = encript_password($password);

	    $usuario = $nuevoSingleton->login_users($nick,$password);

	    if($usuario['exito'] == TRUE){
	    	redirect_login_permisos($usuario['permisos']);
	    }else{
	    	$url = base_url().'?error=4';
			header("Location:".$url);
			exit();
	    }
	}
}


function redirect_login_permisos($permisos){

	$url = ($permisos == 1) ? base_url().'admin' : base_url().'galeria' ;
	header("Location:".$url);
}


function encript_password($password){
	$salt = '$bgr$/';
	return $password = sha1(md5($salt . $password));
}

/**
 * checa que el usuario sea admin
 */
function check_user_permisos_admin(){
	$is_ad = isset($_GET['admin']) ? $_GET['admin'] : '';
	if ($is_ad != 'galeria' AND $_SESSION['user']->usu_permisos != 1):
		$url = base_url().'galeria';
		header("Location:".$url);
		exit();
	endif;

	return true;
}


function check_url_no_home(){

	$url_actual = url_active();
	$url_error = base_url().'?error=4';

	if ($url_actual != base_url() AND $url_actual != $url_error) :
		$url = base_url();
		header("Location:".$url);
		exit();
	endif;
}


function get_info_pats(){
	$obj = new stdClass;
	$obj->user_nick       = isset($_SESSION['user']->usu_nick) ? $_SESSION['user']->usu_nick : '';
	$obj->url_eventos    = base_url().'eventos/';
	$obj->url_usuarios   = base_url().'usuarios/';
	$obj->url_categorias = base_url().'categorias/';
	return $obj;
}

function get_nombre_vista($admin){
	$eve_dos = isset($_GET['accionA']) ? $_GET['accionA'] : false;
	$vew_name = ($admin == 'admin') ? 'admin': $admin ;
	$vew_name = ($admin == 'categorias') ? 'categorias': $admin ;
	$vew_name = ($admin == 'eventos') ? 'eventos': $admin ;
	if ($eve_dos != false) {
		$vew_name = ($eve_dos == 'nuevo-evento') ? 'nuevo-evento': false ;
		$vew_name = ($eve_dos == 'editar-evento') ? 'editar-evento': $vew_name ;
	}
	return $vew_name;
}


function get_class_name($admin){

	$eve_dos = isset($_GET['accionA']) ? $_GET['accionA'] : false;
	$class_name = ($admin == 'admin') ? 'Admin': $admin ;
	$vew_name = ($admin == 'categorias') ? 'Categorias': $admin ;
	$class_name = ($admin == 'eventos') ? 'Eventos': $class_name;
	if ($eve_dos != false) {
		$class_name = ($eve_dos == 'nuevo-evento') ? 'Eventos': false ;
		$class_name = ($eve_dos == 'editar-evento') ? 'Eventos': $class_name ;
	}
	return $class_name;
}

/**
 * GUARDA LA IMAGEN DEL EVENTO
 */
function save_image_attachment( $imagen_data, $imagen_name, $event_id ){

	$imagen      = imagecreatefromstring( base64_decode($imagen_data) );
	$upload_dir  = PATH_MIEVENTO.'/uploads/evento-'.$event_id;
	$path        = $upload_dir. '/'. "$imagen_name.jpg";
	$upload      = imagejpeg( $imagen, $path, 100 );
	$url_imagen  = base_url()."/uploads/evento-".$event_id."/".$imagen_name.".jpg";

	if ($upload){
		cortar_imagen_jpg($url_imagen, $imagen_name, $event_id);
	 	resize_imagen_jpg( $url_imagen, $imagen_name, $event_id );
	}

	set_SaveDataImage($event_id, $imagen_name);

	if ($upload) return base_url()."/uploads/evento-".$event_id."/".$imagen_name;

	return false;

}


/**
 * GUARDA LA IMAGEN CORTADA
 */
function saveCropImage( $imagen, $image_name, $event_id, $final_path){
	$upload_dir  = PATH_MIEVENTO.'/uploads/evento-'.$event_id;
	$path        = $upload_dir. '/'. $image_name.'-'.$final_path.'.jpg';
	$upload      = imagejpeg( $imagen, $path, 100 );

	if ($upload) {
		$url_imagen  = base_url()."/uploads/evento-".$event_id."/".$image_name."-".$final_path.".jpg";
	}

}




/**
 * CORTAR IMAGEN DESTACADA (CORTA DE 150X150)
 */
function cortar_imagen_jpg($source_path, $imagen_name, $event_id){

	define('DESIRED_IMAGE_WIDTH', 300);
	define('DESIRED_IMAGE_HEIGHT', 169);

	list($source_width, $source_height,$otro, $source_type ) = getimagesize($source_path);

	$source_gdim = imagecreatefromjpeg($source_path);

	$source_aspect_ratio = $source_width / $source_height;
	$desired_aspect_ratio = DESIRED_IMAGE_WIDTH / DESIRED_IMAGE_HEIGHT;

	if ($source_aspect_ratio > $desired_aspect_ratio) {

		$temp_height = DESIRED_IMAGE_HEIGHT;
		$temp_width = ( int ) (DESIRED_IMAGE_HEIGHT * $source_aspect_ratio);

	} else {

		$temp_width = DESIRED_IMAGE_WIDTH;
		$temp_height = ( int ) (DESIRED_IMAGE_WIDTH / $source_aspect_ratio);
	}


	$temp_gdim = imagecreatetruecolor($temp_width, $temp_height);
	imagecopyresampled(
		$temp_gdim,
		$source_gdim,
		0, 0,
		0, 0,
		$temp_width, $temp_height,
		$source_width, $source_height
	);

	$x0 = ($temp_width - DESIRED_IMAGE_WIDTH) / 2;
	$y0 = ($temp_height - DESIRED_IMAGE_HEIGHT) / 2;
	$desired_gdim = imagecreatetruecolor(DESIRED_IMAGE_WIDTH, DESIRED_IMAGE_HEIGHT);
	imagecopy(
		$desired_gdim,
		$temp_gdim,
		0, 0,
		$x0, $y0,
		DESIRED_IMAGE_WIDTH, DESIRED_IMAGE_HEIGHT
	);

	header('Content-type: image/jpeg');
	return saveCropImage($desired_gdim, $imagen_name, $event_id, '300x169');

}


/**
 * REDUSIR IMAGEN DESTACADA (a un 20%)
 */
function resize_imagen_jpg($source_path, $imagen_name, $event_id){
 list($orig_width, $orig_height) = getimagesize($source_path);
 	$max_width = 300;
 	$max_height = 535;
    $width = $orig_width;
    $height = $orig_height;

    # taller
    if ($height > $max_height) {
        $width = ($max_height / $height) * $width;
        $height = $max_height;
    }

    # wider
    if ($width > $max_width) {
        $height = ($max_width / $width) * $height;
        $width = $max_width;
    }

    $image_p = imagecreatetruecolor($width, $height);

    $image = imagecreatefromjpeg($source_path);

    imagecopyresampled($image_p, $image, 0, 0, 0, 0,
                                     $width, $height, $orig_width, $orig_height);

	return saveCropImage($image_p, $imagen_name, $event_id, 'resize');

}



/**
 * ARMA LA URL DE LA FOTO
 */
function url_foto($title, $evento_id, $size = 'large'){
	$title = ($size == 'thumbnail') ? $title.'-300x169' : $title;
	$title = ($size == 'resize') ? $title.'-resize' : $title;
	$src = base_url().'uploads/evento-'.$evento_id.'/'.$title.'.jpg';

	return $src;
}

/**
 * GENERA EL SLUG DE UN TITULO
 */
function get_slug($title) {
	$title = strip_tags($title);
	$title = remove_accents($title);


	$title = preg_replace('|%([a-fA-F0-9][a-fA-F0-9])|', '---$1---', $title);

	$title = str_replace('%', '', $title);

	$title = preg_replace('|---([a-fA-F0-9][a-fA-F0-9])---|', '%$1', $title);

	if (seems_utf8($title)) {
		if (function_exists('mb_strtolower')) {
			$title = mb_strtolower($title, 'UTF-8');
		}

	}

	$title = strtolower($title);
	$title = preg_replace('/&.+?;/', '', $title); // kill entities
	$title = str_replace('.', '-', $title);
	$title = preg_replace('/[^%a-z0-9 _-]/', '', $title);
	$title = preg_replace('/\s+/', '-', $title);
	$title = preg_replace('|-+|', '-', $title);
	$title = trim($title, '-');

	return $title;
}



function seems_utf8($str) {
	$length = strlen($str);
	for ($i=0; $i < $length; $i++) {
		$c = ord($str[$i]);
		if ($c < 0x80) $n = 0; # 0bbbbbbb
		elseif (($c & 0xE0) == 0xC0) $n=1; # 110bbbbb
		elseif (($c & 0xF0) == 0xE0) $n=2; # 1110bbbb
		elseif (($c & 0xF8) == 0xF0) $n=3; # 11110bbb
		elseif (($c & 0xFC) == 0xF8) $n=4; # 111110bb
		elseif (($c & 0xFE) == 0xFC) $n=5; # 1111110b
		else return false; # Does not match any model
		for ($j=0; $j<$n; $j++) { # n bytes matching 10bbbbbb follow ?
			if ((++$i == $length) || ((ord($str[$i]) & 0xC0) != 0x80))
				return false;
		}
	}
	return true;
}

function remove_accents($string) {
	if ( !preg_match('/[\x80-\xff]/', $string) )
		return $string;

	if (seems_utf8($string)) {
		$chars = array(
		// Decompositions for Latin-1 Supplement
		chr(195).chr(128) => 'A', chr(195).chr(129) => 'A',
		chr(195).chr(130) => 'A', chr(195).chr(131) => 'A',
		chr(195).chr(132) => 'A', chr(195).chr(133) => 'A',
		chr(195).chr(134) => 'AE',chr(195).chr(135) => 'C',
		chr(195).chr(136) => 'E', chr(195).chr(137) => 'E',
		chr(195).chr(138) => 'E', chr(195).chr(139) => 'E',
		chr(195).chr(140) => 'I', chr(195).chr(141) => 'I',
		chr(195).chr(142) => 'I', chr(195).chr(143) => 'I',
		chr(195).chr(144) => 'D', chr(195).chr(145) => 'N',
		chr(195).chr(146) => 'O', chr(195).chr(147) => 'O',
		chr(195).chr(148) => 'O', chr(195).chr(149) => 'O',
		chr(195).chr(150) => 'O', chr(195).chr(153) => 'U',
		chr(195).chr(154) => 'U', chr(195).chr(155) => 'U',
		chr(195).chr(156) => 'U', chr(195).chr(157) => 'Y',
		chr(195).chr(158) => 'TH',chr(195).chr(159) => 's',
		chr(195).chr(160) => 'a', chr(195).chr(161) => 'a',
		chr(195).chr(162) => 'a', chr(195).chr(163) => 'a',
		chr(195).chr(164) => 'a', chr(195).chr(165) => 'a',
		chr(195).chr(166) => 'ae',chr(195).chr(167) => 'c',
		chr(195).chr(168) => 'e', chr(195).chr(169) => 'e',
		chr(195).chr(170) => 'e', chr(195).chr(171) => 'e',
		chr(195).chr(172) => 'i', chr(195).chr(173) => 'i',
		chr(195).chr(174) => 'i', chr(195).chr(175) => 'i',
		chr(195).chr(176) => 'd', chr(195).chr(177) => 'n',
		chr(195).chr(178) => 'o', chr(195).chr(179) => 'o',
		chr(195).chr(180) => 'o', chr(195).chr(181) => 'o',
		chr(195).chr(182) => 'o', chr(195).chr(182) => 'o',
		chr(195).chr(185) => 'u', chr(195).chr(186) => 'u',
		chr(195).chr(187) => 'u', chr(195).chr(188) => 'u',
		chr(195).chr(189) => 'y', chr(195).chr(190) => 'th',
		chr(195).chr(191) => 'y',
		// Decompositions for Latin Extended-A
		chr(196).chr(128) => 'A', chr(196).chr(129) => 'a',
		chr(196).chr(130) => 'A', chr(196).chr(131) => 'a',
		chr(196).chr(132) => 'A', chr(196).chr(133) => 'a',
		chr(196).chr(134) => 'C', chr(196).chr(135) => 'c',
		chr(196).chr(136) => 'C', chr(196).chr(137) => 'c',
		chr(196).chr(138) => 'C', chr(196).chr(139) => 'c',
		chr(196).chr(140) => 'C', chr(196).chr(141) => 'c',
		chr(196).chr(142) => 'D', chr(196).chr(143) => 'd',
		chr(196).chr(144) => 'D', chr(196).chr(145) => 'd',
		chr(196).chr(146) => 'E', chr(196).chr(147) => 'e',
		chr(196).chr(148) => 'E', chr(196).chr(149) => 'e',
		chr(196).chr(150) => 'E', chr(196).chr(151) => 'e',
		chr(196).chr(152) => 'E', chr(196).chr(153) => 'e',
		chr(196).chr(154) => 'E', chr(196).chr(155) => 'e',
		chr(196).chr(156) => 'G', chr(196).chr(157) => 'g',
		chr(196).chr(158) => 'G', chr(196).chr(159) => 'g',
		chr(196).chr(160) => 'G', chr(196).chr(161) => 'g',
		chr(196).chr(162) => 'G', chr(196).chr(163) => 'g',
		chr(196).chr(164) => 'H', chr(196).chr(165) => 'h',
		chr(196).chr(166) => 'H', chr(196).chr(167) => 'h',
		chr(196).chr(168) => 'I', chr(196).chr(169) => 'i',
		chr(196).chr(170) => 'I', chr(196).chr(171) => 'i',
		chr(196).chr(172) => 'I', chr(196).chr(173) => 'i',
		chr(196).chr(174) => 'I', chr(196).chr(175) => 'i',
		chr(196).chr(176) => 'I', chr(196).chr(177) => 'i',
		chr(196).chr(178) => 'IJ',chr(196).chr(179) => 'ij',
		chr(196).chr(180) => 'J', chr(196).chr(181) => 'j',
		chr(196).chr(182) => 'K', chr(196).chr(183) => 'k',
		chr(196).chr(184) => 'k', chr(196).chr(185) => 'L',
		chr(196).chr(186) => 'l', chr(196).chr(187) => 'L',
		chr(196).chr(188) => 'l', chr(196).chr(189) => 'L',
		chr(196).chr(190) => 'l', chr(196).chr(191) => 'L',
		chr(197).chr(128) => 'l', chr(197).chr(129) => 'L',
		chr(197).chr(130) => 'l', chr(197).chr(131) => 'N',
		chr(197).chr(132) => 'n', chr(197).chr(133) => 'N',
		chr(197).chr(134) => 'n', chr(197).chr(135) => 'N',
		chr(197).chr(136) => 'n', chr(197).chr(137) => 'N',
		chr(197).chr(138) => 'n', chr(197).chr(139) => 'N',
		chr(197).chr(140) => 'O', chr(197).chr(141) => 'o',
		chr(197).chr(142) => 'O', chr(197).chr(143) => 'o',
		chr(197).chr(144) => 'O', chr(197).chr(145) => 'o',
		chr(197).chr(146) => 'OE',chr(197).chr(147) => 'oe',
		chr(197).chr(148) => 'R',chr(197).chr(149) => 'r',
		chr(197).chr(150) => 'R',chr(197).chr(151) => 'r',
		chr(197).chr(152) => 'R',chr(197).chr(153) => 'r',
		chr(197).chr(154) => 'S',chr(197).chr(155) => 's',
		chr(197).chr(156) => 'S',chr(197).chr(157) => 's',
		chr(197).chr(158) => 'S',chr(197).chr(159) => 's',
		chr(197).chr(160) => 'S', chr(197).chr(161) => 's',
		chr(197).chr(162) => 'T', chr(197).chr(163) => 't',
		chr(197).chr(164) => 'T', chr(197).chr(165) => 't',
		chr(197).chr(166) => 'T', chr(197).chr(167) => 't',
		chr(197).chr(168) => 'U', chr(197).chr(169) => 'u',
		chr(197).chr(170) => 'U', chr(197).chr(171) => 'u',
		chr(197).chr(172) => 'U', chr(197).chr(173) => 'u',
		chr(197).chr(174) => 'U', chr(197).chr(175) => 'u',
		chr(197).chr(176) => 'U', chr(197).chr(177) => 'u',
		chr(197).chr(178) => 'U', chr(197).chr(179) => 'u',
		chr(197).chr(180) => 'W', chr(197).chr(181) => 'w',
		chr(197).chr(182) => 'Y', chr(197).chr(183) => 'y',
		chr(197).chr(184) => 'Y', chr(197).chr(185) => 'Z',
		chr(197).chr(186) => 'z', chr(197).chr(187) => 'Z',
		chr(197).chr(188) => 'z', chr(197).chr(189) => 'Z',
		chr(197).chr(190) => 'z', chr(197).chr(191) => 's',
		// Decompositions for Latin Extended-B
		chr(200).chr(152) => 'S', chr(200).chr(153) => 's',
		chr(200).chr(154) => 'T', chr(200).chr(155) => 't',
		// Euro Sign
		chr(226).chr(130).chr(172) => 'E',
		// GBP (Pound) Sign
		chr(194).chr(163) => '');

		$string = strtr($string, $chars);
	} else {
		// Assume ISO-8859-1 if not UTF-8
		$chars['in'] = chr(128).chr(131).chr(138).chr(142).chr(154).chr(158)
			.chr(159).chr(162).chr(165).chr(181).chr(192).chr(193).chr(194)
			.chr(195).chr(196).chr(197).chr(199).chr(200).chr(201).chr(202)
			.chr(203).chr(204).chr(205).chr(206).chr(207).chr(209).chr(210)
			.chr(211).chr(212).chr(213).chr(214).chr(216).chr(217).chr(218)
			.chr(219).chr(220).chr(221).chr(224).chr(225).chr(226).chr(227)
			.chr(228).chr(229).chr(231).chr(232).chr(233).chr(234).chr(235)
			.chr(236).chr(237).chr(238).chr(239).chr(241).chr(242).chr(243)
			.chr(244).chr(245).chr(246).chr(248).chr(249).chr(250).chr(251)
			.chr(252).chr(253).chr(255);

		$chars['out'] = "EfSZszYcYuAAAAAACEEEEIIIINOOOOOOUUUUYaaaaaaceeeeiiiinoooooouuuuyy";

		$string = strtr($string, $chars['in'], $chars['out']);
		$double_chars['in'] = array(chr(140), chr(156), chr(198), chr(208), chr(222), chr(223), chr(230), chr(240), chr(254));
		$double_chars['out'] = array('OE', 'oe', 'AE', 'DH', 'TH', 'ss', 'ae', 'dh', 'th');
		$string = str_replace($double_chars['in'], $double_chars['out'], $string);
	}

	return $string;
}