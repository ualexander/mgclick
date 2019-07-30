<div class="border table-responsive rounded mb-5">
  <table class="table table-sm table-hover m-0">
    <thead class="table-borderless">
    <tr>
      <th scope="col" class="text-left">Материал</th>
      <th scope="col" class="text-right">Приход м.</th>
      <th scope="col" class="text-right">Расход м.</th>
      <th scope="col" class="text-right">Остаток м.</th>
      <th scope="col" class="text-right">Заказов</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($data['materialsList'] as $key => $value): ?>
      <?php if ($value['balance'] < $data['config']['minMaterialQuantity']): ?>
        <tr class="table-danger">
      <?php else : ?>
        <tr class="">
      <?php endif; ?>
        <td class="text"><?= $value['material_name'] ?></td>
        <td class="text-right"><?= $value['deb'] ?></td>
        <td class="text-right"><?= $value['cred'] ?></td>
        <td class="text-right"><b><?= $value['balance'] ?></b></td>
        <td class="text-right"><?= $value['order_quantity'] ?></td>
      </tr>
    <?php endforeach ?>
    </tbody>
  </table>
</div>
