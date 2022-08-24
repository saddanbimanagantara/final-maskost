-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 13, 2022 at 03:01 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db-kost`
--

-- --------------------------------------------------------

--
-- Table structure for table `administrator`
--

CREATE TABLE `administrator` (
  `uid_administrator` varchar(36) NOT NULL,
  `email` varchar(16) NOT NULL,
  `username` varchar(16) NOT NULL,
  `password` varchar(16) NOT NULL,
  `nama` varchar(36) NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `chart_item`
--

CREATE TABLE `chart_item` (
  `uid_chart` varchar(36) NOT NULL,
  `uid_kamar` varchar(36) NOT NULL,
  `uid_penghuni` varchar(36) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `chat`
--

CREATE TABLE `chat` (
  `uid_chat` int(11) NOT NULL,
  `uid_pengirim` varchar(36) NOT NULL,
  `uid_penerima` varchar(36) NOT NULL,
  `message` text NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `durasi_kamar`
--

CREATE TABLE `durasi_kamar` (
  `uid_durasi` int(11) NOT NULL,
  `durasi` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `durasi_kamar`
--

INSERT INTO `durasi_kamar` (`uid_durasi`, `durasi`) VALUES
(1, '1 Bulan'),
(2, '2 Bulan'),
(3, '3 Bulan'),
(4, '4 Bulan'),
(5, '5 Bulan'),
(6, '6 Bulan'),
(7, '7 Bulan'),
(8, '8 Bulan'),
(9, '9 Bulan'),
(10, '10 Bulan'),
(11, '11 Bulan'),
(12, '12 Bulan');

-- --------------------------------------------------------

--
-- Table structure for table `fasilitas_kamar`
--

CREATE TABLE `fasilitas_kamar` (
  `uid_fasilitas` int(11) NOT NULL,
  `nama` varchar(36) NOT NULL,
  `icon` varchar(36) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `fasilitas_kamar`
--

INSERT INTO `fasilitas_kamar` (`uid_fasilitas`, `nama`, `icon`) VALUES
(1, 'AC', 'fa-solid fa-snowflake'),
(2, 'Wifi', 'fas fa-wifi'),
(3, 'Kamar Mandi Dalam', 'fas fa-shower');

-- --------------------------------------------------------

--
-- Table structure for table `gambar_kamar`
--

CREATE TABLE `gambar_kamar` (
  `uid_gambar` int(11) NOT NULL,
  `uid_kamar` varchar(36) NOT NULL,
  `gambar_satu` varchar(36) NOT NULL,
  `gambar_dua` varchar(36) NOT NULL,
  `gambar_tiga` varchar(36) NOT NULL,
  `gambar_empat` varchar(36) NOT NULL,
  `gambar_lima` varchar(36) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `gambar_kamar`
--

INSERT INTO `gambar_kamar` (`uid_gambar`, `uid_kamar`, `gambar_satu`, `gambar_dua`, `gambar_tiga`, `gambar_empat`, `gambar_lima`) VALUES
(1, '35bb8fb2-a332-46a2-b120-6de3fd93e109', 'kost1.jpg', '', '', '', ''),
(2, '2f874f9c-5392-47b5-9c7f-8fd1ff7527ad', 'kost2.jpg', '', '', '', ''),
(3, '23ac3ad8-6f61-4e3c-803b-b9bf2253ae10', 'kost3.jpg', 'kost1.jpg', 'kost2.jpg', 'kost4.jpg', 'kost5.jpg'),
(4, '59e4b078-87e5-4f1e-9127-9cd59638c871', 'kost4.jpg', '', '', '', ''),
(5, 'e1537b80-f5e0-441c-adda-d4590570c22e', 'kost5.jpg', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `kamar_kost`
--

CREATE TABLE `kamar_kost` (
  `uid_kamar` varchar(36) NOT NULL,
  `uid_gambar` varchar(11) NOT NULL,
  `uid_fasilitas` varchar(11) NOT NULL,
  `uid_durasi` varchar(11) NOT NULL,
  `uid_kategori` varchar(11) NOT NULL,
  `uid_juragan` varchar(36) NOT NULL,
  `nama` varchar(36) NOT NULL,
  `url_title` varchar(128) NOT NULL,
  `harga` int(11) NOT NULL,
  `diskon` int(11) NOT NULL,
  `deskripsi` text NOT NULL,
  `luas_kamar` varchar(16) NOT NULL,
  `alamat` varchar(225) NOT NULL,
  `provinsi` varchar(36) NOT NULL,
  `kota` varchar(36) NOT NULL,
  `lat` varchar(25) NOT NULL,
  `lng` varchar(25) NOT NULL,
  `maps` text NOT NULL,
  `status` int(11) NOT NULL,
  `date_post` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kamar_kost`
--

INSERT INTO `kamar_kost` (`uid_kamar`, `uid_gambar`, `uid_fasilitas`, `uid_durasi`, `uid_kategori`, `uid_juragan`, `nama`, `url_title`, `harga`, `diskon`, `deskripsi`, `luas_kamar`, `alamat`, `provinsi`, `kota`, `lat`, `lng`, `maps`, `status`, `date_post`) VALUES
('23ac3ad8-6f61-4e3c-803b-b9bf2253ae10', '3', '1,2,3', '1,2,3', '1', '7274edaf-f702-453b-a223-d59cd39f1309', 'Kost Perempuan Adinda No 10', 'kost-perempuana-adinda-no-10-803b', 750000, 0, 'What is Lorem Ipsum?\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '3x4', 'Jalan Samirono I No.3, Samirono, Catur Tunggal, Solo, Samirono, Caturtunggal, Kec. Depok, Kabupaten Sleman, Daerah Istimewa Yogyakarta 55281', 'DI YOGYAKARTA', 'Jogja', '-7.7754601', '110.3538055', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d26589.605047462624!2d110.36252778956195!3d-7.835457751607407!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a56537c58ea35%3A0xc4ad869d9e4dd727!2sKost%20Cendana!5e0!3m2!1sen!2sus!4v1649806505001!5m2!1sen!2sus\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>', 0, '2022-04-12 23:35:15'),
('2f874f9c-5392-47b5-9c7f-8fd1ff7527ad', '2', '2,3', '1,2,3', '1', 'b81dcd21-06ff-492a-9ec9-c7430b887184', 'Kost Putra Indie No 1', 'kost-putra-indie-no1-9c7f', 650000, 0, 'What is Lorem Ipsum?\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '3x3', 'Jalan Samirono I No.3, Samirono, Catur Tunggal, Solo, Samirono, Caturtunggal, Kec. Depok, Kabupaten Sleman, Daerah Istimewa Yogy', 'DI YOGYAKARTA', 'Jogja', '', '', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d42210.497699676715!2d110.30390208410806!3d-7.814383443550602!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xe851dbfbecd18b00!2sKost%20Amelia!5e0!3m2!1sen!2sus!4v1649806574402!5m2!1sen!2sus\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>', 0, '2022-04-12 23:36:22'),
('35bb8fb2-a332-46a2-b120-6de3fd93e109', '1', '1,2,3', '1,2,3', '1', 'b81dcd21-06ff-492a-9ec9-c7430b887184', 'Kost Singgahsini Citra', 'kost-singgahsini-citra-b120', 700000, 0, 'What is Lorem Ipsum?\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '3x4', 'Jl. Bintaran Wetan No.2, RT.3 Rw1, Wirogunan, Kec. Mergangsan, Kota Yogyakarta, Daerah Istimewa Yogyakarta 55151', 'DI YOGYAKARTA', 'Jogja', '-7.7754601', '110.3575839', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d31622.254594185193!2d110.31251535595446!3d-7.812904999999995!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7af984bc22dbe9%3A0x27e1c6ccbb37b0a3!2sKost%20Falisha!5e0!3m2!1sen!2sus!4v1649806526253!5m2!1sen!2sus\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>', 0, '2022-04-12 23:35:32'),
('59e4b078-87e5-4f1e-9127-9cd59638c871', '4', '1,2', '1,2,3', '3', 'b81dcd21-06ff-492a-9ec9-c7430b887184', 'Kost Singgahsini Citra No 10', 'kost-singgahsini-citra-no-9-9127', 800000, 0, 'What is Lorem Ipsum?\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '3x4', 'Ngebel, RT. 1 Kasihan, Geblagan, Tamantirto, Kec. Kasihan, Kabupaten Bantul, Daerah Istimewa Yogyakarta 55184', 'DI YOGYAKARTA', 'Jogja', '', '', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d39838.60998987036!2d110.35210932562589!3d-7.843609399487684!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a57d78eea269d%3A0xe28eda72c665a596!2sKost%20Putri%20Griya%20Kade!5e0!3m2!1sen!2sus!4v1649806595556!5m2!1sen!2sus\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>', 0, '2022-04-12 23:36:40'),
('e1537b80-f5e0-441c-adda-d4590570c22e', '5', '1,3', '1,2,3', '2', '7274edaf-f702-453b-a223-d59cd39f1309', 'Kost Perempuan Risman No 10', 'kost-perempuan-risman-no-8-adda', 750000, 0, 'What is Lorem Ipsum?\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '3x4', 'Jl. Kaper No.305, Sorosutan, Kec. Umbulharjo, Kota Yogyakarta, Daerah Istimewa Yogyakarta 55162', 'DI YOGYAKARTA', 'Jogja', '-7.8267015', '110.3646893,', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d31622.254594185193!2d110.31251535595446!3d-7.812904999999995!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a57a295f0f2b9%3A0xc3ca209f111e6775!2sKost%20Eksklusif%20Family%203!5e0!3m2!1sen!2sus!4v1649806540677!5m2!1sen!2sus\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>', 0, '2022-04-12 23:35:47');

-- --------------------------------------------------------

--
-- Table structure for table `kategori_kamar`
--

CREATE TABLE `kategori_kamar` (
  `uid_kategori` int(11) NOT NULL,
  `nama_kategori` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kategori_kamar`
--

INSERT INTO `kategori_kamar` (`uid_kategori`, `nama_kategori`) VALUES
(1, 'Perempuan'),
(2, 'Laki'),
(3, 'Campur');

-- --------------------------------------------------------

--
-- Table structure for table `komplain`
--

CREATE TABLE `komplain` (
  `uid_komplain` int(11) NOT NULL,
  `uid_penghuni` varchar(36) NOT NULL,
  `uid_kamar` varchar(36) NOT NULL,
  `pesan` text NOT NULL,
  `status` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `member_juragan`
--

CREATE TABLE `member_juragan` (
  `uid_juragan` varchar(36) NOT NULL,
  `email` varchar(36) NOT NULL,
  `username` varchar(16) NOT NULL,
  `password` varchar(16) NOT NULL,
  `nama` varchar(36) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `jenis_kelamin` varchar(1) NOT NULL,
  `no_hp` varchar(12) NOT NULL,
  `foto` varchar(36) NOT NULL,
  `status` int(1) NOT NULL,
  `saldo` int(11) NOT NULL,
  `saldo_released` int(11) NOT NULL,
  `date_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `member_juragan`
--

INSERT INTO `member_juragan` (`uid_juragan`, `email`, `username`, `password`, `nama`, `alamat`, `jenis_kelamin`, `no_hp`, `foto`, `status`, `saldo`, `saldo_released`, `date_created`) VALUES
('2f874f9c-5392-47b5-9c7f-8fd1ff7527ad', 'bnagantara@yahoo.com', 'maskost', 'Saddan11!', 'Jalu', 'Rejokusuman, Tamanan, Banguntapan, Bantul', 'L', '08995425248', 'profil.jpg', 1, 0, 0, '2022-03-24 08:41:21'),
('7274edaf-f702-453b-a223-d59cd39f1309', 'januputra@gmail.com', 'januputra', 'Saddan11!', 'Jalu', 'Rejokusuman, Tamanan, Banguntapan, Bantul', 'L', '08995425248', 'profil.jpg', 1, 0, 0, '2022-03-28 08:41:21'),
('b81dcd21-06ff-492a-9ec9-c7430b887184', 'bnagantara@gmail.com', 'bnagantaraid', 'Saddan11!', 'Saddan Bima Nagantara', 'Rejokusuman, Tamanan, Banguntapan, Bantul', 'L', '08995425248', 'profil.jpg', 1, 0, 0, '2022-03-24 08:41:21');

-- --------------------------------------------------------

--
-- Table structure for table `member_penghuni`
--

CREATE TABLE `member_penghuni` (
  `uid_penghuni` varchar(36) NOT NULL,
  `email` varchar(16) NOT NULL,
  `username` varchar(16) NOT NULL,
  `password` varchar(16) NOT NULL,
  `nama` varchar(36) NOT NULL,
  `no_identitas` varchar(16) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `jenis_kelamin` varchar(1) NOT NULL,
  `no_hp` varchar(12) NOT NULL,
  `foto` varchar(16) NOT NULL,
  `status` int(11) NOT NULL,
  `date_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `member_penghuni`
--

INSERT INTO `member_penghuni` (`uid_penghuni`, `email`, `username`, `password`, `nama`, `no_identitas`, `alamat`, `jenis_kelamin`, `no_hp`, `foto`, `status`, `date_created`) VALUES
('61d8fd7a-5080-4a95-b166-c0713c70ea5a', 'bnagantara@gmail', 'bnagantaraid', 'Saddan11!', 'Crystal R. Robbs', '12121212312312', '200 Layman Court\r\nGainesville, GA 30501', 'L', '08995425248', 'default.png', 1, '2022-04-13 02:00:05');

-- --------------------------------------------------------

--
-- Table structure for table `testimonial`
--

CREATE TABLE `testimonial` (
  `uid_testimonial` int(11) NOT NULL,
  `uid_kamar` varchar(36) NOT NULL,
  `uid_penghuni` varchar(36) NOT NULL,
  `anonim_status` text NOT NULL,
  `bintang` int(11) NOT NULL,
  `pesan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `testimonial`
--

INSERT INTO `testimonial` (`uid_testimonial`, `uid_kamar`, `uid_penghuni`, `anonim_status`, `bintang`, `pesan`) VALUES
(1, '35bb8fb2-a332-46a2-b120-6de3fd93e109', '61d8fd7a-5080-4a95-b166-c0713c70ea5a', '1', 4, 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Ex cupiditate tempora accusantium eligendi soluta natus repellat in at beatae nemo!'),
(2, '35bb8fb2-a332-46a2-b120-6de3fd93e109', '61d8fd7a-5080-4a95-b166-c0713c70ea5a', '1', 5, 'kost rapi'),
(3, '23ac3ad8-6f61-4e3c-803b-b9bf2253ae10', '61d8fd7a-5080-4a95-b166-c0713c70ea5a', '1', 5, 'kost murah'),
(4, '35bb8fb2-a332-46a2-b120-6de3fd93e109', '61d8fd7a-5080-4a95-b166-c0713c70ea5a', '0', 4, 'kost menarik');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_detail`
--

CREATE TABLE `transaksi_detail` (
  `uid_trxdetail` int(16) NOT NULL,
  `uid_penghuni` varchar(36) NOT NULL,
  `uid_kamar` varchar(36) NOT NULL,
  `uid_durasi` varchar(16) NOT NULL,
  `tanggal_masuk` date NOT NULL,
  `tanggal_keluar` date NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_kamar`
--

CREATE TABLE `transaksi_kamar` (
  `uid_transaksi` varchar(36) NOT NULL,
  `uid_trxdetail` int(11) NOT NULL,
  `id_pembayaran` varchar(36) NOT NULL,
  `jumlah_pembayaran` int(11) NOT NULL,
  `status_pembayaran` varchar(16) NOT NULL,
  `jenis_pembayaran` varchar(16) NOT NULL,
  `waktu_transaksi` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `administrator`
--
ALTER TABLE `administrator`
  ADD PRIMARY KEY (`uid_administrator`);

--
-- Indexes for table `chart_item`
--
ALTER TABLE `chart_item`
  ADD PRIMARY KEY (`uid_chart`),
  ADD KEY `uid_kamar` (`uid_kamar`,`uid_penghuni`);

--
-- Indexes for table `chat`
--
ALTER TABLE `chat`
  ADD PRIMARY KEY (`uid_chat`);

--
-- Indexes for table `durasi_kamar`
--
ALTER TABLE `durasi_kamar`
  ADD PRIMARY KEY (`uid_durasi`);

--
-- Indexes for table `fasilitas_kamar`
--
ALTER TABLE `fasilitas_kamar`
  ADD PRIMARY KEY (`uid_fasilitas`);

--
-- Indexes for table `gambar_kamar`
--
ALTER TABLE `gambar_kamar`
  ADD PRIMARY KEY (`uid_gambar`),
  ADD KEY `uid_kamar` (`uid_kamar`);

--
-- Indexes for table `kamar_kost`
--
ALTER TABLE `kamar_kost`
  ADD PRIMARY KEY (`uid_kamar`),
  ADD KEY `uid_gambar` (`uid_gambar`,`uid_fasilitas`,`uid_durasi`,`uid_juragan`),
  ADD KEY `uid_kategori` (`uid_kategori`);

--
-- Indexes for table `kategori_kamar`
--
ALTER TABLE `kategori_kamar`
  ADD PRIMARY KEY (`uid_kategori`);

--
-- Indexes for table `komplain`
--
ALTER TABLE `komplain`
  ADD PRIMARY KEY (`uid_komplain`);

--
-- Indexes for table `member_juragan`
--
ALTER TABLE `member_juragan`
  ADD PRIMARY KEY (`uid_juragan`);

--
-- Indexes for table `member_penghuni`
--
ALTER TABLE `member_penghuni`
  ADD PRIMARY KEY (`uid_penghuni`);

--
-- Indexes for table `testimonial`
--
ALTER TABLE `testimonial`
  ADD PRIMARY KEY (`uid_testimonial`),
  ADD KEY `uid_kamar` (`uid_kamar`,`uid_penghuni`);

--
-- Indexes for table `transaksi_detail`
--
ALTER TABLE `transaksi_detail`
  ADD PRIMARY KEY (`uid_trxdetail`),
  ADD KEY `uid_penghuni` (`uid_penghuni`,`uid_kamar`,`uid_durasi`);

--
-- Indexes for table `transaksi_kamar`
--
ALTER TABLE `transaksi_kamar`
  ADD PRIMARY KEY (`uid_transaksi`),
  ADD KEY `uid_trx` (`uid_trxdetail`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chat`
--
ALTER TABLE `chat`
  MODIFY `uid_chat` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `durasi_kamar`
--
ALTER TABLE `durasi_kamar`
  MODIFY `uid_durasi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `fasilitas_kamar`
--
ALTER TABLE `fasilitas_kamar`
  MODIFY `uid_fasilitas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `gambar_kamar`
--
ALTER TABLE `gambar_kamar`
  MODIFY `uid_gambar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `kategori_kamar`
--
ALTER TABLE `kategori_kamar`
  MODIFY `uid_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `komplain`
--
ALTER TABLE `komplain`
  MODIFY `uid_komplain` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `testimonial`
--
ALTER TABLE `testimonial`
  MODIFY `uid_testimonial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
