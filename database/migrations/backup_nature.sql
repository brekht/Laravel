-- MySQL dump 10.15  Distrib 10.0.36-MariaDB, for debian-linux-gnu (i686)
--
-- Host: localhost    Database: nature
-- ------------------------------------------------------
-- Server version	10.0.36-MariaDB-0ubuntu0.16.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `articles`
--

DROP TABLE IF EXISTS `articles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `articles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_text` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `full_text` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `articles`
--

LOCK TABLES `articles` WRITE;
/*!40000 ALTER TABLE `articles` DISABLE KEYS */;
INSERT INTO `articles` VALUES (1,'Это статья про фрукты','Под фруктами обычно понимают сладкие плоды деревьев и кустарников','Под фруктами обычно понимают сладкие плоды деревьев и кустарников. Фрукты обладают особенной ценностью для организма человека - насыщая его необходимыми витаминами и углеводами.',1,'2018-12-23 07:01:30','2018-12-23 07:01:30'),(2,'Птички','Птицы - группа теплокровных позвоночных животных, традиционно рассматриваемая в ранге отдельного класса','Птицы - группа теплокровных позвоночных животных, традиционно рассматриваемая в ранге отдельного класса. Птицы - это одна из шести основных групп животных, наряду с рептилиями, млекопитающими, земноводными, рыбами и беспозвоночными. Птицы имеют отличительные признаки, включая их перья и способность летать (у большинства видов). Наша планета является домом для более 10 000 известных видов птиц.',1,'2018-12-23 07:01:30','2018-12-23 07:01:30'),(3,'Space article','Космическое пространство, космос - относительно пустые участки Вселенной, которые лежат вне границ атмосфер небесных тел','Космическое пространство, космос - относительно пустые участки Вселенной, которые лежат вне границ атмосфер небесных тел. Вопреки распространённым представлениям, космос не является абсолютно пустым пространством: в нём есть, хотя и с очень низкой плотностью, межзвёздное вещество (преимущественно молекулы водорода), кислород в малых количествах (остаток после взрыва звезды), космические лучи и электромагнитное излучение, а также гипотетическая тёмная материя.',1,'2018-12-23 07:01:30','2018-12-23 07:01:30'),(4,'Мы любим кофе','Горький кофе или негорький - это вопрос вкусов, о которых, как известно, не спорят','Горький кофе или негорький - это вопрос вкусов, о которых, как известно, не спорят. Кофе должен быть качественным. Это главное условие. Если говорить о напитках, то по популярности пальму первенства уверенно держит капучино.',2,'2018-12-23 07:01:30','2018-12-23 07:01:30'),(5,'Любительская фотография - как хобби','Любительская фотография - фотографии, сделанные фотолюбителями или неизвестными фотографами-профессионалами','Любительская фотография - фотографии, сделанные фотолюбителями или неизвестными фотографами-профессионалами, на которых запечатлен быт и повседневные вещи в качестве субъектов. Примерами любительской фотографии являются фотоальбомы путешествий и отпускные фотографии, семейные снимки, фотографии друзей.',3,'2018-12-23 07:01:30','2018-12-23 07:01:30'),(6,'А это статья про кошек и птиц','Данная статья не особо увлекательна,  ...','Данная статья не особо увлекательна,  ... странно что меня не заблокировали)',4,'2018-12-23 07:01:30','2018-12-23 07:01:30');
/*!40000 ALTER TABLE `articles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `desc` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'Fruits','This is Fruits Category',1,'2018-12-23 07:01:29','2018-12-23 07:01:29'),(2,'Space','Category of Space',1,'2018-12-23 07:01:30','2018-12-23 07:01:30'),(3,'Cats','Cats Category',1,'2018-12-23 07:01:30','2018-12-23 07:01:30'),(4,'Birds','Birds category',1,'2018-12-23 07:01:30','2018-12-23 07:01:30'),(5,'Coffee','Категория про Кофе',2,'2018-12-23 07:01:30','2018-12-23 07:01:30'),(6,'Хобби','Категория Хобби',3,'2018-12-23 07:01:30','2018-12-23 07:01:30');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `category_articles`
--

DROP TABLE IF EXISTS `category_articles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `category_articles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` int(10) unsigned NOT NULL,
  `article_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `category_articles_category_id_foreign` (`category_id`),
  KEY `category_articles_article_id_foreign` (`article_id`),
  CONSTRAINT `category_articles_article_id_foreign` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`) ON DELETE CASCADE,
  CONSTRAINT `category_articles_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category_articles`
--

LOCK TABLES `category_articles` WRITE;
/*!40000 ALTER TABLE `category_articles` DISABLE KEYS */;
INSERT INTO `category_articles` VALUES (1,1,1,'2018-12-23 07:01:30','2018-12-23 07:01:30'),(2,5,4,'2018-12-23 07:01:30','2018-12-23 07:01:30'),(3,6,5,'2018-12-23 07:01:30','2018-12-23 07:01:30'),(4,3,6,'2018-12-23 07:01:30','2018-12-23 07:01:30'),(5,4,6,'2018-12-23 07:01:30','2018-12-23 07:01:30'),(6,2,3,'2018-12-23 07:01:30','2018-12-23 07:01:30'),(7,4,2,'2018-12-23 07:01:30','2018-12-23 07:01:30');
/*!40000 ALTER TABLE `category_articles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `comment` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `article_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `comments_article_id_foreign` (`article_id`),
  KEY `comments_user_id_foreign` (`user_id`),
  CONSTRAINT `comments_article_id_foreign` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`) ON DELETE CASCADE,
  CONSTRAINT `comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
INSERT INTO `comments` VALUES (1,1,'Уважаемый автор mike@mike.com - вас уже заблокировали!',6,1,'2018-12-23 07:01:30','2018-12-23 07:01:30'),(2,1,'Правильно, будет знать',6,2,'2018-12-23 07:01:30','2018-12-23 07:01:30'),(3,1,'Скажите, кто нибудь знает классический рецепт Американо с молоком?',4,2,'2018-12-23 07:01:30','2018-12-23 07:01:30'),(4,1,'Нeoбхoдимo cвapить эcпpecco, paзбaвить eгo вoдoй один к трём, a зaтeм дoбaвить в пopцию мoлoкa',4,3,'2018-12-23 07:01:30','2018-12-23 07:01:30'),(5,0,'Птички - они такие смешные',2,3,'2018-12-23 07:01:30','2018-12-23 07:01:30');
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `desc_property`
--

DROP TABLE IF EXISTS `desc_property`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `desc_property` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `desc` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `essences_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `first_author` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `desc_property_essences_id_unique` (`essences_id`),
  CONSTRAINT `desc_property_essences_id_foreign` FOREIGN KEY (`essences_id`) REFERENCES `essences` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `desc_property`
--

LOCK TABLES `desc_property` WRITE;
/*!40000 ALTER TABLE `desc_property` DISABLE KEYS */;
INSERT INTO `desc_property` VALUES (1,'Это Cвойство \'Описание\', и его Значение - собственно само описание свойства',1,1,1,'2018-12-23 07:01:31','2018-12-23 07:01:31'),(2,'сладкие плоды деревьев и кустарников',3,2,2,'2018-12-23 07:01:31','2018-12-23 07:01:31');
/*!40000 ALTER TABLE `desc_property` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `essences`
--

DROP TABLE IF EXISTS `essences`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `essences` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `first_author` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `essences_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `essences`
--

LOCK TABLES `essences` WRITE;
/*!40000 ALTER TABLE `essences` DISABLE KEYS */;
INSERT INTO `essences` VALUES (1,'Cats',1,1,'2018-12-23 07:01:30','2018-12-23 07:01:30'),(2,'Birds',3,3,'2018-12-23 07:01:30','2018-12-23 07:01:30'),(3,'Fruits (tropic)',1,2,'2018-12-23 07:01:30','2018-12-23 07:01:30'),(4,'Colors',1,1,'2018-12-23 07:01:31','2018-12-23 07:01:31');
/*!40000 ALTER TABLE `essences` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `freeproperties`
--

DROP TABLE IF EXISTS `freeproperties`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `freeproperties` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `col_prop` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `col_desc` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `essences_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `first_author` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `freeproperties_essences_id_foreign` (`essences_id`),
  CONSTRAINT `freeproperties_essences_id_foreign` FOREIGN KEY (`essences_id`) REFERENCES `essences` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `freeproperties`
--

LOCK TABLES `freeproperties` WRITE;
/*!40000 ALTER TABLE `freeproperties` DISABLE KEYS */;
INSERT INTO `freeproperties` VALUES (1,'Окрас','чепрачный',1,1,1,'2018-12-23 07:01:31','2018-12-23 07:01:31'),(2,'Группа здоровья','Fat Cats',1,1,1,'2018-12-23 07:01:31','2018-12-23 07:01:31'),(3,'Вес','до 3 кг',1,1,1,'2018-12-23 07:01:31','2018-12-23 07:01:31'),(4,'Описание породы','европейская короткошерстная',1,1,1,'2018-12-23 07:01:31','2018-12-23 07:01:31'),(5,'Type','tropic',3,1,2,'2018-12-23 07:01:31','2018-12-23 07:01:31');
/*!40000 ALTER TABLE `freeproperties` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `img_property`
--

DROP TABLE IF EXISTS `img_property`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `img_property` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `img` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `essences_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `first_author` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `img_property_img_unique` (`img`),
  UNIQUE KEY `img_property_essences_id_unique` (`essences_id`),
  CONSTRAINT `img_property_essences_id_foreign` FOREIGN KEY (`essences_id`) REFERENCES `essences` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `img_property`
--

LOCK TABLES `img_property` WRITE;
/*!40000 ALTER TABLE `img_property` DISABLE KEYS */;
INSERT INTO `img_property` VALUES (1,'wzwq503axq4k03os7cvptkgdz.jpeg',1,1,1,'2018-12-23 07:01:31','2018-12-23 07:01:31'),(2,'w82iqhddgt9w3yhlqxptfsc7z.jpg',2,3,3,'2018-12-23 07:01:31','2018-12-23 07:01:31');
/*!40000 ALTER TABLE `img_property` ENABLE KEYS */;
UNLOCK TABLES;


-- # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #
--
-- Table structure for table `migrations`
--

--DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
--CREATE TABLE `migrations` (
--  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
--  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
--  `batch` int(11) NOT NULL,
--  PRIMARY KEY (`id`)
--) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

--LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
--INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_resets_table',1),(3,'2018_12_01_100001_create_essences_table',1),(4,'2018_12_01_100002_create_num_property_table',1),(5,'2018_12_01_100003_create_desc_property_table',1),(6,'2018_12_01_100004_create_img_property_table',1),(7,'2018_12_01_100005_create_freeproperties_table',1),(8,'2018_12_01_200001_create_categories_table',1),(9,'2018_12_01_200002_create_articles_table',1),(10,'2018_12_01_200003_create_category_articles_table',1),(11,'2018_12_01_200004_create_comments_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
--UNLOCK TABLES;
-- # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #

--
-- Table structure for table `num_property`
--

DROP TABLE IF EXISTS `num_property`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `num_property` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `num` smallint(5) unsigned NOT NULL,
  `essences_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `first_author` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `num_property_essences_id_unique` (`essences_id`),
  CONSTRAINT `num_property_essences_id_foreign` FOREIGN KEY (`essences_id`) REFERENCES `essences` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `num_property`
--

LOCK TABLES `num_property` WRITE;
/*!40000 ALTER TABLE `num_property` DISABLE KEYS */;
INSERT INTO `num_property` VALUES (1,25,1,1,1,'2018-12-23 07:01:31','2018-12-23 07:01:31');
/*!40000 ALTER TABLE `num_property` ENABLE KEYS */;
UNLOCK TABLES;

-- # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #
--
-- Table structure for table `password_resets`
--

--DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
--CREATE TABLE `password_resets` (
--  `email` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
--  `token` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
--  `created_at` timestamp NULL DEFAULT NULL,
--  KEY `password_resets_email_index` (`email`)
--) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

--LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
--UNLOCK TABLES;
-- # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `isAdmin` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `root` tinyint(3) unsigned DEFAULT NULL,
  `isConfirm` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'al@al.com','$2y$10$MDwZDCB5N9QXaH4LQ2VnJuGPXURLzmM1kv6dTJxSq1geC.mMv.ajm',1,1,1,'xj8ArQjzgY8CPKW8EEbgyaG7x0ueD1rH3CrmvCYaWmjkmlXSE03gZQtIeGkG','2018-12-23 07:01:29','2018-12-23 07:01:29'),(2,'lara@lara.com','$2y$10$dmKZmiSh2CP25DLVHyWuzO3ITx6dFZ6rGiO8GsxR9CPx8AhdHh/AS',1,NULL,1,'4Uq6KCs5davNeFNvRbR7cILerOuvmSnRpmLgbWkIcylhzEnYxHL2kNpQwdjs','2018-12-23 07:01:29','2018-12-23 07:01:29'),(3,'john@john.com','$2y$10$gsjFf2FzrSTOY9jgdFayZeWZvwt0HMw6h5NZwLyyXB3mwpVb4dLim',0,NULL,1,'qvqO6bAox8Jefov4h5D2dCbsTujfBWDu8AW0baCLcsOyd7iDv4kaqY0agIYc','2018-12-23 07:01:29','2018-12-23 07:01:29'),(4,'mike@mike.com','$2y$10$CEdQCTJS7AfYc86qK7t6SeTUSaKEFH31JNnwgSKSBJd9IOhbZuCxK',0,NULL,0,'7llFWq5wXC2tXYwbLhXf9CAB7BkXAJyZGvxuwSTEHoU1iXfl9um5G7Mnkc6x','2018-12-23 07:01:29','2018-12-23 07:01:29');
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

-- Dump completed on 2018-12-23 17:06:30
