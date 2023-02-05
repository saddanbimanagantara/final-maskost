-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 05 Feb 2023 pada 07.08
-- Versi server: 10.4.27-MariaDB
-- Versi PHP: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_kost`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `administrator`
--

CREATE TABLE `administrator` (
  `uid_administrator` varchar(36) NOT NULL,
  `email` varchar(16) NOT NULL,
  `username` varchar(16) NOT NULL,
  `password` varchar(16) NOT NULL,
  `nama` varchar(36) NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `chart_item`
--

CREATE TABLE `chart_item` (
  `uid_chart` varchar(36) NOT NULL,
  `uid_kamar` varchar(36) NOT NULL,
  `uid_penghuni` varchar(36) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `chat`
--

CREATE TABLE `chat` (
  `uid_chat` int(11) NOT NULL,
  `uid_pengirim` varchar(36) NOT NULL,
  `uid_penerima` varchar(36) NOT NULL,
  `message` text NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `durasi_kamar`
--

CREATE TABLE `durasi_kamar` (
  `uid_durasi` int(11) NOT NULL,
  `durasi` varchar(12) NOT NULL,
  `nama` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `durasi_kamar`
--

INSERT INTO `durasi_kamar` (`uid_durasi`, `durasi`, `nama`) VALUES
(1, '1 Bulan', '1 Bulan'),
(2, '2 Bulan', '2 Bulan'),
(3, '3 Bulan', '3 Bulan'),
(4, '4 Bulan', '4 Bulan'),
(5, '5 Bulan', '5 Bulan'),
(6, '6 Bulan', '6 Bulan'),
(7, '7 Bulan', '7 Bulan'),
(8, '8 Bulan', '8 Bulan'),
(9, '9 Bulan', '9 Bulan'),
(10, '10 Bulan', '10 Bulan'),
(11, '11 Bulan', '11 Bulan'),
(12, '12 Bulan', '12 Bulan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `fasilitas_kamar`
--

CREATE TABLE `fasilitas_kamar` (
  `uid_fasilitas` int(11) NOT NULL,
  `nama` varchar(36) NOT NULL,
  `icon` varchar(36) NOT NULL,
  `tipe` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `fasilitas_kamar`
--

INSERT INTO `fasilitas_kamar` (`uid_fasilitas`, `nama`, `icon`, `tipe`) VALUES
(1, 'AC', 'fa-solid fa-snowflake', 'kamar'),
(2, 'Wifi', 'fas fa-wifi', 'umum'),
(3, 'Kamar Mandi Dalam', 'fas fa-shower', 'kamar mandi'),
(4, 'Kamar Mandi Luar', 'fas fa-shower', 'kamar mandi'),
(5, 'mobil', 'fa-solid fa-car', 'parkiran'),
(6, 'motor', 'fa-solid fa-motorcycle', 'parkiran');

-- --------------------------------------------------------

--
-- Struktur dari tabel `gambar_kamar`
--

CREATE TABLE `gambar_kamar` (
  `uid_gambar` int(11) NOT NULL,
  `uid_kamar` varchar(36) NOT NULL,
  `gambar_satu` varchar(36) NOT NULL,
  `gambar_dua` varchar(36) NOT NULL,
  `gambar_tiga` varchar(36) NOT NULL,
  `gambar_empat` varchar(36) NOT NULL,
  `gambar_lima` varchar(36) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `gambar_kamar`
--

INSERT INTO `gambar_kamar` (`uid_gambar`, `uid_kamar`, `gambar_satu`, `gambar_dua`, `gambar_tiga`, `gambar_empat`, `gambar_lima`) VALUES
(1, '35bb8fb2-a332-46a2-b120-6de3fd93e109', 'kost1.jpg', '', '', '', ''),
(2, '2f874f9c-5392-47b5-9c7f-8fd1ff7527ad', 'kost2.jpg', '', '', '', ''),
(3, '23ac3ad8-6f61-4e3c-803b-b9bf2253ae10', 'kost3.jpg', 'kost1.jpg', 'kost2.jpg', 'kost4.jpg', 'kost5.jpg'),
(4, '59e4b078-87e5-4f1e-9127-9cd59638c871', 'kost4.jpg', '', '', '', ''),
(5, 'e1537b80-f5e0-441c-adda-d4590570c22e', 'kost5.jpg', '', '', '', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kamar_kost`
--

CREATE TABLE `kamar_kost` (
  `uid_kamar` varchar(36) NOT NULL,
  `uid_gambar` varchar(11) NOT NULL,
  `uid_fasilitas` varchar(11) NOT NULL,
  `uid_durasi` varchar(11) NOT NULL,
  `uid_kategori` varchar(11) NOT NULL,
  `uid_member` varchar(36) NOT NULL,
  `nama` varchar(36) NOT NULL,
  `tipe` varchar(11) NOT NULL DEFAULT 'A',
  `jumlah_kamar` int(11) NOT NULL,
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
  `date_post` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `update_post` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kamar_kost`
--

INSERT INTO `kamar_kost` (`uid_kamar`, `uid_gambar`, `uid_fasilitas`, `uid_durasi`, `uid_kategori`, `uid_member`, `nama`, `tipe`, `jumlah_kamar`, `url_title`, `harga`, `diskon`, `deskripsi`, `luas_kamar`, `alamat`, `provinsi`, `kota`, `lat`, `lng`, `maps`, `status`, `date_post`, `update_post`) VALUES
('23ac3ad8-6f61-4e3c-803b-b9bf2253ae10', '3', '1,2,3', '1,2,3', '1', 'e143c94a-53f1-4ef3-a562-ad798f461679', 'Kost Perempuan Adinda No 10', 'A', 5, 'kost-perempuana-adinda-no-10-803b', 750000, 0, 'What is Lorem Ipsum?\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '3x4', 'Jalan Samirono I No.3, Samirono, Catur Tunggal, Solo, Samirono, Caturtunggal, Kec. Depok, Kabupaten Sleman, Daerah Istimewa Yogyakarta 55281', 'DI YOGYAKARTA', 'Jogja', '-7.7754601', '110.3538055', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d26589.605047462624!2d110.36252778956195!3d-7.835457751607407!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a56537c58ea35%3A0xc4ad869d9e4dd727!2sKost%20Cendana!5e0!3m2!1sen!2sus!4v1649806505001!5m2!1sen!2sus\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>', 0, '2022-12-31 06:23:25', '2022-12-29 14:23:38'),
('2f874f9c-5392-47b5-9c7f-8fd1ff7527ad', '2', '2,3', '1,2,3', '1', 'e143c94a-53f1-4ef3-a562-ad798f461679', 'Kost Putra Indie No 1', 'A', 5, 'kost-putra-indie-no1-9c7f', 650000, 0, 'What is Lorem Ipsum?\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '3x3', 'Jalan Samirono I No.3, Samirono, Catur Tunggal, Solo, Samirono, Caturtunggal, Kec. Depok, Kabupaten Sleman, Daerah Istimewa Yogy', 'DI YOGYAKARTA', 'Jogja', '', '', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d42210.497699676715!2d110.30390208410806!3d-7.814383443550602!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xe851dbfbecd18b00!2sKost%20Amelia!5e0!3m2!1sen!2sus!4v1649806574402!5m2!1sen!2sus\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>', 0, '2023-02-05 06:59:22', '2022-12-29 14:23:38'),
('35bb8fb2-a332-46a2-b120-6de3fd93e109', '1', '1,2,3', '1,2,3', '1', 'e143c94a-53f1-4ef3-a562-ad798f461679', 'Kost Singgahsini Citra', 'A', 5, 'kost-singgahsini-citra-b120', 700000, 0, 'What is Lorem Ipsum?\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '3x4', 'Jl. Bintaran Wetan No.2, RT.3 Rw1, Wirogunan, Kec. Mergangsan, Kota Yogyakarta, Daerah Istimewa Yogyakarta 55151', 'DI YOGYAKARTA', 'Jogja', '-7.7754601', '110.3575839', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d31622.254594185193!2d110.31251535595446!3d-7.812904999999995!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7af984bc22dbe9%3A0x27e1c6ccbb37b0a3!2sKost%20Falisha!5e0!3m2!1sen!2sus!4v1649806526253!5m2!1sen!2sus\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>', 0, '2023-02-05 06:59:23', '2022-12-29 14:23:38'),
('59e4b078-87e5-4f1e-9127-9cd59638c871', '4', '1,2', '1,2,3', '3', 'e143c94a-53f1-4ef3-a562-ad798f461679', 'Kost Singgahsini Citra No 10', 'A', 5, 'kost-singgahsini-citra-no-9-9127', 800000, 0, 'What is Lorem Ipsum?\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '3x4', 'Ngebel, RT. 1 Kasihan, Geblagan, Tamantirto, Kec. Kasihan, Kabupaten Bantul, Daerah Istimewa Yogyakarta 55184', 'DI YOGYAKARTA', 'Jogja', '', '', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d39838.60998987036!2d110.35210932562589!3d-7.843609399487684!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a57d78eea269d%3A0xe28eda72c665a596!2sKost%20Putri%20Griya%20Kade!5e0!3m2!1sen!2sus!4v1649806595556!5m2!1sen!2sus\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>', 0, '2023-02-05 06:59:25', '2022-12-29 14:23:38'),
('e1537b80-f5e0-441c-adda-d4590570c22e', '5', '1,3', '1,2,3', '2', 'e143c94a-53f1-4ef3-a562-ad798f461679', 'Kost Perempuan Risman No 10', 'A', 5, 'kost-perempuan-risman-no-8-adda', 750000, 0, 'What is Lorem Ipsum?\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '3x4', 'Jl. Kaper No.305, Sorosutan, Kec. Umbulharjo, Kota Yogyakarta, Daerah Istimewa Yogyakarta 55162', 'DI YOGYAKARTA', 'Jogja', '-7.8267015', '110.3646893,', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d31622.254594185193!2d110.31251535595446!3d-7.812904999999995!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a57a295f0f2b9%3A0xc3ca209f111e6775!2sKost%20Eksklusif%20Family%203!5e0!3m2!1sen!2sus!4v1649806540677!5m2!1sen!2sus\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>', 0, '2023-02-05 06:59:29', '2022-12-29 14:23:38');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori_kamar`
--

CREATE TABLE `kategori_kamar` (
  `uid_kategori` int(11) NOT NULL,
  `nama_kategori` varchar(16) NOT NULL,
  `icon_kategori` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kategori_kamar`
--

INSERT INTO `kategori_kamar` (`uid_kategori`, `nama_kategori`, `icon_kategori`) VALUES
(1, 'Perempuan', ''),
(2, 'Laki', ''),
(3, 'Campur', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `keuangan`
--

CREATE TABLE `keuangan` (
  `uid_keuangan` int(11) NOT NULL,
  `uid_transaksi` varchar(36) NOT NULL,
  `uid_member` varchar(36) NOT NULL,
  `saldo_masuk` int(11) NOT NULL,
  `saldo_withdraw` int(11) NOT NULL,
  `status` varchar(36) NOT NULL,
  `deskripsi` text NOT NULL,
  `nomor_rekening` int(11) NOT NULL,
  `date_updated` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_proses` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `keuangan`
--

INSERT INTO `keuangan` (`uid_keuangan`, `uid_transaksi`, `uid_member`, `saldo_masuk`, `saldo_withdraw`, `status`, `deskripsi`, `nomor_rekening`, `date_updated`, `date_proses`) VALUES
(2, 'TX-557394654', 'e143c94a-53f1-4ef3-a562-ad798f461679', 745000, 0, 'SETTLEMENT', 'Pembayaran Kost', 0, '2022-12-31 06:02:47', '2022-12-31 06:02:47'),
(3, 'TX-457873085', 'e143c94a-53f1-4ef3-a562-ad798f461679', 745000, 0, 'SETTLEMENT', 'Pembayaran Kost', 0, '2022-12-31 06:12:22', '2022-12-31 06:12:22'),
(4, 'TX-1173608674', 'e143c94a-53f1-4ef3-a562-ad798f461679', 745000, 0, 'SETTLEMENT', 'Pembayaran Kost', 0, '2023-02-05 04:17:38', '2023-02-05 04:17:38');

-- --------------------------------------------------------

--
-- Struktur dari tabel `komplain`
--

CREATE TABLE `komplain` (
  `uid_komplain` int(11) NOT NULL,
  `uid_penghuni` varchar(36) NOT NULL,
  `uid_kamar` varchar(36) NOT NULL,
  `pesan` text NOT NULL,
  `status` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `member`
--

CREATE TABLE `member` (
  `uid_member` varchar(36) NOT NULL,
  `email` varchar(36) NOT NULL,
  `username` varchar(16) NOT NULL,
  `password` varchar(100) NOT NULL,
  `fnama` varchar(36) NOT NULL,
  `lnama` varchar(36) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `jenis_kelamin` varchar(1) NOT NULL,
  `no_hp` varchar(12) NOT NULL,
  `image` varchar(50) NOT NULL,
  `status` varchar(10) NOT NULL,
  `otoritas` varchar(36) NOT NULL,
  `saldo` int(11) NOT NULL,
  `saldo_released` int(11) NOT NULL,
  `date_created` datetime NOT NULL,
  `date_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `member`
--

INSERT INTO `member` (`uid_member`, `email`, `username`, `password`, `fnama`, `lnama`, `alamat`, `jenis_kelamin`, `no_hp`, `image`, `status`, `otoritas`, `saldo`, `saldo_released`, `date_created`, `date_updated`) VALUES
('7274edaf-f702-453b-a223-d59cd39f1309', 'januputra@gmail.com', 'januputra', '$2y$10$PnYqZj/wqXHLKHGZwE8Mpu00wIm8RyPUgGWs13/8skDSPLv4wk5Qm', 'Jalu', 'Putra', 'Rejokusuman, Tamanan, Banguntapan, Bantul', 'P', '08995425248', 'profil.jpg', '1', 'penghuni', 0, 0, '2022-03-28 08:41:21', '2022-12-31 05:40:55'),
('b81dcd21-06ff-492a-9ec9-c7430b887184', 'bnagantara@gmail.com', 'bnagantaraid', '$2y$10$PnYqZj/wqXHLKHGZwE8Mpu00wIm8RyPUgGWs13/8skDSPLv4wk5Qm', 'Saddan Bima Nagantara', '', 'Rejokusuman, Tamanan, Banguntapan, Bantul', 'L', '08995425248', 'profil.jpg', '1', 'admin', 0, 0, '2022-03-24 08:41:21', '2022-12-31 05:33:17'),
('e143c94a-53f1-4ef3-a562-ad798f461679', 'yedola8195@prolug.com', 'heruantoro', '$2y$10$bKaqahMY6dxI5wseqT3uCeLAhNC3PiSw8F2Fv1WWn3qLM.Dp1nH9S', 'heru', 'antoro', 'rejokusuman', 'L', '08995425248', 'avatar-1.png', 'aktif', 'juragan', 0, 0, '2022-12-31 12:35:16', '2022-12-31 05:35:34');

-- --------------------------------------------------------

--
-- Struktur dari tabel `member_token`
--

CREATE TABLE `member_token` (
  `uid` int(11) NOT NULL,
  `email` varchar(128) NOT NULL,
  `token` varchar(128) NOT NULL,
  `date_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `member_token`
--

INSERT INTO `member_token` (`uid`, `email`, `token`, `date_created`) VALUES
(66, 'bnagantara@gmail.com', '1604cf3cb760d90f626647693c04b6a8d261750f16fa1f26d4f63887b6f960b3129476ea', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `profit`
--

CREATE TABLE `profit` (
  `uid_profit` int(11) NOT NULL,
  `jumlah_profit` int(11) NOT NULL,
  `date_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `profit`
--

INSERT INTO `profit` (`uid_profit`, `jumlah_profit`, `date_updated`) VALUES
(1, 5000, '2022-12-31 06:02:47'),
(2, 5000, '2022-12-31 06:12:22'),
(3, 5000, '2023-02-05 04:17:38');

-- --------------------------------------------------------

--
-- Struktur dari tabel `profit_set`
--

CREATE TABLE `profit_set` (
  `set_profit_id` int(11) NOT NULL,
  `gross_amount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `profit_set`
--

INSERT INTO `profit_set` (`set_profit_id`, `gross_amount`) VALUES
(1, 5000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `rekening`
--

CREATE TABLE `rekening` (
  `uid_rekening` int(11) NOT NULL,
  `uid_member` varchar(36) NOT NULL,
  `nomor_rekening` varchar(36) NOT NULL,
  `atas_nama` varchar(100) NOT NULL,
  `nama_bank` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `testimonial`
--

CREATE TABLE `testimonial` (
  `uid_testimonial` int(11) NOT NULL,
  `uid_transaksi` varchar(36) NOT NULL,
  `uid_kamar` varchar(36) NOT NULL,
  `uid_member` varchar(36) NOT NULL,
  `anonim_status` text NOT NULL,
  `bintang` int(11) NOT NULL,
  `pesan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `testimonial`
--

INSERT INTO `testimonial` (`uid_testimonial`, `uid_transaksi`, `uid_kamar`, `uid_member`, `anonim_status`, `bintang`, `pesan`) VALUES
(5, 'TX-1173608674', '23ac3ad8-6f61-4e3c-803b-b9bf2253ae10', '7274edaf-f702-453b-a223-d59cd39f1309', '1', 5, 'bagus sekali');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi`
--

CREATE TABLE `transaksi` (
  `uid_transaksi` varchar(36) NOT NULL,
  `uid_perpanjang` varchar(36) NOT NULL,
  `id_pembayaran` varchar(36) NOT NULL,
  `jenis` text NOT NULL,
  `jumlah_pembayaran` int(11) NOT NULL,
  `status_pembayaran` text NOT NULL,
  `jenis_pembayaran` varchar(16) NOT NULL,
  `bank` varchar(5) NOT NULL,
  `va_number` varchar(36) NOT NULL,
  `payment_code` varchar(36) DEFAULT NULL,
  `reference_number` varchar(36) DEFAULT NULL,
  `pdf_url` text DEFAULT NULL,
  `waktu_transaksi` timestamp NOT NULL DEFAULT current_timestamp(),
  `tenggat_pembayaran` timestamp NULL DEFAULT NULL,
  `status_code` varchar(3) NOT NULL,
  `snapToken` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `transaksi`
--

INSERT INTO `transaksi` (`uid_transaksi`, `uid_perpanjang`, `id_pembayaran`, `jenis`, `jumlah_pembayaran`, `status_pembayaran`, `jenis_pembayaran`, `bank`, `va_number`, `payment_code`, `reference_number`, `pdf_url`, `waktu_transaksi`, `tenggat_pembayaran`, `status_code`, `snapToken`) VALUES
('TX-1173608674', 'TX-457873085', 'f40bab9f-6f4b-401f-8604-de53216cc480', 'perpanjang', 750000, 'SETTLEMENT', 'bank_transfer', 'bca', '77046176256', NULL, NULL, NULL, '2023-02-05 04:17:19', '2023-02-05 12:37:00', '200', 'b4430673-7f94-45bd-8d3c-23b6e2514ff8'),
('TX-457873085', 'TX-557394654', '25d5739d-dc4d-47b4-abe1-763efd74bc0b', 'perpanjang', 750000, 'SETTLEMENT', 'bank_transfer', 'bca', '77046709512', NULL, NULL, NULL, '2022-12-31 06:12:12', '2022-12-31 14:32:00', '200', '3d797f76-7035-4ab6-bf12-e75b30bbe8fe'),
('TX-557394654', '', 'ae0922ca-373f-401b-a74f-2378d73ce054', 'baru', 750000, 'SETTLEMENT', 'bank_transfer', 'bca', '77046829734', NULL, NULL, NULL, '2022-12-31 06:02:36', '2022-12-31 14:22:00', '200', '14e9bb53-023a-4e91-8e52-fcfd7f547172');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi_detail`
--

CREATE TABLE `transaksi_detail` (
  `uid_transaksi` varchar(36) NOT NULL,
  `uid_member` varchar(36) NOT NULL,
  `uid_kamar` varchar(36) NOT NULL,
  `uid_durasi` varchar(16) NOT NULL,
  `tanggal_masuk` date NOT NULL,
  `tanggal_keluar` date NOT NULL,
  `status` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `transaksi_detail`
--

INSERT INTO `transaksi_detail` (`uid_transaksi`, `uid_member`, `uid_kamar`, `uid_durasi`, `tanggal_masuk`, `tanggal_keluar`, `status`) VALUES
('TX-1173608674', '7274edaf-f702-453b-a223-d59cd39f1309', '23ac3ad8-6f61-4e3c-803b-b9bf2253ae10', '1', '2023-01-31', '2023-03-03', 'huni'),
('TX-457873085', '7274edaf-f702-453b-a223-d59cd39f1309', '23ac3ad8-6f61-4e3c-803b-b9bf2253ae10', '1', '2022-12-31', '2023-01-31', 'huni'),
('TX-557394654', '7274edaf-f702-453b-a223-d59cd39f1309', '23ac3ad8-6f61-4e3c-803b-b9bf2253ae10', '1', '2022-11-30', '2022-12-31', 'huni');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `administrator`
--
ALTER TABLE `administrator`
  ADD PRIMARY KEY (`uid_administrator`);

--
-- Indeks untuk tabel `chart_item`
--
ALTER TABLE `chart_item`
  ADD PRIMARY KEY (`uid_chart`),
  ADD KEY `uid_kamar` (`uid_kamar`,`uid_penghuni`);

--
-- Indeks untuk tabel `chat`
--
ALTER TABLE `chat`
  ADD PRIMARY KEY (`uid_chat`);

--
-- Indeks untuk tabel `durasi_kamar`
--
ALTER TABLE `durasi_kamar`
  ADD PRIMARY KEY (`uid_durasi`);

--
-- Indeks untuk tabel `fasilitas_kamar`
--
ALTER TABLE `fasilitas_kamar`
  ADD PRIMARY KEY (`uid_fasilitas`);

--
-- Indeks untuk tabel `gambar_kamar`
--
ALTER TABLE `gambar_kamar`
  ADD PRIMARY KEY (`uid_gambar`),
  ADD KEY `uid_kamar` (`uid_kamar`);

--
-- Indeks untuk tabel `kamar_kost`
--
ALTER TABLE `kamar_kost`
  ADD PRIMARY KEY (`uid_kamar`),
  ADD KEY `uid_gambar` (`uid_gambar`,`uid_fasilitas`,`uid_durasi`,`uid_member`),
  ADD KEY `uid_kategori` (`uid_kategori`);

--
-- Indeks untuk tabel `kategori_kamar`
--
ALTER TABLE `kategori_kamar`
  ADD PRIMARY KEY (`uid_kategori`);

--
-- Indeks untuk tabel `keuangan`
--
ALTER TABLE `keuangan`
  ADD PRIMARY KEY (`uid_keuangan`);

--
-- Indeks untuk tabel `komplain`
--
ALTER TABLE `komplain`
  ADD PRIMARY KEY (`uid_komplain`);

--
-- Indeks untuk tabel `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`uid_member`);

--
-- Indeks untuk tabel `member_token`
--
ALTER TABLE `member_token`
  ADD PRIMARY KEY (`uid`);

--
-- Indeks untuk tabel `profit`
--
ALTER TABLE `profit`
  ADD PRIMARY KEY (`uid_profit`);

--
-- Indeks untuk tabel `profit_set`
--
ALTER TABLE `profit_set`
  ADD PRIMARY KEY (`set_profit_id`);

--
-- Indeks untuk tabel `rekening`
--
ALTER TABLE `rekening`
  ADD PRIMARY KEY (`uid_rekening`);

--
-- Indeks untuk tabel `testimonial`
--
ALTER TABLE `testimonial`
  ADD PRIMARY KEY (`uid_testimonial`),
  ADD KEY `uid_kamar` (`uid_kamar`,`uid_member`);

--
-- Indeks untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`uid_transaksi`);

--
-- Indeks untuk tabel `transaksi_detail`
--
ALTER TABLE `transaksi_detail`
  ADD PRIMARY KEY (`uid_transaksi`),
  ADD KEY `uid_penghuni` (`uid_member`,`uid_kamar`,`uid_durasi`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `chat`
--
ALTER TABLE `chat`
  MODIFY `uid_chat` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `durasi_kamar`
--
ALTER TABLE `durasi_kamar`
  MODIFY `uid_durasi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `fasilitas_kamar`
--
ALTER TABLE `fasilitas_kamar`
  MODIFY `uid_fasilitas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `gambar_kamar`
--
ALTER TABLE `gambar_kamar`
  MODIFY `uid_gambar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `kategori_kamar`
--
ALTER TABLE `kategori_kamar`
  MODIFY `uid_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `keuangan`
--
ALTER TABLE `keuangan`
  MODIFY `uid_keuangan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `komplain`
--
ALTER TABLE `komplain`
  MODIFY `uid_komplain` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `member_token`
--
ALTER TABLE `member_token`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT untuk tabel `profit`
--
ALTER TABLE `profit`
  MODIFY `uid_profit` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `profit_set`
--
ALTER TABLE `profit_set`
  MODIFY `set_profit_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `rekening`
--
ALTER TABLE `rekening`
  MODIFY `uid_rekening` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `testimonial`
--
ALTER TABLE `testimonial`
  MODIFY `uid_testimonial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
