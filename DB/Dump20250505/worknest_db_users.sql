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
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text,
  `date_of_birth` date DEFAULT NULL,
  `gender` enum('Male','Female','Other') DEFAULT NULL,
  `profile_picture_url` varchar(255) DEFAULT NULL,
  `resume_url` varchar(255) DEFAULT NULL,
  `linkedin_url` varchar(255) DEFAULT NULL,
  `github_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `job_title` varchar(100) DEFAULT NULL,
  `about` text,
  `bio` varchar(255) DEFAULT NULL,
  `job_status` enum('Employed','Looking for job') DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (13,'tarek@gmail.com','$2y$10$VBpY74tkZuoTB8eHAkpB3u3y4WkbVuI/2rcOiQGpHD6ceBqme92n2','Tarek Ashraf',NULL,'Street 1','2025-05-17','Male','./uploads/68134215936f0_shapeImage1.png','./uploads/68134215937a2_Bank of Questions.pdf','https://linkedin.com/tarek','https://github.com/tarek','2025-05-01 09:42:45','2025-05-01 09:42:45','Penteration Tester','I\'m Tarek Ashraf, a passionate Penetration Tester with a strong focus on web and network security. I specialize in discovering vulnerabilities before attackers do, using tools like Burp Suite, Nmap, and Metasploit, alongside custom scripts.\r\n\r\nI have hands-on experience in ethical hacking, vulnerability assessment, and security reporting. I\'m continuously learning and currently preparing for the OSCP certification.\r\n\r\nSecurity isn’t just my job — it’s how I think.\r\n\r\n',NULL,NULL),(14,'1tarek@gmail.com','$2y$10$rf.O8Mc.eyvboNK5gUlmt.IaagqbUPsQKjX0IgOhM1dp2iKYp6J4C','Tarek Ashraf',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-05-02 19:27:05','2025-05-02 19:27:05','Backend Developer',NULL,NULL,NULL),(15,'mohamed@gmail.com','$2y$10$pl1KC.MMaw3uLMAPIqylP.q0xEjs9aKMxsaWYrmT34koAxtTL3plW','Mohamed Ahmed',NULL,'','2025-05-02','Other','./uploads/68151d42ae6a8_shapeImage1.png','./uploads/68151d42ae84f_kerls.pdf','','','2025-05-02 19:30:10','2025-05-02 19:30:10','Frontend Developer','',NULL,NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
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
