<?php

/**
 * Este archivo contiene la clase que controla las conexiones a la base de datos
 */
class conexionDB
{

    private $dbhost; # --> Nombre del servidor
    private $dbuser; # --> Usuario de la base de datos
    private $dbpass; # --> Contraseña de acceso
    private $dbname; # --> Nombre de la base de datos
    private $conn;   # --> Conexión a la base de datos

    /**
     * En el constructor de la clase establecemos los parámetros de conexión con la base de datos.
     */
    function __construct()
    {
        $this->dbhost = "localhost";
        $this->dbuser = "root";
        $this->dbpass = "";
        $this->dbname = "milleniumweb";
    }

    /**
     * Se genera un nuevo método de conexión utilizando PDO
     * La función abrir establece una conexión con la base de datos
     */
    private function abrir()
    {
        try {
            $this->conn = new PDO('mysql:host=' . $this->dbhost . ';dbname=' . $this->dbname, $this->dbuser, $this->dbpass, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
        } catch (PDOException $e) {
            print "Error al conectarse con la base de datos: " . $e->getMessage();
            die();
        }
    }

    /**
     * Función principal, ejecuta todas las consultas y devuelve el resultado en un arreglo
     * @param string $query consulta SQL
     * @param array  $param Array con los parametros de la consulta
     * @return array $resultado array asociativo del resultado de la consulta
     */
    public function consulta($query, $param)
    {
        $this->abrir();
        $resultado = false;
        try {
            $stmt = $this->conn->prepare($query, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
            $stmt->execute($param);

            while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
                foreach ($row as $value) {
                    $resultado[] = $value;
                }
            }
        } catch (PDOException $e) {
            $resultado['estado'] = 'ERROR: ' . $e->getMessage();
        }

        $this->cerrar();
        return $resultado;
    }

    /**
     * función que ejecuta las sentencia de inserción, actualización y borrado
     * @param $query Consulta mysql
     * @param $param Parametros requeridos en la sentencia
     * @return $resultado Array con el resultado de la ejecución: estado => 0 para error, 1 para éxito, affect => número de columnas afectadas
     */
    public function modifica($query, $param)
    {
        $this->abrir();
        try {
            //$stmt = $this->conn->prepare("set global sql_mode='NO_ENGINE_SUBSTITUTION'", [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
            //$stmt->execute();
            $stmt = $this->conn->prepare($query, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
            $stmt->execute($param);

            $resultado = array(
                'estado' => 1,
                'affect' => $stmt->rowCount(),
                'lastId' => $this->conn->lastInsertId()
            );
        } catch (PDOException $e) {
            $resultado = array(
                'estado' => 'ERROR: ' . $e->getMessage(),
                'affect' => '',
                'lastId' => ''
            );
        }

        $this->cerrar();
        return $resultado;
    }

    /**
     * función que ejecuta las eliminación, creación y llenado masivo de tablas
     * @param $query Consulta mysql
     * @return $resultado Array con el resultado de la ejecución: estado => 0 para error, 1 para éxito, affect => número de columnas afectadas
     */
    public function create_drop_tablas($query)
    {
        $this->abrir();

        try {
            //$stmt = $this->conn->prepare("set global sql_mode='NO_ENGINE_SUBSTITUTION'", [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
            //$stmt->execute();
            $stmt = $this->conn->prepare($query, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
            $stmt->execute();

            $resultado = array(
                'estado'  => 1,
                'mensaje' => "Sentencia ejecutada correctamente"
            );
        } catch (PDOException $e) {
            $resultado = array(
                'estado'  => 0,
                'mensaje' => $e->getMessage()
            );
        }

        return $resultado;
    }

    # Función que cierra la conexión con la base de datos
    private function cerrar()
    {
        $this->conn = null;
    }
}
