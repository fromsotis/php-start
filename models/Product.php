<?php


class Product
{
    const SHOW_BY_DEFAULT = 10;

    public static function getLatestProduct(int $count = self::SHOW_BY_DEFAULT) : array
    {
        $count = intval($count);

        $db = Db::getConnection();

        $productList = [];

        $query = "SELECT id, `name`, price, is_new FROM product WHERE status = 1 ORDER BY id DESC LIMIT {$count}";
        $result = $db->query($query);

        $i = 0;
        while ($row = $result->fetch()) {
            $productList[$i]['id'] = $row['id'];
            $productList[$i]['name'] = $row['name'];
//            $productList[$i]['image'] = $row['image'];
            $productList[$i]['price'] = $row['price'];
            $productList[$i]['is_new'] = $row['is_new'];
            $i++;
        }

        return $productList;
    }

    public static function getProductListByCategory($categoryId = false) : array
    {
        if ($categoryId) {

            $db = Db::getConnection();
            $products = [];
            $query = 'SELECT id, name, price, is_new FROM product '
                    . 'WHERE status = 1 AND category_id = ' . $categoryId . ' '
                    . 'ORDER BY id DESC '
                    . 'LIMIT ' . self::SHOW_BY_DEFAULT;
            $result = $db->query($query);

            $i = 0;
            while ($row = $result->fetch()) {
                $products[$i]['id'] = $row['id'];
                $products[$i]['name'] = $row['name'];
//                $products[$i]['image'] = $row['image'];
                $products[$i]['price'] = $row['price'];
                $products[$i]['is_new'] = $row['is_new'];
                $i++;
            }

            return $products;
        }
    }

    public static function getProductById($id)
    {
        $id = intval($id);

        if ($id) {
            $db = Db::getConnection();

            $query = "SELECT * FROM product WHERE id = $id";
            $result = $db->query($query);
            $result->setFetchMode(PDO::FETCH_ASSOC);

            return $result->fetch();
        }
    }

}