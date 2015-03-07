<?php
require_once 'model.Conexion.php';

class mMiEvento {

	private $dbh;

    function __construct() {
    	$this->dbh = Conexion::singleton_conexion();
    }

    public function get_categorias($cat_count = ''){
    	try {


            $sql = "SELECT * from me_categorias";
            $sql2 = "SELECT id_categoria AS cat_id, cat_nombre, (SELECT COUNT(*) FROM me_eventos WHERE id_categoria = cat_id ) AS count FROM me_categorias";
            $query_p = ($cat_count == true) ? $sql2 : $sql;
            $query = $this->dbh->prepare($query_p);
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


    public function get_usuarios($tipo = 'all', $usu_count = ''){
    	try {
    		$ext_q = ($tipo!= 'all') ? 'WHERE usu_permisos = ?' : '' ;

            $sql = "SELECT * from me_usuarios $ext_q";
            $sql2 = "SELECT id_usuario AS usu_id, usu_nombre, usu_nick, usu_email, (SELECT COUNT(*) FROM me_eventos WHERE id_usuario = usu_id ) AS count, IF(usu_permisos = 1, 'administrador', 'cliente') AS tipo FROM me_usuarios";

            $query_p = ($usu_count == true) ? $sql2 : $sql;
            $query = $this->dbh->prepare($query_p);
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
    public function set_update_evento($nombre, $slug, $descrip, $categoria,$usuario, $event_id, $estatus){
        if (isset($event_id) AND $event_id != '') :

            try {

                $query = $this->dbh->prepare('UPDATE me_eventos SET eve_nombre = :nombre,
                                                eve_slug = :slug,
                                                eve_descripcion = :descripcion,
                                                id_categoria = :categoria,
                                                id_usuario = :usuario,
                                                estatus = :estatus
                                                WHERE id_evento = :ideve');

                $query->bindParam(':nombre', $nombre, PDO::PARAM_STR);
                $query->bindParam(':slug', $slug, PDO::PARAM_STR);
                $query->bindParam(':descripcion', $descrip, PDO::PARAM_STR);
                // use PARAM_STR although a number
                $query->bindParam(':categoria', $categoria, PDO::PARAM_INT);
                $query->bindParam(':usuario', $usuario, PDO::PARAM_INT);
                $query->bindParam(':estatus', $estatus, PDO::PARAM_INT);
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


    public function get_mEventos($event_id, $limit = ''){
        $query_ex = 'ORDER BY id_evento ASC';
        if ($event_id != false) $query_ex = "WHERE id_evento = ".$event_id;

        try {

            $sql = "SELECT id_evento, eve_nombre, eve_slug, eve_descripcion, estatus, eve.id_usuario, usu_nombre, eve.id_categoria, cat_nombre, (SELECT `title` FROM me_uploads WHERE id_evento = eve.id_evento LIMIT 1) AS freatured FROM me_eventos AS eve
                LEFT OUTER JOIN me_categorias AS ca
                ON eve.id_categoria = ca.id_categoria
                LEFT OUTER JOIN me_usuarios AS usu
                ON eve.id_usuario = usu.id_usuario
                 ".$query_ex.' '.$limit;

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


    ///// CATEGORIAS ////////////////////////////////


    public function set_save_categoria($cat_name, $cat_slug = ''){
        if (isset($cat_name) AND $cat_name != '') :
             try {
                $query = $this->dbh->prepare('INSERT INTO me_categorias (cat_nombre, cat_slug) VALUES (:cat_nombre,:cat_slug)');

                $query->bindParam(":cat_nombre", $cat_name, PDO::PARAM_STR);
                $query->bindParam(":cat_slug", $cat_slug, PDO::PARAM_STR);
                $op = $query->execute();

                return $op;

            }catch(PDOException $e){
                print "Error!: " . $e->getMessage();

            }
        endif;
    }

    public function get_delete_categoria($cat_id){
         try {
            $sql = "DELETE FROM me_categorias WHERE id_categoria = :id_cat";
            $stmt = $this->dbh->prepare($sql);
            $stmt->bindParam(':id_cat', $cat_id, PDO::PARAM_INT);
            $po = $stmt->execute();

            return $po;

            }catch(PDOException $e){
                print "Error!: " . $e->getMessage();

            }
    }

    public function get_user_info($user_id){
         try {

            $sql = "SELECT id_usuario, usu_nombre, usu_nick, usu_email, usu_permisos FROM me_usuarios WHERE id_usuario = $user_id";

            $query = $this->dbh->prepare($sql);
            $query->execute();

            $dbh = null;
            if($query->rowCount() >= 1):
                $result = $query->fetchAll(PDO::FETCH_OBJ);

                return $result[0];
            else:
                return false;
            endif;

        }catch(PDOException $e){
            print "Error!: " . $e->getMessage();

        }
    }


    //// CLIENTE ///////


    public function get_mEventos_user($user_id){
        try {

            $sql = "SELECT id_evento, eve_nombre, eve_slug, eve_descripcion, estatus, eve.id_usuario, usu_nombre, eve.id_categoria, cat_nombre, (SELECT `title` FROM me_uploads WHERE id_evento = eve.id_evento LIMIT 1) AS freatured FROM me_eventos AS eve
                LEFT OUTER JOIN me_categorias AS ca
                ON eve.id_categoria = ca.id_categoria
                LEFT OUTER JOIN me_usuarios AS usu
                ON eve.id_usuario = usu.id_usuario
                WHERE usu.id_usuario = $user_id AND estatus = 1";

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


    public function get_mEvento_slug($slug){
        try {

            $sql = "SELECT id_evento, eve_nombre, eve_slug, eve_descripcion, estatus, eve.id_usuario, usu_nombre, eve.id_categoria, cat_nombre, (SELECT `title` FROM me_uploads WHERE id_evento = eve.id_evento LIMIT 1) AS freatured FROM me_eventos AS eve
                LEFT OUTER JOIN me_categorias AS ca
                ON eve.id_categoria = ca.id_categoria
                LEFT OUTER JOIN me_usuarios AS usu
                ON eve.id_usuario = usu.id_usuario
                WHERE eve_slug = '$slug' AND estatus = 1 LIMIT 1";

            $query = $this->dbh->prepare($sql);
            $query->execute();

            if($query->rowCount() >= 1):
                 $result  = $query->fetchAll(PDO::FETCH_OBJ);

                 return $result[0];
            else:
                return false;
            endif;

        }catch(PDOException $e){
            print "Error!: " . $e->getMessage();
        }
    }

    public function get_fotos_evento($id_evento){
        try {
            $sql = "SELECT id_evento, title FROM me_uploads WHERE id_evento = $id_evento";

            $query = $this->dbh->prepare($sql);
            $query->execute();

            $dbh = null;
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
}