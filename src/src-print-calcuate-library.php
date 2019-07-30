<?php


function getPromoCodeArrayFromString($string, $avalaiblePromoCodes) {

  $promoCodeArray = [];

  $arr = explode(',', (string) $string);

  foreach ($arr as $key => $value) {

    $trimLoverString = mb_strtolower(trim($value));

    if (mb_strlen($trimLoverString) > 0 && in_array($trimLoverString, $avalaiblePromoCodes) && !in_array($trimLoverString, $promoCodeArray)) {
      $promoCodeArray[] = $trimLoverString;
    }

  }

  return $promoCodeArray;

}


    
function simpleOrCustomOpionalWork($printDataWorkName, $formDataWorkName, $curentMaterialType, $formOrderItemData) {
// есть ли у текущего материала этот вид обработки
  // не выбрана customOptionalWorkToggle
  // если иначе у текущего материала разрешена customOptionalWorkToggle && выбранна customOptionalWorkToggle

  /*
    @printDataWorkName - string
    @formDataWorkName - string
    @curentMaterialType - arr
    @orderItem - arr

    @return - arr / false
  */

  $opionalWork = false;

  if (isset($curentMaterialType[$printDataWorkName]) && $curentMaterialType[$printDataWorkName] === true) {
    if (isset($formOrderItemData['customOptionalWorkToggle']) && $formOrderItemData['customOptionalWorkToggle'] === false) {

      $opionalWork = 'simple';
    }
    else if (isset($curentMaterialType['materialCustomOptionalWork']) &&
      $curentMaterialType['materialCustomOptionalWork'] === true &&
      isset($formOrderItemData['customOptionalWorkToggle']) &&
      $formOrderItemData['customOptionalWorkToggle'] === true) {

      $opionalWork = 'custom';
    }
  }
  return $opionalWork;
}

function getCringleValue($opionalWorkData) {
  $cringleValue = false;
    if (isset($opionalWorkData['cringle']) && (int) $opionalWorkData['cringle'] > 0) {
      $cringleValue = (int) $opionalWorkData['cringle'];
    }
    else if (isset($opionalWorkData['cringle']) && (string) $opionalWorkData['cringle'] === 'corners') {
      $cringleValue = 'corners';
    }
    else if (isset($opionalWorkData['cringle']) &&
             (string) $opionalWorkData['cringle'] === 'custom' &&
             isset($opionalWorkData['cringleCustom'])) {
      $cringleValue = (int) $opionalWorkData['cringleCustom'];
    }
  return $cringleValue;
}

function getGainValue($opionalWorkData) {
  $gainValue = false;
  if (isset($opionalWorkData['gain']) &&
      $opionalWorkData['gain'] === true) {
    $gainValue = true;
  }
  return $gainValue;
}


function getCutValue($opionalWorkData) {
  $cutValue = false;
  if (isset($opionalWorkData['cut']) &&
      $opionalWorkData['cut'] === true) {
    $cutValue = true;
  }
  return $cutValue;
}

function getCordValue($opionalWorkData) {
  $cordValue = false;
  if (isset($opionalWorkData['cord']) &&
      $opionalWorkData['cord'] === true) {
    $cordValue = true;
  }
  return $cordValue;
}

function getPocketValue($opionalWorkData) {
  $pocketValue = false;
    if (isset($opionalWorkData['pocket']) && (int) $opionalWorkData['pocket'] > 0) {
      $pocketValue = (int) $opionalWorkData['pocket'];
    }
    else if (isset($opionalWorkData['pocket']) &&
             (string) $opionalWorkData['pocket'] === 'custom' &&
             isset($opionalWorkData['pocketCustom'])) {

      $pocketValue = (int) $opionalWorkData['pocketCustom'];
    }
  return $pocketValue;
}

function getLamination($curentMaterialType, $formOrderItemData, $printData) {
// RELATION function simpleOrCustomOpionalWork

  $lamination = false;

  $simpleOrCustomLamination = simpleOrCustomOpionalWork('materialLamination', 'lamination', $curentMaterialType, $formOrderItemData);

  if ($simpleOrCustomLamination === 'simple' &&
      isset($formOrderItemData['simpleOptionalWork']['lamination']) &&
      (string) $formOrderItemData['simpleOptionalWork']['lamination'] !== 'none') {

    $lamination = $printData['optionalWorks']['lamination']['materials'][$formOrderItemData['simpleOptionalWork']['lamination']] ?? false;

  }

  return $lamination;
}

function getStickToPlastic($curentMaterialType, $formOrderItemData, $printData) {
// RELATION function simpleOrCustomOpionalWork

  $stickToPlastic = false;

  $simpleOrCustomStickToPlastic = simpleOrCustomOpionalWork('materialStickToPlastic', 'stickToPlastic', $curentMaterialType, $formOrderItemData);

  if ($simpleOrCustomStickToPlastic === 'simple' &&
      isset($formOrderItemData['simpleOptionalWork']['stickToPlastic']) &&
      (string) $formOrderItemData['simpleOptionalWork']['stickToPlastic'] !== 'none') {

    $stickToPlastic = $printData['optionalWorks']['stickToPlastic']['materials'][$formOrderItemData['simpleOptionalWork']['stickToPlastic']] ?? false;

  }

  return $stickToPlastic;
}

function getDesignPriceValue($opionalWorkData) {
  $designPrice = false;

    if (isset($opionalWorkData['designPrice']) && (int) $opionalWorkData['designPrice'] > 0) {
      $designPrice = (int) $opionalWorkData['designPrice'];
    }

    else if (isset($opionalWorkData['designPrice']) &&
             (string) $opionalWorkData['designPrice'] === 'custom' &&
             isset($opionalWorkData['designPriceCustom'])) {

      $designPrice = (int) $opionalWorkData['designPriceCustom'];
    }

  return $designPrice;
}

function getTotalFildsStandart($curentFields) {

  $totalFildsStandart = [
    'top' => $curentFields['tech']['top'] + $curentFields['margin']['top'] + $curentFields['pocket']['top'],
    'bottom' => $curentFields['tech']['bottom'] + $curentFields['margin']['bottom'] + $curentFields['pocket']['bottom'],
    'left' => $curentFields['tech']['left'] + $curentFields['margin']['left'] + $curentFields['pocket']['left'],
    'right' => $curentFields['tech']['right'] + $curentFields['margin']['right'] + $curentFields['pocket']['right'],
  ];

  return $totalFildsStandart;
}

function getTotalFildsMin($curentFields) {

  $totalFildsMin = [
    'top' => 0,
    'bottom' => 0,
    'left' => 0,
    'right' => 0,
  ];

  if ($curentFields['tech']['top'] >= $curentFields['margin']['top']) {
    $totalFildsMin['top'] = $curentFields['tech']['top'] + $curentFields['pocket']['top'];
  } else {
    $totalFildsMin['top'] = $curentFields['margin']['top'] + $curentFields['pocket']['top'];
  }

  if ($curentFields['tech']['bottom'] >= $curentFields['margin']['bottom']) {
    $totalFildsMin['bottom'] = $curentFields['tech']['bottom'] + $curentFields['pocket']['bottom'];
  } else {
    $totalFildsMin['bottom'] = $curentFields['margin']['bottom'] + $curentFields['pocket']['bottom'];
  }

  if ($curentFields['tech']['left'] >= $curentFields['margin']['left']) {
    $totalFildsMin['left'] = $curentFields['tech']['left'] + $curentFields['pocket']['left'];
  } else {
    $totalFildsMin['left'] = $curentFields['margin']['left'] + $curentFields['pocket']['left'];
  }

  if ($curentFields['tech']['right'] >= $curentFields['margin']['right']) {
    $totalFildsMin['right'] = $curentFields['tech']['right'] + $curentFields['pocket']['right'];
  } else {
    $totalFildsMin['right'] = $curentFields['margin']['right'] + $curentFields['pocket']['right'];
  }

  return $totalFildsMin;

} 

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////


function  getFilledArrQuantity($arr) {
  $arrNumber = 0;
  if (gettype($arr) === 'array') {
    foreach ($arr as $key => $value) {
      if (gettype($value) === 'array') {
        $arrNumber++;
      }
    }
  }
  return $arrNumber;
}


function getFirstArrIndex($arr) {
  $arrIndex = false;
  if (gettype($arr) === 'array') {
    foreach ($arr as $key => $value) {
      if (gettype($value) === 'array') {
        $arrIndex = $key;
        break;
      }
    }
  }
  return $arrIndex;
}


function getManualMaterialFormat($curentMaterialType, $curentPrintType, $formOrderItemData) {
  $manualMaterialFormat = false;
  if (isset($formOrderItemData['manualMaterialFormat']) &&
      (int) $formOrderItemData['manualMaterialFormat'] > 0 &&
      isset($curentMaterialType['materialFormats']) &&
      in_array((int) $formOrderItemData['manualMaterialFormat'], $curentMaterialType['materialFormats'])) {

    $manualMaterialFormat = (int) $formOrderItemData['manualMaterialFormat'];

    if (isset($curentPrintType['printerMaxWidth']) && (int) $formOrderItemData['manualMaterialFormat'] > $curentPrintType['printerMaxWidth']) {
      $manualMaterialFormat = false;
    }
  }
  return $manualMaterialFormat;
}


function getBiggestFormat($maxWidth, $formatsArr) {
  $biggestFormat = false;
  if (gettype($formatsArr) === 'array') {
    foreach ($formatsArr as $key => $value) {
      if ($value > $biggestFormat && $value <= $maxWidth || $value > $biggestFormat && $maxWidth === false) {
        $biggestFormat = (int) $value;
      }
    }
  }
  return $biggestFormat;
}
    

function getSizeParamSquare($sizeParamArr) {
  $sizeParamSquare = 0;
  foreach ($sizeParamArr as $key => $value) {
    if (isset($value['width']) && $value['width'] > 0 &&
        isset($value['height']) && $value['height'] > 0 &&
        isset($value['quantity']) && $value['quantity'] > 0) {

      $sizeParamSquare = $sizeParamSquare + $value['width'] * $value['height'] * $value['quantity'];
    }
  }
  return $sizeParamSquare;
}


function getFormatSizeParamSquare($sizeParamArr) {
  $sizeParamSquare = 0;
  foreach ($sizeParamArr as $key => $value) {
    if (isset($value['formatWidth']) && $value['formatWidth'] > 0 &&
        isset($value['formatHeight']) && $value['formatHeight'] > 0 &&
        isset($value['quantity']) && $value['quantity'] > 0) {

      $sizeParamSquare = $sizeParamSquare + $value['formatWidth'] * $value['formatHeight'] * $value['quantity'];
    }
  }
  return $sizeParamSquare;
}


function getPercentDifference($smal, $large) {
  $percentDifference = false;
  if ($smal > 0 && $large > 0) {
    $difference = $large - $smal;
    $percentDifference = 100 * $difference / $large;
  }
  return $percentDifference;
}


function getOptimalSizeParam($sizeParamsArr) {
  $minOverspendingPercent = 999999;
  $optimalSizeParam = [];
  foreach ($sizeParamsArr as $key => $value) {
    if (isset($value['overspendingPercent']) && $value['overspendingPercent'] < $minOverspendingPercent) {
      $minOverspendingPercent = $value['overspendingPercent'];
      $optimalSizeParam = $value;
    }
  }
  return $optimalSizeParam;
}


function getOptimalFormat($printWidth, $maxWidth, $formats, $curentFields) {
  $optimalFormat = false;
  $format = 999999;
  $printWidthMargin = $printWidth + $curentFields['margin']['left'] + $curentFields['margin']['right'];
  foreach ($formats as $key => $value) {
    if ($printWidthMargin <= $value && $value < $format && $value <= $maxWidth) {
      $format = $value;
      $optimalFormat = $value;
    }
  }
  return $optimalFormat;
}


function getCouplingSegmentsQuanity($printWidth, $formatWidth, $couplingMargin, $curentFields) {

  $standart = 0;
  $min = 0;

  if ($printWidth > 0 && $formatWidth > 0 && gettype($curentFields) === 'array') {

    $printWidthStndartField = $printWidth + $curentFields['pocket']['left'] + $curentFields['pocket']['right'] +
    $curentFields['tech']['left'] + $curentFields['tech']['right'];

    $printWidthMinField = $printWidth + $curentFields['pocket']['left'] + $curentFields['pocket']['right'];

    $printItemWithCoupling = $formatWidth - $curentFields['margin']['left'] - $curentFields['margin']['right'] - $couplingMargin;
    $printItemNoCoupling = $formatWidth - $curentFields['margin']['left'] - $curentFields['margin']['right'];

    for ($standart = 0; $printWidthStndartField > 0; $standart++) {
      if ($printWidthStndartField <= $printItemNoCoupling) {
        $printWidthStndartField = $printWidthStndartField - $printItemNoCoupling;
      }
      else {
        $printWidthStndartField = $printWidthStndartField - $printItemWithCoupling;
      }
    }

    for ($min = 0; $printWidthMinField > 0; $min++) {
      if ($printWidthMinField <= $printItemNoCoupling) {
        $printWidthMinField = $printWidthMinField - $printItemNoCoupling;
      }
      else {
        $printWidthMinField = $printWidthMinField - $printItemWithCoupling;
      }
    }
  }

  return [
    'standart' => $standart,
    'min' => $min
  ];

}


function getMaxCompositionItemsQuantity($printWidth, $canvasWidth, $curentFields) {

  $printWidth = (int) $printWidth;
  $canvasWidth = (int) $canvasWidth;

  $maxCompositionItemQuantityStandartField = 0;
  $maxCompositionItemQuantityMinField = 0;

  if ($printWidth > 0 && $canvasWidth > 0 && gettype($curentFields) === 'array') {

    $spaceBetwenPrint = $curentFields['pocket']['left'] + $curentFields['pocket']['right'] + $curentFields['tech']['left'] + $curentFields['tech']['right'];

    $maxCompositionItemQuantityStandartField = ($canvasWidth + $spaceBetwenPrint - $curentFields['totalStandart']['left'] - $curentFields['totalStandart']['right']) / ($printWidth + $spaceBetwenPrint);

    $maxCompositionItemQuantityMinField = ($canvasWidth + $spaceBetwenPrint - $curentFields['totalMin']['left'] - $curentFields['totalMin']['right']) / ($printWidth + $spaceBetwenPrint);

  }

  return [
    'standart' => (int) $maxCompositionItemQuantityStandartField,
    'min' => (int) $maxCompositionItemQuantityMinField
  ];

}


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////


function getAutoCompositionSizeParam($formatWidth, $sizeParamData, $CONFIG, $curentFields) {
// RELATION function getMaxCompositionItemsQuantity
// RELATION function getSizeParamSquare
// RELATION function getFormatSizeParamSquare
// RELATION function getPercentDifference

  $tempSizeParam = [];

  $printWidth = (int) roundUpAfterDecimal((float) (($sizeParamData['firstPrintSize']['width'] ?? 9999) * $CONFIG['CONVERT_SIZE_UNIT_TO_MM']) , 1);
  $printHeight = (int) roundUpAfterDecimal((float) (($sizeParamData['firstPrintSize']['height'] ?? 9999) * $CONFIG['CONVERT_SIZE_UNIT_TO_MM']) , 1);
//  $printWidth = (int) ((float) $sizeParamData['firstPrintSize']['width'] * $CONFIG['CONVERT_SIZE_UNIT_TO_MM']) ?? 0;
//  $printHeight = (int) ((float) $sizeParamData['firstPrintSize']['height'] * $CONFIG['CONVERT_SIZE_UNIT_TO_MM']) ?? 0;
  $printQuatity = (int) $sizeParamData['firstPrintSize']['quantity'] ?? 0;
  $fileName = trim(strip_tags($sizeParamData['firstPrintSize']['fileName']));

  $maxCompositionItemQuantity = getMaxCompositionItemsQuantity($printWidth, $formatWidth, $curentFields);

  if ($maxCompositionItemQuantity['min'] > 0 && $printWidth > 0 && $printHeight > 0 && $printQuatity > 0) {

    $tempSizeParam['printSize'][0]['width'] = $printWidth;
    $tempSizeParam['printSize'][0]['height'] = $printHeight;
    $tempSizeParam['printSize'][0]['quantity'] = $printQuatity;
    $tempSizeParam['noTechFieldX'] = false;
    $tempSizeParam['couplingMargin'] = false;
    
    $columnNumbers = 0;
    $xSidesFields = 0;

    if ($maxCompositionItemQuantity['standart'] === $maxCompositionItemQuantity['min']) {

      $columnNumbers = $maxCompositionItemQuantity['standart'];

      $xSidesFields = $curentFields['tech']['left'] + $curentFields['tech']['right'] +
      $curentFields['pocket']['left'] + $curentFields['pocket']['right'];
    }
    else {

      $tempSizeParam['noTechFieldX'] = true;

      $columnNumbers = $maxCompositionItemQuantity['min'];

      $xSidesFields = $curentFields['pocket']['left'] + $curentFields['pocket']['right'];
    }

    $rowNumber = (int) ceil(($printQuatity / $columnNumbers));

    $canvasWidth = $printWidth * $columnNumbers + $xSidesFields + 
    ($curentFields['pocket']['left'] + $curentFields['pocket']['right'] + 
    $curentFields['tech']['left'] + $curentFields['tech']['right']) * ($columnNumbers - 1);

    $canvasHeight = $printHeight * $rowNumber +
    $curentFields['tech']['top'] + $curentFields['tech']['bottom'] + 
    $curentFields['pocket']['top'] + $curentFields['pocket']['bottom'] +
    ($curentFields['pocket']['top'] + $curentFields['pocket']['bottom'] + 
    $curentFields['tech']['top'] + $curentFields['tech']['bottom']) * ($rowNumber - 1);

    $formatHeight = $printHeight * $rowNumber +
    $curentFields['totalStandart']['top'] + $curentFields['totalStandart']['bottom'] + 
    ($curentFields['pocket']['top'] + $curentFields['pocket']['bottom'] + 
    $curentFields['tech']['top'] + $curentFields['tech']['bottom']) * ($rowNumber - 1);

    $tempSizeParam['canvasSize'][0]['width'] = $canvasWidth;
    $tempSizeParam['canvasSize'][0]['formatWidth'] = $formatWidth;
    $tempSizeParam['canvasSize'][0]['height'] = $canvasHeight;
    $tempSizeParam['canvasSize'][0]['formatHeight'] = $formatHeight; 
    $tempSizeParam['canvasSize'][0]['quantity'] = 1;
    $tempSizeParam['canvasSize'][0]['fileName'] = $fileName;


    $tempSizeParam['printSquare'] = getSizeParamSquare($tempSizeParam['printSize']) / $CONFIG['CONVERT_MM_TO_M'] / $CONFIG['CONVERT_MM_TO_M'];
    $tempSizeParam['canvasSquare'] = getFormatSizeParamSquare($tempSizeParam['canvasSize']) / $CONFIG['CONVERT_MM_TO_M'] / $CONFIG['CONVERT_MM_TO_M'];
    $tempSizeParam['overspendingPercent'] = getPercentDifference($tempSizeParam['printSquare'], $tempSizeParam['canvasSquare']);
    $tempSizeParam['algorithm'] = 'atoComposition';

    $tempSizeParam['rowNumber'] = $rowNumber;
    $tempSizeParam['columnNumbers'] = $columnNumbers;

  }

  return $tempSizeParam;

}


function getOptimalAutoCompositionSizeParam($sizeParamData, $CONFIG, $curentFields) {
// RELATION function getOptimalSizeParam
  $sizeParam = [];

  if ($sizeParamData['manualMaterialFormat'] > 0) {
    $sizeParam = getAutoCompositionSizeParam($sizeParamData['manualMaterialFormat'], $sizeParamData, $CONFIG, $curentFields);
  }
  else {
    $sizeParamVariants = [];
    foreach ($sizeParamData['materialFormats'] as $key => $value) {
      if ($value <= $sizeParamData['printerMaxWidth']) {
        $sizeParamVariants[] = getAutoCompositionSizeParam($value, $sizeParamData, $CONFIG, $curentFields);
      }
    }
    $sizeParam = getOptimalSizeParam($sizeParamVariants);
  }

  return $sizeParam;

}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function getSingleSizeParam($formatWidth, $sizeParamData, $CONFIG, $curentFields) {
// RELATION function getMaxCompositionItemsQuantity
// RELATION function getSizeParamSquare
// RELATION function getFormatSizeParamSquare
// RELATION function getPercentDifference
  $tempSizeParam = [];

  $printWidth = (int) roundUpAfterDecimal((float) (($sizeParamData['firstPrintSize']['width'] ?? 9999) * $CONFIG['CONVERT_SIZE_UNIT_TO_MM']) , 1);
  $printHeight = (int) roundUpAfterDecimal((float) (($sizeParamData['firstPrintSize']['height'] ?? 9999) * $CONFIG['CONVERT_SIZE_UNIT_TO_MM']) , 1);
//  $printWidth = (int) ((float) $sizeParamData['firstPrintSize']['width'] * $CONFIG['CONVERT_SIZE_UNIT_TO_MM']) ?? 0;
//  $printHeight = (int) ((float) $sizeParamData['firstPrintSize']['height'] * $CONFIG['CONVERT_SIZE_UNIT_TO_MM']) ?? 0;
  $printQuatity = (int) $sizeParamData['firstPrintSize']['quantity'] ?? 0;
  $fileName = trim(strip_tags($sizeParamData['firstPrintSize']['fileName']));

  $maxCompositionItemQuantity = getMaxCompositionItemsQuantity($printWidth, $formatWidth, $curentFields);

  
  if ($maxCompositionItemQuantity['min'] > 0 && $printWidth > 0 && $printHeight > 0 && $printQuatity > 0) {

    $tempSizeParam['printSize'][0]['width'] = $printWidth;
    $tempSizeParam['printSize'][0]['height'] = $printHeight;
    $tempSizeParam['printSize'][0]['quantity'] = $printQuatity;
    $tempSizeParam['noTechFieldX'] = false;
    $tempSizeParam['couplingMargin'] = false;
    $tempSizeParam['rowNumber'] = false;
    $tempSizeParam['columnNumbers'] = false;

    if ($maxCompositionItemQuantity['standart'] > 0 && $maxCompositionItemQuantity['min'] > 0) {
      
      $xSidesFields = $curentFields['tech']['left'] + $curentFields['tech']['right'] +
      $curentFields['pocket']['left'] + $curentFields['pocket']['right'];

    }
    else {

      $tempSizeParam['noTechFieldX'] = true;
      $xSidesFields = $curentFields['pocket']['left'] + $curentFields['pocket']['right'];

    }

    $canvasWidth = $printWidth + $xSidesFields;

    $canvasHeight = $printHeight +
    $curentFields['tech']['top'] + $curentFields['tech']['bottom'] + 
    $curentFields['pocket']['top'] + $curentFields['pocket']['bottom'];

    $formatHeight = $printHeight +
    $curentFields['totalStandart']['top'] + $curentFields['totalStandart']['bottom'];

    $tempSizeParam['canvasSize'][0]['width'] = $canvasWidth;
    $tempSizeParam['canvasSize'][0]['formatWidth'] = $formatWidth;
    $tempSizeParam['canvasSize'][0]['height'] = $canvasHeight;
    $tempSizeParam['canvasSize'][0]['formatHeight'] = $formatHeight;
    $tempSizeParam['canvasSize'][0]['quantity'] = $printQuatity;
    $tempSizeParam['canvasSize'][0]['fileName'] = $fileName;

    $tempSizeParam['printSquare'] = getSizeParamSquare($tempSizeParam['printSize']) / $CONFIG['CONVERT_MM_TO_M'] / $CONFIG['CONVERT_MM_TO_M'];
    $tempSizeParam['canvasSquare'] = getFormatSizeParamSquare($tempSizeParam['canvasSize']) / $CONFIG['CONVERT_MM_TO_M'] / $CONFIG['CONVERT_MM_TO_M'];
    $tempSizeParam['overspendingPercent'] = getPercentDifference($tempSizeParam['printSquare'], $tempSizeParam['canvasSquare']);
    $tempSizeParam['algorithm'] = 'single';

  }

  return $tempSizeParam;

}


function getOptimalSingleSizeParam($sizeParamData, $CONFIG, $curentFields) {
// RELATION function getOptimalSizeParam
  $sizeParam = [];

  if ($sizeParamData['manualMaterialFormat'] > 0) {
    $sizeParam = getSingleSizeParam($sizeParamData['manualMaterialFormat'], $sizeParamData, $CONFIG, $curentFields);
  }
  else {
    $sizeParamVariants = [];
    foreach ($sizeParamData['materialFormats'] as $key => $value) {
      if ($value <= $sizeParamData['printerMaxWidth']) {
        $sizeParamVariants[] = getSingleSizeParam($value, $sizeParamData, $CONFIG, $curentFields);
      }
    }
    $sizeParam = getOptimalSizeParam($sizeParamVariants);
  }

  return $sizeParam;

}


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////


function getCanvasSizeSameItemsWidth($tempData) {
  $canvasSize = [];

  $canvasSize[0]['width'] = (int) ($tempData['printWidthWithFields'] / $tempData['couplingSegmentsQuanity']);
  $canvasSize[0]['formatWidth'] = $tempData['formatWidth'];
  $canvasSize[0]['height'] = $tempData['canvasHeight'];
  $canvasSize[0]['formatHeight'] = $tempData['formatHeight'];
  $canvasSize[0]['quantity'] = $tempData['printQuatity'] * $tempData['couplingSegmentsQuanity'];
  $canvasSize[0]['fileName'] = $tempData['fileName'];

  return $canvasSize;
}

function getCanvasSizeDiferentItemsWidth($tempData) {
  $canvasSize = [];

  $canvasSize[0]['width'] = $tempData['formatWidth'] - $tempData['curentFields']['margin']['left'] - $tempData['curentFields']['margin']['right'];
  $canvasSize[0]['formatWidth'] = $tempData['formatWidth'];
  $canvasSize[0]['height'] = $tempData['canvasHeight'];
  $canvasSize[0]['formatHeight'] = $tempData['formatHeight'];
  $canvasSize[0]['quantity'] = $tempData['printQuatity'] * ($tempData['couplingSegmentsQuanity'] - 1);
  $canvasSize[0]['fileName'] = $tempData['fileName'];

  $canvasSize[1]['width'] = $tempData['lastSegmentWidth'];
  $canvasSize[1]['formatWidth'] = $tempData['formatWidth'];
  $canvasSize[1]['height'] = $tempData['canvasHeight'];
  $canvasSize[1]['formatHeight'] = $tempData['formatHeight'];
  $canvasSize[1]['quantity'] = $tempData['printQuatity'];
  $canvasSize[1]['fileName'] = $tempData['fileName'];

    
    
  return $canvasSize;
}


function getCouplingSizeParam($formatWidth, $sizeParamData, $CONFIG, $curentFields) {
// RELATION function getCouplingSegmentsQuanity
// RELATION function getSizeParamSquare
// RELATION function getFormatSizeParamSquare
// RELATION function getPercentDifference
// RELATION function getBiggestFormat
  $tempSizeParam = [];


  $printWidth = (int) roundUpAfterDecimal((float) (($sizeParamData['firstPrintSize']['width'] ?? 9999) * $CONFIG['CONVERT_SIZE_UNIT_TO_MM']), 1);
  $printHeight = (int) roundUpAfterDecimal((float) (($sizeParamData['firstPrintSize']['height'] ?? 9999) * $CONFIG['CONVERT_SIZE_UNIT_TO_MM']), 1);
//  $printWidth = (int) ((float) $sizeParamData['firstPrintSize']['width'] * $CONFIG['CONVERT_SIZE_UNIT_TO_MM']) ?? 0;
//  $printHeight = (int) ((float) $sizeParamData['firstPrintSize']['height'] * $CONFIG['CONVERT_SIZE_UNIT_TO_MM']) ?? 0;
  $printQuatity = (int) $sizeParamData['firstPrintSize']['quantity'] ?? 0;
  $fileName = trim(strip_tags($sizeParamData['firstPrintSize']['fileName']));

  $canvasHeight = $printHeight +
  $curentFields['tech']['top'] + $curentFields['tech']['bottom'] + 
  $curentFields['pocket']['top'] + $curentFields['pocket']['bottom'];

  $formatHeight = $printHeight +
  $curentFields['totalStandart']['top'] + $curentFields['totalStandart']['bottom'];

  $couplingSegmentsQuanity = getCouplingSegmentsQuanity($printWidth, $formatWidth, $sizeParamData['couplingMargin'], $curentFields);

  if ($couplingSegmentsQuanity['min'] > 1 && $printWidth > 0 && $printHeight > 0 && $printQuatity > 0) {

    $tempSizeParam['printSize'][0]['width'] = $printWidth;
    $tempSizeParam['printSize'][0]['height'] = $printHeight;
    $tempSizeParam['printSize'][0]['quantity'] = $printQuatity;
    $tempSizeParam['noTechFieldX'] = false;
    $tempSizeParam['couplingMargin'] = false;
    $tempSizeParam['rowNumber'] = false;
    $tempSizeParam['columnNumbers'] = false;

    $tempData = [
      'printQuatity' => $printQuatity,
      'printHeight' => $printHeight,
      'formatWidth' => $formatWidth,
      'fileName' => $fileName,
      'curentFields' => $curentFields,
      'canvasHeight' => $canvasHeight,
      'formatHeight' => $formatHeight,
      'printWidthWithFields' => 0,
      'couplingSegmentsQuanity' => 0,
      'lastSegmentWidth' => 0,
    ];

    if ($couplingSegmentsQuanity['standart'] === $couplingSegmentsQuanity['min']) {

      $tempData['printWidthWithFields'] = $printWidth +
      ($sizeParamData['couplingMargin'] * ($couplingSegmentsQuanity['standart'] - 1)) +
      $curentFields['pocket']['left'] + $curentFields['pocket']['right'] +
      $curentFields['tech']['left'] + $curentFields['tech']['right'];

      $tempData['couplingSegmentsQuanity'] = $couplingSegmentsQuanity['standart'];
    }
    else {

      $tempSizeParam['noTechFieldX'] = true;

      $tempData['printWidthWithFields'] = $printWidth +
      ($sizeParamData['couplingMargin'] * ($couplingSegmentsQuanity['min'] - 1)) +
      $curentFields['pocket']['left'] + $curentFields['pocket']['right'];

      $tempData['couplingSegmentsQuanity'] = $couplingSegmentsQuanity['min'];
    }

    $tempData['lastSegmentWidth'] = $tempData['printWidthWithFields'] % ($formatWidth - $curentFields['margin']['left'] - $curentFields['margin']['right']);

    if ($couplingSegmentsQuanity['min'] <= $CONFIG['MAX_SAME_COUPLING_ITEMS'] || $tempData['lastSegmentWidth'] === 0) {
      $tempSizeParam['canvasSize'] = getCanvasSizeSameItemsWidth($tempData);
    }
    else {
      $tempSizeParam['canvasSize'] = getCanvasSizeDiferentItemsWidth($tempData);
    }

    $tempSizeParam['printSquare'] = getSizeParamSquare($tempSizeParam['printSize']) / $CONFIG['CONVERT_MM_TO_M'] / $CONFIG['CONVERT_MM_TO_M'];
    $tempSizeParam['canvasSquare'] = getFormatSizeParamSquare($tempSizeParam['canvasSize']) / $CONFIG['CONVERT_MM_TO_M'] / $CONFIG['CONVERT_MM_TO_M'];
    $tempSizeParam['overspendingPercent'] = getPercentDifference($tempSizeParam['printSquare'], $tempSizeParam['canvasSquare']);
    $tempSizeParam['algorithm'] = 'coupling';

    $tempSizeParam['couplingMargin'] = $sizeParamData['couplingMargin'];

  }

  return $tempSizeParam;

}



function getOptimalCouplingSizeParam($sizeParamData, $CONFIG, $curentFields) {

  $sizeParam = [];


  if ($sizeParamData['manualMaterialFormat'] > 0) {
    $sizeParam = getCouplingSizeParam($sizeParamData['manualMaterialFormat'], $sizeParamData, $CONFIG, $curentFields);
  }
  else if ((int) ((float) $sizeParamData['firstPrintSize']['width'] * $CONFIG['CONVERT_SIZE_UNIT_TO_MM']) > $CONFIG['MAX_WIDTH_OPTIMAL_COUPLIG']) {
    $biggestFormat = getBiggestFormat($sizeParamData['printerMaxWidth'], $sizeParamData['materialFormats']);
    $sizeParam = getCouplingSizeParam($biggestFormat, $sizeParamData, $CONFIG, $curentFields);
  }
  else {
    $sizeParamVariants = [];
    
    // если доступно более 3 форматов то подбирать оптимальный формат с третьего по счету
    $materialFormatsCountIndex = 0;
    $avalaibleFormatsQuantity = count($sizeParamData['materialFormats']);
    if ($avalaibleFormatsQuantity > 3 && $sizeParamData['materialFormats'][$avalaibleFormatsQuantity - 1] <= $sizeParamData['printerMaxWidth']) {
      $materialFormatsCountIndex = -2;
    }
    
    foreach ($sizeParamData['materialFormats'] as $key => $value) {
      if ($value <= $sizeParamData['printerMaxWidth'] && $materialFormatsCountIndex >= 0) {
        $sizeParamVariants[] = getCouplingSizeParam($value, $sizeParamData, $CONFIG, $curentFields);
      }
      $materialFormatsCountIndex++;
    }
    $sizeParam = getOptimalSizeParam($sizeParamVariants);
  }

  return $sizeParam;
  

}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////


function getManualCompositionSizeParam($sizeParamData, $CONFIG, $curentFields) {

  $sizeParam = [];

  $tempSizeParam = [];
  $printSize = [];
  $canvasSize = [];

  foreach ($sizeParamData['printSize'] as $key => $value) {

    if (isset($value['width']) && $value['width'] > 0 &&
        isset($value['height']) && $value['height'] > 0 &&
        isset($value['quantity']) && $value['quantity'] > 0) {

      $printSize[] = [
        'width' => (int) roundUpAfterDecimal((float) (($value['width'] ?? 9999) * $CONFIG['CONVERT_SIZE_UNIT_TO_MM']) , 1),
        'height' => (int) roundUpAfterDecimal((float) (($value['height'] ?? 9999) * $CONFIG['CONVERT_SIZE_UNIT_TO_MM']), 1),
        'quantity' => (int) $value['quantity']
      ];

    }
  }

  foreach ($sizeParamData['canvasSize'] as $key => $value) {

    $printWidth = (int) roundUpAfterDecimal((float) (($value['width'] ?? 9999) * $CONFIG['CONVERT_SIZE_UNIT_TO_MM']), 1);
    $printHeight = (int) roundUpAfterDecimal((float) (($value['height'] ?? 9999) * $CONFIG['CONVERT_SIZE_UNIT_TO_MM']), 1);
    $printQuatity = (int) $value['quantity'] ?? 9999;

    if ($printWidth > 0 && $printHeight > 0 && $printQuatity > 0) {

      $optimalFormat = getOptimalFormat($printWidth, $sizeParamData['printerMaxWidth'], $sizeParamData['materialFormats'], $curentFields);
      $printWidthMargin = $printWidth + $curentFields['margin']['left'] + $curentFields['margin']['right'];

      if ($sizeParamData['manualMaterialFormat'] >= $printWidthMargin) {

        $canvasSize[] = [
          'width' => $printWidth,
          'formatWidth' => $sizeParamData['manualMaterialFormat'],
          'height' => $printHeight,
          'formatHeight' => $printHeight + $curentFields['margin']['top'] + $curentFields['margin']['bottom'],
          'quantity' => $printQuatity,
          'fileName' => strip_tags(trim($value['fileName']))
        ];

      }

      else if ($sizeParamData['manualMaterialFormat'] === false && $optimalFormat >= $printWidthMargin) {

        $canvasSize[] = [
          'width' => $printWidth,
          'formatWidth' => $optimalFormat,
          'height' => $printHeight,
          'formatHeight' => $printHeight + $curentFields['margin']['top'] + $curentFields['margin']['bottom'],
          'quantity' => $printQuatity,
          'fileName' => strip_tags(trim($value['fileName']))
        ];

      }
    }
  }

  $formatSquare = getSizeParamSquare($canvasSize) / $CONFIG['CONVERT_MM_TO_M'] / $CONFIG['CONVERT_MM_TO_M'];

  $tempSizeParam['printSize'] = $printSize;
  $tempSizeParam['canvasSize'] = $canvasSize;
  $tempSizeParam['noTechFieldX'] = false;
  $tempSizeParam['couplingMargin'] = false;
  $tempSizeParam['rowNumber'] = false;
  $tempSizeParam['columnNumbers'] = false;
  $tempSizeParam['algorithm'] = 'manualComposition';
  $tempSizeParam['printSquare'] = getSizeParamSquare($tempSizeParam['printSize']) / $CONFIG['CONVERT_MM_TO_M'] / $CONFIG['CONVERT_MM_TO_M'];
  $tempSizeParam['canvasSquare'] = getFormatSizeParamSquare($tempSizeParam['canvasSize']) / $CONFIG['CONVERT_MM_TO_M'] / $CONFIG['CONVERT_MM_TO_M'];
  $tempSizeParam['overspendingPercent'] = getPercentDifference($tempSizeParam['printSquare'], $tempSizeParam['canvasSquare']);

  if ($tempSizeParam['printSquare'] <= $formatSquare) {
    $sizeParam = $tempSizeParam;
  } 

  return $sizeParam;

}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function getLaminationOrStickSize($curentSizeParam, $curentLaminationOrStick, $maxWidth) {

  $isOksize = true;

  $size = [];

  $curentFields = [
    'margin' => [
      'left' => $curentLaminationOrStick['materialMargin']['x'] ?? 99,
      'right' => $curentLaminationOrStick['materialMargin']['x'] ?? 99
    ]
  ];

  $firstSegmentOptimalFormatWidth = getOptimalFormat($curentSizeParam['canvasSize'][0]['width'],
                                                     $maxWidth, $curentLaminationOrStick['materialFormats'] ?? [],
                                                     $curentFields);

  foreach ($curentSizeParam['canvasSize'] as $key => $value) {

    $optimalFormatWidth = getOptimalFormat($value['width'], $maxWidth, $curentLaminationOrStick['materialFormats'] ?? [], $curentFields);

    if ($optimalFormatWidth > 0 && $curentSizeParam['algorithm'] === 'coupling') {

      $size[] = [
        'width' => $value['width'],
        'formatWidth' => $firstSegmentOptimalFormatWidth,
        'height' => $value['height'],
        'formatHeight' => $value['height'] + (($curentLaminationOrStick['materialMargin']['y'] ?? 99) * 2),
        'quantity' => $value['quantity']
      ];

    }

    else if ($optimalFormatWidth > 0) {

      $size[] = [
        'width' => $value['width'],
        'formatWidth' => $optimalFormatWidth,
        'height' => $value['height'],
        'formatHeight' => $value['height'] + (($curentLaminationOrStick['materialMargin']['y'] ?? 99) * 2),
        'quantity' => $value['quantity'] 
      ];

    }

    else {
      $isOksize = false;
      break;
    }

  }

  if ($isOksize === true) {
    return $size;
  }
  else {
    return [];
  }

}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function roundUpAfterDecimal($num, $step) {
  if ($num === 0) return 0;
  return ceil($num * $step) / $step;
}

function roundDownBeforeDecimal($num, $step) {
  if ($num === 0) return 0;
  return ((int) ($num / $step)) * $step;
}


function getCringleQuatity($printSize, $cringle) {

  $cringleQuatity = 0;

  foreach ($printSize as $key => $value) {

    $quatity = 0;

    if ($cringle['other'] === 'corners') {
      $quatity = 4 * $value['quantity'];
    }
    else {
      if (isset($value['width']) && $value['width'] > 0 && $cringle['top'] > 0) {
        $quatity = $quatity + (int) ($value['width'] * $value['quantity'] / $cringle['top']);
      }

      if (isset($value['width']) && $value['width'] > 0 && $cringle['bottom'] > 0) {
        $quatity = $quatity + (int) ($value['width'] * $value['quantity'] / $cringle['bottom']);
      }

      if (isset($value['height']) && $value['height'] > 0 && $cringle['left'] > 0) {
        $quatity = $quatity + (int) ($value['height'] * $value['quantity'] / $cringle['left']);
      }

      if (isset($value['height']) && $value['height'] > 0 && $cringle['right'] > 0) {
        $quatity = $quatity + (int) ($value['height'] * $value['quantity'] / $cringle['right']);
      }
    }

    $cringleQuatity = $cringleQuatity + $quatity;
  }

  return $cringleQuatity;

}


function getOptionalWorkQuatity($printSize, $optionalWork) {

  $optionalWorkQuantity = 0;

  foreach ($printSize as $key => $value) {

    $quatity = 0;

    if (isset($value['width']) && $value['width'] > 0) {

      if  ($optionalWork['top'] === true || $optionalWork['top'] > 0) {
        $quatity = $quatity + (int) ($value['width'] * $value['quantity']);
      }
      if  ($optionalWork['bottom'] === true || $optionalWork['bottom'] > 0) {
        $quatity = $quatity + (int) ($value['width'] * $value['quantity']);
      }

    }

    if (isset($value['height']) && $value['height'] > 0) {

      if  ($optionalWork['left'] === true || $optionalWork['left'] > 0) {
        $quatity = $quatity + (int) ($value['height'] * $value['quantity']);
      }
      if  ($optionalWork['right'] === true || $optionalWork['right'] > 0) {
        $quatity = $quatity + (int) ($value['height'] * $value['quantity']);
      }

    }

    $optionalWorkQuantity = $optionalWorkQuantity + $quatity;
  }

  return $optionalWorkQuantity;

}


function selectPrice($priceGradation, $squareGradation, $curentSquare) {
  $priceIndex = 0;
  $price = false;

  if (gettype($priceGradation) === 'array' && gettype($priceGradation) === 'array') {
    foreach ($squareGradation as $key => $value) {
      if ($curentSquare >= (int) $value ) {
        $priceIndex = $key;
      }
    }

    $priceGradationArrayLenght = count($priceGradation);

    if (($priceGradationArrayLenght - 1) < $priceIndex) {
      $price = $priceGradation[$priceGradationArrayLenght - 1] ?? 999999;
    }
    else {
      $price = $priceGradation[$priceIndex] ?? 999999;
    }
  }

  return $price;

}

function calculationsTotalOrderItem($calculationsData, $include) {

  $total = [];

  foreach ($calculationsData as $key => $value) {

    foreach ($value as $key2 => $value2) {

      if (in_array($key2, $include) && isset($total[$key2])) {
        $total[$key2] = $total[$key2] + $value2;
      }
      else if (in_array($key2, $include)) {
        $total[$key2] = $value2;
      }

    }

  }

  return $total;
}


function getApproximatePrintSizeItemPrice($curentSizeParam, $totalPrice, $CONFIG) {

  $printSize = [];

  foreach ($curentSizeParam['printSize'] as $key => $value) {

    $printSize[$key] = $value;

    $itemSquare = $value['width'] * $value['height'] * $value['quantity'] / $CONFIG['CONVERT_MM_TO_M'] / $CONFIG['CONVERT_MM_TO_M'];

    $printSize[$key]['price'] = (int) ceil($totalPrice * $itemSquare / $curentSizeParam['printSquare']);

  }

  return $printSize;

}


function calculationsTotal($orderItems) {

  $total = [];

  foreach ($orderItems as $key => $value) {
    if (isset($value['calculations'])) {

      foreach ($value['calculations'] as $key2 => $value2) {
        if (isset($total[$key2])) {
          foreach ($value2 as $key3 => $value3) {
            
            if (isset($total[$key2][$key3]) && gettype($value3) === 'double' ||
                isset($total[$key2][$key3]) && gettype($value3) === 'integer') {
                
              $total[$key2][$key3] = $total[$key2][$key3] + $value3;
            }
            else {
              $total[$key2][$key3] = $value3;
            }
          }

        }
        else {
          $total[$key2] = $value2;
        }
      }
    }
  }
  return $total;
}


function calculateOrderSquare($form) {
  $square = 0;

  foreach ($form['orderItems'] as $key => $value) {

    if (!isset($value['printSize'])) continue;

    foreach ($value['printSize'] as $key2 => $value2) {

      if (isset($value2['width']) && (float) $value2['width'] > 0 &&
          isset($value2['height']) && (float) $value2['height'] > 0 &&
          isset($value2['quantity']) && (float) $value2['quantity'] > 0) {

        $square = $square + ((float) $value2['width'] * (float) $value2['height'] * $value2['quantity']);

      }


    }

  }
  return $square;
}



function rotateSize($input) {
  $output = [];
  foreach ($input as $key => $value) {
    if ($key === 'margin') {
      $output[$key] = $value;
    }
    else if (isset($value['other']) && isset($value['top']) && isset($value['bottom']) && isset($value['left']) && isset($value['right'])) {
      $curent = [
        'other' => $value['other'],
        'top' => $value['left'],
        'bottom' => $value['right'],
        'left' => $value['bottom'],
        'right' => $value['top'],
      ];
      $output[$key] = $curent;
    }
    else if (isset($value['top']) && isset($value['bottom']) && isset($value['left']) && isset($value['right'])) {
      $curent = [
        'top' => $value['left'],
        'bottom' => $value['right'],
        'left' => $value['bottom'],
        'right' => $value['top'],
      ];
      $output[$key] = $curent;
    }
    else {
      $output[$key] = $value;
    }
  }
  return $output;
}
