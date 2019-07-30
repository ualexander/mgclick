<?php if ($data['orderItemStatus'] === 'сохранен'): ?>
<div class="container-fluid d-flex flex-column justify-content-between justify-content-sm-start bg-warning" style="width: 100%; height: 100%">
  <?php elseif ($data['orderItemStatus'] === 'в работе'): ?>
  <div class="container-fluid d-flex flex-column justify-content-between justify-content-sm-start bg-primary" style="width: 100%; height: 100%">
    <?php elseif ($data['orderItemStatus'] === 'выполнен'): ?>
    <div class="container-fluid d-flex flex-column justify-content-between justify-content-sm-start bg-success" style="width: 100%; height: 100%">
      <?php elseif ($data['orderItemStatus'] === 'отгружен'): ?>
      <div class="container-fluid d-flex flex-column justify-content-between justify-content-sm-start bg-light" style="width: 100%; height: 100%">
        <?php elseif ($data['orderItemStatus'] === 'отменен'): ?>
        <div class="container-fluid d-flex flex-column justify-content-between justify-content-sm-start bg-danger" style="width: 100%; height: 100%">
          <?php else: ?>
          <div class="container-fluid d-flex flex-column justify-content-between justify-content-sm-start" style="width: 100%; height: 100%">
            <?php endif; ?>

            <?php if ($data['alertMassage']): ?>
              <div class="row mt-3 mb-3">
                <div class="alert alert-info fade show col-11 col-sm-8 col-md-5 m-auto" role="alert">
                  <span class="h4"><?= $data['alertMassage'] ?></span>
                </div>
              </div>
            <?php endif; ?>
            <?php if ($data['errorMassage']): ?>
              <div class="row mt-3 mb-3">
                <div class="alert alert-danger fade show col-11 col-sm-8 col-md-5 m-auto" role="alert">
                  <span class="h4"><?= $data['errorMassage'] ?></span>
                </div>
              </div>
            <?php endif; ?>

            <?php if ($data['showInfo']): ?>
            <div class="row mt-3 mb-3">
              <ul class="list-group col-11 col-sm-8 col-md-5 m-auto m-0 p-0">
                <li class="list-group-item py-1 py-md-3">Дата: <?= $data['dateCreate'] ?></li>
                <li class="list-group-item py-1 py-md-3">Заказчик: <?= $data['name'] ?></li>
                <li class="list-group-item py-1 py-md-3">Заказ: <?= $data['orderName'] ?></li>
                <li class="list-group-item py-1 py-md-3">
                  Бланк: <?= ($data['orderItemIndex'] + 1) . ' / ' . $data['orderItemTotal'] ?></li>
                <li class="list-group-item py-1 py-md-3">Материал: <?= $data['materialType'] ?></li>
                <li class="list-group-item py-1 py-md-3">Печать: <?= $data['printType'] ?></li>
                <li class="list-group-item py-1 py-md-3">Площадь: <?= $data['printQuantity'] ?> м<sup>2</sup></li>
                <li class="list-group-item py-1 py-md-3">Сатус: <?= $data['orderItemStatus'] ?></li>
              </ul>
            </div>
            <?php if ($data['showInfo'] && $data['orderItemStatus'] === 'в работе'): ?>
              <div class="row mt-3 mb-3 sm-mb-5">
                <a class="btn btn-success btn-lg col-11 col-sm-8 col-md-5 m-auto" href="<?= $data['config']['host'] .
                '/service-order-info.php?change-print-orderitem-status=ready&order=' .
                $data['orderNamePrivat'] .
                '&orderitem=' . $data['orderItemIndex'] . '&operation-id=' . $data['operationId'] ?>" role="button">ВЫПОЛНЕН</a>
              </div>
            <?php endif; ?>
            <?php endif; ?>
          </div>