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
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `job_id` int NOT NULL AUTO_INCREMENT,
  `company_id` int NOT NULL,
  `category_id` int DEFAULT NULL,
  `title` varchar(100) NOT NULL,
  `description` text,
  `requirements` text,
  `location` varchar(100) DEFAULT NULL,
  `employment_type` enum('Full-Time','Part-Time','Contract','Internship') NOT NULL,
  `status` enum('Open','Closed','Draft') DEFAULT 'Open',
  `posted_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `receive_application_method` varchar(255) DEFAULT NULL,
  `receive_application_email` varchar(255) DEFAULT NULL,
  `salary` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`job_id`),
  KEY `company_id` (`company_id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `jobs_ibfk_1` FOREIGN KEY (`company_id`) REFERENCES `companies` (`company_id`) ON DELETE CASCADE,
  CONSTRAINT `jobs_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON DELETE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
INSERT INTO `jobs` VALUES (27,18,1,'Penteration Testing','CyberSecure Labs is seeking a highly skilled and motivated Web Penetration Tester to assess and strengthen the security of our web applications. You will be responsible for simulating real-world attacks, identifying vulnerabilities, and working closely with developers to mitigate risks.\r\n\r\nYou will use both manual and automated techniques to assess systems and provide clear, actionable reports. This role is ideal for someone passionate about ethical hacking, cybersecurity, and staying up-to-date with the latest web threats.\r\n\r\n','Conduct penetration testing on web applications and APIs.\r\n\r\nIdentify and exploit vulnerabilities (XSS, SQLi, CSRF, IDOR, etc.).\r\n\r\nPerform manual testing beyond automated scanner results.\r\n\r\nGenerate detailed security reports and remediation guidance.\r\n\r\nWork with development teams to fix and validate vulnerabilities.\r\n\r\nStay current on security trends, CVEs, and new exploits.\r\n\r\n','Remotly','Contract','Closed','2025-05-01 10:34:57','2025-05-01 10:35:47','email','vigo@gmail.com','$9,000  -  $12,000'),(28,18,1,'Backend Developer','Description','Req','Remotly','Part-Time','Open','2025-05-01 11:40:21','2025-05-01 11:40:21','email','google@google.com','$9,000  -  $12,000'),(29,18,1,'Frontend Developer','job','job','Remotly','Contract','Open','2025-05-01 11:40:47','2025-05-01 11:40:47','email','vigo@gmail.com','$4,000  -  $6,000'),(30,18,1,'IOS Developer','Dddd','Rrrr','US','Part-Time','Open','2025-05-01 11:41:16','2025-05-01 11:41:16','email','vigo@gmail.com','$8,000  -  $10,000'),(31,18,1,'Flutter Developer','DDDDDDDDhhhh','Hkkkkkkkkkkkkkkk','Remotly','Internship','Open','2025-05-01 11:41:47','2025-05-01 11:41:47','email','google@google.com','$4,000  -  $6,000'),(32,19,1,'Frontend Enginner','As a Front-End Engineer, you will be responsible for building and maintaining the user-facing parts of web applications. You will collaborate with designers, back-end developers, and product managers to create responsive, accessible, and efficient interfaces that deliver a great user experience.','- Proficient in HTML5, CSS3, and JavaScript (ES6+).\r\n- Experience with front-end frameworks (e.g., React, Angular, Vue).\r\n- Familiarity with version control systems like Git.\r\n- Understanding of responsive design and cross-browser compatibility.\r\n- Knowledge of RESTful APIs and how to integrate them.\r\n- Good problem-solving skills and attention to detail.\r\n- Bachelor\'s degree in Computer Science or related field (preferred, not always required).\r\n- Bonus: Experience with testing tools (Jest, Cypress), performance optimization, or working with back-end technologies.','US','Contract','Open','2025-05-02 12:25:42','2025-05-02 12:25:42','external_web','google@google.com','$4,000  -  $6,000'),(33,19,1,'Backend Developer (PHP / Node.js)','Responsible for developing and maintaining the server-side logic of web applications, ensuring high performance and responsiveness to requests from the front-end.\r\n\r\n','Proficient in PHP or Node.js.\r\nKnowledge of databases (MySQL, PostgreSQL).\r\nExperience with REST APIs and authentication (JWT, OAuth).\r\nFamiliarity with MVC architecture.\r\nUnderstanding of security and data protection.','Remotly','Contract','Open','2025-05-02 13:17:23','2025-05-02 13:17:23','external_web','google@google.com','$9,000  -  $12,000'),(34,19,1,'Cybersecurity Analyst','You’ll monitor and protect systems, networks, and data from cyber attacks. You will analyze security risks, investigate incidents, and implement protective measures.','Strong understanding of network protocols and firewalls.\r\nFamiliarity with vulnerability assessment tools.\r\nKnowledge of penetration testing basics.\r\nUnderstanding of Linux and Windows security.\r\nCertifications like CompTIA Security+ or CEH are a plus.','US','Contract','Open','2025-05-02 13:18:25','2025-05-02 13:18:25','external_web','google@google.com','$8,000  -  $10,000'),(35,19,1,'DevOps Engineer','You\'ll be responsible for automating, deploying, and maintaining applications and systems. Work with CI/CD pipelines and cloud services to ensure smooth development and deployment processes.','Experience with CI/CD tools like Jenkins, GitLab CI.\r\nKnowledge of containerization (Docker, Kubernetes).\r\nFamiliarity with cloud platforms (AWS, Azure, GCP).\r\nScripting (Bash, Python).\r\nStrong system administration skills (Linux/Unix).','US','Contract','Open','2025-05-02 13:19:35','2025-05-02 13:19:35','external_web','google@google.com','$8,000  -  $10,000'),(36,20,1,'IT Support Specialist','Provide technical assistance to users, troubleshoot hardware and software issues, and maintain IT systems and infrastructure.','Good understanding of computer hardware, operating systems (Windows, Linux).\r\nBasic networking knowledge.\r\nStrong communication skills.\r\nProblem-solving attitude.\r\nExperience with helpdesk software is a plus.','USA','Full-Time','Open','2025-05-02 13:38:32','2025-05-02 13:38:32','external_web','microsoft@microsoft.com','$4,000  -  $6,000'),(37,20,1,'Machine Learning Engineer','You will build and train machine learning models using large datasets. Collaborate with data scientists to develop intelligent systems for prediction, classification, or recommendation.','Strong knowledge of Python and libraries like TensorFlow, PyTorch, or Scikit-learn.\r\nUnderstanding of algorithms and statistics.\r\nExperience with data preprocessing and model evaluation.\r\nKnowledge of cloud ML services (e.g., AWS SageMaker).\r\nDegree in Computer Science, Data Science, or related field.','Remotly','Contract','Closed','2025-05-02 13:40:40','2025-05-02 19:34:55','external_web','microsoft@microsoft.com','$9,000  -  $12,000'),(38,20,1,'Mobile App Developer (Android/iOS)','Develop, test, and maintain mobile applications for Android or iOS platforms. Ensure performance, usability, and consistency across different devices.','Experience with Kotlin/Java for Android or Swift for iOS.\r\nFamiliarity with mobile UI/UX standards.\r\nKnowledge of REST APIs and third-party SDKs.\r\nUnderstanding of app deployment on Google Play/App Store.\r\nDebugging and performance optimization skills.','USA','Part-Time','Open','2025-05-02 13:41:35','2025-05-02 13:41:35','external_web','microsoft@microsoft.com','$4,000  -  $6,000');
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
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
