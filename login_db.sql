-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 31, 2025 at 12:26 PM
-- Server version: 8.0.39
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `login_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `about_content`
--

CREATE TABLE `about_content` (
  `id` int NOT NULL,
  `image` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `more_description` text,
  `client` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `cases_won` varchar(50) NOT NULL,
  `achievements` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `our_team` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `status` enum('Active','Pending') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'Active',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `about_content`
--

INSERT INTO `about_content` (`id`, `image`, `title`, `description`, `more_description`, `client`, `cases_won`, `achievements`, `our_team`, `status`, `created_at`) VALUES
(7, 'nyirabyo-1-1.png', 'About Fair Law Firm LTD', 'Fair Law Firm Ltd, a Rwandan company founded in 2021, provides a full range of legal services and property management solutions. They offer court representation, mediation, business transaction facilitation, contract drafting, and legal advice across various fields.\r\n\r\nIn property management, they handle rental contracts, marketing, rental profit maximization, compliance with administrative directives, tax payments, rent recovery, and sales transactions. Their goal is to make accessible legal services and property management services to their clients.', 'Fair Law Firm Ltd is a specialized Rwandan company offering a comprehensive range of legal services and property management solutions.\r\n\r\nIn the realm of legal services, the firm provides robust representation and assistance in court, ensuring clients have professional support during litigation. Our expertise extends to mediation and conciliation, helping parties to resolve disputes amicably. The firm also facilitates business transactions, ensuring all legal aspects are meticulously handled. Additionally, they draft internal rules and regulations, draft contracts, and offer legal advice across various professional fields, tailoring their services to meet the specific needs of their clients.\r\n\r\nIn terms of property management, Fair Law Firm Ltd offers a suite of services designed to optimize rental and sales transactions. They represent clients in renting houses and apartments, ensuring smooth execution of rental contracts and effective marketing strategies. The firm is committed to maximizing rental profits and ensuring compliance with administrative directives and rental tax obligations. They handle reporting and filing, rent recovery, and provide facilitation in both movable and immovable sales transactions.', '500', '300', '65', '3', 'Active', '2025-03-22 11:56:20');

-- --------------------------------------------------------

--
-- Table structure for table `add_property`
--

CREATE TABLE `add_property` (
  `id` int NOT NULL,
  `image` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `title` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `status` varchar(12) NOT NULL DEFAULT 'Active',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `add_property`
--

INSERT INTO `add_property` (`id`, `image`, `location`, `title`, `status`, `created_at`) VALUES
(1, 'uploads/1740044589_J0400005.PNG', 'kicukiro, kigali, rwanda', 'Cette maison est gérée par Fair Law Firm LTD', 'pending', '2025-02-20 09:43:09'),
(12, '1740398605_house4_property_1.jpg', 'Kicukiro, Kigali', 'This house is managed by Fair Law Firm LTD\r\n', 'Active', '2025-02-24 12:03:25'),
(13, '1740398685_house1_property_1.jpg', ' kacyiru, Gasabo, Kigali', 'This house is managed by Fair Law Firm LTD\r\n', 'Active', '2025-02-24 12:04:45'),
(14, '1740398706_house2_property_1.jpg', ' Kibagabaga, Gasabo, Kigali', 'This house is managed by Fair Law Firm LTD\r\n', 'Active', '2025-02-24 12:05:06'),
(15, '1740398730_promoHouse_1.jpg', 'Kimironko, Gasabo, Kigali', 'This house is managed by Fair Law Firm LTD\r\n', 'Active', '2025-02-24 12:05:30'),
(16, '1740398762_house5_property_1.jpg', 'Kibagabaga, Gasabo, Kigali', 'This house is managed by Fair Law Firm LTD', 'Active', '2025-02-24 12:06:02'),
(31, '1742838983_1740400319_house6_property_1.jpg', ' Kicukiro, Kigali', 'This house is managed by Fair Law Firm LTD', 'Active', '2025-03-24 17:56:23'),
(32, '1742839132_house3_property_1.jpg', ' Kibagabaga, Gasabo, Kigali', 'This house is managed by Fair Law Firm LTD', 'Active', '2025-03-24 17:58:52');

-- --------------------------------------------------------

--
-- Table structure for table `blog`
--

CREATE TABLE `blog` (
  `id` int NOT NULL,
  `image` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `title` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `description_blog` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `blog_description_details` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `category_blog` varchar(255) COLLATE utf8mb4_general_ci DEFAULT 'Uncategorized',
  `status` enum('active','pending') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blog`
--

INSERT INTO `blog` (`id`, `image`, `title`, `description_blog`, `blog_description_details`, `date`, `category_blog`, `status`) VALUES
(39, '67ea64a9cf989.jpg', 'Rwanda enacted a new Law of Evidence', 'Over the past decade, the GOR undertook a series of policy and legal reforms intended to improve the rule of law and access to justice,', 'Over the past decade, the GOR undertook a series of policy and legal reforms intended to improve the rule of law and access to justice, as well as the investment and business climate. Therefore, it’s in this direction that the country has recently introduced significant amendments to its Law of Evidence, aiming to enhance judicial efficiency and uphold fairness in legal proceedings as stipulated in the constitution.  further, it is important to keep in mind, the Rwandan legal system was originally based on the Belgian civil law system.\r\n\r\nHowever, following the introduction of a new constitution in 2003 and the 2006 reforms and restructuration of the judiciary resulted to the shift to a hybrid legal system, which consists of a mixture of civil law and common law, in this regard these recent amendments mark a pivotal moment in Rwanda’s legal landscape, reflecting the country’s commitment to modernize its judicial system in line with international standards.\r\n\r\nThe Law of Evidence in Rwanda originally enacted to regulate the admissibility and presentation of evidence in courts enacted in the year 2004 recognized as the law no 15/2004 of 15/6/2024, has undergone substantial changes in the year 2024 that is 20years later, now identified as the law n062/2024 of 20/06/2024. The amendments build upon the foundation laid by the original law, addressing emerging challenges and adapting to evolving legal practices.\r\n\r\n   The recent amendments focus on several key aspects of the Law of Evidence.  They include provisions to broaden the admissibility of electronic evidence, enhance protections for vulnerable witnesses, streamline procedures for the presentation of expert testimony, and strengthen mechanisms for the authentication of documentary evidence in this article we shall focus on the admissibility of electronic evidence. Which addresses issues that the society face both nationally and internationally.\r\n\r\nThe world is experiencing a frenetic digital activities resulting to a lot of crime and illegal acts that usually went unpunished, the was therefore a hurried need for legal reform adapting to the societal issues we face every day. The amendments were driven by a desire to address practical challenges faced in Rwandan courts, and to align the legal framework with international best practices. Factors such as technological advancements, changes in societal norms, and feedback from legal practitioners and stakeholders influenced the decision to reform the Law of Evidence, which was an urgent need.\r\n\r\nMoreover, it will be important for us to understand clearly what electronic evidence, as define in article 2 of the law governing evidence of the year  2024 “electronic evidence” means electronic data of probative value to an investigation that is stored in received or transmitted through an electronic device. the are many types of electronic evidence to name a few; emails, text message digital document social media ,digital images and videos, computer forensic, meta data etc\r\n\r\nThe inclusion of electronic evidence will shape the judicial system in such a way that it reflects the reality of modern interactions and ensures that the legal system can effectively address contemporary issues that the world faces today. The inclusion of electronic evidence is crucial for enforcing laws and regulations related to digital activities such as cybercrime, data breaches, and intellectual property infringement; it allows court to hold individuals and organization accountable for their actions in the digital realm  \r\n\r\n      The amending law of evidence 0f 2024 in it article 35 to article 49 determine the relevance, admissibility, probative value, presumption and verifications procedures of electronic evidence, electronic signature, digital signature and electronic certificates.\r\n\r\nFurthermore, From a legal perspective, the amendments introduce new procedural safeguards and standards for evidence handling. They clarify rules regarding the admissibility of digital evidence, ensuring that courts can effectively address cases involving cybercrime and electronic transactions. Practical implications include updated training programs for legal professionals to ensure they are well-versed in the amended provisions.\r\n\r\nWhile generally welcomed, the amendments have sparked debates among legal scholars and practitioners. Some critics argue that certain provisions could lead to increased litigation costs or potential misuse of electronic evidence if its not handle with proper care . Others raise concerns about the adequacy of safeguards for protecting sensitive information and ensuring the reliability of expert testimony.', '2025-03-31 09:47:21', 'Law', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `blog_attachments`
--

CREATE TABLE `blog_attachments` (
  `id` int NOT NULL,
  `blog_id` int NOT NULL,
  `file_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `file_type` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `file_size` int NOT NULL,
  `upload_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blog_attachments`
--

INSERT INTO `blog_attachments` (`id`, `blog_id`, `file_name`, `file_path`, `file_type`, `file_size`, `upload_date`) VALUES
(3, 39, 'evidence.pdf', '67ea64aa92ff2.pdf', 'pdf', 367907, '2025-03-31 09:47:22');

-- --------------------------------------------------------

--
-- Table structure for table `home_backgrounds`
--

CREATE TABLE `home_backgrounds` (
  `id` int NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `status` enum('active','pending') DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `home_backgrounds`
--

INSERT INTO `home_backgrounds` (`id`, `image_path`, `status`, `created_at`) VALUES
(1, 'backgroundImg', 'active', '2025-03-20 13:49:34');

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `usertype` enum('admin','user') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`email`, `password`, `usertype`) VALUES
('jado@gmail.com', '$2y$10$xWUut5kaR/yK9xkK1D9vhOh3imNAUC7jJ29yXOGhRE.DQAPE0A4fW', 'user'),
('kabera@gmail.com', '$2y$10$swEBwarwUEwGxXEK4EfsQujzDhXf6OM7aFhw.PWHHilqAekg9TOIi', 'user'),
('ngirumpetse@gmail.com', '$2y$10$nMZA69Ox5XOMkDKJfgGgG.58GA2ZIfLHRhM4jQkPzbQPcuDftAo92', 'user'),
('remy@gmail.com', '$2y$10$3pM53C57w..qd.rFY4/xp.hxhlRK.c11dXKk9Ldjq8pO0E2C9Npdi', 'user'),
('remymugisha64@gmail.com', '$2y$10$N4C/rBod6HcuNnrRzXHacOmGQtA65sVgUVoYEJ/6FAuqkfQpcREqm', 'admin'),
('shemagabi0@gmail.com', '$2y$10$VDvYaZlpag3v4MvWDPbig.8vhN0uPa.9V9CLGK2N.NGDPBHIZ2wua', 'user'),
('ttt@gmail.com', '$2y$10$.D6UjGqtAwdHrP03G5UN3OUiJWJo/bVCBk9KR5ozdeSuXO2MX1FBK', 'user'),
('user@gmail.com', '$2y$10$cu2h5j1FOchTiPq1SXXaiuF8D5Aca4niyr0g7xMKLq04M9HAWBfTi', 'user');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset`
--

CREATE TABLE `password_reset` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `expiry` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `password_reset`
--

INSERT INTO `password_reset` (`email`, `token`, `expiry`, `created_at`) VALUES
('admin@gmail.com', 'f1bb425f9aaafce7b318179b4f3fb8257c37fac4d0607550d7d7655ccda7f90e', '2025-03-07 23:20:00', '2025-03-07 21:20:00'),
('kabera@gmail.com', '35d3adc588b36222c63bb6bfdbf216bfe6e63f316f730a188bb6f729cb372f7c', '2025-03-25 20:31:09', '2025-03-24 09:56:59'),
('user@gmail.com', '77df3760058ca3c9c9c0c5ff0d43d29e747f83860b9f544b229598fc5277e06d', '2025-03-07 15:14:53', '2025-03-07 12:37:10');

-- --------------------------------------------------------

--
-- Table structure for table `properties`
--

CREATE TABLE `properties` (
  `id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `property_status` enum('For Rent','For Sale','Not Available') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `property_type` varchar(100) NOT NULL,
  `price` varchar(50) NOT NULL DEFAULT '',
  `property_size` varchar(50) NOT NULL,
  `bedroom` int DEFAULT NULL,
  `bathroom` int DEFAULT NULL,
  `street` varchar(255) NOT NULL,
  `status` enum('Active','Inactive','Pending') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'Active',
  `sector` varchar(255) DEFAULT NULL,
  `district` varchar(255) DEFAULT NULL,
  `country` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `floor` varchar(50) DEFAULT NULL,
  `months` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `properties`
--

INSERT INTO `properties` (`id`, `title`, `description`, `property_status`, `property_type`, `price`, `property_size`, `bedroom`, `bathroom`, `street`, `status`, `sector`, `district`, `country`, `created_at`, `floor`, `months`) VALUES
(38, 'Lorem Ipsum lorem', 'Lorem Ipsum loremLorem Ipsum loremLorem Ipsum loremLorem Ipsum loremLorem Ipsum loremLorem Ipsum loremLorem Ipsum loremLorem Ipsum loremLorem Ipsum loremLorem Ipsum loremLorem Ipsum loremLorem Ipsum loremLorem Ipsum loremLorem Ipsum loremLorem Ipsum loremLorem Ipsum loremLorem Ipsum loremLorem Ipsum lorem\r\nLorem Ipsum loremLorem Ipsum loremLorem Ipsum loremLorem Ipsum loremLorem Ipsum loremLorem Ipsum loremLorem Ipsum loremLorem Ipsum loremLorem Ipsum loremLorem Ipsum loremLorem Ipsum loremLorem Ipsum loremLorem Ipsum loremLorem Ipsum loremLorem Ipsum loremLorem Ipsum loremLorem Ipsum loremLorem Ipsum loremLorem Ipsum loremLorem Ipsum lorem', 'For Rent', 'Commercial Building', '1000000 - 500000', '200km - 300km', 0, 0, '849 st', 'Active', 'kimironko', 'gasabo', 'Rwanda', '2025-03-31 09:08:17', 'Ground Floor, 1st Floor, 2nd Floor', 1);

-- --------------------------------------------------------

--
-- Table structure for table `property`
--

CREATE TABLE `property` (
  `id` int NOT NULL,
  `img` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `location` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `property`
--

INSERT INTO `property` (`id`, `img`, `location`) VALUES
(1, 'house1_property_1.jpg', 'kacyiru, Gasabo, Kigali'),
(2, 'house3_property_1.jpg', 'Kibagabaga, Gasabo, Kigali'),
(3, 'house5_property_1.jpg', 'Kibagabaga, Gasabo, Kigali'),
(4, 'house6_property_1.jpg', 'Kicukiro, Kigali'),
(5, 'house4_property_1.jpg', 'Kicukiro, Kigali'),
(7, 'house2_property_1.jpg', 'Kibagabaga, Gasabo, Kigali'),
(8, 'promoHouse_1.jpg', 'Kimironko, Gasabo, Kigali');

-- --------------------------------------------------------

--
-- Table structure for table `property_images`
--

CREATE TABLE `property_images` (
  `id` int NOT NULL,
  `property_id` int NOT NULL,
  `image_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `is_featured` tinyint(1) DEFAULT '0',
  `image_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `property_images`
--

INSERT INTO `property_images` (`id`, `property_id`, `image_name`, `is_featured`, `image_path`) VALUES
(48, 38, '67ea5bb683ffa.jpg', 1, 'propertyMgt/rentalImg/67ea5bb683ffa.jpg'),
(49, 38, '67ea5bcc38098.jpg', 1, 'propertyMgt/rentalImg/67ea5bcc38098.jpg'),
(50, 38, '67ea5bcc4812d.jpg', 0, 'propertyMgt/rentalImg/67ea5bcc4812d.jpg'),
(51, 38, '67ea5bef74b52.jpg', 1, 'propertyMgt/rentalImg/67ea5bef74b52.jpg'),
(52, 38, '67ea5bef8c35c.jpg', 0, 'propertyMgt/rentalImg/67ea5bef8c35c.jpg'),
(53, 38, '67ea5befa263e.jpg', 0, 'propertyMgt/rentalImg/67ea5befa263e.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id` int NOT NULL,
  `name` varchar(250) NOT NULL,
  `userid` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `role_id` int NOT NULL,
  `role_name` varchar(50) NOT NULL,
  `description` text,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`role_id`, `role_name`, `description`, `created_at`) VALUES
(1, 'Admin', 'Administrator with full access', '2025-03-06 01:33:24'),
(2, 'Employer', 'Regular user with limited access', '2025-03-06 01:33:24');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int UNSIGNED NOT NULL,
  `email` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL,
  `role_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `gender` enum('Male','Female','Other') NOT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `role_id` int NOT NULL,
  `status` enum('Active','Inactive','Pending') DEFAULT 'Pending',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `phone`, `gender`, `profile_image`, `role_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Remy', 'MUGISHA', 'remymugisha64@gmail.com', '0788848185', 'Male', 'uploads/67c8e054f080e.jpg', 1, 'Active', '2025-03-06 01:37:56', '2025-03-06 01:43:46'),
(2, 'Shema', 'Gabi', 'shemagabi0@gmail.com', '0788848185', 'Male', 'uploads/67c8f5e79332b.jpg', 2, 'Active', '2025-03-06 03:09:59', '2025-03-07 22:33:42');

-- --------------------------------------------------------

--
-- Table structure for table `videos`
--

CREATE TABLE `videos` (
  `id` int NOT NULL,
  `video_link` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('active','pending') NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `about_content`
--
ALTER TABLE `about_content`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `add_property`
--
ALTER TABLE `add_property`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blog`
--
ALTER TABLE `blog`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blog_attachments`
--
ALTER TABLE `blog_attachments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `blog_id` (`blog_id`);

--
-- Indexes for table `home_backgrounds`
--
ALTER TABLE `home_backgrounds`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `password_reset`
--
ALTER TABLE `password_reset`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `properties`
--
ALTER TABLE `properties`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `property`
--
ALTER TABLE `property`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `property_images`
--
ALTER TABLE `property_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `property_id` (`property_id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userid` (`userid`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_id`),
  ADD UNIQUE KEY `role_name` (`role_name`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user` (`role_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `videos`
--
ALTER TABLE `videos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `about_content`
--
ALTER TABLE `about_content`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `add_property`
--
ALTER TABLE `add_property`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `blog`
--
ALTER TABLE `blog`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `blog_attachments`
--
ALTER TABLE `blog_attachments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `home_backgrounds`
--
ALTER TABLE `home_backgrounds`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `properties`
--
ALTER TABLE `properties`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `property`
--
ALTER TABLE `property`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `property_images`
--
ALTER TABLE `property_images`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `role_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `videos`
--
ALTER TABLE `videos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `blog_attachments`
--
ALTER TABLE `blog_attachments`
  ADD CONSTRAINT `blog_attachments_ibfk_1` FOREIGN KEY (`blog_id`) REFERENCES `blog` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `property_images`
--
ALTER TABLE `property_images`
  ADD CONSTRAINT `property_images_ibfk_1` FOREIGN KEY (`property_id`) REFERENCES `properties` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role`
--
ALTER TABLE `role`
  ADD CONSTRAINT `role_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `user` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`email`) REFERENCES `login` (`email`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
