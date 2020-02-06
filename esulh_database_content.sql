-- phpMyAdmin SQL Dump
-- version 4.7.1
-- https://www.phpmyadmin.net/
--
-- Host: 10.4.1.136
-- Generation Time: Jun 11, 2017 at 10:20 PM
-- Server version: 10.1.24-MariaDB
-- PHP Version: 7.0.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `zakat`
--

-- --------------------------------------------------------

--
-- Table structure for table `ASNAF`
--

CREATE TABLE `ASNAF` (
  `NO_KP` bigint(12) NOT NULL,
  `NAMA` varchar(100) NOT NULL,
  `KATA_LALUAN` varchar(50) NOT NULL,
  `TEL` varchar(20) NOT NULL,
  `JLN_1` varchar(100) NOT NULL,
  `JLN_2` varchar(100) NOT NULL,
  `POSKOD` int(5) NOT NULL,
  `PERUMAHAN` varchar(4) NOT NULL,
  `BANDAR` varchar(100) NOT NULL,
  `DAERAH` varchar(4) NOT NULL,
  `NEGERI` varchar(4) NOT NULL,
  `PENDAPATAN` int(10) NOT NULL,
  `JENIS` varchar(4) NOT NULL,
  `BANK` varchar(100) NOT NULL,
  `NO_AKAUN` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `BANK`
--

CREATE TABLE `BANK` (
  `KOD_BANK` varchar(4) NOT NULL,
  `NAMA_BANK` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `BANK`
--

INSERT INTO `BANK` (`KOD_BANK`, `NAMA_BANK`) VALUES
('ABMB', 'Alliance Bank Malaysia Berhad'),
('AFNB', 'Affin Bank Berhad'),
('AGBM', 'Bank Pertanian Malaysia Berhad (Agrobank)'),
('AMBK', 'AmBank (M) Berhad'),
('BIMB', 'Bank Islam Malaysia Berhad'),
('BMMB', 'Bank Muamalat Malaysia Berhad'),
('BRKY', 'Bank Rakyat'),
('BSPN', 'Bank Simpanan Nasional (BSN)'),
('CIMB', 'CIMB Bank Berhad'),
('HLBK', 'Hong Leong Bank Berhad'),
('HSBC', 'HSBC Bank Malaysia Berhad'),
('MYBK', 'Malayan Banking Berhad (Maybank)'),
('OCBC', 'OCBC Bank (Malaysia) Berhad'),
('PBBK', 'Public Bank Berhad'),
('PUBB', 'Public Bank Berhad'),
('RHBB', 'RHB Bank Berhad');

-- --------------------------------------------------------

--
-- Table structure for table `DAERAH`
--

CREATE TABLE `DAERAH` (
  `KOD_DAERAH` varchar(4) NOT NULL,
  `NAMA_DAERAH` varchar(100) NOT NULL,
  `KOD_NEGERI` varchar(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `DAERAH`
--

INSERT INTO `DAERAH` (`KOD_DAERAH`, `NAMA_DAERAH`, `KOD_NEGERI`) VALUES
('AGJH', 'Alor Gajah', 'MELK'),
('GMBK', 'Gombak', 'SLGR'),
('HLGT', 'Hulu Langat', 'SLGR'),
('HLSL', 'Hulu Selangor', 'SLGR'),
('JASN', 'Jasin', 'MELK'),
('JLBU', 'Jelebu', 'NESM'),
('JMPL', 'Jempol', 'NESM'),
('KLGT', 'Kuala Langat', 'SLGR'),
('KLNG', 'Klang', 'SLGR'),
('KPLH', 'Kuala Pilah', 'NESM'),
('KSGR', 'Kuala Selangor', 'SLGR'),
('MTGH', 'Melaka Tengah', 'MELK'),
('PDKS', 'Port Dickson', 'NESM'),
('PTLG', 'Petaling', 'SLGR'),
('REMB', 'Rembau', 'NESM'),
('SBNM', 'Sabak Bernam', 'SLGR'),
('SEPG', 'Sepang', 'SLGR'),
('SMBN', 'Seremban', 'NESM'),
('TMPN', 'Tampin', 'NESM'),
('WPKL', 'Wilayah Persekutuan Kuala Lumpur', 'WLYH'),
('WPLB', 'Wilayah Persekutuan Labuan', 'WLYH'),
('WPPT', 'Wilayah Persekutuan Putrajaya', 'WLYH');

-- --------------------------------------------------------

--
-- Table structure for table `JENIS_ASNAF`
--

CREATE TABLE `JENIS_ASNAF` (
  `KOD_JENIS` varchar(4) NOT NULL,
  `JENIS` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `JENIS_ASNAF`
--

INSERT INTO `JENIS_ASNAF` (`KOD_JENIS`, `JENIS`) VALUES
('FKIR', 'Fakir'),
('FSBL', 'Fi Sabilillah'),
('MSKN', 'Miskin');

-- --------------------------------------------------------

--
-- Table structure for table `MUZAKKI`
--

CREATE TABLE `MUZAKKI` (
  `NO_KP` bigint(12) NOT NULL,
  `NAMA` varchar(100) NOT NULL,
  `TEL` varchar(20) NOT NULL,
  `KATA_LALUAN` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `NEGERI`
--

CREATE TABLE `NEGERI` (
  `KOD_NEGERI` varchar(4) NOT NULL,
  `NEGERI` varchar(100) NOT NULL,
  `P_ZAKAT` varchar(100) NOT NULL,
  `KATA_LALUAN` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `NEGERI`
--

INSERT INTO `NEGERI` (`KOD_NEGERI`, `NEGERI`, `P_ZAKAT`, `KATA_LALUAN`) VALUES
('MELK', 'Melaka', 'Pusat Zakat Melaka (PZM)', 'pzm'),
('NESM', 'Negeri Sembilan Darul Khusus', 'Pusat Zakat Negeri Sembilan (PZNS)', 'pzns'),
('SLGR', 'Selangor Darul Ehsan', 'Lembaga Zakat Selangor (LZS-MAIS)', 'lzs'),
('WLYH', 'Wilayah Persekutuan', 'Pusat Pungutan Zakat Wilayah (PPZ-MAIWP)', 'ppzw');

-- --------------------------------------------------------

--
-- Table structure for table `PERMOHONAN`
--

CREATE TABLE `PERMOHONAN` (
  `NO_SIRI` int(10) NOT NULL,
  `PEMOHON` bigint(12) NOT NULL,
  `NAMA` varchar(100) NOT NULL,
  `TAHUN` int(4) NOT NULL,
  `TARIKH_MOHON` datetime NOT NULL,
  `NEGERI` varchar(4) NOT NULL,
  `DAERAH` varchar(4) NOT NULL,
  `PERUMAHAN` varchar(4) NOT NULL,
  `RUMAH` int(2) DEFAULT NULL,
  `BINI_B` int(2) DEFAULT NULL,
  `BINI_M` int(2) DEFAULT NULL,
  `DEW_B` int(2) DEFAULT NULL,
  `DEW_M` int(2) DEFAULT NULL,
  `ANAK_I` int(2) DEFAULT NULL,
  `ANAK_R` int(2) DEFAULT NULL,
  `ANAK_M` int(2) DEFAULT NULL,
  `CACAT` int(2) DEFAULT NULL,
  `BAYI` int(2) DEFAULT NULL,
  `KRONIK` int(2) DEFAULT NULL,
  `PENDAPATAN` int(10) NOT NULL,
  `JENIS` varchar(4) NOT NULL,
  `KIFAYAH_BAKI` int(10) NOT NULL,
  `KIFAYAH_KREDIT` int(10) NOT NULL,
  `LOG_BAYARAN` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `PERUMAHAN`
--

CREATE TABLE `PERUMAHAN` (
  `KOD_KWSN` varchar(4) NOT NULL,
  `NAMA_KWSN` varchar(100) NOT NULL,
  `KOD_DAERAH` varchar(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `PERUMAHAN`
--

INSERT INTO `PERUMAHAN` (`KOD_KWSN`, `NAMA_KWSN`, `KOD_DAERAH`) VALUES
('AGH1', 'PR1MA Residency Alor Gajah', 'AGJH'),
('BGB1', 'Taman Sri Gombak', 'GMBK'),
('HLG1', 'Taman Sri Minang', 'HLGT'),
('HSL1', 'Taman Sri Teratai', 'HLSL'),
('JLB1', 'Taman Pembina Jaya', 'JLBU'),
('JPL1', 'Taman Indah', 'JMPL'),
('JSN1', 'Taman Jasin Height', 'JASN'),
('KLG1', 'Taman Sri Andalas', 'KLNG'),
('KLT1', 'Taman Morib', 'KLGT'),
('KPL1', 'Taman Pilah Jaya', 'KPLH'),
('KSG1', 'Taman Kuala Selangor Utama', 'KSGR'),
('MTG1', 'Taman Tasik Utama', 'MTGH'),
('PDS1', 'Taman Haji Zainal', 'PDKS'),
('PTG1', 'Taman Puchong Perdana', 'PTLG'),
('RMB1', 'Taman Sri Rembau', 'REMB'),
('SBN1', 'Taman Raya', 'SBNM'),
('SMB1', 'Taman Tasek Seremban', 'SMBN'),
('SPG1', 'Taman Ixora', 'SEPG'),
('TPN1', 'Taman Bukit Tampin', 'TMPN'),
('WPK1', 'Taman Danau Desa', 'WPKL'),
('WPL1', 'Taman Udara Sungai Bedaun', 'WPLB'),
('WPP1', 'Presint 1', 'WPPT');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ASNAF`
--
ALTER TABLE `ASNAF`
  ADD PRIMARY KEY (`NO_KP`),
  ADD KEY `DAERAH` (`DAERAH`,`NEGERI`,`PERUMAHAN`),
  ADD KEY `NEGERI` (`NEGERI`),
  ADD KEY `PERUMAHAN` (`PERUMAHAN`),
  ADD KEY `JENIS` (`JENIS`),
  ADD KEY `BANK` (`BANK`);

--
-- Indexes for table `BANK`
--
ALTER TABLE `BANK`
  ADD PRIMARY KEY (`KOD_BANK`);

--
-- Indexes for table `DAERAH`
--
ALTER TABLE `DAERAH`
  ADD PRIMARY KEY (`KOD_DAERAH`),
  ADD KEY `KOD_NEGERI` (`KOD_NEGERI`);

--
-- Indexes for table `JENIS_ASNAF`
--
ALTER TABLE `JENIS_ASNAF`
  ADD PRIMARY KEY (`KOD_JENIS`);

--
-- Indexes for table `MUZAKKI`
--
ALTER TABLE `MUZAKKI`
  ADD PRIMARY KEY (`NO_KP`);

--
-- Indexes for table `NEGERI`
--
ALTER TABLE `NEGERI`
  ADD PRIMARY KEY (`KOD_NEGERI`);

--
-- Indexes for table `PERMOHONAN`
--
ALTER TABLE `PERMOHONAN`
  ADD PRIMARY KEY (`NO_SIRI`),
  ADD KEY `PEMOHON` (`PEMOHON`),
  ADD KEY `NEGERI` (`NEGERI`),
  ADD KEY `JENIS` (`JENIS`),
  ADD KEY `PERUMAHAN` (`PERUMAHAN`),
  ADD KEY `DAERAH` (`DAERAH`);

--
-- Indexes for table `PERUMAHAN`
--
ALTER TABLE `PERUMAHAN`
  ADD PRIMARY KEY (`KOD_KWSN`),
  ADD KEY `KOD_DAERAH` (`KOD_DAERAH`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `PERMOHONAN`
--
ALTER TABLE `PERMOHONAN`
  MODIFY `NO_SIRI` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `ASNAF`
--
ALTER TABLE `ASNAF`
  ADD CONSTRAINT `asnaf_ibfk_1` FOREIGN KEY (`DAERAH`) REFERENCES `DAERAH` (`KOD_DAERAH`) ON UPDATE CASCADE,
  ADD CONSTRAINT `asnaf_ibfk_2` FOREIGN KEY (`NEGERI`) REFERENCES `NEGERI` (`KOD_NEGERI`) ON UPDATE CASCADE,
  ADD CONSTRAINT `asnaf_ibfk_3` FOREIGN KEY (`PERUMAHAN`) REFERENCES `PERUMAHAN` (`KOD_KWSN`) ON UPDATE CASCADE,
  ADD CONSTRAINT `asnaf_ibfk_4` FOREIGN KEY (`JENIS`) REFERENCES `JENIS_ASNAF` (`KOD_JENIS`) ON UPDATE CASCADE;

--
-- Constraints for table `DAERAH`
--
ALTER TABLE `DAERAH`
  ADD CONSTRAINT `daerah_ibfk_1` FOREIGN KEY (`KOD_NEGERI`) REFERENCES `NEGERI` (`KOD_NEGERI`) ON UPDATE CASCADE;

--
-- Constraints for table `PERMOHONAN`
--
ALTER TABLE `PERMOHONAN`
  ADD CONSTRAINT `permohonan_ibfk_1` FOREIGN KEY (`PEMOHON`) REFERENCES `ASNAF` (`NO_KP`) ON UPDATE CASCADE,
  ADD CONSTRAINT `permohonan_ibfk_2` FOREIGN KEY (`NEGERI`) REFERENCES `NEGERI` (`KOD_NEGERI`) ON UPDATE CASCADE,
  ADD CONSTRAINT `permohonan_ibfk_3` FOREIGN KEY (`DAERAH`) REFERENCES `DAERAH` (`KOD_DAERAH`) ON UPDATE CASCADE,
  ADD CONSTRAINT `permohonan_ibfk_4` FOREIGN KEY (`PERUMAHAN`) REFERENCES `PERUMAHAN` (`KOD_KWSN`) ON UPDATE CASCADE,
  ADD CONSTRAINT `permohonan_ibfk_5` FOREIGN KEY (`JENIS`) REFERENCES `JENIS_ASNAF` (`KOD_JENIS`) ON UPDATE CASCADE;

--
-- Constraints for table `PERUMAHAN`
--
ALTER TABLE `PERUMAHAN`
  ADD CONSTRAINT `perumahan_ibfk_1` FOREIGN KEY (`KOD_DAERAH`) REFERENCES `DAERAH` (`KOD_DAERAH`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
