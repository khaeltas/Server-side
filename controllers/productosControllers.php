<?php
class ProductosControllers
{
    static public function mostrarProductosControllers($item, $valor)
    {
        $tabla = "productos";
        $respuesta = ProductosModels::mostrarProductosModels($tabla, $item, $valor);
        return $respuesta;
    }

    static public function mostrarUltimoProductosPorIdCategoriaControllers($item, $valor)
    {
        $tabla = "productos";
        $respuesta = ProductosModels::mostrarUltimoProductosPorIdCategoriaModels($tabla, $item, $valor);
        return $respuesta;
    }

    static public function mostrarProductosDesdeTraspasosControllers($item, $valor)
    {
        $tabla = "productos";
        $respuesta = ProductosModels::mostrarProductosDesdeTraspasosModels($tabla, $item, $valor);
        return $respuesta;
    }

    static public function buscarNombreProductoControllers($item, $valor)
    {
        $tabla = "productos";
        $respuesta = ProductosModels::buscarNombreProductoModels($tabla, $item, $valor);
        return $respuesta;
    }

    static public function mostrarInventarioMinimoProductosControllers()
    {
        $sucursales = SucursalesControllers::mostrarSucursalControllers(null, null);
        $productos = ProductosControllers::mostrarProductosControllers(null, null);
        foreach ($sucursales as $key => $value)
        {
            if($value["esCasaMatriz"] == 0)
            {
                if($_SESSION["perfil"] == "administrador" || $_SESSION["perfil"] == "supervisor")
                {
                    foreach ($productos as $key => $valueProductos)
                    {
                        if($valueProductos["stock"] < $valueProductos["stockMinimo"])
                        {
                            if($valueProductos["stock"] == "" || $valueProductos["stock"] == null)
                            {
                                $stock = '0';
                            }
                            else
                            {
                                $stock = $valueProductos["stock"];
                            }
                            
                            if($valueProductos["stock"] == 1)
                            {
                                $unidad = "unidad";
                            }
                            else
                            {
                                $unidad = "unidades";
                            }
                            echo
                            '
                                <div class="toast toastProductos bg-danger" data-autohide="false">
                                    <div class="toast-header">
                                        <strong class="mr-auto text-primary bg-danger">Alerta de productos</strong>
                                        <button type="button" class="ml-2 mb-1 close" data-dismiss="toast">&times;</button>
                                    </div>
                                    <div class="toast-body">
                                        El stock de producto <b>'.$valueProductos["descripcion"].'</b> de <b>'.$value["nombreSucursal"].'</b> tiene <b>'.$stock.'</b> '.$unidad.'
                                    </div>
                                </div>
                            ';
                        }
                    }
                }
            }
            else
            {
                if($_SESSION["perfil"] == "administrador" || $_SESSION["perfil"] == "supervisor")
                {
                    foreach ($productos as $key => $valueProductos)
                    {
                        $itemSucursal = "idSucursal";
                        $valorSucursal = $value["idSucursal"];
                        $itemProducto = "idProducto";
                        $valorProducto = $valueProductos["idProducto"];
                        $traspasos = TraspasosControllers::mostrarDatosPorIdSucursalIdProductoControllers($itemSucursal, $valorSucursal, $itemProducto, $valorProducto);
                        if($traspasos)
                        {
                            if($traspasos["stock"] <= 2/*$valueProductos["stockMinimo"]*/)
                            {
                                if($traspasos["stock"] == "" || $traspasos["stock"] == null)
                                {
                                    $stock = '0';
                                }
                                else
                                {
                                    $stock = $traspasos["stock"];
                                }

                                if($traspasos["stock"] == 1)
                                {
                                    $unidad = "unidad";
                                }
                                else
                                {
                                    $unidad = "unidades";
                                }
                                echo
                                '
                                    <div class="toast toastProductos bg-danger" data-autohide="false">
                                        <div class="toast-header">
                                            <strong class="mr-auto text-primary bg-danger">Alerta de productos</strong>
                                            <button type="button" class="ml-2 mb-1 close" data-dismiss="toast">&times;</button>
                                        </div>
                                        <div class="toast-body">
                                            El stock de producto <b>'.$valueProductos["descripcion"].'</b> de <b>'.$value["nombreSucursal"].'</b> tiene <b>'.$stock.'</b> '.$unidad.'
                                        </div>
                                    </div>
                                ';
                            }
                        }
                    }
                }
            }
        }
    }

    static public function agregarProductosControllers()
    {
        if(isset($_POST["categoria"]))
        {
            if(preg_match('/^[a-zA-Z0-9 -]+$/', $_POST["codigoProducto"]) &&
               preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ "\',.-]+$/', $_POST["descripcionProducto"]) &&
               //preg_match('/^[0-9,.]+$/', $_POST["stock"]) &&
               preg_match('/^[0-9,.]+$/', $_POST["stockMinimo"])/* &&
               preg_match('/^[0-9,.]+$/', $_POST["precioCompra"]) &&
               preg_match('/^[0-9,.]+$/', $_POST["precioVenta"])*/)
            {
                $ruta = "";
                if(isset($_FILES["nuevaImagen"]["tmp_name"]) && !empty($_FILES["nuevaImagen"]["tmp_name"]))
                {
                    list($ancho, $alto) = getimagesize($_FILES["nuevaImagen"]["tmp_name"]);
					$nuevoAncho = 500;
					$nuevoAlto = 500;
                    $directorio = "views/img/productos/".$_POST["codigoProducto"];
                    if(!is_dir($directorio))
                    {
                        mkdir($directorio, 0755);
                    }
                    if($_FILES["nuevaImagen"]["type"] == "image/jpeg")
                    {
                        $aleatorio = mt_rand(100,999);
                        $ruta = "views/img/productos/".$_POST["codigoProducto"]."/".$aleatorio.".jpg";
                        $origen = imagecreatefromjpeg($_FILES["nuevaImagen"]["tmp_name"]);
                        $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
                        imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
                        imagejpeg($destino, $ruta);
                    }
                    if($_FILES["nuevaImagen"]["type"] == "image/png")
                    {
                        $aleatorio = mt_rand(100,999);
                        $ruta = "views/img/productos/".$_POST["codigoProducto"]."/".$aleatorio.".png";
                        $origen = imagecreatefrompng($_FILES["nuevaImagen"]["tmp_name"]);
                        $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
                        $transparent=imagefill($destino, 0, 0, imagecolorallocatealpha($destino, 255, 255, 255, 127));
                        imagealphablending($destino, false);
                        imagesavealpha($destino, true);
                        imagecopyresampled($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
                        imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
                        imagepng($destino, $ruta);
                    }
                }
                $itemCat = "tokenCategoria";
                $valorCat = $_POST["categoria"];
                $respuestaCat = CategoriasControllers::mostrarCategoriaControllers($itemCat, $valorCat);

                $itemUsuario = "tokenUsuario";
                $valorUsuario = $_POST["tokenUsuario"];
                $respuestaUsuario = UsuariosControllers::mostrarUsuariosControllers($itemUsuario, $valorUsuario);

                if($respuestaCat["tokenCategoria"] == $_POST["categoria"] && $respuestaUsuario["tokenUsuario"] == $_POST["tokenUsuario"])
                {
                    //COMPRA AL CONTADO = 0
                    //COMPRA A CREDITO = 1

                    //$nroAleatorio = mt_rand(1, 999); //para que se genere el token
                    
                    $tabla = "productos";
                    $token = TokenControllers::generarTokenEmpresaControllers($_POST["codigoProducto"]/*.$nroAleatorio*/, $_POST["descripcionProducto"]);
                    $datos = array("idCategoria" => $respuestaCat["idCategoria"], "idUsuario" => $respuestaUsuario["idUsuario"], "tokenProducto" => $token, "foto" => $ruta,
                                   "codigo" => $_POST["codigoProducto"], "descripcion" => $_POST["descripcionProducto"], /*"stock" => $_POST["stock"], */"stockMinimo" => $_POST["stockMinimo"],
                                   "precioVenta" => $_POST["precioVenta"]);
                    $respuesta = ProductosModels::agregarProductosModels($tabla, $datos);
                    if($respuesta == "ok")
                    {
                        echo
                        '
                            <script>
                                Swal.fire(
                                {
                                    icon: "success",
                                    title: "El producto se agrego correctamente.",
                                    allowOutsideClick: false,
                                    allowEscapeKey: false,
                                    showConfirmButton: true,
                                    confirmButtonText: "Cerrar"
                                }).then(function(result)
                                {
                                    if (result.value)
                                    {
                                        window.location = "productos";
                                    }
                                });
                            </script>
                        ';
                    }
                }
                else
                {
                    echo
                    '
                        <script>
                            Swal.fire(
                            {
                                icon: "error",
                                title: "Error al intentar guardar el producto.",
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                showConfirmButton: true,
                                confirmButtonText: "Cerrar"
                            }).then(function(result)
                            {
                                if (result.value)
                                {
                                    window.location = "productos";
                                }
                            });
                        </script>
                    ';
                }
            }
            else
            {
                echo
                '
                    <script>
                        Swal.fire(
                        {
                            icon: "error",
                            tittle: "¡ERROR!",
                            text: "¡Los datos del producto, no puede ir con los campos vacíos o llevar caracteres especiales!",
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            showConfirmButton: true,
                            confirmButtonText: "Cerrar"
                        }).then(function(result)
                        {
                            if (result.value)
                            {
                                window.location = "productos";
                            }
                        });
                    </script>
                ';
            }
        }
    }

    // static public function actualizarComprasControllers($item, $valor1, $valor)
    // {
    //     if(isset($valor1))
    //     {
    //         $tabla = "productos";
    //         $respuesta = ComprasModels::actualizarComprasModels($tabla, $item, $valor1, $valor);
    //         return $respuesta;
    //     }
    // }

    static public function editarProductosControllers()
    {
        if(isset($_POST["tokenProducto"]))
        {
            if(preg_match('/^[a-zA-Z0-9 -]+$/', $_POST["editarCodigoProducto"]) &&
               preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ,.-]+$/', $_POST["editarDescripcionProducto"]) &&
               preg_match('/^[0-9,.]+$/', $_POST["editarStockMinimo"])/* &&
               preg_match('/^[0-9,.]+$/', $_POST["editarPrecioCompra"]) &&
               preg_match('/^[0-9,.]+$/', $_POST["editarPrecioVenta"])*/)
            {
                $ruta = $_POST["imagenActual"];
                if(isset($_FILES["editarImagen"]["tmp_name"]) && !empty($_FILES["editarImagen"]["tmp_name"]))
                {
                    list($ancho, $alto) = getimagesize($_FILES["editarImagen"]["tmp_name"]);
					$nuevoAncho = 500;
					$nuevoAlto = 500;
                    if(!empty($_POST["imagenActual"]) && $_POST["imagenActual"] != "views/img/productos/default/anonymous.png")
                    {
                        unlink($_POST["imagenActual"]);
                    }
                    else
                    {
                        $directorio = "views/img/productos/".$_POST["editarCodigoProducto"];
                        mkdir($directorio, 0755);
                    }
                    if($_FILES["editarImagen"]["type"] == "image/jpeg")
                    {
                        $aleatorio = mt_rand(100,999);
                        $ruta = "views/img/productos/".$_POST["editarCodigoProducto"]."/".$aleatorio.".jpg";
                        $origen = imagecreatefromjpeg($_FILES["editarImagen"]["tmp_name"]);
                        $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
                        imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
                        imagejpeg($destino, $ruta);
                    }
                    if($_FILES["editarImagen"]["type"] == "image/png")
                    {
                        $aleatorio = mt_rand(100,999);
                        $ruta = "views/img/productos/".$_POST["editarCodigoProducto"]."/".$aleatorio.".png";
                        $origen = imagecreatefrompng($_FILES["editarImagen"]["tmp_name"]);
                        $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
                        $transparent=imagefill($destino, 0, 0, imagecolorallocatealpha($destino, 255, 255, 255, 127));
                        imagealphablending($destino, false);
                        imagesavealpha($destino, true);
                        imagecopyresampled($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
                        imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
                        imagepng($destino, $ruta);
                    }
                }
                $itemCat = "tokenCategoria";
                $valorCat = $_POST["editarCategoria"];
                $respuestaCat = CategoriasControllers::mostrarCategoriaControllers($itemCat, $valorCat);

                $itemUsuario = "tokenUsuario";
                $valorUsuario = $_POST["tokenUsuario"];
                $respuestaUsuario = UsuariosControllers::mostrarUsuariosControllers($itemUsuario, $valorUsuario);

                $itemProducto = "tokenProducto";
                $valorProducto = $_POST["tokenProducto"];
                $respuestaProducto = ProductosControllers::mostrarProductosControllers($itemProducto, $valorProducto);

                if($respuestaCat["tokenCategoria"] == $_POST["editarCategoria"] && $respuestaUsuario["tokenUsuario"] == $_POST["tokenUsuario"] && $respuestaProducto["tokenProducto"] == $_POST["tokenProducto"])
                {
                    //COMPRA AL CONTADO = 0
                    //COMPRA A CREDITO = 1

                    date_default_timezone_set('America/La_Paz');
                    $fecha = date('Y-m-d');
                    $hora = date('H:i:s');
					$fechaActual = $fecha.' '.$hora;

                    $tabla = "productos";

                    $datos = array("idCategoria" => $respuestaCat["idCategoria"], "idUsuario" => $respuestaUsuario["idUsuario"], "foto" => $ruta,
                                   "codigo" => $_POST["editarCodigoProducto"], "descripcion" => $_POST["editarDescripcionProducto"],
                                   "stockMinimo" => $_POST["editarStockMinimo"], "fechaModificacion" => $fechaActual, "tokenProducto" => $_POST["tokenProducto"]);
                    $respuesta = ProductosModels::editarProductosModels($tabla, $datos);
                    if($respuesta == "ok")
                    {
                        echo
                        '
                            <script>
                                Swal.fire(
                                {
                                    icon: "success",
                                    title: "El producto se modifico correctamente.",
                                    allowOutsideClick: false,
                                    allowEscapeKey: false,
                                    showConfirmButton: true,
                                    confirmButtonText: "Cerrar"
                                }).then(function(result)
                                {
                                    if (result.value)
                                    {
                                        window.location = "productos";
                                    }
                                });
                            </script>
                        ';
                    }
                }
                else
                {
                    echo
                    '
                        <script>
                            Swal.fire(
                            {
                                icon: "error",
                                title: "Error al intentar modificar el producto.",
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                showConfirmButton: true,
                                confirmButtonText: "Cerrar"
                            }).then(function(result)
                            {
                                if (result.value)
                                {
                                    window.location = "productos";
                                }
                            });
                        </script>
                    ';
                }
            }
            else
            {
                echo
                '
                    <script>
                        Swal.fire(
                        {
                            icon: "error",
                            tittle: ¡ERROR!,
                            text: "¡Los datos del producto, no puede ir con los campos vacíos o llevar caracteres especiales!",
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            showConfirmButton: true,
                            confirmButtonText: "Cerrar"
                        }).then(function(result)
                        {
                            if (result.value)
                            {
                                window.location = "productos";
                            }
                        });
                    </script>
                ';
            }
        }
    }

    static public function eliminarProductosControllers()
    {
        if(isset($_GET["tokenProducto"]))
        {
            $item = "tokenProducto";
            $valor = $_GET["tokenProducto"];
            $token = ProductosControllers::mostrarProductosControllers($item, $valor);
            if($token["tokenProducto"] === $_GET["tokenProducto"])
            {
                $tabla = "productos";
                $datos = $_GET["tokenProducto"];
                $respuesta = ProductosModels::eliminarProductosModels($tabla, $datos);
                if($respuesta == "ok")
                {
                    if(isset($_GET["img"]))
                    {
                        unlink($_GET["img"]);
                        rmdir("views/img/productos/".$_GET["cod"]);
                    }
                    echo
                    '
                        <script>
                            Swal.fire(
                            {
                                icon: "success",
                                title: "El producto se elimino correctamente.",
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                showConfirmButton: true,
                                confirmButtonText: "Cerrar"
                            }).then(function(result)
                            {
                                if (result.value)
                                {
                                    window.location = "productos";
                                }
                            });
                        </script>
                    ';
                }
                elseif ($respuesta == "23000")
                {
                    echo
                    '
                        <script>
                            Swal.fire(
                            {
                                icon: "info",
                                title: "El producto no puede ser eliminado por que esta en uso.",
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                showConfirmButton: true,
                                confirmButtonText: "Cerrar"
                            }).then(function(result)
                            {
                                if (result.value)
                                {
                                    window.location = "productos";
                                }
                            });
                        </script>
                    ';
                }
            }
            else
            {
                echo
                '
                    <script>
                        Swal.fire(
                        {
                            icon: "error",
                            title: "Error al intentar eliminar el producto.",
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            showConfirmButton: true,
                            confirmButtonText: "Cerrar"
                        }).then(function(result)
                        {
                            if (result.value)
                            {
                                window.location = "productos";
                            }
                        });
                    </script>
                ';
            }
        }
    }
}