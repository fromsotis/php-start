<?php


class User
{
    /**
     * Запись пользователя в БД
     * @param string $name
     * @param string $email
     * @param string $password
     * @return bool
     */
    public static function register(string $name, string $email, string $password) : bool
    {
        $db = Db::getConnection();

        $query = "INSERT INTO user (name, email, password) VALUES (:name, :email, :password)";

        $result = $db->prepare($query);
        $result->bindParam(':name', $name, PDO::PARAM_STR);
        $result->bindParam(':email', $email, PDO::PARAM_STR);
        $result->bindParam(':password', $password, PDO::PARAM_STR);

        return $result->execute();
    }

    /**
     * Проверка поля с именем длина не меньше 2 символов
     * @param string $name
     * @return bool
     */
    public static function checkName(string $name) : bool
    {
        if (strlen($name) >= 2) {
            return true;
        }

        return false;
    }

    /** Проверка поля с паролем длиной не меньше 6 символов
     * @param string $password
     * @return bool
     */
    public static function checkPassword(string $password) : bool
    {
        if (strlen($password) >= 6) {
            return true;
        }

        return false;
    }

    /**
     * Проверка поля с email
     * @param string $email
     * @return bool
     */
    public static function checkEmail(string $email) : bool
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        }

        return false;
    }

    /** Проверка email на уникальность в БД
     * @param string $email
     * @return bool
     */
    public static function checkEmailExists(string $email) : bool
    {
        $db = Db::getConnection();

        $query = "SELECT COUNT(*) FROM user WHERE email = :email";

        $result = $db->prepare($query);
        $result->bindParam(':email', $email, PDO::PARAM_STR);
        $result->execute();

        if ($result->fetchColumn()) {
            return true;
        }

        return false;
    }

    /**
     * Проверка существования email и password в БД
     * @param string $email
     * @param string $password
     * @return mixed : int (user id) or false
     */
    public static function checkUserData(string $email, string $password)
    {
        $db = Db::getConnection();

        $query = 'SELECT * FROM user WHERE email = :email AND password = :password';

        $result = $db->prepare($query);
        $result->bindParam(':email', $email, PDO::PARAM_STR);
        $result->bindParam(':password', $password, PDO::PARAM_STR);
        $result->execute();

        $user = $result->fetch();
        if ($user) {
            return (int)$user['id'];
        }

        return false;
    }

    /**
     * Пишем id пользователя в сессию
     * @param int
     */
    public static function auth(int $userId) : void
    {
        $_SESSION['user'] = $userId;
    }

    /**
     * @return mixed :  (int)id пользователя или перенаправит на login.php
     */
    public static function checkLogged()
    {
        // Если сессия есть, вернем id пользователя
        if (isset($_SESSION['user'])) {
            return $_SESSION['user'];
        }

        header('Location: /user/login');
    }

    public static function isGuest() : bool
    {
        if (isset($_SESSION['user'])) {
            return false;
        }

        return true;
    }

    /**
     * @param int $userId
     * @return array
     */
    public static function getUserById(int $userId) : array
    {
        if ($userId) {
            $db = Db::getConnection();
            $query = 'SELECT * FROM user WHERE id = :userId';
            $result = $db->prepare($query);
            $result->bindParam(':userId', $userId, PDO::PARAM_INT);

            $result->setFetchMode(PDO::FETCH_ASSOC);
            $result->execute();

            return $result->fetch();
        }
    }

    /**
     * Редактирование имени и пароля пользователя
     * @param int $userId
     * @param string $name
     * @param string $password
     * @return mixed
     */
    public static function edit(int $userId, string $name, string $password)
    {
        $db = Db::getConnection();

        $query = 'UPDATE user SET name = :name, password = :password WHERE id = :userId';
        $result = $db->prepare($query);
        $result->bindParam(':userId', $userId, PDO::PARAM_INT);
        $result->bindParam(':name', $name, PDO::PARAM_STR);
        $result->bindParam(':password', $password, PDO::PARAM_STR);

        return $result->execute();
    }
}