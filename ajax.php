<?php


require_once($_SERVER['DOCUMENT_ROOT'] . '/src/src-session-start.php');

require_once($_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php');


if ($_SERVER['REQUEST_METHOD'] === 'POST' &&
  isset($_POST['action']) && $_POST['action'] === 'request-text-save' &&
  isset($_POST['request-name']) &&
  isset($_POST['request-contact']) &&
  isset($_POST['request-type']) &&
  isset($_POST['request-body'])) {

  $response = [
    'operation-status' => 'false',
    'response-massage' => 'ошибка'
  ];


  $newRequestTextData = [
    'request_origin' => str_replace('http://', '', $_SERVER['HTTP_ORIGIN']),
    'request_name' => cutStr(trim(htmlspecialchars(strip_tags($_POST['request-name'] ?? ''))), 35),
    'request_contact' => cutStr(trim(htmlspecialchars(strip_tags($_POST['request-contact'] ?? ''))), 240),
    'request_type' => cutStr(trim(htmlspecialchars(strip_tags($_POST['request-type'] ?? ''))), 95),
    'request_body' => cutStr(trim(htmlspecialchars(strip_tags($_POST['request-body'] ?? ''))), 240),
    'request_status' => 'новый',
    'date_create' => date('Y-m-d')
  ];

  $newRequestText = dbInsertData($con, 'requests_text', $newRequestTextData);

  if ($newRequestText) {
    $response['operation-status'] = 'true';
    $response['response-massage'] = 'запрос сохранен, в ближайшее время с вами свяжется наш менеджер';
  }

  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  print json_encode($response);

}