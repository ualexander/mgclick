<?php


require_once($_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php');

function renderTemplate($template, $data) {
  $string = '';
  if (file_exists($template)) {
    ob_start();
    require_once($template);
    $string = ob_get_clean();
    return $string;
  } else {
    return $string;
  }

}


function getAuthorizedUser($loginData, $users) {

  if (isset($users[$_POST['login']]) && $users[$loginData['login']]['password'] === $loginData['password']) {
    return $users[$_POST['login']];
  } else return false;

}


/**
 * Создает подготовленное выражение на основе готового SQL запроса и переданных данных
 *
 * @param $link mysqli Ресурс соединения
 * @param $sql string SQL запрос с плейсхолдерами вместо значений
 * @param array $data Данные для вставки на место плейсхолдеров
 *
 * @return mysqli_stmt Подготовленное выражение
 */
function dbGetPrepareStmt($link, $sql, $data = []) {
  $stmt = mysqli_prepare($link, $sql);

  if ($data) {
    $types = '';
    $stmt_data = [];

    foreach ($data as $value) {
      $type = null;

      if (is_int($value)) {
        $type = 'i';
      } else if (is_string($value)) {
        $type = 's';
      } else if (is_double($value)) {
        $type = 'd';
      }

      if ($type) {
        $types .= $type;
        $stmt_data[] = $value;
      }
    }

    $values = array_merge([$stmt, $types], $stmt_data);

    $func = 'mysqli_stmt_bind_param';
    $func(...$values);
  }

  return $stmt;
}


function dbSelectData($con, $sql, $data) {
  $rows = [];

  $stmt = dbGetPrepareStmt($con, $sql, $data);

  if ($stmt) {
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ($result) {
      $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
  }

  return $rows;
}


function dbInsertData($con, $table, $data) {
  $last_insert_id = false;

  if (count($data) > 0) {
    $data_fields = [];
    $data_value = [];

    foreach ($data as $key => $value) {
      $data_fields[] = $key;
      $data_value[] = '?';
    }

    $sql = 'INSERT INTO ' . $table . ' (' . implode(', ', $data_fields) . ') VALUES (' . implode(', ', $data_value) . ')';

    $stmt = dbGetPrepareStmt($con, $sql, $data);

    if ($stmt) {
      mysqli_stmt_execute($stmt);
      $last_insert_id = mysqli_insert_id($con);
    }
  }

  return $last_insert_id;
}


function dbExecQuery($con, $sql, $data) {
  $rows = false;

  $stmt = dbGetPrepareStmt($con, $sql, $data);

  if ($stmt) {
    mysqli_stmt_execute($stmt);
    if (mysqli_affected_rows($con)) {
      $rows = true;
    }
  }

  return $rows;
}


function updateClientBalance($con, $clientId, $addToDeb, $addToCred) {
  if (!(dbSelectData($con, 'SELECT id FROM clients WHERE id = ?', [$clientId])[0] ?? false)) {
    return false;
  }

  if ($addToDeb && (int)$addToDeb > 0) {
    return dbExecQuery($con, 'UPDATE clients SET balance = balance + ?, deb = deb + ? WHERE id = ?', [$addToDeb, $addToDeb, $clientId]);
  }

  if ($addToCred && (int)$addToCred > 0) {
    return dbExecQuery($con, 'UPDATE clients SET balance = balance - ?, cred = cred + ? WHERE id = ?', [$addToCred, $addToCred, $clientId]);
  }

  return false;
}


function updateClientBalanceDelet($con, $clientId, $addToDeb, $addToCred) {
  if (!(dbSelectData($con, 'SELECT id FROM clients WHERE id = ?', [$clientId])[0] ?? false)) {
    return false;
  }

  if ($addToDeb && (int)$addToDeb > 0) {
    return dbExecQuery($con, 'UPDATE clients SET balance = balance - ?, deb = deb - ? WHERE id = ?', [$addToDeb, $addToDeb, $clientId]);
  }

  if ($addToCred && (int)$addToCred > 0) {
    return dbExecQuery($con, 'UPDATE clients SET balance = balance + ?, cred = cred - ? WHERE id = ?', [$addToCred, $addToCred, $clientId]);
  }

  return false;
}


function updateMaterialsBalance($con, $materialName, $addToDeb, $addToCred) {

  if (!(dbSelectData($con, 'SELECT id FROM materials_remainder WHERE material_name = ?', [$materialName])[0] ?? false)) {
    $addMaterialData = [
      'material_name' => $materialName,
      'balance' => 0,
      'deb' => 0,
      'cred' => 0,
      'order_quantity' => 0
    ];
    $addMaterial = dbInsertData($con, 'materials_remainder', $addMaterialData);
    if (!$addMaterial) return false;
  }

  if ($addToDeb && (float)$addToDeb > 0) {
    return dbExecQuery($con, 'UPDATE materials_remainder SET balance = balance + ?, deb = deb + ? WHERE material_name = ?', [$addToDeb, $addToDeb, $materialName]);
  }

  if ($addToCred && (float)$addToCred > 0) {
    return dbExecQuery($con, 'UPDATE materials_remainder SET balance = balance - ?, cred = cred + ? WHERE material_name = ?', [$addToCred, $addToCred, $materialName]);
  }

  return false;
}


function updateMaterialsBalanceDelet($con, $materialName, $addToDeb, $addToCred) {

  if (!(dbSelectData($con, 'SELECT id FROM materials_remainder WHERE material_name = ?', [$materialName])[0] ?? false)) {
    $addMaterialData = [
      'material_name' => $materialName,
      'balance' => 0,
      'deb' => 0,
      'cred' => 0,
      'order_quantity' => 0
    ];
    $addMaterial = dbInsertData($con, 'materials_remainder', $addMaterialData);
    if (!$addMaterial) return false;
  }

  if ($addToDeb && (float)$addToDeb > 0) {
    return dbExecQuery($con, 'UPDATE materials_remainder SET balance = balance - ?, deb = deb - ? WHERE material_name = ?', [$addToDeb, $addToDeb, $materialName]);
  }

  if ($addToCred && (float)$addToCred > 0) {
    return dbExecQuery($con, 'UPDATE materials_remainder SET balance = balance + ?, cred = cred - ? WHERE material_name = ?', [$addToCred, $addToCred, $materialName]);
  }

  return false;
}


function updateCashBalance($con, $paymentType, $addToDeb, $addToCred) {

  if (!(dbSelectData($con, 'SELECT id FROM cash_remainder WHERE payment_type = ?', [$paymentType])[0] ?? false)) {
    $addPaymentTypeData = [
      'payment_type' => $paymentType,
      'balance' => 0,
      'deb' => 0,
      'cred' => 0
    ];
    $addPaymentType = dbInsertData($con, 'cash_remainder', $addPaymentTypeData);
    if (!$addPaymentType) return false;
  }

  if ($addToDeb && (int)$addToDeb > 0) {
    return dbExecQuery($con, 'UPDATE cash_remainder SET balance = balance + ?, deb = deb + ? WHERE payment_type = ?', [$addToDeb, $addToDeb, $paymentType]);
  }

  if ($addToCred && (int)$addToCred > 0) {
    return dbExecQuery($con, 'UPDATE cash_remainder SET balance = balance - ?, cred = cred + ? WHERE payment_type = ?', [$addToCred, $addToCred, $paymentType]);
  }

  return false;
}


function updateCashBalanceDelet($con, $paymentType, $addToDeb, $addToCred) {

  if (!(dbSelectData($con, 'SELECT id FROM cash_remainder WHERE payment_type = ?', [$paymentType])[0] ?? false)) {
    $addPaymentTypeData = [
      'payment_type' => $paymentType,
      'balance' => 0,
      'deb' => 0,
      'cred' => 0
    ];
    $addPaymentType = dbInsertData($con, 'cash_remainder', $addPaymentTypeData);
    if (!$addPaymentType) return false;
  }

  if ($addToDeb && (int)$addToDeb > 0) {
    return dbExecQuery($con, 'UPDATE cash_remainder SET balance = balance - ?, deb = deb - ? WHERE payment_type = ?', [$addToDeb, $addToDeb, $paymentType]);
  }

  if ($addToCred && (int)$addToCred > 0) {
    return dbExecQuery($con, 'UPDATE cash_remainder SET balance = balance + ?, cred = cred - ? WHERE payment_type = ?', [$addToCred, $addToCred, $paymentType]);
  }

  return false;
}


function getDateRangeFilterValue($dateRange, $format) {
  $datesArr = explode('-', $dateRange);

  if (isset($datesArr[0]) && isset($datesArr[1])) {
    return [
      'from' => date($format, strtotime($datesArr[0])),
      'to' => date($format, strtotime($datesArr[1]))
    ];
  } else {
    return false;
  }
}

function getStrintFromGetQuery($getArr) {

  unset($getArr['page']);
  unset($getArr['error-massage']);
  unset($getArr['alert-massage']);

  $getQueryString = '?';
  foreach ($getArr as $key => $value) {
    $getQueryString = $getQueryString . $key . '=' . $value . '&';
  }
  return $getQueryString;
}


function getPagination($config, $url, $con, $sqlQuery, $sqlParametrs) {

  $sqlPagination = ' ';
  $tmpPagination = '';

  $tmpPaginationData = [
    'config' => $config,
    'url' => $url . getStrintFromGetQuery($_GET),
    'pagesQuantity' => 0,
    'currentPage' => 0
  ];

  $paginationCount = dbSelectData($con, $sqlQuery, $sqlParametrs)[0]['pgn'];

  if ($paginationCount > $config['maxTabeleRow']) {

    $sqlPaginationItem = $config['maxTabeleRow'];
    $sqlPaginationStart = 0;

    $tmpPaginationData['pagesQuantity'] = ceil($paginationCount / $config['maxTabeleRow']);
    $tmpPaginationData['currentPage'] = 1;

    if (isset($_GET['page']) && $_GET['page'] > 1) {
      $sqlPaginationStart = floor($config['maxTabeleRow'] * (floor($_GET['page']) - 1));
      $tmpPaginationData['currentPage'] = floor($_GET['page']);
    }

    $sqlPagination = 'LIMIT ' . $sqlPaginationItem . ' OFFSET ' . $sqlPaginationStart . ' ';
    $tmpPagination = renderTemplate($_SERVER['DOCUMENT_ROOT'] . '/templates/tmp-pagination.php', $tmpPaginationData);
  }

  return [
    'sqlPagination' => $sqlPagination,
    'tmpPagination' => $tmpPagination
  ];
}


function validateGetParam($asd) {
  foreach ($asd as $key => $value) {
    if (isset($_GET[$key]) && mb_strlen($_GET[$key]) >= $value['minValueLingth']) {
      if ($value['valueIs'] && $_GET[$key] != $value['valueIs']) {
        return false;
      }
    } else {
      return false;
    }
  }
  return true;
}


function inArray2step($val, $arr) {
  foreach ($arr as $key => $value) {
    if (isset($value['title']) && $value['title'] === $val) {
      return $value['title'];
    }
  }
  return 'none';
}


function inArray1step($val, $arr) {
  foreach ($arr as $key => $value) {
    if (isset($value) && $value === $val) {
      return $value;
    }
  }
  return 'none';
}


function cutStr($str, $maxLength) {
  if (iconv_strlen($str) > $maxLength) {
    return mb_strimwidth($str, 0, $maxLength) . '...';
  } else {
    return $str;
  }
}


function getAvalaibleMaterials($printMaterialGroups, $printOptionalWorks) {

  $res = [];

  foreach ($printMaterialGroups as $key => $value) {
    if ($key !== 'materialKlienta') {
      foreach ($value['materials'] as $key2 => $value2) {
        foreach ($value2['materialFormats'] as $key3 => $value3) {
          $res[] = $value2['materialNameRu'] . ' (' . $value3 . ')';
        }
      }
    }
  }

  foreach ($printOptionalWorks['lamination']['materials'] as $key4 => $value4) {
    if ($key4 !== 'materialKlienta') {
      foreach ($value4['materialFormats'] as $key5 => $value5) {
        $tmpRes = $value4['materialName'] . ' (' . $value5 . ')';
        if (!array_search($tmpRes, $res)) {
          $res[] = $tmpRes;
        }
      }
    }
  }

  return $res;
}


function getOrderName($orderId) {
  $maxOrderNameBodyLenght = 4;
  $orderIdLength = mb_strlen($orderId);
  if ($orderIdLength > $maxOrderNameBodyLenght) {
    return substr($orderId, $orderIdLength - $maxOrderNameBodyLenght, $orderIdLength) . '-' . date('y-m');
  } else {
    return $orderId . '-' . date('m-y');
  }
}


function updatePrintOrderStatus($con, $orderId, $config) {

  $updatePrintOrderStatusData = [
    'orderItemsCount' => false,
    'deletedOrderItemsCount' => false,
    'readyOrderItemsCount' => false,
    'status' => true
  ];

  $updatePrintOrderStatusData['orderItemsCount'] =
    dbSelectData($con, 'SELECT COUNT(id) AS a FROM print_order_items WHERE print_order_id = ?',
      [$orderId])[0]['a'] ?? false;

  if ($updatePrintOrderStatusData['orderItemsCount'] === 0 || $updatePrintOrderStatusData['orderItemsCount'] === false) {
    return false;
  }

  $updatePrintOrderStatusData['deletedOrderItemsCount'] =
    dbSelectData($con, 'SELECT COUNT(id) AS b FROM print_order_items WHERE print_order_id = ? AND order_item_status = ?',
      [$orderId, 'отменен'])[0]['b'] ?? false;

  $updatePrintOrderStatusData['readyOrderItemsCount'] =
    dbSelectData($con, 'SELECT COUNT(id) AS c FROM print_order_items WHERE print_order_id = ? AND order_item_status = ?',
      [$orderId, 'выполнен'])[0]['c'] ?? false;

  if ($updatePrintOrderStatusData['orderItemsCount'] === $updatePrintOrderStatusData['deletedOrderItemsCount']) {

    $updatePrintOrderStatusData['status'] =
      dbExecQuery($con, 'UPDATE print_orders SET order_status = ?, date_deleted = ? WHERE id = ?',
        ['отменен', date('Y-m-d'), $orderId]);

  } else if ($updatePrintOrderStatusData['readyOrderItemsCount'] > 0 &&
    $updatePrintOrderStatusData['orderItemsCount'] ===
    $updatePrintOrderStatusData['deletedOrderItemsCount'] + $updatePrintOrderStatusData['readyOrderItemsCount']) {

    $updatePrintOrderStatusData['status'] =
      dbExecQuery($con, 'UPDATE print_orders SET order_status = ?, date_ready = ? WHERE id = ?',
        ['выполнен', date('Y-m-d'), $orderId]);


    sendPrintOrderReadyNotify($con, $orderId, $config);

  }

  return $updatePrintOrderStatusData['status'];
}


function sendPrintOrderReadyNotify($con, $orderId, $config) {

  $orderData = dbSelectData($con, 'SELECT po.order_name, po.client_id, po.order_name_privat, cl.email, cl.last_notify_date 
FROM print_orders po 
LEFT JOIN clients cl ON po.client_id = cl.id
WHERE po.id = ?', [$orderId])[0] ?? false;

  $emailSignature = '<br><br><p>' . $config['emailHeader'] . '<br>' . $config['companyTel'] . '</p>';
  $orderStatusLinc = '<br><br><a href="' . $config['host'] . '/order-info.php?print-order-info&order=' .
    $orderData['order_name_privat'] . '">подробнее</a>';

  if ($orderData['last_notify_date'] != date('Y-m-d')) {
    $details = 'Здравствуйте, заказ ' . $orderData['order_name'] . ' выполнен ' . $orderStatusLinc . $emailSignature;
    dbExecQuery($con, 'UPDATE clients SET last_notify_date = ? WHERE id = ?',
      [date('Y-m-d'), $orderData['client_id']]);
  } else {
    $details = 'Заказ ' . $orderData['order_name'] . ' выполнен ' . $orderStatusLinc . $emailSignature;
  }
  $sendEmail =
    send_email($config, $orderData['email'], 'Заказ ' . $orderData['order_name'] . ' выполнен', $details);

}


function getPrintOrderMaterialQuantity($orderItem) {

  if (!isset($orderItem['curentSizeParam']['canvasSize']) && !isset($orderItem['curentLaminationSize'])) {
    return false;
  }

  $orderMaterialQuantity = [];

  if (isset($orderItem['curentSizeParam']['canvasSize'][0])) {
    foreach ($orderItem['curentSizeParam']['canvasSize'] as $key => $value) {
      $name = $orderItem['productParam']['materialTypeRu'] . ' (' . $value['formatWidth'] . ')';
      if (isset($orderMaterialQuantity[$name])) {
        $orderMaterialQuantity[$name] = $orderMaterialQuantity[$name] + $value['formatHeight'] * $value['quantity'];
      } else {
        $orderMaterialQuantity[$name] = $value['formatHeight'] * $value['quantity'];
      }
    }
  }

  if (isset($orderItem['curentLaminationSize'][0])) {
    foreach ($orderItem['curentLaminationSize'] as $key => $value) {
      $name = $orderItem['productParam']['laminationMaterialTypeRu'] . ' (' . $value['formatWidth'] . ')';
      if (isset($orderMaterialQuantity[$name])) {
        $orderMaterialQuantity[$name] = $orderMaterialQuantity[$name] + $value['formatHeight'] * $value['quantity'];
      } else {
        $orderMaterialQuantity[$name] = $value['formatHeight'] * $value['quantity'];
      }
    }
  }

  return $orderMaterialQuantity;
}


function send_email($config, $send_to, $subject, $body) {

  if (filter_var($send_to, FILTER_VALIDATE_EMAIL)) {
    $transport = Swift_SmtpTransport::newInstance('smtp.yandex.ru', 465, 'ssl')
      ->setUsername($config['email'])
      ->setPassword($config['emailPsw']);
    $message = Swift_Message::newInstance();
    $message->setTo($send_to);
    $message->setBcc($config['email']);
    $message->setSubject($subject);
    $message->setBody($body);
    $message->setFrom($config['email'], $config['emailHeader']);
    $message->setContentType('text/html');

    $mailer = Swift_Mailer::newInstance($transport);
    return $mailer->send($message);
  } else {
    return false;
  }

}
