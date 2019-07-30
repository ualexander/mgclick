<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/src/src-library.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/src/data-config.php');



$tmpsSriptsData = [
  'printCalc' => true,
  'yaMetrika' => true
];


$tmpBasisData = [
  'title' => 'Rocket calc',
  'bodyContent' => '<form class="print-calc-container" data-url="' . $config['host'] . '/print-calc.php"></form>',
  'noFlex' => true,
  'scripts' => renderTemplate($_SERVER['DOCUMENT_ROOT'] . '/templates/tmp-basis-scripts.php', $tmpsSriptsData)
];


print(renderTemplate($_SERVER['DOCUMENT_ROOT'] . '/templates/tmp-basis.php', $tmpBasisData));


