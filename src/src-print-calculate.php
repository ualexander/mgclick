<?php
require_once('src-print-calcuate-library.php'); 

function printCalculate($printData, $formData) {
  
  
  $AVALAIBLE_PROMO_CODES = [
    'перерасходбесплатно',
    'перерасходменьше10бесплатно',
    'перерасходпоценематериала',
    'проба',
    'дополнение',
    'ценаколонка2',
    'ценаколонка3'
  ];
  
  $CONFIG = [
    // конвертация входных размеров постпечатной обработки в милиметры
    'CONVERT_OPTIONAL_WORK_UNIT_TO_MM' => 10,
    'OPTIONAL_WORK_UNIT_NAME' => 'см',
    // конвертация входных размеров изделия в милиметры
    'CONVERT_SIZE_UNIT_TO_MM' => 1000,
    // мм в м
    'CONVERT_MM_TO_M' => 1000,
    // до этого количества сегментов стыковка делится на равные сегменты
    'MAX_SAME_COUPLING_ITEMS' => 3,
    // от этой ширины подбирается оптимальный по перерасходу формат, после кладется на максимальный
    'MAX_WIDTH_OPTIMAL_COUPLIG' => 10000,
    'MIN_ORDER_PRICE'  => 1000,
    'MAX_PRINT_SIZE'  => 500,
    'MAX_PRINT_QUANTITY'  => 5000
  ];
  
  
  
  $order = [
    'items' => [],
    'commonData' => [
      'totalOrderSquare' => roundUpAfterDecimal(calculateOrderSquare($formData), 100),
      'customer' => (string) ($formData['orderControl']['customer'] ?? ''),
      'promoCodes' => getPromoCodeArrayFromString($formData['orderControl']['promoCodes'], $AVALAIBLE_PROMO_CODES),
      'calculations' => []
    ]
  ];
  
  
  function calcOrderItem($printData, $formOrderItemData, $commonOrderData, $CONFIG) {
    
    // внешняя сущность
    $productParam = [

      'status' => false,
      'index' => $formOrderItemData['index'] ?? false,
      'qr' => false,
      'customer' => $commonOrderData['customer'] ?? '',
      'orderName' => false,
      'dateCreate' => false,
      'orderItemsQuantity' => false,

      'promoCodes' => $commonOrderData['promoCodes'],
      
      'noTechFieldPerimeter' => '',
      'materialTypeTechFieldSize' => '',
      
      'materialGroup' => '',
      'materialGroupRu' => '',

      'materialType' => '',
      'materialTypeRu' => '',

      'laminationMaterialTypeRu' => '',

      'printType' => '',
      'printTypeRu' => '',
      
      'printerModel' => '',
      'printParam' => '',

      'notes' => trim($formOrderItemData['notes'] ?? ''),

      'customOptionalWorkToggle' => false,
      
      'simpleOptionalWork' => [
        'cringle' => '',
        'gain' => '',
        'cut' => '',
        'cord' => '',
        'pocket' => '',
        'lamination' => '',
        'stickToPlastic' => ''
      ],
      
      'customOptionalWork' => [
        'top' => [
          'cringle' => '',
          'gain' => '',
          'cut' => '',
          'cord' => '',
          'pocket' => '',
          'lamination' => '',
          'stickToPlastic' => ''
        ],
        'bottom' => [
          'cringle' => '',
          'gain' => '',
          'cut' => '',
          'cord' => '',
          'pocket' => '',
          'lamination' => '',
          'stickToPlastic' => ''
        ],
        'left' => [
          'cringle' => '',
          'gain' => '',
          'cut' => '',
          'cord' => '',
          'pocket' => '',
          'lamination' => '',
          'stickToPlastic' => ''
        ],
        'right' => [
          'cringle' => '',
          'gain' => '',
          'cut' => '',
          'cord' => '',
          'pocket' => '',
          'lamination' => '',
          'stickToPlastic' => ''
        ]
      ]
    ];

    if (in_array('ценаколонка2', $commonOrderData['promoCodes']) && $commonOrderData['totalOrderSquare'] < 50) {
      $commonOrderData['totalOrderSquare'] = 50;
    }

    if (in_array('ценаколонка3', $commonOrderData['promoCodes']) && $commonOrderData['totalOrderSquare'] < 150) {
      $commonOrderData['totalOrderSquare'] = 150;
    }

    ///////////////////////////////////////////////////////////////////////////////////////////
    ///////////-----GET VALUE FROM FOM------///////////-----GET VALUE FROM FOM------///////////      
    ///////////////////////////////////////////////////////////////////////////////////////////
    
    $curentMaterialGroup = false;
    $curentMaterialType = false;
    $curentPrintType = false;
    
    if (isset($formOrderItemData['materialGroup']) &&
        isset($printData['materialGroups'][$formOrderItemData['materialGroup']])) {
      
      $curentMaterialGroup = $printData['materialGroups'][(string) $formOrderItemData['materialGroup']];
      
      $productParam['materialGroup'] = (string) $formOrderItemData['materialGroup'];
      $productParam['materialGroupRu'] = $curentMaterialGroup['materialsGroupNameRu'] ?? 999999;
      
    }
    
    if ($curentMaterialGroup !== false &&
        isset($formOrderItemData['materialType']) &&
        isset($curentMaterialGroup['materials'][$formOrderItemData['materialType']])) {
      
      $curentMaterialType = $curentMaterialGroup['materials'][$formOrderItemData['materialType']];

      $productParam['materialType'] = (string) $formOrderItemData['materialType'];
      $productParam['materialTypeRu'] = $curentMaterialType['materialNameRu'] ?? 999999;
      
      
    }

    if ($curentMaterialType !== false &&
        isset($formOrderItemData['printType']) &&
        isset($curentMaterialType['materialPrintTypeParametrs'][$formOrderItemData['printType']])) {
      
      $curentPrintType = $curentMaterialType['materialPrintTypeParametrs'][$formOrderItemData['printType']];
      
      $productParam['printType'] = (string) $formOrderItemData['printType'];
      $productParam['printTypeRu'] = $curentPrintType['nameRu'] ?? 999999;
      
      $productParam['printerModel'] = $curentPrintType['printerModel'] ?? 999999;
      $productParam['printParam'] = $curentPrintType['printParam'] ?? 999999;
      
    }
    
    if ($curentPrintType === false) {
      return false;
    }
    
    // внутренняя сущность
    $curentOptionalWork = [
      'cringleStep' => [
        'other' => false,
        'top' => false,
        'bottom' => false,
        'left' => false,
        'right' => false,
      ],
      'gain' => [
        'top' => false,
        'bottom' => false,
        'left' => false,
        'right' => false,
      ],
      'cut' => [
        'top' => false,
        'bottom' => false,
        'left' => false,
        'right' => false,
      ],
      'cord' => [
        'top' => false,
        'bottom' => false,
        'left' => false,
        'right' => false,
      ],
      'pocketSize' => [
        'top' => false,
        'bottom' => false,
        'left' => false,
        'right' => false,
      ],
      'lamination' => false,
      'stickToPlastic' => false,
      'designPrice' => false,
    ];
    
    

    if (isset($formOrderItemData['customOptionalWorkToggle']) && $formOrderItemData['customOptionalWorkToggle'] === true) {
      $productParam['customOptionalWorkToggle'] = true;
    }
    

    ///////////-----GET CRINGLE STEP VALUE------///////////-----GET CRINGLE STEP VALUE------///////////      

    $simpleOrCustomCringle = simpleOrCustomOpionalWork('materialCringle', 'cringle', $curentMaterialType, $formOrderItemData);

    if ($simpleOrCustomCringle === 'simple') {
      $simpleCringleValue = getCringleValue($formOrderItemData['simpleOptionalWork']);

      if ($simpleCringleValue === 'corners') {
        $curentOptionalWork['cringleStep']['other'] = $simpleCringleValue;
      }
      else {
        $curentOptionalWork['cringleStep']['top'] = $simpleCringleValue * $CONFIG['CONVERT_OPTIONAL_WORK_UNIT_TO_MM'];
        $curentOptionalWork['cringleStep']['bottom'] = $simpleCringleValue * $CONFIG['CONVERT_OPTIONAL_WORK_UNIT_TO_MM'];
        $curentOptionalWork['cringleStep']['left'] = $simpleCringleValue * $CONFIG['CONVERT_OPTIONAL_WORK_UNIT_TO_MM'];
        $curentOptionalWork['cringleStep']['right'] = $simpleCringleValue * $CONFIG['CONVERT_OPTIONAL_WORK_UNIT_TO_MM'];
      }
      
    }

    else if ($simpleOrCustomCringle === 'custom') {
      $customCringleValueTop = getCringleValue($formOrderItemData['customOptionalWork']['top']);
      $customCringleValueBottom = getCringleValue($formOrderItemData['customOptionalWork']['bottom']);
      $customCringleValueLeft = getCringleValue($formOrderItemData['customOptionalWork']['left']);
      $customCringleValueRight = getCringleValue($formOrderItemData['customOptionalWork']['right']);
      
      $curentOptionalWork['cringleStep']['top'] = $customCringleValueTop * $CONFIG['CONVERT_OPTIONAL_WORK_UNIT_TO_MM'];
      $curentOptionalWork['cringleStep']['bottom'] = $customCringleValueBottom * $CONFIG['CONVERT_OPTIONAL_WORK_UNIT_TO_MM'];
      $curentOptionalWork['cringleStep']['left'] = $customCringleValueLeft * $CONFIG['CONVERT_OPTIONAL_WORK_UNIT_TO_MM'];
      $curentOptionalWork['cringleStep']['right'] = $customCringleValueRight * $CONFIG['CONVERT_OPTIONAL_WORK_UNIT_TO_MM'];      
      
    }

    
    if ($simpleOrCustomCringle === 'simple') {
      if  ($simpleCringleValue === 'corners') {
        $productParam['simpleOptionalWork']['cringle'] = "люверсы по углам";
      }
      else if ($simpleCringleValue > 0) {
        $productParam['simpleOptionalWork']['cringle'] = 'люверсы шаг ' . $simpleCringleValue . ' ' . $CONFIG['OPTIONAL_WORK_UNIT_NAME'];
      }
    }
    
    else if ($simpleOrCustomCringle === 'custom') {
      
      if ($customCringleValueTop > 0) {
        $productParam['customOptionalWork']['top']['cringle'] = 'люверсы шаг ' . $customCringleValueTop . ' ' . $CONFIG['OPTIONAL_WORK_UNIT_NAME'];
      }
      if ($customCringleValueBottom > 0) {
        $productParam['customOptionalWork']['bottom']['cringle'] = 'люверсы шаг ' . $customCringleValueBottom . ' ' . $CONFIG['OPTIONAL_WORK_UNIT_NAME'];
      }
      if ($customCringleValueLeft > 0) {
        $productParam['customOptionalWork']['left']['cringle'] = 'люверсы шаг ' . $customCringleValueLeft . ' ' . $CONFIG['OPTIONAL_WORK_UNIT_NAME'];
      }
      if ($customCringleValueRight > 0) {
        $productParam['customOptionalWork']['right']['cringle'] = 'люверсы шаг ' . $customCringleValueRight . ' ' . $CONFIG['OPTIONAL_WORK_UNIT_NAME'];
      }
    }
    
    ///////////-----GET GAIN VALUE------///////////-----GET GAIN VALUE------///////////      

    $simpleOrCustomGain = simpleOrCustomOpionalWork('materialGain', 'gain', $curentMaterialType, $formOrderItemData);

    if ($simpleOrCustomGain === 'simple') {
      $simpleGainValue = getGainValue($formOrderItemData['simpleOptionalWork']);

      $curentOptionalWork['gain']['top'] = $simpleGainValue;
      $curentOptionalWork['gain']['bottom'] = $simpleGainValue;
      $curentOptionalWork['gain']['left'] = $simpleGainValue;
      $curentOptionalWork['gain']['right'] = $simpleGainValue;

    }

    else if ($simpleOrCustomGain === 'custom') {
      $customGainValueTop = getGainValue($formOrderItemData['customOptionalWork']['top']);
      $customGainValueBottom = getGainValue($formOrderItemData['customOptionalWork']['bottom']);
      $customGainValueLeft = getGainValue($formOrderItemData['customOptionalWork']['left']);
      $customGainValueRight = getGainValue($formOrderItemData['customOptionalWork']['right']);

      $curentOptionalWork['gain']['top'] = $customGainValueTop;
      $curentOptionalWork['gain']['bottom'] = $customGainValueBottom;
      $curentOptionalWork['gain']['left'] = $customGainValueLeft;
      $curentOptionalWork['gain']['right'] = $customGainValueRight;

    }
    
    

    if ($simpleOrCustomGain === 'simple') {
      if ($simpleGainValue) {
        $productParam['simpleOptionalWork']['gain'] = 'усиление';
      }
    }
    
    else if ($simpleOrCustomGain === 'custom') {
      
      if ($customGainValueTop) {
        $productParam['customOptionalWork']['top']['gain'] = 'усиление';
      }
      if ($customGainValueBottom) {
        $productParam['customOptionalWork']['bottom']['gain'] = 'усиление';
      }
      if ($customGainValueLeft) {
        $productParam['customOptionalWork']['left']['gain'] = 'усиление';
      }
      if ($customGainValueRight) {
        $productParam['customOptionalWork']['right']['gain'] = 'усиление';
      }
    }
    ///////////-----GET CUT VALUE------///////////-----GET CUT VALUE------///////////      

    $simpleOrCustomCut = simpleOrCustomOpionalWork('materialCut', 'cut', $curentMaterialType, $formOrderItemData);

    if ($simpleOrCustomCut === 'simple') {
      $simpleCutValue = getCutValue($formOrderItemData['simpleOptionalWork']);

      $curentOptionalWork['cut']['top'] = $simpleCutValue;
      $curentOptionalWork['cut']['bottom'] = $simpleCutValue;
      $curentOptionalWork['cut']['left'] = $simpleCutValue;
      $curentOptionalWork['cut']['right'] = $simpleCutValue;
    }

    else if ($simpleOrCustomCut === 'custom') {
      $customCutValueTop = getCutValue($formOrderItemData['customOptionalWork']['top']);
      $customCutValueBottom = getCutValue($formOrderItemData['customOptionalWork']['bottom']);
      $customCutValueLeft = getCutValue($formOrderItemData['customOptionalWork']['left']);
      $customCutValueRight = getCutValue($formOrderItemData['customOptionalWork']['right']);

      $curentOptionalWork['cut']['top'] = $customCutValueTop;
      $curentOptionalWork['cut']['bottom'] = $customCutValueBottom;
      $curentOptionalWork['cut']['left'] = $customCutValueLeft;
      $curentOptionalWork['cut']['right'] = $customCutValueRight;
    }
    
    
    if ($simpleOrCustomCut === 'simple') {
      if ($simpleCutValue) {
        $productParam['simpleOptionalWork']['cut'] = 'рез';
      }
    }
    
    else if ($simpleOrCustomCut === 'custom') {
      
      if ($customCutValueTop) {
        $productParam['customOptionalWork']['top']['cut'] = 'рез';
      }
      if ($customCutValueBottom) {
        $productParam['customOptionalWork']['bottom']['cut'] = 'рез';
      }
      if ($customCutValueLeft) {
        $productParam['customOptionalWork']['left']['cut'] = 'рез';
      }
      if ($customCutValueRight) {
        $productParam['customOptionalWork']['right']['cut'] = 'рез';
      }
    }
    

    
    ///////////-----GET CORD VALUE------///////////-----GET CORD VALUE------///////////      

    $simpleOrCustomCord = simpleOrCustomOpionalWork('materialCord', 'cord', $curentMaterialType, $formOrderItemData);

    if ($simpleOrCustomCord === 'simple') {
      $simpleCordValue = getCordValue($formOrderItemData['simpleOptionalWork']);

      $curentOptionalWork['cord']['top'] = $simpleCordValue;
      $curentOptionalWork['cord']['bottom'] = $simpleCordValue;
      $curentOptionalWork['cord']['left'] = $simpleCordValue;
      $curentOptionalWork['cord']['right'] = $simpleCordValue;
    }

    else if ($simpleOrCustomCord === 'custom') {
      $customCordValueTop = getCordValue($formOrderItemData['customOptionalWork']['top']);
      $customCordValueBottom = getCordValue($formOrderItemData['customOptionalWork']['bottom']);
      $customCordValueLeft = getCordValue($formOrderItemData['customOptionalWork']['left']);
      $customCordValueRight = getCordValue($formOrderItemData['customOptionalWork']['right']);

      $curentOptionalWork['cord']['top'] = $customCordValueTop;
      $curentOptionalWork['cord']['bottom'] = $customCordValueBottom;
      $curentOptionalWork['cord']['left'] = $customCordValueLeft;
      $curentOptionalWork['cord']['right'] = $customCordValueRight;
    }

    
    if ($simpleOrCustomCord === 'simple') {
      if ($simpleCordValue) {
        $productParam['simpleOptionalWork']['cord'] = 'шнур';
      }
    }
    
    else if ($simpleOrCustomCord === 'custom') {
      
      if ($customCordValueTop) {
        $productParam['customOptionalWork']['top']['cord'] = 'шнур';
      }
      if ($customCordValueBottom) {
        $productParam['customOptionalWork']['bottom']['cord'] = 'шнур';
      }
      if ($customCordValueLeft) {
        $productParam['customOptionalWork']['left']['cord'] = 'шнур';
      }
      if ($customCordValueRight) {
        $productParam['customOptionalWork']['right']['cord'] = 'шнур';
      }
    }
    
    

    ///////////-----GET POCKET SIZE VALUE------///////////-----GET POCKET SIZE VALUE------///////////      


    $simpleOrCustomPocket = simpleOrCustomOpionalWork('materialPocket', 'pocket', $curentMaterialType, $formOrderItemData);

    if ($simpleOrCustomPocket === 'simple') {
      $simplePocketValue = getPocketValue($formOrderItemData['simpleOptionalWork']);

      $curentOptionalWork['pocketSize']['top'] = $simplePocketValue * $CONFIG['CONVERT_OPTIONAL_WORK_UNIT_TO_MM'];
      $curentOptionalWork['pocketSize']['bottom'] = $simplePocketValue * $CONFIG['CONVERT_OPTIONAL_WORK_UNIT_TO_MM'];
      $curentOptionalWork['pocketSize']['left'] = $simplePocketValue * $CONFIG['CONVERT_OPTIONAL_WORK_UNIT_TO_MM'];
      $curentOptionalWork['pocketSize']['right'] = $simplePocketValue * $CONFIG['CONVERT_OPTIONAL_WORK_UNIT_TO_MM'];
    }

    else if ($simpleOrCustomPocket === 'custom') {
      $customPocketValueTop = getPocketValue($formOrderItemData['customOptionalWork']['top']);
      $customPocketValueBottom = getPocketValue($formOrderItemData['customOptionalWork']['bottom']);
      $customPocketValueLeft = getPocketValue($formOrderItemData['customOptionalWork']['left']);
      $customPocketValueRight = getPocketValue($formOrderItemData['customOptionalWork']['right']);

      $curentOptionalWork['pocketSize']['top'] = $customPocketValueTop * $CONFIG['CONVERT_OPTIONAL_WORK_UNIT_TO_MM'];
      $curentOptionalWork['pocketSize']['bottom'] = $customPocketValueBottom * $CONFIG['CONVERT_OPTIONAL_WORK_UNIT_TO_MM'];
      $curentOptionalWork['pocketSize']['left'] = $customPocketValueLeft * $CONFIG['CONVERT_OPTIONAL_WORK_UNIT_TO_MM'];
      $curentOptionalWork['pocketSize']['right'] = $customPocketValueRight * $CONFIG['CONVERT_OPTIONAL_WORK_UNIT_TO_MM'];
    }
    
    
    
    if ($simpleOrCustomPocket === 'simple') {
      if ($simplePocketValue > 0) {
        $productParam['simpleOptionalWork']['pocket'] = 'карман ' . $simplePocketValue . ' ' . $CONFIG['OPTIONAL_WORK_UNIT_NAME'];
      }
    }
    
    else if ($simpleOrCustomPocket === 'custom') {
      
      if ($customPocketValueTop > 0) {
        $productParam['customOptionalWork']['top']['pocket'] = 'карман ' . $customPocketValueTop . ' ' . $CONFIG['OPTIONAL_WORK_UNIT_NAME'];
      }
      if ($customPocketValueBottom > 0) {
        $productParam['customOptionalWork']['bottom']['pocket'] = 'карман ' . $customPocketValueBottom . ' ' . $CONFIG['OPTIONAL_WORK_UNIT_NAME'];
      }
      if ($customPocketValueLeft > 0) {
        $productParam['customOptionalWork']['left']['pocket'] = 'карман ' . $customPocketValueLeft . ' ' . $CONFIG['OPTIONAL_WORK_UNIT_NAME'];
      }
      if ($customPocketValueRight > 0) {
        $productParam['customOptionalWork']['right']['pocket'] = 'карман ' . $customPocketValueRight . ' ' . $CONFIG['OPTIONAL_WORK_UNIT_NAME'];
      }
    }
    
    
    ///////////-----GET LAMINATION VALUE------///////////-----GET LAMINATION VALUE------///////////      

    $curentOptionalWork['lamination'] = getLamination($curentMaterialType, $formOrderItemData, $printData);

    if ($curentOptionalWork['lamination'] !== false) {
      $productParam['laminationMaterialTypeRu'] = $curentOptionalWork['lamination']['materialName'] ?? 999999;
    }

    ///////////-----GET STICK TO PLASTIC VALUE------///////////-----GET STICK TO PLASTIC VALUE------///////////      

    $curentOptionalWork['stickToPlastic'] = getStickToPlastic($curentMaterialType, $formOrderItemData, $printData);
    
    ///////////-----GET DESIGN PRICE VALUE------///////////-----GET DESIGN PRICE VALUE------///////////      

    $curentOptionalWork['designPrice'] = getDesignPriceValue($formOrderItemData);

    
    
    
    ///////////////////////////////////////////////////////////////////////////////////////////
    ///////////-----SELECT FIELD------///////////-----SELECT FIELD------///////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////
    
    // внутренняя сущность
    $curentFields = [
      'tech' => [
        'top' => $curentMaterialType['materialTechField'] ?? 0,
        'bottom' => $curentMaterialType['materialTechField'] ?? 0,
        'left' => $curentMaterialType['materialTechField'] ?? 0,
        'right' => $curentMaterialType['materialTechField'] ?? 0,
      ],
      'margin' => [
        'top' => $curentMaterialType['materialMargin']['y'] ?? 0,
        'bottom' => $curentMaterialType['materialMargin']['y'] ?? 0,
        'left' => $curentMaterialType['materialMargin']['x'] ?? 0,
        'right' => $curentMaterialType['materialMargin']['x'] ?? 0,
      ],
      'pocket' => [
        'top' => 0,
        'bottom' => 0,
        'left' => 0,
        'right' => 0,
      ],
      'totalStandart' => [
        'top' => 0,
        'bottom' => 0,
        'left' => 0,
        'right' => 0,
      ],
      'totalMin' => [
        'top' => 0,
        'bottom' => 0,
        'left' => 0,
        'right' => 0,
      ]
    ];
    
    $productParam['materialTypeTechFieldSize'] = $curentMaterialType['materialTechField'] ?? 999999;
    
    ///////////-----SELECT TECH FIELD------///////////-----SELECT TECH FIELD------///////////      
     
    
    $noTechFieldsValue = false;
    if (isset($formOrderItemData['noTechFields']) && $formOrderItemData['noTechFields'] === true) {
      $noTechFieldsValue = true;
      $productParam['noTechFieldPerimeter'] = true;
    }

    if ($noTechFieldsValue || $curentOptionalWork['cut']['top']) {
      $curentFields['tech']['top'] = 0;
    }
    if ($noTechFieldsValue || $curentOptionalWork['cut']['bottom']) {
      $curentFields['tech']['bottom'] = 0;
    }
    if ($noTechFieldsValue || $curentOptionalWork['cut']['left']) {
      $curentFields['tech']['left'] = 0;
    }
    if ($noTechFieldsValue || $curentOptionalWork['cut']['right']) {
      $curentFields['tech']['right'] = 0;
    }
    
    
    
    ///////////-----SELECT POCKET FIELD------///////////-----SELECT POCKET FIELD------///////////      
    
    
    $curentFields['pocket']['top'] = $curentOptionalWork['pocketSize']['top'];
    $curentFields['pocket']['bottom'] = $curentOptionalWork['pocketSize']['bottom'];
    $curentFields['pocket']['left'] = $curentOptionalWork['pocketSize']['left'];
    $curentFields['pocket']['right'] = $curentOptionalWork['pocketSize']['right'];
    

    ///////////-----SELECT TOTAL FIELD STANDART------///////////-----SELECT TOTAL FIELD STANDART------///////////      
    
    
    $curentFields['totalStandart'] = getTotalFildsStandart($curentFields);
    
    
    ///////////-----SELECT TOTAL FIELD MIN------///////////-----SELECT TOTAL FIELD MIN------///////////      
    

    $curentFields['totalMin'] = getTotalFildsMin($curentFields);


    
    ///////////////////////////////////////////////////////////////////////////////////////////
    ///////////-----SIZE PARAM------///////////-----SIZE PARAM------///////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////
    
    // внешняя сущность
    $curentSizeParam = [];
    
    // внутренняя сущность
    $sizeParamData = [
      // формат выбранный вручную
      'manualMaterialFormat' => getManualMaterialFormat($curentMaterialType, $curentPrintType, $formOrderItemData),
      // наибольший из доступных форматов
      'biggestAvalaibleFormat' => false,
      // максимальное количество отпечатков при компановке на наибольший из доступных форматов
      'maxCompositionItemQuantity' => false,
      // максимальная ширина принтера
      'printerMaxWidth' => $curentPrintType['printerMaxWidth'] ?? false,
      // количество блоков printSize в форме
      'printSizeNumber' =>  getFilledArrQuantity($formOrderItemData['printSize'] ?? false),
      // количество блоков pizeNumber в форме                            
      'canvasSizeNumber' =>  getFilledArrQuantity($formOrderItemData['canvasSize'] ?? false),
      // параметры содержимое первого блока printSize (width, height, quantity)
      'firstPrintSize' => $formOrderItemData['printSize'][getFirstArrIndex($formOrderItemData['printSize'])] ?? [],
      'printSize' => $formOrderItemData['printSize'] ?? [],
      'canvasSize' => $formOrderItemData['canvasSize'] ?? [],
      'materialFormats' => $curentMaterialType['materialFormats'] ?? [],
      'couplingMargin' => $curentMaterialType['materialCoupling']['margin'] ?? 999999
    ];
    
    if ((float) $sizeParamData['firstPrintSize']['width'] > $CONFIG['MAX_PRINT_SIZE'] || (float) $sizeParamData['firstPrintSize']['width'] < 0.01 || 
        (float) $sizeParamData['firstPrintSize']['height'] > $CONFIG['MAX_PRINT_SIZE'] || (float) $sizeParamData['firstPrintSize']['height'] < 0.01 ||
        (float) $sizeParamData['firstPrintSize']['quantity'] > $CONFIG['MAX_PRINT_QUANTITY'] || (float) $sizeParamData['firstPrintSize']['quantity'] < 1) {
      return false;
    }
    
    if ($sizeParamData['manualMaterialFormat'] === false) {
      $sizeParamData['biggestAvalaibleFormat'] = getBiggestFormat($sizeParamData['printerMaxWidth'], $curentMaterialType['materialFormats']);
    } 
    else if ($sizeParamData['manualMaterialFormat'] > 0) {
      $sizeParamData['biggestAvalaibleFormat'] = $sizeParamData['manualMaterialFormat'];
    }
    


    ///////////-----AUTO ROTATE------///////////---AUTO ROTATE------///////////
    
    $autoRotate = true;
    
    if ($autoRotate === true &&
      $sizeParamData['canvasSizeNumber'] === 0 &&
      $sizeParamData['manualMaterialFormat'] === false) {
      
      $tmpWidth = $sizeParamData['firstPrintSize']['width'];
      $tmpHeight = $sizeParamData['firstPrintSize']['height'];
      $curentFieldsOriginal = $curentFields;
      
      $maxCompositionItemsQuantityWidth = getMaxCompositionItemsQuantity((int) ((float) $tmpWidth * $CONFIG['CONVERT_SIZE_UNIT_TO_MM']), $sizeParamData['biggestAvalaibleFormat'], $curentFields)['min'];
      
      if ($maxCompositionItemsQuantityWidth === 0) {

        $curentFields = rotateSize($curentFields);
        $curentFields['totalStandart'] = getTotalFildsStandart($curentFields);
        $curentFields['totalMin'] = getTotalFildsMin($curentFields);

        $maxCompositionItemsQuantityHeight = getMaxCompositionItemsQuantity((int) ((float) $tmpHeight * $CONFIG['CONVERT_SIZE_UNIT_TO_MM']), $sizeParamData['biggestAvalaibleFormat'], $curentFields)['min'];
        
        if ($maxCompositionItemsQuantityHeight > 0) {
          $sizeParamData['firstPrintSize']['width'] = $tmpHeight;
          $sizeParamData['firstPrintSize']['height'] = $tmpWidth;
          $curentOptionalWork = rotateSize($curentOptionalWork);
        }
       else {
          $curentFields = $curentFieldsOriginal;
        }
      }
    }

    
    ///////////-----SIZE PARAM------///////////-----SIZE PARAM------///////////////////////

    $sizeParamData['maxCompositionItemQuantity'] = getMaxCompositionItemsQuantity((int) ((float) $sizeParamData['firstPrintSize']['width'] * $CONFIG['CONVERT_SIZE_UNIT_TO_MM']), $sizeParamData['biggestAvalaibleFormat'], $curentFields)['min'];
    
    ///////////-----SELECT SIZE PARAM  METHOD------///////////---SELECT SIZE PARAM  METHOD------///////////
    
    if ($sizeParamData['printSizeNumber'] === 1 &&
        $sizeParamData['canvasSizeNumber'] === 0 &&
        (int) $sizeParamData['firstPrintSize']['quantity'] > 1 &&
        $sizeParamData['maxCompositionItemQuantity'] > 1) {
      
      $autoCompositionSizeParam = getOptimalAutoCompositionSizeParam($sizeParamData, $CONFIG, $curentFields);
    }
    
    if ($sizeParamData['printSizeNumber'] === 1 &&
        $sizeParamData['canvasSizeNumber'] === 0 &&
        $sizeParamData['maxCompositionItemQuantity'] > 0) {
      
      $singleSizeParam = getOptimalSingleSizeParam($sizeParamData, $CONFIG, $curentFields);
      
      if (isset($autoCompositionSizeParam['overspendingPercent']) &&
          $autoCompositionSizeParam['overspendingPercent'] < $singleSizeParam['overspendingPercent']) {
        
        $curentSizeParam = $autoCompositionSizeParam;
      }
      else {
        $curentSizeParam = $singleSizeParam;
      }
    }
    
    else if ($sizeParamData['printSizeNumber'] === 1 && $sizeParamData['canvasSizeNumber'] === 0 &&
             $sizeParamData['maxCompositionItemQuantity'] === 0) {
      
      $curentSizeParam = getOptimalCouplingSizeParam($sizeParamData, $CONFIG, $curentFields);
    }

    else if ($sizeParamData['printSizeNumber'] > 0 && $sizeParamData['canvasSizeNumber'] > 0) {

      $curentSizeParam = getManualCompositionSizeParam($sizeParamData, $CONFIG, $curentFields, $formOrderItemData);
    }


    if(isset($curentSizeParam['printSquare']) === false) {
      return false;
    }
    
    
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /////-----LAMINATION AND STICK TO PLASTIC SIZE PARAM------///////////-----LAMINATION AND STICK TO PLASTIC SIZE PARAM------////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    // внешняя сущность
    $curentLaminationSize = [];
    // внешняя сущность
    $curentStickToPlasticSize = [];
  
    
    
    if ($curentOptionalWork['lamination'] !== false) {
      
      $curentLaminationSize = getLaminationOrStickSize($curentSizeParam,
                                                       $curentOptionalWork['lamination'],
                                                       $printData['optionalWorks']['lamination']['maxWidth'] ?? 999999);
      
      
      if (!isset($curentLaminationSize[0])) {
        $productParam['simpleOptionalWork']['lamination'] = 'нет подходящего формата для ламинации';
      }
      
    }
    
    if ($curentOptionalWork['stickToPlastic'] !== false) {
      
      $curentStickToPlasticSize = getLaminationOrStickSize($curentSizeParam,
                                                           $curentOptionalWork['stickToPlastic'],
                                                           $printData['optionalWorks']['stickToPlastic']['maxWidth'] ?? 999999);
      
      if (!isset($curentStickToPlasticSize[0])) {
        $productParam['simpleOptionalWork']['stickToPlastic'] = 'нет подходящего формата для накатки';
      }
      
    }

    
    
    if (isset($curentLaminationSize[0]['formatWidth']) && $curentLaminationSize[0]['formatWidth'] > 0) {
      $productParam['simpleOptionalWork']['lamination'] = $curentOptionalWork['lamination']['nameRu'] ?? 999999;
    }
    
    
    if (isset($curentStickToPlasticSize[0]['formatWidth']) && $curentStickToPlasticSize[0]['formatWidth'] > 0) {
      $productParam['simpleOptionalWork']['stickToPlastic'] = $curentOptionalWork['stickToPlastic']['nameRu'] ?? 999999;
    }
    

    ///////////////////////////////////////////////////////////////////////////////////////////
    ///////////-----CALCULATIONS------///////////-----CALCULATIONS------///////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////

    // внешняя сущность
    $calculations = [
      'print' => [
        'quantity' => 0,
        'price' => 0,
        'totalPrice' => 0,
        'materialCost' => 0,
        'hours' => 0,
        'kg' => 0,
        'name' => 'печать',
        'unit' => 'м<sup>2</sup>'
      ],
      'overspending' => [
        'quantity' => 0,
        'price' => 0,
        'totalPrice' => 0,
        'materialCost' => 0,
        'hours' => 0,
        'kg' => 0,
        'name' => 'перерасход',
        'unit' => 'м<sup>2</sup>'
      ],
      'cringle' => [
        'quantity' => 0,
        'price' => 0,
        'totalPrice' => 0,
        'materialCost' => 0,
        'hours' => 0,
        'kg' => 0,
        'name' => 'люверсы',
        'unit' => 'шт'
      ],
      'gain' => [
        'quantity' => 0,
        'price' => 0,
        'totalPrice' => 0,
        'materialCost' => 0,
        'hours' => 0,
        'kg' => 0,
        'name' => 'проварка края',
        'unit' => 'м'
      ],
      'cut' => [
        'quantity' => 0,
        'price' => 0,
        'totalPrice' => 0,
        'materialCost' => 0,
        'hours' => 0,
        'kg' => 0,
        'name' => 'рез',
        'unit' => 'м'
      ],
      'cord' => [
        'quantity' => 0,
        'price' => 0,
        'totalPrice' => 0,
        'materialCost' => 0,
        'hours' => 0,
        'kg' => 0,
        'name' => 'шнур',
        'unit' => 'м'
      ],
      'pocket' => [
        'quantity' => 0,
        'price' => 0,
        'totalPrice' => 0,
        'materialCost' => 0,
        'hours' => 0,
        'kg' => 0,
        'name' => 'карман',
        'unit' => 'м'
      ],
      'coupling' => [
        'quantity' => 0,
        'price' => 0,
        'totalPrice' => 0,
        'materialCost' => 0,
        'hours' => 0,
        'kg' => 0,
        'name' => 'стыковка',
        'unit' => 'м'
      ],
      'lamination' => [
        'quantity' => 0,
        'price' => 0,
        'totalPrice' => 0,
        'materialCost' => 0,
        'hours' => 0,
        'kg' => 0,
        'name' => 'ламинация',
        'unit' => 'м<sup>2</sup>'
      ],
      'stickToPlastic' => [
        'quantity' => 0,
        'price' => 0,
        'totalPrice' => 0,
        'materialCost' => 0,
        'hours' => 0,
        'kg' => 0,
        'name' => 'накатка',
        'unit' => 'м<sup>2</sup>'
      ],
      'designPrice' => [
        'quantity' => 0,
        'price' => 0,
        'totalPrice' => 0,
        'materialCost' => 0,
        'hours' => 0,
        'kg' => 0,
        'name' => 'макет',
        'unit' => ''
      ]
    ];
    


    
    ///////////-----CALCULATIONS PRINT------///////////---CALCULATIONS PRINT------///////////      
        
    $calculations['print']['quantity'] = roundUpAfterDecimal($curentSizeParam['printSquare'], 10);
    
    if ($calculations['print']['quantity'] < 1) {
      $calculations['print']['quantity'] = 1;
    }

    $calculations['print']['price'] = selectPrice($curentPrintType['priceGradation'],
                                                           $curentMaterialGroup['squarePriceGradation'],
                                                           $commonOrderData['totalOrderSquare']);


    $calculations['print']['totalPrice'] = (int) ($calculations['print']['quantity'] * $calculations['print']['price']);
    
    $calculations['print']['materialCost'] = (int) ((($curentMaterialType['materialPrice'] ?? 999999) +
                                                     ($curentPrintType['materialPrice'] ?? 999999)) *
                                                      $calculations['print']['quantity']);
    
    $calculations['print']['hours'] = roundUpAfterDecimal($calculations['print']['quantity'] / ($curentPrintType['output'] ?? 999999), 10);
    
    $calculations['print']['kg'] = roundUpAfterDecimal($calculations['print']['quantity'] * ($curentMaterialType['materialWeight'] ?? 999999), 10);

    ///////////-----CALCULATIONS OVERSPENDING------///////////---CALCULATIONS OVERSPENDING------///////////      
    
    $calculations['overspending']['quantity'] = roundUpAfterDecimal($curentSizeParam['canvasSquare'] - $curentSizeParam['printSquare'], 10);
    
    // free перерасходбесплатно
    if (in_array('перерасходбесплатно', $commonOrderData['promoCodes']) ||
        $curentMaterialType['materialOverspendingDefaultMetrod'] === 'free') {
      
      $calculations['overspending']['price'] = 0;
      
    }
    // free10 перерасходменьше10бесплатно
    else if (in_array('перерасходменьше10бесплатно', $commonOrderData['promoCodes']) ||
             $curentMaterialType['materialOverspendingDefaultMetrod'] === 'free10') {
      
      if ($curentSizeParam['overspendingPercent'] <= 10) {
        $calculations['overspending']['price'] = 0;
      }
      else {
        $calculations['overspending']['price'] = $curentMaterialType['materialPrice'] ?? 999999;
      }
      
    }
    // materialprice перерасходпоценематериала
    else if (in_array('перерасходпоценематериала', $commonOrderData['promoCodes']) ||
             $curentMaterialType['materialOverspendingDefaultMetrod'] === 'material') {
      
      $calculations['overspending']['price'] = $curentMaterialType['materialPrice'] ?? 999999;
      
    }
    // full
    else {
      
      $calculations['overspending']['price'] = $calculations['print']['price'];
      
    }
    
    $calculations['overspending']['totalPrice'] = (int) ($calculations['overspending']['quantity'] *
      $calculations['overspending']['price']);

    $calculations['overspending']['materialCost'] = (int) (($curentMaterialType['materialPrice'] ?? 999999) *
      $calculations['overspending']['quantity']);
    
    
    ///////////-----CALCULATIONS CRINGLE------///////////---CALCULATIONS CRINGLE------///////////   
    
    $calculations['cringle']['quantity'] = 
      getCringleQuatity($curentSizeParam['printSize'], $curentOptionalWork['cringleStep']);

    
    if ($calculations['cringle']['quantity'] > 0) {
      
      $calculations['cringle']['price'] = 
        selectPrice($printData['optionalWorks']['cringle']['priceGradation'] ?? [], $printData['optionalWorks']['squareGradation']  ?? [], $commonOrderData['totalOrderSquare']);
      
      $calculations['cringle']['totalPrice'] = (int) ($calculations['cringle']['quantity'] * $calculations['cringle']['price']);
      
      $calculations['cringle']['materialCost'] = (int) ($calculations['cringle']['quantity'] *
                                                        ($printData['optionalWorks']['cringle']['materialPrice'] ?? 999999));
        
      $calculations['cringle']['hours'] = roundUpAfterDecimal($calculations['cringle']['quantity'] / ($printData['optionalWorks']['cringle']['output'] ?? 999999), 10);
    }

    ///////////-----CALCULATIONS GAIN------///////////---CALCULATIONS GAIN------///////////      

    $calculations['gain']['quantity'] = roundUpAfterDecimal(getOptionalWorkQuatity($curentSizeParam['printSize'], $curentOptionalWork['gain']) / $CONFIG['CONVERT_MM_TO_M'], 10);


    if ($calculations['gain']['quantity'] > 0) {
      
      $calculations['gain']['price'] = 
        selectPrice($printData['optionalWorks']['gain']['priceGradation'] ?? [],
                    $printData['optionalWorks']['squareGradation'] ?? [],
                    $commonOrderData['totalOrderSquare']);
      
      $calculations['gain']['totalPrice'] = (int) ($calculations['gain']['quantity'] * $calculations['gain']['price']);
        
      $calculations['gain']['hours'] = roundUpAfterDecimal($calculations['gain']['quantity'] / ($printData['optionalWorks']['gain']['output'] ?? 999999), 10);
        
    }
    

    ///////////-----CALCULATIONS CUT------///////////---CALCULATIONS CUT------///////////      

    $calculations['cut']['quantity'] = roundUpAfterDecimal(getOptionalWorkQuatity($curentSizeParam['printSize'], $curentOptionalWork['cut']) / $CONFIG['CONVERT_MM_TO_M'], 10);

    if ($calculations['cut']['quantity'] > 0) {
      
      $calculations['cut']['price'] = 
        selectPrice($printData['optionalWorks']['cut']['priceGradation'] ?? [],
                    $printData['optionalWorks']['squareGradation'] ?? [],
                    $commonOrderData['totalOrderSquare']);
      
      $calculations['cut']['totalPrice'] = (int) ($calculations['cut']['quantity'] * $calculations['cut']['price']);
        
      $calculations['cut']['hours'] = roundUpAfterDecimal($calculations['cut']['quantity'] / ($printData['optionalWorks']['cut']['output'] ?? 999999), 10);

    }
    
    if ($curentOptionalWork['stickToPlastic'] !== false) {
      $calculations['cut']['price'] = $calculations['cut']['price'] * 2;
      $calculations['cut']['totalPrice'] = $calculations['cut']['totalPrice'] * 2;
      $calculations['cut']['hours'] = $calculations['cut']['hours'] * 2;
    }
    
    ///////////-----CALCULATIONS CORD------///////////---CALCULATIONS CORD------///////////      

    $calculations['cord']['quantity'] = roundUpAfterDecimal(getOptionalWorkQuatity($curentSizeParam['printSize'], $curentOptionalWork['cord']) / $CONFIG['CONVERT_MM_TO_M'], 10);

    if ($calculations['cord']['quantity'] > 0) {
      
      $calculations['cord']['price'] = 
        selectPrice($printData['optionalWorks']['cord']['priceGradation'] ?? [],
                    $printData['optionalWorks']['squareGradation'] ?? [],
                    $commonOrderData['totalOrderSquare']);
      
      $calculations['cord']['totalPrice'] = (int) ($calculations['cord']['quantity'] * $calculations['cord']['price']);
      
      $calculations['cord']['materialCost'] = (int) ($calculations['cord']['quantity'] *
                                                     ($printData['optionalWorks']['cord']['materialPrice'] ?? 999999));
      
      $calculations['cord']['hours'] = roundUpAfterDecimal($calculations['cord']['quantity'] / ($printData['optionalWorks']['cord']['output'] ?? 999999), 10);

    }
    

    ///////////-----CALCULATIONS POCKET------///////////---CALCULATIONS POCKET------///////////      


    $calculations['pocket']['quantity'] = roundUpAfterDecimal(getOptionalWorkQuatity($curentSizeParam['printSize'], $curentOptionalWork['pocketSize']) / $CONFIG['CONVERT_MM_TO_M'], 10);
      
    if ($calculations['pocket']['quantity'] > 0) {
      
      $calculations['pocket']['price'] = 
        selectPrice($printData['optionalWorks']['pocket']['priceGradation'] ?? [],
                    $printData['optionalWorks']['squareGradation'] ?? [],
                    $commonOrderData['totalOrderSquare']);
      
      $calculations['pocket']['totalPrice'] = (int) ($calculations['pocket']['quantity'] * $calculations['pocket']['price']);
        
      $calculations['pocket']['hours'] = roundUpAfterDecimal($calculations['pocket']['quantity'] / ($printData['optionalWorks']['pocket']['output'] ?? 999999), 10);

    }
      
      
    ///////////-----CALCULATIONS CUPLING------///////////---CALCULATIONS CUPLING------///////////      

    if ($curentSizeParam['algorithm'] === 'coupling' && ($curentMaterialType['materialCoupling']['price'] ?? 0) > 0) {
      
      $segmentQuantity = ($curentSizeParam['canvasSize'][0]['quantity'] ?? 0) + ($curentSizeParam['canvasSize'][1]['quantity'] ?? 0);
      $jointQuantity = $segmentQuantity - 1;
      
      if (isset($curentSizeParam['printSize'][0]['quantity']) && $curentSizeParam['printSize'][0]['quantity'] > 1) {
        $jointQuantity = ($segmentQuantity / $curentSizeParam['printSize'][0]['quantity'] - 1) * $curentSizeParam['printSize'][0]['quantity'];
      }
      
      $calculations['coupling']['quantity'] = roundUpAfterDecimal($jointQuantity * $curentSizeParam['printSize'][0]['height'] / $CONFIG['CONVERT_MM_TO_M'], 10);
        
      $calculations['coupling']['price'] = $curentMaterialType['materialCoupling']['price'] ?? 999999;
      
      $calculations['coupling']['totalPrice'] = (int) ($calculations['coupling']['quantity'] * $calculations['coupling']['price']);
      
      $calculations['coupling']['hours'] = roundUpAfterDecimal($calculations['coupling']['quantity'] / ($curentMaterialType['materialCoupling']['output'] ?? 999999), 10);
      
    }
    
    
    ///////////-----CALCULATIONS LAMINATION------///////////---CALCULATIONS LAMINATION------///////////      

    if ($curentOptionalWork['lamination'] !== false) {
      
      $calculations['lamination']['quantity'] = roundUpAfterDecimal(getFormatSizeParamSquare($curentLaminationSize) / $CONFIG['CONVERT_MM_TO_M'] / $CONFIG['CONVERT_MM_TO_M'], 10);
      
      if ($calculations['lamination']['quantity'] < 1 && isset($curentLaminationSize[0])) {
        $calculations['lamination']['quantity'] = 1;
      }
      
      $calculations['lamination']['price'] = selectPrice($curentOptionalWork['lamination']['priceGradation'] ?? [],
                                                           $printData['optionalWorks']['squareGradation'] ?? [],
                                                           $commonOrderData['totalOrderSquare']);
      
      $calculations['lamination']['totalPrice'] = (int) ($calculations['lamination']['quantity'] * $calculations['lamination']['price']);
      
      $calculations['lamination']['materialCost'] = (int) ($calculations['lamination']['quantity'] *
                                                           ($curentOptionalWork['lamination']['materialPrice'] ?? 999999));
      
      $calculations['lamination']['hours'] = roundUpAfterDecimal($calculations['lamination']['quantity'] / ($curentOptionalWork['lamination']['output'] ?? 999999), 10);
      
      $calculations['lamination']['kg'] = roundUpAfterDecimal($calculations['lamination']['quantity'] * ($curentOptionalWork['lamination']['materialWeight'] ?? 999999), 10);
      
    }
      
    ///////////-----CALCULATIONS STICK TO PLASTIC------///////////---CALCULATIONS STICK TO PLASTIC------///////////
    
    if ($curentOptionalWork['stickToPlastic'] !== false) {
      
      $calculations['stickToPlastic']['quantity'] = roundUpAfterDecimal(getSizeParamSquare($curentStickToPlasticSize) / $CONFIG['CONVERT_MM_TO_M'] / $CONFIG['CONVERT_MM_TO_M'], 10);
      
      if ($calculations['stickToPlastic']['quantity'] < 0.25 && isset($curentStickToPlasticSize[0])) {
        $calculations['stickToPlastic']['quantity'] = 0.25;
      }
      
      $calculations['stickToPlastic']['price'] = selectPrice($curentOptionalWork['stickToPlastic']['priceGradation'] ?? [],
                                                           $printData['optionalWorks']['squareGradation'] ?? [],
                                                           $commonOrderData['totalOrderSquare']);
      
      $calculations['stickToPlastic']['totalPrice'] = (int) ($calculations['stickToPlastic']['quantity'] * $calculations['stickToPlastic']['price']);
      
      $calculations['stickToPlastic']['materialCost'] = (int) ($calculations['stickToPlastic']['quantity'] * ($curentOptionalWork['stickToPlastic']['materialPrice'] ?? 999999));
      
      $calculations['stickToPlastic']['hours'] = roundUpAfterDecimal($calculations['stickToPlastic']['quantity'] / ($curentOptionalWork['stickToPlastic']['output'] ?? 999999), 10);
      
      $calculations['stickToPlastic']['kg'] = roundUpAfterDecimal($calculations['stickToPlastic']['quantity'] * ($curentOptionalWork['stickToPlastic']['materialWeight'] ?? 999999), 10);
    }

    ///////////-----CALCULATIONS DESIGN------///////////---CALCULATIONS DESIGN------///////////
    
    
    if ($curentOptionalWork['designPrice'] > 0) {
      
      $calculations['designPrice']['quantity'] = 1;

      $calculations['designPrice']['price'] = $curentOptionalWork['designPrice'];

      $calculations['designPrice']['totalPrice'] = $curentOptionalWork['designPrice'];
      
    }

    
    ///////////-----CALCULATIONS TOTAL ORDER ITEM------///////////---CALCULATIONS TOTAL ORDER ITEM------///////////


    $calculations['total'] = calculationsTotalOrderItem($calculations, ['totalPrice', 'materialCost', 'hours', 'kg']);
    
    
    if (isset($calculations['total']['totalPrice']) && $calculations['total']['totalPrice'] > 0) {
      
      $calculations['total']['totalPrice'] = roundDownBeforeDecimal($calculations['total']['totalPrice'], 10);
      $calculations['total']['name'] = 'итого';
      
    }
    
    if (in_array('проба', $commonOrderData['promoCodes']) && $commonOrderData['totalOrderSquare'] < 1) {
      $calculations['total']['totalPrice'] = 1;
    }
    

    ///////////-----CALCULATIONS PRINT ITEM PRICE------///////////---CALCULATIONS PRINT ITEM PRICE------///////////

    $curentSizeParam['printSize'] = getApproximatePrintSizeItemPrice($curentSizeParam, $calculations['total']['totalPrice'], $CONFIG);

    return [
      'productParam' => $productParam,
      'curentLaminationSize' => $curentLaminationSize,
      'curentStickToPlasticSize' => $curentStickToPlasticSize,
      'curentSizeParam' => $curentSizeParam,
      'calculations' => $calculations
    ];

  }
  

  
  foreach ($formData['orderItems'] as $key => $value) {
    
    if (isset($value['index'])) {
      
      $item = calcOrderItem($printData, $value, $order['commonData'], $CONFIG);
      
      if (isset($item['productParam']['index'])) {
        $order['items'][] = $item;
      }

    }
    
  }
  
  if (count($order['items']) === 0) {
    return false;
  }
  
  $order['commonData']['calculations'] = calculationsTotal($order['items']);
  
  $order['commonData']['calculations']['total']['hours'] = roundUpAfterDecimal($order['commonData']['calculations']['total']['hours'], 10);
  $order['commonData']['calculations']['total']['kg'] = roundUpAfterDecimal($order['commonData']['calculations']['total']['kg'], 10);
  


  if (!in_array('дополнение', $order['commonData']['promoCodes']) && $order['commonData']['calculations']['total']['totalPrice'] < $CONFIG['MIN_ORDER_PRICE']) {

    $order['items'][0]['calculations']['total']['totalPrice'] =
      $CONFIG['MIN_ORDER_PRICE'] -
      ($order['commonData']['calculations']['total']['totalPrice'] -
      $order['items'][0]['calculations']['total']['totalPrice']);

    $order['commonData']['calculations']['total']['totalPrice'] = $CONFIG['MIN_ORDER_PRICE'];

  }

  
  if (in_array('проба', $order['commonData']['promoCodes']) && $order['commonData']['totalOrderSquare'] < 1) {

    foreach ($order['items'] as $key => $value) {
      foreach ($order['items'][$key]['calculations'] as $key2 => $value2) {
        if (isset($order['items'][$key]['calculations'][$key2]['totalPrice'])) {
          $order['items'][$key]['calculations'][$key2]['totalPrice'] = 0;
        }
      }
    }

    foreach ($order['commonData']['calculations'] as $key3 => $value3) {
      if (isset($order['commonData']['calculations'][$key3]['totalPrice'])) {
        $order['commonData']['calculations'][$key3]['totalPrice'] = 0;
      }
    }

  }
  

  return $order;
  
}
