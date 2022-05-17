
CREATE DATABASE restaurant;
GRANT USAGE ON *.* TO 'appuser'@'localhost' IDENTIFIED BY 'password';
GRANT ALL PRIVILEGES ON restaurant.* TO 'appuser'@'localhost';
FLUSH PRIVILEGES;

USE restaurant;
--
-- Table structure for table `menu`
--

CREATE TABLE IF NOT EXISTS `menu_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `price` int(10) NOT NULL,
  `date_added` date NOT NULL,
  `image` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu_items` (`id`, `name`, `price`, `date_added`) VALUES
(1, 'Pizza', 10, '2020-11-30'),
(2, 'Chicken Burger', 15, '2020-11-01'),
(3, 'Meatballs', 12, '2020-11-15');

