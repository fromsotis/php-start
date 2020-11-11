<?php


class Email
{
    /**
     * Отправке email сообщений
     * @param string $subject : тема сообщение
     * @param string $body : тело сообщения
     * @return int : 1 - успешно отправлено || 0 - ошибка отправки
     */
    public static function sendMail(string $subject, string $body)
    {
        $configPath = ROOT . '/config/email_params.php'; // настройки отправки почты
        $params = require_once ($configPath);

        $transport = (new Swift_SmtpTransport(
            $params['smtp']['host'],
            $params['smtp']['port'],
            $params['smtp']['encryption'],
        ))
            ->setUsername($params['smtp']['username'])
            ->setPassword($params['smtp']['password']);

        $mailer = new Swift_Mailer($transport);

        $message = (new Swift_Message($subject))
            ->setFrom($params['setFrom'])
            ->setTo([$params['setTo']])
            ->setBody($body, $params['contentType']);

        return $mailer->send($message);

        // Debug send mail
        // (для отладки закоментируйте return $mailer->send($message); и раскоментрируйте код ниже)
//        $logger = new Swift_Plugins_Loggers_EchoLogger();
//        $mailer->registerPlugin(new Swift_Plugins_LoggerPlugin($logger));
//
//        $result = $mailer->send($message, $failures);
//        var_dump($failures);
    }
}