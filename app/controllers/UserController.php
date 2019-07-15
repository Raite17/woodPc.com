<?php


namespace app\controllers;


use app\models\User;

class UserController extends AppController
{
    public function signupAction()
    {
        if (!empty($_POST)) {
            $user = new User();
            $data = $_POST;
            $user->load($data);
            if (!$user->validate($data) || !$user->checkUnique()) {
                $user->getErrors();
                $_SESSION['form_data'] = $data;
            } else {
                $user->attributes['password'] = password_hash($user->attributes['password'], PASSWORD_DEFAULT);
                if ($user->save('users')) {
                    $_SESSION['success'] = 'Регистрация прошла успешнно!';

                } else {
                    $_SESSION['error'] = 'Ошибка!';
                }
            }
            redirect();
        }
        $this->setMeta('Регистрация');
    }

    public function loginAction()
    {
        if (!empty($_POST)) {
            $user = new User();
            if ($user->login()) {
                $_SESSION['success'] = 'Вы успешно авторизованы';
            } else {
                $_SESSION['error'] = 'Логин или пароль не верны';
            }
            redirect();
        }
        $this->setMeta('Вход');
    }

    public function logoutAction()
    {
        if ($_SESSION['user']) unset($_SESSION['user']);
        redirect();
    }
}