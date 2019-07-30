<?php if (count($data['requestList']) > 0): ?>
  <div class="table-responsive rounded mb-5 min-height">
    <table class="table table-sm table-hover table-borderedless m-0 text-nowrap border">
      <thead class="">
      <tr>
        <th scope="col" class="text-center">Запрос</th>
        <th scope="col" class="">Статус</th>
        <th scope="col" class="">Дата отктытия</th>
        <th scope="col" class="">Источник</th>
        <th scope="col" class="">Тип заявки</th>
        <th scope="col" class="">Дата закрытия</th>
      </tr>
      </thead>
      <tbody>
      <?php foreach ($data['requestList'] as $key1 => $value1): ?>
        <tr class="">
          <td class="text-center">
            <ul class="nav d-inline-block">
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle m-0 p-0" data-toggle="dropdown" href="#" role="button" aria-haspopup="true"
                   aria-expanded="false"><?= $value1['id'] ?></a>
                <div class="dropdown-menu">
                  <a class="dropdown-item"
                     href="<?= $data['config']['host'] . '/requests.php?action=show-card&list=text&id=' . $value1['id'] . $data['getParamStr'] ?>">смотреть запрос</a>
                  <?php if ($value1['request_status'] === 'новый'): ?>
                    <a class="dropdown-item"
                       href="<?= $data['config']['host'] . '/requests.php?action=change-status&new-status=закрыт&list=text&id=' . $value1['id'] . $data['getParamStr'] ?>">пометить как
                      закрытый</a>
                  <?php endif; ?>
                </div>
              </li>
            </ul>
          </td>
          <?php if ($value1['request_status'] === 'новый'): ?>
            <td>
              <span class="badge badge-warning"><?= $value1['request_status'] ?></span>
            </td>
          <?php elseif ($value1['request_status'] === 'закрыт'): ?>
            <td>
              <span class="badge badge-light"><?= $value1['request_status'] ?></span>
            </td>
          <?php else : ?>
            <td></td>
          <?php endif; ?>
          <td><?= $value1['date_create'] ?></td>
          <td><?= $value1['request_origin'] ?></td>
          <td><?= cutStr($value1['request_type'], 20) ?></td>
          <td><?= $value1['date_closed'] ?></td>
        </tr>
      <?php endforeach ?>
      </tbody>
    </table>
  </div>
<?php else: ?>
  <p class="h1 text-secondary">ничего :(</p>
<?php endif; ?>