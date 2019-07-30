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

$tmpBasisLayoutData['navigationList']['requests']['isActive'] = true;
$documentTitle = 'Заявки';


if (isset($_GET['error-massage'])) {
  $tmpBasisLayoutData['errorMassage'] = $_GET['error-massage'];
}
if (isset($_GET['alert-massage'])) {
  $tmpBasisLayoutData['alertMassage'] = $_GET['alert-massage'];
}


///////////////////////////////////////////////////////////////////////////////////////////
///////////----- SHOW LIST -----///////////----- SHOW LIST ------///////////
///////////////////////////////////////////////////////////////////////////////////////////


if ($_SERVER['REQUEST_METHOD'] === 'GET' &&
  isset($_GET['action']) && $_GET['action'] === 'show-list' &&
  isset($_GET['list']) && $_GET['list'] === 'text') {

  $documentTitle = 'Заявки';

  $tmpRequestListTextData = [
    'config' => $config,
    'requestList' => [],
    'getParamStr' => '&status=' . ($_GET['status'] ?? '') . '&page=' . ($_GET['page'] ?? '')
  ];

  if (isset($_GET['status']) && $_GET['status'] === 'все') {
    $documentTitle = 'Заявки / все';
    $tmpBasisLayoutData['navigationList']['requests']['options']['listTextAll']['isActive'] = true;
  }

  if (isset($_GET['status']) && $_GET['status'] === 'новый') {
    $documentTitle = 'Заявки / новые';
    $tmpBasisLayoutData['navigationList']['requests']['options']['listTextNew']['isActive'] = true;
  }
  if (isset($_GET['status']) && $_GET['status'] === 'закрыт') {
    $documentTitle = 'Заявки / закрытые';
    $tmpBasisLayoutData['navigationList']['requests']['options']['listTextClosed']['isActive'] = true;
  }


  $sqlQuerySelect = 'SELECT DATE_FORMAT(date_create, \'%d.%m.%Y\') as date_create, 
  DATE_FORMAT(date_closed, \'%d.%m.%Y\') as date_closed, id, request_origin, request_name, request_contact, 
  request_type, request_body, request_status, stuff_request_closed FROM requests_text ';
  $sqlQueryWhere = ' ';
  $sqlParametrs = [];

  $sqlSortBy = 'ORDER BY id DESC ';

  if (isset($_GET['status']) && $_GET['status'] !== 'все') {
    $sqlQueryWhere = 'WHERE request_status = ? AND date_create BETWEEN CURDATE() - INTERVAL 1 MONTH AND CURDATE() ';
    $sqlParametrs[0] = $_GET['status'];
  }


  $paginationData =
    getPagination($config, $config['host'] . '/requests.php', $con, 'SELECT COUNT(id) as pgn FROM requests_text ' .
      $sqlQueryWhere, $sqlParametrs);

  $tmpBasisLayoutData['pagination'] = $paginationData['tmpPagination'];
  $sqlPagination = $paginationData['sqlPagination'];

  $tmpRequestListTextData['requestList'] =
    dbSelectData($con, $sqlQuerySelect . $sqlQueryWhere . $sqlSortBy . $sqlPagination, $sqlParametrs);


  $tmpBasisLayoutData['layoutContent'] = renderTemplate('templates/requests/tmp-requests-list-text.php', $tmpRequestListTextData);


}


///////////////////////////////////////////////////////////////////////////////////////////
///////////----- SHOW CARD -----///////////----- SHOW CARD ------///////////
///////////////////////////////////////////////////////////////////////////////////////////


$isShowCard = ($_SERVER['REQUEST_METHOD'] === 'GET' &&
  isset($_GET['action']) && $_GET['action'] === 'show-card' &&
  isset($_GET['list']) && $_GET['list'] === 'text' &&
  isset($_GET['id']));

if ($isShowCard &&
  $requestDataShow = (dbSelectData($con, 'SELECT DATE_FORMAT(date_create, \'%d.%m.%Y\') as date_create, 
  DATE_FORMAT(date_closed, \'%d.%m.%Y\') as date_closed, id, request_origin, request_name, request_contact, 
  request_type, request_body, request_status, stuff_request_closed FROM requests_text WHERE id = ?', [$_GET['id']])[0] ?? false)) {

  $documentTitle = 'Заявки / текстовый запрос';

  $tmpRequestCardTextData = [
    'config' => $config,
    'requestCard' => $requestDataShow,
    'getParamStr' => '&status=' . ($_GET['status'] ?? '') . '&page=' . ($_GET['page'] ?? '')
  ];

  $tmpBasisLayoutData['layoutContent'] = renderTemplate('templates/requests/tmp-requests-show-card-text.php', $tmpRequestCardTextData);

}
else if ($isShowCard &&
  $requestDataShow === false) {

  $tmpBasisLayoutData['errorMassage'] = 'нет данных';
  $documentTitle = 'Нет данных';
  http_response_code(404);
}



///////////////////////////////////////////////////////////////////////////////////////////
///////////----- CHANGE STATUS ЗАКРЫТ -----///////////----- CHANGE STATUS ЗАКРЫТ ------///////////
///////////////////////////////////////////////////////////////////////////////////////////

$isChangeStatus = ($_SERVER['REQUEST_METHOD'] === 'GET' &&
  isset($_GET['action']) && $_GET['action'] === 'change-status' &&
  isset($_GET['new-status']) && $_GET['new-status'] === 'закрыт' &&
  isset($_GET['list']) && $_GET['list'] === 'text' &&
  isset($_GET['id']));


if ($isChangeStatus &&
  $requestDataChange = (dbSelectData($con, 'SELECT id, request_status FROM requests_text WHERE id = ?', [$_GET['id']])[0] ?? false)) {

  $changeStatus = [
    'getParamStr' => '&status=' . ($_GET['status'] ?? '') . '&page=' . ($_GET['page'] ?? ''),
    'updateStatus' => false
  ];

  if ($requestDataChange['request_status'] !== 'новый') {
    header('Location:' . $config['host'] . '/requests.php?action=show-list&list=text&error-massage=пометить как закрытый можно только новый запрос' . $changeStatus['getParamStr']);
    exit();
  }

  $changeStatus['updateStatus'] =
    dbExecQuery($con, 'UPDATE requests_text SET request_status = ?, date_closed = ?, stuff_request_closed = ? 
      WHERE id = ?', ['закрыт', date('Y-m-d'), $_SESSION['user']['name'], $_GET['id']]);

  if ($changeStatus['updateStatus']) {
    header('Location:' . $config['host'] . '/requests.php?action=show-list&list=text&alert-massage=статус изменен на \'закрыт\'' . $changeStatus['getParamStr']);
    exit();
  } else {
    header('Location:' . $config['host'] . '/requests.php?action=show-list&list=text&error-massage=ошибка' . $changeStatus['getParamStr']);
    exit();
  }

}
else if ($isChangeStatus &&
  $requestDataChange === false) {

  $tmpBasisLayoutData['errorMassage'] = 'нет данных';
  $documentTitle = 'Нет данных';
  http_response_code(404);
}



///////////////////////////////////////////////////////////////////////////////////////////
///////////----- REDNER BASIS TMP -----///////////----- REDNER BASIS TMP ------///////////
///////////////////////////////////////////////////////////////////////////////////////////

$tmpsSriptsData = [
  'printCalc' => false,
  'yaMetrika' => true
];

$tmpBasisData = [
  'title' => $documentTitle,
  'bodyContent' => renderTemplate($_SERVER['DOCUMENT_ROOT'] . '/templates/tmp-basis-layout.php', $tmpBasisLayoutData),
  'noFlex' => false,
  'scripts' => renderTemplate($_SERVER['DOCUMENT_ROOT'] . '/templates/tmp-basis-scripts.php', $tmpsSriptsData)
];

print(renderTemplate($_SERVER['DOCUMENT_ROOT'] . '/templates/tmp-basis.php', $tmpBasisData));

