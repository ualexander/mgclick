<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/src/data-config.php');

$navigationList = [
  'print' => [
    'title' => '<i class="material-icons align-bottom mr-1">print</i><span class="">Печать</span>',
    'isActive' => false,
    'url' => $config['host'] . '/print.php',
    'options' => [
      'main' => [
        'title' => '<i class="material-icons align-bottom mr-1">bar_chart</i>основное',
        'isActive' => false,
        'url' => $config['host'] . '/print.php'
      ],
      'printCalc' => [
        'title' => '<i class="material-icons align-bottom mr-1">keyboard</i>калькулятор',
        'isActive' => false,
        'url' => $config['host'] . '/print.php?print-calc'
      ],

      'divider1' => [
        'title' => 'divider',
        'isActive' => false,
        'url' => '#'
      ],

      'orders' => [
        'title' => '<i class="material-icons align-bottom mr-1">list</i>все',
        'isActive' => false,
        'url' => $config['host'] . '/print.php?orders&status=все'
      ],
      'ordersСreate' => [
        'title' => '<i class="material-icons align-bottom mr-1 text-warning">star</i>сохраненные',
        'isActive' => false,
        'url' => $config['host'] . '/print.php?orders&status=сохранен'
      ],
      'ordersInJob' => [
        'title' => '<i class="material-icons align-bottom mr-1 text-primary">star</i>в работе',
        'isActive' => false,
        'url' => $config['host'] . '/print.php?orders&status=в работе'
      ],
      'ordersReady' => [
        'title' => '<i class="material-icons align-bottom mr-1 text-success">star</i>выполненные',
        'isActive' => false,
        'url' => $config['host'] . '/print.php?orders&status=выполнен'
      ],
      'ordersIssued' => [
        'title' => '<i class="material-icons align-bottom mr-1 text-secondary">star</i>отгруженные',
        'isActive' => false,
        'url' => $config['host'] . '/print.php?orders&status=отгружен'
      ],
      'ordersDeleted' => [
        'title' => '<i class="material-icons align-bottom mr-1 text-danger">delete</i>отмененные',
        'isActive' => false,
        'url' => $config['host'] . '/print.php?orders&status=отменен'
      ],

      'divider2' => [
        'title' => 'divider',
        'isActive' => false,
        'url' => '#'
      ],

      'orderItems' => [
        'title' => '<i class="material-icons align-bottom mr-1">bar_chart</i>подробно',
        'isActive' => false,
        'url' => $config['host'] . '/print.php?orderitems'
      ]
    ]
  ],
  'cash' => [
    'title' => '<i class="material-icons align-bottom mr-1">monetization_on</i><span class="">Касса</span>',
    'isActive' => false,
    'url' => $config['host'] . '/cash.php',
    'options' => [
      'main' => [
        'title' => '<i class="material-icons align-bottom mr-1">bar_chart</i>основное',
        'isActive' => false,
        'url' => $config['host'] . '/cash.php'
      ],
      'list' => [
        'title' => '<i class="material-icons align-bottom mr-1">list</i>записи',
        'isActive' => false,
        'url' => $config['host'] . '/cash.php?action=show-list'
      ],
      'add' => [
        'title' => '<i class="material-icons align-bottom mr-1">add</i>внести',
        'isActive' => false,
        'url' => $config['host'] . '/cash.php?action=add-cash'
      ]
    ]
  ],
  'clients' => [
    'title' => '<i class="material-icons align-bottom mr-1">people</i><span class="">Клиенты</span>',
    'isActive' => false,
    'url' => $config['host'] . '/clients.php',
    'options' => [
      'main' => [
        'title' => '<i class="material-icons align-bottom mr-1">bar_chart</i>основное',
        'isActive' => false,
        'url' => $config['host'] . '/clients.php'
      ],
      'list' => [
        'title' => '<i class="material-icons align-bottom mr-1">list</i>список',
        'isActive' => false,
        'url' => $config['host'] . '/clients.php?action=show-list'
      ],

      'add' => [
        'title' => '<i class="material-icons align-bottom mr-1">person_add</i>добавить',
        'isActive' => false,
        'url' => $config['host'] . '/clients.php?action=add-card'
      ]
    ]
  ],
  'materials' => [
    'title' => '<i class="material-icons align-bottom mr-1">local_grocery_store</i><span class="">Материалы</span>',
    'isActive' => false,
    'url' => $config['host'] . '/materials.php',
    'options' => [
      'main' => [
        'title' => '<i class="material-icons align-bottom mr-1">bar_chart</i>основное',
        'isActive' => false,
        'url' => $config['host'] . '/materials.php'
      ],
      'list' => [
        'title' => '<i class="material-icons align-bottom mr-1">list</i>записи',
        'isActive' => false,
        'url' => $config['host'] . '/materials.php?action=show-list'
      ],
      'add' => [
        'title' => '<i class="material-icons align-bottom mr-1">add</i>внести',
        'isActive' => false,
        'url' => $config['host'] . '/materials.php?action=add-material'
      ]
    ]
  ],
  'requests' => [
    'title' => '<i class="material-icons align-bottom mr-1">forum</i><span class="">Запросы</span>',
    'isActive' => false,
    'url' => $config['host'] . '/requests.php',
    'options' => [
      'listTextAll' => [
        'title' => '<i class="material-icons align-bottom mr-1">list</i>все',
        'isActive' => false,
        'url' => $config['host'] . '/requests.php?action=show-list&list=text&status=все'
      ],
      'listTextNew' => [
        'title' => '<i class="material-icons align-bottom mr-1">chat</i>новые',
        'isActive' => false,
        'url' => $config['host'] . '/requests.php?action=show-list&list=text&status=новый'
      ],
      'listTextClosed' => [
        'title' => '<i class="material-icons align-bottom mr-1">forum</i>закрытые',
        'isActive' => false,
        'url' => $config['host'] . '/requests.php?action=show-list&list=text&status=закрыт'
      ]
    ]
  ],
];


$navigationList['requests']['notification'] = dbSelectData($con, 'SELECT COUNT(id) as cnt 
  FROM requests_text 
  WHERE request_status = \'новый\' 
  AND date_create BETWEEN CURDATE() - INTERVAL 1 MONTH AND CURDATE()', [])[0]['cnt'] ?? false;
