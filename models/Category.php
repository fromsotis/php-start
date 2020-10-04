<?php


class Category
{
    public static function getCategoriesList() : array
    {
        $db = Db::getConnection();

        $categoryList = [];

        $query = "SELECT id, `name` FROM category ORDER BY sort_order ASC";
        $result = $db->query($query);

        $i = 0;
        while ($row = $result->fetch()) {
            $categoryList[$i]['id'] = $row['id'];
            $categoryList[$i]['name'] = $row['name'];
            $i++;
        }

        return $categoryList;
    }
}
/*
var_dump($categoryList);

/var/www/html/models/Category.php:20:
array (size=4)
  0 =>
    array (size=2)
      'id' => string '1' (length=1)
      'name' => string 'Системные блоки' (length=29)
  1 =>
    array (size=2)
      'id' => string '2' (length=1)
      'name' => string 'Ноутбуки' (length=16)
  2 =>
    array (size=2)
      'id' => string '3' (length=1)
      'name' => string 'Моноблоки' (length=18)
  3 =>
    array (size=2)
      'id' => string '4' (length=1)
      'name' => string 'Игровые ноутбуки' (length=31)
*/