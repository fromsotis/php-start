DROP DATABASE IF EXISTS `e-shopper`;
CREATE DATABASE IF NOT EXISTS `e-shopper` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `e-shopper`;

-- category
CREATE TABLE IF NOT EXISTS `category`
(
    `id`         INT(11)     NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name`       VARCHAR(50) NOT NULL,
    `sort_order` INT(11)      NOT NULL DEFAULT '0',
    `status`     INT(1)      NOT NULL DEFAULT '1'
);

INSERT INTO `category` (`name`, `sort_order`, `status`) VALUES
    ('Ноутбуки', '1', '1'),
    ('Планшеты', '2', '1'),
    ('Мониторы', '3', '1'),
    ('Игровые компьютеры', '4', '1');

-- product
CREATE TABLE IF NOT EXISTS `product`
(
    `id`             INT(11)      NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name`           VARCHAR(255) NOT NULL,
    `category_id`    INT(11)      NOT NULL,
    `code`           INT(11)      NOT NULL,
    `price`          FLOAT        NOT NULL,
    `availability`   INT(11)      NOT NULL,
    `brand`          VARCHAR(50)  NOT NULL,
    `description`    TEXT         NOT NULL,
    `is_new`         INT(1)       NOT NULL DEFAULT '0',
    `is_recommended` INT(1)       NOT NULL DEFAULT '0',
    `status`         INT(1)       NOT NULL DEFAULT '1'
);

-- Связь id категории в таблицы товаров с id категории в таблице категорий
-- product(category_id) -> category(id)
ALTER TABLE `product`
    ADD CONSTRAINT fk_product_category
        FOREIGN KEY (`category_id`)
            REFERENCES `category` (`id`)
            ON DELETE NO ACTION
            ON UPDATE NO ACTION;

INSERT INTO `product`
(name, category_id, code, price, availability, brand, description, is_new, is_recommended, status)
VALUES
('Ноутбук Asus X200MA (X200MA-KX315D)',1,1839707,395,1,'Asus','Экран 11.6\" (1366x768) HD LED, глянцевый / Intel Pentium N3530 (2.16 - 2.58 ГГц) / RAM 4 ГБ / HDD 750 ГБ / Intel HD Graphics / без ОД / Bluetooth 4.0 / Wi-Fi / LAN / веб-камера / без ОС / 1.24 кг / синий',0,0,1),
('Ноутбук HP Stream 11-d050nr',1,2343847,305,0,'Hewlett Packard','Экран 11.6” (1366x768) HD LED, матовый / Intel Celeron N2840 (2.16 ГГц) / RAM 2 ГБ / eMMC 32 ГБ / Intel HD Graphics / без ОД / Wi-Fi / Bluetooth / веб-камера / Windows 8.1 + MS Office 365 / 1.28 кг / синий',1,1,1),
('Ноутбук Asus X200MA White ',1,2028027,270,1,'Asus','Экран 11.6\" (1366x768) HD LED, глянцевый / Intel Celeron N2840 (2.16 ГГц) / RAM 2 ГБ / HDD 500 ГБ / Intel HD Graphics / без ОД / Bluetooth 4.0 / Wi-Fi / LAN / веб-камера / без ОС / 1.24 кг / белый',0,1,1),
('Ноутбук Acer Aspire E3-112-C65X',1,2019487,325,1,'Acer','Экран 11.6\'\' (1366x768) HD LED, матовый / Intel Celeron N2840 (2.16 ГГц) / RAM 2 ГБ / HDD 500 ГБ / Intel HD Graphics / без ОД / LAN / Wi-Fi / Bluetooth / веб-камера / Linpus / 1.29 кг / серебристый',0,1,1),
('Ноутбук Acer TravelMate TMB115',1,1953212,275,1,'Acer','Экран 11.6\'\' (1366x768) HD LED, матовый / Intel Celeron N2840 (2.16 ГГц) / RAM 2 ГБ / HDD 500 ГБ / Intel HD Graphics / без ОД / LAN / Wi-Fi / Bluetooth 4.0 / веб-камера / Linpus / 1.32 кг / черный',0,0,1),
('Ноутбук Lenovo Flex 10',1,1602042,370,0,'Lenovo','Экран 10.1\" (1366x768) HD LED, сенсорный, глянцевый / Intel Celeron N2830 (2.16 ГГц) / RAM 2 ГБ / HDD 500 ГБ / Intel HD Graphics / без ОД / Wi-Fi / Bluetooth / веб-камера / Windows 8.1 / 1.2 кг / черный',0,0,1),
('Ноутбук Asus X751MA',1,2028367,430,1,'Asus','Экран 17.3\" (1600х900) HD+ LED, глянцевый / Intel Pentium N3540 (2.16 - 2.66 ГГц) / RAM 4 ГБ / HDD 1 ТБ / Intel HD Graphics / DVD Super Multi / LAN / Wi-Fi / Bluetooth 4.0 / веб-камера / DOS / 2.6 кг / белый',0,1,1),
('Samsung Galaxy Tab S 10.5 16GB',2,1129365,780,1,'Samsung','Samsung Galaxy Tab S создан для того, чтобы сделать вашу жизнь лучше. Наслаждайтесь своим контентом с покрытием 94% цветов Adobe RGB и 100000:1 уровнем контрастности, который обеспечивается sAmoled экраном с функцией оптимизации под отображаемое изображение и окружение. Яркий 10.5” экран в ультратонком корпусе весом 467 г порадует вас высоким уровнем портативности. Работа станет проще вместе с Hancom Office и удаленным доступом к вашему ПК. E-Meeting и WebEx – отличные помощники для проведения встреч, когда вы находитесь вне офиса. Надежно храните ваши данные благодаря сканеру отпечатка пальцев.',1,1,1),
('Samsung Galaxy Tab S 8.4 16GB',2,1128670,640,1,'Samsung','Экран 8.4\" Super AMOLED (2560x1600) емкостный Multi-Touch / Samsung Exynos 5420 (1.9 ГГц + 1.3 ГГц) / RAM 3 ГБ / 16 ГБ встроенной памяти + поддержка карт памяти microSD / Bluetooth 4.0 / Wi-Fi 802.11 a/b/g/n/ac / основная камера 8 Мп, фронтальная 2.1 Мп / GPS / ГЛОНАСС / Android 4.4.2 (KitKat) / 294 г / белый',0,0,1),
('Gazer Tegra Note 7',2,683364,210,1,'Gazer','Экран 7\" IPS (1280x800) емкостный Multi-Touch / NVIDIA Tegra 4 (1.8 ГГц) / RAM 1 ГБ / 16 ГБ встроенной памяти + поддержка карт памяти microSD / Wi-Fi / Bluetooth 4.0 / основная камера 5 Мп, фронтальная - 0.3 Мп / GPS / ГЛОНАСС / Android 4.4.2 (KitKat) / вес 320 г',0,0,1),
('Монитор 23\" Dell E2314H Black',3,355025,175,1,'Dell','С расширением Full HD Вы сможете рассмотреть мельчайшие детали. Dell E2314H предоставит Вам резкое и четкое изображение, с которым любая работа будет в удовольствие. Full HD 1920 x 1080 при 60 Гц разрешение (макс.)',0,0,1),
('Компьютер Everest Game ',4,1563832,1320,1,'Everest','Everest Game 9085 — это компьютеры премимум класса, собранные на базе эксклюзивных компонентов, тщательно подобранных и протестированных лучшими специалистами нашей компании. Это топовый сегмент систем, который отвечает наилучшим характеристикам показателей качества и производительности.',0,0,1);

-- user
CREATE TABLE IF NOT EXISTS `user`
(
    `id`       INT(11)      NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name`     VARCHAR(255) NOT NULL,
    `email`    VARCHAR(255) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `role`     VARCHAR(50)  NOT NULL DEFAULT 'user',
    UNIQUE `unique_email` (`email`)
);

-- Тестовые пользователи пароли Qw12345
INSERT INTO `user` (`name`, `email`, `password`, role)
VALUES
    ('Администратор', 'admin@mail.com', '$2y$10$cDCVYWP2OISLgovs2Vl2Qe3lfoynJ2w9HaCvU7MHm4f.I2RB5pvWW', 'admin'),
    ('Пользователь', 'user@mail.com', '$2y$10$RU7iS8UKXVoMhVMIZlutLOe25dLGTHnFQ62ff5oSR67BhHbdmWUiG', 'user');

-- product_order
CREATE TABLE IF NOT EXISTS `product_order`
(
    `id`           INT(11)      NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `user_name`    VARCHAR(255) NOT NULL,
    `user_phone`   VARCHAR(255) NOT NULL,
    `user_comment` TEXT         NOT NULL,
    `user_id`      INT(11)      NULL     DEFAULT NULL,
    `date`         TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `products`     TEXT         NOT NULL,
    `status`       INT(1)       NOT NULL DEFAULT '1'
);

INSERT INTO `product_order` (`user_name`, `user_phone`, `user_comment`, `user_id`, `date`, `products`, `status`)
VALUES
    ('Алексей', '+79998887777', 'Звонить после 18:00', NULL, '2020-11-11 01:29:41', '{\"9\":1,\"11\":1,\"12\":1,\"1\":1}', 1);
