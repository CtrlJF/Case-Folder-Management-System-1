-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 08, 2024 at 05:06 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `capstone123`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_account`
--

CREATE TABLE `admin_account` (
  `id` int(11) NOT NULL,
  `id_no` int(11) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `mname` varchar(255) DEFAULT NULL,
  `lname` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_account`
--

INSERT INTO `admin_account` (`id`, `id_no`, `password`, `fname`, `mname`, `lname`) VALUES
(1, 'Admin01', '$2y$10$cLkrub8vAfKuoJHQ5mdU.eLVO5H//ZkLcaY/IEuLbM9waqPkliDz6', 'Admin01', '', 'Super Admin')

-- --------------------------------------------------------

--
-- Table structure for table `bp_cash_received`
--

CREATE TABLE `bp_cash_received` (
  `id` int(11) NOT NULL,
  `year` year(4) NOT NULL,
  `dec_jan` int(11) NOT NULL,
  `feb_mar` int(11) NOT NULL,
  `apr_may` int(11) NOT NULL,
  `june_jul` int(11) NOT NULL,
  `aug_sept` int(11) NOT NULL,
  `oct_nov` int(11) NOT NULL,
  `bp_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



-- --------------------------------------------------------

--
-- Table structure for table `bp_hh_member`
--

CREATE TABLE `bp_hh_member` (
  `id` int(11) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `mname` varchar(255) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `gender` varchar(255) NOT NULL,
  `family_relation` varchar(255) NOT NULL,
  `civil_status` varchar(255) NOT NULL,
  `buntis` varchar(255) NOT NULL,
  `school` varchar(255) NOT NULL,
  `grade` varchar(255) NOT NULL,
  `register_grant` varchar(255) NOT NULL,
  `livelihood` varchar(255) NOT NULL,
  `bp_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bp_hh_member`
--


-- --------------------------------------------------------

--
-- Table structure for table `user_account`
--

CREATE TABLE `user_account` (
  `acc_id` int(11) NOT NULL,
  `hhid` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `mname` varchar(255) DEFAULT NULL,
  `lname` varchar(255) NOT NULL,
  `phone_number` varchar(255) NOT NULL,
  `barangay` varchar(255) NOT NULL,
  `purok` varchar(255) NOT NULL,
  `user_set` varchar(255) NOT NULL,
  `phylsis_id` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `dateEntered` date NOT NULL,
  `password_length` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_account`
--
-- --------------------------------------------------------

--
-- Table structure for table `user_aer`
--

CREATE TABLE `user_aer` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `upload_date` date NOT NULL,
  `img` varchar(255) NOT NULL,
  `acc_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_beneficiary_profile`
--

CREATE TABLE `user_beneficiary_profile` (
  `id` int(11) NOT NULL,
  `probinsya` varchar(255) NOT NULL,
  `lungsod` varchar(255) NOT NULL,
  `barangay` varchar(255) NOT NULL,
  `purok` varchar(255) NOT NULL,
  `household_id` varchar(255) NOT NULL,
  `membro_tribo` varchar(255) NOT NULL,
  `name_tribo` varchar(255) NOT NULL,
  `relihiyon` varchar(255) NOT NULL,
  `family_size` int(11) NOT NULL,
  `philhealth` varchar(255) NOT NULL,
  `usergrant` varchar(255) NOT NULL,
  `account_num` varchar(255) NOT NULL,
  `hh_status` varchar(255) NOT NULL,
  `daily_income` decimal(10,2) NOT NULL,
  `use_money` varchar(255) NOT NULL,
  `upload` date NOT NULL,
  `status` varchar(255) NOT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `acc_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_beneficiary_profile`
--

-- --------------------------------------------------------

--
-- Table structure for table `user_birth_certificate`
--

CREATE TABLE `user_birth_certificate` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `famrole` varchar(255) NOT NULL,
  `img` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `acc_id` int(11) NOT NULL,
  `upload` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_birth_certificate`
--

-- --------------------------------------------------------

--
-- Table structure for table `user_car`
--

CREATE TABLE `user_car` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `upload_date` date NOT NULL,
  `img` varchar(255) NOT NULL,
  `acc_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_cash_card`
--

CREATE TABLE `user_cash_card` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `img` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `acc_id` int(11) NOT NULL,
  `upload` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_cash_card`
--

-- --------------------------------------------------------

--
-- Table structure for table `user_certificate`
--

CREATE TABLE `user_certificate` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `img` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `acc_id` int(11) NOT NULL,
  `upload` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_certificate`
--

-- --------------------------------------------------------

--
-- Table structure for table `user_family_photo`
--

CREATE TABLE `user_family_photo` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `upload` date NOT NULL,
  `img` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `acc_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_family_photo`
--

-- --------------------------------------------------------

--
-- Table structure for table `user_gis`
--

CREATE TABLE `user_gis` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `upload_date` date NOT NULL,
  `img` varchar(255) NOT NULL,
  `acc_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_gis`
--


-- --------------------------------------------------------

--
-- Table structure for table `user_grade_cards`
--

CREATE TABLE `user_grade_cards` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `upload` date NOT NULL,
  `img` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `acc_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_grade_cards`
--


-- --------------------------------------------------------

--
-- Table structure for table `user_haf`
--

CREATE TABLE `user_haf` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `upload_date` date NOT NULL,
  `img` varchar(255) NOT NULL,
  `acc_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_haf`
--


-- --------------------------------------------------------

--
-- Table structure for table `user_immunization_record`
--

CREATE TABLE `user_immunization_record` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `img` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `acc_id` int(11) NOT NULL,
  `upload` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_immunization_record`
--


-- --------------------------------------------------------

--
-- Table structure for table `user_kasabutan`
--

CREATE TABLE `user_kasabutan` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `img` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `acc_id` int(11) NOT NULL,
  `upload` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_kasabutan`
--


-- --------------------------------------------------------

--
-- Table structure for table `user_marriage_contract`
--

CREATE TABLE `user_marriage_contract` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `img` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `acc_id` int(11) NOT NULL,
  `upload` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_marriage_contract`
--


-- --------------------------------------------------------

--
-- Table structure for table `user_mdr`
--

CREATE TABLE `user_mdr` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `img` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `acc_id` int(11) NOT NULL,
  `upload` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_mdr`
--


-- --------------------------------------------------------

--
-- Table structure for table `user_national_id`
--

CREATE TABLE `user_national_id` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `famrole` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `acc_id` int(11) NOT NULL,
  `img` varchar(255) NOT NULL,
  `upload` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_national_id`
--

-- --------------------------------------------------------

--
-- Table structure for table `user_pantawid_id`
--

CREATE TABLE `user_pantawid_id` (
  `id` int(11) NOT NULL,
  `img` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `acc_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `upload` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_pantawid_id`
--


-- --------------------------------------------------------

--
-- Table structure for table `user_progress_notes`
--

CREATE TABLE `user_progress_notes` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `upload_date` date NOT NULL,
  `img` varchar(255) NOT NULL,
  `acc_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_psms`
--

CREATE TABLE `user_psms` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `upload_date` date NOT NULL,
  `img` varchar(255) NOT NULL,
  `acc_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_referral_letters`
--

CREATE TABLE `user_referral_letters` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `upload_date` date NOT NULL,
  `img` varchar(255) NOT NULL,
  `acc_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_scsr`
--

CREATE TABLE `user_scsr` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `upload_date` date NOT NULL,
  `img` varchar(255) NOT NULL,
  `acc_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_swdi_result`
--

CREATE TABLE `user_swdi_result` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `upload_date` date NOT NULL,
  `img` varchar(255) NOT NULL,
  `acc_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_account`
--
ALTER TABLE `admin_account`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_no` (`id_no`);

--
-- Indexes for table `admin_verification`
--
ALTER TABLE `admin_verification`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `master_key` (`master_key`);

--
-- Indexes for table `bp_cash_received`
--
ALTER TABLE `bp_cash_received`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bp_id` (`bp_id`) USING BTREE;

--
-- Indexes for table `bp_hh_member`
--
ALTER TABLE `bp_hh_member`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bp_id` (`bp_id`) USING BTREE;

--
-- Indexes for table `user_account`
--
ALTER TABLE `user_account`
  ADD PRIMARY KEY (`acc_id`),
  ADD UNIQUE KEY `hhid` (`hhid`);

--
-- Indexes for table `user_aer`
--
ALTER TABLE `user_aer`
  ADD PRIMARY KEY (`id`),
  ADD KEY `acc_id` (`acc_id`);

--
-- Indexes for table `user_beneficiary_profile`
--
ALTER TABLE `user_beneficiary_profile`
  ADD PRIMARY KEY (`id`),
  ADD KEY `acc_id` (`acc_id`);

--
-- Indexes for table `user_birth_certificate`
--
ALTER TABLE `user_birth_certificate`
  ADD PRIMARY KEY (`id`),
  ADD KEY `acc_id` (`acc_id`);

--
-- Indexes for table `user_car`
--
ALTER TABLE `user_car`
  ADD PRIMARY KEY (`id`),
  ADD KEY `acc_id` (`acc_id`);

--
-- Indexes for table `user_cash_card`
--
ALTER TABLE `user_cash_card`
  ADD PRIMARY KEY (`id`),
  ADD KEY `acc_id` (`acc_id`);

--
-- Indexes for table `user_certificate`
--
ALTER TABLE `user_certificate`
  ADD PRIMARY KEY (`id`),
  ADD KEY `acc_id` (`acc_id`);

--
-- Indexes for table `user_family_photo`
--
ALTER TABLE `user_family_photo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `acc_id` (`acc_id`);

--
-- Indexes for table `user_gis`
--
ALTER TABLE `user_gis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `acc_id` (`acc_id`);

--
-- Indexes for table `user_grade_cards`
--
ALTER TABLE `user_grade_cards`
  ADD PRIMARY KEY (`id`),
  ADD KEY `acc_id` (`acc_id`);

--
-- Indexes for table `user_haf`
--
ALTER TABLE `user_haf`
  ADD PRIMARY KEY (`id`),
  ADD KEY `acc_id` (`acc_id`);

--
-- Indexes for table `user_immunization_record`
--
ALTER TABLE `user_immunization_record`
  ADD PRIMARY KEY (`id`),
  ADD KEY `acc_id` (`acc_id`);

--
-- Indexes for table `user_kasabutan`
--
ALTER TABLE `user_kasabutan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `acc_id` (`acc_id`);

--
-- Indexes for table `user_marriage_contract`
--
ALTER TABLE `user_marriage_contract`
  ADD PRIMARY KEY (`id`),
  ADD KEY `acc_id` (`acc_id`);

--
-- Indexes for table `user_mdr`
--
ALTER TABLE `user_mdr`
  ADD PRIMARY KEY (`id`),
  ADD KEY `acc_id` (`acc_id`);

--
-- Indexes for table `user_national_id`
--
ALTER TABLE `user_national_id`
  ADD PRIMARY KEY (`id`),
  ADD KEY `acc_id` (`acc_id`);

--
-- Indexes for table `user_pantawid_id`
--
ALTER TABLE `user_pantawid_id`
  ADD PRIMARY KEY (`id`),
  ADD KEY `acc_id` (`acc_id`);

--
-- Indexes for table `user_progress_notes`
--
ALTER TABLE `user_progress_notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `acc_id` (`acc_id`);

--
-- Indexes for table `user_psms`
--
ALTER TABLE `user_psms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `acc_id` (`acc_id`);

--
-- Indexes for table `user_referral_letters`
--
ALTER TABLE `user_referral_letters`
  ADD PRIMARY KEY (`id`),
  ADD KEY `acc_id` (`acc_id`);

--
-- Indexes for table `user_scsr`
--
ALTER TABLE `user_scsr`
  ADD PRIMARY KEY (`id`),
  ADD KEY `acc_id` (`acc_id`);

--
-- Indexes for table `user_swdi_result`
--
ALTER TABLE `user_swdi_result`
  ADD PRIMARY KEY (`id`),
  ADD KEY `acc_id` (`acc_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_account`
--
ALTER TABLE `admin_account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `admin_verification`
--
ALTER TABLE `admin_verification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `bp_cash_received`
--
ALTER TABLE `bp_cash_received`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT for table `bp_hh_member`
--
ALTER TABLE `bp_hh_member`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=207;

--
-- AUTO_INCREMENT for table `user_account`
--
ALTER TABLE `user_account`
  MODIFY `acc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=196;

--
-- AUTO_INCREMENT for table `user_aer`
--
ALTER TABLE `user_aer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user_beneficiary_profile`
--
ALTER TABLE `user_beneficiary_profile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `user_birth_certificate`
--
ALTER TABLE `user_birth_certificate`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `user_car`
--
ALTER TABLE `user_car`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user_cash_card`
--
ALTER TABLE `user_cash_card`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `user_certificate`
--
ALTER TABLE `user_certificate`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user_family_photo`
--
ALTER TABLE `user_family_photo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `user_gis`
--
ALTER TABLE `user_gis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `user_grade_cards`
--
ALTER TABLE `user_grade_cards`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `user_haf`
--
ALTER TABLE `user_haf`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user_immunization_record`
--
ALTER TABLE `user_immunization_record`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `user_kasabutan`
--
ALTER TABLE `user_kasabutan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `user_marriage_contract`
--
ALTER TABLE `user_marriage_contract`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `user_mdr`
--
ALTER TABLE `user_mdr`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `user_national_id`
--
ALTER TABLE `user_national_id`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `user_pantawid_id`
--
ALTER TABLE `user_pantawid_id`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `user_progress_notes`
--
ALTER TABLE `user_progress_notes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user_psms`
--
ALTER TABLE `user_psms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user_referral_letters`
--
ALTER TABLE `user_referral_letters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user_scsr`
--
ALTER TABLE `user_scsr`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user_swdi_result`
--
ALTER TABLE `user_swdi_result`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bp_cash_received`
--
ALTER TABLE `bp_cash_received`
  ADD CONSTRAINT `bp_cash_received_ibfk_1` FOREIGN KEY (`bp_id`) REFERENCES `user_beneficiary_profile` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `bp_hh_member`
--
ALTER TABLE `bp_hh_member`
  ADD CONSTRAINT `bp_hh_member_ibfk_1` FOREIGN KEY (`bp_id`) REFERENCES `user_beneficiary_profile` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_aer`
--
ALTER TABLE `user_aer`
  ADD CONSTRAINT `user_aer_ibfk_1` FOREIGN KEY (`acc_id`) REFERENCES `user_account` (`acc_id`);

--
-- Constraints for table `user_beneficiary_profile`
--
ALTER TABLE `user_beneficiary_profile`
  ADD CONSTRAINT `user_beneficiary_profile_ibfk_1` FOREIGN KEY (`acc_id`) REFERENCES `user_account` (`acc_id`);

--
-- Constraints for table `user_birth_certificate`
--
ALTER TABLE `user_birth_certificate`
  ADD CONSTRAINT `user_birth_certificate_ibfk_1` FOREIGN KEY (`acc_id`) REFERENCES `user_account` (`acc_id`);

--
-- Constraints for table `user_car`
--
ALTER TABLE `user_car`
  ADD CONSTRAINT `user_car_ibfk_1` FOREIGN KEY (`acc_id`) REFERENCES `user_account` (`acc_id`);

--
-- Constraints for table `user_cash_card`
--
ALTER TABLE `user_cash_card`
  ADD CONSTRAINT `user_cash_card_ibfk_1` FOREIGN KEY (`acc_id`) REFERENCES `user_account` (`acc_id`);

--
-- Constraints for table `user_certificate`
--
ALTER TABLE `user_certificate`
  ADD CONSTRAINT `user_certificate_ibfk_1` FOREIGN KEY (`acc_id`) REFERENCES `user_account` (`acc_id`);

--
-- Constraints for table `user_family_photo`
--
ALTER TABLE `user_family_photo`
  ADD CONSTRAINT `user_family_photo_ibfk_1` FOREIGN KEY (`acc_id`) REFERENCES `user_account` (`acc_id`);

--
-- Constraints for table `user_gis`
--
ALTER TABLE `user_gis`
  ADD CONSTRAINT `user_gis_ibfk_1` FOREIGN KEY (`acc_id`) REFERENCES `user_account` (`acc_id`);

--
-- Constraints for table `user_grade_cards`
--
ALTER TABLE `user_grade_cards`
  ADD CONSTRAINT `user_grade_cards_ibfk_1` FOREIGN KEY (`acc_id`) REFERENCES `user_account` (`acc_id`);

--
-- Constraints for table `user_haf`
--
ALTER TABLE `user_haf`
  ADD CONSTRAINT `user_haf_ibfk_1` FOREIGN KEY (`acc_id`) REFERENCES `user_account` (`acc_id`);

--
-- Constraints for table `user_immunization_record`
--
ALTER TABLE `user_immunization_record`
  ADD CONSTRAINT `user_immunization_record_ibfk_1` FOREIGN KEY (`acc_id`) REFERENCES `user_account` (`acc_id`);

--
-- Constraints for table `user_kasabutan`
--
ALTER TABLE `user_kasabutan`
  ADD CONSTRAINT `user_kasabutan_ibfk_1` FOREIGN KEY (`acc_id`) REFERENCES `user_account` (`acc_id`);

--
-- Constraints for table `user_marriage_contract`
--
ALTER TABLE `user_marriage_contract`
  ADD CONSTRAINT `user_marriage_contract_ibfk_1` FOREIGN KEY (`acc_id`) REFERENCES `user_account` (`acc_id`);

--
-- Constraints for table `user_mdr`
--
ALTER TABLE `user_mdr`
  ADD CONSTRAINT `user_mdr_ibfk_1` FOREIGN KEY (`acc_id`) REFERENCES `user_account` (`acc_id`);

--
-- Constraints for table `user_national_id`
--
ALTER TABLE `user_national_id`
  ADD CONSTRAINT `user_national_id_ibfk_1` FOREIGN KEY (`acc_id`) REFERENCES `user_account` (`acc_id`);

--
-- Constraints for table `user_pantawid_id`
--
ALTER TABLE `user_pantawid_id`
  ADD CONSTRAINT `user_pantawid_id_ibfk_1` FOREIGN KEY (`acc_id`) REFERENCES `user_account` (`acc_id`);

--
-- Constraints for table `user_progress_notes`
--
ALTER TABLE `user_progress_notes`
  ADD CONSTRAINT `user_progress_notes_ibfk_1` FOREIGN KEY (`acc_id`) REFERENCES `user_account` (`acc_id`);

--
-- Constraints for table `user_psms`
--
ALTER TABLE `user_psms`
  ADD CONSTRAINT `user_psms_ibfk_1` FOREIGN KEY (`acc_id`) REFERENCES `user_account` (`acc_id`);

--
-- Constraints for table `user_referral_letters`
--
ALTER TABLE `user_referral_letters`
  ADD CONSTRAINT `user_referral_letters_ibfk_1` FOREIGN KEY (`acc_id`) REFERENCES `user_account` (`acc_id`);

--
-- Constraints for table `user_scsr`
--
ALTER TABLE `user_scsr`
  ADD CONSTRAINT `user_scsr_ibfk_1` FOREIGN KEY (`acc_id`) REFERENCES `user_account` (`acc_id`);

--
-- Constraints for table `user_swdi_result`
--
ALTER TABLE `user_swdi_result`
  ADD CONSTRAINT `user_swdi_result_ibfk_1` FOREIGN KEY (`acc_id`) REFERENCES `user_account` (`acc_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
