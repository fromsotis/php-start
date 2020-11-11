<?php


class UserController
{
    /** Action для регистрации нового пользователя
     * @return bool
     */
    public function actionRegister() : bool
    {
        $name = '';
        $email = '';
        $password = '';
        $repeatPassword = '';
        $result = false;

        if (isset($_POST['submit'])) {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $repeatPassword = $_POST['repeat_password'];

            $errors = false;

            if (!User::checkName($name)) {
                $errors[] = 'Имя не должно быть короче 2-х символов';
            }

            if (!User::checkEmail($email)) {
                $errors[] = 'Не правелный email';
            }

            if (!User::checkPasswordLen($password)) {
                $errors[] = 'Пароль не должен быть короче 6-ти символов';
            }

            if ($password !== $repeatPassword) {
                $errors[] = 'Пароли не совпадают';
            }

            if (User::checkEmailExists($email)) {
                $errors[] = 'Такой email уже используется';
            }

            if ($errors === false) {
                $result = User::register($name, $email, $password);
            }
        }

        require_once (ROOT . '/views/user/register.php');

        return true;
    }

    /**
     * Action для авторизации пользователя на сайте
     * @return mixed true || void
     */
    public function actionLogin()
    {
        $email = '';
        $password = '';
        if (isset($_POST['submit'])) {
             $email = $_POST['email'];
             $password = $_POST['password'];

             $errors = false;

             if (!User::checkEmail($email)) {
                 $errors[] = 'Неправельные email';
             }
             if (!User::checkPasswordLen($password)) {
                 $errors[] = 'Пароль, не короче 6 символов';
             }

             $userId = User::checkUserData($email, $password); // (int)id пользователя || false

             if (!$userId) {
                 $errors[] = 'Неверные логин или пароль';
             } else {
                 // если данные верны то запишем пользователя в сессию
                 User::auth($userId);
                 header('Location: /cabinet/');
                 exit();
             }
        }
        require_once (ROOT . '/views/user/login.php');

        return true;
    }

    /**
     * Action для выхода из личного кабинете
     * удалит сессию текущего пользователя
     */
    public function actionLogout() : void
    {
        unset($_SESSION['user']);
        header('Location: /');
        exit();
    }
}