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

$tmpBasisLayoutData['navigationList']['materials']['isActive'] = true;
$documentTitle = 'Материалы';

if (isset($_GET['error-massage'])) {
  $tmpBasisLayoutData['errorMassage'] = $_GET['error-massage'];
}
if (isset($_GET['alert-massage'])) {
  $tmpBasisLayoutData['alertMassage'] = $_GET['alert-massage'];
}


///////////////////////////////////////////////////////////////////////////////////////////
///////////----- MATERIAL LIST -----///////////----- MATERIAL LIST ------///////////      
///////////////////////////////////////////////////////////////////////////////////////////


if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'show-list') {

  $tmpBasisLayoutData['navigationList']['materials']['options']['list']['isActive'] = true;
  $documentTitle = 'Материалы / записи';

  $tmpMaterialListData = [
    'config' => $config,
    'materialsList' => [],
    'fieldsData' => [
      'operationType' => $_GET['operation-type'] ?? '',
      'materialPurpose' => $_GET['material-purpose'] ?? '',
      'materialName' => $_GET['material-name'] ?? '',
      'dateRangeFilter' => date('d.m.Y', strtotime('-1 month')) . ' - ' . date('d.m.Y')
    ],
    'sum' => false
  ];

  $sqlQuerySelect = 'SELECT *, DATE_FORMAT(action_date, \'%d.%m.%Y\') as action_date FROM materials ';
  $sqlQueryWhere = 'WHERE action_date BETWEEN ? AND ? ';

  $sqlParametrs = [
    date('Y-m-d', strtotime('-1 month')),
    date('Y-m-d'),
  ];

  if (isset($_GET['date-range-filter']) &&
    $dateRangeFilterValue = getDateRangeFilterValue($_GET['date-range-filter'] ?? '', 'Y-m-d')) {
    $sqlParametrs[0] = $dateRangeFilterValue['from'];
    $sqlParametrs[1] = $dateRangeFilterValue['to'];
    $tmpMaterialListData['fieldsData']['dateRangeFilter'] = $_GET['date-range-filter'];
  }

  if (isset($_GET['operation-type']) && $_GET['operation-type'] === 'приход') {
    $sqlQueryWhere = $sqlQueryWhere . 'AND deb > 0 ';
  }

  if (isset($_GET['operation-type']) && $_GET['operation-type'] === 'расход') {
    $sqlQueryWhere = $sqlQueryWhere . 'AND cred > 0 ';
  }

  if (isset($_GET['material-purpose']) && $_GET['material-purpose'] !== 'все') {
    $sqlParametrs[3] = (string)$_GET['material-purpose'];
    $sqlQueryWhere = $sqlQueryWhere . 'AND material_purpose = ? ';
  }

  if (isset($_GET['material-name']) && $_GET['material-name'] !== 'все') {
    $sqlParametrs[4] = (string)$_GET['material-name'];
    $sqlQueryWhere = $sqlQueryWhere . 'AND material_name = ? ';

    $tmpMaterialListData['sum'] =
      dbSelectData($con, 'SELECT ROUND(SUM(deb), 1) as deb, ROUND(SUM(cred), 1) as cred FROM materials mtr ' .
        $sqlQueryWhere . 'AND is_deleted IS NULL', $sqlParametrs)[0];

  }

  $sqlSortBy = 'ORDER BY id DESC ';

  $paginationData =
    getPagination($config, $config['host'] . '/materials.php', $con, 'SELECT COUNT(*) as pgn FROM materials mtr ' .
      $sqlQueryWhere, $sqlParametrs);

  $tmpBasisLayoutData['pagination'] = $paginationData['tmpPagination'];
  $sqlPagination = $paginationData['sqlPagination'];

  $tmpMaterialListData['materialsList'] =
    dbSelectData($con, $sqlQuerySelect . $sqlQueryWhere . $sqlSortBy . $sqlPagination, $sqlParametrs);

  $tmpBasisLayoutData['layoutContent'] =
    renderTemplate('templates/materials/tmp-materials-list.php', $tmpMaterialListData);

}


///////////////////////////////////////////////////////////////////////////////////////////
///////////----- ADD MATERIAL -----///////////----- ADD MATERIAL ------///////////      
///////////////////////////////////////////////////////////////////////////////////////////


if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'add-material') {

  $tmpBasisLayoutData['navigationList']['materials']['options']['add']['isActive'] = true;
  $documentTitle = 'Материалы / внести запись';

  $operationId = hash('md5', rand());

  $addMaterialValidationData = [
    'operation-id' => [
      'minValueLingth' => 3,
      'valueIs' => $_SESSION['matetials']['operationId'] ?? ''
    ],
    'operation-type' => [
      'minValueLingth' => 1,
      'valueIs' => false
    ],
    'material-purpose' => [
      'minValueLingth' => 2,
      'valueIs' => inArray1step($_GET['material-purpose'] ?? 'none', $config['materialsPurpose'])
    ],
    'material-name' => [
      'minValueLingth' => 2,
      'valueIs' => inArray1step($_GET['material-name'] ?? 'none', $_SESSION['materials']['avalaibleMaterials'])
    ],
    'amount' => [
      'minValueLingth' => 1,
      'valueIs' => false
    ],
    'material-note' => [
      'minValueLingth' => 0,
      'valueIs' => false
    ]
  ];

  $addMaterialIsValid = validateGetParam($addMaterialValidationData);

  if (isset($_GET['amount']) && $addMaterialIsValid) {

    $addMaterialData = [
      'material_purpose' => $_GET['material-purpose'],
      'material_name' => $_GET['material-name'],
      'material_note' => trim(htmlspecialchars(strip_tags(mb_strtolower($_GET['material-note'] ?? '')))),
      'action_date' => date('Y-m-d'),
      'stuff' => (string)$_SESSION['user']['name'] ?? ''
    ];

    $updateMaterialsBalanceData = [
      'deb' => false,
      'cred' => false,
    ];

    if (isset($_GET['operation-type']) && $_GET['operation-type'] === 'deb') {
      $addMaterialData['deb'] = (float)$_GET['amount'];
      $updateMaterialsBalanceData['deb'] = (float)$_GET['amount'];
    }
    if (isset($_GET['operation-type']) && $_GET['operation-type'] === 'cred') {
      $addMaterialData['cred'] = (float)$_GET['amount'];
      $updateMaterialsBalanceData['cred'] = (float)$_GET['amount'];
    }

    mysqli_query($con, 'START TRANSACTION');

    $addMaterial = dbInsertData($con, 'materials', $addMaterialData);

    $updateMaterialsBalance =
      updateMaterialsBalance(
        $con, $_GET['material-name'], $updateMaterialsBalanceData['deb'], $updateMaterialsBalanceData['cred']);

    if ($addMaterial && $updateMaterialsBalance) {
      mysqli_query($con, 'COMMIT');
      $tmpBasisLayoutData['alertMassage'] = 'операция сохранена';
    } else {
      mysqli_query($con, 'ROLLBACK');
      $tmpBasisLayoutData['errorMassage'] = 'ошибка';
    }

  } else if (isset($_GET['amount']) && $addMaterialIsValid === false) {
    $tmpBasisLayoutData['errorMassage'] = 'ошибка входных данных';
  }

  $_SESSION['matetials']['operationId'] = $operationId;

  $tmpMaterialsAddData = [
    'config' => $config,
    'operationId' => $operationId,
    'avalaibleMaterials' => $_SESSION['materials']['avalaibleMaterials']
  ];

  $tmpBasisLayoutData['layoutContent'] = renderTemplate('templates/materials/tmp-materials-add.php', $tmpMaterialsAddData);
}



///////////////////////////////////////////////////////////////////////////////////////////
///////////----- CANCEL MATERIAL ITEM -----///////////----- CANCEL MATERIAL ITEM ------///////////
///////////////////////////////////////////////////////////////////////////////////////////


if ($_SERVER['REQUEST_METHOD'] === 'GET' &&
  isset($_GET['action']) && $_GET['action'] === 'cancel-material-item'
  && isset($_GET['id'])) {


  $cancelMaterialItemData = [
    'materialItemData' => dbSelectData($con, 'SELECT * FROM materials WHERE id = ?', [$_GET['id']])[0] ?? false,
    'setMaterialsIsDeleted' => false,
    'updateMaterialsBalance' => false
  ];

  if ($cancelMaterialItemData['materialItemData'] === false) {
    header('Location:' . $config['host'] . '/materials.php?action=show-list&error-massage=нет данных');
    exit();
  }

  if (isset($cancelMaterialItemData['materialItemData']['stuff']) && $cancelMaterialItemData['materialItemData']['stuff'] !== $_SESSION['user']['name']) {
    header('Location:' . $config['host'] . '/materials.php?action=show-list&error-massage=запись может отменить только тот пользователь, кто ее создал');
    exit();
  }

  if (time() - strtotime($cancelMaterialItemData['materialItemData']['action_date']) > $config['daysForCancelItem'] * 24 * 60 * 60) {
    header('Location:' . $config['host'] . '/materials.php?action=show-list&error-massage=запись нельзя отменить более чем через ' . $config['daysForCancelItem'] . ' дня');
    exit();
  }

  if ($cancelMaterialItemData['materialItemData']['is_auto_create'] === 1) {
    header('Location:' . $config['host'] . '/materials.php?action=show-list&error-massage=нельзя отменить автоматически созданную запись');
    exit();
  }

  
  mysqli_query($con, 'START TRANSACTION');

  $cancelMaterialItemData['setMaterialsIsDeleted'] =
    dbExecQuery($con, 'UPDATE materials SET is_deleted = 1 WHERE id = ?', [$cancelMaterialItemData['materialItemData']['id']]);

  $cancelMaterialItemData['updateMaterialsBalance'] =
    updateMaterialsBalanceDelet($con,
      $cancelMaterialItemData['materialItemData']['material_name'],
      $cancelMaterialItemData['materialItemData']['deb'],
      $cancelMaterialItemData['materialItemData']['cred']);


  if ($cancelMaterialItemData['setMaterialsIsDeleted'] && $cancelMaterialItemData['updateMaterialsBalance']) {
    mysqli_query($con, 'COMMIT');
    header('Location:' . $config['host'] . '/materials.php?action=show-list&alert-massage=запись ' . $cancelMaterialItemData['materialItemData']['id'] . ' отменена');
    exit();
  } else {
    mysqli_query($con, 'ROLLBACK');
    header('Location:' . $config['host'] . '/materials.php?action=show-list&error-massage=ошибка');
    exit();
  }




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



  }


///////////////////////////////////////////////////////////////////////////////////////////
///////////----- MAIN -----///////////----- MAIN ------///////////
///////////////////////////////////////////////////////////////////////////////////////////


if ($tmpBasisLayoutData['layoutContent'] === false) {

  $documentTitle = 'Материалы / основная информация';

  $tmpBasisLayoutData['navigationList']['materials']['options']['main']['isActive'] = true;

  $tmpMaterialsMainData = [
    'config' => $config,
    'materialsList' =>
      dbSelectData($con, 'SELECT *, ROUND(deb, 1) as deb, ROUND(cred, 1) as cred, ROUND(balance, 1) as balance 
        FROM materials_remainder WHERE hide IS NULL ORDER BY material_name, balance', [])
  ];

  $tmpBasisLayoutData['layoutContent'] =
    renderTemplate('templates/materials/tmp-materials-main.php', $tmpMaterialsMainData);
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
