<?php
class Usuarios {

    private $_model;

    function __construct() {
    	$this->_model = new mMiEvento();
    }

    public function getHtml_Template(){
      $array=array();
      $array['usuarios'] = $this->_model->get_usuarios('all', true);

    	return $array;
    }

    public function set_save($data){

    	$usu_name = isset($data['usu_name']) ? $data['usu_name'] : '';
    	$usu_nick = isset($data['usu_nick']) ? $data['usu_nick'] : '';
      $usu_email = isset($data['usu_email']) ? $data['usu_email'] : '';
      $usu_password = isset($data['usu_password']) ? encript_password($data['usu_password']) : '';
      $tipo_us = isset($data['tipo_us']) ? $data['tipo_us'] : '';

    	if ($usu_name != '' || $usu_nick != '' || $usu_password != '' ):
    		$result = $this->_model->set_save_user($usu_name, $usu_nick, $usu_email, $usu_password, $tipo_us);
    	endif;

    	$url = base_url().'admin/usuarios/';
    	header("Location:".$url);
    	exit();

    }

  //   public function get_delete(){
  //   	if (isset($_GET['d']) AND $_GET['d'] != '' AND $_GET['d'] != 1) :
  //   		$this->_model->get_delete_categoria($_GET['d']);
  //   	endif;

		// $url = base_url().'admin/categorias/';
		// header("Location:".$url);
		// exit();

  //   }

}