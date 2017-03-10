-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 10, 2017 at 06:50 AM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

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
CREATE TABLE `categories` (
  `category_id` smallint(6) NOT NULL,
  `cat_name` varchar(200) NOT NULL,
  `parent_id` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `cat_name`, `parent_id`) VALUES
(1, 'eyes', 0),
(2, 'eyeliner', 1),
(3, 'eyeshadow', 1),
(4, 'lips', 0),
(5, 'lipstick', 4),
(6, 'lip gloss', 4),
(7, 'face', 0),
(8, 'blush', 7),
(9, 'foundation', 7);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
  `product_id` smallint(6) NOT NULL,
  `name` varchar(150) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `added_date` datetime NOT NULL,
  `is_sale` tinyint(1) NOT NULL,
  `in_stock` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `name`, `description`, `price`, `added_date`, `is_sale`, `in_stock`) VALUES
(1, 'Razor Sharp', 'Water-Resistant Longwear Liquid Eyeliner. Available Colors: PERVERSION, REVOLVER, DEMOLITION, PUSH, STREET, ZODIAC, DEEP END, KUSH, CHAOS, RETROGRADE, ECSTACY, JUNKSHOW, INTERGALACTIC, CUFF, SPACE COWBOY, GOLDRUSH, FIREBALL, BUMP, DARK FORCE', '22.00', '2017-03-01 17:04:04', 1, 1),
(2, 'Tonic', 'Lilac with blue shift', '19.00', '2017-03-01 17:04:04', 1, 1),
(3, 'The Purrfect Pair Studded Kiss Set', 'A $42 value!\n\nGet your claws on this lipstick duo devoted to KvD’s beloved hairless kitties! You get two fabulous full-sized Studded Kiss shades—Piaf, a cool chocolate with subtle purple shimmer, and Poe, a rich navy shimmer. That’s what we call the Kat’s meow!\n\nEach long-wear, pigment-rich lipstick is formulated with Color Cushion Technology™ to keep your pout feeling comfy and velvety soft. Just swipe it across lips to lock in bold, badass color with unstoppable wear.\n\nHere at Kat Von D Beauty, we believe that the best things in life are black and studded! Kat designed this insanely sexy lipstick after her signature studded cuff. Pretty rad, huh?!\n\nYou rule our world, Studded Darlings! Show us how you rock your lips with #kvdlook\n\n#VeganAlert!\n\n100% Cruelty Free Forever!', '35.00', '2017-03-01 17:26:48', 1, 1),
(4, 'GREEN_Z', 'dafs', '11.33', '2017-03-02 08:44:58', 1, 0),
(5, 'dank_z', 'safsagsfs', '4.20', '2017-03-02 08:45:33', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `product_categories`
--

DROP TABLE IF EXISTS `product_categories`;
CREATE TABLE `product_categories` (
  `prodcat_id` smallint(6) NOT NULL,
  `product_id` smallint(6) NOT NULL,
  `category_id` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product_categories`
--

INSERT INTO `product_categories` (`prodcat_id`, `product_id`, `category_id`) VALUES
(1, 1, 2),
(2, 2, 3),
(3, 3, 5),
(4, 1, 1),
(5, 2, 1),
(6, 3, 4);

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

DROP TABLE IF EXISTS `product_images`;
CREATE TABLE `product_images` (
  `prodimg_id` smallint(200) NOT NULL,
  `product_id` smallint(6) NOT NULL,
  `image` text NOT NULL,
  `is_main` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`prodimg_id`, `product_id`, `image`, `is_main`) VALUES
(1, 1, 'razorsharpeye', 1),
(2, 2, 'tonic', 1),
(3, 3, 'purrfectpair', 1);

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

DROP TABLE IF EXISTS `reviews`;
CREATE TABLE `reviews` (
  `review_id` smallint(6) NOT NULL,
  `title` varchar(200) NOT NULL,
  `body` text NOT NULL,
  `rating` smallint(1) NOT NULL,
  `date` datetime NOT NULL,
  `user_id` smallint(6) NOT NULL,
  `product_id` smallint(6) NOT NULL,
  `is_published` tinyint(1) NOT NULL,
  `would_rec` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`review_id`, `title`, `body`, `rating`, `date`, `user_id`, `product_id`, `is_published`, `would_rec`) VALUES
(1, 'Applies Smoothly, Works Great!', 'Probably the best item to my whole collection! Really great for when I don''t want to pull a whole look, I can add a pop of color to my eyes just by using this eyeliner and a little mascara.. Maybe some gloss! It''s fantastic! Lasts forever too. :)', 5, '2017-03-04 23:46:39', 1, 1, 1, 1),
(2, 'LOVE THE COLOR!', 'Very vibrant. Stays well.', 4, '2017-03-05 00:21:26', 2, 2, 1, 1),
(3, 'Pretty color..but', 'The color is really bright and pigmented but it comes off to the slightest touch.! I love all of other products and these are the only two studded lipsticks I own. I LOVE her liquid lipstick though. Some things just don''t work out.', 3, '2017-03-05 00:36:26', 3, 3, 1, 0),
(4, 'Great colors, not long lasting', 'Pretty great colors, but they don''t last that long, unfortunately. ', 3, '2017-03-07 11:32:04', 1, 3, 1, 1),
(7, 'Disappointed', 'Lipstick Colors I have are Poe & Piaf, they are super pretty but did not feel smooth on & don&#39;t last as long as I expected. Had to apply more than one stroke to get a smooth black line', 2, '2017-03-07 21:50:07', 1, 3, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `review_image`
--

DROP TABLE IF EXISTS `review_image`;
CREATE TABLE `review_image` (
  `revimg_id` smallint(6) NOT NULL,
  `review_id` smallint(6) NOT NULL,
  `image` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
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
  `is_approved` tinyint(1) NOT NULL,
  `security_key` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `email`, `fname`, `lname`, `bio`, `user_pic`, `is_admin`, `signup_date`, `is_approved`, `security_key`) VALUES
(1, 'Naomi', '842c8c63427efeb9f36a8521d902bb4968244254', 'naomi.k.rodriguez@gmail.com', 'Naomi', 'Rodriguez', 'Hello! My name is Naomi, and I am OBSESSED with great makeup!', '6cc52da051635933d07e7ad0848a213230c77815', 1, '2017-03-02 16:32:03', 1, '53bd074eb16d19a95219b740bfbe5b5da6fced37'),
(2, 'DatBih', '33c7cf4947f2c2e12dce16d52dfc750db14f9b9e', 'ladjlsflkjslkejfej@gmail.com', '', '', '', '', 0, '2017-03-02 16:32:56', 1, ''),
(3, 'Melissa', '33c7cf4947f2c2e12dce16d52dfc750db14f9b9e', 'melissac@platt.edu', '', '', '', '', 0, '2017-03-03 11:59:26', 1, ''),
(4, 'Ariana', '33c7cf4947f2c2e12dce16d52dfc750db14f9b9e', 'grandeallthetime@gmail.com', 'Ariana', 'Grande', 'Been here all night... Been here all day.', '29da0db8ebe8dacaba3867efcdffdca2fcb896b4', 0, '2017-03-08 15:17:29', 1, '');

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
  MODIFY `category_id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `product_categories`
--
ALTER TABLE `product_categories`
  MODIFY `prodcat_id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `prodimg_id` smallint(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `review_id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `review_image`
--
ALTER TABLE `review_image`
  MODIFY `revimg_id` smallint(6) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
