CREATE DATABASE IF NOT EXISTS Booking ;
GRANT CREATE,SELECT,UPDATE,DELETE,INSERT ON booking.* TO develop@'%' IDENTIFIED BY 'develop';

CREATE TABLE IF NOT EXISTS `Booking`.`Booking` (
    `id` INT(14) NOT NULL auto_increment,
    `date` DATE,
    `hourlyslot` TINYINT( 2 ) UNSIGNED DEFAULT NULL,
    `ReserveeId` VARCHAR(100) NOT NULL default '',
    `ReserveeDesc` VARCHAR(256) NOT NULL default '',
    `status` tinyint(1) DEFAULT 0,
    tstamp TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `ix_booking` (`date`, `hourlyslot`),
    INDEX `date` (`date`),
    INDEX `ReserveeId` (`ReserveeId`),
    INDEX `status` (`status`)
);


CREATE TABLE IF NOT EXISTS `Booking`.`BookingTemplate` (
    `hourlyslot` TINYINT( 2 ) UNSIGNED DEFAULT NULL,
    `status` tinyint(1) DEFAULT 0
);

INSERT INTO `Booking`.`BookingTemplate` (`hourlyslot`,`status`) VALUES (7,0), (8,0), (9,0), (10,0), (11,0), (12,0),(13,0), (14,0), (15,0), (16,0), (17,0), (18,0), (19,0), (20,0), (21,0), (22,0), (23,0);


CREATE TABLE IF NOT EXISTS `Booking`.`User`(
    `id` INT(14) NOT NULL auto_increment,
    `username` varchar(100) DEFAULT NULL,
    `nAccessLevel` TINYINT(1) DEFAULT 0,
    tstamp TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `ix_username` (`username`),
    INDEX `nAccessLevel` (`nAccessLevel`)
);
