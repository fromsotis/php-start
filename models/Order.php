<?php


class Order
{
    /**
     * Сохраняем заказ в БД
     * @param string $userName
     * @param string $userPhone
     * @param string $userComment
     * @param mixed $userId : null | int
     * @param array $products
     * @return mixed
     */
    public static function save(string $userName, string $userPhone, string $userComment, $userId, array $products)
    {
        // Преобразуем $products (массив с товаром) в строку json
//        var_dump($products);
        /*
        array (size=3)
            16 => int 6
            15 => int 1
            14 => int 1
         */
        $products = json_encode($products); // string '{"16":6,"15":1,"14":1}'

        $dbh = Db::getConnection();
        $sql = 'INSERT INTO product_order (user_name, user_phone, user_comment, user_id, products) '
            . 'VALUES (:user_name, :user_phone, :user_comment, :user_id, :products)';
        $result = $dbh->prepare($sql);
        $result->bindParam(':user_name', $userName, PDO::PARAM_STR);
        $result->bindParam(':user_phone', $userPhone, PDO::PARAM_STR);
        $result->bindParam(':user_comment', $userComment, PDO::PARAM_STR);
        $result->bindParam(':user_id', $userId, PDO::PARAM_STR);
        $result->bindParam(':products', $products, PDO::PARAM_STR);

        return $result->execute();
    }

    /**
     * Возвращает список заказов
     * @return array Список заказов
     */
    public static function getOrdersList() : array
    {
        $dbh = Db::getConnection();
        $sql = 'SELECT id, user_name, user_phone, date, status FROM product_order ORDER BY id DESC';
        $result = $dbh->query($sql);

        $ordersList = [];
        $i = 0;
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $ordersList[$i]['id'] = $row['id'];
            $ordersList[$i]['user_name'] = $row['user_name'];
            $ordersList[$i]['user_phone'] = $row['user_phone'];
            $ordersList[$i]['date'] = $row['date'];
            $ordersList[$i]['status'] = $row['status'];
            $i++;
        }

        return $ordersList;
    }

    /**
     * Возвращает текстое пояснение статуса для заказа
     * 1 - Новый заказ, 2 - В обработке, 3 - Доставляется, 4 - Закрыт
     * @param int $status Статус
     * @return string Текстовое пояснение
     */
    public static function getStatusText(int $status) : string
    {
        switch ($status) {
            case '1':
                return 'Новый заказ';
                break;
            case '2':
                return 'В обработке';
                break;
            case '3':
                return 'Доставляется';
                break;
            case '4':
                return 'Закрыт';
                break;
        }
    }

    /**
     * Возвращает заказ с указанным id
     * @param int $id id
     * @return array Массив с информацией о заказе
     */
    public static function getOrderById(int $id) :array
    {
        $dbh = Db::getConnection();
        $sql = 'SELECT * FROM product_order WHERE id = :id';
        $result = $dbh->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->execute();

        return $result->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Удаляет заказ с заданным id
     * @param int $id id заказа
     * @return bool Результат выполнения метода
     */
    public static function deleteOrderById(int $id) : bool
    {
        $dbh = Db::getConnection();
        $sql = 'DELETE FROM product_order WHERE id = :id';
        $result = $dbh->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);

        return $result->execute();
    }

    /**
     * Редактирует заказ с заданным id
     * @param int $id id товара
     * @param string $userName Имя клиента
     * @param string $userPhone Телефон клиента
     * @param string $userComment Комментарий клиента
     * @param string $date Дата оформления
     * @param integer $status Статус (включено "1", выключено "0")
     * @return bool Результат выполнения метода
     */
    public static function updateOrderById(
        int $id, string $userName, string $userPhone, string $userComment, string $date, int $status
    ) : bool
    {
        $dbh = Db::getConnection();
        $sql = 'UPDATE product_order
                SET
                    user_name = :user_name,
                    user_phone = :user_phone,
                    user_comment = :user_comment,
                    date = :date,
                    status = :status 
                WHERE id = :id';
        $result = $dbh->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->bindParam(':user_name', $userName, PDO::PARAM_STR);
        $result->bindParam(':user_phone', $userPhone, PDO::PARAM_STR);
        $result->bindParam(':user_comment', $userComment, PDO::PARAM_STR);
        $result->bindParam(':date', $date, PDO::PARAM_STR);
        $result->bindParam(':status', $status, PDO::PARAM_INT);

        return $result->execute();
    }
}