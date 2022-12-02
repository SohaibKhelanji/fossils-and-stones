-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 29 nov 2022 om 10:49
-- Serverversie: 10.4.24-MariaDB
-- PHP-versie: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fas`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(50) NOT NULL,
  `product_price` int(11) NOT NULL,
  `product_category` int(11) NOT NULL,
  `product_description` longtext NOT NULL,
  `product_quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Gegevens worden geëxporteerd voor tabel `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `product_price`, `product_category`, `product_description`, `product_quantity`) VALUES
(1, 'Kana-Boon', 150, 1, 'Mooie steen', 1000),
(2, 'See Tinh', 120, 2, 'Mooie steen', 1000),
(3, 'Namida', 200, 1, 'Mooie steen', 1000);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `products_categories`
--

CREATE TABLE `products_categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Gegevens worden geëxporteerd voor tabel `products_categories`
--

INSERT INTO `products_categories` (`category_id`, `category_name`) VALUES
(1, 'Stenen'),
(2, 'Kristallen');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `products_images`
--

CREATE TABLE `products_images` (
  `image_id` int(11) NOT NULL,
  `image_name` varchar(250) NOT NULL,
  `product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Gegevens worden geëxporteerd voor tabel `products_images`
--

INSERT INTO `products_images` (`image_id`, `image_name`, `product_id`) VALUES
(1, 'kanaboon.png', 1),
(2, 'seetinh.png', 2),
(3, 'namida.png', 3);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_firstname` varchar(50) NOT NULL,
  `user_lastname` varchar(50) NOT NULL,
  `user_email` varchar(250) NOT NULL,
  `user_password` varchar(250) NOT NULL,
  `user_role` varchar(10) DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Gegevens worden geëxporteerd voor tabel `users`
--

INSERT INTO `users` (`user_id`, `user_firstname`, `user_lastname`, `user_email`, `user_password`, `user_role`) VALUES
(4, 'Sohaib', 'Khelanji', 'Sohaib1411@hotmail.com', '$2y$10$drmEwlnSLlbEqqD7XoY.YejRZoGEIg9gmiUMFzZYzC2/WwEvT7WwW', 'user');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `users_addresses`
--

CREATE TABLE `users_addresses` (
  `address_id` int(11) NOT NULL,
  `address_streetname` varchar(250) NOT NULL,
  `address_housenumber` int(5) NOT NULL,
  `address_postalcode` varchar(10) NOT NULL,
  `address_city` varchar(250) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Gegevens worden geëxporteerd voor tabel `users_addresses`
--

INSERT INTO `users_addresses` (`address_id`, `address_streetname`, `address_housenumber`, `address_postalcode`, `address_city`, `user_id`) VALUES
(2, 'Viljoenstraat', 106, '2572 PH', 'Den Haag', 4);

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `product_category` (`product_category`);

--
-- Indexen voor tabel `products_categories`
--
ALTER TABLE `products_categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexen voor tabel `products_images`
--
ALTER TABLE `products_images`
  ADD PRIMARY KEY (`image_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexen voor tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexen voor tabel `users_addresses`
--
ALTER TABLE `users_addresses`
  ADD PRIMARY KEY (`address_id`),
  ADD KEY `users_addresses_ibfk_1` (`user_id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT voor een tabel `products_categories`
--
ALTER TABLE `products_categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT voor een tabel `products_images`
--
ALTER TABLE `products_images`
  MODIFY `image_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT voor een tabel `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT voor een tabel `users_addresses`
--
ALTER TABLE `users_addresses`
  MODIFY `address_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`product_category`) REFERENCES `products_categories` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Beperkingen voor tabel `products_images`
--
ALTER TABLE `products_images`
  ADD CONSTRAINT `products_images_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Beperkingen voor tabel `users_addresses`
--
ALTER TABLE `users_addresses`
  ADD CONSTRAINT `users_addresses_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
