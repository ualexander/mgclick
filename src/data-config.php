<?php

$config = [
  'host' => 'http://megapolis.loc',
  'maxTabeleRow' => 50,
  'daysForCancelItem' => 2,
  'currency' => 'р.',
  'dateFormat' => 'd.m.Y',
  'minMaterialQuantity' => 20,
  'email' => 'megacmyk@yandex.ru',
  'emailPsw' => 'flex2014',
  'emailHeader' => 'Студия печати Мегаполис',
  'companyTel' => '+7 977 811 89 66',
  'paymentsType' => [
    'нал',
    'сбер',
    'бн-УСН',
    'бн-ОСН'
  ],
  'paymentsPurpose' => [
    [
      'title' => 'производство',
      'isPrivate' => false
    ],
    [
      'title' => 'торговля',
      'isPrivate' => false
    ],
    [
      'title' => 'материалы',
      'isPrivate' => false
    ],
    [
      'title' => 'налоги',
      'isPrivate' => false
    ],
    [
      'title' => 'зп',
      'isPrivate' => false
    ],
    [
      'title' => 'хоз',
      'isPrivate' => false
    ],
    [
      'title' => 'реклама',
      'isPrivate' => false
    ],
    [
      'title' => 'со счета на счет',
      'isPrivate' => false
    ],
    [
      'title' => 'инна',
      'isPrivate' => false
    ],
    [
      'title' => 'приватные',
      'isPrivate' => true
    ]
  ],
  'materialsPurpose' => [
    'печать',
    'поставщики',
    'списание',
    'брак'
  ],
  'clientSource' => [
    'мегаполис',
    'яндекс',
    'гугл'
  ],
];