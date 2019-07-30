<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/src/src-session-start.php');

if (isset($_SESSION['user']) === false) {
  http_response_code(401);
  header('Location:' . $config['host'] . '/login.php');
  exit();
}

require_once($_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php');

///////////////////////////////////////////////////////////////////////////////////////////
///////////----- PRINT ORDER INFO -----///////////----- PRINT ORDER INFO ------///////////
///////////////////////////////////////////////////////////////////////////////////////////

if ($_SERVER['REQUEST_METHOD'] === 'GET' &&
  isset($_GET['notify']) &&
  $_GET['notify'] === 'print-order-info' &&
  isset($_GET['order'])) {

  $tmpPrintOrderInfoData = [
    'config' => $config,
    'getParamStr' => '&orders&status=' . ($_GET['status'] ?? '') . '&page=' . ($_GET['page'] ?? ''),
    'massage' => false,
    'orderData' => true,
    'calcResultData' => false,
    'user' => $_SESSION['user']['tel']
  ];

  $tmpPrintOrderInfoData['orderData'] = dbSelectData($con, 'SELECT 
po.id, po.calc_result_file_path, po.client_id, po.order_name, po.order_name_privat, po.total_price,
cl.name, cl.email, cl.last_notify_date FROM print_orders po 
LEFT JOIN clients cl ON po.client_id = cl.id 
WHERE po.id = ?', [$_GET['order']])[0] ?? false;

  if (!$tmpPrintOrderInfoData['orderData']) {
    header('Location:' . $config['host'] . '/print.php?error-massage=нет данных' . $tmpPrintOrderInfoData['getParamStr']);
    exit();
  }

  $tmpPrintOrderInfoData['calcResultData'] =
    json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . $tmpPrintOrderInfoData['orderData']['calc_result_file_path']), true);

  if (isset($tmpPrintOrderInfoData['calcResultData']) === false) {
    header('Location:' . $config['host'] . '/print.php?error-massage=нет данных' . $tmpPrintOrderInfoData['getParamStr']);
    exit();
  }

  mysqli_query($con, 'START TRANSACTION');

  if ($tmpPrintOrderInfoData['orderData']['last_notify_date'] != date('Y-m-d')) {

    $tmpPrintOrderInfoData['massage'] = 'Здравствуйте';

    dbExecQuery($con, 'UPDATE clients SET last_notify_date = ? WHERE id = ?',
      [date('Y-m-d'), $tmpPrintOrderInfoData['orderData']['client_id']]);
  }

  dbExecQuery($con, 'UPDATE print_orders SET date_notify = ? WHERE id = ?',
    [date('Y-m-d'), $tmpPrintOrderInfoData['orderData']['id']]);


  $printDetails = renderTemplate(
    $_SERVER['DOCUMENT_ROOT'] . '/templates/notify/tmp-print-order-info.php', $tmpPrintOrderInfoData);

  $sendEmail =
    send_email($config,
      $tmpPrintOrderInfoData['orderData']['email'],
      'Заказ ' . $tmpPrintOrderInfoData['orderData']['order_name'],
      $printDetails);

  if ($sendEmail) {
    mysqli_query($con, 'COMMIT');
    header('Location:' . $config['host'] . '/print.php?alert-massage=отправлено' . $tmpPrintOrderInfoData['getParamStr']);
    exit();
  } else {
    mysqli_query($con, 'ROLLBACK');
    header('Location:' . $config['host'] . '/print.php?error-massage=ошибка отправки' . $tmpPrintOrderInfoData['getParamStr']);
    exit();
  }
}
