CREATE DATABASE movieDB;
USE movieDB;


-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 21, 2017 at 07:01 AM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `movieDB`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `commentid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `movieid` int(11) NOT NULL,
  `comment_date` date NOT NULL,
  `comment_text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`commentid`, `userid`, `movieid`, `comment_date`, `comment_text`) VALUES
(1, 1, 1, '2017-03-15', 'should\'ve won best picture'),
(2, 2, 2, '2017-03-15', 'can\'t swim anymore because of this movie'),
(3, 3, 3, '2017-03-15', 'sequels are just as good'),
(4, 4, 4, '2017-03-15', 'this movie is still scary at the beginning'),
(5, 5, 5, '2017-03-15', 'surprisingly brutal'),
(6, 6, 6, '2017-03-15', 'the CGI is insane'),
(7, 7, 7, '2017-03-15', 'never expected this movie to be so hilarious'),
(8, 8, 8, '2017-03-15', 'i think this is the bloodiest movie I have ever seen'),
(9, 9, 9, '2017-03-15', 'love the home ec scene'),
(10, 10, 10, '2017-03-15', 'i have never seen an audience cheer so loudly for a character'),
(11, 11, 11, '2017-04-20', 'Shyamalan\'s best work since Unbreakable'),
(12, 12, 12, '2017-04-20', 'So that\'s how Aliens were born...'),
(13, 13, 13, '2017-04-20', 'This is a surprising story about love'),
(14, 14, 14, '2017-04-20', 'Jennifer Lawrence makes every movie amazing'),
(15, 15, 15, '2017-04-20', 'Apes are badasses'),
(16, 16, 16, '2017-04-20', 'It\'s kind of sad that Cooper didn\'t see his daughter again for about 60 years :('),
(17, 17, 17, '2017-04-20', 'The underground scene was the most horrifying'),
(18, 18, 18, '2017-04-20', 'I couldn\'t sleep for five days straight after watching this'),
(19, 19, 19, '2017-04-20', 'Being stuck in a building with a bunch of zombies is a huge NOPE'),
(20, 20, 20, '2017-04-20', 'What if there is no witch, and it\'s all a plot to kill Heather?'),
(21, 21, 21, '2017-04-20', 'This movie is an inspiration to people like Vincent'),
(22, 22, 22, '2017-04-20', 'The boy learned the hard way how brutal war is, it\'s quite depressing.'),
(23, 23, 23, '2017-04-20', 'I love the main character for never giving up!'),
(24, 24, 24, '2017-04-20', 'I can\'t believe she still decided to have the baby'),
(25, 25, 25, '2017-04-20', '\"Look at me. I\'m the captain now.\"'),
(26, 26, 26, '2017-04-20', 'If a giant rabbit told me what to do, I would probably listen as well.'),
(27, 27, 27, '2017-04-20', 'This is one of the most depressing movies I\'ve ever seen'),
(28, 28, 28, '2017-04-20', 'Robert Downey Jr. is my favorite actor ever'),
(29, 29, 29, '2017-04-20', 'This movie is infuriating because it\'s so sad and illogical!'),
(30, 30, 30, '2017-04-20', 'Superman can never be beaten, ever.');

-- --------------------------------------------------------

--
-- Table structure for table `crew`
--

CREATE TABLE `crew` (
  `crewid` int(11) NOT NULL,
  `FirstName` varchar(255) NOT NULL,
  `LastName` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `crew`
--

INSERT INTO `crew` (`crewid`, `FirstName`, `LastName`) VALUES
(1, 'Felicity', 'Jones'),
(2, 'Michael', 'Cera'),
(3, 'Ryan', 'Gosling'),
(4, 'Jordan', 'Peele'),
(5, 'Richard', 'Dreyfuss'),
(6, 'Adam', 'Scott'),
(7, 'Brie', 'Larson'),
(8, 'Tim', 'Allen'),
(9, 'Drew', 'Barrymore'),
(10, 'Bradley', 'Cooper'),
(11, 'Mel', 'Gibson'),
(12, 'Noomi', 'Rapace'),
(13, 'Rooney', 'Mara'),
(14, 'Jennifer', 'Lawrence'),
(15, 'James', 'Franco'),
(16, 'Matthew', 'McConaughey'),
(17, 'Lizzy', 'Caplan'),
(18, 'Brad', 'Miska'),
(19, 'Jennifer', 'Carpenter'),
(20, 'Heather', 'Donahue'),
(21, 'Ethan', 'Hawke'),
(22, 'Brad', 'Pitt'),
(23, 'Angelina', 'Jolie'),
(24, 'Amy', 'Adams'),
(25, 'Tom', 'Hanks'),
(26, 'Jake', 'Gyllenhaal'),
(27, 'Paddy', 'Considine'),
(28, 'Jude', 'Law'),
(29, 'Will', 'Smith'),
(30, 'Zack', 'Snyder'),
(31, 'Jonah', 'Hill'),
(32, 'Christopher', 'Mintz-Plasse'),
(33, 'Emma', 'Stone'),
(34, 'Damien', 'Chazelle');

-- --------------------------------------------------------

--
-- Table structure for table `db_user`
--

CREATE TABLE `db_user` (
  `userid` int(11) NOT NULL,
  `username` varchar(64) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `middlename` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) NOT NULL,
  `user_password` varchar(60) NOT NULL,
  `date_of_birth` date NOT NULL,
  `gender` varchar(6) NOT NULL,
  `permission_id` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `db_user`
--

INSERT INTO `db_user` (`userid`, `username`, `firstname`, `middlename`, `lastname`, `user_password`, `date_of_birth`, `gender`, `permission_id`) VALUES
(1, 'ecole96', 'Evan', 'Bond', 'Cole', 'lol', '1996-01-28', 'Male', 1),
(2, 'test1', 'John', 'Cornelius', 'Smith', 'password', '1990-02-01', 'Male', 0),
(3, 'test2', 'Nick', NULL, 'Wilson', 'password', '1990-02-01', 'Male', 0),
(4, 'test3', 'Mike', 'whaddup', 'Jones', 'password', '1990-02-01', 'Male', 0),
(5, 'test4', 'Adam', 'Randall', 'Sims', 'password', '1990-02-01', 'Male', 0),
(6, 'test5', 'Zoe', 'Ophelia', 'Jones', 'password', '1990-02-01', 'Female', 0),
(7, 'test6', 'Chandra', NULL, 'Wilson', 'password', '1990-02-01', 'Female', 0),
(8, 'test7', 'Gillian', NULL, 'Jacobs', 'password', '1990-02-01', 'Female', 0),
(9, 'test8', 'Stacy', 'Loren', 'Smith', 'password', '1990-02-01', 'Female', 0),
(10, 'test9', 'Teresa', 'Darlene', 'Gillespie', 'password', '1990-02-01', 'Female', 0),
(11, 'test10', 'James', 'Brian', 'Smith', 'password', '1995-03-01', 'Male', 0),
(12, 'test11', 'John', 'Edward', 'Johnson', 'password', '1995-04-02', 'Male', 0),
(13, 'test12', 'Robert', 'Steven', 'Williams', 'password', '1995-05-03', 'Male', 0),
(14, 'test13', 'Michael', 'Kenneth', 'Jones', 'password', '1995-06-04', 'Male', 0),
(15, 'test14', 'William', 'George', 'Brown', 'password', '1995-07-05', 'Male', 0),
(16, 'test15', 'David', 'Donald', 'Davis', 'password', '1995-08-06', 'Male', 0),
(17, 'test16', 'Richard', 'Mark', 'Miller', 'password', '1995-09-07', 'Male', 0),
(18, 'test17', 'Charles', 'Paul', 'Wilson', 'password', '1995-10-08', 'Male', 0),
(19, 'test18', 'Joseph', 'Daniel', 'Moore', 'password', '1995-11-09', 'Male', 0),
(20, 'test19', 'Thomas', 'Christopher', 'Taylor', 'password', '1995-12-10', 'Male', 0),
(21, 'test20', 'Mary', 'Sharon', 'Anderson', 'password', '1995-01-27', 'Female', 0),
(22, 'test21', 'Patricia', 'Ruth', 'Thomas', 'password', '1995-02-26', 'Female', 0),
(23, 'test22', 'Linda', 'Carol', 'Jackson', 'password', '1995-03-25', 'Female', 0),
(24, 'test23', 'Barbara', 'Donna', 'White', 'password', '1995-04-24', 'Female', 0),
(25, 'test24', 'Elizabeth', 'Sandra', 'Harris', 'password', '1995-05-23', 'Female', 0),
(26, 'test25', 'Jennifer', 'Helen', 'Martin', 'password', '1995-06-22', 'Female', 0),
(27, 'test26', 'Susan', 'Betty', 'Thompson', 'password', '1995-07-21', 'Female', 0),
(28, 'test27', 'Margaret', 'Karen', 'Robinson', 'password', '1995-08-20', 'Female', 0),
(29, 'test28', 'Dorothy', 'Nancy', 'Clark', 'password', '1995-09-19', 'Female', 0),
(30, 'test29', 'Lisa', 'Sarah', 'Lewis', 'password', '1995-10-18', 'Female', 0);

-- --------------------------------------------------------

--
-- Table structure for table `genres`
--

CREATE TABLE `genres` (
  `genreid` int(11) NOT NULL,
  `genre_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `genres`
--

INSERT INTO `genres` (`genreid`, `genre_name`) VALUES
(1, 'horror'),
(2, 'comedy'),
(3, 'romance'),
(4, 'action'),
(5, 'adventure'),
(6, 'teen'),
(7, 'drama'),
(8, 'sci-fi'),
(9, 'musical'),
(10, 'family'),
(11, 'thriller'),
(12, 'mystery');

-- --------------------------------------------------------

--
-- Table structure for table `movie`
--

CREATE TABLE `movie` (
  `title` varchar(255) NOT NULL,
  `summary` text,
  `lang` varchar(255) DEFAULT NULL,
  `duration` int(11) DEFAULT NULL,
  `release_date` date DEFAULT NULL,
  `movieid` int(11) NOT NULL,
  `trailer` text,
  `poster` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `movie`
--

INSERT INTO `movie` (`title`, `summary`, `lang`, `duration`, `release_date`, `movieid`, `trailer`, `poster`) VALUES
('La La Land', 'jazz pianist and actress', 'English', 120, '2016-12-06', 1, 'https://www.youtube.com/watch?v=0pdqf4P9MB8', 'http://www.impawards.com/2016/posters/la_la_land_ver3_xxlg.jpg'),
('Jaws', 'shark!!', 'english', 133, '1975-06-20', 2, 'https://www.youtube.com/watch?v=U1fu_sA7XhE', 'https://s-media-cache-ak0.pinimg.com/736x/f1/84/66/f18466a7a69f22d678388adc9e3e4ef6.jpg'),
('Toy Story', 'toys, toys everywhere', 'English', 95, '1995-11-22', 3, 'https://www.youtube.com/watch?v=KYz2wyBy3kc', 'http://vignette4.wikia.nocookie.net/disney/images/4/4c/Toy-story-movie-posters-4.jpg/revision/latest?cb=20140816182710'),
('E.T.', 'aliens!', 'english', 115, '1983-06-03', 4, 'https://www.youtube.com/watch?v=qYAETtIIClk', 'http://centerforcreativemedia.com/wp-content/uploads/2015/11/E.T..jpg'),
('Kong: Skull Island', 'giant ape goes bananas', 'English', 120, '2017-03-10', 5, 'https://www.youtube.com/watch?v=44LdLqgOpjo', 'http://www.impawards.com/2017/posters/kong_skull_island_ver10_xlg.jpg'),
('Stars Wars: Rogue One', 'rebels get plans to death star', 'english', 135, '2016-12-16', 6, 'https://www.youtube.com/watch?v=sC9abcLLQpI', 'https://cdn.tube.hk/images/titles_cache/1000x1410_movie12175postersrogue_one_a_star_wars_story-hk.jpg'),
('The Hangover', 'guys blacked out, did crazy stuff', 'English', 95, '2009-06-05', 7, 'https://www.youtube.com/watch?v=tcdUhdOlz9M', 'http://www.impawards.com/2009/posters/hangover_xlg.jpg'),
('Piranha 3D', 'you know what this is about', 'English', 80, '2010-08-20', 8, 'https://www.youtube.com/watch?v=hKVY94MpUiE', 'http://cdn.movieweb.com/img.site/PHD22GHKLg2EGK_2_l.jpg'),
('Superbad', 'high school', 'English', 100, '2007-08-07', 9, 'https://www.youtube.com/watch?v=zFjaJbihWwc', 'http://kingofwallpapers.com/superbad/superbad-010.jpg'),
('Get Out', 'white people are crazy', 'English', 100, '2017-02-24', 10, 'https://www.youtube.com/watch?v=sRfnevzM9kQ', 'http://thevalleystar.com/wp-content/uploads/2017/03/Poster-2017-Get-Out.jpg'),
('Signs', 'a family is terrorized by aliens', 'English', 106, '2002-08-02', 11, 'https://www.youtube.com/watch?v=F5-Lv4CJmFM', 'https://brettmkane.files.wordpress.com/2015/08/signs-530ccccc436a9.jpg'),
('Prometheus', 'humans set out to find their makers', 'English', 124, '2012-06-08', 12, 'https://www.youtube.com/watch?v=nmJOO6D5RvA', 'https://literaryvisuality.files.wordpress.com/2012/06/newprometheusposter.jpg'),
('Carol', 'a photographer and an older woman fall in love', 'English', 118, '2016-01-15', 13, 'https://www.youtube.com/watch?v=H4z7Px68ywk', 'https://arandomenglishlife.files.wordpress.com/2015/12/91d4nh27r0l-_sl1500_.jpg'),
('Passengers', 'two sleep chambers malfunction', 'English', 116, '2016-12-21', 14, 'https://www.youtube.com/watch?v=7BWWWQzTpNU', 'http://www.impawards.com/2016/posters/passengers_xxlg.jpg'),
('Rise of the Planet of the Apes', 'the beginning of the ape uprising', 'English', 105, '2011-08-05', 15, 'https://www.youtube.com/watch?v=X616MkD0k7I', 'https://fanart.tv/fanart/movies/61791/movieposter/rise-of-the-planet-of-the-apes-52f99f227c310.jpg'),
('Interstellar', 'a father saves the world by not staying', 'English', 169, '2014-11-07', 16, 'https://www.youtube.com/watch?v=2LqzF5WauAw', 'http://www.cinemixtape.com/wp-content/uploads/2014/11/interstellar_movie_poster.jpg'),
('Cloverfield', 'a huge alien monster attacks New York', 'English', 85, '2008-01-18', 17, 'https://www.youtube.com/watch?v=sQFpMZ6glTo', 'http://www.sanfordallen.com/wp-content/uploads/cloverfield-poster.jpg'),
('V/H/S', 'a bunch of creepy vhs tapes are shown', 'English', 116, '2012-09-06', 18, 'https://www.youtube.com/watch?v=Z_vPmmZpV4I', 'http://grimmfest.com/grimmupnorth/wp-content/uploads/2012/11/VHS-image.jpg'),
('Quarantine', 'a building is quarantined after a virus outbreak', 'English', 89, '2008-10-10', 19, 'https://www.youtube.com/watch?v=UxlL4aC-H8s', 'https://images-na.ssl-images-amazon.com/images/I/81B-RV-icHL._SL1500_.jpg'),
('The Blair Witch Project', 'three people disappear after exploring a witch\'s territory', 'English', 81, '1999-07-30', 20, 'https://www.youtube.com/watch?v=a_Hw4bAUj8A', 'https://hellhorror.com/imgs/movies/490.jpg'),
('Gattaca', 'a man achieves his lifelong dream', 'English', 106, '1997-10-24', 21, 'https://www.youtube.com/watch?v=hWjlUj7Czlk', 'https://s-media-cache-ak0.pinimg.com/originals/fe/2f/99/fe2f99118f2133891a3d4c70b72b6a29.jpg'),
('Fury', 'a boy learns of the reality of war', 'English', 134, '2014-10-17', 22, 'https://www.youtube.com/watch?v=-OGvZoIrXpg', 'http://www.korsgaardscommentary.com/wp-content/uploads/2014/10/Fury-Movie-Poster.jpg'),
('Unbroken', 'a man shows incredible willpower in the face of hopelessness', 'English', 137, '2014-12-25', 23, 'https://www.youtube.com/watch?v=XrjJbl7kRrI', 'http://cdn.collider.com/wp-content/uploads/unbroken-movie-poster-2.jpg'),
('Arrival', 'a linguistics professor saves the world', 'English', 116, '2016-11-11', 24, 'https://www.youtube.com/watch?v=tFMo3UJ4B4g', 'https://4.bp.blogspot.com/-D0hWLtpggzw/V7N1YT2F7xI/AAAAAAAAX6s/6n0fLGXPjocZPa0uU444WJEkc6bMLvQ4gCLcB/s1600/cp8v8n0vmaadzn6-jpg-large.jpg'),
('Captain Phillips', 'the story of the hijacking of the MV Maersk Alabama', 'English', 134, '2013-10-11', 25, 'https://www.youtube.com/watch?v=TzU3UJuV80w', 'http://glassreels.com/wp-content/uploads/2013/11/captain-phillips_poster.jpg'),
('Donnie Darko', 'a troubled teenager prevents the destruction of the universe', 'English', 113, '2001-10-26', 26, 'https://www.youtube.com/watch?v=ZZyBaFYFySk', 'https://s-media-cache-ak0.pinimg.com/originals/25/83/fc/2583fcd19bb1a56ed404744a6782184f.jpg'),
('Tyrannosaur', 'a self-destructive man gets a chance of redemption', 'English', 92, '2011-10-07', 27, 'https://www.youtube.com/watch?v=nG280k72MM8', 'https://images-na.ssl-images-amazon.com/images/I/81yIjsaIiAL._SL1412_.jpg'),
('Sherlock Holmes', 'an adventure of a detective and his partner', 'English', 128, '2009-12-25', 28, 'https://www.youtube.com/watch?v=iKUzhzustok', 'http://vignette3.wikia.nocookie.net/bakerstreet/images/d/db/Sherlock_holmes_ritchie.jpg/revision/latest?cb=20130202212947'),
('Seven Pounds', 'a man changes the lives of seven strangers', 'English', 123, '2008-12-19', 29, 'https://www.youtube.com/watch?v=MwrtEI-fcmM', 'https://alchetron.com/cdn/Seven-Pounds-images-94fbd3c2-aa02-45e8-9c01-5822792233e.jpg'),
('Man of Steel', 'Clark Kent must reveal his identity to save the planet', 'English', 143, '2013-06-14', 30, 'https://www.youtube.com/watch?v=T6DJcgm3wNY', 'https://s-media-cache-ak0.pinimg.com/originals/8a/7f/b1/8a7fb197c5a27002222c181e239d8e62.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `moviecrews`
--

CREATE TABLE `moviecrews` (
  `mcid` int(11) NOT NULL,
  `movieid` int(11) NOT NULL,
  `crewid` int(11) NOT NULL,
  `role` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `moviecrews`
--

INSERT INTO `moviecrews` (`mcid`, `movieid`, `crewid`, `role`) VALUES
(1, 1, 3, 'Sebastian'),
(2, 2, 5, 'Hooper'),
(3, 3, 8, 'Buzz Lightyear'),
(4, 4, 9, 'Gertie'),
(5, 5, 7, 'Mason Weaver'),
(6, 6, 1, 'Jyn Erso'),
(7, 7, 10, 'Phil'),
(8, 8, 6, 'Novak'),
(9, 9, 2, 'Evan'),
(10, 10, 4, 'Director'),
(11, 11, 11, 'Reverend Graham Hess'),
(12, 12, 12, 'Elizabeth Shaw'),
(13, 13, 13, 'Therese Belivet'),
(14, 14, 14, 'Aurora Lane'),
(15, 15, 15, 'Will Rodman'),
(16, 16, 16, 'Cooper'),
(17, 17, 17, 'Marlena Diamond'),
(18, 18, 18, 'Concept Writer'),
(19, 19, 19, 'Angela Vidal'),
(20, 20, 20, 'Heather Donahue'),
(21, 21, 21, 'Vincent Freeman'),
(22, 22, 22, 'Don \'Wardaddy\' Collier'),
(23, 23, 23, 'Director (Unbroken)'),
(24, 24, 24, 'Louise Banks'),
(25, 25, 25, 'Captain Richard Phillips'),
(26, 26, 26, 'Donnie Darko'),
(27, 27, 27, 'Writer (Tyrannosaur)'),
(28, 28, 28, 'Dr. John Watson'),
(29, 29, 29, 'Ben'),
(30, 30, 30, 'Director (Man of Steel)'),
(31, 9, 31, 'Seth'),
(32, 9, 32, 'Fogell'),
(33, 1, 33, 'Mia'),
(34, 1, 34, 'Director'),
(35, 9, 33, 'Jules');

-- --------------------------------------------------------

--
-- Table structure for table `moviegenres`
--

CREATE TABLE `moviegenres` (
  `mgid` int(11) NOT NULL,
  `movieid` int(11) NOT NULL,
  `genreid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `moviegenres`
--

INSERT INTO `moviegenres` (`mgid`, `movieid`, `genreid`) VALUES
(1, 1, 9),
(2, 2, 1),
(3, 3, 10),
(4, 4, 5),
(5, 5, 4),
(6, 6, 8),
(7, 7, 2),
(8, 8, 1),
(9, 8, 2),
(10, 9, 6),
(11, 10, 11),
(12, 11, 12),
(13, 12, 8),
(14, 13, 3),
(15, 14, 5),
(16, 15, 4),
(17, 16, 8),
(18, 17, 1),
(19, 18, 1),
(20, 19, 1),
(21, 20, 1),
(22, 21, 7),
(23, 22, 4),
(24, 23, 7),
(25, 24, 12),
(26, 25, 11),
(27, 26, 7),
(28, 27, 7),
(29, 28, 5),
(30, 29, 7),
(31, 30, 4);

-- --------------------------------------------------------

--
-- Table structure for table `score_and_reviews`
--

CREATE TABLE `score_and_reviews` (
  `scoreid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `movieid` int(11) NOT NULL,
  `score_data` int(11) NOT NULL,
  `review` text,
  `review_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `score_and_reviews`
--

INSERT INTO `score_and_reviews` (`scoreid`, `userid`, `movieid`, `score_data`, `review`, `review_date`) VALUES
(1, 1, 1, 8, 'good stuff', '2017-04-21'),
(2, 2, 2, 10, '2 spooky 4 me', '2017-03-15'),
(3, 3, 3, 10, 'classic animated movie', '2017-03-15'),
(4, 4, 4, 10, 'wonderful', '2017-03-15'),
(5, 5, 5, 10, 'great special effects, way better than the new godzilla', '2017-03-15'),
(6, 6, 6, 10, 'best star wars since empire', '2017-03-15'),
(7, 7, 7, 10, 'comedy classic!', '2017-03-15'),
(8, 8, 8, 10, 'knows it\'s dumb, rolls with it, lot of fun', '2017-03-15'),
(9, 9, 9, 10, 'most realistic high school movie', '2017-03-15'),
(10, 10, 10, 10, NULL, NULL),
(11, 11, 11, 10, 'an old-school, well crafted film', '2017-04-20'),
(12, 12, 12, 10, 'the 3D cinemetography is flawless', '2017-04-20'),
(13, 13, 13, 10, 'a rich and detailed piece of art', '2017-04-20'),
(14, 14, 14, 10, 'a romance and sci-fi hybrid that works', '2017-04-20'),
(15, 15, 15, 10, 'the characters are executed perfectly', '2017-04-20'),
(16, 16, 16, 10, 'a bold and ambitious film', '2017-04-20'),
(17, 17, 17, 10, 'an immersive horror adventure', '2017-04-20'),
(18, 18, 18, 10, 'an anothology of found-footage shorts that gives chills', '2017-04-20'),
(19, 19, 19, 10, 'a first-person thriller with lots of gore', '2017-04-20'),
(20, 20, 20, 10, 'the original found-footage film with an inexplicable ending', '2017-04-20'),
(21, 21, 21, 10, 'one of the most provocative sci-fi films to date', '2017-04-20'),
(22, 22, 22, 10, 'a grueling, accurate representation of WWII warfare', '2017-04-20'),
(23, 23, 23, 10, 'a film that celebrates the courage it takes to choose to fight', '2017-04-20'),
(24, 24, 24, 10, 'a perfectly crafted film about fear, love, and loss', '2017-04-20'),
(25, 25, 25, 10, 'a movie that grips you and takes your breath away', '2017-04-20'),
(26, 26, 26, 10, 'a film that explores scientific theories like no other', '2017-04-20'),
(27, 27, 27, 10, 'an unforgettable film that has an ominous, grim mood but still tugs at your heart', '2017-04-20'),
(28, 28, 28, 10, 'thanks to Robert Downey\'s energy, the film is comical and outrageous', '2017-04-20'),
(29, 29, 29, 10, 'Emotionally manipulative in a good way', '2017-04-20'),
(30, 30, 30, 10, 'a powerful depiction of the word \"epic\"', '2017-04-20'),
(31, 1, 9, 8, 'good stuff', '2017-04-21'),
(32, 1, 8, 7, 'love it', '2017-04-21');

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
  `tagid` int(11) NOT NULL,
  `movieid` int(11) NOT NULL,
  `tagdata` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`tagid`, `movieid`, `tagdata`) VALUES
(1, 1, 'oscar winner'),
(2, 2, 'scary'),
(3, 3, 'funny'),
(4, 4, 'fantastical'),
(5, 5, 'crazy'),
(6, 6, 'midquel'),
(7, 7, 'sleeper hit'),
(8, 8, 'gory'),
(9, 9, 'raunchy'),
(10, 10, 'crowd-pleaser'),
(11, 11, 'eerie'),
(12, 12, 'suspenceful'),
(13, 13, 'intriguing'),
(14, 14, 'original'),
(15, 15, 'powerful'),
(16, 16, 'clever'),
(17, 17, 'confusing action'),
(18, 18, 'unpredictable'),
(19, 19, 'brutal'),
(20, 20, 'legendary'),
(21, 21, 'imaginative'),
(22, 22, 'riveting'),
(23, 23, 'absorbing'),
(24, 24, 'fascinating'),
(25, 25, 'highly-charged'),
(26, 26, 'thought provoking'),
(27, 27, 'slow-paced'),
(28, 28, 'comical'),
(29, 29, 'sentimental'),
(30, 30, 'big-budget'),
(31, 8, 'killer fish');

-- --------------------------------------------------------

--
-- Table structure for table `watchlist`
--

CREATE TABLE `watchlist` (
  `wlid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `movieid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `watchlist`
--

INSERT INTO `watchlist` (`wlid`, `userid`, `movieid`) VALUES
(1, 2, 29),
(2, 3, 28),
(3, 4, 27),
(4, 5, 26),
(5, 6, 25),
(6, 7, 24),
(7, 8, 23),
(8, 9, 22),
(9, 10, 21),
(10, 11, 20),
(11, 12, 19),
(12, 13, 18),
(13, 14, 17),
(14, 15, 16),
(15, 16, 15),
(16, 17, 14),
(17, 18, 13),
(18, 19, 12),
(19, 20, 11),
(20, 21, 10),
(21, 22, 9),
(22, 23, 8),
(23, 24, 7),
(24, 25, 6),
(25, 26, 5),
(26, 27, 4),
(27, 28, 3),
(28, 29, 2),
(29, 30, 1),
(30, 2, 2),
(31, 1, 8),
(32, 1, 1),
(33, 1, 6),
(34, 1, 9);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`commentid`),
  ADD KEY `userid` (`userid`),
  ADD KEY `movieid` (`movieid`);

--
-- Indexes for table `crew`
--
ALTER TABLE `crew`
  ADD PRIMARY KEY (`crewid`);

--
-- Indexes for table `db_user`
--
ALTER TABLE `db_user`
  ADD PRIMARY KEY (`userid`,`username`);

--
-- Indexes for table `genres`
--
ALTER TABLE `genres`
  ADD PRIMARY KEY (`genreid`);

--
-- Indexes for table `movie`
--
ALTER TABLE `movie`
  ADD PRIMARY KEY (`movieid`);

--
-- Indexes for table `moviecrews`
--
ALTER TABLE `moviecrews`
  ADD PRIMARY KEY (`mcid`),
  ADD KEY `movieid` (`movieid`),
  ADD KEY `crewid` (`crewid`);

--
-- Indexes for table `moviegenres`
--
ALTER TABLE `moviegenres`
  ADD PRIMARY KEY (`mgid`),
  ADD KEY `movieid` (`movieid`),
  ADD KEY `genreid` (`genreid`);

--
-- Indexes for table `score_and_reviews`
--
ALTER TABLE `score_and_reviews`
  ADD PRIMARY KEY (`scoreid`),
  ADD KEY `movieid` (`movieid`),
  ADD KEY `userid` (`userid`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`tagid`),
  ADD KEY `movieid` (`movieid`);

--
-- Indexes for table `watchlist`
--
ALTER TABLE `watchlist`
  ADD PRIMARY KEY (`wlid`),
  ADD KEY `userid` (`userid`),
  ADD KEY `movieid` (`movieid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `commentid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
--
-- AUTO_INCREMENT for table `crew`
--
ALTER TABLE `crew`
  MODIFY `crewid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
--
-- AUTO_INCREMENT for table `db_user`
--
ALTER TABLE `db_user`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
--
-- AUTO_INCREMENT for table `genres`
--
ALTER TABLE `genres`
  MODIFY `genreid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `movie`
--
ALTER TABLE `movie`
  MODIFY `movieid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
--
-- AUTO_INCREMENT for table `moviecrews`
--
ALTER TABLE `moviecrews`
  MODIFY `mcid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
--
-- AUTO_INCREMENT for table `moviegenres`
--
ALTER TABLE `moviegenres`
  MODIFY `mgid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
--
-- AUTO_INCREMENT for table `score_and_reviews`
--
ALTER TABLE `score_and_reviews`
  MODIFY `scoreid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `tagid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
--
-- AUTO_INCREMENT for table `watchlist`
--
ALTER TABLE `watchlist`
  MODIFY `wlid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `db_user` (`userid`),
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`movieid`) REFERENCES `movie` (`movieid`);

--
-- Constraints for table `moviecrews`
--
ALTER TABLE `moviecrews`
  ADD CONSTRAINT `moviecrews_ibfk_1` FOREIGN KEY (`movieid`) REFERENCES `movie` (`movieid`),
  ADD CONSTRAINT `moviecrews_ibfk_2` FOREIGN KEY (`crewid`) REFERENCES `crew` (`crewid`);

--
-- Constraints for table `moviegenres`
--
ALTER TABLE `moviegenres`
  ADD CONSTRAINT `moviegenres_ibfk_1` FOREIGN KEY (`movieid`) REFERENCES `movie` (`movieid`),
  ADD CONSTRAINT `moviegenres_ibfk_2` FOREIGN KEY (`genreid`) REFERENCES `genres` (`genreid`);

--
-- Constraints for table `score_and_reviews`
--
ALTER TABLE `score_and_reviews`
  ADD CONSTRAINT `score_and_reviews_ibfk_1` FOREIGN KEY (`movieid`) REFERENCES `movie` (`movieid`),
  ADD CONSTRAINT `score_and_reviews_ibfk_2` FOREIGN KEY (`userid`) REFERENCES `db_user` (`userid`);

--
-- Constraints for table `tags`
--
ALTER TABLE `tags`
  ADD CONSTRAINT `tags_ibfk_1` FOREIGN KEY (`movieid`) REFERENCES `movie` (`movieid`);

--
-- Constraints for table `watchlist`
--
ALTER TABLE `watchlist`
  ADD CONSTRAINT `watchlist_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `db_user` (`userid`),
  ADD CONSTRAINT `watchlist_ibfk_2` FOREIGN KEY (`movieid`) REFERENCES `movie` (`movieid`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
