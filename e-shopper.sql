DROP DATABASE IF EXISTS `e-shopper`;
CREATE DATABASE IF NOT EXISTS `e-shopper` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `e-shopper`;

-- category
CREATE TABLE IF NOT EXISTS `category`
(
    `id`         INT(11)     NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name`       VARCHAR(50) NOT NULL,
    `sort_order` INT(1)      NOT NULL DEFAULT '0',
    `status`     INT(1)      NOT NULL DEFAULT '1'
);

INSERT INTO `category` (`name`, `sort_order`, `status`) VALUES
    ('Системные блоки', '1', '1'),
    ('Ноутбуки', '2', '1'),
    ('Моноблоки', '3', '1'),
    ('Игровые ноутбуки', '4', '1');

-- product
CREATE TABLE IF NOT EXISTS `product`
(
    `id`             INT(11)      NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name`           VARCHAR(255) NOT NULL,
    `category_id`    INT(11)      NOT NULL,
    `code`           INT(11)      NOT NULL,
    `price`          FLOAT        NOT NULL,
    `availability`   INT(11)      NOT NULL DEFAULT '1',  -- ???
    `brand`          VARCHAR(50)  NOT NULL,
    `image`          VARCHAR(50)  NULL     DEFAULT NULL, -- Картника товара по умолчанию NULL
    `description`    TEXT         NOT NULL,
    `is_new`         INT(1)       NOT NULL DEFAULT '0',
    `is_recommended` INT(1)       NOT NULL DEFAULT '0',
    `status`         INT(1)       NOT NULL DEFAULT '1'
);

-- product(category_id) -> category(id)
ALTER TABLE `product`
    ADD CONSTRAINT fk_product_category
        FOREIGN KEY (`category_id`)
            REFERENCES `category` (`id`)
            ON DELETE NO ACTION
            ON UPDATE NO ACTION;

INSERT INTO `product`
    (`name`, `category_id`, `code`, `price`, `brand`, `description`)
VALUES
('ПК Lenovo IdeaCentre T540-15ICK G [90LW003HRS]', 1, 1629116, 49999, 'Lenovo', '[Intel Core i5 9400F, 6x2900 МГц, 8 ГБ DDR4, GeForce GTX 1650, SSD 512 ГБ, Wi-Fi, Windows 10 Домашняя]'),
('Рабочая станция Dell Precision T5820 5820-2811', 1, 8154542, 185999, 'Dell', '[Intel Core i9-9900X, 10x3500 МГц, 16 ГБ DDR4, HDD 1 ТБ, SSD 256 ГБ, DVD±RW, Linux]'),
('ПК HP Pavilion TP01-0020ur [8KE39EA]', 1, 8155114, 56199, 'HP', '[AMD Ryzen 3 3200G, 4x3600 МГц, 8 ГБ DDR4, Radeon RX 5300XT, HDD 1 ТБ, SSD 128 ГБ, Wi-Fi, Windows 10 Домашняя]'),
('ПК MSI Codex 5 10SI-215RU [9S6-B93041-215]', 1, 1671522, 76999, 'MSI', '[Intel Core i5 10400F, 6x2900 МГц, 16 ГБ DDR4, GeForce GTX 1660 SUPER, HDD 1 ТБ, SSD 256 ГБ, Wi-Fi, без ОС]'),
('16" Ноутбук Apple MacBook Pro Retina TB (MVVJ2RU/A) серый', 2, 1611363, 199999, 'Apple', '[3072x1920, IPS, Intel Core i7, 6 х 2.6 ГГц, RAM 16 ГБ, SSD 512 ГБ, Radeon Pro 5300M 4 Гб, Wi-Fi, macOS]'),
('15.6" Ноутбук HP 15-da1108ur черный', 2, 1631614, 54699, 'HP', '[1920x1080, SVA (TN+film), Intel Core i5 8265U, 4 х 1.6 ГГц, RAM 4 ГБ, SSD 256 ГБ, GeForce MX130 4 Гб, Wi-Fi, Windows 10 Home]'),
('15.6" Ноутбук Lenovo IdeaPad 3 15ARE05 серый', 2, 1655068, 42999, 'Lenovo', '[1920x1080, IPS, AMD Ryzen 3 4300U, 4 х 2.7 ГГц, RAM 8 ГБ, SSD 512 ГБ, Radeon Vega 5 , Wi-Fi, DOS]'),
('13.4" Ультрабук Dell XPS 9300-3133 серебристый', 2, 1654824, 142999, 'Dell', '[1920x1200, IPS, Intel Core i5 1035G1, 4 х 1 ГГц, RAM 8 ГБ, SSD 512 ГБ, Intel UHD , Wi-Fi, Windows 10 Home]'),
('27" Моноблок Apple iMac 27 Retina 5K [MXWU2RU/A]', 3, 1697734, 189999, 'Apple','[Intel Core i5, 6x3300 МГц, IPS, 5120x2880, 8 ГБ DDR4, SSD 512 ГБ, AMD Radeon Pro 5300, клавиатура, мышь, Mac OS X]'),
('23.8" Моноблок HP 24-df0037ur [14Q08EA]', 3, 1663274, 50099,'HP', '[Intel Core i3 1005G1, 2x1200 МГц, IPS, 1920x1080, 8 ГБ DDR4 SODIMM, SSD 256 ГБ, GeForce MX 330, Windows 10 Домашняя]'),
('21.5" Моноблок Lenovo AIO V530-22ICB [10US00M9RU]', 3, 8185416, 55999, 'Lenovo', '[Intel Core i3 9100T, 4x3100 МГц, IPS, 1920x1080, 4 ГБ DDR4, SSD 128 ГБ, DVD-RW, клавиатура, мышь, без ОС]'),
('21.5" Моноблок Dell OptiPlex 3280 [3280-6611]', 3, 8189854, 89399, 'Dell', '[Intel Core i5 10500T, 6x2300 МГц, VA, 1920x1080, 8 ГБ DDR4, SSD 256 ГБ, Windows 10 Pro]'),
('16" Ноутбук Apple MacBook Pro Retina TB (MVVK2RU/A) серый', 4, 1611367, 225999, 'Apple', '[3072x1920, IPS, Intel Core i9, 8 х 2.3 ГГц, RAM 16 ГБ, SSD 1024 ГБ, Radeon Pro 5500M 4 Гб, Wi-Fi, macOS]'),
('17.3" Ноутбук HP OMEN 17-cb1001ur черный', 4, 1652139, 145999, 'HP', '[1920x1080, IPS, Intel Core i7 10750H, 6 х 2.6 ГГц, RAM 16 ГБ, SSD 1024 ГБ, GeForce RTX 2070 Super 8 Гб, Wi-Fi, Windows 10 Home]'),
('15.6" Ноутбук Lenovo Legion 7 15IMHg05 серый', 4, 1655145, 229999, 'Lenovo', '[1920x1080, IPS, Intel Core i7 10875H, 8 х 2.3 ГГц, RAM 32 ГБ, SSD 1024 ГБ, GeForce RTX 2080 Super MaxQ 8 Гб, Wi-Fi, Windows 10 Home]'),
('15.6" Ноутбук MSI GE66 DragonShield 10SGS-476RU серый', 4, 1687496, 289999, 'MSI', '[1920x1080, IPS, Intel Core i9 10980HK, 8 х 2.4 ГГц, RAM 32 ГБ, SSD 2048 ГБ, GeForce RTX 2080 Super MaxQ 8 Гб, Wi-Fi, Windows 10 Home]');

-- user
CREATE TABLE IF NOT EXISTS `user`
(
    `id`       INT(11)      NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name`     VARCHAR(255) NOT NULL,
    `email`    VARCHAR(255) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    UNIQUE `unique_email` (`email`)
);

INSERT INTO `user` (`name`, `email`, `password`)
VALUES ('Алексей', 'fromsotis@gmail.com', 'Qw12345');

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

-- product_order(user_id) -> user(id)
# ALTER TABLE `product_order`
#     ADD CONSTRAINT fk_product_order_user
#         FOREIGN KEY (`user_id`)
#             REFERENCES `user` (`id`)
#             ON DELETE NO ACTION
#             ON UPDATE NO ACTION;