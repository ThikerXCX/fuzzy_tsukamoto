/*
SQLyog Ultimate v9.50 
MySQL - 5.5.5-10.4.22-MariaDB : Database - tsukamoto_produksi
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`tsukamoto_produksi` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `tsukamoto_produksi`;

/*Table structure for table `tb_aturan` */

DROP TABLE IF EXISTS `tb_aturan`;

CREATE TABLE `tb_aturan` (
  `id_aturan` int(11) NOT NULL AUTO_INCREMENT,
  `no_aturan` int(11) DEFAULT NULL,
  `kode_kriteria` varchar(16) DEFAULT NULL,
  `operator` varchar(16) DEFAULT NULL,
  `kode_himpunan` varchar(16) DEFAULT NULL,
  PRIMARY KEY (`id_aturan`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;

/*Data for the table `tb_aturan` */

insert  into `tb_aturan`(`id_aturan`,`no_aturan`,`kode_kriteria`,`operator`,`kode_himpunan`) values (1,1,'C01','AND','C01-01'),(2,1,'C02','AND','C02-01'),(3,1,'C03','AND','C03-02'),(4,2,'C01','AND','C01-01'),(5,2,'C02','AND','C02-02'),(6,2,'C03','AND','C03-01'),(7,3,'C01','AND','C01-01'),(8,3,'C02','AND','C02-03'),(9,3,'C03','AND','C03-01'),(10,4,'C01','AND','C01-02'),(11,4,'C02','AND','C02-01'),(12,4,'C03','AND','C03-03'),(13,5,'C01','AND','C01-02'),(14,5,'C02','AND','C02-02'),(15,5,'C03','AND','C03-02'),(16,6,'C01','AND','C01-02'),(17,6,'C02','AND','C02-03'),(18,6,'C03','AND','C03-01'),(19,7,'C01','AND','C01-03'),(20,7,'C02','AND','C02-01'),(21,7,'C03','AND','C03-03'),(22,8,'C01','AND','C01-03'),(23,8,'C02','AND','C02-02'),(24,8,'C03','AND','C03-03'),(25,9,'C01','AND','C01-03'),(26,9,'C02','AND','C02-03'),(27,9,'C03','AND','C03-02');

/*Table structure for table `tb_hasil` */

DROP TABLE IF EXISTS `tb_hasil`;

CREATE TABLE `tb_hasil` (
  `id_hasil` int(11) NOT NULL AUTO_INCREMENT,
  `id_produk` int(11) DEFAULT NULL,
  `tanggal_hasil` date DEFAULT NULL,
  `persediaan` int(11) DEFAULT NULL,
  `permintaan` int(11) DEFAULT NULL,
  `produksi` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_hasil`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_hasil` */

insert  into `tb_hasil`(`id_hasil`,`id_produk`,`tanggal_hasil`,`persediaan`,`permintaan`,`produksi`) values (4,1,'2022-08-01',300,3500,3825),(5,1,'2022-12-17',700,1000,1427);

/*Table structure for table `tb_himpunan` */

DROP TABLE IF EXISTS `tb_himpunan`;

CREATE TABLE `tb_himpunan` (
  `kode_himpunan` varchar(16) NOT NULL,
  `kode_kriteria` varchar(16) DEFAULT NULL,
  `nama_himpunan` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`kode_himpunan`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tb_himpunan` */

insert  into `tb_himpunan`(`kode_himpunan`,`kode_kriteria`,`nama_himpunan`) values ('C01-01','C01','Sedikit'),('C01-02','C01','Sedang'),('C01-03','C01','Banyak'),('C02-01','C02','Sedikit'),('C02-02','C02','Sedang'),('C02-03','C02','Banyak'),('C03-01','C03','Sedikit'),('C03-02','C03','Sedang'),('C03-03','C03','Banyak');

/*Table structure for table `tb_kriteria` */

DROP TABLE IF EXISTS `tb_kriteria`;

CREATE TABLE `tb_kriteria` (
  `kode_kriteria` varchar(16) NOT NULL,
  `nama_kriteria` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`kode_kriteria`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `tb_kriteria` */

insert  into `tb_kriteria`(`kode_kriteria`,`nama_kriteria`) values ('C01','Permintaan'),('C02','Persediaan'),('C03','Produksi');

/*Table structure for table `tb_produk` */

DROP TABLE IF EXISTS `tb_produk`;

CREATE TABLE `tb_produk` (
  `id_produk` int(11) NOT NULL AUTO_INCREMENT,
  `nama_produk` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_produk`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_produk` */

insert  into `tb_produk`(`id_produk`,`nama_produk`) values (1,'Chinos'),(2,'Jeans'),(3,'Cargo');

/*Table structure for table `tb_training` */

DROP TABLE IF EXISTS `tb_training`;

CREATE TABLE `tb_training` (
  `id_training` int(11) NOT NULL AUTO_INCREMENT,
  `id_produk` int(11) DEFAULT NULL,
  `tanggal_training` date DEFAULT NULL,
  `permintaan` int(11) DEFAULT NULL,
  `persediaan` int(11) DEFAULT NULL,
  `produksi` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_training`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_training` */

insert  into `tb_training`(`id_training`,`id_produk`,`tanggal_training`,`permintaan`,`persediaan`,`produksi`) values (1,1,'2020-05-01',1600,900,2500),(2,1,'2020-06-01',1560,140,1700),(4,1,'2020-07-01',675,310,985),(5,1,'2020-08-01',1468,387,1855),(6,1,'2020-09-01',1250,650,870),(7,1,'2020-10-01',1255,215,1470),(8,1,'2020-11-01',2580,90,2670),(9,1,'2020-12-01',1376,164,1540),(10,1,'2021-01-01',1390,475,1865),(11,1,'2021-02-01',1325,145,1470),(12,1,'2021-03-01',2100,130,2230),(13,1,'2021-04-01',1582,495,2077);

/*Table structure for table `tb_user` */

DROP TABLE IF EXISTS `tb_user`;

CREATE TABLE `tb_user` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `nama_user` varchar(255) DEFAULT NULL,
  `user` varchar(16) DEFAULT NULL,
  `pass` varchar(16) DEFAULT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `tb_user` */

insert  into `tb_user`(`id_user`,`nama_user`,`user`,`pass`) values (1,'Administrator','admin','admin'),(2,'User','user','user');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
