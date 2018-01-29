-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 13, 2017 at 02:19 AM
-- Server version: 10.1.26-MariaDB
-- PHP Version: 7.1.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cms-database`
--

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `id` text NOT NULL,
  `author` text NOT NULL,
  `title` text NOT NULL,
  `text` text NOT NULL,
  `image` text NOT NULL,
  `files` text NOT NULL,
  `active` tinyint(1) NOT NULL,
  `dateBeg` date NOT NULL,
  `dateEnd` date NOT NULL,
  `position` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `blogs`
--

INSERT INTO `blogs` (`id`, `author`, `title`, `text`, `image`, `files`, `active`, `dateBeg`, `dateEnd`, `position`) VALUES
('59e004da3a92a', 'admin', 'Parent', 'asdasd', '161201115958-68-year-in-pictures-2016-restricted-super-169.jpg', 'searchicon link .txt', 1, '2017-10-13', '2017-10-29', 1),
('59e004dba7561', 'admin', 'Parent', 'asdasd', '161201115958-68-year-in-pictures-2016-restricted-super-169.jpg', 'searchicon link .txt', 1, '2017-10-13', '2017-10-29', 2),
('59e004dcb5284', 'admin', 'Parent', 'asdasd', '161201115958-68-year-in-pictures-2016-restricted-super-169.jpg', 'searchicon link .txt', 1, '2017-10-13', '2017-10-29', 3),
('59e004f1de449', 'admin', 'Child1', 'asdasd', '161201115958-68-year-in-pictures-2016-restricted-super-169.jpg', 'searchicon link .txt', 1, '2017-10-13', '2017-10-29', 0),
('59e004f547a5c', 'admin', 'Child2', 'asdasd', '161201115958-68-year-in-pictures-2016-restricted-super-169.jpg', 'searchicon link .txt', 1, '2017-10-13', '2017-10-29', 0),
('59e004f9213c7', 'admin', 'Child1', 'asdasd', '161201115958-68-year-in-pictures-2016-restricted-super-169.jpg', 'searchicon link .txt', 1, '2017-10-13', '2017-10-29', 0);

-- --------------------------------------------------------

--
-- Table structure for table `childblogs`
--

CREATE TABLE `childblogs` (
  `parentId` text NOT NULL,
  `childId` text NOT NULL,
  `position` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `childblogs`
--

INSERT INTO `childblogs` (`parentId`, `childId`, `position`) VALUES
('59e004da3a92a', '59e004f1de449', 1),
('59e004da3a92a', '59e004f547a5c', 2),
('59e004dba7561', '59e004f9213c7', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `username` text NOT NULL,
  `password` text NOT NULL,
  `email` text NOT NULL,
  `adminrights` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`username`, `password`, `email`, `adminrights`) VALUES
('admin', 'admin', 'adminmail', 1),
('user', 'user', 'usermail', 0);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
