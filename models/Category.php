<?php


class Category
{
    /**
     * Возвращает массив категорий у которых status = 1 для списка на сайте
     * @return array
     */
    public static function getCategoriesList() : array
    {
        $dbh = Db::getConnection();
        $sql = 'SELECT id, `name` FROM category WHERE status = 1 ORDER BY sort_order';
        $result = $dbh->query($sql);

        $categoryList = [];
        $i = 0;
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $categoryList[$i]['id'] = $row['id'];
            $categoryList[$i]['name'] = $row['name'];
            $i++;
        }

        return $categoryList;
    }

    /**
     * Возвращает массив ВСЕХ категорий для списка в админпанели
     * @return array
     */
    public static function getCategoriesListAdmin() : array
    {
        $dbh = Db::getConnection();
        $sql = 'SELECT id, `name`, sort_order, status FROM category ORDER BY sort_order';
        $result = $dbh->query($sql);

        $categoryList = [];
        $i = 0;
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $categoryList[$i]['id'] = $row['id'];
            $categoryList[$i]['name'] = $row['name'];
            $categoryList[$i]['sort_order'] = $row['sort_order'];
            $categoryList[$i]['status'] = $row['status'];
            $i++;
        }

        return $categoryList;
    }

    /**
     * Удаляет категорию с заданным id
     * @param int $id
     * @return bool
     */
    public static function deleteCategoryById(int $id) : bool
    {
        $dbh = Db::getConnection();
        $sql = 'DELETE FROM category WHERE id = :id';
        $result = $dbh->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);

        return $result->execute();
    }

    /**
     * Редактирование категории с заданным id
     * @param int $id id категории
     * @param string $name Название
     * @param int $sortOrder Порядковый номер
     * @param int $status Статус (включено "1", выключено "0")
     * @return bool
     */
    public static function updateCategoryById(int $id, string $name, int $sortOrder, int $status) : bool
    {
        $dbh = Db::getConnection();
        $sql = 'UPDATE category SET name = :name, sort_order = :sort_order, status = :status WHERE id = :id';
        $result = $dbh->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->bindParam(':name', $name, PDO::PARAM_STR);
        $result->bindParam(':sort_order', $sortOrder, PDO::PARAM_INT);
        $result->bindParam(':status', $status, PDO::PARAM_INT);

        return $result->execute();
    }

    /**
     * Возвращает категорию с указанным id
     * @param int $id id категории
     * @return array Массив с информацией о категории
     */
    public static function getCategoryById(int $id)
    {
        $dbh = Db::getConnection();
        $sql = 'SELECT * FROM category WHERE id = :id';
        $result = $dbh->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->execute();

        return $result->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Возвращает текстое пояснение статуса для категории
     * 0 - Скрыта, 1 - Отображается
     * @param int $status Статус
     * @return string Текстовое пояснение
     */
    public static function getStatusText(int $status) : string
    {
        switch ($status) {
            case '1':
                return 'Отображается';
                break;
            case '0':
                return 'Скрыта';
                break;
        }
    }

    /**
     * Добавляет новую категорию в БД
     * @param string $name Название
     * @param int $sortOrder Порядковый номер
     * @param int $status Статус (включено "1", выключено "0")
     * @return bool
     */
    public static function createCategory(string $name, int $sortOrder, int $status) : bool
    {
        $dbh = Db::getConnection();
        $sql = 'INSERT INTO category (name, sort_order, status) VALUES (:name, :sort_order, :status)';
        $result = $dbh->prepare($sql);
        $result->bindParam(':name', $name, PDO::PARAM_STR);
        $result->bindParam(':sort_order', $sortOrder, PDO::PARAM_INT);
        $result->bindParam(':status', $status, PDO::PARAM_INT);

        return $result->execute();
    }
}
