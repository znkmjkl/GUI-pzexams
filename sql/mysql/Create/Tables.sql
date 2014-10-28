/* Usuwanie poprzednich tabel */
DROP TABLE IF EXISTS `Records`;
DROP TABLE IF EXISTS `Students`;
DROP TABLE IF EXISTS `ExamUnits`;
DROP TABLE IF EXISTS `Exams`;
DROP TABLE IF EXISTS `UsersSettings`;
DROP TABLE IF EXISTS `Users`;

/* Users */
CREATE TABLE `Users` (
	`ID`               INT                                         AUTO_INCREMENT,
	`Email`            VARCHAR (80)                                UNIQUE NOT NULL,
	`Password`         VARCHAR (50)                                NOT NULL,
	`Activated`        BOOLEAN                                     NOT NULL,
	`ActivationCode`   VARCHAR (32)                                UNIQUE,
	`FirstName`        VARCHAR (50),
	`Surname`          VARCHAR (70),
	`Visibility`       ENUM ('private', 'public')                  NOT NULL,
	`Rights`           ENUM ('owner', 'administrator', 'examiner') NOT NULL,
	`Gender`           ENUM ('female', 'male'),
	`RegistrationDate` DATE                                        NOT NULL,
	`University`       VARCHAR(120),
	`Telephone`        VARCHAR(15),
	`WebSite`          VARCHAR(150),
	PRIMARY KEY (`ID`)
) ENGINE=InnoDB;

/* Exam */
CREATE TABLE `Exams` (
	`ID`           INT          AUTO_INCREMENT,
	`UserID`       INT,
	`Name`         VARCHAR(100) NOT NULL,
	`Duration`     TIME         NOT NULL,
	`Activated`    BOOLEAN      NOT NULL,
	`EmailsPosted` BOOLEAN      NOT NULL,
	PRIMARY KEY (`ID`),
	FOREIGN KEY (`UserID`) REFERENCES `Users` (`ID`) ON DELETE CASCADE,
	INDEX (`UserID`)
) ENGINE=InnoDB;

/* ExamUnit */
CREATE TABLE `ExamUnits` (
	`ID`       INT  AUTO_INCREMENT,
	`ExamID`   INT,
	`Day`      DATE                        NOT NULL,
	`TimeFrom` TIME                        NOT NULL,
	`TimeTo`   TIME                        NOT NULL,
	`State`    ENUM ('unlocked', 'locked') NOT NULL,
	PRIMARY KEY (`ID`),
	FOREIGN KEY (`ExamID`) REFERENCES `Exams` (`ID`) ON DELETE CASCADE,
	INDEX (`ExamID`)
) ENGINE=InnoDB;

/* Students */
CREATE TABLE `Students` (
	`ID`        INT          AUTO_INCREMENT,
	`Email`     VARCHAR (80) UNIQUE NULL,
	`Code`      VARCHAR (32) UNIQUE,
	`FirstName` VARCHAR (50) NOT NULL,
	`Surname`   VARCHAR (70) NOT NULL,
	PRIMARY KEY (`ID`)
) ENGINE=InnoDB;

CREATE TABLE `Records` (
	`ID`          INT          AUTO_INCREMENT,
	`StudentID`   INT,
	`ExamID`      INT,
	`ExamUnitID`  INT          NULL,
	`MessageSent` BOOLEAN      NOT NULL,
	PRIMARY KEY (`ID`),
	FOREIGN KEY (`StudentID`) REFERENCES `Students` (`ID`) ON DELETE CASCADE,
	FOREIGN KEY (`ExamID`) REFERENCES `Exams` (`ID`) ON DELETE CASCADE
) ENGINE=InnoDB;
