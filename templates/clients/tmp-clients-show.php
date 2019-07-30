<div class="card mb-5">
  <div class="card-header bg-light text-primary h6">
    <?= $data['clientData']['name'] ?>
  </div>
  <ul class="list-group list-group-flush">
    <li class="list-group-item">
      <?php if ($data['clientData']['balance'] < 0): ?>
        <p class="h5 text-danger mb-3">Баланс: <?= number_format($data['clientData']['balance'], 0, '.', ' ') . ' ' . $data['config']['currency'] ?></p>
      <?php elseif ($data['clientData']['balance'] > 0): ?>
        <p class="h5 text-success mb-3">Баланс: <?= number_format($data['clientData']['balance'], 0, '.', ' ') . ' ' . $data['config']['currency'] ?></p>
      <?php else: ?>
        <p class="h5 mb-3">Баланс: <?= number_format($data['clientData']['balance'], 0, '.', ' ') . ' ' . $data['config']['currency'] ?></p>
      <?php endif; ?>
      <p class="">Приход: <?= number_format($data['clientData']['deb'], 0, '.', ' ') . ' ' . $data['config']['currency'] ?> /
        Расход: <?= number_format($data['clientData']['cred'], 0, '.', ' ') . ' ' . $data['config']['currency'] ?></p>
      <p>Кол-во заказов: <?= $data['clientData']['orders_count'] ?></p>
      <p>Email: <?= $data['clientData']['email'] ?></p>
      <p>Основной телефон: <?= $data['clientData']['first_tel'] ?></p>
      <p>Дополнительный телефон: <?= $data['clientData']['second_tel'] ?></p>
      <p>Адрес: <?= $data['clientData']['address'] ?></p>
      <p>Заметки: <?= $data['clientData']['note'] ?></p>
      <p>Дата последнего заказа:
        <?php if ($data['clientData']['last_order_date']): ?>
          <?= date($data['config']['dateFormat'], strtotime($data['clientData']['last_order_date'])) ?>
        <?php endif; ?>
      </p>
      <p>Дата регистрации: <?= date($data['config']['dateFormat'], strtotime($data['clientData']['reg_date'])) ?></p>
      <p>Добавил / изменил: <?= $data['clientData']['stuff'] ?></p>
      <p>Источник: <?= $data['clientData']['source'] ?></p>
    </li>
    <li class="list-group-item">
      <a href="<?= $data['config']['host'] . '/clients.php?action=add-payment&id=' . $data['clientData']['id'] ?>" class="btn btn-link btn-sm pl-0 pr-3"
         role="button" aria-pressed="true">платежная операция</a>
      <a href="<?= $data['config']['host'] . '/clients.php?action=payments-list&id=' . $data['clientData']['id'] ?>" class="btn btn-link btn-sm pl-0 pr-3"
         role="button"
         aria-pressed="true">история платежей</a>
      <a href="<?= $data['config']['host'] . '/clients.php?action=add-service&id=' . $data['clientData']['id'] ?>" class="btn btn-link btn-sm pl-0 pr-3"
         role="button" aria-pressed="true">добавить услугу</a>
      <a href="<?= $data['config']['host'] . '/print.php?orders=&ready-orders-client=' . $data['clientData']['id'] ?>"
         class="btn btn-link btn-sm pl-0 pr-3" role="button" aria-pressed="true">неотгруженные заказы</a>
      <a href="<?= $data['config']['host'] . '/clients.php?action=edit-card&id=' . $data['clientData']['id'] ?>" class="btn btn-link btn-sm pl-0 pr-3"
         role="button"
         aria-pressed="true">редактировать карту</a>
    </li>
  </ul>
</div>