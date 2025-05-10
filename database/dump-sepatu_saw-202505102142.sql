-- MySQL dump 10.13  Distrib 8.0.19, for Win64 (x86_64)
--
-- Host: localhost    Database: sepatu_saw
-- ------------------------------------------------------
-- Server version	8.0.30

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `akun`
--

DROP TABLE IF EXISTS `akun`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `akun` (
  `idakun` int NOT NULL AUTO_INCREMENT,
  `nama` text NOT NULL,
  `nik` varchar(25) NOT NULL,
  `jeniskelamin` varchar(255) NOT NULL,
  `email` text NOT NULL,
  `nohp` varchar(255) NOT NULL,
  `pekerjaan` text NOT NULL,
  `alamat` text NOT NULL,
  `role` text NOT NULL,
  `password` text NOT NULL,
  `foto` text NOT NULL,
  PRIMARY KEY (`idakun`),
  KEY `nip` (`nik`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `akun`
--

LOCK TABLES `akun` WRITE;
/*!40000 ALTER TABLE `akun` DISABLE KEYS */;
INSERT INTO `akun` VALUES (2,'Administrator','123','Laki - Laki','admin@gmail.com','08988387271','Kepala Sekolah','-','Admin','admin',''),(30,'Sugeng','A1','Laki - Laki','sugeng@gmail.com','085912592','Programmer','Jl. Palembang','Peserta','sugeng',''),(31,'Alex','A2','Laki - Laki','alex@gmail.com','085981295821','Staff','Jl. Palembang','Peserta','alex',''),(35,'Husen','A4','Laki - Laki','husen@gmail.com','0858215912','Staff','Jl. Palembang','Peserta','husen',''),(39,'Vidha','99','Perempuan','vidha@gmail.com','08951829521','Guru Biologi','Jl. Palembang','Peserta','vidha',''),(40,'Agnes','666','Laki - Laki','agnes@gmail.com','085912512612','-','Jl. Palembang','Peserta','agnes','');
/*!40000 ALTER TABLE `akun` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bobot_kriteria`
--

DROP TABLE IF EXISTS `bobot_kriteria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bobot_kriteria` (
  `id_bobotkriteria` int NOT NULL AUTO_INCREMENT,
  `id_sepatu` int NOT NULL,
  `kd_kriteria` int NOT NULL,
  `bobot` float NOT NULL,
  PRIMARY KEY (`id_bobotkriteria`),
  KEY `id_jenisbarang` (`id_sepatu`),
  KEY `id_kriteria` (`kd_kriteria`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bobot_kriteria`
--

LOCK TABLES `bobot_kriteria` WRITE;
/*!40000 ALTER TABLE `bobot_kriteria` DISABLE KEYS */;
INSERT INTO `bobot_kriteria` VALUES (1,1,1,3),(2,1,2,4),(3,1,3,3),(4,1,4,4),(5,1,5,4),(6,1,6,2),(7,2,1,4),(8,2,2,4),(9,2,3,2),(10,2,4,3),(11,2,5,3),(12,2,6,3),(13,3,1,2),(15,3,3,1),(16,3,4,4),(17,3,5,3),(18,3,6,2),(19,4,1,1),(20,4,2,3),(21,4,3,2),(22,4,4,3),(23,4,5,2),(24,4,6,3),(25,5,1,3),(26,5,2,4),(27,5,3,3),(28,5,4,4),(29,5,5,4),(30,5,6,2),(31,6,1,3),(32,6,2,3),(33,6,3,3),(34,6,4,3),(35,6,5,3),(36,6,6,3),(37,7,1,3),(38,7,2,3),(39,7,3,2),(40,7,4,3),(41,7,5,4),(42,7,6,2),(43,8,1,3),(44,8,2,4),(45,8,3,1),(46,8,4,3),(47,8,5,3),(48,8,6,3),(49,3,2,4);
/*!40000 ALTER TABLE `bobot_kriteria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hasil_rekomendasi`
--

DROP TABLE IF EXISTS `hasil_rekomendasi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `hasil_rekomendasi` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_user` int DEFAULT NULL,
  `id_sepatu` int DEFAULT NULL,
  `skor_wp` float DEFAULT NULL,
  `persentase_wp` float DEFAULT NULL,
  `preferensi_json` text,
  `penjelasan_json` text,
  `tanggal` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hasil_rekomendasi`
--

LOCK TABLES `hasil_rekomendasi` WRITE;
/*!40000 ALTER TABLE `hasil_rekomendasi` DISABLE KEYS */;
INSERT INTO `hasil_rekomendasi` VALUES (5,30,5,1,25,'{\"gender\":\"Pria\",\"jenis_olahraga\":\"Lari\",\"warna\":\"Gelap\",\"kelenturan\":\"Kaku\",\"tebal_sol\":\"Tipis\"}','[\"Gender = Pria, preferensi: Pria, bobot: 1, Cocok (nilai 1), kontribusi: 1\",\"Jenis_olahraga = Lari, preferensi: Lari, bobot: 1, Cocok (nilai 1), kontribusi: 1\",\"Warna = Gelap, preferensi: Gelap, bobot: 1, Cocok (nilai 1), kontribusi: 1\",\"Kelenturan = Kaku, preferensi: Kaku, bobot: 1, Cocok (nilai 1), kontribusi: 1\",\"Tebal_sol = Tipis, preferensi: Tipis, bobot: 1, Cocok (nilai 1), kontribusi: 1\"]','2025-05-09 09:44:51'),(6,30,6,1,25,'{\"gender\":\"Pria\",\"jenis_olahraga\":\"Lari\",\"warna\":\"Gelap\",\"kelenturan\":\"Kaku\",\"tebal_sol\":\"Tipis\"}','[\"Gender = Pria, preferensi: Pria, bobot: 1, Cocok (nilai 1), kontribusi: 1\",\"Jenis_olahraga = Lari, preferensi: Lari, bobot: 1, Cocok (nilai 1), kontribusi: 1\",\"Warna = Gelap, preferensi: Gelap, bobot: 1, Cocok (nilai 1), kontribusi: 1\",\"Kelenturan = Kaku, preferensi: Kaku, bobot: 1, Cocok (nilai 1), kontribusi: 1\",\"Tebal_sol = Tipis, preferensi: Tipis, bobot: 1, Cocok (nilai 1), kontribusi: 1\"]','2025-05-09 09:44:51'),(7,30,7,1,25,'{\"gender\":\"Pria\",\"jenis_olahraga\":\"Lari\",\"warna\":\"Gelap\",\"kelenturan\":\"Kaku\",\"tebal_sol\":\"Tipis\"}','[\"Gender = Pria, preferensi: Pria, bobot: 1, Cocok (nilai 1), kontribusi: 1\",\"Jenis_olahraga = Lari, preferensi: Lari, bobot: 1, Cocok (nilai 1), kontribusi: 1\",\"Warna = Gelap, preferensi: Gelap, bobot: 1, Cocok (nilai 1), kontribusi: 1\",\"Kelenturan = Kaku, preferensi: Kaku, bobot: 1, Cocok (nilai 1), kontribusi: 1\",\"Tebal_sol = Tipis, preferensi: Tipis, bobot: 1, Cocok (nilai 1), kontribusi: 1\"]','2025-05-09 09:44:51'),(8,30,8,1,25,'{\"gender\":\"Pria\",\"jenis_olahraga\":\"Lari\",\"warna\":\"Gelap\",\"kelenturan\":\"Kaku\",\"tebal_sol\":\"Tipis\"}','[\"Gender = Pria, preferensi: Pria, bobot: 1, Cocok (nilai 1), kontribusi: 1\",\"Jenis_olahraga = Lari, preferensi: Lari, bobot: 1, Cocok (nilai 1), kontribusi: 1\",\"Warna = Gelap, preferensi: Gelap, bobot: 1, Cocok (nilai 1), kontribusi: 1\",\"Kelenturan = Kaku, preferensi: Kaku, bobot: 1, Cocok (nilai 1), kontribusi: 1\",\"Tebal_sol = Tipis, preferensi: Tipis, bobot: 1, Cocok (nilai 1), kontribusi: 1\"]','2025-05-09 09:44:51'),(9,30,5,1,25,'{\"gender\":\"Pria\",\"jenis_olahraga\":\"Lari\",\"warna\":\"Gelap\",\"kelenturan\":\"Kaku\",\"tebal_sol\":\"Tipis\"}','[\"Gender = Pria, preferensi: Pria, bobot: 1, Cocok (nilai 1), kontribusi: 1\",\"Jenis_olahraga = Lari, preferensi: Lari, bobot: 1, Cocok (nilai 1), kontribusi: 1\",\"Warna = Gelap, preferensi: Gelap, bobot: 1, Cocok (nilai 1), kontribusi: 1\",\"Kelenturan = Kaku, preferensi: Kaku, bobot: 1, Cocok (nilai 1), kontribusi: 1\",\"Tebal_sol = Tipis, preferensi: Tipis, bobot: 1, Cocok (nilai 1), kontribusi: 1\"]','2025-05-09 14:01:28'),(10,30,6,1,25,'{\"gender\":\"Pria\",\"jenis_olahraga\":\"Lari\",\"warna\":\"Gelap\",\"kelenturan\":\"Kaku\",\"tebal_sol\":\"Tipis\"}','[\"Gender = Pria, preferensi: Pria, bobot: 1, Cocok (nilai 1), kontribusi: 1\",\"Jenis_olahraga = Lari, preferensi: Lari, bobot: 1, Cocok (nilai 1), kontribusi: 1\",\"Warna = Gelap, preferensi: Gelap, bobot: 1, Cocok (nilai 1), kontribusi: 1\",\"Kelenturan = Kaku, preferensi: Kaku, bobot: 1, Cocok (nilai 1), kontribusi: 1\",\"Tebal_sol = Tipis, preferensi: Tipis, bobot: 1, Cocok (nilai 1), kontribusi: 1\"]','2025-05-09 14:01:28'),(11,30,7,1,25,'{\"gender\":\"Pria\",\"jenis_olahraga\":\"Lari\",\"warna\":\"Gelap\",\"kelenturan\":\"Kaku\",\"tebal_sol\":\"Tipis\"}','[\"Gender = Pria, preferensi: Pria, bobot: 1, Cocok (nilai 1), kontribusi: 1\",\"Jenis_olahraga = Lari, preferensi: Lari, bobot: 1, Cocok (nilai 1), kontribusi: 1\",\"Warna = Gelap, preferensi: Gelap, bobot: 1, Cocok (nilai 1), kontribusi: 1\",\"Kelenturan = Kaku, preferensi: Kaku, bobot: 1, Cocok (nilai 1), kontribusi: 1\",\"Tebal_sol = Tipis, preferensi: Tipis, bobot: 1, Cocok (nilai 1), kontribusi: 1\"]','2025-05-09 14:01:28'),(12,30,8,1,25,'{\"gender\":\"Pria\",\"jenis_olahraga\":\"Lari\",\"warna\":\"Gelap\",\"kelenturan\":\"Kaku\",\"tebal_sol\":\"Tipis\"}','[\"Gender = Pria, preferensi: Pria, bobot: 1, Cocok (nilai 1), kontribusi: 1\",\"Jenis_olahraga = Lari, preferensi: Lari, bobot: 1, Cocok (nilai 1), kontribusi: 1\",\"Warna = Gelap, preferensi: Gelap, bobot: 1, Cocok (nilai 1), kontribusi: 1\",\"Kelenturan = Kaku, preferensi: Kaku, bobot: 1, Cocok (nilai 1), kontribusi: 1\",\"Tebal_sol = Tipis, preferensi: Tipis, bobot: 1, Cocok (nilai 1), kontribusi: 1\"]','2025-05-09 14:01:28'),(13,30,5,1,25,'{\"gender\":\"Pria\",\"olahraga\":\"Lari\",\"warna\":\"Gelap\",\"kelenturan\":\"Kaku\",\"tebal_sol\":\"Tipis\",\"search\":\"\"}','[\"Kriteria 1: Nilai = 1, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 2: Nilai = 1, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 3: Nilai = 1, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 4: Nilai = 1, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 5: Nilai = 1, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 6: Nilai = 1, Bobot = 0.16666666666667, Sifat = min, Kontribusi = 1\"]','2025-05-10 20:50:59'),(14,30,6,1,25,'{\"gender\":\"Pria\",\"olahraga\":\"Lari\",\"warna\":\"Gelap\",\"kelenturan\":\"Kaku\",\"tebal_sol\":\"Tipis\",\"search\":\"\"}','[\"Kriteria 1: Nilai = 1, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 2: Nilai = 1, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 3: Nilai = 1, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 4: Nilai = 1, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 5: Nilai = 1, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 6: Nilai = 1, Bobot = 0.16666666666667, Sifat = min, Kontribusi = 1\"]','2025-05-10 20:50:59'),(15,30,7,1,25,'{\"gender\":\"Pria\",\"olahraga\":\"Lari\",\"warna\":\"Gelap\",\"kelenturan\":\"Kaku\",\"tebal_sol\":\"Tipis\",\"search\":\"\"}','[\"Kriteria 1: Nilai = 1, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 2: Nilai = 1, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 3: Nilai = 1, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 4: Nilai = 1, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 5: Nilai = 1, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 6: Nilai = 1, Bobot = 0.16666666666667, Sifat = min, Kontribusi = 1\"]','2025-05-10 20:50:59'),(16,30,7,1,25,'{\"gender\":\"Pria\",\"olahraga\":\"Lari\",\"warna\":\"Gelap\",\"kelenturan\":\"Kaku\",\"tebal_sol\":\"Tipis\",\"search\":\"\"}','[\"Kriteria 1: Nilai = 1, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 2: Nilai = 1, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 3: Nilai = 1, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 4: Nilai = 1, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 5: Nilai = 1, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 6: Nilai = 1, Bobot = 0.16666666666667, Sifat = min, Kontribusi = 1\"]','2025-05-10 20:50:59'),(17,30,1,1,100,'{\"gender\":\"Pria\",\"olahraga\":\"Lari\",\"warna\":\"Gelap\",\"kelenturan\":\"Lentur\",\"tebal_sol\":\"Tebal\",\"search\":\"\"}','[\"Kriteria 1: Nilai = 1, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 2: Nilai = 1, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 3: Nilai = 1, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 4: Nilai = 1.00, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 5: Nilai = 1, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 6: Nilai = 1, Bobot = 0.16666666666667, Sifat = min, Kontribusi = 1\"]','2025-05-10 20:51:48'),(18,30,0,0.000000666667,100,'{\"gender\":\"Pria\",\"olahraga\":\"Lari\",\"warna\":\"Gelap\",\"kelenturan\":\"Lentur\",\"tebal_sol\":\"Tebal\",\"harga_min\":\"1000000.0\",\"harga_max\":\"2000000.0\",\"search\":\"\"}','[\"Harga: Nilai = 1500000, Bobot = 1, Sifat = min, Kontribusi Harga = 0\",\"Kriteria 1: Nilai = 1, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 2: Nilai = 1, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 3: Nilai = 1, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 4: Nilai = 1.00, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 5: Nilai = 1, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 6: Nilai = 1, Bobot = 0.16666666666667, Sifat = min, Kontribusi = 1\"]','2025-05-10 21:25:48'),(19,30,0,0.000000666667,100,'{\"gender\":\"Pria\",\"olahraga\":\"Lari\",\"warna\":\"Gelap\",\"kelenturan\":\"Lentur\",\"tebal_sol\":\"Tebal\",\"harga_min\":\"1000000.0\",\"harga_max\":\"2000000.0\",\"search\":\"\"}','[\"Harga: Nilai = 1500000, Bobot = 1, Sifat = min, Kontribusi Harga = 0\",\"Kriteria 1: Nilai = 1, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 2: Nilai = 1, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 3: Nilai = 1, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 4: Nilai = 1.00, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 5: Nilai = 1, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 6: Nilai = 1, Bobot = 0.16666666666667, Sifat = min, Kontribusi = 1\"]','2025-05-10 21:26:52'),(20,30,0,0.000000666667,100,'{\"gender\":\"Pria\",\"olahraga\":\"Lari\",\"warna\":\"Gelap\",\"kelenturan\":\"Lentur\",\"tebal_sol\":\"Tebal\",\"harga_min\":\"1000000.0\",\"harga_max\":\"2000000.0\",\"search\":\"\"}','[\"Harga: Nilai = 1500000, Bobot = 1, Sifat = min, Kontribusi Harga = 0\",\"Kriteria 1: Nilai = 1, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 2: Nilai = 1, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 3: Nilai = 1, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 4: Nilai = 1.00, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 5: Nilai = 1, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 6: Nilai = 1, Bobot = 0.16666666666667, Sifat = min, Kontribusi = 1\"]','2025-05-10 21:27:44'),(21,30,0,0.000000666667,100,'{\"gender\":\"Pria\",\"olahraga\":\"Lari\",\"warna\":\"Gelap\",\"kelenturan\":\"Lentur\",\"tebal_sol\":\"Tebal\",\"harga_min\":\"1000000.0\",\"harga_max\":\"2000000.0\",\"search\":\"\"}','[\"Harga: Nilai = 1500000, Bobot = 1, Sifat = min, Kontribusi Harga = 0\",\"Kriteria 1: Nilai = 1, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 2: Nilai = 1, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 3: Nilai = 1, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 4: Nilai = 1.00, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 5: Nilai = 1, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 6: Nilai = 1, Bobot = 0.16666666666667, Sifat = min, Kontribusi = 1\"]','2025-05-10 21:29:02'),(22,30,0,0.000000666667,100,'{\"gender\":\"Pria\",\"olahraga\":\"Lari\",\"warna\":\"Gelap\",\"kelenturan\":\"Lentur\",\"tebal_sol\":\"Tebal\",\"harga_min\":\"1000000.0\",\"harga_max\":\"2000000.0\",\"search\":\"\"}','[\"Harga: Nilai = 1500000, Bobot = 1, Sifat = min, Kontribusi Harga = 0\",\"Kriteria 1: Nilai = 1, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 2: Nilai = 1, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 3: Nilai = 1, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 4: Nilai = 1.00, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 5: Nilai = 1, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 6: Nilai = 1, Bobot = 0.16666666666667, Sifat = min, Kontribusi = 1\"]','2025-05-10 21:29:55'),(23,30,0,0.000000666667,100,'{\"gender\":\"Pria\",\"olahraga\":\"Lari\",\"warna\":\"Gelap\",\"kelenturan\":\"Lentur\",\"tebal_sol\":\"Tebal\",\"harga_min\":\"1000000.0\",\"harga_max\":\"2000000.0\",\"search\":\"\"}','[\"Harga: Nilai = 1500000, Bobot = 1, Sifat = min, Kontribusi Harga = 0\",\"Kriteria 1: Nilai = 1, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 2: Nilai = 1, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 3: Nilai = 1, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 4: Nilai = 1.00, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 5: Nilai = 1, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 6: Nilai = 1, Bobot = 0.16666666666667, Sifat = min, Kontribusi = 1\"]','2025-05-10 21:32:33'),(24,30,0,0.000000666667,100,'{\"gender\":\"Pria\",\"olahraga\":\"Lari\",\"warna\":\"Gelap\",\"kelenturan\":\"Lentur\",\"tebal_sol\":\"Tebal\",\"harga_min\":\"1000000.0\",\"harga_max\":\"2000000.0\",\"search\":\"\"}','[\"Harga: Nilai = 1500000, Bobot = 1, Sifat = min, Kontribusi Harga = 0\",\"Kriteria 1: Nilai = 1, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 2: Nilai = 1, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 3: Nilai = 1, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 4: Nilai = 1.00, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 5: Nilai = 1, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 6: Nilai = 1, Bobot = 0.16666666666667, Sifat = min, Kontribusi = 1\"]','2025-05-10 21:33:03'),(25,30,1,0.000000666667,100,'{\"gender\":\"Pria\",\"olahraga\":\"Lari\",\"warna\":\"Gelap\",\"kelenturan\":\"Lentur\",\"tebal_sol\":\"Tebal\",\"harga_min\":\"1000000.0\",\"harga_max\":\"2000000.0\",\"search\":\"\"}','[\"Harga: Nilai = 1500000, Bobot = 1, Sifat = min, Kontribusi Harga = 0\",\"Kriteria 1: Nilai = 1, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 2: Nilai = 1, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 3: Nilai = 1, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 4: Nilai = 1.00, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 5: Nilai = 1, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 6: Nilai = 1, Bobot = 0.16666666666667, Sifat = min, Kontribusi = 1\"]','2025-05-10 21:33:21'),(26,30,1,0.000000666667,100,'{\"gender\":\"Pria\",\"olahraga\":\"Lari\",\"warna\":\"Gelap\",\"kelenturan\":\"Lentur\",\"tebal_sol\":\"Tebal\",\"harga_min\":\"0\",\"harga_max\":\"1800000\",\"search\":\"\"}','[\"Harga: Nilai = 1500000, Bobot = 1, Sifat = min, Kontribusi Harga = 0\",\"Kriteria 1: Nilai = 1, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 2: Nilai = 1, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 3: Nilai = 1, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 4: Nilai = 1.00, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 5: Nilai = 1, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 6: Nilai = 1, Bobot = 0.16666666666667, Sifat = min, Kontribusi = 1\"]','2025-05-10 21:33:39'),(27,30,1,0.000000666667,100,'{\"gender\":\"Pria\",\"olahraga\":\"Lari\",\"warna\":\"Gelap\",\"kelenturan\":\"Lentur\",\"tebal_sol\":\"Tebal\",\"harga_min\":\"1400000\",\"harga_max\":\"1800000\",\"search\":\"\"}','[\"Harga: Nilai = 1500000, Bobot = 1, Sifat = min, Kontribusi Harga = 0\",\"Kriteria 1: Nilai = 1, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 2: Nilai = 1, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 3: Nilai = 1, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 4: Nilai = 1.00, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 5: Nilai = 1, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 6: Nilai = 1, Bobot = 0.16666666666667, Sifat = min, Kontribusi = 1\"]','2025-05-10 21:34:48'),(28,30,5,0.000000588235,25,'{\"gender\":\"Pria\",\"olahraga\":\"Lari\",\"warna\":\"Gelap\",\"kelenturan\":\"Kaku\",\"tebal_sol\":\"Tipis\",\"harga_min\":\"0\",\"harga_max\":\"1800000\",\"search\":\"\"}','[\"Harga: Nilai = 1700000, Bobot = 1, Sifat = min, Kontribusi Harga = 0\",\"Kriteria 1: Nilai = 1, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 2: Nilai = 1, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 3: Nilai = 1, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 4: Nilai = 1, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 5: Nilai = 1, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 6: Nilai = 1, Bobot = 0.16666666666667, Sifat = min, Kontribusi = 1\"]','2025-05-10 21:36:41'),(29,30,6,0.000000588235,25,'{\"gender\":\"Pria\",\"olahraga\":\"Lari\",\"warna\":\"Gelap\",\"kelenturan\":\"Kaku\",\"tebal_sol\":\"Tipis\",\"harga_min\":\"0\",\"harga_max\":\"1800000\",\"search\":\"\"}','[\"Harga: Nilai = 1700000, Bobot = 1, Sifat = min, Kontribusi Harga = 0\",\"Kriteria 1: Nilai = 1, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 2: Nilai = 1, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 3: Nilai = 1, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 4: Nilai = 1, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 5: Nilai = 1, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 6: Nilai = 1, Bobot = 0.16666666666667, Sifat = min, Kontribusi = 1\"]','2025-05-10 21:36:41'),(30,30,7,0.000000588235,25,'{\"gender\":\"Pria\",\"olahraga\":\"Lari\",\"warna\":\"Gelap\",\"kelenturan\":\"Kaku\",\"tebal_sol\":\"Tipis\",\"harga_min\":\"0\",\"harga_max\":\"1800000\",\"search\":\"\"}','[\"Harga: Nilai = 1700000, Bobot = 1, Sifat = min, Kontribusi Harga = 0\",\"Kriteria 1: Nilai = 1, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 2: Nilai = 1, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 3: Nilai = 1, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 4: Nilai = 1, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 5: Nilai = 1, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 6: Nilai = 1, Bobot = 0.16666666666667, Sifat = min, Kontribusi = 1\"]','2025-05-10 21:36:41'),(31,30,7,0.000000588235,25,'{\"gender\":\"Pria\",\"olahraga\":\"Lari\",\"warna\":\"Gelap\",\"kelenturan\":\"Kaku\",\"tebal_sol\":\"Tipis\",\"harga_min\":\"0\",\"harga_max\":\"1800000\",\"search\":\"\"}','[\"Harga: Nilai = 1700000, Bobot = 1, Sifat = min, Kontribusi Harga = 0\",\"Kriteria 1: Nilai = 1, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 2: Nilai = 1, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 3: Nilai = 1, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 4: Nilai = 1, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 5: Nilai = 1, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 6: Nilai = 1, Bobot = 0.16666666666667, Sifat = min, Kontribusi = 1\"]','2025-05-10 21:36:41'),(32,30,0,0.000000588235,25,'{\"gender\":\"Pria\",\"olahraga\":\"Lari\",\"warna\":\"Gelap\",\"kelenturan\":\"Kaku\",\"tebal_sol\":\"Tipis\",\"harga_min\":\"1400000\",\"harga_max\":\"1800000\",\"search\":\"\"}','[\"Harga: Nilai = 1700000, Bobot = 1, Sifat = min, Kontribusi Harga = 0\",\"Kriteria 1: Nilai = 1, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 2: Nilai = 1, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 3: Nilai = 1, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 4: Nilai = 1, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 5: Nilai = 1, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 6: Nilai = 1, Bobot = 0.16666666666667, Sifat = min, Kontribusi = 1\"]','2025-05-10 21:40:30'),(33,30,0,0.000000588235,25,'{\"gender\":\"Pria\",\"olahraga\":\"Lari\",\"warna\":\"Gelap\",\"kelenturan\":\"Kaku\",\"tebal_sol\":\"Tipis\",\"harga_min\":\"1400000\",\"harga_max\":\"1800000\",\"search\":\"\"}','[\"Harga: Nilai = 1700000, Bobot = 1, Sifat = min, Kontribusi Harga = 0\",\"Kriteria 1: Nilai = 1, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 2: Nilai = 1, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 3: Nilai = 1, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 4: Nilai = 1, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 5: Nilai = 1, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 6: Nilai = 1, Bobot = 0.16666666666667, Sifat = min, Kontribusi = 1\"]','2025-05-10 21:40:30'),(34,30,0,0.000000588235,25,'{\"gender\":\"Pria\",\"olahraga\":\"Lari\",\"warna\":\"Gelap\",\"kelenturan\":\"Kaku\",\"tebal_sol\":\"Tipis\",\"harga_min\":\"1400000\",\"harga_max\":\"1800000\",\"search\":\"\"}','[\"Harga: Nilai = 1700000, Bobot = 1, Sifat = min, Kontribusi Harga = 0\",\"Kriteria 1: Nilai = 1, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 2: Nilai = 1, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 3: Nilai = 1, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 4: Nilai = 1, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 5: Nilai = 1, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 6: Nilai = 1, Bobot = 0.16666666666667, Sifat = min, Kontribusi = 1\"]','2025-05-10 21:40:30'),(35,30,0,0.000000588235,25,'{\"gender\":\"Pria\",\"olahraga\":\"Lari\",\"warna\":\"Gelap\",\"kelenturan\":\"Kaku\",\"tebal_sol\":\"Tipis\",\"harga_min\":\"1400000\",\"harga_max\":\"1800000\",\"search\":\"\"}','[\"Harga: Nilai = 1700000, Bobot = 1, Sifat = min, Kontribusi Harga = 0\",\"Kriteria 1: Nilai = 1, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 2: Nilai = 1, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 3: Nilai = 1, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 4: Nilai = 1, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 5: Nilai = 1, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 6: Nilai = 1, Bobot = 0.16666666666667, Sifat = min, Kontribusi = 1\"]','2025-05-10 21:40:30'),(36,30,5,0.000000588235,25,'{\"gender\":\"Pria\",\"olahraga\":\"Lari\",\"warna\":\"Gelap\",\"kelenturan\":\"Kaku\",\"tebal_sol\":\"Tipis\",\"harga_min\":\"1400000\",\"harga_max\":\"1800000\",\"search\":\"\"}','[\"Harga: Nilai = 1700000, Bobot = 1, Sifat = min, Kontribusi Harga = 0\",\"Kriteria 1: Nilai = 1, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 2: Nilai = 1, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 3: Nilai = 1, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 4: Nilai = 1, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 5: Nilai = 1, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 6: Nilai = 1, Bobot = 0.16666666666667, Sifat = min, Kontribusi = 1\"]','2025-05-10 21:40:53'),(37,30,6,0.000000588235,25,'{\"gender\":\"Pria\",\"olahraga\":\"Lari\",\"warna\":\"Gelap\",\"kelenturan\":\"Kaku\",\"tebal_sol\":\"Tipis\",\"harga_min\":\"1400000\",\"harga_max\":\"1800000\",\"search\":\"\"}','[\"Harga: Nilai = 1700000, Bobot = 1, Sifat = min, Kontribusi Harga = 0\",\"Kriteria 1: Nilai = 1, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 2: Nilai = 1, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 3: Nilai = 1, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 4: Nilai = 1, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 5: Nilai = 1, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 6: Nilai = 1, Bobot = 0.16666666666667, Sifat = min, Kontribusi = 1\"]','2025-05-10 21:40:53'),(38,30,7,0.000000588235,25,'{\"gender\":\"Pria\",\"olahraga\":\"Lari\",\"warna\":\"Gelap\",\"kelenturan\":\"Kaku\",\"tebal_sol\":\"Tipis\",\"harga_min\":\"1400000\",\"harga_max\":\"1800000\",\"search\":\"\"}','[\"Harga: Nilai = 1700000, Bobot = 1, Sifat = min, Kontribusi Harga = 0\",\"Kriteria 1: Nilai = 1, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 2: Nilai = 1, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 3: Nilai = 1, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 4: Nilai = 1, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 5: Nilai = 1, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 6: Nilai = 1, Bobot = 0.16666666666667, Sifat = min, Kontribusi = 1\"]','2025-05-10 21:40:53'),(39,30,7,0.000000588235,25,'{\"gender\":\"Pria\",\"olahraga\":\"Lari\",\"warna\":\"Gelap\",\"kelenturan\":\"Kaku\",\"tebal_sol\":\"Tipis\",\"harga_min\":\"1400000\",\"harga_max\":\"1800000\",\"search\":\"\"}','[\"Harga: Nilai = 1700000, Bobot = 1, Sifat = min, Kontribusi Harga = 0\",\"Kriteria 1: Nilai = 1, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 2: Nilai = 1, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 3: Nilai = 1, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 4: Nilai = 1, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 5: Nilai = 1, Bobot = 0.16666666666667, Sifat = max, Kontribusi = 1\",\"Kriteria 6: Nilai = 1, Bobot = 0.16666666666667, Sifat = min, Kontribusi = 1\"]','2025-05-10 21:40:53');
/*!40000 ALTER TABLE `hasil_rekomendasi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jenis`
--

DROP TABLE IF EXISTS `jenis`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jenis` (
  `kd_jenis` int NOT NULL AUTO_INCREMENT,
  `nama` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`kd_jenis`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jenis`
--

LOCK TABLES `jenis` WRITE;
/*!40000 ALTER TABLE `jenis` DISABLE KEYS */;
INSERT INTO `jenis` VALUES (1,'Penilaian Guru');
/*!40000 ALTER TABLE `jenis` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kriteria`
--

DROP TABLE IF EXISTS `kriteria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `kriteria` (
  `kd_kriteria` int NOT NULL AUTO_INCREMENT,
  `kd_jenis` int NOT NULL,
  `nama` text,
  `tipe` varchar(25) NOT NULL,
  `sifat` enum('min','max') DEFAULT NULL,
  `atribut` enum('benefit','cost') DEFAULT 'benefit',
  PRIMARY KEY (`kd_kriteria`),
  KEY `kd_beasiswa` (`kd_jenis`),
  KEY `kd_beasiswa_2` (`kd_jenis`),
  CONSTRAINT `fk_beasiswa` FOREIGN KEY (`kd_jenis`) REFERENCES `jenis` (`kd_jenis`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kriteria`
--

LOCK TABLES `kriteria` WRITE;
/*!40000 ALTER TABLE `kriteria` DISABLE KEYS */;
INSERT INTO `kriteria` VALUES (1,1,'Jenis Olahraga','Jenis Olahraga','max','benefit'),(2,1,'Gender','Gender Sepatu','max','benefit'),(3,1,'Warna','Warna Sepatu','max','benefit'),(4,1,'Kelenturan','Kelenturan Sepatu','max','benefit'),(5,1,'Tebal Sol','Ketebalan Sol Sepatu','max','benefit'),(6,1,'Harga','Harga Sepatu','min','benefit');
/*!40000 ALTER TABLE `kriteria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model`
--

DROP TABLE IF EXISTS `model`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `model` (
  `kd_model` int NOT NULL AUTO_INCREMENT,
  `kd_jenis` int NOT NULL,
  `kd_kriteria` int NOT NULL,
  `bobot` float DEFAULT NULL,
  PRIMARY KEY (`kd_model`),
  KEY `fk_kriteria` (`kd_kriteria`),
  KEY `fk_beasiswa` (`kd_jenis`),
  CONSTRAINT `model_ibfk_1` FOREIGN KEY (`kd_kriteria`) REFERENCES `kriteria` (`kd_kriteria`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `model_ibfk_2` FOREIGN KEY (`kd_jenis`) REFERENCES `jenis` (`kd_jenis`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model`
--

LOCK TABLES `model` WRITE;
/*!40000 ALTER TABLE `model` DISABLE KEYS */;
INSERT INTO `model` VALUES (1,1,1,5),(2,1,2,4),(3,1,3,3),(4,1,4,4),(5,1,5,2),(6,1,6,5);
/*!40000 ALTER TABLE `model` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nilai`
--

DROP TABLE IF EXISTS `nilai`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `nilai` (
  `kd_nilai` int NOT NULL AUTO_INCREMENT,
  `kd_jenis` int DEFAULT NULL,
  `kd_kriteria` int NOT NULL,
  `nik` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `nilai` float DEFAULT NULL,
  PRIMARY KEY (`kd_nilai`),
  KEY `fk_kriteria` (`kd_kriteria`),
  KEY `fk_beasiswa` (`kd_jenis`),
  KEY `nip` (`nik`),
  CONSTRAINT `nilai_ibfk_1` FOREIGN KEY (`kd_kriteria`) REFERENCES `kriteria` (`kd_kriteria`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `nilai_ibfk_3` FOREIGN KEY (`kd_jenis`) REFERENCES `jenis` (`kd_jenis`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `nilai_ibfk_4` FOREIGN KEY (`nik`) REFERENCES `akun` (`nik`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nilai`
--

LOCK TABLES `nilai` WRITE;
/*!40000 ALTER TABLE `nilai` DISABLE KEYS */;
INSERT INTO `nilai` VALUES (25,1,1,'A2',0.5),(26,1,2,'A2',1),(27,1,3,'A2',0.75),(28,1,4,'A2',0.5),(29,1,5,'A2',1),(30,1,6,'A2',0.5),(55,1,1,'A1',4),(56,1,2,'A1',4),(57,1,3,'A1',4),(58,1,4,'A1',4),(59,1,5,'A1',4),(60,1,6,'A1',1);
/*!40000 ALTER TABLE `nilai` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nilai_kriteria`
--

DROP TABLE IF EXISTS `nilai_kriteria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `nilai_kriteria` (
  `kd_nilaikriteria` int NOT NULL AUTO_INCREMENT,
  `kd_kriteria` int NOT NULL,
  `nilai` float NOT NULL,
  `keterangan` text NOT NULL,
  PRIMARY KEY (`kd_nilaikriteria`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nilai_kriteria`
--

LOCK TABLES `nilai_kriteria` WRITE;
/*!40000 ALTER TABLE `nilai_kriteria` DISABLE KEYS */;
INSERT INTO `nilai_kriteria` VALUES (1,1,4,'Lari'),(2,1,3,'Tenis'),(3,1,2,'Volley'),(4,1,1,'Basketball'),(5,2,4,'Pria'),(6,2,3,'Wanita'),(7,3,4,'Gelap'),(8,3,3,'Terang'),(9,4,4,'Lentur'),(10,4,2,'Kaku'),(11,5,4,'Tebal'),(12,5,3,'Tipis'),(13,6,1,'< 1,500,000'),(14,6,2,'1,500,000 - 2,000,000'),(15,6,3,'2,000,000 - 2,500,000'),(16,6,4,'> 2,500,000');
/*!40000 ALTER TABLE `nilai_kriteria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nilai_wp`
--

DROP TABLE IF EXISTS `nilai_wp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `nilai_wp` (
  `id_nilai` int NOT NULL AUTO_INCREMENT,
  `id_sepatu` int DEFAULT NULL,
  `kd_kriteria` varchar(10) DEFAULT NULL,
  `nilai` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id_nilai`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nilai_wp`
--

LOCK TABLES `nilai_wp` WRITE;
/*!40000 ALTER TABLE `nilai_wp` DISABLE KEYS */;
INSERT INTO `nilai_wp` VALUES (1,1,'4',1.00),(2,2,'1',5.00),(3,2,'2',1.00),(4,2,'3',3.00),(5,2,'4',4.00),(6,2,'5',2.00),(7,2,'6',600.00);
/*!40000 ALTER TABLE `nilai_wp` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `penilaian`
--

DROP TABLE IF EXISTS `penilaian`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `penilaian` (
  `kd_penilaian` int NOT NULL AUTO_INCREMENT,
  `kd_jenis` int DEFAULT NULL,
  `kd_kriteria` int NOT NULL,
  `keterangan` text NOT NULL,
  `bobot` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`kd_penilaian`),
  KEY `fk_kriteria` (`kd_kriteria`),
  KEY `fk_beasiswa` (`kd_jenis`),
  CONSTRAINT `penilaian_ibfk_1` FOREIGN KEY (`kd_kriteria`) REFERENCES `kriteria` (`kd_kriteria`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `penilaian_ibfk_2` FOREIGN KEY (`kd_jenis`) REFERENCES `jenis` (`kd_jenis`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `penilaian`
--

LOCK TABLES `penilaian` WRITE;
/*!40000 ALTER TABLE `penilaian` DISABLE KEYS */;
INSERT INTO `penilaian` VALUES (2,1,1,'Basket',4),(3,1,1,'Lari',3),(4,1,1,'Tenis',2),(5,1,2,'Pria',5),(6,1,2,'Wanita',4),(7,1,3,'Gelap',5),(8,1,3,'Terang',4),(9,1,4,'Lentur',5),(10,1,4,'Kaku',3),(11,1,5,'Tebal',5),(12,1,5,'Tipis',3),(13,1,6,'Sangat Murah',5),(14,1,6,'Murah',4),(15,1,6,'Sedang',3),(16,1,6,'Mahal',2),(17,1,6,'Sangat Mahal',1),(19,1,1,'Volley',1);
/*!40000 ALTER TABLE `penilaian` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `penilaian_sepatu`
--

DROP TABLE IF EXISTS `penilaian_sepatu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `penilaian_sepatu` (
  `kd_penilaian` int NOT NULL AUTO_INCREMENT,
  `id_sepatu` int NOT NULL,
  `kd_kriteria` int NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `bobot` int NOT NULL,
  PRIMARY KEY (`kd_penilaian`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `penilaian_sepatu`
--

LOCK TABLES `penilaian_sepatu` WRITE;
/*!40000 ALTER TABLE `penilaian_sepatu` DISABLE KEYS */;
INSERT INTO `penilaian_sepatu` VALUES (1,1,1,'Lari',5),(2,1,2,'Pria',4),(3,1,3,'Gelap',3),(4,1,4,'Lentur',4),(5,1,5,'Tebal',2),(6,1,6,'1500000',5),(7,2,1,'Lari',5),(8,2,2,'Wanita',4),(9,2,3,'Terang',3),(10,2,4,'Lentur',4),(11,2,5,'Tebal',2),(12,2,6,'1800000',5),(13,3,1,'Basket',5),(14,3,2,'Pria',4),(15,3,3,'Gelap',3),(16,3,4,'Kaku',4),(17,3,5,'Tipis',2),(18,3,6,'1400000',5),(19,4,1,'Tenis',5),(20,4,2,'Wanita',4),(21,4,3,'Terang',3),(22,4,4,'Lentur',4),(23,4,5,'Tebal',2),(24,4,6,'1700000',5);
/*!40000 ALTER TABLE `penilaian_sepatu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sepatu`
--

DROP TABLE IF EXISTS `sepatu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sepatu` (
  `id_sepatu` int NOT NULL AUTO_INCREMENT,
  `nama_sepatu` varchar(100) NOT NULL,
  `jenis_olahraga` enum('Lari','Tenis','Volley','Basket') NOT NULL,
  `merk` varchar(50) NOT NULL,
  `gender` enum('Pria','Wanita') NOT NULL,
  `warna` enum('Gelap','Terang') NOT NULL,
  `kelenturan` enum('Kaku','Lentur') NOT NULL,
  `tebal_sol` enum('Tipis','Tebal') NOT NULL,
  `harga` float NOT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_sepatu`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sepatu`
--

LOCK TABLES `sepatu` WRITE;
/*!40000 ALTER TABLE `sepatu` DISABLE KEYS */;
INSERT INTO `sepatu` VALUES (1,'Nike Air Zoom','Lari','Nike','Pria','Gelap','Lentur','Tebal',1500000,'nike_zoom.jpg'),(2,'Adidas Ultraboost','Lari','Adidas','Wanita','Terang','Lentur','Tebal',1800000,'adidas_ultra.jpg'),(3,'Puma Ignite','Basket','Puma','Pria','Gelap','Kaku','Tipis',1400000,'puma_ignite.jpg'),(4,'Asics Gel','Tenis','Asics','Wanita','Terang','Lentur','Tebal',1700000,'asics_gel.jpg'),(5,'Reebok Nano X','Lari','','Pria','Gelap','Kaku','Tipis',1700000,'reebok_nano_x.jpg'),(6,'Under Armour HOVR','Lari','','Pria','Gelap','Kaku','Tipis',1700000,'under_armour_hovr.jpg'),(7,'New Balance 1080','Lari','','Pria','Gelap','Kaku','Tipis',1700000,'new_balance_1080.jpg'),(8,'Mizuno Wave Rider','Lari','','Pria','Gelap','Kaku','Tipis',1700000,'mizuno_wave_rider.jpg');
/*!40000 ALTER TABLE `sepatu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'sepatu_saw'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-05-10 21:42:53
