<?php
class Usuarios {

    private $_model;

    function __construct() {
    	$this->_model = new mMiEvento();
    }

    public function getHtml_Template(){

    	return 'as';
    }

  //   public function set_save($data){

  //   	$cat_name = isset($data['cat_name']) ? $data['cat_name'] : '';
  //   	$cat_slug = isset($data['cat_name']) ? get_slug($data['cat_name']) : '';

  //   	if ($cat_name != ''):
  //   		$result = $this->_model->set_save_categoria($cat_name, $cat_slug);
  //   	endif;

		// $url = base_url().'admin/categorias/';
		// header("Location:".$url);
		// exit();

  //   }

  //   public function get_delete(){
  //   	if (isset($_GET['d']) AND $_GET['d'] != '' AND $_GET['d'] != 1) :
  //   		$this->_model->get_delete_categoria($_GET['d']);
  //   	endif;

		// $url = base_url().'admin/categorias/';
		// header("Location:".$url);
		// exit();

  //   }

}