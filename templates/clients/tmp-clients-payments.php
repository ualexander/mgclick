<form class="mb-3" action="<?= $data['config']['host'] . '/clients.php' ?>" method="get">
  <input type="hidden" name="action" value="payments-list">
  <input type="hidden" name="id" value="<?= $data['clientData']['id'] ?>">
  <div class="form-row">
    <div class="col">
      <select name="operation-type" class="custom-select custom-select-sm" placeholder="по">
        <option value="" disabled selected>прих/расх</option>
        <?php if ($data['fieldsData']['operationType'] === 'все'): ?>
          <option selected value="все">все</option>
        <?php else: ?>
          <option>все</option>
        <?php endif; ?>

        <?php if ($data['fieldsData']['operationType'] === 'приход'): ?>
          <option selected value="приход">приход</option>
        <?php else: ?>
          <option value="приход">приход</option>
        <?php endif; ?>

        <?php if ($data['fieldsData']['operationType'] === 'расход'): ?>
          <option selected value="расход">расход</option>
        <?php else: ?>
          <option value="расход">расход</option>
        <?php endif; ?>
      </select>
    </div>
    <div class="col">
      <select name="payment-type" class="custom-select custom-select-sm">
        <option value="" disabled selected>оплата</option>
        <?php if ($data['fieldsData']['paymentType'] === 'все'): ?>
          <option selected value="все">все</option>
        <?php else: ?>
          <option>все</option>
        <?php endif; ?>
        <?php if ($data['fieldsData']['paymentType'] === 'авт'): ?>
          <option selected value="авт">авт</option>
        <?php else: ?>
          <option>авт</option>
        <?php endif; ?>
        <?php foreach ($data['config']['paymentsType'] as $key => $value): ?>
          <?php if ($data['fieldsData']['paymentType'] === $value): ?>
            <option selected value="<?= $value ?>"><?= $value ?></option>
          <?php else: ?>
            <option value="<?= $value ?>"><?= $value ?></option>
          <?php endif; ?>
        <?php endforeach ?>
      </select>
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
<?php if (count($data['paymentList']) > 0): ?>
  <div class="card table-responsive mb-5">
    <div class="card-header bg-light text-primary h6">
      <a href="<?= $data['config']['host'] . '/clients.php?action=show-card&id=' . $data['clientData']['id'] ?>"
         class="btn btn-link btn-sm m-0 py-0 pl-0 pr-3"
         role="button"
         aria-pressed="true"><?= $data['clientData']['name'] ?></a>
    </div>
    <ul class="list-group list-group-flush">
      <li class="list-group-item">
        <?php if ($data['clientData']['balance'] < 0): ?>
          <p class="h6 text-danger">Баланс: <?= number_format($data['clientData']['balance'], 0, '.', ' ') . ' ' . $data['config']['currency'] ?></p>
        <?php elseif ($data['clientData']['balance'] > 0): ?>
          <p class="h6 text-success">Баланс: <?= number_format($data['clientData']['balance'], 0, '.', ' ') . ' ' . $data['config']['currency'] ?></p>
        <?php else: ?>
          <p class="h6">Баланс: <?= number_format($data['clientData']['balance'], 0, '.', ' ') . ' ' . $data['config']['currency'] ?></p>
        <?php endif; ?>
        <a href="<?= $data['config']['host'] . '/clients.php?action=add-payment&id=' . $data['clientData']['id'] ?>"
           class="btn btn-link btn-sm m-0 p-0"
           role="button" aria-pressed="true">платежная операция</a>
      </li>
    </ul>
    <table class="table table-sm table-hover m-0">
      <thead class="table-borderless">
      <tr class="">
        <th scope="col" class="text-left">Касса#</th>
        <th scope="col" class="text-right">Приход</th>
        <th scope="col" class="text-right">Расход</th>
        <th scope="col" class="text-right">Назначение</th>
        <th scope="col" class="text-right">Оплата</th>
        <th scope="col" class="text-right">Дата</th>
        <th scope="col" class="text-right">Заказ</th>
      </tr>
      </thead>
      <tbody>
      <?php foreach ($data['paymentList'] as $key1 => $value1): ?>
        <tr class="">
          <td class="text-left">
            <?php if ($value1['is_deleted'] === 1 || $value1['is_auto_create'] === 1): ?>
              <?= $value1['cash_id'] ?>
            <?php else: ?>
              <ul class="nav text-right d-inline-block">
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle m-0 p-0" data-toggle="dropdown" href="#" role="button" aria-haspopup="true"
                     aria-expanded="false"><?= $value1['cash_id'] ?? 'нет'?></a>
                  <div class="dropdown-menu">
                    <a class="dropdown-item text-danger"
                       href="<?= $data['config']['host'] . '/clients.php?action=cancel-payment-item' . '&payments-list-client-id=' . $value1['client_id'] . '&id=' . $value1['id'] ?>">отменить
                      запись</a>
                  </div>
                </li>
              </ul>
            <?php endif; ?>
            <?php if ($value1['is_deleted'] === 1): ?>
              <span class="badge badge-danger" data-toggle="tooltip" data-placement="top" title="запись отменена">отм</span>
            <?php endif; ?>
          </td>
          <td class="text-right text-success"><?= number_format($value1['deb'], 0, '.', ' ') ?></td>
          <td class="text-right text-danger"><?= number_format($value1['cred'], 0, '.', ' ') ?></td>
          <td class="text-right"><?= $value1['payment_purpose'] ?></td>
          <td class="text-right"><span data-toggle="tooltip" data-placement="top" title="<?= $value1['payment_note'] ?>"
                                       class=""><?= $value1['payment_type'] . '...' ?></span></td>
          <td class="text-right"><span data-toggle="tooltip" data-placement="top" title="<?= $value1['stuff'] ?>"
                                       class=""><?= $value1['payment_date'] . '...' ?></span>
          </td>
          <td class="text-right"><?= $value1['order_name'] ?></td>
        </tr>
      <?php endforeach ?>
      <tr class="">
        <th scope="col" class="">Итого:</th>
        <th scope="col" class="text-success text-right"><?= number_format($data['sum']['deb'], 0, '.', ' ') ?></th>
        <th scope="col" class="text-danger text-right"><?= number_format($data['sum']['cred'], 0, '.', ' ') ?></th>
        <th scope="col" class=""></th>
        <th scope="col" class=""></th>
        <th scope="col" class=""></th>
        <th scope="col" class=""></th>
      </tr>
      </tbody>
    </table>
  </div>
<?php else: ?>
  <p class="h1 text-secondary">ничего :(</p>
<?php endif; ?>