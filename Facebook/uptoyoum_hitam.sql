-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 14, 2018 at 12:46 PM
-- Server version: 5.6.39
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `uptoyoum_hitam`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `user` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `lastlogin` datetime NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `user`, `email`, `lastlogin`, `password`) VALUES
(1, 'harith', 'harithkhairol@gmail.com', '2018-05-14 11:54:18', 'ff9165d0be06bfcba790d28f007b34c2'),
(3, 'admin', 'admin@admin.com', '2018-05-03 12:30:07', 'e99a18c428cb38d5f260853678922e03');

-- --------------------------------------------------------

--
-- Table structure for table `aduan`
--

CREATE TABLE `aduan` (
  `id` int(11) NOT NULL,
  `tajuk` varchar(255) NOT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `bukti1` varchar(255) DEFAULT NULL,
  `bukti2` varchar(255) DEFAULT NULL,
  `bukti3` varchar(255) DEFAULT NULL,
  `bukti4` varchar(255) DEFAULT NULL,
  `ic` varchar(20) DEFAULT NULL,
  `telefon` varchar(20) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `bank` varchar(255) DEFAULT NULL,
  `penjelasan` text,
  `rugi` varchar(255) DEFAULT NULL,
  `tarikh` date DEFAULT NULL,
  `masa` time DEFAULT NULL,
  `tarikhAduan` varchar(255) NOT NULL,
  `tempatAduan` varchar(255) NOT NULL,
  `idPengadu` int(11) NOT NULL,
  `kategori` varchar(255) DEFAULT NULL,
  `aktif` enum('0','1','2','3') NOT NULL DEFAULT '0',
  `vote_up` int(11) NOT NULL,
  `vote_down` int(11) NOT NULL,
  `has_vote` enum('0','1') NOT NULL DEFAULT '0',
  `tambahanPengadu` enum('0','1','2','3') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `aduan`
--

INSERT INTO `aduan` (`id`, `tajuk`, `nama`, `gambar`, `bukti1`, `bukti2`, `bukti3`, `bukti4`, `ic`, `telefon`, `email`, `link`, `bank`, `penjelasan`, `rugi`, `tarikh`, `masa`, `tarikhAduan`, `tempatAduan`, `idPengadu`, `kategori`, `aktif`, `vote_up`, `vote_down`, `has_vote`, `tambahanPengadu`) VALUES
(1, 'Scammer Penjual Handphone', 'Ali bin Aziz', '1.jpg', '2.jpg', '3.jpg', '4.jpg', '5.jpg', '980401-23-4123', '012-3214501', '\r\nali_2019@gmail.com', 'facebook.com/user/Ali', 'CIMB 18282', 'TOLONG SHARE SEBAR. Tolong ajar kepada rakan2 / tolong ingatkan kepada kawan2. Menipu dengan jualan hp murah . Sadis berkata-kata berlagak baik menggunakan agama utk berlagak baik.', 'RM1000.00', '2018-04-06', '03:00:00', '', '', 0, NULL, '1', 8, 2, '0', '3'),
(3, 'Penyewa Rumah Puaka', 'Hazmin bin Sameon', '1.jpg', '2.jpg', '3.jpg', '4.jpg', '5.jpg', '810203-04-0101', '018-0928374', 'hazmin@yahoo.com', 'facebook.com/user/hazmin', 'MAYBANK 1920384', 'Penyewa Rumah ini tidak bayar 5 bulan dan melarikan diri. Bukan itu sahaja, dia juga mengambil semua perabot, alat perkakas, dan alat elektronik di rumah saya. Tolong sebarkan kepada semua.', 'RM4500', '2018-04-11', '02:07:07', '', '', 0, NULL, '1', 95, 6, '0', '3'),
(13, 'Kucing Puaka', 'Comel', 'aqx0rW6L_700w_0.jpg', '', '', '', '', '990102-09-8374', '013-0293847', 'comel123@gmail.com', '-', NULL, 'Kucing ni jahat.', 'RM300', '2018-04-17', '09:53:21', '', '', 43, 'Lain-Lain', '1', 3, 1, '0', '3'),
(22, 'Kucing Puaka', 'Comel', 'aqx0rW6L_700w_0.jpg', '', '', '', '', '990102-09-8374', '013-0293847', 'comel123@gmail.com', '-', NULL, 'Kucing ni jahat.', 'RM300', '2018-04-17', '09:53:21', '', '', 43, 'Lain-Lain', '1', 3, 1, '0', '3'),
(23, 'Penyewa Rumah Puaka', 'Hazmin bin Jahat', '1.jpg', '2.jpg', '3.jpg', '4.jpg', '5.jpg', '810203-04-0101', '018-0928374', 'hazmin@yahoo.com', 'facebook.com/user/hazmin', 'MAYBANK 1920384', 'Penyewa Rumah ini tidak bayar 5 bulan dan melarikan diri. Bukan itu sahaja, dia juga mengambil semua perabot, alat perkakas, dan alat elektronik di rumah saya. Tolong sebarkan kepada semua.', 'RM4500', '2018-04-11', '02:07:07', '', '', 43, NULL, '1', 2, 0, '0', '3'),
(24, 'Penyewa Rumah Jahat', 'Hazmin bin Tipu', '1.jpg', '2.jpg', '3.jpg', '4.jpg', '5.jpg', '810203-04-0101', '018-0928374', 'hazmin@yahoo.com', 'facebook.com/user/hazmin', 'MAYBANK 1920384', 'Penyewa Rumah ini tidak bayar 5 bulan dan melarikan diri. Bukan itu sahaja, dia juga mengambil semua perabot, alat perkakas, dan alat elektronik di rumah saya. Tolong sebarkan kepada semua.', 'RM4500', '2018-04-11', '02:07:07', '', '', 43, NULL, '1', 3, 0, '0', '3'),
(32, 'Anjing tipu', '', 'naruhodo.jpg', '', '', '', '', '', '', '', '', '', 'Dia suka tipu', '', '2018-05-03', '11:33:36', '', '', 43, 'Online', '0', 0, 0, '0', '1'),
(48, 'Dexter', 'Dexter Morgan', 'download.jpg', 'download.jpg', 'download.jpg', '', '', '12345678901930', '01136510720', 'test@mail.com', 'www.test.com', 'Maybank', '...', '1', '2018-05-08', '11:19:45', '2018-04-03', 'Negeri Sembilan', 48, 'Jenayah', '0', 0, 0, '0', '2');

-- --------------------------------------------------------

--
-- Table structure for table `detailpengadu`
--

CREATE TABLE `detailpengadu` (
  `id` int(11) NOT NULL,
  `aduanID` int(255) NOT NULL,
  `pengaduID` int(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `ic` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `picture` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `detailpengadu`
--

INSERT INTO `detailpengadu` (`id`, `aduanID`, `pengaduID`, `nama`, `ic`, `phone`, `email`, `picture`) VALUES
(7, 32, 43, 'Muhammad Harith Bin Khairolanuar', '970417-23-5161', '017-3622632', 'harithkhairol@gmail.com', 'user/43/ic/20180418_120523.jpg'),
(23, 48, 48, 'Dansih Danial', '960529565107', '01136510720', 'danishdanialzurkanain@gmail.com', 'user/48/ic/app_icon.png');

-- --------------------------------------------------------

--
-- Table structure for table `gambar`
--

CREATE TABLE `gambar` (
  `id` int(11) NOT NULL,
  `tajuk` varchar(255) DEFAULT NULL,
  `gambarDepan` varchar(255) DEFAULT NULL,
  `gambar1` varchar(255) DEFAULT NULL,
  `gambar2` varchar(255) DEFAULT NULL,
  `gambar3` varchar(255) DEFAULT NULL,
  `gambar4` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gambar`
--

INSERT INTO `gambar` (`id`, `tajuk`, `gambarDepan`, `gambar1`, `gambar2`, `gambar3`, `gambar4`) VALUES
(1, 'Scammer Penjual Handphone', 'van.png', NULL, NULL, NULL, NULL),
(2, 'Penipu jual baju', 'vellfire.png', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pengadu`
--

CREATE TABLE `pengadu` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `ic` varchar(20) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `picture` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `register` datetime NOT NULL,
  `lastlogin` datetime NOT NULL,
  `ip` varchar(255) NOT NULL,
  `activated` enum('0','1') NOT NULL DEFAULT '0',
  `provider` varchar(255) NOT NULL,
  `id_provider` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pengadu`
--

INSERT INTO `pengadu` (`id`, `nama`, `ic`, `phone`, `email`, `picture`, `password`, `register`, `lastlogin`, `ip`, `activated`, `provider`, `id_provider`) VALUES
(2, 'abc', '', '', 'abc', '', '900150983cd24fb0d696', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '0', '', '0'),
(3, 'koa', '', '', 'ko', '', '900150983cd24fb0d696', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '0', '', '0'),
(4, 'ahaha', '', '', 'ahaha', '', '900150983cd24fb0d696', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '0', '', '0'),
(5, 'zxc', '', '', 'zxc', '', '900150983cd24fb0d696', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '0', '', '0'),
(6, 'fgh', 'fgh', '', 'fgh', '', '900150983cd24fb0d696', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '0', '', '0'),
(8, 'qwerty', '123', '123', 'jkl', '', '900150983cd24fb0d696', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '0', '', '0'),
(9, 'harito', 'harito', 'harito', 'harito', 'harito', 'a6d15d2c7e6f3eb68e5b', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '0', '', '0'),
(10, 'bnm', 'bnm', 'bnm', 'bnm', 'bnm', 'bd93b91d4a5e9a7a5fcd', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '0', '', '0'),
(11, 'cvb', 'cvb', 'cvb', 'cvb', 'C:\\fakepath\\alza15.png', '116fa690d8dd9c3bd746', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '0', '', '0'),
(12, 'mmm', 'mmm', 'mmm', 'mmm', '', 'c4efd5020cb49b9d3257', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '0', '', '0'),
(13, 'wer', 'wer', 'wer', 'wer', '', '22c276a05aa7c90566ae', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '0', '', '0'),
(14, 'fff', 'fff', 'fff', 'fff', '', '343d9040a671c45832ee', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '0', '', '0'),
(15, '', '', '', '', 'alza15.png', '', '0000-00-00 00:00:00', '2018-04-12 00:00:00', '1', '0', '', '0'),
(16, '', '', '', '', 'axia.png', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '0', '', '0'),
(17, 'rrr', 'rrr', 'rrr', 'rrr', '', '44f437ced647ec3f40fa', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '0', '', '0'),
(18, 'sss', 'sss', 'sss', 'sss', '', '9f6e6800cfae7749eb6c', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '0', '', '0'),
(19, 'bbb', 'bbb', 'bbb', 'bbb', '', '08f8e0260c64418510ce', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '0', '', '0'),
(20, '', '', '', '', 'vellfire.png', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '0', '', '0'),
(43, 'Muhammad Harith Bin Khairolanuar', '970417-23-5161', '017-3622632', 'harithkhairol@gmail.com', 'user/43/ic/20180418_120523.jpg', 'ff9165d0be06bfcba790d28f007b34c2', '2018-04-13 00:00:00', '2018-05-14 09:44:51', '175.143.80.225', '1', '', '0'),
(45, 'AAA bin Alberqueque', '780901-43-2345', '0123421145', 'degressix@gmail.com', 'user/45/ic/aqx0rW6L_700w_0.jpg', 'ff9165d0be06bfcba790d28f007b34c2', '2018-04-24 00:00:00', '2018-05-14 10:05:17', '175.143.80.225', '1', '', '0'),
(47, 'MOHD IQBALBIN ZAINON', '850226086099', '0195057004', 'iqbalzainon@yahoo.com', 'user/47/ic/image.jpg', '5069a782e884d6bcbd32ce2d08dec01c', '2018-05-03 00:00:00', '2018-05-03 00:00:00', '175.143.83.92', '1', '', '0'),
(48, 'Dansih Danial', '960529565107', '01136510720', 'danishdanialzurkanain@gmail.com', 'user/48/ic/app_icon.png', 'd4cb1683e33b14f36db91a567ebd32eb', '2018-05-08 00:00:00', '2018-05-08 00:00:00', '175.143.82.186', '1', '', '0'),
(60, 'Harith Khairolanuar', '', '', 'degres_six@yahoo.com', '', '', '2018-05-08 16:19:39', '2018-05-14 12:41:01', '175.143.80.225', '1', 'facebook', '10215141716232958'),
(61, 'Harith Khairol', 'eheee', 'uhuuu', 'degressix@gmail.com', 'user/61/ic/Pause.png', '', '2018-05-14 09:21:59', '2018-05-14 10:05:29', '175.143.80.225', '1', 'google', '110759925187195199447');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_comment`
--

CREATE TABLE `tbl_comment` (
  `comment_id` int(11) NOT NULL,
  `parent_comment_id` int(11) DEFAULT NULL,
  `comment` varchar(200) NOT NULL,
  `comment_sender_name` varchar(40) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_comment`
--

INSERT INTO `tbl_comment` (`comment_id`, `parent_comment_id`, `comment`, `comment_sender_name`, `date`) VALUES
(1, 0, '  asd', 'asd', '2017-12-13 23:54:57'),
(2, 0, '  sss', 'Vincy', '2017-12-13 23:56:01'),
(3, 2, '  ccc', 'xc', '2017-12-13 23:56:12'),
(4, 0, 'sdf  ', 'sdf', '2017-12-13 23:58:29'),
(5, 0, '  ', 'as', '2017-12-14 00:02:32'),
(6, 0, '  sdfsdf', 'dsfdsf', '2017-12-14 00:42:44'),
(7, 0, '  ssss', 'ss', '2017-12-14 00:42:55'),
(8, 3, 'New Comment  ', 'Vincy', '2017-12-14 04:33:03'),
(9, 2, 'jj  ', 'gh', '2017-12-14 04:39:21'),
(10, 2, 'jj  ', 'ghasdsd', '2017-12-14 04:39:35'),
(11, 0, '  asdasd', 'asdasd', '2017-12-14 04:40:01'),
(12, 1, '  asdasd', 'aasd', '2017-12-14 04:40:10'),
(13, 1, 'sss  ', 'sss', '2017-12-14 04:40:38'),
(14, 0, '  asdasd', 'asdasd', '2017-12-14 04:40:55'),
(15, 1, 'vvv', 'vvv', '2017-12-14 04:41:14'),
(16, 0, '  sss', 'sss', '2017-12-14 04:51:17'),
(17, 0, '  ', '', '2017-12-14 04:51:21'),
(18, 0, '  ', '', '2017-12-14 04:51:26'),
(19, 0, '  ss', 'ss', '2017-12-14 04:51:54'),
(20, 0, '  sdsd', 'sdsds', '2017-12-14 04:52:11'),
(21, 0, '  sdsd', 'sddsd', '2017-12-14 05:14:40'),
(22, 0, 'test  ', 'vincy', '2017-12-14 05:16:25'),
(23, 21, 'test', 'Reply added by vincy', '2017-12-14 05:16:52'),
(24, 20, 'reply for sdsd  ', 'vincy', '2017-12-14 05:17:24'),
(25, 0, '  ss', 'sss', '2017-12-14 05:23:59'),
(26, 12, 'rep for asdf  ', 'vin', '2017-12-14 05:26:02');

-- --------------------------------------------------------

--
-- Table structure for table `vote`
--

CREATE TABLE `vote` (
  `id` int(11) NOT NULL,
  `pengaduID` int(255) NOT NULL,
  `namaPengadu` varchar(255) NOT NULL,
  `aduanID` int(255) NOT NULL,
  `has_vote` enum('0','1') NOT NULL,
  `lapor` varchar(255) NOT NULL,
  `tarikh` datetime NOT NULL,
  `aktif` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vote`
--

INSERT INTO `vote` (`id`, `pengaduID`, `namaPengadu`, `aduanID`, `has_vote`, `lapor`, `tarikh`, `aktif`) VALUES
(49, 43, 'Muhammad Harith Bin Khairolanuar', 1, '1', 'kucinng terbang', '2018-04-20 15:28:23', '1'),
(50, 43, 'Muhammad Harith Bin Khairolanuar', 1, '0', 'kkk', '2018-04-20 15:59:18', '1'),
(55, 43, 'Muhammad Harith Bin Khairolanuar', 1, '0', 'aaahaiihhh sabar jelaaa', '2018-04-20 15:59:20', '1'),
(90, 43, 'Muhammad Harith Bin Khairolanuar', 24, '1', 'Aku nak pukul diaaa', '2018-05-02 09:54:47', '1');

-- --------------------------------------------------------

--
-- Table structure for table `voting_count`
--

CREATE TABLE `voting_count` (
  `id` int(11) NOT NULL,
  `unique_content_id` varchar(100) NOT NULL,
  `vote_up` int(11) NOT NULL,
  `vote_down` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `voting_count`
--

INSERT INTO `voting_count` (`id`, `unique_content_id`, `vote_up`, `vote_down`) VALUES
(1, 'b8c37e33defde51cf91e1e03e51657da', 5, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `aduan`
--
ALTER TABLE `aduan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `detailpengadu`
--
ALTER TABLE `detailpengadu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gambar`
--
ALTER TABLE `gambar`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pengadu`
--
ALTER TABLE `pengadu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_comment`
--
ALTER TABLE `tbl_comment`
  ADD PRIMARY KEY (`comment_id`);

--
-- Indexes for table `vote`
--
ALTER TABLE `vote`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `voting_count`
--
ALTER TABLE `voting_count`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `aduan`
--
ALTER TABLE `aduan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `detailpengadu`
--
ALTER TABLE `detailpengadu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `gambar`
--
ALTER TABLE `gambar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pengadu`
--
ALTER TABLE `pengadu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `tbl_comment`
--
ALTER TABLE `tbl_comment`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `vote`
--
ALTER TABLE `vote`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT for table `voting_count`
--
ALTER TABLE `voting_count`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
