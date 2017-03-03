-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 03, 2017 at 02:37 AM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `chroma_beauty`
--
CREATE DATABASE IF NOT EXISTS `chroma_beauty` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `chroma_beauty`;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
`category_id` smallint(6) NOT NULL,
  `name` varchar(200) NOT NULL,
  `parent_id` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
`product_id` smallint(6) NOT NULL,
  `name` varchar(150) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `added_date` datetime NOT NULL,
  `prodimg_id` smallint(200) NOT NULL,
  `is_sale` tinyint(1) NOT NULL,
  `in_stock` tinyint(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `name`, `description`, `price`, `added_date`, `prodimg_id`, `is_sale`, `in_stock`) VALUES
(1, 'RAZOR SHARP', 'Water-Resistant Longwear Liquid Eyeliner\r\n\r\nAvailable Colors\r\nPERVERSION\r\nREVOLVER\r\nDEMOLITION\r\nPUSH\r\nSTREET\r\nZODIAC\r\nDEEP END\r\nKUSH\r\nCHAOS\r\nRETROGRADE\r\nECSTACY\r\nJUNKSHOW\r\nINTERGALACTIC\r\nCUFF\r\nSPACE COWBOY\r\nGOLDRUSH\r\nFIREBALL\r\nBUMP\r\nDARK FORCE', '22.00', '2017-03-01 17:04:04', 0, 1, 1),
(2, 'TONIC', 'Lilac with blue shift', '19.00', '2017-03-01 17:04:04', 0, 1, 1),
(3, 'The Purrfect Pair Studded Kiss Set', 'A $42 value!\r\n\r\nGet your claws on this lipstick duo devoted to KvD’s beloved hairless kitties! You get two fabulous full-sized Studded Kiss shades—Piaf, a cool chocolate with subtle purple shimmer, and Poe, a rich navy shimmer. That’s what we call the Kat’s meow!\r\n\r\nEach long-wear, pigment-rich lipstick is formulated with Color Cushion Technology™ to keep your pout feeling comfy and velvety soft. Just swipe it across lips to lock in bold, badass color with unstoppable wear.\r\n\r\nHere at Kat Von D Beauty, we believe that the best things in life are black and studded! Kat designed this insanely sexy lipstick after her signature studded cuff. Pretty rad, huh?!\r\n\r\nYou rule our world, Studded Darlings! Show us how you rock your lips with #kvdlook\r\n\r\n#VeganAlert!\r\n\r\n100% Cruelty Free Forever!', '35.00', '2017-03-01 17:26:48', 0, 1, 1),
(4, 'GREEN_Z', 'dafs', '11.33', '2017-03-02 08:44:58', 0, 1, 0),
(5, 'dank_z', 'safsagsfs', '4.20', '2017-03-02 08:45:33', 0, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `product_categories`
--

DROP TABLE IF EXISTS `product_categories`;
CREATE TABLE IF NOT EXISTS `product_categories` (
`prodcat_id` smallint(6) NOT NULL,
  `product_id` smallint(6) NOT NULL,
  `category_id` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

DROP TABLE IF EXISTS `product_images`;
CREATE TABLE IF NOT EXISTS `product_images` (
`prodimg_id` smallint(200) NOT NULL,
  `product_id` smallint(6) NOT NULL,
  `image` text NOT NULL,
  `is_main` tinyint(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`prodimg_id`, `product_id`, `image`, `is_main`) VALUES
(1, 1, 'http://www.placecorgi.com/200/200', 1),
(2, 2, 'http://www.placecorgi.com/200/200', 1);

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

DROP TABLE IF EXISTS `reviews`;
CREATE TABLE IF NOT EXISTS `reviews` (
`review_id` smallint(6) NOT NULL,
  `title` varchar(200) NOT NULL,
  `comment` text NOT NULL,
  `rating` smallint(1) NOT NULL,
  `date` datetime NOT NULL,
  `user_id` smallint(6) NOT NULL,
  `product_id` smallint(6) NOT NULL,
  `is_published` tinyint(1) NOT NULL,
  `would_rec` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `review_image`
--

DROP TABLE IF EXISTS `review_image`;
CREATE TABLE IF NOT EXISTS `review_image` (
`revimg_id` smallint(6) NOT NULL,
  `review_id` smallint(6) NOT NULL,
  `image` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
`user_id` int(6) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(40) NOT NULL,
  `email` varchar(254) NOT NULL,
  `fname` varchar(100) NOT NULL,
  `lname` varchar(100) NOT NULL,
  `bio` text NOT NULL,
  `user_pic` text NOT NULL,
  `is_admin` tinyint(1) NOT NULL,
  `signup_date` datetime NOT NULL,
  `is_approved` tinyint(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `email`, `fname`, `lname`, `bio`, `user_pic`, `is_admin`, `signup_date`, `is_approved`) VALUES
(6, 'Naomi', '842c8c63427efeb9f36a8521d902bb4968244254', 'naomi.k.rodriguez@gmail.com', '', '', '', '', 1, '2017-03-02 16:32:03', 1),
(7, 'DatBih', '33c7cf4947f2c2e12dce16d52dfc750db14f9b9e', 'ladjlsflkjslkejfej@gmail.com', '', '', '', '', 0, '2017-03-02 16:32:56', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
 ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
 ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `product_categories`
--
ALTER TABLE `product_categories`
 ADD PRIMARY KEY (`prodcat_id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
 ADD PRIMARY KEY (`prodimg_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
 ADD PRIMARY KEY (`review_id`);

--
-- Indexes for table `review_image`
--
ALTER TABLE `review_image`
 ADD PRIMARY KEY (`revimg_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
MODIFY `category_id` smallint(6) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
MODIFY `product_id` smallint(6) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `product_categories`
--
ALTER TABLE `product_categories`
MODIFY `prodcat_id` smallint(6) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
MODIFY `prodimg_id` smallint(200) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
MODIFY `review_id` smallint(6) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `review_image`
--
ALTER TABLE `review_image`
MODIFY `revimg_id` smallint(6) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `user_id` int(6) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
