<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/src/src-session-start.php');

unset($_SESSION['user']);
unset($_SESSION['cash']);
unset($_SESSION['clients']);
unset($_SESSION['matetials']);
unset($_SESSION['service-order-info']);


header('Location:' . $config['host'] . '/login.php');