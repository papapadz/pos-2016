-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 27, 2016 at 09:48 PM
-- Server version: 5.6.20
-- PHP Version: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `posdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
`category_id` int(11) NOT NULL,
  `categoryname` varchar(100) NOT NULL,
  `description` varchar(200) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=30 ;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `categoryname`, `description`) VALUES
(6, 'Souvenirs', 'party favors for birthdays, christening and weddings\r\n'),
(8, 'School Supplies', 'things used in school and/or in the office'),
(10, 'Outdoor & Garden', 'garden decors, etc'),
(13, 'Party Supplies', 'party decorations, paper plates, loot bags, etc...'),
(14, 'Toys', 'for kids...'),
(15, 'Balloons', '...'),
(16, 'Scrapbook Materials', 'cutouts, designer papers, etc...\r\n'),
(17, 'T-shirt/Blouses', '...'),
(18, 'Tumblers & Mugs', '...'),
(19, 'Pens', 'for writing, lettering, coloring, drawing, etc...'),
(20, 'Notebooks', 'for writing...'),
(21, 'Gift Wrappers', 'colorful wrappers for gifts...'),
(22, 'Ribbons', '...'),
(23, 'Art Materials', 'for arts and crafts...'),
(24, 'ID Laces', 'cords for IDs...'),
(25, 'Keychains', 'for souvenirs, bag accessories'),
(26, 'Head Accessories', 'head dresses, etc.....'),
(27, 'Makeups', '...'),
(28, 'Paper Bags', 'for gifts, etc...\r\n'),
(29, 'Painting Supplies', 'materials used for painting, etc...');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE IF NOT EXISTS `customer` (
`cust_id` int(11) NOT NULL,
  `companyname` varchar(200) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `contactno` varchar(20) NOT NULL,
  `tin_no` int(11) NOT NULL,
  `address` varchar(200) NOT NULL,
  `city` varchar(100) NOT NULL,
  `cust_type` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`cust_id`, `companyname`, `lastname`, `firstname`, `contactno`, `tin_no`, `address`, `city`, `cust_type`) VALUES
(1, '', 'walk-in customer', '', '', 0, '', '', 3),
(5, 'MMSU', 'Franco', 'Prima Fe', '09169089171', 2147483647, '# 16 Quiling Sur', 'City of Batac', 1),
(6, 'Corner''s Place', 'Castro', 'Bonzee', '09179992255', 1267484902, '# 11 Ben-agan', 'City of Batac', 2),
(7, 'Batac City Hall', 'Camangeg', 'Honeylet', '09192190891', 1268709001, '# 1 Ricarte', 'City of Batac', 1),
(11, 'Brgy. 1 Ricarte', 'Camangeg', 'Sonny', '09198891234', 670890460, '# 1 Ricarte', 'City of Batac', 1),
(15, 'MAEHEM''s Inc', 'Javier', 'Marla', '09194749591', 0, 'Taft St., # 6 San Julian', 'City of Batac', 2);

-- --------------------------------------------------------

--
-- Table structure for table `delivery`
--

CREATE TABLE IF NOT EXISTS `delivery` (
`delivery_id` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `totalcost` double(10,2) NOT NULL DEFAULT '0.00',
  `deliverydate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `deliverydetails`
--

CREATE TABLE IF NOT EXISTS `deliverydetails` (
`deliverydetails_id` int(11) NOT NULL,
  `delivery_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `unitcost` double(10,2) NOT NULL,
  `deliverycost` double(10,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `deliveryset`
--

CREATE TABLE IF NOT EXISTS `deliveryset` (
`deliveryset_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `unitcost` double(10,2) NOT NULL DEFAULT '0.00',
  `deliverycost` double(10,2) NOT NULL DEFAULT '0.00',
  `employee_id` int(11) NOT NULL DEFAULT '8'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE IF NOT EXISTS `employee` (
`employee_id` int(11) NOT NULL,
  `employeename` varchar(100) NOT NULL,
  `position` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` text NOT NULL,
  `address` varchar(100) NOT NULL,
  `contactno` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `remember_token` text NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`employee_id`, `employeename`, `position`, `username`, `password`, `address`, `contactno`, `email`, `remember_token`) VALUES
(8, 'Jocel Tagatac', '1', 'jotag', '$2y$10$./K/d89d9WeF0qgiDksAROXnaOWol/wQ.uoeslciKh6e6wUEW6jnC', '# 5 Callaguip, City of Batac', '09293202718', 'jotag@gmail.com', 'csbnJDG9xQEMz2UAnAkf46w3Xw35goGwjju8VYauh76BCC6Igv6GHvt8oc7N');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
`order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `salesprice` double(10,2) NOT NULL DEFAULT '0.00',
  `orderprice` double(10,2) NOT NULL,
  `markup` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE IF NOT EXISTS `payment` (
`payment_id` int(11) NOT NULL,
  `sales_id` int(11) NOT NULL,
  `amounttendered` double(10,2) NOT NULL DEFAULT '0.00',
  `amountpaid` double(10,2) NOT NULL,
  `balancedue` double(10,2) NOT NULL,
  `or_number` varchar(20) NOT NULL,
  `paymentdate` datetime DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE IF NOT EXISTS `product` (
`product_id` int(11) NOT NULL,
  `productcode` varchar(12) NOT NULL DEFAULT '0',
  `productname` varchar(50) NOT NULL,
  `unitprice` double(10,2) NOT NULL,
  `stock` int(11) NOT NULL,
  `reorderlimit` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `status` int(2) NOT NULL DEFAULT '0',
  `unitcost` double(10,2) NOT NULL DEFAULT '0.00',
  `percentage` double(10,2) NOT NULL DEFAULT '0.00',
  `markup` double(10,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=43 ;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `productcode`, `productname`, `unitprice`, `stock`, `reorderlimit`, `category_id`, `supplier_id`, `status`, `unitcost`, `percentage`, `markup`) VALUES
(3, '0', 'Pilot- ballpen', 11.50, 4810, 100, 8, 8, 0, 10.00, 0.00, 15.00),
(8, '0', 'Wisepoint Notebook', 38.50, 808, 100, 8, 8, 0, 35.00, 0.00, 10.00),
(14, '0', 'Disney Character Keychains', 51.80, 90, 200, 6, 9, 0, 32.00, 15.00, 15.00),
(15, '0', 'Mini bears (souvenirs)', 35.20, 35, 250, 6, 9, 0, 32.00, 0.00, 10.00),
(16, '0', 'Self Stirring Coffee Mug', 338.80, 129, 40, 6, 9, 0, 308.00, 0.00, 10.00),
(23, '0', 'Drawsting Bags', 33.35, 221, 250, 6, 9, 0, 29.00, 0.00, 15.00),
(29, '0', 'Peppa Pig Plush Toy (4-inch tall)', 67.85, 513, 30, 6, 9, 0, 59.00, 0.00, 15.00),
(40, '0', 'pencil', 22.00, 401, 100, 8, 7, 0, 20.00, 0.00, 10.00),
(41, '0', 'pencil', 33.00, 100, 100, 8, 7, 0, 30.00, 0.00, 10.00),
(42, '0', 'beach ball', 28.75, 80, 20, 10, 7, 0, 25.00, 0.00, 15.00);

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE IF NOT EXISTS `sales` (
`sales_id` int(11) NOT NULL,
  `cust_id` int(11) NOT NULL,
  `invoicenumber` varchar(11) NOT NULL,
  `totalsales` double(10,2) NOT NULL DEFAULT '0.00',
  `sales_type` int(11) NOT NULL COMMENT '1:CASH; 2:CREDIT',
  `status` int(11) NOT NULL COMMENT '0:UNPAID; 1:PAID; 2:BALANCE',
  `salesdate` timestamp NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

-- --------------------------------------------------------

--
-- Table structure for table `salesdetails`
--

CREATE TABLE IF NOT EXISTS `salesdetails` (
`salesdetails_id` int(11) NOT NULL,
  `sales_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `ordersalesprice` double(10,2) NOT NULL DEFAULT '0.00',
  `sales_price` double(10,2) NOT NULL,
  `markup` decimal(4,0) NOT NULL DEFAULT '0',
  `discount` decimal(4,0) NOT NULL DEFAULT '0'
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE IF NOT EXISTS `supplier` (
`supplier_id` int(11) NOT NULL,
  `companyname` varchar(200) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `contactno` varchar(20) NOT NULL,
  `address` varchar(200) NOT NULL,
  `city` varchar(20) NOT NULL,
  `tin` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`supplier_id`, `companyname`, `lastname`, `firstname`, `contactno`, `address`, `city`, `tin`) VALUES
(1, 'KARMAK', 'Agpaoa', 'Ken', '772-890-1234', '# 15', 'Laoag City', 12537900),
(3, 'New India Department Store', 'Mahmuk', 'Ahkary', '1452254417', 'Brgy. Salet', 'Laoag City', 314567780),
(4, 'Makita Corp.', 'Mashida', 'Yokomora', '0215547849', 'Mirador Hills', 'Valenzuela City', 0),
(5, 'Welders ', 'Tan', 'JJ', '09198906789', 'Marcos Ave,', 'San Fernando City', 123456789),
(6, 'Q-loft', 'Aqui', 'Lorly', '0917889113', 'Guillermo Hill', 'City of Batac', 34567430),
(7, 'Chum Bucket Corp.', 'Plankton', 'Tenco', '0917889113', 'Bikini Bottom', 'Nick City', 15467809),
(8, 'TOPCOMS', 'Aguinaldo', 'Emil', '09228867266', 'Westside St.', 'Makati City', 2147483647),
(9, 'G & J Prints', 'Quiambao', 'Estrella', '09182005512', 'San Julian', 'Baguio City', 2147483647),
(10, 'GEARson Corp', 'Reyes', 'Dencio', '09123217800', '46 Grace Village', 'Dagupan City', 2147483647),
(11, 'Wilcon Depot', 'dela Cruz', 'Juan', '09176781234', 'Monte Vista Village', 'Marikina City', 2147483647);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
 ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
 ADD PRIMARY KEY (`cust_id`);

--
-- Indexes for table `delivery`
--
ALTER TABLE `delivery`
 ADD PRIMARY KEY (`delivery_id`), ADD KEY `supplier_id` (`supplier_id`);

--
-- Indexes for table `deliverydetails`
--
ALTER TABLE `deliverydetails`
 ADD PRIMARY KEY (`deliverydetails_id`), ADD KEY `delivery_id` (`delivery_id`), ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `deliveryset`
--
ALTER TABLE `deliveryset`
 ADD PRIMARY KEY (`deliveryset_id`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
 ADD PRIMARY KEY (`employee_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
 ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
 ADD PRIMARY KEY (`payment_id`), ADD KEY `sales_id` (`sales_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
 ADD PRIMARY KEY (`product_id`), ADD KEY `category_id` (`category_id`), ADD KEY `supplier_id` (`supplier_id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
 ADD PRIMARY KEY (`sales_id`), ADD KEY `cust_id` (`cust_id`);

--
-- Indexes for table `salesdetails`
--
ALTER TABLE `salesdetails`
 ADD PRIMARY KEY (`salesdetails_id`), ADD KEY `sales_id` (`sales_id`), ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
 ADD PRIMARY KEY (`supplier_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=30;
--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
MODIFY `cust_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `delivery`
--
ALTER TABLE `delivery`
MODIFY `delivery_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `deliverydetails`
--
ALTER TABLE `deliverydetails`
MODIFY `deliverydetails_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `deliveryset`
--
ALTER TABLE `deliveryset`
MODIFY `deliveryset_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
MODIFY `employee_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=43;
--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
MODIFY `sales_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `salesdetails`
--
ALTER TABLE `salesdetails`
MODIFY `salesdetails_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
MODIFY `supplier_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `delivery`
--
ALTER TABLE `delivery`
ADD CONSTRAINT `delivery_ibfk_1` FOREIGN KEY (`supplier_id`) REFERENCES `supplier` (`supplier_id`) ON UPDATE CASCADE;

--
-- Constraints for table `deliverydetails`
--
ALTER TABLE `deliverydetails`
ADD CONSTRAINT `deliverydetails_ibfk_1` FOREIGN KEY (`delivery_id`) REFERENCES `delivery` (`delivery_id`) ON UPDATE CASCADE,
ADD CONSTRAINT `deliverydetails_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON UPDATE CASCADE;

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`sales_id`) REFERENCES `sales` (`sales_id`) ON UPDATE CASCADE;

--
-- Constraints for table `product`
--
ALTER TABLE `product`
ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`) ON UPDATE CASCADE,
ADD CONSTRAINT `product_ibfk_2` FOREIGN KEY (`supplier_id`) REFERENCES `supplier` (`supplier_id`) ON UPDATE CASCADE;

--
-- Constraints for table `sales`
--
ALTER TABLE `sales`
ADD CONSTRAINT `sales_ibfk_1` FOREIGN KEY (`cust_id`) REFERENCES `customer` (`cust_id`) ON UPDATE CASCADE;

--
-- Constraints for table `salesdetails`
--
ALTER TABLE `salesdetails`
ADD CONSTRAINT `salesdetails_ibfk_1` FOREIGN KEY (`sales_id`) REFERENCES `sales` (`sales_id`) ON UPDATE CASCADE,
ADD CONSTRAINT `salesdetails_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
