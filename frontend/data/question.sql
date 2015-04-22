-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 22, 2015 at 05:44 AM
-- Server version: 5.6.20
-- PHP Version: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `mrcuong`
--

-- --------------------------------------------------------

--
-- Table structure for table `question`
--

CREATE TABLE IF NOT EXISTS `question` (
`id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `status` tinyint(2) NOT NULL,
  `question` text CHARACTER SET utf8 NOT NULL,
  `type` varchar(25) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=armscii8 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `question`
--

INSERT INTO `question` (`id`, `user_id`, `date`, `status`, `question`, `type`) VALUES
(1, 2, '2015-04-21 12:39:15', 1, 'how are you?', 'office'),
(2, 1, '2015-04-21 12:40:01', 0, 'what your name?', 'global'),
(3, 1, '2015-04-21 12:40:20', 1, 'khỏe ko?', 'global'),
(4, 2, '2015-04-21 12:40:37', 0, 'đang làm gì đó?', 'office'),
(5, 2, '2015-04-21 12:44:32', 0, 'test lần 1', 'office'),
(6, 2, '2015-04-21 12:47:47', 0, 'hello', 'office'),
(7, 2, '2015-04-21 13:13:49', 0, 'tesst tiếp lần nữa', 'office'),
(8, 3, '2015-04-21 13:14:31', 1, 'câu hỏi của admin 2!', 'office'),
(9, 2, '2015-04-21 13:14:53', 0, 'test thêm lần nữa! :D', 'office'),
(10, 3, '2015-04-21 13:15:24', 0, 'câu hỏi thứ 2 của admin2', 'office'),
(11, 2, '2015-04-21 13:18:36', 0, 'cau hoi admin1', 'office');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `question`
--
ALTER TABLE `question`
 ADD PRIMARY KEY (`id`), ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `question`
--
ALTER TABLE `question`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `question`
--
ALTER TABLE `question`
ADD CONSTRAINT `question_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
