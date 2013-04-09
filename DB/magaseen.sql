-- phpMyAdmin SQL Dump
-- version 3.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 09, 2013 at 08:16 PM
-- Server version: 5.5.25a
-- PHP Version: 5.4.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `magaseen`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_app`
--

CREATE TABLE IF NOT EXISTS `tb_app` (
  `iId` int(11) NOT NULL AUTO_INCREMENT,
  `iClientId` int(11) NOT NULL,
  `vName` varchar(250) NOT NULL,
  `vDescription` text NOT NULL,
  `vInternalDescription` text NOT NULL,
  `dPaidDate` date NOT NULL,
  `vReference` varchar(250) NOT NULL,
  `iActive` tinyint(1) NOT NULL DEFAULT '1',
  `dCreated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`iId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tb_app`
--

INSERT INTO `tb_app` (`iId`, `iClientId`, `vName`, `vDescription`, `vInternalDescription`, `dPaidDate`, `vReference`, `iActive`, `dCreated`) VALUES
(1, 1, 'Sabby''s Mag', 'Test Mag 1', 'My first test', '2013-01-18', 'payed here', 1, '2013-01-22 18:21:04'),
(2, 4, 'TheComic', 'Sequential Pub', 'Test internal pub', '2013-01-28', 'payed', 1, '2013-01-29 01:54:45');

-- --------------------------------------------------------

--
-- Table structure for table `tb_article`
--

CREATE TABLE IF NOT EXISTS `tb_article` (
  `iId` int(11) NOT NULL AUTO_INCREMENT,
  `iClientId` int(11) NOT NULL,
  `vName` varchar(250) NOT NULL,
  `iPublicationId` varchar(30) NOT NULL,
  `dCreated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`iId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `tb_article`
--

INSERT INTO `tb_article` (`iId`, `iClientId`, `vName`, `iPublicationId`, `dCreated`) VALUES
(1, 1, 'abcd', '38', '2013-01-29 10:41:33'),
(2, 1, 'art', '45', '2013-01-29 16:43:44'),
(3, 1, 'Test Article', '43', '2013-01-29 17:23:52'),
(4, 1, 'articulo1', '51', '2013-01-29 21:22:07'),
(5, 1, 'articulo2', '51', '2013-01-29 21:22:29'),
(6, 1, 'Testing Page', '48', '2013-01-31 11:52:50'),
(7, 0, 'sdhgf', '53', '2013-01-31 17:01:04'),
(8, 1, 'edw3ewew', '53', '2013-01-31 17:49:23'),
(9, 1, 'dewdew', '53', '2013-01-31 17:49:37'),
(10, 1, 'dewdew', '53', '2013-01-31 17:49:38'),
(11, 1, 'edw', '53', '2013-01-31 17:51:12'),
(12, 1, 'wewqrew', '46', '2013-02-01 07:24:48'),
(13, 1, 'first', '64', '2013-02-02 01:30:34'),
(14, 1, 'content', '64', '2013-02-02 01:30:51'),
(15, 0, 'fdfsdf', '64', '2013-02-02 08:38:15');

-- --------------------------------------------------------

--
-- Table structure for table `tb_client`
--

CREATE TABLE IF NOT EXISTS `tb_client` (
  `iId` int(11) NOT NULL AUTO_INCREMENT,
  `vName` varchar(100) NOT NULL,
  `vRFC` varchar(100) NOT NULL,
  `vPassword` varchar(100) NOT NULL,
  `vContact` varchar(250) NOT NULL,
  `vEmail` varchar(100) NOT NULL,
  `vPhone` varchar(50) NOT NULL,
  `vAddress` varchar(250) NOT NULL,
  `vCity` varchar(100) NOT NULL,
  `vZip` varchar(10) NOT NULL,
  `vColonia` varchar(250) NOT NULL,
  `vDelegMunic` varchar(250) NOT NULL,
  `iProvinceId` int(4) NOT NULL,
  `iCountryId` int(4) NOT NULL,
  `iTotalSlots` int(11) NOT NULL,
  `iConsumedSlots` int(11) NOT NULL,
  `dRegDate` datetime NOT NULL,
  `dUpdatedOn` datetime NOT NULL,
  `iActive` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`iId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `tb_client`
--

INSERT INTO `tb_client` (`iId`, `vName`, `vRFC`, `vPassword`, `vContact`, `vEmail`, `vPhone`, `vAddress`, `vCity`, `vZip`, `vColonia`, `vDelegMunic`, `iProvinceId`, `iCountryId`, `iTotalSlots`, `iConsumedSlots`, `dRegDate`, `dUpdatedOn`, `iActive`) VALUES
(1, 'Sabby', 'rfc5555555', 'welcome', '134567890', 'test@test.com', '4564564656', '#123', 'New York', '10001', '', '', 17, 1, 40, 30, '2012-10-29 08:59:09', '2013-01-22 10:20:29', 1),
(4, 'Raul', 'terr', 'batracio', '', 'raul@m9girls.com', '555555555', '524 evergreen', 'mexico', '52910', '', '', 0, 9, 0, 0, '2013-01-28 17:47:04', '0000-00-00 00:00:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_country`
--

CREATE TABLE IF NOT EXISTS `tb_country` (
  `iId` int(11) NOT NULL AUTO_INCREMENT,
  `vCode` char(2) NOT NULL,
  `vName` varchar(150) NOT NULL,
  PRIMARY KEY (`iId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=247 ;

--
-- Dumping data for table `tb_country`
--

INSERT INTO `tb_country` (`iId`, `vCode`, `vName`) VALUES
(3, 'CA', 'Canada'),
(4, 'FR', 'France'),
(5, 'DE', 'Germany'),
(6, 'IE', 'Ireland'),
(7, 'IT', 'Italy'),
(8, 'ES', 'Spain'),
(2, 'GB', 'United Kingdom'),
(1, 'US', 'United States'),
(9, 'MX', 'Mexico');

-- --------------------------------------------------------

--
-- Table structure for table `tb_hotspots`
--

CREATE TABLE IF NOT EXISTS `tb_hotspots` (
  `iId` int(11) NOT NULL AUTO_INCREMENT,
  `iPubFileId` int(11) NOT NULL,
  `iXPos` int(11) NOT NULL,
  `iYPos` int(11) NOT NULL,
  `iXPosLandscape` int(11) NOT NULL,
  `iYPosLandscape` int(11) NOT NULL,
  `iXPosPotrait` int(11) NOT NULL,
  `iYPosPotrait` int(11) NOT NULL,
  `eType` varchar(50) NOT NULL,
  `vDivId` varchar(50) NOT NULL,
  `dCreated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`iId`),
  KEY `iPubFileId` (`iPubFileId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=146 ;

--
-- Dumping data for table `tb_hotspots`
--

INSERT INTO `tb_hotspots` (`iId`, `iPubFileId`, `iXPos`, `iYPos`, `iXPosLandscape`, `iYPosLandscape`, `iXPosPotrait`, `iYPosPotrait`, `eType`, `vDivId`, `dCreated`) VALUES
(101, 283, 127, 255, 274, 303, 205, 406, 'video', 'clonediv1', '2013-02-01 17:56:49'),
(102, 283, 248, 279, 536, 331, 402, 445, 'link', 'clonediv3', '2013-02-01 17:56:52'),
(103, 284, 381, 198, 824, 235, 618, 316, 'video', 'clonediv1', '2013-02-01 18:01:22'),
(104, 284, 240, 246, 518, 292, 389, 392, 'gallery', 'clonediv3', '2013-02-01 18:01:23'),
(105, 284, 209, 261, 451, 310, 339, 416, 'link', 'clonediv5', '2013-02-01 18:01:24'),
(106, 285, 329, 202, 712, 240, 534, 322, 'photo', 'clonediv1', '2013-02-01 18:02:36'),
(107, 285, 126, 173, 273, 205, 205, 276, 'gallery', 'clonediv3', '2013-02-01 18:02:37'),
(108, 286, 162, 230, 351, 273, 263, 367, 'photo', 'clonediv1', '2013-02-01 18:04:46'),
(109, 286, 363, 216, 786, 256, 589, 344, 'sponsor', 'clonediv3', '2013-02-01 18:04:47'),
(112, 373, 201, 92, 435, 109, 326, 147, 'gallery', 'clonediv5', '2013-02-02 01:35:17'),
(113, 376, 227, 122, 491, 145, 369, 194, 'video', 'clonediv7', '2013-02-02 01:38:14'),
(114, 373, 298, 468, 645, 556, 484, 746, 'link', 'clonediv9', '2013-02-02 01:59:54'),
(121, 372, 223, 485, 483, 576, 362, 773, 'pub_link', 'clonediv10', '2013-02-02 09:23:48'),
(122, 372, 147, 251, 318, 298, 239, 400, 'photo', 'clonediv12', '2013-02-02 09:23:50'),
(123, 372, 82, 112, 178, 133, 133, 178, 'gallery', 'clonediv14', '2013-02-02 09:23:51'),
(124, 372, 274, 433, 593, 514, 445, 690, 'video', 'clonediv16', '2013-02-02 09:23:53'),
(125, 372, 348, 110, 753, 131, 565, 175, 'link', 'clonediv18', '2013-02-02 09:23:55'),
(126, 372, 160, 390, 346, 463, 260, 622, 'sponsor', 'clonediv20', '2013-02-02 09:23:56'),
(128, 371, 317, 376, 686, 446, 515, 599, 'pub_link', 'clonediv23', '2013-02-02 10:08:13'),
(129, 371, 107, 206, 232, 245, 174, 328, 'pub_link', 'clonediv25', '2013-02-02 10:13:49'),
(130, 371, 286, 238, 619, 283, 464, 379, 'photo', 'clonediv27', '2013-02-02 10:19:02'),
(131, 371, 246, 113, 531, 134, 399, 180, 'video', 'clonediv16', '2013-02-02 12:09:40'),
(132, 376, 268, 289, 580, 343, 435, 461, 'video', 'clonediv28', '2013-02-02 14:23:52'),
(133, 394, 336, 223, 727, 265, 546, 355, 'pub_link', 'clonediv1', '2013-02-02 14:53:52'),
(134, 394, 67, 165, 145, 196, 109, 263, 'link', 'clonediv3', '2013-02-02 14:54:03'),
(135, 394, 95, 410, 206, 487, 154, 653, 'photo', 'clonediv5', '2013-02-02 14:54:20'),
(136, 394, 252, 170, 546, 202, 409, 271, 'video', 'clonediv7', '2013-02-02 14:54:54'),
(137, 394, 88, 321, 191, 381, 143, 512, 'video', 'clonediv9', '2013-02-02 14:56:04'),
(138, 394, 222, 308, 481, 366, 360, 491, 'pub_link', 'clonediv11', '2013-02-02 14:57:35'),
(139, 394, 132, 57, 286, 68, 214, 91, 'pub_link', 'clonediv13', '2013-02-02 14:57:51'),
(140, 394, 421, 329, 911, 391, 684, 524, 'link', 'clonediv15', '2013-02-02 14:58:07'),
(141, 398, 342, 115, 740, 137, 555, 183, 'gallery', 'clonediv1', '2013-02-05 07:46:36'),
(142, 398, 128, 311, 277, 369, 208, 496, 'pub_link', 'clonediv3', '2013-02-05 07:46:45'),
(143, 398, 269, 75, 582, 89, 437, 120, 'link', 'clonediv5', '2013-02-05 07:47:23'),
(144, 400, 140, 28, 303, 33, 227, 45, 'pub_link', 'clonediv1', '2013-03-21 13:39:52'),
(145, 400, 253, 43, 548, 51, 411, 69, 'photo', 'clonediv3', '2013-03-21 13:39:56');

-- --------------------------------------------------------

--
-- Table structure for table `tb_hotspot_files`
--

CREATE TABLE IF NOT EXISTS `tb_hotspot_files` (
  `iId` int(11) NOT NULL AUTO_INCREMENT,
  `iHotspotId` int(11) NOT NULL,
  `vName` varchar(250) NOT NULL,
  `vDesc` text NOT NULL,
  `vFile` varchar(250) NOT NULL,
  `vLink` varchar(250) NOT NULL,
  `dCreated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`iId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=98 ;

--
-- Dumping data for table `tb_hotspot_files`
--

INSERT INTO `tb_hotspot_files` (`iId`, `iHotspotId`, `vName`, `vDesc`, `vFile`, `vLink`, `dCreated`) VALUES
(43, 100, 'ewfe', 'sdafdsf', 'hotspot_1359731374.jpg', '', '2013-02-01 17:09:34'),
(44, 0, '', '', '', '376', '2013-02-02 01:31:47'),
(45, 110, '', '', '', '375', '2013-02-02 01:34:17'),
(46, 112, 'Data', 'mas informaciÃ³n GrÃ¡fica', 'hotspot_1359761765.png', '', '2013-02-02 01:36:05'),
(47, 112, 'Data', 'mas informaciÃ³n GrÃ¡fica', 'hotspot_1359761775.jpg', '', '2013-02-02 01:36:15'),
(48, 112, 'Data', 'mas informaciÃ³n GrÃ¡fica', 'hotspot_1359761784.jpg', '', '2013-02-02 01:36:24'),
(49, 113, 'Test video', 'Video en acciÃ³n', 'video_1359779435.mp4', '', '2013-02-02 01:43:04'),
(50, 113, '', '', '', 'www.ieee.org', '2013-02-02 02:00:33'),
(51, 113, 'Microsoft Research', '', 'hotspot_1359763493.jpg', 'http://research.microsoft.com', '2013-02-02 02:04:56'),
(52, 114, '', '', '', 'www.ieee.org', '2013-02-02 02:35:49'),
(53, 115, 'VisualizaciÃ³n', 'Vemos el mundo girar', 'hotspot_1359765425.jpg', 'http://research.microsoft.com', '2013-02-02 02:37:09'),
(54, 111, 'Realidad Aumentada', 'Imagen de Realidad aumentada', 'hotspot_1359765508.jpg', '', '2013-02-02 02:38:31'),
(55, 115, 'VisualizaciÃ³n', 'Vemos el mundo girar', 'hotspot_1359765854.jpg', '', '2013-02-02 02:44:14'),
(56, 115, 'VisualizaciÃ³n', 'Vemos el mundo girar', 'hotspot_1359765874.jpg', '', '2013-02-02 02:44:34'),
(57, 115, 'VisualizaciÃ³n', 'Vemos el mundo girar', 'hotspot_1359765881.jpg', '', '2013-02-02 02:44:41'),
(58, 115, 'VisualizaciÃ³n', 'Vemos el mundo girar', 'hotspot_1359765891.jpg', '', '2013-02-02 02:44:51'),
(59, 115, 'VisualizaciÃ³n', 'Vemos el mundo girar', 'hotspot_1359765899.jpg', '', '2013-02-02 02:44:59'),
(60, 115, 'VisualizaciÃ³n', 'Vemos el mundo girar', 'hotspot_1359765906.jpg', '', '2013-02-02 02:45:06'),
(61, 115, 'VisualizaciÃ³n', 'Vemos el mundo girar', 'hotspot_1359765914.jpg', '', '2013-02-02 02:45:14'),
(62, 115, 'VisualizaciÃ³n', 'Vemos el mundo girar', 'hotspot_1359765923.jpg', '', '2013-02-02 02:45:23'),
(63, 115, 'VisualizaciÃ³n', 'Vemos el mundo girar', 'hotspot_1359765936.jpg', '', '2013-02-02 02:45:36'),
(64, 117, '', '', 'hotspot_1359767448.jpg', '', '2013-02-02 03:10:48'),
(65, 119, 'Gira', 'Girando', 'hotspot_1359767495.jpg', '', '2013-02-02 03:11:35'),
(66, 119, 'Gira', 'Girando', 'hotspot_1359767501.jpg', '', '2013-02-02 03:11:41'),
(67, 119, 'Gira', 'Girando', 'hotspot_1359767508.jpg', '', '2013-02-02 03:11:48'),
(68, 119, 'Gira', 'Girando', 'hotspot_1359767514.jpg', '', '2013-02-02 03:11:54'),
(69, 119, 'Gira', 'Girando', 'hotspot_1359767521.jpg', '', '2013-02-02 03:12:01'),
(70, 119, 'Gira', 'Girando', 'hotspot_1359767527.jpg', '', '2013-02-02 03:12:07'),
(71, 120, 'rwerwer', 'ewrewrwqr', 'video_1359785705.mp4', 'rewwq', '2013-02-02 08:15:11'),
(72, 121, '', '', '', '371', '2013-02-02 09:24:03'),
(73, 125, '', '', '', 'abc.com', '2013-02-02 09:24:21'),
(74, 122, 'abc', 'bc', 'hotspot_1359790129.png', '', '2013-02-02 09:29:00'),
(75, 123, '', '', 'hotspot_1359790175.jpg', '', '2013-02-02 09:29:35'),
(76, 126, 'sponsor name', '', 'hotspot_1359790242.png', 'www.beckondelve.com', '2013-02-02 09:30:49'),
(77, 124, 'BMW Clips', 'BMW Clips', 'video_1359790545.mp4', 'BMW Clips', '2013-02-02 09:36:08'),
(78, 0, '', '', '', '374', '2013-02-02 09:52:02'),
(79, 127, '', '', '', '374', '2013-02-02 09:52:21'),
(80, 128, '', '', '', '371', '2013-02-02 10:08:19'),
(81, 129, '', '', '', '374', '2013-02-02 10:14:00'),
(82, 129, 'jjkjkjkl', 'klklljlj', 'hotspot_1359793163.png', '', '2013-02-02 10:19:28'),
(83, 132, 'Testing Video', 'Testing video BeckonDelve', 'video_1359808225.mp4', '', '2013-02-02 14:30:27'),
(84, 133, '', '', '', '395', '2013-02-02 14:53:56'),
(85, 134, '', '', '', 'http://www.beckondelve.com', '2013-02-02 14:54:16'),
(86, 135, 'Test Image', 'This is the testing image ', 'hotspot_1359809686.png', '', '2013-02-02 14:54:49'),
(87, 136, 'Testing Video', 'This is the test video added for the testing', 'video_1359809750.mp4', '', '2013-02-02 14:55:53'),
(88, 137, 'Testing 2 Video on One Page', 'This video test the multiple videos on a single page', 'video_1359809817.mp4', '', '2013-02-02 14:57:18'),
(89, 137, '', '', '', '397', '2013-02-02 14:57:41'),
(90, 139, '', '', '', '397', '2013-02-02 14:57:55'),
(91, 140, '', '', '', 'ieee.org', '2013-02-02 14:58:26'),
(92, 138, '', '', '', '396', '2013-02-02 15:08:01'),
(93, 143, '', '', '', 'sfsdfsdfsd', '2013-02-05 07:47:28'),
(94, 143, '', '', '', 'sfsdfsdfsd', '2013-02-05 07:47:29'),
(95, 0, 'tset', 'ttst', 'hotspot_1363873202.JPG', '', '2013-03-21 13:40:11'),
(96, 144, '', '', '', '399', '2013-03-21 13:40:18'),
(97, 145, 'tests', 'tess', 'hotspot_1363873240.JPG', '', '2013-03-21 13:40:42');

-- --------------------------------------------------------

--
-- Table structure for table `tb_magazine`
--

CREATE TABLE IF NOT EXISTS `tb_magazine` (
  `iId` int(11) NOT NULL AUTO_INCREMENT,
  `iAppId` int(11) NOT NULL,
  `vName` varchar(255) NOT NULL,
  `vDescription` text NOT NULL,
  `vImage` varchar(100) NOT NULL,
  `dCreated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`iId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tb_magazine`
--

INSERT INTO `tb_magazine` (`iId`, `iAppId`, `vName`, `vDescription`, `vImage`, `dCreated`) VALUES
(1, 1, 'The Magaseen', 'Ejemplo Magaseen', 'magazina_1359417448.jpg', '2013-01-29 01:57:36'),
(2, 1, 'TestArea', 'Tes for files', 'magazina_1359419625.jpg', '2013-01-29 02:33:48');

-- --------------------------------------------------------

--
-- Table structure for table `tb_publication`
--

CREATE TABLE IF NOT EXISTS `tb_publication` (
  `iId` int(11) NOT NULL AUTO_INCREMENT,
  `vName` varchar(255) NOT NULL,
  `vDescription` text NOT NULL,
  `iMonth` tinyint(2) NOT NULL,
  `dActivationDate` date NOT NULL,
  `iMagazineId` int(11) NOT NULL,
  `iPublished` tinyint(1) NOT NULL DEFAULT '0',
  `dCreated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`iId`),
  KEY `iMagazineId` (`iMagazineId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=71 ;

--
-- Dumping data for table `tb_publication`
--

INSERT INTO `tb_publication` (`iId`, `vName`, `vDescription`, `iMonth`, `dActivationDate`, `iMagazineId`, `iPublished`, `dCreated`) VALUES
(59, 'wadadwe', 'wqrwerewtreyry', 1, '2013-02-05', 2, 0, '2013-02-01 17:56:11'),
(61, 'wed', 'dsdsada', 1, '2013-02-04', 2, 0, '2013-02-01 18:00:46'),
(62, 'gdgfdg', 'dgdfg', 1, '2013-02-04', 2, 0, '2013-02-01 18:01:58'),
(63, 'wrewe', 'ertretrtretgyety', 1, '2013-02-04', 2, 0, '2013-02-01 18:04:10'),
(64, 'FascÃƒï¿½Ã¯Â¿Â½ÃƒÂ¯Ã‚Â¿Ã‚Â½Ãƒï¿½Ã¯Â¿Â½Ãƒï¿½Ã‚Â­culo', 'Publicaciones periÃ³dicas', 5, '2011-11-01', 1, 1, '2013-02-02 00:41:04'),
(65, 'Revista Mensual', 'Revista mensual', 9, '2013-01-14', 1, 0, '2013-02-02 06:54:23'),
(67, 'try again', 'try again', 11, '2013-01-14', 1, 0, '2013-02-02 10:50:22'),
(68, 'Testing iPad App', 'This is the test publication added to check the iPad functionality in the app.', 9, '2013-02-21', 2, 1, '2013-02-02 14:48:26'),
(69, 'Ã¡ or Ã±Ã¡ or Ã±Ã¡ or Ã±Ã¡ or Ã±', 'xxzxzx', 1, '2013-02-06', 1, 0, '2013-02-06 04:42:53'),
(70, 'á or ñá or ñá or ñá or ñ', 'xxzxzx', 1, '2013-02-06', 1, 0, '2013-02-06 05:33:03');

-- --------------------------------------------------------

--
-- Table structure for table `tb_publication_files`
--

CREATE TABLE IF NOT EXISTS `tb_publication_files` (
  `iId` int(11) NOT NULL AUTO_INCREMENT,
  `iPublicationId` int(11) NOT NULL,
  `iArticleId` int(11) NOT NULL,
  `vFile` varchar(100) NOT NULL,
  `vDispName` varchar(100) NOT NULL,
  `dCreated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`iId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=401 ;

--
-- Dumping data for table `tb_publication_files`
--

INSERT INTO `tb_publication_files` (`iId`, `iPublicationId`, `iArticleId`, `vFile`, `vDispName`, `dCreated`) VALUES
(283, 59, 0, 'publication_1359734200.jpg', 'bg-20130201.jpg', '2013-02-01 17:56:40'),
(284, 61, 0, 'publication_1359734471.jpg', 'bg-20130201.jpg', '2013-02-01 18:01:12'),
(285, 62, 0, 'publication_1359734548.jpg', 'bg-20130201.jpg', '2013-02-01 18:02:28'),
(286, 63, 0, 'publication_1359734679.jpg', 'bg-20130201.jpg', '2013-02-01 18:04:40'),
(287, 61, 0, 'publication_13597369840.png', 'Revista6baja72[1]-20130201.png', '2013-02-01 18:46:48'),
(288, 61, 0, 'publication_13597369841.png', 'Revista6baja72[2]-20130201.png', '2013-02-01 18:46:50'),
(289, 61, 0, 'publication_13597369842.png', 'Revista6baja72[3]-20130201.png', '2013-02-01 18:46:52'),
(290, 61, 0, 'publication_13597369843.png', 'Revista6baja72[4]-20130201.png', '2013-02-01 18:46:53'),
(291, 61, 0, 'publication_13597369844.png', 'Revista6baja72[5]-20130201.png', '2013-02-01 18:46:56'),
(292, 61, 0, 'publication_13597369845.png', 'Revista6baja72[6]-20130201.png', '2013-02-01 18:46:58'),
(293, 61, 0, 'publication_13597369846.png', 'Revista6baja72[7]-20130201.png', '2013-02-01 18:46:59'),
(294, 61, 0, 'publication_13597369847.png', 'Revista6baja72[8]-20130201.png', '2013-02-01 18:47:00'),
(295, 61, 0, 'publication_13597369848.png', 'Revista6baja72[9]-20130201.png', '2013-02-01 18:47:02'),
(296, 61, 0, 'publication_13597369849.png', 'Revista6baja72[10]-20130201.png', '2013-02-01 18:47:07'),
(297, 61, 0, 'publication_135973698410.png', 'Revista6baja72[11]-20130201.png', '2013-02-01 18:47:08'),
(298, 61, 0, 'publication_135973698411.png', 'Revista6baja72[12]-20130201.png', '2013-02-01 18:47:10'),
(299, 61, 0, 'publication_135973698412.png', 'Revista6baja72[13]-20130201.png', '2013-02-01 18:47:11'),
(300, 61, 0, 'publication_135973698413.png', 'Revista6baja72[14]-20130201.png', '2013-02-01 18:47:13'),
(301, 61, 0, 'publication_135973698414.png', 'Revista6baja72[15]-20130201.png', '2013-02-01 18:47:14'),
(302, 61, 0, 'publication_135973698415.png', 'Revista6baja72[16]-20130201.png', '2013-02-01 18:47:16'),
(303, 61, 0, 'publication_135973698416.png', 'Revista6baja72[17]-20130201.png', '2013-02-01 18:47:18'),
(304, 61, 0, 'publication_135973698417.png', 'Revista6baja72[18]-20130201.png', '2013-02-01 18:47:19'),
(305, 61, 0, 'publication_135973698418.png', 'Revista6baja72[19]-20130201.png', '2013-02-01 18:47:22'),
(306, 61, 0, 'publication_135973698419.png', 'Revista6baja72[20]-20130201.png', '2013-02-01 18:47:25'),
(307, 61, 0, 'publication_135973698420.png', 'Revista6baja72[21]-20130201.png', '2013-02-01 18:47:27'),
(308, 61, 0, 'publication_135973698421.png', 'Revista6baja72[22]-20130201.png', '2013-02-01 18:47:28'),
(309, 61, 0, 'publication_135973698422.png', 'Revista6baja72[23]-20130201.png', '2013-02-01 18:47:30'),
(310, 61, 0, 'publication_135973698423.png', 'Revista6baja72[24]-20130201.png', '2013-02-01 18:47:32'),
(311, 61, 0, 'publication_135973698424.png', 'Revista6baja72[25]-20130201.png', '2013-02-01 18:47:34'),
(312, 61, 0, 'publication_135973698425.png', 'Revista6baja72[26]-20130201.png', '2013-02-01 18:47:36'),
(313, 61, 0, 'publication_135973698426.png', 'Revista6baja72[27]-20130201.png', '2013-02-01 18:47:38'),
(314, 61, 0, 'publication_135973698427.png', 'Revista6baja72[28]-20130201.png', '2013-02-01 18:47:41'),
(315, 61, 0, 'publication_135973698428.png', 'Revista6baja72[29]-20130201.png', '2013-02-01 18:47:43'),
(316, 61, 0, 'publication_135973698429.png', 'Revista6baja72[30]-20130201.png', '2013-02-01 18:47:45'),
(317, 61, 0, 'publication_135973698430.png', 'Revista6baja72[31]-20130201.png', '2013-02-01 18:47:47'),
(318, 61, 0, 'publication_135973698431.png', 'Revista6baja72[32]-20130201.png', '2013-02-01 18:47:49'),
(319, 61, 0, 'publication_135973698432.png', 'Revista6baja72[33]-20130201.png', '2013-02-01 18:47:54'),
(320, 61, 0, 'publication_135973698433.png', 'Revista6baja72[34]-20130201.png', '2013-02-01 18:47:56'),
(321, 61, 0, 'publication_135973698434.png', 'Revista6baja72[35]-20130201.png', '2013-02-01 18:47:57'),
(322, 61, 0, 'publication_135973698435.png', 'Revista6baja72[36]-20130201.png', '2013-02-01 18:48:00'),
(323, 61, 0, 'publication_135973698436.png', 'Revista6baja72[37]-20130201.png', '2013-02-01 18:48:04'),
(324, 61, 0, 'publication_135973698437.png', 'Revista6baja72[38]-20130201.png', '2013-02-01 18:48:06'),
(325, 61, 0, 'publication_135973698438.png', 'Revista6baja72[39]-20130201.png', '2013-02-01 18:48:09'),
(326, 61, 0, 'publication_135973698439.png', 'Revista6baja72[40]-20130201.png', '2013-02-01 18:48:10'),
(327, 61, 0, 'publication_135973698440.png', 'Revista6baja72[41]-20130201.png', '2013-02-01 18:48:12'),
(328, 61, 0, 'publication_135973698441.png', 'Revista6baja72[42]-20130201.png', '2013-02-01 18:48:14'),
(329, 61, 0, 'publication_135973698442.png', 'Revista6baja72[43]-20130201.png', '2013-02-01 18:48:17'),
(330, 61, 0, 'publication_135973698443.png', 'Revista6baja72[44]-20130201.png', '2013-02-01 18:48:18'),
(331, 61, 0, 'publication_135973698444.png', 'Revista6baja72[45]-20130201.png', '2013-02-01 18:48:20'),
(332, 61, 0, 'publication_135973698445.png', 'Revista6baja72[46]-20130201.png', '2013-02-01 18:48:22'),
(333, 61, 0, 'publication_135973698446.png', 'Revista6baja72[47]-20130201.png', '2013-02-01 18:48:24'),
(334, 61, 0, 'publication_135973698447.png', 'Revista6baja72[48]-20130201.png', '2013-02-01 18:48:25'),
(335, 61, 0, 'publication_135973698448.png', 'Revista6baja72[49]-20130201.png', '2013-02-01 18:48:27'),
(336, 61, 0, 'publication_135973698449.png', 'Revista6baja72[50]-20130201.png', '2013-02-01 18:48:29'),
(337, 61, 0, 'publication_135973698450.png', 'Revista6baja72[51]-20130201.png', '2013-02-01 18:48:32'),
(338, 61, 0, 'publication_135973698451.png', 'Revista6baja72[52]-20130201.png', '2013-02-01 18:48:33'),
(339, 61, 0, 'publication_135973698452.png', 'Revista6baja72[53]-20130201.png', '2013-02-01 18:48:36'),
(340, 61, 0, 'publication_135973698453.png', 'Revista6baja72[54]-20130201.png', '2013-02-01 18:48:37'),
(341, 61, 0, 'publication_135973698454.png', 'Revista6baja72[55]-20130201.png', '2013-02-01 18:48:39'),
(342, 61, 0, 'publication_135973698455.png', 'Revista6baja72[56]-20130201.png', '2013-02-01 18:48:41'),
(343, 61, 0, 'publication_135973698456.png', 'Revista6baja72[57]-20130201.png', '2013-02-01 18:48:42'),
(344, 61, 0, 'publication_135973698457.png', 'Revista6baja72[58]-20130201.png', '2013-02-01 18:48:44'),
(345, 61, 0, 'publication_135973698458.png', 'Revista6baja72[59]-20130201.png', '2013-02-01 18:48:46'),
(346, 61, 0, 'publication_135973698459.png', 'Revista6baja72[60]-20130201.png', '2013-02-01 18:48:47'),
(347, 61, 0, 'publication_135973698460.png', 'Revista6baja72[61]-20130201.png', '2013-02-01 18:48:49'),
(348, 61, 0, 'publication_135973698461.png', 'Revista6baja72[62]-20130201.png', '2013-02-01 18:48:52'),
(349, 61, 0, 'publication_135973698462.png', 'Revista6baja72[63]-20130201.png', '2013-02-01 18:48:53'),
(350, 61, 0, 'publication_135973698463.png', 'Revista6baja72[64]-20130201.png', '2013-02-01 18:48:53'),
(351, 61, 0, 'publication_135973698464.png', 'Revista6baja72[65]-20130201.png', '2013-02-01 18:48:55'),
(352, 61, 0, 'publication_135973698465.png', 'Revista6baja72[66]-20130201.png', '2013-02-01 18:48:57'),
(353, 61, 0, 'publication_135973698466.png', 'Revista6baja72[67]-20130201.png', '2013-02-01 18:48:58'),
(354, 61, 0, 'publication_135973698467.png', 'Revista6baja72[68]-20130201.png', '2013-02-01 18:49:00'),
(355, 61, 0, 'publication_135973698468.png', 'Revista6baja72[69]-20130201.png', '2013-02-01 18:49:01'),
(356, 61, 0, 'publication_135973698469.png', 'Revista6baja72[70]-20130201.png', '2013-02-01 18:49:02'),
(357, 61, 0, 'publication_135973698470.png', 'Revista6baja72[71]-20130201.png', '2013-02-01 18:49:04'),
(358, 61, 0, 'publication_135973698471.png', 'Revista6baja72[72]-20130201.png', '2013-02-01 18:49:06'),
(359, 61, 0, 'publication_135973698472.png', 'Revista6baja72[73]-20130201.png', '2013-02-01 18:49:08'),
(360, 61, 0, 'publication_135973698473.png', 'Revista6baja72[74]-20130201.png', '2013-02-01 18:49:09'),
(361, 61, 0, 'publication_135973698474.png', 'Revista6baja72[75]-20130201.png', '2013-02-01 18:49:10'),
(362, 61, 0, 'publication_135973698475.png', 'Revista6baja72[76]-20130201.png', '2013-02-01 18:49:12'),
(363, 61, 0, 'publication_135973698476.png', 'Revista6baja72[77]-20130201.png', '2013-02-01 18:49:14'),
(364, 61, 0, 'publication_135973698477.png', 'Revista6baja72[78]-20130201.png', '2013-02-01 18:49:16'),
(365, 61, 0, 'publication_135973698478.png', 'Revista6baja72[79]-20130201.png', '2013-02-01 18:49:17'),
(366, 61, 0, 'publication_135973698479.png', 'Revista6baja72[80]-20130201.png', '2013-02-01 18:49:19'),
(367, 61, 0, 'publication_135973698480.png', 'Revista6baja72[81]-20130201.png', '2013-02-01 18:49:21'),
(368, 61, 0, 'publication_135973698481.png', 'Revista6baja72[82]-20130201.png', '2013-02-01 18:49:22'),
(369, 61, 0, 'publication_135973698482.png', 'Revista6baja72[83]-20130201.png', '2013-02-01 18:49:22'),
(370, 61, 0, 'publication_135973698483.png', 'Revista6baja72[84]-20130201.png', '2013-02-01 18:49:24'),
(371, 64, 0, 'publication_13597611170.png', 'medicalStudyFlightsim[1]-20130201.png', '2013-02-02 01:25:30'),
(372, 64, 0, 'publication_13597611171.png', 'medicalStudyFlightsim[2]-20130201.png', '2013-02-02 01:25:32'),
(373, 64, 13, 'publication_13597611172.png', 'medicalStudyFlightsim[3]-20130201.png', '2013-02-02 01:25:34'),
(374, 64, 0, 'publication_13597611173.png', 'medicalStudyFlightsim[4]-20130201.png', '2013-02-02 01:25:36'),
(375, 64, 0, 'publication_13597611174.png', 'medicalStudyFlightsim[5]-20130201.png', '2013-02-02 01:25:37'),
(376, 64, 14, 'publication_13597611175.png', 'medicalStudyFlightsim[6]-20130201.png', '2013-02-02 01:25:39'),
(377, 64, 0, 'publication_13597611176.png', 'medicalStudyFlightsim[7]-20130201.png', '2013-02-02 01:25:40'),
(378, 64, 0, 'publication_13597869800.png', 'WhatsReal[1]-20130202.png', '2013-02-02 08:36:23'),
(379, 64, 0, 'publication_13597869801.png', 'WhatsReal[2]-20130202.png', '2013-02-02 08:36:24'),
(387, 67, 0, 'publication_13597950730.png', 'medicalStudyFlightsim[1]-20130202.png', '2013-02-02 10:51:21'),
(388, 67, 0, 'publication_13597950731.png', 'medicalStudyFlightsim[2]-20130202.png', '2013-02-02 10:51:23'),
(389, 67, 0, 'publication_13597950732.png', 'medicalStudyFlightsim[3]-20130202.png', '2013-02-02 10:51:24'),
(390, 67, 0, 'publication_13597950733.png', 'medicalStudyFlightsim[4]-20130202.png', '2013-02-02 10:51:25'),
(391, 67, 0, 'publication_13597950734.png', 'medicalStudyFlightsim[5]-20130202.png', '2013-02-02 10:51:26'),
(392, 67, 0, 'publication_13597950735.png', 'medicalStudyFlightsim[6]-20130202.png', '2013-02-02 10:51:27'),
(393, 67, 0, 'publication_13597950736.png', 'medicalStudyFlightsim[7]-20130202.png', '2013-02-02 10:51:28'),
(394, 68, 0, 'publication_13598094030.png', 'IDMarker[1]-20130202.png', '2013-02-02 14:50:05'),
(395, 68, 0, 'publication_13598094031.png', 'IDMarker[2]-20130202.png', '2013-02-02 14:50:06'),
(396, 68, 0, 'publication_13598094540.png', 'PictureMarker[1]-20130202.png', '2013-02-02 14:50:56'),
(397, 68, 0, 'publication_13598094541.png', 'PictureMarker[2]-20130202.png', '2013-02-02 14:50:57'),
(398, 67, 0, 'publication_1360050382.JPG', '1-20130205.JPG', '2013-02-05 07:46:22'),
(399, 69, 0, 'publication_1360126005.JPG', '1-20130206.JPG', '2013-02-06 04:46:45'),
(400, 69, 0, 'publication_1363873180.jpg', 'n1013207564_30103416_7658-20130321.jpg', '2013-03-21 13:39:41');

-- --------------------------------------------------------

--
-- Table structure for table `tb_slot`
--

CREATE TABLE IF NOT EXISTS `tb_slot` (
  `iId` int(11) NOT NULL AUTO_INCREMENT,
  `iClientId` int(11) NOT NULL,
  `iSlots` int(11) NOT NULL,
  `dPaidDate` date NOT NULL,
  `vReference` varchar(250) NOT NULL,
  `iTotal` int(11) NOT NULL DEFAULT '0',
  `dCreated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`iId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `tb_slot`
--

INSERT INTO `tb_slot` (`iId`, `iClientId`, `iSlots`, `dPaidDate`, `vReference`, `iTotal`, `dCreated`) VALUES
(1, 1, 10, '2012-12-09', 'Ref Added by Sabby', 0, '2012-12-09 18:18:10'),
(3, 1, 20, '2013-01-22', 'si pago', 0, '2013-01-23 01:37:32'),
(4, 1, 10, '2013-01-16', 'Bsnca25 %', 0, '2013-01-24 00:56:49');

-- --------------------------------------------------------

--
-- Table structure for table `tb_state`
--

CREATE TABLE IF NOT EXISTS `tb_state` (
  `iId` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `iCountryId` smallint(5) unsigned NOT NULL,
  `vName` varchar(100) NOT NULL,
  `vCode` varchar(3) NOT NULL,
  PRIMARY KEY (`iId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=66 ;

--
-- Dumping data for table `tb_state`
--

INSERT INTO `tb_state` (`iId`, `iCountryId`, `vName`, `vCode`) VALUES
(1, 1, 'Alabama', 'AL'),
(2, 1, 'Alaska', 'AK'),
(3, 1, 'Arizona', 'AZ'),
(4, 1, 'Arkansas', 'AR'),
(5, 1, 'California', 'CA'),
(6, 1, 'Colorado', 'CO'),
(7, 1, 'Connecticut', 'CT'),
(8, 1, 'Delaware', 'DE'),
(9, 1, 'District of Columbia', 'DC'),
(10, 1, 'Florida', 'FL'),
(11, 1, 'Georgia', 'GA'),
(12, 1, 'Hawaii', 'HI'),
(13, 1, 'Idaho', 'ID'),
(14, 1, 'Illinois', 'IL'),
(15, 1, 'Indiana', 'IN'),
(16, 1, 'Iowa', 'IA'),
(17, 1, 'Kansas', 'KS'),
(18, 1, 'Kentucky', 'KY'),
(19, 1, 'Louisiana', 'LA'),
(20, 1, 'Maine', 'ME'),
(21, 1, 'Maryland', 'MD'),
(22, 1, 'Massachusetts', 'MA'),
(23, 1, 'Michigan', 'MI'),
(24, 1, 'Minnesota', 'MN'),
(25, 1, 'Mississippi', 'MS'),
(26, 1, 'Missouri', 'MO'),
(27, 1, 'Montana', 'MT'),
(28, 1, 'Nebraska', 'NE'),
(29, 1, 'Nevada', 'NV'),
(30, 1, 'New Hampshire', 'NH'),
(31, 1, 'New Jersey', 'NJ'),
(32, 1, 'New Mexico', 'NM'),
(33, 1, 'New York', 'NY'),
(34, 1, 'North Carolina', 'NC'),
(35, 1, 'North Dakota', 'ND'),
(36, 1, 'Ohio', 'OH'),
(37, 1, 'Oklahoma', 'OK'),
(38, 1, 'Oregon', 'OR'),
(39, 1, 'Pennsylvania', 'PA'),
(40, 1, 'Rhode Island', 'RI'),
(41, 1, 'South Carolina', 'SC'),
(42, 1, 'South Dakota', 'SD'),
(43, 1, 'Tennessee', 'TN'),
(44, 1, 'Texas', 'TX'),
(45, 1, 'Utah', 'UT'),
(46, 1, 'Vermont', 'VT'),
(47, 1, 'Virginia', 'VA'),
(48, 1, 'Washington', 'WA'),
(49, 1, 'West Virginia', 'WV'),
(50, 1, 'Wisconsin', 'WI'),
(51, 1, 'Wyoming', 'WY'),
(52, 3, 'Alberta', 'AB'),
(53, 3, 'British Columbia', 'BC'),
(54, 3, 'Manitoba', 'MB'),
(55, 3, 'New Brunswick', 'NB'),
(56, 3, 'Newfoundland and Labrador', 'NL'),
(57, 3, 'Northwest Territories', 'NT'),
(58, 3, 'Nova Scotia', 'NS'),
(59, 3, 'Nunavut', 'NU'),
(60, 3, 'Ontario', 'ON'),
(61, 3, 'Prince Edward Island', 'PE'),
(62, 3, 'Quebec', 'QC'),
(63, 3, 'Saskatchewan', 'SK'),
(64, 3, 'Yukon', 'YT'),
(65, 0, '--Other--', 'OT');

-- --------------------------------------------------------

--
-- Table structure for table `tb_user`
--

CREATE TABLE IF NOT EXISTS `tb_user` (
  `iId` int(11) NOT NULL AUTO_INCREMENT,
  `vType` enum('SA','TRD') NOT NULL DEFAULT 'TRD',
  `vFirstName` varchar(100) NOT NULL,
  `vMiddleName` varchar(100) NOT NULL,
  `vLastName` varchar(100) NOT NULL,
  `vEmail` varchar(255) NOT NULL,
  `vPassword` varchar(255) NOT NULL,
  `vStreet` varchar(255) NOT NULL,
  `vSuite` varchar(255) NOT NULL,
  `vZip` char(8) NOT NULL,
  `vCity` varchar(100) NOT NULL,
  `iProvinceId` int(5) NOT NULL,
  `vPhone` varchar(20) NOT NULL,
  `iCountryId` int(5) NOT NULL,
  `iActive` tinyint(1) NOT NULL DEFAULT '1',
  `dRegDate` datetime NOT NULL,
  `dUpdatedOn` datetime NOT NULL,
  PRIMARY KEY (`iId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `tb_user`
--

INSERT INTO `tb_user` (`iId`, `vType`, `vFirstName`, `vMiddleName`, `vLastName`, `vEmail`, `vPassword`, `vStreet`, `vSuite`, `vZip`, `vCity`, `iProvinceId`, `vPhone`, `iCountryId`, `iActive`, `dRegDate`, `dUpdatedOn`) VALUES
(1, 'SA', 'Sabby', '', 'Singh', 'admin@test.com', 'tester', '1 Main St', 'abc suite', '95131', 'San Jose', 5, '202 380 9331', 1, 1, '2012-01-25 00:36:00', '2012-02-17 01:22:00');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_hotspots`
--
ALTER TABLE `tb_hotspots`
  ADD CONSTRAINT `tb_hotspots_ibfk_1` FOREIGN KEY (`iPubFileId`) REFERENCES `tb_publication_files` (`iId`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
