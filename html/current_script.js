//функция проверки полей, принимает два аргумента name1, и name2 
function check_fields(name1, name2) { 
  //если значения name1 и name2 не пусты 
  if (document.getElementsByName(name1).value != "") &&  
     (document.getElementsByName(name2).value != "") 
   { 
    //то пишем, что "Поля не пусты" 
     document.write("Поля не пусты"); 
   } 
  else // иначе 
  {   
    //пишем это 
    document.write("Одно или оба поля пусты"); 
  } 
} 