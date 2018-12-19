<?php 
  //объявляем POST переменные  
  $lastName = $_POST['last_name']; //фамилия 
  $firstName = $_POST['first_name']; //имя 
 
  //если поле "Фамилия" и "Имя" не пусто 
  if (!empty($lastName) && !empty($firstName)) 
  { 
    //пишем  
    echo "<h1>$lastName $firstName - пидарас. <br /></h1>"; 
    echo "<meta http-equiv='refresh' content='4; url=index.html' />"; 
  } 
  else //иначе 
  {  
    //пишем 
    echo "<h1>Вы - пидарас</h1>"; 
    //и обратно возвращаемся на index.html через 15 миллисекунд 
    echo "<meta http-equiv='refresh' content='4; url=index.html' />"; 
  } 
?> 
