<div class="card mb-5 table-responsive">
  <div class="card-header bg-light text-primary h6">
    Печать / основная информация
  </div>
  <table class="table table-hover m-0">
    <tbody>
    <tr class="table-borderless">
      <td class="text-left">Текущее время загрузки</td>
      <td class="text-right"><?= $data['ordersInJobData']['total']['total_total_hours'] ?> ч.</td>
    </tr>
    <tr class="">
      <td class="text-left">Постпечатная обработка</td>
      <td class="text-right"><?= $data['ordersInJobData']['total']['optional_work_hours'] ?> ч.</td>
    </tr>
    <tr class="">
      <td class="text-left">Печать</td>
      <td class="text-right"><?= $data['ordersInJobData']['total']['print_hours'] ?> ч.</td>
    </tr>
    <?php foreach ($data['ordersInJobData']['print_type'] as $key => $value): ?>
      <tr class="">
        <td class="text-left"><?= $value['print_type'] ?></td>
        <td class="text-right"><?= $value['print_hours'] ?> ч.</td>
      </tr>
    <?php endforeach; ?>
    </tr>
    </tbody>
  </table>
</div>