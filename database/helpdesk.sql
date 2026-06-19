-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Cze 19, 2026 at 07:46 PM
-- Wersja serwera: 10.4.32-MariaDB
-- Wersja PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `helpdesk`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `tickets`
--

CREATE TABLE `tickets` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `assigned_to` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `status` enum('nowe','w_toku','wstrzymane','zamknięte') NOT NULL,
  `priority` enum('niski','średni','wysoki','') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`id`, `user_id`, `assigned_to`, `title`, `description`, `status`, `priority`, `created_at`) VALUES
(2, 2, 0, 'Test 2', 'lorem ipsum dolor sit amet', 'wstrzymane', 'niski', '2026-05-18 15:04:06'),
(3, 1, 0, 'tytuł', 'opisss', 'nowe', 'niski', '2026-05-22 16:27:33'),
(4, 1, 0, 'tytuł', 'opis', 'nowe', '', '2026-05-22 16:35:28'),
(5, 1, 0, 'zgłoszenie 1234', 'test test test', 'nowe', 'niski', '2026-05-22 16:36:10'),
(6, 1, 0, 'zgłoszenie 1234', 'test test test', 'nowe', 'niski', '2026-05-22 16:39:37'),
(7, 1, 0, 'zgłoszenie 1234', 'test test test', 'nowe', 'niski', '2026-05-22 16:39:53'),
(8, 1, 0, 'zgłoszenie 1234', 'test test test', 'nowe', 'niski', '2026-05-22 16:40:36'),
(9, 1, 0, 'zgłoszenie 1234', 'test test test', 'nowe', 'niski', '2026-05-22 16:49:44'),
(10, 1, 0, 'sdf1', 'asdf', 'nowe', 'niski', '2026-05-22 16:49:55'),
(11, 16, 0, 'user zgłoszenie', 'Opis zgłoszenia.', 'nowe', 'niski', '2026-06-18 15:28:53'),
(12, 18, 0, 'Support zgłoszenie', 'Przykładowy opis zgłoszenia', 'nowe', '', '2026-06-18 15:29:52'),
(13, 17, 0, 'asdf', 'asdf', 'wstrzymane', 'wysoki', '2026-06-19 14:41:50'),
(14, 17, 0, 'dddddd', 'dddddd', 'nowe', 'wysoki', '2026-06-19 14:47:25'),
(15, 17, 0, 'A', 'A', 'nowe', 'wysoki', '2026-06-19 15:35:28'),
(16, 17, 0, 'a', 'a', 'wstrzymane', 'niski', '2026-06-19 15:35:32');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `login` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(20) NOT NULL,
  `role` enum('user','support','admin','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `login`, `password`, `email`, `role`) VALUES
(16, 'user', '$2y$10$Y/q1jJ.HQ3Ir4k54yxmRBe1R3pvr5lmYUDKbMVKG2sLwjxkM.DfFS', 'user', 'user'),
(17, 'admin', '$2y$10$zpFuDvmfqZT952WoYmYLkO0AuFSt541D.yNo7t/.FO.AKfj3Ir0O6', 'admin', 'admin'),
(18, 'support', '$2y$10$7cNGKSW.hA03gOWfxZ0afu7dEIEIBJKMt2DKYG6xGBwvNpe.i0gRC', 'support@email.com', 'support'),
(20, 'test', '$2y$10$qO8eC1ltNbiL7Pu4MAY5s.ZC5vQDO0XnVu5g6xbc6zzLxOEYUnR3G', 'test', 'user');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
