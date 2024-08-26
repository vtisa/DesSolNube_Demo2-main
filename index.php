<!doctype html>
<html lang="es">

<head>
    <title>Pagina Principal</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/docs/4.0/assets/img/favicons/favicon.ico">

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <style>
        h1 {
            font-weight: bold;
            color: #333;
        }

        .card-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
        }

        .card {
            box-shadow: 0px 3px 15px rgba(0, 0, 0, 0.2);
        }

        .navbar-brand img {
            width: 30px;
            position: absolute;
            margin-left: -35px;
        }

        .navbar-brand span {
            position: relative;
            left: 35px;
        }

        .nav-link {
            color: #333 !important;
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            color: #ff6b6b !important;
        }

        .btn-info {
            background-color: #ff6b6b;
            border-color: #ff6b6b;
        }

        .btn-info:hover {
            background-color: #ff4f4f;
            border-color: #ff4f4f;
        }

        footer {
            background-color: #f8f9fa;
            padding: 20px 0;
            margin-top: 50px;
        }

        footer img {
            margin-bottom: 10px;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-md navbar-light bg-light">
        <a class="navbar-brand" href="#">
            <img src="index2.png" alt="Index Logo">
            <span>Index</span>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse"
            aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </nav>

    <div class="container px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
        <h1 class="display-4 text-info">Registrando datos with Railway</h1>
        <p class="lead">PostgreSQL + PHP</p>
    </div>

    <div class="container">
        <div class="card mb-4">
            <div class="card-body">
                <form autocomplete="off" action="index-post.php" method="post" id="registrationForm">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Nro Documento</label>
                                <input type="text" name="doc" maxlength="8" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Nombre</label>
                                <input type="text" name="nom" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Apellidos</label>
                                <input type="text" name="ape" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Direccion</label>
                                <input type="text" name="dir" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Celular</label>
                                <input type="text" name="cel" class="form-control">
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-info float-right">Registrar</button>
                </form>
            </div>
        </div>

        <!-- Modal de confirmación -->



    <footer class="pt-4 text-center">
        <div class="row">
            <div class="col-12 col-md">
                <img class="mb-2" src="https://www.svgrepo.com/show/508391/uncle.svg" alt="" width="24" height="24">
                <small class="d-block mb-3 text-muted">&copy; 2023-1</small>
            </div>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>

    <script>
        $(document).ready(function () {
            $('#registrationForm').submit(function (e) {
                // Verifica si los campos requeridos están vacíos
                var requiredFields = $('input[required]');
                var isValid = true;

                requiredFields.each(function () {
                    if ($(this).val().trim() === '') {
                        isValid = false;
                        $(this).addClass('is-invalid');
                    } else {
                        $(this).removeClass('is-invalid');
                    }
                });


                if (!isValid) {
                    e.preventDefault();
                    return false;
                } else {
                    $('#confirmationModal').modal('show');
                }
            });
        });
    </script>
</body>

</html>