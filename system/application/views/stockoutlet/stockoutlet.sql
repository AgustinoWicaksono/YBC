/*
SQLyog Community Edition- MySQL GUI v6.16
MySQL - 4.1.11 : Database - sap_php
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

create database if not exists `sap_php`;

USE `sap_php`;

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

/*Table structure for table `r_head` */

DROP TABLE IF EXISTS `r_head`;

CREATE TABLE `r_head` (
  `head_id` int(10) unsigned NOT NULL auto_increment,
  `head_controller` varchar(100) NOT NULL default '',
  `head_function` varchar(100) NOT NULL default '',
  `head_scrpt_id` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`head_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `r_head` */

insert  into `r_head`(`head_id`,`head_controller`,`head_function`,`head_scrpt_id`) values (1,'grpo','browse',1),(2,'grpo','browse_result',1),(3,'grpo','input2',1),(4,'grpo','edit',1),(5,'grpodlv','browse',1),(6,'grpodlv','browse_result',1),(7,'stockoutlet','browse',1),(8,'stockoutlet','browse_result',1),(9,'gisto','browse',1),(10,'gisto','browse_result',1),(11,'waste','browse',1),(12,'waste','browse_result',1),(13,'grnonpo','browse',1),(14,'grnonpo','browse_result',1),(15,'grsto','browse',1),(16,'grsto','browse_result',1),(17,'stdstock','browse',1),(18,'stdstock','browse_result',1);

/*Table structure for table `t_stockoutlet_detail` */

DROP TABLE IF EXISTS `t_stockoutlet_detail`;

CREATE TABLE `t_stockoutlet_detail` (
  `id_stockoutlet_detail` int(11) NOT NULL auto_increment,
  `id_stockoutlet_header` int(11) default '0',
  `id_stockoutlet_h_detail` int(11) default NULL,
  `material_no` varchar(20) default '',
  `material_desc` varchar(50) default '',
  `qty_gso` float default '0',
  `qty_gss` float default '0',
  `quantity` float default '0',
  `uom` varchar(5) default '',
  PRIMARY KEY  (`id_stockoutlet_detail`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `t_stockoutlet_detail` */

/*Table structure for table `t_stockoutlet_header` */

DROP TABLE IF EXISTS `t_stockoutlet_header`;

CREATE TABLE `t_stockoutlet_header` (
  `id_stockoutlet_header` int(11) NOT NULL default '0',
  `posting_date` datetime default '0000-00-00 00:00:00',
  `material_doc_no` varchar(20) default '',
  `plant` varchar(20) default '',
  `plant_name` varchar(50) default NULL,
  `id_stockoutlet_plant` int(11) default NULL,
  `storage_location` varchar(20) default '',
  `storage_location_name` varchar(50) default NULL,
  `status` tinyint(3) default NULL,
  `item_group_code` varchar(20) default NULL,
  `id_user_input` varchar(5) default '',
  `id_user_approved` varchar(5) default '',
  `filename` varchar(50) default '',
  PRIMARY KEY  (`id_stockoutlet_header`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `t_stockoutlet_header` */

insert  into `t_stockoutlet_header`(`id_stockoutlet_header`,`posting_date`,`material_doc_no`,`plant`,`plant_name`,`id_stockoutlet_plant`,`storage_location`,`storage_location_name`,`status`,`item_group_code`,`id_user_input`,`id_user_approved`,`filename`) values (1,'2010-11-23 15:15:30','MD001','P001',NULL,1,'ST001',NULL,1,NULL,'','',''),(2,'2010-11-23 15:20:50','MD002','P002',NULL,2,'ST002',NULL,2,NULL,'','',''),(3,'2010-11-24 07:10:20','MD003','P003',NULL,3,'ST003',NULL,2,NULL,'','',''),(4,'2010-11-25 00:00:00','MD004','P004',NULL,4,'ST004',NULL,1,NULL,'','',''),(0,'0000-00-00 00:00:00','','',NULL,NULL,'',NULL,2,NULL,'','','');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
