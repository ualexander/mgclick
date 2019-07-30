<div class="card mb-5 table-responsive">
  <div class="card-header bg-light text-primary h6">
    Касса / основное
  </div>
  <table class="table table-hover m-0">
    <thead class="table-borderless">
    <tr>
      <th scope="col" class="text-left"></th>
      <th scope="col" class="text-right">Остаток</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($data['cashList'] as $key => $value): ?>
      <tr>
        <td class="text-left"><b><?= $value['payment_type'] ?></b></td>
        <td class="text-right"><b><?= number_format($value['balance'], 0, '.', ' ') . ' ' . $data['config']['currency'] ?></b></td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
</div>