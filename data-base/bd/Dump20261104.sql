CREATE DATABASE  IF NOT EXISTS `db-acme-manha` /*!40100 DEFAULT CHARACTER SET utf8mb3 */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `db-acme-manha`;
-- MySQL dump 10.13  Distrib 8.0.32, for Win64 (x86_64)
--
-- Host: localhost    Database: db-acme-manha
-- ------------------------------------------------------
-- Server version	8.2.0

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
-- Table structure for table `animais`
--

DROP TABLE IF EXISTS `animais`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `animais` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) DEFAULT NULL,
  `raca_id` int DEFAULT NULL,
  `sexo` char(1) DEFAULT NULL,
  `data_nascimento` date DEFAULT NULL,
  `peso` decimal(8,2) DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `raca_id` (`raca_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `animais`
--

LOCK TABLES `animais` WRITE;
/*!40000 ALTER TABLE `animais` DISABLE KEYS */;
INSERT INTO `animais` VALUES (5,'jubileu',28,'M','2026-09-24',11.00,10);
/*!40000 ALTER TABLE `animais` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categorias_despesas`
--

DROP TABLE IF EXISTS `categorias_despesas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categorias_despesas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categorias_despesas`
--

LOCK TABLES `categorias_despesas` WRITE;
/*!40000 ALTER TABLE `categorias_despesas` DISABLE KEYS */;
INSERT INTO `categorias_despesas` VALUES (1,'Produção Animal'),(2,'Produção Agrícola'),(3,'Mão de Obra'),(4,'Máquinas e Equipamentos'),(5,'Infraestrutura'),(6,'Transporte e Logística'),(7,'Administrativo'),(8,'Impostos e Taxas'),(9,'Financeiro'),(10,'Serviços Terceirizados'),(11,'Insumos'),(12,'Outras Despesas');
/*!40000 ALTER TABLE `categorias_despesas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categorias_lucros`
--

DROP TABLE IF EXISTS `categorias_lucros`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categorias_lucros` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categorias_lucros`
--

LOCK TABLES `categorias_lucros` WRITE;
/*!40000 ALTER TABLE `categorias_lucros` DISABLE KEYS */;
INSERT INTO `categorias_lucros` VALUES (1,'Venda de Animais'),(2,'Venda de Produção Agrícola'),(3,'Venda de Produtos Beneficiados'),(4,'Prestação de Serviços'),(5,'Receitas Financeiras'),(6,'Subsídios e Incentivos'),(7,'Arrendamento'),(8,'Venda de Ativos'),(9,'Indenizações'),(10,'Outras Receitas');
/*!40000 ALTER TABLE `categorias_lucros` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `despesas`
--

DROP TABLE IF EXISTS `despesas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `despesas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `animal_id` int DEFAULT NULL,
  `grupo_id` int DEFAULT NULL,
  `categoria_id` int DEFAULT NULL,
  `descricao` varchar(255) DEFAULT NULL,
  `valor` decimal(10,2) DEFAULT NULL,
  `data_despesa` date DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `animal_id` (`animal_id`),
  KEY `grupo_id` (`grupo_id`),
  KEY `categoria_id` (`categoria_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `despesas`
--

LOCK TABLES `despesas` WRITE;
/*!40000 ALTER TABLE `despesas` DISABLE KEYS */;
/*!40000 ALTER TABLE `despesas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `especies`
--

DROP TABLE IF EXISTS `especies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `especies` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `especies`
--

LOCK TABLES `especies` WRITE;
/*!40000 ALTER TABLE `especies` DISABLE KEYS */;
INSERT INTO `especies` VALUES (1,'Bovino'),(2,'Equino'),(3,'Ovino'),(4,'Caprino'),(5,'Suíno'),(6,'Canino'),(7,'Felino');
/*!40000 ALTER TABLE `especies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `faqs`
--

DROP TABLE IF EXISTS `faqs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `faqs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `faqs_category_id` int NOT NULL,
  `question` varchar(255) NOT NULL,
  `answer` varchar(255) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `fk_faqs_faqs_categories1_idx` (`faqs_category_id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `faqs`
--

LOCK TABLES `faqs` WRITE;
/*!40000 ALTER TABLE `faqs` DISABLE KEYS */;
INSERT INTO `faqs` VALUES (1,1,'Como faço para acompanhar o status do meu pedido?','Acesse a área \"Meus Pedidos\" no seu perfil e clique sobre o número do pedido para ver o status detalhado.',1),(2,1,'Posso cancelar um pedido após a confirmação?','Pedidos podem ser cancelados em até 1 hora após a confirmação, desde que ainda não tenham sido separados para envio.',1),(3,1,'É possível alterar o endereço de entrega após o pedido?','Sim, contate nosso suporte em até 2 horas após a compra com o número do pedido e o novo endereço.',1),(4,2,'Quais formas de pagamento são aceitas?','Aceitamos cartão de crédito (Visa, Mastercard, Elo), boleto bancário e Pix.',1),(5,2,'Em quantas parcelas posso parcelar minha compra?','Compras com cartão de crédito podem ser parceladas em até 12 vezes sem juros para pedidos acima de R$ 200,00.',1),(6,2,'Meu pagamento foi recusado. O que fazer?','Verifique os dados do cartão e o limite disponível. Se o problema persistir, tente outra forma de pagamento ou entre em contato com seu banco.',1),(7,2,'O boleto venceu. Posso gerar um novo?','Sim. Acesse \"Meus Pedidos\", localize o pedido em questão e clique em \"Gerar novo boleto\". O prazo de pagamento será de 1 dia útil.',1),(8,3,'Qual o prazo de entrega?','O prazo varia conforme a região e o produto. Após a confirmação do pagamento, o prazo estimado é exibido no resumo do pedido.',1),(9,3,'Meu pedido está atrasado. O que fazer?','Se o prazo estimado já passou, acesse \"Meus Pedidos\" e clique em \"Falar com suporte\" para abrir um chamado de rastreamento.',1),(10,3,'Posso retirar meu pedido na loja?','Sim. Selecione a opção \"Retirar na loja\" durante o checkout e aguarde o e-mail de confirmação de disponibilidade.',1),(11,4,'Como solicito a troca de um produto?','Acesse \"Meus Pedidos\", selecione o produto e clique em \"Solicitar troca\". O prazo para solicitação é de até 7 dias após o recebimento.',1),(12,4,'Qual o prazo para devolução?','De acordo com o Código de Defesa do Consumidor, você tem até 7 dias corridos após o recebimento para desistir da compra.',1),(13,4,'Quem paga o frete da devolução?','Caso o produto apresente defeito, o frete de devolução é por nossa conta. Em caso de desistência, o frete é de responsabilidade do cliente.',1),(14,5,'Como altero minha senha?','Acesse \"Minha Conta\" > \"Segurança\" > \"Alterar senha\". Você receberá um e-mail de confirmação para concluir a alteração.',1),(15,5,'Esqueci minha senha. Como recuperá-la?','Na tela de login, clique em \"Esqueci minha senha\" e informe o e-mail cadastrado. Você receberá um link de redefinição em até 5 minutos.',1);
/*!40000 ALTER TABLE `faqs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `faqs_categories`
--

DROP TABLE IF EXISTS `faqs_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `faqs_categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `faqs_categories`
--

LOCK TABLES `faqs_categories` WRITE;
/*!40000 ALTER TABLE `faqs_categories` DISABLE KEYS */;
INSERT INTO `faqs_categories` VALUES (1,'Pedidos',1),(2,'Pagamentos',1),(3,'Entregas',1),(4,'Devoluções e Trocas',1),(5,'Cadastro e Conta',1);
/*!40000 ALTER TABLE `faqs_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `grupos_animais`
--

DROP TABLE IF EXISTS `grupos_animais`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `grupos_animais` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `quantidade` int NOT NULL DEFAULT '0',
  `user_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grupos_animais`
--

LOCK TABLES `grupos_animais` WRITE;
/*!40000 ALTER TABLE `grupos_animais` DISABLE KEYS */;
INSERT INTO `grupos_animais` VALUES (3,'gatos',23,10);
/*!40000 ALTER TABLE `grupos_animais` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lucros`
--

DROP TABLE IF EXISTS `lucros`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `lucros` (
  `id` int NOT NULL AUTO_INCREMENT,
  `animal_id` int DEFAULT NULL,
  `grupo_id` int DEFAULT NULL,
  `categoria_id` int DEFAULT NULL,
  `descricao` varchar(255) DEFAULT NULL,
  `valor` decimal(10,2) DEFAULT NULL,
  `data_lucro` date DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `animal_id` (`animal_id`),
  KEY `grupo_id` (`grupo_id`),
  KEY `categoria_id` (`categoria_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lucros`
--

LOCK TABLES `lucros` WRITE;
/*!40000 ALTER TABLE `lucros` DISABLE KEYS */;
/*!40000 ALTER TABLE `lucros` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products` (
  `id` int NOT NULL AUTO_INCREMENT,
  `category_id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `fk_products_products_categories1_idx` (`category_id`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,1,'Mouse Logitech M170',89.90,1),(2,1,'Teclado Logitech K120',79.90,1),(3,1,'Monitor LG 24 Polegadas IPS Full HD',899.00,1),(4,2,'Notebook Dell Inspiron 15 i5 16GB 512GB SSD',4299.00,1),(5,2,'Notebook Lenovo IdeaPad 3 Ryzen 5 8GB 256GB SSD',3199.00,1),(6,2,'MacBook Air M2 13 Polegadas 256GB',7999.00,1),(7,3,'Smartphone Samsung Galaxy A55 128GB',2199.00,1),(8,3,'iPhone 15 128GB',5999.00,1),(9,3,'Smartphone Motorola Edge 50 Fusion 256GB',2499.00,1),(10,4,'Headset HyperX Cloud Stinger 2',329.90,1),(11,4,'Webcam Logitech C920s Full HD',449.90,1),(12,4,'Caixa de Som JBL Go 4 Bluetooth',279.90,1),(13,5,'SSD Kingston NV2 1TB NVMe',399.90,1),(14,5,'HD Externo Seagate 2TB USB 3.0',499.90,1),(15,5,'Pen Drive Sandisk Ultra 128GB USB 3.0',89.90,1),(16,6,'Roteador TP-Link Archer AX53 Wi-Fi 6',449.90,1),(17,6,'Switch TP-Link TL-SG108 8 Portas Gigabit',219.90,1),(18,6,'Cabo de Rede Cat6 2m',29.90,1),(19,7,'Impressora Epson EcoTank L3250',1199.00,1),(20,7,'Nobreak Intelbras XNB 720VA',679.90,1),(21,7,'Filtro de Linha Clamper 5 Tomadas',89.90,1),(22,8,'Cadeira Gamer ThunderX3 EC3',1199.00,1),(23,8,'Mesa de Escritorio 120cm com 2 Gavetas',699.00,0),(24,8,'Suporte Articulado para Monitor ELG F80N',289.90,0);
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products_categories`
--

DROP TABLE IF EXISTS `products_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products_categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products_categories`
--

LOCK TABLES `products_categories` WRITE;
/*!40000 ALTER TABLE `products_categories` DISABLE KEYS */;
INSERT INTO `products_categories` VALUES (1,'Periféricos',1),(2,'Notebooks',1),(3,'Smartphones',1),(4,'Áudio e Vídeo',1),(5,'Armazenamento',1),(6,'Redes',1),(7,'Energia e Impressão',1),(8,'Acessórios de Escritório',1);
/*!40000 ALTER TABLE `products_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `racas`
--

DROP TABLE IF EXISTS `racas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `racas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `especie_id` int DEFAULT NULL,
  `nome` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `especie_id` (`especie_id`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `racas`
--

LOCK TABLES `racas` WRITE;
/*!40000 ALTER TABLE `racas` DISABLE KEYS */;
INSERT INTO `racas` VALUES (1,1,'Nelore'),(2,1,'Angus'),(3,1,'Hereford'),(4,1,'Holandês'),(5,1,'Gir'),(6,2,'Crioulo'),(7,2,'Mangalarga Marchador'),(8,2,'Quarto de Milha'),(9,2,'Puro Sangue Inglês'),(10,3,'Texel'),(11,3,'Corriedale'),(12,3,'Hampshire Down'),(13,3,'Suffolk'),(14,4,'Boer'),(15,4,'Saanen'),(16,4,'Anglo-Nubiana'),(17,5,'Large White'),(18,5,'Landrace'),(19,5,'Duroc'),(20,6,'Labrador Retriever'),(21,6,'Pastor Alemão'),(22,6,'Golden Retriever'),(23,6,'Border Collie'),(24,7,'Siamês'),(25,7,'Persa'),(26,7,'Maine Coon'),(27,7,'Ragdoll'),(28,0,'Não informada');
/*!40000 ALTER TABLE `racas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `type_id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `fk_users_user_types_idx` (`type_id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,1,'Fábio Santos','fabiosantos@ifsul.edu.br','12345678',NULL,1),(2,2,'Godofredo Silva','godofredo@gmail.com','12345678',NULL,1),(9,2,'fabio','fabio2@gmail.com','$2y$10$LDTDBFwsvss5bw.0OoHKW.C7c8VSwxSvbpI4JW/R/LbDK/yzU4GZy',NULL,1),(8,2,'Eduardo','eduardo123@gmail.com','$2y$10$VU01K/dqRbnV.G3KrQPxd.dnG6uyxV.xLw1D/rInORGgiSjBUvj8C',NULL,1),(7,2,'Eduardo','eduardo@gmail.com','$2y$10$OpJx6zJdrZw1pI8tMRyenueBgxqADLS3QNTnffXF7rqTqIOFSH.RS',NULL,1),(6,2,'cecilia','cecilia@gmail.com','$2y$10$CJETwG/yINAkr3gVhvdJUugnfNKX70hVG0tYYx/edSWXnal.9tmOu',NULL,1),(10,2,'virginia','virginia@gmail.com','$2y$10$PNRXDDcuIyHec4i3caKK2OxwO2jQ5rtkoZYOOBGjSnqtySXbDzsiW',NULL,1),(11,2,'Eduardo N.S Souza','dudu@gmail.com','$2y$10$VcCOrFVZXBlarN9AkQY0puzLjBHktjAYMpNkieum6oC63Nc3ksvLS',NULL,1),(12,2,'Eduardo N.S Souza','dudu2@gmail.com','$2y$10$roUrv6m1tgyw08a2YYye8uQJ2Roogs4E8.oO9lELgVtCqE29lUIPu','uploads/users/1d23bc19b3e789168c873edad328389e.png',1);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users_types`
--

DROP TABLE IF EXISTS `users_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users_types` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users_types`
--

LOCK TABLES `users_types` WRITE;
/*!40000 ALTER TABLE `users_types` DISABLE KEYS */;
INSERT INTO `users_types` VALUES (1,'ADMIN',1),(2,'STANDARD',1);
/*!40000 ALTER TABLE `users_types` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-11-04 15:37:53
