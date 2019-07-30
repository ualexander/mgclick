<?php if (isset($data['massage']) && $data['massage']): ?>
  <p>
    <?= $data['massage'] ?>
  </p>
<?php endif; ?>
<p>
  <b>
  <?= 'Заказ: ' . $data['orderData']['order_name'] . ' / стоимость: ' . number_format($data['orderData']['total_price'], 0, '.', ' ') . ' ' .
  $data['config']['currency'] . ' / вес ≈ ' . $data['calcResultData']['commonData']['calculations']['total']['kg'] . ' кг.'; ?>
  </b>
</p>
<?php foreach ($data['calcResultData']['items'] as $key => $value): ?>
  <div>
    <span>
      <?= $value['productParam']['index'] + 1 . '. ' .
      $value['productParam']['materialTypeRu'] . ', ' .
      $value['productParam']['printTypeRu']; ?>
    </span>
    <br>
    <?php foreach ($value['curentSizeParam']['printSize'] as $printSizeKey => $printSizeValue): ?>
      <span>- размер: <?= $printSizeValue['width'] / 1000 . ' * ' .
        $printSizeValue['height'] / 1000 . ', ' .
        $printSizeValue['quantity'] . ' шт, ' .
        number_format($printSizeValue['price'], 0, '.', ' ') . ' ' . $data['config']['currency']; ?></span>
      <?php if ($value['curentSizeParam']['algorithm'] === 'coupling'): ?>
        <b style="color: red">
          (сегментов
          - <?= ($value['curentSizeParam']['canvasSize'][0]['quantity'] + ($value['curentSizeParam']['canvasSize'][1]['quantity'] ?? 0)) / ($printSizeValue['quantity'] ?? 1)?>)</b>
      <?php endif; ?>
      <br>
    <?php endforeach; ?>
    <ul>
      <?php foreach ($value['calculations'] as $calcKey => $calcValue): ?>
        <?php if ($calcValue['totalPrice'] > 0): ?>
          <?php if ($calcValue['name'] === 'перерасход'): ?>
          <?php elseif ($calcValue['name'] === 'печать'): ?>
            <li><?= $calcValue['name'] . ': ' .
              number_format($value['calculations']['print']['totalPrice'] + $value['calculations']['overspending']['totalPrice'], 0, '.', ' ') . ' ' .
              $data['config']['currency']; ?>
            </li>
          <?php elseif ($calcValue['name'] === 'макет'): ?>
            <li><?= $calcValue['name'] . ': ' . number_format($calcValue['totalPrice'], 0, '.', ' ') . ' ' . $data['config']['currency']; ?>
            </li>
          <?php elseif ($calcValue['name'] === 'итого'): ?>
            <li>
              <b><?= $calcValue['name'] . ': ' . number_format($calcValue['totalPrice'], 0, '.', ' ') . ' ' . $data['config']['currency']; ?></b>
            </li>
          <?php else: ?>
            <li><?= $calcValue['name'] . ': ' . $calcValue['quantity'] . ' ' . $calcValue['unit'] . ' * ' .
              $calcValue['price'] . ' ' . $data['config']['currency'] . ' = ' .
              number_format($calcValue['totalPrice'], 0, '.', ' ') . ' ' . $data['config']['currency']; ?>
            </li>
          <?php endif; ?>
        <?php endif; ?>
      <?php endforeach; ?>
    </ul>
    </li>
  </div>
  <br>
<?php endforeach; ?>
<a href="<?= $data['config']['host'] . '/order-info.php?print-order-info&order=' .
$data['orderData']['order_name_privat'] ?>">статус заказа</a>
<p>
  <?= $_SESSION['user']['name'] ?>
  <br>
  <?= $_SESSION['user']['tel'] ?>
</p>