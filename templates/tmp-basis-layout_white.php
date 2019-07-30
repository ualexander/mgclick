<header class="border-bottom fixed-top bg-white shadow-sm">
  <div class="container px-1 px-xl-3">
    <div class="d-flex justify-content-between my-1">
      <ul class="nav nav-pills">
        <?php foreach ($data['navigationList'] as $key => $value): ?>
          <li class="nav-item">
            <?php if ($value['isActive']): ?>
              <a class="nav-link dropdown-toggle active" data-toggle="dropdown" href="<?= $value['url'] ?>" role="button" aria-haspopup="true"
                 aria-expanded="false"><?= $value['title'] ?></a>
            <?php else: ?>
              <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="<?= $value['url'] ?>" role="button" aria-haspopup="true"
                 aria-expanded="false"><?= $value['title'] ?></a>
            <?php endif; ?>
            <div class="dropdown-menu">
              <?php foreach ($value['options'] as $key2 => $value2): ?>
                <?php if ($value2['title'] === 'divider'): ?>
                  <div class="dropdown-divider"></div>
                <?php elseif ($value2['title'] !== 'divider' && $value2['isActive']): ?>
                  <a class="dropdown-item active" href="<?= $value2['url'] ?>"><?= $value2['title'] ?></a>
                <?php else: ?>
                  <a class="dropdown-item" href="<?= $value2['url'] ?>"><?= $value2['title'] ?></a>
                <?php endif; ?>
              <?php endforeach ?>
            </div>
          </li>
        <?php endforeach ?>
      </ul>
      <div class="nav">
        <a href="<?= $data['config']['host'] . '/logout.php' ?>" class="btn btn-link" role="button" aria-pressed="true">Выйти</a>
      </div>
    </div>
  </div>
</header>
<main class="mt-5">
  <div class="container px-0 px-lx-3 mt-5">
    <div class="row mx-0 mx-xl-3">
      <div class="d-none d-xl-block col-2">
        <ul class="nav nav-pills flex-column sticky-top" style="top:6rem">
          <?php foreach ($data['navigationList'] as $key3 => $value3): ?>
            <?php if ($value3['isActive']): ?>
              <?php foreach ($value3['options'] as $key4 => $value4): ?>
                <?php if ($value4['isActive']): ?>
                  <li class="nav-item">
                    <a class="nav-link active" href="<?= $value4['url'] ?>"><?= $value4['title'] ?></a>
                  </li>
                <?php else: ?>
                  <?php if ($value4['title'] === 'divider'): ?>
                    <li class="dropdown-divider"></li>
                  <?php else: ?>
                    <li class="nav-item">
                      <a class="nav-link" href="<?= $value4['url'] ?>"><?= $value4['title'] ?></a>
                    </li>
                  <?php endif; ?>
                <?php endif; ?>
              <?php endforeach ?>
            <?php endif; ?>
          <?php endforeach ?>
        </ul>
      </div>
      <div class="col-12 col-xl-10">
        <?php if ($data['alertMassage']): ?>
          <div class="alert alert-info fade show mb-5" role="alert">
            <?= $data['alertMassage'] ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        <?php endif; ?>
        <?php if ($data['errorMassage']): ?>
          <div class="alert alert-danger fade show mb-5" role="alert">
            <?= $data['errorMassage'] ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        <?php endif; ?>
        <div>
          <?= $data['layoutContent'] ?>
          <?= $data['pagination'] ?? '' ?>
        </div>
      </div>
    </div>
  </div>
</main>
<footer class="border-top">
  <div class="container py-2">
    <img src="../img/rocket-logo-192.png" width="25" height="25" alt="Rocket Logo" class="mr-1"><a
            href="<?= $data['config']['host'] . '/main.php' ?>">Rocket ©</a>
  </div>
</footer>