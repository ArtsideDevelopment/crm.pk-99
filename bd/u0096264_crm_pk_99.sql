-- phpMyAdmin SQL Dump
-- version 4.6.6
-- https://www.phpmyadmin.net/
--
-- Хост: localhost:3306
-- Время создания: Сен 09 2018 г., 16:56
-- Версия сервера: 5.6.39-83.1
-- Версия PHP: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `u0096264_crm_pk_99`
--

-- --------------------------------------------------------

--
-- Структура таблицы `as_access`
--

CREATE TABLE `as_access` (
  `id` int(11) NOT NULL,
  `as_content_id` int(11) NOT NULL,
  `as_lk_users_type_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `as_access`
--

INSERT INTO `as_access` (`id`, `as_content_id`, `as_lk_users_type_id`) VALUES
(2, 1, 1),
(3, 2, 1),
(4, 3, 1),
(5, 4, 1),
(6, 5, 1),
(7, 6, 1),
(8, 7, 1),
(9, 8, 1),
(10, 9, 1),
(12, 10, 1),
(13, 11, 1),
(14, 12, 1),
(15, 13, 1),
(16, 14, 1),
(17, 15, 1),
(18, 16, 1),
(19, 17, 1),
(20, 18, 1),
(21, 19, 1),
(22, 20, 1),
(23, 21, 1),
(24, 22, 1),
(25, 23, 1),
(26, 24, 1),
(27, 25, 1),
(28, 26, 1),
(29, 27, 1),
(30, 28, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `as_content`
--

CREATE TABLE `as_content` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `hierarchy` int(11) DEFAULT NULL,
  `url_path` varchar(255) DEFAULT NULL,
  `menu_icon` varchar(45) DEFAULT NULL,
  `menu_text` varchar(255) DEFAULT NULL,
  `show_in_menu_set` tinyint(4) DEFAULT NULL,
  `show_in_submenu_set` tinyint(4) DEFAULT NULL,
  `title` tinytext,
  `meta_keywords` text,
  `meta_description` text,
  `default_set` tinyint(4) DEFAULT NULL,
  `main_tpl` varchar(255) DEFAULT NULL,
  `access_without_password_set` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `as_content`
--

INSERT INTO `as_content` (`id`, `parent_id`, `hierarchy`, `url_path`, `menu_icon`, `menu_text`, `show_in_menu_set`, `show_in_submenu_set`, `title`, `meta_keywords`, `meta_description`, `default_set`, `main_tpl`, `access_without_password_set`) VALUES
(1, 0, 1, NULL, NULL, 'Главная', 1, NULL, 'Система управления контентом', NULL, NULL, 1, 'main', 0),
(2, 0, 2, 'pages', NULL, 'Страницы сайта', 1, NULL, 'Страницы сайта', NULL, NULL, 0, 'main', 0),
(3, 0, 3, 'shop', NULL, 'Магазин', 1, NULL, 'Магазин', NULL, NULL, 0, 'main', 0),
(4, 0, 4, 'orders', NULL, 'Заказы', 1, NULL, 'Заказы', NULL, NULL, 0, 'main', 0),
(5, 0, 5, 'settings', NULL, 'Настройки', 1, NULL, 'Настройки', NULL, NULL, 0, 'main', 0),
(6, 0, 6, 'users', NULL, 'Пользователи', 1, NULL, 'Пользователи', NULL, NULL, 0, 'main', 0),
(7, 2, 1, 'pages/all-pages', NULL, 'Все страницы', 1, NULL, 'Все страницы', NULL, NULL, 0, 'main', 0),
(8, 2, 2, 'pages/add-page', NULL, 'Добавить страницу', 1, NULL, 'Добавить страницу', NULL, NULL, 0, 'form', 0),
(9, 2, 3, 'pages/edit-page', NULL, 'Редактировать страницу', 1, NULL, 'Редактировать страницу', NULL, NULL, 0, 'form', 0),
(10, 2, 4, 'pages/comments', NULL, 'Комментарии', 1, NULL, 'Комментарии', NULL, NULL, 0, 'main', 0),
(11, 2, 5, 'pages/news', NULL, 'Новости', 1, NULL, 'Новости', NULL, '', 0, 'main', 0),
(12, 3, 1, 'shop/catalog', NULL, 'Категории', 1, NULL, 'Разделы', NULL, NULL, 0, 'main', 0),
(13, 3, 2, 'shop/products', NULL, 'Товары', 1, NULL, 'Товары', NULL, NULL, 0, 'main', 0),
(14, 3, 3, 'shop/manufacturer', NULL, 'Производители', 1, NULL, 'Производители', NULL, NULL, 0, 'main', 0),
(15, 3, 4, 'shop/import', NULL, 'Импорт', 1, NULL, 'Импорт', NULL, NULL, 0, 'form', 0),
(16, 3, 5, 'shop/export', NULL, 'Экспорт', 1, NULL, 'Экспорт', NULL, NULL, 0, 'form', 0),
(17, 3, 6, 'shop/blocks', NULL, 'Общие блоки', 1, NULL, 'Общие блоки', NULL, NULL, 0, 'main', 0),
(18, 5, 1, 'settings/contacts', NULL, 'Контакты', 1, NULL, 'Контакты', NULL, NULL, 0, 'main', 0),
(19, 5, 2, 'settings/blocks', NULL, 'Общие блоки', 1, NULL, 'Общие блоки', NULL, NULL, 0, 'main', 0),
(20, 5, 3, 'settings/forms', NULL, 'Формы', 1, NULL, 'Формы', NULL, NULL, 0, 'main', 0),
(21, 6, 1, 'users/add-user', NULL, 'Добавить пользователя', 0, NULL, 'Добавить пользователя', NULL, NULL, 0, 'form', 0),
(22, 6, 2, 'users/edit-user', NULL, 'Редактировать пользователя', 0, NULL, 'Редактировать пользователя', NULL, NULL, 0, 'form', 0),
(23, 0, 7, 'confirm-registration', NULL, 'Подтверждение регистрации', 0, NULL, 'Подтверждение регистрации', NULL, NULL, 0, 'sequrity', 1),
(24, 0, 8, 'password-recovery', NULL, 'Восстановление пароля', 0, NULL, 'Восстановление пароля', NULL, NULL, 0, 'sequrity', 0),
(25, 12, 1, 'shop/catalog/add-category', NULL, 'Добавление категории', 0, NULL, 'Добавление категории', NULL, NULL, 0, 'form', 0),
(26, 12, 2, 'shop/catalog/edit-category', NULL, 'Редактирование категории', 0, NULL, 'Редактирование категории', NULL, NULL, 0, 'form', 0),
(27, 13, 1, 'shop/products/add-product', NULL, 'Добавление товара', 0, NULL, 'Добавление товара', NULL, NULL, 0, 'form', 0),
(28, 13, 2, 'shop/products/edit-product', NULL, 'Редактирование товара', 0, NULL, 'Редактирование товара', NULL, NULL, 0, 'form', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `as_lk_users`
--

CREATE TABLE `as_lk_users` (
  `id` int(11) NOT NULL,
  `temp_id` int(11) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `fam` varchar(255) DEFAULT NULL,
  `patronymic` varchar(255) DEFAULT NULL,
  `mail` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `login` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `user_ip` varchar(45) DEFAULT NULL,
  `active` tinyint(4) DEFAULT NULL,
  `hash` varchar(255) DEFAULT NULL,
  `as_lk_users_type_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `as_lk_users`
--

INSERT INTO `as_lk_users` (`id`, `temp_id`, `parent_id`, `name`, `fam`, `patronymic`, `mail`, `phone`, `login`, `password`, `user_ip`, `active`, `hash`, `as_lk_users_type_id`) VALUES
(1, 1536244015, 0, 'Александр', 'Дулебский', 'Владимирович', 'dulebsky@gmail.com', '+7(921)347-87-29', 'dulebsky@gmail.com', '52031d51980d79e1fa45231fd38444b7', '83.102.198.16', 1, NULL, 1),
(11, 1527838833, 1, 'Александр', 'Монтек', 'Владимирович', 'dulebsky@mail.ru', '+7(921)347-8729', 'dulebsky@mail.ru', '2ebfab12d0d216b25f069a645e6b8835', '83.102.135.147', 1, '', 1),
(12, 1536277021, 1, 'Сергей', 'Лащевский', '', 'ls999@yandex.ru', '+7(921)954-65-37', 'ls999@yandex.ru', 'c5df5582c7842fdc0b37d6b53aba9c87', '5.18.248.105', 1, '', 1),
(13, 1527860304, 12, 'Антон', 'Имамгелиев', '', 'blackqweenjok@yandex.ru', '+79522614076', 'blackqweenjok@yandex.ru', '610ea1d61c5c7316aacf0ab0c31a797d', '84.204.87.58', 1, '', 1),
(14, 1536219856, 1, 'Менеджер', 'Контент', '', 'rhea.ergin@gmail.com', '+79312325040', 'rhea.ergin@gmail.com', 'a098e59bf5e5eefc8285565ee3867f57', '88.201.167.26', 1, '', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `as_lk_users_type`
--

CREATE TABLE `as_lk_users_type` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `as_lk_users_type`
--

INSERT INTO `as_lk_users_type` (`id`, `name`) VALUES
(1, 'Администратор'),
(2, 'Редактор');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `as_access`
--
ALTER TABLE `as_access`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_as_access_as_content_idx` (`as_content_id`),
  ADD KEY `fk_as_access_as_lk_users_type1_idx` (`as_lk_users_type_id`);

--
-- Индексы таблицы `as_content`
--
ALTER TABLE `as_content`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `as_lk_users`
--
ALTER TABLE `as_lk_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_as_lk_users_as_lk_users_type1_idx` (`as_lk_users_type_id`);

--
-- Индексы таблицы `as_lk_users_type`
--
ALTER TABLE `as_lk_users_type`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `as_access`
--
ALTER TABLE `as_access`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
--
-- AUTO_INCREMENT для таблицы `as_content`
--
ALTER TABLE `as_content`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT для таблицы `as_lk_users`
--
ALTER TABLE `as_lk_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `as_access`
--
ALTER TABLE `as_access`
  ADD CONSTRAINT `fk_as_access_as_content` FOREIGN KEY (`as_content_id`) REFERENCES `as_content` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_as_access_as_lk_users_type1` FOREIGN KEY (`as_lk_users_type_id`) REFERENCES `as_lk_users_type` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ограничения внешнего ключа таблицы `as_lk_users`
--
ALTER TABLE `as_lk_users`
  ADD CONSTRAINT `fk_as_lk_users_as_lk_users_type1` FOREIGN KEY (`as_lk_users_type_id`) REFERENCES `as_lk_users_type` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
