<h5 style="color: red;">Cotización: <?php echo sprintf('#%s', $d->number); ?></h5>
<?php if (empty($d->items)) : ?>
    <div class="text-center">
        <h3>La cotización está vacía</h3>
        <img src="<?php echo IMG . 'empty.png'; ?>" alt="Sin contenido" class="img-fluid" style="width: 150px;">
    </div>
<?php else : ?>
    <div class="table-responsive">
        <table class="table table-hover table-striped table-bordered">
            <thead>
                <tr>
                    <th></th>
                    <th>Imagen</th>
                    <th>Cod. Barras</th>
                    <th>Modelo</th>
                    <th>Descrip.</th>
                    <th>Cant.</th>
                    <th>Precio</th>
                    <th class="text-end">Sub-Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($d->items as $item) : ?>
                    <tr>
                        <td>
                            <div class="btn-group">
                                <button class="btn btn-sm btn-success edit_model" data-id="<?php echo $item->id; ?>">Editar</button>
                                <button class="btn btn-sm btn-danger delete_model" data-id="<?php echo $item->id; ?>">Borrar</button>
                            </div>
                        </td>
                        <td><img src="<?php echo $item->imagen; ?>" alt="" style="width: 50px; height: 50px;"></td>
                        <td><?php echo $item->cod_barras; ?></td>
                        <td><?php echo $item->modelo; ?></td>
                        <td><?php echo $item->descripcion; ?></td>
                        <td class="text-center"><?php echo $item->cantidad; ?></td>
                        <td><?php echo '$' . number_format($item->precio_unitario, 2); ?></td>
                        <td class="text-end"><?php echo '$' . number_format($item->total, 2); ?></td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td class="text-end text-primary" colspan="7"><b>Sub-Total</b></td>
                    <td class="text-end text-primary"><b><?php echo '$' . number_format($d->subtotal, 2); ?></b></td>
                </tr>
                <tr>
                    <td class="text-end text-primary" colspan="7"><b>I.T.B.M.S</b></td>
                    <td class="text-end text-primary"><b><?php echo '$' . number_format($d->tax, 2); ?></b></td>
                </tr>
                <tr>
                    <td class="text-end text-primary" colspan="7"><b>Descuento</b></td>
                    <td class="text-end text-primary"><b><?php echo '$' . number_format($d->descuento, 2); ?></b></td>
                </tr>
                <tr>
                    <td class="text-end" colspan="8"><b>TOTAL</b>
                        <h3 class="text-success"><b><?php echo '$' . number_format($d->total, 2); ?></b></h3>
                    </td>
                </tr>
            </tbody>
        </table>
        <p class="text-end text-secondary"><b>Impuestos incluidos (<?php $quote=get_quote(); echo $quote['itbms'] ?>%)</b></p>
        <p class="text-end text-secondary"><b>Descuento incluidos (<?php echo $quote['des'] ?>%)</b></p>
    </div>
<?php endif; ?>