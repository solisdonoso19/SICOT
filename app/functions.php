<?php

use Dompdf\Dompdf;

function get_view($view_name)
{
    $view = VIEWS . $view_name . 'View.php';

    //!No exite la vista
    if (!is_file($view)) {
        die('La vista no existe');
    }
    //*Existe la Vista
    require_once $view;
}

//! Cotizacion
//! new_quote[]
/**
 * number
 * vendedor
 * email vendedor
 * telefono
 * vendedor
 * cliente
 * empresa
 * email
 * tiempo_entrega
 * forma_pago
 * telefono
 * tax 
 * total
 * items[]
 */
//! Items
/**
 * item
 * id
 * cod_barras
 * modelo
 * descripcion
 * cantidad
 * precio_unitario
 * taxes
 * total
 */
//! Funciones
/**
 //? Cargar toda la cotizacion
 * get_quote()
 //? Cargar todos los elementos
 * get_items()
 //? Carga un item
 * get_item($id)
 //? Agregar un item
 * add_item($item)
 //? Borrar item
 * delete_item($id)
 //? Borrar todas
 * delete_items()
 //? Reiniciar cotizacion
 * restart_quote()
 */

//? Cargar toda la cotizacion
function get_quote()
{
    if (!isset($_SESSION['new_quote'])) {
        return $_SESSION['new_quote'] =
            [
                'number'         => rand(111111, 999999),
                'vendedor'       => '',
                'email_vendedor' => '',
                'division'       => '',
                'telefono_vendedor' => '',
                'cliente'        => '',
                'empresa'        => '',
                'email'          => '',
                'items'          => [],
                'tiempo_entrega' => '',
                'forma_pago'     => '',
                'telefono'       => '',
                'tax'            => 0,
                'subtotal'       => 0,
                'itbms'          => 0,
                'descuento'      => 0,
                'des'            => 0,   
                'total'          => 0
            ];
    }
    //* Recalcular todos los datos
    recalculate_quote();

    return $_SESSION['new_quote'];
}

function set_client($client)
{
    $_SESSION['new_quote']['vendedor']          = trim($client['vendedor']);
    $_SESSION['new_quote']['email_vendedor']    = trim($client['email_vendedor']);
    $_SESSION['new_quote']['division']    = trim($client['division']);
    $_SESSION['new_quote']['telefono_vendedor'] = trim($client['telefono_vendedor']);
    $_SESSION['new_quote']['cliente']           = trim($client['cliente']);
    $_SESSION['new_quote']['empresa']           = trim($client['empresa']);
    $_SESSION['new_quote']['email']             = trim($client['email']);
    $_SESSION['new_quote']['telefono']          = trim($client['telefono']);
    $_SESSION['new_quote']['forma_pago']        = trim($client['forma_pago']);
    $_SESSION['new_quote']['tiempo_entrega']    = trim($client['tiempo_entrega']);
    return true;
}

function recalculate_quote()
{   
    $des = $_SESSION['new_quote']['des'];
    $items    = [];
    $subtotal = 0;
    $tax      = 0;
    $total    = 0;

    if (!isset($_SESSION['new_quote'])) {
        return false;
    }

    // Validar items
    $items = $_SESSION['new_quote']['items'];

    // Si la lista de items está vacía no es necesario calcular nada
    if (!empty($items)) {
        foreach ($items as $item) {
            $subtotal += $item['total'];
            $tax      += $item['tax'];
        }
    }
    $total = ($subtotal + $tax);
    $des   = $total * ($des / 100);
    $total = $total - $des;
    

    $_SESSION['new_quote']['subtotal'] = $subtotal;
    $_SESSION['new_quote']['tax']      = $tax;
    $_SESSION['new_quote']['total']    = $total;
    $_SESSION['new_quote']['descuento'] = $des;

    return true;
}

//? Reiniciar cotizacion
function restart_quote()
{
    $_SESSION['new_quote'] =
        [
            'number'             => rand(111111, 999999),
            'vendedor'           => '',
            'email_vendedor'     => '',
            'division'           => '',
            'telefono_vendedor'  => '',
            'cliente'            => '',
            'empresa'            => '',
            'email'              => '',
            'items'              => [],
            'tiempo_entrega'     => '',
            'forma_pago'         => '',
            'telefono'           => '',
            'tax'                => 0,
            'subtotal'           => 0,
            'itbms'              => 0,
            'descuento'          => 0,
            'des'                => 0, 
            'total'              => 0
        ];
    return true;
}

//? Cargar todos los elementos
function get_items()
{
    $items = [];

    //! Si no existe la sesion y obviamente esta vacio el array
    if (!isset($_SESSION['new_quote']['items'])) {
        return $items;
    }
    //* La cotizacion existe, se asigna el valor
    $items = $_SESSION['new_quote']['items'];
    return $items;
};

//? Agregar un item
function get_item($id)
{
    $items = get_items();

    //* Si hay items
    if (empty($items)) {
        return false;
    }

    //* Si hay items iteramos

    foreach ($items as $item) {
        //? Validar si existe el mismo id pasado
        if ($item['id'] === $id) {
            return $item;
        }
    }

    //* No hubo match o resultados
    return false;
}

//? Borrar todas
function delete_items()
{
    $_SESSION['new_quote']['items'] = [];

    recalculate_quote();

    return true;
}

//? Borrar item
function delete_item($id)
{
    $items = get_items();

    //* Si no hay items
    if (empty($items)) {
        return false;
    }

    //* Si hay items iteramos
    foreach ($items as $i => $item) {
        // Validar si existe con el mismo id pasado
        if ($item['id'] === $id) {
            unset($_SESSION['new_quote']['items'][$i]);
            return true;
        }
    }

    //* No hubo un match o resultados
    return false;
}

//? Agregar un item
function add_item($item)
{
    $items = get_items();

    //* Si existe el id ya en nuestros items
    //* podemos actualizar la información en lugar de agregarlo
    if (get_item($item['id']) !== false) {
        foreach ($items as $i => $e_item) {
            if ($item['id'] === $e_item['id']) {
                $_SESSION['new_quote']['items'][$i] = $item;
                return true;
            }
        }
    }

    //! No existe en la lista, se agrega simplemente
    $_SESSION['new_quote']['items'][] = $item;
    return true;
}


function add_tax($parametros){
    $_SESSION['new_quote']['itbms']          = trim($parametros['itbms']);
    $_SESSION['new_quote']['descuento']      = trim($parametros['descuento']);
    $_SESSION['new_quote']['des']            = trim($parametros['descuento']);
    return true;
}

/**
 *!200 OK
 *!201 Created
 *!300 Multiple Choices
 *!301 Moved Permanently
 *!302 Found
 *!304 Not Modified
 *!307 Temporary Redirect
 *!400 Bad Request
 *!401 Unauthorized
 *!403 Forbidden
 *!404 Not Found
 *!410 Gone
 *!500 Internal Server Error
 *!501 Not Implemented
 *!503 Service Unavailable
 *!550 Permission denied
 */

function json_build($status = 200, $data = null, $msg = '')
{
    if (empty($msg) || $msg == '') {
        switch ($status) {
            case 200:
                $msg = 'OK';
                break;
            case 201:
                $msg = 'Created';
                break;
            case 400:
                $msg = 'Invalid request';
                break;
            case 403:
                $msg = 'Access denied';
                break;
            case 404:
                $msg = 'Not found';
                break;
            case 500:
                $msg = 'Internal Server Error';
                break;
            case 550:
                $msg = 'Permission denied';
                break;
            default:
                break;
        }
    }

    $json =
        [
            'status' => $status,
            'data'   => $data,
            'msg'    => $msg
        ];

    return json_encode($json);
}

function json_output($json)
{
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json;charset=utf-8');

    if (is_array($json)) {
        $json = json_encode($json);
    }

    echo $json;

    exit();
}

function get_module($view, $data = [])
{
    $view = $view . '.php';
    if (!is_file($view)) {
        return false;
    }
    $d = $data = json_decode(json_encode($data)); //? Conversion del objeto

    ob_start();
    require_once $view;
    $output = ob_get_clean();
    return $output;
}

function hook_mi_funcion()
{
    echo 'Estoy siendo ejecutado en ajax de forma automatica';
}

function hook_get_quote_res()
{
    //* Vamos a cargar la cotizacion
    $quote = get_quote();
    $html  = get_module(MODULES . 'quote_table', $quote);

    json_output(json_build(200, ['quote' => $quote, 'html' => $html]));
}


//? Agregar descuento y itbms
function hook_add_tax(){
    if (!isset($_POST['itbms'], $_POST['descuento'])) {
        json_output(json_build(403, null, 'Parametros incompletos.'));
    }

    $itbms                   = (int)($_POST['itbms']);
    $descuento               = (int)($_POST['descuento']);
    
    $parametros = [
        'itbms' => $itbms,
        'descuento' => $descuento
    ];

    add_tax($parametros);
}

//? Agregar un producto */
function hook_add_to_quote()
{
    // Validar
    if (!isset($_POST['cod_barras'], $_POST['modelo'], $_POST['descripcion'], $_POST['cantidad'], $_POST['precio_unitario'], $_POST['imagen'])) {
        json_output(json_build(403, null, 'Parametros incompletos.'));
    }

    $quote = get_quote();
    $cod_barras         = (int)($_POST['cod_barras']);
    $modelo             = trim($_POST['modelo']);
    $descripcion        = trim($_POST['descripcion']);
    $cantidad           = (int) trim($_POST['cantidad']);
    $precio_unitario    = (float) str_replace([',', '$'], '', $_POST['precio_unitario']);
    $imagen             = ($_POST['imagen']);
    $subtotal           = (float) $precio_unitario * $cantidad;
    $tax                = (float) $subtotal * ($quote['itbms'] / 100);

    $item =
        [
            'id'                 => rand(1111, 9999),
            'cod_barras'         => $cod_barras,
            'modelo'             => $modelo,
            'descripcion'        => $descripcion,
            'cantidad'           => $cantidad,
            'precio_unitario'    => $precio_unitario,
            'imagen'             => $imagen,
            'tax'                => $tax,
            'total'              => $subtotal
        ];

    if (!add_item($item)) {
        json_output(json_build(400, null, 'Hubo un problema al guardar el concepto en la cotización.'));
    }

    json_output(json_build(201, get_item($item['id']), 'Producto agregado con éxito.'));
}

function hook_restart_quote()
{
    $items = get_items();

    if (empty($items)) {
        json_output(json_build(400, null, 'No es necesario reiniciar la cotización, no hay conceptos en ella.'));
    }

    if (!restart_quote()) {
        json_output(json_build(400, null, 'Hubo un problema al reiniciar la cotización'));
    }
    json_output(json_build(200, get_quote(), 'La cotización se ha reiniciado con exito!'));
}

function hook_delete_model()
{
    if (!isset($_POST['id'])) {
        json_output(json_build(403, null, 'Parametros incompletos.'));
    }

    if (!delete_item((int) $_POST['id'])) {
        json_output(json_build(400, null, 'Hubo un problema al borrar el concepto'));
    }

    json_output(json_build(200, get_quote(), 'Concepto borrado con exito,'));
}

function hook_edit_model()
{
    if (!isset($_POST['id'])) {
        json_output(json_build(403, null, 'Parametros incompletos.'));
    }

    if (!$item = get_item((int) $_POST['id'])) {
        json_output(json_build(400, null, 'Hubo un problema al cargar el concepto.'));
    }

    json_output(json_build(200, $item, 'producto cargado con éxito.'));
}

//* Guardar los cambios de un concepto
function hook_save_model()
{

    if (!isset($_POST['cod_barras'], $_POST['id_model'], $_POST['modelo'], $_POST['descripcion'], $_POST['cantidad'], $_POST['precio_unitario'])) {
        json_output(json_build(403, null, 'Parametros incompletos.'));
    }
    $quote = get_quote();
    $id                 = (int) $_POST['id_model'];
    $cod_barras         = (int)($_POST['cod_barras']);
    $modelo             = trim($_POST['modelo']);
    $descripcion        = trim($_POST['descripcion']);
    $cantidad           = (int) trim($_POST['cantidad']);
    $precio_unitario    = (float) str_replace([',', '$'], '', $_POST['precio_unitario']);
    $imagen             = ($_POST['imagen']);
    $subtotal           = (float) $precio_unitario * $cantidad;
    $tax                = (float) $subtotal * ($quote['itbms'] / 100);
    
    $item =
    [
        'id'                 => $id,
        'cod_barras'         => $cod_barras,
        'modelo'             => $modelo,
        'descripcion'        => $descripcion,
        'cantidad'           => $cantidad,
        'precio_unitario'    => $precio_unitario,
        'imagen'             => $imagen,
        'tax'                => $tax,
        'total'              => $subtotal
        ];

    if (!add_item($item)) {
        json_output(json_build(400, null, 'Hubo un problema al guardar los cambios del concepto.'));
    }

    json_output(json_build(200, get_item($id), 'Cambios guardados con éxito.'));
}

function hook_generate_quote()
{
    //*Validar
    if (!isset($_POST['vendedor'] ,$_POST['email_vendedor'], $_POST['division'], $_POST['telefono_vendedor'], $_POST['cliente'], $_POST['empresa'], $_POST['email'], $_POST['telefono'], $_POST['tiempo_entrega'], $_POST['forma_pago'])) {
        json_output(json_build(400, null, 'Parametros incompletos'));
    }
    //* Validar correo
    if ((!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) && (!filter_var($_POST['vendedor_email'], FILTER_VALIDATE_EMAIL))) {
        json_output(json_build(400, null, 'Dirección de correo no valida, Revise que esten bien escritos'));
    }

    //* Guardar informacion del cliente
    $client = [
        'vendedor'          => $_POST['vendedor'],
        'email_vendedor'    => $_POST['email_vendedor'],
        'division'          => $_POST['division'],
        'telefono_vendedor' => $_POST['telefono_vendedor'],
        'cliente'           => $_POST['cliente'],
        'empresa'           => $_POST['empresa'],
        'email'             => $_POST['email'],
        'telefono'          => $_POST['telefono'],
        'tiempo_entrega'    => $_POST['tiempo_entrega'],
        'forma_pago'        => $_POST['forma_pago']
    ];

    set_client($client);

    //*cargar cotizacion

    $quote = get_quote();

    if (empty($quote['items'])) {
        json_output(json_build(400, null, 'No hay conceptos en la cotización'));
    }

    $module = MODULES . 'pdf_template';
    $html = get_module($module, $quote);
    $filename = 'coti_' . $quote['empresa'] . '_' . date('d-m-y') . '_' . $quote['number'];
    $download = sprintf(URL . 'pdf.php?number=%s', $quote['number']);
    $quote['url'] = $download;

    //* generar pdf y guardar en el servidor
    if (!generate_pdf(UPLOADS . $filename, $html)) {
        json_output(json_build(400, null, 'Hubo un problema al generar la corización.'));
    }

    json_output(json_build(200, $quote, 'Cotización generada con éxito.'));
}

function generate_pdf($filename = null, $html, $save_to_file = true)
{
    //nombre del archivo
    $filename = $filename === null ? time() . '.pdf' : $filename . '.pdf';


    $pdf = new Dompdf();
    $pdf->set_option('isRemoteEnabled', TRUE);
    $pdf->setPaper('A4');
    $pdf->loadHtml($html);
    $pdf->render();

    if ($save_to_file) {
        $output = $pdf->output();
        file_put_contents($filename, $output);
        return true;
    }
    $pdf->stream($filename);
    return true;
}

function get_all_quotes()
{
    return $quotes = glob(UPLOADS . 'coti_*.pdf');
}

function redirect($route)
{
    header(sprintf('Location: %s', $route));
    exit;
}
