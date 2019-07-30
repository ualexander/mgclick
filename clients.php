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

$tmpBasisLayoutData['navigationList']['clients']['isActive'] = true;
$documentTitle = 'Клиенты';


if (isset($_GET['error-massage'])) {
  $tmpBasisLayoutData['errorMassage'] = $_GET['error-massage'];
}
if (isset($_GET['alert-massage'])) {
  $tmpBasisLayoutData['alertMassage'] = $_GET['alert-massage'];
}


///////////////////////////////////////////////////////////////////////////////////////////
///////////----- ADD CLIENT CARD ------///////////----- ADD CLIENT CARD ------///////////      
///////////////////////////////////////////////////////////////////////////////////////////

if ($_SERVER['REQUEST_METHOD'] === 'GET' &&
  isset($_GET['action']) && $_GET['action'] === 'add-card') {

  $tmpBasisLayoutData['navigationList']['clients']['options']['add']['isActive'] = true;
  $documentTitle = 'Клиенты / добавить';

  $tmpClientFormData = [
    'config' => $config,
    'fieldsData' => [
      'name' => $_GET['name'] ?? '',
      'email' => $_GET['email'] ?? '',
      'firstTel' => $_GET['first-tel'] ?? '',
      'secondTel' => $_GET['second-tel'] ?? '',
      'address' => $_GET['address'] ?? '',
      'note' => $_GET['note'] ?? ''
    ],
    'isAddCard' => true,
    'isEditCard' => false
  ];

  $addValidationData = [
    'client-source' => [
      'minValueLingth' => 2,
      'valueIs' => inArray1step($_GET['client-source'] ?? 'none', $config['clientSource'])
    ],
    'name' => [
      'minValueLingth' => 5,
      'valueIs' => false
    ],
    'email' => [
      'minValueLingth' => 6,
      'valueIs' => false
    ],
    'first-tel' => [
      'minValueLingth' => 9,
      'valueIs' => false
    ]
  ];

  $addIsValid = validateGetParam($addValidationData);
  $emailIsValid = filter_var($_GET['email'] ?? '', FILTER_VALIDATE_EMAIL);

  if (isset($_GET['name']) && $addIsValid && $emailIsValid) {

    $newClientData = [
      'source' => trim(htmlspecialchars(strip_tags($_GET['client-source']))),
      'name' => trim(htmlspecialchars(strip_tags(mb_strtoupper($_GET['name'])))),
      'email' => trim(htmlspecialchars(strip_tags(mb_strtolower($_GET['email'])))),
      'first_tel' => trim(htmlspecialchars(strip_tags($_GET['first-tel']))),
      'second_tel' => trim(htmlspecialchars(strip_tags($_GET['second-tel'] ?? ''))),
      'address' => trim(htmlspecialchars(strip_tags($_GET['address'] ?? ''))),
      'note' => cutStr(trim(htmlspecialchars(strip_tags($_GET['note'] ?? ''))), 240),
      'balance' => 0,
      'deb' => 0,
      'cred' => 0,
      'reg_date' => date('Y-m-d'),
      'orders_count' => 0,
      'stuff' => $_SESSION['user']['name'] ?? '',
    ];

    $newClient = dbInsertData($con, 'clients', $newClientData);

    if ($newClient) {
      header('Location:' . $config['host'] . '/clients.php?alert-massage=карта клиента сохранена&action=show-card&id=' .
        $newClient);
    } else {
      if (dbSelectData($con, 'SELECT * FROM clients WHERE name = ?', [$newClientData['name']])[0] ?? false) {
        $tmpBasisLayoutData['errorMassage'] = 'клиент с таким именем уже существует';
      } else if (dbSelectData($con, 'SELECT * FROM clients WHERE email = ?', [$newClientData['email']])[0] ?? false) {
        $tmpBasisLayoutData['errorMassage'] = 'клиент с таким email уже существует';
      } else {
        $tmpBasisLayoutData['errorMassage'] = 'ошибка сохранения';
      }
    }
  } else if (isset($_GET['name']) && $addIsValid === false) {
    $tmpBasisLayoutData['errorMassage'] = 'ошибка входных данных';
  } else if (isset($_GET['name']) && $emailIsValid === false) {
    $tmpBasisLayoutData['errorMassage'] = 'не верный формат email';
  }

  $tmpBasisLayoutData['layoutContent'] =
    renderTemplate('templates/clients/tmp-clients-addedit-card.php', $tmpClientFormData);

}


///////////////////////////////////////////////////////////////////////////////////////////
///////////----- CLIENTS LIST -----///////////----- CLIENTS LIST ------///////////      
///////////////////////////////////////////////////////////////////////////////////////////


if ($_SERVER['REQUEST_METHOD'] === 'GET'
  && isset($_GET['action']) && $_GET['action'] === 'show-list') {

  $tmpBasisLayoutData['navigationList']['clients']['options']['list']['isActive'] = true;
  $documentTitle = 'Клиенты / список';

  $tmpClientListData = [
    'config' => $config,
    'clientList' => [],
    'fieldsData' => [
      'search' => $_GET['search'] ?? '',
      'sort' => $_GET['sort'] ?? ''
    ],
    'sortTypes' => [
      'задолженность',
      'переплата',
      'крупные',
      'мелкие',
      'активные',
      'спящие'
    ]
  ];

  $sqlQuerySelect = 'SELECT * FROM clients ';
  $sqlQueryWhere = '';
  $sqlParametrs = [];

  $sqlSortBy = 'ORDER BY last_order_date DESC, orders_count DESC ';

  if (isset($_GET['sort']) && $_GET['sort'] === 'задолженность') {
    $sqlSortBy = 'ORDER BY balance ';
  } else if (isset($_GET['sort']) && $_GET['sort'] === 'переплата') {
    $sqlSortBy = 'ORDER BY balance DESC ';
  } else if (isset($_GET['sort']) && $_GET['sort'] === 'крупные') {
    $sqlSortBy = 'ORDER BY deb DESC ';
  } else if (isset($_GET['sort']) && $_GET['sort'] === 'мелкие') {
    $sqlSortBy = 'ORDER BY deb ';
  } else if (isset($_GET['sort']) && $_GET['sort'] === 'активные') {
    $sqlSortBy = 'ORDER BY last_order_date DESC ';
  } else if (isset($_GET['sort']) && $_GET['sort'] === 'спящие') {
    $sqlSortBy = 'ORDER BY last_order_date ';
  }

  if (isset($_GET['search'])) {
    $sqlQueryWhere = $sqlQueryWhere . 'WHERE name LIKE ? OR email LIKE ? OR first_tel LIKE ? ';
    $sqlParametrs = [
      '%' . ($_GET['search']) . '%',
      '%' . ($_GET['search']) . '%',
      '%' . ($_GET['search']) . '%'
    ];
  }

  $paginationData =
    getPagination($config, $config['host'] . '/clients.php', $con, 'SELECT COUNT(*) as pgn FROM clients ' .
      $sqlQueryWhere, $sqlParametrs);

  $tmpBasisLayoutData['pagination'] = $paginationData['tmpPagination'];
  $sqlPagination = $paginationData['sqlPagination'];

  $tmpClientListData['clientList'] =
    dbSelectData($con, $sqlQuerySelect . $sqlQueryWhere . $sqlSortBy . $sqlPagination, $sqlParametrs);

  $tmpBasisLayoutData['layoutContent'] = renderTemplate('templates/clients/tmp-clients-list.php', $tmpClientListData);
}


///////////////////////////////////////////////////////////////////////////////////////////
///////////----- EDIT CLIENT CARD -----///////////----- EDIT CLIENT CARD ------///////////      
///////////////////////////////////////////////////////////////////////////////////////////

$isEditCard = ($_SERVER['REQUEST_METHOD'] === 'GET' &&
  isset($_GET['action']) && $_GET['action'] === 'edit-card' &&
  isset($_GET['id']));

if ($isEditCard &&
  $clientData = (dbSelectData($con, 'SELECT * FROM clients WHERE id = ?', [$_GET['id']])[0] ?? false)) {

  $documentTitle = 'Клиенты / редактировать карту';

  $tmpClientFormData = [
    'config' => $config,
    'fieldsData' => [
      'name' => $clientData['name'] ?? '',
      'email' => $clientData['email'] ?? '',
      'firstTel' => $clientData['first_tel'] ?? '',
      'secondTel' => $clientData['second_tel'] ?? '',
      'address' => $clientData['address'] ?? '',
      'note' => $clientData['note'] ?? '',
      'editCard' => $_GET['id']
    ],
    'isAddCard' => false,
    'isEditCard' => true
  ];


  $editValidationData = [
    'name' => [
      'minValueLingth' => 5,
      'valueIs' => false
    ],
    'email' => [
      'minValueLingth' => 6,
      'valueIs' => false
    ],
    'first-tel' => [
      'minValueLingth' => 9,
      'valueIs' => false
    ]
  ];

  $editIsValid = validateGetParam($editValidationData);

  if (isset($_GET['name']) && $editIsValid) {

    $editClient = true;

    $editClientData = [
      'name' => trim(htmlspecialchars(strip_tags(mb_strtoupper($_GET['name'])))),
      'email' => trim(htmlspecialchars(strip_tags(mb_strtolower($_GET['email'])))),
      'first_tel' => trim(htmlspecialchars(strip_tags($_GET['first-tel']))),
      'second_tel' => trim(htmlspecialchars(strip_tags($_GET['second-tel'] ?? ''))),
      'address' => trim(htmlspecialchars(strip_tags($_GET['address'] ?? ''))),
      'note' => cutStr(trim(htmlspecialchars(strip_tags($_GET['note'] ?? ''))), 240),
      'stuff' => $_SESSION['user']['name'] ?? '',
      'edit' => $_GET['id']
    ];

    mysqli_query($con, 'START TRANSACTION');

    if ($clientData['name'] !== $editClientData['name'] &&
      (dbSelectData($con, 'SELECT name FROM clients WHERE name = ?', [$editClientData['name']])[0] ?? false)) {
      $tmpBasisLayoutData['errorMassage'] = 'клиент с таким именем уже существует';
      $editClient = false;
    }

    if ($clientData['email'] !== $editClientData['email'] &&
      (dbSelectData($con, 'SELECT name FROM clients WHERE email = ?', [$editClientData['email']])[0] ?? false)) {
      $tmpBasisLayoutData['errorMassage'] = 'клиент с таким email уже существует';
      $editClient = false;
    }

    if (!filter_var($editClientData['email'], FILTER_VALIDATE_EMAIL)) {
      $tmpBasisLayoutData['errorMassage'] = 'не верный формат email';
      $editClient = false;
    }

    if ($editClient) {
      $editClient =
        dbExecQuery($con, 'UPDATE clients SET name = ?, email = ?, first_tel = ?, second_tel = ?, address = ?, note = ?, stuff = ?  
          WHERE id = ?', $editClientData);
    }

    if ($editClient) {
      mysqli_query($con, 'COMMIT');
      header('Location:' . $config['host'] . '/clients.php?alert-massage=изменения сохранены&action=show-card&id=' . $_GET['id']);
    } else {
      mysqli_query($con, 'ROLLBACK');
      if (!$tmpBasisLayoutData['errorMassage']) {
        $tmpBasisLayoutData['errorMassage'] = 'ошибка сохранения';
      }
    }
  } else if (isset($_GET['name']) && $editIsValid === false) {
    $tmpBasisLayoutData['errorMassage'] = 'ошибка входных данных';
  }

  $tmpBasisLayoutData['layoutContent'] =
    renderTemplate('templates/clients/tmp-clients-addedit-card.php', $tmpClientFormData);

} else if ($isEditCard && $clientData === false) {

  $tmpBasisLayoutData['errorMassage'] = 'нет данных';
  $documentTitle = 'Нет данных';
  http_response_code(404);
}


///////////////////////////////////////////////////////////////////////////////////////////
///////////----- SHOW CLIENT CARD -----///////////----- SHOW CLIENT CARD ------///////////      
///////////////////////////////////////////////////////////////////////////////////////////


$isShowCard = ($_SERVER['REQUEST_METHOD'] === 'GET' &&
  isset($_GET['action']) && $_GET['action'] === 'show-card' &&
  isset($_GET['id']));

if ($isShowCard &&
  $clientDataShow = (dbSelectData($con, 'SELECT * FROM clients WHERE id = ?', [$_GET['id']])[0] ?? false)) {

  $documentTitle = 'Клиенты / карта клиента';

  $tmpclientCardData = [
    'config' => $config,
    'clientData' => $clientDataShow
  ];

  $tmpBasisLayoutData['layoutContent'] = renderTemplate('templates/clients/tmp-clients-show.php', $tmpclientCardData);

} else if ($isShowCard && $clientDataShow === false) {

  $tmpBasisLayoutData['errorMassage'] = 'нет данных';
  $documentTitle = 'Нет данных';
  http_response_code(404);
}


///////////////////////////////////////////////////////////////////////////////////////////
///////////----- ADD PAYMENT -----///////////----- ADD PAYMENT ------///////////      
///////////////////////////////////////////////////////////////////////////////////////////


$isAddPayment = ($_SERVER['REQUEST_METHOD'] === 'GET' &&
  isset($_GET['action']) && $_GET['action'] === 'add-payment' &&
  isset($_GET['id']));


if ($isAddPayment && $clientData =
    (dbSelectData($con, 'SELECT * FROM clients WHERE id = ?', [$_GET['id']])[0] ?? false)) {

  $documentTitle = 'Клиенты / платежная операция';
  $operationId = hash('md5', rand());

  $addpaymentValidationData = [
    'operation-id' => [
      'minValueLingth' => 3,
      'valueIs' => $_SESSION['clients']['operationId'] ?? ''
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

  $addPaymentIsValid = validateGetParam($addpaymentValidationData);

  if (isset($_GET['amount']) && $addPaymentIsValid) {

    $addPaymentData = [
      'client_id' => $_GET['id'],
      'payment_date' => date('Y-m-d'),
      'payment_purpose' => $_GET['payment-purpose'],
      'payment_type' => $_GET['payment-type'],
      'payment_note' => trim(htmlspecialchars(strip_tags(mb_strtolower($_GET['payment-note'] ?? '')))),
      'stuff' => (string)$_SESSION['user']['name'] ?? ''
    ];

    $addCashData = [
      'client_id' => $_GET['id'],
      'payment_date' => date('Y-m-d'),
      'payment_purpose' => $_GET['payment-purpose'],
      'payment_type' => $_GET['payment-type'],
      'payment_note' => trim(htmlspecialchars(strip_tags(mb_strtolower($_GET['payment-note'] ?? '')))),
      'stuff' => (string)$_SESSION['user']['name'] ?? ''
    ];

    $updateClientBalanceData = [
      'deb' => false,
      'cred' => false
    ];

    $updateCashBalanceData = [
      'deb' => false,
      'cred' => false
    ];

    if (isset($_GET['operation-type']) && $_GET['operation-type'] === 'deb') {
      $addPaymentData['deb'] = (int)$_GET['amount'];
      $addCashData['deb'] = (int)$_GET['amount'];
      $updateClientBalanceData['deb'] = (int)$_GET['amount'];
      $updateCashBalanceData['deb'] = (int)$_GET['amount'];
    }
    if (isset($_GET['operation-type']) && $_GET['operation-type'] === 'cred') {
      $addPaymentData['cred'] = (int)$_GET['amount'];
      $addCashData['cred'] = (int)$_GET['amount'];
      $updateClientBalanceData['cred'] = (int)$_GET['amount'];
      $updateCashBalanceData['cred'] = (int)$_GET['amount'];
    }

    mysqli_query($con, 'START TRANSACTION');

    $addPayment = dbInsertData($con, 'clients_payments', $addPaymentData);

    $updateClientBalance =
      updateClientBalance($con, $_GET['id'], $updateClientBalanceData['deb'], $updateClientBalanceData['cred']);

    $addCashData['clients_payments_id'] = $addPayment;

    $addCash = dbInsertData($con, 'cash', $addCashData);
    $updateCashBalance =
      updateCashBalance($con, $_GET['payment-type'], $updateCashBalanceData['deb'], $updateCashBalanceData['cred']);

    $updateClientsPayments = dbExecQuery($con, 'UPDATE clients_payments SET cash_id = ? WHERE id = ?', [$addCash, $addPayment]);

    if ($addPayment && $addCash && $updateClientBalance && $updateCashBalance && $updateClientsPayments) {
      mysqli_query($con, 'COMMIT');
      $clientData = dbSelectData($con, 'SELECT * FROM clients WHERE id = ?', [$_GET['id']])[0] ?? false;
      $tmpBasisLayoutData['alertMassage'] = 'платежная операция сохранена';
    } else {
      mysqli_query($con, 'ROLLBACK');
      $tmpBasisLayoutData['errorMassage'] = 'ошибка';
    }
  } else if (isset($_GET['amount']) && $addPaymentIsValid === false) {
    $tmpBasisLayoutData['errorMassage'] = 'ошибка входных данных';
  }

  $_SESSION['clients']['operationId'] = $operationId;

  $tmpClientAddPaymentData = [
    'config' => $config,
    'operationId' => $operationId,
    'clientData' => $clientData,
  ];

  $tmpBasisLayoutData['layoutContent'] =
    renderTemplate('templates/clients/tmp-clients-add-payment.php', $tmpClientAddPaymentData);

} else if ($isAddPayment && $clientData === false) {

  $tmpBasisLayoutData['errorMassage'] = 'нет данных';
  $documentTitle = 'Нет данных';
  http_response_code(404);
}


///////////////////////////////////////////////////////////////////////////////////////////
///////////----- ADD SERVICE -----///////////----- ADD SERVICE ------///////////
///////////////////////////////////////////////////////////////////////////////////////////


$isAddPayment = ($_SERVER['REQUEST_METHOD'] === 'GET' &&
  isset($_GET['action']) && $_GET['action'] === 'add-service' &&
  isset($_GET['id']));


if ($isAddPayment && $clientData =
    (dbSelectData($con, 'SELECT * FROM clients WHERE id = ?', [$_GET['id']])[0] ?? false)) {

  $documentTitle = 'Клиенты / добавить услугу';
  $operationId = hash('md5', rand());

  $addpaymentValidationData = [
    'operation-id' => [
      'minValueLingth' => 3,
      'valueIs' => $_SESSION['clients']['operationId'] ?? ''
    ],
    'payment-purpose' => [
      'minValueLingth' => 2,
      'valueIs' => 'услуги'
    ],
    'amount' => [
      'minValueLingth' => 1,
      'valueIs' => false
    ]
  ];

  $addServiceValid = validateGetParam($addpaymentValidationData);

  if (isset($_GET['amount']) && $addServiceValid) {

    $addPaymentData = [
      'cred' => (int)$_GET['amount'],
      'client_id' => $_GET['id'],
      'payment_date' => date('Y-m-d'),
      'payment_purpose' => $_GET['payment-purpose'],
      'payment_type' => 'авт',
      'payment_note' => trim(htmlspecialchars(strip_tags(mb_strtolower($_GET['payment-note'] ?? '')))),
      'stuff' => (string)$_SESSION['user']['name'] ?? ''
    ];

    $updateClientBalanceData = [
      'deb' => false,
      'cred' => (int)$_GET['amount']
    ];

    mysqli_query($con, 'START TRANSACTION');

    $addPayment = dbInsertData($con, 'clients_payments', $addPaymentData);

    $updateClientBalance =
      updateClientBalance($con, $_GET['id'], $updateClientBalanceData['deb'], $updateClientBalanceData['cred']);

    if ($addPayment && $updateClientBalance) {
      mysqli_query($con, 'COMMIT');
      $clientData = dbSelectData($con, 'SELECT * FROM clients WHERE id = ?', [$_GET['id']])[0] ?? false;
      $tmpBasisLayoutData['alertMassage'] = 'платежная операция сохранена';
    } else {
      mysqli_query($con, 'ROLLBACK');
      $tmpBasisLayoutData['errorMassage'] = 'ошибка';
    }
  } else if (isset($_GET['amount']) && $addServiceValid === false) {
    $tmpBasisLayoutData['errorMassage'] = 'ошибка входных данных';
  }

  $_SESSION['clients']['operationId'] = $operationId;

  $tmpClientAddServiceData = [
    'config' => $config,
    'operationId' => $operationId,
    'clientData' => $clientData,
  ];

  $tmpBasisLayoutData['layoutContent'] =
    renderTemplate('templates/clients/tmp-clients-add-service.php', $tmpClientAddServiceData);

} else if ($isAddPayment && $clientData === false) {

  $tmpBasisLayoutData['errorMassage'] = 'нет данных';
  $documentTitle = 'Нет данных';
  http_response_code(404);
}


///////////////////////////////////////////////////////////////////////////////////////////
///////////----- PAYMENTS -----///////////----- PAYMENTS ------///////////      
///////////////////////////////////////////////////////////////////////////////////////////


$isPaymentsList = ($_SERVER['REQUEST_METHOD'] === 'GET' &&
  isset($_GET['action']) && $_GET['action'] === 'payments-list' &&
  isset($_GET['id']));

if ($isPaymentsList && $clientDataPayments =
    (dbSelectData($con, 'SELECT * FROM clients WHERE id = ?', [$_GET['id']])[0] ?? false)) {

  $documentTitle = 'Клиенты / история платежей';

  $tmpClientPaymetnsData = [
    'config' => $config,
    'clientData' => $clientDataPayments,
    'paymentList' => [],
    'fieldsData' => [
      'operationType' => $_GET['operation-type'] ?? '',
      'paymentType' => $_GET['payment-type'] ?? '',
      'dateRangeFilter' => date('d.m.Y', strtotime('-1 month')) . ' - ' . date('d.m.Y')
    ],
    'sum' => []
  ];

  $sqlQuerySelect = 'SELECT *, DATE_FORMAT(payment_date, \'%d.%m.%Y\') as payment_date FROM clients_payments ';
  $sqlQueryWhere = 'WHERE client_id = ? AND payment_date BETWEEN ? AND ? ';

  $sqlParametrs = [
    $clientDataPayments['id'],
    date('Y-m-d', strtotime('-1 month')),
    date('Y-m-d'),
  ];

  if (isset($_GET['date-range-filter']) &&
    $dateRangeFilterValue = getDateRangeFilterValue($_GET['date-range-filter'] ?? '', 'Y-m-d')) {
    $sqlParametrs[1] = $dateRangeFilterValue['from'];
    $sqlParametrs[2] = $dateRangeFilterValue['to'];
    $tmpClientPaymetnsData['fieldsData']['dateRangeFilter'] = $_GET['date-range-filter'];
  }

  if (isset($_GET['operation-type']) && $_GET['operation-type'] === 'приход') {
    $sqlQueryWhere = $sqlQueryWhere . 'AND deb > 0 ';
  }

  if (isset($_GET['operation-type']) && $_GET['operation-type'] === 'расход') {
    $sqlQueryWhere = $sqlQueryWhere . 'AND cred > 0 ';
  }

  if (isset($_GET['payment-type']) && $_GET['payment-type'] !== 'все') {
    $sqlParametrs[3] = $_GET['payment-type'];
    $sqlQueryWhere = $sqlQueryWhere . 'AND payment_type = ? ';
  }

  $tmpClientPaymetnsData['sum'] =
    dbSelectData($con, 'SELECT SUM(deb) as deb, SUM(cred) as cred FROM clients_payments ' .
      $sqlQueryWhere . 'AND is_deleted IS NULL ', $sqlParametrs)[0];

  $sqlSortBy = 'ORDER BY id DESC ';

  $paginationData =
    getPagination($config, $config['host'] . '/clients.php', $con, 'SELECT COUNT(*) as pgn FROM clients_payments ' .
      $sqlQueryWhere, $sqlParametrs);

  $tmpBasisLayoutData['pagination'] = $paginationData['tmpPagination'];
  $sqlPagination = $paginationData['sqlPagination'];

  $tmpClientPaymetnsData['paymentList'] =
    dbSelectData($con, $sqlQuerySelect . $sqlQueryWhere . $sqlSortBy . $sqlPagination, $sqlParametrs);

  $tmpBasisLayoutData['layoutContent'] =
    renderTemplate('templates/clients/tmp-clients-payments.php', $tmpClientPaymetnsData);

} else if ($isPaymentsList && $clientDataPayments === false) {

  $tmpBasisLayoutData['errorMassage'] = 'нет данных';
  $documentTitle = 'Нет данных';
  http_response_code(404);
}


///////////////////////////////////////////////////////////////////////////////////////////
///////////----- CANCEL CASH ITEM -----///////////----- CANCEL CASH ITEM ------///////////
///////////////////////////////////////////////////////////////////////////////////////////


if ($_SERVER['REQUEST_METHOD'] === 'GET' &&
  isset($_GET['action']) && $_GET['action'] === 'cancel-payment-item'
  && isset($_GET['id']) &&
  isset($_GET['payments-list-client-id'])) {

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

  $cancelPaymentItemData = [
    'clientsPaymentsItemData' => dbSelectData($con, 'SELECT * FROM clients_payments WHERE id = ?', [$_GET['id']])[0] ?? false,
    'cashItemData' => false,
    'setClientsPaymentsIsDeleted' => false,
    'updateClientBalance' => false,
    'setCashIsDeleted' => true,
    'updateCashBalance' => true
  ];


  if ($cancelPaymentItemData['clientsPaymentsItemData'] === false) {
    header('Location:' . $config['host'] . '/clients.php?action=payments-list' . '&id=' . $_GET['payments-list-client-id'] . '&error-massage=нет данных');
    exit();
  }

  if (isset($cancelPaymentItemData['clientsPaymentsItemData']['stuff']) && $cancelPaymentItemData['clientsPaymentsItemData']['stuff'] !== $_SESSION['user']['name']) {
    header('Location:' . $config['host'] . '/clients.php?action=payments-list' . '&id=' . $_GET['payments-list-client-id'] . '&error-massage=запись может отменить только тот пользователь, кто ее создал');
    exit();
  }

  if (time() - strtotime($cancelPaymentItemData['clientsPaymentsItemData']['payment_date']) > $config['daysForCancelItem'] * 24 * 60 * 60) {
    header('Location:' . $config['host'] . '/clients.php?action=payments-list' . '&id=' . $_GET['payments-list-client-id'] . '&error-massage=запись нельзя отменить более чем через ' . $config['daysForCancelItem'] . ' дня');
    exit();
  }

  if ($cancelPaymentItemData['clientsPaymentsItemData']['cash_id']) {
    $cancelPaymentItemData['cashItemData'] =
      dbSelectData($con, 'SELECT * FROM cash WHERE id = ?', [$cancelPaymentItemData['clientsPaymentsItemData']['cash_id']])[0] ?? false;
  }

  if ($cancelPaymentItemData['clientsPaymentsItemData']['is_auto_create'] === 1 || $cancelPaymentItemData['cashItemData']['is_auto_create'] === 1) {
    header('Location:' . $config['host'] . '/clients.php?action=payments-list' . '&id=' . $_GET['payments-list-client-id'] . '&error-massage=нельзя отменить автоматически созданную запись');
    exit();
  }

  mysqli_query($con, 'START TRANSACTION');

  $cancelPaymentItemData['setClientsPaymentsIsDeleted'] =
    dbExecQuery($con, 'UPDATE clients_payments SET is_deleted = 1 WHERE id = ?', [$cancelPaymentItemData['clientsPaymentsItemData']['id']]);

  $cancelPaymentItemData['updateClientBalance'] =
    updateClientBalanceDelet($con,
      $cancelPaymentItemData['clientsPaymentsItemData']['client_id'],
      $cancelPaymentItemData['clientsPaymentsItemData']['deb'],
      $cancelPaymentItemData['clientsPaymentsItemData']['cred']);


  if ($cancelPaymentItemData['clientsPaymentsItemData']['cash_id']) {

    $cancelPaymentItemData['setCashIsDeleted'] =
      dbExecQuery($con, 'UPDATE cash SET is_deleted = 1 WHERE id = ?', [$cancelPaymentItemData['cashItemData']['id']]);

    $cancelPaymentItemData['updateCashBalance'] = updateCashBalanceDelet($con,
      $cancelPaymentItemData['cashItemData']['payment_type'],
      $cancelPaymentItemData['cashItemData']['deb'],
      $cancelPaymentItemData['cashItemData']['cred']);

  }

  if ($cancelPaymentItemData['setClientsPaymentsIsDeleted'] && $cancelPaymentItemData['updateClientBalance'] &&
    $cancelPaymentItemData['setCashIsDeleted'] && $cancelPaymentItemData['updateCashBalance']) {
    mysqli_query($con, 'COMMIT');
    header('Location:' . $config['host'] . '/clients.php?action=payments-list' . '&id=' . $_GET['payments-list-client-id'] . '&alert-massage=запись ' . $cancelPaymentItemData['clientsPaymentsItemData']['cash_id'] . ' отменена');
    exit();
  } else {
    mysqli_query($con, 'ROLLBACK');
    header('Location:' . $config['host'] . '/clients.php?action=payments-list' . '&id=' . $_GET['payments-list-client-id'] . '&error-massage=ошибка');
    exit();
  }

}


///////////////////////////////////////////////////////////////////////////////////////////
///////////----- MAIN -----///////////----- MAIN ------///////////      
///////////////////////////////////////////////////////////////////////////////////////////


if ($tmpBasisLayoutData['layoutContent'] === false) {

  $documentTitle = 'Клиенты / основная информация';

  $tmpBasisLayoutData['navigationList']['clients']['options']['main']['isActive'] = true;

  $tmpClientsMainData = [
    'config' => $config,
    'clientsQuantity' => false,
    'clientsQuantityActive' => false,
    'clientsDeb' => false,
    'clientsdCred' => false,
  ];

  $tmpClientsMainData['clientsQuantity'] =
    dbSelectData($con, 'SELECT COUNT(id) as cnt FROM clients', [])[0]['cnt'] ?? '-';

  $tmpClientsMainData['clientsQuantityActive'] =
    dbSelectData($con,
      'SELECT COUNT(id) as cnt FROM clients WHERE last_order_date > CURDATE() - INTERVAL 3 MONTH AND orders_count >= 3', [])[0]['cnt'] ?? '-';

  $tmpClientsMainData['clientsDeb'] =
    dbSelectData($con, 'SELECT COUNT(id) as cnt, SUM(balance) as deb FROM clients WHERE balance > 0', [])[0];

  $tmpClientsMainData['clientsCred'] =
    dbSelectData($con, 'SELECT COUNT(id) as cnt, SUM(balance) as cred FROM clients WHERE balance < 0', [])[0];

  $tmpBasisLayoutData['layoutContent'] = renderTemplate('templates/clients/tmp-clients-main.php', $tmpClientsMainData);
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
