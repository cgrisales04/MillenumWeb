<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="public/css/style.css">
    <!-- Boostrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" rel="stylesheet">
    <title>Millenium Web</title>
</head>

<body>
    <div class="container d-flex flex-column justify-content-between contenedor">
        <!-- Incluimos el navbar -->
        <?php require('View/nav.php') ?>

        <!-- Contenedor -->
        <div class="col-md-12 d-flex justify-content-center">
            <!-- Formulario -->
            <div class="col-md-6">
                <h3 class="mb-4">Formulario</h3>
                <div class="mb-3">
                    <label for="txtNombre" class="form-label">Nombre:</label>
                    <input type="text" class="form-control" id="txtNombre" aria-describedby="nombreIndicacion">
                    <div id="nombreIndicacion" class="form-text"></div>
                </div>
                <div class="mb-3">
                    <label for="txtApellido" class="form-label">Apellidos:</label>
                    <input type="text" class="form-control" id="txtApellido" aria-describedby="apellidoIndicacion">
                    <div id="apellidoIndicacion" class="form-text"></div>
                </div>
                <button class="btn btn-primary" id="btnGuardarDatos">Guardar datos</button>
            </div>
        </div>

        <!-- Lista de usuario -->
        <div class="col-md-12">
            <table class="table table-dark table-striped">
                <thead>
                    <tr class="table-dark">
                        <th scope="col">#</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Apellido</th>
                    </tr>
                </thead>
                <tbody id="list-usuarios">

                </tbody>
            </table>
        </div>

        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand end" href="#">Millenium Web</a>
            </div>
        </nav>

    </div>
</body>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<!-- JavaScript Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script>
<!-- Jquery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="public/js/usuarios.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

</html>