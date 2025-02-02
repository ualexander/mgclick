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
                        'priceGradation' => [320, 270, 235],
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
                        'priceGradation' => [440, 370, 320],
                        'materialPrice' => 16,
                        'output' => 15.5
                    ]
                ],
                'materialFormats' => [1100, 1600, 2200, 2500, 3200],
                'materialTechField' => 50,
                'materialPrice' => 170,
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
                        'priceGradation' => [370, 320, 300],
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
                        'priceGradation' => [520, 440, 410],
                        'materialPrice' => 16,
                        'output' => 15.5
                    ]
                ],
                'materialFormats' => [2500, 3200],
                'materialTechField' => 50,
                'materialPrice' => 210,
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
                        'priceGradation' => [390, 340, 320],
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
                        'priceGradation' => [540, 470, 420],
                        'materialPrice' => 16,
                        'output' => 15.5
                    ]
                ],
                'materialFormats' => [3200],
                'materialTechField' => 50,
                'materialPrice' => 220,
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
                'materialNameRu' => 'баннер транслюцентный 450 гр',
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
                        'priceGradation' => [420, 370, 350],
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
                        'priceGradation' => [580, 510, 490],
                        'materialPrice' => 16,
                        'output' => 15.5
                    ]
                ],
                'materialFormats' => [3200],
                'materialTechField' => 50,
                'materialPrice' => 230,
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
                'materialInfoTitle' => 'белая самоклеющаяся пленка высокого качества / глянцевая',
                'materialPrintTypeParametrs' => [
                    '720' => [
                        'nameRu' => 'широкоформатная',
                        'printerModel' => 'ph 3286',
                        'printParam' => 'проход: 4 / скорость: high / заливка: 70 / настройка: 2',
                        'printTypeInfoUrl' => '#',
                        'printTypeInfoTitle' => '720 dpi / cредняя детализация / есть запах / применяется на улице',
                        'printerMaxWidth' => 3200,
                        'priceGradation' => [370, 300, 250],
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
                        'priceGradation' => [480, 410, 340],
                        'materialPrice' => 16,
                        'output' => 12
                    ]
                ],
                'materialFormats' => [1050, 1250, 1520],
                'materialTechField' => 0,
                'materialPrice' => 210,
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
                'materialInfoTitle' => 'белая самоклеющаяся пленка высокого качества / матовая',
                'materialPrintTypeParametrs' => [
                    '720' => [
                        'nameRu' => 'широкоформатная',
                        'printerModel' => 'ph 3286',
                        'printParam' => 'проход: 4 / скорость: high / заливка: 70 / настройка: 2',
                        'printTypeInfoUrl' => '#',
                        'printTypeInfoTitle' => '720 dpi / cредняя детализация / есть запах / применяется на улице',
                        'printerMaxWidth' => 3200,
                        'priceGradation' => [370, 300, 250],
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
                        'priceGradation' => [480, 400, 340],
                        'materialPrice' => 16,
                        'output' => 12
                    ]
                ],
                'materialFormats' => [1050, 1250, 1520],
                'materialTechField' => 0,
                'materialPrice' => 210,
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
                'materialInfoTitle' => 'прозрачная самоклеющаяся пленка высокого качества / глянцевая',
                'materialPrintTypeParametrs' => [
                    '720' => [
                        'nameRu' => 'широкоформатная',
                        'printerModel' => 'ph 3286',
                        'printParam' => 'проход: 4 / скорость: high / заливка: 70 / настройка: 2',
                        'printTypeInfoUrl' => '#',
                        'printTypeInfoTitle' => '720 dpi / cредняя детализация / есть запах / применяется на улице',
                        'printerMaxWidth' => 3200,
                        'priceGradation' => [370, 300, 250],
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
                        'priceGradation' => [480, 410, 340],
                        'materialPrice' => 16,
                        'output' => 12
                    ]
                ],
                'materialFormats' => [1050, 1250, 1520],
                'materialTechField' => 0,
                'materialPrice' => 210,
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
                'materialInfoTitle' => 'прозрачная самоклеющаяся пленка высокого качества / матовая',
                'materialPrintTypeParametrs' => [
                    '720' => [
                        'nameRu' => 'широкоформатная',
                        'printerModel' => 'ph 3286',
                        'printParam' => 'проход: 4 / скорость: high / заливка: 70 / настройка: 2',
                        'printTypeInfoUrl' => '#',
                        'printTypeInfoTitle' => '720 dpi / cредняя детализация / есть запах / применяется на улице',
                        'printerMaxWidth' => 3200,
                        'priceGradation' => [370, 300, 250],
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
                        'priceGradation' => [480, 410, 340],
                        'materialPrice' => 16,
                        'output' => 12
                    ]
                ],
                'materialFormats' => [1050, 1250, 1520],
                'materialTechField' => 0,
                'materialPrice' => 210,
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
                        'priceGradation' => [400, 340, 310],
                        'materialPrice' => 5,
                        'output' => 40
                    ],
                ],
                'materialFormats' => [1370],
                'materialTechField' => 0,
                'materialPrice' => 210,
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
                        'priceGradation' => [340, 300, 240],
                        'materialPrice' => 5,
                        'output' => 73
                    ]
                ],
                'materialFormats' => [3200],
                'materialTechField' => 50,
                'materialPrice' => 170,
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
                        'priceGradation' => [240, 220, 180],
                        'materialPrice' => 5,
                        'output' => 40
                    ]
                ],
                'materialFormats' => [1570],
                'materialTechField' => 0,
                'materialPrice' => 100,
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
                        'priceGradation' => [260, 240, 200],
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
                        'priceGradation' => [390, 350, 290],
                        'materialPrice' => 16,
                        'output' => 12
                    ]
                ],
                'materialFormats' => [1570],
                'materialTechField' => 0,
                'materialPrice' => 120,
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
                        'priceGradation' => [720, 640, 530],
                        'materialPrice' => 16,
                        'output' => 12
                    ]
                ],
                'materialFormats' => [1520],
                'materialTechField' => 0,
                'materialPrice' => 400,
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
    'pet' => [
        'materialsGroupNameRu' => 'пэт',
        'squarePriceGradation' => [1, 50, 150],
        'printTypeGradation' => ['720', '1440'],
        'materials' => [
            'beklit150mk' => [
                'materialNameRu' => 'бэклит 150мк',
                'materialInfoUrl' => '#',
                'materialInfoTitle' => 'бэклит 150мк',
                'materialPrintTypeParametrs' => [
                    '1440' => [
                        'nameRu' => 'интерьерная',
                        'printerModel' => 'ph 3278',
                        'printParam' => 'проход: 4 / настройка: quality',
                        'printTypeInfoUrl' => '#',
                        'printTypeInfoTitle' => '1440 dpi ECO / высокая детализация / без запаха / применяется как в помещение, так и на улице',
                        'printerMaxWidth' => 3200,
                        'priceGradation' => [670, 570, 430],
                        'materialPrice' => 16,
                        'output' => 12
                    ]
                ],
                'materialFormats' => [1270],
                'materialTechField' => 0,
                'materialPrice' => 250,
                // free free10  material full
                'materialOverspendingDefaultMetrod' => 'material',
                'materialMargin' => [
                    'x' => 20,
                    'y' => 50
                ],
                'materialWeight' => 0.15,
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
                    'margin' => 0,
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
                        'priceGradation' => [220, 140, 105],
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
                        'priceGradation' => [290, 230, 170],
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
                        'priceGradation' => [250, 160, 110],
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
                        'priceGradation' => [300, 240, 180],
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
