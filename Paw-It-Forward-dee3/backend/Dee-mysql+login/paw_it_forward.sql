-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 10, 2025 at 09:29 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `paw_it_forward`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `AdminID` int(10) UNSIGNED NOT NULL,
  `FirstName` varchar(50) NOT NULL,
  `LastName` varchar(50) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`AdminID`, `FirstName`, `LastName`, `Email`, `Password`) VALUES
(1, 'Darrel', 'Fontillas', 'darrelf07@gmail.com', 'adminpass07');

-- --------------------------------------------------------

--
-- Table structure for table `certificate`
--

CREATE TABLE `certificate` (
  `CertificateID` int(10) UNSIGNED NOT NULL,
  `UserID` int(10) UNSIGNED NOT NULL,
  `AdminID` int(10) UNSIGNED NOT NULL,
  `DonationID` int(10) UNSIGNED NOT NULL,
  `CertificateImage` varchar(255) NOT NULL,
  `IssuedDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `certificate`
--

INSERT INTO `certificate` (`CertificateID`, `UserID`, `AdminID`, `DonationID`, `CertificateImage`, `IssuedDate`) VALUES
(1, 1, 1, 1, 'database/uploads/certificates/certificate-alyanna.png', '2025-02-26 09:49:38'),
(2, 2, 1, 2, 'database/uploads/certificates/certificate-francine.png', '2025-02-26 17:49:38'),
(3, 3, 1, 3, 'database/uploads/certificates/certificate-napoleon.png', '2025-02-26 17:49:38'),
(12, 1, 1, 30, 'database/uploads/certificates/certificate-alyanna-1741636998.png', '2025-03-10 20:03:18');

-- --------------------------------------------------------

--
-- Table structure for table `dog`
--

CREATE TABLE `dog` (
  `DogID` int(10) UNSIGNED NOT NULL,
  `DogName` varchar(100) NOT NULL,
  `DogBioDescription` text NOT NULL,
  `QR_Image` varchar(255) NOT NULL,
  `DogImage` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dog`
--

INSERT INTO `dog` (`DogID`, `DogName`, `DogBioDescription`, `QR_Image`, `DogImage`) VALUES
(1, 'Cinnamon', 'Cinnamon is getting weaker, suffering from a cold, and urgently needs a check-up. A kind rescuer is ready to adopt but help is needed for medical expenses.', 'database/static-qr_codes/gcash_qr_cinnamon.png', 'database/dogs/dog1-cinnamon.jpg'),
(2, 'Cookie', 'Cookie is a sweet stray facing euthanasia at the pound. She needs urgent medical tests and a sponsor to give her a second chance at life.', 'database/static-qr_codes/gcash_qr_cookie.png', 'database/dogs/dog2-cookie.jpg'),
(3, 'Oreo', 'Oreo is sweet, loving, and full. He needs a recovery fund after being stabbed to cover his vet bills. Despite everything, he\'s still a cuddly pup who believes in second chances.', 'database/static-qr_codes/gcash_qr_oreo.png', 'database/dogs/dog3-oreo.jpg'),
(13, 'Sandy', 'Sandy, a gentle dog on death row, needs immediate medical care and a kind soul to help her escape euthanasia. She deserves a chance to be saved.', 'database/static-qr_codes/qr6590-sandy.png', 'database/dogs/dog6590-sandy.jpg'),
(14, 'Mocha', 'Mocha, a loving and loyal dog, is struggling to find enough food to stay healthy and strong. Without help, her future is uncertain. She needs support to ensure she never goes hungry and can continue her journey to finding a forever home.', 'database/static-qr_codes/qr6857-mocha.png', 'database/dogs/dog6857-mocha.jpg'),
(15, 'Spring', 'Spring, a sweet and hopeful dog, is facing a tough battle and urgently needs veterinary care to recover. Without proper treatment, her chances of a happy, healthy life are at risk. She deserves love, care, and a second chance.', 'database/static-qr_codes/qr7390-spring.png', 'database/dogs/dog7390-spring.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `donation`
--

CREATE TABLE `donation` (
  `DonationID` int(10) UNSIGNED NOT NULL,
  `UserID` int(10) UNSIGNED NOT NULL,
  `AdminID` int(10) UNSIGNED NOT NULL,
  `PostID` int(10) UNSIGNED NOT NULL,
  `DonationImageProof` varchar(255) NOT NULL,
  `VerificationStatus` enum('Pending','Approved','Rejected') DEFAULT 'Pending',
  `DonationDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `donation`
--

INSERT INTO `donation` (`DonationID`, `UserID`, `AdminID`, `PostID`, `DonationImageProof`, `VerificationStatus`, `DonationDate`) VALUES
(1, 1, 1, 1, 'database/uploads/donation_proof/donation-alyanna.jpg', 'Pending', '2025-02-26 17:49:38'),
(2, 2, 1, 2, 'database/uploads/donation_proof/donation-francine.jpg', 'Pending', '2025-02-26 17:49:38'),
(3, 3, 1, 3, 'database/uploads/donation_proof/donation-napoleon.jpg', 'Pending', '2025-02-26 17:49:38'),
(30, 1, 1, 3, 'database/uploads/donation_proof/donation-alyanna-67cf446f5f61b.png', 'Approved', '2025-03-10 19:58:39');

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `PostID` int(10) UNSIGNED NOT NULL,
  `AdminID` int(10) UNSIGNED NOT NULL,
  `DogID` int(10) UNSIGNED NOT NULL,
  `AmountNeeded` decimal(10,2) NOT NULL,
  `AmountRaised` decimal(10,2) DEFAULT 0.00,
  `PostStatus` enum('Pending','Approved','Rejected') NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`PostID`, `AdminID`, `DogID`, `AmountNeeded`, `AmountRaised`, `PostStatus`) VALUES
(1, 1, 1, 20000.00, 5000.00, 'Approved'),
(2, 1, 2, 20000.00, 3000.00, 'Approved'),
(3, 1, 3, 20000.00, 3000.00, 'Approved'),
(4, 1, 13, 10000.00, 0.00, 'Pending'),
(5, 1, 14, 30000.00, 0.00, 'Pending'),
(6, 1, 15, 20000.00, 0.00, 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` int(10) UNSIGNED NOT NULL,
  `FirstName` varchar(50) NOT NULL,
  `LastName` varchar(50) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `FirstName`, `LastName`, `Email`, `Password`) VALUES
(1, 'Alyanna', 'Taw', 'alyanna@gmail.com', 'alyanna101'),
(2, 'Francine', 'Taing', 'francine@gmail.com', 'francine102'),
(3, 'Napoleon Jr.', 'Andes', 'napoleon@gmail.com', 'napoleon103'),
(4, 'Nicole', 'Intal', 'nicole@gmail.com', 'nicole104'),
(5, 'Rowencell', 'Penaflor', 'rowencell@gmail.com', 'rowencell105'),
(6, 'Daniella', 'Nilo', 'daniella@gmail.com', 'daniella106');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`AdminID`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- Indexes for table `certificate`
--
ALTER TABLE `certificate`
  ADD PRIMARY KEY (`CertificateID`),
  ADD KEY `UserID` (`UserID`),
  ADD KEY `AdminID` (`AdminID`),
  ADD KEY `DonationID` (`DonationID`);

--
-- Indexes for table `dog`
--
ALTER TABLE `dog`
  ADD PRIMARY KEY (`DogID`);

--
-- Indexes for table `donation`
--
ALTER TABLE `donation`
  ADD PRIMARY KEY (`DonationID`),
  ADD KEY `UserID` (`UserID`),
  ADD KEY `AdminID` (`AdminID`),
  ADD KEY `PostID` (`PostID`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`PostID`),
  ADD KEY `AdminID` (`AdminID`),
  ADD KEY `DogID` (`DogID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `AdminID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `certificate`
--
ALTER TABLE `certificate`
  MODIFY `CertificateID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `dog`
--
ALTER TABLE `dog`
  MODIFY `DogID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `donation`
--
ALTER TABLE `donation`
  MODIFY `DonationID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `PostID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `certificate`
--
ALTER TABLE `certificate`
  ADD CONSTRAINT `certificate_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE,
  ADD CONSTRAINT `certificate_ibfk_2` FOREIGN KEY (`AdminID`) REFERENCES `admin` (`AdminID`) ON DELETE CASCADE,
  ADD CONSTRAINT `certificate_ibfk_3` FOREIGN KEY (`DonationID`) REFERENCES `donation` (`DonationID`) ON DELETE CASCADE;

--
-- Constraints for table `donation`
--
ALTER TABLE `donation`
  ADD CONSTRAINT `donation_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE,
  ADD CONSTRAINT `donation_ibfk_2` FOREIGN KEY (`AdminID`) REFERENCES `admin` (`AdminID`) ON DELETE CASCADE,
  ADD CONSTRAINT `donation_ibfk_3` FOREIGN KEY (`PostID`) REFERENCES `post` (`PostID`) ON DELETE CASCADE;

--
-- Constraints for table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_ibfk_1` FOREIGN KEY (`AdminID`) REFERENCES `admin` (`AdminID`) ON DELETE CASCADE,
  ADD CONSTRAINT `post_ibfk_2` FOREIGN KEY (`DogID`) REFERENCES `dog` (`DogID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
