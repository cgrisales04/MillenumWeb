//Cuando se cargue la pagina
$(document).ready(function () {
  //Haz el metodo para traer todos los usuarios
  obtenerUsuarios();
});

/**
 * Esta funcion es la encargada de hacer las peticiones
 * al controlador y mostrar los datos en el front
 */
function obtenerUsuarios() {
  //Hacemos la peticion
  $.ajax({
    url: "Controller/usuarios_controller.php", //URL
    data: { funcion: "obtenerUsuarios" }, //Datos
    type: "POST", //Tipo de peticion
    dataType: "JSON", //Tipo de dato recibiremos
    //Si la peticion es satisfactoria
    success: function (response) {
      //Retificamos de que el estado sea 1
      if (response.estado == 1) {
        //Recorremos la respuesta y hacemos la estructura para el front
        let usuarios = response.usuarios.map(({ id, nombre, apellido }) => {
          return `<tr>
                    <th scope="row">${id}</th>
                    <td>${nombre}</td>
                    <td>${apellido}</td>
                <tr>`;
        });
        //Mostramos la estructura para el front
        $("#list-usuarios").html(usuarios);
        // Si el estado es 0 fue por que algo ocurrio
      } else {
        //Mostramos al front que todavia no hay usuarios
        $("#list-usuarios").html(
          `<tr><td>Aún no hay usuarios</td><td></td><td></td></tr>`
        );
      }
    },
    //En caso de fallo de peticion
    error: function (err) {
      //Mostramos el inconveniente
      command: toastr["error"]("Ha ocurrido un error.", "Millenium web");
    },
  });
}

/**
 * Esta accion inserta los usuarios
 */
$("#btnGuardarDatos").on("click", function () {
  //Hacemos las validaciones desde el front que no estén vacios
  if ($("#txtNombre").val() != "" && $("#txtApellido").val() != "") {
    //Hacemos la estructura de los datos que vamos a enviar
    const data = {
      funcion: "insertarUsuario",
      nombre: $("#txtNombre").val(),
      apellido: $("#txtApellido").val(),
    };

    //Hacemos la peticion
    $.ajax({
      url: "Controller/usuarios_controller.php", //Url
      data, //Datos
      type: "POST", //Tipo de peticion
      dataType: "JSON", //Tipo de dato
      success: function (response) {
        //Retificamos de que el estado sea 1
        if (response.estado == 1) {
          //Limpiamos el formulario
          $("#txtNombre").val("");
          $("#txtApellido").val("");
          //Mostramos una respuesta satisfactoria
          command: toastr["success"](response.mensaje, "Millenium web");
          //Actualizamos el usuario en la tabla
          obtenerUsuarios();

          // Si el estado es 0 fue por que algo ocurrio
        } else {
          //Mostramos una respuesta erronea
          command: toastr["error"](response.mensaje, "Millenium web");
        }
      },
      //En caso de fallo de peticion
      error: function (err) {
        //Mostramos el inconveniente
        command: toastr["error"]("Ha ocurrido un error.", "Millenium web");
      },
    });
    //Si los campos si estan vacios
  } else {
    //Evitamos que se duplique el alert
    toastr.options.preventDuplicates = true;
    //Mostramos el warning
    command: toastr["warning"](
      "Porfavor llene los campos obligatorios",
      "Millenium web"
    );
  }
});
