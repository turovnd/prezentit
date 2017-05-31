-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Июн 01 2017 г., 02:21
-- Версия сервера: 5.7.18-0ubuntu0.16.04.1
-- Версия PHP: 7.1.4-1+deb.sury.org~xenial+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `prezentit.beta`
--

-- --------------------------------------------------------

--
-- Структура таблицы `Presentations`
--

CREATE TABLE `Presentations` (
  `id` int(11) NOT NULL,
  `code` int(11) DEFAULT NULL,
  `name` varchar(256) NOT NULL,
  `slides_order` text NOT NULL,
  `owner` int(11) NOT NULL,
  `uri` varchar(128) DEFAULT NULL,
  `short_uri` varchar(32) DEFAULT NULL,
  `dt_update` datetime NOT NULL,
  `dt_create` datetime NOT NULL,
  `is_removed` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Структура таблицы `Slides`
--

CREATE TABLE `Slides` (
  `id` int(11) NOT NULL,
  `content_id` int(11) DEFAULT NULL,
  `type` int(11) NOT NULL COMMENT '1 - heading, 2 - image, 3 - paragraph, 4 - choices',
  `presentation` int(11) NOT NULL,
  `dt_create` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `Slides_Choices`
--

CREATE TABLE `Slides_Choices` (
  `id` int(11) NOT NULL,
  `heading` varchar(80) DEFAULT NULL COMMENT 'question',
  `image` text,
  `answers` text,
  `answers_with_image` int(11) NOT NULL DEFAULT '0' COMMENT '0 - false, 1 - true',
  `results_in_percents` tinyint(2) NOT NULL DEFAULT '0' COMMENT '0 - false, 1 - true'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `Slides_Heading`
--

CREATE TABLE `Slides_Heading` (
  `id` int(11) NOT NULL,
  `heading` varchar(90) DEFAULT NULL,
  `subheading` varchar(150) DEFAULT NULL,
  `image` text,
  `image_background` tinyint(2) NOT NULL DEFAULT '1' COMMENT '1 - light, 2 - dark',
  `reactions` text COMMENT '1 - like, 2 - question, 3 - thumbs up, 4 - thumbs down'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `Slides_Image`
--

CREATE TABLE `Slides_Image` (
  `id` int(11) NOT NULL,
  `heading` varchar(90) DEFAULT NULL,
  `image` text,
  `image_position` tinyint(2) NOT NULL DEFAULT '1' COMMENT '1 - in center, 2 - full screen',
  `reactions` text COMMENT '1 - like, 2 - question, 3 - thumbs up, 4 - thumbs down'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `Slides_Paragraph`
--

CREATE TABLE `Slides_Paragraph` (
  `id` int(11) NOT NULL,
  `heading` varchar(90) DEFAULT NULL,
  `paragraph` varchar(300) DEFAULT NULL,
  `image` text,
  `image_background` tinyint(2) NOT NULL DEFAULT '1' COMMENT '1 - light, 2 - dark',
  `reactions` tinyint(4) DEFAULT NULL COMMENT '1 - like, 2 - question, 3 - thumbs up, 4 - thumbs down'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `Subscribers`
--

CREATE TABLE `Subscribers` (
  `id` int(11) NOT NULL,
  `email` varchar(128) NOT NULL,
  `name` varchar(128) NOT NULL,
  `dt_create` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `Users`
--

CREATE TABLE `Users` (
  `id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `email` varchar(64) NOT NULL,
  `password` varchar(512) CHARACTER SET utf8 COLLATE utf8_general_mysql500_ci NOT NULL,
  `newsletter` int(11) DEFAULT '1',
  `is_confirmed` int(1) DEFAULT '0',
  `dt_create` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Структура таблицы `Users_Presentations`
--

CREATE TABLE `Users_Presentations` (
  `u_id` int(11) NOT NULL,
  `p_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `Presentations`
--
ALTER TABLE `Presentations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uri` (`uri`),
  ADD UNIQUE KEY `short_uri` (`short_uri`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Индексы таблицы `Slides`
--
ALTER TABLE `Slides`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`content_id`,`type`);

--
-- Индексы таблицы `Slides_Choices`
--
ALTER TABLE `Slides_Choices`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `Slides_Heading`
--
ALTER TABLE `Slides_Heading`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `Slides_Image`
--
ALTER TABLE `Slides_Image`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `Slides_Paragraph`
--
ALTER TABLE `Slides_Paragraph`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `Subscribers`
--
ALTER TABLE `Subscribers`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`),
  ADD KEY `email` (`email`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `Presentations`
--
ALTER TABLE `Presentations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `Slides`
--
ALTER TABLE `Slides`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `Slides_Choices`
--
ALTER TABLE `Slides_Choices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `Slides_Heading`
--
ALTER TABLE `Slides_Heading`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `Slides_Image`
--
ALTER TABLE `Slides_Image`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `Slides_Paragraph`
--
ALTER TABLE `Slides_Paragraph`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `Subscribers`
--
ALTER TABLE `Subscribers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `Users`
--
ALTER TABLE `Users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
