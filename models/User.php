<?php


class User
{
    /**
     * Запись пользователя в БД, в таблицу user
     * @param string $name
     * @param string $email
     * @param string $password
     * @return bool : true - пользователь добавлен || false - ошибка добавления пользователя
     */
    public static function register(string $name, string $email, string $password) : bool
    {
        $name = trim(strip_tags($name));
        $email = trim(strip_tags($email));
        $hash = password_hash(trim($password), PASSWORD_DEFAULT);

        $dbh = Db::getConnection();
        $sql = 'INSERT INTO user (name, email, password) VALUES (:name, :email, :hash)';
        $result = $dbh->prepare($sql);
        $result->bindParam(':name', $name, PDO::PARAM_STR);
        $result->bindParam(':email', $email, PDO::PARAM_STR);
        $result->bindParam(':hash', $hash, PDO::PARAM_STR);

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

    /**
     * Проверка поля с телефоном
     * @param string $phone
     * @return mixed : 1 | 0 | false
     */
    public static function checkPhone(string $phone)
    {
        $pattern =  '#^((8|\+7)[\- ]?)?(\(?\d{3,4}\)?[\- ]?)?[\d\- ]{5,10}$#';
        return preg_match($pattern, $phone);
    }

    /**
     * Проверка поля с паролем длиной не меньше 6 символов
     * @param string $password
     * @return bool
     */
    public static function checkPasswordLen(string $password) : bool
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

    /**
     * Проверка email на уникальность в БД, в таблице user
     * @param string $email
     * @return bool : true - существует, false - не существует
     */
    public static function checkEmailExists(string $email) : bool
    {
        $dbh = Db::getConnection();
        $sql = 'SELECT COUNT(*) FROM user WHERE email = :email';
        $result = $dbh->prepare($sql);
        $result->bindParam(':email', $email, PDO::PARAM_STR);
        $result->execute();

        if ($result->fetchColumn()) {
            return true;
        }

        return false;
    }

    /**
     * Проверка существования email и password в БД, в таблице user
     * @param string $email
     * @param string $password
     * @return mixed : вернет (int)id пользователя из табл. user || false
     */
    public static function checkUserData(string $email, string $password)
    {
        $dbh = Db::getConnection();
        $sql = 'SELECT id, password FROM user WHERE email = :email';
        $result = $dbh->prepare($sql);
        $result->bindParam(':email', $email, PDO::PARAM_STR);
        $result->execute();

        $user = $result->fetch(PDO::FETCH_ASSOC);
        // в $user = false (email не найден) || true (email найден)
        if ($user) {
            // Если hash от $password == hash в $user['password'] вернем id пользователя
            if (password_verify($password, $user['password'])) {
                return (int)$user['id'];
            }
        }

        return false;
    }

    /**
     * Запишет id пользователя в сессию
     * @param int
     */
    public static function auth(int $userId) : void
    {
        $_SESSION['user'] = $userId;
    }

    /**
     * Проверит авторизирован ли пользователь
     * @return mixed :  (int)id - пользователя || void - перенаправит на login.php
     */
    public static function checkLogged()
    {
        // Если сессия есть, вернем id пользователя
        if (isset($_SESSION['user'])) {
            return $_SESSION['user'];
        }

        header('Location: /user/login');
        exit();
    }

    /**
     * Метод проверяет, является ли пользователь гостем
     * @return bool
     */
    public static function isGuest() : bool
    {
        if (isset($_SESSION['user'])) {
            return false;
        }

        return true;
    }

    /**
     * Вернет массив данных пользователя по его id
     * @param int $userId
     * @return mixed array || false
     */
    public static function getUserById(int $userId)
    {
        if ($userId) {
            $dbh = Db::getConnection();
            $sql = 'SELECT * FROM user WHERE id = :userId';
            $result = $dbh->prepare($sql);
            $result->bindParam(':userId', $userId, PDO::PARAM_INT);
            $result->execute();

            return $result->fetch(PDO::FETCH_ASSOC);
        }

        return false;
    }
}