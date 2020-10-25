-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 16, 2019 at 06:27 PM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.3.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `eqborrow`
--

-- --------------------------------------------------------

--
-- Table structure for table `eb_borrow`
--

CREATE TABLE `eb_borrow` (
  `id` bigint(20) NOT NULL,
  `borrow_date` date DEFAULT NULL,
  `schedule_date` date DEFAULT NULL,
  `return_date` date DEFAULT NULL,
  `return_status` tinyint(1) DEFAULT NULL,
  `member_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `modified_at` datetime DEFAULT NULL,
  `created_on` int(11) DEFAULT NULL,
  `modified_on` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `eb_borrow`
--

INSERT INTO `eb_borrow` (`id`, `borrow_date`, `schedule_date`, `return_date`, `return_status`, `member_id`, `created_at`, `modified_at`, `created_on`, `modified_on`) VALUES
(1, '2018-04-21', '2018-04-26', NULL, 0, 3, '2018-04-21 00:18:54', NULL, 1, NULL),
(2, '2018-04-21', '2018-04-21', NULL, 0, 5, '2018-04-21 00:19:18', NULL, 1, NULL),
(3, '2018-04-21', '2018-04-25', NULL, 0, 1, '2018-04-21 00:20:18', NULL, 1, NULL),
(6, '2018-04-21', '2018-04-28', NULL, 0, 4, '2018-04-21 00:20:59', NULL, 1, NULL),
(7, '2018-04-21', '2018-04-25', '2018-04-28', 1, 5, '2018-04-21 00:21:33', '2018-04-21 11:13:29', 1, 1),
(8, '2018-04-21', '2018-04-28', NULL, 0, 6, '2018-04-21 00:22:22', NULL, 1, NULL),
(9, '2018-04-21', '2018-04-24', NULL, 0, 4, '2018-04-21 12:20:15', NULL, 5, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `eb_borrow_detail`
--

CREATE TABLE `eb_borrow_detail` (
  `id` int(11) NOT NULL,
  `return_status` tinyint(1) DEFAULT NULL,
  `borrow_quantity` decimal(10,2) DEFAULT NULL,
  `return_quantity` decimal(10,2) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `find` decimal(10,2) DEFAULT NULL,
  `issue` enum('normal','lost','defect') DEFAULT NULL,
  `return_date` date DEFAULT NULL,
  `borrow_id` bigint(20) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `serial_number_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `eb_borrow_detail`
--

INSERT INTO `eb_borrow_detail` (`id`, `return_status`, `borrow_quantity`, `return_quantity`, `price`, `find`, `issue`, `return_date`, `borrow_id`, `product_id`, `serial_number_id`) VALUES
(1, 0, '1.00', '0.00', '23000.00', NULL, NULL, NULL, 1, 5, 1),
(1, 0, '1.00', '0.00', '23000.00', NULL, NULL, NULL, 2, 5, 2),
(1, 0, '1.00', '0.00', '3000.00', NULL, NULL, NULL, 3, 8, 10),
(1, 0, '1.00', '0.00', '35000.00', NULL, NULL, NULL, 6, 9, 12),
(1, 1, '1.00', '1.00', '3000.00', NULL, NULL, NULL, 7, 6, 7),
(1, 0, '2.00', '0.00', '15.00', NULL, NULL, NULL, 8, 4, NULL),
(1, 0, '2.00', '0.00', '20000.00', NULL, NULL, NULL, 9, 7, NULL),
(2, 0, '1.00', '0.00', '3000.00', NULL, NULL, NULL, 2, 8, 11),
(2, 0, '1.00', '0.00', '3000.00', NULL, NULL, NULL, 6, 8, 11),
(2, 1, '3.00', '3.00', '5.00', NULL, NULL, NULL, 7, 3, NULL),
(2, 0, '3.00', '0.00', '5.00', NULL, NULL, NULL, 8, 3, NULL),
(3, 0, '3.00', '0.00', '19.00', NULL, NULL, NULL, 8, 2, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `eb_category`
--

CREATE TABLE `eb_category` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `eb_category`
--

INSERT INTO `eb_category` (`id`, `name`, `is_active`) VALUES
(15, 'อุปกรณ์สำนักงาน', 1),
(16, 'อิเล็กทรอนิค', 1),
(17, 'เบ็ดเตล็ด', 1),
(19, 'อาหารและเครื่องดื่ม', 1),
(20, 'เครื่องใช้ไฟฟ้า', 1),
(21, 'เครื่องใช้ในบ้าน', 1);

-- --------------------------------------------------------

--
-- Table structure for table `eb_department`
--

CREATE TABLE `eb_department` (
  `id` int(11) NOT NULL,
  `code` varchar(100) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `eb_department`
--

INSERT INTO `eb_department` (`id`, `code`, `name`, `is_active`) VALUES
(1, NULL, 'บัญชี', 1),
(2, NULL, 'เทคโนโลยีสารสนเทศ', 1),
(3, NULL, 'คลังสินค้า', 1);

-- --------------------------------------------------------

--
-- Table structure for table `eb_member`
--

CREATE TABLE `eb_member` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `code` varchar(100) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `tel` varchar(20) DEFAULT NULL,
  `address` text,
  `image_name` varchar(100) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `membertype_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `modified_at` datetime DEFAULT NULL,
  `created_on` int(11) DEFAULT NULL,
  `modified_on` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `eb_member`
--

INSERT INTO `eb_member` (`id`, `name`, `code`, `username`, `password`, `email`, `tel`, `address`, `image_name`, `is_active`, `department_id`, `membertype_id`, `created_at`, `modified_at`, `created_on`, `modified_on`) VALUES
(1, 'ทรงธรรม มหาดี', '2904240724', NULL, NULL, 'member01@mail.com', '095781541', 'testt\ndffddfdfdfddfd\ndf3343', NULL, 1, 2, 5, '2018-03-29 23:12:59', '2018-04-21 00:14:57', NULL, 1),
(3, 'สมชาย ไทยดี', '569789467', NULL, NULL, 'member02@mail.com', '08149159714', NULL, NULL, 1, 2, 4, '2018-03-30 00:44:04', '2018-04-21 00:15:22', NULL, 1),
(4, 'สกุลภัก มหาลา', '588514561', NULL, NULL, 'member03@mail.com', '0821645614', 'test', NULL, 1, 1, 4, '2018-03-31 20:26:08', '2018-04-21 00:15:50', 1, 1),
(5, 'สมปอง มหาดี', '01544542101', NULL, NULL, 'sompong@mail.com', '0811447887', NULL, NULL, 1, 3, 5, '2018-04-21 00:18:00', NULL, 1, NULL),
(6, 'สมหญิง แท้ไทย', '0932840234', NULL, NULL, 'somying@mail.com', '0384023488', NULL, NULL, 1, 1, 3, '2018-04-21 00:18:25', NULL, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `eb_membertype`
--

CREATE TABLE `eb_membertype` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `eb_membertype`
--

INSERT INTO `eb_membertype` (`id`, `name`, `is_active`) VALUES
(3, 'นักเรียน', 1),
(4, 'อาจารย์', 1),
(5, 'ผู้ใช้ทั่วไป', 1);

-- --------------------------------------------------------

--
-- Table structure for table `eb_product`
--

CREATE TABLE `eb_product` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `code` varchar(100) DEFAULT NULL,
  `model` varchar(100) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `fine` decimal(10,2) DEFAULT NULL,
  `detail` text,
  `profile_picture` varchar(100) DEFAULT NULL,
  `quantity` decimal(10,2) DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `is_serial_number` tinyint(1) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `unit_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `modified_at` datetime DEFAULT NULL,
  `created_on` int(11) DEFAULT NULL,
  `modified_on` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `eb_product`
--

INSERT INTO `eb_product` (`id`, `name`, `code`, `model`, `price`, `fine`, `detail`, `profile_picture`, `quantity`, `remark`, `is_serial_number`, `is_active`, `unit_id`, `category_id`, `created_at`, `modified_at`, `created_on`, `modified_on`) VALUES
(1, 'ข้าวสารคุณภาพดี', 'SK00123456', 'A901', '260.00', '20.00', NULL, NULL, '30.00', NULL, 0, 1, 2, 17, '2018-04-19 21:21:54', '2018-04-20 23:58:48', 1, 1),
(2, 'ปากกาด้านดี', 'SK0032990', 'SK', '19.00', '0.00', NULL, NULL, '87.00', NULL, 0, 1, 40, 15, '2018-04-20 23:56:08', '2018-04-20 23:56:53', 1, 1),
(3, 'ดินสอเขียนงาม', 'SK0392480', 'SK01', '5.00', '0.00', NULL, NULL, '97.00', NULL, 0, 1, 40, 15, '2018-04-20 23:56:44', NULL, 1, NULL),
(4, 'ยางลบคุณภาพดี', 'SK02349008', 'SK01', '15.00', '0.00', NULL, NULL, '58.00', NULL, 0, 1, 70, 15, '2018-04-20 23:59:28', NULL, 1, NULL),
(5, 'คอมพิวเตอร์ Acer', 'AC032948234', 'AC', '23000.00', '10000.00', NULL, 'pro_5d2df9487f558.JPG', '0.00', NULL, 1, 1, 34, 16, '2018-04-21 00:01:15', '2019-07-16 18:20:27', 1, 1),
(6, 'เครื่องคิดเลขอย่างดี', 'AC0924709', 'AC0293', '3000.00', '1000.00', NULL, NULL, '0.00', NULL, 1, 1, 34, 16, '2018-04-21 00:02:12', NULL, 1, NULL),
(7, 'เครื่องซักผ้า LG01', 'LG02432420', 'LG01', '20000.00', '2000.00', NULL, NULL, '14.00', NULL, 0, 1, 12, 20, '2018-04-21 00:04:59', NULL, 1, NULL),
(8, 'หูฟังไร้สายรุ่น 1', 'AE30424027', 'Aer430', '3000.00', '1500.00', NULL, NULL, '0.00', NULL, 1, 1, 12, 15, '2018-04-21 00:06:08', NULL, 1, NULL),
(9, 'iPhone 8 Plus', 'I023470', 'IP8', '35000.00', '0.00', NULL, NULL, '0.00', NULL, 1, 1, 34, 16, '2018-04-21 00:08:05', NULL, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `eb_serial_number`
--

CREATE TABLE `eb_serial_number` (
  `id` int(11) NOT NULL,
  `code` varchar(100) DEFAULT NULL,
  `quantity` decimal(10,2) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `eb_serial_number`
--

INSERT INTO `eb_serial_number` (`id`, `code`, `quantity`, `is_active`, `product_id`) VALUES
(1, 'AC001', '0.00', 1, 5),
(2, 'AC002', '0.00', 1, 5),
(3, 'AC003', '1.00', 1, 5),
(4, 'AC004', '1.00', 1, 5),
(5, 'AC005', '1.00', 1, 5),
(6, 'B320474', '5.00', 1, 6),
(7, 'B02923487', '5.00', 1, 6),
(8, 'B2048234', '5.00', 1, 6),
(9, 'B2492324', '5.00', 1, 6),
(10, 'SLSOI08342-23489327', '2.00', 1, 8),
(11, 'SLDFKU-2-47-000', '0.00', 1, 8),
(12, 'AB2304511', '0.00', 1, 9),
(13, 'DE5646156156', '1.00', 1, 9),
(14, 'JD213516064', '1.00', 1, 9),
(15, 'ES32346543', '1.00', 1, 9),
(16, 'SW213546415646', '1.00', 1, 9);

-- --------------------------------------------------------

--
-- Table structure for table `eb_unit`
--

CREATE TABLE `eb_unit` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `eb_unit`
--

INSERT INTO `eb_unit` (`id`, `name`, `is_active`) VALUES
(1, 'นิ้ว', 1),
(2, 'ถุง', 1),
(3, 'เล่ม', 1),
(4, 'ขวด', 1),
(5, 'กระป๋อง', 1),
(6, 'กล่อง', 1),
(7, 'คาร์ตัน', 1),
(8, 'ถ้วย', 1),
(9, 'หีบ', 1),
(10, 'ถัง', 1),
(11, 'โหล', 1),
(12, 'ชิ้น', 1),
(13, 'แฟ้ม', 1),
(14, 'ออนซ์หน่วยวัดของเหลว US', 1),
(15, 'ฟุต', 1),
(16, 'ตารางฟุต', 1),
(17, 'กรัม', 1),
(18, 'ออนซ์', 1),
(19, 'คู่', 1),
(20, 'แพค/ห่อ', 1),
(21, 'งวด', 1),
(22, 'รีม', 1),
(23, 'Roll', 1),
(24, 'ผืน', 1),
(25, 'แผ่น', 1),
(26, 'ชุด', 1),
(27, 'ท่อน', 1),
(28, 'ตัน', 1),
(29, 'กิโลกรัม', 1),
(30, 'ลิตร', 1),
(31, 'เมตร', 1),
(32, 'โมลต่อลิตร', 1),
(33, 'ตารางเมตร', 1),
(34, 'เครื่อง', 1),
(35, 'มัด', 1),
(36, 'มิลลิกรัม', 1),
(37, 'มิลลิลิตร', 1),
(38, 'มิลลิเมตร', 1),
(39, 'ท่อ', 1),
(40, 'แท่ง', 1),
(41, 'ขด', 1),
(42, 'โคม', 1),
(43, 'คิว', 1),
(44, 'ปี๊บ', 1),
(45, 'ซอง', 1),
(46, 'ดวง', 1),
(47, 'ดอก', 1),
(48, 'แผง', 1),
(49, 'ตลับ', 1),
(50, 'เที่ยว', 1),
(51, 'ตัว', 1),
(52, 'นัด', 1),
(53, 'แท่น', 1),
(54, 'บาน', 1),
(55, 'ใบ', 1),
(56, 'ภาพ/รูป', 1),
(57, 'เรือน', 1),
(58, 'ล้อ', 1),
(59, 'ลัง', 1),
(60, 'วง', 1),
(61, 'เส้น', 1),
(62, 'ลูก', 1),
(63, 'หลอด', 1),
(64, 'หลัง', 1),
(65, 'เม็ด', 1),
(66, 'กรง', 1),
(67, 'กรอบ', 1),
(68, 'กระถาง', 1),
(69, 'กระบอก', 1),
(70, 'ก้อน', 1),
(71, 'หน่วย', 1),
(72, 'วัสดุที่คิดมูลค่าเท่านั้น', 1);

-- --------------------------------------------------------

--
-- Table structure for table `eb_user`
--

CREATE TABLE `eb_user` (
  `id` int(11) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `fullname` varchar(100) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `usertype` enum('ADMIN','USER') DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `key` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `eb_user`
--

INSERT INTO `eb_user` (`id`, `username`, `password`, `fullname`, `is_active`, `usertype`, `last_login`, `key`) VALUES
(1, 'admin@eqborrow', '16b163a3d42abbe8aa8bb37875d328f351c8a2af', 'ธวัชศักดิ์ แตงเอี่ยม', 1, 'ADMIN', '2019-07-16 18:01:49', '8a7e8a03d47d94bc7293f36cb64af1100fc3a0bb'),
(4, 'tester001', '16b163a3d42abbe8aa8bb37875d328f351c8a2af', 'วิชุดา แพรัง', 1, 'USER', '2018-03-31 20:18:57', 'e7c3323509731afa5de6377f906ed3cf9b388c2b'),
(5, 'tester002', '16b163a3d42abbe8aa8bb37875d328f351c8a2af', 'สมศักดิ์ แจงพัก', 1, 'USER', '2018-04-21 14:58:55', 'b8a731a9db2aab5425e2c63f77e285af56ddf491');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `eb_borrow`
--
ALTER TABLE `eb_borrow`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `eb_borrow_detail`
--
ALTER TABLE `eb_borrow_detail`
  ADD PRIMARY KEY (`id`,`borrow_id`) USING BTREE;

--
-- Indexes for table `eb_category`
--
ALTER TABLE `eb_category`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `eb_department`
--
ALTER TABLE `eb_department`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `eb_member`
--
ALTER TABLE `eb_member`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `eb_membertype`
--
ALTER TABLE `eb_membertype`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `eb_product`
--
ALTER TABLE `eb_product`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `eb_serial_number`
--
ALTER TABLE `eb_serial_number`
  ADD PRIMARY KEY (`id`,`product_id`) USING BTREE;

--
-- Indexes for table `eb_unit`
--
ALTER TABLE `eb_unit`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `eb_user`
--
ALTER TABLE `eb_user`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `eb_borrow`
--
ALTER TABLE `eb_borrow`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `eb_category`
--
ALTER TABLE `eb_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `eb_department`
--
ALTER TABLE `eb_department`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `eb_member`
--
ALTER TABLE `eb_member`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `eb_membertype`
--
ALTER TABLE `eb_membertype`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `eb_product`
--
ALTER TABLE `eb_product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `eb_serial_number`
--
ALTER TABLE `eb_serial_number`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `eb_unit`
--
ALTER TABLE `eb_unit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `eb_user`
--
ALTER TABLE `eb_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
