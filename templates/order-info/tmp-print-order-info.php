<div class="container-fluid" style="width: 100%; height: 100%">
  <div class="row mt-3 mb-3">
    <div class="card col-11 col-sm-8 col-md-5 m-auto p-0">
      <h5 class="text-primary card-header bg-light">
        <?= 'Заказ: ' . $data['orderData']['order_name'] ?>
      </h5>

      <ul class="list-group list-group-flush">
        <li class="list-group-item">
          <h6 class="mb-0">
            стоимость: <?= number_format($data['orderData']['total_price'], 0, '.', ' ') . ' ' .
            $data['config']['currency']; ?>
          </h6>
          <h6 class="mb-0">
            вес ≈ <?= $data['calcResultData']['commonData']['calculations']['total']['kg'] . ' кг.'; ?>
          </h6>
        </li>
        <?php foreach ($data['calcResultData']['items'] as $key => $value): ?>
          <li class="list-group-item">
    <span>
      <?= $value['productParam']['index'] + 1 . '. ' .
      $value['productParam']['materialTypeRu'] . ', ' .
      $value['productParam']['printTypeRu']; ?>
    </span>
            <?php if ($value['productParam']['status'] === 'сохранен'): ?>
              <span class="badge badge-warning"><?= $value['productParam']['status'] ?></span>
            <?php elseif ($value['productParam']['status'] === 'в работе'): ?>
              <span class="badge badge-primary"><?= $value['productParam']['status'] ?></span>
            <?php elseif ($value['productParam']['status'] === 'выполнен'): ?>
              <span class="badge badge-success"><?= $value['productParam']['status'] ?></span>
            <?php elseif ($value['productParam']['status'] === 'отгружен'): ?>
              <span class="badge badge-light"><?= $value['productParam']['status'] ?></span>
            <?php else: ?>
              <span class="badge badge-danger"><?= $value['productParam']['status'] ?></span>
            <?php endif; ?>
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
                <?php if ($calcValue['totalPrice'] > 0 || (isset($calcValue['quantity']) && $calcValue['quantity'] > 0)): ?>
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
        <?php endforeach; ?>
      </ul>
    </div>
  </div>
</div>
