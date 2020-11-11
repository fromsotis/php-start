<?php


class Product
{
    const SHOW_BY_DEFAULT = 6; // кол-во отображаемых товаров на странице

    /**
     * Метод вернет из БД последние товары в кол-ве заданном в $limit
     * @param int $page
     * @return array
     */
    public static function getLatestProduct(int $page = 1) : array
    {
        $limit = self::SHOW_BY_DEFAULT;
        $offset = ($page - 1) * $limit;

        $dbh = Db::getConnection();
        $sql = 'SELECT id, `name`, price, is_new FROM product WHERE status = 1
                    ORDER BY id DESC LIMIT :limit OFFSET :offset';
        $result = $dbh->prepare($sql);
        $result->bindParam(':limit', $limit, PDO::PARAM_INT);
        $result->bindParam(':offset', $offset, PDO::PARAM_INT);
        $result->execute();

        $productList = [];
        $i = 0;
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $productList[$i]['id'] = $row['id'];
            $productList[$i]['name'] = $row['name'];
            $productList[$i]['price'] = $row['price'];
            $productList[$i]['is_new'] = $row['is_new'];
            $i++;
        }

        return $productList;
    }

    /**
     * Метод вернёт из БД товары для слайдера на главной странице
     * В БД данные товары определяются как is_recommended = 1
     * @return array
     */
    public static function getRecommendedProducts() : array
    {
        $dbh = Db::getConnection();
        $sql = 'SELECT id, `name`, price, is_new
                    FROM product WHERE status = 1 AND is_recommended = 1 ORDER BY id DESC';
        $result = $dbh->query($sql);
        $result->execute();

        $i = 0;
        $productList = [];
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $productList[$i]['id'] = $row['id'];
            $productList[$i]['name'] = $row['name'];
            $productList[$i]['price'] = $row['price'];
            $productList[$i]['is_new'] = $row['is_new'];
            $i++;
        }

        return $productList;
    }

    /**
     * Метод получает список товаров по id категории, в кол-ве указанном в SHOW_BY_DEFAULT,
     * расчитывает смещение списка товаров для постраничной пагинации
     * @param false $categoryId
     * @param int $page
     * @return array
     */
    public static function getProductListByCategory($categoryId = false, $page = 1) : array
    {
        // Пагинация
        if ($categoryId) {
            $page = (int) $page;
            $limit = self::SHOW_BY_DEFAULT;
            $offset = ($page - 1) * $limit;
        //
            $dbh = Db::getConnection();
            $products = [];
            $sql = 'SELECT id, name, price, is_new FROM product
                        WHERE status = 1 AND category_id = :categoryId
                        ORDER BY id DESC LIMIT :limit OFFSET :offset';
            $result = $dbh->prepare($sql);
            $result->bindParam(':categoryId', $categoryId, PDO::PARAM_INT);
            $result->bindParam(':limit', $limit, PDO::PARAM_INT);
            $result->bindParam(':offset', $offset, PDO::PARAM_INT);
            $result->execute();

            $i = 0;
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $products[$i]['id'] = $row['id'];
                $products[$i]['name'] = $row['name'];
                $products[$i]['price'] = $row['price'];
                $products[$i]['is_new'] = $row['is_new'];
                $i++;
            }

            return $products;
        }
    }

    /**
     * Метод для получения товара по его id
     * @param int $id
     * @return array
     */
    public static function getProductById(int $id) : array
    {
        if ($id) {
            $dbh = Db::getConnection();
            $sql = 'SELECT * FROM product WHERE id = :id';
            $result = $dbh->prepare($sql);
            $result->bindParam(':id', $id, PDO::PARAM_INT);
            $result->execute();

            return $result->fetch(PDO::FETCH_ASSOC);
        }
    }

    /**
    * Вернет кол-во всех товаров (для пагинации)
    * @return int
    */
    public static function getTotalProducts() : int
    {
        $dbh = Db::getConnection();
        $sql = 'SELECT COUNT(id) as count FROM product WHERE status = 1';
        $result = $dbh->query($sql);
        $result->execute();

        $row = $result->fetch(PDO::FETCH_ASSOC);

        return $row['count'];
    }

    /**
     * Вернет кол-во товара в определенной категории (для пагинации)
     * @param int $categoryId
     * @return int
     */
    public static function getTotalProductsInCategory(int $categoryId) : int
    {
        $dbh = Db::getConnection();
        $sql = 'SELECT COUNT(id) as count FROM product WHERE status = 1 AND category_id = :categoryId';
        $result = $dbh->prepare($sql);
        $result->bindParam(':categoryId', $categoryId, PDO::PARAM_INT);
        $result->execute();

        $row = $result->fetch(PDO::FETCH_ASSOC);

        return $row['count'];
    }

    /**
     * @param array $idsArray
     * @return array : products
     */
    public static function getProductsByIds(array $idsArray) : array
    {
        $idsString = implode(', ', $idsArray);

        $dbh = Db::getConnection();
        $sql = "SELECT * FROM product WHERE status = 1 AND id IN ($idsString)";
        $result = $dbh->query($sql);

        $products = [];
        $i = 0;
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $products[$i]['id'] = $row['id'];
            $products[$i]['code'] = $row['code'];
            $products[$i]['name'] = $row['name'];
            $products[$i]['price'] = $row['price'];
            $i++;
        }

        return $products;
    }

    /**
     * Возвращает список товаров
     * @return array
     */
    public static function getProductsList() : array
    {
        $dbh = Db::getConnection();
        $sql = 'SELECT id, name, code, price FROM product ORDER BY id';
        $result = $dbh->query($sql);
        $result->execute();

        $productsList = [];
        $i = 0;
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $productsList[$i]['id'] = $row['id'];
            $productsList[$i]['name'] = $row['name'];
            $productsList[$i]['code'] = $row['code'];
            $productsList[$i]['price'] = $row['price'];
            $i++;
        }

        return $productsList;
    }

    /**
     * Удалит товар в БД по id
     * @param int $id
     * @return bool : true - успех | false - ошибка
     */
    public static function deleteProductById(int $id) : bool
    {
        $dbh = Db::getConnection();
        $sql = 'DELETE FROM product WHERE id = :id';
        $result = $dbh->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);

        return $result->execute();
    }

    /**
     * Добавляет новый товар и возвращает id добавленного товара
     * @param array $options
     * @return int : id добавленного товара
     */
    public static function createProduct(array $options) : int
    {
        $dbh = Db::getConnection();
        $sql = 'INSERT INTO product (name, code, price, category_id, brand, availability, description, is_new, is_recommended, status) VALUES (:name, :code, :price, :category_id, :brand, :availability, :description, :is_new, :is_recommended, :status)';
        $result = $dbh->prepare($sql);
        $result->bindParam(':name', $options['name'], PDO::PARAM_STR);
        $result->bindParam(':code', $options['code'], PDO::PARAM_INT);
        $result->bindParam(':price', $options['price'], PDO::PARAM_STR);
        $result->bindParam(':category_id', $options['category_id'], PDO::PARAM_INT);
        $result->bindParam(':brand', $options['brand'], PDO::PARAM_STR);
        $result->bindParam(':availability', $options['availability'], PDO::PARAM_INT);
        $result->bindParam(':description', $options['description'], PDO::PARAM_STR);
        $result->bindParam(':is_new', $options['is_new'], PDO::PARAM_INT);
        $result->bindParam(':is_recommended', $options['is_recommended'], PDO::PARAM_INT);
        $result->bindParam(':status', $options['status'], PDO::PARAM_INT);
        if ($result->execute()) {
            // Если запрос выполнен успешно, возвращаем id добавленной записи
            return $dbh->lastInsertId();
        }
        // иначе
        return 0;

    }

    /**
     * Редактирует товар с заданным id
     * @param int $id
     * @param array $options
     * @return bool
     */
    public static function updateProductById(int $id, array $options)
    {
        $productName = htmlspecialchars($options['name']); // экранируем " в названии товара

        $dbh = Db::getConnection();
        $sql = 'UPDATE product SET '
                    . 'name = :name, '
                    . 'code = :code, '
                    . 'price = :price, '
                    . 'category_id = :category_id, '
                    . 'brand = :brand, '
                    . 'availability = :availability, '
                    . 'description = :description, '
                    . 'is_new = :is_new, '
                    . 'is_recommended = :is_recommended, '
                    . 'status = :status '
            . 'WHERE id = :id';

        // Получение и возврат резултатов
        $result = $dbh->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->bindParam(':name', $options['name'], PDO::PARAM_STR);
        $result->bindParam(':code', $options['code'], PDO::PARAM_STR);
        $result->bindParam(':price', $options['price'], PDO::PARAM_STR);
        $result->bindParam(':category_id', $options['category_id'], PDO::PARAM_INT);
        $result->bindParam(':brand', $options['brand'], PDO::PARAM_STR);
        $result->bindParam(':availability', $options['availability'], PDO::PARAM_INT);
        $result->bindParam(':description', $options['description'], PDO::PARAM_STR);
        $result->bindParam(':is_new', $options['is_new'], PDO::PARAM_INT);
        $result->bindParam(':is_recommended', $options['is_recommended'], PDO::PARAM_INT);
        $result->bindParam(':status', $options['status'], PDO::PARAM_INT);

        return $result->execute();
    }

    /**
     * Возвращает текстое пояснение наличия товара
     * 0 - Под заказ, 1 - В наличии
     * @param int $availability Статус
     * @return string Текстовое пояснение
     */
    public static function getAvailabilityText(int $availability) : string
    {
        switch ($availability) {
            case '1':
                return 'В наличии';
                break;
            case '0':
                return 'Под заказ';
                break;
        }
    }

    /**
     * Возвращает путь к изображению
     * @param int $id
     * @return string Путь к изображению
     */
    public static function getImage(int $id) : string
    {
        // Название изображения-пустышки
        $noImage = 'no-image.jpg';

        // Путь к папке с товарами
        $path = '/upload/images/products/';

        // Путь к изображению товара
        $pathToProductImage = $path . $id . '.jpg';

        if (file_exists($_SERVER['DOCUMENT_ROOT'] . $pathToProductImage)) {
            // Если изображение для товара существует
            // Возвращаем путь изображения товара
            return $pathToProductImage;
        }

        // Возвращаем путь изображения-пустышки
        return $path . $noImage;
    }

}