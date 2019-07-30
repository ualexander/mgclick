<form class="mb-3" action="<?= $data['config']['host'] . '/clients.php' ?>" method="get">
  <input type="hidden" name="action" value="show-list">
  <div class="form-row">
    <div class="col">
      <input type="text" maxlength="30" name="search" value="<?= $data['fieldsData']['search'] ?>" id="search" class="form-control form-control-sm"
             placeholder="поиск по имени почте или телефону">
    </div>
    <div class="col-3">
      <select name="sort" id="sort" class="custom-select custom-select-sm">
        <option value="" disabled selected>сортировать</option>
        <?php foreach ($data['sortTypes'] as $key => $value): ?>
          <?php if ($value === $data['fieldsData']['sort']): ?>
            <option selected value="<?= $value ?>"><?= $value ?></option>
          <?php else : ?>
            <option value="<?= $value ?>"><?= $value ?></option>
          <?php endif; ?>
        <?php endforeach ?>
      </select>
    </div>
    <div class="col-2">
      <input type="submit" class="btn btn-sm btn-primary btn-block" value="Найти">
    </div>
  </div>
</form>
<?php if (count($data['clientList']) > 0): ?>
  <div class="table-responsive rounded mb-5 min-height">
    <table class="table table-sm table-hover table-borderedless m-0 text-nowrap border">
      <thead class="">
      <tr>
        <th scope="col" class="">Клиент</th>
        <th scope="col" class="text-right">Баланс</th>
      </tr>
      </thead>
      <tbody>
      <?php foreach ($data['clientList'] as $key1 => $value1): ?>
        <?php if ($value1['balance'] < 0): ?>
          <tr class="table-danger">
        <?php elseif ($value1['balance'] > 0): ?>
          <tr class="table-success">
        <?php else : ?>
          <tr class="">
        <?php endif; ?>
        <td>
          <ul class="nav text-right d-inline-block">
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle m-0 p-0" data-toggle="dropdown" href="#" role="button" aria-haspopup="true"
                 aria-expanded="false"><?= $value1['name'] ?></a>
              <div class="dropdown-menu">
                <a class="dropdown-item" href="<?= $data['config']['host'] . '/clients.php?action=show-card&id=' . $value1['id'] ?>">карта клиента</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="<?= $data['config']['host'] . '/clients.php?action=add-payment&id=' . $value1['id'] ?>">платежная
                  операция</a>
                <a class="dropdown-item" href="<?= $data['config']['host'] . '/clients.php?action=payments-list&id=' . $value1['id'] ?>">история
                  платежей</a>
                <a class="dropdown-item" href="<?= $data['config']['host'] . '/clients.php?action=add-service&id=' . $value1['id'] ?>">добавить
                  услугу</a>
                <a class="dropdown-item" href="<?= $data['config']['host'] . '/print.php?orders=&ready-orders-client=' . $value1['id'] ?>">неотгруженные
                  заказы</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="<?= $data['config']['host'] . '/clients.php?action=edit-card&id=' . $value1['id'] ?>">редактировать
                  карту</a>
              </div>
            </li>
          </ul>
        </td>
        <td class="text-right"><?= number_format($value1['balance'], 0, '.', ' ') . ' ' . $data['config']['currency'] ?></td>
        </tr>
      <?php endforeach ?>
      </tbody>
    </table>
  </div>
<?php else: ?>
  <p class="h1 text-secondary">ничего :(</p>
<?php endif; ?>