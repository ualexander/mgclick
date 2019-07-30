<form class="mb-3" action="<?= $data['config']['host'] . '/cash.php' ?>" method="get">
  <input type="hidden" name="action" value="show-list">
  <div class="form-row">
    <div class="col">
      <select name="operation-type" class="custom-select custom-select-sm">
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
      <select name="payment-purpose" class="custom-select custom-select-sm">
        <option value="" disabled selected>назначение</option>
        <?php if ($data['fieldsData']['paymentPurpose'] === 'все'): ?>
          <option selected value="все">все</option>
        <?php else: ?>
          <option>все</option>
        <?php endif; ?>
        <?php foreach ($data['config']['paymentsPurpose'] as $key => $value): ?>
          <?php if (!$value['isPrivate'] || $_SESSION['user']['fullInfo']): ?>
            <?php if ($data['fieldsData']['paymentPurpose'] === $value['title']): ?>
              <option selected value="<?= $value['title'] ?>"><?= $value['title'] ?></option>
            <?php else: ?>
              <option value="<?= $value['title'] ?>"><?= $value['title'] ?></option>
            <?php endif; ?>
          <?php endif; ?>
        <?php endforeach ?>
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
<?php if (count($data['cashList']) > 0): ?>
  <div class="table-responsive rounded mb-5 min-height">
    <table class="table table-sm table-hover table-borderedless m-0 text-nowrap border">
      <thead class="">
      <tr>
        <th scope="col" class="text-left">#</th>
        <th scope="col" class="text-right">Приход</th>
        <th scope="col" class="text-right">Расход</th>
        <th scope="col" class="text-right">Назначение</th>
        <th scope="col" class="text-right">Оплата</th>
        <th scope="col" class="text-right">Дата</th>
        <th scope="col" class="text-right">Клиент</th>
      </tr>
      </thead>
      <tbody>
      <?php foreach ($data['cashList'] as $key1 => $value1): ?>
        <?php if ($_SESSION['user']['fullInfo'] || !($value1['payment_purpose'] == 'приватные')): ?>
          <tr class="">
            <td>
              <?php if ($value1['is_deleted'] === 1 || $value1['is_auto_create'] === 1): ?>
                <?= $value1['id'] ?>
              <?php else: ?>
                <ul class="nav text-right d-inline-block">
                  <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle m-0 p-0" data-toggle="dropdown" href="#" role="button" aria-haspopup="true"
                       aria-expanded="false"><?= $value1['id'] ?></a>
                    <div class="dropdown-menu">
                      <a class="dropdown-item text-danger"
                         href="<?= $data['config']['host'] . '/cash.php?action=cancel-cash-item&id=' . $value1['id'] ?>">отменить запись</a>
                    </div>
                  </li>
                </ul>
              <?php endif; ?>
              <?php if ($value1['is_deleted'] === 1): ?>
                <span class="badge badge-danger" data-toggle="tooltip" data-placement="top" title="запись отменена">отм</span>
              <?php endif; ?>
            </td>
            <td class="text-success text-right"><?= number_format($value1['deb'], 0, '.', ' ') ?></td>
            <td class="text-danger text-right"><?= number_format($value1['cred'], 0, '.', ' ') ?></td>
            <td class="text-right"><?= $value1['payment_purpose'] ?></td>
            <td class="text-right"><span data-toggle="tooltip" data-placement="top" title="<?= $value1['payment_note'] ?>"
                                         class=""><?= $value1['payment_type'] . '...' ?></span></td>
            <td class="text-right"><span data-toggle="tooltip" data-placement="top" title="<?= $value1['stuff'] ?>"
                                         class=""><?= $value1['payment_date'] . '...' ?></span>
            </td>
            <td class="text-right">
              <?php if ($value1['name']): ?>
                <a href="<?= $data['config']['host'] . '/clients.php?action=payments-list&id=' . $value1['client_id'] ?>" data-toggle="tooltip"
                   data-placement="top"
                   title="<?= $value1['name'] ?>"><?= cutStr($value1['name'], 15) ?></a>
              <?php endif; ?>
            </td>
          </tr>
        <?php endif; ?>
      <?php endforeach ?>
      <tr class="">
        <th scope="col" class="">Итого:</th>
        <th scope="col" class="text-success text-right"><?= number_format($data['sum']['deb'], 0, '.', ' ') ?? '' ?></th>
        <th scope="col" class="text-danger text-right"><?= number_format($data['sum']['cred'], 0, '.', ' ') ?? '' ?></th>
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