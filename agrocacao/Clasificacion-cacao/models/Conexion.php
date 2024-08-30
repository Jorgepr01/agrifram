<?php
class conexion{
    // Variables privadas para almacenar la información de conexión
    private $servidor = "fdb1032.awardspace.net";
    private $db = "4487121_agrocacao";
    private $puerto = 3306;
    private $charset = "utf8";
    private $usuario = "4487121_agrocacao";  // Usando el mismo nombre que la base de datos como usuario
    private $contrasena = "Joker1234";  // Debes proporcionar la contraseña correcta

    //TODO: Variable pública para almacenar el objeto de conexión PDO
    public $pdo = null;    

    //TODO: Atributos de configuración para la conexión PDO
    private $atributos=[PDO::ATTR_CASE=>PDO::CASE_LOWER,PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,PDO::ATTR_ORACLE_NULLS=>PDO::NULL_EMPTY_STRING,PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_OBJ];
    
    // TODO:Constructor de la clase
    function __construct(){
        //TODO: Creación de la conexión PDO dentro del constructor
        //TODO: Se utiliza la información de conexión almacenada en las variables privadas
        // TODO: Se establecen los atributos de configuración definidos en $atributos
        $this->pdo= new PDO("mysql:dbname={$this->db};host={$this->servidor};port={$this->puerto};charset={$this->charset}",$this->usuario,$this->contrasena,$this->atributos);  
    }
}


// Crear un objeto de la clase 'conexion'
// $miConexion = new conexion();

// // Verificar si la conexión se ha establecido correctamente
// if ($miConexion->pdo) {
//     echo "Conexión exitosa a la base de datos.";
// } else {
//     echo "Error al conectar a la base de datos.";
// }