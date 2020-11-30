<?php
include 'App/Models/UserModel.php';
include 'Core/View.php';

class UserController extends View
{
    private $UserModel;
    private $View;


    public function __construct()
    {
        $this->UserModel = new UserModel();
        $this->View = new View();
    }


    public function MainAction()
    {
        $attributes = $this->UserModel->getAll();
        $this->View->render('App/Views/User/main.php', ['attributes' => $attributes]);

    }
    public function CreateAction()
    {
        $attribute = [
            'id' => '',
            'login' => '',
            'username' => '',
            'surname' => '',
            'birthdate' => '',
            'email' => '',
            'address' => '',
        ];

        $errors = [
            'login' => '',
            'username' => '',
            'birthdate' => '',

        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $attribute = array_merge($attribute, $_POST);
            $isValid = $this->UserModel->validate($attribute, $errors);

            if ($isValid) {
                $this->UserModel->create($_POST);
                header("Location: /user/");
            }

        }
        $this->View->render('App/Views/User/create.php',['attribute' => $attribute,
                                                                'errors' => $errors]);

    }

    public function ViewAction()
    {
        $id = $this->UserModel->getId();
        $attribute = $this->UserModel->getById($id);
        $this->View->render('App/Views/User/view.php', ['attribute' => $attribute ]);
    }

    public function UpdateAction()
    {
        $id = $this->UserModel->getId();
        $attribute = $this->UserModel->getById($id);
        $attributeUp = $_POST;
        $errors = [
            'login' => '',
            'username' => '',
            'birthdate' => '',
        ];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $attribute = array_merge($attribute, $_POST);

            $isValid = $this->UserModel->validate($attribute, $errors);
            if ($isValid) {
                $attribute = $this->UserModel->update($id, $attributeUp);
                header("Location: /user/");
            }
        }
        $this->View->render('App/Views/User/update.php', ['attribute' => $attribute,
                                                                    'errors' => $errors]);
    }

    public function DeleteAction()
    {
        $id = $this->UserModel->getId();
        $attribute = $this->UserModel->getById($id);
        $this->View->render('App/Views/User/delete.php',['attribute' => $attribute]);
        $this->UserModel->delete($id);
        //header("Location: /user/");

    }

}

