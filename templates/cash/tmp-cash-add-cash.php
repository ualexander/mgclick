<form class="card mb-5" action="<?= $data['config']['host'] . '/cash.php' ?>" method="get">
  <input type="hidden" name="action" value="add-cash">
  <input type="hidden" name="operation-id" value="<?= $data['operationId'] ?>">
  <div class="card-header bg-light text-primary h6">
    Касса / внести запись
  </div>
  <ul class="list-group list-group-flush">
    <li class="list-group-item">
      <div class="form-row mb-3">
        <div class="col">
          <label class="" for="operation-type">Тип опрерации</label>
          <select name="operation-type" id="operation-type" class="custom-select custom-select-sm">
            <option value="" disabled selected>выбрать</option>
            <option value="deb">приход</option>
            <option value="cred">расход</option>
          </select>
        </div>
      </div>
      <div class="form-row mb-3">
        <div class="col">
          <label class="" for="payment-purpose">Назначение</label>
          <select name="payment-purpose" id="payment-purpose" class="custom-select custom-select-sm">
            <option value="" disabled selected>выбрать</option>
            <?php foreach ($data['config']['paymentsPurpose'] as $key => $value): ?>
              <?php if (!$value['isPrivate'] || $_SESSION['user']['fullInfo']): ?>
                <option value="<?= $value['title'] ?>"><?= $value['title'] ?></option>
              <?php endif; ?>
            <?php endforeach ?>
          </select>
        </div>
      </div>
      <div class="form-row mb-3">
        <div class="col">
          <label class="" for="amount">Сумма</label>
          <input type="text" maxlength="6" required pattern="[0-9]{1,6}" name="amount" id="amount" class="form-control form-control-sm">
        </div>
      </div>
      <div class="form-row mb-3">
        <div class="col">
          <label class="" for="payment-type">Форма оплаты</label>
          <select name="payment-type" id="payment-type" class="custom-select custom-select-sm">
            <option value="" disabled selected>выбрать</option>
            <?php foreach ($data['config']['paymentsType'] as $key => $value1): ?>
              <option value="<?= $value1 ?>"><?= $value1 ?></option>
            <?php endforeach ?>
          </select>
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