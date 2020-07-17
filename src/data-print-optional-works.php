<?php

$printOptionalWorks = [
  'squareGradation' => [1, 50, 150],
  'cringle' => [
    'nameRu' => 'люверсы',
    'optionalWorkInfoUrl' => 'http://mega-banner.ru/',
    'optionalWorkInfoTitle' => 'металические кольца для крепления, используется для продевания крепежной веревки или хомута',
    'output' => 210,
    'priceGradation' => [18, 12, 10],
    'unit' => 'шт.',
    'materialPrice' => 1,
    'defaultOptions' => [
      [
        'title' => 'нет',
        'value' => 'none'
      ],
      [
        'title' => 'шаг 25 см',
        'value' => 25
      ],
      [
        'title' => 'шаг 30 см',
        'value' => 30
      ],
      [
        'title' => 'шаг 50 см',
        'value' => 50
      ],
      [
        'title' => 'по углам',
        'value' => 'corners'
      ],
      [
        'title' => 'другое',
        'value' => 'custom'
      ]
    ]
  ],
  'gain' => [
    'nameRu' => 'усиление края',
    'optionalWorkInfoUrl' => 'http://mega-banner.ru/',
    'optionalWorkInfoTitle' => 'край подгибается и проваривается, благодаря чему повышается прочность изделия',
    'output' => 90,
    'priceGradation' => [30, 25, 20],
    'unit' => 'м. пог.'
  ],
  'cut' => [
    'nameRu' => 'рез',
    'optionalWorkInfoUrl' => 'http://mega-banner.ru/',
    'optionalWorkInfoTitle' => 'рез по контуру, возможен только по прямой линии',
    'output' => 225,
    'priceGradation' => [15, 10, 8],
    'unit' => 'м. пог.'
  ],
  'cord' => [
    'nameRu' => 'шнур',
    'optionalWorkInfoUrl' => 'http://mega-banner.ru/',
    'optionalWorkInfoTitle' => 'край материала подгибается, в него помещается капроновый шнур выдерживающий нагрузку на разрыв около 1000 кг, после этого край проваривается',
    'output' => 100,
    'priceGradation' => [35, 30, 25],
    'unit' => 'м. пог.',
    'materialPrice' => 10
  ],
  'pocket' => [
    'nameRu' => 'карман',
    'optionalWorkInfoUrl' => 'http://mega-banner.ru/',
    'optionalWorkInfoTitle' => 'при монтаже в карман возможно поместить утяжелитель или крепежную трубу / трос',
    'output' => 100,
    'priceGradation' => [30, 25, 20],
    'unit' => 'м. пог.',
    'defaultOptions' => [
      [
        'title' => 'нет',
        'value' => 'none'
      ],
      [
        'title' => '5 см',
        'value' => 5
      ],
      [
        'title' => '10 см',
        'value' => 10
      ],
      [
        'title' => '15 см',
        'value' => 15
      ],
      [
        'title' => 'другое',
        'value' => 'custom'
      ]
    ]
  ],
  'lamination'  => [
    'maxWidth' => 1550,
    'materials' => [
      'orajetPrGl' => [
        'nameRu' => 'ламинация прозрачная глянцевая',
        'materialName' => 'orajet прозрачный глянцевый',
        'optionalWorkInfoUrl' => 'http://mega-banner.ru/',
        'optionalWorkInfoTitle' => 'дополнительный защитный слой прозрачной пленки',
        'materialFormats' => [1050, 1250, 1520],
        'output' => 40,
        'materialWeight' => 0.15,
        'priceGradation' => [200, 190, 160],
        'materialPrice' => 120,
        'unit' => 'м<sup>2</sup>',
        'materialMargin' => [
          'x' => 20,
          'y' => 75
        ],
      ],
      'orajetPrMat' => [
        'nameRu' => 'ламинация прозрачная матовая',
        'materialName' => 'orajet прозрачный матовый',
        'optionalWorkInfoUrl' => 'http://mega-banner.ru/',
        'optionalWorkInfoTitle' => 'дополнительный защитный слой прозрачной пленки',
        'materialFormats' => [1050, 1250, 1520],
        'output' => 40,
        'materialWeight' => 0.15,
        'priceGradation' => [200, 190, 160],
        'materialPrice' => 120,
        'unit' => 'м<sup>2</sup>',
        'materialMargin' => [
          'x' => 20,
          'y' => 75
        ],
      ],
      'orajetBelGl' => [
        'nameRu' => 'ламинация белая глянцевая',
        'materialName' => 'orajet белый глянцевый',
        'optionalWorkInfoUrl' => 'http://mega-banner.ru/',
        'optionalWorkInfoTitle' => 'дополнительный защитный слой белой глянцевой пленки, применяется для наклеек с клеевым слоем на лицевой стороне (там где нанесено изображение)',
        'materialFormats' => [1050, 1250, 1520],
        'output' => 40,
        'materialWeight' => 0.15,
        'priceGradation' => [200, 190, 160],
        'materialPrice' => 120,
        'unit' => 'м<sup>2</sup>',
        'materialMargin' => [
          'x' => 20,
          'y' => 75
        ],
      ],
      'orajetBelMat' => [
        'nameRu' => 'ламинация белая матовая',
        'materialName' => 'orajet белый матовый',
        'optionalWorkInfoUrl' => 'http://mega-banner.ru/',
        'optionalWorkInfoTitle' => 'дополнительный защитный слой белой матовой пленки, применяется для наклеек с клеевым слоем на лицевой стороне (там где нанесено изображение)',
        'materialFormats' => [1050, 1250, 1520],
        'output' => 40,
        'materialWeight' => 0.15,
        'priceGradation' => [200, 190, 160],
        'materialPrice' => 120,
        'unit' => 'м<sup>2</sup>',
        'materialMargin' => [
          'x' => 20,
          'y' => 75
        ],
      ],
      'laminNapolPs' => [
        'nameRu' => 'ламинация напольная',
        'materialName' => 'ламинация напольная песок',
        'optionalWorkInfoUrl' => 'http://mega-banner.ru/',
        'optionalWorkInfoTitle' => 'прочная напольная ламинация с антискользящим эффектом',
        'materialFormats' => [915],
        'output' => 40,
        'materialWeight' => 0.15,
        'priceGradation' => [750, 650, 450],
        'materialPrice' => 180,
        'unit' => 'м<sup>2</sup>',
        'materialMargin' => [
          'x' => 20,
          'y' => 75
        ],
      ],
      'kitPl' => [
        'nameRu' => 'ламинация эконом',
        'materialName' => 'пленка эконном',
        'optionalWorkInfoUrl' => 'http://mega-banner.ru/',
        'optionalWorkInfoTitle' => 'дополнительный защитный слой белой матовой пленки, применяется для наклеек с клеевым слоем на лицевой стороне (там где нанесено изображение)',
        'materialFormats' => [1050, 1250, 1520],
        'output' => 40,
        'materialWeight' => 0.15,
        'priceGradation' => [190, 170, 140],
        'materialPrice' => 115,
        'unit' => 'м<sup>2</sup>',
        'materialMargin' => [
          'x' => 20,
          'y' => 75
        ],
      ],
      'materialKlienta' => [
        'nameRu' => 'материал клиента',
        'materialName' => 'ламинация клиента',
        'optionalWorkInfoUrl' => false,
        'optionalWorkInfoTitle' => false,
        'materialFormats' => [1000, 1100, 1200, 1300, 1400, 1500, 1550],
        'output' => 40,
        'materialWeight' => 0.15,
        'priceGradation' => [100, 80, 40],
        'materialPrice' => 0,
        'unit' => 'м<sup>2</sup>',
        'materialMargin' => [
          'x' => 20,
          'y' => 75
        ],
      ],
    ]

  ],
  'stickToPlastic' => [
    'maxWidth' => 1600,
    'materials' => [
      'pvc3Mm' => [
        'nameRu' => 'накатка ПВХ 3 мм',
        'optionalWorkInfoUrl' => '#',
        'optionalWorkInfoTitle' => 'плотный белый пластик толщиной 3 мм',
        'materialFormats' => [1000, 1100, 1200, 1300, 1400, 1500, 1550],
        'output' => 20,
        'materialWeight' => 1,
        'priceGradation' => [1500, 1300, 800],
        'materialPrice' => 100,
        'unit' => 'м<sup>2</sup>',
        'materialMargin' => [
          'x' => 0,
          'y' => 0
        ],
      ],
      'pvc5Mm' => [
        'nameRu' => 'накатка ПВХ 5 мм',
        'optionalWorkInfoUrl' => '#',
        'optionalWorkInfoTitle' => 'плотный белый пластик толщиной 5 мм',
        'materialFormats' => [1000, 1100, 1200, 1300, 1400, 1500, 1550],
        'output' => 20,
        'materialWeight' => 1.5,
        'priceGradation' => [1700, 1500, 1000],
        'materialPrice' => 100,
        'unit' => 'м<sup>2</sup>',
        'materialMargin' => [
          'x' => 0,
          'y' => 0
        ],
      ],
      'matClienta' => [
        'nameRu' => 'материал клиента',
        'optionalWorkInfoUrl' => false,
        'optionalWorkInfoTitle' => false,
        'materialFormats' => [1000, 1100, 1200, 1300, 1400, 1500, 1550],
        'output' => 20,
        'materialWeight' => 0.5,
        'priceGradation' => [300, 200, 150],
        'materialPrice' => 100,
        'unit' => 'м<sup>2</sup>',
        'materialMargin' => [
          'x' => 0,
          'y' => 0
        ],
      ],
    ]
  ]
];
