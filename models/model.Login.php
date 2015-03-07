<?php require_once(PATH_MIEVENTO.'/models/model.Conexion.php');

class Login
{

    private static $instancia;
    private $dbh;

    private function __construct()
    {

        $this->dbh = Conexion::singleton_conexion();
    }

    public static function singleton_login()
    {

        if (!isset(self::$instancia)) {

            $miclase = __CLASS__;
            self::$instancia = new $miclase;

        }

        return self::$instancia;

    }

    public function login_users($nick,$password)
    {
        try {

            $sql = "SELECT id_usuario, usu_nombre, usu_nick, usu_email, usu_permisos from me_usuarios WHERE usu_nick = ? AND usu_contrasena = ?";

            $query = $this->dbh->prepare($sql);
            $query->bindParam(1,$nick);
            $query->bindParam(2,$password);
            $query->execute();

            $this->dbh = null;
            //si existe el usuario
            if($query->rowCount() == 1)
            {

                 $fila  = $query->fetchAll(PDO::FETCH_OBJ);;
                 $_SESSION['id'] = $fila[0]->id_usuario;
                 $_SESSION['user']= $fila[0];
                 $_SESSION['authenticated'] = TRUE;
                 $_SESSION["ultimoAcceso"] = time();
                 return array('exito' => TRUE, 'permisos' => $fila[0]->usu_permisos);

            }

        }catch(PDOException $e){
            print "Error!: " . $e->getMessage();

        }

    }


    public static function time_session_inactive(){
    	//sino, calculamos el tiempo transcurrido
	    $fechaGuardada = $_SESSION["ultimoAcceso"];
	    $ahora = time();
	    $tiempo_transcurrido = $ahora-$fechaGuardada;

	    //comparamos el tiempo transcurrido
	    if($tiempo_transcurrido >= 600) :
	      	session_destroy();
	  		$url = base_url();
	      	header("Location: ".$url);
	    else:
	    	$_SESSION["ultimoAcceso"] = $ahora;
	   	endif;
    }

    public static function logout_session(){
        session_destroy();
        $url = base_url();
        header("Location: ".$url);
    }

     // Evita que el objeto se pueda clonar
    public function __clone()
    {
        trigger_error('La clonación de este objeto no está permitida', E_USER_ERROR);

    }

}