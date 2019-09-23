-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 01, 2016 at 06:31 AM
-- Server version: 5.5.24
-- PHP Version: 5.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ybc`
--

DELIMITER $$
--
-- Functions
--
DROP FUNCTION IF EXISTS `CAP_FIRST`$$
CREATE DEFINER=`root`@`172.71.77.88` FUNCTION `CAP_FIRST`(input VARCHAR(255)) RETURNS varchar(255) CHARSET latin1
    DETERMINISTIC
BEGIN
	DECLARE len INT;
	DECLARE i INT;

	SET len   = CHAR_LENGTH(input);
	SET input = LOWER(input);
	SET i = 0;

	WHILE (i < len) DO
		IF (MID(input,i,1) = ' ' OR i = 0) THEN
			IF (i < len) THEN
				SET input = CONCAT(
					LEFT(input,i),
					UPPER(MID(input,i + 1,1)),
					RIGHT(input,len - i - 1)
				);
			END IF;
		END IF;
		SET i = i + 1;
	END WHILE;

	RETURN input;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

DROP TABLE IF EXISTS `ci_sessions`;
CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(45) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) DEFAULT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` longtext,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `d_admin`
--

DROP TABLE IF EXISTS `d_admin`;
CREATE TABLE IF NOT EXISTS `d_admin` (
  `admin_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `admin_emp_id` int(11) DEFAULT NULL,
  `admin_perm_grup_ids` text,
  `admin_username` varchar(150) NOT NULL,
  `admin_realname` varchar(150) NOT NULL,
  `admin_password` varchar(150) NOT NULL,
  `plant_select_type` tinyint(4) DEFAULT '0',
  `admin_selectall` varchar(150) DEFAULT NULL,
  `plants` text,
  `plant_type_id` char(3) DEFAULT NULL,
  `plant` varchar(20) DEFAULT NULL,
  `admin_add_id` int(11) DEFAULT NULL,
  `add_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `admin_edit_id` int(11) DEFAULT NULL,
  `edit_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `initial_code` varchar(55) DEFAULT NULL,
  `dept_manager` varchar(55) DEFAULT NULL,
  `admin_email` varchar(155) DEFAULT NULL,
  `admin_phone` varchar(35) DEFAULT NULL,
  `admin_level` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1: stocker; 2: mod; 3: SM; 4: AM; 21: SX; 22: SX-Supervisor; 23: SX-Ass-Manager; 24: SX-Manager; 31: SX-OM; 32: SX-GM; 33: SX-BOD; 71: IT-Staff; 72: IT-Spv; 73: IT-Manager;',
  `admin_rfcusername` varchar(21) DEFAULT 'IN_WEB_JAM',
  `admin_lastlogin` datetime DEFAULT NULL,
  `admin_ipaddress` varchar(100) DEFAULT NULL,
  `admin_altemail` varchar(155) DEFAULT NULL,
  `admin_cellphone1` varchar(155) DEFAULT NULL,
  `admin_cellphone2` varchar(155) DEFAULT NULL,
  `admin_photo` varchar(255) DEFAULT NULL,
  `admin_profileupdate` datetime DEFAULT NULL,
  `admin_isoutlet` tinyint(1) DEFAULT '0',
  `password_reset` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`admin_id`),
  UNIQUE KEY `admin_username` (`admin_username`),
  KEY `user_pass` (`admin_username`,`admin_password`),
  KEY `pass_reset` (`password_reset`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='User Administrator' AUTO_INCREMENT=1968 ;

--
-- Dumping data for table `d_admin`
--

INSERT INTO `d_admin` (`admin_id`, `admin_emp_id`, `admin_perm_grup_ids`, `admin_username`, `admin_realname`, `admin_password`, `plant_select_type`, `admin_selectall`, `plants`, `plant_type_id`, `plant`, `admin_add_id`, `add_time`, `admin_edit_id`, `edit_time`, `initial_code`, `dept_manager`, `admin_email`, `admin_phone`, `admin_level`, `admin_rfcusername`, `admin_lastlogin`, `admin_ipaddress`, `admin_altemail`, `admin_cellphone1`, `admin_cellphone2`, `admin_photo`, `admin_profileupdate`, `admin_isoutlet`, `password_reset`) VALUES
(22, NULL, ' 11, ', 'ybc_manager', 'YBC (Manager)', '5221cf7507655edb165c10eac6d54c22', 0, NULL, ' YBC1, ', 'YBC', 'YBC1', NULL, '0000-00-00 00:00:00', 1282, '2016-08-01 06:17:44', '', '', '', NULL, 3, 'SAP_RFC_USER01', '2016-08-01 07:00:34', '127.0.0.1', NULL, NULL, NULL, NULL, NULL, 1, NULL),
(1964, 0, ' 2, ', 'yesaya.norman', 'Yesaya Norman', '5221cf7507655edb165c10eac6d54c22', 0, 'BID, JID, ', ' YBC1, YBC2, YBC3, ', 'YBC', 'YBC1', 1568, '2016-07-14 10:41:33', 1568, '2016-08-01 06:24:17', NULL, NULL, 'yesaya.norman@ybc.co.id', NULL, 0, 'SAP_RFC_USER01', '2016-08-01 13:24:17', '127.0.0.1', NULL, NULL, NULL, NULL, NULL, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `d_employee_absent`
--

DROP TABLE IF EXISTS `d_employee_absent`;
CREATE TABLE IF NOT EXISTS `d_employee_absent` (
  `absent_id` int(11) NOT NULL AUTO_INCREMENT,
  `absent_emp_id` int(11) DEFAULT NULL,
  `absent_date` date DEFAULT NULL,
  `absent_type` varchar(50) DEFAULT NULL,
  `absent_note` varchar(50) DEFAULT NULL,
  `absent_endofday` tinyint(4) NOT NULL DEFAULT '0',
  `absent_status_proses` tinyint(1) DEFAULT '0',
  `absent_eod_lock` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`absent_id`),
  KEY `ABSEN` (`absent_emp_id`,`absent_date`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `d_employee_req`
--

DROP TABLE IF EXISTS `d_employee_req`;
CREATE TABLE IF NOT EXISTS `d_employee_req` (
  `employee_req_id` int(11) NOT NULL AUTO_INCREMENT,
  `emp_id` int(11) NOT NULL DEFAULT '0',
  `req_status_kerja` varchar(50) DEFAULT NULL,
  `req_jumlah` int(11) DEFAULT NULL,
  `req_type` varchar(50) DEFAULT NULL,
  `req_start_date` date NOT NULL,
  `req_marital` varchar(50) DEFAULT NULL,
  `req_kelamin` varchar(50) DEFAULT NULL,
  `req_education` varchar(50) DEFAULT NULL,
  `req_umur` int(11) DEFAULT NULL,
  `req_pengalaman` varchar(50) DEFAULT NULL,
  `req_others` text,
  `req_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`employee_req_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `d_employee_shift`
--

DROP TABLE IF EXISTS `d_employee_shift`;
CREATE TABLE IF NOT EXISTS `d_employee_shift` (
  `shift_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `shift_emp_id` int(11) NOT NULL,
  `shift_date` date NOT NULL,
  `shift_code` int(5) DEFAULT NULL,
  `shift_status_proses` tinyint(1) DEFAULT '0',
  `shift_eod_lock` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`shift_id`),
  KEY `SHIFTDATE` (`shift_date`),
  KEY `SHIFTCODE` (`shift_code`),
  KEY `SHIFTEMPID` (`shift_emp_id`),
  KEY `ADDUPDATE` (`shift_emp_id`,`shift_date`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `d_endofmonth`
--

DROP TABLE IF EXISTS `d_endofmonth`;
CREATE TABLE IF NOT EXISTS `d_endofmonth` (
  `endofmonth_id` int(11) NOT NULL AUTO_INCREMENT,
  `kode_outlet` varchar(50) DEFAULT NULL,
  `period_type` varchar(10) DEFAULT NULL,
  `periode` varchar(10) DEFAULT NULL,
  `eom_status` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`endofmonth_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `d_perm_group`
--

DROP TABLE IF EXISTS `d_perm_group`;
CREATE TABLE IF NOT EXISTS `d_perm_group` (
  `group_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `group_order` int(10) unsigned DEFAULT NULL,
  `group_name` varchar(50) DEFAULT NULL,
  `group_perms` text,
  `group_ids_manage` text,
  PRIMARY KEY (`group_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=47 ;

--
-- Dumping data for table `d_perm_group`
--

INSERT INTO `d_perm_group` (`group_id`, `group_order`, `group_name`, `group_perms`, `group_ids_manage`) VALUES
(1, 1, 'Not Approved', 'aa06aa07aa08aa11aa12aa13aa14aa26aa27', NULL),
(2, 2, 'Super Admin', '*', NULL),
(3, 10, 'Outlet YBC - Supervisor', 'aa10aa20aa25aa30aa35aa45aa50aa55aa80ac30ac35ac115ac120ad10ad15ad20af601ah90101ah90102', NULL),
(11, 9, 'Outlet YBC - Manager', 'aa10aa20aa25aa30aa35aa45aa50aa55aa80ac30ac35ac115ac120ad10ad15ad20ad25af601ag80101ag80102ag80103ag80201ag80301ag80302ag80305ah90101ah90102', NULL),
(13, 11, 'Outlet YBC - Staff', 'aa10aa20aa25aa30aa35aa45aa50aa55ac30ac115ac120af601', NULL),
(14, 8, 'Area Manager YBC', 'aa10aa20aa25aa30aa35aa45aa50aa55aa80ac30ac35ac115ac120ad10ad15ad20ad25ae200ae210ae220af601ag80101ag80102ag80103ag80201ag80301ag80302ag80305ah90101ah90102al170101', NULL),
(20, 13, 'HQ Inventory', 'aa10aa20aa25aa30aa35aa45aa50aa55aa60aa80ab10ab100ac30ac35ac115ac120ac125ac514ad10ad15ad20ad25ae210af601', NULL),
(21, 14, 'HQ Controlling', 'aa10aa100ab110ac115ac120ac125ac514ac515ad10ad15ad20ad25ae210af601', NULL),
(22, 15, 'HQ Manager', 'ac35ac120ae200ae210', NULL),
(23, 16, 'Purchase Requisition (PR)', 'aa45aa50', NULL),
(24, 17, 'Request Additional Stock', 'aa50', NULL),
(27, 20, 'HRD', 'ag80101ag80102ag80103ag80104ag80201ag80301ag80302ag80305ag80306', NULL),
(32, 25, 'HR EOM', 'ag80104', NULL),
(33, 26, 'HR Employee  Master', 'ag80201', NULL),
(36, 28, 'HR Reports', 'ag80301ag80302ag80305', NULL),
(37, 29, 'Sinkronisasi All', 'ak120100ak120101ak120102ak120103ak120104ak120105', NULL),
(38, 30, 'Sinkronisasi Material', 'ak120100ak120101ak120102', NULL),
(39, 31, 'Sinkronisasi HRMS', 'ae200ae210ak120100ak120103ak120104ak120105', NULL),
(42, 34, 'BOD', 'ac35ac115ac120ac514ae200ae210ae50101ae50103ae50201ag80301ag80302ag80306ah90101ah90102ai1001ai100201al170101', NULL),
(44, 36, 'Reset Opname', 'aa100', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `d_running_number`
--

DROP TABLE IF EXISTS `d_running_number`;
CREATE TABLE IF NOT EXISTS `d_running_number` (
  `id_running_number` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `module_name` varchar(20) DEFAULT NULL,
  `id_outlet` int(11) DEFAULT NULL,
  `last_date` date DEFAULT NULL,
  `running_number` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_running_number`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `d_support`
--

DROP TABLE IF EXISTS `d_support`;
CREATE TABLE IF NOT EXISTS `d_support` (
  `support_name` varchar(70) NOT NULL,
  `plant_type_id` char(3) NOT NULL,
  `plants` text,
  `support_job` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '0:all, 1:spv, 2:staff, 3:AM, 7:IT',
  `support_tel` varchar(45) NOT NULL DEFAULT '-',
  `support_mail` varchar(45) NOT NULL DEFAULT '-',
  `support_ext` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`support_name`,`plant_type_id`,`support_job`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `m_absent_type`
--

DROP TABLE IF EXISTS `m_absent_type`;
CREATE TABLE IF NOT EXISTS `m_absent_type` (
  `type_code` int(11) NOT NULL AUTO_INCREMENT,
  `type_name` varchar(100) DEFAULT NULL,
  `type_active` int(11) NOT NULL DEFAULT '1',
  `kode_absent` varchar(10) NOT NULL,
  `kode_absent_system` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`type_code`),
  KEY `ABSEN` (`type_active`),
  KEY `ABSEN2` (`kode_absent`,`type_active`),
  KEY `KODEABSEN` (`kode_absent`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=338 ;

--
-- Dumping data for table `m_absent_type`
--

INSERT INTO `m_absent_type` (`type_code`, `type_name`, `type_active`, `kode_absent`, `kode_absent_system`) VALUES
(26, 'ABSENSI MANUAL', 1, 'AM', 'AM'),
(27, 'COLLECTIVE LEAVE', 0, 'CL', 'CBT'),
(28, 'ADVANCE LEAVE', 0, 'ADVL', 'CH'),
(29, 'CUTI OFF', 1, 'CO', 'CO'),
(30, 'PUBLIC HOLIDAY', 1, 'PH', 'PH'),
(31, 'CUTI RESMI', 0, 'CR', 'CR'),
(32, 'CUTI MENIKAH', 1, 'ML', 'CR'),
(33, 'FAMILY PASS AWAY LEAVE', 0, 'PSAL', 'CR'),
(34, 'CHILDREN CIRCUMCISION LEAVE', 0, 'CCL', 'CR'),
(35, 'PATERNITY LEAVE', 0, 'PTL', 'CR'),
(36, 'CUTI MELAHIRKAN', 1, 'MTL', 'MTL'),
(37, 'RELIGIOUS LEAVE', 0, 'RL', 'CR'),
(38, 'CUTI PUBLIC HOLIDAY', 1, 'CPH', 'CPH'),
(39, 'DISASTER LEAVE', 0, 'DSL', 'CR'),
(40, 'ANNUAL LEAVE', 1, 'AL', 'CT'),
(41, 'CUTI UNPAID', 1, 'UL', 'CU'),
(42, 'DINAS LUAR', 0, 'DL', 'DL'),
(43, 'LATE', 0, 'LT', 'DT'),
(44, 'LATE1', 0, 'LT1', 'DT1'),
(45, 'INPUT ABSEN', 0, 'IASX', 'I'),
(46, 'IZIN DATANG TERLAMBAT', 1, 'IDT', 'IDT'),
(47, 'IZIN PULANG CEPAT', 1, 'IPC', 'IPC'),
(48, 'LONG SHIFT MALAM', 0, 'LM', 'LM'),
(49, 'LONG SHIFT', 0, 'LS', 'LS'),
(50, 'OFF', 1, 'O', 'O'),
(51, 'SAKIT DENGAN SURAT DOKTER', 1, 'SWL', 'S'),
(52, 'SAKIT TANPA SURAT DOKTER', 0, 'SNL', 'S'),
(53, 'TRANSPORT MALAM', 0, 'TM', 'TM'),
(334, 'RESIGN', 1, 'R', 'A'),
(335, 'CUTI KELUARGA MENINGGAL', 1, 'CKM', 'CR'),
(336, 'CUTI HUTANG', 1, 'CH', 'CH'),
(337, 'IZIN CUTI KHUSUS', 0, 'ICK', 'MTL');

-- --------------------------------------------------------

--
-- Table structure for table `m_bagian`
--

DROP TABLE IF EXISTS `m_bagian`;
CREATE TABLE IF NOT EXISTS `m_bagian` (
  `kode_bagian` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `nama_bagian` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `kode_dept` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`kode_bagian`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `m_cuti_ph`
--

DROP TABLE IF EXISTS `m_cuti_ph`;
CREATE TABLE IF NOT EXISTS `m_cuti_ph` (
  `employee_id` int(11) NOT NULL,
  `tanggal_ph` date NOT NULL,
  `keterangan` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tanggal_exp_ph` date DEFAULT NULL,
  `status` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`employee_id`,`tanggal_ph`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `m_cuti_ph`
--

INSERT INTO `m_cuti_ph` (`employee_id`, `tanggal_ph`, `keterangan`, `tanggal_exp_ph`, `status`) VALUES
(0, '2013-01-01', 'Tahun Baru', '2013-04-01', 2),
(0, '2013-01-24', 'Maulid Muhammad Saw', '2013-04-24', 2),
(0, '2013-02-10', 'Tahun Baru Imlek 2564', '2013-05-10', 2),
(0, '2013-03-12', 'Nyepi', '2013-06-12', 2),
(0, '2013-03-29', 'Wafat Isa Almasih', '2013-06-29', 2),
(0, '2013-05-09', 'Kenaikan Isa Almasih', '2013-08-09', 2),
(0, '2013-05-25', 'Waisak', '2013-08-25', 2),
(0, '2013-06-06', 'Isra Miraj', '2013-09-06', 2),
(0, '2013-08-08', 'Idul Fitri', '2013-11-08', 2),
(0, '2013-08-09', 'Idul Fitri', '2013-11-09', 2),
(0, '2013-08-17', 'Kemerdekaan RI', '2013-11-17', 2),
(0, '2013-10-15', 'Idul Adha', '2014-01-15', 3),
(0, '2013-11-05', 'Tahun Baru Hijriah', '2014-02-05', 3),
(0, '2013-12-25', 'Natal', '2014-03-25', 1),
(0, '2014-01-01', 'Tahun Baru 2014', '2014-04-01', 1),
(0, '2014-01-14', 'Maulid Nabi Muhammad', '2014-04-14', 1),
(0, '2014-01-31', 'Imlek 2565', '2014-04-30', 3),
(0, '2014-03-31', 'Nyepi', '2014-06-30', 3),
(0, '2014-04-09', 'PEMILU LEGISLATIF', '2014-07-09', 1),
(0, '2014-04-18', 'Wafat Isa Almasih', '2014-07-18', 1),
(0, '2014-05-01', 'Hari Buruh', '2014-08-01', 1),
(0, '2014-05-15', 'Waisak', '2014-08-15', 1),
(0, '2014-05-27', 'Isra Miraj', '2014-08-27', 1),
(0, '2014-05-29', 'Kenaikan Isa Almasih', '2014-08-29', 1),
(0, '2014-07-09', 'PEMILU PRESIDEN', '2014-10-09', 1),
(0, '2014-07-28', 'IDUL FITRI', '2014-10-28', 1),
(0, '2014-07-29', 'IDUL FITRI 2', '2014-10-29', 1),
(0, '2014-08-17', 'Kemerdekaan RI', '2014-11-17', 1),
(0, '2014-10-05', 'Idul Adha', '2015-01-05', 1),
(0, '2014-10-25', 'Tahun Baru Hijriyah', '2015-01-25', 1),
(0, '2014-12-25', 'Natal', '2015-03-25', 3),
(0, '2015-01-01', 'TAHUN BARU', '2015-04-01', 3),
(0, '2015-01-03', 'MAULID NABI MUHAMMAD SAW', '2015-04-03', 3),
(0, '2015-02-19', 'TAHUN BARU IMLEK', '2015-05-19', 1),
(0, '2015-03-21', 'HARI RAYA NYEPI', '2015-06-21', 3),
(0, '2015-04-03', 'WAFAT YESUS KRISTUS', '2015-07-03', 3),
(0, '2015-05-01', 'HARI BURUH INTERNATIONAL', '2015-08-01', 3),
(0, '2015-05-14', 'KENAIKAN YESUS KRISTUS', '2015-08-14', 3),
(0, '2015-05-16', 'ISRA MIRAJ', '2015-08-16', 3),
(0, '2015-06-02', 'WAISAK', '2015-09-02', 1),
(0, '2015-07-17', 'IDUL FITRI', '2015-10-17', 1),
(0, '2015-07-18', 'IDUL FITRI 2', '2015-10-18', 1),
(0, '2015-08-17', 'KEMERDEKAAN RI', '2015-11-17', 1),
(0, '2015-09-24', 'IDUL ADHA', '2015-12-24', 3),
(0, '2015-10-14', 'TAHUN BARU HIJRIYAH', '2016-01-14', 3),
(0, '2015-12-09', 'PILKADA', '2016-03-09', 3),
(0, '2015-12-24', 'MAULID NABI', '2016-03-24', 3),
(0, '2015-12-25', 'NATAL', '2016-03-25', 3),
(0, '2016-01-01', 'Tahun Baru', '2016-04-01', 3),
(0, '2016-02-08', 'Imlek', '2016-05-08', 1),
(0, '2016-03-09', 'Nyepi', '2016-06-09', 1),
(0, '2016-03-25', 'Wafat Yesus Kristus', '2016-06-25', 1),
(0, '2016-05-01', 'Hari Buruh', '2016-08-01', 0),
(0, '2016-05-05', 'Isra Miraj & Kenaikan Yesus', '2016-08-05', 0),
(0, '2016-05-06', 'Isra Miraj', '2016-08-06', 0),
(0, '2016-05-22', 'Waisak', '2016-08-22', 0),
(0, '2016-07-06', 'Idul Fitri', '2016-10-06', 0),
(0, '2016-07-07', 'Idul Fitri_2', '2016-10-07', 0),
(0, '2016-08-17', 'Kemerdekaan', '2016-11-17', 0),
(1, '2013-01-01', 'Tahun Baru', '2013-04-01', 2),
(1, '2013-01-24', 'Maulid Muhammad Saw', '2013-04-24', 2),
(1, '2013-02-10', 'Tahun Baru Imlek 2564', '2013-05-10', 2),
(1, '2013-03-12', 'Nyepi', '2013-06-12', 2),
(1, '2013-03-29', 'Wafat Isa Almasih', '2013-06-29', 2),
(1, '2013-05-09', 'Kenaikan Isa Almasih', '2013-08-09', 2),
(1, '2013-05-25', 'Waisak', '2013-08-25', 2),
(1, '2013-06-06', 'Isra Miraj', '2013-09-06', 2),
(1, '2013-08-08', 'Idul Fitri', '2013-11-08', 2),
(1, '2013-08-09', 'Idul Fitri', '2013-11-09', 2),
(1, '2013-08-17', 'Kemerdekaan RI', '2013-11-17', 2),
(1, '2013-10-15', 'Idul Adha', '2014-01-15', 2),
(1, '2013-11-05', 'Tahun Baru Hijriah', '2014-02-05', 2),
(1, '2013-12-25', 'Natal', '2014-03-25', 2),
(1, '2014-01-01', 'Tahun Baru 2014', '2014-04-01', 2),
(1, '2014-01-14', 'Maulid Nabi Muhammad', '2014-04-14', 2),
(1, '2014-01-31', 'Imlek 2565', '2014-04-30', 2),
(1, '2014-03-31', 'Nyepi', '2014-06-30', 2),
(1, '2014-04-09', 'PEMILU LEGISLATIF', '2014-07-09', 2),
(1, '2014-04-18', 'Wafat Isa Almasih', '2014-07-18', 2),
(1, '2014-05-01', 'Hari Buruh', '2014-08-01', 2),
(1, '2014-05-15', 'Waisak', '2014-08-15', 2),
(1, '2014-05-27', 'Isra Miraj', '2014-08-27', 2),
(1, '2014-05-29', 'Kenaikan Isa Almasih', '2014-08-29', 2),
(1, '2014-07-09', 'PEMILU PRESIDEN', '2014-10-09', 2),
(1, '2014-07-28', 'IDUL FITRI', '2014-10-28', 2),
(1, '2014-07-29', 'IDUL FITRI 2', '2014-10-29', 2),
(1, '2014-08-17', 'Kemerdekaan RI', '2014-11-17', 2),
(1, '2014-10-05', 'Idul Adha', '2015-01-05', 2),
(1, '2014-10-25', 'Tahun Baru Hijriyah', '2015-01-25', 1),
(1, '2014-12-25', 'Natal', '2015-03-25', 2),
(1, '2015-01-01', 'TAHUN BARU', '2015-04-01', 2),
(1, '2015-01-03', 'MAULID NABI MUHAMMAD SAW', '2015-04-03', 2),
(1, '2015-02-19', 'TAHUN BARU IMLEK', '2015-05-19', 2),
(1, '2015-03-21', 'HARI RAYA NYEPI', '2015-06-21', 2),
(1, '2015-04-03', 'WAFAT YESUS KRISTUS', '2015-07-03', 2),
(1, '2015-05-01', 'HARI BURUH INTERNATIONAL', '2015-08-01', 2),
(1, '2015-05-14', 'KENAIKAN YESUS KRISTUS', '2015-08-14', 2),
(1, '2015-05-16', 'ISRA MIRAJ', '2015-08-16', 2),
(1, '2015-06-02', 'WAISAK', '2015-09-02', 2),
(1, '2015-07-17', 'IDUL FITRI', '2015-10-17', 2),
(1, '2015-07-18', 'IDUL FITRI 2', '2015-10-18', 2),
(1, '2015-08-17', 'KEMERDEKAAN RI', '2015-11-17', 2),
(1, '2015-09-24', 'IDUL ADHA', '2015-12-24', 2),
(1, '2015-10-14', 'TAHUN BARU HIJRIYAH', '2016-01-14', 2),
(1, '2015-12-09', 'PILKADA', '2016-03-09', 2),
(1, '2015-12-24', 'MAULID NABI', '2016-03-24', 2),
(1, '2015-12-25', 'NATAL', '2016-03-25', 2),
(1, '2016-01-01', 'Tahun Baru', '2016-04-01', 2),
(1, '2016-02-08', 'Imlek', '2016-05-08', 2),
(1, '2016-03-09', 'Nyepi', '2016-06-09', 2),
(1, '2016-03-25', 'Wafat Yesus Kristus', '2016-06-25', 2),
(1, '2016-05-01', 'Hari Buruh', '2016-08-01', 2),
(1, '2016-05-05', 'Isra Miraj & Kenaikan Yesus', '2016-08-05', 2),
(1, '2016-05-06', 'Isra Miraj', '2016-08-06', 2),
(1, '2016-05-22', 'Waisak', '2016-08-22', 2),
(1, '2016-07-06', 'Idul Fitri', '2016-10-06', 2),
(1, '2016-07-07', 'Idul Fitri_2', '2016-10-07', 2),
(1, '2016-08-17', 'Kemerdekaan', '2016-11-17', 0),
(3, '2013-01-01', 'Tahun Baru', '2013-04-01', 2),
(3, '2013-01-24', 'Maulid Muhammad Saw', '2013-04-24', 2),
(3, '2013-02-10', 'Tahun Baru Imlek 2564', '2013-05-10', 2),
(3, '2013-03-12', 'Nyepi', '2013-06-12', 2),
(3, '2013-03-29', 'Wafat Isa Almasih', '2013-06-29', 2),
(3, '2013-05-09', 'Kenaikan Isa Almasih', '2013-08-09', 2),
(3, '2013-05-25', 'Waisak', '2013-08-25', 2),
(3, '2013-06-06', 'Isra Miraj', '2013-09-06', 2),
(3, '2013-08-08', 'Idul Fitri', '2013-11-08', 2),
(3, '2013-08-09', 'Idul Fitri', '2013-11-09', 2),
(3, '2013-08-17', 'Kemerdekaan RI', '2013-11-17', 2),
(3, '2013-10-15', 'Idul Adha', '2014-01-15', 1),
(3, '2013-11-05', 'Tahun Baru Hijriah', '2014-02-05', 1),
(3, '2013-12-25', 'Natal', '2014-03-25', 1),
(3, '2014-01-01', 'Tahun Baru 2014', '2014-04-01', 1),
(3, '2014-01-14', 'Maulid Nabi Muhammad', '2014-04-14', 1),
(3, '2014-01-31', 'Imlek 2565', '2014-04-30', 1),
(3, '2014-03-31', 'Nyepi', '2014-06-30', 1),
(3, '2014-04-09', 'PEMILU LEGISLATIF', '2014-07-09', 1),
(3, '2014-04-18', 'Wafat Isa Almasih', '2014-07-18', 1),
(3, '2014-05-01', 'Hari Buruh', '2014-08-01', 1),
(3, '2014-05-15', 'Waisak', '2014-08-15', 1),
(3, '2014-05-27', 'Isra Miraj', '2014-08-27', 1),
(3, '2014-05-29', 'Kenaikan Isa Almasih', '2014-08-29', 1),
(3, '2014-07-09', 'PEMILU PRESIDEN', '2014-10-09', 1),
(3, '2014-07-28', 'IDUL FITRI', '2014-10-28', 1),
(3, '2014-07-29', 'IDUL FITRI 2', '2014-10-29', 1),
(3, '2014-08-17', 'Kemerdekaan RI', '2014-11-17', 1),
(3, '2014-10-05', 'Idul Adha', '2015-01-05', 1),
(3, '2014-10-25', 'Tahun Baru Hijriyah', '2015-01-25', 1),
(3, '2014-12-25', 'Natal', '2015-03-25', 1),
(3, '2015-01-01', 'TAHUN BARU', '2015-04-01', 1),
(3, '2015-01-03', 'MAULID NABI MUHAMMAD SAW', '2015-04-03', 1),
(3, '2015-02-19', 'TAHUN BARU IMLEK', '2015-05-19', 1),
(3, '2015-03-21', 'HARI RAYA NYEPI', '2015-06-21', 1),
(3, '2015-04-03', 'WAFAT YESUS KRISTUS', '2015-07-03', 1),
(3, '2015-05-01', 'HARI BURUH INTERNATIONAL', '2015-08-01', 1),
(3, '2015-05-14', 'KENAIKAN YESUS KRISTUS', '2015-08-14', 1),
(3, '2015-05-16', 'ISRA MIRAJ', '2015-08-16', 1),
(3, '2015-06-02', 'WAISAK', '2015-09-02', 1),
(3, '2015-07-17', 'IDUL FITRI', '2015-10-17', 1),
(3, '2015-07-18', 'IDUL FITRI 2', '2015-10-18', 1),
(3, '2015-08-17', 'KEMERDEKAAN RI', '2015-11-17', 1),
(3, '2015-09-24', 'IDUL ADHA', '2015-12-24', 1),
(3, '2015-10-14', 'TAHUN BARU HIJRIYAH', '2016-01-14', 1),
(3, '2015-12-09', 'PILKADA', '2016-03-09', 1),
(3, '2015-12-24', 'MAULID NABI', '2016-03-24', 1),
(3, '2015-12-25', 'NATAL', '2016-03-25', 1),
(3, '2016-01-01', 'Tahun Baru', '2016-04-01', 1),
(3, '2016-02-08', 'Imlek', '2016-05-08', 1),
(3, '2016-03-09', 'Nyepi', '2016-06-09', 1),
(3, '2016-03-25', 'Wafat Yesus Kristus', '2016-06-25', 1),
(3, '2016-05-01', 'Hari Buruh', '2016-08-01', 0),
(3, '2016-05-05', 'Isra Miraj & Kenaikan Yesus', '2016-08-05', 0),
(3, '2016-05-06', 'Isra Miraj', '2016-08-06', 0),
(3, '2016-05-22', 'Waisak', '2016-08-22', 0),
(3, '2016-07-06', 'Idul Fitri', '2016-10-06', 0),
(3, '2016-07-07', 'Idul Fitri_2', '2016-10-07', 0),
(3, '2016-08-17', 'Kemerdekaan', '2016-11-17', 0),
(4, '2013-01-01', 'Tahun Baru', '2013-04-01', 2),
(4, '2013-01-24', 'Maulid Muhammad Saw', '2013-04-24', 2),
(4, '2013-02-10', 'Tahun Baru Imlek 2564', '2013-05-10', 2),
(4, '2013-03-12', 'Nyepi', '2013-06-12', 2),
(4, '2013-03-29', 'Wafat Isa Almasih', '2013-06-29', 2),
(4, '2013-05-09', 'Kenaikan Isa Almasih', '2013-08-09', 2),
(4, '2013-05-25', 'Waisak', '2013-08-25', 2),
(4, '2013-06-06', 'Isra Miraj', '2013-09-06', 2),
(4, '2013-08-08', 'Idul Fitri', '2013-11-08', 2),
(4, '2013-08-09', 'Idul Fitri', '2013-11-09', 2),
(4, '2013-08-17', 'Kemerdekaan RI', '2013-11-17', 2),
(4, '2013-10-15', 'Idul Adha', '2014-01-15', 1),
(4, '2013-11-05', 'Tahun Baru Hijriah', '2014-02-05', 1),
(4, '2013-12-25', 'Natal', '2014-03-25', 1),
(4, '2014-01-01', 'Tahun Baru 2014', '2014-04-01', 1),
(4, '2014-01-14', 'Maulid Nabi Muhammad', '2014-04-14', 1),
(4, '2014-01-31', 'Imlek 2565', '2014-04-30', 1),
(4, '2014-03-31', 'Nyepi', '2014-06-30', 1),
(4, '2014-04-09', 'PEMILU LEGISLATIF', '2014-07-09', 1),
(4, '2014-04-18', 'Wafat Isa Almasih', '2014-07-18', 1),
(4, '2014-05-01', 'Hari Buruh', '2014-08-01', 1),
(4, '2014-05-15', 'Waisak', '2014-08-15', 1),
(4, '2014-05-27', 'Isra Miraj', '2014-08-27', 1),
(4, '2014-05-29', 'Kenaikan Isa Almasih', '2014-08-29', 1),
(4, '2014-07-09', 'PEMILU PRESIDEN', '2014-10-09', 1),
(4, '2014-07-28', 'IDUL FITRI', '2014-10-28', 1),
(4, '2014-07-29', 'IDUL FITRI 2', '2014-10-29', 1),
(4, '2014-08-17', 'Kemerdekaan RI', '2014-11-17', 1),
(4, '2014-10-05', 'Idul Adha', '2015-01-05', 1),
(4, '2014-10-25', 'Tahun Baru Hijriyah', '2015-01-25', 1),
(4, '2014-12-25', 'Natal', '2015-03-25', 1),
(4, '2015-01-01', 'TAHUN BARU', '2015-04-01', 1),
(4, '2015-01-03', 'MAULID NABI MUHAMMAD SAW', '2015-04-03', 1),
(4, '2015-02-19', 'TAHUN BARU IMLEK', '2015-05-19', 1),
(4, '2015-03-21', 'HARI RAYA NYEPI', '2015-06-21', 1),
(4, '2015-04-03', 'WAFAT YESUS KRISTUS', '2015-07-03', 1),
(4, '2015-05-01', 'HARI BURUH INTERNATIONAL', '2015-08-01', 1),
(4, '2015-05-14', 'KENAIKAN YESUS KRISTUS', '2015-08-14', 1),
(4, '2015-05-16', 'ISRA MIRAJ', '2015-08-16', 1),
(4, '2015-06-02', 'WAISAK', '2015-09-02', 1),
(4, '2015-07-17', 'IDUL FITRI', '2015-10-17', 1),
(4, '2015-07-18', 'IDUL FITRI 2', '2015-10-18', 1),
(4, '2015-08-17', 'KEMERDEKAAN RI', '2015-11-17', 1),
(4, '2015-09-24', 'IDUL ADHA', '2015-12-24', 1),
(4, '2015-10-14', 'TAHUN BARU HIJRIYAH', '2016-01-14', 1),
(4, '2015-12-09', 'PILKADA', '2016-03-09', 1),
(4, '2015-12-24', 'MAULID NABI', '2016-03-24', 1),
(4, '2015-12-25', 'NATAL', '2016-03-25', 1),
(4, '2016-01-01', 'Tahun Baru', '2016-04-01', 1),
(4, '2016-02-08', 'Imlek', '2016-05-08', 1),
(4, '2016-03-09', 'Nyepi', '2016-06-09', 1),
(4, '2016-03-25', 'Wafat Yesus Kristus', '2016-06-25', 1),
(4, '2016-05-01', 'Hari Buruh', '2016-08-01', 0),
(4, '2016-05-05', 'Isra Miraj & Kenaikan Yesus', '2016-08-05', 0),
(4, '2016-05-06', 'Isra Miraj', '2016-08-06', 0),
(4, '2016-05-22', 'Waisak', '2016-08-22', 0),
(4, '2016-07-06', 'Idul Fitri', '2016-10-06', 0),
(4, '2016-07-07', 'Idul Fitri_2', '2016-10-07', 0),
(4, '2016-08-17', 'Kemerdekaan', '2016-11-17', 0),
(5, '2013-01-01', 'Tahun Baru', '2013-04-01', 2),
(5, '2013-01-24', 'Maulid Muhammad Saw', '2013-04-24', 2),
(5, '2013-02-10', 'Tahun Baru Imlek 2564', '2013-05-10', 2),
(5, '2013-03-12', 'Nyepi', '2013-06-12', 2),
(5, '2013-03-29', 'Wafat Isa Almasih', '2013-06-29', 2),
(5, '2013-05-09', 'Kenaikan Isa Almasih', '2013-08-09', 2),
(5, '2013-05-25', 'Waisak', '2013-08-25', 2),
(5, '2013-06-06', 'Isra Miraj', '2013-09-06', 2),
(5, '2013-08-08', 'Idul Fitri', '2013-11-08', 2),
(5, '2013-08-09', 'Idul Fitri', '2013-11-09', 2),
(5, '2013-08-17', 'Kemerdekaan RI', '2013-11-17', 2),
(5, '2013-10-15', 'Idul Adha', '2014-01-15', 1),
(5, '2013-11-05', 'Tahun Baru Hijriah', '2014-02-05', 1),
(5, '2013-12-25', 'Natal', '2014-03-25', 1),
(5, '2014-01-01', 'Tahun Baru 2014', '2014-04-01', 1),
(5, '2014-01-14', 'Maulid Nabi Muhammad', '2014-04-14', 1),
(5, '2014-01-31', 'Imlek 2565', '2014-04-30', 1),
(5, '2014-03-31', 'Nyepi', '2014-06-30', 1),
(5, '2014-04-09', 'PEMILU LEGISLATIF', '2014-07-09', 1),
(5, '2014-04-18', 'Wafat Isa Almasih', '2014-07-18', 1),
(5, '2014-05-01', 'Hari Buruh', '2014-08-01', 1),
(5, '2014-05-15', 'Waisak', '2014-08-15', 1),
(5, '2014-05-27', 'Isra Miraj', '2014-08-27', 1),
(5, '2014-05-29', 'Kenaikan Isa Almasih', '2014-08-29', 1),
(5, '2014-07-09', 'PEMILU PRESIDEN', '2014-10-09', 1),
(5, '2014-07-28', 'IDUL FITRI', '2014-10-28', 1),
(5, '2014-07-29', 'IDUL FITRI 2', '2014-10-29', 1),
(5, '2014-08-17', 'Kemerdekaan RI', '2014-11-17', 1),
(5, '2014-10-05', 'Idul Adha', '2015-01-05', 1),
(5, '2014-10-25', 'Tahun Baru Hijriyah', '2015-01-25', 1),
(5, '2014-12-25', 'Natal', '2015-03-25', 1),
(5, '2015-01-01', 'TAHUN BARU', '2015-04-01', 1),
(5, '2015-01-03', 'MAULID NABI MUHAMMAD SAW', '2015-04-03', 1),
(5, '2015-02-19', 'TAHUN BARU IMLEK', '2015-05-19', 1),
(5, '2015-03-21', 'HARI RAYA NYEPI', '2015-06-21', 1),
(5, '2015-04-03', 'WAFAT YESUS KRISTUS', '2015-07-03', 1),
(5, '2015-05-01', 'HARI BURUH INTERNATIONAL', '2015-08-01', 1),
(5, '2015-05-14', 'KENAIKAN YESUS KRISTUS', '2015-08-14', 1),
(5, '2015-05-16', 'ISRA MIRAJ', '2015-08-16', 1),
(5, '2015-06-02', 'WAISAK', '2015-09-02', 1),
(5, '2015-07-17', 'IDUL FITRI', '2015-10-17', 1),
(5, '2015-07-18', 'IDUL FITRI 2', '2015-10-18', 1),
(5, '2015-08-17', 'KEMERDEKAAN RI', '2015-11-17', 1),
(5, '2015-09-24', 'IDUL ADHA', '2015-12-24', 1),
(5, '2015-10-14', 'TAHUN BARU HIJRIYAH', '2016-01-14', 1),
(5, '2015-12-09', 'PILKADA', '2016-03-09', 1),
(5, '2015-12-24', 'MAULID NABI', '2016-03-24', 1),
(5, '2015-12-25', 'NATAL', '2016-03-25', 1),
(5, '2016-01-01', 'Tahun Baru', '2016-04-01', 1),
(5, '2016-02-08', 'Imlek', '2016-05-08', 1),
(5, '2016-03-09', 'Nyepi', '2016-06-09', 1),
(5, '2016-03-25', 'Wafat Yesus Kristus', '2016-06-25', 1),
(5, '2016-05-01', 'Hari Buruh', '2016-08-01', 0),
(5, '2016-05-05', 'Isra Miraj & Kenaikan Yesus', '2016-08-05', 0),
(5, '2016-05-06', 'Isra Miraj', '2016-08-06', 0),
(5, '2016-05-22', 'Waisak', '2016-08-22', 0),
(5, '2016-07-06', 'Idul Fitri', '2016-10-06', 0),
(5, '2016-07-07', 'Idul Fitri_2', '2016-10-07', 0),
(5, '2016-08-17', 'Kemerdekaan', '2016-11-17', 0),
(6, '2013-01-01', 'Tahun Baru', '2013-04-01', 2),
(6, '2013-01-24', 'Maulid Muhammad Saw', '2013-04-24', 2),
(6, '2013-02-10', 'Tahun Baru Imlek 2564', '2013-05-10', 2),
(6, '2013-03-12', 'Nyepi', '2013-06-12', 2),
(6, '2013-03-29', 'Wafat Isa Almasih', '2013-06-29', 2),
(6, '2013-05-09', 'Kenaikan Isa Almasih', '2013-08-09', 2),
(6, '2013-05-25', 'Waisak', '2013-08-25', 2),
(6, '2013-06-06', 'Isra Miraj', '2013-09-06', 2),
(6, '2013-08-08', 'Idul Fitri', '2013-11-08', 2),
(6, '2013-08-09', 'Idul Fitri', '2013-11-09', 2),
(6, '2013-08-17', 'Kemerdekaan RI', '2013-11-17', 2),
(6, '2013-10-15', 'Idul Adha', '2014-01-15', 1),
(6, '2013-11-05', 'Tahun Baru Hijriah', '2014-02-05', 1),
(6, '2013-12-25', 'Natal', '2014-03-25', 1),
(6, '2014-01-01', 'Tahun Baru 2014', '2014-04-01', 1),
(6, '2014-01-14', 'Maulid Nabi Muhammad', '2014-04-14', 1),
(6, '2014-01-31', 'Imlek 2565', '2014-04-30', 1),
(6, '2014-03-31', 'Nyepi', '2014-06-30', 1),
(6, '2014-04-09', 'PEMILU LEGISLATIF', '2014-07-09', 1),
(6, '2014-04-18', 'Wafat Isa Almasih', '2014-07-18', 1),
(6, '2014-05-01', 'Hari Buruh', '2014-08-01', 1),
(6, '2014-05-15', 'Waisak', '2014-08-15', 1),
(6, '2014-05-27', 'Isra Miraj', '2014-08-27', 1),
(6, '2014-05-29', 'Kenaikan Isa Almasih', '2014-08-29', 1),
(6, '2014-07-09', 'PEMILU PRESIDEN', '2014-10-09', 1),
(6, '2014-07-28', 'IDUL FITRI', '2014-10-28', 1),
(6, '2014-07-29', 'IDUL FITRI 2', '2014-10-29', 1),
(6, '2014-08-17', 'Kemerdekaan RI', '2014-11-17', 1),
(6, '2014-10-05', 'Idul Adha', '2015-01-05', 1),
(6, '2014-10-25', 'Tahun Baru Hijriyah', '2015-01-25', 1),
(6, '2014-12-25', 'Natal', '2015-03-25', 1),
(6, '2015-01-01', 'TAHUN BARU', '2015-04-01', 1),
(6, '2015-01-03', 'MAULID NABI MUHAMMAD SAW', '2015-04-03', 1),
(6, '2015-02-19', 'TAHUN BARU IMLEK', '2015-05-19', 1),
(6, '2015-03-21', 'HARI RAYA NYEPI', '2015-06-21', 1),
(6, '2015-04-03', 'WAFAT YESUS KRISTUS', '2015-07-03', 1),
(6, '2015-05-01', 'HARI BURUH INTERNATIONAL', '2015-08-01', 1),
(6, '2015-05-14', 'KENAIKAN YESUS KRISTUS', '2015-08-14', 1),
(6, '2015-05-16', 'ISRA MIRAJ', '2015-08-16', 1),
(6, '2015-06-02', 'WAISAK', '2015-09-02', 1),
(6, '2015-07-17', 'IDUL FITRI', '2015-10-17', 1),
(6, '2015-07-18', 'IDUL FITRI 2', '2015-10-18', 1),
(6, '2015-08-17', 'KEMERDEKAAN RI', '2015-11-17', 1),
(6, '2015-09-24', 'IDUL ADHA', '2015-12-24', 1),
(6, '2015-10-14', 'TAHUN BARU HIJRIYAH', '2016-01-14', 1),
(6, '2015-12-09', 'PILKADA', '2016-03-09', 1),
(6, '2015-12-24', 'MAULID NABI', '2016-03-24', 1),
(6, '2015-12-25', 'NATAL', '2016-03-25', 1),
(6, '2016-01-01', 'Tahun Baru', '2016-04-01', 1),
(6, '2016-02-08', 'Imlek', '2016-05-08', 1),
(6, '2016-03-09', 'Nyepi', '2016-06-09', 1),
(6, '2016-03-25', 'Wafat Yesus Kristus', '2016-06-25', 1),
(6, '2016-05-01', 'Hari Buruh', '2016-08-01', 0),
(6, '2016-05-05', 'Isra Miraj & Kenaikan Yesus', '2016-08-05', 0),
(6, '2016-05-06', 'Isra Miraj', '2016-08-06', 0),
(6, '2016-05-22', 'Waisak', '2016-08-22', 0),
(6, '2016-07-06', 'Idul Fitri', '2016-10-06', 0),
(6, '2016-07-07', 'Idul Fitri_2', '2016-10-07', 0),
(6, '2016-08-17', 'Kemerdekaan', '2016-11-17', 0),
(7, '2013-01-01', 'Tahun Baru', '2013-04-01', 2),
(7, '2013-01-24', 'Maulid Muhammad Saw', '2013-04-24', 2),
(7, '2013-02-10', 'Tahun Baru Imlek 2564', '2013-05-10', 2),
(7, '2013-03-12', 'Nyepi', '2013-06-12', 2),
(7, '2013-03-29', 'Wafat Isa Almasih', '2013-06-29', 2),
(7, '2013-05-09', 'Kenaikan Isa Almasih', '2013-08-09', 2),
(7, '2013-05-25', 'Waisak', '2013-08-25', 2),
(7, '2013-06-06', 'Isra Miraj', '2013-09-06', 2),
(7, '2013-08-08', 'Idul Fitri', '2013-11-08', 2),
(7, '2013-08-09', 'Idul Fitri', '2013-11-09', 2),
(7, '2013-08-17', 'Kemerdekaan RI', '2013-11-17', 2),
(7, '2013-10-15', 'Idul Adha', '2014-01-15', 1),
(7, '2013-11-05', 'Tahun Baru Hijriah', '2014-02-05', 1),
(7, '2013-12-25', 'Natal', '2014-03-25', 1),
(7, '2014-01-01', 'Tahun Baru 2014', '2014-04-01', 1),
(7, '2014-01-14', 'Maulid Nabi Muhammad', '2014-04-14', 1),
(7, '2014-01-31', 'Imlek 2565', '2014-04-30', 1),
(7, '2014-03-31', 'Nyepi', '2014-06-30', 1),
(7, '2014-04-09', 'PEMILU LEGISLATIF', '2014-07-09', 1),
(7, '2014-04-18', 'Wafat Isa Almasih', '2014-07-18', 1),
(7, '2014-05-01', 'Hari Buruh', '2014-08-01', 1),
(7, '2014-05-15', 'Waisak', '2014-08-15', 1),
(7, '2014-05-27', 'Isra Miraj', '2014-08-27', 1),
(7, '2014-05-29', 'Kenaikan Isa Almasih', '2014-08-29', 1),
(7, '2014-07-09', 'PEMILU PRESIDEN', '2014-10-09', 1),
(7, '2014-07-28', 'IDUL FITRI', '2014-10-28', 1),
(7, '2014-07-29', 'IDUL FITRI 2', '2014-10-29', 1),
(7, '2014-08-17', 'Kemerdekaan RI', '2014-11-17', 1),
(7, '2014-10-05', 'Idul Adha', '2015-01-05', 1),
(7, '2014-10-25', 'Tahun Baru Hijriyah', '2015-01-25', 1),
(7, '2014-12-25', 'Natal', '2015-03-25', 1),
(7, '2015-01-01', 'TAHUN BARU', '2015-04-01', 1),
(7, '2015-01-03', 'MAULID NABI MUHAMMAD SAW', '2015-04-03', 1),
(7, '2015-02-19', 'TAHUN BARU IMLEK', '2015-05-19', 1),
(7, '2015-03-21', 'HARI RAYA NYEPI', '2015-06-21', 1),
(7, '2015-04-03', 'WAFAT YESUS KRISTUS', '2015-07-03', 1),
(7, '2015-05-01', 'HARI BURUH INTERNATIONAL', '2015-08-01', 1),
(7, '2015-05-14', 'KENAIKAN YESUS KRISTUS', '2015-08-14', 1),
(7, '2015-05-16', 'ISRA MIRAJ', '2015-08-16', 1),
(7, '2015-06-02', 'WAISAK', '2015-09-02', 1),
(7, '2015-07-17', 'IDUL FITRI', '2015-10-17', 1),
(7, '2015-07-18', 'IDUL FITRI 2', '2015-10-18', 1),
(7, '2015-08-17', 'KEMERDEKAAN RI', '2015-11-17', 1),
(7, '2015-09-24', 'IDUL ADHA', '2015-12-24', 1),
(7, '2015-10-14', 'TAHUN BARU HIJRIYAH', '2016-01-14', 1),
(7, '2015-12-09', 'PILKADA', '2016-03-09', 1),
(7, '2015-12-24', 'MAULID NABI', '2016-03-24', 1),
(7, '2015-12-25', 'NATAL', '2016-03-25', 1),
(7, '2016-01-01', 'Tahun Baru', '2016-04-01', 1),
(7, '2016-02-08', 'Imlek', '2016-05-08', 1),
(7, '2016-03-09', 'Nyepi', '2016-06-09', 1),
(7, '2016-03-25', 'Wafat Yesus Kristus', '2016-06-25', 1),
(7, '2016-05-01', 'Hari Buruh', '2016-08-01', 0),
(7, '2016-05-05', 'Isra Miraj & Kenaikan Yesus', '2016-08-05', 0),
(7, '2016-05-06', 'Isra Miraj', '2016-08-06', 0),
(7, '2016-05-22', 'Waisak', '2016-08-22', 0),
(7, '2016-07-06', 'Idul Fitri', '2016-10-06', 0),
(7, '2016-07-07', 'Idul Fitri_2', '2016-10-07', 0),
(7, '2016-08-17', 'Kemerdekaan', '2016-11-17', 0),
(8, '2013-01-01', 'Tahun Baru', '2013-04-01', 2),
(8, '2013-01-24', 'Maulid Muhammad Saw', '2013-04-24', 2),
(8, '2013-02-10', 'Tahun Baru Imlek 2564', '2013-05-10', 2),
(8, '2013-03-12', 'Nyepi', '2013-06-12', 2),
(8, '2013-03-29', 'Wafat Isa Almasih', '2013-06-29', 2),
(8, '2013-05-09', 'Kenaikan Isa Almasih', '2013-08-09', 2),
(8, '2013-05-25', 'Waisak', '2013-08-25', 2),
(8, '2013-06-06', 'Isra Miraj', '2013-09-06', 2),
(8, '2013-08-08', 'Idul Fitri', '2013-11-08', 2),
(8, '2013-08-09', 'Idul Fitri', '2013-11-09', 2),
(8, '2013-08-17', 'Kemerdekaan RI', '2013-11-17', 2),
(8, '2013-10-15', 'Idul Adha', '2014-01-15', 1),
(8, '2013-11-05', 'Tahun Baru Hijriah', '2014-02-05', 1),
(8, '2013-12-25', 'Natal', '2014-03-25', 1),
(8, '2014-01-01', 'Tahun Baru 2014', '2014-04-01', 1),
(8, '2014-01-14', 'Maulid Nabi Muhammad', '2014-04-14', 1),
(8, '2014-01-31', 'Imlek 2565', '2014-04-30', 1),
(8, '2014-03-31', 'Nyepi', '2014-06-30', 1),
(8, '2014-04-09', 'PEMILU LEGISLATIF', '2014-07-09', 1),
(8, '2014-04-18', 'Wafat Isa Almasih', '2014-07-18', 1),
(8, '2014-05-01', 'Hari Buruh', '2014-08-01', 1),
(8, '2014-05-15', 'Waisak', '2014-08-15', 1),
(8, '2014-05-27', 'Isra Miraj', '2014-08-27', 1),
(8, '2014-05-29', 'Kenaikan Isa Almasih', '2014-08-29', 1),
(8, '2014-07-09', 'PEMILU PRESIDEN', '2014-10-09', 1),
(8, '2014-07-28', 'IDUL FITRI', '2014-10-28', 1),
(8, '2014-07-29', 'IDUL FITRI 2', '2014-10-29', 1),
(8, '2014-08-17', 'Kemerdekaan RI', '2014-11-17', 1),
(8, '2014-10-05', 'Idul Adha', '2015-01-05', 1),
(8, '2014-10-25', 'Tahun Baru Hijriyah', '2015-01-25', 1),
(8, '2014-12-25', 'Natal', '2015-03-25', 1),
(8, '2015-01-01', 'TAHUN BARU', '2015-04-01', 1),
(8, '2015-01-03', 'MAULID NABI MUHAMMAD SAW', '2015-04-03', 1),
(8, '2015-02-19', 'TAHUN BARU IMLEK', '2015-05-19', 1),
(8, '2015-03-21', 'HARI RAYA NYEPI', '2015-06-21', 1),
(8, '2015-04-03', 'WAFAT YESUS KRISTUS', '2015-07-03', 1),
(8, '2015-05-01', 'HARI BURUH INTERNATIONAL', '2015-08-01', 1),
(8, '2015-05-14', 'KENAIKAN YESUS KRISTUS', '2015-08-14', 1),
(8, '2015-05-16', 'ISRA MIRAJ', '2015-08-16', 1),
(8, '2015-06-02', 'WAISAK', '2015-09-02', 1),
(8, '2015-07-17', 'IDUL FITRI', '2015-10-17', 1),
(8, '2015-07-18', 'IDUL FITRI 2', '2015-10-18', 1),
(8, '2015-08-17', 'KEMERDEKAAN RI', '2015-11-17', 1),
(8, '2015-09-24', 'IDUL ADHA', '2015-12-24', 1),
(8, '2015-10-14', 'TAHUN BARU HIJRIYAH', '2016-01-14', 1),
(8, '2015-12-09', 'PILKADA', '2016-03-09', 1),
(8, '2015-12-24', 'MAULID NABI', '2016-03-24', 1),
(8, '2015-12-25', 'NATAL', '2016-03-25', 1),
(8, '2016-01-01', 'Tahun Baru', '2016-04-01', 1),
(8, '2016-02-08', 'Imlek', '2016-05-08', 1),
(8, '2016-03-09', 'Nyepi', '2016-06-09', 1),
(8, '2016-03-25', 'Wafat Yesus Kristus', '2016-06-25', 1),
(8, '2016-05-01', 'Hari Buruh', '2016-08-01', 0),
(8, '2016-05-05', 'Isra Miraj & Kenaikan Yesus', '2016-08-05', 0),
(8, '2016-05-06', 'Isra Miraj', '2016-08-06', 0),
(8, '2016-05-22', 'Waisak', '2016-08-22', 0),
(8, '2016-07-06', 'Idul Fitri', '2016-10-06', 0),
(8, '2016-07-07', 'Idul Fitri_2', '2016-10-07', 0),
(8, '2016-08-17', 'Kemerdekaan', '2016-11-17', 0),
(9, '2013-01-01', 'Tahun Baru', '2013-04-01', 2),
(9, '2013-01-24', 'Maulid Muhammad Saw', '2013-04-24', 2),
(9, '2013-02-10', 'Tahun Baru Imlek 2564', '2013-05-10', 2),
(9, '2013-03-12', 'Nyepi', '2013-06-12', 2),
(9, '2013-03-29', 'Wafat Isa Almasih', '2013-06-29', 2),
(9, '2013-05-09', 'Kenaikan Isa Almasih', '2013-08-09', 2),
(9, '2013-05-25', 'Waisak', '2013-08-25', 2),
(9, '2013-06-06', 'Isra Miraj', '2013-09-06', 2),
(9, '2013-08-08', 'Idul Fitri', '2013-11-08', 2),
(9, '2013-08-09', 'Idul Fitri', '2013-11-09', 2),
(9, '2013-08-17', 'Kemerdekaan RI', '2013-11-17', 2),
(9, '2013-10-15', 'Idul Adha', '2014-01-15', 1),
(9, '2013-11-05', 'Tahun Baru Hijriah', '2014-02-05', 1),
(9, '2013-12-25', 'Natal', '2014-03-25', 1),
(9, '2014-01-01', 'Tahun Baru 2014', '2014-04-01', 1),
(9, '2014-01-14', 'Maulid Nabi Muhammad', '2014-04-14', 1),
(9, '2014-01-31', 'Imlek 2565', '2014-04-30', 1),
(9, '2014-03-31', 'Nyepi', '2014-06-30', 1),
(9, '2014-04-09', 'PEMILU LEGISLATIF', '2014-07-09', 1),
(9, '2014-04-18', 'Wafat Isa Almasih', '2014-07-18', 1),
(9, '2014-05-01', 'Hari Buruh', '2014-08-01', 1),
(9, '2014-05-15', 'Waisak', '2014-08-15', 1),
(9, '2014-05-27', 'Isra Miraj', '2014-08-27', 1),
(9, '2014-05-29', 'Kenaikan Isa Almasih', '2014-08-29', 1),
(9, '2014-07-09', 'PEMILU PRESIDEN', '2014-10-09', 1),
(9, '2014-07-28', 'IDUL FITRI', '2014-10-28', 1),
(9, '2014-07-29', 'IDUL FITRI 2', '2014-10-29', 1),
(9, '2014-08-17', 'Kemerdekaan RI', '2014-11-17', 1),
(9, '2014-10-05', 'Idul Adha', '2015-01-05', 1),
(9, '2014-10-25', 'Tahun Baru Hijriyah', '2015-01-25', 1),
(9, '2014-12-25', 'Natal', '2015-03-25', 1),
(9, '2015-01-01', 'TAHUN BARU', '2015-04-01', 1),
(9, '2015-01-03', 'MAULID NABI MUHAMMAD SAW', '2015-04-03', 1),
(9, '2015-02-19', 'TAHUN BARU IMLEK', '2015-05-19', 1),
(9, '2015-03-21', 'HARI RAYA NYEPI', '2015-06-21', 1),
(9, '2015-04-03', 'WAFAT YESUS KRISTUS', '2015-07-03', 1),
(9, '2015-05-01', 'HARI BURUH INTERNATIONAL', '2015-08-01', 1),
(9, '2015-05-14', 'KENAIKAN YESUS KRISTUS', '2015-08-14', 1),
(9, '2015-05-16', 'ISRA MIRAJ', '2015-08-16', 1),
(9, '2015-06-02', 'WAISAK', '2015-09-02', 1),
(9, '2015-07-17', 'IDUL FITRI', '2015-10-17', 1),
(9, '2015-07-18', 'IDUL FITRI 2', '2015-10-18', 1),
(9, '2015-08-17', 'KEMERDEKAAN RI', '2015-11-17', 1),
(9, '2015-09-24', 'IDUL ADHA', '2015-12-24', 1),
(9, '2015-10-14', 'TAHUN BARU HIJRIYAH', '2016-01-14', 1),
(9, '2015-12-09', 'PILKADA', '2016-03-09', 1),
(9, '2015-12-24', 'MAULID NABI', '2016-03-24', 1),
(9, '2015-12-25', 'NATAL', '2016-03-25', 1),
(9, '2016-01-01', 'Tahun Baru', '2016-04-01', 1),
(9, '2016-02-08', 'Imlek', '2016-05-08', 1),
(9, '2016-03-09', 'Nyepi', '2016-06-09', 1),
(9, '2016-03-25', 'Wafat Yesus Kristus', '2016-06-25', 1),
(9, '2016-05-01', 'Hari Buruh', '2016-08-01', 0),
(9, '2016-05-05', 'Isra Miraj & Kenaikan Yesus', '2016-08-05', 0),
(9, '2016-05-06', 'Isra Miraj', '2016-08-06', 0),
(9, '2016-05-22', 'Waisak', '2016-08-22', 0),
(9, '2016-07-06', 'Idul Fitri', '2016-10-06', 0),
(9, '2016-07-07', 'Idul Fitri_2', '2016-10-07', 0),
(9, '2016-08-17', 'Kemerdekaan', '2016-11-17', 0),
(10, '2013-01-01', 'Tahun Baru', '2013-04-01', 2),
(10, '2013-01-24', 'Maulid Muhammad Saw', '2013-04-24', 2),
(10, '2013-02-10', 'Tahun Baru Imlek 2564', '2013-05-10', 2),
(10, '2013-03-12', 'Nyepi', '2013-06-12', 2),
(10, '2013-03-29', 'Wafat Isa Almasih', '2013-06-29', 2),
(10, '2013-05-09', 'Kenaikan Isa Almasih', '2013-08-09', 2),
(10, '2013-05-25', 'Waisak', '2013-08-25', 2),
(10, '2013-06-06', 'Isra Miraj', '2013-09-06', 2),
(10, '2013-08-08', 'Idul Fitri', '2013-11-08', 2),
(10, '2013-08-09', 'Idul Fitri', '2013-11-09', 2),
(10, '2013-08-17', 'Kemerdekaan RI', '2013-11-17', 2),
(10, '2013-10-15', 'Idul Adha', '2014-01-15', 1),
(10, '2013-11-05', 'Tahun Baru Hijriah', '2014-02-05', 1),
(10, '2013-12-25', 'Natal', '2014-03-25', 1),
(10, '2014-01-01', 'Tahun Baru 2014', '2014-04-01', 1),
(10, '2014-01-14', 'Maulid Nabi Muhammad', '2014-04-14', 1),
(10, '2014-01-31', 'Imlek 2565', '2014-04-30', 1),
(10, '2014-03-31', 'Nyepi', '2014-06-30', 1),
(10, '2014-04-09', 'PEMILU LEGISLATIF', '2014-07-09', 1),
(10, '2014-04-18', 'Wafat Isa Almasih', '2014-07-18', 1),
(10, '2014-05-01', 'Hari Buruh', '2014-08-01', 1),
(10, '2014-05-15', 'Waisak', '2014-08-15', 1),
(10, '2014-05-27', 'Isra Miraj', '2014-08-27', 1),
(10, '2014-05-29', 'Kenaikan Isa Almasih', '2014-08-29', 1),
(10, '2014-07-09', 'PEMILU PRESIDEN', '2014-10-09', 1),
(10, '2014-07-28', 'IDUL FITRI', '2014-10-28', 1),
(10, '2014-07-29', 'IDUL FITRI 2', '2014-10-29', 1),
(10, '2014-08-17', 'Kemerdekaan RI', '2014-11-17', 1),
(10, '2014-10-05', 'Idul Adha', '2015-01-05', 1),
(10, '2014-10-25', 'Tahun Baru Hijriyah', '2015-01-25', 1),
(10, '2014-12-25', 'Natal', '2015-03-25', 1),
(10, '2015-01-01', 'TAHUN BARU', '2015-04-01', 1),
(10, '2015-01-03', 'MAULID NABI MUHAMMAD SAW', '2015-04-03', 1),
(10, '2015-02-19', 'TAHUN BARU IMLEK', '2015-05-19', 1),
(10, '2015-03-21', 'HARI RAYA NYEPI', '2015-06-21', 1),
(10, '2015-04-03', 'WAFAT YESUS KRISTUS', '2015-07-03', 1),
(10, '2015-05-01', 'HARI BURUH INTERNATIONAL', '2015-08-01', 1),
(10, '2015-05-14', 'KENAIKAN YESUS KRISTUS', '2015-08-14', 1),
(10, '2015-05-16', 'ISRA MIRAJ', '2015-08-16', 1),
(10, '2015-06-02', 'WAISAK', '2015-09-02', 1),
(10, '2015-07-17', 'IDUL FITRI', '2015-10-17', 1),
(10, '2015-07-18', 'IDUL FITRI 2', '2015-10-18', 1),
(10, '2015-08-17', 'KEMERDEKAAN RI', '2015-11-17', 1),
(10, '2015-09-24', 'IDUL ADHA', '2015-12-24', 1),
(10, '2015-10-14', 'TAHUN BARU HIJRIYAH', '2016-01-14', 1),
(10, '2015-12-09', 'PILKADA', '2016-03-09', 1),
(10, '2015-12-24', 'MAULID NABI', '2016-03-24', 1),
(10, '2015-12-25', 'NATAL', '2016-03-25', 1),
(10, '2016-01-01', 'Tahun Baru', '2016-04-01', 1),
(10, '2016-02-08', 'Imlek', '2016-05-08', 1),
(10, '2016-03-09', 'Nyepi', '2016-06-09', 1),
(10, '2016-03-25', 'Wafat Yesus Kristus', '2016-06-25', 1),
(10, '2016-05-01', 'Hari Buruh', '2016-08-01', 0),
(10, '2016-05-05', 'Isra Miraj & Kenaikan Yesus', '2016-08-05', 0),
(10, '2016-05-06', 'Isra Miraj', '2016-08-06', 0),
(10, '2016-05-22', 'Waisak', '2016-08-22', 0),
(10, '2016-07-06', 'Idul Fitri', '2016-10-06', 0),
(10, '2016-07-07', 'Idul Fitri_2', '2016-10-07', 0),
(10, '2016-08-17', 'Kemerdekaan', '2016-11-17', 0);

-- --------------------------------------------------------

--
-- Table structure for table `m_dept`
--

DROP TABLE IF EXISTS `m_dept`;
CREATE TABLE IF NOT EXISTS `m_dept` (
  `kode_dept` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `kode_divisi` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nama_dept` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`kode_dept`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `m_divisi`
--

DROP TABLE IF EXISTS `m_divisi`;
CREATE TABLE IF NOT EXISTS `m_divisi` (
  `kode_divisi` varchar(10) NOT NULL,
  `nama_divisi` varchar(45) DEFAULT NULL,
  `fwarning` tinyint(4) DEFAULT '0',
  `support_division` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`kode_divisi`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `m_divisi`
--

INSERT INTO `m_divisi` (`kode_divisi`, `nama_divisi`, `fwarning`, `support_division`) VALUES
('BOD', 'BOARD OF DIRECTOR', 0, 1),
('BRI', 'BRIDAL', 0, 1),
('BD', 'BUSINESS & DEVELOPMENT', 0, 1),
('DLV', 'DELIVERY', 0, 1),
('DSG', 'DESIGN LAY OUT', 0, 1),
('FA', 'FINANCE & ACCOUNTING', 0, 1),
('GA', 'GENERAL AFFAIR', 0, 1),
('HRD', 'HUMAN RESOURCE DEVELOPMENT', 0, 1),
('IT', 'INFORMATION TECHNOLOGY', 0, 1),
('IA', 'INTERNAL AUDIT', 0, 1),
('LGA', 'LEGAL', 0, 1),
('LOGD', 'LOGISTIC & DISTRIBUTION', 0, 1),
('ME', 'MAINTENANCE & EQUIPMENT', 0, 1),
('MCM', 'MARKETING & COMMUNICATION', 0, 1),
('OPR', 'OPERATION', 0, 1),
('PPIC', 'PPIC', 0, 1),
('PROD', 'PRODUCTION', 0, 1),
('PRO', 'PROJECT', 0, 1),
('PM', 'PROJECT MAINTENANCE', 0, 1),
('PCH', 'PURCHASING', 0, 1),
('QA', 'QUALITY ASSURANCE', 0, 1),
('RND', 'RESEARCH & DEVELOPMENT', 0, 1),
('SEC', 'SECRETARY', 0, 1),
('TAX', 'TAX CORPORATE', 0, 1),
('WAR', 'WAREHOUSE', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `m_education`
--

DROP TABLE IF EXISTS `m_education`;
CREATE TABLE IF NOT EXISTS `m_education` (
  `education_code` varchar(10) NOT NULL,
  `education_name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`education_code`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `m_education`
--

INSERT INTO `m_education` (`education_code`, `education_name`) VALUES
('DI', 'DIPLOMA SATU'),
('DI-E', 'DI - ECONOMIC'),
('DI-H', 'DI - HOSPITALITY'),
('DI-T', 'DI - TECHNIC'),
('DII', 'DIPLOMA DUA'),
('DII-E', 'DII - ECONOMIC'),
('DII-H', 'DII - HOSPITALITY'),
('DII-T', 'DII - TECHNIC'),
('DIII', 'DIPLOMA TIGA'),
('DIII-E', 'DIII - ECONOMIC'),
('DIII-H', 'DIII - HOSPITALITY'),
('DIII-T', 'DIII - TECHNIC'),
('DIV', 'DIPLOMA EMPAT'),
('DIV-H', 'DIV - HOSPITALITY'),
('S1', 'S1'),
('S1-E', 'S1 - ECONOMIC'),
('S1-F', 'S1 - SOCIAL SCIENCE & POLITIC'),
('S1-H', 'S1 - HOSPITALITY'),
('S1-IF', 'S1 - INFORMATIC'),
('S1-L', 'S1 - LANGUAGE'),
('S1-LW', 'S1 - LAW'),
('S1-PSY', 'S1 - PSYCHOLOGY'),
('S1-T', 'S1 - TECHNIC'),
('S2', 'S2'),
('S2-E', 'S2 - ECONOMIC'),
('S2-F', 'S2 - SOCIAL SCIENCE & POLITIC'),
('S2-H', 'S2 - LAW'),
('S2-L', 'S2 - LANGUAGE'),
('S2-PSY', 'S2 - PSYCHOLOGY'),
('S2-T', 'S2 - TECHNIC'),
('S3', 'S3'),
('SD', 'ELEMENTARY SCHOOL'),
('SMK', 'SMK'),
('SMK-E', 'SMK - ECONOMIC'),
('SMK-H', 'SMK - HOSPITALITY'),
('SMK-L', 'SMK - ELECTRICAL'),
('SMK-T', 'SMK - TECHNIC'),
('SMP', 'JUNIOR HIGH SCHOOL'),
('SMU', 'SENIOR HIGH SCHOOL'),
('SMU-A', 'SENIOR HIGH SCHOOL - IPA'),
('SMU-L', 'SENIOR HIGH SCHOOL - LANGUAGE'),
('SMU-S', 'SENIOR HIGH SCHOOL - IPS');

-- --------------------------------------------------------

--
-- Table structure for table `m_employee`
--

DROP TABLE IF EXISTS `m_employee`;
CREATE TABLE IF NOT EXISTS `m_employee` (
  `employee_id` int(11) NOT NULL AUTO_INCREMENT,
  `nik` varchar(50) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `plant` varchar(5) DEFAULT NULL,
  `kode_cabang` varchar(10) DEFAULT NULL,
  `divisi` varchar(50) DEFAULT NULL,
  `department` varchar(50) DEFAULT NULL,
  `bagian` varchar(50) DEFAULT NULL,
  `jabatan` varchar(50) DEFAULT NULL,
  `golongan` varchar(50) DEFAULT NULL,
  `level` varchar(50) DEFAULT NULL,
  `status_kerja` varchar(50) DEFAULT NULL,
  `tanggal_masuk` date DEFAULT NULL,
  `tanggal_akhir` date DEFAULT NULL,
  `tanggal_keluar` date DEFAULT NULL,
  `saldo_cuti` int(11) NOT NULL,
  `saldo_ph` int(11) NOT NULL,
  `saldo_cutihutang` int(11) DEFAULT '0',
  `agama` varchar(50) DEFAULT NULL,
  `kelamin` varchar(50) DEFAULT NULL,
  `marital` varchar(50) DEFAULT NULL,
  `kode_grouppembayaran` varchar(10) DEFAULT NULL,
  `kode_divisi` varchar(10) DEFAULT NULL,
  `kode_bagian` varchar(10) DEFAULT NULL,
  `kode_dept` varchar(10) DEFAULT NULL,
  `kode_job` varchar(10) DEFAULT NULL,
  `kartu_jamsostek` varchar(45) DEFAULT NULL,
  `kartu_kesehatan` varchar(45) DEFAULT NULL,
  `kartu_npwp` varchar(45) DEFAULT NULL,
  `tempat_lahir` varchar(45) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `nomor_hp` varchar(55) DEFAULT NULL,
  `email_kantor` varchar(100) DEFAULT NULL,
  `email_pribadi` varchar(100) DEFAULT NULL,
  `portal_access` tinyint(1) DEFAULT '0',
  `portal_password` varchar(55) DEFAULT NULL,
  `portal_lastlogin` datetime DEFAULT NULL,
  `portal_ipaddress` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`employee_id`),
  KEY `kode_cabang` (`kode_cabang`),
  KEY `nik` (`nik`),
  KEY `CAB_NIK` (`kode_cabang`,`nik`),
  KEY `idx_kartu_jamsostek` (`kartu_jamsostek`),
  KEY `idx_kartu_kesehatan` (`kartu_kesehatan`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `m_eod`
--

DROP TABLE IF EXISTS `m_eod`;
CREATE TABLE IF NOT EXISTS `m_eod` (
  `eod_id` int(11) NOT NULL AUTO_INCREMENT,
  `eod_date` date DEFAULT NULL,
  `kode_outlet` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`eod_id`),
  KEY `kode_outlet` (`kode_outlet`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `m_fp`
--

DROP TABLE IF EXISTS `m_fp`;
CREATE TABLE IF NOT EXISTS `m_fp` (
  `finger_id` int(11) NOT NULL AUTO_INCREMENT,
  `fnik` varchar(50) DEFAULT NULL,
  `fingerprint_id` int(5) DEFAULT NULL,
  `kode_cabang` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`finger_id`),
  KEY `FNIK` (`fnik`),
  KEY `FKODECAB` (`kode_cabang`),
  KEY `SINKRON1` (`fnik`,`kode_cabang`,`fingerprint_id`),
  KEY `FFINGERID` (`fingerprint_id`),
  KEY `fnik_kodecab` (`fnik`,`kode_cabang`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `m_internal_order`
--

DROP TABLE IF EXISTS `m_internal_order`;
CREATE TABLE IF NOT EXISTS `m_internal_order` (
  `plant` varchar(10) NOT NULL,
  `internal_order` varchar(50) NOT NULL,
  PRIMARY KEY (`plant`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `m_item`
--

DROP TABLE IF EXISTS `m_item`;
CREATE TABLE IF NOT EXISTS `m_item` (
  `MATNR` varchar(18) NOT NULL,
  `MTART` varchar(4) DEFAULT NULL,
  `BISMT` varchar(10) DEFAULT NULL,
  `MEINS` varchar(10) DEFAULT NULL,
  `MAKTX` varchar(60) DEFAULT NULL,
  `MAKTG` varchar(60) DEFAULT NULL,
  `MATKL` varchar(6) DEFAULT NULL,
  `DISPO` varchar(10) NOT NULL,
  `WGBEZ` varchar(20) DEFAULT NULL,
  `UNIT` varchar(10) DEFAULT NULL,
  `UNIT_STEXT` varchar(10) DEFAULT NULL,
  `SOBSL` varchar(2) DEFAULT NULL,
  PRIMARY KEY (`MATNR`,`DISPO`),
  KEY `DISPO` (`DISPO`),
  KEY `MTART` (`MTART`),
  KEY `idx_MATNR` (`MATNR`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `m_item_group`
--

DROP TABLE IF EXISTS `m_item_group`;
CREATE TABLE IF NOT EXISTS `m_item_group` (
  `DISPO` varchar(10) NOT NULL,
  `kdplant` varchar(5) NOT NULL,
  `DSNAM` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`DISPO`,`kdplant`),
  KEY `DISPO` (`DISPO`),
  KEY `kdplant` (`kdplant`),
  KEY `SINKRON` (`DISPO`,`kdplant`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `m_jabatan`
--

DROP TABLE IF EXISTS `m_jabatan`;
CREATE TABLE IF NOT EXISTS `m_jabatan` (
  `kode_job` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `nama_job` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`kode_job`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `m_mapping_item`
--

DROP TABLE IF EXISTS `m_mapping_item`;
CREATE TABLE IF NOT EXISTS `m_mapping_item` (
  `MATNR` varchar(20) NOT NULL,
  `kdplant` varchar(5) NOT NULL,
  PRIMARY KEY (`MATNR`,`kdplant`),
  KEY `kdplant` (`kdplant`),
  KEY `SINKRON` (`MATNR`,`kdplant`),
  KEY `idx_MATNR` (`MATNR`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `m_map_item_ck_pos`
--

DROP TABLE IF EXISTS `m_map_item_ck_pos`;
CREATE TABLE IF NOT EXISTS `m_map_item_ck_pos` (
  `id_map_item` int(11) NOT NULL AUTO_INCREMENT,
  `material_no_ck` varchar(20) DEFAULT NULL,
  `material_no_pos` varchar(20) DEFAULT NULL,
  `uom_pos` varchar(5) DEFAULT NULL,
  PRIMARY KEY (`id_map_item`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `m_map_item_trans`
--

DROP TABLE IF EXISTS `m_map_item_trans`;
CREATE TABLE IF NOT EXISTS `m_map_item_trans` (
  `MATNR` varchar(20) NOT NULL,
  `transtype` varchar(11) NOT NULL,
  PRIMARY KEY (`MATNR`,`transtype`),
  KEY `transtype` (`transtype`),
  KEY `SINKRON` (`MATNR`,`transtype`),
  KEY `idx_MATNR` (`MATNR`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `m_map_nik_id`
--

DROP TABLE IF EXISTS `m_map_nik_id`;
CREATE TABLE IF NOT EXISTS `m_map_nik_id` (
  `outlet` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `nik` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `fingerprint_id` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `m_marital`
--

DROP TABLE IF EXISTS `m_marital`;
CREATE TABLE IF NOT EXISTS `m_marital` (
  `marital_code` varchar(10) NOT NULL,
  `marital_name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`marital_code`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `m_mpaket_detail`
--

DROP TABLE IF EXISTS `m_mpaket_detail`;
CREATE TABLE IF NOT EXISTS `m_mpaket_detail` (
  `id_mpaket_detail` bigint(19) NOT NULL AUTO_INCREMENT,
  `id_mpaket_header` bigint(19) DEFAULT NULL,
  `id_mpaket_h_detail` int(11) DEFAULT NULL,
  `material_no` varchar(20) DEFAULT NULL,
  `material_desc` varchar(60) DEFAULT NULL,
  `quantity` decimal(17,4) DEFAULT NULL,
  `uom` varchar(5) DEFAULT NULL,
  PRIMARY KEY (`id_mpaket_detail`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `m_mpaket_header`
--

DROP TABLE IF EXISTS `m_mpaket_header`;
CREATE TABLE IF NOT EXISTS `m_mpaket_header` (
  `id_mpaket_header` bigint(19) NOT NULL AUTO_INCREMENT,
  `kode_paket` varchar(20) DEFAULT NULL,
  `nama_paket` varchar(60) DEFAULT NULL,
  `plant` varchar(4) DEFAULT NULL,
  `quantity_paket` decimal(17,4) DEFAULT '1.0000',
  `uom_paket` varchar(5) DEFAULT NULL,
  `filename` varchar(50) DEFAULT NULL,
  `id_user_input` int(5) DEFAULT NULL,
  PRIMARY KEY (`id_mpaket_header`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `m_mwts_detail`
--

DROP TABLE IF EXISTS `m_mwts_detail`;
CREATE TABLE IF NOT EXISTS `m_mwts_detail` (
  `id_mwts_detail` bigint(19) NOT NULL AUTO_INCREMENT,
  `id_mwts_header` bigint(19) DEFAULT NULL,
  `id_mwts_h_detail` int(11) DEFAULT NULL,
  `material_no` varchar(20) DEFAULT NULL,
  `material_desc` varchar(60) DEFAULT NULL,
  `quantity` decimal(17,4) DEFAULT NULL,
  `uom` varchar(5) DEFAULT NULL,
  PRIMARY KEY (`id_mwts_detail`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `m_mwts_header`
--

DROP TABLE IF EXISTS `m_mwts_header`;
CREATE TABLE IF NOT EXISTS `m_mwts_header` (
  `id_mwts_header` bigint(19) NOT NULL AUTO_INCREMENT,
  `kode_whi` varchar(20) DEFAULT NULL,
  `nama_whi` varchar(60) DEFAULT NULL,
  `plant` varchar(4) DEFAULT NULL,
  `filename` varchar(50) DEFAULT NULL,
  `id_user_input` int(5) DEFAULT NULL,
  `lastmodified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_mwts_header`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `m_opnd_detail`
--

DROP TABLE IF EXISTS `m_opnd_detail`;
CREATE TABLE IF NOT EXISTS `m_opnd_detail` (
  `id_opnd_detail` bigint(19) NOT NULL AUTO_INCREMENT,
  `id_opnd_header` bigint(19) DEFAULT NULL,
  `id_opnd_h_detail` int(11) DEFAULT NULL,
  `material_no` varchar(20) DEFAULT NULL,
  `material_desc` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`id_opnd_detail`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `m_opnd_header`
--

DROP TABLE IF EXISTS `m_opnd_header`;
CREATE TABLE IF NOT EXISTS `m_opnd_header` (
  `id_opnd_header` bigint(19) NOT NULL AUTO_INCREMENT,
  `periode` varchar(20) DEFAULT NULL,
  `plant` varchar(4) DEFAULT NULL,
  `filename` varchar(50) DEFAULT NULL,
  `id_user_input` int(5) DEFAULT NULL,
  `lastmodified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_opnd_header`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `m_outlet`
--

DROP TABLE IF EXISTS `m_outlet`;
CREATE TABLE IF NOT EXISTS `m_outlet` (
  `OUTLET` varchar(10) NOT NULL DEFAULT '',
  `OUTLET_CLASS` varchar(2) DEFAULT NULL,
  `OUTLET_BUILDING` varchar(17) DEFAULT NULL,
  `OUTLET_BUILDING_LOC` varchar(100) DEFAULT NULL,
  `OUTLET_NAME1` varchar(100) DEFAULT NULL,
  `COMP_CODE` varchar(10) DEFAULT NULL,
  `COMP_CODE_NAME` varchar(50) DEFAULT NULL,
  `STOR_LOC` varchar(10) DEFAULT NULL,
  `STOR_LOC_NAME` varchar(20) DEFAULT NULL,
  `COST_CENTER` varchar(50) DEFAULT NULL,
  `COST_CENTER_TXT` varchar(50) DEFAULT NULL,
  `PURCH_ORG` varchar(10) DEFAULT NULL,
  `OUTLET_NAME2` varchar(100) DEFAULT NULL,
  `OUTLET_PHONE` varchar(100) DEFAULT NULL,
  `OUTLET_PHONE2` varchar(45) DEFAULT NULL,
  `OUTLET_FAX` varchar(100) DEFAULT NULL,
  `ADDRESS` varchar(135) DEFAULT NULL,
  `POST_CODE` varchar(10) DEFAULT NULL,
  `CITY` varchar(50) DEFAULT NULL,
  `LAT` float(10,6) DEFAULT NULL,
  `LNG` float(10,6) DEFAULT NULL,
  `AREAMANAGER` varchar(50) DEFAULT NULL,
  `AREAMANAGER_NAME` varchar(50) DEFAULT NULL,
  `AREAMANAGER_MAIL` varchar(75) DEFAULT NULL,
  `EMAIL` varchar(50) DEFAULT NULL,
  `TRANSIGHT_CODE` varchar(7) DEFAULT NULL,
  `HR_CODE` varchar(10) DEFAULT NULL,
  `OPENING_DATE` date DEFAULT NULL,
  `CLOSING_DATE` date DEFAULT NULL,
  `SUPP_IT` varchar(50) DEFAULT NULL,
  `SUPP_INV` varchar(50) DEFAULT NULL,
  `SYSTEMUPDATE` int(11) DEFAULT '0',
  `SYSTEMCREATE` tinyint(3) unsigned DEFAULT '0',
  `OUTLET_STATUS` tinyint(3) DEFAULT '0' COMMENT '0: new, 1: open, 4: close',
  `OUTLET_CAN_SELECT` tinyint(1) DEFAULT '1',
  `USER_ADD` varchar(75) DEFAULT NULL,
  `USER_ADD_TIME` datetime DEFAULT NULL,
  `USER_CHANGE` varchar(75) DEFAULT NULL,
  `USER_CHANGE_TIME` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `OUTLET_COMPETITOR_WATCH` tinyint(1) DEFAULT '0',
  `OUTLET_DELIVERY_HUB` tinyint(1) DEFAULT '0',
  `OUTLET_GOOGLEMAPS` varchar(255) DEFAULT NULL,
  `OUTLET_RIDER` int(11) DEFAULT '1',
  `LOCK_DATA` tinyint(1) DEFAULT '0',
  `OPENING_HOURS` varchar(255) DEFAULT NULL,
  `OUTLET_TIMEZONE` int(11) DEFAULT '0',
  PRIMARY KEY (`OUTLET`),
  KEY `COMP_CODE` (`COMP_CODE`,`OUTLET`),
  KEY `AREAMANAGER` (`AREAMANAGER`),
  KEY `TRANSIGHT_STORE` (`TRANSIGHT_CODE`),
  KEY `BUILDING_CODE` (`OUTLET_BUILDING`),
  KEY `COMP_STATUS` (`COMP_CODE`,`OUTLET_STATUS`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `m_outlet`
--

INSERT INTO `m_outlet` (`OUTLET`, `OUTLET_CLASS`, `OUTLET_BUILDING`, `OUTLET_BUILDING_LOC`, `OUTLET_NAME1`, `COMP_CODE`, `COMP_CODE_NAME`, `STOR_LOC`, `STOR_LOC_NAME`, `COST_CENTER`, `COST_CENTER_TXT`, `PURCH_ORG`, `OUTLET_NAME2`, `OUTLET_PHONE`, `OUTLET_PHONE2`, `OUTLET_FAX`, `ADDRESS`, `POST_CODE`, `CITY`, `LAT`, `LNG`, `AREAMANAGER`, `AREAMANAGER_NAME`, `AREAMANAGER_MAIL`, `EMAIL`, `TRANSIGHT_CODE`, `HR_CODE`, `OPENING_DATE`, `CLOSING_DATE`, `SUPP_IT`, `SUPP_INV`, `SYSTEMUPDATE`, `SYSTEMCREATE`, `OUTLET_STATUS`, `OUTLET_CAN_SELECT`, `USER_ADD`, `USER_ADD_TIME`, `USER_CHANGE`, `USER_CHANGE_TIME`, `OUTLET_COMPETITOR_WATCH`, `OUTLET_DELIVERY_HUB`, `OUTLET_GOOGLEMAPS`, `OUTLET_RIDER`, `LOCK_DATA`, `OPENING_HOURS`, `OUTLET_TIMEZONE`) VALUES
('YBC1', NULL, 'MKG', NULL, 'Mall Kelapa Gading', 'YBC', 'YBC SOFTWARE', 'BG01', 'YBC MKG', 'YB35600001', 'MKG OPERASIONAL', 'YB01', 'YBC MKG', '021-1234567', NULL, '021-1234567', 'Kelapa Gading', '14240', 'Jakarta Utara', -6.157480, 106.907791, '', '', '', '', 'Y78', 'YBC MKG', '2003-03-29', NULL, '', NULL, 2, 0, 1, 1, 'SYSTEM', '2014-01-01 00:00:00', 'SYSTEM', '2016-08-01 06:00:21', 0, 0, NULL, 1, 0, '10am to 10pm', 7),
('YBC2', NULL, 'PI', NULL, 'Plaza Indonesia', 'YBC', 'YBC SOFTWARE', 'BG01', 'YBC PI', 'YB35600002', 'PI OPERASIONAL', 'YB01', 'YBC PI', '021-1234567', NULL, '021-1234567', 'Plaza Indonesia', NULL, 'Jakarta Pusat', -6.194011, 106.821617, '', '', '', '', 'Y79', 'YBC PI', '2003-11-09', NULL, '', NULL, 2, 0, 1, 1, 'SYSTEM', '2014-01-01 00:00:00', 'SYSTEM', '2016-08-01 06:00:21', 0, 0, NULL, 1, 0, '10am to 10pm', 7),
('YBC3', NULL, 'MTA', NULL, 'Mall Taman Anggrek', 'YBC', 'YBC SOFTWARE', 'BG01', 'YBC MTA', 'YB35600003', 'MTA OPERASIONAL', 'YB01', 'YBC MTA', '021-1234567', NULL, '021-1234567', 'Mal Taman Anggrek', '11470', 'Jakarta Barat', -6.177438, 106.792976, '', '', '', '', 'Y80', 'YBC MTA', '2003-12-09', NULL, '', NULL, 2, 0, 1, 1, 'SYSTEM', '2014-01-01 00:00:00', 'SYSTEM', '2016-08-01 06:00:21', 0, 0, NULL, 1, 0, '10am to 10pm', 7);

-- --------------------------------------------------------

--
-- Table structure for table `m_outlet_building`
--

DROP TABLE IF EXISTS `m_outlet_building`;
CREATE TABLE IF NOT EXISTS `m_outlet_building` (
  `BUILDING_CODE` varchar(17) NOT NULL DEFAULT '',
  `BUILDING_NAME` varchar(200) DEFAULT NULL,
  `BUILDING_ADDRESS` text,
  `BUILDING_CITY` varchar(50) DEFAULT NULL,
  `BUILDING_POSTCODE` varchar(45) DEFAULT NULL,
  `BUILDING_GPS` varchar(100) DEFAULT NULL,
  `BUILDING_COMPANY` varchar(100) DEFAULT NULL,
  `BUILDING_TAXID` varchar(100) DEFAULT NULL,
  `USER_ADD` varchar(75) DEFAULT NULL,
  `USER_ADD_TIME` datetime DEFAULT NULL,
  `USER_CHANGE` varchar(75) DEFAULT NULL,
  `USER_CHANGE_TIME` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`BUILDING_CODE`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `m_outlet_building`
--

INSERT INTO `m_outlet_building` (`BUILDING_CODE`, `BUILDING_NAME`, `BUILDING_ADDRESS`, `BUILDING_CITY`, `BUILDING_POSTCODE`, `BUILDING_GPS`, `BUILDING_COMPANY`, `BUILDING_TAXID`, `USER_ADD`, `USER_ADD_TIME`, `USER_CHANGE`, `USER_CHANGE_TIME`) VALUES
('MKG', 'Mall Kelapa Gading', 'Jl. Boulevard Kelapa Gading', 'Jakarta Utara', '14240', '-6.157328, 106.908137', NULL, NULL, 'yesaya.norman', '2014-02-21 00:00:00', NULL, '2014-09-23 09:50:56'),
('MTA', 'Mall Taman Anggrek', 'Jl. Let.Jen S.Parman Kav.21, Slipi No.E25-E26', 'Jakarta Barat', '11470', '-6.177438, 106.792980', NULL, NULL, 'yesaya.norman', '2014-02-21 00:00:00', NULL, '2014-09-23 08:33:11'),
('PI', 'Plaza Indonesia', 'Jl. M. H. Thamrin 28-30 LB 11-12A', 'Jakarta Pusat', '16142', '-6.194011, 106.821619', NULL, NULL, 'yesaya.norman', '2014-02-21 00:00:00', NULL, '2014-09-23 08:55:52');

-- --------------------------------------------------------

--
-- Table structure for table `m_outlet_city`
--

DROP TABLE IF EXISTS `m_outlet_city`;
CREATE TABLE IF NOT EXISTS `m_outlet_city` (
  `city_name` varchar(50) NOT NULL,
  `city_province` varchar(50) DEFAULT NULL,
  `city_country` varchar(50) DEFAULT NULL,
  `city_timezone` int(11) DEFAULT '0',
  `USER_ADD` varchar(75) DEFAULT NULL,
  `USER_ADD_TIME` datetime DEFAULT NULL,
  `USER_CHANGE` varchar(75) DEFAULT NULL,
  `USER_CHANGE_TIME` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`city_name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `m_outlet_city`
--

INSERT INTO `m_outlet_city` (`city_name`, `city_province`, `city_country`, `city_timezone`, `USER_ADD`, `USER_ADD_TIME`, `USER_CHANGE`, `USER_CHANGE_TIME`) VALUES
('Ambon', 'Maluku', 'Indonesia', 9, 'yesaya.norman', '2014-02-21 00:00:00', NULL, '2016-03-01 11:26:27'),
('Kuta', 'Bali', 'Indonesia', 8, 'yesaya.norman', '2014-02-21 00:00:00', NULL, '2016-03-01 11:25:50'),
('Balikpapan', 'Kalimantan Timur', 'Indonesia', 8, 'yesaya.norman', '2014-02-21 00:00:00', 'yesaya.norman', '2016-03-01 11:25:39'),
('Bandar Lampung', 'Lampung', 'Indonesia', 7, 'yesaya.norman', '2014-02-21 00:00:00', 'yesaya.norman', '2014-11-05 18:21:14'),
('Bandung', 'Jawa Barat', 'Indonesia', 7, 'yesaya.norman', '2014-02-21 00:00:00', NULL, NULL),
('Bangka', 'Kepulauan Bangka Belitung', 'Indonesia', 7, 'yesaya.norman', '2014-02-21 00:00:00', NULL, NULL),
('Banjarmasin', 'Kalimantan Selatan', 'Indonesia', 8, 'yesaya.norman', '2014-02-21 00:00:00', NULL, '2016-03-01 11:25:44'),
('Batam', 'Kepulauan Riau', 'Indonesia', 7, 'yesaya.norman', '2014-02-21 00:00:00', NULL, NULL),
('Bekasi', 'Jawa Barat', 'Indonesia', 7, 'yesaya.norman', '2014-02-21 00:00:00', NULL, NULL),
('Bengkulu', 'Bengkulu', 'Indonesia', 7, 'yesaya.norman', '2014-02-21 00:00:00', NULL, NULL),
('Bogor', 'Jawa Barat', 'Indonesia', 7, 'yesaya.norman', '2014-02-21 00:00:00', NULL, NULL),
('Cianjur', 'Jawa Barat', 'Indonesia', 7, 'yesaya.norman', '2014-02-21 00:00:00', NULL, NULL),
('Cibinong', 'Jawa Barat', 'Indonesia', 7, 'yesaya.norman', '2014-02-21 00:00:00', NULL, NULL),
('Cikampek', 'Jawa Barat', 'Indonesia', 7, 'yesaya.norman', '2014-02-21 00:00:00', NULL, NULL),
('Cikarang', 'Jawa Barat', 'Indonesia', 7, 'yesaya.norman', '2014-02-21 00:00:00', NULL, NULL),
('Cilegon', 'Banten', 'Indonesia', 7, 'yesaya.norman', '2014-02-21 00:00:00', NULL, NULL),
('Cirebon', 'Jawa Barat', 'Indonesia', 7, 'yesaya.norman', '2014-02-21 00:00:00', NULL, NULL),
('Denpasar', 'Bali', 'Indonesia', 8, 'yesaya.norman', '2014-02-21 00:00:00', NULL, '2016-03-01 11:25:50'),
('Depok', 'Jawa Barat', 'Indonesia', 7, 'yesaya.norman', '2014-02-21 00:00:00', NULL, NULL),
('Gorontalo', 'Gorontalo', 'Indonesia', 8, 'yesaya.norman', '2014-02-21 00:00:00', NULL, '2016-03-01 11:26:12'),
('Gresik', 'Jawa Timur', 'Indonesia', 7, 'yesaya.norman', '2014-02-21 00:00:00', NULL, NULL),
('Jakarta Barat', 'DKI Jakarta', 'Indonesia', 7, 'yesaya.norman', '2014-02-21 00:00:00', NULL, NULL),
('Jakarta Pusat', 'DKI Jakarta', 'Indonesia', 7, 'yesaya.norman', '2014-02-21 00:00:00', NULL, NULL),
('Jakarta Selatan', 'DKI Jakarta', 'Indonesia', 7, 'yesaya.norman', '2014-02-21 00:00:00', NULL, NULL),
('Jakarta Timur', 'DKI Jakarta', 'Indonesia', 7, 'yesaya.norman', '2014-02-21 00:00:00', NULL, NULL),
('Jakarta Utara', 'DKI Jakarta', 'Indonesia', 7, 'yesaya.norman', '2014-02-21 00:00:00', NULL, NULL),
('Jambi', 'Jambi', 'Indonesia', 7, 'yesaya.norman', '2014-02-21 00:00:00', NULL, NULL),
('Jayapura', 'Papua', 'Indonesia', 9, 'yesaya.norman', '2014-02-21 00:00:00', NULL, '2016-03-01 11:26:30'),
('Karawang', 'Jawa Barat', 'Indonesia', 7, 'yesaya.norman', '2014-02-21 00:00:00', NULL, NULL),
('Madiun', 'Jawa Timur', 'Indonesia', 7, 'yesaya.norman', '2014-02-21 00:00:00', NULL, NULL),
('Magelang', 'Jawa Tengah', 'Indonesia', 7, 'yesaya.norman', '2014-02-21 00:00:00', NULL, NULL),
('Makassar', 'Sulawesi Selatan', 'Indonesia', 8, 'yesaya.norman', '2014-02-21 00:00:00', NULL, '2016-03-01 11:26:09'),
('Malang', 'Jawa Timur', 'Indonesia', 7, 'yesaya.norman', '2014-02-21 00:00:00', NULL, NULL),
('Manado', 'Sulawesi Utara', 'Indonesia', 8, 'yesaya.norman', '2014-02-21 00:00:00', NULL, '2016-03-01 11:26:09'),
('Mataram', 'Nusa Tenggara Barat', 'Indonesia', 8, 'yesaya.norman', '2014-02-21 00:00:00', NULL, '2016-03-01 11:25:56'),
('Medan', 'Sumatera Utara', 'Indonesia', 7, 'yesaya.norman', '2014-02-21 00:00:00', NULL, NULL),
('Padang', 'Sumatera Barat', 'Indonesia', 7, 'yesaya.norman', '2014-02-21 00:00:00', NULL, NULL),
('Palembang', 'Sumatera Selatan', 'Indonesia', 7, 'yesaya.norman', '2014-02-21 00:00:00', NULL, NULL),
('Palu', 'Sulawesi Tengah', 'Indonesia', 8, 'yesaya.norman', '2014-02-21 00:00:00', NULL, '2016-03-01 11:26:09'),
('Pekanbaru', 'Riau', 'Indonesia', 7, 'yesaya.norman', '2014-02-21 00:00:00', NULL, NULL),
('Pontianak', 'Kalimantan Barat', 'Indonesia', 7, 'yesaya.norman', '2014-02-21 00:00:00', NULL, NULL),
('Samarinda', 'Kalimantan Timur', 'Indonesia', 8, 'yesaya.norman', '2014-02-21 00:00:00', NULL, '2016-03-01 11:25:39'),
('Semarang', 'Jawa Tengah', 'Indonesia', 7, 'yesaya.norman', '2014-02-21 00:00:00', NULL, NULL),
('Serang', 'Banten', 'Indonesia', 7, 'yesaya.norman', '2014-02-21 00:00:00', NULL, NULL),
('Sidoarjo', 'Jawa Timur', 'Indonesia', 7, 'yesaya.norman', '2014-02-21 00:00:00', NULL, NULL),
('Sleman', 'Jawa Tengah', 'Indonesia', 7, 'yesaya.norman', '2014-02-21 00:00:00', NULL, NULL),
('Solo', 'Jawa Tengah', 'Indonesia', 7, 'yesaya.norman', '2014-02-21 00:00:00', NULL, NULL),
('Sukabumi', 'Jawa Barat', 'Indonesia', 7, 'yesaya.norman', '2014-02-21 00:00:00', NULL, NULL),
('Surabaya', 'Jawa Timur', 'Indonesia', 7, 'yesaya.norman', '2014-02-21 00:00:00', NULL, NULL),
('Tangerang', 'Banten', 'Indonesia', 7, 'yesaya.norman', '2014-02-21 00:00:00', NULL, NULL),
('Tanjung Pinang', 'Kepulauan Riau', 'Indonesia', 7, 'yesaya.norman', '2014-02-21 00:00:00', NULL, NULL),
('Tasikmalaya', 'Jawa Barat', 'Indonesia', 7, 'yesaya.norman', '2014-02-21 00:00:00', NULL, NULL),
('Tegal', 'Jawa Tengah', 'Indonesia', 7, 'yesaya.norman', '2014-02-21 00:00:00', NULL, NULL),
('Yogyakarta', 'Daerah Istimewa Yogyakarta', 'Indonesia', 7, 'yesaya.norman', '2014-02-21 00:00:00', NULL, NULL),
('Subang', 'Jawa Barat', 'Indonesia', 7, 'yesaya.norman', '2014-02-21 15:37:21', NULL, '2014-02-21 08:37:21'),
('Singkawang', 'Kalimantan Barat', 'Indonesia', 7, 'hermawati.indah', '2015-04-17 18:40:29', NULL, '2015-04-17 11:40:29'),
('Rantau Prapat', 'Sumatera Utara', 'Indonesia', 7, 'hermawati.indah', '2015-08-20 11:16:01', NULL, '2015-08-20 04:16:01'),
('Tangerang Selatan', 'Banten', 'Indonesia', 7, 'yesaya.norman', NULL, NULL, '2016-03-01 11:31:40'),
('Banda Aceh', 'Aceh', 'Indonesia', 7, 'yesaya.norman', NULL, NULL, '2016-03-01 11:32:28');

-- --------------------------------------------------------

--
-- Table structure for table `m_outlet_dns`
--

DROP TABLE IF EXISTS `m_outlet_dns`;
CREATE TABLE IF NOT EXISTS `m_outlet_dns` (
  `kode_cabang` varchar(10) NOT NULL,
  `net_address` varchar(20) DEFAULT NULL,
  `net_type` tinyint(1) DEFAULT '0',
  `net_updated` datetime DEFAULT NULL,
  PRIMARY KEY (`kode_cabang`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `m_outlet_employee`
--

DROP TABLE IF EXISTS `m_outlet_employee`;
CREATE TABLE IF NOT EXISTS `m_outlet_employee` (
  `OUTLET` varchar(10) NOT NULL DEFAULT '',
  `OUTLET_HC` varchar(10) DEFAULT NULL,
  `STANDARD_EMPLOYEE` int(11) NOT NULL,
  `CURRENT_EMPLOYEE` int(11) NOT NULL,
  `LASTMODIFIED` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`OUTLET`),
  KEY `COMP_CODE` (`OUTLET_HC`),
  KEY `OUTLET_COMP` (`OUTLET_HC`,`OUTLET`),
  KEY `OUTLET_COMP1` (`OUTLET`,`OUTLET_HC`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `m_outlet_netstat`
--

DROP TABLE IF EXISTS `m_outlet_netstat`;
CREATE TABLE IF NOT EXISTS `m_outlet_netstat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode_cabang` varchar(10) NOT NULL,
  `waktu` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `status_system` tinyint(4) DEFAULT NULL COMMENT '1: finger ok, kode cabang ok, inet ok\n2: finger not ok, kode cabang ok, inet ok\n3: finger ok, kode cabang not ok\n4: finger not ok, kode cabang not ok',
  `net_address` varchar(20) DEFAULT NULL,
  `net_host` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `kode_cabang` (`kode_cabang`),
  KEY `tanggal` (`waktu`),
  KEY `status_system` (`status_system`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `m_outlet_province`
--

DROP TABLE IF EXISTS `m_outlet_province`;
CREATE TABLE IF NOT EXISTS `m_outlet_province` (
  `province_name` varchar(50) NOT NULL,
  `province_country` varchar(50) DEFAULT NULL,
  `USER_ADD` varchar(75) DEFAULT NULL,
  `USER_ADD_TIME` datetime DEFAULT NULL,
  `USER_CHANGE` varchar(75) DEFAULT NULL,
  `USER_CHANGE_TIME` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`province_name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `m_outlet_province`
--

INSERT INTO `m_outlet_province` (`province_name`, `province_country`, `USER_ADD`, `USER_ADD_TIME`, `USER_CHANGE`, `USER_CHANGE_TIME`) VALUES
('Aceh', 'Indonesia', 'SYSTEM', '2014-02-21 13:27:15', NULL, '2014-02-20 23:27:15'),
('Bali', 'Indonesia', 'SYSTEM', '2014-02-21 13:27:15', NULL, '2014-02-20 23:27:15'),
('Banten', 'Indonesia', 'SYSTEM', '2014-02-21 13:27:15', NULL, '2014-02-20 23:27:15'),
('Bengkulu', 'Indonesia', 'SYSTEM', '2014-02-21 13:27:15', NULL, '2014-02-20 23:27:15'),
('Gorontalo', 'Indonesia', 'SYSTEM', '2014-02-21 13:27:15', NULL, '2014-02-20 23:27:15'),
('DKI Jakarta', 'Indonesia', 'SYSTEM', '2014-02-21 13:27:15', NULL, '2014-02-20 23:27:15'),
('Jambi', 'Indonesia', 'SYSTEM', '2014-02-21 13:27:15', NULL, '2014-02-20 23:27:15'),
('Jawa Barat', 'Indonesia', 'SYSTEM', '2014-02-21 13:27:15', NULL, '2014-02-20 23:27:15'),
('Jawa Tengah', 'Indonesia', 'SYSTEM', '2014-02-21 13:27:15', NULL, '2014-02-20 23:27:15'),
('Jawa Timur', 'Indonesia', 'SYSTEM', '2014-02-21 13:27:15', NULL, '2014-02-20 23:27:15'),
('Kalimantan Barat', 'Indonesia', 'SYSTEM', '2014-02-21 13:27:15', NULL, '2014-02-20 23:27:15'),
('Kalimantan Selatan', 'Indonesia', 'SYSTEM', '2014-02-21 13:27:15', NULL, '2014-02-20 23:27:15'),
('Kalimantan Tengah', 'Indonesia', 'SYSTEM', '2014-02-21 13:27:15', NULL, '2014-02-20 23:27:15'),
('Kalimantan Timur', 'Indonesia', 'SYSTEM', '2014-02-21 13:27:15', NULL, '2014-02-20 23:27:15'),
('Kalimantan Utara', 'Indonesia', 'SYSTEM', '2014-02-21 13:27:15', NULL, '2014-02-20 23:27:15'),
('Kepulauan Bangka Belitung', 'Indonesia', 'SYSTEM', '2014-02-21 13:27:15', NULL, '2014-02-20 23:27:15'),
('Kepulauan Riau', 'Indonesia', 'SYSTEM', '2014-02-21 13:27:15', NULL, '2014-02-20 23:27:15'),
('Lampung', 'Indonesia', 'SYSTEM', '2014-02-21 13:27:15', NULL, '2014-02-20 23:27:15'),
('Maluku', 'Indonesia', 'SYSTEM', '2014-02-21 13:27:15', NULL, '2014-02-20 23:27:15'),
('Maluku Utara', 'Indonesia', 'SYSTEM', '2014-02-21 13:27:15', NULL, '2014-02-20 23:27:15'),
('Nusa Tenggara Barat', 'Indonesia', 'SYSTEM', '2014-02-21 13:27:15', NULL, '2014-02-20 23:27:15'),
('Nusa Tenggara Timur', 'Indonesia', 'SYSTEM', '2014-02-21 13:27:15', NULL, '2014-02-20 23:27:15'),
('Papua', 'Indonesia', 'SYSTEM', '2014-02-21 13:27:15', NULL, '2014-02-20 23:27:15'),
('Papua Barat', 'Indonesia', 'SYSTEM', '2014-02-21 13:27:15', NULL, '2014-02-20 23:27:15'),
('Riau', 'Indonesia', 'SYSTEM', '2014-02-21 13:27:15', NULL, '2014-02-20 23:27:15'),
('Sulawesi Barat', 'Indonesia', 'SYSTEM', '2014-02-21 13:27:15', NULL, '2014-02-20 23:27:15'),
('Sulawesi Selatan', 'Indonesia', 'SYSTEM', '2014-02-21 13:27:15', NULL, '2014-02-20 23:27:15'),
('Sulawesi Tengah', 'Indonesia', 'SYSTEM', '2014-02-21 13:27:15', NULL, '2014-02-20 23:27:15'),
('Sulawesi Tenggara', 'Indonesia', 'SYSTEM', '2014-02-21 13:27:15', NULL, '2014-02-20 23:27:15'),
('Sulawesi Utara', 'Indonesia', 'SYSTEM', '2014-02-21 13:27:15', NULL, '2014-02-20 23:27:15'),
('Sumatera Barat', 'Indonesia', 'SYSTEM', '2014-02-21 13:27:15', NULL, '2014-02-20 23:27:15'),
('Sumatera Selatan', 'Indonesia', 'SYSTEM', '2014-02-21 13:27:15', NULL, '2014-02-20 23:27:15'),
('Sumatera Utara', 'Indonesia', 'SYSTEM', '2014-02-21 13:27:15', NULL, '2014-02-20 23:27:15'),
('Yogyakarta', 'Indonesia', 'SYSTEM', '2014-02-21 13:27:15', NULL, '2014-02-20 23:27:15');

-- --------------------------------------------------------

--
-- Table structure for table `m_outlet_rider`
--

DROP TABLE IF EXISTS `m_outlet_rider`;
CREATE TABLE IF NOT EXISTS `m_outlet_rider` (
  `rider_id` int(11) NOT NULL AUTO_INCREMENT,
  `rider_name` varchar(45) DEFAULT NULL,
  `outlet_plant` varchar(10) NOT NULL,
  PRIMARY KEY (`rider_id`,`outlet_plant`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `m_schedule_pembyaran`
--

DROP TABLE IF EXISTS `m_schedule_pembyaran`;
CREATE TABLE IF NOT EXISTS `m_schedule_pembyaran` (
  `kode_schedule` int(11) NOT NULL AUTO_INCREMENT,
  `kode_grouppembayaran` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `period` varchar(6) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `mulai` date DEFAULT NULL,
  `akhir` date DEFAULT NULL,
  `status` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`kode_schedule`),
  KEY `kode_grouppembayaran` (`kode_grouppembayaran`),
  KEY `periode` (`period`),
  KEY `kode_periode` (`kode_grouppembayaran`,`period`),
  KEY `periode_kode` (`period`,`kode_grouppembayaran`),
  KEY `status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `m_sfgs_detail`
--

DROP TABLE IF EXISTS `m_sfgs_detail`;
CREATE TABLE IF NOT EXISTS `m_sfgs_detail` (
  `id_sfgs_detail` bigint(19) NOT NULL AUTO_INCREMENT,
  `id_sfgs_header` bigint(19) DEFAULT NULL,
  `id_sfgs_h_detail` int(11) DEFAULT NULL,
  `material_no` varchar(20) DEFAULT NULL,
  `material_desc` varchar(60) DEFAULT NULL,
  `quantity` decimal(17,4) DEFAULT NULL,
  `uom` varchar(5) DEFAULT NULL,
  PRIMARY KEY (`id_sfgs_detail`),
  KEY `idx_stocktake_dtl` (`id_sfgs_header`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `m_sfgs_header`
--

DROP TABLE IF EXISTS `m_sfgs_header`;
CREATE TABLE IF NOT EXISTS `m_sfgs_header` (
  `id_sfgs_header` bigint(19) NOT NULL AUTO_INCREMENT,
  `kode_sfg` varchar(20) DEFAULT NULL,
  `nama_sfg` varchar(60) DEFAULT NULL,
  `plant` varchar(4) DEFAULT NULL,
  `quantity_sfg` decimal(17,4) DEFAULT '1.0000',
  `uom_sfg` varchar(5) DEFAULT NULL,
  `filename` varchar(50) DEFAULT NULL,
  `id_user_input` int(5) DEFAULT NULL,
  `lastmodified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_sfgs_header`),
  KEY `idx_stocktake` (`id_sfgs_header`,`kode_sfg`,`plant`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `m_shift`
--

DROP TABLE IF EXISTS `m_shift`;
CREATE TABLE IF NOT EXISTS `m_shift` (
  `shift_code` int(11) NOT NULL,
  `company_code` varchar(10) NOT NULL,
  `duty_on` varchar(5) DEFAULT NULL,
  `duty_off` varchar(5) DEFAULT NULL,
  `break_in` varchar(5) DEFAULT NULL,
  `break_out` varchar(5) DEFAULT NULL,
  `fdiff_date` tinyint(1) DEFAULT NULL,
  `flag_ls` tinyint(1) DEFAULT NULL COMMENT 'Flag LS',
  PRIMARY KEY (`shift_code`,`company_code`),
  KEY `COMPCODE` (`company_code`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `m_shift`
--

INSERT INTO `m_shift` (`shift_code`, `company_code`, `duty_on`, `duty_off`, `break_in`, `break_out`, `fdiff_date`, `flag_ls`) VALUES
(1, 'YBC', '00:00', '08:00', '04:00', '03:00', 0, NULL),
(2, 'YBC', '00:30', '08:30', '04:30', '03:30', 0, NULL),
(3, 'YBC', '01:00', '09:00', '05:00', '04:00', 0, NULL),
(4, 'YBC', '01:30', '09:30', '05:30', '04:30', 0, NULL),
(5, 'YBC', '02:00', '10:00', '06:00', '05:00', 0, NULL),
(6, 'YBC', '02:30', '10:30', '06:30', '05:30', 0, NULL),
(7, 'YBC', '03:00', '11:00', '07:00', '06:00', 0, NULL),
(8, 'YBC', '03:30', '11:30', '07:30', '06:30', 0, NULL),
(9, 'YBC', '04:00', '12:00', '08:00', '07:00', 0, NULL),
(10, 'YBC', '04:30', '12:30', '08:30', '07:30', 0, NULL),
(11, 'YBC', '05:00', '13:00', '09:00', '08:00', 0, NULL),
(12, 'YBC', '05:30', '13:30', '09:30', '08:30', 0, NULL),
(13, 'YBC', '06:00', '14:00', '10:00', '09:00', 0, NULL),
(14, 'YBC', '06:30', '14:30', '10:30', '09:30', 0, NULL),
(15, 'YBC', '07:00', '15:00', '11:00', '10:00', 0, NULL),
(16, 'YBC', '07:30', '15:30', '11:30', '10:30', 0, NULL),
(17, 'YBC', '08:00', '16:00', '12:00', '11:00', 0, NULL),
(18, 'YBC', '08:30', '16:30', '12:30', '11:30', 0, NULL),
(19, 'YBC', '09:00', '17:00', '13:00', '12:00', 0, NULL),
(20, 'YBC', '09:30', '17:30', '13:30', '12:30', 0, NULL),
(21, 'YBC', '10:00', '18:00', '14:00', '13:00', 0, NULL),
(22, 'YBC', '10:30', '18:30', '14:30', '13:30', 0, NULL),
(23, 'YBC', '11:00', '19:00', '15:00', '14:00', 0, NULL),
(24, 'YBC', '11:30', '19:30', '15:30', '14:30', 0, NULL),
(25, 'YBC', '12:00', '20:00', '16:00', '15:00', 0, NULL),
(26, 'YBC', '12:30', '20:30', '16:30', '15:30', 0, NULL),
(27, 'YBC', '13:00', '21:00', '17:00', '16:00', 0, NULL),
(28, 'YBC', '13:30', '21:30', '17:30', '16:30', 0, NULL),
(29, 'YBC', '14:00', '22:00', '18:00', '17:00', 0, NULL),
(30, 'YBC', '14:30', '22:30', '18:30', '17:30', 0, NULL),
(31, 'YBC', '15:00', '23:00', '19:00', '18:00', 0, NULL),
(32, 'YBC', '15:30', '23:30', '19:30', '18:30', 0, NULL),
(33, 'YBC', '16:00', '00:00', '20:00', '19:00', 1, NULL),
(34, 'YBC', '16:30', '00:30', '20:30', '19:30', 1, NULL),
(35, 'YBC', '17:00', '01:00', '21:00', '20:00', 1, NULL),
(36, 'YBC', '17:30', '01:30', '21:30', '20:30', 1, NULL),
(37, 'YBC', '18:00', '02:00', '22:00', '21:00', 1, NULL),
(38, 'YBC', '18:30', '02:30', '22:30', '21:30', 1, NULL),
(39, 'YBC', '19:00', '03:00', '23:00', '22:00', 1, NULL),
(40, 'YBC', '19:30', '03:30', '23:30', '22:30', 1, NULL),
(41, 'YBC', '20:00', '04:00', '00:00', '23:00', 1, NULL),
(42, 'YBC', '20:30', '04:30', '00:30', '23:30', 1, NULL),
(43, 'YBC', '21:00', '05:00', '01:00', '00:00', 1, NULL),
(44, 'YBC', '21:30', '05:30', '01:30', '00:30', 1, NULL),
(45, 'YBC', '22:00', '06:00', '02:00', '01:00', 1, NULL),
(46, 'YBC', '22:30', '06:30', '02:30', '01:30', 1, NULL),
(47, 'YBC', '23:00', '07:00', '03:00', '02:00', 1, NULL),
(48, 'YBC', '23:30', '07:30', '03:30', '02:30', 1, NULL),
(61, 'YBC', '5:00', '0:00', '20:00', '9:00', 1, NULL),
(62, 'YBC', '6:00', '23:00', '19:00', '10:00', 0, NULL),
(63, 'YBC', '6:00', '0:00', '20:00', '10:00', 1, NULL),
(64, 'YBC', '7:00', '23:00', '19:00', '11:00', 0, NULL),
(65, 'YBC', '7:00', '0:00', '20:00', '11:00', 1, NULL),
(66, 'YBC', '7:00', '1:00', '21:00', '11:00', 1, NULL),
(67, 'YBC', '8:00', '23:00', '19:00', '12:00', 0, NULL),
(68, 'YBC', '8:00', '0:00', '20:00', '12:00', 1, NULL),
(51, 'YBC', '12:00', '0:00', '16:00', '15:00', 1, 1),
(52, 'YBC', '14:00', '2:00', '18:00', '17:00', 1, 1),
(0, 'YBC', '00:00', '00:00', '00:00', '00:00', 0, NULL),
(50, 'YBC', '11:00', '23:00', '15:00', '14:00', 0, 1),
(53, 'YBC', '10:00', '22:00', '14:00', '13:00', 1, 1),
(56, 'YBC', '13:00', '01:00', '17:00', '16:00', 1, 1),
(57, 'YBC', '15:00', '03:00', '19:00', '18:00', 1, 1),
(84, 'YBC', '10:30', '22:30', '14:30', '13:30', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `m_waste_reason`
--

DROP TABLE IF EXISTS `m_waste_reason`;
CREATE TABLE IF NOT EXISTS `m_waste_reason` (
  `reason_id` int(5) NOT NULL AUTO_INCREMENT,
  `reason_name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`reason_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `m_waste_reason`
--

INSERT INTO `m_waste_reason` (`reason_id`, `reason_name`) VALUES
(1, 'Rusak'),
(2, 'Expired'),
(3, 'Jatuh/Tumpah');

-- --------------------------------------------------------

--
-- Table structure for table `m_work_status`
--

DROP TABLE IF EXISTS `m_work_status`;
CREATE TABLE IF NOT EXISTS `m_work_status` (
  `work_code` varchar(10) NOT NULL,
  `work_name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`work_code`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `m_work_status`
--

INSERT INTO `m_work_status` (`work_code`, `work_name`) VALUES
('CAS1', 'CASUAL 1 MONTH'),
('CAS3', 'CASUAL 3 MONTHS'),
('CAS6', 'CASUAL 6 MONTHS'),
('CTR01', 'CONTRACT 1 MONTH'),
('CTR03', 'CONTRACT 3 MONTHS'),
('CTR06', 'CONTRACT 6 MONTHS'),
('CTR12', 'CONTRACT 12 MONTHS'),
('CTR18', 'CONTRACT 18 MONTHS'),
('CTR24', 'CONTRACT 24 MONTHS'),
('CTR60', 'CONTRACT 60 MONTHS'),
('DW1', 'DAILY WORKER 1 MONTH'),
('DW2', 'DAILY WORKER 2 MONTHS'),
('DW3', 'DAILY WORKER 3 MONTHS'),
('INT1', 'INTERNSHIP 1 MONTH'),
('INT14', 'INTERNSHIP 14 DAYS'),
('INT6', 'INTERNSHIP 6 MONTHS'),
('INT7', 'INTERNSHIP 7 DAYS'),
('MAG3', 'MAGANG 3 MONTHS'),
('PMT', 'PERMANENT');

-- --------------------------------------------------------

--
-- Table structure for table `rpt_variance`
--

DROP TABLE IF EXISTS `rpt_variance`;
CREATE TABLE IF NOT EXISTS `rpt_variance` (
  `OUTLET` varchar(4) NOT NULL,
  `PERIODE` varchar(14) DEFAULT NULL,
  `S_PERIODE` int(8) NOT NULL,
  `E_PERIODE` int(8) NOT NULL,
  `MATERIAL` varchar(18) NOT NULL,
  `UOM` varchar(3) DEFAULT NULL,
  `RETUR` decimal(17,4) DEFAULT NULL,
  `ACTUAL` decimal(17,4) DEFAULT NULL,
  `STANDART` decimal(17,4) DEFAULT NULL,
  `VARIANCE` decimal(17,4) DEFAULT NULL,
  PRIMARY KEY (`OUTLET`,`S_PERIODE`,`E_PERIODE`,`MATERIAL`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `r_config`
--

DROP TABLE IF EXISTS `r_config`;
CREATE TABLE IF NOT EXISTS `r_config` (
  `config_order_id` int(10) unsigned NOT NULL DEFAULT '0',
  `cat_id` int(10) unsigned NOT NULL DEFAULT '0',
  `config_order` int(10) unsigned DEFAULT '0',
  `config_name` varchar(50) DEFAULT NULL,
  `content` text,
  PRIMARY KEY (`config_order_id`,`cat_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `r_config`
--

INSERT INTO `r_config` (`config_order_id`, `cat_id`, `config_order`, `config_name`, `content`) VALUES
(1, 1, 1, 'main_sitename', 'YBC SAP Portal'),
(1, 2, 1, 'register_email_from_address', 'admin@jokam.org'),
(1, 3, 1, 'forgot_password_email_from_address', 'admin@jokam.org'),
(1, 4, 1, 'member_tek_time_expire', '200'),
(2, 2, 2, 'register_email_from_name', 'Moderator Milis Jokam'),
(2, 3, 2, 'forgot_password_email_from_name', 'Moderator Milis Jokam'),
(2, 4, 2, 'tek_approve_email_from_address', 'admin@jokam.org'),
(3, 2, 3, 'register_x_email_from_address', 'admin@jokam.org'),
(3, 3, 3, 'forgot_password_time_expire', '24'),
(3, 4, 3, 'tek_approve_email_from_name', 'Moderator Milis Jokam'),
(4, 2, 4, 'register_x_email_from_name', 'Moderator Milis Jokam'),
(4, 4, 4, 'tek_approve_email_to_address', 'admin@jokam.org'),
(5, 2, 5, 'register_x_email_to_address', 'admin@jokam.org'),
(5, 4, 5, 'tek_approve_email_to_name', 'Moderator Milis Jokam'),
(6, 2, 6, 'register_x_email_to_name', 'Moderator Milis Jokam'),
(6, 4, 6, 'tek_approved_email_from_address', 'admin@jokam.org'),
(7, 4, 7, 'tek_approved_email_from_name', 'Moderator Milis Jokam'),
(8, 4, 8, 'member_email_add_from_address', 'admin@jokam.org'),
(9, 4, 9, 'member_email_add_from_name', 'Moderator Milis Jokam');

-- --------------------------------------------------------

--
-- Table structure for table `r_config_category`
--

DROP TABLE IF EXISTS `r_config_category`;
CREATE TABLE IF NOT EXISTS `r_config_category` (
  `category_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category_order` int(10) unsigned DEFAULT NULL,
  `category_name` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`category_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `r_config_category`
--

INSERT INTO `r_config_category` (`category_id`, `category_order`, `category_name`) VALUES
(1, 1, 'main'),
(2, 2, 'register'),
(3, 3, 'forgot_password'),
(4, 4, 'member'),
(5, 5, 'place'),
(6, 6, 'question'),
(7, 7, 'config'),
(8, 8, 'perm');

-- --------------------------------------------------------

--
-- Table structure for table `r_head`
--

DROP TABLE IF EXISTS `r_head`;
CREATE TABLE IF NOT EXISTS `r_head` (
  `head_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `head_controller` varchar(100) NOT NULL DEFAULT '',
  `head_function` varchar(100) NOT NULL DEFAULT '',
  `head_scrpt_id` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`head_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=118 ;

--
-- Dumping data for table `r_head`
--

INSERT INTO `r_head` (`head_id`, `head_controller`, `head_function`, `head_scrpt_id`) VALUES
(1, 'grpo', 'browse', 1),
(2, 'grpo', 'browse_result', 1),
(3, 'grpo', 'input2', 1),
(4, 'grpo', 'edit', 1),
(5, 'grpodlv', 'browse', 1),
(6, 'grpodlv', 'browse_result', 1),
(7, 'grpodlv', 'input2', 1),
(8, 'grpodlv', 'edit', 1),
(9, 'stockoutlet', 'browse', 1),
(10, 'stockoutlet', 'browse_result', 1),
(11, 'stockoutlet', 'input2', 1),
(12, 'stockoutlet', 'edit', 1),
(13, 'grsto', 'browse', 1),
(14, 'grsto', 'browse_result', 1),
(15, 'grsto', 'input2', 1),
(16, 'grsto', 'edit', 1),
(17, 'gisto', 'browse', 1),
(18, 'gisto', 'browse_result', 1),
(19, 'gisto', 'input2', 1),
(20, 'gisto', 'edit', 1),
(21, 'waste', 'browse', 1),
(22, 'waste', 'browse_result', 1),
(23, 'waste', 'input2', 1),
(24, 'waste', 'edit', 1),
(25, 'grnonpo', 'browse', 1),
(26, 'grnonpo', 'browse_result', 1),
(27, 'grnonpo', 'input2', 1),
(28, 'grnonpo', 'edit', 1),
(29, 'grfg', 'browse', 1),
(30, 'grfg', 'browse_result', 1),
(31, 'grfg', 'input2', 1),
(32, 'grfg', 'edit', 1),
(33, 'stdstock', 'browse', 1),
(34, 'stdstock', 'browse_result', 1),
(35, 'stdstock', 'input2', 1),
(36, 'stdstock', 'edit', 1),
(37, 'nonstdstock', 'browse', 1),
(38, 'nonstdstock', 'browse_result', 1),
(39, 'nonstdstock', 'input2', 1),
(40, 'nonstdstock', 'edit', 1),
(41, 'trend_utility', 'browse', 1),
(42, 'trend_utility', 'browse_result', 1),
(44, 'trend_utility', 'input', 1),
(45, 'trend_utility', 'edit', 1),
(46, 'tssck', 'browse', 1),
(47, 'tssck', 'browse_result', 1),
(48, 'tssck', 'input2', 1),
(49, 'tssck', 'edit', 1),
(50, 'gitcc', 'browse', 1),
(51, 'gitcc', 'browse_result', 1),
(52, 'gitcc', 'input2', 1),
(53, 'gitcc', 'edit', 1),
(54, 'posinc', 'browse', 1),
(55, 'posinc', 'browse_result', 1),
(56, 'posinc', 'input', 1),
(57, 'posinc', 'edit', 1),
(58, 'prodstaff', 'browse', 1),
(59, 'prodstaff', 'browse_result', 1),
(60, 'prodstaff', 'input', 1),
(61, 'prodstaff', 'edit', 1),
(62, 'variance', '', 1),
(63, 'variance', 'browse', 1),
(64, 'kodematerial', '', 1),
(65, 'kodematerial', 'browse', 1),
(66, 'dispnonstdstock', '', 1),
(67, 'dispnonstdstock', 'browse', 1),
(68, 'listoutstanding', '', 1),
(69, 'listoutstanding', 'browse', 1),
(70, 'stockoutlet', 'input2', 4),
(71, 'stockoutlet', 'edit', 4),
(72, 'summwebdoc', 'browse', 1),
(73, 'summwebdoc', 'browse_result', 1),
(76, 'variance2', 'browse', 1),
(77, 'variance2', 'browse_result', 1),
(78, 'deletedata', '', 1),
(79, 'prstodlvgr', 'browse', 1),
(80, 'prstodlvgr', 'browse', 1),
(81, 'varianceoutlet', 'browse', 1),
(82, 'uploadrptvariance', 'browse', 1),
(83, 'tpaket', 'browse', 1),
(84, 'tpaket', 'browse_result', 1),
(85, 'tpaket', 'input2', 1),
(86, 'tpaket', 'edit', 1),
(87, 'employee', 'browse', 1),
(88, 'employee', 'browse_result', 1),
(89, 'employee_shift', 'browse_result', 1),
(90, 'employee_absent', 'enter_result', 1),
(91, 'employee_absent', 'browse_result', 1),
(92, 'employee_absent', 'input', 1),
(93, 'employee_absent', 'browse_result', 1),
(94, 'employee_absent', 'input', 1),
(95, 'employee_attn_detail', 'browse', 1),
(96, 'employee_attn_detail', 'browse_result', 1),
(97, 'employee_attn_detail', '', 1),
(98, 'employee_attn_list', '', 1),
(99, 'employee_attn_list', 'browse', 1),
(100, 'employee_req_report', '', 1),
(101, 'employee_req_report', 'browse', 1),
(102, 'employee_req', 'report', 1),
(103, 'employee_req', 'report_browse', 1),
(104, 'employee_req', 'input', 1),
(105, 'employee_machine', '', 1),
(106, 'employee_machine', 'browse_result', 1),
(107, 'employee_machine', 'browse', 1),
(108, 'employee_suspect', '', 1),
(109, 'employee_suspect', 'browse_result', 1),
(110, 'employee_suspect', 'browse', 1),
(113, 'rpt_waste', 'browse', 1),
(114, 'rpt_waste', 'input', 1);

-- --------------------------------------------------------

--
-- Table structure for table `r_head_script`
--

DROP TABLE IF EXISTS `r_head_script`;
CREATE TABLE IF NOT EXISTS `r_head_script` (
  `script_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `script_name` varchar(100) NOT NULL DEFAULT '',
  `script_content` text,
  PRIMARY KEY (`script_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `r_head_script`
--

INSERT INTO `r_head_script` (`script_id`, `script_name`, `script_content`) VALUES
(1, 'tigra_calendar', '	<link rel="stylesheet" type="text/css" href="<?=base_url();?>css/<?=$this->session->userdata(''template'');?>/<?=$this->session->userdata(''lang_name'');?>/calendar.css" />\n	<script language="javascript" type="text/javascript">\n	var A_TCALDEF = {\n		''months'' : [''Jan'', ''Feb'', ''Mar'', ''Apr'', ''Mei'', ''Jun'', ''Jul'', ''Agu'', ''Sep'', ''Okt'', ''Nov'', ''Des''],\n		\n		''weekdays'' : [''M'', ''S'', ''S'', ''R'', ''K'', ''J'', ''S''],\n\n\n		''yearscroll'': true, // show year scroller\n		''weekstart'': 0, // first day of week: 0-Su or 1-Mo\n		''centyear''  : 70, // 2 digit years less than ''centyear'' are in 20xx, othewise in 19xx.\n		''imgpath'' : ''<?=base_url();?>js/calendar/<?=$this->session->userdata(''template'');?>/<?=$this->session->userdata(''lang_name'');?>/img/'' // directory with calendar images\n	}\n\n	</script>\n	<script language="javascript" type="text/javascript" src="<?php echo base_url();?>js/tigracalendar.js"></script>'),
(2, 'tinymce_full', '<!-- TinyMCE -->\r\n<script type="text/javascript" src="<?=base_url();?>js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>\r\n<script type="text/javascript">\r\n	tinyMCE.init({\r\n	\r\n		content_css : "<?=base_url();?>css/<?=$this->session->userdata(''template'');?>/<?=$this->session->userdata(''lang_name'');?>/main.css?" + new Date().getTime(),\r\n	\r\n		theme_advanced_fonts : "Arial=arial,helvetica,sans-serif;"+\r\n		"Courier New=courier new,courier;"+\r\n		"Symbol=symbol;"+\r\n		"Times New Roman=times new roman,times;"+\r\n		"Traditional Arabic=traditional arabic;"+\r\n		"Verdana=verdana,geneva;"+\r\n		"Wingdings=wingdings,zapf dingbats",\r\n	\r\n		// General options\r\n		mode : "textareas",\r\n		theme : "advanced",\r\n		plugins : "pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave",\r\n\r\n		// Theme options\r\n		theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",\r\n		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",\r\n		theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",\r\n		theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,restoredraft",\r\n		theme_advanced_toolbar_location : "top",\r\n		theme_advanced_toolbar_align : "left",\r\n		theme_advanced_statusbar_location : "bottom",\r\n		theme_advanced_resizing : true,\r\n\r\n		// Example content CSS (should be your site CSS)\r\n		content_css : "css/content.css",\r\n\r\n		// Drop lists for link/image/media/template dialogs\r\n		template_external_list_url : "lists/template_list.js",\r\n		external_link_list_url : "lists/link_list.js",\r\n		external_image_list_url : "lists/image_list.js",\r\n		media_external_list_url : "lists/media_list.js",\r\n\r\n		// Style formats\r\n		style_formats : [\r\n			{title : ''Bold text'', inline : ''b''},\r\n			{title : ''Red text'', inline : ''span'', styles : {color : ''#ff0000''}},\r\n			{title : ''Red header'', block : ''h1'', styles : {color : ''#ff0000''}},\r\n			{title : ''Example 1'', inline : ''span'', classes : ''example1''},\r\n			{title : ''Example 2'', inline : ''span'', classes : ''example2''},\r\n			{title : ''Table styles''},\r\n			{title : ''Table row 1'', selector : ''tr'', classes : ''tablerow1''}\r\n		],\r\n\r\n		formats : {\r\n			alignleft : {selector : ''p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table,img'', classes : ''left''},\r\n			aligncenter : {selector : ''p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table,img'', classes : ''center''},\r\n			alignright : {selector : ''p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table,img'', classes : ''right''},\r\n			alignfull : {selector : ''p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table,img'', classes : ''full''},\r\n			bold : {inline : ''span'', ''classes'' : ''bold''},\r\n			italic : {inline : ''span'', ''classes'' : ''italic''},\r\n			underline : {inline : ''span'', ''classes'' : ''underline'', exact : true},\r\n			strikethrough : {inline : ''del''}\r\n		},\r\n\r\n		// Replace values for the template plugin\r\n		template_replace_values : {\r\n			username : "Some User",\r\n			staffid : "991234"\r\n		}\r\n	});\r\n</script>\r\n<!-- /TinyMCE -->\r\n'),
(3, 'tinymce_simple', '<!-- TinyMCE -->\r\n<script type="text/javascript" src="<?=base_url();?>js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>\r\n<script type="text/javascript">\r\n	tinyMCE.init({\r\n		mode : "textareas",\r\n		theme : "simple"\r\n	});\r\n</script>\r\n<!-- /TinyMCE -->\r\n'),
(4, 'Tigra Calculator', '<script language="Javascript" type="text/javascript">\r\n\r\nvar TCR = new Tcalculator();\r\n\r\nfunction Tcalculator() {\r\n	this.oper_old =\r\n	this.oper_old_old =\r\n	this.slag_1 =\r\n	this.slag_2 =\r\n	this.slag_1_old =\r\n	this.out_val =\r\n	this.p_out = '''';\r\n	this.t_load = false;\r\n	this.TCRisNumber = TCRisNumber;\r\n	this.TCRisPoint = TCRisPoint;\r\n	this.TCRPopup = TCRPopup;\r\n	this.TCRrezult = TCRrezult;\r\n	this.TCRmntr = TCRmntr;\r\n	// preloading images\r\n	var a_img = [], i, j;\r\n	for (i = 0; i < 19; i ++) {\r\n		a_img[i] = [];\r\n		for (j = 0; j < 3; j ++) {\r\n			a_img[i][j] = new Image();\r\n			a_img[i][j].src = ''<?=base_url();?>js/calculator/img/'' + i + ''_'' + j + ''.png''\r\n		}\r\n	}\r\n}\r\n\r\nfunction TCRisPoint(tmp,n) {\r\n	var flag = 0;\r\n	if (tmp == ''.'') {\r\n		var tmp2 = window.win_ch.document.forms[0].elements[0].value;\r\n		for (var i = 0; i < tmp2.length; i ++) {\r\n			thischar = tmp2.substring(i,i + 1);\r\n			if (thischar == ''.'') flag = 1;\r\n		}\r\n	}\r\n	if (flag == 0) eval(''this.slag_'' + n + ''+=tmp;'');\r\n}\r\n\r\nfunction TCRisNumber(data){\r\n	var numStr = "0123456789", thischar, counter = p_counter = err_cod = popr = 0, len=data.length, i;\r\n	for (i = 0; i < len; i ++) {\r\n		thischar = data.substring(i,i + 1);\r\n		if (numStr.indexOf(thischar)!= -1) counter ++;\r\n		if (thischar == ''-''){\r\n			if (i != 0) {err_cod = 1; break;}\r\n			else popr ++;\r\n		}\r\n		if (thischar == ''.'') {\r\n			if ((i == 0 || i == len - 1) || (i == 1 && data.substring(i - 1, i) == ''-'')) {\r\n				err_cod = 1;\r\n				break;\r\n			}\r\n			else {\r\n				p_counter ++;\r\n				if (p_counter > 1) {\r\n					err_cod = 1;\r\n					break;\r\n				}\r\n				else popr ++;\r\n			}\r\n		}\r\n	}\r\n	if (err_cod != 1 && counter == len - popr) return true;\r\n	else return false;\r\n}\r\n\r\nfunction TCRrezult (slag_1, slag_2, oper) {\r\n	slag_1 = parseFloat(slag_1);\r\n	slag_2 = parseFloat(slag_2);\r\n	eval(''out=('' + slag_1 + '')'' + oper + ''('' + slag_2 + '')'');\r\n	return out;\r\n}\r\n\r\n\r\nfunction TCRPopup(obj_control) {\r\n	//var w = 186, h = 122;\r\n	var w = 200, h = 140;\r\n	var ua = navigator.userAgent.toLowerCase();\r\n	var v = navigator.appVersion.substring(0,1);\r\n	var n = navigator.appName.toLowerCase();\r\n	if (!obj_control)\r\n		return alert("Form element specified can''t be found in the document.");\r\n	this.control_obj = obj_control;\r\n	if (!this.TCRisNumber(this.control_obj.value)) alert(''wrong data'');\r\n	else {\r\n		if (ua.indexOf("opera") > 0) {w = 176; h = 135;}\r\n		else if (ua.indexOf("netscape") < 0 && ua.indexOf("msie") < 0\r\n			&& v >= 5 && ua.indexOf("mac") > 0) {\r\n			w = 212; h = 122;\r\n		}\r\n		else if (n == ''netscape'') {\r\n			if (v == 4) { w = 216; h = 128;}\r\n			if (v >= 5) { w = 185; h = 126;}\r\n		}\r\n\r\n		if (screen) {\r\n			n_left = (screen.width - w) >> 1;\r\n			n_top = (screen.height - h) >> 1;\r\n		}\r\n		win_ch = window.open("<?=base_url();?>js/calculator/calculator.html","win_ch", "width=" + w + ",height=" + h + ",help=no,status=no,scrollbars=no,resizable=no,top=" + n_top + ",left=" + n_left + ",dependent=yes,alwaysRaised=yes", true);\r\n		win_ch.focus();\r\n	}\r\n}\r\n\r\nfunction TCRmntr(num) {\r\n	var flag = 0;\r\n	if (this.t_load) tmp = window.win_ch.document.forms[0].elements[0].value;\r\n	if (num == ''C'') {\r\n		this.out_val = ''0'';\r\n		this.oper_old = this.oper_old_old = this.slag_1 = this.slag_2 = '''';\r\n	}\r\n	else if (tmp != ''NaN'' && tmp != ''Infinity'')\r\n		switch (num) {\r\n			case ''-'':\r\n			case ''+'':\r\n			case ''/'':\r\n			case ''*'':\r\n				if (this.slag_1 != '''' && this.slag_2 != '''') {\r\n					this.out_val = this.slag_1 = this.TCRrezult(this.slag_1, this.slag_2, this.oper_old);\r\n					this.slag_2 = '''';\r\n				}\r\n				else if(this.slag_1 == '''' && this.slag_2 == '''') this.out_val = this.slag_1 = tmp;\r\n				this.oper_old = num;\r\n				break;\r\n			case ''sqr'':\r\n				this.slag_1 = tmp;\r\n				this.slag_2 = '''';\r\n				this.slag_1 = parseFloat(this.slag_1);\r\n				this.slag_1 = Math.sqrt(this.slag_1);\r\n				this.oper_old =this.oper_old_old ='''';\r\n				this.out_val = this.slag_1;\r\n				this.control_obj.value = this.out_val;\r\n				break;\r\n			case ''='':\r\n				if (this.oper_old != '''') {\r\n					if (this.slag_1 != '''' && this.slag_2 != '''') {\r\n						this.out_val = this.TCRrezult(this.slag_1, this.slag_2, this.oper_old);\r\n						this.slag_1 = this.slag_1_old = this.slag_2;\r\n					}\r\n					else if (this.slag_1 != '''' && this.slag_2 == '''') {\r\n						this.out_val = this.TCRrezult(this.slag_1,this.slag_1,this.oper_old);\r\n						this.slag_1_old = this.slag_1;\r\n					}\r\n					this.oper_old_old = this.oper_old;\r\n					this.slag_2 = '''';\r\n					this.slag_1 = '''';\r\n					this.oper_old = '''';\r\n				}\r\n				else if(this.oper_old_old != ''''){\r\n					this.slag_2_old = tmp;\r\n					this.out_val = this.TCRrezult(this.slag_2_old, this.slag_1_old, this.oper_old_old);\r\n				}\r\n				else if (this.slag_1 == '''' && this.slag_2 == '''') this.out_val = ''0'';\r\n				else this.out_val = this.slag_1;\r\n				this.control_obj.value = this.out_val;\r\n				this.control_obj.onchange(); // From Titus Wagono\r\n				break;\r\n			case ''z'':\r\n				tmp = parseFloat(tmp);\r\n				this.out_val = tmp * -1;\r\n				if (this.slag_1 != '''' && this.slag_2 == '''') this.slag_1 = this.out_val;\r\n				else if (this.slag_2 != '''') this.slag_2 = this.out_val;\r\n				break;\r\n			default:\r\n				if (this.oper_old == '''') {\r\n					if (num == ''0'' && tmp == ''0'') this.slag_1 = tmp;\r\n					else if (num == ''.'' && tmp == ''0'') this.slag_1 = tmp + num;\r\n					else if(num == ''.'' && this.slag_1 == '''') this.slag_1 = ''0'' + num;\r\n					else if (num == ''.'' || this.slag_1 != '''') this.TCRisPoint(num, ''1'');\r\n					else this.slag_1 = num;\r\n					this.out_val = this.slag_1;\r\n				}\r\n				else {\r\n					if (num == ''0'' && tmp == ''0'') this.slag_2 = tmp;\r\n					else if(num == ''.'' && this.slag_2 == '''') this.slag_2 = ''0'' + num;\r\n					else if (num == ''.'' || this.slag_2 != '''') this.TCRisPoint(num,''2'');\r\n					else this.slag_2 = num;\r\n					this.out_val = this.slag_2;\r\n				}\r\n	}\r\n	if (this.t_load) window.win_ch.document.forms[0].elements[0].value = this.out_val;\r\n}\r\n</script>'),
(5, 'leasing_script', '	<link href="<?php echo base_url();?>css/bootstrap.icons.css?v=<?php echo $swbcssver; ?>" media="screen" rel="stylesheet" type="text/css" />\n 	<link href="<?php echo base_url();?>css/bootstrap-combined.min.css?v=<?php echo $swbcssver; ?>" media="screen" rel="stylesheet" type="text/css" /> 		\n 	<link href="<?php echo base_url();?>css/jquery.dataTables.css?v=<?php echo $swbcssver; ?>" media="screen" rel="stylesheet" type="text/css" />\n 	<link href="<?php echo base_url();?>css/dataTables.fixedColumns.css?v=<?php echo $swbcssver; ?>" media="screen" rel="stylesheet" type="text/css" />	\n 	<link href="<?php echo base_url();?>css/chosen.min.css?v=<?php echo $swbcssver; ?>" media="screen" rel="stylesheet" type="text/css" />	\n 	<link href="<?php echo base_url();?>css/jquery.datepick.css?v=<?php echo $swbcssver; ?>" rel="stylesheet">	\n 	<style type="text/css" class="init">\n \n \n 	</style>	\n 	<script src="<?php echo base_url();?>js/jquery.dataTables.1.10.min.js?v=<?php echo $swbcssver; ?>" type="text/javascript"></script>\n 	<script src="<?php echo base_url();?>js/dataTables.fixedColumns.js?v=<?php echo $swbcssver; ?>" type="text/javascript"></script>\n 	\n 	<script src="<?php echo base_url();?>js/bootstrap.min.js?v=<?php echo $swbcssver; ?>" type="text/javascript"></script>	\n 	<script src="<?php echo base_url();?>js/leasing_complete.js?v=<?php echo $swbcssver; ?>" type="text/javascript"></script>	\n 	<script src="<?php echo base_url();?>js/jquery.plugin.js?v=<?php echo $swbcssver; ?>"></script>\n 	<script src="<?php echo base_url();?>js/jquery.datepick.js?v=<?php echo $swbcssver; ?>"></script> ');

-- --------------------------------------------------------

--
-- Table structure for table `r_ipaddress`
--

DROP TABLE IF EXISTS `r_ipaddress`;
CREATE TABLE IF NOT EXISTS `r_ipaddress` (
  `ip_address` varchar(16) NOT NULL,
  `ip_plant` varchar(45) NOT NULL,
  `ip_trust_level` int(11) DEFAULT NULL,
  `ip_lastupdated` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`ip_address`,`ip_plant`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `r_lang`
--

DROP TABLE IF EXISTS `r_lang`;
CREATE TABLE IF NOT EXISTS `r_lang` (
  `lang_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `lang_name` varchar(50) NOT NULL,
  PRIMARY KEY (`lang_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `r_lang`
--

INSERT INTO `r_lang` (`lang_id`, `lang_name`) VALUES
(1, 'indonesian'),
(2, 'english');

-- --------------------------------------------------------

--
-- Table structure for table `r_language`
--

DROP TABLE IF EXISTS `r_language`;
CREATE TABLE IF NOT EXISTS `r_language` (
  `language_id` int(10) unsigned NOT NULL DEFAULT '0',
  `lang_lang_id` smallint(5) unsigned NOT NULL DEFAULT '0',
  `lang_name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`language_id`,`lang_lang_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `r_language`
--

INSERT INTO `r_language` (`language_id`, `lang_lang_id`, `lang_name`) VALUES
(1, 1, 'Bahasa Indonesia'),
(1, 2, 'Indonesian'),
(2, 1, 'Bahasa Inggris'),
(2, 2, 'English');

-- --------------------------------------------------------

--
-- Table structure for table `r_menu`
--

DROP TABLE IF EXISTS `r_menu`;
CREATE TABLE IF NOT EXISTS `r_menu` (
  `mn_id` int(11) NOT NULL,
  `mn_order` int(11) DEFAULT '1',
  `mn_text` varchar(40) DEFAULT NULL,
  `mn_text_alt` varchar(160) DEFAULT NULL,
  `mn_type` varchar(1) DEFAULT NULL,
  `mn_class` varchar(13) DEFAULT NULL,
  `mn_parent` varchar(4) DEFAULT NULL,
  `mn_link` varchar(27) DEFAULT NULL,
  `mn_perm` varchar(28) DEFAULT NULL,
  `mn_status` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`mn_id`),
  KEY `mn_perm` (`mn_perm`),
  KEY `mn_parent` (`mn_parent`),
  KEY `mn_parent_perm` (`mn_parent`,`mn_perm`),
  KEY `mn_parent_stat_perm` (`mn_parent`,`mn_status`,`mn_perm`),
  KEY `mn_perm_stat_text` (`mn_perm`,`mn_status`,`mn_text_alt`),
  KEY `mn_stat_text` (`mn_status`,`mn_text_alt`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Dumping data for table `r_menu`
--

INSERT INTO `r_menu` (`mn_id`, `mn_order`, `mn_text`, `mn_text_alt`, `mn_type`, `mn_class`, `mn_parent`, `mn_link`, `mn_perm`, `mn_status`) VALUES
(11, 0, 'My JAG', 'My JAG', '0', 'fa-user', '0', '', 'employee_self', 1),
(4, 1, 'System', 'System', '0', 'fa-cog', '0', '', 'system', 1),
(4801, 1, 'Hak Akses', 'Hak Akses', '0', 'mn_tr_s', '4', 'perm/group_browse', 'masterdata_perm_group', 1),
(4802, 2, 'Manajemen Pengguna', 'List Manajemen Pengguna', '0', 'mn_tr_s', '4', 'user/browse', 'masterdata_admin', 1),
(2, 2, 'Stock', 'Stock', '0', 'fa-calculator', '0', '', 'trans', 1),
(201, 1, 'Master', 'Master', '0', 'dir', '2', '', 'masterdata', 1),
(201701, 1, 'INPUT', 'INPUT', '1', 'mn_sub_input', '201', '', 'trans', 1),
(201702, 2, 'Master Semi Finished Goods (SFG) BOM', 'Input Master Semi Finished Goods (SFG) BOM', '0', 'mn_tr_i', '201', 'sfgs/input', 'masterdata_sfg', 1),
(201703, 3, 'Master Item Opname Daily', 'Input Master Item Opname Daily', '0', 'mn_tr_i', '201', 'opnd/input', 'masterdata_opnd', 1),
(201704, 4, 'Master Konversi Item Whole ke Slice', 'Input Master Konversi Item Whole ke Slice', '0', 'mn_tr_i', '201', 'mwts/input', 'masterdata_mwts', 1),
(201801, 5, 'LIST', 'LIST', '1', 'mn_sub_list', '201', '', 'trans', 1),
(201802, 6, 'Master Semi Finished Goods (SFG) BOM', 'List Master Semi Finished Goods (SFG) BOM', '0', 'mn_tr_l', '201', 'sfgs/browse', 'masterdata_sfg', 1),
(201803, 7, 'Master Item Opname Daily', 'List Master Item Opname Daily', '0', 'mn_tr_l', '201', 'opnd/browse', 'masterdata_opnd', 1),
(201804, 8, 'Master Konversi Item Whole ke Slice', 'List Master Konversi Item Whole ke Slice', '0', 'mn_tr_l', '201', 'mwts/browse', 'masterdata_mwts', 1),
(202, 2, 'Request', 'Request', '0', 'dir', '2', '', 'trans', 1),
(202701, 1, 'INPUT', 'INPUT', '1', 'mn_sub_input', '202', '', 'trans', 1),
(202702, 2, 'Request Standard Stock', 'Input Request Standard Stock', '0', 'mn_tr_i', '202', 'stdstock/input', 'trans_stdstock', 1),
(202703, 3, 'Request Non Standard Stock ', 'Input Request Non Standard Stock ', '0', 'mn_tr_i', '202', 'nonstdstock/input', 'trans_nonstdstock', 1),
(202801, 4, 'LIST', 'LIST', '1', 'mn_sub_list', '202', '', 'trans', 1),
(202802, 5, 'Request Standard Stock', 'List Request Standard Stock', '0', 'mn_tr_l', '202', 'stdstock/browse', 'trans_stdstock', 1),
(202803, 6, 'Request Non Standard Stock ', 'List Request Non Standard Stock ', '0', 'mn_tr_l', '202', 'nonstdstock/browse', 'trans_nonstdstock', 1),
(203, 3, 'Terima Barang', 'Terima Barang', '0', 'dir', '2', '', 'trans', 1),
(203701, 1, 'INPUT', 'INPUT', '1', 'mn_sub_input', '203', '', 'trans', 1),
(203702, 2, 'Goods Receipt PO from Vendor', 'Input Goods Receipt PO from Vendor', '0', 'mn_tr_i', '203', 'grpo/input', 'trans_grpo', 1),
(203703, 3, 'GR FG di Outlet', 'Input GR FG di Outlet', '0', 'mn_tr_i', '203', 'grfg/input', 'trans_grfg', 1),
(203704, 4, 'Goods Receipt Stock Transfer antar Plant', 'Input Goods Receipt Stock Transfer antar Plant', '0', 'mn_tr_i', '203', 'grsto/input', 'trans_grsto', 1),
(203801, 5, 'LIST', 'LIST', '1', 'mn_sub_list', '203', '', 'trans', 1),
(203802, 6, 'Goods Receipt PO from Vendor', 'List Goods Receipt PO from Vendor', '0', 'mn_tr_l', '203', 'grpo/browse', 'trans_grpo', 1),
(203803, 7, 'GR FG di Outlet', 'List GR FG di Outlet', '0', 'mn_tr_l', '203', 'grfg/browse', 'trans_grfg', 1),
(203804, 8, 'Goods Receipt Stock Transfer antar Plant', 'List Goods Receipt Stock Transfer antar Plant', '0', 'mn_tr_l', '203', 'grsto/browse', 'trans_grsto', 1),
(204, 4, 'Kirim Barang', 'Kirim Barang', '0', 'dir', '2', '', 'trans', 1),
(204701, 1, 'INPUT', 'INPUT', '1', 'mn_sub_input', '204', '', 'trans', 1),
(20103, 2, 'Goods Issue Stock Transfer antar Plant', 'Input Goods Issue Stock Transfer antar Plant', '0', 'mn_tr_i', '204', 'gisto/input', 'trans_gisto', 1),
(204801, 3, 'LIST', 'LIST', '1', 'mn_sub_list', '204', '', 'trans', 1),
(204802, 4, 'Goods Issue Stock Transfer antar Plant', 'List Goods Issue Stock Transfer antar Plant', '0', 'mn_tr_l', '204', 'gisto/browse', 'trans_gisto', 1),
(205, 5, 'Cek Opname/Waste', 'Cek Opname/Waste', '0', 'dir', '2', '', 'trans', 1),
(205701, 1, 'INPUT', 'INPUT', '1', 'mn_sub_input', '205', '', 'trans', 1),
(205702, 2, 'Stock Opname ', 'Input Stock Opname ', '0', 'mn_tr_i', '205', 'stockoutlet/input', 'trans_stockoutlet', 1),
(205703, 3, 'Waste Material ', 'Input Waste Material ', '0', 'mn_tr_i', '205', 'waste/input', 'trans_waste', 1),
(205704, 4, 'Reset/Hapus Data Stock', 'Reset/Hapus Data Stock', '0', 'mn_tr_d', '205', 'deletedata', 'trans_deletedata', 1),
(205801, 5, 'LIST', 'LIST', '1', 'mn_sub_list', '205', '', 'trans', 1),
(205802, 6, 'Stock Opname ', 'List Stock Opname ', '0', 'mn_tr_l', '205', 'stockoutlet/browse', 'trans_stockoutlet', 1),
(205803, 7, 'Waste Material', 'List Waste Material', '0', 'mn_tr_l', '205', 'waste/browse', 'trans_waste', 1),
(206, 6, 'End of Day', 'End of Day', '0', 'dir', '2', '', 'trans_posinc', 1),
(206701, 1, 'INPUT', 'INPUT', '1', 'mn_sub_input', '206', '', 'trans', 1),
(206702, 2, 'End of Day', 'Input End of Day', '0', 'mn_tr_i', '206', 'posinc/input', 'trans_posinc', 1),
(206801, 3, 'LIST', 'LIST', '1', 'mn_sub_list', '206', '', 'trans', 1),
(206802, 4, 'End of Day', 'List End of Day', '0', 'mn_tr_l', '206', 'posinc/browse', 'trans_posinc', 1),
(207, 7, 'Report', 'Report', '0', 'dirrpt', '2', '', 'trans', 1),
(207701, 1, 'Material Document Summary', 'List Material Document Summary', '0', 'mn_tr_r', '207', 'summwebdoc/browse', 'report_summwebdoc', 1),
(207702, 2, 'PR STO vs DO vs Goods Receipt', 'List PR STO vs DO vs Goods Receipt', '0', 'mn_tr_r', '207', 'prstodlvgr/browse', 'report_prstodlvgr', 1),
(207703, 3, 'Upload Report Variance Outlet', 'List Upload Report Variance Outlet', '0', 'mn_tr_r', '207', 'uploadrptvariance/browse', 'report_upload_varianceoutlet', 1),
(207704, 4, 'Variance Outlet', 'List Variance Outlet', '0', 'mn_tr_r', '207', 'varianceoutlet/browse', 'report_varianceoutlet', 1),
(207705, 5, 'Waste', 'Input Waste', '0', 'mn_tr_r', '207', 'rpt_waste/input', 'report_waste', 1),
(8, 4, 'HR', 'HR', '0', 'fa-male', '0', '', 'hrd', 1),
(801, 1, 'Input Data', 'Input Data', '0', 'dir', '8', '', 'hrd', 1),
(801702, 1, 'Dinas Luar', 'Dinas Luar', '0', 'mn_tr_i', '801', 'employee_fp/enter', 'hrd_input_dl', 1),
(801703, 2, 'Shift Karyawan', 'Shift Karyawan', '0', 'mn_tr_i', '801', 'employee_shift/browse', 'hrd_input_shift', 1),
(801704, 3, 'Izin Karyawan', 'Izin Karyawan', '0', 'mn_tr_i', '801', 'employee_absent/enter', 'hrd_input_izin', 1),
(801705, 4, 'End of Month', 'End of Month', '0', 'mn_tr_i', '801', 'endofmonth', 'hrd_input_eod', 1),
(802, 2, 'List Data', 'List Data', '0', 'dir', '8', '', 'hrd', 1),
(802701, 1, 'Employee', 'List Employee (Karyawan)', '0', 'mn_tr_l', '802', 'employee/browse', 'hrd_list_employee', 1),
(803, 3, 'Report', 'Report', '0', 'dirrpt', '8', '', 'hrd', 1),
(803701, 1, 'Attendance List', 'Attendance List', '0', 'mn_tr_r', '803', 'employee_attn_list/browse', 'hrd_report_attendance', 1),
(803702, 2, 'Attendance Detail', 'Attendance Detail', '0', 'mn_tr_r', '803', 'employee_attn_detail/browse', 'hrd_report_attendance_detail', 1),
(803705, 3, 'Data Mesin Absen', 'Data Mesin Absen', '0', 'mn_tr_r', '803', 'employee_machine/browse', 'hrd_report_machine', 1),
(803706, 4, 'Data Tidak Wajar', 'Data Absensi Tidak Wajar', '0', 'mn_tr_r', '803', 'employee_suspect/browse', 'hrd_report_suspect', 1),
(90101, 1, 'Web Delivery Online', 'Web Delivery Online', '0', 'mn_tr_r', '901', 'deliveryonline', 'delivery_online', 0),
(6, 101, 'Download', 'Download', '0', 'fa-download', '0', '', 'download', 1),
(601, 1, 'Template (Excel)', 'Download Template (Excel)', '0', 'mn_tr_l', '6', 'download', 'download_excel', 1);

-- --------------------------------------------------------

--
-- Table structure for table `r_page`
--

DROP TABLE IF EXISTS `r_page`;
CREATE TABLE IF NOT EXISTS `r_page` (
  `page_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `page_controller` varchar(100) NOT NULL DEFAULT '',
  `page_function` varchar(100) NOT NULL DEFAULT '',
  `page_name` varchar(100) NOT NULL DEFAULT '',
  `page_focus` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`page_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

--
-- Dumping data for table `r_page`
--

INSERT INTO `r_page` (`page_id`, `page_controller`, `page_function`, `page_name`, `page_focus`) VALUES
(1, '', '', 'home', 'form1.member_name'),
(2, 'login', '', 'login', 'form1.email_address'),
(3, 'login', 'index', 'login', 'form1.email_address'),
(4, 'login', 'login_process', 'login', 'form1.email_address'),
(5, 'login', 'email_wrong', 'login', 'form1.email_address'),
(6, 'login', 'password_wrong', 'login', 'form1.email_address'),
(7, 'register', '', 'register', 'form1.email_address'),
(8, 'register', 'index', 'register', 'form1.email_address'),
(9, 'register', 'register_1', 'register', 'form1.email_address'),
(10, 'register', 'register_2', 'register', 'form1.positions'),
(11, 'forgot_password', '', 'forgot_password', 'form1.email_address'),
(12, 'forgot_password', 'index', 'forgot_password', 'form1.email_address'),
(13, 'forgot_password', 'forgot_process', 'forgot_password', 'form1.email_address'),
(14, 'forgot_password', 'email_wrong', 'forgot_email_wrong', 'form1.email_address'),
(15, 'home', '', 'home', ''),
(16, 'home', 'index', 'home', ''),
(17, 'member', '', 'member', ''),
(18, 'member', 'index', 'member', ''),
(19, 'member', 'browse', 'member_browse', ''),
(20, 'member', 'view', 'member_view', ''),
(21, 'member', 'profile_edit', 'profile_edit', 'form1.member_name'),
(22, 'member', 'password_edit', 'password_edit', 'form1.member_password_old'),
(23, 'member', 'email_add', 'email_add', ''),
(24, 'member', 'email_delete', 'email_delete', ''),
(25, 'member', 'approve', 'member_approve', ''),
(26, 'member', 'perm_group_edit', 'member_perm_group_edit', '');

-- --------------------------------------------------------

--
-- Table structure for table `r_perm`
--

DROP TABLE IF EXISTS `r_perm`;
CREATE TABLE IF NOT EXISTS `r_perm` (
  `perm_order_id` int(10) unsigned NOT NULL DEFAULT '0',
  `cat_id` int(10) unsigned NOT NULL DEFAULT '0',
  `perm_order` int(10) unsigned DEFAULT NULL,
  `perm_name` varchar(50) DEFAULT NULL,
  `perm_code` int(11) DEFAULT NULL,
  `perm_default` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `perm_status` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`perm_order_id`,`cat_id`),
  KEY `perm_code` (`perm_code`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `r_perm`
--

INSERT INTO `r_perm` (`perm_order_id`, `cat_id`, `perm_order`, `perm_name`, `perm_code`, `perm_default`, `perm_status`) VALUES
(1, 1, 1, 'trans_grpo', 10, 0, 1),
(1, 2, 1, 'masterdata_posisi', 10, 0, 1),
(1, 3, 1, 'report_dispnonstdstock', 10, 0, 1),
(1, 4, 1, 'auth_approve', 10, 0, 1),
(2, 1, 2, 'trans_grpodlv', 15, 0, 1),
(2, 2, 2, 'masterdata_status', 15, 0, 1),
(2, 3, 2, 'report_kodematerial', 15, 0, 1),
(2, 4, 2, 'auth_cancel', 15, 0, 1),
(3, 1, 3, 'trans_stockoutlet', 20, 0, 1),
(3, 2, 3, 'masterdata_admin', 20, 0, 1),
(3, 3, 3, 'report_variance', 20, 0, 1),
(3, 4, 3, 'auth_change', 20, 0, 1),
(4, 1, 4, 'trans_gisto', 25, 0, 1),
(4, 2, 4, 'masterdata_perm_group', 25, 0, 1),
(4, 3, 4, 'report_listoutstanding', 25, 0, 1),
(4, 4, 4, 'auth_backdate', 25, 0, 1),
(5, 1, 5, 'trans_grsto', 30, 0, 1),
(5, 3, 5, 'report_summwebdoc', 30, 0, 1),
(6, 1, 6, 'trans_waste', 35, 0, 1),
(7, 1, 7, 'trans_grnonpo', 40, 0, 1),
(7, 3, 7, 'report_variance2', 40, 0, 1),
(8, 1, 8, 'trans_nonstdstock', 45, 0, 1),
(9, 1, 9, 'trans_stdstock', 50, 0, 1),
(10, 1, 10, 'trans_grfg', 55, 0, 1),
(11, 1, 11, 'trans_tssck', 60, 0, 1),
(12, 1, 12, 'trans_trend_utility', 65, 0, 1),
(13, 1, 13, 'trans_prodstaff', 70, 0, 1),
(14, 1, 14, 'trans_gitcc', 75, 0, 1),
(15, 1, 15, 'trans_posinc', 80, 0, 1),
(16, 1, 16, 'trans_po_approval', 85, 0, 1),
(17, 1, 17, 'trans_twts', 90, 0, 1),
(18, 1, 18, 'trans_grpofg', 95, 0, 1),
(19, 1, 19, 'trans_deletedata', 100, 0, 1),
(19, 2, 19, 'masterdata_opnd', 100, 0, 1),
(20, 2, 20, 'masterdata_mwts', 105, 0, 1),
(21, 2, 21, 'masterdata_sfg', 110, 0, 1),
(22, 3, 8, 'report_prstodlvgr', 115, 0, 1),
(23, 3, 9, 'report_varianceoutlet', 120, 0, 1),
(24, 3, 10, 'report_upload_varianceoutlet', 125, 0, 1),
(25, 2, 25, 'masterdata_mpaket', 135, 0, 1),
(26, 1, 26, 'trans_tpaket', 140, 0, 1),
(601, 6, 601, 'download_excel', 601, 0, 1),
(80101, 8, 80101, 'hrd_input_dl', 80101, 0, 1),
(80102, 8, 80102, 'hrd_input_shift', 80102, 0, 1),
(80103, 8, 80103, 'hrd_input_izin', 80103, 0, 1),
(80104, 8, 80104, 'hrd_input_eod', 80104, 0, 1),
(80105, 8, 80105, 'hrd_input_request', 80105, 0, 1),
(80201, 8, 80201, 'hrd_list_employee', 80201, 0, 1),
(80301, 8, 80301, 'hrd_report_attendance', 80301, 0, 1),
(80302, 8, 80302, 'hrd_report_attendance_detail', 80302, 0, 1),
(80303, 8, 80303, 'hrd_report_employee_req', 80303, 0, 1),
(80305, 8, 80305, 'hrd_report_machine', 80305, 0, 1),
(80306, 8, 80306, 'hrd_report_suspect', 80306, 0, 1),
(514, 3, 514, 'report_waste', 514, 0, 1),
(515, 3, 515, 'report_waste_detail', 515, 0, 1),
(120101, 12, 120101, 'sync_material', 120101, 0, 1),
(120103, 12, 120103, 'sync_employee', 120103, 0, 1),
(120104, 12, 120104, 'sync_finger', 120104, 0, 1),
(120105, 12, 120105, 'sync_eom', 120105, 0, 1),
(120100, 12, 120100, 'sync_data', 120100, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `r_perm_category`
--

DROP TABLE IF EXISTS `r_perm_category`;
CREATE TABLE IF NOT EXISTS `r_perm_category` (
  `category_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category_name` varchar(50) DEFAULT NULL,
  `category_order` int(10) unsigned DEFAULT '0',
  `category_code` char(2) DEFAULT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `r_perm_category`
--

INSERT INTO `r_perm_category` (`category_id`, `category_name`, `category_order`, `category_code`) VALUES
(1, 'trans', 1, 'aa'),
(2, 'masterdata', 2, 'ab'),
(3, 'report', 3, 'ac'),
(4, 'auth', 4, 'ad'),
(6, 'download', 6, 'af'),
(8, 'hrd', 8, 'ag'),
(12, 'sync', 12, 'ak');

-- --------------------------------------------------------

--
-- Table structure for table `r_sync`
--

DROP TABLE IF EXISTS `r_sync`;
CREATE TABLE IF NOT EXISTS `r_sync` (
  `sync_type` varchar(45) NOT NULL,
  `sync_status` tinyint(1) NOT NULL DEFAULT '0',
  `sync_created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `sync_run` datetime DEFAULT NULL,
  `sync_schedule` datetime DEFAULT NULL,
  `sync_end` datetime DEFAULT NULL,
  `sync_admin` varchar(75) DEFAULT NULL,
  PRIMARY KEY (`sync_type`),
  UNIQUE KEY `sync_type_UNIQUE` (`sync_type`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `r_sync`
--

INSERT INTO `r_sync` (`sync_type`, `sync_status`, `sync_created`, `sync_run`, `sync_schedule`, `sync_end`, `sync_admin`) VALUES
('sync_employee', 2, '2016-07-31 17:02:01', '2016-08-01 00:02:01', '2016-08-01 00:02:01', '2016-08-01 00:03:20', 'AUTO BY SYSTEM'),
('sync_eom', 2, '2016-07-24 03:07:25', '2016-07-24 10:08:01', '2016-07-24 10:08:00', '2016-07-24 10:13:46', 'AUTO BY SYSTEM'),
('sync_finger', 2, '2016-08-01 03:56:50', '2016-08-01 10:57:01', '2016-08-01 10:57:00', '2016-08-01 11:05:58', 'AUTO BY SYSTEM'),
('sync_material', 1, '2016-08-01 04:57:09', '2016-08-01 11:58:01', '2016-08-01 11:58:00', NULL, 'AUTO BY SYSTEM');

-- --------------------------------------------------------

--
-- Table structure for table `r_system_module`
--

DROP TABLE IF EXISTS `r_system_module`;
CREATE TABLE IF NOT EXISTS `r_system_module` (
  `module_id` int(4) NOT NULL,
  `module_code` varchar(6) CHARACTER SET utf8 DEFAULT NULL,
  `web_module` varchar(8) CHARACTER SET utf8 DEFAULT NULL,
  `web_module_code` varchar(2) CHARACTER SET utf8 DEFAULT NULL,
  `web_trans` varchar(51) CHARACTER SET utf8 DEFAULT NULL,
  `controller_file` varchar(24) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`module_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `r_system_module`
--

INSERT INTO `r_system_module` (`module_id`, `module_code`, `web_module`, `web_module_code`, `web_trans`, `controller_file`) VALUES
(1003, '1003H2', 'HR', 'H2', 'Karyawan', 'employee.php'),
(1004, '1004H2', 'HR', 'H2', 'Izin Karyawan', 'employee_absent.php'),
(1005, '1005H2', 'HR', 'H2', 'Laporan Detail Kehadiran Karyawan', 'employee_attn_detail.php'),
(1006, '1006H2', 'HR', 'H2', 'Laporan Ringkas Kehadiran Karyawan', 'employee_attn_list.php'),
(1007, '1007H2', 'HR', 'H2', 'Dinas Luar', 'employee_fp.php'),
(1008, '1008H2', 'HR', 'H2', 'Laporan Data Mesin Absen', 'employee_machine.php'),
(1009, '1009H2', 'HR', 'H2', 'Permintaan Karyawan', 'employee_req.php'),
(1010, '1010H2', 'HR', 'H2', 'Shift Karyawan', 'employee_shift.php'),
(1011, '1011H2', 'HR', 'H2', 'Laporan Data Tidak Wajar', 'employee_suspect.php'),
(1012, '1012H2', 'HR', 'H2', 'HR End of Month', 'endofmonth.php'),
(1013, '1013H2', 'HR', 'H2', 'Posisi Karyawan', 'posisi.php'),
(1014, '1014H2', 'HR', 'H2', 'Sinkron HR', 'sinkron.php'),
(1015, '1015H2', 'HR', 'H2', 'Employee Status', 'status.php'),
(1016, '1016H2', 'HR', 'H2', 'Sinkron HR', 'synchr.php'),
(1017, '1017H2', 'HR', 'H2', 'Upload Fingerprint', 'upload_absent.php'),
(1018, '1018P1', 'POS', 'P1', 'Laporan Void Transight', 'void.php'),
(1023, '1023S1', 'SAP', 'S1', 'PO Approval X', 'ajax.php'),
(1024, '1024S1', 'SAP', 'S1', 'Reset/Hapus Data Opname & Waste', 'deletedata.php'),
(1025, '1025S1', 'SAP', 'S1', 'Display Standard Stock di Outlet', 'dispnonstdstock.php'),
(1026, '1026S1', 'SAP', 'S1', 'Download File', 'download.php'),
(1027, '1027S1', 'SAP', 'S1', 'Sinkron SAP', 'feed.php'),
(1028, '1028S1', 'SAP', 'S1', 'Goods Issue Stock Transfer Antar Plant', 'gisto.php'),
(1029, '1029S1', 'SAP', 'S1', 'Goods Issue to Cost Center', 'gitcc.php'),
(1030, '1030S1', 'SAP', 'S1', 'Goods Receipt FG Outlet', 'grfg.php'),
(1031, '1031S1', 'SAP', 'S1', 'Goods Receipt Non PO', 'grnonpo.php'),
(1032, '1032S1', 'SAP', 'S1', 'Goods Receipt PO from Vendor (Food)', 'grpo.php'),
(1033, '1033S1', 'SAP', 'S1', 'Goods Receipt PO STO with Delivery', 'grpodlv.php'),
(1034, '1034S1', 'SAP', 'S1', 'GR PO STO & GR FG Pastry/Cookies dr CK', 'grpofg.php'),
(1035, '1035S1', 'SAP', 'S1', 'Goods Receipt Stock Transfer Antar Plant', 'grsto.php'),
(1036, '1036S1', 'SAP', 'S1', 'Kode Material di Outlet', 'kodematerial.php'),
(1037, '1037S1', 'SAP', 'S1', 'Outstanding PR/PO/Delivery vs Stock vs Requirements', 'listoutstanding.php'),
(1038, '1038S1', 'SAP', 'S1', 'Master Paket', 'mpaket.php'),
(1039, '1039S1', 'SAP', 'S1', 'Master Konversi Item Whole ke Slice', 'mwts.php'),
(1040, '1040S1', 'SAP', 'S1', 'Request untuk Non Standard Stock', 'nonstdstock.php'),
(1041, '1041S1', 'SAP', 'S1', 'Master Item Opname Daily', 'opnd.php'),
(1042, '1042S1', 'SAP', 'S1', 'SAP End of Day', 'posinc.php'),
(1043, '1043S1', 'SAP', 'S1', 'PO Approval', 'po_approval.php'),
(1044, '1044S1', 'SAP', 'S1', 'PO Approval Error', 'po_approval_error.php'),
(1045, '1045S1', 'SAP', 'S1', 'Productivity Staff / Labour per Store', 'prodstaff.php'),
(1046, '1046S1', 'SAP', 'S1', 'Laporan PR STO vs DO vs Goods Receipt', 'prstodlvgr.php'),
(1047, '1047S1', 'SAP', 'S1', 'Master Semi Finished Goods (SFG) BOM', 'sfgs.php'),
(1048, '1048S1', 'SAP', 'S1', 'Request tambahan untuk Standard Stock', 'stdstock.php'),
(1049, '1049S1', 'SAP', 'S1', 'Stock Opname', 'stockoutlet.php'),
(1050, '1050S1', 'SAP', 'S1', 'Status Stock Opname', 'stockstatus.php'),
(1051, '1051S1', 'SAP', 'S1', 'Material Document Summary', 'summwebdoc.php'),
(1052, '1052S1', 'SAP', 'S1', 'Transaksi Paket', 'tpaket.php'),
(1053, '1053S1', 'SAP', 'S1', 'Trend Utility ( Usage )', 'trend_utility.php'),
(1054, '1054S1', 'SAP', 'S1', 'Transfer Selisih Stock ke CK', 'tssck.php'),
(1055, '1055S1', 'SAP', 'S1', 'Transaksi Pemotongan Whole di Outlet', 'twts.php'),
(1056, '1056S1', 'SAP', 'S1', 'Upload Report Variance Outlet', 'uploadrptvariance.php'),
(1057, '1057S1', 'SAP', 'S1', 'Request untuk Utensil', 'utensil.php'),
(1058, '1058S1', 'SAP', 'S1', 'Laporan Variance', 'variance.php'),
(1059, '1059S1', 'SAP', 'S1', 'Laporan Variance 2', 'variance2.php'),
(1060, '1060S1', 'SAP', 'S1', 'Laporan Variance Outlet', 'varianceoutlet.php'),
(1061, '1061S1', 'SAP', 'S1', 'Waste Material', 'waste.php'),
(1062, '1062S0', 'System', 'S0', 'Admin', 'admin.php'),
(1063, '1063S0', 'System', 'S0', 'Lupa Password', 'forget.php'),
(1064, '1064S0', 'System', 'S0', 'Home', 'home.php'),
(1066, '1066S0', 'System', 'S0', 'Jenis Outlet', 'jenisoutlet.php'),
(1067, '1067S0', 'System', 'S0', 'Login', 'login.php'),
(1068, '1068S0', 'System', 'S0', 'Logout', 'logout.php'),
(1069, '1069S0', 'System', 'S0', 'Mail System', 'mail.php'),
(1070, '1070S0', 'System', 'S0', 'Ganti Password Personel Outlet', 'password.php'),
(1071, '1071S0', 'System', 'S0', 'Hak Akses', 'perm.php'),
(1072, '1072S0', 'System', 'S0', 'Ubah Outlet Aktif', 'plant.php'),
(1073, '1073S0', 'System', 'S0', 'Manajemen User', 'user.php'),
(1075, '1075S1', 'SAP', 'S1', 'Report Waste', 'rpt_waste.php'),
(1078, '1078S1', 'SAP', 'S1', 'Goods Receipt PO from Vendor  (Non Food)', 'grponf.php');

-- --------------------------------------------------------

--
-- Table structure for table `t_employee_absent`
--

DROP TABLE IF EXISTS `t_employee_absent`;
CREATE TABLE IF NOT EXISTS `t_employee_absent` (
  `absent_id` int(11) NOT NULL AUTO_INCREMENT,
  `cabang` varchar(50) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `nik` varchar(50) DEFAULT NULL,
  `shift` varchar(10) DEFAULT NULL,
  `kd_shift` varchar(10) DEFAULT NULL,
  `shift_in` time DEFAULT NULL,
  `shift_break_out` time DEFAULT NULL,
  `shift_break_in` time DEFAULT NULL,
  `shift_out` time DEFAULT NULL,
  `kd_cuti` varchar(10) DEFAULT NULL,
  `kd_aktual` varchar(10) DEFAULT NULL,
  `kd_aktual_temp` varchar(10) DEFAULT NULL,
  `in` time DEFAULT NULL,
  `break_out` time DEFAULT NULL,
  `break_in` time DEFAULT NULL,
  `out` time DEFAULT NULL,
  `terlambat` time DEFAULT NULL,
  `pulang_cepat` time DEFAULT NULL,
  `jam_kerja` time DEFAULT NULL,
  `data_type` tinyint(3) DEFAULT '1' COMMENT '1: normal; 2: dinas luar',
  `on_process` tinyint(1) DEFAULT '0',
  `eod_lock` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`absent_id`),
  KEY `TGL_CAB_NIK` (`tanggal`,`cabang`,`nik`),
  KEY `CAB_TGL_NIK` (`cabang`,`tanggal`,`nik`,`kd_aktual`),
  KEY `CAB_TGL_NIK_TYPE` (`cabang`,`tanggal`,`nik`,`data_type`),
  KEY `TGL_NIK_SHIFT_TYPE_LOCK` (`tanggal`,`nik`,`shift`,`data_type`,`eod_lock`),
  KEY `LOCK` (`eod_lock`),
  KEY `NIK_TGL` (`nik`,`tanggal`),
  KEY `TGL_NIK` (`tanggal`,`nik`),
  KEY `TGL_NIK_TYPE` (`tanggal`,`nik`,`data_type`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_employee_absent_noshift`
--

DROP TABLE IF EXISTS `t_employee_absent_noshift`;
CREATE TABLE IF NOT EXISTS `t_employee_absent_noshift` (
  `absent_id_noshift` int(11) NOT NULL AUTO_INCREMENT,
  `cabang` varchar(50) NOT NULL DEFAULT '',
  `tanggal` date NOT NULL DEFAULT '0000-00-00',
  `nik` varchar(50) NOT NULL DEFAULT '',
  `in` time DEFAULT NULL,
  `break_out` time DEFAULT NULL,
  `break_in` time DEFAULT NULL,
  `out` time DEFAULT NULL,
  PRIMARY KEY (`absent_id_noshift`),
  UNIQUE KEY `MUST_UNIQUE` (`cabang`,`tanggal`,`nik`),
  KEY `NIK_TGL` (`nik`,`tanggal`),
  KEY `TGL_NIK` (`tanggal`,`nik`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_employee_req_stat`
--

DROP TABLE IF EXISTS `t_employee_req_stat`;
CREATE TABLE IF NOT EXISTS `t_employee_req_stat` (
  `stat_id` int(11) NOT NULL AUTO_INCREMENT,
  `cabang` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `request_id` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `candidate_no` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `candidate_name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `job_apply` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `recruit_date` date DEFAULT NULL,
  `interview_date` date DEFAULT NULL,
  `interview_phase` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `interviewer` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`stat_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_gisto_detail`
--

DROP TABLE IF EXISTS `t_gisto_detail`;
CREATE TABLE IF NOT EXISTS `t_gisto_detail` (
  `id_gisto_detail` bigint(19) NOT NULL AUTO_INCREMENT,
  `id_gisto_header` bigint(19) NOT NULL DEFAULT '0',
  `id_gisto_h_detail` int(11) DEFAULT NULL,
  `material_no` varchar(20) DEFAULT NULL,
  `material_desc` varchar(50) NOT NULL DEFAULT '',
  `gr_quantity` decimal(17,4) DEFAULT '0.0000',
  `uom` varchar(5) NOT NULL DEFAULT '',
  `ok` tinyint(3) NOT NULL DEFAULT '0',
  `ok_cancel` tinyint(3) NOT NULL DEFAULT '0',
  `material_docno_cancellation` varchar(20) NOT NULL DEFAULT '',
  `id_user_cancel` varchar(5) NOT NULL DEFAULT '',
  PRIMARY KEY (`id_gisto_detail`),
  KEY `id_gisto_header` (`id_gisto_header`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_gisto_header`
--

DROP TABLE IF EXISTS `t_gisto_header`;
CREATE TABLE IF NOT EXISTS `t_gisto_header` (
  `id_gisto_header` bigint(19) NOT NULL AUTO_INCREMENT,
  `posting_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `po_no` varchar(20) NOT NULL DEFAULT '',
  `gisto_no` varchar(20) NOT NULL DEFAULT '',
  `plant` varchar(20) DEFAULT NULL,
  `plant_name` varchar(50) DEFAULT NULL,
  `id_gisto_plant` int(11) DEFAULT NULL,
  `storage_location` varchar(20) DEFAULT NULL,
  `receiving_plant` varchar(20) DEFAULT NULL,
  `receiving_plant_name` varchar(50) DEFAULT NULL,
  `status` tinyint(3) NOT NULL DEFAULT '0',
  `item_group_code` varchar(50) DEFAULT NULL,
  `id_user_input` int(5) NOT NULL DEFAULT '0',
  `id_user_approved` int(5) NOT NULL DEFAULT '0',
  `id_user_cancel` int(5) NOT NULL DEFAULT '0',
  `filename` varchar(50) DEFAULT NULL,
  `lastmodified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_gisto_header`),
  KEY `posting_date` (`posting_date`),
  KEY `plant` (`plant`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_gitcc_detail`
--

DROP TABLE IF EXISTS `t_gitcc_detail`;
CREATE TABLE IF NOT EXISTS `t_gitcc_detail` (
  `id_gitcc_detail` bigint(19) NOT NULL AUTO_INCREMENT,
  `id_gitcc_header` bigint(19) DEFAULT NULL,
  `id_gitcc_h_detail` int(11) DEFAULT NULL,
  `material_no` varchar(20) DEFAULT '',
  `material_desc` varchar(50) DEFAULT '',
  `quantity` decimal(17,4) DEFAULT '0.0000',
  `uom` varchar(5) DEFAULT '',
  `additional_text` varchar(50) DEFAULT '',
  `ok` tinyint(3) DEFAULT NULL,
  `ok_cancel` tinyint(3) DEFAULT NULL,
  `material_docno_cancellation` varchar(20) DEFAULT '',
  `id_user_cancel` int(5) DEFAULT NULL,
  PRIMARY KEY (`id_gitcc_detail`),
  KEY `id_gitcc_header` (`id_gitcc_header`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_gitcc_header`
--

DROP TABLE IF EXISTS `t_gitcc_header`;
CREATE TABLE IF NOT EXISTS `t_gitcc_header` (
  `id_gitcc_header` bigint(19) NOT NULL AUTO_INCREMENT,
  `posting_date` datetime DEFAULT '0000-00-00 00:00:00',
  `gitcc_no` varchar(20) DEFAULT '',
  `plant` varchar(20) DEFAULT '',
  `plant_name` varchar(50) DEFAULT NULL,
  `id_gitcc_plant` int(11) DEFAULT NULL,
  `storage_location` varchar(20) DEFAULT '',
  `storage_location_name` varchar(50) DEFAULT NULL,
  `status` tinyint(3) DEFAULT NULL,
  `item_group_code` varchar(50) DEFAULT NULL,
  `id_user_input` int(5) DEFAULT NULL,
  `id_user_approved` int(5) DEFAULT NULL,
  `filename` varchar(50) DEFAULT NULL,
  `lastmodified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_gitcc_header`),
  KEY `posting_date` (`posting_date`),
  KEY `plant` (`plant`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_grfg_detail`
--

DROP TABLE IF EXISTS `t_grfg_detail`;
CREATE TABLE IF NOT EXISTS `t_grfg_detail` (
  `id_grfg_detail` bigint(19) NOT NULL AUTO_INCREMENT,
  `id_grfg_header` bigint(19) NOT NULL DEFAULT '0',
  `id_grfg_h_detail` int(11) DEFAULT NULL,
  `material_no` varchar(20) DEFAULT '',
  `material_desc` varchar(50) DEFAULT '',
  `gr_quantity` decimal(17,4) DEFAULT '0.0000',
  `uom` varchar(5) DEFAULT '',
  `ok` tinyint(3) DEFAULT '0',
  `ok_cancel` tinyint(3) DEFAULT '0',
  `material_docno_cancellation` varchar(20) DEFAULT NULL,
  `material_docno_approval` varchar(20) DEFAULT NULL,
  `id_user_cancel` int(5) DEFAULT '0',
  PRIMARY KEY (`id_grfg_detail`),
  KEY `id_grfg_header` (`id_grfg_header`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_grfg_header`
--

DROP TABLE IF EXISTS `t_grfg_header`;
CREATE TABLE IF NOT EXISTS `t_grfg_header` (
  `id_grfg_header` bigint(19) NOT NULL AUTO_INCREMENT,
  `posting_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `id_grfg_plant` int(11) DEFAULT NULL,
  `grfg_no` varchar(20) DEFAULT NULL,
  `plant` varchar(20) DEFAULT '',
  `plant_name` varchar(50) DEFAULT NULL,
  `storage_location` varchar(20) DEFAULT '',
  `storage_location_name` varchar(50) DEFAULT NULL,
  `item_group_code` varchar(50) DEFAULT NULL,
  `status` tinyint(3) DEFAULT '0',
  `id_user_input` int(5) DEFAULT '0',
  `id_user_approved` int(5) DEFAULT '0',
  `id_user_cancel` int(5) DEFAULT '0',
  `filename` varchar(50) DEFAULT NULL,
  `lastmodified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_grfg_header`),
  KEY `posting_date` (`posting_date`),
  KEY `plant` (`plant`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_grnonpo_detail`
--

DROP TABLE IF EXISTS `t_grnonpo_detail`;
CREATE TABLE IF NOT EXISTS `t_grnonpo_detail` (
  `id_grnonpo_detail` bigint(19) NOT NULL AUTO_INCREMENT,
  `id_grnonpo_header` bigint(19) DEFAULT NULL,
  `id_grnonpo_h_detail` int(11) DEFAULT NULL,
  `material_no` varchar(20) DEFAULT '',
  `material_desc` varchar(50) DEFAULT '',
  `quantity` decimal(17,4) DEFAULT '0.0000',
  `uom` varchar(5) DEFAULT '',
  `additional_text` varchar(50) DEFAULT '',
  `ok` tinyint(3) DEFAULT '0',
  `ok_cancel` tinyint(3) DEFAULT '0',
  `material_docno_cancellation` varchar(20) DEFAULT '',
  `id_user_cancel` int(5) DEFAULT NULL,
  PRIMARY KEY (`id_grnonpo_detail`),
  KEY `id_grnonpo_header` (`id_grnonpo_header`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_grnonpo_header`
--

DROP TABLE IF EXISTS `t_grnonpo_header`;
CREATE TABLE IF NOT EXISTS `t_grnonpo_header` (
  `id_grnonpo_header` bigint(19) NOT NULL AUTO_INCREMENT,
  `posting_date` datetime DEFAULT '0000-00-00 00:00:00',
  `grnonpo_no` varchar(20) DEFAULT '',
  `plant` varchar(20) DEFAULT '',
  `plant_name` varchar(50) DEFAULT NULL,
  `id_grnonpo_plant` int(11) DEFAULT NULL,
  `storage_location` varchar(20) DEFAULT '',
  `storage_location_name` varchar(50) DEFAULT NULL,
  `cost_center` varchar(20) DEFAULT NULL,
  `status` tinyint(3) DEFAULT NULL,
  `item_group_code` varchar(50) DEFAULT NULL,
  `id_user_input` int(5) DEFAULT NULL,
  `id_user_approved` int(5) DEFAULT NULL,
  `filename` varchar(50) DEFAULT NULL,
  `lastmodified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_grnonpo_header`),
  KEY `posting_date` (`posting_date`),
  KEY `plant` (`plant`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_grpodlv_detail`
--

DROP TABLE IF EXISTS `t_grpodlv_detail`;
CREATE TABLE IF NOT EXISTS `t_grpodlv_detail` (
  `id_grpodlv_detail` bigint(19) NOT NULL AUTO_INCREMENT,
  `id_grpodlv_header` bigint(19) DEFAULT NULL,
  `id_grpodlv_h_detail` int(11) DEFAULT NULL,
  `item` int(11) DEFAULT '0',
  `material_no` varchar(20) DEFAULT '',
  `material_desc` varchar(50) DEFAULT '',
  `outstanding_qty` decimal(17,4) DEFAULT '0.0000',
  `gr_quantity` decimal(17,4) DEFAULT '0.0000',
  `uom` varchar(5) DEFAULT '',
  `item_storage_location` varchar(10) DEFAULT NULL,
  `ok` tinyint(3) DEFAULT NULL,
  `ok_cancel` tinyint(3) DEFAULT NULL,
  `material_docno_cancellation` varchar(20) DEFAULT '',
  `id_user_cancel` int(5) DEFAULT NULL,
  `tssck_qty` decimal(17,4) DEFAULT '0.0000',
  PRIMARY KEY (`id_grpodlv_detail`),
  KEY `id_grpodlv_header` (`id_grpodlv_header`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_grpodlv_header`
--

DROP TABLE IF EXISTS `t_grpodlv_header`;
CREATE TABLE IF NOT EXISTS `t_grpodlv_header` (
  `id_grpodlv_header` bigint(19) NOT NULL AUTO_INCREMENT,
  `posting_date` datetime DEFAULT '0000-00-00 00:00:00',
  `do_no` varchar(20) DEFAULT '',
  `grpodlv_no` varchar(20) DEFAULT '',
  `delivery_date` date DEFAULT NULL,
  `plant` varchar(20) DEFAULT '',
  `plant_name` varchar(50) DEFAULT '',
  `id_grpodlv_plant` int(11) DEFAULT NULL,
  `storage_location` varchar(20) DEFAULT '',
  `storage_location_name` varchar(50) DEFAULT '',
  `status` tinyint(3) DEFAULT NULL,
  `item_group_code` varchar(50) DEFAULT NULL,
  `id_user_input` int(5) DEFAULT NULL,
  `id_user_approved` int(5) DEFAULT NULL,
  `id_user_cancel` int(5) DEFAULT NULL,
  `filename` varchar(50) DEFAULT NULL,
  `lastmodified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_grpodlv_header`),
  KEY `posting_date` (`posting_date`),
  KEY `plant` (`plant`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_grpofg_detail`
--

DROP TABLE IF EXISTS `t_grpofg_detail`;
CREATE TABLE IF NOT EXISTS `t_grpofg_detail` (
  `id_grpofg_detail` bigint(19) NOT NULL AUTO_INCREMENT,
  `id_grpofg_header` bigint(19) DEFAULT NULL,
  `id_grpofg_h_detail` int(11) DEFAULT NULL,
  `item` int(11) DEFAULT '0',
  `material_no` varchar(20) DEFAULT '',
  `material_no_pos` varchar(20) DEFAULT '',
  `material_desc` varchar(50) DEFAULT '',
  `outstanding_qty` decimal(17,4) DEFAULT '0.0000',
  `gr_quantity` decimal(17,4) DEFAULT '0.0000',
  `grfg_quantity` decimal(17,4) DEFAULT '0.0000',
  `uom` varchar(5) DEFAULT '',
  `item_storage_location` varchar(10) DEFAULT NULL,
  `ok` tinyint(3) DEFAULT NULL,
  `ok_cancel` tinyint(3) DEFAULT NULL,
  `material_docno_cancellation` varchar(20) DEFAULT '',
  `material_docno_fg_cancellation` varchar(20) DEFAULT '',
  `id_user_cancel` int(5) DEFAULT NULL,
  PRIMARY KEY (`id_grpofg_detail`),
  KEY `id_grpofg_header` (`id_grpofg_header`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_grpofg_header`
--

DROP TABLE IF EXISTS `t_grpofg_header`;
CREATE TABLE IF NOT EXISTS `t_grpofg_header` (
  `id_grpofg_header` bigint(19) NOT NULL AUTO_INCREMENT,
  `posting_date` datetime DEFAULT '0000-00-00 00:00:00',
  `do_no` varchar(20) DEFAULT '',
  `grpo_no` varchar(20) DEFAULT '',
  `grfg_no` varchar(20) DEFAULT '',
  `delivery_date` date DEFAULT NULL,
  `plant` varchar(20) DEFAULT '',
  `plant_name` varchar(50) DEFAULT '',
  `id_grpofg_plant` int(11) DEFAULT NULL,
  `storage_location` varchar(20) DEFAULT '',
  `storage_location_name` varchar(50) DEFAULT '',
  `status` tinyint(3) DEFAULT NULL,
  `item_group_code` varchar(50) DEFAULT NULL,
  `id_user_input` int(5) DEFAULT NULL,
  `id_user_approved` int(5) DEFAULT NULL,
  `id_user_cancel` int(5) DEFAULT NULL,
  `filename` varchar(50) DEFAULT NULL,
  `lastmodified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_grpofg_header`),
  KEY `posting_date` (`posting_date`),
  KEY `plant` (`plant`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_grpo_detail`
--

DROP TABLE IF EXISTS `t_grpo_detail`;
CREATE TABLE IF NOT EXISTS `t_grpo_detail` (
  `id_grpo_detail` bigint(19) NOT NULL AUTO_INCREMENT,
  `id_grpo_header` bigint(19) NOT NULL DEFAULT '0',
  `id_grpo_h_detail` int(11) NOT NULL DEFAULT '0',
  `item` int(11) DEFAULT NULL,
  `material_no` varchar(20) DEFAULT NULL,
  `material_desc` varchar(50) DEFAULT '',
  `outstanding_qty` decimal(17,4) DEFAULT '0.0000',
  `gr_quantity` decimal(17,4) DEFAULT '0.0000',
  `uom` varchar(5) DEFAULT '',
  `ok` tinyint(3) DEFAULT '1',
  `ok_cancel` tinyint(3) DEFAULT '0',
  `material_docno_cancellation` varchar(20) DEFAULT NULL,
  `id_user_cancel` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_grpo_detail`),
  KEY `id_grpo_header` (`id_grpo_header`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_grpo_header`
--

DROP TABLE IF EXISTS `t_grpo_header`;
CREATE TABLE IF NOT EXISTS `t_grpo_header` (
  `id_grpo_header` bigint(19) NOT NULL AUTO_INCREMENT,
  `posting_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `po_no` varchar(20) NOT NULL DEFAULT '',
  `grpo_no` varchar(20) NOT NULL DEFAULT '',
  `delivery_date` date DEFAULT NULL,
  `kd_vendor` varchar(20) NOT NULL DEFAULT '',
  `nm_vendor` varchar(50) NOT NULL DEFAULT '',
  `plant` varchar(20) DEFAULT NULL,
  `plant_name` varchar(50) DEFAULT NULL,
  `id_grpo_plant` int(11) DEFAULT NULL,
  `storage_location` varchar(20) DEFAULT '',
  `storage_location_name` varchar(50) DEFAULT NULL,
  `status` tinyint(3) NOT NULL DEFAULT '1',
  `item_group_code` varchar(50) DEFAULT NULL,
  `id_user_input` int(11) NOT NULL DEFAULT '0',
  `id_user_approved` int(11) DEFAULT NULL,
  `filename` varchar(50) DEFAULT NULL,
  `lastmodified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_grpo_header`),
  KEY `posting_date` (`posting_date`),
  KEY `plant` (`plant`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_grsto_detail`
--

DROP TABLE IF EXISTS `t_grsto_detail`;
CREATE TABLE IF NOT EXISTS `t_grsto_detail` (
  `id_grsto_detail` bigint(19) NOT NULL AUTO_INCREMENT,
  `id_grsto_header` bigint(19) DEFAULT '0',
  `id_grsto_h_detail` int(11) DEFAULT NULL,
  `item` int(11) DEFAULT NULL,
  `material_no` varchar(20) DEFAULT NULL,
  `material_desc` varchar(50) DEFAULT '',
  `outstanding_qty` decimal(17,4) DEFAULT '0.0000',
  `gr_quantity` decimal(17,4) DEFAULT '0.0000',
  `uom` varchar(5) DEFAULT '',
  `ok` tinyint(3) DEFAULT NULL,
  `ok_cancel` tinyint(3) DEFAULT NULL,
  `material_docno_cancellation` varchar(20) DEFAULT '',
  `id_user_cancel` int(5) DEFAULT NULL,
  PRIMARY KEY (`id_grsto_detail`),
  KEY `id_grsto_header` (`id_grsto_header`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_grsto_header`
--

DROP TABLE IF EXISTS `t_grsto_header`;
CREATE TABLE IF NOT EXISTS `t_grsto_header` (
  `id_grsto_header` bigint(19) NOT NULL AUTO_INCREMENT,
  `posting_date` datetime DEFAULT '0000-00-00 00:00:00',
  `po_no` varchar(20) DEFAULT '',
  `grsto_no` varchar(20) DEFAULT '',
  `no_doc_gist` varchar(20) DEFAULT '',
  `plant` varchar(20) DEFAULT NULL,
  `plant_name` varchar(50) DEFAULT NULL,
  `id_grsto_plant` int(11) DEFAULT NULL,
  `delivery_plant` varchar(20) DEFAULT '',
  `delivery_plant_name` varchar(50) DEFAULT NULL,
  `delivery_date` date DEFAULT NULL,
  `storage_location` varchar(20) DEFAULT '',
  `storage_location_name` varchar(50) DEFAULT NULL,
  `status` tinyint(3) DEFAULT NULL,
  `item_group_code` varchar(50) DEFAULT NULL,
  `id_user_input` int(5) DEFAULT NULL,
  `id_user_approved` int(5) DEFAULT NULL,
  `filename` varchar(50) DEFAULT NULL,
  `lastmodified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_grsto_header`),
  KEY `posting_date` (`posting_date`),
  KEY `plant` (`plant`),
  KEY `delivery_plant` (`delivery_plant`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_jenisoutlet`
--

DROP TABLE IF EXISTS `t_jenisoutlet`;
CREATE TABLE IF NOT EXISTS `t_jenisoutlet` (
  `id_jenisoutlet` char(3) NOT NULL DEFAULT '',
  `jenisoutlet` varchar(35) NOT NULL DEFAULT '',
  `nama_perusahaan` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_jenisoutlet`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_jenisoutlet`
--

INSERT INTO `t_jenisoutlet` (`id_jenisoutlet`, `jenisoutlet`, `nama_perusahaan`) VALUES
('YBC', 'YBC SOFTWARE', 'PT YBC SOFTWARE');

-- --------------------------------------------------------

--
-- Table structure for table `t_nonstdstock_detail`
--

DROP TABLE IF EXISTS `t_nonstdstock_detail`;
CREATE TABLE IF NOT EXISTS `t_nonstdstock_detail` (
  `id_nonstdstock_detail` bigint(19) NOT NULL AUTO_INCREMENT,
  `id_nonstdstock_header` bigint(19) DEFAULT NULL,
  `id_nonstdstock_h_detail` int(11) DEFAULT NULL,
  `id_nonstdstock_pr_line_no` int(11) DEFAULT NULL,
  `material_no` varchar(20) DEFAULT '',
  `material_desc` varchar(50) DEFAULT '',
  `delivery_date` datetime DEFAULT NULL,
  `lead_time` tinyint(2) DEFAULT NULL,
  `requirement_qty` decimal(17,4) DEFAULT '0.0000',
  `uom` varchar(5) DEFAULT '',
  `ok` text,
  PRIMARY KEY (`id_nonstdstock_detail`),
  KEY `id_nonstdstock_header` (`id_nonstdstock_header`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_nonstdstock_header`
--

DROP TABLE IF EXISTS `t_nonstdstock_header`;
CREATE TABLE IF NOT EXISTS `t_nonstdstock_header` (
  `id_nonstdstock_header` bigint(19) NOT NULL AUTO_INCREMENT,
  `id_nonstdstock_plant` int(11) DEFAULT NULL,
  `pr_no` varchar(20) DEFAULT NULL,
  `plant` varchar(20) DEFAULT '',
  `plant_name` varchar(50) DEFAULT NULL,
  `storage_location` varchar(20) DEFAULT '',
  `storage_location_name` varchar(50) DEFAULT NULL,
  `request_reason` varchar(10) DEFAULT NULL,
  `item_group_code` varchar(50) DEFAULT NULL,
  `created_date` datetime DEFAULT '0000-00-00 00:00:00',
  `status` tinyint(3) DEFAULT NULL,
  `id_user_input` int(5) DEFAULT NULL,
  `id_user_approved` int(5) DEFAULT NULL,
  `id_user_cancel` int(5) DEFAULT NULL,
  `filename` varchar(50) DEFAULT NULL,
  `lastmodified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_nonstdstock_header`),
  KEY `id_nonstdstock_plant` (`id_nonstdstock_plant`),
  KEY `plant` (`plant`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_posinc_header`
--

DROP TABLE IF EXISTS `t_posinc_header`;
CREATE TABLE IF NOT EXISTS `t_posinc_header` (
  `id_posinc_header` bigint(19) NOT NULL AUTO_INCREMENT,
  `posting_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `id_posinc_plant` int(11) DEFAULT NULL,
  `waste_no` varchar(20) DEFAULT NULL,
  `stockoutlet_no` varchar(20) DEFAULT NULL,
  `plant` varchar(20) DEFAULT '',
  `ok` tinyint(1) DEFAULT NULL,
  `total_remintance` decimal(15,2) DEFAULT NULL,
  `status` tinyint(3) DEFAULT NULL,
  `id_user_input` int(5) DEFAULT NULL,
  `id_user_approved` int(5) DEFAULT NULL,
  `id_user_cancel` int(5) DEFAULT NULL,
  `lastmodified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_posinc_header`),
  KEY `posting_date` (`posting_date`),
  KEY `plant` (`plant`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_posisi`
--

DROP TABLE IF EXISTS `t_posisi`;
CREATE TABLE IF NOT EXISTS `t_posisi` (
  `id_posisi` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `posisi` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`id_posisi`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=86 ;

--
-- Dumping data for table `t_posisi`
--

INSERT INTO `t_posisi` (`id_posisi`, `posisi`) VALUES
(31, 'Topping 1'),
(32, 'Topping 2'),
(33, 'Topping 3'),
(34, 'Topping 4'),
(35, 'Topping 5'),
(36, 'Stocker'),
(37, 'BodyGuard MOD'),
(38, '2'),
(39, '3'),
(40, '4'),
(41, '5'),
(42, '6'),
(43, '7'),
(44, '8'),
(45, 'stocker'),
(46, 'Stocker'),
(47, 'stocker'),
(48, 'stocker'),
(49, 'spv'),
(50, 'Supervisor'),
(51, 'Supervisor'),
(52, 'Supervisor'),
(53, 'Security'),
(54, 'Supervisor'),
(55, 'asm'),
(56, 'ASM'),
(57, 'Security'),
(58, 'katanya manager'),
(59, 'mt (malam trus)'),
(60, 'SM ( Sial Mulu )'),
(61, 'stoker'),
(62, 'asm'),
(63, 'Tukang Kebun'),
(64, 'Store Mgr'),
(65, 'duma'),
(66, 'Tukang Parkir'),
(67, 'Sekretaris MOD'),
(68, 'manager'),
(69, 'Selalu Masalah ( sm )'),
(70, 'akan selalu menghindar( asm )'),
(71, 'stocker'),
(72, 'reser'),
(73, 'samsi'),
(74, 'samsi'),
(75, 'samsi'),
(76, 'jj'),
(77, 'MARKETING'),
(78, 'Manager'),
(79, 'stocker'),
(80, 'stocker'),
(81, 'baker'),
(82, 'frontliner'),
(83, 'sm'),
(84, 'controlling'),
(85, 'controller');

-- --------------------------------------------------------

--
-- Table structure for table `t_prodstaff_detail`
--

DROP TABLE IF EXISTS `t_prodstaff_detail`;
CREATE TABLE IF NOT EXISTS `t_prodstaff_detail` (
  `id_prodstaff_detail` bigint(19) NOT NULL AUTO_INCREMENT,
  `id_prodstaff_header` bigint(19) DEFAULT '0',
  `id_prodstaff_h_detail` int(11) DEFAULT NULL,
  `id_posisi` int(2) DEFAULT NULL,
  `id_status` int(2) DEFAULT NULL,
  `posisi` varchar(50) DEFAULT '',
  `status` varchar(50) DEFAULT '',
  `jml_karyawan` decimal(7,0) DEFAULT '0',
  `total_jam` decimal(7,0) DEFAULT '0',
  `creation_date` datetime DEFAULT '0000-00-00 00:00:00',
  `change_date` datetime DEFAULT '0000-00-00 00:00:00',
  `ok` text,
  PRIMARY KEY (`id_prodstaff_detail`),
  KEY `id_prodstaff_header` (`id_prodstaff_header`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_prodstaff_header`
--

DROP TABLE IF EXISTS `t_prodstaff_header`;
CREATE TABLE IF NOT EXISTS `t_prodstaff_header` (
  `id_prodstaff_header` bigint(19) NOT NULL AUTO_INCREMENT,
  `posting_date` datetime DEFAULT '0000-00-00 00:00:00',
  `prodstaff_no` varchar(20) NOT NULL,
  `plant` varchar(20) DEFAULT '',
  `plant_name` varchar(50) DEFAULT NULL,
  `id_prodstaff_plant` int(11) DEFAULT NULL,
  `status` tinyint(3) DEFAULT NULL,
  `id_user_input` int(5) DEFAULT NULL,
  `id_user_approved` int(5) DEFAULT NULL,
  `filename` varchar(50) DEFAULT '',
  `lastmodified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_prodstaff_header`),
  KEY `posting_date` (`posting_date`),
  KEY `plant` (`plant`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_saprfc_user`
--

DROP TABLE IF EXISTS `t_saprfc_user`;
CREATE TABLE IF NOT EXISTS `t_saprfc_user` (
  `saprfc_user` varchar(20) NOT NULL,
  `saprfc_type` tinyint(4) NOT NULL,
  PRIMARY KEY (`saprfc_user`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `t_status`
--

DROP TABLE IF EXISTS `t_status`;
CREATE TABLE IF NOT EXISTS `t_status` (
  `id_status` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `status` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`id_status`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_statuseod`
--

DROP TABLE IF EXISTS `t_statuseod`;
CREATE TABLE IF NOT EXISTS `t_statuseod` (
  `posting_date` date NOT NULL,
  `plant` varchar(10) NOT NULL DEFAULT '',
  `status_eod_transight` tinyint(3) DEFAULT '0',
  `status_eod_transight_errcode` int(11) DEFAULT '0',
  `status_eod_transight_errdesc` varchar(255) DEFAULT NULL,
  `status_eod_transight_time` datetime DEFAULT NULL,
  `status_eod_pos` tinyint(3) DEFAULT '0',
  `status_eod_opname` tinyint(3) DEFAULT '0',
  `status_eod_waste` tinyint(3) DEFAULT '0',
  `status_eod_sap` tinyint(3) DEFAULT '0',
  `status_hr` tinyint(3) DEFAULT '0',
  `remarkflag` tinyint(3) DEFAULT '0',
  PRIMARY KEY (`posting_date`,`plant`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `t_statusgetdata`
--

DROP TABLE IF EXISTS `t_statusgetdata`;
CREATE TABLE IF NOT EXISTS `t_statusgetdata` (
  `plant` varchar(10) NOT NULL DEFAULT '',
  `poout_lastupdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`plant`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `t_statusgetdataposto`
--

DROP TABLE IF EXISTS `t_statusgetdataposto`;
CREATE TABLE IF NOT EXISTS `t_statusgetdataposto` (
  `plant` varchar(10) NOT NULL DEFAULT '',
  `postoout_lastupdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`plant`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `t_statuspos`
--

DROP TABLE IF EXISTS `t_statuspos`;
CREATE TABLE IF NOT EXISTS `t_statuspos` (
  `posting_date` date NOT NULL,
  `plant` varchar(10) NOT NULL,
  `status` tinyint(3) DEFAULT '0',
  PRIMARY KEY (`posting_date`,`plant`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `t_statusvoid`
--

DROP TABLE IF EXISTS `t_statusvoid`;
CREATE TABLE IF NOT EXISTS `t_statusvoid` (
  `posting_date` date NOT NULL,
  `plant` varchar(10) DEFAULT NULL,
  `storenum` varchar(7) DEFAULT NULL,
  `emplname` varchar(25) DEFAULT NULL,
  `totalvoid` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `numbervoid` smallint(5) unsigned NOT NULL DEFAULT '0',
  KEY `voidstatus` (`posting_date`,`plant`,`emplname`),
  KEY `void_date_plant` (`posting_date`,`plant`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `t_status_sync`
--

DROP TABLE IF EXISTS `t_status_sync`;
CREATE TABLE IF NOT EXISTS `t_status_sync` (
  `sync_stat` varchar(100) NOT NULL,
  `sync_desc` text,
  PRIMARY KEY (`sync_stat`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `t_stdstock_detail`
--

DROP TABLE IF EXISTS `t_stdstock_detail`;
CREATE TABLE IF NOT EXISTS `t_stdstock_detail` (
  `id_stdstock_detail` bigint(19) NOT NULL AUTO_INCREMENT,
  `id_stdstock_header` bigint(19) NOT NULL DEFAULT '0',
  `id_stdstock_h_detail` int(11) DEFAULT NULL,
  `id_stdstock_pr_line_no` int(11) DEFAULT NULL,
  `material_no` varchar(20) NOT NULL DEFAULT '',
  `material_desc` varchar(50) NOT NULL DEFAULT '',
  `requirement_qty` decimal(17,4) DEFAULT '0.0000',
  `uom` varchar(5) NOT NULL DEFAULT '',
  `id_user_change` int(5) DEFAULT NULL,
  PRIMARY KEY (`id_stdstock_detail`),
  KEY `id_stdstock_header` (`id_stdstock_header`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_stdstock_header`
--

DROP TABLE IF EXISTS `t_stdstock_header`;
CREATE TABLE IF NOT EXISTS `t_stdstock_header` (
  `id_stdstock_header` bigint(19) NOT NULL AUTO_INCREMENT,
  `id_stdstock_plant` int(11) DEFAULT NULL,
  `delivery_date` datetime DEFAULT '0000-00-00 00:00:00',
  `pr_no` varchar(20) DEFAULT NULL,
  `plant` varchar(20) DEFAULT '',
  `plant_name` varchar(50) DEFAULT NULL,
  `storage_location` varchar(20) DEFAULT '',
  `storage_location_name` varchar(50) DEFAULT NULL,
  `created_date` datetime DEFAULT '0000-00-00 00:00:00',
  `item_group_code` varchar(50) DEFAULT NULL,
  `request_reason` varchar(20) DEFAULT NULL,
  `status` tinyint(3) DEFAULT '0',
  `id_user_input` int(5) DEFAULT '0',
  `id_user_approved` int(5) DEFAULT '0',
  `id_user_cancel` int(5) DEFAULT '0',
  `filename` varchar(50) DEFAULT NULL,
  `lastmodified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_stdstock_header`),
  KEY `id_stdstock_plant` (`id_stdstock_plant`),
  KEY `plant` (`plant`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_stockoutlet_detail`
--

DROP TABLE IF EXISTS `t_stockoutlet_detail`;
CREATE TABLE IF NOT EXISTS `t_stockoutlet_detail` (
  `id_stockoutlet_detail` bigint(19) NOT NULL AUTO_INCREMENT,
  `id_stockoutlet_header` bigint(19) DEFAULT '0',
  `id_stockoutlet_h_detail` int(11) DEFAULT NULL,
  `material_no` varchar(20) DEFAULT NULL,
  `material_desc` varchar(50) DEFAULT '',
  `qty_gso` decimal(17,4) DEFAULT '0.0000',
  `qty_gss` decimal(17,4) DEFAULT '0.0000',
  `quantity` decimal(17,4) DEFAULT '0.0000',
  `uom` varchar(5) DEFAULT '',
  PRIMARY KEY (`id_stockoutlet_detail`),
  KEY `id_stockoutlet_header` (`id_stockoutlet_header`),
  KEY `material_no` (`material_no`),
  KEY `idx_idstock_matno` (`id_stockoutlet_header`,`material_no`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_stockoutlet_detail_arch`
--

DROP TABLE IF EXISTS `t_stockoutlet_detail_arch`;
CREATE TABLE IF NOT EXISTS `t_stockoutlet_detail_arch` (
  `id_stockoutlet_detail` bigint(19) NOT NULL AUTO_INCREMENT,
  `id_stockoutlet_header` bigint(19) DEFAULT '0',
  `id_stockoutlet_h_detail` int(11) DEFAULT NULL,
  `material_no` varchar(20) DEFAULT '',
  `material_desc` varchar(50) DEFAULT '',
  `qty_gso` decimal(17,4) DEFAULT '0.0000',
  `qty_gss` decimal(17,4) DEFAULT '0.0000',
  `quantity` decimal(17,4) DEFAULT '0.0000',
  `uom` varchar(5) DEFAULT '',
  PRIMARY KEY (`id_stockoutlet_detail`),
  KEY `id_stockoutlet_header` (`id_stockoutlet_header`),
  KEY `material_no` (`material_no`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_stockoutlet_detail_bom`
--

DROP TABLE IF EXISTS `t_stockoutlet_detail_bom`;
CREATE TABLE IF NOT EXISTS `t_stockoutlet_detail_bom` (
  `id_stockoutlet_bom_detail` bigint(19) NOT NULL AUTO_INCREMENT,
  `id_stockoutlet_detail` bigint(19) DEFAULT '0',
  `id_stockoutlet_header` bigint(19) DEFAULT '0',
  `id_stockoutlet_h_detail_bom` int(11) DEFAULT NULL,
  `material_no_sfg` varchar(20) DEFAULT '',
  `material_no` varchar(20) DEFAULT NULL,
  `material_desc` varchar(50) DEFAULT '',
  `quantity` decimal(17,4) DEFAULT '0.0000',
  `uom` varchar(5) DEFAULT '',
  PRIMARY KEY (`id_stockoutlet_bom_detail`),
  KEY `material_no_sfg` (`material_no_sfg`),
  KEY `material_no` (`material_no`),
  KEY `id_stockoutlet_header` (`id_stockoutlet_header`),
  KEY `idx_idstock_dtl` (`id_stockoutlet_detail`),
  KEY `idx_idstock_matno` (`id_stockoutlet_header`,`material_no_sfg`),
  KEY `idx_matno_idstock` (`material_no_sfg`,`id_stockoutlet_header`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_stockoutlet_header`
--

DROP TABLE IF EXISTS `t_stockoutlet_header`;
CREATE TABLE IF NOT EXISTS `t_stockoutlet_header` (
  `id_stockoutlet_header` bigint(19) NOT NULL AUTO_INCREMENT,
  `posting_date` datetime DEFAULT '0000-00-00 00:00:00',
  `material_doc_no` varchar(20) DEFAULT '',
  `plant` varchar(20) DEFAULT NULL,
  `plant_name` varchar(50) DEFAULT NULL,
  `id_stockoutlet_plant` int(11) DEFAULT NULL,
  `storage_location` varchar(20) DEFAULT '',
  `storage_location_name` varchar(50) DEFAULT NULL,
  `status` tinyint(3) DEFAULT NULL,
  `item_group_code` varchar(50) DEFAULT NULL,
  `id_user_input` int(5) DEFAULT NULL,
  `id_user_approved` int(5) DEFAULT NULL,
  `filename` varchar(50) DEFAULT '',
  `lastmodified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_stockoutlet_header`),
  KEY `posting_date` (`posting_date`),
  KEY `plant` (`plant`),
  KEY `idx_maxdate` (`posting_date`,`plant`),
  KEY `idx_maxdate2` (`plant`,`posting_date`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_sys_activity_log`
--

DROP TABLE IF EXISTS `t_sys_activity_log`;
CREATE TABLE IF NOT EXISTS `t_sys_activity_log` (
  `id_activity_log` int(11) NOT NULL AUTO_INCREMENT,
  `sys_browser` varchar(120) DEFAULT NULL,
  `sys_ip` varchar(45) DEFAULT NULL,
  `sys_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `sys_username` varchar(55) DEFAULT NULL,
  `sys_session_id` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_activity_log`),
  KEY `Username` (`sys_username`),
  KEY `SysTime` (`sys_time`),
  KEY `User_Time` (`sys_username`,`sys_time`),
  KEY `Session_ID` (`sys_session_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_tpaket_detail`
--

DROP TABLE IF EXISTS `t_tpaket_detail`;
CREATE TABLE IF NOT EXISTS `t_tpaket_detail` (
  `id_tpaket_detail` bigint(19) NOT NULL AUTO_INCREMENT,
  `id_tpaket_header` bigint(19) DEFAULT '0',
  `id_tpaket_h_detail` int(11) DEFAULT NULL,
  `material_no` varchar(20) DEFAULT NULL,
  `material_desc` varchar(50) DEFAULT '',
  `quantity` decimal(17,4) DEFAULT '0.0000',
  `uom` varchar(5) DEFAULT '',
  `ok` tinyint(3) DEFAULT NULL,
  `ok_cancel` tinyint(3) DEFAULT NULL,
  `material_docno_cancellation` varchar(20) DEFAULT NULL,
  `material_docno_out_cancellation` varchar(20) DEFAULT NULL,
  `id_user_cancel` int(5) DEFAULT NULL,
  PRIMARY KEY (`id_tpaket_detail`),
  KEY `id_tpaket_header` (`id_tpaket_header`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_tpaket_detail_paket`
--

DROP TABLE IF EXISTS `t_tpaket_detail_paket`;
CREATE TABLE IF NOT EXISTS `t_tpaket_detail_paket` (
  `id_tpaket_paket_detail` bigint(19) NOT NULL AUTO_INCREMENT,
  `id_tpaket_detail` bigint(19) DEFAULT '0',
  `id_tpaket_header` bigint(19) DEFAULT '0',
  `id_tpaket_h_detail_paket` int(11) DEFAULT NULL,
  `material_no_paket` varchar(20) DEFAULT '',
  `material_no` varchar(20) DEFAULT NULL,
  `material_desc` varchar(50) DEFAULT '',
  `quantity` decimal(17,4) DEFAULT '0.0000',
  `uom` varchar(5) DEFAULT '',
  PRIMARY KEY (`id_tpaket_paket_detail`),
  KEY `id_tpaket_paket_detail` (`id_tpaket_paket_detail`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_tpaket_header`
--

DROP TABLE IF EXISTS `t_tpaket_header`;
CREATE TABLE IF NOT EXISTS `t_tpaket_header` (
  `id_tpaket_header` bigint(19) NOT NULL AUTO_INCREMENT,
  `posting_date` datetime DEFAULT '0000-00-00 00:00:00',
  `material_doc_no` varchar(20) DEFAULT '',
  `material_doc_no_out` varchar(20) DEFAULT NULL,
  `plant` varchar(20) DEFAULT NULL,
  `plant_name` varchar(50) DEFAULT NULL,
  `id_tpaket_plant` int(11) DEFAULT NULL,
  `storage_location` varchar(20) DEFAULT '',
  `storage_location_name` varchar(50) DEFAULT NULL,
  `status` tinyint(3) DEFAULT NULL,
  `item_group_code` varchar(50) DEFAULT NULL,
  `id_user_input` int(5) DEFAULT '0',
  `id_user_approved` int(5) DEFAULT '0',
  `filename` varchar(50) DEFAULT '',
  PRIMARY KEY (`id_tpaket_header`),
  KEY `posting_date` (`posting_date`),
  KEY `plant` (`plant`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_trend_utility`
--

DROP TABLE IF EXISTS `t_trend_utility`;
CREATE TABLE IF NOT EXISTS `t_trend_utility` (
  `id_tendutility` bigint(19) NOT NULL DEFAULT '0',
  `posting_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `plant` varchar(20) NOT NULL DEFAULT '',
  `kwh` float NOT NULL DEFAULT '0',
  `jam_pencatatan` varchar(5) NOT NULL DEFAULT '',
  `ok` text NOT NULL,
  `material_docno_cancellation` varchar(20) NOT NULL DEFAULT '',
  `status` text NOT NULL,
  `id_user_input` varchar(5) NOT NULL DEFAULT '',
  `id_user_approved` varchar(5) NOT NULL DEFAULT '',
  `id_user_cancel` varchar(5) NOT NULL DEFAULT '',
  `filename` varchar(50) NOT NULL,
  PRIMARY KEY (`id_tendutility`),
  KEY `posting_date` (`posting_date`),
  KEY `plant` (`plant`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `t_trend_utility_header`
--

DROP TABLE IF EXISTS `t_trend_utility_header`;
CREATE TABLE IF NOT EXISTS `t_trend_utility_header` (
  `id_trend_utility_header` bigint(19) NOT NULL AUTO_INCREMENT,
  `posting_date` datetime DEFAULT '0000-00-00 00:00:00',
  `id_trend_utility_plant` int(11) DEFAULT NULL,
  `trend_utility_no` varchar(20) DEFAULT NULL,
  `plant` varchar(20) DEFAULT '',
  `plant_name` varchar(50) DEFAULT NULL,
  `kwh_awal` decimal(15,2) DEFAULT NULL,
  `kwh_akhir` decimal(15,2) DEFAULT NULL,
  `kwh_total` decimal(15,2) DEFAULT NULL,
  `jam_pencatatan` time DEFAULT NULL,
  `ok` text,
  `material_docno_cancellation` varchar(20) DEFAULT '',
  `status` tinyint(3) DEFAULT '0',
  `id_user_input` int(5) DEFAULT NULL,
  `id_user_approved` int(5) DEFAULT NULL,
  `id_user_cancel` int(5) DEFAULT NULL,
  `filename` varchar(50) DEFAULT NULL,
  `lastmodified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_trend_utility_header`),
  KEY `posting_date` (`posting_date`),
  KEY `plant` (`plant`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_tssck_detail`
--

DROP TABLE IF EXISTS `t_tssck_detail`;
CREATE TABLE IF NOT EXISTS `t_tssck_detail` (
  `id_tssck_detail` bigint(19) NOT NULL AUTO_INCREMENT,
  `id_tssck_header` bigint(19) NOT NULL DEFAULT '0',
  `id_tssck_h_detail` int(11) DEFAULT NULL,
  `material_no` varchar(20) NOT NULL DEFAULT '',
  `material_desc` varchar(50) NOT NULL DEFAULT '',
  `gr_quantity` decimal(17,4) DEFAULT '0.0000',
  `uom` varchar(5) NOT NULL DEFAULT '',
  `ok` tinyint(3) NOT NULL DEFAULT '0',
  `ok_cancel` tinyint(3) NOT NULL DEFAULT '0',
  `material_docno_cancellation` varchar(20) NOT NULL DEFAULT '',
  `id_user_cancel` varchar(5) NOT NULL DEFAULT '',
  PRIMARY KEY (`id_tssck_detail`),
  KEY `id_tssck_header` (`id_tssck_header`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_tssck_header`
--

DROP TABLE IF EXISTS `t_tssck_header`;
CREATE TABLE IF NOT EXISTS `t_tssck_header` (
  `id_tssck_header` bigint(19) NOT NULL AUTO_INCREMENT,
  `posting_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `po_no` varchar(20) NOT NULL DEFAULT '',
  `tssck_no` varchar(20) NOT NULL DEFAULT '',
  `do_no` varchar(20) DEFAULT NULL,
  `plant` varchar(20) DEFAULT NULL,
  `plant_name` varchar(50) DEFAULT NULL,
  `id_tssck_plant` int(11) DEFAULT NULL,
  `storage_location` varchar(20) DEFAULT NULL,
  `receiving_plant` varchar(20) DEFAULT NULL,
  `receiving_plant_name` varchar(50) DEFAULT NULL,
  `status` tinyint(3) NOT NULL DEFAULT '0',
  `item_group_code` varchar(50) DEFAULT NULL,
  `id_user_input` int(5) NOT NULL DEFAULT '0',
  `id_user_approved` int(5) NOT NULL DEFAULT '0',
  `id_user_cancel` int(5) NOT NULL DEFAULT '0',
  `filename` varchar(50) DEFAULT NULL,
  `lastmodified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_tssck_header`),
  KEY `posting_date` (`posting_date`),
  KEY `plant` (`plant`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_twts_detail`
--

DROP TABLE IF EXISTS `t_twts_detail`;
CREATE TABLE IF NOT EXISTS `t_twts_detail` (
  `id_twts_detail` bigint(19) NOT NULL AUTO_INCREMENT,
  `id_twts_header` bigint(19) DEFAULT NULL,
  `id_twts_h_detail` int(11) DEFAULT NULL,
  `item` int(11) DEFAULT '0',
  `material_no` varchar(20) DEFAULT '',
  `material_no_gr` varchar(20) DEFAULT '',
  `material_desc` varchar(50) DEFAULT '',
  `material_desc_gr` varchar(50) DEFAULT '',
  `konv_qty` decimal(17,4) DEFAULT '0.0000',
  `quantity` decimal(17,4) DEFAULT '0.0000',
  `quantity_gr` decimal(17,4) DEFAULT '0.0000',
  `uom` varchar(5) DEFAULT '',
  `uom_gr` varchar(5) DEFAULT '',
  `ok` tinyint(3) DEFAULT NULL,
  `ok_cancel` tinyint(3) DEFAULT NULL,
  `material_docno_cancellation` varchar(20) DEFAULT '',
  `material_docno_gr_cancellation` varchar(20) DEFAULT '',
  `id_user_cancel` int(5) DEFAULT NULL,
  PRIMARY KEY (`id_twts_detail`),
  KEY `id_twts_header` (`id_twts_header`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_twts_header`
--

DROP TABLE IF EXISTS `t_twts_header`;
CREATE TABLE IF NOT EXISTS `t_twts_header` (
  `id_twts_header` bigint(19) NOT NULL AUTO_INCREMENT,
  `posting_date` datetime DEFAULT '0000-00-00 00:00:00',
  `gr_no` varchar(20) DEFAULT '',
  `gi_no` varchar(20) DEFAULT '',
  `plant` varchar(20) DEFAULT '',
  `plant_name` varchar(50) DEFAULT '',
  `id_twts_plant` int(11) DEFAULT NULL,
  `storage_location` varchar(20) DEFAULT '',
  `storage_location_name` varchar(50) DEFAULT '',
  `status` tinyint(3) DEFAULT NULL,
  `item_group_code` varchar(50) DEFAULT NULL,
  `id_user_input` int(5) DEFAULT NULL,
  `id_user_approved` int(5) DEFAULT NULL,
  `id_user_cancel` int(5) DEFAULT NULL,
  `filename` varchar(50) DEFAULT NULL,
  `lastmodified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_twts_header`),
  KEY `posting_date` (`posting_date`),
  KEY `plant` (`plant`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_upload_absent`
--

DROP TABLE IF EXISTS `t_upload_absent`;
CREATE TABLE IF NOT EXISTS `t_upload_absent` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode_cabang` varchar(10) NOT NULL,
  `tanggal` date DEFAULT NULL,
  `finger_print` int(5) DEFAULT NULL,
  `waktu` time DEFAULT NULL,
  `status_absen` tinyint(4) DEFAULT NULL,
  `status_proses` tinyint(1) NOT NULL DEFAULT '0',
  `lastmodified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `finger_eod_lock` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `UPLOAD_ABSEN` (`finger_print`,`tanggal`,`waktu`,`kode_cabang`),
  KEY `status_proses` (`status_proses`),
  KEY `TANGGAL` (`tanggal`),
  KEY `TANGGAL_STATPROC` (`tanggal`,`status_proses`),
  KEY `TANGGAL_KODECAB` (`tanggal`,`kode_cabang`),
  KEY `TGL_KODE_FINGER` (`tanggal`,`kode_cabang`,`finger_print`),
  KEY `TGL_KODE_FING_STAT` (`tanggal`,`kode_cabang`,`finger_print`,`status_proses`),
  KEY `KODE_CABANG` (`kode_cabang`),
  KEY `CABANG_STATUS` (`kode_cabang`,`status_proses`),
  KEY `FINGER_KODE_STAT_LOCK` (`finger_print`,`kode_cabang`,`status_proses`,`finger_eod_lock`),
  KEY `LOCK` (`finger_eod_lock`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_upload_absent_anomali`
--

DROP TABLE IF EXISTS `t_upload_absent_anomali`;
CREATE TABLE IF NOT EXISTS `t_upload_absent_anomali` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode_cabang` varchar(10) NOT NULL,
  `tanggal` date DEFAULT NULL,
  `finger_print` int(5) DEFAULT NULL,
  `waktu` time DEFAULT NULL,
  `status_absen` tinyint(4) DEFAULT NULL,
  `status_proses` tinyint(1) NOT NULL DEFAULT '0',
  `anomali_type` tinyint(3) DEFAULT '0',
  `lastmodified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `finger_eod_lock` tinyint(1) DEFAULT '0',
  `waktu_seharusnya` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `UPLOAD_ABSEN` (`finger_print`,`tanggal`,`waktu`,`kode_cabang`),
  KEY `status_proses` (`status_proses`),
  KEY `TANGGAL` (`tanggal`),
  KEY `TANGGAL_STATPROC` (`tanggal`,`status_proses`),
  KEY `TANGGAL_KODECAB` (`tanggal`,`kode_cabang`),
  KEY `TGL_KODE_FINGER` (`tanggal`,`kode_cabang`,`finger_print`),
  KEY `TGL_KODE_FING_STAT` (`tanggal`,`kode_cabang`,`finger_print`,`status_proses`),
  KEY `KODE_CABANG` (`kode_cabang`),
  KEY `CABANG_STATUS` (`kode_cabang`,`status_proses`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_waste_detail`
--

DROP TABLE IF EXISTS `t_waste_detail`;
CREATE TABLE IF NOT EXISTS `t_waste_detail` (
  `id_waste_detail` bigint(19) NOT NULL AUTO_INCREMENT,
  `id_waste_header` bigint(19) DEFAULT '0',
  `id_waste_h_detail` int(11) DEFAULT NULL,
  `material_no` varchar(20) DEFAULT NULL,
  `material_desc` varchar(50) DEFAULT NULL,
  `quantity` decimal(17,4) DEFAULT '0.0000',
  `uom` varchar(5) DEFAULT NULL,
  `reason_name` varchar(50) DEFAULT NULL,
  `other_reason` varchar(50) DEFAULT NULL,
  `ok` tinyint(3) DEFAULT NULL,
  PRIMARY KEY (`id_waste_detail`),
  KEY `id_waste_header` (`id_waste_header`),
  KEY `material_no` (`material_no`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_waste_detail_arch`
--

DROP TABLE IF EXISTS `t_waste_detail_arch`;
CREATE TABLE IF NOT EXISTS `t_waste_detail_arch` (
  `id_waste_detail` bigint(19) NOT NULL AUTO_INCREMENT,
  `id_waste_header` bigint(19) DEFAULT '0',
  `id_waste_h_detail` int(11) DEFAULT NULL,
  `material_no` varchar(20) DEFAULT '',
  `material_desc` varchar(50) DEFAULT '',
  `quantity` decimal(17,4) DEFAULT '0.0000',
  `uom` varchar(5) DEFAULT '',
  `reason_name` varchar(50) DEFAULT NULL,
  `other_reason` varchar(50) DEFAULT NULL,
  `ok` tinyint(3) DEFAULT NULL,
  PRIMARY KEY (`id_waste_detail`),
  KEY `id_waste_header` (`id_waste_header`),
  KEY `material_no` (`material_no`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_waste_detail_bom`
--

DROP TABLE IF EXISTS `t_waste_detail_bom`;
CREATE TABLE IF NOT EXISTS `t_waste_detail_bom` (
  `id_waste_bom_detail` bigint(19) NOT NULL AUTO_INCREMENT,
  `id_waste_detail` bigint(19) DEFAULT '0',
  `id_waste_header` bigint(19) DEFAULT '0',
  `id_waste_h_detail_bom` int(11) DEFAULT NULL,
  `material_no_sfg` varchar(20) DEFAULT NULL,
  `material_no` varchar(20) DEFAULT NULL,
  `material_desc` varchar(50) DEFAULT NULL,
  `quantity` decimal(17,4) DEFAULT '0.0000',
  `uom` varchar(5) DEFAULT NULL,
  PRIMARY KEY (`id_waste_bom_detail`),
  KEY `material_no_sfg` (`material_no_sfg`),
  KEY `material_no` (`material_no`),
  KEY `id_waste_header` (`id_waste_header`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_waste_header`
--

DROP TABLE IF EXISTS `t_waste_header`;
CREATE TABLE IF NOT EXISTS `t_waste_header` (
  `id_waste_header` bigint(19) NOT NULL AUTO_INCREMENT,
  `posting_date` date DEFAULT '0000-00-00',
  `material_doc_no` varchar(20) DEFAULT NULL,
  `plant` varchar(20) DEFAULT NULL,
  `plant_name` varchar(50) DEFAULT NULL,
  `id_waste_plant` int(11) DEFAULT NULL,
  `storage_location` varchar(20) DEFAULT NULL,
  `storage_location_name` varchar(50) DEFAULT NULL,
  `cost_center` varchar(20) DEFAULT NULL,
  `cost_center_name` varchar(50) DEFAULT NULL,
  `status` tinyint(3) DEFAULT NULL,
  `item_group_code` varchar(50) DEFAULT NULL,
  `id_user_input` int(5) DEFAULT '0',
  `id_user_approved` int(5) DEFAULT '0',
  `filename` varchar(50) DEFAULT NULL,
  `lastmodified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_waste_header`),
  KEY `posting_date` (`posting_date`),
  KEY `plant` (`plant`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_employee_absent`
--
DROP VIEW IF EXISTS `v_employee_absent`;
CREATE TABLE IF NOT EXISTS `v_employee_absent` (
`cabang` varchar(50)
,`tanggal` date
,`nik` varchar(50)
,`shift` varchar(10)
,`kd_shift` varchar(10)
,`shift_in` varchar(8)
,`shift_break_out` varchar(8)
,`shift_break_in` varchar(8)
,`shift_out` varchar(8)
,`kd_cuti` varchar(10)
,`kd_aktual` varchar(10)
,`kd_aktual_temp` varchar(10)
,`in` time
,`break_out` time
,`break_in` time
,`out` time
,`terlambat` varchar(8)
,`pulang_cepat` varchar(8)
,`jam_kerja` varchar(8)
,`data_type` bigint(20)
,`on_process` bigint(20)
,`eod_lock` bigint(20)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `v_grpodlv_export`
--
DROP VIEW IF EXISTS `v_grpodlv_export`;
CREATE TABLE IF NOT EXISTS `v_grpodlv_export` (
`id_grpodlv_header` bigint(19)
,`posting_date` datetime
,`do_no` varchar(20)
,`gr_no` varchar(20)
,`delivery_date` date
,`plant` varchar(20)
,`storage_location` varchar(20)
,`item_group_code` varchar(50)
,`status` tinyint(3)
,`id_grpodlv_h_detail` int(11)
,`material_no` varchar(20)
,`material_desc` varchar(50)
,`outstanding_qty` decimal(17,4)
,`gr_quantity` decimal(17,4)
,`uom` varchar(5)
,`item_storage_location` varchar(10)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `v_grpofg_export`
--
DROP VIEW IF EXISTS `v_grpofg_export`;
CREATE TABLE IF NOT EXISTS `v_grpofg_export` (
`id_grpofg_header` bigint(19)
,`posting_date` datetime
,`do_no` varchar(20)
,`grpo_no` varchar(20)
,`grfg_no` varchar(20)
,`delivery_date` date
,`plant` varchar(20)
,`storage_location` varchar(20)
,`item_group_code` varchar(50)
,`status` tinyint(3)
,`id_grpofg_h_detail` int(11)
,`material_no` varchar(20)
,`material_no_pos` varchar(20)
,`material_desc` varchar(50)
,`outstanding_qty` decimal(17,4)
,`grpo_quantity` decimal(17,4)
,`grfg_quantity` decimal(17,4)
,`uom` varchar(5)
,`item_storage_location` varchar(10)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `v_m_outlet_sewa`
--
DROP VIEW IF EXISTS `v_m_outlet_sewa`;
CREATE TABLE IF NOT EXISTS `v_m_outlet_sewa` (
`COMP_CODE` varchar(10)
,`OUTLET` varchar(10)
,`OUTLET_NAME1` varchar(100)
,`CITY` varchar(50)
,`OPENING_DATE` date
,`SEWA_AWAL` varchar(10)
,`SEWA_AKHIR` varchar(10)
,`OUTLET_NAME2` varchar(100)
,`STOR_LOC_NAME` varchar(20)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `v_nonstdstock_export`
--
DROP VIEW IF EXISTS `v_nonstdstock_export`;
CREATE TABLE IF NOT EXISTS `v_nonstdstock_export` (
`id_nonstdstock_header` bigint(19)
,`pr_no` varchar(20)
,`plant` varchar(20)
,`storage_location` varchar(20)
,`request_reason` varchar(10)
,`item_group_code` varchar(50)
,`created_date` datetime
,`status` tinyint(3)
,`id_nonstdstock_h_detail` int(11)
,`material_no` varchar(20)
,`material_desc` varchar(50)
,`delivery_date` datetime
,`lead_time` tinyint(2)
,`requirement_qty` decimal(17,4)
,`uom` varchar(5)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `v_opnd`
--
DROP VIEW IF EXISTS `v_opnd`;
CREATE TABLE IF NOT EXISTS `v_opnd` (
`plant` varchar(4)
,`periode` varchar(20)
,`material_no` varchar(20)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `v_rpt_attn_dtl`
--
DROP VIEW IF EXISTS `v_rpt_attn_dtl`;
CREATE TABLE IF NOT EXISTS `v_rpt_attn_dtl` (
`employee_id` int(11)
,`cabang` varchar(10)
,`nik` varchar(50)
,`nama` varchar(50)
,`tanggal` date
,`shift` varchar(10)
,`kd_shift` varchar(10)
,`shift_in` time
,`shift_out` time
,`shift_break_in` time
,`shift_break_out` time
,`kd_aktual` varchar(10)
,`in` time
,`out` time
,`break_in` time
,`break_out` time
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `v_statuseod`
--
DROP VIEW IF EXISTS `v_statuseod`;
CREATE TABLE IF NOT EXISTS `v_statuseod` (
`posting_date` date
,`plant` varchar(10)
,`status_eod_transight` tinyint(3)
,`status_eod_transight_errcode` int(11)
,`status_eod_transight_errdesc` varchar(255)
,`status_eod_transight_time` datetime
,`status_eod_pos` tinyint(3)
,`status_eod_opname` tinyint(3)
,`status_eod_waste` tinyint(3)
,`status_eod_sap` tinyint(3)
,`status_hr` tinyint(3)
,`remarkflag` tinyint(3)
,`plant_name` varchar(100)
,`comp_code` varchar(10)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `v_statusvoid`
--
DROP VIEW IF EXISTS `v_statusvoid`;
CREATE TABLE IF NOT EXISTS `v_statusvoid` (
`posting_date` date
,`plant` varchar(10)
,`plant_name` varchar(100)
,`emplname` varchar(25)
,`totalvoid` decimal(15,4)
,`numbervoid` smallint(5) unsigned
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `v_stdstock_export`
--
DROP VIEW IF EXISTS `v_stdstock_export`;
CREATE TABLE IF NOT EXISTS `v_stdstock_export` (
`id_stdstock_header` bigint(19)
,`pr_no` varchar(20)
,`plant` varchar(20)
,`storage_location` varchar(20)
,`request_reason` varchar(20)
,`item_group_code` varchar(50)
,`created_date` datetime
,`status` tinyint(3)
,`id_stdstock_h_detail` int(11)
,`material_no` varchar(20)
,`material_desc` varchar(50)
,`delivery_date` datetime
,`requirement_qty` decimal(17,4)
,`uom` varchar(5)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `v_stockoutlet_bom`
--
DROP VIEW IF EXISTS `v_stockoutlet_bom`;
CREATE TABLE IF NOT EXISTS `v_stockoutlet_bom` (
`id_stockoutlet_header` bigint(20)
,`material_no` varchar(20)
,`uom` varchar(5)
,`quantity` decimal(39,4)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `v_stockoutlet_export`
--
DROP VIEW IF EXISTS `v_stockoutlet_export`;
CREATE TABLE IF NOT EXISTS `v_stockoutlet_export` (
`id_stockoutlet_header` bigint(19)
,`posting_date` datetime
,`material_doc_no` varchar(20)
,`plant` varchar(20)
,`storage_location` varchar(20)
,`item_group_code` varchar(50)
,`status` tinyint(3)
,`id_stockoutlet_h_detail` int(11)
,`material_no` varchar(20)
,`material_desc` varchar(50)
,`qty_gso` decimal(17,4)
,`qty_gss` decimal(17,4)
,`quantity` decimal(17,4)
,`uom` varchar(5)
,`material_no_bom` varchar(20)
,`material_desc_bom` varchar(50)
,`qty_bom` decimal(17,4)
,`uom_bom` varchar(5)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `v_tssck_do`
--
DROP VIEW IF EXISTS `v_tssck_do`;
CREATE TABLE IF NOT EXISTS `v_tssck_do` (
`id_do_trans` bigint(19)
,`posting_date` datetime
,`do_no` varchar(20)
,`plant` varchar(20)
,`material_no` varchar(20)
,`material_desc` varchar(50)
,`uom` varchar(5)
,`quantity` decimal(40,4)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `v_waste_bom`
--
DROP VIEW IF EXISTS `v_waste_bom`;
CREATE TABLE IF NOT EXISTS `v_waste_bom` (
`id_waste_header` bigint(20)
,`material_no` varchar(20)
,`uom` varchar(5)
,`quantity` decimal(39,4)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `v_waste_export`
--
DROP VIEW IF EXISTS `v_waste_export`;
CREATE TABLE IF NOT EXISTS `v_waste_export` (
`id_waste_header` bigint(19)
,`posting_date` date
,`material_doc_no` varchar(20)
,`plant` varchar(20)
,`storage_location` varchar(20)
,`item_group_code` varchar(50)
,`status` tinyint(3)
,`id_waste_h_detail` int(11)
,`material_no` varchar(20)
,`material_desc` varchar(50)
,`quantity` decimal(17,4)
,`uom` varchar(5)
,`reason_name` varchar(50)
,`other_reason` varchar(50)
,`material_no_bom` varchar(20)
,`material_desc_bom` varchar(50)
,`qty_bom` decimal(17,4)
,`uom_bom` varchar(5)
);
-- --------------------------------------------------------

--
-- Table structure for table `zmm_bapi_disp_delv_outs`
--

DROP TABLE IF EXISTS `zmm_bapi_disp_delv_outs`;
CREATE TABLE IF NOT EXISTS `zmm_bapi_disp_delv_outs` (
  `PLANT` varchar(10) NOT NULL DEFAULT '',
  `VBELN` varchar(10) NOT NULL DEFAULT '',
  `POSNR` int(10) unsigned NOT NULL DEFAULT '0',
  `MATNR` varchar(18) NOT NULL DEFAULT '',
  `MAKTX` varchar(40) DEFAULT NULL,
  `LFIMG` decimal(17,4) DEFAULT NULL,
  `LFIMG_APRVD` decimal(17,4) DEFAULT '0.0000',
  `VRKME` varchar(3) DEFAULT NULL,
  `MATKL` varchar(9) DEFAULT NULL,
  `DISPO` varchar(3) DEFAULT NULL,
  `LGORT` varchar(4) DEFAULT NULL,
  `MBLNR` varchar(10) DEFAULT NULL,
  `UNIT` varchar(5) DEFAULT NULL,
  `UNIT_STEXT` varchar(15) DEFAULT NULL,
  `DELIV_DATE` varchar(8) DEFAULT NULL,
  `OUT_STATUS` tinyint(3) unsigned DEFAULT '0',
  `LASTUPDATE` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`PLANT`,`VBELN`,`MATNR`,`POSNR`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `zmm_bapi_disp_po_outstanding`
--

DROP TABLE IF EXISTS `zmm_bapi_disp_po_outstanding`;
CREATE TABLE IF NOT EXISTS `zmm_bapi_disp_po_outstanding` (
  `PLANT` varchar(10) NOT NULL DEFAULT '',
  `EBELN` varchar(10) NOT NULL DEFAULT '',
  `EBELP` smallint(6) NOT NULL DEFAULT '0',
  `VENDOR` varchar(10) DEFAULT NULL,
  `VENDOR_NAME` varchar(35) DEFAULT NULL,
  `SUPPL_PLANT` varchar(4) DEFAULT NULL,
  `SPLANT_NAME` varchar(30) DEFAULT NULL,
  `MATNR` varchar(18) DEFAULT NULL,
  `MAKTX` varchar(40) DEFAULT NULL,
  `BSTMG` decimal(17,4) DEFAULT NULL,
  `BSTMG_APRVD` decimal(17,4) DEFAULT '0.0000',
  `BSTME` varchar(3) DEFAULT NULL,
  `MATKL` varchar(9) DEFAULT NULL,
  `DISPO` varchar(3) DEFAULT NULL,
  `MBLNR` varchar(10) DEFAULT NULL,
  `UNIT` varchar(5) DEFAULT NULL,
  `UNIT_STEXT` varchar(15) DEFAULT NULL,
  `DELIV_DATE` varchar(8) DEFAULT NULL,
  `OUT_STATUS` tinyint(3) unsigned DEFAULT '0',
  `LASTUPDATE` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`PLANT`,`EBELN`,`EBELP`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `zmm_bapi_disp_vendor_dtl`
--

DROP TABLE IF EXISTS `zmm_bapi_disp_vendor_dtl`;
CREATE TABLE IF NOT EXISTS `zmm_bapi_disp_vendor_dtl` (
  `LIFNR` int(11) NOT NULL AUTO_INCREMENT,
  `NAME1` varchar(35) DEFAULT NULL,
  `KTOKK` varchar(4) DEFAULT NULL,
  `STRAS` varchar(35) DEFAULT NULL,
  `PSTLZ` varchar(10) DEFAULT NULL,
  `TELF1` varchar(16) DEFAULT NULL,
  `TELFX` varchar(31) DEFAULT NULL,
  `ADRNR` varchar(10) DEFAULT NULL,
  `SMTP_ADDR` varchar(241) DEFAULT NULL,
  `J_1KFTBUS` varchar(30) DEFAULT NULL,
  `SORTL` varchar(10) DEFAULT NULL,
  `S_NAMEV` varchar(35) DEFAULT NULL,
  `S_NAME1` varchar(35) DEFAULT NULL,
  `S_PARAU` varchar(40) DEFAULT NULL,
  `S_STREET` varchar(60) DEFAULT NULL,
  `S_POST_CODE1` varchar(10) DEFAULT NULL,
  `S_TEL_NUMBER` varchar(30) DEFAULT NULL,
  `S_SMTP_ADDR` varchar(241) DEFAULT NULL,
  `D_NAMEV` varchar(35) DEFAULT NULL,
  `D_NAME1` varchar(35) DEFAULT NULL,
  `D_PARAU` varchar(40) DEFAULT NULL,
  `D_STREET` varchar(60) DEFAULT NULL,
  `CP_NAMEV` varchar(35) DEFAULT NULL,
  `CP_NAME1` varchar(35) DEFAULT NULL,
  `CP_TEL_NUMBER` varchar(30) DEFAULT NULL,
  `CP_TELF1` varchar(16) DEFAULT NULL,
  `CP_SMTP_ADDR` varchar(241) DEFAULT NULL,
  `BANKN1` varchar(18) DEFAULT NULL,
  `KOINH1` varchar(60) DEFAULT NULL,
  `BANKL1` varchar(15) DEFAULT NULL,
  `BANKA1` varchar(60) DEFAULT NULL,
  `STRAS1` varchar(35) DEFAULT NULL,
  `SWIFT1` varchar(11) DEFAULT NULL,
  `BANKN2` varchar(18) DEFAULT NULL,
  `KOINH2` varchar(60) DEFAULT NULL,
  `BANKL2` varchar(15) DEFAULT NULL,
  `BANKA2` varchar(60) DEFAULT NULL,
  `STRAS2` varchar(35) DEFAULT NULL,
  `SWIFT2` varchar(11) DEFAULT NULL,
  `NAME2` varchar(35) DEFAULT NULL,
  `NAME3` varchar(35) DEFAULT NULL,
  `STCEG` varchar(20) DEFAULT NULL,
  `NAME4` varchar(35) DEFAULT NULL,
  `REMARK` varchar(50) DEFAULT NULL,
  `EXTENSION1` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`LIFNR`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `zmm_bapi_list_lead_time_a`
--

DROP TABLE IF EXISTS `zmm_bapi_list_lead_time_a`;
CREATE TABLE IF NOT EXISTS `zmm_bapi_list_lead_time_a` (
  `OUTLET` varchar(4) NOT NULL,
  `MATNR` varchar(18) NOT NULL,
  `LEAD_TIME` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`OUTLET`,`MATNR`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `zmm_bapi_list_material_all`
--

DROP TABLE IF EXISTS `zmm_bapi_list_material_all`;
CREATE TABLE IF NOT EXISTS `zmm_bapi_list_material_all` (
  `MATNR` varchar(18) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `MTART` varchar(4) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `BISMT` varchar(18) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `MEINS` varchar(3) CHARACTER SET latin1 DEFAULT NULL,
  `MAKTX` varchar(40) CHARACTER SET latin1 DEFAULT NULL,
  `MAKTG` varchar(40) CHARACTER SET latin1 DEFAULT NULL,
  `MATKL` varchar(9) CHARACTER SET latin1 DEFAULT NULL,
  `DISPO` varchar(3) CHARACTER SET latin1 DEFAULT NULL,
  `WERKS` varchar(4) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `SOBSL` varchar(2) CHARACTER SET latin1 DEFAULT NULL,
  `WGBEZ` varchar(20) CHARACTER SET latin1 DEFAULT NULL,
  `DSNAM` varchar(18) CHARACTER SET latin1 DEFAULT NULL,
  `UNIT` varchar(5) CHARACTER SET latin1 DEFAULT NULL,
  `UNIT_STEXT` varchar(15) CHARACTER SET latin1 DEFAULT NULL,
  PRIMARY KEY (`MATNR`,`MTART`,`BISMT`,`WERKS`) USING BTREE,
  KEY `MAT_PLANT` (`WERKS`),
  KEY `MAT_PLANT_M1` (`WERKS`,`MTART`),
  KEY `MAT_PLANT_M2` (`WERKS`,`MTART`,`SOBSL`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `zmm_bapi_list_outlet_gen`
--

DROP TABLE IF EXISTS `zmm_bapi_list_outlet_gen`;
CREATE TABLE IF NOT EXISTS `zmm_bapi_list_outlet_gen` (
  `OUTLET` varchar(10) NOT NULL DEFAULT '',
  `OUTLET_NAME1` varchar(100) DEFAULT NULL,
  `COMP_CODE` varchar(10) DEFAULT NULL,
  `COMP_CODE_NAME` varchar(50) DEFAULT NULL,
  `STOR_LOC` varchar(10) DEFAULT NULL,
  `STOR_LOC_NAME` varchar(20) DEFAULT NULL,
  `COST_CENTER` varchar(50) DEFAULT NULL,
  `COST_CENTER_TXT` varchar(50) DEFAULT NULL,
  `PURCH_ORG` varchar(10) DEFAULT NULL,
  `OUTLET_NAME2` varchar(100) DEFAULT NULL,
  `ADDRESS` varchar(35) DEFAULT NULL,
  `POST_CODE` varchar(10) DEFAULT NULL,
  `CITY` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`OUTLET`),
  KEY `COMP_CODE` (`COMP_CODE`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `z_mm_bapi_prvsdovsgr`
--

DROP TABLE IF EXISTS `z_mm_bapi_prvsdovsgr`;
CREATE TABLE IF NOT EXISTS `z_mm_bapi_prvsdovsgr` (
  `OUTLET` varchar(10) NOT NULL,
  `PERIODE` int(11) NOT NULL DEFAULT '0',
  `MATERIAL` varchar(18) NOT NULL,
  `UOM` varchar(10) NOT NULL,
  `PR_QTY` decimal(17,4) DEFAULT NULL,
  `PO_QTY` decimal(17,4) DEFAULT NULL,
  `DLV_QTY` decimal(17,4) DEFAULT NULL,
  `DOVSGR` decimal(17,4) DEFAULT NULL,
  `LASTUPDATE` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`OUTLET`,`PERIODE`,`MATERIAL`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure for view `v_employee_absent`
--
DROP TABLE IF EXISTS `v_employee_absent`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_employee_absent` AS select `t_employee_absent`.`cabang` AS `cabang`,`t_employee_absent`.`tanggal` AS `tanggal`,`t_employee_absent`.`nik` AS `nik`,`t_employee_absent`.`shift` AS `shift`,`t_employee_absent`.`kd_shift` AS `kd_shift`,`t_employee_absent`.`shift_in` AS `shift_in`,`t_employee_absent`.`shift_break_out` AS `shift_break_out`,`t_employee_absent`.`shift_break_in` AS `shift_break_in`,`t_employee_absent`.`shift_out` AS `shift_out`,`t_employee_absent`.`kd_cuti` AS `kd_cuti`,`t_employee_absent`.`kd_aktual` AS `kd_aktual`,`t_employee_absent`.`kd_aktual_temp` AS `kd_aktual_temp`,`t_employee_absent`.`in` AS `in`,`t_employee_absent`.`break_out` AS `break_out`,`t_employee_absent`.`break_in` AS `break_in`,`t_employee_absent`.`out` AS `out`,`t_employee_absent`.`terlambat` AS `terlambat`,`t_employee_absent`.`pulang_cepat` AS `pulang_cepat`,`t_employee_absent`.`jam_kerja` AS `jam_kerja`,`t_employee_absent`.`data_type` AS `data_type`,`t_employee_absent`.`on_process` AS `on_process`,`t_employee_absent`.`eod_lock` AS `eod_lock` from `t_employee_absent` union select `t_employee_absent_noshift`.`cabang` AS `cabang`,`t_employee_absent_noshift`.`tanggal` AS `tanggal`,`t_employee_absent_noshift`.`nik` AS `nik`,_utf8'NONE' AS `shift`,_utf8'NONE' AS `kd_shift`,_utf8'?' AS `shift_in`,_utf8'?' AS `shift_break_out`,_utf8'?' AS `shift_break_in`,_utf8'?' AS `shift_out`,_utf8'?' AS `kd_cuti`,_utf8'?' AS `kd_aktual`,_utf8'?' AS `kd_aktual_temp`,`t_employee_absent_noshift`.`in` AS `in`,`t_employee_absent_noshift`.`break_out` AS `break_out`,`t_employee_absent_noshift`.`break_in` AS `break_in`,`t_employee_absent_noshift`.`out` AS `out`,_utf8'' AS `terlambat`,_utf8'' AS `pulang_cepat`,_utf8'' AS `jam_kerja`,3 AS `data_type`,0 AS `on_process`,0 AS `eod_lock` from `t_employee_absent_noshift`;

-- --------------------------------------------------------

--
-- Structure for view `v_grpodlv_export`
--
DROP TABLE IF EXISTS `v_grpodlv_export`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_grpodlv_export` AS select `t_grpodlv_header`.`id_grpodlv_header` AS `id_grpodlv_header`,`t_grpodlv_header`.`posting_date` AS `posting_date`,`t_grpodlv_header`.`do_no` AS `do_no`,`t_grpodlv_header`.`grpodlv_no` AS `gr_no`,`t_grpodlv_header`.`delivery_date` AS `delivery_date`,`t_grpodlv_header`.`plant` AS `plant`,`t_grpodlv_header`.`storage_location` AS `storage_location`,`t_grpodlv_header`.`item_group_code` AS `item_group_code`,`t_grpodlv_header`.`status` AS `status`,`t_grpodlv_detail`.`id_grpodlv_h_detail` AS `id_grpodlv_h_detail`,`t_grpodlv_detail`.`material_no` AS `material_no`,`t_grpodlv_detail`.`material_desc` AS `material_desc`,`t_grpodlv_detail`.`outstanding_qty` AS `outstanding_qty`,`t_grpodlv_detail`.`gr_quantity` AS `gr_quantity`,`t_grpodlv_detail`.`uom` AS `uom`,`t_grpodlv_detail`.`item_storage_location` AS `item_storage_location` from (`t_grpodlv_header` join `t_grpodlv_detail` on((`t_grpodlv_header`.`id_grpodlv_header` = `t_grpodlv_detail`.`id_grpodlv_header`)));

-- --------------------------------------------------------

--
-- Structure for view `v_grpofg_export`
--
DROP TABLE IF EXISTS `v_grpofg_export`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_grpofg_export` AS select `t_grpofg_header`.`id_grpofg_header` AS `id_grpofg_header`,`t_grpofg_header`.`posting_date` AS `posting_date`,`t_grpofg_header`.`do_no` AS `do_no`,`t_grpofg_header`.`grpo_no` AS `grpo_no`,`t_grpofg_header`.`grfg_no` AS `grfg_no`,`t_grpofg_header`.`delivery_date` AS `delivery_date`,`t_grpofg_header`.`plant` AS `plant`,`t_grpofg_header`.`storage_location` AS `storage_location`,`t_grpofg_header`.`item_group_code` AS `item_group_code`,`t_grpofg_header`.`status` AS `status`,`t_grpofg_detail`.`id_grpofg_h_detail` AS `id_grpofg_h_detail`,`t_grpofg_detail`.`material_no` AS `material_no`,`t_grpofg_detail`.`material_no_pos` AS `material_no_pos`,`t_grpofg_detail`.`material_desc` AS `material_desc`,`t_grpofg_detail`.`outstanding_qty` AS `outstanding_qty`,`t_grpofg_detail`.`gr_quantity` AS `grpo_quantity`,`t_grpofg_detail`.`grfg_quantity` AS `grfg_quantity`,`t_grpofg_detail`.`uom` AS `uom`,`t_grpofg_detail`.`item_storage_location` AS `item_storage_location` from (`t_grpofg_header` join `t_grpofg_detail` on((`t_grpofg_header`.`id_grpofg_header` = `t_grpofg_detail`.`id_grpofg_header`)));

-- --------------------------------------------------------

--
-- Structure for view `v_m_outlet_sewa`
--
DROP TABLE IF EXISTS `v_m_outlet_sewa`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`172.71.77.88` SQL SECURITY DEFINER VIEW `v_m_outlet_sewa` AS select `m_outlet`.`COMP_CODE` AS `COMP_CODE`,`m_outlet`.`OUTLET` AS `OUTLET`,`m_outlet`.`OUTLET_NAME1` AS `OUTLET_NAME1`,`m_outlet`.`CITY` AS `CITY`,`m_outlet`.`OPENING_DATE` AS `OPENING_DATE`,_utf8'0000-00-00' AS `SEWA_AWAL`,_utf8'0000-00-00' AS `SEWA_AKHIR`,`m_outlet`.`OUTLET_NAME2` AS `OUTLET_NAME2`,`m_outlet`.`STOR_LOC_NAME` AS `STOR_LOC_NAME` from `m_outlet`;

-- --------------------------------------------------------

--
-- Structure for view `v_nonstdstock_export`
--
DROP TABLE IF EXISTS `v_nonstdstock_export`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_nonstdstock_export` AS select `t_nonstdstock_header`.`id_nonstdstock_header` AS `id_nonstdstock_header`,`t_nonstdstock_header`.`pr_no` AS `pr_no`,`t_nonstdstock_header`.`plant` AS `plant`,`t_nonstdstock_header`.`storage_location` AS `storage_location`,`t_nonstdstock_header`.`request_reason` AS `request_reason`,`t_nonstdstock_header`.`item_group_code` AS `item_group_code`,`t_nonstdstock_header`.`created_date` AS `created_date`,`t_nonstdstock_header`.`status` AS `status`,`t_nonstdstock_detail`.`id_nonstdstock_h_detail` AS `id_nonstdstock_h_detail`,`t_nonstdstock_detail`.`material_no` AS `material_no`,`t_nonstdstock_detail`.`material_desc` AS `material_desc`,`t_nonstdstock_detail`.`delivery_date` AS `delivery_date`,`t_nonstdstock_detail`.`lead_time` AS `lead_time`,`t_nonstdstock_detail`.`requirement_qty` AS `requirement_qty`,`t_nonstdstock_detail`.`uom` AS `uom` from (`t_nonstdstock_header` join `t_nonstdstock_detail` on((`t_nonstdstock_header`.`id_nonstdstock_header` = `t_nonstdstock_detail`.`id_nonstdstock_header`)));

-- --------------------------------------------------------

--
-- Structure for view `v_opnd`
--
DROP TABLE IF EXISTS `v_opnd`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_opnd` AS select `a`.`plant` AS `plant`,`a`.`periode` AS `periode`,`b`.`material_no` AS `material_no` from (`m_opnd_header` `a` join `m_opnd_detail` `b`) where (`a`.`id_opnd_header` = `b`.`id_opnd_header`);

-- --------------------------------------------------------

--
-- Structure for view `v_rpt_attn_dtl`
--
DROP TABLE IF EXISTS `v_rpt_attn_dtl`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_rpt_attn_dtl` AS select `b`.`employee_id` AS `employee_id`,`b`.`kode_cabang` AS `cabang`,`a`.`nik` AS `nik`,`b`.`nama` AS `nama`,`a`.`tanggal` AS `tanggal`,max(`a`.`shift`) AS `shift`,max(`a`.`kd_shift`) AS `kd_shift`,max(`a`.`shift_in`) AS `shift_in`,max(`a`.`shift_out`) AS `shift_out`,max(`a`.`shift_break_in`) AS `shift_break_in`,max(`a`.`shift_break_out`) AS `shift_break_out`,max(`a`.`kd_aktual`) AS `kd_aktual`,max(`a`.`in`) AS `in`,max(`a`.`out`) AS `out`,max(`a`.`break_in`) AS `break_in`,max(`a`.`break_out`) AS `break_out` from (`t_employee_absent` `a` join `m_employee` `b` on((`a`.`nik` = `b`.`nik`))) group by `b`.`employee_id`,`b`.`kode_cabang`,`a`.`nik`,`b`.`nama`,`a`.`tanggal`;

-- --------------------------------------------------------

--
-- Structure for view `v_statuseod`
--
DROP TABLE IF EXISTS `v_statuseod`;

CREATE ALGORITHM=TEMPTABLE DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_statuseod` AS select `a`.`posting_date` AS `posting_date`,`a`.`plant` AS `plant`,`a`.`status_eod_transight` AS `status_eod_transight`,`a`.`status_eod_transight_errcode` AS `status_eod_transight_errcode`,`a`.`status_eod_transight_errdesc` AS `status_eod_transight_errdesc`,`a`.`status_eod_transight_time` AS `status_eod_transight_time`,`a`.`status_eod_pos` AS `status_eod_pos`,`a`.`status_eod_opname` AS `status_eod_opname`,`a`.`status_eod_waste` AS `status_eod_waste`,`a`.`status_eod_sap` AS `status_eod_sap`,`a`.`status_hr` AS `status_hr`,`a`.`remarkflag` AS `remarkflag`,`b`.`OUTLET_NAME2` AS `plant_name`,`b`.`COMP_CODE` AS `comp_code` from (`t_statuseod` `a` join `m_outlet` `b`) where ((`a`.`plant` = `b`.`OUTLET`) and (`b`.`OUTLET_STATUS` = 1));

-- --------------------------------------------------------

--
-- Structure for view `v_statusvoid`
--
DROP TABLE IF EXISTS `v_statusvoid`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`192.168.143.77` SQL SECURITY DEFINER VIEW `v_statusvoid` AS select `a`.`posting_date` AS `posting_date`,`a`.`plant` AS `plant`,`b`.`OUTLET_NAME2` AS `plant_name`,`a`.`emplname` AS `emplname`,`a`.`totalvoid` AS `totalvoid`,`a`.`numbervoid` AS `numbervoid` from (`t_statusvoid` `a` join `m_outlet` `b`) where (`a`.`plant` = `b`.`OUTLET`);

-- --------------------------------------------------------

--
-- Structure for view `v_stdstock_export`
--
DROP TABLE IF EXISTS `v_stdstock_export`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_stdstock_export` AS select `t_stdstock_header`.`id_stdstock_header` AS `id_stdstock_header`,`t_stdstock_header`.`pr_no` AS `pr_no`,`t_stdstock_header`.`plant` AS `plant`,`t_stdstock_header`.`storage_location` AS `storage_location`,`t_stdstock_header`.`request_reason` AS `request_reason`,`t_stdstock_header`.`item_group_code` AS `item_group_code`,`t_stdstock_header`.`created_date` AS `created_date`,`t_stdstock_header`.`status` AS `status`,`t_stdstock_detail`.`id_stdstock_h_detail` AS `id_stdstock_h_detail`,`t_stdstock_detail`.`material_no` AS `material_no`,`t_stdstock_detail`.`material_desc` AS `material_desc`,`t_stdstock_header`.`delivery_date` AS `delivery_date`,`t_stdstock_detail`.`requirement_qty` AS `requirement_qty`,`t_stdstock_detail`.`uom` AS `uom` from (`t_stdstock_header` join `t_stdstock_detail` on((`t_stdstock_header`.`id_stdstock_header` = `t_stdstock_detail`.`id_stdstock_header`)));

-- --------------------------------------------------------

--
-- Structure for view `v_stockoutlet_bom`
--
DROP TABLE IF EXISTS `v_stockoutlet_bom`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`192.168.143.77` SQL SECURITY DEFINER VIEW `v_stockoutlet_bom` AS select `t_stockoutlet_detail`.`id_stockoutlet_header` AS `id_stockoutlet_header`,`t_stockoutlet_detail`.`material_no` AS `material_no`,`t_stockoutlet_detail`.`uom` AS `uom`,sum(`t_stockoutlet_detail`.`quantity`) AS `quantity` from `t_stockoutlet_detail` where (not(`t_stockoutlet_detail`.`id_stockoutlet_detail` in (select `t_stockoutlet_detail_bom`.`id_stockoutlet_detail` AS `id_stockoutlet_detail` from `t_stockoutlet_detail_bom` where ((`t_stockoutlet_detail_bom`.`id_stockoutlet_header` = `t_stockoutlet_detail`.`id_stockoutlet_header`) and (`t_stockoutlet_detail_bom`.`id_stockoutlet_detail` = `t_stockoutlet_detail`.`id_stockoutlet_detail`))))) group by `t_stockoutlet_detail`.`id_stockoutlet_header`,`t_stockoutlet_detail`.`material_no`,`t_stockoutlet_detail`.`uom` union select `t_stockoutlet_detail_bom`.`id_stockoutlet_header` AS `id_stockoutlet_header`,`t_stockoutlet_detail_bom`.`material_no` AS `material_no`,`t_stockoutlet_detail_bom`.`uom` AS `uom`,sum(`t_stockoutlet_detail_bom`.`quantity`) AS `quantity` from `t_stockoutlet_detail_bom` group by `t_stockoutlet_detail_bom`.`id_stockoutlet_header`,`t_stockoutlet_detail_bom`.`material_no`,`t_stockoutlet_detail_bom`.`uom`;

-- --------------------------------------------------------

--
-- Structure for view `v_stockoutlet_export`
--
DROP TABLE IF EXISTS `v_stockoutlet_export`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_stockoutlet_export` AS select `t_stockoutlet_header`.`id_stockoutlet_header` AS `id_stockoutlet_header`,`t_stockoutlet_header`.`posting_date` AS `posting_date`,`t_stockoutlet_header`.`material_doc_no` AS `material_doc_no`,`t_stockoutlet_header`.`plant` AS `plant`,`t_stockoutlet_header`.`storage_location` AS `storage_location`,`t_stockoutlet_header`.`item_group_code` AS `item_group_code`,`t_stockoutlet_header`.`status` AS `status`,`t_stockoutlet_detail`.`id_stockoutlet_h_detail` AS `id_stockoutlet_h_detail`,`t_stockoutlet_detail`.`material_no` AS `material_no`,`t_stockoutlet_detail`.`material_desc` AS `material_desc`,`t_stockoutlet_detail`.`qty_gso` AS `qty_gso`,`t_stockoutlet_detail`.`qty_gss` AS `qty_gss`,`t_stockoutlet_detail`.`quantity` AS `quantity`,`t_stockoutlet_detail`.`uom` AS `uom`,`t_stockoutlet_detail_bom`.`material_no` AS `material_no_bom`,`t_stockoutlet_detail_bom`.`material_desc` AS `material_desc_bom`,`t_stockoutlet_detail_bom`.`quantity` AS `qty_bom`,`t_stockoutlet_detail_bom`.`uom` AS `uom_bom` from ((`t_stockoutlet_header` join `t_stockoutlet_detail` on((`t_stockoutlet_header`.`id_stockoutlet_header` = `t_stockoutlet_detail`.`id_stockoutlet_header`))) left join `t_stockoutlet_detail_bom` on((`t_stockoutlet_detail_bom`.`id_stockoutlet_detail` = `t_stockoutlet_detail`.`id_stockoutlet_detail`)));

-- --------------------------------------------------------

--
-- Structure for view `v_tssck_do`
--
DROP TABLE IF EXISTS `v_tssck_do`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`192.168.143.77` SQL SECURITY DEFINER VIEW `v_tssck_do` AS select `t_grpodlv_header`.`id_grpodlv_header` AS `id_do_trans`,`t_grpodlv_header`.`posting_date` AS `posting_date`,`t_grpodlv_header`.`do_no` AS `do_no`,`t_grpodlv_header`.`plant` AS `plant`,`t_grpodlv_detail`.`material_no` AS `material_no`,`t_grpodlv_detail`.`material_desc` AS `material_desc`,`t_grpodlv_detail`.`uom` AS `uom`,sum((`t_grpodlv_detail`.`gr_quantity` - coalesce(`t_grpodlv_detail`.`tssck_qty`,0))) AS `quantity` from (`t_grpodlv_header` join `t_grpodlv_detail` on((`t_grpodlv_detail`.`id_grpodlv_header` = `t_grpodlv_header`.`id_grpodlv_header`))) where ((`t_grpodlv_header`.`status` = 2) and ((`t_grpodlv_detail`.`gr_quantity` - coalesce(`t_grpodlv_detail`.`tssck_qty`,0)) > 0)) group by `t_grpodlv_header`.`id_grpodlv_header`,`t_grpodlv_header`.`posting_date`,`t_grpodlv_header`.`do_no`,`t_grpodlv_header`.`plant`,`t_grpodlv_detail`.`material_no`,`t_grpodlv_detail`.`uom`,`t_grpodlv_detail`.`material_desc`;

-- --------------------------------------------------------

--
-- Structure for view `v_waste_bom`
--
DROP TABLE IF EXISTS `v_waste_bom`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_waste_bom` AS select `t_waste_detail`.`id_waste_header` AS `id_waste_header`,`t_waste_detail`.`material_no` AS `material_no`,`t_waste_detail`.`uom` AS `uom`,sum(`t_waste_detail`.`quantity`) AS `quantity` from `t_waste_detail` where (not(`t_waste_detail`.`id_waste_detail` in (select `t_waste_detail_bom`.`id_waste_detail` AS `id_waste_detail` from `t_waste_detail_bom` where ((`t_waste_detail_bom`.`material_no_sfg` = `t_waste_detail`.`material_no`) and (`t_waste_detail_bom`.`id_waste_header` = `t_waste_detail`.`id_waste_header`) and (`t_waste_detail_bom`.`id_waste_detail` = `t_waste_detail`.`id_waste_detail`))))) group by `t_waste_detail`.`id_waste_header`,`t_waste_detail`.`material_no`,`t_waste_detail`.`uom` union select `t_waste_detail_bom`.`id_waste_header` AS `id_waste_header`,`t_waste_detail_bom`.`material_no` AS `material_no`,`t_waste_detail_bom`.`uom` AS `uom`,sum(`t_waste_detail_bom`.`quantity`) AS `quantity` from `t_waste_detail_bom` group by `t_waste_detail_bom`.`id_waste_header`,`t_waste_detail_bom`.`material_no`,`t_waste_detail_bom`.`uom`;

-- --------------------------------------------------------

--
-- Structure for view `v_waste_export`
--
DROP TABLE IF EXISTS `v_waste_export`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_waste_export` AS select `t_waste_header`.`id_waste_header` AS `id_waste_header`,`t_waste_header`.`posting_date` AS `posting_date`,`t_waste_header`.`material_doc_no` AS `material_doc_no`,`t_waste_header`.`plant` AS `plant`,`t_waste_header`.`storage_location` AS `storage_location`,`t_waste_header`.`item_group_code` AS `item_group_code`,`t_waste_header`.`status` AS `status`,`t_waste_detail`.`id_waste_h_detail` AS `id_waste_h_detail`,`t_waste_detail`.`material_no` AS `material_no`,`t_waste_detail`.`material_desc` AS `material_desc`,`t_waste_detail`.`quantity` AS `quantity`,`t_waste_detail`.`uom` AS `uom`,`t_waste_detail`.`reason_name` AS `reason_name`,`t_waste_detail`.`other_reason` AS `other_reason`,`t_waste_detail_bom`.`material_no` AS `material_no_bom`,`t_waste_detail_bom`.`material_desc` AS `material_desc_bom`,`t_waste_detail_bom`.`quantity` AS `qty_bom`,`t_waste_detail_bom`.`uom` AS `uom_bom` from ((`t_waste_header` join `t_waste_detail` on((`t_waste_header`.`id_waste_header` = `t_waste_detail`.`id_waste_header`))) left join `t_waste_detail_bom` on((`t_waste_detail_bom`.`id_waste_detail` = `t_waste_detail`.`id_waste_detail`)));

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
