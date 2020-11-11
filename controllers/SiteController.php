<?php


class SiteController
{
    /**
     * Action для главной страници сайта
     * @return bool
     */
    public function actionIndex() : bool
    {
        $categories = Category::getCategoriesList();
        $latestProducts = Product::getLatestProduct(); // товаров на главной в кол-ве Product::SHOW_BY_DEFAULT
        $sliderProducts = Product::getRecommendedProducts(); // товары в слайдаре

        require_once(ROOT . '/views/site/index.php');

        return true;
    }

    /**
     * Action для обратной связи
     * отправляет сообщение пользователя сайта администратору
     * @return bool
     */
    public function actionContact() : bool
    {
        $userEmail = '';
        $userText = '';
        $result = false;

        if (isset($_POST['submit'])) {
            $userEmail = $_POST['userEmail'];
            $userText = $_POST['userText'];
            $subject = 'Обратная связь';
            $message = 'Текст: ' . $userText . '<br> От ' . $userEmail;

            $errors = false;
            if (!User::checkEmail($userEmail)) {
                $errors[] = 'Email указан некорректно';
            }

            if ($errors === false) {
                $result = Email::sendMail($subject, $message);
//                var_dump($result); // успех: int 1  не успех: int 0
            }
        }

        require_once (ROOT . '/views/site/contact.php');
        return true;
    }
}