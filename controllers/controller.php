<?php
header('Content-Type: text/html; charset=UTF-8');
date_default_timezone_set("America/Mexico_City");

error_reporting(E_ALL);
ini_set('display_errors', '1');

// error_reporting(0);

define('PATH_MIEVENTO', dirname(dirname(__FILE__)));

session_start();
require(PATH_MIEVENTO."/helpers/functions.php");
require(PATH_MIEVENTO."/models/model.MiEvento.php");
require(PATH_MIEVENTO."/views/view.php");

if (isset($_SESSION["authenticated"]) && $_SESSION["authenticated"] == true):
	echo get_template_header('header-admin');

	$admin = isset($_GET['admin']) ? $_GET['admin'] : false;
	$admin = isset($_GET['seccionA']) ? $_GET['seccionA'] : $admin;

	$vew_name = get_nombre_vista($admin);
	$class_name = get_class_name($admin);


	if ($class_name == false) redirect_login_permisos($_SESSION['user']->usu_permisos);

	/* autocarga la clase */
	function __autoload($nombre_clase) {

		if (file_exists(PATH_MIEVENTO.'/controllers/controller.'.$nombre_clase.'.php')) :
	    	include 'controller.'.$nombre_clase.'.php';
	    else:
	    	throw new Exception(false);
	   	endif;
	}

	try {

		$getadmin = new $class_name();

		if (isset($_POST['action']) && $_POST['action'] == 'setSave' && method_exists($class_name, "set_save")) :
			$info_vew = $getadmin->set_save($_POST);
		elseif (isset($_POST['action']) && $_POST['action'] == 'setEditEvent' && method_exists($class_name, "set_edit")) :
			$info_vew = $getadmin->set_edit($_POST);
		elseif(method_exists($class_name, "getHtml_Template")):
			$info_vew = $getadmin->getHtml_Template();
		endif;

	} catch (Exception $e) {
	    echo $e->getMessage(), "\n";
	    // if ($e->getMessage() == false) redirect_login_permisos($_SESSION['user']->usu_permisos);
	}

	if (file_exists(PATH_MIEVENTO.'/views/admin/container-'.$vew_name.'.php')):
		require(PATH_MIEVENTO.'/views/admin/container-'.$vew_name.'.php');
	endif;

	if (file_exists(PATH_MIEVENTO.'/views/container-'.$vew_name.'.php')):
		require(PATH_MIEVENTO.'/views/container-'.$vew_name.'.php');
	endif;

	echo get_template_footer('admin');

else:
	check_url_no_home();
	echo get_template_login_header();
	if (file_exists(PATH_MIEVENTO.'/views/form-login.php')):
		require(PATH_MIEVENTO.'/views/form-login.php');
	endif;
	echo get_template_footer();
endif;