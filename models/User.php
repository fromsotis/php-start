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
}