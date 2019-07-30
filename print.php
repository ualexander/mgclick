<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/src/src-session-start.php');

if (isset($_SESSION['user']) === false) {
  http_response_code(401);
  header('Location:' . $config['host'] . '/login.php');
  exit();
}

require_once($_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php');

$tmpBasisLayoutData = [
  'config' => $config,
  'navigationList' => $navigationList,
  'alertMassage' => false,
  'errorMassage' => false,
  'layoutContent' => false,
  'pagination' => false
];

$tmpBasisLayoutData['navigationList']['print']['isActive'] = true;
$documentTitle = 'Печать';


if (isset($_GET['error-massage'])) {
  $tmpBasisLayoutData['errorMassage'] = $_GET['error-massage'];
}
if (isset($_GET['alert-massage'])) {
  $tmpBasisLayoutData['alertMassage'] = $_GET['alert-massage'];
}


///////////////////////////////////////////////////////////////////////////////////////////
///////////----- ADD DELIVERY STICKER -----///////////----- ADD DELIVERY STICKER ------///////////
///////////////////////////////////////////////////////////////////////////////////////////

if ($_SERVER['REQUEST_METHOD'] === 'GET' &&
  isset($_GET['need-delivery']) &&
  isset($_GET['order'])) {


  $needDelevery = [
    'getParamStr' => '&orders&status=' . ($_GET['status'] ?? '') . '&page=' . ($_GET['page'] ?? ''),
    'updatePrintOrders' => false
  ];

  $needDelevery['updatePrintOrders'] = dbExecQuery($con, 'UPDATE print_orders SET need_delivery = 1 WHERE id = ?', [$_GET['order']]);

  if ($needDelevery['updatePrintOrders']) {
    header('Location:' . $config['host'] . '/print.php?' . 'alert-massage=добавлен стикер \'доставка\'' . $needDelevery['getParamStr']);
    exit();
  } else {
    header('Location:' . $config['host'] . '/print.php?' . 'error-massage=ошибка' . $needDelevery['getParamStr']);
    exit();
  }

}


///////////////////////////////////////////////////////////////////////////////////////////
///////////----- CHANGE ORDER STATUS ОТГРУЖЕН -----///////////----- CHANGE ORDER STATUS ОТГРУЖЕН ------///////////
///////////////////////////////////////////////////////////////////////////////////////////

if ($_SERVER['REQUEST_METHOD'] === 'GET' &&
  isset($_GET['change-order-status']) &&
  isset($_GET['order']) &&
  $_GET['change-order-status'] === 'отгружен') {

  $changeOrderStatus = [
    'getParamStr' => '&orders&status=' . ($_GET['status'] ?? '') . '&page=' . ($_GET['page'] ?? ''),
    'printOrder' => false,
    'orderItemsCount' => false,
    'avalaibleOrderItemsCount' => false,
    'updatePrintOrderStatus' => false,
    'updatePrintOrderItemStatus' => false,
    'updateCalcResultFile' => false,
  ];

  $changeOrderStatus['printOrder'] =
    dbSelectData($con, 'SELECT id, client_id, order_status, order_name, calc_result_file_path FROM print_orders 
       WHERE id = ?', [$_GET['order']])[0] ?? false;


  if ($changeOrderStatus['printOrder'] === false) {
    header('Location:' . $config['host'] . '/print.php?' . 'error-massage=несуществующий заказ' .
      $changeOrderStatus['getParamStr']);
    exit();
  }

  if ($changeOrderStatus['printOrder']['order_status'] !== 'выполнен') {
    header('Location:' . $config['host'] . '/print.php?' . 'error-massage=отгрузить можно заказы находящиеся только в статусе \'выполнен\'' .
      $changeOrderStatus['getParamStr']);
    exit();
  }

  $changeOrderStatus['orderItemsCount'] =
    dbSelectData($con, 'SELECT COUNT(id) AS a FROM print_order_items WHERE print_order_id = ?',
      [$changeOrderStatus['printOrder']['id']])[0]['a'] ?? false;

  $changeOrderStatus['avalaibleOrderItemsCount'] =
    dbSelectData($con, 'SELECT COUNT(id) AS b FROM print_order_items WHERE print_order_id = ? AND 
      (order_item_status = ? OR order_item_status = ?)',
      [$changeOrderStatus['printOrder']['id'], 'отменен', 'выполнен'])[0]['b'] ?? false;

  if ($changeOrderStatus['orderItemsCount'] !== $changeOrderStatus['avalaibleOrderItemsCount']) {
    header('Location:' . $config['host'] . '/print.php?error-massage=некоторые части заказа находятся в статусе при котором невозможно отгрузить заказ' .
      $changeOrderStatus['getParamStr']);
    exit();
  }

  if (file_exists($_SERVER['DOCUMENT_ROOT'] . $changeOrderStatus['printOrder']['calc_result_file_path']) === false) {
    header('Location:' . $config['host'] . '/print.php?error-massage=massage=не найден файл заказа' .
      $changeOrderStatus['getParamStr']);
    exit();
  }

  $calcResultData =
    json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . $changeOrderStatus['printOrder']['calc_result_file_path']), true);

  if (isset($calcResultData['items']) === false) {
    header('Location:' . $config['host'] . '/print.php?error-massage=massage=не верный формат файла заказа' .
      $changeOrderStatus['getParamStr']);
    exit();
  }


  mysqli_query($con, 'START TRANSACTION');

  $changeOrderStatus['updatePrintOrderStatus'] =
    dbExecQuery($con, 'UPDATE print_orders SET order_status = ?, date_issued = ? 
      WHERE id = ?', ['отгружен', date('Y-m-d'), $changeOrderStatus['printOrder']['id']]);

  $changeOrderStatus['updatePrintOrderItemStatus'] =
    dbExecQuery($con, 'UPDATE print_order_items SET order_item_status = ?, date_issued = ? 
      WHERE print_order_id = ? AND order_item_status = ?',
      ['отгружен', date('Y-m-d'), $changeOrderStatus['printOrder']['id'], 'выполнен']);


  if ($changeOrderStatus['updatePrintOrderStatus'] &&
    $changeOrderStatus['updatePrintOrderItemStatus']) {

    foreach ($calcResultData['items'] as $key => $value) {
      if ($calcResultData['items'][$key]['productParam']['status'] === 'выполнен') {
        $calcResultData['items'][$key]['productParam']['status'] = 'отгружен';
      }
    }

    $changeOrderStatus['updateCalcResultFile'] =
      file_put_contents($_SERVER['DOCUMENT_ROOT'] .
        $changeOrderStatus['printOrder']['calc_result_file_path'], json_encode($calcResultData));

  }

  dbExecQuery($con, 'UPDATE clients SET last_order_date = ?, orders_count = orders_count + 1 
    WHERE id = ?', [date('Y-m-d'), $changeOrderStatus['printOrder']['client_id']]);

  if ($changeOrderStatus['updateCalcResultFile']) {
    mysqli_query($con, 'COMMIT');
    header('Location:' . $config['host'] . '/print.php?alert-massage=статус заказа ' .
      $changeOrderStatus['printOrder']['order_name'] . ' изменен на \'отгружен\'' . $changeOrderStatus['getParamStr']);
  } else {
    mysqli_query($con, 'ROLLBACK');
    header('Location:' . $config['host'] . '/print.php?&error-massage=ошибка сервера' . $changeOrderStatus['getParamStr']);
  }

  exit();
}

///////////////////////////////////////////////////////////////////////////////////////////
///////////----- CHANGE ORDER STATUS ОТМЕНЕН -----///////////----- CHANGE ORDER STATUS ОТМЕНЕН ------///////////
///////////////////////////////////////////////////////////////////////////////////////////

if ($_SERVER['REQUEST_METHOD'] === 'GET' &&
  isset($_GET['change-order-status']) &&
  isset($_GET['order']) &&
  $_GET['change-order-status'] === 'отменен') {

  $changeOrderStatus = [
    'getParamStr' => '&orders&status=' . ($_GET['status'] ?? '') . '&page=' . ($_GET['page'] ?? ''),
    'printOrder' => false,
    'orderItemsCount' => false,
    'deletedOrderItemsCount' => false,
    'notAvalaibleOrderItemStatusCount' => false,
    'updatePrintOrderStatus' => true,
    'updatePrintOrderItemStatus' => true,
    'updateCalcResultFile' => false
  ];

  $changeOrderStatus['printOrder'] =
    dbSelectData($con, 'SELECT id, order_status, calc_result_file_path, order_name FROM print_orders WHERE id = ?',
      [$_GET['order']])[0] ?? false;

  if ($changeOrderStatus['printOrder'] === false) {
    header('Location:' . $config['host'] . '/print.php?error-massage=несуществующий заказ' .
      $changeOrderStatus['getParamStr']);
    exit();
  }

  if ($changeOrderStatus['printOrder']['order_status'] !== 'сохранен' &&
    $changeOrderStatus['printOrder']['order_status'] !== 'в работе') {

    header('Location:' . $config['host'] . '/print.php?error-massage=отменить можно заказы находящиеся только в статусе \'сохранен\' или \'в работе\'' .
      $changeOrderStatus['getParamStr']);
    exit();
  }

  $changeOrderStatus['notAvalaibleOrderItemStatusCount'] =
    dbSelectData($con, 'SELECT COUNT(id) AS a FROM print_order_items 
      WHERE print_order_id = ? AND order_item_status != ? AND order_item_status != ? AND order_item_status != ?',
      [$changeOrderStatus['printOrder']['id'], 'сохранен', 'в работе', 'отменен'])[0]['a'] ?? false;

  if ($changeOrderStatus['notAvalaibleOrderItemStatusCount'] > 0) {
    header('Location:' . $config['host'] . '/print.php?error-massage=некоторые части заказа находятся в статусе при котором невозможно отменить весь заказ' .
      $changeOrderStatus['getParamStr']);
    exit();
  }


  if (file_exists($_SERVER['DOCUMENT_ROOT'] . $changeOrderStatus['printOrder']['calc_result_file_path']) === false) {
    header('Location:' . $config['host'] . '/print.php?error-massage=не найден файл заказа' .
      $changeOrderStatus['getParamStr']);
    exit();
  }

  $calcResultData = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . $changeOrderStatus['printOrder']['calc_result_file_path']), true);

  if (isset($calcResultData['items']) === false) {
    header('Location:' . $config['host'] . '/print.php?error-massage=не верный формат файла заказа' .
      $changeOrderStatus['getParamStr']);
    exit();
  }


  $changeOrderStatus['orderItemsCount'] =
    dbSelectData($con, 'SELECT COUNT(id) AS b FROM print_order_items WHERE print_order_id = ?',
      [$changeOrderStatus['printOrder']['id']])[0]['b'] ?? false;

  $changeOrderStatus['deletedOrderItemsCount'] =
    dbSelectData($con, 'SELECT COUNT(id) AS c FROM print_order_items WHERE print_order_id = ? AND order_item_status = ?',
      [$changeOrderStatus['printOrder']['id'], 'отменен'])[0]['c'] ?? false;

  mysqli_query($con, 'START TRANSACTION');

  $changeOrderStatus['updatePrintOrderStatus'] =
    dbExecQuery($con, 'UPDATE print_orders SET order_status = ?, date_deleted = ?, order_note = ? WHERE id = ?',
      ['отменен', date('Y-m-d'), '', $changeOrderStatus['printOrder']['id']]);

  if ($changeOrderStatus['printOrder']['order_status'] !== 'сохранен' &&
    $changeOrderStatus['orderItemsCount'] !== $changeOrderStatus['deletedOrderItemsCount']) {

    $changeOrderStatus['updatePrintOrderItemStatus'] =
      dbExecQuery($con, 'UPDATE print_order_items SET order_item_status = ?, date_deleted = ? 
        WHERE print_order_id = ? AND (order_item_status = ? OR order_item_status = ?)',
        ['отменен', date('Y-m-d'), $changeOrderStatus['printOrder']['id'], 'сохранен', 'в работе']);

  }


  if ($changeOrderStatus['updatePrintOrderStatus'] &&
    $changeOrderStatus['updatePrintOrderItemStatus']) {

    foreach ($calcResultData['items'] as $key => $value) {
      $calcResultData['items'][$key]['productParam']['status'] = 'отменен';
    }

    $changeOrderStatus['updateCalcResultFile'] =
      file_put_contents($_SERVER['DOCUMENT_ROOT'] .
        $changeOrderStatus['printOrder']['calc_result_file_path'], json_encode($calcResultData));
  }

  if ($changeOrderStatus['updateCalcResultFile']) {
    mysqli_query($con, 'COMMIT');
    header('Location:' . $config['host'] . '/print.php?alert-massage=статус заказа ' .
      $changeOrderStatus['printOrder']['order_name'] . ' изменен на \'отменен\'' . $changeOrderStatus['getParamStr']);
  } else {
    mysqli_query($con, 'ROLLBACK');
    header('Location:' . $config['host'] . '/print.php?error-massage=ошибка сервера' .
      $changeOrderStatus['getParamStr']);
  }

  exit();
}
///////////////////////////////////////////////////////////////////////////////////////////
///////////----- CHANGE ORDER ITEM STATUS ОТМЕНЕН -----///////////----- CHANGE ORDER ITEM STATUS ОТМЕНЕН ------///////////
///////////////////////////////////////////////////////////////////////////////////////////

if ($_SERVER['REQUEST_METHOD'] === 'GET' &&
  isset($_GET['change-orderitem-status']) &&
  isset($_GET['orderitem']) &&
  $_GET['change-orderitem-status'] === 'отменен') {

  $changeOrderStatus = [
    'getParamStr' => '&orderitems&status=' . ($_GET['status'] ?? '') . '&page=' . ($_GET['page'] ?? ''),
    'printOrderItem' => false,
    'printOrder' => false,
    'updatePrintOrderItemStatus' => true,
    'updatePrintOrderStatus' => true,
    'updateCalcResultFile' => false
  ];

  if (isset($_GET['orderitems-order'])) {
    $changeOrderStatus['getParamStr'] = $changeOrderStatus['getParamStr'] . '&orderitems-order=' . $_GET['orderitems-order'];
  }

  $changeOrderStatus['printOrderItem'] =
    dbSelectData($con, 'SELECT id, print_order_id, order_item_status, order_item_index FROM print_order_items 
      WHERE id = ?', [$_GET['orderitem']])[0] ?? false;

  if ($changeOrderStatus['printOrderItem'] === false) {
    header('Location:' . $config['host'] . '/print.php?error-massage=несуществующий бланк заказа' .
      $changeOrderStatus['getParamStr']);
    exit();
  }

  if ($changeOrderStatus['printOrderItem']['order_item_status'] !== 'сохранен' &&
    $changeOrderStatus['printOrderItem']['order_item_status'] !== 'в работе') {

    header('Location:' . $config['host'] . '/print.php?error-massage=отменить можно заказы находящиеся только в статусе \'сохранен\' или \'в работе\'' .
      $changeOrderStatus['getParamStr']);
    exit();
  }

  $changeOrderStatus['printOrder'] = dbSelectData($con, 'SELECT id, calc_result_file_path, order_name 
    FROM print_orders WHERE id = ?', [$changeOrderStatus['printOrderItem']['print_order_id']])[0] ?? false;

  if ($changeOrderStatus['printOrder'] === false) {
    header('Location:' . $config['host'] . '/print.php?error-massage=несуществующий заказ' .
      $changeOrderStatus['getParamStr']);
    exit();
  }


  if (file_exists($_SERVER['DOCUMENT_ROOT'] . $changeOrderStatus['printOrder']['calc_result_file_path']) === false) {
    header('Location:' . $config['host'] . '/print.php?error-massage=не найден файл заказа' .
      $changeOrderStatus['getParamStr']);
    exit();
  }

  $calcResultData =
    json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . $changeOrderStatus['printOrder']['calc_result_file_path']), true);

  if (isset($calcResultData['items']) === false) {
    header('Location:' . $config['host'] . '/print.php?error-massage=не верный формат файла заказа' .
      $changeOrderStatus['getParamStr']);
    exit();
  }

  mysqli_query($con, 'START TRANSACTION');

  $changeOrderStatus['updatePrintOrderItemStatus'] =
    dbExecQuery($con, 'UPDATE print_order_items SET order_item_status = ?, date_deleted = ? 
      WHERE id = ?', ['отменен', date('Y-m-d'), $changeOrderStatus['printOrderItem']['id']]);

  $changeOrderStatus['updatePrintOrderStatus'] =
    updatePrintOrderStatus($con, $changeOrderStatus['printOrder']['id'], $config);

  dbExecQuery($con, 'UPDATE print_orders SET order_note = ? WHERE id = ?',
    ['частично отменен', $changeOrderStatus['printOrder']['id']]);


  if ($changeOrderStatus['updatePrintOrderItemStatus'] &&
    $changeOrderStatus['updatePrintOrderStatus']) {

    $calcResultData['items'][$changeOrderStatus['printOrderItem']['order_item_index']]['productParam']['status'] = 'отменен';

    $changeOrderStatus['updateCalcResultFile'] =
      file_put_contents($_SERVER['DOCUMENT_ROOT'] .
        $changeOrderStatus['printOrder']['calc_result_file_path'], json_encode($calcResultData));
  }

  if ($changeOrderStatus['updateCalcResultFile']) {
    mysqli_query($con, 'COMMIT');
    header('Location:' . $config['host'] . '/print.php?alert-massage=статус заказа ' .
      $changeOrderStatus['printOrder']['order_name'] . ' (' . ($changeOrderStatus['printOrderItem']['order_item_index'] + 1) .
      ') изменен на \'отменен\'' . $changeOrderStatus['getParamStr']);
  } else {
    mysqli_query($con, 'ROLLBACK');
    header('Location:' . $config['host'] . '/print.php?error-massage=ошибка сервера' . $changeOrderStatus['getParamStr']);
  }

  exit();
}


///////////////////////////////////////////////////////////////////////////////////////////
///////////----- CHANGE ORDER STATUS В РАБОТЕ -----///////////----- CHANGE ORDER STATUS В РАБОТЕ ------///////////
///////////////////////////////////////////////////////////////////////////////////////////


if ($_SERVER['REQUEST_METHOD'] === 'GET' &&
  isset($_GET['change-order-status']) &&
  isset($_GET['order']) &&
  $_GET['change-order-status'] === 'в работе') {

  $orderData = dbSelectData($con, 'SELECT * FROM print_orders WHERE id = ?', [$_GET['order']])[0] ?? false;
  $getParamStr = '&orders&status=' . ($_GET['status'] ?? '') . '&page=' . ($_GET['page'] ?? '');

  if (isset($orderData['order_status']) === false) {
    header('Location:' . $config['host'] . '/print.php?error-massage=несуществующий заказ' . $getParamStr);
    exit();
  }

  if (isset($orderData['order_status']) && $orderData['order_status'] !== 'сохранен') {
    header('Location:' . $config['host'] . '/print.php?error-massage=в работу можно отправить заказы только в статусе \'сохранен\'' .
      $getParamStr);
    exit();
  }

  if (file_exists($_SERVER['DOCUMENT_ROOT'] . $orderData['calc_result_file_path']) === false) {
    header('Location:' . $config['host'] . '/print.php?error-massage=не найден файл заказа' . $getParamStr);
    exit();
  }

  $calcResultData = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . $orderData['calc_result_file_path']), true);

  if (isset($calcResultData['items']) === false) {
    header('Location:' . $config['host'] . '/print.php?error-massage=не верный формат файла заказа' . $getParamStr);
    exit();
  }

  $savePrintOrderItems = true;
  $updateCalcResultFile = true;

  mysqli_query($con, 'START TRANSACTION');

  foreach ($calcResultData['items'] as $key => $value) {

    if (!$savePrintOrderItems) break;

    $savePrintOrderItemsData = [];

    $calcResultData['items'][$key]['productParam']['status'] = 'в работе';

    $savePrintOrderItemsData['print_order_id'] = $orderData['id'];
    $savePrintOrderItemsData['order_item_index'] = $value['productParam']['index'];
    $savePrintOrderItemsData['material_type'] = $value['productParam']['materialTypeRu'];
    $savePrintOrderItemsData['print_type'] = $value['productParam']['printTypeRu'];
    $savePrintOrderItemsData['order_item_status'] = 'в работе';

    $savePrintOrderItemsData['total_total_price'] = $value['calculations']['total']['totalPrice'];
    $savePrintOrderItemsData['total_total_hours'] = $value['calculations']['total']['hours'];
    $savePrintOrderItemsData['total_material_cost'] = $value['calculations']['total']['materialCost'];

    $savePrintOrderItemsData['print_quantity'] = $value['calculations']['print']['quantity'];
    $savePrintOrderItemsData['print_total_price'] = $value['calculations']['print']['totalPrice'];
    $savePrintOrderItemsData['print_hours'] = $value['calculations']['print']['hours'];

    $savePrintOrderItemsData['overspending_quantity'] = $value['calculations']['overspending']['quantity'];
    $savePrintOrderItemsData['overspending_total_price'] = $value['calculations']['overspending']['totalPrice'];
    $savePrintOrderItemsData['overspending_percent'] =
      ceil(100 * $value['calculations']['overspending']['quantity'] /
        ($value['calculations']['overspending']['quantity'] + $value['calculations']['print']['quantity'])
        * 10) / 10;

    $savePrintOrderItemsData['optional_work_total_price'] = $value['calculations']['cringle']['totalPrice'] +
      $value['calculations']['gain']['totalPrice'] +
      $value['calculations']['cut']['totalPrice'] +
      $value['calculations']['cord']['totalPrice'] +
      $value['calculations']['pocket']['totalPrice'] +
      $value['calculations']['coupling']['totalPrice'] +
      $value['calculations']['lamination']['totalPrice'] +
      $value['calculations']['stickToPlastic']['totalPrice'];
    $savePrintOrderItemsData['optional_work_hours'] = $value['calculations']['cringle']['hours'] +
      $value['calculations']['gain']['hours'] +
      $value['calculations']['cut']['hours'] +
      $value['calculations']['cord']['hours'] +
      $value['calculations']['pocket']['hours'] +
      $value['calculations']['coupling']['hours'] +
      $value['calculations']['lamination']['hours'] +
      $value['calculations']['stickToPlastic']['hours'];

    if ($savePrintOrderItemsData['optional_work_total_price'] <= 0) {
      unset($savePrintOrderItemsData['optional_work_total_price']);
    }

    if ($savePrintOrderItemsData['optional_work_hours'] <= 0) {
      unset($savePrintOrderItemsData['optional_work_hours']);
    }

    if ($value['calculations']['cringle']['totalPrice'] > 0 ||
      (isset($value['calculations']['cringle']['quantity']) && $value['calculations']['cringle']['quantity'] > 0)) {
      $savePrintOrderItemsData['cringle_quantity'] = $value['calculations']['cringle']['quantity'];
      $savePrintOrderItemsData['cringle_total_price'] = $value['calculations']['cringle']['totalPrice'];
      $savePrintOrderItemsData['cringle_hours'] = $value['calculations']['cringle']['hours'];
    }
    if ($value['calculations']['gain']['totalPrice'] > 0 ||
      (isset($value['calculations']['gain']['quantity']) && $value['calculations']['gain']['quantity'] > 0)) {
      $savePrintOrderItemsData['gain_quantity'] = $value['calculations']['gain']['quantity'];
      $savePrintOrderItemsData['gain_total_price'] = $value['calculations']['gain']['totalPrice'];
      $savePrintOrderItemsData['gain_hours'] = $value['calculations']['gain']['hours'];
    }
    if ($value['calculations']['cut']['totalPrice'] > 0 ||
      (isset($value['calculations']['cut']['quantity']) && $value['calculations']['cut']['quantity'] > 0)) {
      $savePrintOrderItemsData['cut_quantity'] = $value['calculations']['cut']['quantity'];
      $savePrintOrderItemsData['cut_total_price'] = $value['calculations']['cut']['totalPrice'];
      $savePrintOrderItemsData['cut_hours'] = $value['calculations']['cut']['hours'];
    }
    if ($value['calculations']['cord']['totalPrice'] > 0 ||
      (isset($value['calculations']['cord']['quantity']) && $value['calculations']['cord']['quantity'] > 0)) {
      $savePrintOrderItemsData['cord_quantity'] = $value['calculations']['cord']['quantity'];
      $savePrintOrderItemsData['cord_total_price'] = $value['calculations']['cord']['totalPrice'];
      $savePrintOrderItemsData['cord_hours'] = $value['calculations']['cord']['hours'];
    }

    if ($value['calculations']['pocket']['totalPrice'] > 0 ||
      (isset($value['calculations']['pocket']['quantity']) && $value['calculations']['pocket']['quantity'] > 0)) {
      $savePrintOrderItemsData['pocket_quantity'] = $value['calculations']['pocket']['quantity'];
      $savePrintOrderItemsData['pocket_total_price'] = $value['calculations']['pocket']['totalPrice'];
      $savePrintOrderItemsData['pocket_hours'] = $value['calculations']['pocket']['hours'];
    }
    if ($value['calculations']['coupling']['totalPrice'] > 0 ||
      (isset($value['calculations']['coupling']['quantity']) && $value['calculations']['coupling']['quantity'] > 0)) {
      $savePrintOrderItemsData['coupling_quantity'] = $value['calculations']['coupling']['quantity'];
      $savePrintOrderItemsData['coupling_total_price'] = $value['calculations']['coupling']['totalPrice'];
      $savePrintOrderItemsData['coupling_hours'] = $value['calculations']['coupling']['hours'];
    }
    if ($value['calculations']['lamination']['totalPrice'] > 0 ||
      (isset($value['calculations']['lamination']['quantity']) && $value['calculations']['lamination']['quantity'] > 0)) {
      $savePrintOrderItemsData['lamination_quantity'] = $value['calculations']['lamination']['quantity'];
      $savePrintOrderItemsData['lamination_total_price'] = $value['calculations']['lamination']['totalPrice'];
      $savePrintOrderItemsData['lamination_hours'] = $value['calculations']['lamination']['hours'];
    }
    if ($value['calculations']['stickToPlastic']['totalPrice'] > 0 ||
      (isset($value['calculations']['stickToPlastic']['quantity']) && $value['calculations']['stickToPlastic']['quantity'] > 0)) {
      $savePrintOrderItemsData['stick_to_plastic_quantity'] = $value['calculations']['stickToPlastic']['quantity'];
      $savePrintOrderItemsData['stick_to_plastic_total_price'] = $value['calculations']['stickToPlastic']['totalPrice'];
      $savePrintOrderItemsData['stick_to_plastic_hours'] = $value['calculations']['stickToPlastic']['hours'];
    }
    if ($value['calculations']['designPrice']['totalPrice'] > 0 ||
      (isset($value['calculations']['designPrice']['quantity']) && $value['calculations']['designPrice']['quantity'] > 0)) {
      $savePrintOrderItemsData['design_price_total_price'] = $value['calculations']['designPrice']['totalPrice'];
    }

    $savePrintOrderItems = dbInsertData($con, 'print_order_items', $savePrintOrderItemsData);
    $savePrintOrderItemsData = [];
  }

  $updatePrintOrder = dbExecQuery($con, 'UPDATE print_orders SET order_status = ?, stuff_conf = ?, date_injob = ? 
    WHERE id = ?', ['в работе', $_SESSION['user']['name'], date('Y-m-d'), $orderData['id']]);

  if ($savePrintOrderItems && $updatePrintOrder) {
    $updateCalcResultFile = file_put_contents($_SERVER['DOCUMENT_ROOT'] . $orderData['calc_result_file_path'],
      json_encode($calcResultData));
  }

  if ($savePrintOrderItems && $updatePrintOrder && $updateCalcResultFile) {
    mysqli_query($con, 'COMMIT');
    header('Location:' . $config['host'] . '/print.php?alert-massage=статус заказа ' . $orderData['order_name'] . ' изменен на \'в работе\'' . $getParamStr);
  } else {
    mysqli_query($con, 'ROLLBACK');
    header('Location:' . $config['host'] . '/print.php?error-massage=ошибка сервера' . $getParamStr);
  }
  exit();
}


///////////////////////////////////////////////////////////////////////////////////////////
///////////----- ADD -----///////////----- ADD ------///////////
///////////////////////////////////////////////////////////////////////////////////////////


if ($_SERVER['REQUEST_METHOD'] === 'GET' &&
  isset($_GET['print-calc'])) {

  $documentTitle = 'Печать / калькулятор';
  $tmpBasisLayoutData['navigationList']['print']['options']['printCalc']['isActive'] = true;

  $tmpBasisLayoutData['layoutContent'] = '<form class="print-calc-container mb-5 mx-auto" style="max-width: 800px" data-url="' .
    $config['host'] . '/print-calc.php"></form>';

}


///////////////////////////////////////////////////////////////////////////////////////////
///////////----- ORDERS -----///////////----- ORDERS ------///////////
///////////////////////////////////////////////////////////////////////////////////////////


if ($_SERVER['REQUEST_METHOD'] === 'GET' &&
  isset($_GET['orders'])) {

  $documentTitle = 'Печать / все заказы';
  $tmpBasisLayoutData['navigationList']['print']['options']['orders']['isActive'] = true;


  $tmpPrintOrdersData = [
    'config' => $config,
    'orderList' => [],
    'getParamStr' => '&orders&status=' . ($_GET['status'] ?? '') . '&page=' . ($_GET['page'] ?? ''),
    'fieldsData' => [
      'page' => $_GET['page'] ?? '',
      'status' => $_GET['status'] ?? '',
      'search' => $_GET['search'] ?? '',
      'dateRangeFilter' => date('d.m.Y', strtotime('-1 month')) . ' - ' . date('d.m.Y')
    ],
  ];


  $sqlQuerySelect = 'SELECT po.id, po.order_name, po.calc_result_file_path, 
po.client_id, po.total_price, po.square, po.hours, po.order_status, 
po.order_item_ready, po.order_name_privat, 
po.order_item_total, po.promo_codes, po.order_note, po.need_delivery, 
DATE_FORMAT(po.date_notify, \'%d.%m.%Y\') as date_notify, 
DATE_FORMAT(po.date_create, \'%d.%m.%Y\') as date_create, 
DATE_FORMAT(po.date_injob, \'%d.%m.%Y\') as date_injob, 
DATE_FORMAT(po.date_ready, \'%d.%m.%Y\') as date_ready, 
DATE_FORMAT(po.date_issued, \'%d.%m.%Y\') as date_issued, 
DATE_FORMAT(po.date_deleted, \'%d.%m.%Y\') as date_deleted, 
po.stuff_create, po.stuff_conf, cl.name FROM print_orders po ';

  $dateFrom = '\'' . date('Y-m-d', strtotime('-1 month')) . '\'';
  $dateTo = '\'' . date('Y-m-d') . '\'';

  $notReadyOrdersClient = true;

  if (isset($_GET['ready-orders-client'])) {
    $notReadyOrdersClient = false;
    $dateFrom = '\'' . date('Y-m-d', strtotime('-10 year')) . '\'';
    $tmpPrintOrdersData['fieldsData']['dateRangeFilter'] = date('d.m.Y', strtotime('-10 year')) . ' - ' . date('d.m.Y');
  }

  $dateRangeFilterValue = getDateRangeFilterValue($_GET['date-range-filter'] ?? '', 'Y-m-d');

  if ($notReadyOrdersClient && $dateRangeFilterValue) {
    $dateFrom = '\'' . $dateRangeFilterValue['from'] . '\'';
    $dateTo = '\'' . $dateRangeFilterValue['to'] . '\'';
    $tmpPrintOrdersData['fieldsData']['dateRangeFilter'] = $_GET['date-range-filter'];
  }

  $sqlQueryWhere = "WHERE (po.date_create BETWEEN $dateFrom AND $dateTo OR 
po.date_injob BETWEEN $dateFrom AND $dateTo OR 
po.date_ready BETWEEN $dateFrom AND $dateTo OR
po.date_issued BETWEEN $dateFrom AND $dateTo OR
po.date_deleted BETWEEN $dateFrom AND $dateTo) ";

  $sqlParametrs = [];
  $sqlQueryJoin = 'LEFT JOIN clients cl ON po.client_id = cl.id ';
  $sqlSortBy = 'ORDER BY po.id DESC, po.date_create DESC ';

  if ($notReadyOrdersClient === false) {
    $tmpBasisLayoutData['navigationList']['print']['options']['orders']['isActive'] = false;
    $sqlParametrs[0] = $_GET['ready-orders-client'];
    $sqlParametrs[1] = 'выполнен';
    $sqlParametrs[2] = 'в работе';
    $sqlQueryWhere = "WHERE (po.date_injob BETWEEN $dateFrom AND $dateTo OR 
    po.date_ready BETWEEN $dateFrom AND $dateTo) AND 
    po.client_id = ? AND (po.order_status = ? OR po.order_status = ?) ";
  }

  if ($notReadyOrdersClient && isset($_GET['status']) && $_GET['status'] === 'сохранен') {
    $sqlParametrs[0] = 'сохранен';
    $sqlQueryWhere = "WHERE po.date_create BETWEEN $dateFrom AND $dateTo AND po.order_status = ? ";
    $tmpBasisLayoutData['navigationList']['print']['options']['ordersСreate']['isActive'] = true;
    $tmpBasisLayoutData['navigationList']['print']['options']['orders']['isActive'] = false;
    $documentTitle = 'Печать / сохраненные заказы';
  }
  if ($notReadyOrdersClient && isset($_GET['status']) && $_GET['status'] === 'в работе') {
    $sqlParametrs[0] = 'в работе';
    $sqlQueryWhere = "WHERE po.date_injob BETWEEN $dateFrom AND $dateTo AND po.order_status = ? ";
    $sqlSortBy = 'ORDER BY po.id DESC, po.date_injob DESC ';
    $tmpBasisLayoutData['navigationList']['print']['options']['ordersInJob']['isActive'] = true;
    $tmpBasisLayoutData['navigationList']['print']['options']['orders']['isActive'] = false;
    $documentTitle = 'Печать / заказы в работе';
  }
  if ($notReadyOrdersClient && isset($_GET['status']) && $_GET['status'] === 'выполнен') {
    $sqlParametrs[0] = 'выполнен';
    $sqlQueryWhere = "WHERE po.date_ready BETWEEN $dateFrom AND $dateTo AND po.order_status = ? ";
    $sqlSortBy = 'ORDER BY po.id DESC, po.date_ready DESC ';
    $tmpBasisLayoutData['navigationList']['print']['options']['ordersReady']['isActive'] = true;
    $tmpBasisLayoutData['navigationList']['print']['options']['orders']['isActive'] = false;
    $documentTitle = 'Печать / выполненные заказы';
  }
  if ($notReadyOrdersClient && isset($_GET['status']) && $_GET['status'] === 'отгружен') {
    $sqlParametrs[0] = 'отгружен';
    $sqlQueryWhere = "WHERE po.date_issued BETWEEN $dateFrom AND $dateTo AND po.order_status = ? ";
    $sqlSortBy = 'ORDER BY po.id DESC, po.date_issued DESC ';
    $tmpBasisLayoutData['navigationList']['print']['options']['ordersIssued']['isActive'] = true;
    $tmpBasisLayoutData['navigationList']['print']['options']['orders']['isActive'] = false;
    $documentTitle = 'Печать / отгруженные заказы';
  }
  if ($notReadyOrdersClient && isset($_GET['status']) && $_GET['status'] === 'отменен') {
    $sqlParametrs[0] = 'отменен';
    $sqlQueryWhere = "WHERE date_deleted BETWEEN $dateFrom AND $dateTo AND po.order_status = ? ";
    $sqlSortBy = 'ORDER BY po.id DESC, po.date_deleted DESC ';
    $tmpBasisLayoutData['navigationList']['print']['options']['ordersDeleted']['isActive'] = true;
    $tmpBasisLayoutData['navigationList']['print']['options']['orders']['isActive'] = false;
    $documentTitle = 'Печать / отмененные заказы';
  }

  if ($notReadyOrdersClient && isset($_GET['search']) && mb_strlen(trim($_GET['search'])) > 0) {
    $sqlParametrs[1] = '%' . ($_GET['search']) . '%';
    $sqlParametrs[2] = '%' . ($_GET['search']) . '%';
    $sqlQueryWhere = $sqlQueryWhere . 'AND (po.order_name LIKE ? OR cl.name LIKE ?) ';
  }

  $paginationData = getPagination($config, $config['host'] . '/print.php', $con, 'SELECT COUNT(*) as pgn 
    FROM print_orders po ' . $sqlQueryJoin . $sqlQueryWhere, $sqlParametrs);

  $tmpBasisLayoutData['pagination'] = $paginationData['tmpPagination'];
  $sqlPagination = $paginationData['sqlPagination'];

  $tmpPrintOrdersData['orderList'] =
    dbSelectData($con, $sqlQuerySelect . $sqlQueryJoin . $sqlQueryWhere . $sqlSortBy . $sqlPagination, $sqlParametrs);

  $tmpBasisLayoutData['layoutContent'] = renderTemplate('templates/print/tmp-print-orders.php', $tmpPrintOrdersData);

}


///////////////////////////////////////////////////////////////////////////////////////////
///////////----- ORDER ITEMS -----///////////----- ORDERS ITEMS ------///////////
///////////////////////////////////////////////////////////////////////////////////////////


if ($_SERVER['REQUEST_METHOD'] === 'GET' &&
  isset($_GET['orderitems'])) {

  $documentTitle = 'Печать / подробная информация';
  $tmpBasisLayoutData['navigationList']['print']['options']['orderItems']['isActive'] = true;

  $tmpPrintOrderItemsData = [
    'config' => $config,
    'getParamStr' => '&orderitems&status=' . ($_GET['status'] ?? '') . '&page=' . ($_GET['page'] ?? ''),
    'isForSafe' => false,
    'orderItemsList' => [],
    'printTypeList' => $_SESSION['print']['avalaiblePrintType'] ?? [],
    'sum' => [],
    'fieldsData' => [
      'page' => $_GET['page'] ?? '',
      'status' => $_GET['status'] ?? '',
      'printType' => $_GET['print-type'] ?? '',
      'clientSource' => $_GET['client-source'] ?? '',
      'search' => $_GET['search'] ?? '',
      'dateRangeFilter' => date('d.m.Y', strtotime('-1 month')) . ' - ' . date('d.m.Y')
    ],
  ];


  $sqlQuerySelect = 'SELECT poi.id, poi.print_order_id, poi.order_item_index, poi.material_type, poi.print_type,
poi.order_item_status, 
poi.total_total_price, poi.total_total_hours, poi.total_material_cost,
poi.print_quantity, poi.print_total_price, poi.print_hours, 
poi.overspending_quantity, poi.overspending_total_price, poi.overspending_percent, 
poi.optional_work_total_price, poi.optional_work_hours, 
poi.cringle_quantity, poi.cringle_total_price, poi.cringle_hours, 
poi.gain_quantity, poi.gain_total_price, poi.gain_hours, 
poi.cut_quantity, poi.cut_total_price, poi.cut_hours, 
poi.cord_quantity, poi.cord_total_price, poi.cord_hours, 
poi.pocket_quantity, poi.pocket_total_price, poi.pocket_hours, 
poi.coupling_quantity, poi.coupling_total_price, poi.coupling_hours, 
poi.lamination_quantity, poi.lamination_total_price, poi.lamination_hours, 
poi.stick_to_plastic_quantity, poi.stick_to_plastic_total_price, poi.stick_to_plastic_hours, 
poi.design_price_total_price, 
DATE_FORMAT(po.date_create, \'%d.%m.%Y\') as date_create, 
DATE_FORMAT(po.date_injob, \'%d.%m.%Y\') as date_injob, 
DATE_FORMAT(poi.date_ready, \'%d.%m.%Y\') as date_ready, 
DATE_FORMAT(poi.date_issued, \'%d.%m.%Y\') as date_issued, 
DATE_FORMAT(poi.date_deleted, \'%d.%m.%Y\') as date_deleted, 
po.order_name, po.order_name_privat, po.client_id, po.calc_result_file_path, po.stuff_create, po.stuff_conf, 
cl.name 
FROM print_order_items poi ';

  $dateFrom = '\'' . date('Y-m-d', strtotime('-1 month')) . '\'';
  $dateTo = '\'' . date('Y-m-d') . '\'';

  $notOrderItemsOrder = true;

  if (isset($_GET['orderitems-order'])) {
    $notOrderItemsOrder = false;

    $tmpPrintOrderItemsData['getParamStr'] = $tmpPrintOrderItemsData['getParamStr'] . '&orderitems-order=' . $_GET['orderitems-order'];

    $dateFrom = '\'' . date('Y-m-d', strtotime('-10 year')) . '\'';

    $tmpPrintOrderItemsData['fieldsData']['dateRangeFilter'] = date('d.m.Y', strtotime('-10 year')) . ' - ' . date('d.m.Y');
  }

  $dateRangeFilterValue = getDateRangeFilterValue($_GET['date-range-filter'] ?? '', 'Y-m-d');

  if ($notOrderItemsOrder && $dateRangeFilterValue) {
    $dateFrom = '\'' . $dateRangeFilterValue['from'] . '\'';
    $dateTo = '\'' . $dateRangeFilterValue['to'] . '\'';
    $tmpPrintOrderItemsData['fieldsData']['dateRangeFilter'] = $_GET['date-range-filter'];
  }

  $sqlQueryWhere = "WHERE (po.date_create BETWEEN $dateFrom AND $dateTo OR 
po.date_injob BETWEEN $dateFrom AND $dateTo OR 
poi.date_ready BETWEEN $dateFrom AND $dateTo OR
poi.date_issued BETWEEN $dateFrom AND $dateTo OR
poi.date_deleted BETWEEN $dateFrom AND $dateTo) ";

  $sqlParametrs = [];
  $sqlQueryJoin1 = 'LEFT JOIN print_orders po ON poi.print_order_id = po.id ';
  $sqlQueryJoin2 = 'LEFT JOIN clients cl ON po.client_id = cl.id ';
  $sqlSortBy = 'ORDER BY poi.id DESC, po.date_create DESC ';

  if ($notOrderItemsOrder === false) {
    $sqlParametrs[0] = $_GET['orderitems-order'];
    $sqlQueryWhere = $sqlQueryWhere . 'AND poi.print_order_id = ? ';
    $sqlSortBy = 'ORDER BY poi.id DESC ';
  }

  if ($notOrderItemsOrder && isset($_GET['status']) && $_GET['status'] === 'в работе') {
    $sqlParametrs[0] = 'в работе';
    $sqlQueryWhere = "WHERE po.date_injob BETWEEN $dateFrom AND $dateTo AND poi.order_item_status = ? ";
    $sqlSortBy = 'ORDER BY poi.id DESC, po.date_injob DESC ';
  }
  if ($notOrderItemsOrder && isset($_GET['status']) && $_GET['status'] === 'выполнен') {
    $sqlParametrs[0] = 'выполнен';
    $sqlQueryWhere = "WHERE poi.date_ready BETWEEN $dateFrom AND $dateTo AND poi.order_item_status = ? ";
    $sqlSortBy = 'ORDER BY poi.id DESC, poi.date_ready DESC ';
  }
  if ($notOrderItemsOrder && isset($_GET['status']) && $_GET['status'] === 'отгружен') {
    $sqlParametrs[0] = 'отгружен';
    $sqlQueryWhere = "WHERE poi.date_issued BETWEEN $dateFrom AND $dateTo AND poi.order_item_status = ? ";
    $sqlSortBy = 'ORDER BY poi.id DESC, poi.date_issued DESC ';
  }
  if ($notOrderItemsOrder && isset($_GET['status']) && $_GET['status'] === 'отменен') {
    $sqlParametrs[0] = 'отменен';
    $sqlQueryWhere = "WHERE poi.date_deleted BETWEEN $dateFrom AND $dateTo AND poi.order_item_status = ? ";
    $sqlSortBy = 'ORDER BY poi.id DESC, poi.date_deleted DESC ';
  }

//  if ($notOrderItemsOrder && isset($_GET['status']) && $_GET['status'] === 'в работе') {
//    $sqlParametrs[0] = 'отменен';
//    $sqlQueryWhere = "WHERE po.date_injob BETWEEN $dateFrom AND $dateTo AND poi.order_item_status != ? ";
//    $sqlSortBy = 'ORDER BY poi.id DESC, po.date_injob DESC ';
//  }
//  if ($notOrderItemsOrder && isset($_GET['status']) && $_GET['status'] === 'выполнен') {
//    $sqlQueryWhere = "WHERE poi.date_ready BETWEEN $dateFrom AND $dateTo ";
//    $sqlSortBy = 'ORDER BY poi.id DESC, poi.date_ready DESC ';
//  }
//  if ($notOrderItemsOrder && isset($_GET['status']) && $_GET['status'] === 'отгружен') {
//    $sqlQueryWhere = "WHERE poi.date_issued BETWEEN $dateFrom AND $dateTo ";
//    $sqlSortBy = 'ORDER BY poi.id DESC, poi.date_issued DESC ';
//  }
//  if ($notOrderItemsOrder && isset($_GET['status']) && $_GET['status'] === 'отменен') {
//    $sqlQueryWhere = "WHERE poi.date_deleted BETWEEN $dateFrom AND $dateTo ";
//    $sqlSortBy = 'ORDER BY poi.id DESC, poi.date_deleted DESC ';
//  }


  if ($notOrderItemsOrder && isset($_GET['search']) && mb_strlen(trim($_GET['search'])) > 0) {
    $sqlParametrs[1] = '%' . ($_GET['search']) . '%';
    $sqlParametrs[2] = '%' . ($_GET['search']) . '%';
    $sqlQueryWhere = $sqlQueryWhere . 'AND (po.order_name LIKE ? OR cl.name LIKE ?) ';
  }

  if ($notOrderItemsOrder && isset($_GET['print-type']) && $_GET['print-type'] !== 'все') {
    $sqlParametrs[3] = $_GET['print-type'];
    $sqlQueryWhere = $sqlQueryWhere . 'AND poi.print_type = ? ';
  }

  if ($notOrderItemsOrder && isset($_GET['client-source']) && $_GET['client-source'] !== 'все') {
    $sqlParametrs[4] = $_GET['client-source'];
    $sqlQueryWhere = $sqlQueryWhere . 'AND cl.source = ? ';
  }


  $tmpPrintOrderItemsData['sum'] = dbSelectData($con, 'SELECT SUM(poi.total_total_price) as total_total_price,
  ROUND(SUM(poi.total_total_hours), 1) as total_total_hours,
  SUM(poi.total_material_cost) as total_material_cost,
  ROUND(SUM(poi.print_quantity), 1) as print_quantity,
  SUM(poi.print_total_price) as print_total_price,
  ROUND(SUM(poi.print_hours), 1) as print_hours,
  ROUND(SUM(poi.overspending_quantity), 1) as overspending_quantity,
  SUM(poi.overspending_total_price) as overspending_total_price,
  ROUND(AVG(poi.overspending_percent), 1) as overspending_percent, 
  SUM(poi.optional_work_total_price) as optional_work_total_price,
  ROUND(SUM(poi.optional_work_hours), 1) as optional_work_hours,
  SUM(poi.cringle_quantity) as cringle_quantity,
  SUM(poi.cringle_total_price) as cringle_total_price,
  ROUND(SUM(poi.cringle_hours), 1) as cringle_hours,
  ROUND(SUM(poi.gain_quantity), 1) as gain_quantity,
  SUM(poi.gain_total_price) as gain_total_price,
  ROUND(SUM(poi.gain_hours), 1) as gain_hours,
  ROUND(SUM(poi.cut_quantity), 1) as cut_quantity,
  SUM(poi.cut_total_price) as cut_total_price,
  ROUND(SUM(poi.cut_hours), 1) as cut_hours,
  ROUND(SUM(poi.cord_quantity), 1) as cord_quantity,
  SUM(poi.cord_total_price) as cord_total_price,
  ROUND(SUM(poi.cord_hours), 1) as cord_hours,
  ROUND(SUM(poi.pocket_quantity), 1) as pocket_quantity,
  SUM(poi.pocket_total_price) as pocket_total_price,
  ROUND(SUM(poi.pocket_hours), 1) as pocket_hours,
  ROUND(SUM(poi.coupling_quantity), 1) as coupling_quantity,
  SUM(poi.coupling_total_price) as coupling_total_price,
  ROUND(SUM(poi.coupling_hours), 1) as coupling_hours,
  ROUND(SUM(poi.lamination_quantity), 1) as lamination_quantity,
  SUM(poi.lamination_total_price) as lamination_total_price,
  ROUND(SUM(poi.lamination_hours), 1) as lamination_hours,
  ROUND(SUM(poi.stick_to_plastic_quantity), 1) as stick_to_plastic_quantity,
  SUM(poi.stick_to_plastic_total_price) as stick_to_plastic_total_price,
  ROUND(SUM(poi.stick_to_plastic_hours), 1) as stick_to_plastic_hours,
  SUM(poi.design_price_total_price) as design_price_total_price
  FROM print_order_items poi ' . $sqlQueryJoin1 . $sqlQueryJoin2 . $sqlQueryWhere, $sqlParametrs)[0];


  $paginationData = getPagination($config, $config['host'] . '/print.php', $con, 'SELECT COUNT(*) as pgn 
    FROM print_order_items poi ' . $sqlQueryJoin1 . $sqlQueryJoin2 . $sqlQueryWhere, $sqlParametrs);

  $tmpBasisLayoutData['pagination'] = $paginationData['tmpPagination'];
  $sqlPagination = $paginationData['sqlPagination'];

  $tmpPrintOrderItemsData['orderItemsList'] = dbSelectData($con, $sqlQuerySelect .
    $sqlQueryJoin1 . $sqlQueryJoin2 . $sqlQueryWhere . $sqlSortBy . $sqlPagination, $sqlParametrs);

  $tmpBasisLayoutData['layoutContent'] = renderTemplate('templates/print/tmp-print-order-items.php', $tmpPrintOrderItemsData);
  //header('Content-Type: application/vnd.ms-excel');
  //file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/tmp/asd.xls', renderTemplate('templates/print/tmp-print-order-items.php', $tmpPrintOrderItemsData));
}


///////////////////////////////////////////////////////////////////////////////////////////
///////////----- MAIN -----///////////----- MAIN ------///////////
///////////////////////////////////////////////////////////////////////////////////////////


if ($tmpBasisLayoutData['layoutContent'] === false) {

  $documentTitle = 'Печать / основная информация';

  $tmpBasisLayoutData['navigationList']['print']['options']['main']['isActive'] = true;

  $tmpPrintMainData = [
    'config' => $config,
    'ordersInJobData' => false,
  ];

  $tmpPrintMainData['ordersInJobData']['print_type'] = dbSelectData($con, 'SELECT poi.print_type, ROUND(SUM(poi.print_hours), 1) AS print_hours
FROM print_order_items poi 
LEFT JOIN print_orders po ON poi.print_order_id = po.id 
WHERE poi.order_item_status = \'в работе\' 
AND po.date_injob BETWEEN CURDATE() - INTERVAL 1 MONTH AND CURDATE() 
GROUP BY poi.print_type', []);

  $tmpPrintMainData['ordersInJobData']['total'] = dbSelectData($con, 'SELECT ROUND(SUM(poi.print_hours), 1) AS print_hours,
ROUND(SUM(poi.optional_work_hours), 1) AS optional_work_hours,
ROUND(SUM(poi.total_total_hours), 1) AS total_total_hours
FROM print_order_items poi 
LEFT JOIN print_orders po ON poi.print_order_id = po.id 
WHERE poi.order_item_status = \'в работе\' 
AND po.date_injob BETWEEN CURDATE() - INTERVAL 1 MONTH AND CURDATE()', [])[0];

  $tmpBasisLayoutData['layoutContent'] = renderTemplate('templates/print/tmp-print-main.php', $tmpPrintMainData);

}


///////////////////////////////////////////////////////////////////////////////////////////
///////////----- REDNER BASIS TMP -----///////////----- REDNER BASIS TMP ------///////////
///////////////////////////////////////////////////////////////////////////////////////////


$tmpsSriptsData = [
  'printCalc' => true,
  'yaMetrika' => true
];


$tmpBasisData = [
  'title' => $documentTitle,
  'bodyContent' => renderTemplate($_SERVER['DOCUMENT_ROOT'] . '/templates/tmp-basis-layout.php', $tmpBasisLayoutData),
  'noFlex' => false,
  'scripts' => renderTemplate($_SERVER['DOCUMENT_ROOT'] . '/templates/tmp-basis-scripts.php', $tmpsSriptsData)
];

print(renderTemplate($_SERVER['DOCUMENT_ROOT'] . '/templates/tmp-basis.php', $tmpBasisData));
