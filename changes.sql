-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Апр 30 2020 г., 10:28
-- Версия сервера: 5.7.25-log
-- Версия PHP: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `test2-fact`
--

-- --------------------------------------------------------

--
-- Структура таблицы `changes`
--

CREATE TABLE `changes` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `type` varchar(60) NOT NULL,
  `count` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `changes`
--

INSERT INTO `changes` (`id`, `date`, `type`, `count`) VALUES
(1, '2020-04-28', 'delete', 2),
(2, '2020-04-28', 'add', 1),
(3, '2020-04-29', 'delete', 1),
(4, '2020-04-29', 'add', 1),
(5, '2020-04-30', 'delete', 3);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `changes`
--
ALTER TABLE `changes`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `changes`
--
ALTER TABLE `changes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
