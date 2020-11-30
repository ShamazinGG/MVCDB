<?php
//namespace App\Models;
include_once 'Core/Model.php';
class UserModel extends Model
{
    protected $attributes = [
        'id','login', 'username', 'surname', 'birthdate', 'email', 'address',];
    protected $table = 'users';

    function validate($attribute, &$errors)
    {
        $isValid = true;
        //Начало валидации
        if (!$attribute['login'] || strlen($attribute['login']) < 5 || strlen($attribute['login']) > 20) {
            $isValid = false;
            $errors['login'] = 'Поле "Логин" обязательно и должно содержать от 5 до 20 символов';
        }

        if (!$attribute['birthdate']) {
            $isValid = false;
            $errors['birthdate'] = '"Дата рождения" введена некорректно';

        }
        // Конец валидации

        return $isValid;

    }
}


