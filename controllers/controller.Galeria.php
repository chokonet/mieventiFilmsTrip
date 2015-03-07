<?php
class Galeria {

    private $_model;
    private $_info_user;
    private $_permisos;
    private $_user_id;

    function __construct() {
    	global $info_replase;
    	$this->_model = new mMiEvento();
    	$this->_info_user = $this->_model->get_user_info($info_replase->user_id);

        $this->_permisos = $this->_info_user->usu_permisos;
        $this->_user_id = $this->_info_user->id_usuario;
    }

    public function getHtml_Template(){

    	$array = array();
        if (isset($_GET['accion']) AND $_GET['accion'] == 'evento' AND isset($_GET['slug'])):
            $array['post'] = $this->_model->get_mEvento_slug($_GET['slug']);
            if (isset($array['post']->id_evento)) :
                $array['fotos'] = $this->_model->get_fotos_evento($array['post']->id_evento);
            endif;
        elseif($this->_permisos == 2):
            $array['posts'] = $this->_model->get_mEventos_user($this->_user_id);

        elseif ($this->_permisos == 1):
            $array['posts'] = $this->_model->get_mEventos(false);
        endif;

        return $array;

    }

}