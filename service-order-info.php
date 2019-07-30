<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/src/src-session-start.php');

require_once($_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php');

$documentTitle = 'Информация о заказе';

$operationId = hash('md5', rand());


$tmpPrintServiceOrderInfoData = [
  'config' => $config,

  'showInfo' => false,

  'dateCreate' => false,
  'name' => false,
  'orderName' => false,
  'orderItemIndex' => false,
  'orderItemTotal' => false,
  'materialType' => false,
  'printType' => false,
  'printQuantity' => false,
  'orderItemStatus' => false,
  'orderNamePrivat' => false,

  'operationId' => $operationId,

  'errorMassage' => false,
  'alertMassage' => false
];


if (isset($_GET['error-massage'])) {
  $tmpPrintServiceOrderInfoData['errorMassage'] = $_GET['error-massage'];
  $tmpPrintServiceOrderInfoData['orderItemStatus'] = 'отменен';
}
if (isset($_GET['alert-massage'])) {
  $tmpPrintServiceOrderInfoData['alertMassage'] = $_GET['alert-massage'];
  $tmpPrintServiceOrderInfoData['orderItemStatus'] = 'выполнен';
}


///////////////////////////////////////////////////////////////////////////////////////////
///////////----- PRINT ORDER ITEM INFO -----///////////----- PRINT REDNER BASIS TMP ------///////////
///////////////////////////////////////////////////////////////////////////////////////////


if ($_SERVER['REQUEST_METHOD'] === 'GET' &&
  isset($_GET['print-orderitem-info']) &&
  isset($_GET['orderitem']) &&
  isset($_GET['order'])) {

  $_SESSION['service-order-info']['operationId'] = $operationId;

  $sqlQuerySelect = 'SELECT poi.id, poi.order_item_index, poi.material_type, poi.print_type,
poi.print_quantity, poi.print_order_id, poi.order_item_status, poi.total_total_price, poi.print_quantity, 
DATE_FORMAT(po.date_create, \'%d.%m.%Y\') as date_create, 
po.order_name, po.order_name_privat, po.order_item_ready, po.calc_result_file_path, po.order_item_total, client_id, 
cl.name 
FROM print_order_items poi ';

  $sqlQueryJoin1 = 'LEFT JOIN print_orders po ON poi.print_order_id = po.id ';
  $sqlQueryJoin2 = 'LEFT JOIN clients cl ON po.client_id = cl.id ';

  $sqlQueryWhere = 'WHERE po.order_name_privat = ? AND poi.order_item_index = ?';

  $sqlParametrs = [
    $_GET['order'],
    $_GET['orderitem']
  ];

  $orderData = dbSelectData($con, $sqlQuerySelect . $sqlQueryJoin1 . $sqlQueryJoin2 . $sqlQueryWhere, $sqlParametrs)[0] ?? false;

  if (!$orderData) {
    header('Location:' . $config['host'] . '/service-order-info.php?error-massage=несуществующий заказ');
    exit();
  }

  $tmpPrintServiceOrderInfoData['showInfo'] = true;
  $documentTitle = 'Информация о заказе ' . $orderData['order_name'];

  $tmpPrintServiceOrderInfoData['dateCreate'] = $orderData['date_create'];
  $tmpPrintServiceOrderInfoData['name'] = $orderData['name'];
  $tmpPrintServiceOrderInfoData['orderName'] = $orderData['order_name'];
  $tmpPrintServiceOrderInfoData['orderItemTotal'] = $orderData['order_item_total'];
  $tmpPrintServiceOrderInfoData['materialType'] = $orderData['material_type'];
  $tmpPrintServiceOrderInfoData['printType'] = $orderData['print_type'];
  $tmpPrintServiceOrderInfoData['printQuantity'] = $orderData['print_quantity'];
  $tmpPrintServiceOrderInfoData['orderItemStatus'] = $orderData['order_item_status'];
  $tmpPrintServiceOrderInfoData['orderNamePrivat'] = $orderData['order_name_privat'];
  $tmpPrintServiceOrderInfoData['orderItemIndex'] = $orderData['order_item_index'];

}


///////////////////////////////////////////////////////////////////////////////////////////
// CHANGE PRINT ORDER ITEM STATUS ВЫПОЛНЕН /////////// CHANGE PRINT ORDER ITEM STATUS ВЫПОЛНЕН ------///////////
///////////////////////////////////////////////////////////////////////////////////////////

if ($_SERVER['REQUEST_METHOD'] === 'GET' &&
  isset($_GET['change-print-orderitem-status']) &&
  $_GET['change-print-orderitem-status'] === 'ready' &&
  isset($_GET['order']) &&
  isset($_GET['orderitem']) &&
  isset($_GET['operation-id']) &&
  isset($_SESSION['service-order-info']['operationId'])) {


  if ($_SESSION['service-order-info']['operationId'] !== $_GET['operation-id'] &&
    $changeOrderStatus['updateCalcResultFile'] === false) {
    header('Location:' . $config['host'] . '/service-order-info.php?error-massage=попытка повторного ввода');
    exit();
  }

  $_SESSION['service-order-info']['operationId'] = false;


  $changeOrderStatus = [
    'printOrderItem' => false,
    'updatePrintOrderItemReady' => false,
    'updatePrintOrderItemStatus' => false,
    'addPaymentData' => false,
    'addPayment' => false,
    'updateClientBalance' => false,

    'updatePrintOrderStatus' => false,

    'materialList' => false,

    'addMaterialData' => false,
    'addMaterial' => true,

    'updateMaterialsBalance' => true,

    'updateCalcResultFile' => false
  ];


  $sqlQuerySelect = 'SELECT poi.id, poi.order_item_index, poi.material_type, poi.print_type,
poi.print_quantity, poi.print_order_id, poi.order_item_status, poi.total_total_price, 
DATE_FORMAT(po.date_create, \'%d.%m.%Y\') as date_create, 
po.order_name, po.order_name_privat, po.order_item_ready, po.calc_result_file_path, po.order_item_total, client_id, 
cl.name 
FROM print_order_items poi ';


  $sqlQueryJoin1 = 'LEFT JOIN print_orders po ON poi.print_order_id = po.id ';
  $sqlQueryJoin2 = 'LEFT JOIN clients cl ON po.client_id = cl.id ';

  $sqlQueryWhere = 'WHERE po.order_name_privat = ? AND poi.order_item_index = ?';

  $sqlParametrs = [
    $_GET['order'],
    $_GET['orderitem']
  ];

  $changeOrderStatus['printOrderItem'] =
    dbSelectData($con, $sqlQuerySelect . $sqlQueryJoin1 . $sqlQueryJoin2 . $sqlQueryWhere, $sqlParametrs)[0] ?? false;

  if (!$changeOrderStatus['printOrderItem']) {
    header('Location:' . $config['host'] . '/service-order-info.php?error-massage=несуществующий заказ');
    exit();
  }

  if ($changeOrderStatus['printOrderItem']['order_item_status'] !== 'в работе') {
    header('Location:' . $config['host'] . '/service-order-info.php?error-massage=выполнить можно заказы находящиеся только в статусе \'в работе\'');
    exit();
  }

  if (file_exists($_SERVER['DOCUMENT_ROOT'] . $changeOrderStatus['printOrderItem']['calc_result_file_path']) === false) {
    header('Location:' . $config['host'] . '/service-order-info.php?error-massage=не найден файл заказа');
    exit();
  }

  $calcResultData =
    json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . $changeOrderStatus['printOrderItem']['calc_result_file_path']), true);

  if (isset($calcResultData['items']) === false) {
    header('Location:' . $config['host'] . '/service-order-info.php?error-massage=не верный формат файла заказа');
    exit();
  }

  mysqli_query($con, 'START TRANSACTION');

  $changeOrderStatus['updatePrintOrderItemReady'] =
    dbExecQuery($con, 'UPDATE print_orders SET order_item_ready = ? WHERE id = ?',
      [$changeOrderStatus['printOrderItem']['order_item_ready'] + 1, $changeOrderStatus['printOrderItem']['print_order_id']]);

  $changeOrderStatus['updatePrintOrderItemStatus'] =
    dbExecQuery($con, 'UPDATE print_order_items SET order_item_status = ?, date_ready = ? WHERE id = ?',
      ['выполнен', date('Y-m-d'), $changeOrderStatus['printOrderItem']['id']]);

  $changeOrderStatus['addPaymentData'] = [
    'client_id' => $changeOrderStatus['printOrderItem']['client_id'],
    'cred' => $changeOrderStatus['printOrderItem']['total_total_price'],
    'order_name' =>
      $changeOrderStatus['printOrderItem']['order_name'] . ' (' .
      ($changeOrderStatus['printOrderItem']['order_item_index'] + 1) . ')',
    'payment_date' => date('Y-m-d'),
    'payment_purpose' => 'печать',
    'payment_type' => 'авт',
    'payment_note' => 'автоматическое списание',
    'stuff' => 'Программа',
    'is_auto_create' => 1
  ];


  if ($changeOrderStatus['printOrderItem']['total_total_price'] === 0) {
    $changeOrderStatus['addPayment'] = true;
    $changeOrderStatus['updateClientBalance'] = true;
  }
  else {
    $changeOrderStatus['addPayment'] = dbInsertData($con, 'clients_payments', $changeOrderStatus['addPaymentData']);
    $changeOrderStatus['updateClientBalance'] =
      updateClientBalance($con,
        $changeOrderStatus['printOrderItem']['client_id'],
        false,
        $changeOrderStatus['printOrderItem']['total_total_price']);
  }

  $changeOrderStatus['updatePrintOrderStatus'] =
    updatePrintOrderStatus($con,
      $changeOrderStatus['printOrderItem']['print_order_id'],
      $config);

  $changeOrderStatus['materialList'] =
    getPrintOrderMaterialQuantity($calcResultData['items'][$changeOrderStatus['printOrderItem']['order_item_index']]);

  if ($changeOrderStatus['materialList']) {

    foreach ($changeOrderStatus['materialList'] as $key => $value) {
      if (!$changeOrderStatus['addMaterial']) break;
      $changeOrderStatus['addMaterialData'] = [
        'material_purpose' => 'печать',
        'cred' => $value / 1000,
        'order_name' =>
          $changeOrderStatus['printOrderItem']['order_name'] . ' (' .
          ($changeOrderStatus['printOrderItem']['order_item_index'] + 1) . ')',
        'material_name' => $key,
        'material_note' => 'автоматическое списание',
        'action_date' => date('Y-m-d'),
        'stuff' => 'Программа',
        'is_auto_create' => 1
      ];
      $changeOrderStatus['addMaterial'] = dbInsertData($con, 'materials', $changeOrderStatus['addMaterialData']);
    }
  }

  foreach ($changeOrderStatus['materialList'] as $key => $value) {

    if (!$changeOrderStatus['updateMaterialsBalance']) break;

    $changeOrderStatus['updateMaterialsBalance'] = updateMaterialsBalance($con, $key, false, $value / 1000);

    dbExecQuery($con, 'UPDATE materials_remainder SET last_order_date = ?, order_quantity = order_quantity + 1 
      WHERE material_name = ?', [date('Y-m-d'), $key]);
  }


  if ($changeOrderStatus['updatePrintOrderItemReady'] &&
    $changeOrderStatus['updatePrintOrderItemStatus'] &&
    $changeOrderStatus['addPayment'] &&
    $changeOrderStatus['updateClientBalance'] &&
    $changeOrderStatus['updatePrintOrderStatus'] &&
    $changeOrderStatus['addMaterial'] &&
    $changeOrderStatus['updateMaterialsBalance'] &&
    $calcResultData) {

    $calcResultData['items'][$changeOrderStatus['printOrderItem']['order_item_index']]['productParam']['status'] = 'выполнен';
    $changeOrderStatus['updateCalcResultFile'] =
      file_put_contents($_SERVER['DOCUMENT_ROOT'] . $changeOrderStatus['printOrderItem']['calc_result_file_path'],
        json_encode($calcResultData));
  }


  if ($changeOrderStatus['updateCalcResultFile']) {
    mysqli_query($con, 'COMMIT');
    header('Location:' . $config['host'] . '/service-order-info.php?alert-massage=сохранено');
    exit();
  } else {
    mysqli_query($con, 'ROLLBACK');
    send_email($config, 'aleanches@yandex.ru', '!!!ERROR!!! CHANGE PRINT ORDER ITEM STATUS ВЫПОЛНЕН', json_encode($changeOrderStatus));
    header('Location:' . $config['host'] . '/service-order-info.php?error-massage=ошибка сервера');
    exit();
  }
}


$tmpsSriptsData = [
  'printCalc' => false,
  'yaMetrika' => true
];

$tmpBasisData = [
  'title' => $documentTitle,
  'bodyContent' =>
    renderTemplate($_SERVER['DOCUMENT_ROOT'] . '/templates/order-info/tmp-print-service-order-info.php',
      $tmpPrintServiceOrderInfoData),
  'noFlex' => false,
  'scripts' => renderTemplate($_SERVER['DOCUMENT_ROOT'] . '/templates/tmp-basis-scripts.php', $tmpsSriptsData)
];

print(renderTemplate($_SERVER['DOCUMENT_ROOT'] . '/templates/tmp-basis.php', $tmpBasisData));
