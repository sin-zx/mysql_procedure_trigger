/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50709
Source Host           : localhost:3306
Source Database       : rbms

Target Server Type    : MYSQL
Target Server Version : 50709
File Encoding         : 65001

Date: 2016-06-13 11:27:09
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for customers
-- ----------------------------
DROP TABLE IF EXISTS `customers`;
CREATE TABLE `customers` (
  `cid` int(11) NOT NULL AUTO_INCREMENT,
  `cname` varchar(15) DEFAULT NULL,
  `city` varchar(15) DEFAULT NULL,
  `visits_made` int(5) DEFAULT NULL,
  `last_visit_time` datetime DEFAULT NULL,
  PRIMARY KEY (`cid`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of customers
-- ----------------------------
INSERT INTO `customers` VALUES ('1', 'Kathy', 'Vestal', '2', '2013-11-28 10:25:32');
INSERT INTO `customers` VALUES ('2', 'Brown', 'Binghamton', '1', '2013-12-05 09:12:30');
INSERT INTO `customers` VALUES ('3', 'Anne', 'Vestal', '1', '2013-11-29 14:30:00');
INSERT INTO `customers` VALUES ('4', 'Jack', 'Vestal', '1', '2013-12-04 16:48:02');
INSERT INTO `customers` VALUES ('5', 'Mike', 'Binghamton', '1', '2013-11-30 11:52:16');

-- ----------------------------
-- Table structure for employees
-- ----------------------------
DROP TABLE IF EXISTS `employees`;
CREATE TABLE `employees` (
  `eid` int(11) NOT NULL AUTO_INCREMENT,
  `ename` varchar(15) DEFAULT NULL,
  `city` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`eid`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of employees
-- ----------------------------
INSERT INTO `employees` VALUES ('1', 'Amy', 'Vestal');
INSERT INTO `employees` VALUES ('2', 'Bob', 'Binghamton');
INSERT INTO `employees` VALUES ('3', 'John', 'Binghamton');
INSERT INTO `employees` VALUES ('4', 'Lisa', 'Binghamton');
INSERT INTO `employees` VALUES ('5', 'Matt', 'Vestal');

-- ----------------------------
-- Table structure for logs
-- ----------------------------
DROP TABLE IF EXISTS `logs`;
CREATE TABLE `logs` (
  `logid` int(5) NOT NULL AUTO_INCREMENT,
  `who` varchar(10) NOT NULL,
  `time` datetime NOT NULL,
  `table_name` varchar(20) NOT NULL,
  `operation` varchar(6) NOT NULL,
  `key_value` varchar(4) DEFAULT NULL,
  PRIMARY KEY (`logid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of logs
-- ----------------------------

-- ----------------------------
-- Table structure for products
-- ----------------------------
DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
  `pid` int(11) NOT NULL AUTO_INCREMENT,
  `pname` varchar(20) NOT NULL,
  `qoh` int(5) NOT NULL,
  `qoh_threshold` int(5) DEFAULT NULL,
  `original_price` decimal(6,2) DEFAULT NULL,
  `discnt_rate` decimal(3,2) DEFAULT NULL,
  `sid` int(11) DEFAULT NULL,
  `imgname` varchar(50) DEFAULT '',
  PRIMARY KEY (`pid`),
  KEY `sid` (`sid`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of products
-- ----------------------------
INSERT INTO `products` VALUES ('1', 'Milk', '12', '10', '2.40', '0.10', '1', 'Milk.jpg');
INSERT INTO `products` VALUES ('2', 'Egg', '20', '10', '1.50', '0.20', '2', 'Egg.jpg');
INSERT INTO `products` VALUES ('3', 'Bread', '15', '10', '1.20', '0.10', '1', 'Bread.jpg');
INSERT INTO `products` VALUES ('4', 'Pineapple', '6', '5', '2.00', '0.30', '1', 'Pineapple.jpg');
INSERT INTO `products` VALUES ('5', 'Knife', '10', '8', '2.50', '0.20', '2', 'Knife.jpg');
INSERT INTO `products` VALUES ('6', 'Shovel', '5', '5', '7.99', '0.10', '1', 'Shovel.jpg');

-- ----------------------------
-- Table structure for purchases
-- ----------------------------
DROP TABLE IF EXISTS `purchases`;
CREATE TABLE `purchases` (
  `purid` int(11) NOT NULL AUTO_INCREMENT,
  `cid` int(11) NOT NULL,
  `eid` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `qty` int(5) DEFAULT NULL,
  `ptime` datetime DEFAULT NULL,
  `total_price` decimal(7,2) DEFAULT NULL,
  PRIMARY KEY (`purid`),
  KEY `cid` (`cid`),
  KEY `eid` (`eid`),
  KEY `pid` (`pid`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of purchases
-- ----------------------------
INSERT INTO `purchases` VALUES ('1', '1', '1', '1', '1', '2013-11-26 12:34:22', '2.16');
INSERT INTO `purchases` VALUES ('2', '2', '4', '4', '2', '2013-12-05 09:12:30', '2.80');
INSERT INTO `purchases` VALUES ('3', '3', '4', '1', '1', '2013-11-29 14:30:00', '2.16');
INSERT INTO `purchases` VALUES ('4', '1', '2', '2', '5', '2013-11-28 10:25:32', '6.00');
INSERT INTO `purchases` VALUES ('5', '5', '5', '3', '3', '2013-11-30 11:52:16', '3.24');
INSERT INTO `purchases` VALUES ('6', '4', '3', '6', '1', '2013-12-04 16:48:02', '7.19');

-- ----------------------------
-- Table structure for suppliers
-- ----------------------------
DROP TABLE IF EXISTS `suppliers`;
CREATE TABLE `suppliers` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `sname` varchar(15) NOT NULL,
  `city` varchar(15) DEFAULT NULL,
  `telephone_no` char(10) DEFAULT NULL,
  PRIMARY KEY (`sid`),
  UNIQUE KEY `sname` (`sname`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of suppliers
-- ----------------------------
INSERT INTO `suppliers` VALUES ('1', 'Supplier 1', 'Binghamton', '6075555431');
INSERT INTO `suppliers` VALUES ('2', 'Supplier 2', 'NYC', '6075555432');

-- ----------------------------
-- Procedure structure for add_purchase
-- ----------------------------
DROP PROCEDURE IF EXISTS `add_purchase`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `add_purchase`(IN c_id int, e_id int, p_id int, pur_qty int)
begin
declare totalprice decimal(7,2);
declare ori_price decimal(6,2);
declare rate decimal(3,2);
declare old_qoh int;
declare old_plus_sold int;
select original_price,discnt_rate,qoh into ori_price,rate,old_qoh from products where pid = p_id;

set totalprice = ori_price*(1-rate)*pur_qty;

if old_qoh - pur_qty < (select qoh_threshold from products where pid = p_id) then
   set old_plus_sold = old_qoh + pur_qty;
   select old_qoh,old_plus_sold;
   update products set qoh = 2*old_qoh where pid = p_id;
end if;

insert into purchases(cid,eid,pid,qty,ptime,total_price) values(c_id, e_id, p_id, pur_qty,CURRENT_TIMESTAMP,totalprice);
end
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for del_product
-- ----------------------------
DROP PROCEDURE IF EXISTS `del_product`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `del_product`(IN p_id int)
begin
delete from products where pid = p_id;
end
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for find_product
-- ----------------------------
DROP PROCEDURE IF EXISTS `find_product`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `find_product`(IN prod_id int)
begin
		select * from products where pid = prod_id;
	end
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for new_product
-- ----------------------------
DROP PROCEDURE IF EXISTS `new_product`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `new_product`(IN pname_ varchar(15), qoh_ int(5), qoh_threshold_ int(5), original_price_ decimal(6,2),discnt_rate_ decimal(3,2),sid_ int,imgname_ varchar(50) )
begin
insert into products(pname, qoh, qoh_threshold, original_price,discnt_rate,sid,imgname) values(pname_, qoh_, qoh_threshold_, original_price_,discnt_rate_,sid_,imgname_);
end
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for report_monthly_sale
-- ----------------------------
DROP PROCEDURE IF EXISTS `report_monthly_sale`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `report_monthly_sale`(IN prod_id int)
begin
		select pname,imgname,left( date_format(ptime,'%M'),3) as month,year(ptime) as year,sum(qty) as total_qty,sum(total_price) as total_dollar,sum(total_price)/sum(qty) as avg_price from purchases,products where purchases.pid = prod_id and purchases.pid = products.pid group by DATE_FORMAT(ptime,'%Y-%m');
	end
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for show_customers
-- ----------------------------
DROP PROCEDURE IF EXISTS `show_customers`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `show_customers`()
begin
select * from customers;
end
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for show_employees
-- ----------------------------
DROP PROCEDURE IF EXISTS `show_employees`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `show_employees`()
begin
		select * from employees;
	end
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for show_logs
-- ----------------------------
DROP PROCEDURE IF EXISTS `show_logs`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `show_logs`()
begin
		select * from logs;
	end
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for show_products
-- ----------------------------
DROP PROCEDURE IF EXISTS `show_products`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `show_products`()
begin
		select * from products;
	end
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for show_purchases
-- ----------------------------
DROP PROCEDURE IF EXISTS `show_purchases`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `show_purchases`()
begin
		select * from purchases;
	end
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for show_suppliers
-- ----------------------------
DROP PROCEDURE IF EXISTS `show_suppliers`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `show_suppliers`()
begin
		select * from suppliers;
	end
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `log_update_visit`;
DELIMITER ;;
CREATE TRIGGER `log_update_visit` AFTER UPDATE ON `customers` FOR EACH ROW begin
  if new.visits_made != old.visits_made then
    insert into logs(who,time,table_name,operation,key_value) values('root',CURRENT_TIMESTAMP,'customers','update',new.cid);
  end if;
  end
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `log_update_qoh`;
DELIMITER ;;
CREATE TRIGGER `log_update_qoh` AFTER UPDATE ON `products` FOR EACH ROW begin
  if new.qoh != old.qoh then
    insert into logs(who,time,table_name,operation,key_value) values('root',CURRENT_TIMESTAMP,'products','update',new.pid);
  end if;
  end
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `after_purchase`;
DELIMITER ;;
CREATE TRIGGER `after_purchase` AFTER INSERT ON `purchases` FOR EACH ROW begin
update products set qoh = qoh - new.qty where pid = new.pid;
update customers set visits_made = visits_made + 1,last_visit_time = new.ptime where cid = new.cid;
insert into logs(who,time,table_name,operation,key_value) values('root',CURRENT_TIMESTAMP,'purchases','insert',new.purid);
end
;;
DELIMITER ;
