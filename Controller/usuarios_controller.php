<?php
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    switch ($_POST['funcion']) {
            //  ============= FUNCIÓN PARA INSERTAR USUARIO =========
        case "insertarUsuario":
            require_once(__DIR__ . "/../Model/class_usuarios.php");
            $usuario = new Usuarios();

            $resultado = $usuario->insertarUsuarios($_POST['nombre'], $_POST['apellido']);
            break;

            //  ============= FUNCIÓN PARA OBTENER USUARIOS ==================
        case "obtenerUsuarios":
            require_once(__DIR__ . "/../Model/class_usuarios.php");
            $usuario = new Usuarios();

            $resultado = $usuario->obtenerUsuarios();
            break;
    }

    # Se imprime la respuesta
    echo json_encode($resultado);
}
