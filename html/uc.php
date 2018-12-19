<?php 
  //объявляем POST переменные  
  $lastName = $_POST['last_name']; //фамилия 
  $firstName = $_POST['first_name']; //имя 
 
  //если поле "Фамилия" и "Имя" не пусто 
  if (!empty($lastName) && !empty($firstName)) 
  { 
    //пишем  
    echo "$lastName $firstName - пидарас. <br />"; 
    echo "<meta http-equiv='refresh' content='4; url=index.html' />"; 
  } 
  else //иначе 
  {  
    //пишем 
    echo "Вы - пидарас"; 
    //и обратно возвращаемся на index.html через 15 миллисекунд 
    echo "<meta http-equiv='refresh' content='4; url=index.html' />"; 
  } 
?> 
