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

$tmpBasisLayoutData['navigationList']['cash']['isActive'] = true;
$documentTitle = 'Касса';


if (isset($_GET['error-massage'])) {
  $tmpBasisLayoutData['errorMassage'] = $_GET['error-massage'];
}
if (isset($_GET['alert-massage'])) {
  $tmpBasisLayoutData['alertMassage'] = $_GET['alert-massage'];
}


///////////////////////////////////////////////////////////////////////////////////////////
///////////----- CASH LIST -----///////////----- CASH LIST ------///////////
///////////////////////////////////////////////////////////////////////////////////////////


if ($_SERVER['REQUEST_METHOD'] === 'GET' &&
  isset($_GET['action']) && $_GET['action'] === 'show-list') {

  $tmpBasisLayoutData['navigationList']['cash']['options']['list']['isActive'] = true;
  $documentTitle = 'Касса / записи';

  $tmpCashListData = [
    'config' => $config,
    'cashList' => [],
    'fieldsData' => [
      'operationType' => $_GET['operation-type'] ?? '',
      'paymentPurpose' => $_GET['payment-purpose'] ?? '',
      'paymentType' => $_GET['payment-type'] ?? '',
      'dateRangeFilter' => date('d.m.Y', strtotime('-1 month')) . ' - ' . date('d.m.Y')
    ],
    'sum' => []
  ];

  $sqlQuerySelect = 'SELECT cs.id, cs.deb, cs.cred, cs.payment_purpose, cs.payment_type, cs.payment_note, 
DATE_FORMAT(cs.payment_date, \'%d.%m.%Y\') as payment_date, 
cs.order_id, cs.client_id, cs.stuff, cs.is_deleted, cl.name FROM cash cs ';

  $sqlQueryJoin = 'LEFT JOIN clients cl ON cs.client_id = cl.id ';
  $sqlQueryWhere = 'WHERE cs.payment_date BETWEEN ? AND ? ';

  $sqlParametrs = [
    date('Y-m-d', strtotime('-1 month')),
    date('Y-m-d'),
  ];

  if (isset($_GET['date-range-filter']) &&
    $dateRangeFilterValue = getDateRangeFilterValue($_GET['date-range-filter'] ?? '', 'Y-m-d')) {
    $sqlParametrs[0] = $dateRangeFilterValue['from'];
    $sqlParametrs[1] = $dateRangeFilterValue['to'];
    $tmpCashListData['fieldsData']['dateRangeFilter'] = $_GET['date-range-filter'];
  }

  if (isset($_GET['operation-type']) && $_GET['operation-type'] === 'приход') {
    $sqlQueryWhere = $sqlQueryWhere . 'AND cs.deb > 0 ';
  }

  if (isset($_GET['operation-type']) && $_GET['operation-type'] === 'расход') {
    $sqlQueryWhere = $sqlQueryWhere . 'AND cs.cred > 0 ';
  }

  if (isset($_GET['payment-purpose']) && $_GET['payment-purpose'] !== 'все') {
    $sqlParametrs[3] = $_GET['payment-purpose'];
    $sqlQueryWhere = $sqlQueryWhere . 'AND cs.payment_purpose = ? ';
  }

  if (isset($_GET['payment-type']) && $_GET['payment-type'] !== 'все') {
    $sqlParametrs[4] = $_GET['payment-type'];
    $sqlQueryWhere = $sqlQueryWhere . 'AND cs.payment_type = ? ';
  }

  $tmpCashListData['sum'] =
    dbSelectData($con, 'SELECT SUM(deb) as deb, SUM(cred) as cred FROM cash cs ' . $sqlQueryWhere . 'AND cs.is_deleted IS NULL ', $sqlParametrs)[0];

  $sqlSortBy = 'ORDER BY cs.id DESC ';

  $paginationData =
    getPagination($config, $config['host'] . '/cash.php', $con, 'SELECT COUNT(*) as pgn FROM cash cs ' .
      $sqlQueryWhere, $sqlParametrs);

  $tmpBasisLayoutData['pagination'] = $paginationData['tmpPagination'];
  $sqlPagination = $paginationData['sqlPagination'];

  $tmpCashListData['cashList'] =
    dbSelectData($con, $sqlQuerySelect . $sqlQueryJoin . $sqlQueryWhere . $sqlSortBy . $sqlPagination, $sqlParametrs);

  $tmpBasisLayoutData['layoutContent'] = renderTemplate('templates/cash/tmp-cash-list.php', $tmpCashListData);
}


///////////////////////////////////////////////////////////////////////////////////////////
///////////----- ADD CASH -----///////////----- ADD CASH ------///////////      
///////////////////////////////////////////////////////////////////////////////////////////


if ($_SERVER['REQUEST_METHOD'] === 'GET' &&
  isset($_GET['action']) && $_GET['action'] === 'add-cash') {

  $tmpBasisLayoutData['navigationList']['cash']['options']['add']['isActive'] = true;
  $documentTitle = 'Касса / внести запись';

  $operationId = hash('md5', rand());

  $addCashValidationData = [
    'operation-id' => [
      'minValueLingth' => 3,
      'valueIs' => $_SESSION['cash']['operationId'] ?? ''
    ],
    'operation-type' => [
      'minValueLingth' => 1,
      'valueIs' => false
    ],
    'payment-purpose' => [
      'minValueLingth' => 2,
      'valueIs' => inArray2step($_GET['payment-purpose'] ?? 'none', $config['paymentsPurpose'])
    ],
    'amount' => [
      'minValueLingth' => 1,
      'valueIs' => false
    ],
    'payment-type' => [
      'minValueLingth' => 2,
      'valueIs' => inArray1step($_GET['payment-type'] ?? 'none', $config['paymentsType'])
    ]
  ];

  $addCashIsValid = validateGetParam($addCashValidationData);

  if (isset($_GET['amount']) && $addCashIsValid) {

    $addCashData = [
      'payment_date' => date('Y-m-d'),
      'payment_purpose' => $_GET['payment-purpose'],
      'payment_type' => $_GET['payment-type'],
      'payment_note' => trim(htmlspecialchars(strip_tags(mb_strtolower($_GET['payment-note'] ?? '')))),
      'stuff' => $_SESSION['user']['name']
    ];

    $updateCashBalanceData = [
      'deb' => false,
      'cred' => false
    ];

    if (isset($_GET['operation-type']) && $_GET['operation-type'] === 'deb') {
      $addCashData['deb'] = (int)$_GET['amount'];
      $updateCashBalanceData['deb'] = (int)$_GET['amount'];
    }
    if (isset($_GET['operation-type']) && $_GET['operation-type'] === 'cred') {
      $addCashData['cred'] = (int)$_GET['amount'];
      $updateCashBalanceData['cred'] = (int)$_GET['amount'];
    }

    mysqli_query($con, 'START TRANSACTION');

    $addCash = dbInsertData($con, 'cash', $addCashData);
    $updateCashBalance =
      updateCashBalance($con, $_GET['payment-type'], $updateCashBalanceData['deb'], $updateCashBalanceData['cred']);

    if ($addCash && $updateCashBalance) {
      mysqli_query($con, 'COMMIT');
      $tmpBasisLayoutData['alertMassage'] = 'платежная операция сохранена';
    } else {
      mysqli_query($con, 'ROLLBACK');
      $tmpBasisLayoutData['errorMassage'] = 'ошибка';
    }
  } else if (isset($_GET['amount']) && $addCashIsValid === false) {
    $tmpBasisLayoutData['errorMassage'] = 'ошибка входных данных';
  }

  $_SESSION['cash']['operationId'] = $operationId;

  $tmpAddCashData = [
    'config' => $config,
    'operationId' => $operationId,
  ];

  $tmpBasisLayoutData['layoutContent'] = renderTemplate('templates/cash/tmp-cash-add-cash.php', $tmpAddCashData);
}


///////////////////////////////////////////////////////////////////////////////////////////
///////////----- CANCEL CASH ITEM -----///////////----- CANCEL CASH ITEM ------///////////
///////////////////////////////////////////////////////////////////////////////////////////


if ($_SERVER['REQUEST_METHOD'] === 'GET' &&
  isset($_GET['action']) && $_GET['action'] === 'cancel-cash-item'
  && isset($_GET['id'])) {

  // есть ли такая запись
  // сделал ли эту запись тот же человек
  // когда сделана запись
  // не автоматическая ли запись
  // если запись привязанна к клиенту то проверить не автоматическая ли она


  // если все ок то

  // пометить запись как отмененную
  // обновить баланс по этой валюте

  // если запись привязанна к клиенту то
  // в таблице клиента пометить запись как удаленную
  // обновить баланс клиента
  
  $cancelCashItemData = [
    'cashItemData' => dbSelectData($con, 'SELECT * FROM cash WHERE id = ?', [$_GET['id']])[0] ?? false,
    'clientsPaymentsItemData' => false,
    'setCashIsDeleted' => false,
    'updateCashBalance' => false,
    'setClientsPaymentsIsDeleted' => true,
    'updateClientBalance' => true
  ];

  if ($cancelCashItemData['cashItemData'] === false) {
    header('Location:' . $config['host'] . '/cash.php?action=show-list&' . 'error-massage=нет данных');
    exit();
  }

  if (isset($cancelCashItemData['cashItemData']['stuff']) && $cancelCashItemData['cashItemData']['stuff'] !== $_SESSION['user']['name']) {
    header('Location:' . $config['host'] . '/cash.php?action=show-list&' . 'error-massage=запись может отменить только тот пользователь, кто ее создал');
    exit();
  }

  if (time() - strtotime($cancelCashItemData['cashItemData']['payment_date']) > $config['daysForCancelItem'] * 24 * 60 * 60) {
    header('Location:' . $config['host'] . '/cash.php?action=show-list&' . 'error-massage=запись нельзя отменить более чем через ' . $config['daysForCancelItem'] . ' дня');
    exit();
  }

  if ($cancelCashItemData['cashItemData']['clients_payments_id']) {
    $cancelCashItemData['clientsPaymentsItemData'] =
      dbSelectData($con, 'SELECT * FROM clients_payments WHERE id = ?', [$cancelCashItemData['cashItemData']['clients_payments_id']])[0] ?? false;
  }

  if ($cancelCashItemData['cashItemData']['is_auto_create'] === 1 || $cancelCashItemData['clientsPaymentsItemData']['is_auto_create'] === 1) {
    header('Location:' . $config['host'] . '/cash.php?action=show-list&' . 'error-massage=нельзя отменить автоматически созданную запись');
    exit();
  }

  mysqli_query($con, 'START TRANSACTION');

  $cancelCashItemData['setCashIsDeleted'] =
    dbExecQuery($con, 'UPDATE cash SET is_deleted = 1 WHERE id = ?', [$cancelCashItemData['cashItemData']['id']]);

  $cancelCashItemData['updateCashBalance'] =
    updateCashBalanceDelet($con, $cancelCashItemData['cashItemData']['payment_type'],
      $cancelCashItemData['cashItemData']['deb'],
      $cancelCashItemData['cashItemData']['cred']);

  if ($cancelCashItemData['cashItemData']['clients_payments_id']) {

    $cancelCashItemData['setClientsPaymentsIsDeleted'] =
      dbExecQuery($con, 'UPDATE clients_payments SET is_deleted = 1 WHERE id = ?', [$cancelCashItemData['clientsPaymentsItemData']['id']]);

    $cancelCashItemData['updateClientBalance'] =
      updateClientBalanceDelet($con, $cancelCashItemData['clientsPaymentsItemData']['client_id'],
        $cancelCashItemData['cashItemData']['deb'],
        $cancelCashItemData['cashItemData']['cred']);

  }

  if ($cancelCashItemData['setCashIsDeleted'] && $cancelCashItemData['updateCashBalance'] &&
    $cancelCashItemData['setClientsPaymentsIsDeleted'] && $cancelCashItemData['updateClientBalance']) {
    mysqli_query($con, 'COMMIT');
    header('Location:' . $config['host'] . '/cash.php?action=show-list&' . 'alert-massage=запись ' . $cancelCashItemData['cashItemData']['id'] . ' отменена');
    exit();
  }
  else {
    mysqli_query($con, 'ROLLBACK');
    header('Location:' . $config['host'] . '/cash.php?action=show-list&' . 'error-massage=ошибка');
    exit();
  }

}

///////////////////////////////////////////////////////////////////////////////////////////
///////////----- MAIN -----///////////----- MAIN ------///////////      
///////////////////////////////////////////////////////////////////////////////////////////


if ($tmpBasisLayoutData['layoutContent'] === false) {

  $documentTitle = 'Касса / основная информация';

  $tmpBasisLayoutData['navigationList']['cash']['options']['main']['isActive'] = true;

  $tmpCashMainData = [
    'config' => $config,
    'cashList' => dbSelectData($con, 'SELECT * FROM cash_remainder ORDER BY balance DESC', [])
  ];

  $tmpBasisLayoutData['layoutContent'] = renderTemplate('templates/cash/tmp-cash-main.php', $tmpCashMainData);
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
