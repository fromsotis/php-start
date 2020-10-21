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

        $db = Db::getConnection();

        $query = 'INSERT INTO product_order (user_name, user_phone, user_comment, user_id, products) '
            . 'VALUES (:user_name, :user_phone, :user_comment, :user_id, :products)';

        $result = $db->prepare($query);
        $result->bindParam(':user_name', $userName, PDO::PARAM_STR);
        $result->bindParam(':user_phone', $userPhone, PDO::PARAM_STR);
        $result->bindParam(':user_comment', $userComment, PDO::PARAM_STR);
        $result->bindParam(':user_id', $userId, PDO::PARAM_STR);
        $result->bindParam(':products', $products, PDO::PARAM_STR);

        return $result->execute();
    }
}