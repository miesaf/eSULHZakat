-- e-Asnaf Transfer / e-SULH Zakat: schema and reference data (no accounts, applications or suggestions).
-- NEGERI rows are the state zakat bodies (admin logins): set their passwords with tools/set-password.php.

SET NAMES latin1;
SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS `ASNAF`;
CREATE TABLE `ASNAF` (
  `NO_KP` bigint(12) NOT NULL,
  `NAMA` varchar(100) NOT NULL,
  `KATA_LALUAN` varchar(255) NOT NULL,
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
  `NO_AKAUN` varchar(50) NOT NULL,
  PRIMARY KEY (`NO_KP`),
  KEY `DAERAH` (`DAERAH`,`NEGERI`,`PERUMAHAN`),
  KEY `NEGERI` (`NEGERI`),
  KEY `PERUMAHAN` (`PERUMAHAN`),
  KEY `JENIS` (`JENIS`),
  KEY `BANK` (`BANK`),
  CONSTRAINT `asnaf_ibfk_1` FOREIGN KEY (`DAERAH`) REFERENCES `DAERAH` (`KOD_DAERAH`) ON UPDATE CASCADE,
  CONSTRAINT `asnaf_ibfk_2` FOREIGN KEY (`NEGERI`) REFERENCES `NEGERI` (`KOD_NEGERI`) ON UPDATE CASCADE,
  CONSTRAINT `asnaf_ibfk_3` FOREIGN KEY (`PERUMAHAN`) REFERENCES `PERUMAHAN` (`KOD_KWSN`) ON UPDATE CASCADE,
  CONSTRAINT `asnaf_ibfk_4` FOREIGN KEY (`JENIS`) REFERENCES `JENIS_ASNAF` (`KOD_JENIS`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

DROP TABLE IF EXISTS `BANK`;
CREATE TABLE `BANK` (
  `KOD_BANK` varchar(4) NOT NULL,
  `NAMA_BANK` varchar(50) NOT NULL,
  PRIMARY KEY (`KOD_BANK`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
INSERT INTO `BANK` VALUES
('ABMB','Alliance Bank Malaysia Berhad'),
('AFNB','Affin Bank Berhad'),
('AGBM','Bank Pertanian Malaysia Berhad (Agrobank)'),
('AMBK','AmBank (M) Berhad'),
('BIMB','Bank Islam Malaysia Berhad'),
('BMMB','Bank Muamalat Malaysia Berhad'),
('BRKY','Bank Rakyat'),
('BSPN','Bank Simpanan Nasional (BSN)'),
('CIMB','CIMB Bank Berhad'),
('HLBK','Hong Leong Bank Berhad'),
('HSBC','HSBC Bank Malaysia Berhad'),
('MYBK','Malayan Banking Berhad (Maybank)'),
('OCBC','OCBC Bank (Malaysia) Berhad'),
('PBBK','Public Bank Berhad'),
('PUBB','Public Bank Berhad'),
('RHBB','RHB Bank Berhad');

DROP TABLE IF EXISTS `CADANG_ASNAF`;
CREATE TABLE `CADANG_ASNAF` (
  `NO_KP` bigint(12) NOT NULL,
  `NAMA` varchar(100) NOT NULL,
  `TEL` varchar(20) NOT NULL,
  `JLN_1` varchar(100) NOT NULL,
  `JLN_2` varchar(100) NOT NULL,
  `POSKOD` int(5) NOT NULL,
  `PERUMAHAN` varchar(4) NOT NULL,
  `BANDAR` varchar(100) NOT NULL,
  `DAERAH` varchar(4) NOT NULL,
  `NEGERI` varchar(4) NOT NULL,
  `PENDAPATAN` int(10) NOT NULL,
  `BUKTI` text NOT NULL,
  `JENIS` varchar(4) NOT NULL,
  `BANK` varchar(100) NOT NULL,
  `NO_AKAUN` varchar(50) NOT NULL,
  PRIMARY KEY (`NO_KP`),
  KEY `DAERAH` (`DAERAH`,`NEGERI`,`PERUMAHAN`),
  KEY `NEGERI` (`NEGERI`),
  KEY `PERUMAHAN` (`PERUMAHAN`),
  KEY `JENIS` (`JENIS`),
  KEY `BANK` (`BANK`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

DROP TABLE IF EXISTS `DAERAH`;
CREATE TABLE `DAERAH` (
  `KOD_DAERAH` varchar(4) NOT NULL,
  `NAMA_DAERAH` varchar(100) NOT NULL,
  `KOD_NEGERI` varchar(4) NOT NULL,
  PRIMARY KEY (`KOD_DAERAH`),
  KEY `KOD_NEGERI` (`KOD_NEGERI`),
  CONSTRAINT `daerah_ibfk_1` FOREIGN KEY (`KOD_NEGERI`) REFERENCES `NEGERI` (`KOD_NEGERI`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
INSERT INTO `DAERAH` VALUES
('AGJH','Alor Gajah','MELK'),
('GMBK','Gombak','SLGR'),
('HLGT','Hulu Langat','SLGR'),
('HLSL','Hulu Selangor','SLGR'),
('JASN','Jasin','MELK'),
('JLBU','Jelebu','NESM'),
('JMPL','Jempol','NESM'),
('KLGT','Kuala Langat','SLGR'),
('KLNG','Klang','SLGR'),
('KPLH','Kuala Pilah','NESM'),
('KSGR','Kuala Selangor','SLGR'),
('MTGH','Melaka Tengah','MELK'),
('PDKS','Port Dickson','NESM'),
('PTLG','Petaling','SLGR'),
('REMB','Rembau','NESM'),
('SBNM','Sabak Bernam','SLGR'),
('SEPG','Sepang','SLGR'),
('SMBN','Seremban','NESM'),
('TMPN','Tampin','NESM'),
('WPKL','Wilayah Persekutuan Kuala Lumpur','WLYH'),
('WPLB','Wilayah Persekutuan Labuan','WLYH'),
('WPPT','Wilayah Persekutuan Putrajaya','WLYH');

DROP TABLE IF EXISTS `JENIS_ASNAF`;
CREATE TABLE `JENIS_ASNAF` (
  `KOD_JENIS` varchar(4) NOT NULL,
  `JENIS` varchar(50) NOT NULL,
  PRIMARY KEY (`KOD_JENIS`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
INSERT INTO `JENIS_ASNAF` VALUES
('FKIR','Fakir'),
('FSBL','Fi Sabilillah'),
('MSKN','Miskin');

DROP TABLE IF EXISTS `MUZAKKI`;
CREATE TABLE `MUZAKKI` (
  `NO_KP` bigint(12) NOT NULL,
  `NAMA` varchar(100) NOT NULL,
  `TEL` varchar(20) NOT NULL,
  `EMEL` varchar(100) NOT NULL,
  `KATA_LALUAN` varchar(255) NOT NULL,
  PRIMARY KEY (`NO_KP`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

DROP TABLE IF EXISTS `NEGERI`;
CREATE TABLE `NEGERI` (
  `KOD_NEGERI` varchar(4) NOT NULL,
  `NEGERI` varchar(100) NOT NULL,
  `P_ZAKAT` varchar(100) NOT NULL,
  `KATA_LALUAN` varchar(255) NOT NULL,
  PRIMARY KEY (`KOD_NEGERI`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
INSERT INTO `NEGERI` VALUES
('MELK','Melaka','Pusat Zakat Melaka (PZM)',''),
('NESM','Negeri Sembilan Darul Khusus','Pusat Zakat Negeri Sembilan (PZNS)',''),
('SLGR','Selangor Darul Ehsan','Lembaga Zakat Selangor (LZS-MAIS)',''),
('WLYH','Wilayah Persekutuan','Pusat Pungutan Zakat Wilayah (PPZ-MAIWP)','');

DROP TABLE IF EXISTS `PERMOHONAN`;
CREATE TABLE `PERMOHONAN` (
  `NO_SIRI` int(10) NOT NULL AUTO_INCREMENT,
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
  `LOG_BAYARAN` text NOT NULL,
  PRIMARY KEY (`NO_SIRI`),
  KEY `PEMOHON` (`PEMOHON`),
  KEY `NEGERI` (`NEGERI`),
  KEY `JENIS` (`JENIS`),
  KEY `PERUMAHAN` (`PERUMAHAN`),
  KEY `DAERAH` (`DAERAH`),
  CONSTRAINT `permohonan_ibfk_1` FOREIGN KEY (`PEMOHON`) REFERENCES `ASNAF` (`NO_KP`) ON UPDATE CASCADE,
  CONSTRAINT `permohonan_ibfk_2` FOREIGN KEY (`NEGERI`) REFERENCES `NEGERI` (`KOD_NEGERI`) ON UPDATE CASCADE,
  CONSTRAINT `permohonan_ibfk_3` FOREIGN KEY (`DAERAH`) REFERENCES `DAERAH` (`KOD_DAERAH`) ON UPDATE CASCADE,
  CONSTRAINT `permohonan_ibfk_4` FOREIGN KEY (`PERUMAHAN`) REFERENCES `PERUMAHAN` (`KOD_KWSN`) ON UPDATE CASCADE,
  CONSTRAINT `permohonan_ibfk_5` FOREIGN KEY (`JENIS`) REFERENCES `JENIS_ASNAF` (`KOD_JENIS`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

DROP TABLE IF EXISTS `PERUMAHAN`;
CREATE TABLE `PERUMAHAN` (
  `KOD_KWSN` varchar(4) NOT NULL,
  `NAMA_KWSN` varchar(100) NOT NULL,
  `KOD_DAERAH` varchar(4) NOT NULL,
  PRIMARY KEY (`KOD_KWSN`),
  KEY `KOD_DAERAH` (`KOD_DAERAH`),
  CONSTRAINT `perumahan_ibfk_1` FOREIGN KEY (`KOD_DAERAH`) REFERENCES `DAERAH` (`KOD_DAERAH`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
INSERT INTO `PERUMAHAN` VALUES
('AGH1','PR1MA Residency Alor Gajah','AGJH'),
('AGH2','Taman Lendu Bakti','AGJH'),
('AGH3','Taman Pengkalan','AGJH'),
('BGB1','Taman Sri Gombak','GMBK'),
('HLG1','Taman Sri Minang','HLGT'),
('HSL1','Taman Sri Teratai','HLSL'),
('JLB1','Taman Pembina Jaya','JLBU'),
('JPL1','Taman Indah','JMPL'),
('JSN1','Taman Jasin Height','JASN'),
('JSN2','Taman Maju','JASN'),
('JSN3','Taman Bemban','JASN'),
('JSN4','Taman Lipat Kajang Perdana','JASN'),
('KLG1','Taman Sri Andalas','KLNG'),
('KLT1','Taman Morib','KLGT'),
('KPL1','Taman Pilah Jaya','KPLH'),
('KSG1','Taman Kuala Selangor Utama','KSGR'),
('MTG1','Taman Tasik Utama','MTGH'),
('MTG2','Taman Bukit Katil Damai','MTGH'),
('MTG3','Taman Saujana Indah','MTGH'),
('MTG4','Taman Merak Mas','MTGH'),
('MTG5','Taman Merbok','MTGH'),
('PDS1','Taman Haji Zainal','PDKS'),
('PTG1','Taman Puchong Perdana','PTLG'),
('RMB1','Taman Sri Rembau','REMB'),
('SBN1','Taman Raya','SBNM'),
('SMB1','Taman Tasek Seremban','SMBN'),
('SPG1','Taman Ixora','SEPG'),
('TPN1','Taman Bukit Tampin','TMPN'),
('WPK1','Taman Danau Desa','WPKL'),
('WPL1','Taman Udara Sungai Bedaun','WPLB'),
('WPP1','Presint 1','WPPT');

SET FOREIGN_KEY_CHECKS = 1;
