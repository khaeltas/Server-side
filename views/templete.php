<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Server Side</title>

    <link rel="stylesheet" href="views/css/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="views/css/dist/css/adminlte.css">
    <link rel="stylesheet" href="views/js/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="views/js/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">

    <script src="views/js/jquery-3.6.0.min.js"></script>
    <script src="views/js/dist/js/adminlte.min.js"></script>
    <script src="views/js/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="views/js/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="views/js/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="views/js/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="views/js/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
</head>
<body>
    <div class="text-center bg-primary">
        <h1>Server Side</h1>
    </div>
    <?php
        include "modules/seriesProductos.php";
    ?>
    <script src="views/js/series.js"></script>
    <script>
        $(document).ready(function ()
        {
            valoresLista();
        });
    </script>
</body>
</html>