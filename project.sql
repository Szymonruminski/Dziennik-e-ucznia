-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 22 Sty 2022, 19:10
-- Wersja serwera: 10.4.14-MariaDB
-- Wersja PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `project`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `id_meeting` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=Active, 0=Block'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Zrzut danych tabeli `events`
--

INSERT INTO `events` (`id`, `id_meeting`, `title`, `date`, `created`, `modified`, `status`) VALUES
(0, 8, 'matematyka', '2022-01-20', '2022-01-22 00:05:27', '2022-01-22 00:05:27', 1),
(0, 9, 'Matematyka', '2022-01-19', '2022-01-22 00:06:26', '2022-01-22 00:06:26', 1),
(0, 10, 'polski', '2024-09-12', '2022-01-22 13:50:31', '2022-01-22 13:50:31', 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `frekwencja`
--

CREATE TABLE `frekwencja` (
  `id_obecności` int(11) NOT NULL,
  `nazwisko` varchar(33) NOT NULL,
  `data` date NOT NULL,
  `przedmiot` varchar(33) NOT NULL,
  `obecność` varchar(33) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

--
-- Zrzut danych tabeli `frekwencja`
--

INSERT INTO `frekwencja` (`id_obecności`, `nazwisko`, `data`, `przedmiot`, `obecność`) VALUES
(1, 'Kuszyński', '2022-01-21', 'matematyka', 'obecny'),
(2, 'Zieliński', '2022-01-21', 'matematyka', 'nieobecny'),
(3, 'Kubiak', '2022-01-21', 'matematyka', 'spóźniony'),
(4, 'Kuszyński', '2022-01-22', 'angielski', 'obecny'),
(9, 'Kuszyński', '2022-01-22', 'matematyka', 'obecny'),
(10, 'Kuszyński', '2022-01-22', 'wychowanie fizyczne', 'obecny'),
(11, 'Kubiak', '2022-01-22', 'matematyka', 'nieobecny'),
(12, 'Kuszyński', '2022-01-19', 'matematyka', 'nieobecny'),
(13, 'Kuszyński', '2022-01-30', 'matematyka', 'nieobecny');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `grades`
--

CREATE TABLE `grades` (
  `id_oceny` int(2) NOT NULL,
  `przedmiot` text NOT NULL,
  `ocena` int(1) NOT NULL,
  `id_ucznia` int(33) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `grades`
--

INSERT INTO `grades` (`id_oceny`, `przedmiot`, `ocena`, `id_ucznia`) VALUES
(1, 'angielski', 4, 1),
(2, 'wychowanie fizyczne', 5, 1),
(3, 'biologia', 2, 1),
(4, 'angielski', 4, 2),
(5, 'biologia', 4, 2),
(6, 'matematyka', 4, 2),
(7, 'matematyka', 4, 3),
(8, 'matematyka', 5, 2),
(9, 'matematyka', 5, 4),
(10, 'matematyka', 5, 1),
(11, 'matematyka', 2, 2),
(12, 'matematyka', 3, 3),
(13, 'matematyka', 4, 3),
(14, 'matematyka', 3, 11),
(15, 'angielski', 5, 3),
(16, 'wychowanie fizyczne', 5, 2),
(17, 'wychowanie fizyczne', 6, 3);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `messages`
--

CREATE TABLE `messages` (
  `id_wiadomosci` int(33) NOT NULL,
  `id_rodzica` int(3) NOT NULL,
  `nazwisko_r` varchar(33) NOT NULL,
  `id_nauczyciela` int(3) NOT NULL,
  `nazwisko_t` varchar(33) NOT NULL,
  `wiadomosc_t` varchar(255) DEFAULT '.',
  `wiadomosc_r` varchar(255) NOT NULL DEFAULT 'test',
  `data_wyslania` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `messages`
--

INSERT INTO `messages` (`id_wiadomosci`, `id_rodzica`, `nazwisko_r`, `id_nauczyciela`, `nazwisko_t`, `wiadomosc_t`, `wiadomosc_r`, `data_wyslania`) VALUES
(1, 2, 'Działowy', 1, 'Nowak', 'Tomaszu działowy to wiadomość tekstowa', '', '2022-01-22'),
(2, 2, 'Działowy', 1, 'Nowak', '', 'dziękuję za wiadomość', '2022-01-22'),
(3, 1, 'Wiśniewski', 1, 'Nowak', 'Fajnie że odpisałeś', '', '2022-01-22'),
(4, 1, 'Wiśniewski', 1, 'Nowak', '', 'testowa wiadomosc', '2022-01-22'),
(5, 1, 'Wiśniewski', 2, 'Wójcik', '', 'Dzień dobry Pani Anito.', '2022-01-22'),
(6, 1, 'Wiśniewski', 3, 'Lewandowski', '', 'Panie Piotrze jak tam mój syn na w-f?', '2022-01-22'),
(7, 1, 'Wiśniewski', 4, 'Kowalczyk', '', 'Pani Marleno może mi pani podać swój numer telefonu? to pilne', '2022-01-22'),
(8, 2, 'Kubiak', 1, 'Nowak', '', 'Dzień dobry', '2022-01-22'),
(9, 1, 'Wiśniewski', 3, 'Lewandowski', 'a spoko', '', '2022-01-22'),
(10, 2, 'Działowy', 3, 'Lewandowski', 'no co tam', '', '2022-01-22'),
(11, 2, 'Działowy', 3, 'Lewandowski', '', 'a co ma być?', '2022-01-22'),
(12, 2, 'Działowy', 1, 'Nowak', 'nie ma za co', '', '2022-01-22');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `students`
--

CREATE TABLE `students` (
  `id_ucznia` int(4) NOT NULL,
  `imie` varchar(33) NOT NULL,
  `nazwisko` varchar(33) NOT NULL,
  `pesel` bigint(33) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `students`
--

INSERT INTO `students` (`id_ucznia`, `imie`, `nazwisko`, `pesel`) VALUES
(1, 'Michał', 'Kuszyński', 99736281724),
(2, 'Piotr', 'Kubiak', 73947592014),
(3, 'Rafał', 'Zieliński', 20101092745);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `teachers`
--

CREATE TABLE `teachers` (
  `id_nauczyciela` int(33) NOT NULL,
  `username` varchar(33) NOT NULL,
  `nazwisko_t` varchar(33) NOT NULL,
  `przedmiot` varchar(33) NOT NULL,
  `login` varchar(33) NOT NULL,
  `password` varchar(33) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `teachers`
--

INSERT INTO `teachers` (`id_nauczyciela`, `username`, `nazwisko_t`, `przedmiot`, `login`, `password`) VALUES
(1, 'Karol', 'Nowak', 'matematyka', 'nauczyciel', '53f1fce859c22ffdeff1adfcc31f670f'),
(2, 'Anita', 'Wójcik', 'angielski', 'nauczyciel1', '53f1fce859c22ffdeff1adfcc31f670f'),
(3, 'Piotr', 'Lewandowski', 'wychowanie fizyczne', 'nauczyciel2', '53f1fce859c22ffdeff1adfcc31f670f'),
(4, 'Marlena', 'Kowalczyk', 'biologia', 'nauczyciel3', '53f1fce859c22ffdeff1adfcc31f670f');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `id_rodzica` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `nazwisko` varchar(30) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `pesel` bigint(33) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `users`
--

INSERT INTO `users` (`id_rodzica`, `username`, `nazwisko`, `email`, `password`, `pesel`) VALUES
(1, 'Kacper', 'Wiśniewski', 'wisniewski.kacper@gmail.com', '6a8f25e5b30777a0435c22fe36f45e3c', 99736281724),
(2, 'Tomasz', 'Działowy', 'dzialowytomasz@email.com', '2df8ce7d317c7d89dfa95be7695d2de0', 73947592014);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id_meeting`);

--
-- Indeksy dla tabeli `frekwencja`
--
ALTER TABLE `frekwencja`
  ADD PRIMARY KEY (`id_obecności`);

--
-- Indeksy dla tabeli `grades`
--
ALTER TABLE `grades`
  ADD PRIMARY KEY (`id_oceny`);

--
-- Indeksy dla tabeli `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id_wiadomosci`);

--
-- Indeksy dla tabeli `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id_ucznia`);

--
-- Indeksy dla tabeli `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`id_nauczyciela`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_rodzica`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `events`
--
ALTER TABLE `events`
  MODIFY `id_meeting` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT dla tabeli `frekwencja`
--
ALTER TABLE `frekwencja`
  MODIFY `id_obecności` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT dla tabeli `grades`
--
ALTER TABLE `grades`
  MODIFY `id_oceny` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT dla tabeli `messages`
--
ALTER TABLE `messages`
  MODIFY `id_wiadomosci` int(33) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT dla tabeli `students`
--
ALTER TABLE `students`
  MODIFY `id_ucznia` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT dla tabeli `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id_nauczyciela` int(33) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT dla tabeli `users`
--
ALTER TABLE `users`
  MODIFY `id_rodzica` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
