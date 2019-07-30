<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/src/src-session-start.php');

require_once($_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php');

$errorMassage = false;


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login']) && isset($_POST['password'])) {
  
  $user = getAuthorizedUser($_POST, $users);
  
  if ($user) {
    $_SESSION['user'] = $user;

    $_SESSION['materials']['avalaibleMaterials'] = getAvalaibleMaterials($printMaterialGroups, $printOptionalWorks);

    $_SESSION['print']['avalaiblePrintType'] =
      dbSelectData($con, 'SELECT print_type, COUNT(print_type) as cnt 
        FROM print_order_items GROUP BY print_type ORDER BY cnt DESC', []);

    header('Location:' . $config['host'] . '/main.php');
  }
  else {
    $errorMassage = 'Неверный логин или пароль';
  }
  
};


$tmpBasisLoginData = [
  'login' => $_POST['login'] ?? '',
  'password' => $_POST['password'] ?? '',
  'errorMassage' => $errorMassage
];


$tmpBasisData = [
  'title' => 'Войти',
  'bodyContent' => renderTemplate($_SERVER['DOCUMENT_ROOT'] . '/templates/tmp-basis-login.php', $tmpBasisLoginData),
  'noFlex' => false,
  'scripts' => renderTemplate($_SERVER['DOCUMENT_ROOT'] . '/templates/tmp-basis-scripts.php', [])
];


print(renderTemplate($_SERVER['DOCUMENT_ROOT'] . '/templates/tmp-basis.php', $tmpBasisData));
