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

        if (isset($_GET['accion']) AND $_GET['accion'] == 'descargar' AND isset($_GET['slug'])):

            $this->get_download_image($_GET['slug']);

        elseif (isset($_GET['accion']) AND $_GET['accion'] == 'evento' AND isset($_GET['slug'])):
            if($this->_permisos == 2):
                $array['post'] = $this->_model->get_mEvento_slug($_GET['slug'], $this->_user_id);
            elseif ($this->_permisos == 1):

                $array['post'] = $this->_model->get_mEvento_slug($_GET['slug']);
            endif;

            if (isset($array['post']->id_evento)) :
                $array['fotos'] = $this->_model->get_fotos_evento($array['post']->id_evento);
            elseif(empty($array['post'])):
                $url = base_url().'admin/galeria/';
                header("Location:".$url);
                exit();
            endif;
        elseif($this->_permisos == 2):
            $array['posts'] = $this->_model->get_mEventos_user($this->_user_id);

        elseif ($this->_permisos == 1):
            $array['posts'] = $this->_model->get_mEventos(false);
        endif;

        return $array;

    }


    public function get_download_image($id_img){
        global $info_replase;
        $piezas = explode("-", $id_img);
        $id_img = $piezas[0];
        $id_usu = $piezas[1];

        $userPermisos = isset($_SESSION['user']) ? $_SESSION['user']->usu_permisos : 2;

        if ( (isset($info_replase->user_id) AND $info_replase->user_id == $id_usu) ||  $userPermisos == 1):
            $foto = $this->_model->get_foto($id_img, $id_usu);

            if(!empty($foto))
            {

                $url = url_foto($foto->title, $foto->id_evento, 'large');
 // don't accept other directories
                set_time_limit(0);
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                $r = curl_exec($ch);
                curl_close($ch);
                header('Expires: 0'); // no cache
                header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
                header('Last-Modified: ' . gmdate('D, d M Y H:i:s', time()) . ' GMT');
                header('Cache-Control: private', false);
                header('Content-Type: application/force-download');
                header('Content-Disposition: attachment; filename="filmstrip-'.$foto->id_evento.'-'.$id_img.'.jpg"');
                header('Content-Transfer-Encoding: binary');
                header('Content-Length: ' . strlen($r)); // provide file size
                header('Connection: close');
                echo $r;
            }
            header("HTTP/1.0 404 Not Found");

        endif;


    }
}