<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/src/src-session-start.php');

require_once($_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php');

$documentTitle = 'Сатус заказа';

$tmpOrderInfoData = [
  'alertMassage' => false,
  'errorMassage' => false,
  'content' => false
];

if (isset($_GET['error-massage'])) {
  $tmpOrderInfoData['errorMassage'] = $_GET['error-massage'];
}

if (!$tmpOrderInfoData['errorMassage'] &&
  $_SERVER['REQUEST_METHOD'] === 'GET' &&
  isset($_GET['print-order-info']) &&
  isset($_GET['order'])) {

  $tmpPrintOrderInfoData = [
    'config' => $config,
    'orderData' => true,
    'calcResultData' => false
  ];

  $tmpPrintOrderInfoData['orderData'] = dbSelectData($con, 'SELECT 
po.id, po.calc_result_file_path, po.order_name, po.order_status, po.total_price, po.client_id, cl.name, cl.email 
FROM print_orders po LEFT JOIN clients cl ON po.client_id = cl.id 
WHERE po.order_name_privat = ?', [$_GET['order']])[0] ?? false;

  if (!$tmpPrintOrderInfoData['orderData']) {
    header('Location:' . $config['host'] . '/order-info.php?error-massage=нет данных о заказе');
    exit();
  }

  $tmpPrintOrderInfoData['calcResultData'] = json_decode(
    file_get_contents($_SERVER['DOCUMENT_ROOT'] .
      $tmpPrintOrderInfoData['orderData']['calc_result_file_path']), true);

  if (isset($tmpPrintOrderInfoData['calcResultData']) === false) {
    header('Location:' . $config['host'] . '/order-info.php?error-massage=нет данных о заказе');
    exit();
  }

  $documentTitle = 'Заказ ' . $tmpPrintOrderInfoData['orderData']['order_name'];

  $tmpOrderInfoData['content'] = renderTemplate(
    $_SERVER['DOCUMENT_ROOT'] . '/templates/order-info/tmp-print-order-info.php', $tmpPrintOrderInfoData);

}

$tmpsSriptsData = [
  'printCalc' => false,
  'yaMetrika' => true
];

$tmpBasisData = [
  'title' => $documentTitle,
  'bodyContent' => renderTemplate($_SERVER['DOCUMENT_ROOT'] . '/templates/order-info/tmp-order-info.php', $tmpOrderInfoData),
  'noFlex' => false,
  'scripts' => renderTemplate($_SERVER['DOCUMENT_ROOT'] . '/templates/tmp-basis-scripts.php', $tmpsSriptsData)
];

print(renderTemplate($_SERVER['DOCUMENT_ROOT'] . '/templates/tmp-basis.php', $tmpBasisData));
