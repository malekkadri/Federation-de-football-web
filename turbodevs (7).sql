-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 10, 2022 at 01:33 AM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 7.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `turbodevs`
--

-- --------------------------------------------------------

--
-- Table structure for table `arbitre`
--

CREATE TABLE `arbitre` (
  `id` int(11) NOT NULL,
  `nom_a` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nbe` int(11) NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descrp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `arbitre`
--

INSERT INTO `arbitre` (`id`, `nom_a`, `nbe`, `image`, `descrp`) VALUES
(1, 'François Letexier', 13, '8e865bc3d74b65033d5201997ec6c67e.jpg', 'François Letexier, né le 23 avril 1989 à Bédée, est un arbitre international français de football. Il est actuellement l’un des plus jeunes arbitres de Ligue 1'),
(3, 'Benoît Bastien', 9, '35c2d8c953715b8ab433d5c2b843ca9c.jpg', 'Benoît Bastien est un arbitre international français de football né le 17 avril 1983 à Épinal.'),
(5, 'Clément Turpin', 18, 'c36b9fb349bd933f30fa2a0fbca9f218.jpg', 'Clément Turpin, né le 16 mai 1982 à Oullins, est un arbitre international français de football. Il représente la Ligue de Bourgogne et est licencié au FC Montceau Bourgogne depuis 1989.'),
(10, 'Ruddy Buquet', 15, 'f11f9359b2adf0374dd4136dbb427e86.jpg', 'Ruddy Buquet est un arbitre international français de football né le 29 janvier 1977 à Amiens. Le vendredi 10 août 2018, il est le premier arbitre français à utiliser l’assistance vidéo en Ligue 1');

-- --------------------------------------------------------

--
-- Table structure for table `article`
--

CREATE TABLE `article` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `titre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descr` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `datea` date NOT NULL,
  `img` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `article`
--

INSERT INTO `article` (`id`, `user_id`, `titre`, `descr`, `datea`, `img`) VALUES
(7, 2, 'The world\'s press reacts to FC Barcelona\'s histori', 'the impossible became the possible. The players, coaching staff and fans always believed that Barça could turn things around against Paris Saint-Germain  their faith was vindicated after the historic 6-1 victory at Camp Nou.', '2022-02-20', 'khYxRaOW-62275b50562cd.jpg'),
(8, 2, 'Joan Laporta: \'Xavi has changed the mentality of t', 'monday 7 March marks one year since Joan Laporta\'s victory in the FC Barcelona presidential elections. To look back over the last 12 months the Club President took part in an exclusive interview with Barça TV+.', '2022-02-01', '1200-L-bara-laporta-l-avoue-messi-et-xavi-lui-ont-fait-vivre-ses-pires-et-meilleurs-moments-de-son-mandat-62275bebbcdf6.jpg'),
(9, 1, 'Lionel Messi Top Landing Spots: Which Team Will Me', 'On Tuesday, FC Barcelona confirmed that Lionel Messi has requested to leave the club he has spent his entire career playing for. I was lucky enough to spend a few months in Barcelona earlier this year, and I saw firsthand how much the entire region of Ca', '2022-02-20', 'lionelmessilandingspots-450x250-62275c3e3ea2e.jpg'),
(11, 4, 'Les Ballons d\'Or blaugrana', 'Leo Messi, avec 6 Ballons d\'Or (2009, 2010, 2011, 2012, 2015 et 2019). Johan Cruyff, 2 (1973 et 1974), Luis Suarez Miramontes, 1 (1960), Stoichkov, 1 (1994), Rivaldo, 1 (1999) et Ronaldinho, 1 (2005).', '2022-03-09', 'mini-3200x2000-grafica-pilotes-equips-62291f7ce548a.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `badge`
--

CREATE TABLE `badge` (
  `id` int(11) NOT NULL,
  `nom_b` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo_b` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nb` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `badge`
--

INSERT INTO `badge` (`id`, `nom_b`, `logo_b`, `nb`) VALUES
(1, 'Master', 'test2-621a834f600bc.png', 250),
(6, 'Gold', 'test5-621a89b4b7bbb.png', 25),
(8, 'Grand Master', 'test1-621a818e8c154.png', 500),
(10, 'Diamond', 'test3-621a8415df439.png', 50),
(37, 'Platinum', 'test4-621a86906a598.png', 100),
(39, 'Bronze', 'test7-621a8f9c7fc15.png', 0),
(44, 'Silver', 'test6-621a8b7865196.png', 15),
(45, 'Challenger', 'test-1-621a7f9eb0bfb.png', 1000);

-- --------------------------------------------------------

--
-- Table structure for table `categorie`
--

CREATE TABLE `categorie` (
  `id` int(11) NOT NULL,
  `type_c` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categorie`
--

INSERT INTO `categorie` (`id`, `type_c`) VALUES
(1, 'tshirt'),
(2, 'shirt'),
(5, 'sweat');

-- --------------------------------------------------------

--
-- Table structure for table `classement`
--

CREATE TABLE `classement` (
  `id` int(11) NOT NULL,
  `club_id` int(11) NOT NULL,
  `tournoi_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `classement`
--

INSERT INTO `classement` (`id`, `club_id`, `tournoi_id`) VALUES
(7, 2, 2),
(8, 12, 2),
(9, 13, 2),
(10, 13, 3),
(11, 2, 3),
(13, 12, 3),
(14, 15, 3),
(15, 16, 3),
(16, 17, 3),
(17, 15, 2),
(18, 2, 4),
(19, 12, 4),
(20, 13, 4),
(21, 15, 4),
(22, 16, 4),
(23, 17, 4);

-- --------------------------------------------------------

--
-- Table structure for table `club`
--

CREATE TABLE `club` (
  `id` int(11) NOT NULL,
  `sponsor_id` int(11) DEFAULT NULL,
  `nomc` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descr` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `president` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `club`
--

INSERT INTO `club` (`id`, `sponsor_id`, `nomc`, `logo`, `descr`, `president`) VALUES
(2, 7, 'CSCH', 'e48e5c7075c0523560fb632b5bc8f6f7.png', 'Equipe Sportive de football founded 1960', 'Taoufik Mkacher'),
(12, 1, 'CSS', '27f7f9db37e7bb6334c508b1ac5f2158.png', 'Equipe Sortive Tunisienne Fondée en 1920', 'khmekhem'),
(13, 2, 'ESS', 'c50496eef57136fa01a1576b6d6fde2e.png', 'Equipe Spotive de Sahel 1925', 'charf eddine'),
(15, 5, 'EST', 'def95775bbcc14e338394997726d00b7.png', 'Equipe Sortive Tunisienne Fondée en 1920', 'hamdi meddeb'),
(16, 2, 'CA', '8f316b8173cc7bc5948a528fc11d339b.png', 'Equipe Sortive Tunisienne Fondée en 1922', 'slim riahi'),
(17, 6, 'Beja', 'fa7c3ebebfbcc9bf80c2ee361e1574ac.gif', 'Equipe Sortive Tunisienne Fondée en 1950', 'mohamed');

-- --------------------------------------------------------

--
-- Table structure for table `commande`
--

CREATE TABLE `commande` (
  `id` int(11) NOT NULL,
  `prix_u` double NOT NULL,
  `qte` int(11) NOT NULL,
  `date` date NOT NULL,
  `id_p_id` int(11) NOT NULL,
  `id_u_id` int(11) NOT NULL,
  `etat` int(11) NOT NULL,
  `taille` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `commande`
--

INSERT INTO `commande` (`id`, `prix_u`, `qte`, `date`, `id_p_id`, `id_u_id`, `etat`, `taille`) VALUES
(1, 45, 1, '2022-03-07', 1, 1, 1, 's'),
(2, 45, 1, '2022-03-07', 1, 4, 1, 's'),
(3, 45, 1, '2022-03-07', 1, 4, 1, 's'),
(4, 45, 1, '2022-03-07', 1, 4, 1, 's'),
(5, 45, 1, '2022-03-07', 1, 4, 1, 's'),
(6, 45, 1, '2022-03-08', 1, 4, 1, 'm'),
(7, 45, 1, '2022-03-09', 1, 4, 1, 's'),
(8, 45, 1, '2022-03-09', 1, 4, 1, 's'),
(9, 100, 1, '2022-03-09', 21, 4, 1, 'm'),
(10, 600, 6, '2022-03-09', 21, 4, 1, 'm'),
(11, 90, 2, '2022-03-09', 1, 4, 1, 's');

-- --------------------------------------------------------

--
-- Table structure for table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20220213133319', '2022-02-13 14:33:24', 23412),
('DoctrineMigrations\\Version20220305131159', '2022-03-05 14:12:15', 9355),
('DoctrineMigrations\\Version20220307225907', '2022-03-09 17:19:16', 721),
('DoctrineMigrations\\Version20220309161907', '2022-03-09 17:19:16', 7754),
('DoctrineMigrations\\Version20220309162351', '2022-03-09 17:23:58', 1137);

-- --------------------------------------------------------

--
-- Table structure for table `game`
--

CREATE TABLE `game` (
  `id` int(11) NOT NULL,
  `club1_id` int(11) NOT NULL,
  `club2_id` int(11) NOT NULL,
  `arbitre_id` int(11) DEFAULT NULL,
  `stade_id` int(11) NOT NULL,
  `r1` int(11) NOT NULL,
  `r2` int(11) NOT NULL,
  `dated` date NOT NULL,
  `tournoi_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `game`
--

INSERT INTO `game` (`id`, `club1_id`, `club2_id`, `arbitre_id`, `stade_id`, `r1`, `r2`, `dated`, `tournoi_id`) VALUES
(48, 2, 12, 1, 10, 4, 1, '2022-03-02', 2),
(49, 12, 2, 3, 10, 2, 2, '2022-03-08', 2),
(50, 13, 12, 1, 12, 2, 1, '2022-03-02', 2),
(56, 2, 13, 1, 10, 1, 0, '2022-03-02', 3),
(57, 13, 2, 1, 10, 2, 3, '2022-03-04', 2),
(58, 2, 12, 1, 10, 1, 1, '2022-03-01', 4),
(59, 2, 15, 3, 12, 5, 4, '2022-03-08', 2),
(60, 15, 13, 5, 12, 4, 3, '2022-03-03', 2);

-- --------------------------------------------------------

--
-- Table structure for table `interaction`
--

CREATE TABLE `interaction` (
  `idi` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `article_id` int(11) NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descrp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `interaction`
--

INSERT INTO `interaction` (`idi`, `user_id`, `article_id`, `type`, `descrp`) VALUES
(2, 2, 7, 'comment', 'aaaaaaaaaaaaaaa'),
(27, 2, 7, 'reply?26', 'zaeazezaeazeaazea'),
(291, 2, 7, 'up', ''),
(297, 2, 7, 'comment', 'homaaa'),
(298, 2, 7, 'reply?297', 'ahla'),
(302, 2, 7, 'comment', 'good jooob'),
(305, 2, 7, 'reply?302', 'yes i knoww'),
(306, 2, 7, 'comment', 'nice  bro good job'),
(307, 2, 7, 'reply?306', 'hoooy'),
(313, 2, 7, 'reply?302', 'zeaezaea'),
(316, 2, 7, 'reply?306', 'hoyyy'),
(317, 2, 7, 'comment', 'hhhhhhhh'),
(318, 2, 7, 'comment', 'okkkkkkkkkk'),
(319, 2, 7, 'reply?318', 'aaaaa'),
(343, 1, 7, 'reply?2', 'trahh'),
(344, 4, 7, 'comment', 'com com'),
(351, 4, 7, 'reply?2', 'bezzz'),
(355, 4, 7, 'up', '');

-- --------------------------------------------------------

--
-- Table structure for table `joueur`
--

CREATE TABLE `joueur` (
  `cin` int(11) NOT NULL,
  `club_id` int(11) DEFAULT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `age` int(11) NOT NULL,
  `nbm` int(11) NOT NULL,
  `nba` int(11) NOT NULL,
  `poste` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nationalite` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `numt` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `joueur`
--

INSERT INTO `joueur` (`cin`, `club_id`, `nom`, `prenom`, `age`, `nbm`, `nba`, `poste`, `nationalite`, `photo`, `numt`) VALUES
(9, 2, 'timouni', 'foued', 25, 6, 4, 'MILIEU', 'Tunisien', '3f0de9e4c1e69c2def061d25ac5ce61c.png', 9),
(12, 2, 'konaté', 'omar', 28, 3, 2, 'DEFENDERS', 'Malien', 'e678e6409540e9edc114bfda474db438.jpg', 15),
(13, 2, 'kalai', 'ali', 30, 0, 0, 'GOALKEEPERS', 'Tunisien', 'e7db153287c7fef5b327b384b0790377.png', 1),
(14, 2, 'jilani', 'abdesslam', 27, 11, 4, 'ATTACK', 'Tunisien', '0e3d790f3ce375b85e3f251f1467be0b.jpg', 10),
(15, 12, 'dahmen', 'aymen', 24, 0, 0, 'GOALKEEPERS', 'Tunisien', 'c92fc0aa3824a322ba1df43da6bfddde.jpg', 1),
(16, 12, 'chaouat', 'firas', 26, 3, 2, 'ATTACK', 'Tunisien', '6a1df40ae449faaf4fef4e361d5ed970.jpg', 7),
(17, 12, 'harzi', 'aymen', 30, 2, 1, 'MILIEU', 'Tunisien', '68f78d81fecedd2479c1f99ae3061509.jpg', 5),
(18, 12, 'hammemi', 'chedi', 31, 1, 2, 'DEFENDERS', 'Tunisien', '7a441df4e0eb7561918d5f6bb5e9e415.jpg', 11),
(19, 2, 'ahmed', 'hsouna', 21, 0, 1, 'GOALKEEPERS', 'Tunisien', '6c2e7cf4c5e3cf4dfcccb9b9177cc1cc.jpg', 23),
(20, 15, 'ben chrifia', 'moez', 30, 0, 0, 'GOALKEEPERS', 'Tunisien', 'a4d0b63f420df0c4bfa72ae3f53eb8fa.jpg', 1),
(21, 15, 'benguit', 'mohamed', 26, 1, 1, 'MILIEU', 'Tunisien', '1bebb544df9d8324dfe005de2cf38722.jpg', 12),
(22, 15, 'yaakoubi', 'mohamed', 31, 2, 1, 'DEFENDERS', 'Tunisien', '1ffa243cdf8f89bc9cde6b2f9cfb2759.jpg', 22),
(23, 15, 'houni', 'hamdi', 24, 6, 3, 'ATTACK', 'Libyien', 'eb6df79ccd2e28b1feefec6222c2a573.jpg', 10),
(24, 15, 'koulibali', 'fousini', 28, 5, 4, 'MILIEU', 'camirounien', '2cd69ac4d512e708c12586473666247b.jpg', 11),
(25, 15, 'ben mostfa', 'farouk', 22, 0, 0, 'GOALKEEPERS', 'Tunisien', '8c3647948b123565e654503fafdb54f7.jpg', 18),
(26, 15, 'ben romthane', 'mohamed', 25, 4, 2, 'ATTACK', 'Tunisien', '1623b0458742b73d1c142f3f3d39aa6d.jpg', 11),
(27, 16, 'hsan', 'moez', 27, 0, 0, 'GOALKEEPERS', 'Tunisien', '04efa542e992670a6a963372a6837c8e.jpg', 1),
(28, 16, 'lamara', 'nabil', 28, 1, 1, 'DEFENDERS', 'Tunisien', 'eb8d5fbbb16155111d4e2443d3381351.jpg', 14),
(29, 16, 'khlifa', 'saber', 32, 3, 3, 'ATTACK', 'Tunisien', '43938e2c0dca7d470e7bd92bb194066d.jpg', 10),
(30, 16, 'chamakhi', 'yassine', 30, 5, 3, 'MILIEU', 'Tunisien', 'c4cf125866720b0a9edbf9bb946fc52a.jpg', 19),
(31, 16, 'Larry', 'azouni', 33, 2, 1, 'MILIEU', 'Francaise', '4095171902f2820803e90d84bfe27911.jpg', 22),
(32, 13, 'balbouli', 'aymen', 35, 1, 1, 'GOALKEEPERS', 'Tunisien', '4a5fa3c3a418909f4dca0273e0087039.jpg', 1),
(33, 13, 'mbe', 'jacque', 22, 7, 4, 'MILIEU', 'camirounien', 'd8832c6035c644049fada2e9fd89f858.jpg', 11),
(34, 13, 'ben amor', 'mohamed amin', 27, 4, 8, 'MILIEU', 'Tunisien', '0eb06eb4a1d63a626e5a477bde3f4fed.jpg', 10),
(35, 13, 'ben ayada', 'heucein', 28, 4, 1, 'DEFENDERS', 'Algerienne', '84ba27b82e3fbbf83f74cfe4bf6463c6.jpg', 5),
(36, 13, 'jmal', 'ali', 28, 0, 0, 'GOALKEEPERS', 'Tunisien', '764071154922e133154cefb6cc8a37a5.jpg', 16),
(37, 13, 'chikhaoui', 'yassine', 35, 3, 7, 'ATTACK', 'Tunisien', 'd737daf64cc75b1d15e572aa7afac5c2.jpg', 23);

-- --------------------------------------------------------

--
-- Table structure for table `jour`
--

CREATE TABLE `jour` (
  `id` int(11) NOT NULL,
  `clu_id` int(11) DEFAULT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `marques`
--

CREATE TABLE `marques` (
  `id` int(11) NOT NULL,
  `nom_m` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `marques`
--

INSERT INTO `marques` (`id`, `nom_m`) VALUES
(1, 'puma'),
(3, 'adidas');

-- --------------------------------------------------------

--
-- Table structure for table `panier`
--

CREATE TABLE `panier` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `produit_id` int(11) NOT NULL,
  `prix_u` double NOT NULL,
  `qte` int(11) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `produit`
--

CREATE TABLE `produit` (
  `id` int(11) NOT NULL,
  `categorie_id` int(11) NOT NULL,
  `nom_p` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `taille` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `couleur` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prix` double NOT NULL,
  `descr` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `qte` int(11) NOT NULL,
  `img` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `marquep_id` int(11) DEFAULT NULL,
  `taille2` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_ajout` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `produit`
--

INSERT INTO `produit` (`id`, `categorie_id`, `nom_p`, `taille`, `couleur`, `prix`, `descr`, `qte`, `img`, `marquep_id`, `taille2`, `date_ajout`) VALUES
(1, 1, 'marvel', 's', 'blanc', 45, 't-shirt marvel blanc 100% coton', 0, 'product-2-6216aacf65578.jpg', 1, 'm', '2022-02-23'),
(21, 2, 'punisher', 's', 'blanc', 100, 'Shirt punisher noire', 10, 'blanc-621ff0a736cfc.jpg', 1, 'm', '2022-03-02'),
(22, 2, 'punisher', 's', 'noire', 150, 'Shirt punisher noire', 10, 'landing-news-1-621ff0dd90020.jpg', 1, 'm', '2022-03-02'),
(23, 5, 'iron man', 's', 'blanc', 105, 'Sweat iron man blanc', 10, 'product-3-621fcf5014354.jpg', 1, 'm', '2022-03-02'),
(24, 2, '.t-shirt psg', 's', 'blanc', 150, 'shirt psg adidas blanc', 10, '16026932-500-B-621ff223a45ab.jpg', 3, 'm', '2022-03-02');

-- --------------------------------------------------------

--
-- Table structure for table `reclamation`
--

CREATE TABLE `reclamation` (
  `idr` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `objet` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `desc_r` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reclamation`
--

INSERT INTO `reclamation` (`idr`, `user_id`, `objet`, `desc_r`, `status`) VALUES
(1, 4, 'azeae', 'azeaazeazeaeaz', 'Sevices et personel de TurboDevs'),
(2, 4, 'azeae', 'azeaazeazeaeaz', 'Comptabilité et factures'),
(3, 4, 'azeae', 'azeaazeazeaeaz', 'Autre');

-- --------------------------------------------------------

--
-- Table structure for table `rewards`
--

CREATE TABLE `rewards` (
  `id_r` int(11) NOT NULL,
  `tournoi_id` int(11) NOT NULL,
  `rank` int(11) NOT NULL,
  `trophe` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prix_r` double NOT NULL,
  `img` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rewards`
--

INSERT INTO `rewards` (`id_r`, `tournoi_id`, `rank`, `trophe`, `prix_r`, `img`) VALUES
(2, 2, 1, 'champions league trophies', 5000000, '3b2b928b681660e797537e20766a267a.png'),
(3, 3, 1, 'trophé championnat', 1000000, 'a06d59d3b6201e65e9ae43b80780c6db.jpg'),
(4, 4, 2, 'trophé coupe', 1000000, '0d82193d666e02f6065379c7f8c8ce4e.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `sponsor`
--

CREATE TABLE `sponsor` (
  `id` int(11) NOT NULL,
  `nom_s` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo_s` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sponsor`
--

INSERT INTO `sponsor` (`id`, `nom_s`, `logo_s`) VALUES
(1, 'Orange', 'b03fae3d4174a6ff21587222f4961697.png'),
(2, 'ooredoo', 'd51f18a7312f54a4b87be1b2f05e5446.jpg'),
(5, 'Delice', 'd7d703a2ee3ac702c74d31781f66640f.jpg'),
(6, 'Vitalait', '73ebc2804323eed512f2422f14cb837f.jpg'),
(7, 'cocacola', 'c11658ef5e5ed51cb9da411ddf722523.jpg'),
(8, 'Esprit', 'bc05ef792627f34dde7fffc410bf3766.png');

-- --------------------------------------------------------

--
-- Table structure for table `stade`
--

CREATE TABLE `stade` (
  `id` int(11) NOT NULL,
  `lieu` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `noms` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `etat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nbr_p` int(11) NOT NULL,
  `photo` text COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stade`
--

INSERT INTO `stade` (`id`, `lieu`, `noms`, `etat`, `nbr_p`, `photo`) VALUES
(10, 'camp nou', 'camp nou', 'complet', 54894, '92cc1e045b85f6fcf7a51cfb0a355657.jpg'),
(11, 'chebba chebba', 'Stade Municipale Chebba', 'complet', 2000, '13f07beaaf5cb981db24f5654fc2a37e.jpg'),
(12, 'rades rades', 'rades tunis', 'en travaux', 60000, '2c7d7d1327b66a42ecd3aae09a995c76.jpg'),
(14, 'england', 'stanford bridge', 'complet', 80000, 'a1c8e5d712ca81a80ffeb770730a0aa8.jpg'),
(15, 'France Paris', 'parc des princes', 'complet', 90000, 'e852db6fcf5fc677a35bcd33098f3519.jpg'),
(16, 'Italy Rome', 'San Siro', 'Olympique', 75000, '91c8f0a7ad994b5deae22b42a0975647.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tournoi`
--

CREATE TABLE `tournoi` (
  `id` int(11) NOT NULL,
  `nomt` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dated` date NOT NULL,
  `datef` date NOT NULL,
  `typet` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nbrc` int(11) NOT NULL,
  `logo` text COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tournoi`
--

INSERT INTO `tournoi` (`id`, `nomt`, `dated`, `datef`, `typet`, `nbrc`, `logo`) VALUES
(2, 'Champion league', '2022-02-23', '2022-02-28', 'eliminatoire', 4, '648a93ac2938e46528cad0ef52129127.png'),
(3, 'Championnat', '2022-03-01', '2022-06-30', 'club', 6, '5050382a6412c5d27ca19a9bd23f1bb6.png'),
(4, 'CoupeTunisie', '2022-03-01', '2022-06-30', 'eliminatoire', 6, '159c7a9ed1e9cc636cab7a52746a4ed8.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `badge_id` int(11) DEFAULT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mdp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nbp` int(11) NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `img` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `badge_id`, `username`, `mdp`, `nbp`, `email`, `role`, `img`) VALUES
(1, 39, 'momo', '1234', 2, 'ksaay2000@gmail.com', 'admin', 'avatar.png'),
(2, 37, 'hamroni', '12345', 100, 'ksaay2000@gmail.com', 'admin', 'avatar.png'),
(3, 1, 'degla', 'azeaze', 0, 'ksaay2000@gmail.com', 'admin', 'avatar.png'),
(4, 39, 'ksaay2000', 'anouer', 250, 'ksaay2000@gmail.com', 'admin', 'avatar.png'),
(5, 1, 'ahmed', 'mibon', 0, 'ahmedazeaea@gmail.com', 'client', 'avatar.png'),
(6, 1, 'OUMAIMA', '1', 0, 'ksaay2000@gmail.com', 'client', 'avatar.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `arbitre`
--
ALTER TABLE `arbitre`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `article`
--
ALTER TABLE `article`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_23A0E66A76ED395` (`user_id`);

--
-- Indexes for table `badge`
--
ALTER TABLE `badge`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `classement`
--
ALTER TABLE `classement`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_55EE9D6D61190A32` (`club_id`),
  ADD KEY `IDX_55EE9D6DF607770A` (`tournoi_id`);

--
-- Indexes for table `club`
--
ALTER TABLE `club`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_B8EE387212F7FB51` (`sponsor_id`);

--
-- Indexes for table `commande`
--
ALTER TABLE `commande`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_6EEAA67D6F858F92` (`id_u_id`),
  ADD KEY `IDX_6EEAA67D585B7FA0` (`id_p_id`);

--
-- Indexes for table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `game`
--
ALTER TABLE `game`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_232B318C1EDA6519` (`club1_id`),
  ADD KEY `IDX_232B318CC6FCAF7` (`club2_id`),
  ADD KEY `IDX_232B318C943A5F0` (`arbitre_id`),
  ADD KEY `IDX_232B318C6538AB43` (`stade_id`),
  ADD KEY `IDX_232B318CF607770A` (`tournoi_id`);

--
-- Indexes for table `interaction`
--
ALTER TABLE `interaction`
  ADD PRIMARY KEY (`idi`),
  ADD KEY `IDX_378DFDA7A76ED395` (`user_id`),
  ADD KEY `IDX_378DFDA77294869C` (`article_id`);

--
-- Indexes for table `joueur`
--
ALTER TABLE `joueur`
  ADD PRIMARY KEY (`cin`),
  ADD KEY `IDX_FD71A9C561190A32` (`club_id`);

--
-- Indexes for table `jour`
--
ALTER TABLE `jour`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_DA17D9C5A6810A97` (`clu_id`);

--
-- Indexes for table `marques`
--
ALTER TABLE `marques`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `panier`
--
ALTER TABLE `panier`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_24CC0DF2A76ED395` (`user_id`),
  ADD KEY `IDX_24CC0DF2F347EFB` (`produit_id`);

--
-- Indexes for table `produit`
--
ALTER TABLE `produit`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_29A5EC27BCF5E72D` (`categorie_id`),
  ADD KEY `IDX_29A5EC27D0E3E7D2` (`marquep_id`);

--
-- Indexes for table `reclamation`
--
ALTER TABLE `reclamation`
  ADD PRIMARY KEY (`idr`),
  ADD KEY `IDX_CE606404A76ED395` (`user_id`);

--
-- Indexes for table `rewards`
--
ALTER TABLE `rewards`
  ADD PRIMARY KEY (`id_r`),
  ADD KEY `IDX_E9221E37F607770A` (`tournoi_id`);

--
-- Indexes for table `sponsor`
--
ALTER TABLE `sponsor`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stade`
--
ALTER TABLE `stade`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tournoi`
--
ALTER TABLE `tournoi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_8D93D649F7A2C2FC` (`badge_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `arbitre`
--
ALTER TABLE `arbitre`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `article`
--
ALTER TABLE `article`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `badge`
--
ALTER TABLE `badge`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `categorie`
--
ALTER TABLE `categorie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `classement`
--
ALTER TABLE `classement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `club`
--
ALTER TABLE `club`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `commande`
--
ALTER TABLE `commande`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `game`
--
ALTER TABLE `game`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `interaction`
--
ALTER TABLE `interaction`
  MODIFY `idi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=356;

--
-- AUTO_INCREMENT for table `joueur`
--
ALTER TABLE `joueur`
  MODIFY `cin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `jour`
--
ALTER TABLE `jour`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `marques`
--
ALTER TABLE `marques`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `panier`
--
ALTER TABLE `panier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `produit`
--
ALTER TABLE `produit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `reclamation`
--
ALTER TABLE `reclamation`
  MODIFY `idr` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `rewards`
--
ALTER TABLE `rewards`
  MODIFY `id_r` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `sponsor`
--
ALTER TABLE `sponsor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `stade`
--
ALTER TABLE `stade`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tournoi`
--
ALTER TABLE `tournoi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `article`
--
ALTER TABLE `article`
  ADD CONSTRAINT `FK_23A0E66A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `classement`
--
ALTER TABLE `classement`
  ADD CONSTRAINT `FK_55EE9D6D61190A32` FOREIGN KEY (`club_id`) REFERENCES `club` (`id`),
  ADD CONSTRAINT `FK_55EE9D6DF607770A` FOREIGN KEY (`tournoi_id`) REFERENCES `tournoi` (`id`);

--
-- Constraints for table `club`
--
ALTER TABLE `club`
  ADD CONSTRAINT `FK_B8EE387212F7FB51` FOREIGN KEY (`sponsor_id`) REFERENCES `sponsor` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `commande`
--
ALTER TABLE `commande`
  ADD CONSTRAINT `FK_6EEAA67D585B7FA0` FOREIGN KEY (`id_p_id`) REFERENCES `produit` (`id`),
  ADD CONSTRAINT `FK_6EEAA67D6F858F92` FOREIGN KEY (`id_u_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `game`
--
ALTER TABLE `game`
  ADD CONSTRAINT `FK_232B318C1EDA6519` FOREIGN KEY (`club1_id`) REFERENCES `club` (`id`),
  ADD CONSTRAINT `FK_232B318C6538AB43` FOREIGN KEY (`stade_id`) REFERENCES `stade` (`id`),
  ADD CONSTRAINT `FK_232B318C943A5F0` FOREIGN KEY (`arbitre_id`) REFERENCES `arbitre` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `FK_232B318CC6FCAF7` FOREIGN KEY (`club2_id`) REFERENCES `club` (`id`),
  ADD CONSTRAINT `FK_232B318CF607770A` FOREIGN KEY (`tournoi_id`) REFERENCES `tournoi` (`id`);

--
-- Constraints for table `interaction`
--
ALTER TABLE `interaction`
  ADD CONSTRAINT `FK_378DFDA77294869C` FOREIGN KEY (`article_id`) REFERENCES `article` (`id`),
  ADD CONSTRAINT `FK_378DFDA7A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `joueur`
--
ALTER TABLE `joueur`
  ADD CONSTRAINT `FK_FD71A9C561190A32` FOREIGN KEY (`club_id`) REFERENCES `club` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `jour`
--
ALTER TABLE `jour`
  ADD CONSTRAINT `FK_DA17D9C5A6810A97` FOREIGN KEY (`clu_id`) REFERENCES `club` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `panier`
--
ALTER TABLE `panier`
  ADD CONSTRAINT `FK_24CC0DF2A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_24CC0DF2F347EFB` FOREIGN KEY (`produit_id`) REFERENCES `produit` (`id`);

--
-- Constraints for table `produit`
--
ALTER TABLE `produit`
  ADD CONSTRAINT `FK_29A5EC27BCF5E72D` FOREIGN KEY (`categorie_id`) REFERENCES `categorie` (`id`),
  ADD CONSTRAINT `FK_29A5EC27D0E3E7D2` FOREIGN KEY (`marquep_id`) REFERENCES `marques` (`id`);

--
-- Constraints for table `reclamation`
--
ALTER TABLE `reclamation`
  ADD CONSTRAINT `FK_CE606404A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `rewards`
--
ALTER TABLE `rewards`
  ADD CONSTRAINT `FK_E9221E37F607770A` FOREIGN KEY (`tournoi_id`) REFERENCES `tournoi` (`id`);

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `FK_8D93D649F7A2C2FC` FOREIGN KEY (`badge_id`) REFERENCES `badge` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
