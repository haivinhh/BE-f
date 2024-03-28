-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 28, 2024 at 08:48 AM
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
-- Database: `doanflutter1`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id_cart` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `status` varchar(255) NOT NULL,
  `order_date` date NOT NULL DEFAULT current_timestamp(),
  `tong_tien` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id_cart`, `id_user`, `status`, `order_date`, `tong_tien`) VALUES
(81, 1, 'Y', '2024-03-23', '360000'),
(82, 2, 'Y', '2024-03-23', '980000'),
(83, 3, 'N', '2024-03-23', '1320000'),
(84, 68, 'Y', '2024-03-23', '360000'),
(85, 75, 'Y', '2024-03-23', '1020000'),
(86, 1, 'Y', '2024-03-27', '180000');

-- --------------------------------------------------------

--
-- Table structure for table `cate`
--

CREATE TABLE `cate` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `cate`
--

INSERT INTO `cate` (`id`, `name`) VALUES
(1, 'Ốp chống sốc '),
(2, 'Drew collection'),
(8, 'VVVa'),
(11, 'ta');

-- --------------------------------------------------------

--
-- Table structure for table `detailcart`
--

CREATE TABLE `detailcart` (
  `id_dc` int(10) NOT NULL,
  `id_cart` int(11) NOT NULL,
  `id_product` int(11) NOT NULL,
  `soluong` int(11) NOT NULL,
  `tong_tien` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detailcart`
--

INSERT INTO `detailcart` (`id_dc`, `id_cart`, `id_product`, `soluong`, `tong_tien`) VALUES
(153, 81, 18, 2, '360000'),
(154, 82, 4, 3, '540000'),
(155, 82, 7, 1, '220000'),
(156, 82, 8, 1, '220000'),
(157, 83, 8, 2, '440000'),
(158, 83, 16, 4, '880000'),
(161, 84, 3, 1, '180000'),
(162, 84, 4, 1, '180000'),
(163, 85, 4, 2, '360000'),
(164, 85, 11, 3, '660000'),
(165, 86, 4, 1, '180000');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `price` varchar(20) NOT NULL,
  `content` text DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `cateId` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `name`, `price`, `content`, `image`, `cateId`, `quantity`) VALUES
(1, 'Ốp lưng iPhone chống sốc Gradient', '180000', 'Chất liệu: TPU cao cấp,Viền TPE chống sốc bao bọc toàn bộ bên trong, bảo vệ 360 độ, khả năng chống sốc lên đến 2m', 'https://product.hstatic.net/200000204373/product/op_phao_4f4c51ad718e43619746c5c44b5209c1_master.png', 1, 50),
(2, 'Ốp lưng iPhone chống sốc trong suốt', '180000', 'Chất liệu: TPU cao cấp,Viền TPE chống sốc bao bọc toàn bộ bên trong, bảo vệ 360 độ, khả năng chống sốc lên đến 2m', 'https://product.hstatic.net/200000204373/product/op_lung_iphone_chong_soc_m_case_iphone_trong_suot_do_mcase_01fd50a502784f7fbdad7253663dc1a3_grande.png', 1, 50),
(3, 'Ốp lưng iPhone chống sốc Đen', '180000', 'Chất liệu: TPU cao cấp,Viền TPE chống sốc bao bọc toàn bộ bên trong, bảo vệ 360 độ, khả năng chống sốc lên đến 2m', 'https://product.hstatic.net/200000204373/product/op_lung_iphone_chong_soc_trong_suot_den_mcase-01_34ec88229b2449cdb3f77c6c9a154c41_master.jpg', 1, 50),
(4, 'Ốp lưng iPhone chống sốc Xanh lá', '180000', 'Chất liệu: TPU cao cấp,Viền TPE chống sốc bao bọc toàn bộ bên trong, bảo vệ 360 độ, khả năng chống sốc lên đến 2m', 'https://product.hstatic.net/200000204373/product/op_lung_iphone_chong_soc_trong_suot_xanh_la_mcase-01_f942a20442b248468e316fea4ac4ef5a_master.jpg', 1, 50),
(5, 'Ốp lưng iPhone Drew Mascot Light Pink', '220000', 'Chất liệu: TPU cao cấp,Viền TPE chống sốc bao bọc toàn bộ bên trong, bảo vệ 360 độ, khả năng chống sốc lên đến 2m', 'https://product.hstatic.net/200000204373/product/op_lung_iphone_chong_soc_drew_mascot_hong_nhat-01-01-01_3530afb7e67a4dcab551264510622665_master.jpg', 2, 50),
(6, 'Ốp lưng iPhone Drew Mascot Blue', '220000', 'Chất liệu: TPU cao cấp,Viền TPE chống sốc bao bọc toàn bộ bên trong, bảo vệ 360 độ, khả năng chống sốc lên đến 2m', 'https://product.hstatic.net/200000204373/product/op_lung_iphone_chong_soc_drew_mascot_xanh_coban-01-01-01_dbb99d7742c9410a81f0ff6638101276_master.jpg', 2, 50),
(7, 'Ốp lưng iPhone Drew Mascot Red', '220000', 'Chất liệu: TPU cao cấp,Viền TPE chống sốc bao bọc toàn bộ bên trong, bảo vệ 360 độ, khả năng chống sốc lên đến 2m', 'https://product.hstatic.net/200000204373/product/op_lung_iphone_chong_soc_drew_mascot_do-01-01-01-01_63ce8b215fa74179952b77c197624377_master.jpg', 2, 50),
(8, 'Ốp lưng iPhone Drew Phi Hành Gia', '220000', 'Chất liệu: TPU cao cấp,Viền TPE chống sốc bao bọc toàn bộ bên trong, bảo vệ 360 độ, khả năng chống sốc lên đến 2m', 'https://product.hstatic.net/200000204373/product/op_lung_iphone_chong_soc_drew_phi_hanh_gia_mcase-01_0aacb30ec5f9469da862be59e485b9d1_master.png', 2, 50),
(9, 'Ốp lưng iPhone Drew Shark', '220000', 'Chất liệu: TPU cao cấp,Viền TPE chống sốc bao bọc toàn bộ bên trong, bảo vệ 360 độ, khả năng chống sốc lên đến 2m', 'https://product.hstatic.net/200000204373/product/op_iphone_chong_soc_bunny_stickers_den_390b9d33527846429acb037b33bccc76_grande.png', 2, 50),
(10, 'Ốp lưng iPhone Drew Skull', '220000', 'Chất liệu: TPU cao cấp,Viền TPE chống sốc bao bọc toàn bộ bên trong, bảo vệ 360 độ, khả năng chống sốc lên đến 2m', 'https://product.hstatic.net/200000204373/product/op_iphone_chong_soc_bunny_stickers_den_390b9d33527846429acb037b33bccc76_grande.png', 2, 50),
(11, 'Ốp lưng iPhone Drew Stickers 1.0', '220000', 'Chất liệu: TPU cao cấp,Viền TPE chống sốc bao bọc toàn bộ bên trong, bảo vệ 360 độ, khả năng chống sốc lên đến 2m', 'https://product.hstatic.net/200000204373/product/op_iphone_chong_soc_mcase_bunny_lai_ca_rot_den_22668e9a2de44c6395a95725231b1311_grande.png', 2, 50),
(12, 'Ốp lưng iPhone Drew Teddy 2.0 ', '220000', 'Chất liệu: TPU cao cấp,Viền TPE chống sốc bao bọc toàn bộ bên trong, bảo vệ 360 độ, khả năng chống sốc lên đến 2m', 'https://product.hstatic.net/200000204373/product/op_iphone_chong_soc_mcase_bunny_lai_ca_rot_den_22668e9a2de44c6395a95725231b1311_grande.png', 2, 50),
(13, 'Ốp lưng iPhone Drew Dino Bowl Vàng ', '220000', 'Chất liệu: TPU cao cấp,Viền TPE chống sốc bao bọc toàn bộ bên trong, bảo vệ 360 độ, khả năng chống sốc lên đến 2m', 'https://product.hstatic.net/200000204373/product/op_lung_iphone_13_pro_max_chong_soc_drew_dino_bowl_mcase_a09a78efc9ea41769fe4076dea4555d8_master.png', 2, 50),
(14, 'Ốp lưng iPhone Drew Dino Bowl trong suốt ', '220000', 'Chất liệu: TPU cao cấp,Viền TPE chống sốc bao bọc toàn bộ bên trong, bảo vệ 360 độ, khả năng chống sốc lên đến 2m', 'https://product.hstatic.net/200000204373/product/op_iphone_chong_soc_mcase_bunny_bup_be_hong_den_b979e18c61cf4acc88f81d39499e0964_grande.png', 2, 50),
(15, 'Ốp lưng iPhone Drew Dino ', '220000', 'Chất liệu: TPU cao cấp,Viền TPE chống sốc bao bọc toàn bộ bên trong, bảo vệ 360 độ, khả năng chống sốc lên đến 2m', 'https://product.hstatic.net/200000204373/product/op_lung_iphone_chong_soc_mcase_woof_corgi_trong_suot_den_efdd6a4c80594327b68f3238eda21075_grande.png', 2, 50),
(16, 'Ốp lưng iPhone Drew Friends 1.0', '220000', 'Chất liệu: TPU cao cấp,Viền TPE chống sốc bao bọc toàn bộ bên trong, bảo vệ 360 độ, khả năng chống sốc lên đến 2m', 'https://product.hstatic.net/200000204373/product/op_iphone_chong_soc_mcase_bunny_cai_toc_den_4a0f1ffdf0f74ffcbd2533d4c84da998_grande.png', 2, 50),
(17, 'Ốp lưng iPhone chống sốc Đỏ ', '180000', 'Chất liệu: TPU cao cấp,Viền TPE chống sốc bao bọc toàn bộ bên trong, bảo vệ 360 độ, khả năng chống sốc lên đến 2m', 'https://product.hstatic.net/200000204373/product/op_lung_iphone_chong_soc_mcase_shiba_ramen_trong_suot_den_fe33ef38d5e14a7e87aace4fbc79a0cf_grande.png', 1, 50),
(18, 'Ốp lưng iPhone chống sốc Vàng', '180000', 'Chất liệu: TPU cao cấp,Viền TPE chống sốc bao bọc toàn bộ bên trong, bảo vệ 360 độ, khả năng chống sốc lên đến 2m', 'https://product.hstatic.net/200000204373/product/op_lung_iphone_chong_soc_mcase_shiba_ramen_trong_suot_den_fe33ef38d5e14a7e87aace4fbc79a0cf_grande.png', 1, 50),
(78, 'dsavzzzz', '2312', 'das', 'dsa', 8, 23),
(85, 'd', '123444', 'caaaq', '2aasd', 11, 41);

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `role_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id`, `role_name`) VALUES
(1, 'admin'),
(2, 'user'),
(3, 'customer');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int(4) NOT NULL,
  `username` varchar(10) NOT NULL,
  `password` varchar(10) NOT NULL,
  `role_id` int(11) NOT NULL,
  `phone` int(12) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `full_name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `username`, `password`, `role_id`, `phone`, `address`, `full_name`) VALUES
(1, 'a', '123', 1, 213, 'asd', 'asdsad'),
(2, 'd', '123', 2, 12321, 'asdsa', 'ddd'),
(3, 'c', '123', 3, 12321, 'asdsad', 'asdasd'),
(55, 'cxaaaddf', '12', 2, 12321, 'das', 'ddaaaaa'),
(63, 'ds', 'ads', 1, 123, 'fdsf', 'fsdf'),
(65, 'Hay', '123', 1, 2321, 'asdsa', 'sada'),
(66, 'haivinh', '123', 3, 565, 'gngh', 'ttt'),
(68, 'vip', '123', 3, 123, 'das', 'fd'),
(75, 'w', '123', 3, 3213, 'asd', 'dsa'),
(83, 'nguyenvana', '$2y$10$.V0', 3, 987654321, '123 Street, City', 'Nguyen Van A'),
(87, 'testuserrr', '$2y$10$Qaj', 3, 123456789, '123 Street, City', 'Test User');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id_cart`),
  ADD KEY `cart_ibfk_1` (`id_user`);

--
-- Indexes for table `cate`
--
ALTER TABLE `cate`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `detailcart`
--
ALTER TABLE `detailcart`
  ADD PRIMARY KEY (`id_dc`),
  ADD KEY `detailcart_ibfk_1` (`id_cart`),
  ADD KEY `detailcart_ibfk_2` (`id_product`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD KEY `cateId` (`cateId`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD KEY `role_id` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id_cart` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT for table `cate`
--
ALTER TABLE `cate`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `detailcart`
--
ALTER TABLE `detailcart`
  MODIFY `id_dc` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=166;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`);

--
-- Constraints for table `detailcart`
--
ALTER TABLE `detailcart`
  ADD CONSTRAINT `detailcart_ibfk_1` FOREIGN KEY (`id_cart`) REFERENCES `cart` (`id_cart`),
  ADD CONSTRAINT `detailcart_ibfk_2` FOREIGN KEY (`id_product`) REFERENCES `product` (`id`);

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`cateId`) REFERENCES `cate` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`),
  ADD CONSTRAINT `users_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
