-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 30 May 2026, 01:17:53
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
  `cover_image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `books`
--

INSERT INTO `books` (`id`, `title`, `author`, `isbn`, `publish_year`, `genre`, `shelf_location`, `stock`, `cover_image`) VALUES
(8, 'Clean Code: A Handbook of Agile Software Craftsmanship', 'Robert C. Martin', '9780132350884', 2008, 'Yazılım', 'Y-01', 4, 'default.png'),
(9, 'Python Crash Course', 'Eric Matthes', '9781593279288', 2019, 'Yazılım', 'Y-02', 5, 'default.png'),
(10, 'C# in Depth', 'Jon Skeet', '9781617294532', 2019, 'Yazılım', 'Y-03', 3, 'default.png'),
(11, 'PHP & MySQL: Novice to Ninja', 'Tom Butler', '9780994182654', 2017, 'Yazılım', 'Y-04', 2, 'default.png'),
(12, 'Linux Command Line', 'William E. Shotts', '9781593273897', 2012, 'İşletim Sistemleri', 'S-01', 3, 'default.png'),
(13, 'The Pragmatic Programmer', 'Andrew Hunt', '9780135957059', 1999, 'Yazılım', 'Y-05', 4, 'default.png'),
(14, 'Head First HTML and CSS', 'Elisabeth Robson', '9780596159900', 2012, 'Web Geliştirme', 'W-01', 5, 'default.png'),
(15, 'Modern PC Hardware Optimization', 'Scott Mueller', '9780789755255', 2015, 'Donanım', 'D-01', 2, 'default.png'),
(16, 'Unity in Action: Multiplatform game development in C#', 'Joe Hocking', '9781617294969', 2018, 'Oyun Geliştirme', 'O-01', 3, 'default.png'),
(17, 'Flask Web Development', 'Miguel Grinberg', '9781491991732', 2018, 'Web Geliştirme', 'W-02', 4, 'default.png'),
(18, 'Balkanlar Tarihi', 'Mark Mazower', '9786051066865', 2013, 'Tarih', 'T-01', 2, 'default.png'),
(19, 'Otomotiv Mühendisliğinin Temelleri', 'Hermann Winner', '9783658257005', 2020, 'Mühendislik', 'M-01', 1, 'default.png'),
(20, '1984', 'George Orwell', '9789750718533', 1949, 'Distopya', 'E-01', 5, 'default.png'),
(21, 'Hayvan Çiftliği', 'George Orwell', '9789750719387', 1945, 'Distopya', 'E-02', 4, 'default.png'),
(22, 'Suç ve Ceza', 'Fyodor Dostoyevski', '9786053327346', 1866, 'Dünya Klasikleri', 'K-01', 3, 'default.png'),
(23, 'Karamazov Kardeşler', 'Fyodor Dostoyevski', '9786053326165', 1880, 'Dünya Klasikleri', 'K-02', 2, 'default.png'),
(24, 'İnce Memed 1', 'Yaşar Kemal', '9789750807140', 1955, 'Türk Edebiyatı', 'T-02', 5, 'default.png'),
(25, 'Tutunamayanlar', 'Oğuz Atay', '9789754700114', 1972, 'Türk Edebiyatı', 'T-03', 3, 'default.png'),
(26, 'Saatleri Ayarlama Enstitüsü', 'Ahmet Hamdi Tanpınar', '9789755109594', 1961, 'Türk Edebiyatı', 'T-04', 4, 'default.png'),
(27, 'Kürk Mantolu Madonna', 'Sabahattin Ali', '9789753638029', 1943, 'Türk Edebiyatı', 'T-05', 6, 'default.png'),
(28, 'Kuyucaklı Yusuf', 'Sabahattin Ali', '9789753638036', 1937, 'Türk Edebiyatı', 'T-06', 3, 'default.png'),
(29, 'Sefiller', 'Victor Hugo', '9789754580648', 1862, 'Dünya Klasikleri', 'K-03', 2, 'default.png'),
(30, 'Savaş ve Barış', 'Lev Tolstoy', '9786053327179', 1869, 'Dünya Klasikleri', 'K-04', 1, 'default.png'),
(31, 'Anna Karenina', 'Lev Tolstoy', '9786053325601', 1877, 'Dünya Klasikleri', 'K-05', 2, 'default.png'),
(32, 'Don Kişot', 'Miguel de Cervantes', '9789750810140', 1605, 'Dünya Klasikleri', 'K-06', 4, 'default.png'),
(33, 'Gurur ve Önyargı', 'Jane Austen', '9786053326448', 1813, 'Dünya Klasikleri', 'K-07', 3, 'default.png'),
(34, 'Uğultulu Tepeler', 'Emily Brontë', '9786053326622', 1847, 'Dünya Klasikleri', 'K-08', 3, 'default.png'),
(35, 'Yüzüklerin Efendisi: Yüzük Kardeşliği', 'J.R.R. Tolkien', '9789753423473', 1954, 'Fantastik', 'F-01', 5, 'default.png'),
(36, 'Yüzüklerin Efendisi: İki Kule', 'J.R.R. Tolkien', '9789753423480', 1954, 'Fantastik', 'F-02', 4, 'default.png'),
(37, 'Yüzüklerin Efendisi: Kralın Dönüşü', 'J.R.R. Tolkien', '9789753423497', 1955, 'Fantastik', 'F-03', 4, 'default.png'),
(38, 'Hobbit', 'J.R.R. Tolkien', '9789753426214', 1937, 'Fantastik', 'F-04', 6, 'default.png'),
(39, 'Harry Potter ve Felsefe Taşı', 'J.K. Rowling', '9789750802947', 1997, 'Fantastik', 'F-05', 5, 'default.png'),
(40, 'Harry Potter ve Sırlar Odası', 'J.K. Rowling', '9789750803111', 1998, 'Fantastik', 'F-06', 4, 'default.png'),
(41, 'Dune', 'Frank Herbert', '9786053754982', 1965, 'Bilim Kurgu', 'B-01', 5, 'default.png'),
(42, 'Vakıf', 'Isaac Asimov', '9786053757136', 1951, 'Bilim Kurgu', 'B-02', 3, 'default.png'),
(43, 'Cesur Yeni Dünya', 'Aldous Huxley', '9789756902165', 1932, 'Distopya', 'E-03', 4, 'default.png'),
(44, 'Fahrenheit 451', 'Ray Bradbury', '9786053757815', 1953, 'Distopya', 'E-04', 3, 'default.png'),
(45, 'Otostopçunun Galaksi Rehberi', 'Douglas Adams', '9786054820250', 1979, 'Bilim Kurgu', 'B-03', 4, 'default.png'),
(46, 'Simyacı', 'Paulo Coelho', '9789750726439', 1988, 'Roman', 'R-01', 6, 'default.png'),
(47, 'Şeker Portakalı', 'José Mauro de Vasconcelos', '9789755102557', 1968, 'Roman', 'R-02', 5, 'default.png'),
(48, 'Küçük Prens', 'Antoine de Saint-Exupéry', '9789750726446', 1943, 'Çocuk/Roman', 'R-03', 7, 'default.png'),
(49, 'Bülbülü Öldürmek', 'Harper Lee', '9786053140594', 1960, 'Roman', 'R-04', 4, 'default.png'),
(50, 'Büyük Umutlar', 'Charles Dickens', '9786053326172', 1861, 'Dünya Klasikleri', 'K-09', 3, 'default.png'),
(51, 'Sapiens: Hayvanlardan Tanrılara', 'Yuval Noah Harari', '9786055089046', 2011, 'Popüler Bilim', 'P-01', 4, 'default.png'),
(52, 'Homo Deus: Yarının Kısa Bir Tarihi', 'Yuval Noah Harari', '9786055089855', 2015, 'Popüler Bilim', 'P-02', 3, 'default.png'),
(53, 'Kozmos', 'Carl Sagan', '9789752115378', 1980, 'Bilim', 'P-03', 2, 'default.png'),
(54, 'Zamanın Kısa Tarihi', 'Stephen Hawking', '9786053320149', 1988, 'Bilim', 'P-04', 3, 'default.png'),
(55, 'Türlerin Kökeni', 'Charles Darwin', '9786053325793', 1859, 'Bilim', 'P-05', 2, 'default.png'),
(56, 'İzafiyet Teorisi', 'Albert Einstein', '9789754685046', 1916, 'Bilim', 'P-06', 1, 'default.png'),
(57, 'Balkan Kıyılarında Kamp Rotaları', 'Seyyah Ekibi', '9789759999999', 2023, 'Gezi Rehberi', 'G-01', 3, 'default.png');

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
(1, 9, 1, '2026-05-06 18:38:25', NULL, NULL, 'borrowed'),
(2, 7, 2, '2026-05-06 18:39:23', NULL, NULL, 'borrowed'),
(3, 9, 3, '2026-05-06 23:03:23', NULL, NULL, 'borrowed'),
(4, 9, 3, '2026-05-06 23:03:25', NULL, NULL, 'borrowed'),
(5, 9, 3, '2026-05-06 23:03:26', NULL, NULL, 'borrowed'),
(6, 9, 3, '2026-05-06 23:03:26', NULL, NULL, 'borrowed'),
(7, 9, 3, '2026-05-06 23:03:27', NULL, NULL, 'borrowed'),
(8, 9, 3, '2026-05-06 23:03:28', NULL, NULL, 'borrowed'),
(9, 9, 3, '2026-05-06 23:03:29', NULL, NULL, 'borrowed'),
(10, 9, 3, '2026-05-06 23:03:29', NULL, NULL, 'borrowed'),
(11, 9, 3, '2026-05-06 23:03:30', NULL, NULL, 'borrowed'),
(12, 9, 3, '2026-05-06 23:03:30', NULL, NULL, 'borrowed'),
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
(25, 9, 57, '2026-05-30 01:14:24', '2026-06-13 01:14:24', '2026-05-30 01:14:32', 'returned');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- Tablo için AUTO_INCREMENT değeri `borrowings`
--
ALTER TABLE `borrowings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Tablo için AUTO_INCREMENT değeri `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Tablo için AUTO_INCREMENT değeri `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
