<?php if ($data['isForSafe'] === false): ?>
  <form class="mb-3" action="<?= $data['config']['host'] . '/print.php' ?>" method="get">
    <input type="hidden" name="orderitems" value="">
    <div class="form-row mb-2">
      <div class="col">
        <select name="status" class="custom-select custom-select-sm">
          <option value="" disabled selected>статус</option>
          <?php if ($data['fieldsData']['status'] === 'все'): ?>
            <option selected value="все">все</option>
          <?php else: ?>
            <option>все</option>
          <?php endif; ?>
          <?php if ($data['fieldsData']['status'] === 'в работе'): ?>
            <option selected value="в работе">в работе</option>
          <?php else: ?>
            <option value="в работе">в работе</option>
          <?php endif; ?>
          <?php if ($data['fieldsData']['status'] === 'выполнен'): ?>
            <option selected value="выполнен">выполнен</option>
          <?php else: ?>
            <option value="выполнен">выполнен</option>
          <?php endif; ?>
          <?php if ($data['fieldsData']['status'] === 'отгружен'): ?>
            <option selected value="отгружен">отгружен</option>
          <?php else: ?>
            <option value="отгружен">отгружен</option>
          <?php endif; ?>
          <?php if ($data['fieldsData']['status'] === 'отменен'): ?>
            <option selected value="отменен">отменен</option>
          <?php else: ?>
            <option value="отменен">отменен</option>
          <?php endif; ?>
        </select>
      </div>
      <div class="col">
        <select name="print-type" class="custom-select custom-select-sm">
          <option value="" disabled selected>печать</option>
          <?php if ($data['fieldsData']['printType'] === 'все'): ?>
            <option selected value="все">все</option>
          <?php else: ?>
            <option>все</option>
          <?php endif; ?>
          <?php foreach ($data['printTypeList'] as $printTypeListKey => $printTypeListValue): ?>
            <?php if ($data['fieldsData']['printType'] === $printTypeListValue['print_type']): ?>
              <option selected value="<?= $printTypeListValue['print_type'] ?>"><?= $printTypeListValue['print_type'] ?></option>
            <?php else: ?>
              <option><?= $printTypeListValue['print_type'] ?></option>
            <?php endif; ?>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col">
        <select name="client-source" class="custom-select custom-select-sm">
          <option value="" disabled selected>источник</option>
          <?php if ($data['fieldsData']['clientSource'] === 'все'): ?>
            <option selected value="все">все</option>
          <?php else: ?>
            <option>все</option>
          <?php endif; ?>
          <?php foreach ($data['config']['clientSource'] as $clientsSource): ?>
            <?php if ($data['fieldsData']['clientSource'] === $clientsSource): ?>
              <option selected value="<?= $clientsSource ?>"><?= $clientsSource ?></option>
            <?php else: ?>
              <option><?= $clientsSource ?></option>
            <?php endif; ?>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col">
        <input type="text" name="date-range-filter" id="daterangepicker" value="<?= $data['fieldsData']['dateRangeFilter'] ?>"
               placeholder="за период" class="form-control form-control-sm">
      </div>
    </div>
    <div class="form-row">
      <div class="col">
        <input type="text" maxlength="30" name="search" value="<?= $data['fieldsData']['search'] ?>" id="search" class="form-control form-control-sm"
               placeholder="поиск по номеру заказа или клиенту">
      </div>
      <div class="col-2">
        <input type="submit" class="btn btn-sm btn-primary btn-block" value="Найти">
      </div>
    </div>
  </form>
<?php endif; ?>
<?php if (count($data['orderItemsList']) > 0): ?>
  <div class="table-responsive rounded mb-5 min-height">
    <table class="table table-sm table-hover table-bordered m-0 text-nowrap">
      <thead class="">
      <tr>
        <th colspan="" scope="col" class="text-center">Заказ</th>
        <th colspan="" scope="col" class="text-center">Статус</th>
        <th colspan="" scope="col" class="text-center">Клиент</th>
        <th colspan="" scope="col" class="text-center">Материал</th>
        <th colspan="" scope="col" class="text-center">Печать</th>
        <th colspan="" scope="col" class="text-center">Сумма</th>
        <th colspan="" scope="col" class="text-center">Время изг.</th>
        <th colspan="3" scope="col" class="text-center">Печать</th>
        <th colspan="3" scope="col" class="text-center">Перерасход</th>
        <th colspan="2" scope="col" class="text-center">Обработка</th>
        <th colspan="" scope="col" class="text-center">Макет</th>
        <th colspan="3" scope="col" class="text-center">Люверсы</th>
        <th colspan="3" scope="col" class="text-center">Усиление</th>
        <th colspan="3" scope="col" class="text-center">Рез</th>
        <th colspan="3" scope="col" class="text-center">Шнур</th>
        <th colspan="3" scope="col" class="text-center">Карман</th>
        <th colspan="3" scope="col" class="text-center">Стык</th>
        <th colspan="3" scope="col" class="text-center">Ламинация</th>
        <th colspan="3" scope="col" class="text-center">Накатка</th>
        <th colspan="" scope="col" class="text-center">РМ</th>
        <th colspan="" scope="col" class="text-center">Сохранил</th>
        <th colspan="" scope="col" class="text-center">Подтвердил</th>
        <th scope="col" class="text-center">Дата сохранения</th>
        <th scope="col" class="text-center">Дата подтверждения</th>
        <th scope="col" class="text-center">Дата выполнения</th>
        <th scope="col" class="text-center">Дата отгрузки</th>
        <th scope="col" class="text-center">Дата отмены</th>
      </tr>
      <tr>
        <th scope="col" class="text-center"></th>
        <th scope="col" class="text-center"></th>
        <th scope="col" class="text-center"></th>
        <th scope="col" class="text-center"></th>
        <th scope="col" class="text-center"></th>
        <th scope="col" class="text-center"><?= $data['config']['currency'] ?></th>
        <th scope="col" class="text-center">ч.</th>
        <th scope="col" class="text-center">м<sup>2</sup></th>
        <th scope="col" class="text-center"><?= $data['config']['currency'] ?></th>
        <th scope="col" class="text-center">ч.</th>
        <th scope="col" class="text-center">м<sup>2</sup></th>
        <th scope="col" class="text-center"><?= $data['config']['currency'] ?></th>
        <th scope="col" class="text-center">%</th>
        <th scope="col" class="text-center"><?= $data['config']['currency'] ?></th>
        <th scope="col" class="text-center">ч.</th>
        <th scope="col" class="text-center"><?= $data['config']['currency'] ?></th>
        <th scope="col" class="text-center">шт.</th>
        <th scope="col" class="text-center"><?= $data['config']['currency'] ?></th>
        <th scope="col" class="text-center">ч.</th>
        <th scope="col" class="text-center">м.</th>
        <th scope="col" class="text-center"><?= $data['config']['currency'] ?></th>
        <th scope="col" class="text-center">ч.</th>
        <th scope="col" class="text-center">м.</th>
        <th scope="col" class="text-center"><?= $data['config']['currency'] ?></th>
        <th scope="col" class="text-center">ч.</th>
        <th scope="col" class="text-center">м.</th>
        <th scope="col" class="text-center"><?= $data['config']['currency'] ?></th>
        <th scope="col" class="text-center">ч.</th>
        <th scope="col" class="text-center">м.</th>
        <th scope="col" class="text-center"><?= $data['config']['currency'] ?></th>
        <th scope="col" class="text-center">ч.</th>
        <th scope="col" class="text-center">м.</th>
        <th scope="col" class="text-center"><?= $data['config']['currency'] ?></th>
        <th scope="col" class="text-center">ч.</th>
        <th scope="col" class="text-center">м<sup>2</sup></th>
        <th scope="col" class="text-center"><?= $data['config']['currency'] ?></th>
        <th scope="col" class="text-center">ч.</th>
        <th scope="col" class="text-center">м<sup>2</sup></th>
        <th scope="col" class="text-center"><?= $data['config']['currency'] ?></th>
        <th scope="col" class="text-center">ч.</th>
        <th scope="col" class="text-center"><?= $data['config']['currency'] ?></th>
        <th scope="col" class="text-center"></th>
        <th scope="col" class="text-center"></th>
        <th scope="col" class="text-center"></th>
        <th scope="col" class="text-center"></th>
        <th scope="col" class="text-center"></th>
        <th scope="col" class="text-center"></th>
        <th scope="col" class="text-center"></th>
      </tr>
      </thead>
      <tbody>
      <?php foreach ($data['orderItemsList'] as $key => $value): ?>
        <tr class="">
          <td class="text-right">
            <ul class="nav text-right d-inline-block">
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle m-0 p-0" data-toggle="dropdown" href="#" role="button" aria-haspopup="true"
                   aria-expanded="false"><?= $value['order_name'] . ' (' . ($value['order_item_index'] + 1) . ')' ?></a>
                <div class="dropdown-menu">
                  <?php if ($value['order_item_status'] === 'в работе'): ?>
                    <a class="dropdown-item" target="_blank"
                       href="<?= $data['config']['host'] . '/print-calc.php?action=render-print-blank&file-path=' .
                       $value['calc_result_file_path'] . '&only=' . $value['order_item_index'] ?>">бланк</a>
                    <a class="dropdown-item text-danger" href="<?= $data['config']['host'] . '/print.php?orderitem=' .
                    $value['id'] . '&change-orderitem-status=отменен' .
                    $data['getParamStr'] ?>">отменить</a>
                  <?php else: ?>
                    <a class="dropdown-item" target="_blank"
                       href="<?= $data['config']['host'] . '/print-calc.php?action=render-print-blank&file-path=' .
                       $value['calc_result_file_path'] . '&only=' . $value['order_item_index'] ?>">бланк</a>
                  <?php endif; ?>
                </div>
              </li>
            </ul>
          </td>
          <?php if ($data['isForSafe']): ?>
            <td class="text-left"><?= $value['order_name'] . ' (' . ($value['order_item_index'] + 1) . ')' ?></td>
          <?php else: ?>
            <?php if ($value['order_item_status'] === 'сохранен'): ?>
              <td class="text-center"><span class="badge badge-warning"><?= $value['order_item_status'] ?></span></td>
            <?php elseif ($value['order_item_status'] === 'в работе'): ?>
              <td class="text-center"><span class="badge badge-primary"><?= $value['order_item_status'] ?></span></td>
            <?php elseif ($value['order_item_status'] === 'выполнен'): ?>
              <td class="text-center"><span class="badge badge-success"><?= $value['order_item_status'] ?></span></td>
            <?php elseif ($value['order_item_status'] === 'отгружен'): ?>
              <td class="text-center"><span class="badge badge-light"><?= $value['order_item_status'] ?></span></td>
            <?php else: ?>
              <td class="text-center"><span class="badge badge-danger"><?= $value['order_item_status'] ?></span></td>
            <?php endif; ?>
          <?php endif; ?>
          <?php if ($data['isForSafe']): ?>
            <td class="text-left"><?= $value['name'] ?></td>
          <?php else: ?>
            <td class="text-left">
              <a href="<?= $data['config']['host'] . '/clients.php?action=show-card&id=' . $value['client_id'] ?>" data-toggle="tooltip"
                 data-placement="top"
                 title="<?= $value['name'] ?>"><?= cutStr($value['name'], 10) ?></a></td>
          <?php endif; ?>

          <?php if ($data['isForSafe']): ?>
            <td class="text-left"><?= $value['material_type'] ?></td>
          <?php else: ?>
            <td class="text-left">
          <span data-toggle="tooltip" data-placement="top" title="<?= $value['material_type'] ?>"
                class=""><?= cutStr($value['material_type'], 15) ?></span>
            </td>
          <?php endif; ?>

          <?php if ($data['isForSafe']): ?>
            <td class="text-left"><?= $value['print_type'] ?></td>
          <?php else: ?>
            <td class="text-left">
          <span data-toggle="tooltip" data-placement="top" title="<?= $value['print_type'] ?>"
                class=""><?= cutStr($value['print_type'], 12) ?></span>
            </td>
          <?php endif; ?>
          <td class="text-right"><?= $value['total_total_price'] ?></td>
          <td class="text-right"><?= $value['total_total_hours'] ?></td>
          <td class="text-right"><?= $value['print_quantity'] ?></td>
          <td class="text-right"><?= $value['print_total_price'] ?></td>
          <td class="text-right"><?= $value['print_hours'] ?></td>
          <td class="text-right"><?= $value['overspending_quantity'] ?></td>
          <td class="text-right"><?= $value['overspending_total_price'] ?></td>
          <td class="text-right"><?= $value['overspending_percent'] ?></td>
          <td class="text-right"><?= $value['optional_work_total_price'] ?></td>
          <td class="text-right"><?= $value['optional_work_hours'] ?></td>
          <td class="text-right"><?= $value['design_price_total_price'] ?></td>
          <td class="text-right"><?= $value['cringle_quantity'] ?></td>
          <td class="text-right"><?= $value['cringle_total_price'] ?></td>
          <td class="text-right"><?= $value['cringle_hours'] ?></td>
          <td class="text-right"><?= $value['gain_quantity'] ?></td>
          <td class="text-right"><?= $value['gain_total_price'] ?></td>
          <td class="text-right"><?= $value['gain_hours'] ?></td>
          <td class="text-right"><?= $value['cut_quantity'] ?></td>
          <td class="text-right"><?= $value['cut_total_price'] ?></td>
          <td class="text-right"><?= $value['cut_hours'] ?></td>
          <td class="text-right"><?= $value['cord_quantity'] ?></td>
          <td class="text-right"><?= $value['cord_total_price'] ?></td>
          <td class="text-right"><?= $value['cord_hours'] ?></td>
          <td class="text-right"><?= $value['pocket_quantity'] ?></td>
          <td class="text-right"><?= $value['pocket_total_price'] ?></td>
          <td class="text-right"><?= $value['pocket_hours'] ?></td>
          <td class="text-right"><?= $value['coupling_quantity'] ?></td>
          <td class="text-right"><?= $value['coupling_total_price'] ?></td>
          <td class="text-right"><?= $value['coupling_hours'] ?></td>
          <td class="text-right"><?= $value['lamination_quantity'] ?></td>
          <td class="text-right"><?= $value['lamination_total_price'] ?></td>
          <td class="text-right"><?= $value['lamination_hours'] ?></td>
          <td class="text-right"><?= $value['stick_to_plastic_quantity'] ?></td>
          <td class="text-right"><?= $value['stick_to_plastic_total_price'] ?></td>
          <td class="text-right"><?= $value['stick_to_plastic_hours'] ?></td>
          <td class="text-right"><?= $value['total_material_cost'] ?></td>
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
      <?php if ($data['sum']): ?>
        <thead class="">
        <tr>
          <th colspan="48" class="text-left">Итого:</th>
        </tr>
        <tr>
          <th colspan="" scope="col" class="text-center"></th>
          <th colspan="" scope="col" class="text-center"></th>
          <th colspan="" scope="col" class="text-center"></th>
          <th colspan="" scope="col" class="text-center"></th>
          <th colspan="" scope="col" class="text-center"></th>
          <th colspan="" scope="col" class="text-center">Сумма</th>
          <th colspan="" scope="col" class="text-center">Время изг.</th>
          <th colspan="3" scope="col" class="text-center">Печать</th>
          <th colspan="3" scope="col" class="text-center">Перерасход</th>
          <th colspan="2" scope="col" class="text-center">Обработка</th>
          <th colspan="" scope="col" class="text-center">Макет</th>
          <th colspan="3" scope="col" class="text-center">Люверсы</th>
          <th colspan="3" scope="col" class="text-center">Усиление</th>
          <th colspan="3" scope="col" class="text-center">Рез</th>
          <th colspan="3" scope="col" class="text-center">Шнур</th>
          <th colspan="3" scope="col" class="text-center">Карман</th>
          <th colspan="3" scope="col" class="text-center">Стык</th>
          <th colspan="3" scope="col" class="text-center">Ламинация</th>
          <th colspan="3" scope="col" class="text-center">Накатка</th>
          <th colspan="" scope="col" class="text-center">РМ</th>
          <th colspan="" scope="col" class="text-center"></th>
          <th colspan="" scope="col" class="text-center"></th>
          <th colspan="" scope="col" class="text-center"></th>
          <th colspan="" scope="col" class="text-center"></th>
          <th colspan="" scope="col" class="text-center"></th>
          <th colspan="" scope="col" class="text-center"></th>
          <th colspan="" scope="col" class="text-center"></th>
        </tr>
        <tr>
          <th scope="col" class="text-center"></th>
          <th scope="col" class="text-center"></th>
          <th scope="col" class="text-center"></th>
          <th scope="col" class="text-center"></th>
          <th scope="col" class="text-center"></th>
          <th scope="col" class="text-center"><?= $data['config']['currency'] ?></th>
          <th scope="col" class="text-center">ч.</th>
          <th scope="col" class="text-center">м<sup>2</sup></th>
          <th scope="col" class="text-center"><?= $data['config']['currency'] ?></th>
          <th scope="col" class="text-center">ч.</th>
          <th scope="col" class="text-center">м<sup>2</sup></th>
          <th scope="col" class="text-center"><?= $data['config']['currency'] ?></th>
          <th scope="col" class="text-center">%</th>
          <th scope="col" class="text-center"><?= $data['config']['currency'] ?></th>
          <th scope="col" class="text-center">ч.</th>
          <th scope="col" class="text-center"><?= $data['config']['currency'] ?></th>
          <th scope="col" class="text-center">шт.</th>
          <th scope="col" class="text-center"><?= $data['config']['currency'] ?></th>
          <th scope="col" class="text-center">ч.</th>
          <th scope="col" class="text-center">м.</th>
          <th scope="col" class="text-center"><?= $data['config']['currency'] ?></th>
          <th scope="col" class="text-center">ч.</th>
          <th scope="col" class="text-center">м.</th>
          <th scope="col" class="text-center"><?= $data['config']['currency'] ?></th>
          <th scope="col" class="text-center">ч.</th>
          <th scope="col" class="text-center">м.</th>
          <th scope="col" class="text-center"><?= $data['config']['currency'] ?></th>
          <th scope="col" class="text-center">ч.</th>
          <th scope="col" class="text-center">м.</th>
          <th scope="col" class="text-center"><?= $data['config']['currency'] ?></th>
          <th scope="col" class="text-center">ч.</th>
          <th scope="col" class="text-center">м.</th>
          <th scope="col" class="text-center"><?= $data['config']['currency'] ?></th>
          <th scope="col" class="text-center">ч.</th>
          <th scope="col" class="text-center">м<sup>2</sup></th>
          <th scope="col" class="text-center"><?= $data['config']['currency'] ?></th>
          <th scope="col" class="text-center">ч.</th>
          <th scope="col" class="text-center">м<sup>2</sup></th>
          <th scope="col" class="text-center"><?= $data['config']['currency'] ?></th>
          <th scope="col" class="text-center">ч.</th>
          <th scope="col" class="text-center"><?= $data['config']['currency'] ?></th>
          <th scope="col" class="text-center"></th>
          <th scope="col" class="text-center"></th>
          <th scope="col" class="text-center"></th>
          <th scope="col" class="text-center"></th>
          <th scope="col" class="text-center"></th>
          <th scope="col" class="text-center"></th>
          <th scope="col" class="text-center"></th>
        </tr>
        <tr>
          <th scope="col" class="text-center"></th>
          <th scope="col" class="text-center"></th>
          <th scope="col" class="text-center"></th>
          <th scope="col" class="text-center"></th>
          <th scope="col" class="text-center"></th>
          <th scope="col" class="text-center"><?= number_format($data['sum']['total_total_price'], 0, '.', ' ') ?></th>
          <th scope="col" class="text-center"><?= $data['sum']['total_total_hours'] ?></th>
          <th scope="col" class="text-center"><?= $data['sum']['print_quantity'] ?></th>
          <th scope="col" class="text-center"><?= number_format($data['sum']['print_total_price'], 0, '.', ' ') ?></th>
          <th scope="col" class="text-center"><?= $data['sum']['print_hours'] ?></th>
          <th scope="col" class="text-center"><?= $data['sum']['overspending_quantity'] ?></th>
          <th scope="col" class="text-center"><?= number_format($data['sum']['overspending_total_price'], 0, '.', ' ') ?></th>
          <th scope="col" class="text-center"><?= $data['sum']['overspending_percent'] ?></th>
          <th scope="col" class="text-center"><?= number_format($data['sum']['optional_work_total_price'], 0, '.', ' ') ?></th>
          <th scope="col" class="text-center"><?= $data['sum']['optional_work_hours'] ?></th>
          <th scope="col" class="text-center"><?= number_format($data['sum']['design_price_total_price'], 0, '.', ' ') ?></th>
          <th scope="col" class="text-center"><?= $data['sum']['cringle_quantity'] ?></th>
          <th scope="col" class="text-center"><?= number_format($data['sum']['cringle_total_price'], 0, '.', ' ') ?></th>
          <th scope="col" class="text-center"><?= $data['sum']['cringle_hours'] ?></th>
          <th scope="col" class="text-center"><?= $data['sum']['gain_quantity'] ?></th>
          <th scope="col" class="text-center"><?= number_format($data['sum']['gain_total_price'], 0, '.', ' ') ?></th>
          <th scope="col" class="text-center"><?= $data['sum']['gain_hours'] ?></th>
          <th scope="col" class="text-center"><?= $data['sum']['cut_quantity'] ?></th>
          <th scope="col" class="text-center"><?= number_format($data['sum']['cut_total_price'], 0, '.', ' ') ?></th>
          <th scope="col" class="text-center"><?= $data['sum']['cut_hours'] ?></th>
          <th scope="col" class="text-center"><?= $data['sum']['cord_quantity'] ?></th>
          <th scope="col" class="text-center"><?= number_format($data['sum']['cord_total_price'], 0, '.', ' ') ?></th>
          <th scope="col" class="text-center"><?= $data['sum']['cord_hours'] ?></th>
          <th scope="col" class="text-center"><?= $data['sum']['pocket_quantity'] ?></th>
          <th scope="col" class="text-center"><?= number_format($data['sum']['pocket_total_price'], 0, '.', ' ') ?></th>
          <th scope="col" class="text-center"><?= $data['sum']['pocket_hours'] ?></th>
          <th scope="col" class="text-center"><?= $data['sum']['coupling_quantity'] ?></th>
          <th scope="col" class="text-center"><?= number_format($data['sum']['coupling_total_price'], 0, '.', ' ') ?></th>
          <th scope="col" class="text-center"><?= $data['sum']['coupling_hours'] ?></th>
          <th scope="col" class="text-center"><?= $data['sum']['lamination_quantity'] ?></th>
          <th scope="col" class="text-center"><?= number_format($data['sum']['lamination_total_price'], 0, '.', ' ') ?></th>
          <th scope="col" class="text-center"><?= $data['sum']['lamination_hours'] ?></th>
          <th scope="col" class="text-center"><?= $data['sum']['stick_to_plastic_quantity'] ?></th>
          <th scope="col" class="text-center"><?= number_format($data['sum']['stick_to_plastic_total_price'], 0, '.', ' ') ?></th>
          <th scope="col" class="text-center"><?= $data['sum']['stick_to_plastic_hours'] ?></th>
          <th scope="col" class="text-center"><?= number_format($data['sum']['total_material_cost'], 0, '.', ' ') ?></th>
          <th scope="col" class="text-center"></th>
          <th scope="col" class="text-center"></th>
          <th scope="col" class="text-center"></th>
          <th scope="col" class="text-center"></th>
          <th scope="col" class="text-center"></th>
          <th scope="col" class="text-center"></th>
          <th scope="col" class="text-center"></th>
        </tr>
        </thead>
      <?php endif; ?>
    </table>
  </div>
<?php else: ?>
  <p class="h1 text-secondary">ничего :(</p>
<?php endif; ?>
