
---
--- Dumping data for table `account`
---

INSERT INTO `account` (`username`, `password`, `email`, `phoneNumber`, `telegramid`, `stonks`, `equipHead`, `equipBody`, `equipHand`, `equipPet`) VALUES 
('Yoshi', 'youshi123', 'youshi@gmail.com', '67009000', '12345', 100.00, 'hat2.png', Null, Null, Null), 
('James', 'james123', 'james@gmail.com', '98882345', '98572', 100.00, Null, Null, Null, 'pet2.png'), 
('mary', '123', 'mary@gmail.com', '74653725', '98972', 100.00, Null, Null, Null, 'pet2.png'), 
('Amy', 'amy123', 'amy@gmail.com', '66667888', '23456', 100.00, Null, 'body3.png', Null, Null);

---
--- Dumping data for table `accessory`
---

INSERT INTO `accessory` (`accessoryID`, `accessoryName`, `accessoryDesc`, `category`, `src`) VALUES
(1, 'Santa Hat', 'Ho ho ho! It\'s Christmas Time!', 'equipHead', 'hat2.png'),
(2, 'Spidersuit', 'A Spidersuit specially created for Yoshi', 'equipBody', 'body3.png'),
(3, 'Jake The Dog', 'Jake the Dog from Adventure Time. Get one today!', 'equipPet', 'pet2.png'),
(4, 'Ice Cream', 'Eat me~', 'equipHand', 'hand1.png');

---
--- Dumping data for table `stock`
---

INSERT INTO `stock` (`stockname`, `spoofname`) VALUES
('A', 'DKBank Inc'),
('AA', 'ThisKong Pte Ltd'),
('DAL', 'Yeet and Yeehaw Advisory');


---
--- Dumping data for table `inventory`
---

INSERT INTO `inventory` (`username`, `accessoryID`, `quantity`) VALUES
('Yoshi', 1, 1),
('James', 3, 1),
('mary', 3, 1),
('Amy', 2, 1);

---
--- Dumping data for table `shop`
---

INSERT INTO `shop` (`shopID`, `accessoryID`, `inStock`, `price`) VALUES
(1, 1, 10, '20.50'),
(1, 2, 15, '15.50'),
(1, 3, 12, '18.00');
