<?php

include_once ROOT . '/models/Category.php';
include_once ROOT . '/models/Product.php';

class SiteController
{
    public function actionIndex() : bool
    {
        $categories = [];
        $categories = Category::getCategoriesList();

        $lastProducts = [];
        $lastProducts = Product::getLatestProduct(6); // кол-во отоброжаемых товаров на главной

        $sliderProducts = [];
        $sliderProducts = Product::getRecommendedProducts(); // кол-во отоброжаемых товаров в слайдаре

        require_once(ROOT . '/views/site/index.php');
        return true;
    }

     // mail() - устарело и удалено с php7.4
//    public function actionContact()
//    {
//        $mail = 'womxez09hez2@mail.ru';
//        $subject = 'Тема письма';
//        $message = 'Содержание письма';
//        $result = mail($mail, $subject, $message);
//
//        var_dump($result);
//
//        die();
//    }

    public function actionContact()
    {
        $userEmail = '';
        $userText = '';
        $result = false;

        if (isset($_POST['submit'])) {
            $userEmail = $_POST['userEmail'];
            $userText = $_POST['userText'];

            $errors = false;
            if (!User::checkEmail($userEmail)) {
                $errors[] = 'Email указан некорректно';
            }

            if ($errors === false) {
                $adminEmail = 'womxez09hez2@mail.ru';
                $message = "Текст: {$userText}<br>От {$userEmail}";
                $subject = 'Тема письма';

                $transport = (new Swift_SmtpTransport('smtp.gmail.com', 465, 'ssl'))
                    ->setUsername('fromyeticave@gmail.com')
                    ->setPassword('!@Qw123456789');

                $mailer = new Swift_Mailer($transport);

                $message = (new Swift_Message($subject))
                    ->setFrom(['fromyeticave@gmail.com' => 'E-Shopper'])
                    ->setTo([$adminEmail])
                    ->setBody($message, 'text/html');

                $result = $mailer->send($message);
//                var_dump($result); // успех: int 1  не успех: int 0
            }
        }

        require_once (ROOT . '/views/site/contact.php');
        return true;
    }
}