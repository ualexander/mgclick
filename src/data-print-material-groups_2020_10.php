<?php

// ПЛЕНКА 540 проход: 4 / скорость: high / заливка: 70 / настройка: 2
// КИТАЙ 540 проход: 3 / скорость: normal / заливка: 70 / настройка: 5
// ЛИТОЙ 540 проход: 3 / скорость: high / заливка: 80 / настройка: 4
// СЕТКА 540 проход: 3 / скорость: high / заливка: 80 / настройка: 3
// БУМААГА 540 проход: 3 / скорость: high / заливка: 70 / настройка: 6
// БЭКСАЙД 540 проход: 3 / скорость: normal / заливка: 70 / настройка: 7


// ПЛЕНКА 720 проход: 4 / скорость: high / в одну сторону / заливка: 80 / настройка: 2
// КИТАЙ 720 проход: 4 / скорость: high / заливка: 80 / настройка: 5
// ЛИТОЙ 720 проход: 4 / скорость: high / заливка: 80 / настройка: 4
// СЕТКА 720 проход: 3 / скорость: high / заливка: 100 / настройка: 3
// БУМААГА 720 проход: 4 / скорость: high / в одну сторону /заливка: 80 / настройка: 6
// БЭКСАЙД 720 проход: 4 / скорость: normal / заливка: 80 / настройка: 7


// ИНТЕРЬЕРКА 720 проход: 4 / настройка: quality
// ИНТЕРЬЕРКА 1440 проход: 6 / настройка: high quality

$printMaterialGroups = [
  'banneri' => [
    'materialsGroupNameRu' => 'баннеры',
    'squarePriceGradation' => [1, 50, 150],
    'printTypeGradation' => ['720', '1440'],
    'materials' => [
      'banLamin440' => [
        'materialNameRu' => 'баннер ламинированный 440 гр',
        'materialInfoUrl' => '#',
        'materialInfoTitle' => 'бюджетный баннер / подходит как для помещения так и для улицы / имеет явную текстуру / средний срок эксплуатации около 1 года',
        'materialPrintTypeParametrs' => [
          '720' => [
            'nameRu' => 'широкоформатная',
            'printerModel' => 'ph 3286',
            'printParam' => 'проход: 3 / скорость: high / заливка: 80 / настройка: 5',
            'printTypeInfoUrl' => '#',
            'printTypeInfoTitle' => '720 dpi / cредняя детализация / есть запах / применяется на улице',
            'printerMaxWidth' => 3200,
            'priceGradation' => [260, 200, 170],
            'materialPrice' => 7,
            'output' => 52
          ],
          '1440' => [
            'nameRu' => 'интерьерная',
            'printerModel' => 'ph 3278',
            'printParam' => 'проход: 4 / настройка: quality',
            'printTypeInfoUrl' => '#',
            'printTypeInfoTitle' => '1440 dpi ECO / высокая детализация / без запаха / применяется как в помещение, так и на улице',
            'printerMaxWidth' => 3200,
            'priceGradation' => [380, 330, 290],
            'materialPrice' => 16,
            'output' => 15.5
          ]
        ],
        'materialFormats' => [1100, 1600, 2200, 2500, 3200],
        'materialTechField' => 50,
        'materialPrice' => 70,
        // free free10 material full
        'materialOverspendingDefaultMetrod' => 'material',
        'materialMargin' => [
          'x' => 50,
          'y' => 0
        ],
        'materialWeight' => 0.44,
        'materialCustomOptionalWork' => true,
        'materialCringle' => true,
        'materialGain' => true,
        'materialCut' => true,
        'materialCord' => true,
        'materialPocket' => true,
        'materialLamination' => false,
        'materialStickToPlastic' => false,
        'materialCoupling' => [
          'price' => 40,
          'margin' => 50,
          'output' => 40
        ]
      ],
      'banLitoy' => [
        'materialNameRu' => 'баннер литой 510 гр',
        'materialInfoUrl' => '#',
        'materialInfoTitle' => 'премиальный баннер / подходит как для помещения так и для улицы / однородная текстура / не бликует / возможна эксплуатация до 3 лет',
        'materialPrintTypeParametrs' => [
          '720' => [
            'nameRu' => 'широкоформатная',
            'printerModel' => 'ph 3286',
            'printParam' => 'проход: 3 / скорость: normal / заливка: 80 / настройка: 4',
            'printTypeInfoUrl' => '#',
            'printTypeInfoTitle' => '720 dpi / cредняя детализация / есть запах / применяется на улице',
            'printerMaxWidth' => 3200,
            'priceGradation' => [310, 250, 210],
            'materialPrice' => 5,
            'output' => 73
          ],
          '1440' => [
            'nameRu' => 'интерьерная',
            'printerModel' => 'ph 3278',
            'printParam' => 'проход: 4 / настройка: quality',
            'printTypeInfoUrl' => '#',
            'printTypeInfoTitle' => '1440 dpi ECO / высокая детализация / без запаха / применяется как в помещение, так и на улице',
            'printerMaxWidth' => 3200,
            'priceGradation' => [470, 400, 310],
            'materialPrice' => 16,
            'output' => 15.5
          ]
        ],
        'materialFormats' => [2500, 3200],
        'materialTechField' => 50,
        'materialPrice' => 120,
        // free free10  material full
        'materialOverspendingDefaultMetrod' => 'material',
        'materialMargin' => [
          'x' => 50,
          'y' => 0
        ],
        'materialWeight' => 0.5,
        'materialCustomOptionalWork' => true,
        'materialCringle' => true,
        'materialGain' => true,
        'materialCut' => true,
        'materialCord' => true,
        'materialPocket' => true,
        'materialLamination' => false,
        'materialStickToPlastic' => false,
        'materialCoupling' => [
          'price' => 40,
          'margin' => 50,
          'output' => 40
        ]
      ],
      'banBlackBack' => [
        'materialNameRu' => 'баннер блэк-бэк 510 гр',
        'materialInfoUrl' => '#',
        'materialInfoTitle' => 'премиальный баннер / задняя сторона черная / не просвечивает / подходит как для помещения так и для улицы / однородная текстура / не бликует / возможна эксплуатация до 3 лет',
        'materialPrintTypeParametrs' => [
          '720' => [
            'nameRu' => 'широкоформатная',
            'printerModel' => 'ph 3286',
            'printParam' => 'проход: 3 / скорость: normal / заливка: 80 / настройка: 4',
            'printTypeInfoUrl' => '#',
            'printTypeInfoTitle' => '720 dpi / cредняя детализация / есть запах / применяется на улице',
            'printerMaxWidth' => 3200,
            'priceGradation' => [325, 265, 225],
            'materialPrice' => 5,
            'output' => 73
          ],
          '1440' => [
            'nameRu' => 'интерьерная',
            'printerModel' => 'ph 3278',
            'printParam' => 'проход: 4 / настройка: quality',
            'printTypeInfoUrl' => '#',
            'printTypeInfoTitle' => '1440 dpi ECO / высокая детализация / без запаха / применяется как в помещение, так и на улице',
            'printerMaxWidth' => 3200,
            'priceGradation' => [490, 420, 330],
            'materialPrice' => 16,
            'output' => 15.5
          ]
        ],
        'materialFormats' => [3200],
        'materialTechField' => 50,
        'materialPrice' => 130,
        // free free10  material full
        'materialOverspendingDefaultMetrod' => 'material',
        'materialMargin' => [
          'x' => 50,
          'y' => 0
        ],
        'materialWeight' => 0.5,
        'materialCustomOptionalWork' => true,
        'materialCringle' => true,
        'materialGain' => true,
        'materialCut' => true,
        'materialCord' => true,
        'materialPocket' => true,
        'materialLamination' => false,
        'materialStickToPlastic' => false,
        'materialCoupling' => [
          'price' => 40,
          'margin' => 50,
          'output' => 40
        ]
      ],
      'banTrans' => [
        'materialNameRu' => 'баннер транслюцентный 600 гр',
        'materialInfoUrl' => '#',
        'materialInfoTitle' => 'транслюцентный баннер пропускает свет / используется для световых коробов (лайтбоксов) / плотный / однородная текстура / возможна эксплуатация до 3 лет',
        'materialPrintTypeParametrs' => [
          '720' => [
            'nameRu' => 'широкоформатная',
            'printerModel' => 'ph 3286',
            'printParam' => 'проход: 4 / скорость: high / заливка: 80 / настройка: 7',
            'printTypeInfoUrl' => '#',
            'printTypeInfoTitle' => '720 dpi / cредняя детализация / есть запах / применяется на улице',
            'printerMaxWidth' => 3200,
            'priceGradation' => [325, 265, 225],
            'materialPrice' => 5,
            'output' => 73
          ],
          '1440' => [
            'nameRu' => 'интерьерная',
            'printerModel' => 'ph 3278',
            'printParam' => 'проход: 4 / настройка: quality',
            'printTypeInfoUrl' => '#',
            'printTypeInfoTitle' => '1440 dpi ECO / высокая детализация / без запаха / применяется как в помещение, так и на улице',
            'printerMaxWidth' => 3200,
            'priceGradation' => [490, 420, 330],
            'materialPrice' => 16,
            'output' => 15.5
          ]
        ],
        'materialFormats' => [1600, 3200],
        'materialTechField' => 50,
        'materialPrice' => 130,
        // free free10  material full
        'materialOverspendingDefaultMetrod' => 'material',
        'materialMargin' => [
          'x' => 50,
          'y' => 0
        ],
        'materialWeight' => 0.5,
        'materialCustomOptionalWork' => true,
        'materialCringle' => true,
        'materialGain' => true,
        'materialCut' => true,
        'materialCord' => true,
        'materialPocket' => true,
        'materialLamination' => false,
        'materialStickToPlastic' => false,
        'materialCoupling' => [
          'price' => 40,
          'margin' => 50,
          'output' => 40
        ]
      ]
    ]
  ],
  'plenki' => [
    'materialsGroupNameRu' => 'самоклеющиеся пленки',
    'squarePriceGradation' => [1, 50, 150],
    'printTypeGradation' => ['720', '1440'],
    'materials' => [
      'orajetBelGl' => [
        'materialNameRu' => 'orajet белый глянцевый',
        'materialInfoUrl' => '#',
        'materialInfoTitle' => 'белая самоклеющаяся пленка высокого качества / глянцевая / производство Германия',
        'materialPrintTypeParametrs' => [
          '720' => [
            'nameRu' => 'широкоформатная',
            'printerModel' => 'ph 3286',
            'printParam' => 'проход: 4 / скорость: high / заливка: 70 / настройка: 2',
            'printTypeInfoUrl' => '#',
            'printTypeInfoTitle' => '720 dpi / cредняя детализация / есть запах / применяется на улице',
            'printerMaxWidth' => 3200,
            'priceGradation' => [320, 260, 220],
            'materialPrice' => 5,
            'output' => 40
          ],
          '1440' => [
            'nameRu' => 'интерьерная',
            'printerModel' => 'ph 3278',
            'printParam' => 'проход: 4 / настройка: quality',
            'printTypeInfoUrl' => '#',
            'printTypeInfoTitle' => '1440 dpi ECO / высокая детализация / без запаха / применяется как в помещение, так и на улице',
            'printerMaxWidth' => 3200,
            'priceGradation' => [430, 370, 310],
            'materialPrice' => 16,
            'output' => 12
          ]
        ],
        'materialFormats' => [1050, 1250, 1520],
        'materialTechField' => 0,
        'materialPrice' => 140,
        // free free10  material full
        'materialOverspendingDefaultMetrod' => 'material',
        'materialMargin' => [
          'x' => 20,
          'y' => 50
        ],
        'materialWeight' => 0.3,
        'materialCustomOptionalWork' => false,
        'materialCringle' => false,
        'materialGain' => false,
        'materialCut' => true,
        'materialCord' => false,
        'materialPocket' => false,
        'materialLamination' => true,
        'materialStickToPlastic' => true,
        'materialCoupling' => [
          'price' => 0,
          'margin' => 10,
          'output' => 0
        ]
      ],
      'orajetBelMat' => [
        'materialNameRu' => 'orajet белый матовый',
        'materialInfoUrl' => '#',
        'materialInfoTitle' => 'белая самоклеющаяся пленка высокого качества / матовая / производство Германия',
        'materialPrintTypeParametrs' => [
          '720' => [
            'nameRu' => 'широкоформатная',
            'printerModel' => 'ph 3286',
            'printParam' => 'проход: 4 / скорость: high / заливка: 70 / настройка: 2',
            'printTypeInfoUrl' => '#',
            'printTypeInfoTitle' => '720 dpi / cредняя детализация / есть запах / применяется на улице',
            'printerMaxWidth' => 3200,
            'priceGradation' => [320, 260, 220],
            'materialPrice' => 5,
            'output' => 40
          ],
          '1440' => [
            'nameRu' => 'интерьерная',
            'printerModel' => 'ph 3278',
            'printParam' => 'проход: 4 / настройка: quality',
            'printTypeInfoUrl' => '#',
            'printTypeInfoTitle' => '1440 dpi ECO / высокая детализация / без запаха / применяется как в помещение, так и на улице',
            'printerMaxWidth' => 3200,
            'priceGradation' => [430, 370, 310],
            'materialPrice' => 16,
            'output' => 12
          ]
        ],
        'materialFormats' => [1050, 1250, 1520],
        'materialTechField' => 0,
        'materialPrice' => 140,
        // free free10  material full
        'materialOverspendingDefaultMetrod' => 'material',
        'materialMargin' => [
          'x' => 20,
          'y' => 50
        ],
        'materialWeight' => 0.3,
        'materialCustomOptionalWork' => false,
        'materialCringle' => false,
        'materialGain' => false,
        'materialCut' => true,
        'materialCord' => false,
        'materialPocket' => false,
        'materialLamination' => true,
        'materialStickToPlastic' => true,
        'materialCoupling' => [
          'price' => 0,
          'margin' => 10,
          'output' => 0
        ]
      ],
      'orajetBelMatLegko' => [
        'materialNameRu' => 'orajet белый матовый легкосъемный',
        'materialInfoUrl' => '#',
        'materialInfoTitle' => 'белая самоклеющаяся пленка высокого качества / при демонтаже не оставляет следов клея / матовая / производство Германия',
        'materialPrintTypeParametrs' => [
          '720' => [
            'nameRu' => 'широкоформатная',
            'printerModel' => 'ph 3286',
            'printParam' => 'проход: 4 / скорость: high / заливка: 70 / настройка: 2',
            'printTypeInfoUrl' => '#',
            'printTypeInfoTitle' => '720 dpi / cредняя детализация / есть запах / применяется на улице',
            'printerMaxWidth' => 3200,
            'priceGradation' => [340, 280, 240],
            'materialPrice' => 5,
            'output' => 40
          ],
          '1440' => [
            'nameRu' => 'интерьерная',
            'printerModel' => 'ph 3278',
            'printParam' => 'проход: 4 / настройка: quality',
            'printTypeInfoUrl' => '#',
            'printTypeInfoTitle' => '1440 dpi ECO / высокая детализация / без запаха / применяется как в помещение, так и на улице',
            'printerMaxWidth' => 3200,
            'priceGradation' => [450, 390, 330],
            'materialPrice' => 16,
            'output' => 12
          ]
        ],
        'materialFormats' => [1520],
        'materialTechField' => 0,
        'materialPrice' => 150,
        // free free10  material full
        'materialOverspendingDefaultMetrod' => 'material',
        'materialMargin' => [
          'x' => 20,
          'y' => 50
        ],
        'materialWeight' => 0.3,
        'materialCustomOptionalWork' => false,
        'materialCringle' => false,
        'materialGain' => false,
        'materialCut' => true,
        'materialCord' => false,
        'materialPocket' => false,
        'materialLamination' => true,
        'materialStickToPlastic' => true,
        'materialCoupling' => [
          'price' => 0,
          'margin' => 10,
          'output' => 0
        ]
      ],
      'orajetPrGl' => [
        'materialNameRu' => 'orajet прозрачный глянцевый',
        'materialInfoUrl' => '#',
        'materialInfoTitle' => 'прозрачная самоклеющаяся пленка высокого качества / глянцевая / производство Германия',
        'materialPrintTypeParametrs' => [
          '720' => [
            'nameRu' => 'широкоформатная',
            'printerModel' => 'ph 3286',
            'printParam' => 'проход: 4 / скорость: high / заливка: 70 / настройка: 2',
            'printTypeInfoUrl' => '#',
            'printTypeInfoTitle' => '720 dpi / cредняя детализация / есть запах / применяется на улице',
            'printerMaxWidth' => 3200,
            'priceGradation' => [320, 260, 220],
            'materialPrice' => 5,
            'output' => 40
          ],
          '1440' => [
            'nameRu' => 'интерьерная',
            'printerModel' => 'ph 3278',
            'printParam' => 'проход: 4 / настройка: quality',
            'printTypeInfoUrl' => '#',
            'printTypeInfoTitle' => '1440 dpi ECO / высокая детализация / без запаха / применяется как в помещение, так и на улице',
            'printerMaxWidth' => 3200,
            'priceGradation' => [430, 370, 310],
            'materialPrice' => 16,
            'output' => 12
          ]
        ],
        'materialFormats' => [1050, 1250, 1520],
        'materialTechField' => 0,
        'materialPrice' => 140,
        // free free10  material full
        'materialOverspendingDefaultMetrod' => 'material',
        'materialMargin' => [
          'x' => 20,
          'y' => 50
        ],
        'materialWeight' => 0.3,
        'materialCustomOptionalWork' => false,
        'materialCringle' => false,
        'materialGain' => false,
        'materialCut' => true,
        'materialCord' => false,
        'materialPocket' => false,
        'materialLamination' => true,
        'materialStickToPlastic' => true,
        'materialCoupling' => [
          'price' => 0,
          'margin' => 10,
          'output' => 0
        ]
      ],
      'orajetPrMat' => [
        'materialNameRu' => 'orajet прозрачный матовый',
        'materialInfoUrl' => '#',
        'materialInfoTitle' => 'прозрачная самоклеющаяся пленка высокого качества / матовая / производство Германия',
        'materialPrintTypeParametrs' => [
          '720' => [
            'nameRu' => 'широкоформатная',
            'printerModel' => 'ph 3286',
            'printParam' => 'проход: 4 / скорость: high / заливка: 70 / настройка: 2',
            'printTypeInfoUrl' => '#',
            'printTypeInfoTitle' => '720 dpi / cредняя детализация / есть запах / применяется на улице',
            'printerMaxWidth' => 3200,
            'priceGradation' => [320, 260, 220],
            'materialPrice' => 5,
            'output' => 40
          ],
          '1440' => [
            'nameRu' => 'интерьерная',
            'printerModel' => 'ph 3278',
            'printParam' => 'проход: 4 / настройка: quality',
            'printTypeInfoUrl' => '#',
            'printTypeInfoTitle' => '1440 dpi ECO / высокая детализация / без запаха / применяется как в помещение, так и на улице',
            'printerMaxWidth' => 3200,
            'priceGradation' => [430, 370, 310],
            'materialPrice' => 16,
            'output' => 12
          ]
        ],
        'materialFormats' => [1050, 1250, 1520],
        'materialTechField' => 0,
        'materialPrice' => 140,
        // free free10  material full
        'materialOverspendingDefaultMetrod' => 'material',
        'materialMargin' => [
          'x' => 20,
          'y' => 50
        ],
        'materialWeight' => 0.3,
        'materialCustomOptionalWork' => false,
        'materialCringle' => false,
        'materialGain' => false,
        'materialCut' => true,
        'materialCord' => false,
        'materialPocket' => false,
        'materialLamination' => true,
        'materialStickToPlastic' => true,
        'materialCoupling' => [
          'price' => 0,
          'margin' => 10,
          'output' => 0
        ]
      ],
      'plenkaPerf' => [
        'materialNameRu' => 'пленка перфарированная',
        'materialInfoUrl' => '#',
        'materialInfoTitle' => 'перфарированная самоклеющаяся пленка используется для оклейки окон  пропускает свет в помещение / с улицы не видно помещение / а с помещения видно улицу',
        'materialPrintTypeParametrs' => [
          '720' => [
            'nameRu' => 'широкоформатная',
            'printerModel' => 'ph 3286',
            'printParam' => 'проход: 4 / скорость: high / заливка: 70 / настройка: 1',
            'printTypeInfoUrl' => '#',
            'printTypeInfoTitle' => '720 dpi / cредняя детализация / есть запах / применяется на улице',
            'printerMaxWidth' => 3200,
            'priceGradation' => [350, 300, 270],
            'materialPrice' => 5,
            'output' => 40
          ],
        ],
        'materialFormats' => [1370],
        'materialTechField' => 0,
        'materialPrice' => 160,
        // free free10  material full
        'materialOverspendingDefaultMetrod' => 'material',
        'materialMargin' => [
          'x' => 20,
          'y' => 50
        ],
        'materialWeight' => 0.4,
        'materialCustomOptionalWork' => false,
        'materialCringle' => false,
        'materialGain' => false,
        'materialCut' => true,
        'materialCord' => false,
        'materialPocket' => false,
        'materialLamination' => true,
        'materialStickToPlastic' => false,
        'materialCoupling' => [
          'price' => 0,
          'margin' => 10,
          'output' => 0
        ]
      ],
      'kitPl' => [
        'materialNameRu' => 'пленка эконном',
        'materialInfoUrl' => '#',
        'materialInfoTitle' => 'пленка эконом для помещений',
        'materialPrintTypeParametrs' => [
          '720' => [
            'nameRu' => 'широкоформатная',
            'printerModel' => 'ph 3286',
            'printParam' => 'проход: 4 / скорость: high / заливка: 70 / настройка: 2',
            'printTypeInfoUrl' => '#',
            'printTypeInfoTitle' => '720 dpi / cредняя детализация / есть запах / применяется на улице',
            'printerMaxWidth' => 3200,
            'priceGradation' => [220, 200, 180],
            'materialPrice' => 5,
            'output' => 40
          ]
        ],
        'materialFormats' => [1050, 1250, 1520],
        'materialTechField' => 0,
        'materialPrice' => 50,
        // free free10  material full
        'materialOverspendingDefaultMetrod' => 'material',
        'materialMargin' => [
          'x' => 20,
          'y' => 50
        ],
        'materialWeight' => 0.3,
        'materialCustomOptionalWork' => false,
        'materialCringle' => false,
        'materialGain' => false,
        'materialCut' => true,
        'materialCord' => false,
        'materialPocket' => false,
        'materialLamination' => true,
        'materialStickToPlastic' => true,
        'materialCoupling' => [
          'price' => 0,
          'margin' => 10,
          'output' => 0
        ]
      ]
    ]
  ],
  'setki' => [
    'materialsGroupNameRu' => 'сетка',
    'squarePriceGradation' => [1, 50, 150],
    'printTypeGradation' => ['720', '1440'],
    'materials' => [
      'setka250' => [
        'materialNameRu' => 'сетка 250 гр',
        'materialInfoUrl' => '#',
        'materialInfoTitle' => 'сетка из за перфарированной структуры пропускает воздух, что значительно снижает ветровую нагрузку на конструкцию',
        'materialPrintTypeParametrs' => [
          '720' => [
            'nameRu' => 'широкоформатная',
            'printerModel' => 'ph 3286',
            'printParam' => 'проход: 3 / скорость: high / заливка: 80 / настройка: 3',
            'printTypeInfoUrl' => '#',
            'printTypeInfoTitle' => '720 dpi / cредняя детализация / есть запах / применяется на улице',
            'printerMaxWidth' => 3200,
            'priceGradation' => [280, 190, 160],
            'materialPrice' => 5,
            'output' => 73
          ]
        ],
        'materialFormats' => [3200],
        'materialTechField' => 50,
        'materialPrice' => 80,
        // free free10  material full
        'materialOverspendingDefaultMetrod' => 'material',
        'materialMargin' => [
          'x' => 50,
          'y' => 0
        ],
        'materialWeight' => 0.3,
        'materialCustomOptionalWork' => true,
        'materialCringle' => true,
        'materialGain' => true,
        'materialCut' => true,
        'materialCord' => true,
        'materialPocket' => true,
        'materialLamination' => false,
        'materialStickToPlastic' => false,
        'materialCoupling' => [
          'price' => 40,
          'margin' => 50,
          'output' => 40
        ]
      ]
    ]
  ],
  'bumagi' => [
    'materialsGroupNameRu' => 'бумаги',
    'squarePriceGradation' => [1, 50, 150],
    'printTypeGradation' => ['720', '1440'],
    'materials' => [
      'bumagaBlueback' => [
        'materialNameRu' => 'блюбэк',
        'materialInfoUrl' => '#',
        'materialInfoTitle' => 'бюджетная бумага / плотность 180-200 гр / с голубой обратной стороной / используется для уличных афиш а так же щитов',
        'materialPrintTypeParametrs' => [
          '720' => [
            'nameRu' => 'широкоформатная',
            'printerModel' => 'ph 3286',
            'printParam' => 'проход: 4 / скорость: high / заливка: 70 / настройка: 6',
            'printTypeInfoUrl' => '#',
            'printTypeInfoTitle' => '720 dpi / cредняя детализация / есть запах / применяется на улице',
            'printerMaxWidth' => 3200,
            'priceGradation' => [190, 180, 150],
            'materialPrice' => 5,
            'output' => 40
          ]
        ],
        'materialFormats' => [1570],
        'materialTechField' => 0,
        'materialPrice' => 35,
        // free free10  material full
        'materialOverspendingDefaultMetrod' => 'material',
        'materialMargin' => [
          'x' => 20,
          'y' => 50
        ],
        'materialWeight' => 0.2,
        'materialCustomOptionalWork' => false,
        'materialCringle' => false,
        'materialGain' => false,
        'materialCut' => true,
        'materialCord' => false,
        'materialPocket' => false,
        'materialLamination' => true,
        'materialStickToPlastic' => false,
        'materialCoupling' => [
          'price' => 0,
          'margin' => 10,
          'output' => 0
        ]
      ],
      'bumagaPoster' => [
        'materialNameRu' => 'постерная бумага',
        'materialInfoUrl' => '#',
        'materialInfoTitle' => 'бумага высокого качества / плотность 180-200 гр / применяется при изготовление постеров и прочих рекламных носителей примеряется как в помещение так и на улице',
        'materialPrintTypeParametrs' => [
          '720' => [
            'nameRu' => 'широкоформатная',
            'printerModel' => 'ph 3286',
            'printParam' => 'проход: 4 / скорость: high / заливка: 70 / настройка: 6',
            'printTypeInfoUrl' => '#',
            'printTypeInfoTitle' => '720 dpi / cредняя детализация / есть запах / применяется на улице',
            'printerMaxWidth' => 3200,
            'priceGradation' => [210, 200, 170],
            'materialPrice' => 5,
            'output' => 40
          ],
          '1440' => [
            'nameRu' => 'интерьерная',
            'printerModel' => 'ph 3278',
            'printParam' => 'проход: 4 / настройка: quality',
            'printTypeInfoUrl' => '#',
            'printTypeInfoTitle' => '1440 dpi ECO / высокая детализация / без запаха / применяется как в помещение, так и на улице',
            'printerMaxWidth' => 3200,
            'priceGradation' => [340, 310, 260],
            'materialPrice' => 16,
            'output' => 12
          ]
        ],
        'materialFormats' => [1570],
        'materialTechField' => 0,
        'materialPrice' => 50,
        // free free10  material full
        'materialOverspendingDefaultMetrod' => 'material',
        'materialMargin' => [
          'x' => 20,
          'y' => 50
        ],
        'materialWeight' => 0.2,
        'materialCustomOptionalWork' => false,
        'materialCringle' => false,
        'materialGain' => false,
        'materialCut' => true,
        'materialCord' => false,
        'materialPocket' => false,
        'materialLamination' => true,
        'materialStickToPlastic' => false,
        'materialCoupling' => [
          'price' => 0,
          'margin' => 10,
          'output' => 0
        ]
      ]
    ]
  ],
  'holsti' => [
    'materialsGroupNameRu' => 'холсты',
    'squarePriceGradation' => [1, 50, 150],
    'printTypeGradation' => ['720', '1440'],
    'materials' => [
      'holstNat' => [
        'materialNameRu' => 'холст натуральный',
        'materialInfoUrl' => '#',
        'materialInfoTitle' => 'натуральный холст идентичен художественному / применяется для печати картин / репродукций / фотографий',
        'materialPrintTypeParametrs' => [
          '1440' => [
            'nameRu' => 'интерьерная',
            'printerModel' => 'ph 3278',
            'printParam' => 'проход: 4 / настройка: quality',
            'printTypeInfoUrl' => '#',
            'printTypeInfoTitle' => '1440 dpi ECO / высокая детализация / без запаха / применяется как в помещение, так и на улице',
            'printerMaxWidth' => 3200,
            'priceGradation' => [700, 600, 500],
            'materialPrice' => 16,
            'output' => 12
          ]
        ],
        'materialFormats' => [1520],
        'materialTechField' => 0,
        'materialPrice' => 300,
        // free free10  material full
        'materialOverspendingDefaultMetrod' => 'material',
        'materialMargin' => [
          'x' => 20,
          'y' => 50
        ],
        'materialWeight' => 0.3,
        'materialCustomOptionalWork' => false,
        'materialCringle' => false,
        'materialGain' => false,
        'materialCut' => true,
        'materialCord' => false,
        'materialPocket' => false,
        'materialLamination' => false,
        'materialStickToPlastic' => false,
        'materialCoupling' => [
          'price' => 0,
          'margin' => 10,
          'output' => 0
        ]
      ]
    ]
  ],
  'tkani' => [
    'materialsGroupNameRu' => 'ткани',
    'squarePriceGradation' => [1, 50, 150],
    'printTypeGradation' => ['720', '1440'],
    'materials' => [
      'flag' => [
        'materialNameRu' => 'флаговая ткань',
        'materialInfoUrl' => '#',
        'materialInfoTitle' => 'полиэстеровая ткань для флагов / изображение просвечивается с обратной стороны',
        'materialPrintTypeParametrs' => [
          '1440' => [
            'nameRu' => 'интерьерная',
            'printerModel' => 'ph 3278',
            'printParam' => 'проход: 4 / настройка: quality',
            'printTypeInfoUrl' => '#',
            'printTypeInfoTitle' => '1440 dpi ECO / высокая детализация / без запаха / применяется как в помещение, так и на улице',
            'printerMaxWidth' => 3200,
            'priceGradation' => [600, 500, 400],
            'materialPrice' => 16,
            'output' => 12
          ]
        ],
        'materialFormats' => [1260],
        'materialTechField' => 0,
        'materialPrice' => 190,
        // free free10  material full
        'materialOverspendingDefaultMetrod' => 'material',
        'materialMargin' => [
          'x' => 20,
          'y' => 50
        ],
        'materialWeight' => 0.1,
        'materialCustomOptionalWork' => false,
        'materialCringle' => false,
        'materialGain' => false,
        'materialCut' => true,
        'materialCord' => false,
        'materialPocket' => false,
        'materialLamination' => false,
        'materialStickToPlastic' => false,
        'materialCoupling' => [
          'price' => 0,
          'margin' => 10,
          'output' => 0
        ]
      ]
    ]
  ],
  'materialKlienta' => [
    'materialsGroupNameRu' => 'материал клиента',
    'squarePriceGradation' => [1, 50, 150],
    'printTypeGradation' => ['720', '1440'],
    'materials' => [
      'bannerKlienta' => [
        'materialNameRu' => 'баннеры / сетки клиента',
        'materialInfoUrl' => '#',
        'materialInfoTitle' => 'материал должен подходить для сольвентной печати / допустимый процент брака - 10% / цены могут меняться в зависимости от особенностей нанесения на материал',
        'materialPrintTypeParametrs' => [
          '720' => [
            'nameRu' => 'широкоформатная',
            'printerModel' => 'ph 3286',
            'printParam' => 'проход: 4 / скорость: high / заливка: 80 / настройка: 4',
            'printTypeInfoUrl' => '#',
            'printTypeInfoTitle' => '720 dpi / cредняя детализация / есть запах / применяется на улице',
            'printerMaxWidth' => 3200,
            'priceGradation' => [210, 120, 85],
            'materialPrice' => 5,
            'output' => 73
          ],
          '1440' => [
            'nameRu' => 'интерьерная',
            'printerModel' => 'ph 3278',
            'printParam' => 'проход: 4 / настройка: quality',
            'printTypeInfoUrl' => '#',
            'printTypeInfoTitle' => '1440 dpi ECO / высокая детализация / без запаха / применяется как в помещение, так и на улице',
            'printerMaxWidth' => 3200,
            'priceGradation' => [270, 210, 150],
            'materialPrice' => 16,
            'output' => 15.5
          ]
        ],
        'materialFormats' => [1000, 1100, 1200, 1300, 1400, 1500, 1600, 1700, 1800, 1900, 2000, 2100, 2200, 2300, 2400, 2500, 2600, 2700, 2800, 2900, 3000, 3100, 3200],
        'materialTechField' => 50,
        'materialPrice' => 0,
        // free free10  material full
        'materialOverspendingDefaultMetrod' => 'material',
        'materialMargin' => [
          'x' => 50,
          'y' => 0
        ],
        'materialWeight' => 0.5,
        'materialCustomOptionalWork' => true,
        'materialCringle' => true,
        'materialGain' => true,
        'materialCut' => true,
        'materialCord' => true,
        'materialPocket' => true,
        'materialLamination' => false,
        'materialStickToPlastic' => false,
        'materialCoupling' => [
          'price' => 40,
          'margin' => 50,
          'output' => 40
        ]
      ],
      'plenkaKlienta' => [
        'materialNameRu' => 'пленки / холсты клиента',
        'materialInfoUrl' => '#',
        'materialInfoTitle' => 'материал должен подходить для сольвентной печати / допустимый процент брака - 10% / цены могут меняться в зависимости от особенностей нанесения на материал',
        'materialPrintTypeParametrs' => [
          '720' => [
            'nameRu' => 'широкоформатная',
            'printerModel' => 'ph 3286',
            'printParam' => 'проход: 4 / скорость: high / заливка: 70 / настройка: 2',
            'printTypeInfoUrl' => '#',
            'printTypeInfoTitle' => '720 dpi / cредняя детализация / есть запах / применяется на улице',
            'printerMaxWidth' => 3200,
            'priceGradation' => [230, 140, 90],
            'materialPrice' => 5,
            'output' => 40
          ],
          '1440' => [
            'nameRu' => 'интерьерная',
            'printerModel' => 'ph 3278',
            'printParam' => 'проход: 4 / настройка: quality',
            'printTypeInfoUrl' => '#',
            'printTypeInfoTitle' => '1440 dpi ECO / высокая детализация / без запаха / применяется как в помещение, так и на улице',
            'printerMaxWidth' => 3200,
            'priceGradation' => [280, 220, 160],
            'materialPrice' => 16,
            'output' => 12
          ]
        ],
        'materialFormats' => [1050, 1250, 1300, 1400, 1500, 1520, 1600, 1700, 1800, 1900, 2000],
        'materialTechField' => 0,
        'materialPrice' => 0,
        // free free10  material full
        'materialOverspendingDefaultMetrod' => 'material',
        'materialMargin' => [
          'x' => 20,
          'y' => 25
        ],
        'materialWeight' => 0.3,
        'materialCustomOptionalWork' => false,
        'materialCringle' => false,
        'materialGain' => false,
        'materialCut' => true,
        'materialCord' => false,
        'materialPocket' => false,
        'materialLamination' => true,
        'materialStickToPlastic' => true,
        'materialCoupling' => [
          'price' => 0,
          'margin' => 10,
          'output' => 0
        ]
      ]
    ]
  ]
];
