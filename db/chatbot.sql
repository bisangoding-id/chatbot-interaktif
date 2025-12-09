-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 09, 2025 at 09:31 AM
-- Server version: 9.5.0
-- PHP Version: 8.4.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `chatbot`
--

-- --------------------------------------------------------

--
-- Table structure for table `qa_list`
--

CREATE TABLE `qa_list` (
  `id` int NOT NULL,
  `keyword` varchar(50) NOT NULL,
  `variations` text,
  `response` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `qa_list`
--

INSERT INTO `qa_list` (`id`, `keyword`, `variations`, `response`) VALUES
(1, 'ketersediaan kamar', 'kamar,available,ready,kosong', 'Untuk ketersediaan kamar bisa dicek saat reservasi ya ka, ketik aja *6* untuk reservasi 😊'),
(2, 'harga', 'harganya,biaya,cost,price,tarif', 'Harga kamar mulai dari *Rp.1.400.000/bulan*  \r\n\r\nKamar bisa ditempati maksimal 2 orang ya ka, namun ada tambahan biaya *Rp.200.000/bulan*.'),
(3, 'fasilitas', 'fasilitas,facility,amenities', '*Fasilitas Vilaza Kost:*\r\n• Kamar AC\r\n• Free Wifi\r\n• Kamar mandi dalam\r\n• Kasur & Dipan\r\n• Meja & Kursi\r\n• Lemari\r\n• Smart TV'),
(4, 'lokasi', 'lokasi,alamat,map,google maps,gmaps', 'Ini lokasi Vilaza Kost kak:\r\nhttps://maps.app.goo.gl/8kVPN1ciGkFr6C5K9'),
(5, 'foto', 'foto,gambar,image,pic,photo,foto kamar', 'Berikut foto kamar ya kak 😊\r\n\r\n🖼️ https://ibb.co.com/album/SNg510\r\n\r\n(Klik untuk melihat gambarnya)'),
(6, 'reservasi', 'reservasi,booking,pesan,daftar,sewa,reserve', 'Untuk reservasi silahkan isi data berikut ya kak 😊\r\n\r\n🔗 https://forms.gle/a7ppvMU1cxn1dmfZ8\r\n\r\nJika datanya sudah diisi, kami akan segera menghubungi kembali 🙏'),
(7, 'terima kasih', 'makasih,thanks,trimakasih,thx,thanks,nuhun,', 'Sama-sama kak 😊 Senang bisa membantu! Jika ada yang ingin ditanyakan lagi, tinggal chat ya. \r\n\r\nKunjungi juga sosmed Vilaza Kost:\r\n\r\n📸: instagram.com/vilazakost\r\n🌐: www.vilazakost.com');

-- --------------------------------------------------------

--
-- Table structure for table `user_state`
--

CREATE TABLE `user_state` (
  `id` int NOT NULL,
  `phone` varchar(20) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `step` varchar(50) DEFAULT NULL,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user_state`
--

INSERT INTO `user_state` (`id`, `phone`, `name`, `step`, `updated_at`) VALUES
(2, '6281286869786', 'Ikmal', 'menu', '2025-12-08 05:22:10');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `qa_list`
--
ALTER TABLE `qa_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_state`
--
ALTER TABLE `user_state`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `qa_list`
--
ALTER TABLE `qa_list`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `user_state`
--
ALTER TABLE `user_state`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
