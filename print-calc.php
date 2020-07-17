<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/src/src-session-start.php');

require_once($_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php');

$printCalcUserConfig = [
  'includeBloks' => [

    'maxOrderBlok' => 30,
    'maxSizeBlok' => 15,

    'canvasSize' => true,

    'noTechFields' => true,
    'manualMaterialFormat' => true,

    'customOptionalWork' => true,

    'designPrice' => true,
    'notes' => true,

    'customer' => true,
    // false or url str
    'addCustomerButton' => $config['host'] . '/clients.php?action=add-card',
    'promoCodes' => true,
    // false or arr
    'quickPromoCodes' => ['проба', 'дополнение'],

    'blankButton' => true,
    'toSaveButton' => true,

    // false or url str
    'promoSite' => false,
    // false or full str
    'descriptionBlokDetails' => 'full'
  ]
];

$printData = [
  'userConfig' => $printCalcUserConfig ?? null,
  'materialGroups' => $printMaterialGroups ?? null,
  'optionalWorks' => $printOptionalWorks ?? null,
  'otherParam' => $printOtherParam ?? null
];

///////////////////////////////////////////////////////////////////////////////////////////
///////////----- GET PRINT CALC DATA -----///////////----- GET PRINT CALC DATA ------///////////
///////////////////////////////////////////////////////////////////////////////////////////


if ($_SERVER['REQUEST_METHOD'] === 'GET' &&
  isset($_GET['action']) &&
  $_GET['action'] === 'get-print-data') {

  if (isset($_SESSION['user']) === false) {
    $printData['userConfig']['includeBloks']['maxOrderBlok'] = 10;
    $printData['userConfig']['includeBloks']['maxSizeBlok'] = 10;
    $printData['userConfig']['includeBloks']['canvasSize'] = false;
    $printData['userConfig']['includeBloks']['noTechFields'] = false;
    $printData['userConfig']['includeBloks']['manualMaterialFormat'] = false;
    $printData['userConfig']['includeBloks']['designPrice'] = false;
    $printData['userConfig']['includeBloks']['notes'] = false;
    $printData['userConfig']['includeBloks']['customer'] = false;
    $printData['userConfig']['includeBloks']['quickPromoCodes'] = false;
    $printData['userConfig']['includeBloks']['blankButton'] = false;
    $printData['userConfig']['includeBloks']['toSaveButton'] = false;
    $printData['userConfig']['includeBloks']['descriptionBlokDetails'] = false;
  }

  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  print json_encode($printData);
}

///////////////////////////////////////////////////////////////////////////////////////////
///////////----- GET CALC RESULT DATA -----///////////----- GET CALC RESULT DATA ------///////////
///////////////////////////////////////////////////////////////////////////////////////////


if ($_SERVER['REQUEST_METHOD'] === 'POST' &&
  isset($_POST['action']) &&
  $_POST['action'] === 'get-calc-result-data' &&
  isset($_POST['print-calc-form-value'])) {

  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  $calcResultData = printCalculate($printData, json_decode($_POST['print-calc-form-value'], true));
  print json_encode($calcResultData);
}


///////////////////////////////////////////////////////////////////////////////////////////
///////////----- SAVE TMP CALC RESULT DATA -----///////////----- SAVE TMP CALC RESULT DATA ------///////////
///////////////////////////////////////////////////////////////////////////////////////////


if ($_SERVER['REQUEST_METHOD'] === 'POST' &&
  isset($_SESSION['user']) &&
  isset($_POST['action']) &&
  isset($_POST['print-calc-form-value']) &&
  $_POST['action'] === 'save-tmp-calc-result-data') {

  $filePath = '/print_calc_result_data/tmp/' . hash('md5', json_encode($_SESSION['user'])) . '.json';

  $printCalcFormValue = json_decode($_POST['print-calc-form-value'], true);

  $calcResultData = printCalculate($printData, $printCalcFormValue);

  if (!isset($calcResultData['items'][0])) {
    header('Content-Type: application/json');
    print json_encode(['operation-status' => 'false', 'error-massage' => 'Ошибка данных формы']);
    exit();
  }

  if (file_put_contents($_SERVER['DOCUMENT_ROOT'] . $filePath, json_encode($calcResultData))) {
    header('Content-Type: application/json');
    print json_encode([
      'operation-status' => 'true',
      'url' => $config['host'] . '/print-calc.php?action=render-print-blank&file-path=' . $filePath]);
  } else {
    header('Content-Type: application/json');
    print json_encode([
      'operation-status' => 'false',
      'error-massage' => 'Ошибка сервера - файл не сохранен']);
  }
}

///////////////////////////////////////////////////////////////////////////////////////////
///////////----- RENDER PRINT BLANK -----///////////----- RENDER PRINT BLANK ------///////////
///////////////////////////////////////////////////////////////////////////////////////////


if ($_SERVER['REQUEST_METHOD'] === 'GET' &&
  isset($_SESSION['user']) &&
  isset($_GET['action']) &&
  isset($_GET['file-path']) &&
  $_GET['action'] === 'render-print-blank') {

  if (!file_exists($_SERVER['DOCUMENT_ROOT'] . trim($_GET['file-path']))) {
    header('Content-Type: text/html');
    print 'файл недоступен';
    exit();
  }

  $calcResultData = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . $_GET['file-path']), true);

  if (!isset($calcResultData['items'][0])) {
    header('Content-Type: text/html');
    print 'неверный формат файла';
    exit();
  }

  $tmpPrintBlankData = [
    'config' => $config,
    'only' => $_GET['only'] ?? false,
    'calcResultData' => $calcResultData
  ];

  header('Access-Control-Allow-Origin: *');
  header('Content-Type: text/html');
  print renderTemplate('templates/print/tmp-print-blank.php', $tmpPrintBlankData);
}


///////////////////////////////////////////////////////////////////////////////////////////
///////////----- GET CLIENT NAMES -----///////////----- GET CLIENT NAMES ------///////////
///////////////////////////////////////////////////////////////////////////////////////////


if ($_SERVER['REQUEST_METHOD'] === 'GET' &&
  isset($_SESSION['user']) &&
  isset($_GET['action']) &&
  $_GET['action'] === 'get-client-names' &&
  isset($_GET['short-info']) &&
  mb_strlen(trim($_GET['short-info'])) >= 3) {

  $sqlParametrs = [
    '%' . (trim($_GET['short-info'])) . '%',
    '%' . (trim($_GET['short-info'])) . '%',
    '%' . (trim($_GET['short-info'])) . '%'
  ];

  $clientsData =
    dbSelectData($con, 'SELECT name, id FROM clients WHERE name LIKE ? OR email LIKE ? OR first_tel LIKE ?', $sqlParametrs);

  header('Content-Type: application/json');
  print json_encode($clientsData);
}


///////////////////////////////////////////////////////////////////////////////////////////
///////////----- SAVE PRINT ORDER -----///////////----- SAVE PRINT ORDER ------///////////
///////////////////////////////////////////////////////////////////////////////////////////


if ($_SERVER['REQUEST_METHOD'] === 'POST' &&
  isset($_SESSION['user']) &&
  isset($_POST['action']) &&
  $_POST['action'] === 'save-print-order' &&
  isset($_POST['print-calc-form-value'])) {

  $orderNamePrivat = hash('md5', time() . rand());
  $orderName = false;
  $calcResultFolderName = '/print_calc_result_data/';
  $calcResultFolderPath = $calcResultFolderName . date('Y') . '/' . date('m') . '/';
  $calcResultFilePath = $calcResultFolderPath . $orderNamePrivat . '.json';
  $responseErrorMassage = '';

  if (!file_exists($_SERVER['DOCUMENT_ROOT'] . $calcResultFolderName . date('Y') . '/')) {
    mkdir($_SERVER['DOCUMENT_ROOT'] . $calcResultFolderName . date('Y') . '/', 0777);
  }

  if (!file_exists($_SERVER['DOCUMENT_ROOT'] . $calcResultFolderName . date('Y') . '/' . date('m') . '/')) {
    mkdir($_SERVER['DOCUMENT_ROOT'] . $calcResultFolderName . date('Y') . '/' . date('m') . '/', 0777);
  }

  $savePrintOrder = [
    'status' => true,
    'clientData' => true,
    'calcResultData' => true,
    'savePrintOrderIndex' => true,
    'updateOrderName' => true,
    'saveFileStatus' => true
  ];

  if (!file_exists($_SERVER['DOCUMENT_ROOT'] . $calcResultFolderPath)) {
    $savePrintOrder['status'] = false;
    $responseErrorMassage = 'Папка сохранения файлов недоступна';
  }

  $printCalcFormValue = json_decode(strip_tags($_POST['print-calc-form-value']), true);
  $calcResultData = printCalculate($printData, $printCalcFormValue);

  $savePrintOrder['clientData'] =
    dbSelectData($con, 'SELECT * FROM clients WHERE id = ?',
      [trim($printCalcFormValue['orderControl']['customerId'])])[0] ?? false;

  if (!$savePrintOrder['clientData']) {
    $savePrintOrder['status'] = false;
    $responseErrorMassage = 'Несохраненный клиент';
  }
  if ($savePrintOrder['status'] && !isset($calcResultData['items'][0])) {
    $savePrintOrder['status'] = false;
    $responseErrorMassage = 'Ошибка данных формы';
  }

  if ($savePrintOrder['status']) {
    mysqli_query($con, 'START TRANSACTION');

    $savePrintOrderData = [
      'order_name_privat' => $orderNamePrivat,
      'calc_result_file_path' => $calcResultFilePath,
      'client_id' => $savePrintOrder['clientData']['id'],
      'total_price' => $calcResultData['commonData']['calculations']['total']['totalPrice'],
      'square' => $calcResultData['commonData']['calculations']['print']['quantity'],
      'hours' => $calcResultData['commonData']['calculations']['total']['hours'],
      'order_status' => 'сохранен',
      'order_item_ready' => 0,
      'order_item_total' => count($calcResultData['items']),
      'promo_codes' => implode(', ', $calcResultData['commonData']['promoCodes']),
      'date_create' => date('Y-m-d'),
      'stuff_create' => $_SESSION['user']['name']
    ];

    $savePrintOrder['savePrintOrderIndex'] = dbInsertData($con, 'print_orders', $savePrintOrderData);

    if (!$savePrintOrder['savePrintOrderIndex']) {
      $savePrintOrder['status'] = false;
      $responseErrorMassage = 'Ошибка сервера - ошибка сохранения в бд';
    }

    $orderName = getOrderName($savePrintOrder['savePrintOrderIndex']);

    foreach ($calcResultData['items'] as $key => $value) {
      $calcResultData['items'][$key]['productParam']['index'] = $key;
      $calcResultData['items'][$key]['productParam']['status'] = 'сохранен';
      $calcResultData['items'][$key]['productParam']['customer'] = $savePrintOrder['clientData']['name'];
      $calcResultData['items'][$key]['productParam']['qr'] =
        $config['host'] . '/service-order-info.php?print-orderitem-info&order=' . $orderNamePrivat . '&orderitem=' . $key;
      $calcResultData['items'][$key]['productParam']['orderName'] = $orderName;
      $calcResultData['items'][$key]['productParam']['dateCreate'] = date('d.m.Y');
      $calcResultData['items'][$key]['productParam']['orderItemsQuantity'] = $savePrintOrderData['order_item_total'];
    }

    if ($savePrintOrder['status']) {
      $savePrintOrder['updateOrderName'] =
        dbExecQuery($con, 'UPDATE print_orders SET order_name = ? WHERE id = ?', [$orderName, $savePrintOrder['savePrintOrderIndex']]);
    }
    if (!$savePrintOrder['updateOrderName']) {
      $savePrintOrder['status'] = false;
      $responseErrorMassage = 'Ошибка сервера - не обновленно имя заказа';
    }

    if ($savePrintOrder['status']) {
      $savePrintOrder['saveFileStatus'] = file_put_contents($_SERVER['DOCUMENT_ROOT'] . $calcResultFilePath, json_encode($calcResultData));
    }
    if (!$savePrintOrder['saveFileStatus']) {
      $savePrintOrder['status'] = false;
      $responseErrorMassage = 'Ошибка сервера - файл не сохранен';
    }

  }

  if ($savePrintOrder['status']) {
    mysqli_query($con, 'COMMIT');
    header('Content-Type: application/json');
    print json_encode([
      'operation-status' => 'true',
      'url' => $config['host'] . '/print-calc.php?action=render-print-blank&file-path=' . $calcResultFilePath]);
  } else {
    mysqli_query($con, 'ROLLBACK');
    header('Content-Type: application/json');
    print json_encode(['operation-status' => 'false', 'error-massage' => $responseErrorMassage]);
  }

}
