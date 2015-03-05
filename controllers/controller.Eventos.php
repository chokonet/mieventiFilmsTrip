<?php
class Eventos {

	private $_model;

    function __construct() {
    	$this->_model = new mMiEvento();
    }

    public function getHtml_Template(){

        if(isset($_GET['accionA']) AND $_GET['accionA'] == 'editar-evento' AND isset($_GET['d'])):
            $data = $this->get_editar_eventos($_GET['d']);
        elseif(isset($_GET['accionA'])):
            $data = $this->data_nuevoEvento();
        else:
            $data = $this->get_eventos();
        endif;
    	return $data;
    }

     private function get_eventos($event_id = false){
        $array = array();
        $array['posts'] = $this->_model->get_mEventos($event_id);

        return $array;
    }

    private function get_editar_eventos($event_id = false){
        $array = array();
        $array['posts'] = $this->_model->get_mEventos($event_id);
        $array['fotos'] = $this->_model->get_mFotos($event_id);
        $array['categorias'] = $this->_model->get_categorias();
        $array['usuarios'] = $this->_model->get_usuarios(2);

        return $array;
    }

    private function data_nuevoEvento(){
    	$array = array();
    	$array['categorias'] = $this->_model->get_categorias();
    	$array['usuarios'] = $this->_model->get_usuarios(2);

    	return $array;
    }

    public function set_save($data){
    	$nombre    = isset($data['event_name']) ? $data['event_name'] : '';
    	$slug      = isset($data['event_name']) ? get_slug($data['event_name']) : '';
    	$descrip   = isset($data['event_descripcion']) ? $data['event_descripcion'] : '';
    	$categoria = isset($data['event_categoria']) ? $data['event_categoria'] : 1;
    	$usuario   = isset($data['event_usuario']) ? $data['event_usuario'] : 1;

    	$result = $this->_model->set_save_evento($nombre, $slug, $descrip, $categoria,$usuario );

   		if ($result == TRUE) :
            $id_event = $this->_model->get_id_ultimo_evento();
            mkdir(PATH_MIEVENTO."/uploads/evento-".$id_event, 0700);
   			$url = base_url().'admin/eventos/editar-evento/'.$id_event.'/';
			header("Location:".$url);
			exit();
   		endif;
    }

    public function set_edit($data){
        $nombre    = isset($data['event_name']) ? $data['event_name'] : '';
        $slug      = isset($data['event_name']) ? get_slug($data['event_name']) : '';
        $descrip   = isset($data['event_descripcion']) ? $data['event_descripcion'] : '';
        $categoria = isset($data['event_categoria']) ? $data['event_categoria'] : 1;
        $usuario   = isset($data['event_usuario']) ? $data['event_usuario'] : 1;
        $event_id  = isset($data['evento_id_edit']) ? $data['evento_id_edit'] : 1;
        $estatus   = isset($data['event_estatus']) ? $data['event_estatus'] : 1;

        $result = $this->_model->set_update_evento($nombre, $slug, $descrip, $categoria,$usuario, $event_id, $estatus);

        if ($result == TRUE) :
            $url = base_url().'admin/eventos/editar-evento/'.$event_id.'/';
            header("Location:".$url);
            exit();
        endif;
    }
}