-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 18 jan 2023 om 10:01
-- Serverversie: 10.4.27-MariaDB
-- PHP-versie: 8.0.25

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
-- Tabelstructuur voor tabel `orders`
--

CREATE TABLE `orders` (
  `orders_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `orders_timestamp` varchar(255) NOT NULL,
  `orders_processed` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `orders`
--

INSERT INTO `orders` (`orders_id`, `user_id`, `orders_timestamp`, `orders_processed`) VALUES
(18, NULL, '2022-12-20 15:35:16', 0),
(19, 4, '2022-12-20 15:58:54', 0),
(20, 4, '2022-12-20 16:26:12', 0),
(21, 4, '2022-12-20 20:50:55', 1),
(22, 4, '2022-12-21 09:20:17', 0),
(23, NULL, '2023-01-11 09:49:19', 1),
(24, 4, '2023-01-11 09:50:15', 0);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `order_address`
--

CREATE TABLE `order_address` (
  `order_address_id` int(11) NOT NULL,
  `order_address_streetname` varchar(255) NOT NULL,
  `order_address_housenumber` varchar(5) NOT NULL,
  `order_address_postalcode` varchar(10) NOT NULL,
  `order_address_city` varchar(255) NOT NULL,
  `orders_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `order_address`
--

INSERT INTO `order_address` (`order_address_id`, `order_address_streetname`, `order_address_housenumber`, `order_address_postalcode`, `order_address_city`, `orders_id`) VALUES
(4, 'Test', '1', '1111 TT', 'Test', 18),
(5, 'Test', '1', '1111 TT', 'Test', 23);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `order_product`
--

CREATE TABLE `order_product` (
  `order_product_id` int(11) NOT NULL,
  `orders_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `order_product_quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `order_product`
--

INSERT INTO `order_product` (`order_product_id`, `orders_id`, `product_id`, `order_product_quantity`) VALUES
(14, 18, 34, 1),
(15, 19, 1, 1),
(16, 20, 3, 1),
(17, 20, 2, 1),
(18, 21, 3, 1),
(19, 21, 2, 1),
(20, 22, 34, 1),
(21, 22, 3, 1),
(22, 23, 34, 3),
(23, 23, 2, 1),
(24, 24, 34, 1);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `order_user`
--

CREATE TABLE `order_user` (
  `order_user_id` int(11) NOT NULL,
  `order_user_firstname` varchar(255) NOT NULL,
  `order_user_lastname` varchar(255) NOT NULL,
  `order_user_email` varchar(255) NOT NULL,
  `orders_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `order_user`
--

INSERT INTO `order_user` (`order_user_id`, `order_user_firstname`, `order_user_lastname`, `order_user_email`, `orders_id`) VALUES
(2, 'Rony', 'Ali', 'Rony@test.nl', 18),
(3, 'Henry', 'Robben', 'Hrobben@mbo.nl', 23);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `product`
--

CREATE TABLE `product` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(50) NOT NULL,
  `product_price` int(11) NOT NULL,
  `product_category` int(11) NOT NULL,
  `product_description` longtext NOT NULL,
  `product_quantity` int(11) DEFAULT NULL,
  `product_availability` varchar(5) NOT NULL DEFAULT 'true'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `product`
--

INSERT INTO `product` (`product_id`, `product_name`, `product_price`, `product_category`, `product_description`, `product_quantity`, `product_availability`) VALUES
(1, 'Kana-Boon', 150, 1, 'Mooie steen', 999, 'true'),
(2, 'See Tinh', 120, 2, 'Mooie steen', 997, 'true'),
(3, 'Namida', 200, 1, 'Mooie steen', 984, 'true'),
(34, 'Snowglobe', 300, 2, 'Een mooie steen', 900, 'true');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `product_category`
--

CREATE TABLE `product_category` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `product_category`
--

INSERT INTO `product_category` (`category_id`, `category_name`) VALUES
(1, 'Stenen'),
(2, 'Kristallen');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `product_image`
--

CREATE TABLE `product_image` (
  `image_id` int(11) NOT NULL,
  `image_name` varchar(250) NOT NULL,
  `product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `product_image`
--

INSERT INTO `product_image` (`image_id`, `image_name`, `product_id`) VALUES
(1, 'kanaboon.png', 1),
(2, 'seetinh.png', 2),
(3, 'namida.png', 3),
(21, '63be7a2cc7e6c2.09788407.png', 34);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `user_firstname` varchar(50) NOT NULL,
  `user_lastname` varchar(50) NOT NULL,
  `user_email` varchar(250) NOT NULL,
  `user_password` varchar(250) NOT NULL,
  `user_role` varchar(10) DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `user`
--

INSERT INTO `user` (`user_id`, `user_firstname`, `user_lastname`, `user_email`, `user_password`, `user_role`) VALUES
(4, 'Sohaib', 'Khelanji', 'test@test.nl', '$2y$10$drmEwlnSLlbEqqD7XoY.YejRZoGEIg9gmiUMFzZYzC2/WwEvT7WwW', 'user'),
(5, 'Admin', 'FAS', 'Admin@fossilsandstones.nl', '$2y$10$8X202Sywqa9ZYSaiZT04be36az1QeAIj7hPJcRq76otMn8iMXWKf.', 'admin');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `user_address`
--

CREATE TABLE `user_address` (
  `address_id` int(11) NOT NULL,
  `address_streetname` varchar(250) NOT NULL,
  `address_housenumber` int(5) NOT NULL,
  `address_postalcode` varchar(10) NOT NULL,
  `address_city` varchar(250) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `user_address`
--

INSERT INTO `user_address` (`address_id`, `address_streetname`, `address_housenumber`, `address_postalcode`, `address_city`, `user_id`) VALUES
(2, 'Testweg', 12, '2525 HP', 'Den Haag', 4),
(3, 'Adminweg', 1, '2525 FAS', 'Fossils and Stones', 5);

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`orders_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexen voor tabel `order_address`
--
ALTER TABLE `order_address`
  ADD PRIMARY KEY (`order_address_id`),
  ADD KEY `order_id` (`orders_id`);

--
-- Indexen voor tabel `order_product`
--
ALTER TABLE `order_product`
  ADD PRIMARY KEY (`order_product_id`),
  ADD KEY `order_product_ibfk_1` (`product_id`),
  ADD KEY `orders_id` (`orders_id`);

--
-- Indexen voor tabel `order_user`
--
ALTER TABLE `order_user`
  ADD PRIMARY KEY (`order_user_id`),
  ADD KEY `order_id` (`orders_id`);

--
-- Indexen voor tabel `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `product_category` (`product_category`);

--
-- Indexen voor tabel `product_category`
--
ALTER TABLE `product_category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexen voor tabel `product_image`
--
ALTER TABLE `product_image`
  ADD PRIMARY KEY (`image_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexen voor tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexen voor tabel `user_address`
--
ALTER TABLE `user_address`
  ADD PRIMARY KEY (`address_id`),
  ADD KEY `users_addresses_ibfk_1` (`user_id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `orders`
--
ALTER TABLE `orders`
  MODIFY `orders_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT voor een tabel `order_address`
--
ALTER TABLE `order_address`
  MODIFY `order_address_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT voor een tabel `order_product`
--
ALTER TABLE `order_product`
  MODIFY `order_product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT voor een tabel `order_user`
--
ALTER TABLE `order_user`
  MODIFY `order_user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT voor een tabel `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT voor een tabel `product_category`
--
ALTER TABLE `product_category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT voor een tabel `product_image`
--
ALTER TABLE `product_image`
  MODIFY `image_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT voor een tabel `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT voor een tabel `user_address`
--
ALTER TABLE `user_address`
  MODIFY `address_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Beperkingen voor tabel `order_address`
--
ALTER TABLE `order_address`
  ADD CONSTRAINT `order_address_ibfk_1` FOREIGN KEY (`orders_id`) REFERENCES `orders` (`orders_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Beperkingen voor tabel `order_product`
--
ALTER TABLE `order_product`
  ADD CONSTRAINT `order_product_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `order_product_ibfk_2` FOREIGN KEY (`orders_id`) REFERENCES `orders` (`orders_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Beperkingen voor tabel `order_user`
--
ALTER TABLE `order_user`
  ADD CONSTRAINT `order_user_ibfk_1` FOREIGN KEY (`orders_id`) REFERENCES `orders` (`orders_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Beperkingen voor tabel `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`product_category`) REFERENCES `product_category` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Beperkingen voor tabel `product_image`
--
ALTER TABLE `product_image`
  ADD CONSTRAINT `product_image_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Beperkingen voor tabel `user_address`
--
ALTER TABLE `user_address`
  ADD CONSTRAINT `user_address_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
