<?php
include_once 'Core/Model.php';
class ArticleModel extends Model
{
    protected $attributes = [ 'id','title', 'body', 'date', 'author',
    ];
    protected $table = 'articles';


    public function validate($attribute, &$errors)
    {
        $isValid = true;
        if (!$attribute['title']) {
            $isValid = false;
            $errors['title'] = 'Поле "Название статьи" обязательно';
        }


        if (!$attribute['author']) {
            $isValid = false;
            $errors['author'] = 'Имя автора статьи обязательно';

        }
        // Конец валидации

        return $isValid;
    }


}