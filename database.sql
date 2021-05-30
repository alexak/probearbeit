SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

CREATE DATABASE IF NOT EXISTS `intellishop-probeaufgabe` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin;
USE `intellishop-probeaufgabe`;

CREATE TABLE `films` (
  `id` int NOT NULL,
  `title` varchar(255) COLLATE utf8_bin NOT NULL,
  `year` year NOT NULL,
  `poster` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_bin;

INSERT INTO `films` (`id`, `title`, `year`, `poster`) VALUES
(10, 'Bad Boys', 1995, 'https://m.media-amazon.com/images/M/MV5BMGE1ZTQ0ZTEtZTEwZS00NWE0LTlmMDUtMTE1ZWJiZTYzZTQ2XkEyXkFqcGdeQXVyNTAyODkwOQ@@._V1_SX300.jpg'),
(8, 'Harry Potter and the Deathly Hallows: Part 2', 2011, 'https://m.media-amazon.com/images/M/MV5BMGVmMWNiMDktYjQ0Mi00MWIxLTk0N2UtN2ZlYTdkN2IzNDNlXkEyXkFqcGdeQXVyODE5NzE3OTE@._V1_SX300.jpg');

CREATE TABLE `user_films` (
  `id` int NOT NULL,
  `username` varchar(255) COLLATE utf8_bin NOT NULL,
  `film_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_bin;

INSERT INTO `user_films` (`id`, `username`, `film_id`) VALUES
(1, 'user2', 7),
(2, 'user1', 8),
(4, 'user1', 10);


ALTER TABLE `films`
  ADD PRIMARY KEY (`title`,`year`),
  ADD UNIQUE KEY `id` (`id`);

ALTER TABLE `user_films`
  ADD UNIQUE KEY `id` (`id`);


ALTER TABLE `films`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

ALTER TABLE `user_films`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
