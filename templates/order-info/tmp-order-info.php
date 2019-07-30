<?php if ($data['alertMassage']): ?>
  <div class="row mt-3 mb-3">
    <div class="alert alert-info fade show col-11 col-sm-8 col-md-5 m-auto" role="alert">
      <span class="h4"><?= $data['alertMassage'] ?></span>
    </div>
  </div>
<?php elseif ($data['errorMassage']): ?>
  <div class="row mt-3 mb-3">
    <div class="alert alert-danger fade show col-11 col-sm-8 col-md-5 m-auto" role="alert">
      <span class="h4"><?= $data['errorMassage'] ?></span>
    </div>
  </div>
<?php elseif ($data['content']):  ?>
<?= $data['content']; ?>
<?php endif; ?>