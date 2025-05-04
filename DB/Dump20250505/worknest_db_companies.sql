-- MySQL dump 10.13  Distrib 8.0.36, for Linux (x86_64)
--
-- Host: localhost    Database: worknest_db
-- ------------------------------------------------------
-- Server version	8.0.41-0ubuntu0.24.10.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `companies`
--

DROP TABLE IF EXISTS `companies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `companies` (
  `company_id` int NOT NULL AUTO_INCREMENT,
  `company_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `industry` varchar(255) DEFAULT NULL,
  `address` text,
  `website` varchar(255) DEFAULT NULL,
  `description` text,
  `why_choose` text,
  `logo_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`company_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `companies`
--

LOCK TABLES `companies` WRITE;
/*!40000 ALTER TABLE `companies` DISABLE KEYS */;
INSERT INTO `companies` VALUES (18,'vigo','vigo@vigo.com','$2y$10$nVwlz3WwP7Ed/Zw.f2wD2ullnrcZXBSI15nqjmzFaTqtI7rsbiOx2','Pentration Testing',NULL,NULL,NULL,NULL,NULL,'2025-05-01 09:53:49','2025-05-01 09:53:49'),(19,'Google','google@google.com','$2y$10$nqdZGL4kx7hRn33lnhLfCOZBe/oWAcB/vu5Y.E7WTiPgwTB6Oz8pi','Software Development','USA','https://www.google.com','Google is one of the largest software development companies in the world. It is known for building massive systems like the Google Search Engine, the Android operating system, and the Google Chrome browser. The company heavily relies on programming languages like C++, Java, and Python to develop its products.','People choose Google because of its fast and accurate search results, user-friendly products like Gmail and Google Maps, and powerful tools for developers such as Android Studio and Google Cloud Platform. Its reliability, innovation, and global infrastructure make it a top choice worldwide.','./uploads/6814c4fadca30_Google_Icons-09-512.webp','2025-05-02 11:54:44','2025-05-02 13:13:30'),(20,'Microsoft','microsoft@microsoft.com','$2y$10$AR2qygwA6cAb0qaiU8P15urBxxT/I5MeDD5GreosMXjquxI77SooK','Software Development','USA','https://www.microsoft.com','At NexaTech Solutions, we are passionate about building powerful, scalable, and user-centric software products that shape the future of digital transformation. Since our founding in 2010, we’ve been committed to innovation, delivering enterprise-grade solutions to clients worldwide.\r\n\r\nOur teams of engineers, designers, and technologists work collaboratively to develop software that solves real-world problems—from cloud-based platforms to intelligent automation systems. Whether it\'s custom application development, SaaS platforms, or AI integration, we bring vision to reality with cutting-edge technology and unmatched expertise.','? Innovation at Core: We embrace the latest technologies to keep your business one step ahead.\r\n?‍? Experienced Talent: Our team brings years of experience in delivering mission-critical software for Fortune 500 companies.\r\n☁️ Cloud-First Approach: We build solutions that are scalable, secure, and optimized for the cloud.\r\n? End-to-End Services: From ideation to deployment and support, we handle the full development lifecycle.\r\n?️ Security & Quality: Every line of code we write is backed by rigorous testing and best security practices.\r\n','./uploads/6814cc2083dc0_Microsoft_Logo_512px.png','2025-05-02 13:37:01','2025-05-02 13:44:00');
/*!40000 ALTER TABLE `companies` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-05-05  1:42:27
