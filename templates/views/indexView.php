<!-- All The Code -->
<?php require_once INCLUDES . 'head.php'; ?>
<?php require_once INCLUDES . 'nav.php'; ?>
<!-- Appliaction Content -->
<div class="container-fluid py-4">
    <div class="ror">
        <div class="col-12 wrapper_notifications"></div>
    </div>
    <div class="row">
        <!-- Client information -->
        <div class="col-lg-6 col-12">
            <div class="card mb-3">
                <div class="card-header"><b>Información del Cliente</b></div>
                <div class="card-body">
                    <form id="" method="POST">
                        <div class="form-group row">
                            <div class="col-6">
                                <label for="cliente">Cliente</label>
                                <input type="text" class="form-control" id="cliente" name="cliente" placeholder="Michael Jackson" required>
                            </div>
                            <div class="col-6">
                                <label for="empresa">Empresa</label>
                                <input type="text" class="form-control" id="empresa" name="empresa" placeholder="Apple Inc." required>
                            </div>
                            <div class="col-6">
                                <label for="email">E-mail</label>
                                <input type="text" class="form-control" id="email" name="email" placeholder="MichaelJackson@reydelpop.com" required>
                            </div>
                            <div class="col-6">
                                <label for="tiempo_entrega">Tiempo de Entrega</label>
                                <input type="text" class="form-control" id="tiempo_entrega" name="tiempo_entrega" placeholder="Mañana" required>
                            </div>
                            <div class="col-6">
                                <label for="forma_pago">Forma de Pago</label>
                                <input type="text" class="form-control" id="forma_pago" name="forma_pago" placeholder="Credito" required>
                            </div>
                            <div class="col-6">
                                <label for="telefono">Telefono</label>
                                <input type="text" class="form-control" id="telefono" name="telefono" placeholder="8888-8888" required>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Product information -->
            <div class="card">
                <div class="card-header"> <b>Agregar Producto</b></div>
                <div class="card-body">
                    <form id="add_to_quote" method="POST">
                        <div class="form-group row">
                            <div class="col-4">
                                <label for="cod_barras">Codigo de Barras</label>
                                <input type="text" class="form-control" id="cod_barras" name="cod_barras" placeholder="80008888" required>
                            </div>
                            <div class="col-4">
                                <label for="modelo">Modelo</label>
                                <input type="text" class="form-control" id="modelo" name="modelo" placeholder="MDX-5142" required>
                            </div>
                            <div class="col-4">
                                <label for="descripcion">Descripcion</label>
                                <input type="text" class="form-control" id="descripcion" name="descripcion" placeholder="Lorem ipsum dolor sit amet..." required>
                            </div>
                            <div class="col-4">
                                <label for="cantidad">Cantidad</label>
                                <input type="number" class="form-control" id="cantidad" name="cantidad" min="1" max="9999" placeholder="80008888" required>
                            </div>
                            <div class="col-4">
                                <label for="precio_unitario" colspan="3">Precio unitario</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">$</span>
                                    </div>
                                    <input type="text" class="form-control" id="precio_unitario" name="precio_unitario" placeholder="0.00" required>
                                </div>
                            </div>
                            <div class="col-4">
                            <label for="imagen"> Imagen </label>
                                <input type="text" class="form-control" id="imagen" name="imagen" />
                            </div>
                        </div>
                        <br>
                        <button class="btn btn-success" type="submit">Guardar Cambios</button>
                        <button class="btn btn-danger" type="reset">Cancelar</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-12 b-5">
            <!-- Editando producto -->
            <div class="wrapper_update_model" style="display: none;">
            <div class="card mb-3">
                <div class="card-header text-danger">           
                    <b>EDITANDO PRODUCTO</b>
                </div>
                <div class="card-body">
                    <form id="save_model" method="POST">
                        <input type="hidden" class="form-control" id="id_model" name="id_model" required>
                        <div class="form-group row">
                            <div class="col-4">
                                <label for="cod_barras">Codigo de Barras</label>
                                <input type="text" class="form-control" id="cod_barras" name="cod_barras" placeholder="80008888" required>
                            </div>
                            <div class="col-4">
                                <label for="modelo">Modelo</label>
                                <input type="text" class="form-control" id="modelo" name="modelo" placeholder="MDX-5142" required>
                            </div>
                            <div class="col-4">
                                <label for="descripcion">Descripcion</label>
                                <input type="text" class="form-control" id="descripcion" name="descripcion" placeholder="Lorem ipsum dolor sit amet..." required>
                            </div>
                            <div class="col-4">
                                <label for="cantidad">Cantidad</label>
                                <input type="number" class="form-control" id="cantidad" name="cantidad" min="1" max="9999" placeholder="80008888" required>
                            </div>
                            <div class="col-4">
                                <label for="precio_unitario" colspan="3">Precio unitario</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">$</span>
                                    </div>
                                    <input type="text" class="form-control" id="precio_unitario" name="precio_unitario" placeholder="0.00" required>
                                </div>
                            </div>
                            <div class="col-4">
                            <label for="imagen"> Imagen </label>
                                <input type="text" class="form-control" id="imagen" name="imagen" />
                            </div>
                        </div>
                        <br>
                        <button class="btn btn-success" type="submit">Guardar Cambios</button>
                        <button class="btn btn-danger" type="reset" id="cancel_edit">Cancelar</button>
                    </form>
                </div>
            </div>
            </div>
            <div class="card mt-3 mt-lg-0">
                <div class="card-header"><b>Resumen De La Cotización</b></div>
                <div class="card-body pb-4 wrapper_quote">
                </div>
                <div class="card-footer">
                    <button class="btn btn-success" id="generate_quote">Generar Cotización</button>
                    <a class="btn btn-primary" id="download_quote" style="display: none;" href="">Descargar PDF</a>
                    <!-- <button class="btn btn-success" id="send_quote" style="display: none;">Enviar Por Correo</button> -->
                    <button class="btn btn-danger float-end restart_quote">Reinciar</button>
                    <br>
                    <b class="text-danger">*RECUERDE SIEMPRE DESCARGAR LA COTIZACIÓN*</b>
                </div>
            </div>
        </div>

    </div>
</div>

<?php require_once INCLUDES . 'footer.php'; ?>

<!-- End Application Content -->