-- MySQL dump 10.13  Distrib 5.5.34, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: loginlog
-- ------------------------------------------------------
-- Server version	5.5.34-0ubuntu0.12.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `applog`
--

DROP TABLE IF EXISTS `applog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `applog` (
  `ID` int(15) NOT NULL AUTO_INCREMENT,
  `dato` varchar(10) DEFAULT '00.00.0000',
  `tid` varchar(8) DEFAULT '00:00',
  `unixtime` int(10) DEFAULT '0',
  `userDN` varchar(55) DEFAULT NULL,
  `appname` varchar(50) DEFAULT '',
  `appSID` varchar(40) DEFAULT '',
  `klientDN` text,
  `klientIP` varchar(15) DEFAULT '000.000.000.000',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=1919 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `bruksmonster`
--

DROP TABLE IF EXISTS `bruksmonster`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bruksmonster` (
  `ID` int(3) NOT NULL AUTO_INCREMENT,
  `bruk` varchar(35) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `groups`
--

DROP TABLE IF EXISTS `groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `groups` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `skole` varchar(25) DEFAULT NULL,
  `kommune` char(1) DEFAULT 'U',
  `company` varchar(6) DEFAULT 'ukjent',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=50 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `guestbook`
--

DROP TABLE IF EXISTS `guestbook`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `guestbook` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `skole` varchar(25) DEFAULT NULL,
  `userIP` varchar(15) DEFAULT '000.000.000.000',
  `logintime` int(11) DEFAULT '0',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=1162 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `images`
--

DROP TABLE IF EXISTS `images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `images` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `navn` varchar(25) DEFAULT NULL,
  `restoretime` int(11) DEFAULT '0',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=1179 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `klienter`
--

DROP TABLE IF EXISTS `klienter`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `klienter` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `gruppe` int(11) DEFAULT '1',
  `navn` varchar(25) DEFAULT NULL,
  `type` smallint(1) DEFAULT '0',
  `lastseen` int(11) DEFAULT '0',
  `kommentar` text,
  `modell` int(3) DEFAULT '1',
  `bruksmonster` int(3) DEFAULT '1',
  PRIMARY KEY (`ID`),
  KEY `ind_klienter` (`navn`)
) ENGINE=MyISAM AUTO_INCREMENT=17691 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `loginlog`
--

DROP TABLE IF EXISTS `loginlog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `loginlog` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(11) DEFAULT '',
  `hostname` varchar(25) DEFAULT '',
  `unixtime` int(25) DEFAULT '0',
  `clientname` varchar(25) DEFAULT '',
  `addtime` int(25) DEFAULT '0',
  `context` varchar(35) DEFAULT '',
  `company` varchar(7) DEFAULT '',
  `shellversion` varchar(17) DEFAULT '',
  `loginserver` varchar(15) DEFAULT '',
  `dato` varchar(10) DEFAULT '01.01.70',
  `tid` varchar(8) DEFAULT '01:00:00',
  `title` varchar(8) DEFAULT '',
  `department` varchar(8) DEFAULT '',
  `location` varchar(8) DEFAULT '',
  `clientIP` varchar(15) DEFAULT '000.000.000.000',
  PRIMARY KEY (`ID`),
  KEY `login_uname` (`username`),
  KEY `log_clientname` (`clientname`),
  KEY `log_context` (`context`),
  KEY `log_hostname` (`hostname`),
  KEY `log_company` (`company`),
  KEY `log_unixtime` (`unixtime`),
  KEY `log_title` (`title`),
  KEY `log_department` (`department`)
) ENGINE=MyISAM AUTO_INCREMENT=3381145 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `modeller`
--

DROP TABLE IF EXISTS `modeller`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `modeller` (
  `ID` int(3) NOT NULL AUTO_INCREMENT,
  `modellnavn` varchar(35) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tsbrukere`
--

DROP TABLE IF EXISTS `tsbrukere`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tsbrukere` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `hostname` varchar(25) NOT NULL,
  `innlogget` int(4) NOT NULL,
  `tidspunkt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=1292 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `utskrifter`
--

DROP TABLE IF EXISTS `utskrifter`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `utskrifter` (
  `ID` int(3) NOT NULL AUTO_INCREMENT,
  `jobowner` text,
  `printer` varchar(35) DEFAULT NULL,
  `startdato` varchar(35) DEFAULT NULL,
  `stopdato` varchar(35) DEFAULT NULL,
  `sider` int(5) DEFAULT '0',
  `jobsize` int(10) DEFAULT '0',
  `statuskode` varchar(15) DEFAULT NULL,
  `jobname` text,
  `PDL` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-01-13 14:02:38
