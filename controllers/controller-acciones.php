<?php
if ($_POST['action'] == 'setSave' || $_POST['action'] == 'setEditEvent' ) :

	$admin = isset($_GET['admin']) ? $_GET['admin'] : false;
	$admin = isset($_GET['seccionA']) ? $_GET['seccionA'] : $admin;

	$class_name = get_class_name($admin);


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

			$getadmin->set_save($_POST);
		elseif (isset($_POST['action']) && $_POST['action'] == 'setEditEvent' && method_exists($class_name, "set_edit")) :
			$getadmin->set_edit($_POST);
		endif;

	} catch (Exception $e) {
	    echo $e->getMessage(), "\n";
	    // if ($e->getMessage() == false) redirect_login_permisos($_SESSION['user']->usu_permisos);
	}
endif;