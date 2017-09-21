-- phpMyAdmin SQL Dump
-- version 4.0.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 31, 2017 at 12:47 PM
-- Server version: 5.7.16
-- PHP Version: 5.6.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `checklist`
--

-- --------------------------------------------------------

--
-- Table structure for table `api_log`
--

CREATE TABLE IF NOT EXISTS `api_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uri` varchar(255) NOT NULL,
  `method` varchar(6) NOT NULL,
  `params` text,
  `api_key` varchar(250) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `auditlogs`
--

CREATE TABLE IF NOT EXISTS `auditlogs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `message` longtext NOT NULL,
  `ip_address` varchar(50) NOT NULL,
  `date` datetime NOT NULL,
  `tabtype` enum('1','2','3','4','5','6','7','8','9','10','11','12','13') NOT NULL COMMENT '1- Login, 2-Category, 3-User, 4-Questions, 5-Forms,6-Others',
  `login_id` int(11) NOT NULL,
  `created_name` varchar(100) NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=125 ;

--
-- Dumping data for table `auditlogs`
--

INSERT INTO `auditlogs` (`id`, `message`, `ip_address`, `date`, `tabtype`, `login_id`, `created_name`, `updated_at`, `created_at`) VALUES
(1, 'Logged-Out', '::1', '2017-05-18 13:03:55', '1', 3, 'Check Admin', '2017-05-18 13:03:55', '2017-05-18 13:03:55'),
(2, 'Logged-In', '::1', '2017-05-18 13:03:58', '1', 1, 'Admin', '2017-05-18 13:03:58', '2017-05-18 13:03:58'),
(3, 'Logged-In', '172.31.12.216', '2017-05-19 10:08:01', '1', 1, 'Admin', '2017-05-19 10:08:01', '2017-05-19 10:08:01'),
(4, 'Category #Chemotherapy Rounds  updated successfully!', '172.31.12.216', '2017-05-19 10:22:14', '2', 1, 'Admin', '2017-05-19 10:22:14', '2017-05-19 10:22:14'),
(5, 'Question #Turnign Schedules updated successfully!', '172.31.12.216', '2017-05-19 10:23:03', '4', 1, 'Admin', '2017-05-19 10:23:03', '2017-05-19 10:23:03'),
(6, 'Logged-Out', '172.31.12.216', '2017-05-19 12:07:10', '1', 1, 'Admin', '2017-05-19 12:07:10', '2017-05-19 12:07:10'),
(7, 'Logged-In', '172.31.12.216', '2017-05-19 12:07:13', '1', 1, 'Admin', '2017-05-19 12:07:13', '2017-05-19 12:07:13'),
(8, 'Form #Checklist Status List  created successfully!', '172.31.12.216', '2017-05-19 12:08:05', '5', 1, 'Admin', '2017-05-19 12:08:05', '2017-05-19 12:08:05'),
(9, 'Form #Checklist Status List  updated successfully!', '172.31.12.216', '2017-05-19 12:08:32', '5', 1, 'Admin', '2017-05-19 12:08:32', '2017-05-19 12:08:32'),
(10, 'Logged-Out', '172.31.12.216', '2017-05-19 12:41:46', '1', 1, 'Admin', '2017-05-19 12:41:46', '2017-05-19 12:41:46'),
(11, 'Logged-In', '172.31.12.216', '2017-05-19 12:41:55', '1', 1, 'Admin', '2017-05-19 12:41:55', '2017-05-19 12:41:55'),
(12, 'Logged-Out', '172.31.12.216', '2017-05-19 12:46:16', '1', 1, 'Admin', '2017-05-19 12:46:16', '2017-05-19 12:46:16'),
(13, 'Logged-In', '172.31.12.216', '2017-05-19 12:57:45', '1', 1, 'Admin', '2017-05-19 12:57:45', '2017-05-19 12:57:45'),
(14, 'Logged-In', '172.31.12.216', '2017-05-19 14:13:55', '1', 1, 'Admin', '2017-05-19 14:13:55', '2017-05-19 14:13:55'),
(15, 'Question #What is the ?  created successfully!', '172.31.12.216', '2017-05-19 14:16:21', '4', 1, 'Admin', '2017-05-19 14:16:21', '2017-05-19 14:16:21'),
(16, 'Form #Night shift nurse tish6 floor 5  created successfully!', '172.31.12.216', '2017-05-19 14:19:17', '5', 1, 'Admin', '2017-05-19 14:19:17', '2017-05-19 14:19:17'),
(17, 'Question #Done or not ?  created successfully!', '172.31.12.216', '2017-05-19 14:22:41', '4', 1, 'Admin', '2017-05-19 14:22:41', '2017-05-19 14:22:41'),
(18, 'Logged-Out', '172.31.12.216', '2017-05-19 15:09:25', '1', 1, 'Admin', '2017-05-19 15:09:25', '2017-05-19 15:09:25'),
(19, 'Logged-In', '172.31.12.216', '2017-05-19 16:08:22', '1', 1, 'Admin', '2017-05-19 16:08:22', '2017-05-19 16:08:22'),
(20, 'Logged-In', '172.31.12.216', '2017-05-19 19:25:04', '1', 1, 'Admin', '2017-05-19 19:25:04', '2017-05-19 19:25:04'),
(21, 'Logged-In', '172.31.12.216', '2017-05-19 19:25:52', '1', 1, 'Admin', '2017-05-19 19:25:52', '2017-05-19 19:25:52'),
(22, 'Logged-In', '172.31.12.216', '2017-05-22 06:22:15', '1', 1, 'Admin', '2017-05-22 06:22:15', '2017-05-22 06:22:15'),
(23, 'Logged-In', '172.31.12.216', '2017-05-22 11:21:18', '1', 1, 'Admin', '2017-05-22 11:21:18', '2017-05-22 11:21:18'),
(24, 'Logged-In', '172.31.12.216', '2017-05-22 12:38:27', '1', 1, 'Admin', '2017-05-22 12:38:27', '2017-05-22 12:38:27'),
(25, 'Logged-In', '172.31.12.216', '2017-05-22 12:38:54', '1', 1, 'Admin', '2017-05-22 12:38:54', '2017-05-22 12:38:54'),
(26, 'Logged-Out', '172.31.12.216', '2017-05-22 13:12:53', '1', 1, 'Admin', '2017-05-22 13:12:53', '2017-05-22 13:12:53'),
(27, 'Logged-In', '172.31.12.216', '2017-05-24 05:32:06', '1', 1, 'Admin', '2017-05-24 05:32:06', '2017-05-24 05:32:06'),
(28, 'Group #Group 1  created successfully!', '172.31.12.216', '2017-05-24 05:44:09', '6', 1, 'Admin', '2017-05-24 05:44:09', '2017-05-24 05:44:09'),
(29, 'Logged-Out', '172.31.12.216', '2017-05-24 06:33:38', '1', 1, 'Admin', '2017-05-24 06:33:38', '2017-05-24 06:33:38'),
(30, 'Logged-In', '172.31.12.216', '2017-05-24 06:34:04', '1', 1, 'Admin', '2017-05-24 06:34:04', '2017-05-24 06:34:04'),
(31, 'Logged-In', '172.31.12.216', '2017-05-24 09:00:57', '1', 1, 'Admin', '2017-05-24 09:00:57', '2017-05-24 09:00:57'),
(32, 'Category #Test Rounds  created successfully!', '172.31.12.216', '2017-05-24 09:07:31', '2', 1, 'Admin', '2017-05-24 09:07:31', '2017-05-24 09:07:31'),
(33, 'Category #Patient Rounds  created successfully!', '172.31.12.216', '2017-05-24 09:07:45', '2', 1, 'Admin', '2017-05-24 09:07:45', '2017-05-24 09:07:45'),
(34, 'Question #Obtain report from night charge nurse  created successfully!', '172.31.12.216', '2017-05-24 09:11:06', '4', 1, 'Admin', '2017-05-24 09:11:06', '2017-05-24 09:11:06'),
(35, 'Question #Chemotherapy for shift  created successfully!', '172.31.12.216', '2017-05-24 09:12:15', '4', 1, 'Admin', '2017-05-24 09:12:15', '2017-05-24 09:12:15'),
(36, 'Question #Telemetry check/count  created successfully!', '172.31.12.216', '2017-05-24 09:16:48', '4', 1, 'Admin', '2017-05-24 09:16:48', '2017-05-24 09:16:48'),
(37, 'Question #Chemotherapy for shift updated successfully!', '172.31.12.216', '2017-05-24 09:18:05', '4', 1, 'Admin', '2017-05-24 09:18:05', '2017-05-24 09:18:05'),
(38, 'Question #Telemetry check/count updated successfully!', '172.31.12.216', '2017-05-24 09:18:14', '4', 1, 'Admin', '2017-05-24 09:18:14', '2017-05-24 09:18:14'),
(39, 'Question #Telemetry check/count updated successfully!', '172.31.12.216', '2017-05-24 09:18:18', '4', 1, 'Admin', '2017-05-24 09:18:18', '2017-05-24 09:18:18'),
(40, 'Question #Chemotherapy for shift updated successfully!', '172.31.12.216', '2017-05-24 09:18:28', '4', 1, 'Admin', '2017-05-24 09:18:28', '2017-05-24 09:18:28'),
(41, 'Question deleted successfully!', '172.31.12.216', '2017-05-24 09:20:55', '4', 1, 'Admin', '2017-05-24 09:20:55', '2017-05-24 09:20:55'),
(42, 'Question #Obtain report from night charge nurse  created successfully!', '172.31.12.216', '2017-05-24 09:21:29', '4', 1, 'Admin', '2017-05-24 09:21:29', '2017-05-24 09:21:29'),
(43, 'Category #Environmental Rounds  created successfully!', '172.31.12.216', '2017-05-24 09:23:50', '2', 1, 'Admin', '2017-05-24 09:23:50', '2017-05-24 09:23:50'),
(44, 'Category #patient safety  created successfully!', '172.31.12.216', '2017-05-24 09:24:24', '2', 1, 'Admin', '2017-05-24 09:24:24', '2017-05-24 09:24:24'),
(45, 'Logged-In', '172.31.12.216', '2017-05-24 09:53:55', '1', 1, 'Admin', '2017-05-24 09:53:55', '2017-05-24 09:53:55'),
(46, 'Group deleted successfully!', '172.31.12.216', '2017-05-24 09:54:50', '6', 1, 'Admin', '2017-05-24 09:54:50', '2017-05-24 09:54:50'),
(47, 'Category deleted successfully!', '172.31.12.216', '2017-05-24 09:55:09', '2', 1, 'Admin', '2017-05-24 09:55:09', '2017-05-24 09:55:09'),
(48, 'Category deleted successfully!', '172.31.12.216', '2017-05-24 09:55:15', '2', 1, 'Admin', '2017-05-24 09:55:15', '2017-05-24 09:55:15'),
(49, 'Logged-Out', '172.31.12.216', '2017-05-24 09:55:24', '1', 1, 'Admin', '2017-05-24 09:55:24', '2017-05-24 09:55:24'),
(50, 'Category #To Do List Pertinent to shift  created successfully!', '172.31.12.216', '2017-05-24 10:46:45', '2', 1, 'Admin', '2017-05-24 10:46:45', '2017-05-24 10:46:45'),
(51, 'Question #Obtain report from night charge nurse  created successfully!', '172.31.12.216', '2017-05-24 10:52:54', '4', 1, 'Admin', '2017-05-24 10:52:54', '2017-05-24 10:52:54'),
(52, 'Question #Chemotheraphy for shifts  created successfully!', '172.31.12.216', '2017-05-24 10:53:55', '4', 1, 'Admin', '2017-05-24 10:53:55', '2017-05-24 10:53:55'),
(53, 'Question #Telemetry check/count   created successfully!', '172.31.12.216', '2017-05-24 10:55:40', '4', 1, 'Admin', '2017-05-24 10:55:40', '2017-05-24 10:55:40'),
(54, 'Question #Omnicell discrepancy check with night charge nurse  created successfully!', '172.31.12.216', '2017-05-24 10:57:51', '4', 1, 'Admin', '2017-05-24 10:57:51', '2017-05-24 10:57:51'),
(55, 'Question #Airway cart check (16E and BMT)  created successfully!', '172.31.12.216', '2017-05-24 10:59:10', '4', 1, 'Admin', '2017-05-24 10:59:10', '2017-05-24 10:59:10'),
(56, 'Question #Emergency Transport monitor with all attachments and plugged(stored in BMT)  created successfully!', '172.31.12.216', '2017-05-24 11:00:14', '4', 1, 'Admin', '2017-05-24 11:00:14', '2017-05-24 11:00:14'),
(57, 'Question #Check with PUA to double check bed status in case charge RN missed anything  created successfully!', '172.31.12.216', '2017-05-24 11:01:18', '4', 1, 'Admin', '2017-05-24 11:01:18', '2017-05-24 11:01:18'),
(58, 'Question #Urine QC  created successfully!', '172.31.12.216', '2017-05-24 11:01:42', '4', 1, 'Admin', '2017-05-24 11:01:42', '2017-05-24 11:01:42'),
(59, 'Question #Narcotic count/MRT box  created successfully!', '172.31.12.216', '2017-05-24 11:02:14', '4', 1, 'Admin', '2017-05-24 11:02:14', '2017-05-24 11:02:14'),
(60, 'Question #Ensure all RN''s attend team Rounds  created successfully!', '172.31.12.216', '2017-05-24 11:02:52', '4', 1, 'Admin', '2017-05-24 11:02:52', '2017-05-24 11:02:52'),
(61, 'Question #Address your self as the charge nurse/Nurse leader, and perform rounds  created successfully!', '172.31.12.216', '2017-05-24 11:04:01', '4', 1, 'Admin', '2017-05-24 11:04:01', '2017-05-24 11:04:01'),
(62, 'Question #Bed Huddle 1130  created successfully!', '172.31.12.216', '2017-05-24 11:05:21', '4', 1, 'Admin', '2017-05-24 11:05:21', '2017-05-24 11:05:21'),
(63, 'Question #Address your self as the charge nurse/Nurse leader, and perform rounds(document feedback in nurse leader rounds binder) updated successfully!', '172.31.12.216', '2017-05-24 11:06:22', '4', 1, 'Admin', '2017-05-24 11:06:22', '2017-05-24 11:06:22'),
(64, 'Question #Assess and address Patient/family concern or complaints  created successfully!', '172.31.12.216', '2017-05-24 11:07:42', '4', 1, 'Admin', '2017-05-24 11:07:42', '2017-05-24 11:07:42'),
(65, 'Question #Assess and address Patient/family concern or complaints (document in nurse leader rounds binder) updated successfully!', '172.31.12.216', '2017-05-24 11:09:00', '4', 1, 'Admin', '2017-05-24 11:09:00', '2017-05-24 11:09:00'),
(66, 'Question #IV tubing Dated  created successfully!', '172.31.12.216', '2017-05-24 11:09:21', '4', 1, 'Admin', '2017-05-24 11:09:21', '2017-05-24 11:09:21'),
(67, 'Question #CVL and PVL sites dated and with no signs of infection  created successfully!', '172.31.12.216', '2017-05-24 11:10:09', '4', 1, 'Admin', '2017-05-24 11:10:09', '2017-05-24 11:10:09'),
(68, 'Question #Oxygen tubing, humidifiers, Nebulizer dated  created successfully!', '172.31.12.216', '2017-05-24 11:12:10', '4', 1, 'Admin', '2017-05-24 11:12:10', '2017-05-24 11:12:10'),
(69, 'Question #open saline bottles and dated  created successfully!', '172.31.12.216', '2017-05-24 11:12:56', '4', 1, 'Admin', '2017-05-24 11:12:56', '2017-05-24 11:12:56'),
(70, 'Question #Patient bedside clean  created successfully!', '172.31.12.216', '2017-05-24 11:13:32', '4', 1, 'Admin', '2017-05-24 11:13:32', '2017-05-24 11:13:32'),
(71, 'Question #No meds/scissors/syringes on carts or at nursing station, medicaion cards locked, computers secured when not in use, medication fridge locked (remove key from lock)  created successfully!', '172.31.12.216', '2017-05-24 11:24:52', '4', 1, 'Admin', '2017-05-24 11:24:52', '2017-05-24 11:24:52'),
(72, 'Question #No loose ks in halls, hallway clear, and unobstucted  created successfully!', '172.31.12.216', '2017-05-24 11:26:37', '4', 1, 'Admin', '2017-05-24 11:26:37', '2017-05-24 11:26:37'),
(73, 'Question #Check for look-alike-sound alike names(need 100% compliance X 90 days)  created successfully!', '172.31.12.216', '2017-05-24 11:29:09', '4', 1, 'Admin', '2017-05-24 11:29:09', '2017-05-24 11:29:09'),
(74, 'Question #fall huddle 0800  created successfully!', '172.31.12.216', '2017-05-24 11:29:36', '4', 1, 'Admin', '2017-05-24 11:29:36', '2017-05-24 11:29:36'),
(75, 'Question #Limited English Proficiency(LEP) patients  created successfully!', '172.31.12.216', '2017-05-24 11:31:17', '4', 1, 'Admin', '2017-05-24 11:31:17', '2017-05-24 11:31:17'),
(76, 'Question #Limited English Proficiency(LEP) patients updated successfully!', '172.31.12.216', '2017-05-24 11:31:38', '4', 1, 'Admin', '2017-05-24 11:31:38', '2017-05-24 11:31:38'),
(77, 'Question #Patients on turning schedules  created successfully!', '172.31.12.216', '2017-05-24 11:32:38', '4', 1, 'Admin', '2017-05-24 11:32:38', '2017-05-24 11:32:38'),
(78, 'Question #Patients with significant pain  created successfully!', '172.31.12.216', '2017-05-24 11:33:15', '4', 1, 'Admin', '2017-05-24 11:33:15', '2017-05-24 11:33:15'),
(79, 'Question #Patients on turning schedules updated successfully!', '172.31.12.216', '2017-05-24 11:33:33', '4', 1, 'Admin', '2017-05-24 11:33:33', '2017-05-24 11:33:33'),
(80, 'Question #fall Audits(wednesday and friday am PCTs)  created successfully!', '172.31.12.216', '2017-05-24 11:35:11', '4', 1, 'Admin', '2017-05-24 11:35:11', '2017-05-24 11:35:11'),
(81, 'Question #Update shift assignment shift  created successfully!', '172.31.12.216', '2017-05-24 11:36:50', '4', 1, 'Admin', '2017-05-24 11:36:50', '2017-05-24 11:36:50'),
(82, 'Question #Assign and document meal times for all staff  created successfully!', '172.31.12.216', '2017-05-24 11:37:38', '4', 1, 'Admin', '2017-05-24 11:37:38', '2017-05-24 11:37:38'),
(83, 'Question #Evening PCT  assignment/ and break assignments 1530  created successfully!', '172.31.12.216', '2017-05-24 11:38:39', '4', 1, 'Admin', '2017-05-24 11:38:39', '2017-05-24 11:38:39'),
(84, 'Question #Narcotic Count/MRT box/patient transport med box in omnicell  created successfully!', '172.31.12.216', '2017-05-24 11:39:51', '4', 1, 'Admin', '2017-05-24 11:39:51', '2017-05-24 11:39:51'),
(85, 'Question #Discharge/DBN rounds at 1430  created successfully!', '172.31.12.216', '2017-05-24 11:42:50', '4', 1, 'Admin', '2017-05-24 11:42:50', '2017-05-24 11:42:50'),
(86, 'Question #RN "numbers" & receive update on patient''s conditions  created successfully!', '172.31.12.216', '2017-05-24 11:44:07', '4', 1, 'Admin', '2017-05-24 11:44:07', '2017-05-24 11:44:07'),
(87, 'Question #RN and PCT assignments for next shift completed at 1730  created successfully!', '172.31.12.216', '2017-05-24 11:45:44', '4', 1, 'Admin', '2017-05-24 11:45:44', '2017-05-24 11:45:44'),
(88, 'Question #Plan for future shifts, ensure adequate staffing on 16east and BMT unit   created successfully!', '172.31.12.216', '2017-05-24 11:47:12', '4', 1, 'Admin', '2017-05-24 11:47:12', '2017-05-24 11:47:12'),
(89, 'Question #Utilize downtime to assign staff to complete iDevelop learning modules  created successfully!', '172.31.12.216', '2017-05-24 11:48:20', '4', 1, 'Admin', '2017-05-24 11:48:20', '2017-05-24 11:48:20'),
(90, 'Question #Ensure that staff is able to attend council meetings of the unit  created successfully!', '172.31.12.216', '2017-05-24 11:49:23', '4', 1, 'Admin', '2017-05-24 11:49:23', '2017-05-24 11:49:23'),
(91, 'Question #check charge blackberry email for radiation oncology appointments for the next day; pending admission  created successfully!', '172.31.12.216', '2017-05-24 11:51:58', '4', 1, 'Admin', '2017-05-24 11:51:58', '2017-05-24 11:51:58'),
(92, 'Question #NASH/PCM updated with PUA  created successfully!', '172.31.12.216', '2017-05-24 11:53:23', '4', 1, 'Admin', '2017-05-24 11:53:23', '2017-05-24 11:53:23'),
(93, 'Question #Update schedule with sick calls, floats, emergency time off, OT,etc  created successfully!', '172.31.12.216', '2017-05-24 11:54:29', '4', 1, 'Admin', '2017-05-24 11:54:29', '2017-05-24 11:54:29'),
(94, 'Question #Obtain report from day charge nurse  created successfully!', '172.31.12.216', '2017-05-24 11:59:49', '4', 1, 'Admin', '2017-05-24 11:59:49', '2017-05-24 11:59:49'),
(95, 'Question #Fall Audits(Monday evening/night)  created successfully!', '172.31.12.216', '2017-05-24 12:03:15', '4', 1, 'Admin', '2017-05-24 12:03:15', '2017-05-24 12:03:15'),
(96, 'Question #Cauti Binder (Fri Nights)  created successfully!', '172.31.12.216', '2017-05-24 12:04:46', '4', 1, 'Admin', '2017-05-24 12:04:46', '2017-05-24 12:04:46'),
(97, 'Question #Skin binder (Mon, wed, Friday nights)- please do during your initial rounds!  created successfully!', '172.31.12.216', '2017-05-24 12:06:11', '4', 1, 'Admin', '2017-05-24 12:06:11', '2017-05-24 12:06:11'),
(98, 'Question #Night PCT assignment/ and break assignments 2330  created successfully!', '172.31.12.216', '2017-05-24 12:07:34', '4', 1, 'Admin', '2017-05-24 12:07:34', '2017-05-24 12:07:34'),
(99, 'Question #Assign PCT for Glucometer check at 0030. Must add comment "cleaned monitor"  created successfully!', '172.31.12.216', '2017-05-24 12:10:07', '4', 1, 'Admin', '2017-05-24 12:10:07', '2017-05-24 12:10:07'),
(100, 'Question #Glucose Strips dated  created successfully!', '172.31.12.216', '2017-05-24 12:11:10', '4', 1, 'Admin', '2017-05-24 12:11:10', '2017-05-24 12:11:10'),
(101, 'Question #Rounds with RNS  created successfully!', '172.31.12.216', '2017-05-24 12:13:35', '4', 1, 'Admin', '2017-05-24 12:13:35', '2017-05-24 12:13:35'),
(102, 'Question #RN and PCT assignments for next shift completed at 0500  created successfully!', '172.31.12.216', '2017-05-24 12:15:07', '4', 1, 'Admin', '2017-05-24 12:15:07', '2017-05-24 12:15:07'),
(103, 'Logged-In', '172.31.12.216', '2017-05-24 15:26:39', '1', 1, 'Admin', '2017-05-24 15:26:39', '2017-05-24 15:26:39'),
(104, 'Logged-In', '172.31.12.216', '2017-05-25 06:07:35', '1', 1, 'Admin', '2017-05-25 06:07:35', '2017-05-25 06:07:35'),
(105, 'Logged-In', '172.31.12.216', '2017-05-25 06:08:43', '1', 1, 'Admin', '2017-05-25 06:08:43', '2017-05-25 06:08:43'),
(106, 'Logged-In', '172.31.12.216', '2017-05-25 15:28:56', '1', 1, 'Admin', '2017-05-25 15:28:56', '2017-05-25 15:28:56'),
(107, 'Logged-In', '172.31.12.216', '2017-05-30 14:53:01', '1', 1, 'Admin', '2017-05-30 14:53:01', '2017-05-30 14:53:01'),
(108, 'Logged-In', '172.31.12.216', '2017-05-31 09:25:15', '1', 1, 'Admin', '2017-05-31 09:25:15', '2017-05-31 09:25:15'),
(109, 'User # gmaturu created successfully!', '172.31.12.216', '2017-05-31 10:24:31', '3', 1, 'Admin', '2017-05-31 10:24:31', '2017-05-31 10:24:31'),
(110, 'Logged-In', '172.31.12.216', '2017-05-31 10:26:45', '1', 1, 'Admin ', '2017-05-31 10:26:45', '2017-05-31 10:26:45'),
(111, 'Logged-In', '172.31.12.216', '2017-05-31 10:35:35', '1', 1, 'Admin ', '2017-05-31 10:35:35', '2017-05-31 10:35:35'),
(112, 'Logged-In', '172.31.12.216', '2017-05-31 10:42:47', '1', 1, 'Admin ', '2017-05-31 10:42:47', '2017-05-31 10:42:47'),
(113, 'Logged-In', '172.31.12.216', '2017-05-31 10:52:03', '1', 1, 'Admin ', '2017-05-31 10:52:03', '2017-05-31 10:52:03'),
(114, 'Logged-In', '172.31.12.216', '2017-05-31 10:53:21', '1', 2, 'Gopi Maturu', '2017-05-31 10:53:21', '2017-05-31 10:53:21'),
(115, 'Logged-In', '172.31.12.216', '2017-05-31 11:09:34', '1', 1, 'Admin ', '2017-05-31 11:09:34', '2017-05-31 11:09:34'),
(116, 'Logged-In', '172.31.12.216', '2017-05-31 11:14:29', '1', 1, 'Admin ', '2017-05-31 11:14:29', '2017-05-31 11:14:29'),
(117, 'Logged-In', '172.31.12.216', '2017-05-31 12:06:21', '1', 1, 'Admin ', '2017-05-31 12:06:21', '2017-05-31 12:06:21'),
(118, 'Logged-In', '172.31.12.216', '2017-05-31 12:06:50', '1', 1, 'Admin ', '2017-05-31 12:06:50', '2017-05-31 12:06:50'),
(119, 'Logged-In', '172.31.12.216', '2017-05-31 12:07:18', '1', 1, 'Admin ', '2017-05-31 12:07:18', '2017-05-31 12:07:18'),
(120, 'Logged-In', '172.31.12.216', '2017-05-31 12:09:06', '1', 2, 'Gopi Maturu', '2017-05-31 12:09:06', '2017-05-31 12:09:06'),
(121, 'Logged-In', '172.31.12.216', '2017-05-31 12:09:10', '1', 2, 'Gopi Maturu', '2017-05-31 12:09:10', '2017-05-31 12:09:10'),
(122, 'Logged-In', '172.31.12.216', '2017-05-31 12:09:36', '1', 1, 'Admin ', '2017-05-31 12:09:36', '2017-05-31 12:09:36'),
(123, 'Logged-In', '172.31.12.216', '2017-05-31 12:10:33', '1', 2, 'Gopi Maturu', '2017-05-31 12:10:33', '2017-05-31 12:10:33'),
(124, 'Logged-In', '172.31.12.216', '2017-05-31 12:28:22', '1', 1, 'Admin ', '2017-05-31 12:28:22', '2017-05-31 12:28:22');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` datetime NOT NULL,
  `record_status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`, `description`, `created_at`, `created_by`, `updated_at`, `record_status`) VALUES
(1, 'Test Rounds', '', '2017-05-24 09:07:31', 1, '2017-05-24 09:07:31', 1),
(2, 'Patient Rounds', '', '2017-05-24 09:07:45', 1, '2017-05-24 09:07:45', 1),
(3, 'Environmental Rounds', '', '2017-05-24 09:23:50', 1, '2017-05-24 09:55:15', 1),
(4, 'patient safety', '', '2017-05-24 09:24:24', 1, '2017-05-24 09:55:09', 1),
(5, 'To Do List Pertinent to shift', '', '2017-05-24 10:46:45', 1, '2017-05-24 10:46:45', 1);

-- --------------------------------------------------------

--
-- Table structure for table `forms`
--

CREATE TABLE IF NOT EXISTS `forms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  `description` text NOT NULL,
  `no_of_questions` int(11) NOT NULL DEFAULT '0',
  `questions` longtext NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` datetime NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '1=>Completed 2 => Draft',
  `record_status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` datetime NOT NULL,
  `record_status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `name`, `description`, `created_at`, `created_by`, `updated_at`, `record_status`) VALUES
(1, 'Group 1', '', '2017-05-24 05:44:09', 1, '2017-05-24 09:54:50', 0);

-- --------------------------------------------------------

--
-- Table structure for table `link_form_groups`
--

CREATE TABLE IF NOT EXISTS `link_form_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `form_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` datetime NOT NULL,
  `record_status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `link_user_groups`
--

CREATE TABLE IF NOT EXISTS `link_user_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` datetime NOT NULL,
  `record_status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE IF NOT EXISTS `questions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `options` longtext NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` datetime NOT NULL,
  `record_status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=49 ;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `category_id`, `name`, `description`, `options`, `created_at`, `created_by`, `updated_at`, `record_status`) VALUES
(1, 1, 'Obtain report from night charge nurse', '', 'a:3:{s:11:"option_type";s:8:"checkbox";s:13:"no_of_options";i:1;s:7:"options";a:1:{i:0;s:4:"Done";}}', '2017-05-24 10:52:54', 1, '2017-05-24 10:52:54', 1),
(2, 1, 'Chemotheraphy for shifts', '', 'a:3:{s:11:"option_type";s:5:"input";s:13:"no_of_options";s:1:"4";s:7:"options";a:0:{}}', '2017-05-24 10:53:55', 1, '2017-05-24 10:53:55', 1),
(3, 1, 'Telemetry check/count ', '', 'a:3:{s:11:"option_type";s:8:"checkbox";s:13:"no_of_options";i:1;s:7:"options";a:1:{i:0;s:4:"Done";}}', '2017-05-24 10:55:40', 1, '2017-05-24 10:55:40', 1),
(4, 1, 'Omnicell discrepancy check with night charge nurse', '', 'a:3:{s:11:"option_type";s:8:"checkbox";s:13:"no_of_options";i:1;s:7:"options";a:1:{i:0;s:4:"Done";}}', '2017-05-24 10:57:51', 1, '2017-05-24 10:57:51', 1),
(5, 1, 'Airway cart check (16E and BMT)', '', 'a:3:{s:11:"option_type";s:8:"checkbox";s:13:"no_of_options";i:1;s:7:"options";a:1:{i:0;s:4:"Done";}}', '2017-05-24 10:59:10', 1, '2017-05-24 10:59:10', 1),
(6, 1, 'Emergency Transport monitor with all attachments and plugged(stored in BMT)', '', 'a:3:{s:11:"option_type";s:8:"checkbox";s:13:"no_of_options";i:1;s:7:"options";a:1:{i:0;s:4:"Done";}}', '2017-05-24 11:00:14', 1, '2017-05-24 11:00:14', 1),
(7, 1, 'Check with PUA to double check bed status in case charge RN missed anything', '', 'a:3:{s:11:"option_type";s:8:"checkbox";s:13:"no_of_options";i:1;s:7:"options";a:1:{i:0;s:4:"Done";}}', '2017-05-24 11:01:18', 1, '2017-05-24 11:01:18', 1),
(8, 1, 'Urine QC', '', 'a:3:{s:11:"option_type";s:8:"checkbox";s:13:"no_of_options";i:1;s:7:"options";a:1:{i:0;s:4:"Done";}}', '2017-05-24 11:01:42', 1, '2017-05-24 11:01:42', 1),
(9, 1, 'Narcotic count/MRT box', '', 'a:3:{s:11:"option_type";s:8:"checkbox";s:13:"no_of_options";i:1;s:7:"options";a:1:{i:0;s:4:"Done";}}', '2017-05-24 11:02:14', 1, '2017-05-24 11:02:14', 1),
(10, 1, 'Ensure all RN''s attend team Rounds', '', 'a:3:{s:11:"option_type";s:8:"checkbox";s:13:"no_of_options";i:1;s:7:"options";a:1:{i:0;s:4:"Done";}}', '2017-05-24 11:02:52', 1, '2017-05-24 11:02:52', 1),
(11, 2, 'Address your self as the charge nurse/Nurse leader, and perform rounds(document feedback in nurse leader rounds binder)', '', 'a:3:{s:11:"option_type";s:8:"checkbox";s:13:"no_of_options";i:1;s:7:"options";a:1:{i:0;s:4:"Done";}}', '2017-05-24 11:04:01', 1, '2017-05-24 11:06:22', 1),
(12, 1, 'Bed Huddle 1130', '', 'a:3:{s:11:"option_type";s:8:"checkbox";s:13:"no_of_options";i:1;s:7:"options";a:1:{i:0;s:4:"Done";}}', '2017-05-24 11:05:21', 1, '2017-05-24 11:05:21', 1),
(13, 2, 'Assess and address Patient/family concern or complaints (document in nurse leader rounds binder)', '', 'a:3:{s:11:"option_type";s:8:"checkbox";s:13:"no_of_options";i:1;s:7:"options";a:1:{i:0;s:4:"Done";}}', '2017-05-24 11:07:42', 1, '2017-05-24 11:09:00', 1),
(14, 2, 'IV tubing Dated', '', 'a:3:{s:11:"option_type";s:8:"checkbox";s:13:"no_of_options";i:1;s:7:"options";a:1:{i:0;s:4:"Done";}}', '2017-05-24 11:09:21', 1, '2017-05-24 11:09:21', 1),
(15, 2, 'CVL and PVL sites dated and with no signs of infection', '', 'a:3:{s:11:"option_type";s:8:"checkbox";s:13:"no_of_options";i:1;s:7:"options";a:1:{i:0;s:4:"Done";}}', '2017-05-24 11:10:09', 1, '2017-05-24 11:10:09', 1),
(16, 2, 'Oxygen tubing, humidifiers, Nebulizer dated', '', 'a:3:{s:11:"option_type";s:8:"checkbox";s:13:"no_of_options";i:1;s:7:"options";a:1:{i:0;s:4:"Done";}}', '2017-05-24 11:12:10', 1, '2017-05-24 11:12:10', 1),
(17, 2, 'open saline bottles and dated', '', 'a:3:{s:11:"option_type";s:8:"checkbox";s:13:"no_of_options";i:1;s:7:"options";a:1:{i:0;s:4:"Done";}}', '2017-05-24 11:12:56', 1, '2017-05-24 11:12:56', 1),
(18, 2, 'Patient bedside clean', '', 'a:3:{s:11:"option_type";s:8:"checkbox";s:13:"no_of_options";i:1;s:7:"options";a:1:{i:0;s:4:"Done";}}', '2017-05-24 11:13:32', 1, '2017-05-24 11:13:32', 1),
(19, 3, 'No meds/scissors/syringes on carts or at nursing station, medicaion cards locked, computers secured when not in use, medication fridge locked (remove key from lock)', '', 'a:3:{s:11:"option_type";s:8:"checkbox";s:13:"no_of_options";i:1;s:7:"options";a:1:{i:0;s:4:"Done";}}', '2017-05-24 11:24:52', 1, '2017-05-24 11:24:52', 1),
(20, 3, 'No loose ks in halls, hallway clear, and unobstucted', '', 'a:3:{s:11:"option_type";s:8:"checkbox";s:13:"no_of_options";i:1;s:7:"options";a:1:{i:0;s:4:"Done";}}', '2017-05-24 11:26:37', 1, '2017-05-24 11:26:37', 1),
(21, 4, 'Check for look-alike-sound alike names(need 100% compliance X 90 days)', '', 'a:3:{s:11:"option_type";s:8:"checkbox";s:13:"no_of_options";i:1;s:7:"options";a:1:{i:0;s:4:"Done";}}', '2017-05-24 11:29:09', 1, '2017-05-24 11:29:09', 1),
(22, 4, 'fall huddle 0800', '', 'a:3:{s:11:"option_type";s:8:"checkbox";s:13:"no_of_options";i:1;s:7:"options";a:1:{i:0;s:4:"Done";}}', '2017-05-24 11:29:36', 1, '2017-05-24 11:29:36', 1),
(23, 4, 'Limited English Proficiency(LEP) patients', '', 'a:3:{s:11:"option_type";s:5:"input";s:13:"no_of_options";s:1:"1";s:7:"options";a:0:{}}', '2017-05-24 11:31:17', 1, '2017-05-24 11:31:38', 1),
(24, 4, 'Patients on turning schedules', '', 'a:3:{s:11:"option_type";s:5:"input";s:13:"no_of_options";s:1:"1";s:7:"options";a:0:{}}', '2017-05-24 11:32:38', 1, '2017-05-24 11:33:33', 1),
(25, 4, 'Patients with significant pain', '', 'a:3:{s:11:"option_type";s:5:"input";s:13:"no_of_options";s:1:"1";s:7:"options";a:0:{}}', '2017-05-24 11:33:15', 1, '2017-05-24 11:33:15', 1),
(26, 4, 'fall Audits(wednesday and friday am PCTs)', '', 'a:3:{s:11:"option_type";s:8:"checkbox";s:13:"no_of_options";i:1;s:7:"options";a:1:{i:0;s:4:"Done";}}', '2017-05-24 11:35:11', 1, '2017-05-24 11:35:11', 1),
(27, 5, 'Update shift assignment shift', '', 'a:3:{s:11:"option_type";s:8:"checkbox";s:13:"no_of_options";i:1;s:7:"options";a:1:{i:0;s:4:"Done";}}', '2017-05-24 11:36:50', 1, '2017-05-24 11:36:50', 1),
(28, 5, 'Assign and document meal times for all staff', '', 'a:3:{s:11:"option_type";s:8:"checkbox";s:13:"no_of_options";i:1;s:7:"options";a:1:{i:0;s:4:"Done";}}', '2017-05-24 11:37:38', 1, '2017-05-24 11:37:38', 1),
(29, 5, 'Evening PCT  assignment/ and break assignments 1530', '', 'a:3:{s:11:"option_type";s:8:"checkbox";s:13:"no_of_options";i:1;s:7:"options";a:1:{i:0;s:4:"Done";}}', '2017-05-24 11:38:39', 1, '2017-05-24 11:38:39', 1),
(30, 5, 'Narcotic Count/MRT box/patient transport med box in omnicell', '', 'a:3:{s:11:"option_type";s:8:"checkbox";s:13:"no_of_options";i:1;s:7:"options";a:1:{i:0;s:4:"Done";}}', '2017-05-24 11:39:51', 1, '2017-05-24 11:39:51', 1),
(31, 5, 'Discharge/DBN rounds at 1430', '', 'a:3:{s:11:"option_type";s:8:"checkbox";s:13:"no_of_options";i:1;s:7:"options";a:1:{i:0;s:4:"Done";}}', '2017-05-24 11:42:50', 1, '2017-05-24 11:42:50', 1),
(32, 5, 'RN "numbers" & receive update on patient''s conditions', '', 'a:3:{s:11:"option_type";s:8:"checkbox";s:13:"no_of_options";i:1;s:7:"options";a:1:{i:0;s:4:"Done";}}', '2017-05-24 11:44:07', 1, '2017-05-24 11:44:07', 1),
(33, 5, 'RN and PCT assignments for next shift completed at 1730', '', 'a:3:{s:11:"option_type";s:8:"checkbox";s:13:"no_of_options";i:1;s:7:"options";a:1:{i:0;s:4:"Done";}}', '2017-05-24 11:45:44', 1, '2017-05-24 11:45:44', 1),
(34, 5, 'Plan for future shifts, ensure adequate staffing on 16east and BMT unit ', '', 'a:3:{s:11:"option_type";s:8:"checkbox";s:13:"no_of_options";i:1;s:7:"options";a:1:{i:0;s:4:"Done";}}', '2017-05-24 11:47:12', 1, '2017-05-24 11:47:12', 1),
(35, 5, 'Utilize downtime to assign staff to complete iDevelop learning modules', '', 'a:3:{s:11:"option_type";s:8:"checkbox";s:13:"no_of_options";i:1;s:7:"options";a:1:{i:0;s:4:"Done";}}', '2017-05-24 11:48:20', 1, '2017-05-24 11:48:20', 1),
(36, 5, 'Ensure that staff is able to attend council meetings of the unit', '', 'a:3:{s:11:"option_type";s:8:"checkbox";s:13:"no_of_options";i:1;s:7:"options";a:1:{i:0;s:4:"Done";}}', '2017-05-24 11:49:23', 1, '2017-05-24 11:49:23', 1),
(37, 5, 'check charge blackberry email for radiation oncology appointments for the next day; pending admission', '', 'a:3:{s:11:"option_type";s:8:"checkbox";s:13:"no_of_options";i:1;s:7:"options";a:1:{i:0;s:4:"Done";}}', '2017-05-24 11:51:58', 1, '2017-05-24 11:51:58', 1),
(38, 5, 'NASH/PCM updated with PUA', '', 'a:3:{s:11:"option_type";s:8:"checkbox";s:13:"no_of_options";i:1;s:7:"options";a:1:{i:0;s:4:"Done";}}', '2017-05-24 11:53:23', 1, '2017-05-24 11:53:23', 1),
(39, 5, 'Update schedule with sick calls, floats, emergency time off, OT,etc', '', 'a:3:{s:11:"option_type";s:8:"checkbox";s:13:"no_of_options";i:1;s:7:"options";a:1:{i:0;s:4:"Done";}}', '2017-05-24 11:54:29', 1, '2017-05-24 11:54:29', 1),
(40, 1, 'Obtain report from day charge nurse', '', 'a:3:{s:11:"option_type";s:8:"checkbox";s:13:"no_of_options";i:1;s:7:"options";a:1:{i:0;s:4:"Done";}}', '2017-05-24 11:59:49', 1, '2017-05-24 11:59:49', 1),
(41, 4, 'Fall Audits(Monday evening/night)', '', 'a:3:{s:11:"option_type";s:8:"checkbox";s:13:"no_of_options";i:1;s:7:"options";a:1:{i:0;s:4:"Done";}}', '2017-05-24 12:03:15', 1, '2017-05-24 12:03:15', 1),
(42, 4, 'Cauti Binder (Fri Nights)', '', 'a:3:{s:11:"option_type";s:8:"checkbox";s:13:"no_of_options";i:1;s:7:"options";a:1:{i:0;s:4:"Done";}}', '2017-05-24 12:04:46', 1, '2017-05-24 12:04:46', 1),
(43, 4, 'Skin binder (Mon, wed, Friday nights)- please do during your initial rounds!', '', 'a:3:{s:11:"option_type";s:8:"checkbox";s:13:"no_of_options";i:1;s:7:"options";a:1:{i:0;s:4:"Done";}}', '2017-05-24 12:06:11', 1, '2017-05-24 12:06:11', 1),
(44, 5, 'Night PCT assignment/ and break assignments 2330', '', 'a:3:{s:11:"option_type";s:8:"checkbox";s:13:"no_of_options";i:1;s:7:"options";a:1:{i:0;s:4:"Done";}}', '2017-05-24 12:07:34', 1, '2017-05-24 12:07:34', 1),
(45, 5, 'Assign PCT for Glucometer check at 0030. Must add comment "cleaned monitor"', '', 'a:3:{s:11:"option_type";s:8:"checkbox";s:13:"no_of_options";i:1;s:7:"options";a:1:{i:0;s:4:"Done";}}', '2017-05-24 12:10:07', 1, '2017-05-24 12:10:07', 1),
(46, 5, 'Glucose Strips dated', '', 'a:3:{s:11:"option_type";s:8:"checkbox";s:13:"no_of_options";i:1;s:7:"options";a:1:{i:0;s:4:"Done";}}', '2017-05-24 12:11:10', 1, '2017-05-24 12:11:10', 1),
(47, 5, 'Rounds with RNS', '', 'a:3:{s:11:"option_type";s:8:"checkbox";s:13:"no_of_options";i:1;s:7:"options";a:1:{i:0;s:4:"Done";}}', '2017-05-24 12:13:35', 1, '2017-05-24 12:13:35', 1),
(48, 5, 'RN and PCT assignments for next shift completed at 0500', '', 'a:3:{s:11:"option_type";s:8:"checkbox";s:13:"no_of_options";i:1;s:7:"options";a:1:{i:0;s:4:"Done";}}', '2017-05-24 12:15:07', 1, '2017-05-24 12:15:07', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `title` varchar(150) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `group_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `tmp_password` varchar(250) NOT NULL,
  `api_token` varchar(250) NOT NULL,
  `last_login` datetime NOT NULL,
  `profile_avatar` varchar(100) NOT NULL,
  `role_id` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '1 => Active 2=> Inactive',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `record_status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `last_name`, `title`, `email`, `phone`, `group_id`, `username`, `password`, `tmp_password`, `api_token`, `last_login`, `profile_avatar`, `role_id`, `status`, `created_at`, `updated_at`, `record_status`) VALUES
(1, 'Admin', '', '', 'v.phaneendrakumar@gmail.com', '9989789874', 0, 'admin', '2dbaa2bcba911b55e49a4313817c64fb', '', 'eyJpdiI6ImFqdjRvakxhTFlCbGttRnNyemlZOHc9PSIsInZhbHVlIjoiMDdlYWRvSmdvNndHSzdrbDVSUEt0MytkeTE2OXNuQ3JCMElpQ3J2MlBmdz0iLCJtYWMiOiI3OWI4ZjdkZjYzYTE0MTNhYzg0MGVjZGFmZjdhNTIzNGNlNjBjNDliYzVkNTYyNjY5NGI3ODlmMzc3YjAwNjMxIn0=', '2017-05-31 12:28:22', '', 1, 1, '2017-05-18 00:00:00', '2017-05-31 12:28:22', 1),
(2, 'Gopi', 'Maturu', 'SE', 'gmaturu@bimarian.com', '7416922457', 0, 'gmaturu', '2dbaa2bcba911b55e49a4313817c64fb', '', 'eyJpdiI6ImhwalU5ZnV1QU0yY1ZIYkdzXC9SejFBPT0iLCJ2YWx1ZSI6Ik5SK1N3d1ZDbStcL3l4anVsY2hhTEJmWFlCaW1QbkJuK2VVMjVqQ0JEK1wvND0iLCJtYWMiOiJhMDI1N2ZhODM3ZTBlYjY1MGQ2N2RkM2Y4MzAwYjZlOTUzNmVhNGU2MTNkZjc0N2EzNjNmNjA4NjhiZjY2ZGNmIn0=', '2017-05-31 12:10:33', '', 2, 1, '2017-05-31 10:24:31', '2017-05-31 12:10:33', 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
