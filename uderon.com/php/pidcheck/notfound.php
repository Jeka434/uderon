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
    <div class='ulabeled'>'НЕИЗВЕСТНО'</div>
  </div>
  <div class='button'>
    <form method='post'>
      <input type='hidden' name='_fname' value='<?= $fname ?>'>
      <input type='hidden' name='_lname' value='<?= $lname ?>'>
      <input type='submit' name='add' value='Добавить в базу'>
    </form>
  </div>
</div>
