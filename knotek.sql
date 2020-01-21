-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Počítač: 127.0.0.1
-- Vytvořeno: Úte 21. led 2020, 15:11
-- Verze serveru: 10.4.11-MariaDB
-- Verze PHP: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáze: `knotek`
--
CREATE DATABASE IF NOT EXISTS `knotek` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `knotek`;

-- --------------------------------------------------------

--
-- Struktura tabulky `akce`
--

CREATE TABLE `akce` (
  `id` int(10) UNSIGNED NOT NULL,
  `ucitel` int(10) UNSIGNED DEFAULT NULL,
  `nazev` varchar(50) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `popis` text CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `datum` date NOT NULL,
  `typ` int(11) DEFAULT NULL,
  `zaci` int(11) DEFAULT NULL,
  `dvpp` set('ano','ne') NOT NULL,
  `msmt` set('ano','ne') NOT NULL,
  `poradatel` varchar(200) DEFAULT NULL,
  `vyukove_hodiny` int(11) NOT NULL,
  `file` blob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Vypisuji data pro tabulku `akce`
--

INSERT INTO `akce` (`id`, `ucitel`, `nazev`, `popis`, `datum`, `typ`, `zaci`, `dvpp`, `msmt`, `poradatel`, `vyukove_hodiny`, `file`) VALUES
(1, 7, 'vylet na praded', '<p>lorem ipsum jashfajk w jwej jewfwoevj weovw</p>', '2018-12-21', 1, 11, 'ne', 'ano', 'poradatel takovy', 24, 0x2f75706c6f616473617364662e68746d6c),
(2, 7, 'patlamatla', 'sadfasdfsafs sad sf sf dsf dsf ds dsf fd sfddsf ', '2019-09-18', 2, 25, 'ano', 'ne', 'takovy poradatel', 35, NULL),
(3, 2, 'Pokus', 'gfhgfhgfhgf', '2019-12-04', 1, 5, 'ne', 'ano', 'dfgdfsgdf', 5, NULL),
(4, 2, 'nazev', '<p>asdf</p>', '2019-12-18', 1, 3, 'ne', 'ano', 'sro', 50, 0x2f75706c6f616473312e6a7067);

-- --------------------------------------------------------

--
-- Struktura tabulky `typ`
--

CREATE TABLE `typ` (
  `id` int(10) UNSIGNED NOT NULL,
  `typ` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Vypisuji data pro tabulku `typ`
--

INSERT INTO `typ` (`id`, `typ`) VALUES
(1, 'exkurze'),
(2, 'výlet');

-- --------------------------------------------------------

--
-- Struktura tabulky `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(30) COLLATE utf8_czech_ci NOT NULL,
  `password` char(128) COLLATE utf8_czech_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_czech_ci DEFAULT NULL,
  `role` enum('ucitel','admin') COLLATE utf8_czech_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Vypisuji data pro tabulku `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `role`) VALUES
(2, 'lucny', '$2y$10$.pcmcSteg.ZMo8toN50q0eDmknZU09Vq5k4XIlWgsgsBGvyZdTsqm', NULL, 'ucitel'),
(4, 'ucitelsky', '$2y$10$OIPihnpusO9ozJXGmlqxHeAlz1bIqrw3ZOQc6bOjw/LtN4VC4NZV2', NULL, 'ucitel'),
(7, 'student', '$2y$10$ckH0QtMjfWOqLgQGEouayOlC7bgav/Y.9rYnBjneIKMTYfznfX2mG', 'student@email.cz', 'ucitel'),
(8, 'administrator', '$2y$10$H9hG0txy9ISgnS12eeS82.bmCEcw0cQVnonw8Rs5prv2i0uP7pZ2y', 'admin@cesko.cz', 'ucitel');

--
-- Klíče pro exportované tabulky
--

--
-- Klíče pro tabulku `akce`
--
ALTER TABLE `akce`
  ADD PRIMARY KEY (`id`);

--
-- Klíče pro tabulku `typ`
--
ALTER TABLE `typ`
  ADD PRIMARY KEY (`id`);

--
-- Klíče pro tabulku `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pro tabulky
--

--
-- AUTO_INCREMENT pro tabulku `akce`
--
ALTER TABLE `akce`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pro tabulku `typ`
--
ALTER TABLE `typ`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pro tabulku `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
