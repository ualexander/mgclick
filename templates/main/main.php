<div class="container-fluid bg-primary shadow mb-5">
  <div class="container-fluid px-3 px-md-0">
    <div class="row mx-sm-1 d-flex justify-content-between align-items-center">
        <h3 class="text-white my-3"><?= $data['user']['name'] ?></h3>
      <a href="<?= $data['config']['host'] . '/logout.php' ?>" class="d-inline-block text-light px-0" role="button" aria-pressed="true">
        <i class="material-icons align-bottom mr-1">exit_to_app</i><span class="d-md-none d-lg-inline-block">Выйти</span>
      </a>
    </div>
  </div>
</div>
<div class="container px-3">
  <div class="card-columns">
    <?php foreach ($data['navigationList'] as $sectionKey => $sectionValue): ?>
        <div class="card">
          <h4 class="card-header bg-light text-primary"><?= $sectionValue['title'] ?></h4>
          <ul class="list-group list-group-flush">
            <li class="list-group-item">
              <?php foreach ($sectionValue['options'] as $optionsKey => $optionsValue): ?>
                <?php if ($optionsValue['title'] === 'divider'): ?>
                  <hr>
                  <?php continue; ?>
                <?php endif; ?>
                <a class="btn btn-link" role="button" href="<?= $optionsValue['url'] ?>"><?= $optionsValue['title'] ?></a>
                <br>
              <?php endforeach; ?>
            </li>
          </ul>
      </div>
    <?php endforeach; ?>
  </div>
</div>