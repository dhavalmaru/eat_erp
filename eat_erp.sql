-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 03, 2016 at 09:34 AM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `eat_erp`
--

-- --------------------------------------------------------

--
-- Table structure for table `bar_to_box`
--

CREATE TABLE IF NOT EXISTS `bar_to_box` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_of_processing` date DEFAULT NULL,
  `depot_id` int(11) DEFAULT NULL,
  `qty` float DEFAULT NULL,
  `grams` float DEFAULT NULL,
  `amount` float DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  `remarks` varchar(1000) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `modified_on` datetime DEFAULT NULL,
  `approved_by` int(11) DEFAULT NULL,
  `approved_on` datetime DEFAULT NULL,
  `rejected_by` int(11) DEFAULT NULL,
  `rejected_on` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `bar_to_box_qty`
--

CREATE TABLE IF NOT EXISTS `bar_to_box_qty` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bar_to_box_id` int(11) DEFAULT NULL,
  `box_id` int(11) DEFAULT NULL,
  `qty` float DEFAULT NULL,
  `grams` float DEFAULT NULL,
  `rate` float DEFAULT NULL,
  `amount` float DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `batch_processing`
--

CREATE TABLE IF NOT EXISTS `batch_processing` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `batch_id_as_per_fssai` varchar(100) DEFAULT NULL,
  `date_of_processing` date DEFAULT NULL,
  `depot_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `qty_in_bar` float DEFAULT NULL,
  `actual_wastage` float DEFAULT NULL,
  `wastage_percent` float DEFAULT NULL,
  `anticipated_wastage` float DEFAULT NULL,
  `wastage_variance` float DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  `remarks` varchar(1000) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `modified_on` datetime DEFAULT NULL,
  `approved_by` int(11) DEFAULT NULL,
  `approved_on` datetime DEFAULT NULL,
  `rejected_by` int(11) DEFAULT NULL,
  `rejected_on` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `batch_raw_material`
--

CREATE TABLE IF NOT EXISTS `batch_raw_material` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `batch_processing_id` int(11) DEFAULT NULL,
  `raw_material_id` int(11) DEFAULT NULL,
  `qty` float DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `box_master`
--

CREATE TABLE IF NOT EXISTS `box_master` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `box_name` varchar(255) DEFAULT NULL,
  `barcode` varchar(100) DEFAULT NULL,
  `grams` float DEFAULT NULL,
  `rate` float DEFAULT NULL,
  `amount` float DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  `remarks` varchar(1000) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `modified_on` datetime DEFAULT NULL,
  `approved_by` int(11) DEFAULT NULL,
  `approved_on` datetime DEFAULT NULL,
  `rejected_by` int(11) DEFAULT NULL,
  `rejected_on` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `box_product`
--

CREATE TABLE IF NOT EXISTS `box_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `box_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `qty` float DEFAULT NULL,
  `grams` float DEFAULT NULL,
  `rate` float DEFAULT NULL,
  `amount` float DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `box_to_bar`
--

CREATE TABLE IF NOT EXISTS `box_to_bar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_of_processing` date DEFAULT NULL,
  `depot_id` int(11) DEFAULT NULL,
  `qty` float DEFAULT NULL,
  `grams` float DEFAULT NULL,
  `amount` float DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  `remarks` varchar(1000) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `modified_on` datetime DEFAULT NULL,
  `approved_by` int(11) DEFAULT NULL,
  `approved_on` datetime DEFAULT NULL,
  `rejected_by` int(11) DEFAULT NULL,
  `rejected_on` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `box_to_bar_qty`
--

CREATE TABLE IF NOT EXISTS `box_to_bar_qty` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `box_to_bar_id` int(11) DEFAULT NULL,
  `box_id` int(11) DEFAULT NULL,
  `qty` float DEFAULT NULL,
  `grams` float DEFAULT NULL,
  `rate` float DEFAULT NULL,
  `amount` float DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `city_master`
--

CREATE TABLE IF NOT EXISTS `city_master` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `city_name` varchar(256) DEFAULT NULL,
  `state_id` text,
  `status` int(1) NOT NULL DEFAULT '0',
  `created_by` int(11) DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `modified_on` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `country_master`
--

CREATE TABLE IF NOT EXISTS `country_master` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `country_code` varchar(256) NOT NULL,
  `country_name` varchar(256) NOT NULL,
  `date` varchar(256) NOT NULL,
  `time` varchar(256) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(1) NOT NULL DEFAULT '0',
  `create_date` date NOT NULL,
  `create_time` time NOT NULL,
  `created_by` int(11) NOT NULL,
  `ip_addrs` varchar(1000) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `depot_master`
--

CREATE TABLE IF NOT EXISTS `depot_master` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `depot_name` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `pincode` varchar(100) DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `email_id` varchar(100) DEFAULT NULL,
  `mobile` varchar(100) DEFAULT NULL,
  `contact_person` varchar(255) DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  `remarks` varchar(1000) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `modified_on` datetime DEFAULT NULL,
  `approved_by` int(11) DEFAULT NULL,
  `approved_on` datetime DEFAULT NULL,
  `rejected_by` int(11) DEFAULT NULL,
  `rejected_on` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `depot_transfer`
--

CREATE TABLE IF NOT EXISTS `depot_transfer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_of_transfer` date DEFAULT NULL,
  `depot_out_id` int(11) DEFAULT NULL,
  `depot_in_id` int(11) DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  `remarks` varchar(1000) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `modified_on` datetime DEFAULT NULL,
  `approved_by` int(11) DEFAULT NULL,
  `approved_on` datetime DEFAULT NULL,
  `rejected_by` int(11) DEFAULT NULL,
  `rejected_on` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `depot_transfer_items`
--

CREATE TABLE IF NOT EXISTS `depot_transfer_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `depot_transfer_id` int(11) DEFAULT NULL,
  `type` varchar(100) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `qty` float DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `distributor_in`
--

CREATE TABLE IF NOT EXISTS `distributor_in` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_of_processing` date DEFAULT NULL,
  `depot_id` int(11) DEFAULT NULL,
  `distributor_id` int(11) DEFAULT NULL,
  `sales_rep_id` int(11) DEFAULT NULL,
  `amount` float DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  `remarks` varchar(1000) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `modified_on` datetime DEFAULT NULL,
  `approved_by` int(11) DEFAULT NULL,
  `approved_on` datetime DEFAULT NULL,
  `rejected_by` int(11) DEFAULT NULL,
  `rejected_on` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `distributor_invoice_details`
--

CREATE TABLE IF NOT EXISTS `distributor_invoice_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `distributor_out_id` int(11) DEFAULT NULL,
  `invoice_no` varchar(100) DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  `remarks` varchar(1000) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `modified_on` datetime DEFAULT NULL,
  `approved_by` int(11) DEFAULT NULL,
  `approved_on` datetime DEFAULT NULL,
  `rejected_by` int(11) DEFAULT NULL,
  `rejected_on` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `distributor_in_items`
--

CREATE TABLE IF NOT EXISTS `distributor_in_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `distributor_in_id` int(11) DEFAULT NULL,
  `type` varchar(100) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `qty` float DEFAULT NULL,
  `sell_rate` float DEFAULT NULL,
  `grams` float DEFAULT NULL,
  `rate` float DEFAULT NULL,
  `amount` float DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `distributor_master`
--

CREATE TABLE IF NOT EXISTS `distributor_master` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `distributor_name` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `pincode` varchar(100) DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `email_id` varchar(100) DEFAULT NULL,
  `mobile` varchar(100) DEFAULT NULL,
  `tin_number` varchar(100) DEFAULT NULL,
  `cst_number` varchar(100) DEFAULT NULL,
  `contact_person` varchar(255) DEFAULT NULL,
  `sales_rep_id` int(11) DEFAULT NULL,
  `sell_out` float DEFAULT NULL,
  `send_invoice` int(11) DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  `remarks` varchar(1000) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `modified_on` datetime DEFAULT NULL,
  `approved_by` int(11) DEFAULT NULL,
  `approved_on` datetime DEFAULT NULL,
  `rejected_by` int(11) DEFAULT NULL,
  `rejected_on` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `distributor_out`
--

CREATE TABLE IF NOT EXISTS `distributor_out` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_of_processing` date DEFAULT NULL,
  `depot_id` int(11) DEFAULT NULL,
  `distributor_id` int(11) DEFAULT NULL,
  `sales_rep_id` int(11) DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `cst_amount` double DEFAULT NULL,
  `final_amount` double DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  `remarks` varchar(1000) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `modified_on` datetime DEFAULT NULL,
  `approved_by` int(11) DEFAULT NULL,
  `approved_on` datetime DEFAULT NULL,
  `rejected_by` int(11) DEFAULT NULL,
  `rejected_on` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `distributor_out_items`
--

CREATE TABLE IF NOT EXISTS `distributor_out_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `distributor_out_id` int(11) DEFAULT NULL,
  `type` varchar(100) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `qty` float DEFAULT NULL,
  `sell_rate` float DEFAULT NULL,
  `grams` float DEFAULT NULL,
  `rate` float DEFAULT NULL,
  `amount` float DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `distributor_payment_details`
--

CREATE TABLE IF NOT EXISTS `distributor_payment_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `distributor_out_id` int(11) DEFAULT NULL,
  `payment_mode` varchar(100) DEFAULT NULL,
  `ref_no` varchar(100) DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `payment_amount` double DEFAULT NULL,
  `deposit_date` date DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  `remarks` varchar(1000) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `modified_on` datetime DEFAULT NULL,
  `approved_by` int(11) DEFAULT NULL,
  `approved_on` datetime DEFAULT NULL,
  `rejected_by` int(11) DEFAULT NULL,
  `rejected_on` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `distributor_transfer`
--

CREATE TABLE IF NOT EXISTS `distributor_transfer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_of_transfer` date DEFAULT NULL,
  `distributor_out_id` int(11) DEFAULT NULL,
  `distributor_in_id` int(11) DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  `remarks` varchar(1000) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `modified_on` datetime DEFAULT NULL,
  `approved_by` int(11) DEFAULT NULL,
  `approved_on` datetime DEFAULT NULL,
  `rejected_by` int(11) DEFAULT NULL,
  `rejected_on` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `distributor_transfer_items`
--

CREATE TABLE IF NOT EXISTS `distributor_transfer_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `distributor_transfer_id` int(11) DEFAULT NULL,
  `type` varchar(100) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `qty` float DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `document_details`
--

CREATE TABLE IF NOT EXISTS `document_details` (
  `doc_id` int(11) NOT NULL AUTO_INCREMENT,
  `doc_ref_name` varchar(255) DEFAULT NULL,
  `doc_ref_id` int(11) DEFAULT NULL,
  `doc_ref_type` varchar(100) DEFAULT NULL,
  `doc_type_id` int(11) DEFAULT NULL,
  `doc_doc_id` int(11) DEFAULT NULL,
  `doc_description` varchar(500) DEFAULT NULL,
  `doc_ref_no` varchar(500) DEFAULT NULL,
  `doc_doi` date DEFAULT NULL,
  `doc_doe` date DEFAULT NULL,
  `doc_document` varchar(500) DEFAULT NULL,
  `document_name` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`doc_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `document_master`
--

CREATE TABLE IF NOT EXISTS `document_master` (
  `d_id` int(11) NOT NULL AUTO_INCREMENT,
  `d_documentname` varchar(100) DEFAULT NULL,
  `d_description` varchar(100) DEFAULT NULL,
  `d_status` varchar(100) DEFAULT NULL,
  `d_type` varchar(100) DEFAULT NULL,
  `d_show_expiry_date` varchar(100) DEFAULT NULL,
  `d_t_type` varchar(100) DEFAULT NULL,
  `d_cat_individual` varchar(100) DEFAULT NULL,
  `d_cat_huf` varchar(100) DEFAULT NULL,
  `d_cat_privateltd` varchar(100) DEFAULT NULL,
  `d_cat_limited` varchar(100) DEFAULT NULL,
  `d_cat_lpp` varchar(100) DEFAULT NULL,
  `d_cat_partnership` varchar(100) DEFAULT NULL,
  `d_cat_aop` varchar(100) DEFAULT NULL,
  `d_cat_trust` varchar(100) DEFAULT NULL,
  `d_cat_proprietorship` varchar(100) DEFAULT NULL,
  `d_type_apartment` varchar(100) DEFAULT NULL,
  `d_type_bunglow` varchar(100) DEFAULT NULL,
  `d_type_commercial` varchar(100) DEFAULT NULL,
  `d_type_retail` varchar(100) DEFAULT NULL,
  `d_type_industry` varchar(100) DEFAULT NULL,
  `d_type_landagriculture` varchar(100) DEFAULT NULL,
  `d_type_landnonagricultural` varchar(100) DEFAULT NULL,
  `d_add_date` date DEFAULT NULL,
  `d_gid` int(11) DEFAULT NULL,
  `d_type_building` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`d_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `document_types`
--

CREATE TABLE IF NOT EXISTS `document_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `d_id` int(11) DEFAULT NULL,
  `d_type_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `document_type_master`
--

CREATE TABLE IF NOT EXISTS `document_type_master` (
  `d_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `d_type` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `d_m_status` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `d_type_add_date` date DEFAULT NULL,
  `d_type_gid` int(11) DEFAULT NULL,
  PRIMARY KEY (`d_type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `product_master`
--

CREATE TABLE IF NOT EXISTS `product_master` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_name` varchar(255) DEFAULT NULL,
  `barcode` varchar(100) DEFAULT NULL,
  `grams` float DEFAULT NULL,
  `rate` float DEFAULT NULL,
  `tax` varchar(255) DEFAULT NULL,
  `anticipated_wastage` float DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  `remarks` varchar(1000) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `modified_on` datetime DEFAULT NULL,
  `approved_by` int(11) DEFAULT NULL,
  `approved_on` datetime DEFAULT NULL,
  `rejected_by` int(11) DEFAULT NULL,
  `rejected_on` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `raw_material_in`
--

CREATE TABLE IF NOT EXISTS `raw_material_in` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_of_receipt` date DEFAULT NULL,
  `vendor_id` int(11) DEFAULT NULL,
  `depot_id` int(11) DEFAULT NULL,
  `vat` float DEFAULT NULL,
  `cst` float DEFAULT NULL,
  `excise` float DEFAULT NULL,
  `final_amount` float DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  `remarks` varchar(1000) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `modified_on` datetime DEFAULT NULL,
  `approved_by` int(11) DEFAULT NULL,
  `approved_on` datetime DEFAULT NULL,
  `rejected_by` int(11) DEFAULT NULL,
  `rejected_on` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `raw_material_master`
--

CREATE TABLE IF NOT EXISTS `raw_material_master` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rm_name` varchar(255) DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  `remarks` varchar(1000) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `modified_on` datetime DEFAULT NULL,
  `approved_by` int(11) DEFAULT NULL,
  `approved_on` datetime DEFAULT NULL,
  `rejected_by` int(11) DEFAULT NULL,
  `rejected_on` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `raw_material_stock`
--

CREATE TABLE IF NOT EXISTS `raw_material_stock` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `raw_material_in_id` int(11) DEFAULT NULL,
  `raw_material_id` int(11) DEFAULT NULL,
  `qty` float DEFAULT NULL,
  `rate` float DEFAULT NULL,
  `amount` float DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `report_roles`
--

CREATE TABLE IF NOT EXISTS `report_roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rep_id` int(11) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  `rep_view` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `modified_on` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sales_rep_master`
--

CREATE TABLE IF NOT EXISTS `sales_rep_master` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sales_rep_name` varchar(255) DEFAULT NULL,
  `pan_no` varchar(255) DEFAULT NULL,
  `email_id` varchar(100) DEFAULT NULL,
  `mobile` varchar(100) DEFAULT NULL,
  `kyc_done` int(11) DEFAULT NULL,
  `teritory` varchar(255) DEFAULT NULL,
  `target_pm` float DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  `remarks` varchar(1000) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `modified_on` datetime DEFAULT NULL,
  `approved_by` int(11) DEFAULT NULL,
  `approved_on` datetime DEFAULT NULL,
  `rejected_by` int(11) DEFAULT NULL,
  `rejected_on` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `series_master`
--

CREATE TABLE IF NOT EXISTS `series_master` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(100) DEFAULT NULL,
  `series` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `state_master`
--

CREATE TABLE IF NOT EXISTS `state_master` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `state_name` varchar(256) NOT NULL,
  `country_id` int(11) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '0',
  `create_date` date NOT NULL,
  `create_time` time NOT NULL,
  `created_by` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tax_master`
--

CREATE TABLE IF NOT EXISTS `tax_master` (
  `tax_id` int(11) NOT NULL AUTO_INCREMENT,
  `tax_name` varchar(200) DEFAULT NULL,
  `tax_percent` float DEFAULT NULL,
  `txn_type` varchar(100) DEFAULT NULL,
  `tax_action` int(2) DEFAULT NULL,
  `effective_date` date DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `create_date` date DEFAULT NULL,
  `modified_by` varchar(100) DEFAULT NULL,
  `modified_date` date DEFAULT NULL,
  `purpose` varchar(100) DEFAULT NULL,
  `status` int(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`tax_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user_access_log`
--

CREATE TABLE IF NOT EXISTS `user_access_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `module_name` varchar(100) DEFAULT NULL,
  `controller_name` varchar(256) DEFAULT NULL,
  `action` varchar(256) DEFAULT NULL,
  `table_id` int(11) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user_master`
--

CREATE TABLE IF NOT EXISTS `user_master` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(100) DEFAULT NULL,
  `middle_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `company` varchar(100) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `anniversary_date` date DEFAULT NULL,
  `gender` varchar(100) DEFAULT NULL,
  `designation` varchar(100) DEFAULT NULL,
  `guardian` varchar(100) DEFAULT NULL,
  `relation` varchar(100) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `landmark` varchar(100) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `pincode` varchar(100) DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `email_id1` varchar(100) DEFAULT NULL,
  `email_id2` varchar(100) DEFAULT NULL,
  `password` varchar(100) NOT NULL DEFAULT 'pass@123',
  `role_id` int(11) DEFAULT NULL,
  `mobile1` varchar(100) DEFAULT NULL,
  `mobile2` varchar(100) DEFAULT NULL,
  `pan_card` varchar(50) DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  `remarks` varchar(1000) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `modified_on` datetime DEFAULT NULL,
  `approved_by` int(11) DEFAULT NULL,
  `approved_on` datetime DEFAULT NULL,
  `rejected_by` int(11) DEFAULT NULL,
  `rejected_on` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user_role_master`
--

CREATE TABLE IF NOT EXISTS `user_role_master` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(100) DEFAULT NULL,
  `description` varchar(500) DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `modified_on` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user_role_options`
--

CREATE TABLE IF NOT EXISTS `user_role_options` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) DEFAULT NULL,
  `section` varchar(100) DEFAULT NULL,
  `r_view` int(11) DEFAULT NULL,
  `r_insert` int(11) DEFAULT NULL,
  `r_edit` int(11) DEFAULT NULL,
  `r_delete` int(11) DEFAULT NULL,
  `r_approvals` int(11) DEFAULT NULL,
  `r_export` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `vendor_master`
--

CREATE TABLE IF NOT EXISTS `vendor_master` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vendor_name` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `pincode` varchar(100) DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `email_id` varchar(100) DEFAULT NULL,
  `mobile` varchar(100) DEFAULT NULL,
  `contact_person` varchar(255) DEFAULT NULL,
  `tin_number` varchar(100) DEFAULT NULL,
  `cst_number` varchar(100) DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  `remarks` varchar(1000) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `modified_on` datetime DEFAULT NULL,
  `approved_by` int(11) DEFAULT NULL,
  `approved_on` datetime DEFAULT NULL,
  `rejected_by` int(11) DEFAULT NULL,
  `rejected_on` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
