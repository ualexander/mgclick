<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/src/src-session-start.php');

if (isset($_SESSION['user']) === false) {
  http_response_code(401);
  header('Location:' . $config['host'] . '/login.php');
  exit();
}

require_once($_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php');

$documentTitle = $_SESSION['user']['name'];

if ($_SESSION['user']['fullInfo'] === true) {
  $documentTitle = $documentTitle . '+';
}


$tmpMainData = [
  'config' => $config,
  'user' => $_SESSION['user'],
  'navigationList' => $navigationList
];





$bodyContent = renderTemplate($_SERVER['DOCUMENT_ROOT'] . '/templates/main/main.php', $tmpMainData);


///////////////////////////////////////////////////////////////////////////////////////////
///////////----- REDNER BASIS TMP -----///////////----- REDNER BASIS TMP ------///////////
///////////////////////////////////////////////////////////////////////////////////////////

$tmpsSriptsData = [
  'printCalc' => true,
  'yaMetrika' => true
];


$tmpBasisData = [
  'title' => $documentTitle,
  'bodyContent' => $bodyContent,
  'noFlex' => false,
  'scripts' => renderTemplate($_SERVER['DOCUMENT_ROOT'] . '/templates/tmp-basis-scripts.php', $tmpsSriptsData)
];

print(renderTemplate($_SERVER['DOCUMENT_ROOT'] . '/templates/tmp-basis.php', $tmpBasisData));

