-- MySQL dump 10.13  Distrib 8.0.19, for Win64 (x86_64)
--
-- Host: localhost    Database: films_index
-- ------------------------------------------------------
-- Server version	8.0.19

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
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `category` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(45) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category`
--

LOCK TABLES `category` WRITE;
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
INSERT INTO `category` VALUES (1,'Новинки'),(2,'Фильмы'),(3,'Сериалы'),(4,'Рекомендуем'),(5,'Семейные'),(6,'Мультфильмы'),(7,'Классика');
/*!40000 ALTER TABLE `category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `category_list`
--

DROP TABLE IF EXISTS `category_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `category_list` (
  `film_id` int NOT NULL,
  `category_id` int NOT NULL,
  PRIMARY KEY (`film_id`,`category_id`),
  KEY `fk_category_id_idx` (`category_id`),
  CONSTRAINT `fk_category_id` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_flim_id` FOREIGN KEY (`film_id`) REFERENCES `film` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category_list`
--

LOCK TABLES `category_list` WRITE;
/*!40000 ALTER TABLE `category_list` DISABLE KEYS */;
INSERT INTO `category_list` VALUES (5,1),(6,1),(10,1),(11,1),(12,1),(13,1),(1,2),(2,2),(6,2),(7,2),(8,2),(9,2),(12,2),(13,2),(5,3),(10,3),(2,4),(6,4),(9,4),(10,4),(5,5),(11,5),(5,6),(10,6),(11,6),(2,7),(7,7),(8,7),(10,7);
/*!40000 ALTER TABLE `category_list` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `client`
--

DROP TABLE IF EXISTS `client`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `client` (
  `id` int NOT NULL AUTO_INCREMENT,
  `client_name` varchar(128) NOT NULL,
  `address` longtext NOT NULL,
  `phone` bigint NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `client`
--

LOCK TABLES `client` WRITE;
/*!40000 ALTER TABLE `client` DISABLE KEYS */;
INSERT INTO `client` VALUES (1,'Константин','Братьев Кашириных 101а, 74',89517958956),(2,'Константин','ПЦпцупру',89517958956);
/*!40000 ALTER TABLE `client` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `country`
--

DROP TABLE IF EXISTS `country`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `country` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(45) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `country`
--

LOCK TABLES `country` WRITE;
/*!40000 ALTER TABLE `country` DISABLE KEYS */;
INSERT INTO `country` VALUES (6,'Грузия'),(3,'Индия'),(7,'Испания'),(1,'Казахстан'),(5,'Канада'),(2,'Россия'),(4,'США');
/*!40000 ALTER TABLE `country` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `film`
--

DROP TABLE IF EXISTS `film`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `film` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(128) NOT NULL,
  `country_id` int NOT NULL,
  `release` int NOT NULL,
  `rate` tinyint NOT NULL,
  `discription` text NOT NULL,
  `trailer` text NOT NULL,
  `director` text NOT NULL,
  `role` text NOT NULL,
  `price` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_UNIQUE` (`title`),
  KEY `fk_country_idx` (`country_id`),
  CONSTRAINT `fk_country_id` FOREIGN KEY (`country_id`) REFERENCES `country` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `film`
--

LOCK TABLES `film` WRITE;
/*!40000 ALTER TABLE `film` DISABLE KEYS */;
INSERT INTO `film` VALUES (1,'Ледокол',1,2016,12,'Основано на реальных событиях. 1985 год. Навстречу ледоколу «Михаил Громов» движется огромный айсберг. Уходя от столкновения с ним, судно попадает в ледовый плен и оказывается в вынужденном дрейфе вблизи побережья Антарктиды. Вокруг зловещая тишина и жуткий холод. Горючее на исходе… Нервы на пределе… И даже если можно было бы уйти — деваться все равно некуда. У командования ледокола нет права на ошибку. Одно неверное решение — и тяжелые льды раздавят судно…','LIA98S3ajhY','Николай Хомерики','Пётр Фёдоров,\r\nСергей Пускепалис,\r\nАнна Михалкова,\r\nОльга Филимонова,\r\nАлександр Яценко,\r\nАлександр Паль,\r\nВиталий Хаев',1000),(2,'Аватар',4,2009,12,'Джейк Салли — бывший морской пехотинец, прикованный к инвалидному креслу. Несмотря на немощное тело, Джейк в душе по-прежнему остается воином. Он получает задание совершить путешествие в несколько световых лет к базе землян на планете Пандора, где корпорации добывают редкий минерал, имеющий огромное значение для выхода Земли из энергетического кризиса.','4HFlPcX2HFo','Джеймс Кэмерон','Сэм Уортингтон,\r\nЗои Салдана,\r\nСигурни Уивер,\r\nСтивен Лэнг,\r\nМишель Родригес,\r\nДжованни Рибизи',590),(5,'Смешарики. Новый сезон',2,2020,0,'Истории о дружбе и приключениях обаятельных круглых героев. Весёлые и музыкальные, неожиданные и мечтательные, домашние и авантюрные. Целый мир в одной уютной ромашковой долине.','FnYb6kF-vNQ','Денис Чернов, Алексей Горбунов, Александра Аверьянова','Салават Шайхинуров, Лариса Половикова, Оксана Осипова',680),(6,'Мстители: Финал',4,2019,16,'Оставшиеся в живых члены команды Мстителей и их союзники должны разработать новый план, который поможет противостоять разрушительным действиям могущественного титана Таноса. После наиболее масштабной и трагической битвы в истории они не могут допустить ошибку.','gbcVZgO4n4E','Джо Руссо, Энтони Руссо','Роберт Дауни мл.,\r\nКрис Эванс,\r\nМарк Руффало,\r\nКрис Хемсворт,\r\nСкарлетт Йоханссон,\r\nДжереми Реннер,\r\nДон Чидл,\r\nПол Радд,\r\nБри Ларсон,\r\nКарен Гиллан',1650),(7,'Побег из Шоушенка',4,1994,16,'Бухгалтер Энди Дюфрейн обвинён в убийстве собственной жены и её любовника. Оказавшись в тюрьме под названием Шоушенк, он сталкивается с жестокостью и беззаконием, царящими по обе стороны решётки. Каждый, кто попадает в эти стены, становится их рабом до конца жизни. Но Энди, обладающий живым умом и доброй душой, находит подход как к заключённым, так и к охранникам, добиваясь их особого к себе расположения.','kgAeKpAPOYk','Фрэнк Дарабонт','Тим Роббинс,\r\nМорган Фриман,\r\nБоб Гантон,\r\nУильям Сэдлер,\r\nКлэнси Браун,\r\nДжил Беллоуз,\r\nМарк Ролстон,\r\nДжеймс Уитмор,\r\nДжеффри ДеМанн,\r\nЛарри Бранденбург',680),(8,'Форрест Гамп',4,1994,12,'От лица главного героя Форреста Гампа, слабоумного безобидного человека с благородным и открытым сердцем, рассказывается история его необыкновенной жизни.\r\nФантастическим образом превращается он в известного футболиста, героя войны, преуспевающего бизнесмена. Он становится миллиардером, но остается таким же бесхитростным, глупым и добрым. Форреста ждет постоянный успех во всем, а он любит девочку, с которой дружил в детстве, но взаимность приходит слишком поздно.','otmeAaifX04','Роберт Земекис','Том Хэнкс,\r\nРобин Райт,\r\nСалли Филд,\r\nГэри Синиз,\r\nМайкелти Уильямсон,\r\nМайкл Коннер Хэмпфри,\r\nХанна Р. Холл,\r\nСэм Андерсон,\r\nШиван Фэллон,\r\nРебекка Уильямс',680),(9,'Начало ',4,2010,12,'&nbsp;&nbsp;Кобб — талантливый вор, лучший из лучших в опасном искусстве извлечения: он крадет ценные секреты из глубин подсознания во время сна, когда человеческий разум наиболее уязвим. Редкие способности Кобба сделали его ценным игроком в привычном к предательству мире промышленного шпионажа, но они же превратили его в извечного беглеца и лишили всего, что он когда-либо любил.<br>\r\n&nbsp;&nbsp;И вот у Кобба появляется шанс исправить ошибки. Его последнее дело может вернуть все назад, но для этого ему нужно совершить невозможное — инициацию. Вместо идеальной кражи Кобб и его команда спецов должны будут провернуть обратное. Теперь их задача — не украсть идею, а внедрить ее. Если у них получится, это и станет идеальным преступлением.<br>\r\n&nbsp;&nbsp;Но никакое планирование или мастерство не могут подготовить команду к встрече с опасным противником, который, кажется, предугадывает каждый их ход. Врагом, увидеть которого мог бы лишь Кобб','85Zz1CCXyDI','Кристофер Нолан','Леонардо ДиКаприо,\r\nДжозеф Гордон-Левитт,\r\nЭллен Пейдж,\r\nТом Харди,\r\nКэн Ватанабэ,\r\nДилип Рао,\r\nКиллиан Мёрфи,\r\nТом Беренджер,\r\nМарион Котийяр,\r\nПит Постлетуэйт',780),(10,'Рик и Морти (5 сезон)',4,2019,18,'В центре сюжета - школьник по имени Морти и его дедушка Рик. Морти - самый обычный мальчик, который ничем не отличается от своих сверстников. А вот его дедуля занимается необычными научными исследованиями и зачастую полностью неадекватен. Он может в любое время дня и ночи схватить внука и отправиться вместе с ним в безумные приключения с помощью построенной из разного хлама летающей тарелки, которая способна перемещаться сквозь межпространственный тоннель. Каждый раз эта парочка оказывается в самых неожиданных местах и самых нелепых ситуациях.','FnF0Eh0tGHE','Уэсли Арчер, Пит Мишелс, Брайан Ньютон','Сыендук',1300),(11,'Клаус',7,2019,0,'\r\nВладелец почтовой империи, чтобы научить ленивого отпрыска по имени Джеспер уму-разуму, отправляет его на крайний север в город Смиренсбург. Тот должен организовать там почтовое отделение и за год обработать не менее 6000 писем. Прибыв на место, парень оказывается в зоне боевых действий: два семейных клана, так уж исторически сложилось, питают взаимную ненависть и свято чтут многовековую традицию при любой возможности мутузить друг друга и делать пакости. Разумеется, в такой обстановке не до писем, и почтовое отделение давно превратилось в курятник. Уже практически отчаявшись, Джеспер посещает лесного отшельника по имени Клаус, и их знакомство положит начало удивительным событиям.','6ntdmScyBDM','Серхио Паблос, Карлос Мартинес Лопес','Джейсон Шварцман,\r\nДж.К. Симмонс,\r\nДжоан Кьюсак,\r\nРашида Джонс,\r\nУилл Сассо,\r\nНеда Маргрете Лабба,\r\nСерхио Паблос,\r\nНорм МакДональд,\r\nИвэн Агос,\r\nСкай Алексис',980),(12,'Джокер',4,2019,18,'Готэм, начало 1980-х годов. Комик Артур Флек живет с больной матерью, которая с детства учит его «ходить с улыбкой». Пытаясь нести в мир хорошее и дарить людям радость, Артур сталкивается с человеческой жестокостью и постепенно приходит к выводу, что этот мир получит от него не добрую улыбку, а ухмылку злодея Джокера.','50IJyz7ecqc','Тодд Филлипс','Хоакин Феникс,\r\nРоберт Де Ниро,\r\nЗази Битц,\r\nФрэнсис Конрой,\r\nБретт Каллен,\r\nШей Уигэм,\r\nБилл Кэмп,\r\nГленн Флешлер,\r\nЛи Гилл,\r\nДжош Пэйс',150),(13,'Джентльмены',4,2020,18,'Один ушлый американец ещё со студенческих лет приторговывал наркотиками, а теперь придумал схему нелегального обогащения с использованием поместий обедневшей английской аристократии и очень неплохо на этом разбогател. Другой пронырливый журналист приходит к Рэю, правой руке американца, и предлагает тому купить киносценарий, в котором подробно описаны преступления его босса при участии других представителей лондонского криминального мира — партнёра-еврея, китайской диаспоры, чернокожих спортсменов и даже русского олигарха.','dABPCMxu074','Гай Ричи','Мэттью МакКонахи,\r\nЧарли Ханнэм,\r\nГенри Голдинг,\r\nХью Грант,\r\nМишель Докери,\r\nДжереми Стронг,\r\nЭдди Марсан,\r\nДжейсон Вонг,\r\nКолин Фаррелл,\r\nЛайн Рени',850);
/*!40000 ALTER TABLE `film` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `genre`
--

DROP TABLE IF EXISTS `genre`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `genre` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `genre`
--

LOCK TABLES `genre` WRITE;
/*!40000 ALTER TABLE `genre` DISABLE KEYS */;
INSERT INTO `genre` VALUES (1,'анимация'),(2,'аниме'),(3,'балет'),(4,'биография'),(5,'боевик'),(6,'вестерн'),(7,'военный'),(8,'детектив'),(9,'детский'),(10,'документальный'),(11,'драма'),(12,'исторический'),(13,'комедия'),(14,'концерт'),(15,'короткометражный'),(16,'криминал'),(17,'мелодрама'),(18,'мистика'),(19,'мюзикл'),(20,'приключения'),(21,'сборник'),(22,'семейный'),(23,'сериал'),(24,'сказка'),(25,'спорт'),(26,'триллер'),(27,'ужасы'),(28,'фантастика'),(29,'фэнтези');
/*!40000 ALTER TABLE `genre` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `genre_list`
--

DROP TABLE IF EXISTS `genre_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `genre_list` (
  `film_id` int NOT NULL,
  `genre_id` int NOT NULL,
  PRIMARY KEY (`film_id`,`genre_id`),
  KEY `fk_genre_id_idx` (`genre_id`),
  CONSTRAINT `fk_film_id` FOREIGN KEY (`film_id`) REFERENCES `film` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_genre_id` FOREIGN KEY (`genre_id`) REFERENCES `genre` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `genre_list`
--

LOCK TABLES `genre_list` WRITE;
/*!40000 ALTER TABLE `genre_list` DISABLE KEYS */;
INSERT INTO `genre_list` VALUES (5,1),(10,1),(11,1),(2,5),(6,5),(9,5),(2,7),(8,7),(9,8),(1,11),(6,11),(7,11),(8,11),(9,11),(12,11),(8,12),(8,13),(10,13),(11,13),(12,16),(8,17),(6,20),(10,20),(11,20),(10,21),(5,22),(11,22),(5,23),(10,23),(9,26),(12,26),(6,28),(9,28),(10,28);
/*!40000 ALTER TABLE `genre_list` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order`
--

DROP TABLE IF EXISTS `order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `order` (
  `id` int NOT NULL AUTO_INCREMENT,
  `client_id` int NOT NULL,
  PRIMARY KEY (`id`,`client_id`),
  KEY `fk_client_id_idx` (`client_id`),
  CONSTRAINT `fk_client_id` FOREIGN KEY (`client_id`) REFERENCES `client` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order`
--

LOCK TABLES `order` WRITE;
/*!40000 ALTER TABLE `order` DISABLE KEYS */;
INSERT INTO `order` VALUES (1,1),(2,2);
/*!40000 ALTER TABLE `order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_products`
--

DROP TABLE IF EXISTS `order_products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `order_products` (
  `order_id` int NOT NULL AUTO_INCREMENT,
  `product_id` int NOT NULL,
  PRIMARY KEY (`order_id`,`product_id`),
  KEY `fk_product_id_idx` (`product_id`),
  CONSTRAINT `fk_product_id` FOREIGN KEY (`product_id`) REFERENCES `film` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_products`
--

LOCK TABLES `order_products` WRITE;
/*!40000 ALTER TABLE `order_products` DISABLE KEYS */;
INSERT INTO `order_products` VALUES (1,8),(1,10),(2,10),(2,11);
/*!40000 ALTER TABLE `order_products` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-06-17 18:54:25
