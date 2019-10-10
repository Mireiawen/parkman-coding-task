CREATE TABLE IF NOT EXISTS `Company`
(
	`ID` int(12) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Company unique ID',
	`Name` varchar(64) NOT NULL COMMENT 'Company name',
	`Email` varchar(255) NOT NULL COMMENT 'Email contact address',
	PRIMARY KEY (`ID`),
	UNIQUE (`Name`)
) ENGINE='InnoDB' DEFAULT CHARSET='utf8mb4' AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS `Currency`
(
	`ID` int(8) unsigned NOT NULL COMMENT 'Currency unique ID',
	`Name` varchar(32) NOT NULL COMMENT 'Currency name',
	`Code` varchar(4) NOT NULL COMMENT 'ISO-4217 3-letter code',
	`Symbol` varchar(8) NOT NULL COMMENT 'Currency symbol',
	PRIMARY KEY (`ID`),
	UNIQUE (`Code`)
) ENGINE='InnoDB' DEFAULT CHARSET='utf8mb4' AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS `Country`
(
	`ID` int(8) unsigned NOT NULL COMMENT 'Country unique ID',
	`Name` varchar(32) NOT NULL COMMENT 'Country name',
	`Code` varchar(4) NOT NULL COMMENT 'ISO-3166-1 3-letter code',
	PRIMARY KEY (`ID`),
	UNIQUE (`Name`),
	UNIQUE (`Code`)
) ENGINE='InnoDB' DEFAULT CHARSET='utf8mb4' AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS `Garage`
(
	`ID` int(12) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Garage unique ID',
	`Company` int(12) unsigned NOT NULL COMMENT 'Company ID for the owner',
	`Name` varchar(64) NOT NULL COMMENT 'Garage name',
	`Price` float(7,2) NOT NULL COMMENT 'Hourly price',
	`Currency` int(8) unsigned NOT NULL COMMENT 'Currency ID',
	`Country` int(8) unsigned NOT NULL COMMENT 'Country ID',
	`Latitude` float(19,15) NOT NULL COMMENT 'The garage latitude',
	`Longitude` float(19,15) NOT NULL COMMENT 'The garage longitude',
	PRIMARY KEY (`ID`),
	CONSTRAINT `fk_garage_company` FOREIGN KEY (`Company`) REFERENCES `Company` (`ID`) ON UPDATE CASCADE ON DELETE CASCADE,
	CONSTRAINT `fk_garage_currency` FOREIGN KEY (`Currency`) REFERENCES `Currency` (`ID`) ON UPDATE CASCADE ON DELETE RESTRICT,
	CONSTRAINT `fk_garage_country` FOREIGN KEY (`Country`) REFERENCES `Country` (`ID`) ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE='InnoDB' DEFAULT CHARSET='utf8mb4' AUTO_INCREMENT=1;
