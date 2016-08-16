CREATE DATABASE IF NOT EXISTS Booking ;
GRANT CREATE,SELECT,UPDATE,DELETE,INSERT ON Booking.* TO develop@'%' IDENTIFIED BY 'develop';

CREATE TABLE IF NOT EXISTS `Booking`.`Booking` (
    `id` INT(14) NOT NULL auto_increment,
    `Date` DATE,
    `HourlySlot` TINYINT( 2 ) UNSIGNED DEFAULT NULL,
    `ReserveeId` VARCHAR(100) NOT NULL default '',
    `ReserveeComment` VARCHAR(256) NOT NULL default '',
    `Status` tinyint(1) DEFAULT 0,
    tstamp TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `ix_booking` (`Date`, `HourlySlot`),
    INDEX `Date` (`Date`),
    INDEX `ReserveeId` (`ReserveeId`),
    INDEX `Status` (`Status`)
);


DROP TABLE IF EXISTS `Booking`.`BookingTemplate`;
CREATE TABLE IF NOT EXISTS `Booking`.`BookingTemplate` (
    `HourlySlot` TINYINT( 2 ) UNSIGNED DEFAULT NULL,
    `Status` tinyint(1) DEFAULT 0,
    PRIMARY KEY (`HourlySlot`)
);

INSERT INTO `Booking`.`BookingTemplate` (`HourlySlot`,`Status`) VALUES (7,0), (8,0), (9,0), (10,0), (11,0), (12,0),(13,0), (14,0), (15,0), (16,0), (17,0), (18,0), (19,0), (20,0), (21,0), (22,0), (23,0);


CREATE TABLE IF NOT EXISTS `Booking`.`User`(
    `id` INT(14) NOT NULL auto_increment,
    `Username` varchar(100) DEFAULT NULL,
    `AccessLevel` TINYINT(1) DEFAULT 0,
    tstamp TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `ix_username` (`username`),
    INDEX `AccessLevel` (`AccessLevel`)
);
