<?php

class News
{
    /**
     * Вернет новость по id
     * @param int $id
     * @return array
     */
    public static function getNewsItemById(int $id) : array
    {
        $id = intval($id);
        if ($id) {
            $db = Db::getConnection();
            $result = $db->query('SELECT * FROM news WHERE id='.$id);
//            $result->setFetchMode(PDO::FETCH_NUM);
            $result->setFetchMode(PDO::FETCH_ASSOC);
            return $result->fetch();
        }
    }

    /**
     * @return array
     */
    public static function getNewsList() : array
    {
        $db = Db::getConnection();
        $newsList = [];

        $result = $db->query("
            SELECT id, title, `date`, short_content, content, author_name
            FROM news
            ORDER BY `date` DESC
            LIMIT 10
            ");

        $i = 0;
        while ($row = $result->fetch()) {
            $newsList[$i]['id'] = $row['id'];
            $newsList[$i]['title'] = $row['title'];
            $newsList[$i]['date'] = $row['date'];
            $newsList[$i]['short_content'] = $row['short_content'];
            $newsList[$i]['content'] = $row['content'];
            $newsList[$i]['author_name'] = $row['author_name'];
            $i++;
        }

        return $newsList;
    }
}