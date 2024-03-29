-- MYSQL
-- version 8.0.36
-- Время создания: Мар 30 2024 г., 01:14
-- Версия сервера: 8.0.36
-- Версия PHP: 8.1.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


-- База данных: `API_v3`

CREATE TABLE `category` (
  `project` int NOT NULL,
  `skill` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `projects` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '',
  `link` varchar(255) NOT NULL DEFAULT '',
  `status` int NOT NULL,
  `budget` int NOT NULL DEFAULT '0',
  `employer_login` varchar(255) NOT NULL DEFAULT '',
  `employer_first_name` varchar(255) NOT NULL DEFAULT '',
  `employer_last_name` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `skills` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


CREATE TABLE `status` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `status` (`id`, `name`) VALUES
(11, 'Відкрито для пропозицій'),
(12, 'Резервування у очікуванні оплати'),
(13, 'Підрядник вибраний'),
(14, 'Проект продовжується'),
(15, 'Проект у арбітражі'),
(21, 'Проект завершено'),
(22, 'Закрито без завершення'),
(23, 'Термін дії проекту минув'),
(24, 'Правила порушено'),
(25, 'Проект не завершено'),
(26, 'Проект неоплачений'),
(27, 'Закрито без розгляду'),
(32, 'Заблоковано користувачами'),
(33, 'Закрито модератором'),
(34, 'Закрито через бюджет');

ALTER TABLE `category`
  ADD PRIMARY KEY (`project`,`skill`),
  ADD KEY `FK_skill` (`skill`),
  ADD KEY `FK_project` (`project`);

ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_status` (`status`);

ALTER TABLE `skills`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `status`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `category`
  ADD CONSTRAINT `FK_project` FOREIGN KEY (`project`) REFERENCES `projects` (`id`),
  ADD CONSTRAINT `FK_skill` FOREIGN KEY (`skill`) REFERENCES `skills` (`id`);

ALTER TABLE `projects`
  ADD CONSTRAINT `FK_status` FOREIGN KEY (`status`) REFERENCES `status` (`id`);
COMMIT;

