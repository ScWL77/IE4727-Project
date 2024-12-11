-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 27, 2024 at 11:11 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `golden_gate_cinema`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `bookingID` int(11) NOT NULL,
  `userID` int(11) DEFAULT NULL,
  `movieID` int(11) DEFAULT NULL,
  `seatsSelected` text DEFAULT NULL,
  `outlet` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `time` time DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `numberOfTickets` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`bookingID`, `userID`, `movieID`, `seatsSelected`, `outlet`, `date`, `time`, `total`, `numberOfTickets`) VALUES
(5, 0, 1, 'B2', 'GGC JEM', '2024-11-03', '10:15:00', 13.00, 1),
(6, 0, 2, 'C9, C10', 'GGC JEM', '2024-11-03', '10:15:00', 26.00, 2),
(15, 1, 2, 'A9, A10, A11, A12, A13', 'GGC Vivocity', '2024-11-03', '10:15:00', 65.00, 5);

-- --------------------------------------------------------

--
-- Table structure for table `movies`
--

CREATE TABLE `movies` (
  `id` int(11) NOT NULL,
  `poster` varchar(255) DEFAULT NULL,
  `title` varchar(100) NOT NULL,
  `classification` varchar(255) DEFAULT NULL,
  `synopsis` text DEFAULT NULL,
  `director` varchar(100) DEFAULT NULL,
  `duration` int(11) DEFAULT NULL,
  `genre` varchar(50) DEFAULT NULL,
  `cast` text DEFAULT NULL,
  `release_date` date DEFAULT NULL,
  `language` varchar(50) DEFAULT NULL,
  `show_status` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `movies`
--

INSERT INTO `movies` (`id`, `poster`, `title`, `classification`, `synopsis`, `director`, `duration`, `genre`, `cast`, `release_date`, `language`, `show_status`) VALUES
(1, '..\\assets\\inside_out_2.png', 'Disney and Pixar’s Inside Out 2', '..\\assets\\PG.png', 'The mind of newly minted teenager Riley is undergoing a sudden demolition to make room for something entirely unexpected: new Emotions! Joy, Sadness, Anger, Fear and Disgust, who`ve long been running a successful operation by all accounts, aren\'t sure how to feel when Anxiety shows up. And it looks like she’s not alone.', 'Kelsey Mann', 97, 'Animation, Adventure, Comedy', 'Amy Poehler, Phyllis Smith, Lewis Black, Tony Hale, Liza Lapira, Maya Hawke', '2024-06-13', 'English (with Chinese subtitles)', 'airing'),
(2, '..\\assets\\despicable_me_4.png', 'Despicable Me 4', '..\\assets\\PG13.png', 'Gru, Lucy, Margo, Edith, and Agnes welcome a new member to the family, Gru Jr., who is intent on tormenting his dad. Gru faces a new nemesis in Maxime Le Mal and his girlfriend Valentina, and the family is forced to go on the run.', 'Chris Renaud', 95, 'Animation, Comedy, Adventure', 'Steve Carell, Kristen Wiig, Will Ferrell, Pierre Coffin, Joey King, Sofia Vergara, Stephen Colbert, Miranda Cosgrove, Chloe Fineman, Steve Coogan, Chris Renaud, Dana Gaier, Madison Polan', '2024-07-04', 'English (with Chinese subtitles)', 'airing'),
(3, '..\\assets\\red_one.png', 'Red One', '..\\assets\\PG13.png', 'After Santa Claus – Code Name: RED ONE – is kidnapped, the North Pole\'s Head of Security (Dwayne Johnson) must team up with the world’s most infamous bounty hunter (Chris Evans) in a globe-trotting, action-packed mission to save Christmas.', 'Jake Kasdan', 123, 'Action, Comedy, Adventure', 'Dwayne Johnson, Chris Evans, Lucy Liu', '2024-11-07', 'English (with Chinese subtitles)', 'coming soon'),
(4, '..\\assets\\my_dearest_fu_bao.png', 'My Dearest Fu Bao', '..\\assets\\PG.png', '“Hello, and goodbye.”\n\nA miraculous encounter, a heartbreaking farewell.\n\nAfter her miraculous birth in Korea, giant panda Fu Bao gained tremendous popularity and love from her fans worldwide. While her upcoming return to China is leaving fans in sorrow, her zookeepers continue their duty to make Fu Bao happy and solemnly start preparing her trip to China. As the expected day of farewell approaches, the zookeepers have to confront another unexpected farewell, and cannot but give in to the emotions they have been holding back. Knowing they must say goodbye soon, they cherish and treasure each day leading up to the farewell.\n\nA touching and beautiful journey of Fu Bao and her zookeepers, from the miraculous first encounter to the last farewell.', 'Shim Hyeong-jun, Thomas Ko', 94, 'Documentary', 'Fu Bao, Ai Bao, Le Bao, Rui Bao, Hui Bao, Kang Cher-won, Song Young-kwan, Oh Seung-hee', '2024-09-26', 'Korean (with English/Chinese subtitles)', 'airing'),
(5, '..\\assets\\venom_the_last_dance.png', 'Venom: The Last Dance', '..\\assets\\PG13.png', 'In Venom: The Last Dance, Tom Hardy returns as Venom, one of Marvel’s greatest and most complex characters, for the final film in the trilogy. Eddie and Venom are on the run. Hunted by both of their worlds and with the net closing in, the duo are forced into a devastating decision that will bring the curtains down on Venom and Eddie\'s last dance.', 'Kelly Marcel', 109, 'Action, Adventure', 'Tom Hardy, Chiwetel Ejiofor, Juno Temple, Rhys Ifans, Peggy Lu, Alanna Ubach, Stephen Graham', '2024-10-24', 'English (with Chinese subtitles)', 'airing'),
(6, '..\\assets\\gladiator_2.png', 'Gladiator II', '..\\assets\\M18.png', 'From legendary director Ridley Scott, Gladiator II continues the epic saga of power, intrigue, and vengeance set in Ancient Rome. Years after witnessing the death of the revered hero Maximus at the hands of his uncle, Lucius (Paul Mescal) is forced to enter the Colosseum after his home is conquered by the tyrannical Emperors who now lead Rome with an iron fist. With rage in his heart and the future of the Empire at stake, Lucius must look to his past to find strength and honor to return the glory of Rome to its people.', 'Ridley Scott', 148, 'Action, Adventure', 'Paul Mescal, Pedro Pascal, Joseph Quinn, Fred Hechinger, Lior Raz, Derek Jacobi, Connie Nielsen, Denzel Washington', '2024-11-14', 'English (with Chinese subtitles)', 'advance sales'),
(7, '..\\assets\\anora.png', 'Anora', '..\\assets\\R21.png', 'Anora, a young sex worker from Brooklyn, gets her chance at a Cinderella story when she meets and impulsively marries the son of an oligarch. Once the news reaches Russia, her fairytale is threatened as his parents set out for New York to get the marriage annulled.', 'Sean Baker', 139, 'Comedy, Drama', 'Mikey Madison, Mark Eidelstein, Yura Borisov, Karren Karagulian, Vache Tovmasyan, Aleksei Serebryakov', '2024-10-31', 'English', 'airing'),
(8, '..\\assets\\moana_2.png', 'Disney’s Moana 2', '..\\assets\\PG.png', '“Moana 2” reunites Moana and Maui three years later for an expansive new voyage alongside a crew of unlikely seafarers. After receiving an unexpected call from her wayfinding ancestors, Moana must journey to the far seas of Oceania and into dangerous, long-lost waters for an adventure unlike anything she’s ever faced.', 'David Derrick Jr.', 100, 'Animation', 'Auliʻi Cravalho, Dwayne Johnson, Temuera Morrison, Nicole Scherzinger, Khaleesi Lambert-Tsuda, Rose Matafeo, David Fane, Hualālai Chung, Alan Tudyk', '2024-11-28', 'English (with Chinese Subtitles)', 'coming soon');

-- --------------------------------------------------------

--
-- Table structure for table `outlets`
--

CREATE TABLE `outlets` (
  `id` int(11) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `address` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `outlets`
--

INSERT INTO `outlets` (`id`, `photo`, `name`, `address`) VALUES
(1, '..\\assets\\vivo.jpg', 'GGC Vivocity', '1 HarbourFront Walk, #02-30, VivoCity, Singapore 098585'),
(2, '..\\assets\\jem.jpg', 'GGC JEM', '50 Jurong Gateway Rd, #05-04, JEM, Singapore 608549'),
(3, '..\\assets\\jewel.jpg', 'GGC Jewel', '78 Airport Blvd, #B2-237, Jewel Changi Airport, Singapore 819666'),
(4, '..\\assets\\causeway point.jpg', 'GGC Causeway Point', '1 Woodlands Square, #07-10, Causeway Point, Singapore 738099'),
(5, '..\\assets\\plaza singapura.jpg', 'GGC Plaza Singapura', '68 Orchard Road, #07-01, Plaza Singapura, Singapore 238839');

-- --------------------------------------------------------

--
-- Table structure for table `seats`
--

CREATE TABLE `seats` (
  `seatID` int(11) NOT NULL,
  `movieID` int(11) NOT NULL,
  `movieOutlet` int(11) NOT NULL,
  `showDate` date NOT NULL,
  `showTime` time NOT NULL,
  `seatsAvailable` varchar(255) DEFAULT NULL,
  `seatsOccupied` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `seats`
--

INSERT INTO `seats` (`seatID`, `movieID`, `movieOutlet`, `showDate`, `showTime`, `seatsAvailable`, `seatsOccupied`) VALUES
(1, 2, 1, '2024-11-03', '10:15:00', 'A5,A9,A10,A11,A12,A13,B1,B2,B3,B4,B5,B9,B11,B12,B13,C1,C4,C5,C9,C10,C11,C12,C13,D1,D2,D10,D13', 'A2,A3,A4,B10,B11,B12,C2,C3,D3,D4,D5,A1'),
(2, 2, 2, '2024-11-03', '10:30:00', 'A1, A2, A3, A4, A5, A9, A10, A11, A12, A13, B1, B2, B3, B4, B5, B9, B10, B11, B12, B13, C1, C2, C3, C4, C5, C9, C10, C11, C12, C13, D1, D2, D3, D4, D5, D10, D13', 'B3, B4'),
(3, 2, 3, '2024-11-03', '15:15:00', 'A1, A2, A3, A4, A5, A9, A10, A11, A12, A13, B1, B2, B3, B4, B5, B9, B10, B11, B12, B13, C1, C2, C3, C4, C5, C9, C10, C11, C12, C13, D1, D2, D3, D4, D5, D10, D13', 'C1, C2'),
(4, 2, 4, '2024-11-04', '10:15:00', 'A1,A2,A3,A9,A10,A11,A12,A13,B1,B2,B3,B4,B5,B9,B10,B11,B12,B13,C1,C2,C3,C4,C5,C9,C10,C11,C12,C13,D1,D2,D3,D4,D5,D10,D13', 'A4,A5'),
(5, 2, 3, '2024-11-04', '12:45:00', 'A1, A2, A3, A4, A5, A9, A10, A11, A12, A13, B1, B2, B3, B4, B5, B9, B10, B11, B12, B13, C1, C2, C3, C4, C5, C9, C10, C11, C12, C13, D1, D2, D3, D4, D5, D10, D13', 'B5'),
(6, 2, 5, '2024-11-04', '15:15:00', 'A1, A2, A3, A4, A5, A9, A10, A11, A12, A13, B1, B2, B3, B4, B5, B9, B10, B11, B12, B13, C1, C2, C3, C4, C5, C9, C10, C11, C12, C13, D1, D2, D3, D4, D5, D10, D13', 'D1'),
(7, 2, 1, '2024-11-05', '10:15:00', 'A1, A2, A3, A4, A5, A9, A10, A11, A12, A13, B1, B4, B5, B9, B10, B11, B12, B13, C1, C2, C3, C4, C5,C9, C10, C11, C12, C13, D1, D2, D3, D4, D5, D10, D13', 'B2, B3'),
(8, 1, 4, '2024-11-05', '18:50:00', 'A1, A2, A3, A4, A5, A9, A10, A11, A12, A13 B1, B2, B3, B4, B5, B9, B10, B11, B12, B13, C1, C2, C3, C4, C5, C9, C10, C11, C12, C13, D1, D2, D3, D4, D5, D10, D13', 'C3, C4, C5'),
(9, 2, 2, '2024-11-05', '12:45:00', 'A4, A5, A9, A10, A11, A12, A13, B1, B2, B3, B4, B5, B9, B10, B11, B12, B13, C1, C2, C3, C4, C5, C9, C10, C11, C12, C13, D1, D2, D3, D4, D5, D10, D13', 'A1, A2, A3'),
(28, 4, 2, '2024-11-05', '12:45:00', 'A4, A5, A9, A10, A11, A12, A13, B1, B2, B3, B4, B5, B9, B10, B11, B12, B13, C1, C2, C3, C4, C5, C9, C10, C11, C12, C13, D1, D2, D3, D4, D5, D10, D13', 'A1, A2, A3'),
(29, 5, 2, '2024-11-05', '12:45:00', 'A4, A5, A9, A10, A11, A12, A13, B1, B2, B3, B4, B5, B9, B10, B11, B12, B13, C1, C2, C3, C4, C5, C9, C10, C11, C12, C13, D1, D2, D3, D4, D5, D10, D13', 'A1, A2, A3'),
(30, 6, 2, '2024-11-05', '12:45:00', 'A4, A5, A9, A10, A11, A12, A13, B1, B2, B3, B4, B5, B9, B10, B11, B12, B13, C1, C2, C3, C4, C5, C9, C10, C11, C12, C13, D1, D2, D3, D4, D5, D10, D13', 'A1, A2, A3'),
(31, 7, 2, '2024-11-05', '12:45:00', 'A4, A5, A9, A10, A11, A12, A13, B1, B2, B3, B4, B5, B9, B10, B11, B12, B13, C1, C2, C3, C4, C5, C9, C10, C11, C12, C13, D1, D2, D3, D4, D5, D10, D13', 'A1, A2, A3'),
(32, 4, 2, '2024-11-05', '12:45:00', 'A4, A5, A9, A10, A11, A12, A13, B1, B2, B3, B4, B5, B9, B10, B11, B12, B13, C1, C2, C3, C4, C5, C9, C10, C11, C12, C13, D1, D2, D3, D4, D5, D10, D13', 'A1, A2, A3'),
(33, 1, 1, '2024-11-03', '10:30:00', 'A1, A2, A3, A4, A5, A9, A10, A11, A12, A13, B1, B2, B3, B4, B5, B9, B10, B11, B12, B13, C1, C2, C3, C4, C5, C9, C10, C11, C12, C13, D1, D2, D3, D4, D5, D10, D13', 'A2, A3, A4, B10, B11, B12, C2, C3, D3, D4, D5'),
(34, 1, 1, '2024-11-04', '14:45:00', 'A1, A2, A3, A4, A5, A9, A10, A11, A12, A13, B1, B2, B3, B4, B5, B9, B10, B11, B12, B13, C1, C2, C3, C4, C5, C9, C10, C11, C12, C13, D1, D2, D3, D4, D5, D10, D13', 'B3, B4'),
(35, 1, 2, '2024-11-03', '10:15:00', 'A1, A2, A3, A4, A5, A9, A10, A11, A12, A13, B1, B2, B3, B4, B5, B9, B10, B11, B12, B13, C1, C2, C3, C4, C5, C9, C10, C11, C12, C13, D1, D2, D3, D4, D5, D10, D13', 'C1, C2'),
(36, 1, 2, '2024-11-05', '13:45:00', 'A1,A2,A3,A9,A10,A11,A12,A13,B1,B2,B3,B4,B5,B9,B10,B11,B12,B13,C1,C2,C3,C4,C5,C9,C10,C11,C12,C13,D1,D2,D3,D4,D5,D10,D13', 'A4,A5'),
(37, 1, 3, '2024-11-03', '12:45:00', 'A1, A2, A3, A4, A5, A9, A10, A11, A12, A13, B1, B2, B3, B4, B5, B9, B10, B11, B12, B13, C1, C2, C3, C4, C5, C9, C10, C11, C12, C13, D1, D2, D3, D4, D5, D10, D13', 'B5'),
(38, 1, 3, '2024-11-03', '16:20:00', 'A1, A2, A3, A4, A5, A9, A10, A11, A12, A13, B1, B2, B3, B4, B5, B9, B10, B11, B12, B13, C1, C2, C3, C4, C5, C9, C10, C11, C12, C13, D1, D2, D3, D4, D5, D10, D13', 'D1'),
(39, 1, 3, '2024-11-04', '19:30:00', 'A1, A2, A3, A4, A5, A9, A10, A11, A12, A13, B1, B4, B5, B9, B10, B11, B12, B13, C1, C2, C3, C4, C5,C9, C10, C11, C12, C13, D1, D2, D3, D4, D5, D10, D13', 'B2, B3'),
(40, 1, 4, '2024-11-04', '10:00:00', 'A1, A2, A3, A4, A5, A9, A10, A11, A12, A13 B1, B2, B3, B4, B5, B9, B10, B11, B12, B13, C1, C2, C3, C4, C5, C9, C10, C11, C12, C13, D1, D2, D3, D4, D5, D10, D13', 'C3, C4, C5'),
(41, 1, 4, '2024-11-04', '15:45:00', 'A4, A5, A9, A10, A11, A12, A13, B1, B2, B3, B4, B5, B9, B10, B11, B12, B13, C1, C2, C3, C4, C5, C9, C10, C11, C12, C13, D1, D2, D3, D4, D5, D10, D13', 'A1, A2, A3'),
(42, 1, 4, '2024-11-05', '18:50:00', 'A4, A5, A9, A10, A11, A12, A13, B1, B2, B3, B4, B5, B9, B10, B11, B12, B13, C1, C2, C3, C4, C5, C9, C10, C11, C12, C13, D1, D2, D3, D4, D5, D10, D13', 'A1, A2, A3'),
(43, 1, 4, '2024-11-05', '20:30:00', 'A4, A5, A9, A10, A11, A12, A13, B1, B2, B3, B4, B5, B9, B10, B11, B12, B13, C1, C2, C3, C4, C5, C9, C10, C11, C12, C13, D1, D2, D3, D4, D5, D10, D13', 'A1, A2, A3'),
(44, 1, 5, '2024-11-04', '10:45:00', 'A4, A5, A9, A10, A11, A12, A13, B1, B2, B3, B4, B5, B9, B10, B11, B12, B13, C1, C2, C3, C4, C5, C9, C10, C11, C12, C13, D1, D2, D3, D4, D5, D10, D13', 'A1, A2, A3'),
(45, 4, 1, '2024-11-03', '10:20:00', 'A1, A2, A3, A4, A5, A9, A10, A11, A12, A13, B1, B2, B3, B4, B5, B9, B10, B11, B12, B13, C1, C2, C3, C4, C5, C9, C10, C11, C12, C13, D1, D2, D3, D4, D5, D10, D13', 'A2, A3, A4, B10, B11, B12, C2, C3, D3, D4, D5'),
(46, 4, 1, '2024-11-04', '14:35:00', 'A1, A2, A3, A4, A5, A9, A10, A11, A12, A13, B1, B2, B3, B4, B5, B9, B10, B11, B12, B13, C1, C2, C3, C4, C5, C9, C10, C11, C12, C13, D1, D2, D3, D4, D5, D10, D13', 'B3, B4'),
(47, 4, 1, '2024-11-03', '11:15:00', 'A1, A2, A3, A4, A5, A9, A10, A11, A12, A13, B1, B2, B3, B4, B5, B9, B10, B11, B12, B13, C1, C2, C3, C4, C5, C9, C10, C11, C12, C13, D1, D2, D3, D4, D5, D10, D13', 'C1, C2'),
(48, 4, 2, '2024-11-05', '14:45:00', 'A1,A2,A3,A9,A10,A11,A12,A13,B1,B2,B3,B4,B5,B9,B10,B11,B12,B13,C1,C2,C3,C4,C5,C9,C10,C11,C12,C13,D1,D2,D3,D4,D5,D10,D13', 'A4,A5'),
(49, 4, 2, '2024-11-03', '13:45:00', 'A1, A2, A3, A4, A5, A9, A10, A11, A12, A13, B1, B2, B3, B4, B5, B9, B10, B11, B12, B13, C1, C2, C3, C4, C5, C9, C10, C11, C12, C13, D1, D2, D3, D4, D5, D10, D13', 'B5'),
(50, 4, 2, '2024-11-03', '17:20:00', 'A1, A2, A3, A4, A5, A9, A10, A11, A12, A13, B1, B2, B3, B4, B5, B9, B10, B11, B12, B13, C1, C2, C3, C4, C5, C9, C10, C11, C12, C13, D1, D2, D3, D4, D5, D10, D13', 'D1'),
(51, 4, 3, '2024-11-04', '09:30:00', 'A1, A2, A3, A4, A5, A9, A10, A11, A12, A13, B1, B4, B5, B9, B10, B11, B12, B13, C1, C2, C3, C4, C5,C9, C10, C11, C12, C13, D1, D2, D3, D4, D5, D10, D13', 'B2, B3'),
(52, 4, 3, '2024-11-04', '12:00:00', 'A1, A2, A3, A4, A5, A9, A10, A11, A12, A13 B1, B2, B3, B4, B5, B9, B10, B11, B12, B13, C1, C2, C3, C4, C5, C9, C10, C11, C12, C13, D1, D2, D3, D4, D5, D10, D13', 'C3, C4, C5'),
(53, 4, 4, '2024-11-04', '15:50:00', 'A4, A5, A9, A10, A11, A12, A13, B1, B2, B3, B4, B5, B9, B10, B11, B12, B13, C1, C2, C3, C4, C5, C9, C10, C11, C12, C13, D1, D2, D3, D4, D5, D10, D13', 'A1, A2, A3'),
(54, 4, 5, '2024-11-04', '15:45:00', 'A4, A5, A9, A10, A11, A12, A13, B1, B2, B3, B4, B5, B9, B10, B11, B12, B13, C1, C2, C3, C4, C5, C9, C10, C11, C12, C13, D1, D2, D3, D4, D5, D10, D13', 'A1, A2, A3'),
(55, 4, 5, '2024-11-05', '19:30:00', 'A4, A5, A9, A10, A11, A12, A13, B1, B2, B3, B4, B5, B9, B10, B11, B12, B13, C1, C2, C3, C4, C5, C9, C10, C11, C12, C13, D1, D2, D3, D4, D5, D10, D13', 'A1, A2, A3'),
(56, 4, 5, '2024-11-04', '21:45:00', 'A4, A5, A9, A10, A11, A12, A13, B1, B2, B3, B4, B5, B9, B10, B11, B12, B13, C1, C2, C3, C4, C5, C9, C10, C11, C12, C13, D1, D2, D3, D4, D5, D10, D13', 'A1, A2, A3'),
(57, 5, 1, '2024-11-03', '10:20:00', 'A1, A2, A3, A4, A5, A9, A10, A11, A12, A13, B1, B2, B3, B4, B5, B9, B10, B11, B12, B13, C1, C2, C3, C4, C5, C9, C10, C11, C12, C13, D1, D2, D3, D4, D5, D10, D13', 'A2, A3, A4, B10, B11, B12, C2, C3, D3, D4, D5'),
(58, 5, 1, '2024-11-04', '14:35:00', 'A1, A2, A3, A4, A5, A9, A10, A11, A12, A13, B1, B2, B3, B4, B5, B9, B10, B11, B12, B13, C1, C2, C3, C4, C5, C9, C10, C11, C12, C13, D1, D2, D3, D4, D5, D10, D13', 'B3, B4'),
(59, 5, 1, '2024-11-03', '11:15:00', 'A1, A2, A3, A4, A5, A9, A10, A11, A12, A13, B1, B2, B3, B4, B5, B9, B10, B11, B12, B13, C1, C2, C3, C4, C5, C9, C10, C11, C12, C13, D1, D2, D3, D4, D5, D10, D13', 'C1, C2'),
(60, 5, 1, '2024-11-05', '14:45:00', 'A1,A2,A3,A9,A10,A11,A12,A13,B1,B2,B3,B4,B5,B9,B10,B11,B12,B13,C1,C2,C3,C4,C5,C9,C10,C11,C12,C13,D1,D2,D3,D4,D5,D10,D13', 'A4,A5'),
(61, 5, 2, '2024-11-03', '13:45:00', 'A1, A2, A3, A4, A5, A9, A10, A11, A12, A13, B1, B2, B3, B4, B5, B9, B10, B11, B12, B13, C1, C2, C3, C4, C5, C9, C10, C11, C12, C13, D1, D2, D3, D4, D5, D10, D13', 'B5'),
(62, 5, 2, '2024-11-03', '17:20:00', 'A1, A2, A3, A4, A5, A9, A10, A11, A12, A13, B1, B2, B3, B4, B5, B9, B10, B11, B12, B13, C1, C2, C3, C4, C5, C9, C10, C11, C12, C13, D1, D2, D3, D4, D5, D10, D13', 'D1'),
(63, 5, 2, '2024-11-04', '09:30:00', 'A1, A2, A3, A4, A5, A9, A10, A11, A12, A13, B1, B4, B5, B9, B10, B11, B12, B13, C1, C2, C3, C4, C5,C9, C10, C11, C12, C13, D1, D2, D3, D4, D5, D10, D13', 'B2, B3'),
(64, 5, 2, '2024-11-04', '12:00:00', 'A1, A2, A3, A4, A5, A9, A10, A11, A12, A13 B1, B2, B3, B4, B5, B9, B10, B11, B12, B13, C1, C2, C3, C4, C5, C9, C10, C11, C12, C13, D1, D2, D3, D4, D5, D10, D13', 'C3, C4, C5'),
(65, 5, 3, '2024-11-04', '15:50:00', 'A4, A5, A9, A10, A11, A12, A13, B1, B2, B3, B4, B5, B9, B10, B11, B12, B13, C1, C2, C3, C4, C5, C9, C10, C11, C12, C13, D1, D2, D3, D4, D5, D10, D13', 'A1, A2, A3'),
(66, 5, 3, '2024-11-04', '15:45:00', 'A4, A5, A9, A10, A11, A12, A13, B1, B2, B3, B4, B5, B9, B10, B11, B12, B13, C1, C2, C3, C4, C5, C9, C10, C11, C12, C13, D1, D2, D3, D4, D5, D10, D13', 'A1, A2, A3'),
(67, 5, 3, '2024-11-05', '19:30:00', 'A4, A5, A9, A10, A11, A12, A13, B1, B2, B3, B4, B5, B9, B10, B11, B12, B13, C1, C2, C3, C4, C5, C9, C10, C11, C12, C13, D1, D2, D3, D4, D5, D10, D13', 'A1, A2, A3'),
(68, 5, 3, '2024-11-04', '21:45:00', 'A4, A5, A9, A10, A11, A12, A13, B1, B2, B3, B4, B5, B9, B10, B11, B12, B13, C1, C2, C3, C4, C5, C9, C10, C11, C12, C13, D1, D2, D3, D4, D5, D10, D13', 'A1, A2, A3'),
(69, 6, 3, '2024-11-03', '10:20:00', 'A1, A2, A3, A4, A5, A9, A10, A11, A12, A13, B1, B2, B3, B4, B5, B9, B10, B11, B12, B13, C1, C2, C3, C4, C5, C9, C10, C11, C12, C13, D1, D2, D3, D4, D5, D10, D13', 'A2, A3, A4, B10, B11, B12, C2, C3, D3, D4, D5'),
(70, 6, 3, '2024-11-04', '14:35:00', 'A1, A2, A3, A4, A5, A9, A10, A11, A12, A13, B1, B2, B3, B4, B5, B9, B10, B11, B12, B13, C1, C2, C3, C4, C5, C9, C10, C11, C12, C13, D1, D2, D3, D4, D5, D10, D13', 'B3, B4'),
(71, 6, 3, '2024-11-03', '11:15:00', 'A1, A2, A3, A4, A5, A9, A10, A11, A12, A13, B1, B2, B3, B4, B5, B9, B10, B11, B12, B13, C1, C2, C3, C4, C5, C9, C10, C11, C12, C13, D1, D2, D3, D4, D5, D10, D13', 'C1, C2'),
(72, 6, 3, '2024-11-05', '14:45:00', 'A1,A2,A3,A9,A10,A11,A12,A13,B1,B2,B3,B4,B5,B9,B10,B11,B12,B13,C1,C2,C3,C4,C5,C9,C10,C11,C12,C13,D1,D2,D3,D4,D5,D10,D13', 'A4,A5'),
(73, 6, 4, '2024-11-03', '13:45:00', 'A1, A2, A3, A4, A5, A9, A10, A11, A12, A13, B1, B2, B3, B4, B5, B9, B10, B11, B12, B13, C1, C2, C3, C4, C5, C9, C10, C11, C12, C13, D1, D2, D3, D4, D5, D10, D13', 'B5'),
(74, 6, 4, '2024-11-03', '17:20:00', 'A1, A2, A3, A4, A5, A9, A10, A11, A12, A13, B1, B2, B3, B4, B5, B9, B10, B11, B12, B13, C1, C2, C3, C4, C5, C9, C10, C11, C12, C13, D1, D2, D3, D4, D5, D10, D13', 'D1'),
(75, 6, 4, '2024-11-04', '09:30:00', 'A1, A2, A3, A4, A5, A9, A10, A11, A12, A13, B1, B4, B5, B9, B10, B11, B12, B13, C1, C2, C3, C4, C5,C9, C10, C11, C12, C13, D1, D2, D3, D4, D5, D10, D13', 'B2, B3'),
(76, 6, 4, '2024-11-04', '12:00:00', 'A1, A2, A3, A4, A5, A9, A10, A11, A12, A13 B1, B2, B3, B4, B5, B9, B10, B11, B12, B13, C1, C2, C3, C4, C5, C9, C10, C11, C12, C13, D1, D2, D3, D4, D5, D10, D13', 'C3, C4, C5'),
(77, 6, 5, '2024-11-03', '15:50:00', 'A4, A5, A9, A10, A11, A12, A13, B1, B2, B3, B4, B5, B9, B10, B11, B12, B13, C1, C2, C3, C4, C5, C9, C10, C11, C12, C13, D1, D2, D3, D4, D5, D10, D13', 'A1, A2, A3'),
(78, 6, 5, '2024-11-04', '15:45:00', 'A4, A5, A9, A10, A11, A12, A13, B1, B2, B3, B4, B5, B9, B10, B11, B12, B13, C1, C2, C3, C4, C5, C9, C10, C11, C12, C13, D1, D2, D3, D4, D5, D10, D13', 'A1, A2, A3'),
(79, 6, 5, '2024-11-05', '19:30:00', 'A4, A5, A9, A10, A11, A12, A13, B1, B2, B3, B4, B5, B9, B10, B11, B12, B13, C1, C2, C3, C4, C5, C9, C10, C11, C12, C13, D1, D2, D3, D4, D5, D10, D13', 'A1, A2, A3'),
(80, 6, 5, '2024-11-04', '21:45:00', 'A4, A5, A9, A10, A11, A12, A13, B1, B2, B3, B4, B5, B9, B10, B11, B12, B13, C1, C2, C3, C4, C5, C9, C10, C11, C12, C13, D1, D2, D3, D4, D5, D10, D13', 'A1, A2, A3'),
(81, 7, 3, '2024-11-03', '10:20:00', 'A1, A2, A3, A4, A5, A9, A10, A11, A12, A13, B1, B2, B3, B4, B5, B9, B10, B11, B12, B13, C1, C2, C3, C4, C5, C9, C10, C11, C12, C13, D1, D2, D3, D4, D5, D10, D13', 'A2, A3, A4, B10, B11, B12, C2, C3, D3, D4, D5'),
(82, 7, 3, '2024-11-04', '14:35:00', 'A1, A2, A3, A4, A5, A9, A10, A11, A12, A13, B1, B2, B3, B4, B5, B9, B10, B11, B12, B13, C1, C2, C3, C4, C5, C9, C10, C11, C12, C13, D1, D2, D3, D4, D5, D10, D13', 'B3, B4'),
(83, 7, 3, '2024-11-03', '11:15:00', 'A1, A2, A3, A4, A5, A9, A10, A11, A12, A13, B1, B2, B3, B4, B5, B9, B10, B11, B12, B13, C1, C2, C3, C4, C5, C9, C10, C11, C12, C13, D1, D2, D3, D4, D5, D10, D13', 'C1, C2'),
(84, 7, 3, '2024-11-05', '14:45:00', 'A1,A2,A3,A9,A10,A11,A12,A13,B1,B2,B3,B4,B5,B9,B10,B11,B12,B13,C1,C2,C3,C4,C5,C9,C10,C11,C12,C13,D1,D2,D3,D4,D5,D10,D13', 'A4,A5'),
(85, 7, 4, '2024-11-03', '13:45:00', 'A1, A2, A3, A4, A5, A9, A10, A11, A12, A13, B1, B2, B3, B4, B5, B9, B10, B11, B12, B13, C1, C2, C3, C4, C5, C9, C10, C11, C12, C13, D1, D2, D3, D4, D5, D10, D13', 'B5'),
(86, 7, 4, '2024-11-03', '17:20:00', 'A1, A2, A3, A4, A5, A9, A10, A11, A12, A13, B1, B2, B3, B4, B5, B9, B10, B11, B12, B13, C1, C2, C3, C4, C5, C9, C10, C11, C12, C13, D1, D2, D3, D4, D5, D10, D13', 'D1'),
(87, 7, 4, '2024-11-04', '09:30:00', 'A1, A2, A3, A4, A5, A9, A10, A11, A12, A13, B1, B4, B5, B9, B10, B11, B12, B13, C1, C2, C3, C4, C5,C9, C10, C11, C12, C13, D1, D2, D3, D4, D5, D10, D13', 'B2, B3'),
(88, 7, 4, '2024-11-04', '12:00:00', 'A1, A2, A3, A4, A5, A9, A10, A11, A12, A13 B1, B2, B3, B4, B5, B9, B10, B11, B12, B13, C1, C2, C3, C4, C5, C9, C10, C11, C12, C13, D1, D2, D3, D4, D5, D10, D13', 'C3, C4, C5'),
(89, 7, 5, '2024-11-03', '15:50:00', 'A4, A5, A9, A10, A11, A12, A13, B1, B2, B3, B4, B5, B9, B10, B11, B12, B13, C1, C2, C3, C4, C5, C9, C10, C11, C12, C13, D1, D2, D3, D4, D5, D10, D13', 'A1, A2, A3'),
(90, 7, 5, '2024-11-04', '15:45:00', 'A4, A5, A9, A10, A11, A12, A13, B1, B2, B3, B4, B5, B9, B10, B11, B12, B13, C1, C2, C3, C4, C5, C9, C10, C11, C12, C13, D1, D2, D3, D4, D5, D10, D13', 'A1, A2, A3'),
(91, 7, 5, '2024-11-05', '19:30:00', 'A4, A5, A9, A10, A11, A12, A13, B1, B2, B3, B4, B5, B9, B10, B11, B12, B13, C1, C2, C3, C4, C5, C9, C10, C11, C12, C13, D1, D2, D3, D4, D5, D10, D13', 'A1, A2, A3'),
(92, 7, 5, '2024-11-04', '21:45:00', 'A4, A5, A9, A10, A11, A12, A13, B1, B2, B3, B4, B5, B9, B10, B11, B12, B13, C1, C2, C3, C4, C5, C9, C10, C11, C12, C13, D1, D2, D3, D4, D5, D10, D13', 'A1, A2, A3');

-- --------------------------------------------------------

--
-- Table structure for table `showtimes`
--

CREATE TABLE `showtimes` (
  `showtime_id` int(11) NOT NULL,
  `movie_id` int(11) DEFAULT NULL,
  `outlet_id` int(11) DEFAULT NULL,
  `show_date` date DEFAULT NULL,
  `start_time` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `showtimes`
--

INSERT INTO `showtimes` (`showtime_id`, `movie_id`, `outlet_id`, `show_date`, `start_time`) VALUES
(1, 1, 4, '2024-11-05', '12:45:00'),
(2, 2, 2, '2024-11-05', '12:45:00'),
(3, 2, 1, '2024-11-03', '10:15:00'),
(4, 2, 2, '2024-11-03', '10:30:00'),
(5, 2, 3, '2024-11-03', '15:15:00'),
(6, 2, 4, '2024-11-04', '10:15:00'),
(7, 2, 3, '2024-11-04', '12:45:00'),
(8, 2, 5, '2024-11-04', '15:15:00'),
(9, 2, 1, '2024-11-05', '10:15:00'),
(37, 4, 2, '2024-11-05', '12:45:00'),
(38, 5, 2, '2024-11-05', '12:45:00'),
(39, 6, 2, '2024-11-05', '12:45:00'),
(40, 7, 2, '2024-11-05', '12:45:00'),
(41, 1, 1, '2024-11-03', '10:30:00'),
(42, 1, 1, '2024-11-04', '14:45:00'),
(43, 1, 2, '2024-11-03', '10:15:00'),
(44, 1, 2, '2024-11-05', '13:45:00'),
(45, 1, 3, '2024-11-03', '12:45:00'),
(46, 1, 3, '2024-11-03', '16:20:00'),
(47, 1, 3, '2024-11-04', '19:30:00'),
(48, 1, 4, '2024-11-04', '10:00:00'),
(49, 1, 4, '2024-11-04', '15:45:00'),
(50, 1, 4, '2024-11-05', '18:50:00'),
(51, 1, 4, '2024-11-05', '20:30:00'),
(52, 1, 5, '2024-11-04', '10:45:00'),
(53, 4, 1, '2024-11-03', '10:20:00'),
(54, 4, 1, '2024-11-04', '14:35:00'),
(55, 4, 1, '2024-11-03', '11:15:00'),
(56, 4, 2, '2024-11-05', '14:45:00'),
(57, 4, 2, '2024-11-03', '13:45:00'),
(58, 4, 2, '2024-11-03', '17:20:00'),
(59, 4, 3, '2024-11-04', '09:30:00'),
(60, 4, 3, '2024-11-04', '12:00:00'),
(61, 4, 4, '2024-11-04', '15:50:00'),
(62, 4, 5, '2024-11-04', '15:45:00'),
(63, 4, 5, '2024-11-05', '19:30:00'),
(64, 4, 5, '2024-11-04', '21:45:00'),
(65, 5, 1, '2024-11-03', '10:20:00'),
(66, 5, 1, '2024-11-04', '14:35:00'),
(67, 5, 1, '2024-11-03', '11:15:00'),
(68, 5, 1, '2024-11-05', '14:45:00'),
(69, 5, 2, '2024-11-03', '13:45:00'),
(70, 5, 2, '2024-11-03', '17:20:00'),
(71, 5, 2, '2024-11-04', '09:30:00'),
(72, 5, 2, '2024-11-04', '12:00:00'),
(73, 5, 3, '2024-11-04', '15:50:00'),
(74, 5, 3, '2024-11-04', '15:45:00'),
(75, 5, 3, '2024-11-05', '19:30:00'),
(76, 5, 3, '2024-11-04', '21:45:00'),
(77, 6, 3, '2024-11-03', '10:20:00'),
(78, 6, 3, '2024-11-04', '14:35:00'),
(79, 6, 3, '2024-11-03', '11:15:00'),
(80, 6, 3, '2024-11-05', '14:45:00'),
(81, 6, 4, '2024-11-03', '13:45:00'),
(82, 6, 4, '2024-11-03', '17:20:00'),
(83, 6, 4, '2024-11-04', '09:30:00'),
(84, 6, 4, '2024-11-04', '12:00:00'),
(85, 6, 5, '2024-11-03', '15:50:00'),
(86, 6, 5, '2024-11-04', '15:45:00'),
(87, 6, 5, '2024-11-05', '19:30:00'),
(88, 6, 5, '2024-11-04', '21:45:00'),
(89, 7, 3, '2024-11-03', '10:20:00'),
(90, 7, 3, '2024-11-04', '14:35:00'),
(91, 7, 3, '2024-11-03', '11:15:00'),
(92, 7, 3, '2024-11-05', '14:45:00'),
(93, 7, 4, '2024-11-03', '13:45:00'),
(94, 7, 4, '2024-11-03', '17:20:00'),
(95, 7, 4, '2024-11-04', '09:30:00'),
(96, 7, 4, '2024-11-04', '12:00:00'),
(97, 7, 5, '2024-11-03', '15:50:00'),
(98, 7, 5, '2024-11-04', '15:45:00'),
(99, 7, 5, '2024-11-05', '19:30:00'),
(100, 7, 5, '2024-11-04', '21:45:00');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `transactionID` int(11) NOT NULL,
  `transactionTime` time NOT NULL,
  `transactionDate` date NOT NULL,
  `status` enum('Pending','Completed','Failed') NOT NULL,
  `paymentMethod` varchar(50) NOT NULL,
  `userID` int(11) NOT NULL,
  `movieID` int(11) NOT NULL,
  `outlet` varchar(100) NOT NULL,
  `movieTime` time NOT NULL,
  `movieDate` date NOT NULL,
  `movieSeats` varchar(255) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`transactionID`, `transactionTime`, `transactionDate`, `status`, `paymentMethod`, `userID`, `movieID`, `outlet`, `movieTime`, `movieDate`, `movieSeats`, `subtotal`) VALUES
(1, '16:00:20', '2024-11-12', 'Completed', 'VISA', 1, 1, 'GGC Jewel', '12:45:00', '2024-11-03', 'A1, A2, A3', 39.00),
(7, '06:14:56', '2024-11-13', 'Completed', 'VISA', 1, 2, 'GGC Vivocity', '10:15:00', '2024-11-03', 'A1', 13.00);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userID` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `contact` varchar(8) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userID`, `username`, `contact`, `email`, `password`, `created_at`) VALUES
(1, 'testing', '98726384', 'testing2@gmail.com', '$2y$10$PKm4OZpfPgGhJgmlBZyeFOzNEz2/3zg.GRN5M4IZZXkfC6IHmw8d.', '2024-11-12 06:43:59');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`bookingID`);

--
-- Indexes for table `seats`
--
ALTER TABLE `seats`
  ADD PRIMARY KEY (`seatID`);

--
-- Indexes for table `showtimes`
--
ALTER TABLE `showtimes`
  ADD PRIMARY KEY (`showtime_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`transactionID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `bookingID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `seats`
--
ALTER TABLE `seats`
  MODIFY `seatID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT for table `showtimes`
--
ALTER TABLE `showtimes`
  MODIFY `showtime_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `transactionID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
