<?php

require_once('class_conexion.php');
class Usuarios {
    private $conn;

    /**
     * Metodo constructor que iniciliza la conexion con la base de datos
     */
    function __construct() {
        $this->conn = new conexionDB();
    }

     /**
     * Esta funcion se encarga de insertar los usuarios
     * @param [string] $nombre Nombre del usuario
     * @param [string] $nombre Apellido del usuario
     */
    function insertarUsuarios($nombre, $apellido) {
        #Validamos que los campos no esten vacios
        if ($nombre != '' && $apellido != '') {
            #Hacemos la consulta para insertar usuarios
            $sql = "INSERT INTO usuarios (NOMBRE, APELLIDO) VALUES (:nombre, :apellido)";
            #Enviamos los parametros para evitar inject sql
            $param = [
                'nombre'   => $nombre,
                'apellido' => $apellido
            ];
            #Ejecutamos la consulta
            $result = $this->conn->modifica($sql, $param);

            #Si se insterto almenos 1 usuario
            if ($result['estado'] == 1) {
                #Hacemos la estructura de respuesta satisfactoria
                $res = [
                    'estado'  => 1,
                    'mensaje' => 'Enhorabuena, tienes un nuevo usuario agregado.'
                ];
            } else {
                #Hacemos la estructura de respuesta erronea
                $res = [
                    'estado'  => 1,
                    'mensaje' => 'Oops, tuvimos un inconveniente, intentalo mas tarde'
                ];
            }
        } else {
            #En caso de que los campos requeridos no esten llenos
            $res = [
                'estado'  => 0,
                'mensaje' => 'Porfavor ingresa todos los campos obligatorios'
            ];
        }
        #Retornamos la respuesta para el front
        return $res;
    }

    /**
     * Esta funcion se encarga de mostrar todos los usuarios
     */
    function obtenerUsuarios() {
        #Hacemos la consulta para mostrar usuarios
        $sql = "SELECT * FROM usuarios";
        $param = [];
        #Hacemos la consulta
        $result = $this->conn->consulta($sql, $param);

        #Si tenemos almenos 1 resultado
        if ($result != null) {
            #Recorremos la consulta
            foreach ($result as $usuario) {
                #Hacemos la estructura de usuarios para el front
                $res[] = [
                    'id'       => $usuario['ID_USUARIO_PK'],
                    'nombre'   => $usuario['NOMBRE'],
                    'apellido' => $usuario['APELLIDO']
                ];
            }
            #Hacemos la estrucutra de respuesta satisfactoria
            $res = [
                'estado'   => 1,
                'mensaje'  => 'Usuarios consultados con exito',
                'usuarios' => $res
            ];
        } else {
            #Hacemos la estrucutra de respuesta erroneo
            $res = [
                'estado'   => 0,
                'mensaje'  => 'Aún no hay usuarios registrados'
            ];
        }
        #Retornamos la respuesta para el front
        return $res;
    }

}
