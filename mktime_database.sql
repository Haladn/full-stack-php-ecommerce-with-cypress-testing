-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 11, 2024 at 05:25 AM
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
-- Database: `mktime`
--

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

CREATE TABLE `address` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `country` varchar(50) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `street` varchar(100) NOT NULL,
  `city` varchar(50) NOT NULL,
  `postcode` varchar(20) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `default_address` tinyint(1) DEFAULT 0,
  `formatted_address` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `address`
--

INSERT INTO `address` (`id`, `customer_id`, `first_name`, `last_name`, `country`, `phone`, `street`, `city`, `postcode`, `created_at`, `default_address`, `formatted_address`) VALUES
(33, 22, 'rio', 'jack', 'scotland', '743372819280', 'sipson road', 'london', 'ub7 0ju', '2024-06-10 20:07:41', 1, 'sipson road,London,UB7 0JU');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `customer_id`, `created_at`) VALUES
(11, 22, '2024-06-10 21:00:51');

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

CREATE TABLE `cart_items` (
  `id` int(11) NOT NULL,
  `cart_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL CHECK (`quantity` > 0),
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `customer_id` int(11) NOT NULL,
  `title` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `username` varchar(25) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(400) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `username`, `first_name`, `last_name`, `email`, `password`, `created_at`) VALUES
(1, 'rio', '', '', 'rio@gmail.com', 'rio1234', '2024-06-04 12:33:05'),
(2, 'me', '', '', 'me@gmail.com', 'me1234', '2024-06-05 10:00:45'),
(9, 'you', '', '', 'you@gmail.com', 'you1234', '2024-06-05 15:36:47'),
(21, 'jack', '', '', 'jack@gmail.com', 'jack1234', '2024-06-08 01:52:41'),
(22, 'dastan', '', '', 'dastan@gmail.com', 'dastan1234', '2024-06-09 23:22:38');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `total_quantity` int(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'Pending',
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `customer_id`, `total_quantity`, `total_price`, `status`, `created_at`) VALUES
(27, 22, 3, 94.28, 'Pending', '2024-06-11 02:22:19'),
(28, 22, 3, 94.28, 'Pending', '2024-06-11 02:22:48'),
(29, 22, 3, 94.28, 'Pending', '2024-06-11 02:23:52'),
(37, 22, 4, 244.23, 'Pending', '2024-06-11 03:47:12');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `total_quantity` int(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `customer_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `total_quantity`, `total_price`, `created_at`, `customer_id`) VALUES
(34, 37, 3, 2, 111.98, '2024-06-11 03:47:12', 22),
(35, 37, 2, 1, 22.30, '2024-06-11 03:47:12', 22),
(37, 37, 1, 1, 109.95, '2024-06-11 03:47:12', 22),
(38, 37, 1, 1, 109.95, '2024-06-11 03:47:12', 22);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `title` varchar(150) NOT NULL,
  `description` varchar(400) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(250) NOT NULL,
  `category` varchar(50) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `title`, `description`, `price`, `image`, `category`, `quantity`) VALUES
(1, 'Fjallraven - Foldsack No. 1 Backpack, Fits 15 Laptops', 'Your perfect pack for everyday use and walks in the forest. Stash your laptop (up to 15 inches) in the padded sleeve, your everyday', 109.95, 'https://fakestoreapi.com/img/81fPKd-2AYL._AC_SL1500_.jpg', 'men\'s clothing', 21),
(2, 'Mens Casual Premium Slim Fit T-Shirts ', 'Slim-fitting style, contrast raglan long sleeve, three-button henley placket, light weight & soft fabric for breathable and comfortable wearing. And Solid stitched shirts with round neck made for durability and a great fit for casual fashion wear and diehard baseball fans. The Henley style round neckline includes a three-button placket.', 22.30, 'https://fakestoreapi.com/img/71-3HjGNDUL._AC_SY879._SX._UX._SY._UY_.jpg', 'men\'s clothing', 21),
(3, 'Mens Cotton Jacket', 'great outerwear jackets for Spring/Autumn/Winter, suitable for many occasions, such as working, hiking, camping, mountain/rock climbing, cycling, traveling or other outdoors. Good gift choice for you or your family member. A warm hearted love to Father, husband or son in this thanksgiving or Christmas Day.', 55.99, 'https://fakestoreapi.com/img/71li-ujtlUL._AC_UX679_.jpg', 'men\'s clothing', 20),
(4, 'Mens Casual Slim Fit', 'The color could be slightly different between on the screen and in practice. / Please note that body builds vary by person, therefore, detailed size information should be reviewed below on the product description.', 15.99, 'https://fakestoreapi.com/img/71YXzeOuslL._AC_UY879_.jpg', 'men\'s clothing', 22),
(5, 'John Hardy Women\'s Legends Naga Gold & Silver Dragon Station Chain Bracelet', 'From our Legends Collection, the Naga was inspired by the mythical water dragon that protects the ocean\'s pearl. Wear facing inward to be bestowed with love and abundance, or outward for protection.', 695.00, 'https://fakestoreapi.com/img/71pWzhdJNwL._AC_UL640_QL65_ML3_.jpg', 'jewelery', 22),
(6, 'Solid Gold Petite Micropave ', 'Satisfaction Guaranteed. Return or exchange any order within 30 days.Designed and sold by Hafeez Center in the United States. Satisfaction Guaranteed. Return or exchange any order within 30 days.', 168.00, 'https://fakestoreapi.com/img/61sbMiUnoGL._AC_UL640_QL65_ML3_.jpg', 'jewelery', 22),
(7, 'White Gold Plated Princess', 'Classic Created Wedding Engagement Solitaire Diamond Promise Ring for Her. Gifts to spoil your love more for Engagement, Wedding, Anniversary, Valentine\'s Day...', 9.99, 'https://fakestoreapi.com/img/71YAIFU48IL._AC_UL640_QL65_ML3_.jpg', 'jewelery', 22),
(8, 'Pierced Owl Rose Gold Plated Stainless Steel Double', 'Rose Gold Plated Double Flared Tunnel Plug Earrings. Made of 316L Stainless Steel', 10.99, 'https://fakestoreapi.com/img/51UDEzMJVpL._AC_UL640_QL65_ML3_.jpg', 'jewelery', 22),
(9, 'WD 2TB Elements Portable External Hard Drive - USB 3.0 ', 'USB 3.0 and USB 2.0 Compatibility Fast data transfers Improve PC Performance High Capacity; Compatibility Formatted NTFS for Windows 10, Windows 8.1, Windows 7; Reformatting may be required for other operating systems; Compatibility may vary depending on user’s hardware configuration and operating system', 64.00, 'https://fakestoreapi.com/img/61IBBVJvSDL._AC_SY879_.jpg', 'electronics', 22),
(10, 'SanDisk SSD PLUS 1TB Internal SSD - SATA III 6 Gb/s', 'Easy upgrade for faster boot up, shutdown, application load and response (As compared to 5400 RPM SATA 2.5” hard drive; Based on published specifications and internal benchmarking tests using PCMark vantage scores) Boosts burst write performance, making it ideal for typical PC workloads The perfect balance of performance and reliability Read/write speeds of up to 535MB/s/450MB/s (Based on internal', 109.00, 'https://fakestoreapi.com/img/61U7T1koQqL._AC_SX679_.jpg', 'electronics', 22),
(11, 'Silicon Power 256GB SSD 3D NAND A55 SLC Cache Performance Boost SATA III 2.5', '3D NAND flash are applied to deliver high transfer speeds Remarkable transfer speeds that enable faster bootup and improved overall system performance. The advanced SLC Cache Technology allows performance boost and longer lifespan 7mm slim design suitable for Ultrabooks and Ultra-slim notebooks. Supports TRIM command, Garbage Collection technology, RAID, and ECC (Error Checking & Correction) to pr', 109.00, 'https://fakestoreapi.com/img/71kWymZ+c+L._AC_SX679_.jpg', 'electronics', 22),
(12, 'WD 4TB Gaming Drive Works with Playstation 4 Portable External Hard Drive', 'Expand your PS4 gaming experience, Play anywhere Fast and easy, setup Sleek design with high capacity, 3-year manufacturer\'s limited warranty', 114.00, 'https://fakestoreapi.com/img/61mtL65D4cL._AC_SX679_.jpg', 'electronics', 22),
(13, 'Acer SB220Q bi 21.5 inches Full HD (1920 x 1080) IPS Ultra-Thin', '21. 5 inches Full HD (1920 x 1080) widescreen IPS display And Radeon free Sync technology. No compatibility for VESA Mount Refresh Rate: 75Hz - Using HDMI port Zero-frame design | ultra-thin | 4ms response time | IPS panel Aspect ratio - 16: 9. Color Supported - 16. 7 million colors. Brightness - 250 nit Tilt angle -5 degree to 15 degree. Horizontal viewing angle-178 degree. Vertical viewing angle', 599.00, 'https://fakestoreapi.com/img/81QpkIctqPL._AC_SX679_.jpg', 'electronics', 22),
(14, 'Samsung 49-Inch CHG90 144Hz Curved Gaming Monitor (LC49HG90DMNXZA) – Super Ultrawide Screen QLED ', '49 INCH SUPER ULTRAWIDE 32:9 CURVED GAMING MONITOR with dual 27 inch screen side by side QUANTUM DOT (QLED) TECHNOLOGY, HDR support and factory calibration provides stunningly realistic and accurate color and contrast 144HZ HIGH REFRESH RATE and 1ms ultra fast response time work to eliminate motion blur, ghosting, and reduce input lag', 999.99, 'https://fakestoreapi.com/img/81Zt42ioCgL._AC_SX679_.jpg', 'electronics', 22),
(15, 'BIYLACLESEN Women\'s 3-in-1 Snowboard Jacket Winter Coats', 'Note:The Jackets is US standard size, Please choose size as your usual wear Material: 100% Polyester; Detachable Liner Fabric: Warm Fleece. Detachable Functional Liner: Skin Friendly, Lightweigt and Warm.Stand Collar Liner jacket, keep you warm in cold weather. Zippered Pockets: 2 Zippered Hand Pockets, 2 Zippered Pockets on Chest (enough to keep cards or keys)and 1 Hidden Pocket Inside.Zippered H', 56.99, 'https://fakestoreapi.com/img/51Y5NI-I5jL._AC_UX679_.jpg', 'women\'s clothing', 22),
(16, 'Lock and Love Women\'s Removable Hooded Faux Leather Moto Biker Jacket', '100% POLYURETHANE(shell) 100% POLYESTER(lining) 75% POLYESTER 25% COTTON (SWEATER), Faux leather material for style and comfort / 2 pockets of front, 2-For-One Hooded denim style faux leather jacket, Button detail on waist / Detail stitching at sides, HAND WASH ONLY / DO NOT BLEACH / LINE DRY / DO NOT IRON', 29.95, 'https://fakestoreapi.com/img/81XH0e8fefL._AC_UY879_.jpg', 'women\'s clothing', 22),
(17, 'Rain Jacket Women Windbreaker Striped Climbing Raincoats', 'Lightweight perfet for trip or casual wear---Long sleeve with hooded, adjustable drawstring waist design. Button and zipper front closure raincoat, fully stripes Lined and The Raincoat has 2 side pockets are a good size to hold all kinds of things, it covers the hips, and the hood is generous but doesn\'t overdo it.Attached Cotton Lined Hood with Adjustable Drawstrings give it a real styled look.', 39.99, 'https://fakestoreapi.com/img/71HblAHs5xL._AC_UY879_-2.jpg', 'women\'s clothing', 22),
(18, 'MBJ Women\'s Solid Short Sleeve Boat Neck V ', '95% RAYON 5% SPANDEX, Made in USA or Imported, Do Not Bleach, Lightweight fabric with great stretch for comfort, Ribbed on sleeves and neckline / Double stitching on bottom hem', 9.85, 'https://fakestoreapi.com/img/71z3kpMAYsL._AC_UY879_.jpg', 'women\'s clothing', 22),
(19, 'Opna Women\'s Short Sleeve Moisture', '100% Polyester, Machine wash, 100% cationic polyester interlock, Machine Wash & Pre Shrunk for a Great Fit, Lightweight, roomy and highly breathable with moisture wicking fabric which helps to keep moisture away, Soft Lightweight Fabric with comfortable V-neck collar and a slimmer fit, delivers a sleek, more feminine silhouette and Added Comfort', 7.95, 'https://fakestoreapi.com/img/51eg55uWmdL._AC_UX679_.jpg', 'women\'s clothing', 22),
(20, 'DANVOUY Womens T Shirt Casual Cotton Short', '95%Cotton,5%Spandex, Features: Casual, Short Sleeve, Letter Print,V-Neck,Fashion Tees, The fabric is soft and has some stretch., Occasion: Casual/Office/Beach/School/Home/Street. Season: Spring,Summer,Autumn,Winter.', 12.99, 'https://fakestoreapi.com/img/61pHAEJ4NML._AC_UX679_.jpg', 'women\'s clothing', 22);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_customer_cart`
-- (See below for the actual view)
--
CREATE TABLE `view_customer_cart` (
`customer_id` int(11)
,`product_id` int(11)
,`cart_id` int(11)
,`cart_item_id` int(11)
,`title` varchar(150)
,`image` varchar(250)
,`product_quantity` int(11)
,`price` decimal(10,2)
,`in_cart_quantity` int(11)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_customer_order`
-- (See below for the actual view)
--
CREATE TABLE `view_customer_order` (
`title` varchar(150)
,`customer_id` int(11)
,`total_quantity` int(11)
,`total_price` decimal(10,2)
,`status` varchar(50)
,`ordered_at` datetime
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_customer_total_items`
-- (See below for the actual view)
--
CREATE TABLE `view_customer_total_items` (
`customer_id` int(11)
,`total_quantity` decimal(32,0)
,`total_price` decimal(32,2)
);

-- --------------------------------------------------------

--
-- Structure for view `view_customer_cart`
--
DROP TABLE IF EXISTS `view_customer_cart`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_customer_cart`  AS SELECT `cts`.`id` AS `customer_id`, `p`.`id` AS `product_id`, `ct`.`id` AS `cart_id`, `ci`.`id` AS `cart_item_id`, `p`.`title` AS `title`, `p`.`image` AS `image`, `p`.`quantity` AS `product_quantity`, `p`.`price` AS `price`, `ci`.`quantity` AS `in_cart_quantity` FROM (((`customers` `cts` join `cart` `ct` on(`ct`.`customer_id` = `cts`.`id`)) join `cart_items` `ci` on(`ci`.`cart_id` = `ct`.`id`)) join `products` `p` on(`ci`.`product_id` = `p`.`id`)) WHERE `cts`.`id` = `ct`.`customer_id` ;

-- --------------------------------------------------------

--
-- Structure for view `view_customer_order`
--
DROP TABLE IF EXISTS `view_customer_order`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_customer_order`  AS SELECT `p`.`title` AS `title`, `c`.`id` AS `customer_id`, `oi`.`total_quantity` AS `total_quantity`, `oi`.`total_price` AS `total_price`, `o`.`status` AS `status`, `o`.`created_at` AS `ordered_at` FROM (((`customers` `c` join `order_items` `oi` on(`oi`.`customer_id` = `c`.`id`)) join `orders` `o` on(`o`.`id` = `oi`.`order_id`)) join `products` `p` on(`p`.`id` = `oi`.`product_id`)) WHERE `c`.`id` = `oi`.`customer_id` ;

-- --------------------------------------------------------

--
-- Structure for view `view_customer_total_items`
--
DROP TABLE IF EXISTS `view_customer_total_items`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_customer_total_items`  AS SELECT `c`.`id` AS `customer_id`, sum(`ci`.`quantity`) AS `total_quantity`, sum(`ci`.`total_price`) AS `total_price` FROM ((`customers` `c` join `cart` `ct` on(`ct`.`customer_id` = `c`.`id`)) join `cart_items` `ci` on(`ct`.`id` = `ci`.`cart_id`)) WHERE `c`.`id` = `ct`.`customer_id` GROUP BY `c`.`id` ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `customer_id` (`customer_id`);

--
-- Indexes for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cart_id` (`cart_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `fk_customer` (`customer_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `address`
--
ALTER TABLE `address`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `address`
--
ALTER TABLE `address`
  ADD CONSTRAINT `address_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_customer_id` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`);

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_ibfk_1` FOREIGN KEY (`cart_id`) REFERENCES `cart` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `customer_id` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `fk_customer` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
