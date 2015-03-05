<?php
require_once 'model.Conexion.php';

class mMiEvento {

	private $dbh;

    function __construct() {
    	$this->dbh = Conexion::singleton_conexion();
    }

    public function get_categorias(){
    	try {

            $sql = "SELECT * from me_categorias";

            $query = $this->dbh->prepare($sql);
            $query->execute();

            if($query->rowCount() >= 1):
                 $result  = $query->fetchAll(PDO::FETCH_OBJ);;
                 return $result;
            else:
            	return false;
            endif;

        }catch(PDOException $e){
            print "Error!: " . $e->getMessage();

        }
    }


    public function get_usuarios($tipo = 'all'){
    	try {
    		$ext_q = ($tipo!= 'all') ? 'WHERE usu_permisos = ?' : '' ;

            $sql = "SELECT * from me_usuarios $ext_q";

            $query = $this->dbh->prepare($sql);
            $query->bindParam(1,$tipo);
            $query->execute();

            $dbh = null;
            if($query->rowCount() >= 1):
                 $result  = $query->fetchAll(PDO::FETCH_OBJ);;
                 return $result;
            else:
            	return false;
            endif;

        }catch(PDOException $e){
            print "Error!: " . $e->getMessage();

        }
    }


    public function set_save_evento($nombre, $slug, $descrip, $categoria, $usuario ){
        try {
            $query = $this->dbh->prepare('INSERT INTO me_eventos (eve_nombre, eve_slug, eve_descripcion, id_usuario, id_categoria) VALUES (:nombre,:slug,:descrip,:usuario,:categoria)');

            $query->bindParam(":nombre", $nombre, PDO::PARAM_STR);
            $query->bindParam(":slug", $slug, PDO::PARAM_STR);
            $query->bindParam(":descrip", $descrip, PDO::PARAM_STR);
            $query->bindParam(":usuario", $usuario, PDO::PARAM_INT);
            $query->bindParam(":categoria", $categoria, PDO::PARAM_INT);

            $op = $query->execute();

            return $op;

        }catch(PDOException $e){
            print "Error!: " . $e->getMessage();

        }
    }

    /**
     * ACTUALIZA LA INFORMACION DEL EVENTO
     */
    public function set_update_evento($nombre, $slug, $descrip, $categoria,$usuario, $event_id){
        if (isset($event_id) AND $event_id != '') :

            try {

                $query = $this->dbh->prepare('UPDATE me_eventos SET eve_nombre = :nombre,
                                                eve_slug = :slug,
                                                eve_descripcion = :descripcion,
                                                id_categoria = :categoria,
                                                id_usuario = :usuario
                                                WHERE id_evento = :ideve');

                $query->bindParam(':nombre', $nombre, PDO::PARAM_STR);
                $query->bindParam(':slug', $slug, PDO::PARAM_STR);
                $query->bindParam(':descripcion', $descrip, PDO::PARAM_STR);
                // use PARAM_STR although a number
                $query->bindParam(':categoria', $categoria, PDO::PARAM_INT);
                $query->bindParam(':usuario', $usuario, PDO::PARAM_INT);
                $query->bindParam(':ideve', $event_id, PDO::PARAM_INT);
                $op = $query->execute();

                return $op;

            }catch(PDOException $e){
                print "Error!: " . $e->getMessage();

            }
        endif;
    }

    public function get_id_ultimo_evento(){
        try {

            $sql = "SELECT * FROM me_eventos ORDER BY id_evento DESC LIMIT 1";

            $query = $this->dbh->prepare($sql);
            $query->execute();

            if($query->rowCount() >= 1):
                 $result  = $query->fetchAll(PDO::FETCH_OBJ);

                 return $result[0]->id_evento;
            else:
                return false;
            endif;

        }catch(PDOException $e){
            print "Error!: " . $e->getMessage();

        }
    }


    public function get_mEventos($event_id){
        $query_ex = 'ORDER BY id_evento ASC';
        if ($event_id != false) $query_ex = "WHERE id_evento = ".$event_id;

        try {

            $sql = "SELECT id_evento, eve_nombre, eve_slug, eve_descripcion, eve.id_usuario, usu_nombre, eve.id_categoria, cat_nombre, (SELECT `title` FROM me_uploads WHERE id_evento = eve.id_evento LIMIT 1) AS freatured FROM me_eventos AS eve
                LEFT OUTER JOIN me_categorias AS ca
                ON eve.id_categoria = ca.id_categoria
                LEFT OUTER JOIN me_usuarios AS usu
                ON eve.id_usuario = usu.id_usuario
                 ".$query_ex;

            $query = $this->dbh->prepare($sql);
            $query->execute();

            if($query->rowCount() >= 1):
                 $result  = $query->fetchAll(PDO::FETCH_OBJ);

                 return $result;
            else:
                return false;
            endif;

        }catch(PDOException $e){
            print "Error!: " . $e->getMessage();

        }
    }

    public function get_mFotos($event_id){
        try {

            $sql = "SELECT * FROM me_uploads WHERE id_evento = $event_id";

            $query = $this->dbh->prepare($sql);
            $query->execute();

            if($query->rowCount() >= 1):
                $result = $query->fetchAll(PDO::FETCH_OBJ);

                return $result;
            else:
                return false;
            endif;

        }catch(PDOException $e){
            print "Error!: " . $e->getMessage();

        }
    }

    public function set_saveImageData($event_id, $imagen_name){

        if (isset($event_id) AND $event_id != '') :

            try {
                $query = $this->dbh->prepare('INSERT INTO me_uploads (id_evento, title) VALUES (:id_evento,:title)');

                $query->bindParam(":id_evento", $event_id, PDO::PARAM_INT);
                $query->bindParam(":title", $imagen_name, PDO::PARAM_STR);
                $op = $query->execute();

                return $op;

            }catch(PDOException $e){
                print "Error!: " . $e->getMessage();

            }
        endif;
    }

}