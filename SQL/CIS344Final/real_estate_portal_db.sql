CREATE DATABASE real_estate_portal_db;
USE real_estate_portal_db;

CREATE TABLE USERS (
    userId INT NOT NULL UNIQUE AUTO_INCREMENT PRIMARY KEY,
    userName VARCHAR(50) NOT NULL UNIQUE,
    contactInfo VARCHAR(200),
    passwordHash VARCHAR(255) NOT NULL,
    userType ENUM("agent", "buyer", "renter") NOT NULL
);

CREATE TABLE PROPERTIES (
    propertyId INT NOT NULL UNIQUE AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    propertyType VARCHAR(50) NOT NULL,
    address VARCHAR(200) NOT NULL,
    city VARCHAR(100) NOT NULL,
    price DECIMAL(12,2) NOT NULL,
    status ENUM("available", "sold", "rented") NOT NULL DEFAULT "available",
    agentId INT NOT NULL,
    FOREIGN KEY (agentId) REFERENCES Users(userId)
);

CREATE TABLE INQUIRIES (
    inquiryId INT NOT NULL UNIQUE AUTO_INCREMENT PRIMARY KEY,
    userId INT NOT NULL,
    propertyId INT NOT NULL,
    message VARCHAR(255) NOT NULL,
    inquiryDate DATETIME NOT NULL,
    FOREIGN KEY (userId) REFERENCES Users(userId),
    FOREIGN KEY (propertyId) REFERENCES Properties(propertyId)
);

CREATE TABLE TRANSACTIONS (
    transactionId INT NOT NULL UNIQUE AUTO_INCREMENT PRIMARY KEY,
    propertyId INT NOT NULL,
    userId INT NOT NULL,
    transactionType ENUM("sale", "rental") NOT NULL,
    transactionDate DATETIME NOT NULL,
    amount DECIMAL(12,2) NOT NULL,
    FOREIGN KEY (propertyId) REFERENCES Properties(propertyId),
    FOREIGN KEY (userId) REFERENCES Users(userId)
);

CREATE TABLE FAVORITES (
    favoriteId INT NOT NULL UNIQUE AUTO_INCREMENT PRIMARY KEY,
    userId INT NOT NULL,
    propertyId INT NOT NULL,
    savedDate DATETIME NOT NULL,
    FOREIGN KEY (userId) REFERENCES Users(userId),
    FOREIGN KEY (propertyId) REFERENCES Properties(propertyId)
);

INSERT INTO Users (userName, contactInfo, passwordHash, userType) VALUES
("hero_garp", "hero_garp@gmail.com", "galaxy#impact", "agent"),
("strawhat_luffy", "strawhat_luffy@gmail.com", "jet#gatling", "renter"),
("nasir_cipher", "nasir_cipher@gmail.com", "black|myth|wukong", "buyer"),
("roronoa_zoro", "zoro_santoryu@gmail.com", "stupid#curlybrow&cook", "buyer"),
("usopp_sogeking", "usopp_sogeking@gmail.com", "kayaku#boshi", "renter");

INSERT INTO Properties (title, propertyType, address, city, price, `status`, agentId) VALUES
("Traditional Japanese Apartment", "Apartment", "199 Kingsbridge Road", "Bronx", 50000.00, "available", 1),
("Family House", "House", "333 Oak Ave", "Los Angeles", 750000.00, "available", 1),
("Galaxy Condo", "Condo", "565 Elm Avenue", "Chicago", 3000000.00, "available", 1),
("Green Penthouse", "Penthouse", "12 Grand Street", "New York", 4500000.00, "available", 1),
("Alabasta Studio", "Studio", "2090 Adam Clayton Avenue", "New York", 180000.00, "available", 1);

INSERT INTO Inquiries (userId, propertyId, message, inquiryDate) VALUES
(2, 1, "Is this still available for sale?", NOW()),
(3, 2, "Can we have a look around?", NOW()),
(2, 3, "How peaceful is the surrounding?", NOW()),
(4, 4, "Does this come with parking?", NOW()),
(5, 5, "Is the price negotiable?", NOW());

INSERT INTO Transactions (propertyId, userId, transactionType, transactionDate, amount) VALUES
(1, 2, "sale", NOW(), 78000.00),
(2, 3, "rental", NOW(), 1100.00),
(3, 2, "sale", NOW(), 990000.00),
(4, 4, "sale", NOW(), 4200000.00),
(5, 5, "rental", NOW(), 1500.00);

INSERT INTO Favorites (userId, propertyId, savedDate) VALUES
(2, 1, NOW()),
(3, 2, NOW()),
(2, 3, NOW()),
(4, 4, NOW()),
(5, 5, NOW());

DELIMITER $$

CREATE PROCEDURE AddOrUpdateUser(
    IN p_userId INT,
    IN p_userName VARCHAR(50),
    IN p_contactInfo VARCHAR(200),
    IN p_passwordHash VARCHAR(255),
    IN p_userType VARCHAR(20)
)
BEGIN
    IF p_userId IS NULL OR p_userId = 0 THEN
        INSERT INTO Users (userName, contactInfo, passwordHash, userType)
        VALUES (p_userName, p_contactInfo, p_passwordHash, p_userType);
    ELSE
        UPDATE Users
        SET userName = p_userName,
            contactInfo = p_contactInfo,
            passwordHash = p_passwordHash,
            userType = p_userType
        WHERE userId = p_userId;
    END IF;
END$$

DELIMITER ;


DELIMITER $$

CREATE PROCEDURE ProcessTransaction(
    IN p_propertyId INT,   
    IN p_userId INT,             
    IN p_transactionType VARCHAR(10),
    IN p_amount DECIMAL(12,2)    
)
BEGIN
    
    INSERT INTO Transactions(propertyId, userId, transactionType, transactionDate, amount)
    VALUES (p_propertyId, p_userId, p_transactionType, NOW(), p_amount);

    IF p_transactionType = "sale" THEN  
        UPDATE Properties
        SET status = "sold"
        WHERE propertyId = p_propertyId;

    ELSEIF p_transactionType = "rental" THEN
        UPDATE Properties
        SET status = "rented"
        WHERE propertyId = p_propertyId;
    END IF;
END $$

DELIMITER ;

CREATE VIEW PropertyListingView AS
SELECT 
    Properties.propertyId,   
    Properties.title,        
    Properties.city,        
    Properties.price,        
    Properties.status,       
    Users.userName AS agentName 
FROM Properties
INNER JOIN Users
ON Properties.agentId = Users.userId; 

DELIMITER $$

CREATE TRIGGER AfterTransactionInsert
AFTER INSERT ON Transactions
FOR EACH ROW
BEGIN

    IF NEW.transactionType = "sale" THEN   
        UPDATE Properties
        SET status = "sold"
        WHERE propertyId = NEW.propertyId;

    ELSEIF NEW.transactionType = "rental" THEN
        UPDATE Properties
        SET status = "rented"
        WHERE propertyId = NEW.propertyId;
    END IF;
END $$
DELIMITER ;

select * from Users;