<form class="card mb-5" action="<?= $data['config']['host'] . '/clients.php' ?>" method="get">
  <?php if ($data['isAddCard']): ?>
    <input type="hidden" name="action" value="add-card">
    <div class="card-header bg-light text-primary h6">
      Клиенты / добавить
    </div>
  <?php elseif ($data['isEditCard']): ?>
    <input type="hidden" name="action" value="edit-card">
    <input type="hidden" name="id" value="<?= $data['fieldsData']['editCard'] ?>">
    <div class="card-header bg-light text-primary h6">
      <?= $data['fieldsData']['name'] ?>
    </div>
  <?php endif; ?>
  <ul class="list-group list-group-flush">
    <li class="list-group-item">
      <?php if ($data['isAddCard']): ?>
        <div class="form-row mb-3">
          <div class="col">
            <label class="" for="client-source">Источник</label>
            <select name="client-source" id="client-source" class="custom-select custom-select-sm">
              <option value="" disabled selected>выбрать</option>
              <?php foreach ($data['config']['clientSource'] as $key => $value): ?>
                  <option value="<?= $value ?>"><?= $value ?></option>
              <?php endforeach ?>
            </select>
          </div>
        </div>
      <?php endif; ?>
      <div class="form-row mb-3">
        <div class="col">
          <label class="" for="name">Фамилия Имя или Организация</label>
          <input type="text" maxlength="45" name="name" id="name" class="form-control form-control-sm" pattern="[А-Яа-яЁё0-9 ]{5,30}"
                 value="<?= $data['fieldsData']['name'] ?>" required>
        </div>
      </div>
      <div class="form-row mb-3">
        <div class="col">
          <label class="" for="email">Email</label>
          <input type="email" maxlength="45" name="email" id="email" class="form-control form-control-sm" value="<?= $data['fieldsData']['email'] ?>"
                 required>
        </div>
      </div>
      <div class="form-row mb-3">
        <div class="col">
          <label class="" for="first-tel">Основной телефон</label>
          <input type="tel" name="first-tel" id="first-tel" class="form-control form-control-sm" pattern="\+7\s\d{3}\s\d{3}\s\d{2}\s\d{2}"
                 value="<?= $data['fieldsData']['firstTel'] ?>" required placeholder="формат +7 XXX XXX XX XX">
        </div>
      </div>
      <div class="form-row mb-3">
        <div class="col">
          <label class="" for="second-tel"">Дополнительный телефон</label>
          <input type="tel" name="second-tel" id="second-tel" class="form-control form-control-sm" pattern="\+7\s\d{3}\s\d{3}\s\d{2}\s\d{2}"
                 value="<?= $data['fieldsData']['secondTel'] ?>" placeholder="формат +7 XXX XXX XX XX">
        </div>
      </div>
      <div class="form-row mb-3">
        <div class="col">
          <label class="" for="address"">Адрес</label>
          <input type="text" id="address" maxlength="90" name="address" class="form-control form-control-sm"
                 value="<?= $data['fieldsData']['address'] ?>">
        </div>
      </div>
      <div class="form-row mb-3">
        <div class="col">
          <label class="" for="note">Заметки</label>
          <textarea name="note" id="note" class="form-control form-control-sm" rows="2" maxlength="240"><?= $data['fieldsData']['note'] ?></textarea>
        </div>
      </div>
      <?php if ($data['isAddCard']): ?>
        <input type="submit" class="btn btn-sm btn-primary" value="Добавить">
      <?php elseif ($data['isEditCard']): ?>
        <input type="submit" class="btn btn-sm btn-primary" value="Сохранить">
      <?php endif; ?>
    </li>
  </ul>
</form>