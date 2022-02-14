<?php

use FontLib\Table\Type\head;

require_once 'app/config.php';

//* primero validamos que existan cotizaciones y el parametro $_GET number
if (!isset($_GET['number'])) {
    redirect('index.php?error=invalid_number');
}
//* si no hay cotizacion
$quotes = get_all_quotes();
if (empty($quotes)) {
    redirect('index.php?error=no_quotes');
}

//* buscar el match del folio que buscamos
$quote = get_quote();
$number = trim($_GET['number']);
$empresa = trim($quote['empresa']);

$file = sprintf(UPLOADS.'coti_%s_'.date('d-m-y').'_%s.pdf', $empresa, $number);

if(!is_file($file)) {
    // No existe la cotización
    redirect('index.php?error=not_found');
  }
  
  //*descarga
  header('Content-Type: application/pdf');
header(sprintf('Content-Disposition: attachment;filename=%s', pathinfo($file, PATHINFO_BASENAME)));
readfile($file);

