<div class="card mb-5">
  <div class="card-header bg-light text-primary h6">
    Текстовый запрос
    <?php if ($data['requestCard']['request_status'] === 'новый'): ?>
      <span class="badge badge-warning"><?= $data['requestCard']['request_status'] ?></span>
    <?php else: ?>
      <span class="badge badge-light"><?= $data['requestCard']['request_status'] ?></span>
    <?php endif; ?>
  </div>
  <ul class="list-group list-group-flush">
  <li class="list-group-item">
    <p>Источник: <?= $data['requestCard']['request_origin'] ?></p>
    <p>Имя: <?= $data['requestCard']['request_name'] ?></p>
    <p>Контакт: <?= $data['requestCard']['request_contact'] ?></p>
    <p>Тип запроса: <?= $data['requestCard']['request_type'] ?></p>
    <p>Запрос: <?= $data['requestCard']['request_body'] ?></p>
    <p>Дата создания: <?= $data['requestCard']['date_create'] ?></p>
    <p>Дата закрытия: <?= $data['requestCard']['date_closed'] ?></p>
    <p>Закрыл: <?= $data['requestCard']['stuff_request_closed'] ?></p>
  </li>
  <?php if ($data['requestCard']['request_status'] === 'новый'): ?>
    <li class="list-group-item">
      <a href="<?= $data['config']['host'] . '/requests.php?action=change-status&new-status=закрыт&list=text&id=' . $data['requestCard']['id'] . $data['getParamStr'] ?>"
         class="btn btn-link btn-sm pl-0 pr-3"
         role="button" aria-pressed="true">пометить как
        закрытый</a>
    </li>
  <?php endif; ?>
  </ul>
</div>


