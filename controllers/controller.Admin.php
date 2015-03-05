<?php
class Admin {

    private $_model;

    function __construct() {
    	$this->_model = new mMiEvento();
    }

    public function getHtml_Template(){
    	$array = array();
        $array['posts'] = $this->_model->get_mEventos(false, 'LIMIT 3');

        return $array;
    }


}