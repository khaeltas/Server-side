<div class="modal fade" id="modalEditarSerie" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="agregarCuentas" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form role="form" method="post">
                <div class="modal-header navbar-dark navbar-cyan">
                    <h5 class="modal-title">Editar Serie</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-md-12 text-center">
                        <input type="hidden" name="tokenSerie" id="tokenSerie">
                        <p id="editarNombreProducto">Producto: </p>
                    </div>
                    <div class="box-body">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i class="fas fa-key"></i></span>
                            </div>
                            <input type="text" class="form-control" placeholder="Serie" name="editarSerieTabla" id="editarSerieTabla">
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i class="fas fa-key"></i></span>
                            </div>
                            <select class="form-control" name="editarTraspasoSeries" id="editarTraspasoSeries">
                                <option value="" selected disabled>Seleccione el trapaso Origen</option>
                                <?php
                                    // $traspasos = TraspasosControllers::mostrarTraspasosControllers(null, null, "todo");
                                    // foreach ($traspasos as $key => $value)
                                    // {
                                    //     $item = "idSucursal";
                                    //     $valor = $value["idSucOrigen"];
                                    //     $sucursal = SucursalesControllers::mostrarSucursalControllers($item, $valor);
                                    //     echo
                                    //     '
                                    //         <option value="'.$value["tokenTraspaso"].'">Nº '.$value["nroTraspaso"].'|'.$sucursal["nombreSucursal"].'</option>
                                    //     ';
                                    // }
                                ?>
                            </select>
                        </div>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i class="fas fa-key"></i></span>
                            </div>
                            <select class="form-control" name="editarEstadoSerie" id="editarEstadoSerie">
                                <option value="" selected disabled>Seleccione Estado</option>
                                <option value="generado">Generado</option>
                                <option value="traspaso">Traspaso</option>
                                <option value="vendido">Vendido</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                </div>
                <?php
                    // $editarSerie = new NumeroSeriesControllers();
                    // $editarSerie -> editarSerieDesdeTablaControllers();
                ?>
            </form>
        </div>
    </div>
</div>