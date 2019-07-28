<?php


namespace app\controllers\admin;


use app\models\User;

class UserController extends AdminAppController
{
    public function loginAdminAction()
    {
        if (!empty($_POST)) {
            $user = new User();
            if ($user->login(true)) {
                $_SESSION['success'] = 'Вы успешно авторизованы';
            } else {
                $_SESSION['error'] = 'Логин или пароль не верны!';
            }
            if (User::isAdmin()) {
                redirect(ADMIN);
            } else {
                redirect();
            }
        }
        $this->layout = 'login';
    }
}