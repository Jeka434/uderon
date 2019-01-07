function vkcheck()
{
	valid = true;
    if (document.contact_form.contact_name.value == "") {
        alert ("Пожалуйста заполните поле 'Ваше имя'.");
        valid = false;
    }
    return valid;
}
