-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 26. Nov 2022 um 12:11
-- Server-Version: 10.4.25-MariaDB
-- PHP-Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `mypreferences`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `categories`
--

CREATE TABLE `categories` (
  `category` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `categories`
--

INSERT INTO `categories` (`category`) VALUES
('essen'),
('farbe'),
('spiele');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `cross_person_categories`
--

CREATE TABLE `cross_person_categories` (
  `cross_person_categories_id` int(11) NOT NULL,
  `persons_id` varchar(20) NOT NULL,
  `categories_id` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `cross_person_categories`
--

INSERT INTO `cross_person_categories` (`cross_person_categories_id`, `persons_id`, `categories_id`) VALUES
(8, 'Emma', 'essen'),
(2, 'feezotter', 'essen'),
(6, 'feezotter', 'farbe'),
(7, 'feezotter', 'spiele'),
(3, 'Theodore', 'essen'),
(4, 'Theodore', 'farbe');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `persons`
--

CREATE TABLE `persons` (
  `name` varchar(20) NOT NULL,
  `pasword` varchar(512) NOT NULL,
  `alias` varchar(20) NOT NULL,
  `product_key` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `persons`
--

INSERT INTO `persons` (`name`, `pasword`, `alias`, `product_key`) VALUES
('42asdf', '', 'Amanda', NULL),
('aBird', '', 'PiepYou', NULL),
('asdf', '', 'Programmer420', NULL),
('Emma', '', 'EMMArmelade', NULL),
('feezotter', 'asdf', 'Fee', '2xt1O6jYSJTM6HCma6ScLtl2CtKUDCaA'),
('LalaTheBest', '', '__Lala__', NULL),
('Liamasdf', '', 'Liam', NULL),
('Lissa64', '', 'Lissa', NULL),
('MariaDB', '', 'Maria', NULL),
('MinecraftSteve', '', 'Steevie', NULL),
('NoahAndTheArc', '', 'Noah', NULL),
('OlivesBest', '', 'Olivia', NULL),
('OtttoVonMond', '', 'Ottto', NULL),
('Theodore', '123456', 'Theo', NULL);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `preferences`
--

CREATE TABLE `preferences` (
  `preferences_id` int(11) NOT NULL,
  `cross_person_categories_id` int(11) NOT NULL,
  `preference` varchar(20) NOT NULL,
  `rating` int(5) NOT NULL,
  `subkategorie` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `preferences`
--

INSERT INTO `preferences` (`preferences_id`, `cross_person_categories_id`, `preference`, `rating`, `subkategorie`) VALUES
(2, 2, 'Brot', 8, ''),
(3, 2, 'Pudding', 9, 'Milch'),
(4, 2, 'Oliven', 0, ''),
(5, 3, 'Oliven', 10, ''),
(6, 3, 'Kekse', 3, ''),
(7, 4, 'blau', 8, ''),
(8, 4, 'orange', 3, ''),
(9, 2, 'Butterkekse', 6, ''),
(10, 2, 'Honigbrot', 8, ''),
(11, 6, 'Blau', 7, ''),
(12, 6, 'Grün', 8, ''),
(13, 6, 'Türkis', 6, ''),
(14, 6, 'Orange', 2, ''),
(15, 6, 'Gelb', 3, ''),
(16, 6, 'Magenta', 7, ''),
(17, 6, 'Rosa', 8, ''),
(18, 6, 'Rot', 9, ''),
(19, 6, 'Hellblau', 9, ''),
(20, 6, 'Braun', 5, ''),
(21, 6, 'Braunrot', 10, ''),
(22, 8, 'Oliven', 5, ''),
(43, 8, 'Butterbrot', 2, ''),
(44, 8, 'Kekse', 8, ''),
(45, 8, 'Rettich', 8, ''),
(46, 8, 'Kaffee', 4, ''),
(47, 8, 'Dosensuppe', 10, ''),
(48, 8, 'Petersilie', 0, ''),
(49, 8, 'Karotten', 10, ''),
(50, 8, 'Möhren', 0, ''),
(51, 8, 'Ente', 5, ''),
(52, 8, 'Sushi', 4, ''),
(53, 8, 'Porree', 3, ''),
(54, 8, 'Kartoffelsalat', 9, ''),
(55, 8, 'Döner', 10, ''),
(56, 8, 'Apfel', 2, ''),
(57, 8, 'Orange', 1, ''),
(58, 8, 'Donut', 7, ''),
(59, 8, 'Joguhrt', 3, ''),
(60, 8, 'Marmelade', 4, ''),
(61, 8, 'Ofenkartoffel', 7, ''),
(62, 8, 'Zwiebel', 6, ''),
(63, 2, 'Banane', 6, ''),
(64, 2, 'Rettich', 4, ''),
(65, 2, 'Fleisch', 0, ''),
(66, 2, 'Fisch', 0, ''),
(67, 2, 'Orangensaft', 8, ''),
(68, 2, 'Zitronen', 9, ''),
(69, 2, 'Apfel', 9, ''),
(70, 2, 'Ei', 3, ''),
(71, 2, 'Pfannkuchen', 10, ''),
(72, 2, 'Kartoffel', 9, ''),
(73, 2, 'Möhre', 7, ''),
(74, 2, 'Honig', 8, ''),
(75, 2, 'Tomate', 2, ''),
(76, 2, 'Soßen', 2, ''),
(77, 2, 'Wurst', 0, ''),
(78, 2, 'Quark', 4, ''),
(79, 2, 'Kimchi', 7, ''),
(80, 2, 'Sushi', 7, ''),
(81, 2, 'Indisch', 9, ''),
(82, 2, 'Bathura', 10, '');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `product_keys`
--

CREATE TABLE `product_keys` (
  `product_key` varchar(32) NOT NULL,
  `max_users` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `product_keys`
--

INSERT INTO `product_keys` (`product_key`, `max_users`) VALUES
('2xt1O6jYSJTM6HCma6ScLtl2CtKUDCaA', 5),
('Xv8msTJY14EXntEjrrejVzIkKOakVnWo', 2),
('zlZDdMGeqYAZfZrHnTQ7P6QXKdZoT1O', 4);

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category`) USING BTREE;

--
-- Indizes für die Tabelle `cross_person_categories`
--
ALTER TABLE `cross_person_categories`
  ADD PRIMARY KEY (`cross_person_categories_id`),
  ADD UNIQUE KEY `persons_id` (`persons_id`,`categories_id`) USING BTREE,
  ADD KEY `categories_id` (`categories_id`);

--
-- Indizes für die Tabelle `persons`
--
ALTER TABLE `persons`
  ADD PRIMARY KEY (`name`) USING BTREE,
  ADD UNIQUE KEY `alias` (`alias`),
  ADD KEY `product_key` (`product_key`);

--
-- Indizes für die Tabelle `preferences`
--
ALTER TABLE `preferences`
  ADD PRIMARY KEY (`preferences_id`),
  ADD KEY `preferences_ibfk_1` (`cross_person_categories_id`);

--
-- Indizes für die Tabelle `product_keys`
--
ALTER TABLE `product_keys`
  ADD PRIMARY KEY (`product_key`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `cross_person_categories`
--
ALTER TABLE `cross_person_categories`
  MODIFY `cross_person_categories_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT für Tabelle `preferences`
--
ALTER TABLE `preferences`
  MODIFY `preferences_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `cross_person_categories`
--
ALTER TABLE `cross_person_categories`
  ADD CONSTRAINT `cross_person_categories_ibfk_1` FOREIGN KEY (`categories_id`) REFERENCES `categories` (`category`) ON UPDATE CASCADE,
  ADD CONSTRAINT `cross_person_categories_ibfk_2` FOREIGN KEY (`persons_id`) REFERENCES `persons` (`name`) ON UPDATE CASCADE;

--
-- Constraints der Tabelle `persons`
--
ALTER TABLE `persons`
  ADD CONSTRAINT `persons_ibfk_1` FOREIGN KEY (`product_key`) REFERENCES `product_keys` (`product_key`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `preferences`
--
ALTER TABLE `preferences`
  ADD CONSTRAINT `preferences_ibfk_1` FOREIGN KEY (`cross_person_categories_id`) REFERENCES `cross_person_categories` (`cross_person_categories_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
