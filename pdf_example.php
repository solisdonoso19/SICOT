<?php

require_once 'app/config.php' ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cotizacion</title>
    <style type="text/css">
        body {
            margin: 0;
        }

        * {
            font-family: Verdana, Geneva, Tahoma, sans-serif;
        }

        table {
            font-size: x-small;
        }

        tfoot tr td {
            font-weight: bold;
            font-size: x-small;
        }

        .gray {
            background-color: lightgray;
        }

        .success {
            color: green;
        }

        footer {
            width: 100%;
            font-size: xx-small;
            text-align: center;
            position: fixed;
            bottom: 1px;
        }

        footer>p {
            margin: 0;
            padding: 0;
        }


        .contenedor {

            position: relative;
        }
    </style>
</head>

<body>
    <div class="contenedor">
        <!-- //? Cabezera -->
        <h2 style="text-align:center; padding: 0; margin: 0;"><strong>DISCOVERY CENTER</strong></h2>
        <p style="text-align:center; font-size: 10px; padding: 0; margin: 0;" ; padding: 0; margin: 0;>R.U.C 1719593-690057 D.V. 59</p>
        <p style="text-align:center; font-size: 10px; padding: 0; margin: 0;">Ricardi J. Alfaro</p>
        <p style="text-align:center; font-size: 10px; padding: 0; margin: 0;">Teléfono: 294-6252</p>
        <p style="text-align:center; font-size: 10px; padding: 0; margin: 0;">FAX: 230-3869</p>
        <table style="width: 100%;">
            <tr>
                <td align="left">
                    <table>
                        <tr>
                            <td align="left">
                                <h3><?php echo APP_NAME; ?></h3>
                                <table align="left">
                                    <tr>
                                        <td align="left"><strong>Cotizacion</strong></td>
                                        <td align="left">: <?php echo rand(1111, 9999) ?></td>
                                    </tr>
                                    <tr>
                                        <td align="left"><strong>Fecha</strong></td>
                                        <td align="left">: <?php echo date('d-m-y') ?></td>
                                    </tr>
                                    <tr>
                                        <td><br></td>
                                    </tr>
                                    <tr>
                                        <td align="left"><strong>Vendedor</strong></td>
                                        <td align="left">: Carlos Solis</td>
                                    </tr>
                                    <tr>
                                        <td align="left"><strong>Email</strong></td>
                                        <td align="left">: solisdonoso@gmail.com</td>
                                    </tr>
                                    <tr>
                                        <td align="left"><strong>Telefono</strong></td>
                                        <td align="left">: 4565-5456</td>
                                    </tr>
                                </table>

                            </td>
                        </tr>
                    </table>
                </td>
                <td>
                    <table align="right">
                        <tr>
                            <td>
                                <table align="left">
                                    <tr>
                                        <td align="left"><strong>Cliente</strong></td>
                                        <td align="left">: Carlos Solis</td>
                                    </tr>
                                    <tr>
                                        <td align="left"><strong>Empresa</strong></td>
                                        <td align="left">: Dipsa</td>
                                    </tr>
                                    <tr>
                                        <td align="left"><strong>Email</strong></td>
                                        <td align="left">: Hola@mundo.com</td>
                                    </tr>
                                    <tr>
                                        <td align="left"><strong>Telefono</strong></td>
                                        <td align="left">:9696-9696</td>
                                    </tr>
                                    <br>
                                    <tr>
                                        <td align="left"><strong>Tiempo de Entrega</strong></td>
                                        <td align="left">:lorem1</td>
                                    </tr>
                                    <tr>
                                        <td align="left"><strong>Forma de Pago</strong></td>
                                        <td align="left">:lorem1</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <!-- //? informacion de la empresa -->
        <table width="100%">
            <tr>
                <table></table>
            </tr>
        </table>
        <br>
        <!-- //? resumen de la cotizacion -->
        <table width="100%">
            <thead style="background-color: lightgray;">
                <tr>
                    <th>Codigo de barras</th>
                    <th>Modelo</th>
                    <th>Descripción</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Sub-Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th scope="row">02505253</th>
                    <td>CDDF-4343</td>
                    <td>Aspiradora</td>
                    <td align="center">1</td>
                    <td align="right">10.00</td>
                    <td align="right">10.00</td>

                </tr>
                <tr>
                    <th scope="row">02505253</th>
                    <td>CDDF-4343</td>
                    <td>Aspiradora</td>
                    <td align="center">1</td>
                    <td align="right">10.00</td>
                    <td align="right">10.00</td>

                </tr>
                <tr>
                    <th scope="row">02505253</th>
                    <td>CDDF-4343</td>
                    <td>Aspiradora</td>
                    <td align="center">1</td>
                    <td align="right">10.00</td>
                    <td align="right">10.00</td>

                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4"></td>
                    <td align="right">Sub-Total</td>
                    <td align="right">100</td>
                </tr>
                <tr>
                    <td colspan="4"></td>
                    <td align="right">I.T.B.M.S</td>
                    <td align="right">10</td>
                </tr>
                <tr>
                    <td colspan="4"></td>
                    <td align="right">TOTAL</td>
                    <td align="right" class="gray">
                        <h3 style="margin: 0px 0px; font-size: 25px;">110</h3>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
    <footer>
        <p>Por favor girar cheques a nombre de DIPSA; S.A.</p>
        <p>Se aceptaran cheques certificados y sin certificar hasta <strong>$500.00.</strong></p>
        <p>*Estimados Clientes: en vista del oleaje de chques falsificados, anunciado en los medios de comunicación le informamos <br>que toda compra realizada por medio de cheque, debera esperar a que el banco compense el cheque para la entrega de mercancia <br> (Siete(7) dias habiles laborables luego de que se haya efectuado el deposito al banco.)</p>
        <p><strong>*ENTREGAS A 36 HORAS LABORABLES DESPUES DE FACTURAR Y CANCELAR*<br>*TODA ENTREGA TENDRA UN COSTO DE FLETE DEPENDIENDO DEL LUGAR DE ENTREGA</strong></p>
        <p>*No se aceptan copias de <strong>SLIP DE DEPOSITO</strong>para efectuar compras</p>
        <p>*Para su compra puede realizar pagos en efectivo, tarjetas o ACH a la cuenta corriente de Banco General de: DIPSA, S.A. 03-29-01-070626-6</p>
        <hr>
        <p>Esta cotización de nuestros productos es válida por 7 dias.</p>
        <p>Horario de atención: Lunes a Viernes de 9:00 AM a 5:00 PM y Sabados de 9:00 AM a 2:30 PM. </p>
    </footer>

</body>

</html>