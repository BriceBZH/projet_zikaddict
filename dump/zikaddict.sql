-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : sam. 29 juin 2024 à 16:29
-- Version du serveur : 10.4.27-MariaDB
-- Version de PHP : 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `zikaddict`
--

-- --------------------------------------------------------

--
-- Structure de la table `albums`
--

CREATE TABLE `albums` (
  `id` int(11) NOT NULL,
  `media_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `year` int(11) NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `update_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `valid` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `albums`
--

INSERT INTO `albums` (`id`, `media_id`, `title`, `year`, `created_at`, `update_at`, `valid`) VALUES
(1, 2, 'Exodus', 1977, '2024-06-29 16:17:39', '2024-06-29 16:17:39', 1),
(2, 3, 'Burnin', 1973, '2024-06-29 16:17:48', '2024-06-29 16:17:48', 1),
(3, 4, 'Legend', 1984, '2024-06-29 16:17:56', '2024-06-29 16:17:56', 1),
(4, 5, 'Rastaman Vibration', 1976, '2024-06-29 16:18:11', '2024-06-29 16:18:11', 1),
(5, 6, 'Survival', 1979, '2024-06-29 16:18:21', '2024-06-29 16:18:21', 1),
(6, 7, 'Uprising', 1980, '2024-06-29 16:18:28', '2024-06-29 16:18:28', 1),
(7, 9, '2 Times Revolution', 2011, '2024-06-29 16:18:37', '2024-06-29 16:18:37', 1),
(8, 11, 'Coup de Gueule', 2004, '2024-06-29 16:18:56', '2024-06-29 16:18:56', 1);

-- --------------------------------------------------------

--
-- Structure de la table `album_format`
--

CREATE TABLE `album_format` (
  `album_id` int(11) NOT NULL,
  `format_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `album_format`
--

INSERT INTO `album_format` (`album_id`, `format_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(2, 1),
(2, 2),
(2, 3),
(2, 4),
(3, 1),
(3, 2),
(3, 3),
(3, 4),
(4, 1),
(4, 2),
(4, 3),
(4, 4),
(5, 1),
(5, 2),
(5, 3),
(5, 4),
(6, 1),
(6, 2),
(6, 3),
(6, 4),
(7, 1),
(7, 2),
(8, 1),
(8, 2);

-- --------------------------------------------------------

--
-- Structure de la table `album_song`
--

CREATE TABLE `album_song` (
  `album_id` int(11) NOT NULL,
  `song_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `album_song`
--

INSERT INTO `album_song` (`album_id`, `song_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(1, 6),
(1, 7),
(1, 8),
(1, 9),
(1, 10),
(2, 11),
(2, 12),
(2, 13),
(2, 14),
(2, 15),
(2, 16),
(3, 5),
(3, 6),
(3, 7),
(3, 9),
(3, 10),
(3, 11),
(3, 13),
(3, 17),
(3, 18),
(3, 19),
(3, 20),
(3, 21),
(3, 22),
(3, 23),
(4, 24),
(4, 25),
(4, 26),
(4, 27),
(4, 28),
(4, 29),
(4, 30),
(4, 31),
(4, 32),
(4, 33),
(5, 2),
(5, 34),
(5, 35),
(5, 36),
(5, 37),
(5, 38),
(5, 39),
(5, 40),
(5, 41),
(6, 19),
(6, 22),
(6, 42),
(6, 43),
(6, 44),
(6, 45),
(6, 46),
(6, 47),
(6, 48),
(6, 49),
(7, 50),
(7, 51),
(7, 52),
(7, 53),
(7, 54),
(7, 55),
(7, 56),
(7, 57),
(7, 58),
(7, 59),
(7, 60),
(7, 61),
(7, 62),
(7, 63),
(7, 64),
(7, 65),
(8, 66),
(8, 67),
(8, 68),
(8, 69),
(8, 70),
(8, 71),
(8, 72),
(8, 73),
(8, 74),
(8, 75),
(8, 76),
(8, 77),
(8, 78),
(8, 79),
(8, 80);

-- --------------------------------------------------------

--
-- Structure de la table `artists`
--

CREATE TABLE `artists` (
  `id` int(11) NOT NULL,
  `media_id` int(11) NOT NULL,
  `country_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `birth_date` date NOT NULL,
  `death_date` date DEFAULT NULL,
  `valid` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `artists`
--

INSERT INTO `artists` (`id`, `media_id`, `country_id`, `name`, `description`, `birth_date`, `death_date`, `valid`) VALUES
(1, 1, 1, 'Bob Marley', 'Bob Marley, légendaire icône du reggae, a répandu un message de paix et d\'unité à travers sa musique intemporelle.', '1945-02-06', '1981-05-11', 1),
(2, 8, 2, 'Alborosie', 'Reggae artiste, producteur et compositeur', '1977-07-04', NULL, 1),
(3, 10, 3, 'Tiken Jah Fakoly', 'Figure majeure du reggae africain, engagé politiquement', '1968-06-23', NULL, 1),
(4, 12, 3, 'Alpha Blondy', 'Légende du reggae africain, porteur de messages sociaux et politiques', '1953-01-01', NULL, 1),
(5, 14, 1, 'Damian Marley', 'Artiste de reggae primé, fils de Bob Marley', '1978-07-21', NULL, 1),
(6, 15, 4, 'Eminem', 'Rappeur emblématique, paroles crues et introspectives', '1972-10-17', NULL, 1),
(7, 16, 4, 'Harrison Stafford', 'Leader du groupe de reggae Groundation, musicien et militant', '1969-04-21', NULL, 1),
(8, 17, 4, 'Ice Cube', 'Rappeur, acteur et producteur, membre fondateur de N.W.A', '1969-06-15', NULL, 1),
(9, 18, 5, 'Ilements', 'Artiste reggae engagé, porteur de messages spirituels et sociaux', '1986-11-30', NULL, 1),
(10, 19, 5, 'Naâman', 'Artiste reggae talentueux, fusionnant reggae, hip-hop et soul', '1990-02-25', NULL, 1),
(11, 20, 5, 'Pierpoljak', 'Artiste reggae français, connu pour ses chansons festives et engagées', '1964-09-07', NULL, 1),
(12, 21, 4, 'Tupac Shakur', 'Légende du rap, poète et activiste, influent dans la culture hip-hop', '1971-06-16', '1996-09-13', 1);

-- --------------------------------------------------------

--
-- Structure de la table `artist_album`
--

CREATE TABLE `artist_album` (
  `artist_id` int(11) NOT NULL,
  `album_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `artist_album`
--

INSERT INTO `artist_album` (`artist_id`, `album_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(1, 6),
(2, 7),
(3, 8);

-- --------------------------------------------------------

--
-- Structure de la table `artist_song`
--

CREATE TABLE `artist_song` (
  `artist_id` int(11) NOT NULL,
  `song_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `artist_song`
--

INSERT INTO `artist_song` (`artist_id`, `song_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(1, 6),
(1, 7),
(1, 8),
(1, 9),
(1, 10),
(1, 11),
(1, 12),
(1, 13),
(1, 14),
(1, 15),
(1, 16),
(1, 17),
(1, 18),
(1, 19),
(1, 20),
(1, 21),
(1, 22),
(1, 23),
(1, 24),
(1, 25),
(1, 26),
(1, 27),
(1, 28),
(1, 29),
(1, 30),
(1, 31),
(1, 32),
(1, 33),
(1, 34),
(1, 35),
(1, 36),
(1, 37),
(1, 38),
(1, 39),
(1, 40),
(1, 41),
(1, 42),
(1, 43),
(1, 44),
(1, 45),
(1, 46),
(1, 47),
(1, 48),
(1, 49),
(2, 50),
(2, 51),
(2, 52),
(2, 53),
(2, 54),
(2, 55),
(2, 56),
(2, 57),
(2, 58),
(2, 59),
(2, 60),
(2, 61),
(2, 62),
(2, 63),
(2, 64),
(2, 65),
(3, 66),
(3, 67),
(3, 68),
(3, 69),
(3, 70),
(3, 71),
(3, 72),
(3, 73),
(3, 74),
(3, 75),
(3, 76),
(3, 77),
(3, 78),
(3, 79),
(3, 80),
(4, 81),
(5, 81),
(6, 81),
(7, 81),
(8, 81),
(9, 81),
(10, 81),
(11, 81),
(12, 81);

-- --------------------------------------------------------

--
-- Structure de la table `countries`
--

CREATE TABLE `countries` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `countries`
--

INSERT INTO `countries` (`id`, `name`) VALUES
(1, 'Jamaïque'),
(2, 'Italie'),
(3, 'Côte d\'Ivoire'),
(4, 'États-Unis'),
(5, 'France');

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `formats`
--

CREATE TABLE `formats` (
  `id` int(11) NOT NULL,
  `libelle` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `formats`
--

INSERT INTO `formats` (`id`, `libelle`) VALUES
(1, 'CD'),
(2, ' 33T'),
(3, ' 45T'),
(4, ' K7'),
(5, '');

-- --------------------------------------------------------

--
-- Structure de la table `genres`
--

CREATE TABLE `genres` (
  `id` int(11) NOT NULL,
  `libelle` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `genres`
--

INSERT INTO `genres` (`id`, `libelle`) VALUES
(1, 'Reggae'),
(2, '');

-- --------------------------------------------------------

--
-- Structure de la table `medias`
--

CREATE TABLE `medias` (
  `id` int(11) NOT NULL,
  `url` varchar(255) NOT NULL,
  `alt` varchar(255) NOT NULL,
  `url_source` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `medias`
--

INSERT INTO `medias` (`id`, `url`, `alt`, `url_source`) VALUES
(1, 'Bob Marley.jpg', 'Bob Marley', 'https://img.nrj.fr/VHLqHiQjV0lFGcp_O7Tm6Kr2lAk=/0x450/smart/http%3A%2F%2Fmedia.nrj.fr%2Fraw%2F2020%2F07%2Fbob-marley-retour-sur-ses-plus-grands-concerts-1595254123.jpg'),
(2, 'Exodus.jpg', 'Exodus', 'https://m.media-amazon.com/images/I/81J3LJGOsfL._UF1000,1000_QL80_.jpg'),
(3, 'Burnin.jpg', 'Burnin', 'https://m.media-amazon.com/images/I/81imoxLfpUL._SL1400_.jpg'),
(4, 'Legend.jpg', 'Legend', 'https://m.media-amazon.com/images/I/71EFb-BEAeL._SL1400_.jpg'),
(5, 'Rastaman Vibration.jpg', 'Rastaman Vibration', 'https://www.melodisque.com/wp-content/uploads/2020/05/bob-marley-rastaman.jpg'),
(6, 'Survival.jpg', 'Survival', 'https://i.ebayimg.com/images/g/ZNwAAOSwPKtlhBy4/s-l1600.jpg'),
(7, 'Uprising.jpg', 'Uprising', 'https://i.ebayimg.com/images/g/ZNwAAOSwPKtlhBy4/s-l1600.jpg'),
(8, 'Alborosie.jpg', 'Alborosie', 'https://swiftmedia.s3.amazonaws.com/pacific.swiftcom.com/images/sites/5/2018/04/15090807/Alborosie-act-041418.jpg'),
(9, '2 Times Revolution.jpg', '2 Times Revolution', 'https://e-cdn-images.dzcdn.net/images/cover/8753878c554fe8a6c7de4c5c0a160138/500x500-000000-80-0-0.jpg'),
(10, 'Tiken Jah Fakoly.jpg', 'Tiken Jah Fakoly', 'https://mobile-img.lpcdn.ca/lpca/924x/182e9a18/c21e0c3b-916f-11e9-9f79-0e7266730414.jpg'),
(11, 'Coup de Gueule.jpg', 'Coup de Gueule', 'https://m.media-amazon.com/images/I/A11yFGIM76L._SL1500_.jpg'),
(12, 'Alpha Blondy.jpg', 'Alpha Blondy', 'https://www.solidays.org/wp-content/uploads/2021/05/alpha-bondy-1140x570.jpg'),
(13, 'Coup de Gueule.jpg', '', ''),
(14, 'Damian Marley.jpg', 'Damian Marley', 'https://media.contentapi.ea.com/content/www-easports/fr_FR/fifa/ultimate-team/news/2016/damian-marley-interview/_jcr_content/headerImages/image.img.jpg'),
(15, 'Eminem.jpg', 'Eminem', 'https://img.nrj.fr/GaiD9jo5tC3QaFZ76AJEyBh_SXE=/0x450/smart/http%3A%2F%2Fmedia.nrj.fr%2F1900x1200%2F2018%2F01%2Feminem_7983.jpg'),
(16, 'Harrison Stafford.jpg', 'Harrison Stafford', 'https://www.lagrosseradio.com/_images/fck/36336.jpg'),
(17, 'Ice Cube.jpg', 'Ice Cube', 'https://images.ladepeche.fr/api/v1/images/view/5c37d86c8fe56f3e6754d5a0/full/image.jpg'),
(18, 'Ilements.jpeg', 'Ilements', 'https://photos.bandsintown.com/thumb/212645.jpeg'),
(19, 'Naâman.jpg', 'Naâman', 'https://www.reggae.fr/uploads/articles_photos/large/4477.jpg'),
(20, 'Pierpoljak.jpg', 'Pierpoljak', 'https://media.lhebdoduvendredi.com/illustrations/00020938_normal.jpg'),
(21, 'Tupac Shakur.jpg', 'Tupac Shakur', 'https://www.francetvinfo.fr/pictures/JLnUA5cKZTgglJktgdI0w8PBNsI/36x0:623x330/2656x1494/filters:format(avif):quality(50)/2019/04/12/tupacpoeticjusticeok.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `messenger_messages`
--

CREATE TABLE `messenger_messages` (
  `id` bigint(20) NOT NULL,
  `body` longtext NOT NULL,
  `headers` longtext NOT NULL,
  `queue_name` varchar(190) NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `available_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `delivered_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `songs`
--

CREATE TABLE `songs` (
  `id` int(11) NOT NULL,
  `genre_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `duration` int(11) NOT NULL,
  `valid` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `songs`
--

INSERT INTO `songs` (`id`, `genre_id`, `title`, `description`, `duration`, `valid`) VALUES
(1, 1, 'Natural Mystic', 'Une méditation atmosphérique sur les mystères de la vie.', 141, 1),
(2, 1, 'So Much Trouble in the World', 'Une réflexion sur les défis de la vie et les luttes de la société.', 141, 1),
(3, 1, 'Guiltiness', 'Une chanson sur la culpabilité et la rédemption.', 141, 1),
(4, 1, 'The Heathen', 'Un appel à la conscience et à la réforme spirituelle.', 141, 1),
(5, 1, 'Exodus', 'Une chanson sur le thème de l\'exode biblique, avec des références à la quête de liberté et à l\'oppression.', 141, 1),
(6, 1, 'Jamming', 'Une chanson légère et entraînante sur la joie de la musique et du rassemblement.', 141, 1),
(7, 1, 'Waiting in Vain', 'Une ballade d\'amour sur l\'attente et l\'espoir.', 141, 1),
(8, 1, 'Turn Your Lights Down Low', 'Une chanson d\'amour sensuelle et romantique.', 141, 1),
(9, 1, 'Three Little Birds', 'Un hymne optimiste sur la persévérance malgré les difficultés de la vie.', 141, 1),
(10, 1, 'One Love/People Get Ready', 'Un appel à l\'unité et à l\'amour universel.', 141, 1),
(11, 1, 'Get Up, Stand Up', 'Un appel à l\'action et à la protestation contre l\'injustice sociale.', 141, 1),
(12, 1, 'Hallelujah Time', 'Une célébration de la vie malgré les épreuves.', 141, 1),
(13, 1, 'I Shot the Sheriff', 'Une chanson narrative sur un homme qui avoue avoir tué le shérif mais nie avoir tué le deputy.', 141, 1),
(14, 1, 'Burnin\' and Lootin\'', 'Une critique des émeutes et de la violence urbaine.', 141, 1),
(15, 1, 'Put It On', 'Une chanson sur l\'importance de rester fidèle à soi-même et à ses principes.', 141, 1),
(16, 1, 'Small Axe', 'Une métaphore sur la puissance du peuple opprimé.', 141, 1),
(17, 1, 'Is This Love', 'Une chanson d\'amour emblématique avec une mélodie accrocheuse et des paroles romantiques.', 141, 1),
(18, 1, 'No Woman, No Cry', 'Une ballade émouvante sur la lutte et la résilience dans les moments difficiles.', 141, 1),
(19, 1, 'Could You Be Loved', 'Une chanson entraînante avec des éléments pop, sur l\'amour et l\'acceptation.', 141, 1),
(20, 1, 'Buffalo Soldier', 'Une chanson sur les soldats afro-américains de la cavalerie de l\'armée américaine.', 141, 1),
(21, 1, 'Stir It Up', 'Une chanson sensuelle sur l\'amour et la passion.', 141, 1),
(22, 1, 'Redemption Song', 'Une piste acoustique profonde et introspective, centrée sur l\'autonomisation personnelle et l\'espoir.', 141, 1),
(23, 1, 'Satisfy My Soul', 'Une chanson sensuelle sur le désir et la connexion émotionnelle.', 141, 1),
(24, 1, 'Positive Vibration', 'Une chanson énergique et optimiste sur la puissance de la pensée positive.', 141, 1),
(25, 1, 'Roots, Rock, Reggae', 'Une célébration de la musique reggae en tant que force unificatrice et expression culturelle.', 141, 1),
(26, 1, 'Johnny Was', 'Une chanson sur la violence politique et ses conséquences.', 141, 1),
(27, 1, 'Cry to Me', 'Une chanson émotionnelle sur le besoin de réconfort dans les moments difficiles.', 141, 1),
(28, 1, 'Want More', 'Une invitation à chercher plus dans la vie et à viser plus haut.', 141, 1),
(29, 1, 'Crazy Baldhead', 'Une critique des oppressions sociales et politiques.', 141, 1),
(30, 1, 'Who the Cap Fit', 'Une réflexion sur l\'authenticité et l\'intégrité personnelle.', 141, 1),
(31, 1, 'Night Shift', 'Une chanson sur le dur labeur et les sacrifices.', 141, 1),
(32, 1, 'War', 'Une adaptation d\'un discours de Haile Selassie I à l\'ONU, exprimant le rejet de la guerre et de l\'oppression.', 141, 1),
(33, 1, 'Rat Race', 'Une critique de la compétition et du matérialisme.', 141, 1),
(34, 1, 'Zimbabwe', 'Un hommage à la lutte pour l\'indépendance du Zimbabwe et à la solidarité africaine.', 141, 1),
(35, 1, 'Top Rankin\'', 'Une chanson sur le combat pour la reconnaissance et le respect.', 141, 1),
(36, 1, 'Babylon System', 'Une critique du système politique et économique mondial.', 141, 1),
(37, 1, 'Survival', 'Un appel à la résilience et à la survie dans un monde plein de défis.', 141, 1),
(38, 1, 'Africa Unite', 'Un appel à l\'unité et à la solidarité entre les peuples africains.', 141, 1),
(39, 1, 'One Drop', 'Une chanson sur le groove et le rythme caractéristiques du reggae.', 141, 1),
(40, 1, 'Ride Natty Ride', 'Une célébration de la culture rasta et de la résistance spirituelle.', 141, 1),
(41, 1, 'Ambush in the Night', 'Une chanson sur la persécution politique et l\'oppression.', 141, 1),
(42, 1, 'Coming in from the Cold', 'Une chanson sur l\'acceptation et le pardon après des conflits personnels.', 141, 1),
(43, 1, 'Real Situation', 'Une réflexion sur la réalité et la vérité dans un monde en évolution.', 141, 1),
(44, 1, 'Bad Card', 'Une critique des hypocrisies sociales et politiques.', 141, 1),
(45, 1, 'We and Dem', 'Une chanson sur la division et l\'unité dans la société.', 141, 1),
(46, 1, 'Work', 'Une méditation sur le travail et la persévérance.', 141, 1),
(47, 1, 'Zion Train', 'Une métaphore sur le voyage spirituel et la quête de vérité.', 141, 1),
(48, 1, 'Pimper\'s Paradise', 'Une critique des excès et des illusions matérialistes.', 141, 1),
(49, 1, 'Forever Loving Jah', 'Une méditation sur la foi et la dévotion à Jah (Dieu) dans un monde en mutation.', 141, 1),
(50, 1, 'Rolling Like a Rock', 'Une chanson énergique avec des rythmes percutants et des paroles affirmant la force intérieure.', 208, 1),
(51, 1, 'Respect', 'Collaboration puissante avec des messages de respect et d\'unité, portée par des harmonies vocales vibrantes.', 204, 1),
(52, 1, 'Who You Think You Are', 'Critique sociale sur l\'authenticité et l\'intégrité personnelle, avec un rythme entraînant et des paroles percutantes.', 219, 1),
(53, 1, 'La Revolucion', 'Célébration de la révolution intérieure et du changement personnel, avec des accents reggae caractéristiques.', 225, 1),
(54, 1, 'I Wanna Go Home', 'Ballade émotionnelle sur le désir de retourner à ses racines, portée par des mélodies douces et poignantes.', 213, 1),
(55, 1, 'You Make Me Feel Good', 'Chanson d\'amour douce et soulful avec des harmonies envoûtantes, évoquant un sentiment de bonheur et de plénitude.', 223, 1),
(56, 1, 'International Drama', 'Réflexion sur les conflits mondiaux et la nécessité de paix, avec des influences reggae et des sonorités contemporaines.', 270, 1),
(57, 1, 'Camilla', 'Chanson d\'amour tendre et poétique, mettant en valeur la douceur des sentiments et des émotions.', 208, 1),
(58, 1, 'Tax War', 'Critique politique sur les taxes et les injustices économiques, portée par un rythme entraînant et des paroles incisives.', 191, 1),
(59, 1, 'Jesus Is Coming', 'Méditation spirituelle sur la seconde venue de Jésus et les questions religieuses, avec des sonorités reggae caractéristiques.', 223, 1),
(60, 1, 'Ragamuffin', 'Hymne reggae affirmant l\'identité et la fierté culturelle, avec des rythmes accrocheurs et des paroles édifiantes.', 225, 1),
(61, 1, 'Soul Train', 'Morceau funk/reggae entraînant avec des grooves irrésistibles et une ambiance festive.', 228, 1),
(62, 1, 'Grow Your Dreads', 'Célébration de la culture rasta et de l\'identité personnelle, avec des sonorités reggae authentiques et des paroles inspirantes.', 215, 1),
(63, 1, 'Rude Bwoy Love', 'Explorant les thèmes de l\'amour et de la loyauté, avec des influences reggae et des éléments de dancehall.', 256, 1),
(64, 1, 'What If Jamaica', 'Réflexion sur l\'état de la Jamaïque et les perspectives d\'avenir, portée par des rythmes reggae envoûtants.', 232, 1),
(65, 1, 'Games', 'Exploration des dynamiques de pouvoir et de manipulation, avec des rythmes reggae captivants et des paroles incisives.', 219, 1),
(66, 1, 'Quitte le pouvoir', 'Un appel vibrant à la fin des dictatures en Afrique.', 141, 1),
(67, 1, 'Cours d\'histoire', 'Une leçon d\'histoire engagée, dénonçant les injustices passées.', 141, 1),
(68, 1, 'L\'Africain', 'Une célébration de l\'identité africaine et de la fierté.', 141, 1),
(69, 1, 'Quitte le pouvoir (part 2)', 'Une continuation du premier titre, renforçant l\'appel à la fin des régimes oppressifs.', 141, 1),
(70, 1, 'Justice', 'Une demande de justice pour tous, avec des paroles poignantes dénonçant les inégalités.', 141, 1),
(71, 1, 'Y\'en a marre', 'Un cri de ras-le-bol contre la corruption et l\'injustice sociale.', 141, 1),
(72, 1, 'Africain à Paris', 'Une réflexion sur l\'expérience de l\'immigrant africain en Europe.', 141, 1),
(73, 1, 'Ouvrez les frontières', 'Un plaidoyer pour l\'ouverture des frontières et la libre circulation des personnes.', 141, 1),
(74, 1, 'J\'ai besoin de changement', 'Une chanson sur le besoin urgent de changement politique et social.', 141, 1),
(75, 1, 'Libérez', 'Un appel à la libération des prisonniers politiques et des prisonniers d\'opinion.', 141, 1),
(76, 1, 'Allah', 'Une méditation spirituelle sur la foi et l\'espoir.', 141, 1),
(77, 1, 'Les martyrs', 'Un hommage aux héros tombés pour la liberté et la justice en Afrique.', 141, 1),
(78, 1, 'Cameroun', 'Une chanson dédiée au Cameroun, mettant en lumière ses défis et ses espoirs.', 141, 1),
(79, 1, 'Balayer', 'Une invitation à balayer la corruption et l\'injustice de nos sociétés.', 141, 1),
(80, 1, 'Les fronts sont désormais fermés', 'Une conclusion puissante, affirmant la détermination à combattre les oppresseurs.', 141, 1),
(81, 2, '', '', 0, 1);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `roles` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL COMMENT '(DC2Type:json)' CHECK (json_valid(`roles`)),
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `is_verified` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `username`, `roles`, `email`, `password`, `created_at`, `is_verified`) VALUES
(2, 'plop', '[\"ROLE_USER\"]', 'skull-2@hotmail.fr', '$2y$13$COdIGyOXJeE7UW1JiSpMHOh6L4XvPdBF/b7iTPdIJCwScIVNTUvoy', '2024-04-05 14:35:00', 1),
(9, 'brice', '[\"ROLE_USER\", \"ROLE_ADMIN\"]', 'brice.rubeaux@wanadoo.fr', '$2y$13$yiXi9w81/Ls6lR8nMGX/2uQ1Vk41eDpYRkZ/iNo7Cvl5ydZc5Y1jO', '2024-06-23 18:58:11', 1),
(11, 'azerty', '[\"ROLE_USER\"]', 'brubeaux.iris08@gmail.com', '$2y$13$3YJKNXbGz0mK38lhuK2cCed0x6C8nPw0EIbeJjS/vJlzcdHCr1sKy', '2024-06-26 15:13:13', 1);

-- --------------------------------------------------------

--
-- Structure de la table `user_album_format`
--

CREATE TABLE `user_album_format` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `album_id` int(11) NOT NULL,
  `format_id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `albums`
--
ALTER TABLE `albums`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_F4E2474FEA9FDD75` (`media_id`);

--
-- Index pour la table `album_format`
--
ALTER TABLE `album_format`
  ADD PRIMARY KEY (`album_id`,`format_id`),
  ADD KEY `IDX_CC14F681137ABCF` (`album_id`),
  ADD KEY `IDX_CC14F68D629F605` (`format_id`);

--
-- Index pour la table `album_song`
--
ALTER TABLE `album_song`
  ADD PRIMARY KEY (`album_id`,`song_id`),
  ADD KEY `IDX_57E658E11137ABCF` (`album_id`),
  ADD KEY `IDX_57E658E1A0BDB2F3` (`song_id`);

--
-- Index pour la table `artists`
--
ALTER TABLE `artists`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_68D3801EEA9FDD75` (`media_id`),
  ADD KEY `IDX_68D3801EF92F3E70` (`country_id`);

--
-- Index pour la table `artist_album`
--
ALTER TABLE `artist_album`
  ADD PRIMARY KEY (`artist_id`,`album_id`),
  ADD KEY `IDX_59945E10B7970CF8` (`artist_id`),
  ADD KEY `IDX_59945E101137ABCF` (`album_id`);

--
-- Index pour la table `artist_song`
--
ALTER TABLE `artist_song`
  ADD PRIMARY KEY (`artist_id`,`song_id`),
  ADD KEY `IDX_8F53683EB7970CF8` (`artist_id`),
  ADD KEY `IDX_8F53683EA0BDB2F3` (`song_id`);

--
-- Index pour la table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Index pour la table `formats`
--
ALTER TABLE `formats`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `genres`
--
ALTER TABLE `genres`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `medias`
--
ALTER TABLE `medias`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  ADD KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  ADD KEY `IDX_75EA56E016BA31DB` (`delivered_at`);

--
-- Index pour la table `songs`
--
ALTER TABLE `songs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_BAECB19B4296D31F` (`genre_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `user_album_format`
--
ALTER TABLE `user_album_format`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_8C0D336AA76ED395` (`user_id`),
  ADD KEY `IDX_8C0D336A1137ABCF` (`album_id`),
  ADD KEY `IDX_8C0D336AD629F605` (`format_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `albums`
--
ALTER TABLE `albums`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `artists`
--
ALTER TABLE `artists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `formats`
--
ALTER TABLE `formats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `genres`
--
ALTER TABLE `genres`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `medias`
--
ALTER TABLE `medias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT pour la table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `songs`
--
ALTER TABLE `songs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `user_album_format`
--
ALTER TABLE `user_album_format`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `albums`
--
ALTER TABLE `albums`
  ADD CONSTRAINT `FK_F4E2474FEA9FDD75` FOREIGN KEY (`media_id`) REFERENCES `medias` (`id`);

--
-- Contraintes pour la table `album_format`
--
ALTER TABLE `album_format`
  ADD CONSTRAINT `FK_CC14F681137ABCF` FOREIGN KEY (`album_id`) REFERENCES `albums` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_CC14F68D629F605` FOREIGN KEY (`format_id`) REFERENCES `formats` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `album_song`
--
ALTER TABLE `album_song`
  ADD CONSTRAINT `FK_57E658E11137ABCF` FOREIGN KEY (`album_id`) REFERENCES `albums` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_57E658E1A0BDB2F3` FOREIGN KEY (`song_id`) REFERENCES `songs` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `artists`
--
ALTER TABLE `artists`
  ADD CONSTRAINT `FK_68D3801EEA9FDD75` FOREIGN KEY (`media_id`) REFERENCES `medias` (`id`),
  ADD CONSTRAINT `FK_68D3801EF92F3E70` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`);

--
-- Contraintes pour la table `artist_album`
--
ALTER TABLE `artist_album`
  ADD CONSTRAINT `FK_59945E101137ABCF` FOREIGN KEY (`album_id`) REFERENCES `albums` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_59945E10B7970CF8` FOREIGN KEY (`artist_id`) REFERENCES `artists` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `artist_song`
--
ALTER TABLE `artist_song`
  ADD CONSTRAINT `FK_8F53683EA0BDB2F3` FOREIGN KEY (`song_id`) REFERENCES `songs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_8F53683EB7970CF8` FOREIGN KEY (`artist_id`) REFERENCES `artists` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `songs`
--
ALTER TABLE `songs`
  ADD CONSTRAINT `FK_BAECB19B4296D31F` FOREIGN KEY (`genre_id`) REFERENCES `genres` (`id`);

--
-- Contraintes pour la table `user_album_format`
--
ALTER TABLE `user_album_format`
  ADD CONSTRAINT `FK_8C0D336A1137ABCF` FOREIGN KEY (`album_id`) REFERENCES `albums` (`id`),
  ADD CONSTRAINT `FK_8C0D336AA76ED395` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `FK_8C0D336AD629F605` FOREIGN KEY (`format_id`) REFERENCES `formats` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
