<?php
include 'App/Models/ArticleModel.php';
include 'Core/View.php';
class ArticleController
{
    private  $ArticleModel;
    private $View;

    public function __construct()
    {
        $this->ArticleModel = new ArticleModel();
        $this->View = new View();
    }

    public function MainAction()
    {
        $attributes = $this->ArticleModel->getAll();
        $this->View->render('App/Views/Article/main.php', ['attributes' => $attributes]);
    }

    public function ViewAction()
    {
        $id = $this->ArticleModel->getId();
        $attribute = $this->ArticleModel->getById($id);
        $this->View->render('App/Views/Article/view.php', ['attribute' => $attribute ]);

    }
    public function CreateAction()
    {
        $attribute = [
            'id' => '',
            'title' => '',
            'body' => '',
            'date' => '',
            'author' => '',

        ];
        $errors = [
            'title' => '',
            'body' => '',
            'author' => '',

        ];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $attribute = array_merge($attribute, $_POST);
            $isValid = $this->ArticleModel->validate($attribute, $errors);

            if ($isValid) {
                $this->ArticleModel->create($_POST);
                header("Location: /article/");
            }

        }
        $this->View->render('App/Views/Article/create.php',['attribute' => $attribute,
            'errors' => $errors]);
    }



    public function UpdateAction()
    {
        $id = $this->ArticleModel->getId();
        $attributeUp = $_POST;
        $attribute = $this->ArticleModel->getById($id);
        $errors = [
            'title' => '',
            'body' => '',
            'author' => '',
        ];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $attribute = array_merge($attribute, $_POST);

            $isValid = $this->ArticleModel->validate($attribute, $errors);
            if ($isValid) {
                $attribute = $this->ArticleModel->update($id, $attributeUp);
                header("Location: /article/");
            }
        }
        $this->View->render('App/Views/Article/update.php', ['attribute' => $attribute,
            'errors' => $errors]);

    }
    public function DeleteAction()
    {
        $id = $this->ArticleModel->getId();
        $attribute = $this->ArticleModel->getById($id);
        $this->View->render('App/Views/Article/delete.php',['attribute' => $attribute]);
        $this->ArticleModel->delete($id);

    }

}