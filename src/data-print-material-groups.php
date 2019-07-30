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
    'squarePriceGradation' => [1, 17, 150, 300],
    'printTypeGradation' => ['540', '720', '720i', '1440i'],
    'materials' => [
      'banLamin440' => [
        'materialNameRu' => 'баннер ламинированный 440 гр',
        'materialInfoUrl' => '#',
        'materialInfoTitle' => 'бюджетный баннер / подходит как для помещения так и для улицы / имеет явную текстуру / средний срок эксплуатации около 1 года',
        'materialPrintTypeParametrs' => [
          '540' => [
            'nameRu' => '540 dpi широкоформатная',
            'printerModel' => 'ph 3286',
            'printParam' => 'проход: 3 / скорость: normal / заливка: 70 / настройка: 5',
            'printTypeInfoUrl' => '#',
            'printTypeInfoTitle' => 'средняя яркость / средняя детализация / есть запах / применяется на улице',
            'printerMaxWidth' => 3200,
            'priceGradation' => [220, 200, 165, 150],
            'materialPrice' => 5,
            // м2 в час
            'output' => 73
          ],
          '720' => [
            'nameRu' => '720 dpi широкоформатная',
            'printerModel' => 'ph 3286',
            'printParam' => 'проход: 4 / скорость: high / заливка: 80 / настройка: 5',
            'printTypeInfoUrl' => '#',
            'printTypeInfoTitle' => 'высокая яркость / средняя детализация / есть запах / применяется на улице',
            'printerMaxWidth' => 3200,
            'priceGradation' => [265, 240, 190],
            'materialPrice' => 7,
            'output' => 52
          ],
          '720i' => [
            'nameRu' => '720 dpi интерьерная',
            'printerModel' => 'ph 3278',
            'printParam' => 'проход: 4 / настройка: quality',
            'printTypeInfoUrl' => '#',
            'printTypeInfoTitle' => 'средняя яркость / высокая детализация / без запаха / применяется как в помещение, так и на улице',
            'printerMaxWidth' => 3200,
            'priceGradation' => [345, 295, 210],
            'materialPrice' => 16,
            'output' => 15.5
          ],
          '1440i' => [
            'nameRu' => '1440 dpi интерьерная',
            'printerModel' => 'ph 3278',
            'printParam' => 'проход: 6 / настройка: high quality',
            'printTypeInfoUrl' => '#',
            'printTypeInfoTitle' => 'высокая яркость / высокая детализация / без запаха / применяется как в помещение, так и на улице',
            'printerMaxWidth' => 3200,
            'priceGradation' => [390, 350, 255],
            'materialPrice' => 18,
            'output' => 11.2
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
      'banLamin300' => [
        'materialNameRu' => 'баннер ламинированный 300 гр',
        'materialInfoUrl' => '#',
        'materialInfoTitle' => 'бюджетный баннер / имеет явную текстуру / низкой прочности / рассчитан на короткий срок использования',
        'materialPrintTypeParametrs' => [
          '540' => [
            'nameRu' => '540 dpi широкоформатная',
            'printerModel' => 'ph 3286',
            'printParam' => 'проход: 3 / скорость: normal / заливка: 70 / настройка: 7',
            'printTypeInfoUrl' => '#',
            'printTypeInfoTitle' => 'средняя яркость / средняя детализация / есть запах / применяется на улице',
            'printerMaxWidth' => 3200,
            'priceGradation' => [170, 150, 135, 100],
            'materialPrice' => 5,
            // м2 в час
            'output' => 73
          ],
          '720' => [
            'nameRu' => '720 dpi широкоформатная',
            'printerModel' => 'ph 3286',
            'printParam' => 'проход: 4 / скорость: high / заливка: 80 / настройка: 7',
            'printTypeInfoUrl' => '#',
            'printTypeInfoTitle' => 'высокая яркость / средняя детализация / есть запах / применяется на улице',
            'printerMaxWidth' => 3200,
            'priceGradation' => [200, 180, 155],
            'materialPrice' => 7,
            'output' => 52
          ],
        ],
        'materialFormats' => [3200],
        'materialTechField' => 50,
        'materialPrice' => 50,
        // free free10  material full
        'materialOverspendingDefaultMetrod' => 'material',
        'materialMargin' => [
          'x' => 50,
          'y' => 0
        ],
        'materialWeight' => 0.3,
        'materialCustomOptionalWork' => true,
        'materialCringle' => true,
        'materialGain' => false,
        'materialCut' => true,
        'materialCord' => false,
        'materialPocket' => false,
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
          '540' => [
            'nameRu' => '540 dpi широкоформатная',
            'printerModel' => 'ph 3286',
            'printParam' => 'проход: 3 / скорость: normal / заливка: 80 / настройка: 4',
            'printTypeInfoUrl' => '#',
            'printTypeInfoTitle' => 'средняя яркость / средняя детализация / есть запах / применяется на улице',
            'printerMaxWidth' => 3200,
            'priceGradation' => [265, 245, 210, 185],
            'materialPrice' => 5,
            'output' => 73
          ],
          '720' => [
            'nameRu' => '720 dpi широкоформатная',
            'printerModel' => 'ph 3286',
            'printParam' => 'проход: 4 / скорость: high / заливка: 80 / настройка: 4',
            'printTypeInfoUrl' => '#',
            'printTypeInfoTitle' => 'высокая яркость / средняя детализация / есть запах / применяется на улице',
            'printerMaxWidth' => 3200,
            'priceGradation' => [305, 285, 230],
            'materialPrice' => 7,
            'output' => 52
          ],
          '720i' => [
            'nameRu' => '720 dpi интерьерная',
            'printerModel' => 'ph 3278',
            'printParam' => 'проход: 4 / настройка: quality',
            'printTypeInfoUrl' => '#',
            'printTypeInfoTitle' => 'средняя яркость / высокая детализация / без запаха / применяется как в помещение, так и на улице',
            'printerMaxWidth' => 3200,
            'priceGradation' => [420, 370, 285],
            'materialPrice' => 16,
            'output' => 15.5
          ],
          '1440i' => [
            'nameRu' => '1440 dpi интерьерная',
            'printerModel' => 'ph 3278',
            'printParam' => 'проход: 6 / настройка: high quality',
            'printTypeInfoUrl' => '#',
            'printTypeInfoTitle' => 'высокая яркость / высокая детализация / без запаха / применяется как в помещение, так и на улице',
            'printerMaxWidth' => 3200,
            'priceGradation' => [460, 410, 320],
            'materialPrice' => 18,
            'output' => 11.2
          ]
        ],
        'materialFormats' => [2500, 3200],
        'materialTechField' => 50,
        'materialPrice' => 105,
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
          '540' => [
            'nameRu' => '540 dpi широкоформатная',
            'printerModel' => 'ph 3286',
            'printParam' => 'проход: 3 / скорость: normal / заливка: 80 / настройка: 4',
            'printTypeInfoUrl' => '#',
            'printTypeInfoTitle' => 'средняя яркость / средняя детализация / есть запах / применяется на улице',
            'printerMaxWidth' => 3200,
            'priceGradation' => [270, 250, 215, 190],
            'materialPrice' => 5,
            'output' => 73
          ],
          '720' => [
            'nameRu' => '720 dpi широкоформатная',
            'printerModel' => 'ph 3286',
            'printParam' => 'проход: 4 / скорость: high / заливка: 80 / настройка: 4',
            'printTypeInfoUrl' => '#',
            'printTypeInfoTitle' => 'высокая яркость / средняя детализация / есть запах / применяется на улице',
            'printerMaxWidth' => 3200,
            'priceGradation' => [310, 290, 235],
            'materialPrice' => 7,
            'output' => 52
          ],
          '720i' => [
            'nameRu' => '720 dpi интерьерная',
            'printerModel' => 'ph 3278',
            'printParam' => 'проход: 4 / настройка: quality',
            'printTypeInfoUrl' => '#',
            'printTypeInfoTitle' => 'средняя яркость / высокая детализация / без запаха / применяется как в помещение, так и на улице',
            'printerMaxWidth' => 3200,
            'priceGradation' => [420, 370, 285],
            'materialPrice' => 16,
            'output' => 15.5
          ],
          '1440i' => [
            'nameRu' => '1440 dpi интерьерная',
            'printerModel' => 'ph 3278',
            'printParam' => 'проход: 6 / настройка: high quality',
            'printTypeInfoUrl' => '#',
            'printTypeInfoTitle' => 'высокая яркость / высокая детализация / без запаха / применяется как в помещение, так и на улице',
            'printerMaxWidth' => 3200,
            'priceGradation' => [460, 410, 325],
            'materialPrice' => 18,
            'output' => 11.2
          ]
        ],
        'materialFormats' => [3200],
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
      'banTrans' => [
        'materialNameRu' => 'баннер транслюцентный 600 гр',
        'materialInfoUrl' => '#',
        'materialInfoTitle' => 'транслюцентный баннер пропускает свет / используется для световых коробов (лайтбоксов) / плотный / однородная текстура / возможна эксплуатация до 3 лет',
        'materialPrintTypeParametrs' => [
          '540' => [
            'nameRu' => '540 dpi широкоформатная',
            'printerModel' => 'ph 3286',
            'printParam' => 'проход: 4 / скорость: high / заливка: 70 / настройка: 7',
            'printTypeInfoUrl' => '#',
            'printTypeInfoTitle' => 'средняя яркость / средняя детализация / есть запах / применяется на улице',
            'printerMaxWidth' => 3200,
            'priceGradation' => [295, 265, 230, 185],
            'materialPrice' => 5,
            'output' => 73
          ],
          '720' => [
            'nameRu' => '720 dpi широкоформатная',
            'printerModel' => 'ph 3286',
            'printParam' => 'проход: 3 / скорость: high / заливка: 80 / настройка: 7',
            'printTypeInfoUrl' => '#',
            'printTypeInfoTitle' => 'высокая яркость / средняя детализация / есть запах / применяется на улице',
            'printerMaxWidth' => 3200,
            'priceGradation' => [335, 305, 255],
            'materialPrice' => 7,
            'output' => 52
          ],
          '720i' => [
            'nameRu' => '720 dpi интерьерная',
            'printerModel' => 'ph 3278',
            'printParam' => 'проход: 4 / настройка: quality',
            'printTypeInfoUrl' => '#',
            'printTypeInfoTitle' => 'средняя яркость / высокая детализация / без запаха / применяется как в помещение, так и на улице',
            'printerMaxWidth' => 3200,
            'priceGradation' => [420, 365, 305],
            'materialPrice' => 16,
            'output' => 15.5
          ],
          '1440i' => [
            'nameRu' => '1440 dpi интерьерная',
            'printerModel' => 'ph 3278',
            'printParam' => 'проход: 6 / настройка: high quality',
            'printTypeInfoUrl' => '#',
            'printTypeInfoTitle' => 'высокая яркость / высокая детализация / без запаха / применяется как в помещение, так и на улице',
            'printerMaxWidth' => 3200,
            'priceGradation' => [455, 425, 340],
            'materialPrice' => 18,
            'output' => 11.2
          ]
        ],
        'materialFormats' => [1600],
        'materialTechField' => 50,
        'materialPrice' => 100,
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
    'squarePriceGradation' => [1, 17, 150, 300],
    'printTypeGradation' => ['540', '720', '720i', '1440i'],
    'materials' => [
      'orajetBelGl' => [
        'materialNameRu' => 'orajet белый глянцевый',
        'materialInfoUrl' => '#',
        'materialInfoTitle' => 'белая самоклеющаяся пленка высокого качества / глянцевая / производство Германия',
        'materialPrintTypeParametrs' => [
          '540' => [
            'nameRu' => '540 dpi широкоформатная',
            'printerModel' => 'ph 3286',
            'printParam' => 'проход: 4 / скорость: high / заливка: 70 / настройка: 2',
            'printTypeInfoUrl' => '#',
            'printTypeInfoTitle' => 'средняя яркость / средняя детализация / есть запах / применяется на улице',
            'printerMaxWidth' => 3200,
            'priceGradation' => [275, 245, 215, 170],
            'materialPrice' => 5,
            'output' => 40
          ],
          '720' => [
            'nameRu' => '720 dpi широкоформатная',
            'printerModel' => 'ph 3286',
            'printParam' => 'проход: 4 / скорость: high / в одну сторону / заливка: 80 / настройка: 2',
            'printTypeInfoUrl' => '#',
            'printTypeInfoTitle' => 'высокая яркость / средняя детализация / есть запах / применяется на улице',
            'printerMaxWidth' => 3200,
            'priceGradation' => [300, 280, 215],
            'materialPrice' => 7,
            'output' => 24
          ],
          '720i' => [
            'nameRu' => '720 dpi интерьерная',
            'printerModel' => 'ph 3278',
            'printParam' => 'проход: 4 / настройка: quality',
            'printTypeInfoUrl' => '#',
            'printTypeInfoTitle' => 'средняя яркость / высокая детализация / без запаха / применяется как в помещение, так и на улице',
            'printerMaxWidth' => 3200,
            'priceGradation' => [385, 335, 230],
            'materialPrice' => 16,
            'output' => 12
          ],
          '1440i' => [
            'nameRu' => '1440 dpi интерьерная',
            'printerModel' => 'ph 3278',
            'printParam' => 'проход: 6 / настройка: high quality',
            'printTypeInfoUrl' => '#',
            'printTypeInfoTitle' => 'высокая яркость / высокая детализация / без запаха / применяется как в помещение, так и на улице',
            'printerMaxWidth' => 3200,
            'priceGradation' => [425, 365, 270],
            'materialPrice' => 18,
            'output' => 8.5
          ]
        ],
        'materialFormats' => [1050, 1250, 1520],
        'materialTechField' => 0,
        'materialPrice' => 120,
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
          '540' => [
            'nameRu' => '540 dpi широкоформатная',
            'printerModel' => 'ph 3286',
            'printParam' => 'проход: 4 / скорость: high / заливка: 70 / настройка: 2',
            'printTypeInfoUrl' => '#',
            'printTypeInfoTitle' => 'средняя яркость / средняя детализация / есть запах / применяется на улице',
            'printerMaxWidth' => 3200,
            'priceGradation' => [275, 245, 215, 170],
            'materialPrice' => 5,
            'output' => 40
          ],
          '720' => [
            'nameRu' => '720 dpi широкоформатная',
            'printerModel' => 'ph 3286',
            'printParam' => 'проход: 4 / скорость: high / в одну сторону / заливка: 80 / настройка: 2',
            'printTypeInfoUrl' => '#',
            'printTypeInfoTitle' => 'высокая яркость / средняя детализация / есть запах / применяется на улице',
            'printerMaxWidth' => 3200,
            'priceGradation' => [300, 280, 215],
            'materialPrice' => 7,
            'output' => 24
          ],
          '720i' => [
            'nameRu' => '720 dpi интерьерная',
            'printerModel' => 'ph 3278',
            'printParam' => 'проход: 4 / настройка: quality',
            'printTypeInfoUrl' => '#',
            'printTypeInfoTitle' => 'средняя яркость / высокая детализация / без запаха / применяется как в помещение, так и на улице',
            'printerMaxWidth' => 3200,
            'priceGradation' => [385, 335, 230],
            'materialPrice' => 16,
            'output' => 12
          ],
          '1440i' => [
            'nameRu' => '1440 dpi интерьерная',
            'printerModel' => 'ph 3278',
            'printParam' => 'проход: 6 / настройка: high quality',
            'printTypeInfoUrl' => '#',
            'printTypeInfoTitle' => 'высокая яркость / высокая детализация / без запаха / применяется как в помещение, так и на улице',
            'printerMaxWidth' => 3200,
            'priceGradation' => [425, 365, 270],
            'materialPrice' => 18,
            'output' => 8.5
          ]
        ],
        'materialFormats' => [1050, 1250, 1520],
        'materialTechField' => 0,
        'materialPrice' => 120,
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
          '540' => [
            'nameRu' => '540 dpi широкоформатная',
            'printerModel' => 'ph 3286',
            'printParam' => 'проход: 4 / скорость: high / заливка: 70 / настройка: 2',
            'printTypeInfoUrl' => '#',
            'printTypeInfoTitle' => 'средняя яркость / средняя детализация / есть запах / применяется на улице',
            'printerMaxWidth' => 3200,
            'priceGradation' => [275, 245, 215, 170],
            'materialPrice' => 5,
            'output' => 40
          ],
          '720' => [
            'nameRu' => '720 dpi широкоформатная',
            'printerModel' => 'ph 3286',
            'printParam' => 'проход: 4 / скорость: high / в одну сторону / заливка: 80 / настройка: 2',
            'printTypeInfoUrl' => '#',
            'printTypeInfoTitle' => 'высокая яркость / средняя детализация / есть запах / применяется на улице',
            'printerMaxWidth' => 3200,
            'priceGradation' => [300, 280, 215],
            'materialPrice' => 7,
            'output' => 24
          ],
          '720i' => [
            'nameRu' => '720 dpi интерьерная',
            'printerModel' => 'ph 3278',
            'printParam' => 'проход: 4 / настройка: quality',
            'printTypeInfoUrl' => '#',
            'printTypeInfoTitle' => 'средняя яркость / высокая детализация / без запаха / применяется как в помещение, так и на улице',
            'printerMaxWidth' => 3200,
            'priceGradation' => [385, 335, 230],
            'materialPrice' => 16,
            'output' => 12
          ],
          '1440i' => [
            'nameRu' => '1440 dpi интерьерная',
            'printerModel' => 'ph 3278',
            'printParam' => 'проход: 6 / настройка: high quality',
            'printTypeInfoUrl' => '#',
            'printTypeInfoTitle' => 'высокая яркость / высокая детализация / без запаха / применяется как в помещение, так и на улице',
            'printerMaxWidth' => 3200,
            'priceGradation' => [425, 365, 270],
            'materialPrice' => 18,
            'output' => 8.5
          ]
        ],
        'materialFormats' => [1050, 1250, 1520],
        'materialTechField' => 0,
        'materialPrice' => 120,
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
          '540' => [
            'nameRu' => '540 dpi широкоформатная',
            'printerModel' => 'ph 3286',
            'printParam' => 'проход: 4 / скорость: high / заливка: 70 / настройка: 2',
            'printTypeInfoUrl' => '#',
            'printTypeInfoTitle' => 'средняя яркость / средняя детализация / есть запах / применяется на улице',
            'printerMaxWidth' => 3200,
            'priceGradation' => [275, 245, 215, 170],
            'materialPrice' => 5,
            'output' => 40
          ],
          '720' => [
            'nameRu' => '720 dpi широкоформатная',
            'printerModel' => 'ph 3286',
            'printParam' => 'проход: 4 / скорость: high / в одну сторону / заливка: 80 / настройка: 2',
            'printTypeInfoUrl' => '#',
            'printTypeInfoTitle' => 'высокая яркость / средняя детализация / есть запах / применяется на улице',
            'printerMaxWidth' => 3200,
            'priceGradation' => [300, 280, 215],
            'materialPrice' => 7,
            'output' => 24
          ],
          '720i' => [
            'nameRu' => '720 dpi интерьерная',
            'printerModel' => 'ph 3278',
            'printParam' => 'проход: 4 / настройка: quality',
            'printTypeInfoUrl' => '#',
            'printTypeInfoTitle' => 'средняя яркость / высокая детализация / без запаха / применяется как в помещение, так и на улице',
            'printerMaxWidth' => 3200,
            'priceGradation' => [385, 335, 230],
            'materialPrice' => 16,
            'output' => 12
          ],
          '1440i' => [
            'nameRu' => '1440 dpi интерьерная',
            'printerModel' => 'ph 3278',
            'printParam' => 'проход: 6 / настройка: high quality',
            'printTypeInfoUrl' => '#',
            'printTypeInfoTitle' => 'высокая яркость / высокая детализация / без запаха / применяется как в помещение, так и на улице',
            'printerMaxWidth' => 3200,
            'priceGradation' => [425, 365, 270],
            'materialPrice' => 18,
            'output' => 8.5
          ]
        ],
        'materialFormats' => [1050, 1250, 1520],
        'materialTechField' => 0,
        'materialPrice' => 120,
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
          '540' => [
            'nameRu' => '540 dpi широкоформатная',
            'printerModel' => 'ph 3286',
            'printParam' => 'проход: 4 / скорость: high / заливка: 70 / настройка: 2',
            'printTypeInfoUrl' => '#',
            'printTypeInfoTitle' => 'средняя яркость / средняя детализация / есть запах / применяется на улице',
            'printerMaxWidth' => 3200,
            'priceGradation' => [490, 440, 420, 355],
            'materialPrice' => 5,
            'output' => 40
          ],
          '720' => [
            'nameRu' => '720 dpi широкоформатная',
            'printerModel' => 'ph 3286',
            'printParam' => 'проход: 4 / скорость: high / в одну сторону / заливка: 80 / настройка: 2',
            'printTypeInfoUrl' => '#',
            'printTypeInfoTitle' => 'высокая яркость / средняя детализация / есть запах / применяется на улице',
            'printerMaxWidth' => 3200,
            'priceGradation' => [550, 500, 455],
            'materialPrice' => 7,
            'output' => 24
          ]
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
          '540' => [
            'nameRu' => '540 dpi широкоформатная',
            'printerModel' => 'ph 3286',
            'printParam' => 'проход: 4 / скорость: high / заливка: 70 / настройка: 2',
            'printTypeInfoUrl' => '#',
            'printTypeInfoTitle' => 'средняя яркость / средняя детализация / есть запах / применяется на улице',
            'printerMaxWidth' => 3200,
            'priceGradation' => [205, 180, 155, 120],
            'materialPrice' => 5,
            'output' => 40
          ],
          '720' => [
            'nameRu' => '720 dpi широкоформатная',
            'printerModel' => 'ph 3286',
            'printParam' => 'проход: 4 / скорость: high / в одну сторону / заливка: 80 / настройка: 2',
            'printTypeInfoUrl' => '#',
            'printTypeInfoTitle' => 'высокая яркость / средняя детализация / есть запах / применяется на улице',
            'printerMaxWidth' => 3200,
            'priceGradation' => [270, 215, 160],
            'materialPrice' => 7,
            'output' => 24
          ],
          '720i' => [
            'nameRu' => '720 dpi интерьерная',
            'printerModel' => 'ph 3278',
            'printParam' => 'проход: 4 / настройка: quality',
            'printTypeInfoUrl' => '#',
            'printTypeInfoTitle' => 'средняя яркость / высокая детализация / без запаха / применяется как в помещение, так и на улице',
            'printerMaxWidth' => 3200,
            'priceGradation' => [285, 245, 170],
            'materialPrice' => 16,
            'output' => 12
          ],
          '1440i' => [
            'nameRu' => '1440 dpi интерьерная',
            'printerModel' => 'ph 3278',
            'printParam' => 'проход: 6 / настройка: high quality',
            'printTypeInfoUrl' => '#',
            'printTypeInfoTitle' => 'высокая яркость / высокая детализация / без запаха / применяется как в помещение, так и на улице',
            'printerMaxWidth' => 3200,
            'priceGradation' => [315, 275, 200],
            'materialPrice' => 18,
            'output' => 8.5
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
    'squarePriceGradation' => [1, 17, 150, 300],
    'printTypeGradation' => ['540', '720', '720i', '1440i'],
    'materials' => [
      'setka250' => [
        'materialNameRu' => 'сетка 250 гр',
        'materialInfoUrl' => '#',
        'materialInfoTitle' => 'сетка из за перфарированной структуры пропускает воздух, что значительно снижает ветровую нагрузку на конструкцию',
        'materialPrintTypeParametrs' => [
          '540' => [
            'nameRu' => '540 dpi широкоформатная',
            'printerModel' => 'ph 3286',
            'printParam' => 'проход: 3 / скорость: high / заливка: 80 / настройка: 3',
            'printTypeInfoUrl' => '#',
            'printTypeInfoTitle' => 'средняя яркость / средняя детализация / есть запах / применяется на улице',
            'printerMaxWidth' => 3200,
            'priceGradation' => [275, 255, 190, 170],
            'materialPrice' => 5,
            'output' => 73
          ],
          '720' => [
            'nameRu' => '720 dpi широкоформатная',
            'printerModel' => 'ph 3286',
            'printParam' => 'проход: 3 / скорость: high / заливка: 100 / настройка: 3',
            'printTypeInfoUrl' => '#',
            'printTypeInfoTitle' => 'высокая яркость / средняя детализация / есть запах / применяется на улице',
            'printerMaxWidth' => 3200,
            'priceGradation' => [315, 295, 235],
            'materialPrice' => 7,
            'output' => 52
          ]
        ],
        'materialFormats' => [3200],
        'materialTechField' => 50,
        'materialPrice' => 95,
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
    'squarePriceGradation' => [1, 17, 150, 300],
    'printTypeGradation' => ['540', '720', '720i', '1440i'],
    'materials' => [
      'bumagaBlueback' => [
        'materialNameRu' => 'блюбэк',
        'materialInfoUrl' => '#',
        'materialInfoTitle' => 'бюджетная бумага / плотность 180-200 гр / с голубой обратной стороной / используется для уличных афиш а так же щитов',
        'materialPrintTypeParametrs' => [
          '540' => [
            'nameRu' => '540 dpi широкоформатная',
            'printerModel' => 'ph 3286',
            'printParam' => 'проход: 3 / скорость: high / заливка: 70 / настройка: 6',
            'printTypeInfoUrl' => '#',
            'printTypeInfoTitle' => 'средняя яркость / средняя детализация / есть запах / применяется на улице',
            'printerMaxWidth' => 3200,
            'priceGradation' => [140, 130, 120, 80],
            'materialPrice' => 5,
            'output' => 40
          ],
          '720' => [
            'nameRu' => '720 dpi широкоформатная',
            'printerModel' => 'ph 3286',
            'printParam' => 'проход: 4 / скорость: high / в одну сторону /заливка: 80 / настройка: 6',
            'printTypeInfoUrl' => '#',
            'printTypeInfoTitle' => 'высокая яркость / средняя детализация / есть запах / применяется на улице',
            'printerMaxWidth' => 3200,
            'priceGradation' => [175, 155, 125],
            'materialPrice' => 7,
            'output' => 24
          ],
          '720i' => [
            'nameRu' => '720 dpi интерьерная',
            'printerModel' => 'ph 3278',
            'printParam' => 'проход: 4 / настройка: quality',
            'printTypeInfoUrl' => '#',
            'printTypeInfoTitle' => 'средняя яркость / высокая детализация / без запаха / применяется как в помещение, так и на улице',
            'printerMaxWidth' => 3200,
            'priceGradation' => [270, 220, 135],
            'materialPrice' => 16,
            'output' => 12
          ],
          '1440i' => [
            'nameRu' => '1440 dpi интерьерная',
            'printerModel' => 'ph 3278',
            'printParam' => 'проход: 6 / настройка: high quality',
            'printTypeInfoUrl' => '#',
            'printTypeInfoTitle' => 'высокая яркость / высокая детализация / без запаха / применяется как в помещение, так и на улице',
            'printerMaxWidth' => 3200,
            'priceGradation' => [310, 260, 175],
            'materialPrice' => 18,
            'output' => 8.5
          ]
        ],
        'materialFormats' => [1570],
        'materialTechField' => 0,
        'materialPrice' => 40,
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
          '540' => [
            'nameRu' => '540 dpi широкоформатная',
            'printerModel' => 'ph 3286',
            'printParam' => 'проход: 3 / скорость: high / заливка: 70 / настройка: 6',
            'printTypeInfoUrl' => '#',
            'printTypeInfoTitle' => 'средняя яркость / средняя детализация / есть запах / применяется на улице',
            'printerMaxWidth' => 3200,
            'priceGradation' => [170, 150, 130, 100],
            'materialPrice' => 5,
            'output' => 40
          ],
          '720' => [
            'nameRu' => '720 dpi широкоформатная',
            'printerModel' => 'ph 3286',
            'printParam' => 'проход: 4 / скорость: high / в одну сторону /заливка: 80 / настройка: 6',
            'printTypeInfoUrl' => '#',
            'printTypeInfoTitle' => 'высокая яркость / средняя детализация / есть запах / применяется на улице',
            'printerMaxWidth' => 3200,
            'priceGradation' => [195, 175, 135],
            'materialPrice' => 7,
            'output' => 24
          ],
          '720i' => [
            'nameRu' => '720 dpi интерьерная',
            'printerModel' => 'ph 3278',
            'printParam' => 'проход: 4 / настройка: quality',
            'printTypeInfoUrl' => '#',
            'printTypeInfoTitle' => 'средняя яркость / высокая детализация / без запаха / применяется как в помещение, так и на улице',
            'printerMaxWidth' => 3200,
            'priceGradation' => [290, 240, 175],
            'materialPrice' => 16,
            'output' => 12
          ],
          '1440i' => [
            'nameRu' => '1440 dpi интерьерная',
            'printerModel' => 'ph 3278',
            'printParam' => 'проход: 6 / настройка: high quality',
            'printTypeInfoUrl' => '#',
            'printTypeInfoTitle' => 'высокая яркость / высокая детализация / без запаха / применяется как в помещение, так и на улице',
            'printerMaxWidth' => 3200,
            'priceGradation' => [330, 280, 215],
            'materialPrice' => 18,
            'output' => 8.5
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
    'squarePriceGradation' => [1, 17, 150, 300],
    'printTypeGradation' => ['540', '720', '720i', '1440i'],
    'materials' => [
      'holstNat' => [
        'materialNameRu' => 'холст натуральный',
        'materialInfoUrl' => '#',
        'materialInfoTitle' => 'натуральный холст идентичен художественному / применяется для печати картин / репродукций / фотографий',
        'materialPrintTypeParametrs' => [
          '720i' => [
            'nameRu' => '720 dpi интерьерная',
            'printerModel' => 'ph 3278',
            'printParam' => 'проход: 4 / настройка: quality',
            'printTypeInfoUrl' => '#',
            'printTypeInfoTitle' => 'средняя яркость / высокая детализация / без запаха / применяется как в помещение, так и на улице',
            'printerMaxWidth' => 3200,
            'priceGradation' => [900, 800, 700],
            'materialPrice' => 16,
            'output' => 12
          ],
          '1440i' => [
            'nameRu' => '1440 dpi интерьерная',
            'printerModel' => 'ph 3278',
            'printParam' => 'проход: 6 / настройка: high quality',
            'printTypeInfoUrl' => '#',
            'printTypeInfoTitle' => 'высокая яркость / высокая детализация / без запаха / применяется как в помещение, так и на улице',
            'printerMaxWidth' => 3200,
            'priceGradation' => [1000, 900, 800],
            'materialPrice' => 18,
            'output' => 8.5
          ]
        ],
        'materialFormats' => [1520],
        'materialTechField' => 0,
        'materialPrice' => 500,
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
    'squarePriceGradation' => [1, 17, 150, 300],
    'printTypeGradation' => ['540', '720', '720i', '1440i'],
    'materials' => [
      'flag' => [
        'materialNameRu' => 'флаговая ткань',
        'materialInfoUrl' => '#',
        'materialInfoTitle' => 'полиэстеровая ткань для флагов / изображение просвечивается с обратной стороны',
        'materialPrintTypeParametrs' => [
          '540' => [
            'nameRu' => '540 dpi широкоформатная',
            'printerModel' => 'ph 3286',
            'printParam' => '???',
            'printTypeInfoUrl' => '#',
            'printTypeInfoTitle' => 'средняя яркость / средняя детализация / есть запах / применяется на улице',
            'printerMaxWidth' => 3200,
            'priceGradation' => [210, 195, 155, 130],
            'materialPrice' => 5,
            'output' => 40
          ],
          '720' => [
            'nameRu' => '720 dpi широкоформатная',
            'printerModel' => 'ph 3286',
            'printParam' => '???',
            'printTypeInfoUrl' => '#',
            'printTypeInfoTitle' => 'высокая яркость / средняя детализация / есть запах / применяется на улице',
            'printerMaxWidth' => 3200,
            'priceGradation' => [270, 255, 185],
            'materialPrice' => 7,
            'output' => 24
          ],
          '720i' => [
            'nameRu' => '720 dpi интерьерная',
            'printerModel' => 'ph 3278',
            'printParam' => 'проход: 4 / настройка: quality',
            'printTypeInfoUrl' => '#',
            'printTypeInfoTitle' => 'средняя яркость / высокая детализация / без запаха / применяется как в помещение, так и на улице',
            'printerMaxWidth' => 3200,
            'priceGradation' => [430, 400, 325],
            'materialPrice' => 16,
            'output' => 12
          ],
          '1440i' => [
            'nameRu' => '1440 dpi интерьерная',
            'printerModel' => 'ph 3278',
            'printParam' => 'проход: 6 / настройка: high quality',
            'printTypeInfoUrl' => '#',
            'printTypeInfoTitle' => 'высокая яркость / высокая детализация / без запаха / применяется как в помещение, так и на улице',
            'printerMaxWidth' => 3200,
            'priceGradation' => [470, 450, 365],
            'materialPrice' => 18,
            'output' => 8.5
          ]
        ],
        'materialFormats' => [1260],
        'materialTechField' => 0,
        'materialPrice' => 130,
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
    'squarePriceGradation' => [1, 17, 150, 300],
    'printTypeGradation' => ['540', '720', '720i', '1440i'],
    'materials' => [
      'bannerKlienta' => [
        'materialNameRu' => 'баннеры / сетки клиента',
        'materialInfoUrl' => '#',
        'materialInfoTitle' => 'материал должен подходить для сольвентной печати / допустимый процент брака - 10% / цены могут меняться в зависимости от особенностей нанесения на материал',
        'materialPrintTypeParametrs' => [
          '540' => [
            'nameRu' => '540 dpi широкоформатная',
            'printerModel' => 'ph 3286',
            'printParam' => 'проход: 4 / скорость: high / заливка: 70 / настройка: 4',
            'printTypeInfoUrl' => '#',
            'printTypeInfoTitle' => 'средняя яркость / средняя детализация / есть запах / применяется на улице',
            'printerMaxWidth' => 3200,
            'priceGradation' => [170, 140, 105, 75],
            'materialPrice' => 5,
            'output' => 73
          ],
          '720' => [
            'nameRu' => '720 dpi широкоформатная',
            'printerModel' => 'ph 3286',
            'printParam' => 'проход: 4 / скорость: high / заливка: 80 / настройка: 4',
            'printTypeInfoUrl' => '#',
            'printTypeInfoTitle' => 'высокая яркость / средняя детализация / есть запах / применяется на улице',
            'printerMaxWidth' => 3200,
            'priceGradation' => [200, 180, 125],
            'materialPrice' => 7,
            'output' => 52
          ],
          '720i' => [
            'nameRu' => '720 dpi интерьерная',
            'printerModel' => 'ph 3278',
            'printParam' => 'проход: 4 / настройка: quality',
            'printTypeInfoUrl' => '#',
            'printTypeInfoTitle' => 'средняя яркость / высокая детализация / без запаха / применяется как в помещение, так и на улице',
            'printerMaxWidth' => 3200,
            'priceGradation' => [310, 260, 175],
            'materialPrice' => 16,
            'output' => 15.5
          ],
          '1440i' => [
            'nameRu' => '1440 dpi интерьерная',
            'printerModel' => 'ph 3278',
            'printParam' => 'проход: 6 / настройка: high quality',
            'printTypeInfoUrl' => '#',
            'printTypeInfoTitle' => 'высокая яркость / высокая детализация / без запаха / применяется как в помещение, так и на улице',
            'printerMaxWidth' => 3200,
            'priceGradation' => [350, 300, 215],
            'materialPrice' => 18,
            'output' => 11.2
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
          '540' => [
            'nameRu' => '540 dpi широкоформатная',
            'printerModel' => 'ph 3286',
            'printParam' => 'проход: 4 / скорость: high / заливка: 70 / настройка: 2',
            'printTypeInfoUrl' => '#',
            'printTypeInfoTitle' => 'средняя яркость / средняя детализация / есть запах / применяется на улице',
            'printerMaxWidth' => 3200,
            'priceGradation' => [180, 140, 105, 75],
            'materialPrice' => 5,
            'output' => 40
          ],
          '720' => [
            'nameRu' => '720 dpi широкоформатная',
            'printerModel' => 'ph 3286',
            'printParam' => 'проход: 4 / скорость: high / в одну сторону / заливка: 80 / настройка: 2',
            'printTypeInfoUrl' => '#',
            'printTypeInfoTitle' => 'высокая яркость / средняя детализация / есть запах / применяется на улице',
            'printerMaxWidth' => 3200,
            'priceGradation' => [200, 165, 100],
            'materialPrice' => 7,
            'output' => 24
          ],
          '720i' => [
            'nameRu' => '720 dpi интерьерная',
            'printerModel' => 'ph 3278',
            'printParam' => 'проход: 4 / настройка: quality',
            'printTypeInfoUrl' => '#',
            'printTypeInfoTitle' => 'средняя яркость / высокая детализация / без запаха / применяется как в помещение, так и на улице',
            'printerMaxWidth' => 3200,
            'priceGradation' => [270, 210, 120],
            'materialPrice' => 16,
            'output' => 12
          ],
          '1440i' => [
            'nameRu' => '1440 dpi интерьерная',
            'printerModel' => 'ph 3278',
            'printParam' => 'проход: 6 / настройка: high quality',
            'printTypeInfoUrl' => '#',
            'printTypeInfoTitle' => 'высокая яркость / высокая детализация / без запаха / применяется как в помещение, так и на улице',
            'printerMaxWidth' => 3200,
            'priceGradation' => [310, 250, 155],
            'materialPrice' => 18,
            'output' => 8.5
          ]
        ],
        'materialFormats' => [1000, 1100, 1200, 1300, 1400, 1500, 1600, 1700, 1800, 1900, 2000],
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
