<form class="card mb-5" action="<?= $data['config']['host'] . '/materials.php' ?>" method="get">
  <input type="hidden" name="action" value="add-material">
  <input type="hidden" name="operation-id" value="<?= $data['operationId'] ?>">
  <div class="card-header bg-light text-primary h6">
    Материалы / внести запись
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
          <label class="" for="material-purpose">Назначение</label>
          <select name="material-purpose" id="material-purpose" class="custom-select custom-select-sm">
            <option value="" disabled selected>выбрать</option>
            <?php foreach ($data['config']['materialsPurpose'] as $key => $value): ?>
              <option value="<?= $value ?>"><?= $value ?></option>
            <?php endforeach ?>
          </select>
        </div>
      </div>
      <div class="form-row mb-3">
        <div class="col">
          <label class="" for="material-name">Материал</label>
          <select name="material-name" id="material-name" class="custom-select custom-select-sm">
            <option value="" disabled selected>выбрать</option>
            <?php foreach ($data['avalaibleMaterials'] as $key => $value): ?>
              <option value="<?= $value ?>"><?= $value ?></option>
            <?php endforeach ?>
          </select>
        </div>
      </div>
      <div class="form-row mb-3">
        <div class="col">
          <label class="" for="amount">Погонных метров</label>
          <input type="number" step="0.1" max="999" required name="amount" id="amount" class="form-control form-control-sm" placeholder="">
        </div>
      </div>
      <div class="form-row mb-4">
        <div class="col">
          <label class="" for="material-note">Детали</label>
          <input type="text" maxlength="80" name="material-note" id="material-note" class="form-control form-control-sm">
        </div>
      </div>
      <input type="submit" class="btn btn-sm btn-primary" value="Сохранить">
    </li>
  </ul>
</form>
