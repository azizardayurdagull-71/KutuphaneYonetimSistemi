-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 07 May 2026, 22:00:03
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
(51, 'Vakıf', 'Isaac Asimov', '9786053754930', NULL, 'Bilim', 'D-5', 4, 'default.png', 'Genel'),
(53, 'Dracula', 'Bram Stoker', '9789750734069', NULL, 'Roman', 'C-7', 5, 'default.png', 'Genel'),
(54, 'Frankenstein', 'Mary Shelley', '9789750734076', NULL, 'Roman', 'C-7', 4, 'default.png', 'Genel'),
(55, 'Dorian Gray in Portresi', 'Oscar Wilde', '9789750719370', NULL, 'Roman', 'C-8', 6, 'default.png', 'Genel'),
(56, 'Silahlara Veda', 'Ernest Hemingway', '9789750719394', NULL, 'Roman', 'B-15', 3, 'default.png', 'Genel'),
(57, 'Canlar Kimin Icin Caliyor', 'Ernest Hemingway', '9789750719400', NULL, 'Roman', 'B-15', 2, 'default.png', 'Genel'),
(58, 'Aylak Adam', 'Yusuf Atılgan', '9789750809057', NULL, 'Roman', 'A-6', 3, 'default.png', 'Genel'),
(59, 'Anayurt Oteli', 'Yusuf Atılgan', '9789750809064', NULL, 'Roman', 'A-6', 2, 'default.png', 'Genel'),
(60, 'Kuyucaklı Yusuf', 'Sabahattin Ali', '9789753638045', NULL, 'Roman', 'A-2', 8, 'default.png', 'Genel'),
(61, 'Eylül', 'Mehmet Rauf', '9789754580495', NULL, 'Roman', 'A-7', 4, 'default.png', 'Genel'),
(62, 'Mai ve Siyah', 'Halid Ziya Uşaklıgil', '9789754580501', NULL, 'Roman', 'A-7', 3, 'default.png', 'Genel'),
(63, 'Ask-ı Memnu', 'Halid Ziya Uşaklıgil', '9789754580518', NULL, 'Roman', 'A-7', 5, 'default.png', 'Genel'),
(64, 'Fatih-Harbiye', 'Peyami Safa', '9789754370522', NULL, 'Roman', 'A-8', 4, 'default.png', 'Genel'),
(65, 'Dokuzuncu Hariciye Kogusu', 'Peyami Safa', '9789754370539', NULL, 'Roman', 'A-8', 6, 'default.png', 'Genel'),
(67, 'Yaprak Dökümü', 'Reşat Nuri Güntekin', '9789751001061', NULL, 'Roman', 'A-9', 4, 'default.png', 'Genel'),
(68, 'Sineklerin Tanrısı', 'William Golding', '9789753638052', NULL, 'Roman', 'B-16', 5, 'default.png', 'Genel'),
(69, 'Beyaz Dis', 'Jack London', '9789750734083', NULL, 'Roman', 'C-8', 7, 'default.png', 'Genel'),
(70, 'Vahsetin Cagrısı', 'Jack London', '9789750734090', NULL, 'Roman', 'C-8', 5, 'default.png', 'Genel'),
(71, 'Martin Eden', 'Jack London', '9789750734106', NULL, 'Roman', 'C-8', 4, 'default.png', 'Genel'),
(72, 'Sherlock Holmes: Kızıl Dosya', 'Arthur Conan Doyle', '9786055513375', NULL, 'Roman', 'C-9', 9, 'default.png', 'Genel'),
(73, 'Müfettis', 'Nikolay Gogol', '9789753638069', NULL, 'Roman', 'B-17', 3, 'default.png', 'Genel'),
(74, 'Ölü Canlar', 'Nikolay Gogol', '9789753638076', NULL, 'Roman', 'B-17', 2, 'default.png', 'Genel'),
(75, 'Babalar ve Ogullar', 'Ivan Turgenyev', '9789753638083', NULL, 'Roman', 'B-18', 4, 'default.png', 'Genel'),
(76, 'Genc Werther in Acıları', 'Goethe', '9789753638090', NULL, 'Roman', 'B-18', 5, 'default.png', 'Genel'),
(77, 'Bülbülü Öldürmek', 'Harper Lee', '9789752981546', NULL, 'Roman', 'B-19', 6, 'default.png', 'Genel'),
(78, 'Muhtesem Gatsby', 'F. Scott Fitzgerald', '9789750719417', NULL, 'Roman', 'B-19', 4, 'default.png', 'Genel'),
(79, 'Lolita', 'Vladimir Nabokov', '9789750719424', NULL, 'Roman', 'B-20', 2, 'default.png', 'Genel'),
(81, 'Görmek', 'Jose Saramago', '9789750719448', NULL, 'Roman', 'B-20', 3, 'default.png', 'Genel'),
(82, 'Zübük', 'Aziz Nesin', '9789753638113', NULL, 'Roman', 'A-10', 5, 'default.png', 'Genel'),
(83, 'Simdiki Cocuklar Harika', 'Aziz Nesin', '9789753638120', NULL, 'Roman', 'A-10', 7, 'default.png', 'Genel'),
(84, 'Kayıp Sembol', 'Dan Brown', '9786054439065', NULL, 'Roman', 'C-10', 4, 'default.png', 'Genel'),
(85, 'Da Vinci Sifresi', 'Dan Brown', '9786054439072', NULL, 'Roman', 'C-10', 6, 'default.png', 'Genel'),
(86, 'Melekler ve Seytanlar', 'Dan Brown', '9786054439089', NULL, 'Roman', 'C-10', 5, 'default.png', 'Genel'),
(87, 'Otostopcunun Galaksi Rehberi', 'Douglas Adams', '9786053754800', NULL, 'Bilim', 'D-6', 8, 'default.png', 'Genel'),
(88, 'Ben Robot', 'Isaac Asimov', '9786053754947', NULL, 'Bilim', 'D-6', 5, 'default.png', 'Genel'),
(89, 'Marslı', 'Andy Weir', '9786053754954', NULL, 'Bilim', 'D-7', 6, 'default.png', 'Genel'),
(90, 'Sonsuzlugun Sonu', 'Isaac Asimov', '9786053754961', NULL, 'Bilim', 'D-7', 3, 'default.png', 'Genel'),
(91, 'Gelecek Bilimi', 'Michio Kaku', '9786051061757', NULL, 'Bilim', 'D-8', 4, 'default.png', 'Genel'),
(92, 'Paralel Dünyalar', 'Michio Kaku', '9786051061764', NULL, 'Bilim', 'D-8', 2, 'default.png', 'Genel'),
(93, 'Kara Delikler', 'Stephen Hawking', '9786051061771', NULL, 'Bilim', 'D-9', 5, 'default.png', 'Genel'),
(94, 'Büyük Tasarım', 'Stephen Hawking', '9786051061788', NULL, 'Bilim', 'D-9', 4, 'default.png', 'Genel'),
(95, 'Savas Sanatı', 'Sun Tzu', '9789754580525', NULL, 'Genel', 'F-3', 10, 'default.png', 'Genel'),
(96, 'Prens', 'Machiavelli', '9789754580532', NULL, 'Genel', 'F-3', 6, 'default.png', 'Genel'),
(97, 'Toplum Sözlesmesi', 'Jean-Jacques Rousseau', '9789754580549', NULL, 'Genel', 'F-4', 4, 'default.png', 'Genel'),
(98, 'Ütopya', 'Thomas More', '9789754580556', NULL, 'Genel', 'F-4', 3, 'default.png', 'Genel'),
(99, 'Denemeler', 'Montaigne', '9789753638106', NULL, 'Genel', 'F-5', 7, 'default.png', 'Genel'),
(100, 'Mecburiyet', 'Stefan Zweig', '9786053322153', NULL, 'Roman', 'B-21', 12, 'default.png', 'Genel');

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

--
-- Tablo döküm verisi `reviews`
--

INSERT INTO `reviews` (`id`, `book_id`, `user_id`, `rating`, `comment`, `created_at`) VALUES
(5, 50, 11, 5, 'çok güzel\r\n', '2026-05-07 22:42:08'),
(6, 50, 11, 5, 'olmuş\r\n', '2026-05-07 22:42:22');

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
(9, 'admin', 'admin@gmail.com', '$2y$10$RAEHOlRSmKn6/S11.6gmYOwqGObvrFBqtTj0aLIXHdDDZFwkLKE0m', 'admin');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- Tablo için AUTO_INCREMENT değeri `borrowings`
--
ALTER TABLE `borrowings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- Tablo için AUTO_INCREMENT değeri `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Tablo için AUTO_INCREMENT değeri `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
