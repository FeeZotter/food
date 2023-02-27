-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 27. Feb 2023 um 19:28
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
('birds'),
('books'),
('colors'),
('consoles'),
('food'),
('games'),
('series'),
('websites');

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
(8, 'Emma', 'food'),
(14, 'feezotter', 'birds'),
(6, 'feezotter', 'colors'),
(13, 'feezotter', 'consoles'),
(2, 'feezotter', 'food'),
(34, 'feezotter', 'games'),
(23, 'feezotter', 'websites'),
(10, 'MyBot1', 'birds');

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
('agweh eaöoj', '708ce22c7470b66148653771701f9ccc7461ad252342a95b1d2de160acf98087', 'anwerhn', '9E5h1OCnW6b88GGqVr1VV3n5Z5G5j1xc'),
('agweh mao', 'c977589431bbc5a8038de7b5376ae5715f0d0c34394b772cf3b8a90a9c546014', 'anwerhnahr', '9E5h1OCnW6b88GGqVr1VV3n5Z5G5j1xc'),
('Betha', 'c977589431bbc5a8038de7b5376ae5715f0d0c34394b772cf3b8a90a9c546014', 'Betha', '9E5h1OCnW6b88GGqVr1VV3n5Z5G5j1xc'),
('Emma', '', 'EMMArmelade', NULL),
('feezotter', 'c977589431bbc5a8038de7b5376ae5715f0d0c34394b772cf3b8a90a9c546014', 'Fee', '2xt1O6jYSJTM6HCma6ScLtl2CtKUDCaA'),
('Kowalski', '772bc1c40992828057bba4710e54ed702bab41851186239a0fc69c2aeb63b457', 'Kowalski', '9E5h1OCnW6b88GGqVr1VV3n5Z5G5j1xc'),
('Kowalski3qwt', '3b507bf9b5bd7d4146227bbea4378ca96a3f0181ec7e5c3a1662892ae78c29b6', 'Kowalskiqz26', '9E5h1OCnW6b88GGqVr1VV3n5Z5G5j1xc'),
('Mavis', '4e618f5528c078762f39ffdad147fe65aa820171ab2455a8511151db87602b43', 'Mavis', '9E5h1OCnW6b88GGqVr1VV3n5Z5G5j1xc'),
('MyBot', 'c977589431bbc5a8038de7b5376ae5715f0d0c34394b772cf3b8a90a9c546014', 'MyBot', '9E5h1OCnW6b88GGqVr1VV3n5Z5G5j1xc'),
('MyBot1', 'c977589431bbc5a8038de7b5376ae5715f0d0c34394b772cf3b8a90a9c546014', 'MyBot1', '9E5h1OCnW6b88GGqVr1VV3n5Z5G5j1xc'),
('MyBot10', 'c977589431bbc5a8038de7b5376ae5715f0d0c34394b772cf3b8a90a9c546014', 'MyBot10', '9E5h1OCnW6b88GGqVr1VV3n5Z5G5j1xc'),
('MyBot11', 'c977589431bbc5a8038de7b5376ae5715f0d0c34394b772cf3b8a90a9c546014', 'MyBot11', '9E5h1OCnW6b88GGqVr1VV3n5Z5G5j1xc'),
('MyBot12', 'c977589431bbc5a8038de7b5376ae5715f0d0c34394b772cf3b8a90a9c546014', 'MyBot13', '9E5h1OCnW6b88GGqVr1VV3n5Z5G5j1xc'),
('MyBot14', 'c977589431bbc5a8038de7b5376ae5715f0d0c34394b772cf3b8a90a9c546014', 'MyBot14', '9E5h1OCnW6b88GGqVr1VV3n5Z5G5j1xc'),
('MyBot15', '1a38a696423ef8697566bdd105d7c7904bf2e114fad443e3cd6f2eb7d75e51c5', 'MyBot15', '9E5h1OCnW6b88GGqVr1VV3n5Z5G5j1xc'),
('MyBot16', 'c977589431bbc5a8038de7b5376ae5715f0d0c34394b772cf3b8a90a9c546014', 'MyBot16', '9E5h1OCnW6b88GGqVr1VV3n5Z5G5j1xc'),
('MyBot17', 'c977589431bbc5a8038de7b5376ae5715f0d0c34394b772cf3b8a90a9c546014', 'MyBot17', '9E5h1OCnW6b88GGqVr1VV3n5Z5G5j1xc'),
('MyBot18', '51f8fd67be1a2f30fd9fc1709e5b9d7c96430f8a62f0aefeda25912f93abee88', 'MyBot18', '9E5h1OCnW6b88GGqVr1VV3n5Z5G5j1xc'),
('MyBot19', '9d4f28c5803b4596b4903b90a9dfbdff0d5d74dac004dd03b7801d003641ca22', 'MyBot19', '9E5h1OCnW6b88GGqVr1VV3n5Z5G5j1xc'),
('MyBot2', 'c977589431bbc5a8038de7b5376ae5715f0d0c34394b772cf3b8a90a9c546014', 'MyBot2', '9E5h1OCnW6b88GGqVr1VV3n5Z5G5j1xc'),
('MyBot20', '209eeb77cdaf18fdc71f330a07630e65b8f95de110dffac3cf8cf26c06be7d9b', 'MyBot20', '9E5h1OCnW6b88GGqVr1VV3n5Z5G5j1xc'),
('MyBot21', '4ed473194a1908bba3299fe85c1c6045f97bef763714e4514de9cdbbdb08b3ce', 'MyBot21', '9E5h1OCnW6b88GGqVr1VV3n5Z5G5j1xc'),
('MyBot22', 'c5d46e7772b7be1c8a75f1b4b4ecacd4453d0edaccb0cb806ff893cb1c0b5e97', 'MyBot22', '9E5h1OCnW6b88GGqVr1VV3n5Z5G5j1xc'),
('MyBot23', '0068c048039cd4e213f20a19d9743cab1f82437716fe159f7263209494a98989', 'MyBot23', '9E5h1OCnW6b88GGqVr1VV3n5Z5G5j1xc'),
('MyBot24', 'de7524e6dc81d79106205ed4d1bfbdd84912810f812c0baeba852fe268232e0c', 'MyBot24', '9E5h1OCnW6b88GGqVr1VV3n5Z5G5j1xc'),
('MyBot25', 'f72d72ed8302c8f43e13d0817dadc6fbe35de82516dbd71cab87108c09794c31', 'MyBot25', '9E5h1OCnW6b88GGqVr1VV3n5Z5G5j1xc'),
('MyBot3', 'c7e615903d68525622372335b1f380d37283addcf9bdf9c9c9d9153f1dc72b6b', 'MyBot3', '9E5h1OCnW6b88GGqVr1VV3n5Z5G5j1xc'),
('MyBot4', 'c977589431bbc5a8038de7b5376ae5715f0d0c34394b772cf3b8a90a9c546014', 'MyBot4', '9E5h1OCnW6b88GGqVr1VV3n5Z5G5j1xc'),
('MyBot5', 'e8845c55d406a82aecb640995a0a55aa2110afba16d7efee25f1d0b21a2175a7', 'MyBot5', '9E5h1OCnW6b88GGqVr1VV3n5Z5G5j1xc'),
('MyBot6', 'c7e615903d68525622372335b1f380d37283addcf9bdf9c9c9d9153f1dc72b6b', 'MyBot6', '9E5h1OCnW6b88GGqVr1VV3n5Z5G5j1xc'),
('MyBot7', 'fd56110421a32050004623c12b05db6a7327883dd419e658b35b01c6e956656d', 'MyBot7', '9E5h1OCnW6b88GGqVr1VV3n5Z5G5j1xc'),
('MyBot8', 'c977589431bbc5a8038de7b5376ae5715f0d0c34394b772cf3b8a90a9c546014', 'MyBot8', '9E5h1OCnW6b88GGqVr1VV3n5Z5G5j1xc'),
('MyBot9', 'c977589431bbc5a8038de7b5376ae5715f0d0c34394b772cf3b8a90a9c546014', 'MyBot9', '9E5h1OCnW6b88GGqVr1VV3n5Z5G5j1xc'),
('mysupername', '2b4d5cdd185dd5df9fc80878efd5706450ef3b6da1aa412fe1e6ddcabdb3cfaa', 'mysupername', 'KJ8ADkY3MflWQFwXBFW9ExiNheV0TUH0');

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
(77, 2, 'Wurst', 0, ''),
(78, 2, 'Quark', 4, ''),
(79, 2, 'Kimchi', 7, ''),
(80, 2, 'Sushi', 7, ''),
(81, 2, 'Indisch', 9, ''),
(82, 2, 'Bathura', 10, ''),
(83, 14, 'duck', 10, ''),
(84, 2, 'Rettich', 3, ''),
(89, 2, 'Soßen', 1, ''),
(93, 14, 'pigeon', 10, ''),
(94, 14, 'geese', 10, ''),
(99, 34, 'suffering', 0, '');

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
('9E5h1OCnW6b88GGqVr1VV3n5Z5G5j1xc', 50),
('KJ8ADkY3MflWQFwXBFW9ExiNheV0TUH0', 1),
('Xv8msTJY14EXntEjrrejVzIkKOakVnWo', 2),
('zlZDdMGeqYAZfZrHnTQ7P6QXKdZoT1Ot', 4);

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
  MODIFY `cross_person_categories_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT für Tabelle `preferences`
--
ALTER TABLE `preferences`
  MODIFY `preferences_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `cross_person_categories`
--
ALTER TABLE `cross_person_categories`
  ADD CONSTRAINT `cross_person_categories_ibfk_1` FOREIGN KEY (`categories_id`) REFERENCES `categories` (`category`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cross_person_categories_ibfk_2` FOREIGN KEY (`persons_id`) REFERENCES `persons` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

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
