<form class="card mb-5" action="<?= $data['config']['host'] . '/clients.php' ?>" method="get">
  <input type="hidden" name="action" value="add-service">
  <input type="hidden" name="id" value="<?= $data['clientData']['id'] ?>">
  <input type="hidden" name="operation-id" value="<?= $data['operationId'] ?>">
  <div class="card-header bg-light text-primary h6">
    <a href="<?= $data['config']['host'] . '/clients.php?action=show-card&id=' . $data['clientData']['id'] ?>" class="btn btn-link btn-sm m-0 py-0 pl-0 pr-3"
       role="button"
       aria-pressed="true"><?= $data['clientData']['name'] ?></a>
  </div>
  <ul class="list-group list-group-flush">
    <li class="list-group-item">
      <?php if ($data['clientData']['balance'] < 0): ?>
        <p class="h6 text-danger">Баланс: <?= number_format($data['clientData']['balance'], 0, '.', ' ') . ' ' . $data['config']['currency'] ?></p>
      <?php elseif ($data['clientData']['balance'] > 0): ?>
        <p class="h6 text-success">Баланс: <?= number_format($data['clientData']['balance'], 0, '.', ' ') . ' ' . $data['config']['currency'] ?></p>
      <?php else: ?>
        <p class="h6">Баланс: <?= number_format($data['clientData']['balance'], 0, '.', ' ') . ' ' . $data['config']['currency'] ?></p>
      <?php endif; ?>
      <a href="<?= $data['config']['host'] . '/clients.php?action=payments-list&id=' . $data['clientData']['id'] ?>" class="btn btn-link btn-sm p-0 m-0"
         role="button"
         aria-pressed="true">история платежей</a>
    </li>
    <li class="list-group-item">
      <div class="form-row mb-3">
        <div class="col">
          <label class="" for="payment-purpose">Назначение</label>
          <select name="payment-purpose" id="payment-purpose" class="custom-select custom-select-sm">
            <option value="" disabled selected>выбрать</option>
            <option value="услуги">услуги</option>
          </select>
        </div>
      </div>
      <div class="form-row mb-3">
        <div class="col">
          <label class="" for="amount">Сумма</label>
          <input type="text" maxlength="6" required pattern="[0-9]{1,6}" name="amount" id="amount" class="form-control form-control-sm"
                 placeholder="">
        </div>
      </div>
      <div class="form-row mb-4">
        <div class="col">
          <label class="" for="payment-note">Детали</label>
          <input type="text" maxlength="80" name="payment-note" id="payment-note" class="form-control form-control-sm">
        </div>
      </div>
      <input type="submit" class="btn btn-sm btn-primary" value="Сохранить">
    </li>
  </ul>
</form>