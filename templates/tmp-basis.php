<!doctype html>
<html lang="ru">
<head>
  <title><?= $data['title'] ?></title>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css"
        integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">

  <link href="../css/daterangepicker-min.css" rel="stylesheet" type="text/css">
  <link href="../css/rocket-main.css" rel="stylesheet" type="text/css">
  <link href="../css/print-calc.css" rel="stylesheet" type="text/css">

  <!-- favicon -->
  <link href="../img/rocket-logo-64.png" rel="icon" type="image/x-icon">
  <link rel="icon" href="../img/rocket-logo-32.png" sizes="32x32">
  <link rel="icon" href="../img/rocket-logo-192.png" sizes="192x192">
  <link rel="apple-touch-icon-precomposed" href="../img/rocket-logo-180.png">
  <meta name="msapplication-TileImage" content="../img/rocket-logo-270.png">
  <!-- /favicon -->

</head>
<?php if ($data['noFlex']): ?>
<body class="">
<?php else: ?>
<body class="d-flex flex-column">
<?php endif; ?>
<?= $data['bodyContent'] ?>
<?= $data['scripts'] ?>

</body>
</html>
