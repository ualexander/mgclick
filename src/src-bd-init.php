<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/src/src-library.php');

$con = mysqli_connect("localhost", "root", "root", "megapolis");
//$con = mysqli_connect("localhost", "root-megapolis", "3BCCDA981F351984B5CAFB79485755F2", "megapolis_8f5f167");

if ($con) {
  mysqli_set_charset($con, "utf8");
} else {
  print(renderTemplate($_SERVER['DOCUMENT_ROOT'] . '/templates/tmp-basis.php', [
    'title' => 'ошибка БД',
    'bodyContent' => 'ошибка БД',
    'scripts' => ''
  ]));
  exit();
}

