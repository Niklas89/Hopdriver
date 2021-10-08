-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 08, 2015 at 05:35 PM
-- Server version: 5.6.12-log
-- PHP Version: 5.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `choosedriver`
--
CREATE DATABASE IF NOT EXISTS `choosedriver` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `choosedriver`;

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE IF NOT EXISTS `admins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `first_name`, `last_name`, `email`, `pass`) VALUES
(1, 'Nicha', 'Edelchauff', 'contact@email.com', '213123123213');

-- --------------------------------------------------------

--
-- Table structure for table `chauffeurs`
--

CREATE TABLE IF NOT EXISTS `chauffeurs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pass` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `date_inscription` datetime NOT NULL,
  `city` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `phonetwo` varchar(255) NOT NULL,
  `languages` text NOT NULL,
  `vehicles` text NOT NULL,
  `address` varchar(255) NOT NULL,
  `postal_code` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `company` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `chauffeurs`
--

INSERT INTO `chauffeurs` (`id`, `pass`, `email`, `date_inscription`, `city`, `first_name`, `last_name`, `phone`, `phonetwo`, `languages`, `vehicles`, `address`, `postal_code`, `country`, `company`) VALUES
(1, '08a6666970c19feaaa92745672862014', 'contact@email.com', '2013-10-31 00:00:00', 'Paris', 'Ed', 'Hardy', '+33 6 32541254', '', 'English and French', 'Im the best driver in the world', '', '75001', 'France', 'VTC Anywhere'),
(2, '08a6666970c19feaaa92745672862014', 'qsdqsd@hotmail.com', '2013-10-31 00:00:00', 'paris', 'Nikcha', 'Edelschauff', '0687564398', '019879879', 'English \r\nChinese', 'MB S Class\r\nMB E Class', '321 bd bineau', '92200', 'France', 'Vanee'),
(16, 'd2e85bd226645584be1f8e117b7c7a4e', 'asdasdas@hotmail.com', '2015-03-09 21:26:52', 'Paris', 'sadadas', 'asdsdsa', '', '', '', '', '', '', '', 'Transport Co'),
(17, '1a2774b573e7f1126506a5558dbb8cd3', 'qsdqds@gmail.com', '2015-03-30 22:06:23', '', 'Edouard', 'Lala', '', '', '', '', '', '', '', ''),
(18, '9069506b839473a3443eec233a42c1b2', 'lala@email.com', '2015-12-07 15:32:52', '', 'Roger', 'Moore', '', '', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE IF NOT EXISTS `clients` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pass` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `date_inscription` datetime NOT NULL,
  `city` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `postal_code` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `company` varchar(255) NOT NULL,
  `promo` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `pass`, `email`, `date_inscription`, `city`, `first_name`, `last_name`, `phone`, `address`, `postal_code`, `country`, `company`, `promo`) VALUES
(1, '08a6666970c19feaaa92745672862014', 'contact@email.com', '2013-10-31 00:00:00', '', '', '', '', '', '', '', '', ''),
(2, '08a6666970c19feaaa92745672862014', 'qsdqsd@hotmail.com', '2013-10-31 00:00:00', 'paris', 'Nikcha', 'Edelschauff', '0687564398', '321 bd bineau', '92200', 'France', 'Vani', ''),
(16, 'd2e85bd226645584be1f8e117b7c7a4e', 'asdasdas@hotmail.com', '2015-03-09 21:26:52', '', 'sadadas', 'asdsdsa', '', '', '', '', '', ''),
(11, '08a6666970c19feaaa92745672862014', 'qsdsqd@hotmail.com', '2015-03-09 18:43:03', '', 'sadsa', 'asdsad', '', '', '', '', '', ''),
(21, 'f65eb20f723b21e2b65f54bc535656ed', 'asdad@sad.com', '2015-12-04 17:43:09', '', 'asdasd', 'asd', '+33687564398', '', '', '', '', ''),
(20, 'cf1776b6bb2f04e84ae13376ba3069b2', 'qsdqd@gmail.com', '2015-03-22 15:11:32', '', 'Ahmed', 'Lalk', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `disposal_booking`
--

CREATE TABLE IF NOT EXISTS `disposal_booking` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `coldate` datetime NOT NULL,
  `service` varchar(255) NOT NULL,
  `pickupdate` varchar(255) NOT NULL,
  `pickuptime` varchar(255) NOT NULL,
  `drop_off_date` varchar(255) NOT NULL,
  `drop_off_time` varchar(255) NOT NULL,
  `pick_up_loc` varchar(255) NOT NULL,
  `drop_off_loc` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `flightnumber` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `price` varchar(10) NOT NULL,
  `hoursday` varchar(10) NOT NULL,
  `promo` varchar(255) NOT NULL,
  `comments` text NOT NULL,
  `driverid` int(11) NOT NULL,
  `clientid` int(11) NOT NULL,
  `accepted` int(11) NOT NULL,
  `vehicle` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=54 ;

--
-- Dumping data for table `disposal_booking`
--

INSERT INTO `disposal_booking` (`id`, `coldate`, `service`, `pickupdate`, `pickuptime`, `drop_off_date`, `drop_off_time`, `pick_up_loc`, `drop_off_loc`, `first_name`, `last_name`, `flightnumber`, `email`, `phone`, `price`, `hoursday`, `promo`, `comments`, `driverid`, `clientid`, `accepted`, `vehicle`) VALUES
(30, '2015-02-12 14:58:20', 'Disposal - Mercedes Benz Viano', '>Feb 12, Thu', '>12:00 AM', '>Feb 19, Thu', '>12:00 AM', '>163 Avenue Achille Peretti, Neuilly-sur-Seine, France', '>Roissy Charles De Gaulle, Roissy-en-France, France', 'asd', 'asd', 'asd', 'asd', 'asd', '8232', '>12', '', '', 0, 0, 0, ''),
(31, '2015-02-12 14:59:10', 'Disposal - Clio Renault', '>Feb 12, Thu', '>12:00 AM', '>Feb 19, Thu', '>12:00 AM', '>163 Avenue Achille Peretti, Neuilly-sur-Seine, France', '>Roissy Charles De Gaulle, Roissy-en-France, France', 'asdasd', 'asd', 'dasda', 'asdasd', 'asdsa', '3444', '>12', '', '', 0, 0, 0, ''),
(32, '2015-02-12 15:01:21', 'Disposal - Volkswagen Caravelle', '>Feb 12, Thu', '>12:00 AM', '>Feb 19, Thu', '>12:00 AM', '>163 Avenue Achille Peretti, Neuilly-sur-Seine, France', '>Roissy Charles De Gaulle, Roissy-en-France, France', 'iiii', 'eee', 'fllii', 'oo', 'pphoo', '5964', '>12', '', '', 0, 0, 0, ''),
(33, '2015-02-12 15:03:15', '', '>', '>', '>', '>', '>', '>', 'asd', 'asd', 'asd', 'asd', 'asd', '', '>', '', '', 0, 0, 0, ''),
(34, '2015-02-12 15:10:14', 'Disposal - Mercedes Benz S Class', '>Feb 12, Thu', '>12:00 AM', '>Feb 19, Thu', '>12:00 AM', '>163 Avenue Achille Peretti, Neuilly-sur-Seine, France', '>Roissy Charles De Gaulle, Roissy-en-France, France', 'asd', 'asd', 'asd', 'ad', 'asd', '8232', '>12', '', '', 0, 0, 0, ''),
(35, '2015-02-12 15:11:07', 'Disposal - Peugeot 508', '>Feb 12, Thu', '>12:00 AM', '>Feb 19, Thu', '>12:00 AM', '>163 Avenue Achille Peretti, Neuilly-sur-Seine, France', '>Roissy Charles De Gaulle, Roissy-en-France, France', 'asdasd', 'asdasd', 'asdasd', 'asdsad', 'asdasd', '4620', '>12', '', '', 0, 0, 0, ''),
(36, '2015-02-12 15:11:38', 'Disposal - Mercedes Benz E Class', '>Feb 12, Thu', '>12:00 AM', '>Feb 19, Thu', '>12:00 AM', '>163 Avenue Achille Peretti, Neuilly-sur-Seine, France', '>Roissy Charles De Gaulle, Roissy-en-France, France', 'asdasd', 'asdsad', 'asda', 'asdas', 'asdasd', '5964', '>12', '', '', 0, 0, 0, ''),
(37, '2015-02-22 21:03:16', 'Disposal - Business car', '>Feb 22, Sun', '>12:00 AM', '>Mar 1, Sun', '>12:00 AM', '>Roissy Charles De Gaulle, Roissy-en-France, France', '>164 Boulevard Saint-Germain, Paris, France', 'asd', 'asda', 'dsadad', 'sdsad', 'asdas', '3706.85', '>7', 'vok34Prom', 'asdasd sada dsad sad sa d asdsa', 0, 0, 0, ''),
(38, '2015-02-22 21:03:52', 'Disposal - Business car', '>Feb 22, Sun', '>12:00 AM', '>Mar 1, Sun', '>12:00 AM', '>Roissy Charles De Gaulle, Roissy-en-France, France', '>164 Boulevard Saint-Germain, Paris, France', 'asd', 'asda', 'dsadad', 'sdsad', 'asdas', '4361', '>7', 'asdasd', 'asdasd sada dsad sad sa d asdsa', 0, 0, 0, ''),
(39, '2015-02-22 21:24:01', 'Disposal - Economy van', '>Feb 22, Sun', '>12:00 AM', '>Mar 1, Sun', '>12:00 AM', '>876 Boulevard Bileau, Neuilly-sur-Seine, France', '>Nanagatan 43, Stockholm, Suède', 'asdasdd', 'asdasd', 'asdsad', 'asdasd', 'sadsad', '3276', '>6', '', '', 0, 0, 0, ''),
(40, '2015-02-27 16:50:51', 'Disposal - Economy car', '>27-02-2015', '>12:00 AM', '>06-03-2015', '>11:15 PM', '>165 Rue de Rome, Paris, France', '>Roissy Charles De Gaulle, Roissy-en-France, France', 'asdasd', 'asdsad', 'asdsa', 'asdsad', 'asdszd', '4620', '>11', '', '', 0, 0, 1, ''),
(41, '2015-03-16 20:36:07', '', 'Mar 16, Mon', '12:00 AM', 'Mar 23, Mon', '11:15 PM', '165 Avenue Charles de Gaulle, Neuilly-sur-Seine, France', 'Roissy Charles De Gaulle, Roissy-en-France, France', '', '', '', '', '', '45', '6', '', 'dsad asdsa dsad asdsa dasdasd \r\nasdasd asdsa dsdssssds\r\n\r\nasdasd adsad as\r\n123€', 1, 2, 1, ''),
(47, '2015-03-29 17:43:19', 'Business Van', 'Mar 29, Sun', '12:00 AM', 'Apr 5, Sun', '12:00 AM', '55 Boulevard Haussmann, Paris, France', '87 Rue de Richelieu, Paris, France', 'nik1', 'ede1', '123133', 'nikl1@mail.com', '121313', '56', '4', '', 'mon 2e essai', 2, 2, 1, ''),
(48, '2015-03-29 17:51:31', '', 'Mar 29, Sun', '12:00 AM', 'Apr 5, Sun', '12:00 AM', '45 Avenue Victor Hugo, Aubervilliers, France', 'Charles de Gaulle Airport, Roissy-en-France, France', '', '', '', '', '', '', '7', '', 'asdasdsad', 1, 2, 0, ''),
(49, '2015-03-29 18:12:02', 'Choose Service', 'Mar 30, Mon', '12:00 AM', 'Apr 5, Sun', '12:00 AM', 'Asdale Road, Durkar, United Kingdom', '43 Avenue Bugeaud, Paris, France', 'asd', 'sad', '123222', 'asd', '12313', '32', '5', '', 'asdsadadad', 0, 2, 1, ''),
(50, '2015-03-29 18:16:48', 'Economy Car', '8 Apr 2015', '12:00 AM', 'Apr 9, Thu', '9:35 PM', 'Nanagatan 43, Stockholm, Sweden', 'Arlanda Airport, Stockholm-Arlanda, Sweden', 'asdsa', 'dasd', 'asdsad', 'asdasd', 'asdsad', '213123', '6', '', 'LA CA DEVRAIT MARCHER', 0, 2, 1, ''),
(51, '2015-04-08 17:47:33', 'Business Van', '8 Apr 2015', '12:00 AM', '15 Apr 2015', '12:00 AM', 'Nanagatan 43, Stockholm, Sweden', 'Arlanda Airport, Stockholm-Arlanda, Sweden', 'asdsad', 'asdasd', '3123123', 'asdsad', '1312', '222', '5', '', 'adasdadfff', 0, 2, 1, ''),
(52, '2015-12-08 14:54:20', 'Disposal - Economy Car', '08 Dec 2015', '00:00', '15 Dec 2015', '14:03', '165 Boulevard Haussmann, Paris, France', 'Aéroport Charles de Gaulle 2 - TGV, Tremblay-en-France, France', 'Nikcha', 'Edelschauff', '', 'qsdqsd@hotmail.com', 'Edelschauff', '2800', '10', '', '', 0, 2, 0, 'Not Specified'),
(53, '2015-12-08 15:02:21', 'Disposal - Motorcycle', '08 Dec 2015', '00:00', '15 Dec 2015', '15:01', '165 Boulevard Haussmann, Paris, France', '12 Rue du Chevalier de la Barre, Paris, France', 'Nikcha', 'Edelschauff', 'SD2321', 'qsdqsd@hotmail.com', 'Edelschauff', '2100', '10', '', ' asdsad asdsa das', 2, 2, 1, 'Not Specified');

-- --------------------------------------------------------

--
-- Table structure for table `driver_luggage`
--

CREATE TABLE IF NOT EXISTS `driver_luggage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `driverid` int(11) NOT NULL,
  `ecocar` tinyint(2) NOT NULL,
  `ecovan` tinyint(2) NOT NULL,
  `buscar` tinyint(2) NOT NULL,
  `busvan` tinyint(2) NOT NULL,
  `luxcar` tinyint(2) NOT NULL,
  `moto` tinyint(1) NOT NULL,
  `coach` tinyint(3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `driver_luggage`
--

INSERT INTO `driver_luggage` (`id`, `driverid`, `ecocar`, `ecovan`, `buscar`, `busvan`, `luxcar`, `moto`, `coach`) VALUES
(1, 2, 3, 6, 2, 2, 2, 2, 54),
(2, 1, 4, 4, 4, 4, 4, 4, 4);

-- --------------------------------------------------------

--
-- Table structure for table `driver_payment`
--

CREATE TABLE IF NOT EXISTS `driver_payment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `driverid` int(11) NOT NULL,
  `cash` tinyint(1) NOT NULL,
  `card` tinyint(1) NOT NULL,
  `water` tinyint(1) NOT NULL,
  `wifi` tinyint(1) NOT NULL,
  `magazines` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `driver_payment`
--

INSERT INTO `driver_payment` (`id`, `driverid`, `cash`, `card`, `water`, `wifi`, `magazines`) VALUES
(1, 2, 1, 0, 0, 1, 0),
(2, 1, 1, 0, 1, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `driver_prices`
--

CREATE TABLE IF NOT EXISTS `driver_prices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `driverid` int(11) NOT NULL,
  `ecocar` decimal(4,2) NOT NULL,
  `ecovan` decimal(4,2) NOT NULL,
  `buscar` decimal(4,2) NOT NULL,
  `busvan` decimal(4,2) NOT NULL,
  `luxcar` decimal(4,2) NOT NULL,
  `moto` decimal(4,2) NOT NULL,
  `coach` decimal(3,2) NOT NULL,
  `minimum_ecocar` int(3) NOT NULL,
  `minimum_ecovan` int(3) NOT NULL,
  `minimum_buscar` int(3) NOT NULL,
  `minimum_busvan` int(3) NOT NULL,
  `minimum_luxcar` int(3) NOT NULL,
  `minimum_moto` int(3) NOT NULL,
  `minimum_coach` int(4) NOT NULL,
  `disposal_ecocar` tinyint(3) NOT NULL,
  `disposal_ecovan` tinyint(3) NOT NULL,
  `disposal_buscar` tinyint(3) NOT NULL,
  `disposal_busvan` tinyint(3) NOT NULL,
  `disposal_luxcar` tinyint(3) NOT NULL,
  `disposal_moto` tinyint(3) NOT NULL,
  `disposal_coach` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `driver_prices`
--

INSERT INTO `driver_prices` (`id`, `driverid`, `ecocar`, `ecovan`, `buscar`, `busvan`, `luxcar`, `moto`, `coach`, `minimum_ecocar`, `minimum_ecovan`, `minimum_buscar`, `minimum_busvan`, `minimum_luxcar`, `minimum_moto`, `minimum_coach`, `disposal_ecocar`, `disposal_ecovan`, `disposal_buscar`, `disposal_busvan`, `disposal_luxcar`, `disposal_moto`, `disposal_coach`) VALUES
(1, 2, '0.87', '1.98', '3.00', '4.00', '5.00', '1.00', '9.00', 10, 10, 10, 10, 10, 10, 10, 40, 50, 50, 60, 70, 30, 127),
(2, 1, '2.00', '2.00', '2.54', '2.77', '3.63', '2.00', '2.00', 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `driver_seats`
--

CREATE TABLE IF NOT EXISTS `driver_seats` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `driverid` int(11) NOT NULL,
  `ecocar` tinyint(1) NOT NULL,
  `ecovan` tinyint(2) NOT NULL,
  `buscar` tinyint(1) NOT NULL,
  `busvan` tinyint(2) NOT NULL,
  `luxcar` tinyint(1) NOT NULL,
  `moto` tinyint(1) NOT NULL,
  `coach` tinyint(3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `driver_seats`
--

INSERT INTO `driver_seats` (`id`, `driverid`, `ecocar`, `ecovan`, `buscar`, `busvan`, `luxcar`, `moto`, `coach`) VALUES
(1, 2, 3, 2, 2, 2, 2, 2, 54),
(2, 1, 3, 3, 3, 3, 3, 3, 3);

-- --------------------------------------------------------

--
-- Table structure for table `driver_vehicles`
--

CREATE TABLE IF NOT EXISTS `driver_vehicles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `driverid` int(11) NOT NULL,
  `ecocar` text NOT NULL,
  `ecovan` text NOT NULL,
  `buscar` text NOT NULL,
  `busvan` text NOT NULL,
  `luxcar` text NOT NULL,
  `moto` text NOT NULL,
  `coach` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `driver_vehicles`
--

INSERT INTO `driver_vehicles` (`id`, `driverid`, `ecocar`, `ecovan`, `buscar`, `busvan`, `luxcar`, `moto`, `coach`) VALUES
(1, 2, 'Mercedes Benz Classe C,\nRenault Laguna,\nPeugeot 508', 'Mercedes Benz Vito Noir 2014', 'Mercedes Benz Classe E Noir 2014', 'Mercedes Benz Classe V Noir 2015', 'Mercedes Benz Classe S Noir 2014', 'Hyundai', 'Grand bus'),
(2, 1, 'Peugeot 508, BMW série 5', 'Mercedes Benz Vito', 'Mercedes Benz Classe E', 'Mercedes Benz Classe V ', 'Mercedes Benz Classe S', 'Hyundai', 'Grand bus');

-- --------------------------------------------------------

--
-- Table structure for table `prices`
--

CREATE TABLE IF NOT EXISTS `prices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `moto` varchar(255) NOT NULL,
  `economy` varchar(255) NOT NULL,
  `business` varchar(255) NOT NULL,
  `luxury` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `prices`
--

INSERT INTO `prices` (`id`, `moto`, `economy`, `business`, `luxury`) VALUES
(1, '1.5', '2', '2.6', '3.6');

-- --------------------------------------------------------

--
-- Table structure for table `transfers_booking`
--

CREATE TABLE IF NOT EXISTS `transfers_booking` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `coldate` datetime NOT NULL,
  `service` varchar(255) NOT NULL,
  `pickupdate` varchar(255) NOT NULL,
  `pickuptime` varchar(255) NOT NULL,
  `returndate` varchar(255) NOT NULL,
  `returntime` varchar(255) NOT NULL,
  `origin` varchar(255) NOT NULL,
  `destination` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `flightnumber` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `price` varchar(10) NOT NULL,
  `promo` varchar(255) NOT NULL,
  `comments` text NOT NULL,
  `driverid` int(11) NOT NULL,
  `clientid` int(11) NOT NULL,
  `accepted` int(11) NOT NULL,
  `vehicle` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=114 ;

--
-- Dumping data for table `transfers_booking`
--

INSERT INTO `transfers_booking` (`id`, `coldate`, `service`, `pickupdate`, `pickuptime`, `returndate`, `returntime`, `origin`, `destination`, `first_name`, `last_name`, `flightnumber`, `email`, `phone`, `price`, `promo`, `comments`, `driverid`, `clientid`, `accepted`, `vehicle`) VALUES
(23, '2015-02-12 15:12:30', 'Transfer - Mercedes Benz Viano', '>Feb 12, Thu', '>12:00 AM', '>Feb 19, Thu', '>12:00 AM', '>163 Avenue Achille Peretti, Neuilly-sur-Seine, France', '>Roissy Charles De Gaulle, Roissy-en-France, France', 'asdsad', 'asdsa', 'asda', 'asdsa', 'asdsa', '196', '', '', 0, 0, 0, ''),
(24, '2015-02-12 15:13:05', 'Transfer - Clio Renault', '>Feb 12, Thu', '>12:00 AM', '>Feb 19, Thu', '>12:00 AM', '>163 Avenue Achille Peretti, Neuilly-sur-Seine, France', '>Roissy Charles De Gaulle, Roissy-en-France, France', 'adsada', 'asdsa', 'sdad', 'asda', 'asdsa', '82', '', '', 0, 0, 0, ''),
(25, '2015-02-12 15:15:20', 'Transfer - Volkswagen Caravelle', '>Feb 12, Thu', '>12:00 AM', '>Feb 19, Thu', '>12:00 AM', '>163 Avenue Achille Peretti, Neuilly-sur-Seine, France', '>Roissy Charles De Gaulle, Roissy-en-France, France', 'asdsa', 'asdasd', 'asas', 'asd', 'sadas', '142', '', '', 0, 0, 0, ''),
(26, '2015-02-12 15:16:06', 'Transfer - Mercedes Benz S Class', '>Feb 12, Thu', '>12:00 AM', '>Feb 19, Thu', '>12:00 AM', '>163 Avenue Achille Peretti, Neuilly-sur-Seine, France', '>Roissy Charles De Gaulle, Roissy-en-France, France', 'asda', 'asd', 'asd', 'asdasd', 'asdas', '196', '', '', 0, 0, 0, ''),
(27, '2015-02-12 15:16:41', 'Transfer - Peugeot 508', '>Feb 12, Thu', '>12:00 AM', '>Feb 19, Thu', '>12:00 AM', '>163 Avenue Achille Peretti, Neuilly-sur-Seine, France', '>Roissy Charles De Gaulle, Roissy-en-France, France', 'asdq', 'asd', 'asd', 'asd', 'asd', '110', '', '', 0, 0, 0, ''),
(28, '2015-02-12 15:17:15', 'Transfer - Mercedes Benz E Class', '>Feb 12, Thu', '>12:00 AM', '>Feb 19, Thu', '>12:00 AM', '>163 Avenue Achille Peretti, Neuilly-sur-Seine, France', '>Roissy Charles De Gaulle, Roissy-en-France, France', 'ad', 'asd', 'asd', 'sd', 'asd', '142', '', '', 0, 0, 0, ''),
(29, '2015-02-22 21:01:38', 'Transfer - Economy van', '>Feb 22, Sun', '>12:00 AM', '>Mar 1, Sun', '>12:00 AM', '>Roissy Charles De Gaulle, Roissy-en-France, France', '>165 Boulevard Haussmann, Paris, France', 'Nicha', 'edelell', '123lkj32', 'Nicha.edelel@asd.com', '123123123 ', '147.9', 'vok34Prom', 'my super uper duper comments are all fucking here.', 0, 0, 0, ''),
(30, '2015-02-22 21:13:25', 'Transfer - Business van', '>Feb 22, Sun', '>12:00 AM', '>Mar 1, Sun', '>12:00 AM', '>Roissy Charles De Gaulle, Roissy-en-France, France', '>165 Boulevard Haussmann, Paris, France', 'asda', 'asdad', 'asdasd', 'asdasd', 'asdsad', '174', 'asd', 'asdad', 0, 0, 0, ''),
(31, '2015-02-22 21:16:37', 'Transfer - Economy van', '>Feb 22, Sun', '>12:00 AM', '>Mar 1, Sun', '>12:00 AM', '>Roissy Charles De Gaulle, Roissy-en-France, France', '>165 Boulevard Haussmann, Paris, France', 'asda', 'asdad', 'asdasd', 'asdasd', 'asdsad', '174', '', '', 0, 0, 0, ''),
(32, '2015-02-27 18:55:12', 'Transfer - Economy car', '27-02-2015', '23:00', '', '', '165 Avenue Charles de Gaulle, Neuilly-sur-Seine, France', 'Roissy Charles De Gaulle, Roissy-en-France, France', 'asdas', 'szdsad', 'sdsad', 'asdsa', 'asdsad', '56', 'ljl', 'hgfhgf', 0, 0, 0, ''),
(33, '2015-02-27 18:55:15', 'Transfer - Economy car', '27-02-2015', '23:00', '', '', '165 Avenue Charles de Gaulle, Neuilly-sur-Seine, France', 'Roissy Charles De Gaulle, Roissy-en-France, France', 'asdas', 'szdsad', 'sdsad', 'asdsa', 'asdsad', '56', 'ljl', 'hgfhgf', 0, 0, 0, ''),
(34, '2015-02-27 18:57:02', 'Transfer - Economy car', '27-02-2015', '23:00', '', '', '165 Avenue Charles de Gaulle, Neuilly-sur-Seine, France', 'Roissy Charles De Gaulle, Roissy-en-France, France', 'asdas', 'szdsad', 'sdsad', 'asdsa', 'asdsad', '56', 'ljl', 'hgfhgf', 0, 0, 0, ''),
(35, '2015-02-27 18:58:15', 'Transfer - Economy car', '27-02-2015', '23:00', '', '', '165 Avenue Charles de Gaulle, Neuilly-sur-Seine, France', 'Roissy Charles De Gaulle, Roissy-en-France, France', 'asdas', 'szdsad', 'sdsad', 'asdsa', 'asdsad', '56', '', '', 0, 0, 0, ''),
(36, '2015-03-11 15:52:23', 'Transfer - Economy car', '11-03-2015', '23:20', '18-03-2015', '00:00', '165 Avenue Charles de Gaulle, Neuilly-sur-Seine, France', 'Roissy Charles De Gaulle, Roissy-en-France, France', 'jkgjhty', 'gfdgfd', 'dgfdgr', 'gfdgfd', 'fdsfds', '112', 'dsdfs', 'gdsgfd', 0, 0, 0, ''),
(37, '2015-03-11 16:05:46', '', 'Mar 12, Thu', '12:10 AM', '', '', 'Roissy Charles De Gaulle, Roissy-en-France, France', '165 Rue de Rome, Paris, France', '', '', '', '', '', '', '', 'asdsadadsad asd sad a sa dsa', 0, 0, 0, ''),
(38, '2015-03-11 16:08:46', '', 'Mar 11, Wed', '12:00 AM', 'Mar 18, Wed', '12:00 AM', '165 Avenue Charles de Gaulle, Neuilly-sur-Seine, France', 'Roissy Charles De Gaulle, Roissy-en-France, France', '', '', '', '', '', '', '', 'asdasd sad sadas', 0, 2, 0, ''),
(39, '2015-03-11 16:11:52', '', 'Mar 11, Wed', '12:00 AM', 'Mar 18, Wed', '12:00 AM', '', '', '', '', '', '', '', '', '', 'asdasd sad sadas', 1, 2, 0, ''),
(40, '2015-03-13 14:50:55', '', 'Mar 13, Fri', '12:10 AM', 'Mar 20, Fri', '11:40 PM', 'Roissy Charles De Gaulle, Roissy-en-France, France', 'Fontainebleau, France', '', '', '', '', '', '123', '', 'Client: MR MICHAEL KATOUNAS\r\n\r\nAller\r\nDate : 29/03/2015 à 20h15\r\n\r\nDépart :\r\nCharles de Gaulle CDG (QR037)\r\nRoissy-en-France (Aéroport) - 95700\r\nArrivée :\r\nHotel Mercure Royal Fontainebleau,41 Rue Royale\r\nFontainebleau - 77300\r\n\r\nPassager(s) : 1\r\nBagage(s) : 1\r\n\r\nEmergency Number:+447900242424', 1, 2, 1, ''),
(41, '2015-03-24 17:24:59', 'Business Car', 'Mar 24, Tue', '12:00 AM', 'Mar 31, Tue', '12:00 AM', '16e Arrondissement, Paris, France', 'Roissy Charles De Gaulle, Roissy-en-France, France', 'asdasd', 'asdasd', '123', 'sadsa', '13123', '213', '', 'Type all the details about your badsadooking here.', 0, 0, 0, ''),
(42, '2015-03-24 17:27:44', 'Business Car', 'Mar 24, Tue', '12:00 AM', 'Mar 31, Tue', '12:00 AM', '185 Avenue Charles de Gaulle, Neuilly-sur-Seine, France', 'Roissy Charles De Gaulle, Roissy-en-France, France', 'asd', 'asdasd', '132', 'asdasd', '1233', '23', '', 'Type all the details about your booking here.asdasd', 0, 2, 0, ''),
(43, '2015-03-24 17:32:14', 'Business Car', 'Mar 24, Tue', '12:00 AM', 'Mar 31, Tue', '12:00 AM', '', '', 'asd', 'asdasd', '132', 'asdasd', '1233', '23', '', 'Type all the details about your booking here.asdasd', 0, 2, 1, ''),
(44, '2015-03-24 17:33:45', 'Luxury Car', 'Mar 24, Tue', '12:10 AM', '', '', '165 Avenue Charles de Gaulle, Neuilly-sur-Seine, France', 'Roissy Charles De Gaulle, Roissy-en-France, France', 'asdsadsad', 'asdadasd', '098lk', 'asdsad@asd.cokm', '123098098', '543', '', 'asdasd asdasdasda s\r\ndsa\r\ndsadasdasdsadasd', 0, 2, 1, ''),
(45, '2015-03-25 17:48:56', 'Luxury Car', 'Mar 25, Wed', '12:10 AM', '', '', '165 Avenue Charles de Gaulle, Neuilly-sur-Seine, France', 'Roissy Charles De Gaulle, Roissy-en-France, France', 'asdsadsad', 'asdadasd', '098lk', 'asdsad@asd.cokm', '123098098', '543', '', 'asdasd asdasdasda s\r\ndsa\r\ndsadasdasdsadasd', 0, 2, 1, ''),
(46, '2015-03-25 17:57:44', 'Luxury Car', 'Mar 25, Wed', '12:10 AM', '', '', '165 Avenue Charles de Gaulle, Neuilly-sur-Seine, France', 'Roissy Charles De Gaulle, Roissy-en-France, France', 'asdsadsad', 'asdadasd', '098lk', 'asdsad@asd.cokm', '123098098', '543', '', 'asdasd asdasdasda s\r\ndsa\r\ndsadasdasdsadasd', 0, 2, 1, ''),
(47, '2015-03-25 18:14:25', 'Luxury Car', 'Mar 25, Wed', '12:10 AM', '', '', '165 Avenue Charles de Gaulle, Neuilly-sur-Seine, France', 'Roissy Charles De Gaulle, Roissy-en-France, France', 'asdsadsad', 'asdadasd', '098lk', 'asdsad@asd.cokm', '123098098', '543', '', 'asdasd asdasdasda s\r\ndsa\r\ndsadasdasdsadasd', 0, 2, 1, ''),
(48, '2015-03-25 18:15:02', 'Luxury Car', 'Mar 25, Wed', '12:10 AM', '', '', '165 Avenue Charles de Gaulle, Neuilly-sur-Seine, France', 'Roissy Charles De Gaulle, Roissy-en-France, France', 'asdsadsad', 'asdadasd', '098lk', 'asdsad@asd.cokm', '123098098', '543', '', 'asdasd asdasdasda s\r\ndsa\r\ndsadasdasdsadasd', 0, 2, 1, ''),
(49, '2015-03-25 18:17:37', 'Luxury Car', 'Mar 25, Wed', '12:10 AM', '', '', '165 Avenue Charles de Gaulle, Neuilly-sur-Seine, France', 'Roissy Charles De Gaulle, Roissy-en-France, France', 'asdsadsad', 'asdadasd', '098lk', 'asdsad@asd.cokm', '123098098', '543', '', 'asdasd asdasdasda s\r\ndsa\r\ndsadasdasdsadasd', 0, 2, 1, ''),
(50, '2015-03-25 18:22:12', 'Luxury Car', 'Mar 25, Wed', '12:10 AM', '', '', '165 Avenue Charles de Gaulle, Neuilly-sur-Seine, France', 'Roissy Charles De Gaulle, Roissy-en-France, France', 'asdsadsad', 'asdadasd', '098lk', 'asdsad@asd.cokm', '123098098', '543', '', 'asdasd asdasdasda s\r\ndsa\r\ndsadasdasdsadasd', 0, 2, 1, ''),
(51, '2015-03-25 18:23:47', 'Luxury Car', 'Mar 25, Wed', '12:10 AM', '', '', '165 Avenue Charles de Gaulle, Neuilly-sur-Seine, France', 'Roissy Charles De Gaulle, Roissy-en-France, France', 'asdsadsad', 'asdadasd', '098lk', 'asdsad@asd.cokm', '123098098', '543', '', 'asdasd asdasdasda s\r\ndsa\r\ndsadasdasdsadasd', 0, 0, 0, ''),
(52, '2015-03-25 18:26:41', 'Luxury Car', 'Mar 25, Wed', '12:10 AM', '', '', '165 Avenue Charles de Gaulle, Neuilly-sur-Seine, France', 'Roissy Charles De Gaulle, Roissy-en-France, France', 'asdsadsad', 'asdadasd', '098lk', 'asdsad@asd.cokm', '123098098', '543', '', 'asdasd asdasdasda s\r\ndsa\r\ndsadasdasdsadasd', 0, 2, 1, ''),
(53, '2015-03-25 18:29:45', 'Luxury Car', 'Mar 25, Wed', '12:10 AM', '', '', '165 Avenue Charles de Gaulle, Neuilly-sur-Seine, France', 'Roissy Charles De Gaulle, Roissy-en-France, France', 'asdsadsad', 'asdadasd', '098lk', 'asdsad@asd.cokm', '123098098', '543', '', 'asdasd asdasdasda s\r\ndsa\r\ndsadasdasdsadasd', 0, 2, 1, ''),
(54, '2015-03-25 18:30:26', 'Luxury Car', 'Mar 25, Wed', '12:10 AM', '', '', '165 Avenue Charles de Gaulle, Neuilly-sur-Seine, France', 'Roissy Charles De Gaulle, Roissy-en-France, France', 'asdsadsad', 'asdadasd', '098lk', 'asdsad@asd.cokm', '123098098', '543', '', 'asdasd asdasdasda s\r\ndsa\r\ndsadasdasdsadasd', 0, 2, 1, ''),
(55, '2015-03-25 18:30:33', 'Luxury Car', 'Mar 25, Wed', '12:10 AM', '', '', '165 Avenue Charles de Gaulle, Neuilly-sur-Seine, France', 'Roissy Charles De Gaulle, Roissy-en-France, France', 'asdsadsad', 'asdadasd', '098lk', 'asdsad@asd.cokm', '123098098', '543', '', 'asdasd asdasdasda s\r\ndsa\r\ndsadasdasdsadasd', 0, 2, 1, ''),
(56, '2015-03-25 18:32:42', 'Luxury Car', 'Mar 25, Wed', '12:10 AM', '', '', '165 Avenue Charles de Gaulle, Neuilly-sur-Seine, France', 'Roissy Charles De Gaulle, Roissy-en-France, France', 'asdsadsad', 'asdadasd', '098lk', 'asdsad@asd.cokm', '123098098', '543', '', 'asdasd asdasdasda s\r\ndsa\r\ndsadasdasdsadasd', 0, 2, 1, ''),
(57, '2015-03-25 18:34:50', 'Luxury Car', 'Mar 25, Wed', '12:10 AM', '', '', '165 Avenue Charles de Gaulle, Neuilly-sur-Seine, France', 'Roissy Charles De Gaulle, Roissy-en-France, France', 'asdsadsad', 'asdadasd', '098lk', 'asdsad@asd.cokm', '123098098', '543', '', 'asdasd asdasdasda s\r\ndsa\r\ndsadasdasdsadasd', 0, 2, 1, ''),
(58, '2015-03-25 18:38:01', 'Luxury Car', 'Mar 25, Wed', '12:10 AM', '', '', '165 Avenue Charles de Gaulle, Neuilly-sur-Seine, France', 'Roissy Charles De Gaulle, Roissy-en-France, France', 'asdsadsad', 'asdadasd', '098lk', 'asdsad@asd.cokm', '123098098', '543', '', 'asdasd asdasdasda s\r\ndsa\r\ndsadasdasdsadasd', 0, 2, 1, ''),
(59, '2015-03-25 18:41:39', 'Luxury Car', 'Mar 25, Wed', '12:10 AM', '', '', '165 Avenue Charles de Gaulle, Neuilly-sur-Seine, France', 'Roissy Charles De Gaulle, Roissy-en-France, France', 'asdsadsad', 'asdadasd', '098lk', 'asdsad@asd.cokm', '123098098', '543', '', 'asdasd asdasdasda s\r\ndsa\r\ndsadasdasdsadasd', 0, 2, 1, ''),
(60, '2015-03-25 18:47:06', 'Luxury Car', 'Mar 25, Wed', '12:10 AM', '', '', '165 Avenue Charles de Gaulle, Neuilly-sur-Seine, France', 'Roissy Charles De Gaulle, Roissy-en-France, France', 'asdsadsad', 'asdadasd', '098lk', 'asdsad@asd.cokm', '123098098', '543', '', 'asdasd asdasdasda s\r\ndsa\r\ndsadasdasdsadasd', 0, 2, 1, ''),
(61, '2015-03-25 18:47:38', 'Luxury Car', 'Mar 25, Wed', '12:10 AM', '', '', '165 Avenue Charles de Gaulle, Neuilly-sur-Seine, France', 'Roissy Charles De Gaulle, Roissy-en-France, France', 'asdsadsad', 'asdadasd', '098lk', 'asdsad@asd.cokm', '123098098', '543', '', 'asdasd asdasdasda s\r\ndsa\r\ndsadasdasdsadasd', 0, 2, 1, ''),
(62, '2015-03-25 18:49:42', 'Luxury Car', 'Mar 25, Wed', '12:10 AM', '', '', '165 Avenue Charles de Gaulle, Neuilly-sur-Seine, France', 'Roissy Charles De Gaulle, Roissy-en-France, France', 'asdsadsad', 'asdadasd', '098lk', 'asdsad@asd.cokm', '123098098', '543', '', 'asdasd asdasdasda s\r\ndsa\r\ndsadasdasdsadasd', 0, 2, 1, ''),
(63, '2015-03-25 18:53:11', 'Luxury Car', 'Mar 25, Wed', '12:10 AM', '', '', '165 Avenue Charles de Gaulle, Neuilly-sur-Seine, France', 'Roissy Charles De Gaulle, Roissy-en-France, France', 'asdsadsad', 'asdadasd', '098lk', 'asdsad@asd.cokm', '123098098', '543', '', 'asdasd asdasdasda s\r\ndsa\r\ndsadasdasdsadasd', 0, 2, 1, ''),
(64, '2015-03-25 18:56:37', 'Luxury Car', 'Mar 25, Wed', '12:10 AM', '', '', '165 Avenue Charles de Gaulle, Neuilly-sur-Seine, France', 'Roissy Charles De Gaulle, Roissy-en-France, France', 'asdsadsad', 'asdadasd', '098lk', 'asdsad@asd.cokm', '123098098', '543', '', 'asdasd asdasdasda s\r\ndsa\r\ndsadasdasdsadasd', 0, 0, 0, ''),
(65, '2015-03-25 18:56:45', 'Luxury Car', 'Mar 25, Wed', '12:10 AM', '', '', '165 Avenue Charles de Gaulle, Neuilly-sur-Seine, France', 'Roissy Charles De Gaulle, Roissy-en-France, France', 'asdsadsad', 'asdadasd', '098lk', 'asdsad@asd.cokm', '123098098', '543', '', 'asdasd asdasdasda s\r\ndsa\r\ndsadasdasdsadasd', 0, 0, 0, ''),
(66, '2015-03-25 18:58:44', 'Luxury Car', 'Mar 25, Wed', '12:10 AM', '', '', '165 Avenue Charles de Gaulle, Neuilly-sur-Seine, France', 'Roissy Charles De Gaulle, Roissy-en-France, France', 'asdsadsad', 'asdadasd', '098lk', 'asdsad@asd.cokm', '123098098', '543', '', 'asdasd asdasdasda s\r\ndsa\r\ndsadasdasdsadasd', 0, 2, 1, ''),
(67, '2015-03-25 18:58:47', 'Luxury Car', 'Mar 25, Wed', '12:10 AM', '', '', '165 Avenue Charles de Gaulle, Neuilly-sur-Seine, France', 'Roissy Charles De Gaulle, Roissy-en-France, France', 'asdsadsad', 'asdadasd', '098lk', 'asdsad@asd.cokm', '123098098', '543', '', 'asdasd asdasdasda s\r\ndsa\r\ndsadasdasdsadasd', 0, 2, 1, ''),
(68, '2015-03-25 18:59:51', 'Luxury Car', 'Mar 25, Wed', '12:10 AM', '', '', '165 Avenue Charles de Gaulle, Neuilly-sur-Seine, France', 'Roissy Charles De Gaulle, Roissy-en-France, France', 'asdsadsad', 'asdadasd', '098lk', 'asdsad@asd.cokm', '123098098', '543', '', 'asdasd asdasdasda s\r\ndsa\r\ndsadasdasdsadasd', 0, 2, 1, ''),
(69, '2015-03-25 19:00:34', 'Luxury Car', 'Mar 25, Wed', '12:10 AM', '', '', '165 Avenue Charles de Gaulle, Neuilly-sur-Seine, France', 'Roissy Charles De Gaulle, Roissy-en-France, France', 'asdsadsad', 'asdadasd', '098lk', 'asdsad@asd.cokm', '123098098', '543', '', 'asdasd asdasdasda s\r\ndsa\r\ndsadasdasdsadasd', 0, 2, 1, ''),
(70, '2015-03-25 19:02:01', 'Luxury Car', 'Mar 25, Wed', '12:10 AM', '', '', '165 Avenue Charles de Gaulle, Neuilly-sur-Seine, France', 'Roissy Charles De Gaulle, Roissy-en-France, France', 'asdsadsad', 'asdadasd', '098lk', 'asdsad@asd.cokm', '123098098', '543', '', 'asdasd asdasdasda s\r\ndsa\r\ndsadasdasdsadasd', 17, 2, 1, ''),
(71, '2015-03-25 19:02:55', 'Luxury Car', 'Mar 25, Wed', '12:10 AM', '', '', '165 Avenue Charles de Gaulle, Neuilly-sur-Seine, France', 'Roissy Charles De Gaulle, Roissy-en-France, France', 'asdsadsad', 'asdadasd', '098lk', 'asdsad@asd.cokm', '123098098', '543', '', 'asdasd asdasdasda s\r\ndsa\r\ndsadasdasdsadasd', 0, 2, 0, ''),
(72, '2015-03-27 17:49:54', '', 'Mar 27, Fri', '12:00 AM', 'Apr 3, Fri', '12:00 AM', 'Calle de Santander, 16, Arroyomolinos, Espagne', 'Madrid-Barajas Airport, Madrid, Espagne', '', '', '', '', '', '', '', 'Type all the details about your booking here.', 1, 2, 0, ''),
(73, '2015-03-29 16:50:00', 'Economy Car', 'Mar 29, Sun', '12:00 AM', '', '', 'Roissy Charles De Gaulle, Roissy-en-France, France', 'Paroisse Saint-Francois de Sales, Rue Bremontier, Paris, France', 'asdsad', 'asdsa', 'sadsad', 'sadasd', 'asdsad', '123', '', 'sadasd', 0, 2, 1, ''),
(74, '2015-03-29 17:40:40', 'Economy Car', 'Mar 29, Sun', '12:00 AM', 'Apr 5, Sun', '12:00 AM', '55 Rue Victor Hugo, Courbevoie, France', '87 Rue de Richelieu, Paris, France', 'asdasd', 'sad', 'sadasd', 'sadsad', 'asdsad', '33', '', 'asdasd', 0, 2, 0, ''),
(75, '2015-03-29 17:51:11', '', 'Mar 29, Sun', '12:00 AM', '', '', '56 Rue de Lille, Paris, France', 'Charles de Gaulle Airport, Roissy-en-France, France', '', '', '', '', '', '', '', 'asdsadasd', 1, 2, 0, ''),
(76, '2015-03-29 18:07:32', '', 'Mar 29, Sun', '12:00 AM', 'Apr 5, Sun', '12:00 AM', '34 Rue des Rosiers, Paris, France', 'Charles de Gaulle Airport, Roissy-en-France, France', '', '', '', '', '', '', '', 'sdadsadadasdad', 1, 2, 0, ''),
(77, '2015-03-29 18:11:07', '', 'Mar 29, Sun', '12:00 AM', 'Apr 5, Sun', '12:00 AM', 'Asnières-sur-Seine, France', 'Disneyland Paris, Marne-la-Vallée, France', '', '', '', '', '', '', '', 'ASs', 1, 2, 0, ''),
(78, '2015-03-29 18:13:06', '', 'Mar 29, Sun', '12:00 AM', 'Apr 5, Sun', '12:00 AM', '43 Rue de Caumartin, Paris, France', 'Charles de Gaulle Airport, Roissy-en-France, France', '', '', '', '', '', '', '', 'asdasdasda', 1, 2, 0, ''),
(79, '2015-03-29 18:17:00', 'Bus/Coach', 'Mar 30, Mon', '12:00 AM', ' - ', ' - ', '23 Rue Rambuteau, Paris, France', 'Aéroport Charles de Gaulle 2 - TGV, Tremblay-en-France, France', 'asdasd', 'asdasd', '123', 'asdas', '231323', '3444', '', 'LA JE NIK TOUT', 0, 2, 1, ''),
(80, '2015-03-29 18:27:22', 'Economy Van', 'Mar 29, Sun', '12:00 AM', '', '', '23 Rue Rambuteau, Paris, France', 'Aéroport Charles de Gaulle 2 - TGV, Tremblay-en-France, France', 'asdsad', 'asdsa', '13123', 'asdsad', '212313', '34', '', 'asdsadasd', 0, 2, 0, ''),
(81, '2015-03-30 20:02:28', 'Economy Car', 'Mar 30, Mon', '12:00 AM', 'Apr 6, Mon', '12:00 AM', 'Roissy Charles De Gaulle, Roissy-en-France, France', '165 Rue de Rome, Paris, France', 'asdsad', 'asdsad', 'asdsad', 'asdsad', 'asdasd', '123', '', 'asdasdasd', 0, 2, 1, ''),
(82, '2015-03-30 20:04:14', 'Economy Car', 'Mar 30, Mon', '12:00 AM', 'Apr 6, Mon', '12:00 AM', 'Roissy Charles De Gaulle, Roissy-en-France, France', '165 Avenue Charles de Gaulle, Neuilly-sur-Seine, France', 'asdsad', 'asdsad', 'asdsad', 'asdsad', 'asdasd', '123', '', 'asdasdasd', 17, 2, 1, ''),
(83, '2015-03-30 20:04:46', 'Economy Car', 'Mar 30, Mon', '12:00 AM', 'Apr 6, Mon', '12:00 AM', 'Roissy Charles De Gaulle, Roissy-en-France, France', '165 Rue de Rome, Paris, France', 'asdsad', 'asdsad', 'asdsad', 'asdsad', 'asdasd', '123', '', 'asdasdasd', 0, 2, 1, ''),
(84, '2015-03-30 21:52:14', 'Business Car', 'Mar 30, Mon', '12:00 AM', '', '', '23 Rue Rambuteau, Paris, France', 'Aéroport Charles de Gaulle 2 - TGV, Tremblay-en-France, France', 'asda', 'sdsad', '123', 'asdsad', '1231', '54', '', 'ca va marcher ca?', 17, 2, 1, ''),
(85, '2015-03-31 16:33:13', 'Economy Van', 'Mar 31, Tue', '12:00 AM', 'Apr 7, Tue', '12:00 AM', '265 Boulevard Pereire, Paris, France', 'Roissy Charles De Gaulle, Roissy-en-France, France', 'asdasd', 'asdasd', '1233', 'asdsda', '21321', '433', '', 'asdsad sadsa das sad asdsasadsa asdsa addd', 0, 2, 1, ''),
(86, '2015-04-03 16:17:07', 'Transfer - Economy car', '03-04-2015', '00:00', '10-04-2015', '00:00', 'Paris, France', 'Paris, France', '', '', '', '', '', '60', '', '', 0, 0, 0, ''),
(87, '2015-04-03 16:17:42', 'Transfer - Economy car', '2015-04-03', '16:16:28', '', '', 'CDG Charles De Gaulle Airport, Roissy-en-France, France', '3 Rue Caulaincourt, 75018 Paris, France', '', '', '', '', '', '60', '', '', 0, 0, 0, ''),
(88, '2015-04-07 16:55:52', 'Transfer - Economy car', '8 Apr 2015', '1:15 AM', '15 Apr 2015', '12:50 AM', 'Nanagatan 43, Stockholm, Sweden', 'Sankt Eriksplan 6B, Stockholm, Sweden', 'asdasd', 'asdasd', '2132', 'asd', '213123', '60', '', 'kkk', 0, 2, 1, ''),
(89, '2015-11-13 15:37:30', '', '24 Nov 2015', '12:00 AM', '', '', 'Aéroport Charles de Gaulle 1, Tremblay-en-France, France', '876 Boulevard Bileau, Neuilly-sur-Seine, France', '', '', '', '', '', '', '', 'Pour 2 personnes, classe business il faut', 1, 2, 0, ''),
(105, '2015-12-05 18:00:48', 'Transfer - Economy Car', '05 Dec 2015', '00:00', '12 Dec 2015', '00:00', '165 Boulevard Voltaire, Paris, France', 'Aéroport Charles de Gaulle 1, Tremblay-en-France, France', 'Nikcha', 'Edelschauff', '', 'qsdqsd@hotmail.com', '0687564398', '50', '', '', 2, 2, 0, 'Mercedes Benz Classe C'),
(106, '2015-12-05 18:03:45', 'Transfer - Economy Car', '05 Dec 2015', '00:00', '', '', '165 Boulevard Voltaire, Paris, France', 'Aéroport Charles de Gaulle 1, Tremblay-en-France, France', 'Nikcha', 'Edelschauff', '', 'qsdqsd@hotmail.com', '0687564398', '25', '', '', 2, 2, 0, 'Not Specified'),
(107, '2015-12-05 18:04:18', 'Transfer - Economy Car', '05 Dec 2015', '00:00', '', '', '165 Boulevard Voltaire, Paris, France', 'Aéroport Charles de Gaulle 1, Tremblay-en-France, France', 'Nikcha', 'Edelschauff', 'SK578', 'qsdqsd@hotmail.com', '0687564398', '25', '', 'sadasd ad sadlksajd asdsaklj ', 2, 2, 0, 'Not Specified'),
(108, '2015-12-05 18:05:31', 'Transfer - Economy Car', '05 Dec 2015', '00:00', '', '', '165 Boulevard Voltaire, Paris, France', 'Aéroport Charles de Gaulle 1, Tremblay-en-France, France', 'Nikcha', 'Edelschauff', '', 'qsdqsd@hotmail.com', '0687564398', '25', '', '', 2, 2, 0, 'Mercedes Benz Classe C'),
(109, '2015-12-05 18:11:00', 'Transfer - Economy Car', '05 Dec 2015', '00:00', '', '', '165 Boulevard Voltaire, Paris, France', 'Aéroport Charles de Gaulle 1, Tremblay-en-France, France', 'Nikcha', 'Edelschauff', '', 'qsdqsd@hotmail.com', '0687564398', '25', '', '', 2, 2, 0, 'Mercedes Benz Classe C'),
(110, '2015-12-05 18:31:52', 'Transfer - Economy Car', '05 Dec 2015', '00:00', '', '', '165 Boulevard Voltaire, Paris, France', 'Aéroport Charles de Gaulle 1, Tremblay-en-France, France', 'Nikcha', 'Edelschauff', '', 'qsdqsd@hotmail.com', 'Edelschauff', '25', '', '', 2, 2, 0, 'Mercedes Benz Classe C'),
(111, '2015-12-05 18:33:59', 'Transfer - Economy Car', '05 Dec 2015', '22:15', '', '', '165 Boulevard Voltaire, Paris, France', 'Aéroport Charles de Gaulle 1, Tremblay-en-France, France', 'Nikcha', 'Edelschauff', 'kjhk', 'qsdqsd@hotmail.com', 'Edelschauff', '25', '', 'jyfn jgk h khjhk', 2, 2, 0, 'Not Specified'),
(112, '2015-12-05 18:35:06', 'Transfer - Economy Car', '05 Dec 2015', '00:00', '12 Dec 2015', '00:00', '2 Rue de l''Alma, Courbevoie, France', 'Orly-Ouest, Paray-Vieille-Poste, France', 'Nikcha', 'Edelschauff', 'kljl', 'qsdqsd@hotmail.com', 'Edelschauff', '106', '', 'htgfhgfh fgfh g', 1, 2, 0, ' BMW série 5'),
(113, '2015-12-07 13:55:50', 'Transfer - Economy Car', '07 Dec 2015', '00:00', '', '', '165 Boulevard Haussmann, Paris, France', 'Aéroport Charles de Gaulle 1, Tremblay-en-France, France', 'Nikcha', 'Edelschauff', '', 'qsdqsd@hotmail.com', '0687564398', '26', '', '', 2, 2, 1, 'Not Specified');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
