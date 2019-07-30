<form class="login-form" action="login.php" method="post">
  <?php if ($data['errorMassage']): ?>
    <h6 class="text-danger"><?= $data['errorMassage'] ?></h6>
  <?php endif; ?>
  <div class="form-group">
    <input type="text" required class="form-control" name="login" autocomplete="off" value="<?= $data['login'] ?>" placeholder="Логин">
  </div>
  <div class="form-group">
    <input type="password" required class="form-control" name="password" autocomplete="off" value="<?= $data['password'] ?>" placeholder="Пароль">
  </div>
  <button type="submit" class="btn btn-primary ">Войти</button>
</form>