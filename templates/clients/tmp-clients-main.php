<div class="card mb-5">
  <div class="card-header bg-light text-primary h6">
    Клиенты / основная информация
  </div>
  <table class="table table-hover m-0">
    <tbody>
    <tr class="table-borderless">
      <td class="text-left">Всего клиентов в базе</td>
      <td class="text-right"><?= $data['clientsQuantity'] ?></td>
    </tr>
    <tr class="">
      <td class="text-left">Из них активных (3 заказа / 3 мес)</td>
      <td class="text-right"><?= $data['clientsQuantityActive'] ?></td>
    </tr>
    <tr class="">
      <td class="text-left">Клиентов с отрицательным балансом</td>
      <td class="text-right"><?= $data['clientsCred']['cnt'] ?></td>
    </tr>
    <tr class="">
      <td class="text-left">Общая сумма задолженности</td>
      <td class="text-right"><?= number_format($data['clientsCred']['cred'], 0, '.', ' ') . ' ' . $data['config']['currency'] ?></td>
    </tr>
    <tr class="">
      <td class="text-left">Клиентов с положительным балансом</td>
      <td class="text-right"><?= $data['clientsDeb']['cnt'] ?></td>
    </tr>
    <tr class="">
      <td class="text-left">Общая сумма переплаты</td>
      <td class="text-right"><?= number_format($data['clientsDeb']['deb'], 0, '.', ' ') . ' ' . $data['config']['currency'] ?></td>
    </tr>
    </tbody>
  </table>
</div>