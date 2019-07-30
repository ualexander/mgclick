<form class="mb-3" action="<?= $data['config']['host'] . '/materials.php' ?>" method="get">
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
      <select name="material-purpose" class="custom-select custom-select-sm">
        <option value="" disabled selected>назначение</option>
        <?php if ($data['fieldsData']['materialPurpose'] === 'все'): ?>
          <option selected value="все">все</option>
        <?php else: ?>
          <option>все</option>
        <?php endif; ?>
        <?php foreach ($data['config']['materialsPurpose'] as $key => $value): ?>
          <?php if ($data['fieldsData']['materialPurpose'] === $value): ?>
            <option selected value="<?= $value ?>"><?= $value ?></option>
          <?php else: ?>
            <option value="<?= $value ?>"><?= $value ?></option>
          <?php endif; ?>
        <?php endforeach ?>
      </select>
    </div>
    <div class="col">
      <select name="material-name" class="custom-select custom-select-sm">
        <option value="" disabled selected>материал</option>
        <?php if ($data['fieldsData']['materialName'] === 'все'): ?>
          <option selected value="все">все</option>
        <?php else: ?>
          <option>все</option>
        <?php endif; ?>
        <?php foreach ($_SESSION['materials']['avalaibleMaterials'] as $key => $value): ?>
          <?php if ($data['fieldsData']['materialName'] === $value): ?>
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
<?php if (count($data['materialsList']) > 0): ?>
  <div class="table-responsive rounded mb-5 min-height">
    <table class="table table-sm table-hover table-borderedless m-0 text-nowrap border">
      <thead class="">
      <tr>
        <th scope="col" class="text-left">#</th>
        <th scope="col" class="text-right">Приход</th>
        <th scope="col" class="text-right">Расход</th>
        <th scope="col" class="text-right">Назначение</th>
        <th scope="col" class="text-right">Материал</th>
        <th scope="col" class="text-right">Дата</th>
        <th scope="col" class="text-right">Заказ</th>
      </tr>
      </thead>
      <tbody>
      <?php foreach ($data['materialsList'] as $key1 => $value1): ?>
        <tr class="">
          <td class="text-left">
            <?php if ($value1['is_deleted'] === 1 || $value1['is_auto_create'] === 1): ?>
              <?= $value1['id'] ?>
            <?php else: ?>
              <ul class="nav text-right d-inline-block">
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle m-0 p-0" data-toggle="dropdown" href="#" role="button" aria-haspopup="true"
                     aria-expanded="false"><?= $value1['id'] ?></a>
                  <div class="dropdown-menu">
                    <a class="dropdown-item text-danger" href="<?= $data['config']['host'] . '/materials.php?action=cancel-material-item&id=' . $value1['id'] ?>">отменить
                      запись</a>
                  </div>
                </li>
              </ul>
            <?php endif; ?>
            <?php if ($value1['is_deleted'] === 1): ?>
              <span class="badge badge-danger" data-toggle="tooltip" data-placement="top" title="запись отменена">отм</span>
            <?php endif; ?>
          </td>
          <td class="text-right text-success"><?= $value1['deb'] ?></td>
          <td class="text-right text-danger"><?= $value1['cred'] ?></td>
          <td class="text-right"><span data-toggle="tooltip" data-placement="top" title="<?= $value1['material_note'] ?>"
                                       class=""><?= $value1['material_purpose'] . '...' ?></span></td>
          <td class="text-right"><span data-toggle="tooltip" data-placement="top" title="<?= $value1['material_name'] ?>"
                                       class=""><?= cutStr($value1['material_name'], 25) ?></span></td>
          <td class="text-right"><span data-toggle="tooltip" data-placement="top" title="<?= $value1['stuff'] ?>"
                                       class=""><?= $value1['action_date'] . '...' ?></span>
          </td>
          <td class="text-right"><?= $value1['order_name'] ?></td>
        </tr>
      <?php endforeach ?>
      <tr class="">
        <th scope="col" class="">Итого:</th>
        <th scope="col" class="text-success text-right"><?= $data['sum']['deb'] ?? '' ?></th>
        <th scope="col" class="text-danger text-right"><?= $data['sum']['cred'] ?? '' ?></th>
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