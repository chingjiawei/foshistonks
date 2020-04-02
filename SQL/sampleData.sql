
---
--- Dumping data for table `account`
---

INSERT INTO `account` (`username`, `password`, `email`, `phoneNumber`, `telegramid`, `stonks`, `equipHead`, `equipBody`, `equipHand`, `equipPet`,`lastLogin`,`dailyStonks`) VALUES 
('Yoshi', 'youshi123', 'youshi@gmail.com', '67009000', '12345', 100.00, 'hat2.png', Null, Null, Null, now(), 0), 
('James', 'james123', 'james@gmail.com', '98882345', '98572', 100.00, Null, Null, Null, 'pet2.png', now(), 0), 
('mary', '123', 'mary@gmail.com', '74653725', '98972', 100.00, Null, Null, Null, 'pet2.png', now(), 0), 
('Amy', 'amy123', 'amy@gmail.com', '66667888', '23456', 100.00, Null, 'body3.png', Null, Null, now(), 0);

---
--- Dumping data for table `accessory`
---

INSERT INTO `accessory` (`accessoryID`, `accessoryName`, `accessoryDesc`, `category`, `src`) VALUES
(1, 'Cappy', 'Accompanied Mario in his adventures!', 'equipHead', 'hat1.png'),
(2, 'Santa Hat', 'Ho ho ho! Merry Christmas Yoshi!', 'equipHead', 'hat2.png'),
(3, 'King\'s Crown', 'An essential for every king!', 'equipHead', 'hat3.png'),
(4, 'Poop Hat', 'A hat with a fragrant smell..', 'equipHead', 'hat4.png'),
(5, 'No Face Suit', 'Nobody can see me enjoying my life!', 'equipBody', 'body1.png'),
(6, 'Princess Dress', 'A princess dress for the pretty girl!', 'equipBody', 'body2.png'),
(7, 'Spidersuit', 'A Spidersuit specially created for Yoshi', 'equipBody', 'body3.png'),
(8, 'Ice Cream', 'I know you are thirsty, eat me!', 'equipHand', 'hand1.png'),
(9, 'Magic Wand', 'A wand with super powers!', 'equipHand', 'hand2.png'),
(10, 'Bomb', 'A bomb to protect yourself!', 'equipHand', 'hand3.png'),
(11, 'Water Gun', 'Let \'s other people be wet!', 'equipHand', 'hand4.png'),
(12, 'Cat Cat', 'Why one cat when you can have two?', 'equipPet', 'pet1.png'),
(13, 'Andrew Marlton', 'First dog on the moon; your best friend!', 'equipPet', 'pet2.png'),
(14, 'Jumbo', 'Dumbo\'s childhood friend!', 'equipPet', 'pet3.png'),
(15, 'Jake The Dog', 'Jake the Dog from Adventure Time!', 'equipPet', 'pet4.png');

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
(1, 2, 10, '24.50'),
(1, 3, 10, '40.00'),
(1, 4, 10, '28.50'),
(1, 5, 10, '45.00'),
(1, 6, 10, '50.00'),
(1, 7, 10, '55.00'),
(1, 8, 10, '15.50'),
(1, 9, 10, '18.00'),
(1, 10, 10, '16.50'),
(1, 11, 10, '18.00'),
(1, 12, 10, '25.00'),
(1, 13, 10, '26.50'),
(1, 14, 10, '27.50'),
(1, 15, 10, '28.00');
