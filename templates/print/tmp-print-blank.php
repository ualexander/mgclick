<?php

$CONVERT_MM_TO_SIZE_UNIT = 1000;

?>
<!doctype html>
<html lang="ru">
<head>
  <title>Бланк заказа <?= $data['calcResultData']['items'][0]['productParam']['orderName'] ?? '' ?> </title>
  <link href="../img/rocket-logo-64.png" rel="icon" type="image/x-icon">
  <style>
    @page {
      margin: 0cm;
    }
    .pb-10 {
      padding-bottom: 10px;
    }
    @media screen {
      .order-blank {
        border: 1px dashed red
      }
    }
    .order-blank img {
      margin: 0;
      padding: 0;
    }
    .order-blank {
      width: 20cm;
      height: 28cm;
      page-break-after: always;
      margin: auto;
      font-family: sans-serif;
      padding-top: 20px;
      padding-bottom: 10px;
      padding-left: 10px;
      padding-right: 10px;
    }
    .order-blank table {
      width: 100%;
      border-collapse: collapse
    }
    .order-blank td {
      width: 50%;
      vertical-align: top
    }
    .order-blank td {
      font-weight: 100;
      font-size: 14px
    }
    .order-blank td div {
      min-height: 25px
    }
    .order-blank td div span {
      line-height: 25px;
      vertical-align: bottom
    }
    .order-blank h3, .order-blank h4 {
      margin: 0;
      padding: 0
    }
    .order-blank .border-bottom {
      border-bottom: 1px solid
    }
    .order-blank .padding-top {
      padding-top: 20px
    }
    .attention-text {
      font-weight: 800;
      color: red
    }
    .align-center {
      text-align: center
    }
  </style>
  <script src="../js/qrcode-min.js"></script>
</head>
<body>
<div class="order-blank-conteiner">
  <?php foreach ($data['calcResultData']['items'] as $key => $value): ?>
  <?php  if ($data['only'] !== false && $key !== (int) $data['only']) continue; ?>
    <div class="order-blank">
      <table>
        <tr class="border-bottom">
          <?php if ($value['productParam']['status'] === 'в работе'): ?>
            <td>
              <div class="pb-10" id="qrcode<?= $value['productParam']['index'] ?>"></div>
              <script type="text/javascript">
                var qrcode = new QRCode(document.getElementById("qrcode<?= $value['productParam']['index'] ?>"), {
                  text: "<?= $value['productParam']['qr'] ?? '?' ?>",
                  width: 120,
                  height: 120,
                  colorDark: "#000000",
                  colorLight: "#ffffff",
                  correctLevel: QRCode.CorrectLevel.L
                });
              </script>
            </td>
          <?php elseif ($value['productParam']['status'] === 'отменен'): ?>
            <td class="border-bottom"><h1 class="attention-text"><?= $value['productParam']['status'] ?></h1></td>
          <?php elseif ($value['productParam']['status']): ?>
            <td class="border-bottom"><h1 class=""><?= $value['productParam']['status'] ?></h1></td>
          <?php else: ?>
            <td class="border-bottom"><h1 class="">пробный бланк</h1></td>
          <?php endif; ?>
          <?php if ($value['productParam']['status']): ?>
            <td>
              <h4>Дата: <?= $value['productParam']['dateCreate'] ?? '?' ?></h4>
              <h4>Заказчик: <?= $value['productParam']['customer'] ?? '?' ?></h4>
              <h4>Заказ: <?= $value['productParam']['orderName'] ?? '?' ?></h4>
              <h4>Бланк: <?= $value['productParam']['index'] + 1 . ' / ' . ($value['productParam']['orderItemsQuantity'] ?? '?') ?></h4>
            </td>
          <?php else: ?>
            <td>
              <h1>форма: <?= $value['productParam']['index'] + 1 ?></h1>
            </td>
          <?php endif; ?>

        </tr>
        <tr class="border-bottom">
          <td>
            <h4><?= $value['productParam']['materialTypeRu'] ?></h4>
          </td>
          <td>
            <h4><?= $value['productParam']['printTypeRu'] ?></h4>
          </td>
        </tr>
        <tr class="border-bottom">
          <td class="align-center padding-top">
            <h4>Печатные размеры</h4>
          </td>
          <td class="align-center padding-top">
            <h4>Фактические размеры</h4>
          </td>
        </tr>
        <tr>
          <td>
            <?php foreach ($value['curentSizeParam']['canvasSize'] as $canvasSizeKey => $canvasSizeValue): ?>
              <div class="border-bottom">
                <?php if ($canvasSizeValue['quantity'] > 1): ?>
                <span class="attention-text">
              <?php else: ?>
                  <span class="">
                <?php endif; ?>
                    <?=
                    $canvasSizeValue['width'] . ' * ' .
                    $canvasSizeValue['height'] . ' - ' .
                    $canvasSizeValue['quantity'] . ' шт, формат ' .
                    $canvasSizeValue['formatWidth'] / $CONVERT_MM_TO_SIZE_UNIT
                    ?>
                    <?php if ($canvasSizeValue['fileName']): ?>
                      (<?= $canvasSizeValue['fileName'] ?>)
                    <?php endif; ?>
              </span>
              </div>
            <?php endforeach; ?>
          </td>
          <td>
            <?php foreach ($value['curentSizeParam']['printSize'] as $printSizeKey => $printSizeValue): ?>
              <div class="border-bottom">
            <span class="">
              <?=
              $printSizeValue['width'] / $CONVERT_MM_TO_SIZE_UNIT . ' * ' .
              $printSizeValue['height'] / $CONVERT_MM_TO_SIZE_UNIT . ' - ' .
              $printSizeValue['quantity'] . ' шт, ' .
              $printSizeValue['price'] . ' ' . $data['config']['currency']
              ?>
            </span>
              </div>
            <?php endforeach; ?>
          </td>
        </tr>
        <tr class="border-bottom">
          <td class="align-center padding-top" colspan="2">
            <h3>Обработка</h3>
          </td>
        </tr>
        <?php
        $laminationFormatDescription = [];
        foreach ($value['curentLaminationSize'] as $laminationSizeKey => $laminationSizeValue) {
          if (array_search($laminationSizeValue['formatWidth'] / $CONVERT_MM_TO_SIZE_UNIT, $laminationFormatDescription) === false) {
            $laminationFormatDescription[] = $laminationSizeValue['formatWidth'] / $CONVERT_MM_TO_SIZE_UNIT;
          }
        }
        ?>
        <tr>
          <td class="" colspan="2">
            <?php if ($value['productParam']['customOptionalWorkToggle'] === false): ?>
              <div class="border-bottom">
                <span><b>Пириметр: </b></span>
                <?php foreach ($value['productParam']['simpleOptionalWork'] as $optionalWorkKey => $optionalWorkValue): ?>
                  <?php if ($optionalWorkValue && $optionalWorkKey !== 'lamination'): ?>
                    <span><?= $optionalWorkValue . ', ' ?></span>
                  <?php elseif ($optionalWorkValue): ?>
                    <span><?= $optionalWorkValue . ' (' . implode(', ', $laminationFormatDescription) . '), ' ?></span>
                  <?php endif; ?>
                <?php endforeach; ?>
              </div>
            <?php else: ?>
              <div class="border-bottom">
                <span><b>Верх: </b></span>
                <?php foreach ($value['productParam']['customOptionalWork']['top'] as $optionalWorkKey => $optionalWorkValue): ?>
                  <?php if ($optionalWorkValue && $optionalWorkKey !== 'lamination'): ?>
                    <span><?= $optionalWorkValue . ', ' ?></span>
                  <?php elseif ($optionalWorkValue): ?>
                    <span><?= $optionalWorkValue . ' (' . implode(', ', $laminationFormatDescription) . '), ' ?></span>
                  <?php endif; ?>
                <?php endforeach; ?>
              </div>
              <div class="border-bottom">
                <span><b>Низ: </b></span>
                <?php foreach ($value['productParam']['customOptionalWork']['bottom'] as $optionalWorkKey => $optionalWorkValue): ?>
                  <?php if ($optionalWorkValue && $optionalWorkKey !== 'lamination'): ?>
                    <span><?= $optionalWorkValue . ', ' ?></span>
                  <?php elseif ($optionalWorkValue): ?>
                    <span><?= $optionalWorkValue . ' (' . implode(', ', $laminationFormatDescription) . '), ' ?></span>
                  <?php endif; ?>
                <?php endforeach; ?>
              </div>
              <div class="border-bottom">
                <span><b>Лево: </b></span>
                <?php foreach ($value['productParam']['customOptionalWork']['left'] as $optionalWorkKey => $optionalWorkValue): ?>
                  <?php if ($optionalWorkValue && $optionalWorkKey !== 'lamination'): ?>
                    <span><?= $optionalWorkValue . ', ' ?></span>
                  <?php elseif ($optionalWorkValue): ?>
                    <span><?= $optionalWorkValue . ' (' . implode(', ', $laminationFormatDescription) . '), ' ?></span>
                  <?php endif; ?>
                <?php endforeach; ?>
              </div>
              <div class="border-bottom">
                <span><b>Право: </b></span>
                <?php foreach ($value['productParam']['customOptionalWork']['right'] as $optionalWorkKey => $optionalWorkValue): ?>
                  <?php if ($optionalWorkValue && $optionalWorkKey !== 'lamination'): ?>
                    <span><?= $optionalWorkValue . ', ' ?></span>
                  <?php elseif ($optionalWorkValue): ?>
                    <span><?= $optionalWorkValue . ' (' . implode(', ', $laminationFormatDescription) . '), ' ?></span>
                  <?php endif; ?>
                <?php endforeach; ?>
              </div>
            <?php endif; ?>
          </td>
        </tr>

        <tr class="">
          <td class="padding-top">
            <h4>Расчет</h4>
            <?php foreach ($value['calculations'] as $calculationsKey => $calculationsValue): ?>
              <?php if ($calculationsValue['totalPrice'] > 0 || (isset($calculationsValue['quantity']) && $calculationsValue['quantity'] > 0)): ?>
                <?php if ($calculationsKey === 'total'): ?>
                  <div class="border-bottom">
            <span class="">
              <b>
              <?=
              $calculationsValue['name'] . ': ' .
              $calculationsValue['totalPrice'] . ' ' . $data['config']['currency'] . ' / ' .
              $calculationsValue['hours'] . ' ч. / ' .
              $calculationsValue['kg'] . ' кг.'
              ?>
              </b>
            </span>
                  </div>
                <?php elseif ($calculationsKey === 'designPrice'): ?>
                  <div class="border-bottom">
            <span class="">
            <?=
            $calculationsValue['name'] . ': ' .
            $calculationsValue['totalPrice'] . ' ' . $data['config']['currency']
            ?>
            </span>
                  </div>
                <?php else: ?>
                  <div class="border-bottom">
            <span class="">
              <?=
              $calculationsValue['name'] . ': ' .
              $calculationsValue['quantity'] . ' ' .
              $calculationsValue['unit'] . ' * ' .
              $calculationsValue['price'] . ' ' . $data['config']['currency'] . ' = ' .
              $calculationsValue['totalPrice'] . ' ' . $data['config']['currency']
              ?>
              <?php if ($calculationsValue['hours'] > 0): ?>
                <?= ' / ' . $calculationsValue['hours'] . ' ч.' ?>
              <?php endif; ?>
            </span>
                  </div>
                <?php endif; ?>
              <?php endif; ?>
            <?php endforeach; ?>
          </td>

          <td class="padding-top">
            <ul style="margin-top:0">
              <h4>Производство</h4>
              <li>принтер: <?= $value['productParam']['printerModel'] ?></li>
              <li>печать: <?= $value['productParam']['printParam'] ?></li>
            </ul>
            <ul>
              <h4>Макет</h4>
              <?php if ($value['curentSizeParam']['noTechFieldX']): ?>
                <li class="attention-text">без тех полей по бокам</li>
              <?php endif; ?>

              <?php if ($value['productParam']['noTechFieldPerimeter']): ?>
                <li class="attention-text">без тех полей по периметру (фактические размеры)</li>
              <?php endif; ?>

              <?php if (!$value['productParam']['noTechFieldPerimeter']): ?>
                <li><?= 'стандарт тех поля: ' . $value['productParam']['materialTypeTechFieldSize'] . ' мм' ?></li>
              <?php endif; ?>

              <?php if ($value['curentSizeParam']['couplingMargin']): ?>
                <li><?= 'нахлест при стыковке: ' . $value['curentSizeParam']['couplingMargin'] . ' мм' ?></li>
              <?php endif; ?>

              <?php if ($value['curentSizeParam']['rowNumber']): ?>
                <li><?= 'рядов при компановке: ' . $value['curentSizeParam']['rowNumber'] ?></li>
              <?php endif; ?>

              <?php if ($value['curentSizeParam']['columnNumbers']): ?>
                <li><?= 'колонок при компановке: ' . $value['curentSizeParam']['columnNumbers'] ?></li>
              <?php endif; ?>
            </ul>
            <ul>
              <h4>Промо коды</h4>
              <?php foreach ($value['productParam']['promoCodes'] as $promoCodesKey => $promoCodesValue): ?>
                <li><?= $promoCodesValue ?></li>
              <?php endforeach; ?>
            </ul>
          </td>
        </tr>
        <?php if (isset($value['productParam']['notes']) && mb_strlen($value['productParam']['notes']) > 2): ?>
        <tr class="">
          <td colspan="2"><h2>Заметки: <?= $value['productParam']['notes'] ?></h2></td>
        </tr>
        <?php endif; ?>
      </table>
    </div>
  <?php endforeach; ?>
</div>
</body>
</html>
