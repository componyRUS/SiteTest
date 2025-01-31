-- MySQL dump 10.13  Distrib 8.0.40, for Linux (x86_64)
--
-- Host: localhost    Database: shop_db
-- ------------------------------------------------------
-- Server version	8.0.40-0ubuntu0.24.04.1

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
-- Table structure for table `Categories`
--

DROP TABLE IF EXISTS `Categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Categories` (
  `CategoryId` int NOT NULL AUTO_INCREMENT,
  `CategoryName` varchar(255) NOT NULL,
  PRIMARY KEY (`CategoryId`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Categories`
--

LOCK TABLES `Categories` WRITE;
/*!40000 ALTER TABLE `Categories` DISABLE KEYS */;
INSERT INTO `Categories` VALUES (1,'Плюшевые игрушки'),(2,'Настольные игры'),(3,'Конструкторы'),(4,'Головоломки');
/*!40000 ALTER TABLE `Categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ProductComments`
--

DROP TABLE IF EXISTS `ProductComments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ProductComments` (
  `CommentId` int NOT NULL AUTO_INCREMENT,
  `ProductId` int NOT NULL,
  `UserId` int NOT NULL,
  `CommentText` text NOT NULL,
  `CommentDate` datetime NOT NULL,
  PRIMARY KEY (`CommentId`),
  KEY `ProductId` (`ProductId`),
  KEY `UserId` (`UserId`),
  CONSTRAINT `ProductComments_ibfk_1` FOREIGN KEY (`ProductId`) REFERENCES `Products` (`ProductId`),
  CONSTRAINT `ProductComments_ibfk_2` FOREIGN KEY (`UserId`) REFERENCES `users` (`Userid`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ProductComments`
--

LOCK TABLES `ProductComments` WRITE;
/*!40000 ALTER TABLE `ProductComments` DISABLE KEYS */;
/*!40000 ALTER TABLE `ProductComments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Products`
--

DROP TABLE IF EXISTS `Products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Products` (
  `ProductId` int NOT NULL AUTO_INCREMENT,
  `CategoryId` int DEFAULT NULL,
  `ProductName` varchar(255) NOT NULL,
  `Price` decimal(10,2) NOT NULL,
  `Description` text,
  `Width` decimal(10,2) DEFAULT NULL,
  `Height` decimal(10,2) DEFAULT NULL,
  `Length` decimal(10,2) DEFAULT NULL,
  `img1` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ProductId`),
  KEY `CategoryId` (`CategoryId`),
  CONSTRAINT `Products_ibfk_1` FOREIGN KEY (`CategoryId`) REFERENCES `Categories` (`CategoryId`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Products`
--

LOCK TABLES `Products` WRITE;
/*!40000 ALTER TABLE `Products` DISABLE KEYS */;
INSERT INTO `Products` VALUES (1,1,'Мишка Тедди',1200.00,'Классический плюшевый мишка. Сделано в Германии!\r\n\r\nВ комплекте: Мой Мишка Тедди Бирли 28 см, с металлической клипсой в ухе и фирменным ярлычком Steiff',25.00,30.00,28.00,'myagkaya-igrushka-steiff-my-bearly-teddy-bear-shtayf-mishka-teddi-korichnevyy-28-sm.jpg'),(2,1,'Кошка в платье в цветок',1200.00,'Серый плюшевый зайчик.',27.00,44.00,23.00,'00000164962.jpeg'),(3,2,'Монополия',1700.00,'Настольная игра \"Моя первая монополия\" – это настольная игра по мотивам оригинальной Монополии, созданной для самых маленьких. Все правила игры упрощены, а фишки сделаны в виде котика, собачки, корабля и машинки. Вы не заметите, как Ваш ребенок легко и быстро научится играть в Монополию.',27.00,4.00,27.00,'00000154432.jpg'),(4,2,'Шахматы',2200.00,'Набор шахмат из дерева.',25.00,25.00,5.00,'00000162300_1.jpeg'),(5,3,'Конструктор LEGO DUPLO Classic Коробка с кубиками',2400.00,'Конструктор LEGO DUPLO Classic 10913 «Коробка с кубиками» вдохновит ваших малышей на творческие подвиги. Знакомые объекты - яркие кубики - стимулируют развитие мыслительного процесса. Прекрасно подойдет в качестве первой игрушки. Этот творческий конструктор еще сильнее объединит вас с детьми. Вращающиеся колеса, кубики с цифрами, фигурки людей, оригинальные детали: дети смогут собирать конструктор, а родители будут наблюдать за процессом и давать советы. Набор LEGO DUPLO Classic подойдет для детей от 1 года и 6 месяцев. Яркие кубики удобно держать в руках: они достаточно большого размера, поэтому безопасны для малышей. Кубики легко разъединять и соединять: дети справятся без помощи родителей.',35.00,30.00,20.00,'00000155270_1.jpg'),(6,4,'Кубик Рубика',500.00,'Классическая головоломка.',6.00,6.00,6.00,'AnyConv.com__06320fa88ae6fe60acbc75c851380104-auto_width_1000.jpeg');
/*!40000 ALTER TABLE `Products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `order_items` (
  `order_item_id` int NOT NULL AUTO_INCREMENT,
  `order_id` int DEFAULT NULL,
  `quantity` int DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`order_item_id`),
  KEY `order_items_ibfk_1` (`order_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_items`
--

LOCK TABLES `order_items` WRITE;
/*!40000 ALTER TABLE `order_items` DISABLE KEYS */;
INSERT INTO `order_items` VALUES (6,11,2,1200.00,'Мишка Тедди'),(7,12,3,1200.00,'Мишка Тедди'),(8,12,2,1500.00,'Монополия'),(9,13,1,2400.00,'Конструктор LEGO DUPLO Classic Коробка с кубиками');
/*!40000 ALTER TABLE `order_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders` (
  `order_id` int NOT NULL AUTO_INCREMENT,
  `order_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('Pending','Shipped','Delivered','Canceled') DEFAULT 'Pending',
  `user_id` int DEFAULT NULL,
  `total_amount` decimal(10,2) DEFAULT NULL,
  `payment_method` enum('upon_receipt') DEFAULT 'upon_receipt',
  `notes` text,
  `ContactNumber` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`order_id`),
  KEY `fk_orders_users` (`user_id`),
  CONSTRAINT `fk_orders_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`Userid`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (12,'2025-01-30 23:16:04','Delivered',10,6600.00,'upon_receipt','Примеч.','777777'),(13,'2025-01-31 06:53:26','Pending',10,2400.00,'upon_receipt','Приду к 12:00','88005553535');
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `Userid` int NOT NULL AUTO_INCREMENT,
  `FIO` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `role` enum('default','admin') NOT NULL DEFAULT 'default',
  PRIMARY KEY (`Userid`),
  UNIQUE KEY `Email` (`Email`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Иванов Иван Иванович','ivan@example.com','secure_password123','default'),(2,'Администратор','admin@mail.ru','admin','admin'),(3,'Test1','test1@test.com','$2y$10$34cCdht4eYbpko84mUcPh.PBUTu4cOgW4KrSsQOQfsHaOR2.zcleO','default'),(4,'Test2','Test2@test.com','$2y$10$kt7EOFuzaPpmp/tkcEi67OWjkjEl.a5pL2qYo9gRNDfNJlNVtoq9q','default'),(5,'Test4','Test4@Test4','$2y$10$sq6d9rsgfcXJDtpZFBETAemlZv1k1ouLMiWM7.Bl30rXqSVF2CJoy','default'),(6,'Test5','Test5@Test5','$2y$10$ErA.8IfOzHRHLEuiZ7Ssx..s7BSFRTndxmhniG5bFJMQttMrlSqwS','default'),(8,'Test7','Test7@Test7','$2y$10$NWyljMVtm..8T/3R135ooen4xEK7hdv64VtzwwKPEVSsbAUb0aTc2','default'),(10,'Test6','Test6@Test6','$2y$10$aHE7zuKArp1ZK90ErXqr5uQh6iZNDMP1JWO6KzUfWlgvd9gGqfFgK','admin');
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

-- Dump completed on 2025-01-31  7:13:11
