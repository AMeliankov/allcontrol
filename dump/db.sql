-- phpMyAdmin SQL Dump
-- version 4.9.4
-- https://www.phpmyadmin.net/
--
-- Хост: 10.0.0.143:3306
-- Время создания: Июн 02 2020 г., 13:38
-- Версия сервера: 10.2.32-MariaDB-log
-- Версия PHP: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `allcontrol`
--

-- --------------------------------------------------------

--
-- Структура таблицы `info`
--

CREATE TABLE `info` (
  `i_id` int(11) NOT NULL,
  `worker` int(11) NOT NULL,
  `start` datetime NOT NULL,
  `finish` datetime DEFAULT NULL,
  `flag` int(100) NOT NULL,
  `time` int(100) DEFAULT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Структура таблицы `money`
--

CREATE TABLE `money` (
  `m_id` int(11) NOT NULL,
  `worker` int(100) NOT NULL,
  `date` date NOT NULL,
  `type` varchar(100) NOT NULL,
  `sum` int(100) NOT NULL,
  `payout` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Структура таблицы `profession`
--

CREATE TABLE `profession` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `profession`
--

INSERT INTO `profession` (`id`, `name`) VALUES
(1, 'Сотрудник ИТР'),
(2, 'Монолитчик'),
(3, 'Каменщик'),
(4, 'Монтажник'),
(5, 'Разнорабочий'),
(6, 'Специалист'),
(7, 'Электрик'),
(8, 'Сварщик');

-- --------------------------------------------------------

--
-- Структура таблицы `role`
--

CREATE TABLE `role` (
  `r_id` int(11) NOT NULL,
  `r_role` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `role`
--

INSERT INTO `role` (`r_id`, `r_role`) VALUES
(1, 'admin'),
(3, 'moderator'),
(2, 'security'),
(4, 'view');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `u_id` int(11) NOT NULL,
  `login` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `role` int(100) NOT NULL,
  `status` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`u_id`, `login`, `password`, `name`, `role`, `status`) VALUES
(1, 'admin', '$2y$10$tKtg5ONLfNpiZKvRwQfel.3J2I8C0eL6g0bamaR6vAdra.G8S2cKy', 'Администратор', 1, 1),
(2, 'moderator', '$2y$10$lj8Yu69kJh5KJKLSscHUieTyJJs1oqR6YLGV6lZiF8AIILNpo.jFy', 'Модератор', 2, 1),
(3, 'security', '$2y$10$6eRlq3J4cZoqSH51Qt25Zehhx5mbQ23YPA9iVvoIe1S5lSQ3OLrHC', 'Охрана', 3, 1),
(4, 'view', '$2y$10$uRt/ngwzDq3abPXSCmCRbO544PV.fiD5TYohZGSFoHZo7/jgYTnnO', 'Просмотр', 4, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `workers`
--

CREATE TABLE `workers` (
  `w_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `surname` varchar(100) DEFAULT NULL,
  `father` varchar(100) NOT NULL,
  `code` varchar(100) NOT NULL,
  `commander` varchar(100) NOT NULL,
  `profession` int(100) NOT NULL,
  `smena` varchar(100) NOT NULL,
  `phone` varchar(100) DEFAULT NULL,
  `status` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `workers`
--

INSERT INTO `workers` (`w_id`, `name`, `surname`, `father`, `code`, `commander`, `profession`, `smena`, `phone`, `status`) VALUES
(1, 'Сергей', 'Иванов', 'Анатольевич', '9186222725245', '0', 1, 'Дневная', '+7 (456) 546-45-64', 1),
(2, 'Егор', 'Николаев', 'Николаевич', '8005543837710', '1', 8, 'Дневная', '+7 (546) 546-54-64', 1),
(3, 'Петр', 'Петров', 'Плегович', '1285146472906', '1', 6, 'Ночная', '+7 (345) 367-87-90', 1);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `info`
--
ALTER TABLE `info`
  ADD PRIMARY KEY (`i_id`),
  ADD KEY `worker` (`worker`);

--
-- Индексы таблицы `money`
--
ALTER TABLE `money`
  ADD PRIMARY KEY (`m_id`),
  ADD KEY `money_ibfk_1` (`worker`);

--
-- Индексы таблицы `profession`
--
ALTER TABLE `profession`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`r_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`u_id`),
  ADD KEY `role` (`role`);

--
-- Индексы таблицы `workers`
--
ALTER TABLE `workers`
  ADD PRIMARY KEY (`w_id`),
  ADD KEY `w_profession` (`profession`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `info`
--
ALTER TABLE `info`
  MODIFY `i_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=218;

--
-- AUTO_INCREMENT для таблицы `money`
--
ALTER TABLE `money`
  MODIFY `m_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=115;

--
-- AUTO_INCREMENT для таблицы `profession`
--
ALTER TABLE `profession`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT для таблицы `role`
--
ALTER TABLE `role`
  MODIFY `r_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `u_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT для таблицы `workers`
--
ALTER TABLE `workers`
  MODIFY `w_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=287;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `info`
--
ALTER TABLE `info`
  ADD CONSTRAINT `info_ibfk_1` FOREIGN KEY (`worker`) REFERENCES `workers` (`w_id`);

--
-- Ограничения внешнего ключа таблицы `money`
--
ALTER TABLE `money`
  ADD CONSTRAINT `money_ibfk_1` FOREIGN KEY (`worker`) REFERENCES `workers` (`w_id`);

--
-- Ограничения внешнего ключа таблицы `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role`) REFERENCES `role` (`r_id`);

--
-- Ограничения внешнего ключа таблицы `workers`
--
ALTER TABLE `workers`
  ADD CONSTRAINT `workers_ibfk_1` FOREIGN KEY (`profession`) REFERENCES `profession` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
