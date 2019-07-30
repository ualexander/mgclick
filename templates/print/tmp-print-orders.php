<form class="mb-3" action="<?= $data['config']['host'] . '/print.php' ?>" method="get">
  <input type="hidden" name="orders" value="">
  <input type="hidden" name="status" value="<?= $data['fieldsData']['status'] ?>">
  <div class="form-row">
    <div class="col">
      <input type="text" maxlength="30" name="search" value="<?= $data['fieldsData']['search'] ?>" id="search" class="form-control form-control-sm"
             placeholder="поиск по номеру заказа или клиенту">
    </div>
    <div class="col-3">
      <input type="text" name="date-range-filter" id="daterangepicker" value="<?= $data['fieldsData']['dateRangeFilter'] ?>" placeholder="за период"
             class="form-control form-control-sm">
    </div>
    <div class="col-2">
      <input type="submit" class="btn btn-sm btn-primary btn-block" value="Найти">
    </div>
  </div>
</form>
<?php if (count($data['orderList']) > 0): ?>
  <div class="table-responsive rounded mb-5 min-height">
    <table class="table table-sm table-hover table-borderedless m-0 text-nowrap border">
      <thead class="">
      <tr>
        <th scope="col" class="text-center">Заказ</th>
        <th scope="col" class="text-center"></th>
        <th scope="col" class="text-left">Клиент</th>
        <th scope="col" class="text-right">Сумма</th>
        <th scope="col" class="text-right">Площадь</th>
        <th scope="col" class="text-right">Время изг.</th>
        <th scope="col" class="text-right">Готовность</th>
        <th scope="col" class="text-right">Доп инф</th>
        <th scope="col" class="text-right">Промо коды</th>
        <th scope="col" class="text-right">Сохранил</th>
        <th scope="col" class="text-right">Подтвердил</th>
        <th scope="col" class="text-right">Дата сохранения</th>
        <th scope="col" class="text-right">Дата подтверждения</th>
        <th scope="col" class="text-right">Дата выполнения</th>
        <th scope="col" class="text-right">Дата отгрузки</th>
        <th scope="col" class="text-right">Дата отмены</th>
      </tr>
      </thead>
      <tbody>
      <?php foreach ($data['orderList'] as $key => $value): ?>
        <?php if ($value['order_note']): ?>
          <tr class="table-warning">
        <?php else: ?>
          <tr class="">
        <?php endif; ?>
        <td class="text-right">
          <ul class="nav text-right d-inline-block">
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle m-0 p-0" data-toggle="dropdown" href="#" role="button" aria-haspopup="true"
                 aria-expanded="false"><?= $value['order_name'] ?></a>
              <div class="dropdown-menu">
                <?php if ($value['order_status'] === 'сохранен'): ?>
                  <a class="dropdown-item" href="<?= $data['config']['host'] . '/notify.php?order=' .
                  $value['id'] . '&notify=print-order-info' . $data['getParamStr'] ?>">отправить расчет</a>
                  <a class="dropdown-item" href="<?= $data['config']['host'] . '/print.php?&order=' .
                  $value['id'] . '&change-order-status=в работе' . $data['getParamStr'] ?>">в работу</a>
                  <a class="dropdown-item" target="_blank"
                     href="<?= $data['config']['host'] . '/print-calc.php?action=render-print-blank&file-path=' .
                     $value['calc_result_file_path'] ?>">бланки</a>
                  <?php if ($value['need_delivery'] != 1): ?>
                    <a class="dropdown-item" href="<?= $data['config']['host'] . '/print.php?&order=' .
                    $value['id'] . '&need-delivery' . $data['getParamStr'] ?>">стикер доставка</a>
                  <?php endif; ?>
                  <a class="dropdown-item text-danger" href="<?= $data['config']['host'] . '/print.php?&order=' .
                  $value['id'] . '&change-order-status=отменен' . $data['getParamStr'] ?>">отменить</a>
                <?php elseif ($value['order_status'] === 'в работе'): ?>
                  <a class="dropdown-item" target="_blank"
                     href="<?= $data['config']['host'] . '/print-calc.php?action=render-print-blank&file-path=' .
                     $value['calc_result_file_path'] ?>">бланки</a>
                  <a class="dropdown-item" href="<?= $data['config']['host'] . '/print.php?orderitems&orderitems-order=' .
                  $value['id'] ?>">подробно</a>
                  <a class="dropdown-item" href="<?= $data['config']['host'] . '/notify.php?order=' .
                  $value['id'] . '&notify=print-order-info' . $data['getParamStr'] ?>">отправить расчет</a>
                  <?php if ($value['need_delivery'] != 1): ?>
                    <a class="dropdown-item" href="<?= $data['config']['host'] . '/print.php?&order=' .
                    $value['id'] . '&need-delivery' . $data['getParamStr'] ?>">стикер доставка</a>
                  <?php endif; ?>
                  <a class="dropdown-item text-danger" href="<?= $data['config']['host'] . '/print.php?&order=' .
                  $value['id'] . '&change-order-status=отменен' . $data['getParamStr'] ?>">отменить</a>
                <?php elseif ($value['order_status'] === 'выполнен'): ?>
                  <a class="dropdown-item" href="<?= $data['config']['host'] . '/print.php?&order=' .
                  $value['id'] . '&change-order-status=отгружен' . $data['getParamStr'] ?>">отгрузить</a>
                  <a class="dropdown-item" target="_blank"
                     href="<?= $data['config']['host'] . '/print-calc.php?action=render-print-blank&file-path=' .
                     $value['calc_result_file_path'] ?>">бланки</a>
                  <a class="dropdown-item" href="<?= $data['config']['host'] . '/print.php?orderitems&orderitems-order=' .
                  $value['id'] ?>">подробно</a>
                  <?php if ($value['need_delivery'] != 1): ?>
                    <a class="dropdown-item" href="<?= $data['config']['host'] . '/print.php?&order=' .
                    $value['id'] . '&need-delivery' . $data['getParamStr'] ?>">стикер доставка</a>
                  <?php endif; ?>
                  <a class="dropdown-item" href="<?= $data['config']['host'] . '/notify.php?order=' .
                  $value['id'] . '&notify=print-order-info' . $data['getParamStr'] ?>">отправить расчет</a>
                <?php elseif ($value['order_status'] === 'отгружен' || $value['order_status'] === 'отменен'): ?>
                  <a class="dropdown-item" target="_blank"
                     href="<?= $data['config']['host'] . '/print-calc.php?action=render-print-blank&file-path=' .
                     $value['calc_result_file_path'] ?>">бланки</a>
                  <a class="dropdown-item" href="<?= $data['config']['host'] . '/print.php?orderitems&orderitems-order=' .
                  $value['id'] ?>">подробно</a>
                  <a class="dropdown-item" href="<?= $data['config']['host'] . '/notify.php?order=' .
                  $value['id'] . '&notify=print-order-info' . $data['getParamStr'] ?>">отправить расчет</a>
                <?php endif; ?>
              </div>
            </li>
          </ul>
        </td>
        <td class="text-left">
          <?php if ($value['order_status'] === 'сохранен'): ?>
            <span class="badge badge-warning"><?= $value['order_status'] ?></span>
          <?php elseif ($value['order_status'] === 'в работе'): ?>
            <span class="badge badge-primary"><?= $value['order_status'] ?></span>
          <?php elseif ($value['order_status'] === 'выполнен'): ?>
            <span class="badge badge-success"><?= $value['order_status'] ?></span>
          <?php elseif ($value['order_status'] === 'отгружен'): ?>
            <span class="badge badge-light"><?= $value['order_status'] ?></span>
          <?php else: ?>
            <span class="badge badge-danger"><?= $value['order_status'] ?></span>
          <?php endif; ?>
          <?php if ($value['date_notify']): ?>
            <span class="badge badge-info" data-toggle="tooltip" data-placement="top" title="расчет отправлен <?= $value['date_notify'] ?>">@</span>
          <?php endif; ?>
          <?php if ($value['order_status'] !== 'отгружен' && $value['order_status'] !== 'отменен' && $value['need_delivery'] == 1): ?>
            <span class="badge badge-danger" data-toggle="tooltip" data-placement="top" title="нужна доставка">дост</span>
          <?php endif; ?>
        </td>
        <td class="text-left">
          <a href="<?= $data['config']['host'] . '/clients.php?action=show-card&id=' . $value['client_id'] ?>"><?= cutStr($value['name'], 10) ?></a>
        </td>
        <td class="text-right"><?= number_format($value['total_price'], 0, '.', ' ') . ' ' . $data['config']['currency'] ?></td>
        <td class="text-right"><?= $value['square'] ?> м<sup>2</sup></td>
        <td class="text-right"><?= $value['hours'] ?> ч.</td>
        <td class="text-right"><?= $value['order_item_ready'] . ' / ' . $value['order_item_total'] ?></td>
        <td class="text-right"><?= $value['order_note'] ?></td>
        <td class="text-right"><?= $value['promo_codes'] ?></td>
        <td class="text-right"><?= $value['stuff_create'] ?></td>
        <td class="text-right"><?= $value['stuff_conf'] ?></td>
        <td class="text-right"><?= $value['date_create'] ?></td>
        <td class="text-right"><?= $value['date_injob'] ?></td>
        <td class="text-right"><?= $value['date_ready'] ?></td>
        <td class="text-right"><?= $value['date_issued'] ?></td>
        <td class="text-right"><?= $value['date_deleted'] ?></td>
        </tr>
      <?php endforeach ?>
      </tbody>
    </table>
  </div>
<?php else: ?>
  <p class="h1 text-secondary">ничего :(</p>
<?php endif; ?>