-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 07 May 2026, 19:34:09
-- Sunucu sürümü: 10.4.32-MariaDB
-- PHP Sürümü: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `kutuphane_sistemi`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `isbn` varchar(20) DEFAULT NULL,
  `publish_year` int(4) DEFAULT NULL,
  `genre` varchar(100) DEFAULT NULL,
  `shelf_location` varchar(50) DEFAULT NULL,
  `stock` int(11) DEFAULT 0,
  `cover_image` varchar(255) DEFAULT NULL,
  `category` varchar(50) DEFAULT 'Genel'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `books`
--

INSERT INTO `books` (`id`, `title`, `author`, `isbn`, `publish_year`, `genre`, `shelf_location`, `stock`, `cover_image`, `category`) VALUES
(1, 'Suç ve Ceza', 'Fyodor Dostoyevski', '9786053321151', 1866, 'Psikolojik Dram', 'A-01', 6, 'default.png', 'Roman'),
(2, '1984', 'George Orwell', '9789750718533', 1949, 'Distopya', 'A-02', 3, 'default.png', 'Roman'),
(3, 'Sapiens', 'Yuval Noah Harari', '9786055162463', 2011, 'Antropoloji', 'B-01', 14, 'default.png', 'Bilim'),
(4, 'Kürk Mantolu Madonna', 'Sabahattin Ali', '9789753631621', 1943, 'Aşk', 'C-01', 10, 'default.png', 'Roman'),
(5, 'Zamanın Kısa Tarihi', 'Stephen Hawking', '9786055903028', 1988, 'Popüler Bilim', 'B-02', 2, 'default.png', 'Bilim'),
(6, 'İlber Ortaylı Seyahatnamesi', 'İlber Ortaylı', '9786050901512', 2011, 'Gezi Yazısı', 'D-01', 3, 'default.png', 'Gezi'),
(7, 'Nutuk', 'Mustafa Kemal Atatürk', '9789751611024', 1927, 'Söylev', 'E-01', 15, 'default.png', 'Tarih'),
(8, 'Simyacı', 'Paulo Coelho', '9789750726439', 1988, 'Felsefi Roman', 'A-03', 6, 'default.png', 'Roman'),
(9, 'Küçük Prens', 'Antoine de Saint-Exupéry', '9789750724282', 1943, 'Masal', 'A-04', 8, 'default.png', 'Roman'),
(10, 'Türlerin Kökeni', 'Charles Darwin', '9789752981921', 1859, 'Biyoloji', 'B-03', 1, 'default.png', 'Bilim'),
(11, 'Sefiller', 'Victor Hugo', '9786053320246', 1862, 'Klasik', 'A-05', 4, 'default.png', 'Roman'),
(12, 'Dune', 'Frank Herbert', '9786053754718', 1965, 'Bilim Kurgu', 'A-06', 3, 'default.png', 'Roman'),
(13, 'Tüfek, Mikrop ve Çelik', 'Jared Diamond', '9789756580000', 1997, 'Tarihsel Coğrafya', 'B-04', 2, 'default.png', 'Bilim'),
(14, 'Bilinmeyen Bir Kadının Mektubu', 'Stefan Zweig', '9786053320000', 1922, 'Novella', 'A-07', 12, 'default.png', 'Roman'),
(15, 'Satranç', 'Stefan Zweig', '9786053320001', 1941, 'Psikolojik', 'A-08', 9, 'default.png', 'Roman'),
(16, 'Hayvan Çiftliği', 'George Orwell', '9789750719387', 1945, 'Politik Hiciv', 'A-09', 7, 'default.png', 'Roman'),
(17, 'Martı', 'Richard Bach', '9789750000001', 1970, 'Kişisel Gelişim', 'F-01', 5, 'default.png', 'Genel'),
(18, 'Kozmos', 'Carl Sagan', '9786054439000', 1980, 'Astronomi', 'B-05', 3, 'default.png', 'Bilim'),
(19, 'Şeker Portakalı', 'José Mauro de Vasconcelos', '9789750700002', 1968, 'Dram', 'A-10', 6, 'default.png', 'Roman'),
(20, 'Tutunamayanlar', 'Oğuz Atay', '9789754700114', 1971, 'Modernizm', 'A-11', 4, 'default.png', 'Roman'),
(21, 'Semerkant', 'Amin Maalouf', '9789753630005', 1988, 'Tarihi Roman', 'A-12', 3, 'default.png', 'Roman'),
(22, 'Doğu Ekspresinde Cinayet', 'Agatha Christie', '9789752100003', 1934, 'Polisiye', 'A-13', 5, 'default.png', 'Roman'),
(23, 'Sherlock Holmes', 'Sir Arthur Conan Doyle', '9786050000005', 1887, 'Polisiye', 'A-14', 8, 'default.png', 'Roman'),
(24, 'Atlas Silkindi', 'Ayn Rand', '9789750000006', 1957, 'Felsefe', 'F-02', 2, 'default.png', 'Genel'),
(25, 'Beyaz Zambaklar Ülkesinde', 'Grigory Petrov', '9786050000007', 1923, 'Kişisel Gelişim', 'F-03', 10, 'default.png', 'Genel'),
(26, 'National Geographic Türkiye', 'Kolektif', '9771302800000', 2024, 'Coğrafya', 'G-01', 20, 'default.png', 'Dergi'),
(27, 'Bilim ve Teknik', 'TÜBİTAK', '9771300300000', 2024, 'Bilim', 'G-02', 15, 'default.png', 'Dergi'),
(28, 'Evrim Kuramı ve Mekanizmaları', 'Çağrı Mert Bakırcı', '9786050000008', 2013, 'Evrimsel Biyoloji', 'B-06', 4, 'default.png', 'Bilim'),
(29, 'Kısa Türkiye Tarihi', 'Sina Akşin', '9789754580009', 2007, 'Tarih', 'E-02', 5, 'default.png', 'Tarih'),
(30, 'Savaş ve Barış', 'Lev Tolstoy', '9786050000010', 1869, 'Klasik', 'A-15', 3, 'default.png', 'Roman'),
(31, 'Anna Karenina', 'Lev Tolstoy', '9786050000011', 1877, 'Klasik', 'A-16', 4, 'default.png', 'Roman'),
(32, 'Fahrenheit 451', 'Ray Bradbury', '9786050000012', 1953, 'Bilim Kurgu', 'A-17', 5, 'default.png', 'Roman'),
(33, 'Cesur Yeni Dünya', 'Aldous Huxley', '9789750000013', 1932, 'Distopya', 'A-18', 6, 'default.png', 'Roman'),
(34, 'Ulysses', 'James Joyce', '9789750000014', 1922, 'Modernist', 'A-19', 2, 'default.png', 'Roman'),
(35, 'Don Kişot', 'Miguel de Cervantes', '9786050000015', 1605, 'Klasik', 'A-20', 3, 'default.png', 'Roman'),
(36, 'İlahi Komedya', 'Dante Alighieri', '9786050000016', 1320, 'Klasik', 'A-21', 2, 'default.png', 'Roman'),
(37, 'Odessa Dosyası', 'Frederick Forsyth', '9789750000017', 1972, 'Gerilim', 'A-22', 3, 'default.png', 'Roman'),
(38, 'Da Vinci Şifresi', 'Dan Brown', '9789750000018', 2003, 'Gerilim', 'A-23', 7, 'default.png', 'Roman'),
(39, 'Melekler ve Şeytanlar', 'Dan Brown', '9789750000019', 2000, 'Gerilim', 'A-24', 6, 'default.png', 'Roman'),
(40, 'Olasılıksız', 'Adam Fawer', '9789750000020', 2005, 'Bilimsel Gerilim', 'A-25', 8, 'default.png', 'Roman'),
(41, 'Empati', 'Adam Fawer', '9789750000021', 2008, 'Bilimsel Gerilim', 'A-26', 7, 'default.png', 'Roman'),
(42, 'Körlük', 'José Saramago', '9789750000022', 1995, 'Felsefi', 'A-27', 4, 'default.png', 'Roman'),
(43, 'Yeraltından Notlar', 'Fyodor Dostoyevski', '9786050000023', 1864, 'Varoluşçu', 'A-28', 9, 'default.png', 'Roman'),
(44, 'Madam Bovary', 'Gustave Flaubert', '9786050000024', 1856, 'Realizm', 'A-29', 5, 'default.png', 'Roman'),
(45, 'Büyük Umutlar', 'Charles Dickens', '9786050000025', 1861, 'Klasik', 'A-30', 4, 'default.png', 'Roman'),
(46, 'Oliver Twist', 'Charles Dickens', '9786050000026', 1837, 'Klasik', 'A-31', 6, 'default.png', 'Roman'),
(47, 'İnce Memed', 'Yaşar Kemal', '9789753630001', 1955, 'Destan', 'A-32', 5, 'default.png', 'Roman'),
(48, 'Çalıkuşu', 'Reşat Nuri Güntekin', '9789751000001', 1922, 'Dram', 'A-33', 7, 'default.png', 'Roman'),
(49, 'Eylül', 'Mehmet Rauf', '9789750000027', 1901, 'Psikolojik', 'A-34', 3, 'default.png', 'Roman'),
(50, 'Mai ve Siyah', 'Halid Ziya Uşaklıgil', '9789750000028', 1897, 'Realizm', 'A-35', 4, 'default.png', 'Roman');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `borrowings`
--

CREATE TABLE `borrowings` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `borrow_date` datetime DEFAULT current_timestamp(),
  `due_date` datetime DEFAULT NULL,
  `return_date` datetime DEFAULT NULL,
  `status` enum('borrowed','returned') NOT NULL DEFAULT 'borrowed'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `borrowings`
--

INSERT INTO `borrowings` (`id`, `user_id`, `book_id`, `borrow_date`, `due_date`, `return_date`, `status`) VALUES
(1, 9, 1, '2026-05-06 18:38:25', NULL, '2026-05-07 19:33:43', 'returned'),
(2, 7, 2, '2026-05-06 18:39:23', NULL, NULL, 'borrowed'),
(3, 9, 3, '2026-05-06 23:03:23', NULL, '2026-05-07 19:33:41', 'returned'),
(4, 9, 3, '2026-05-06 23:03:25', NULL, '2026-05-07 19:33:40', 'returned'),
(5, 9, 3, '2026-05-06 23:03:26', NULL, '2026-05-07 19:33:36', 'returned'),
(6, 9, 3, '2026-05-06 23:03:26', NULL, '2026-05-07 19:33:37', 'returned'),
(7, 9, 3, '2026-05-06 23:03:27', NULL, '2026-05-07 19:33:34', 'returned'),
(8, 9, 3, '2026-05-06 23:03:28', NULL, '2026-05-07 19:33:33', 'returned'),
(9, 9, 3, '2026-05-06 23:03:29', NULL, '2026-05-07 19:33:30', 'returned'),
(10, 9, 3, '2026-05-06 23:03:29', NULL, '2026-05-07 19:33:31', 'returned'),
(11, 9, 3, '2026-05-06 23:03:30', NULL, '2026-05-07 19:33:27', 'returned'),
(12, 9, 3, '2026-05-06 23:03:30', NULL, '2026-05-07 19:33:28', 'returned'),
(13, 7, 7, '2026-05-06 23:22:15', '2026-05-20 23:22:15', '2026-05-21 23:32:42', 'returned'),
(14, 7, 6, '2026-05-06 23:22:17', '2026-05-20 23:22:17', '2026-05-21 23:32:41', 'returned'),
(15, 7, 4, '2026-05-06 23:22:19', '2026-05-20 23:22:19', '2026-05-06 23:23:43', 'returned'),
(16, 7, 5, '2026-05-06 23:22:21', '2026-05-20 23:22:21', '2026-05-06 23:23:34', 'returned'),
(17, 9, 7, '2026-05-06 23:24:01', '2026-05-20 23:24:01', '2026-05-06 23:25:12', 'returned'),
(18, 10, 6, '2026-05-06 23:24:45', '2026-05-20 23:24:45', '2026-05-06 23:24:56', 'returned'),
(19, 7, 7, '2026-05-21 23:33:06', '2026-06-04 23:33:06', '2026-05-21 23:33:11', 'returned'),
(20, 7, 7, '2026-05-21 23:33:14', '2026-06-04 23:33:14', '2026-05-06 23:39:21', 'returned'),
(21, 7, 7, '2026-05-06 23:39:25', '2026-05-20 23:39:25', NULL, 'borrowed'),
(22, 7, 57, '2026-05-07 00:26:54', '2026-05-21 00:26:54', '2026-05-30 00:29:37', 'returned'),
(23, 7, 52, '2026-05-07 00:27:09', '2026-05-21 00:27:09', '2026-05-30 00:29:39', 'returned'),
(24, 9, 57, '2026-05-30 01:01:10', '2026-06-13 01:01:10', '2026-05-30 01:01:30', 'returned'),
(25, 9, 57, '2026-05-30 01:14:24', '2026-06-13 01:14:24', '2026-05-30 01:14:32', 'returned'),
(26, 7, 52, '2026-05-30 15:51:00', '2026-06-13 15:51:00', '2026-06-20 15:52:16', 'returned');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rating` int(1) NOT NULL,
  `comment` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','librarian','student') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`) VALUES
(7, 'arda', 'azizardayurdagull@gmail.com', '$2y$10$yjPrS7wqilLHt43fHb/RKObCLim/U1qCBWOa..HvpVEapnUFO0/wi', 'student'),
(9, 'admin', 'admin@gmail.com', '$2y$10$RAEHOlRSmKn6/S11.6gmYOwqGObvrFBqtTj0aLIXHdDDZFwkLKE0m', 'admin'),
(10, 'merve', 'merve@gmail.com', '$2y$10$bJYUcMmA9/ycQArCoR6jJ.M5GG4WMjlEwu/hG/QIS.C3gTdPC8.t2', 'student');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `isbn` (`isbn`);

--
-- Tablo için indeksler `borrowings`
--
ALTER TABLE `borrowings`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- Tablo için AUTO_INCREMENT değeri `borrowings`
--
ALTER TABLE `borrowings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- Tablo için AUTO_INCREMENT değeri `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Tablo için AUTO_INCREMENT değeri `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
