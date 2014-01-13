-- MySQL dump 10.11
--
-- Host: localhost    Database: loginlog
-- ------------------------------------------------------
-- Server version	5.0.32-Debian_7etch1-log

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
-- Table structure for table `bruksmonster`
--

DROP TABLE IF EXISTS `bruksmonster`;
CREATE TABLE `bruksmonster` (
  `ID` int(3) NOT NULL auto_increment,
  `bruk` varchar(35) NOT NULL,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Table structure for table `groups`
--

DROP TABLE IF EXISTS `groups`;
CREATE TABLE `groups` (
  `ID` int(11) NOT NULL auto_increment,
  `skole` varchar(25) default NULL,
  `kommune` char(1) default 'U',
  `company` varchar(6) default 'ukjent',
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=32 DEFAULT CHARSET=latin1;

--
-- Table structure for table `klienter`
--

DROP TABLE IF EXISTS `klienter`;
CREATE TABLE `klienter` (
  `ID` int(11) NOT NULL auto_increment,
  `gruppe` int(11) default '1',
  `navn` varchar(25) default NULL,
  `type` smallint(1) default '0',
  `lastseen` int(11) default '0',
  `kommentar` text,
  `modell` int(3) default '1',
  `bruksmonster` int(3) default '1',
  PRIMARY KEY  (`ID`),
  KEY `ind_klienter` (`navn`)
) ENGINE=MyISAM AUTO_INCREMENT=4827 DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `images`;
CREATE TABLE `images` (
  `ID` int(11) NOT NULL auto_increment,
  `navn` varchar(25) default NULL,
  `restoretime` int(11) default '0',
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `guestbook`;
CREATE TABLE `guestbook` (
  `ID` int(11) NOT NULL auto_increment,
  `skole` varchar(25) default NULL,
  `userIP` varchar(15) default '000.000.000.000',
  `logintime` int(11) default '0',
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Table structure for table `loginlog`
--

DROP TABLE IF EXISTS `loginlog`;
CREATE TABLE `loginlog` (
  `ID` int(11) NOT NULL auto_increment,
  `username` varchar(11) default '',
  `hostname` varchar(25) default '',
  `unixtime` int(25) default '0',
  `clientname` varchar(25) default '',
  `addtime` int(25) default '0',
  `context` varchar(35) default '',
  `company` varchar(7) default '',
  `shellversion` varchar(17) default '',
  `loginserver` varchar(15) default '',
  `dato` varchar(10) default '01.01.70',
  `tid` varchar(8) default '01:00:00',
  `title` varchar(8) default '',
  `department` varchar(8) default '',
  `location` varchar(8) default '',
  PRIMARY KEY  (`ID`),
  KEY `login_uname` (`username`),
  KEY `log_clientname` (`clientname`),
  KEY `log_context` (`context`),
  KEY `log_hostname` (`hostname`),
  KEY `log_company` (`company`),
  KEY `log_unixtime` (`unixtime`),
  KEY `log_title` (`title`),
  KEY `log_unixtime` (`department`)
  
) ENGINE=MyISAM AUTO_INCREMENT=749341 DEFAULT CHARSET=latin1;

--
-- Table structure for table `modeller`
--

DROP TABLE IF EXISTS `modeller`;
CREATE TABLE `modeller` (
  `ID` int(3) NOT NULL auto_increment,
  `modellnavn` varchar(35) default NULL,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `utskrifter`;
CREATE TABLE `utskrifter` (
  `ID` int(3) NOT NULL auto_increment,
  `jobowner` text default NULL,
  `printer` varchar(35) default NULL,
  `startdato` varchar(35) default NULL,
  `stopdato` varchar(35) default NULL,
  `sider` int(5) default 0,
  `jobsize` int(10) default 0,  
  `statuskode` varchar(15) default NULL,
  `jobname` text default NULL,
  `PDL` varchar(15) default NULL,  
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;
CREATE TABLE applog (
 ID int(15) auto_increment primary key,
 dato varchar(10) default '00.00.0000',
 tid varchar(5) default '00:00',
 unixtime int(10) default 0,
 userDN varchar(40),
 appname varchar(50) default '',
 appSID varchar(40) default '',
 klientDN text,
 klientIP varchar(15) default '000.000.000.000'
 );
 
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2008-02-14 21:03:32

