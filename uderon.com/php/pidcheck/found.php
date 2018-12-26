<div class='user_inf'>
  <div class='urow'>
    <div class='ulabel'>Имя:</div>
    <div class='ulabeled'><?= $fname ?></div>
  </div>
  <div class='urow'>
    <div class='ulabel'>Фамилия:</div>
    <div class='ulabeled'><?= $lname ?></div>
  </div>
  <div class='urow'>
    <div class='ulabel'>Ориентация:</div>
    <div class='ulabeled'>'ПИДАРАС'</div>
  </div>
  <div class='button'>
    <form method='post'>
      <input type='hidden' name='id' value='<?= $check_id ?>'>
      <input type='submit' name='del' value='Удалить из базы'>
    </form>
  </div>
</div>
