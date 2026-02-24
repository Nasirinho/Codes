-- Farming Vendor Management System 
-- Name: Nasir Karim
-- Class: CIS 344



-- CREATE DATABASE farming_vendor_db;


USE farming_vendor_db;

CREATE TABLE farmer (
    farmer_id INT AUTO_INCREMENT PRIMARY KEY,
    farm_name VARCHAR(100) NOT NULL,
    farmer_first_name VARCHAR(50) NOT NULL,
    farmer_last_name VARCHAR(50) NOT NULL,
    farm_address VARCHAR(255),
    phone VARCHAR(20),
    email VARCHAR(100)
);

CREATE TABLE product (
    product_id INT AUTO_INCREMENT PRIMARY KEY,
    product_name VARCHAR(100) NOT NULL,
    category VARCHAR(50),
    measurement VARCHAR(20) NOT NULL,
    price DECIMAL(10,2) NOT NULL
);

CREATE TABLE customer (
    customer_id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(100),
    phone VARCHAR(20)
);

CREATE TABLE transaction (
    transaction_id INT AUTO_INCREMENT PRIMARY KEY,
    transaction_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    total_amount DECIMAL(10, 2),
    customer_id INT NOT NULL,
    FOREIGN KEY (customer_id) REFERENCES customer(customer_id)
);

CREATE TABLE transaction_per_item (
    item_id INT AUTO_INCREMENT PRIMARY KEY,
    quantity DECIMAL(10, 2) NOT NULL,
    price_at_sale DECIMAL(10, 2) NOT NULL,
    transaction_id INT NOT NULL,
    product_id INT NOT NULL,
    farmer_id INT NOT NULL,
    FOREIGN KEY (transaction_id) REFERENCES transaction(transaction_id),
    FOREIGN KEY (product_id) REFERENCES product(product_id),
    FOREIGN KEY (farmer_id) REFERENCES farmer(farmer_id)
);

INSERT INTO farmer (farm_name, farmer_first_name, farmer_last_name, farm_address, phone, email) VALUES
('Baratie Ocean Farm', 'Sanji', 'Vinsmoke', '1127 Restaurant Row, Baratie', '929-555-0123', 'sanji@germa66.com'),
('Sunny Citrus Grove', 'Ace', 'Portgas', '3298 Dawn Island, Goa Kingdom', '518-666-0124', 'ace@roger.com'),
('Thousand Sunny Orchard', 'Luffy', 'Monkey D.', '1000 Going Merry Way, Foosha Village', '347-777-0125', 'luffy@bazooka.com'),
('Cotton Candy Land', 'Chopper', 'Tony Tony', '789 Drum Island, Sakura Kingdom', '616-888-0126', 'chopper@yahoo.com'),
('Rumbar Vineyards', 'Brook', 'Rumbar', '444 Laboon Strait, Reverse Mountain', '800-999-0127', 'brook@hotmail.com'),
('Alabasta Oasis Farm', 'Vivi', 'Nefeltari', '5000 Sandora River, Alabasta', '347-444-0128', 'vivi@outlook.com'),
('Weatheria Wheat Fields', 'Zoro', 'Roronoa', '2105 Weatheria Island', '929-120-0129', 'zoro@santoryu.com'),
('Skypiea Bean Farm', 'Shanks', 'Figarland', '888 Upper Yard, Skypiea', '712-578-0130', 'shanks@akagami.com'),
('Water 7 Seafood', 'Usopp', 'Yasopp', '3141 Water 7 Docks', '646-365-0131', 'usopp@sogeking.com'),
('Wano Kuni Rice Paddies', 'Momonosuke', 'Kozuki', '777 Flower Capital, Wano Kuni', '929-333-0132', 'momonosuke@wano.com');

INSERT INTO product (product_name, category, measurement, price) VALUES
('Drum Island Snow Apples', 'Fruit', 'lb', 3.50),
('Alabasta Desert Melons', 'Fruit', 'each', 4.00),
('Skypiea Cloud Coffee Beans', 'Beverage', 'lb', 12.00),
('Baratie Sea King Fillet', 'Seafood', 'lb', 15.00),
('Wano Kuni Rice', 'Grain', 'lb', 2.50),
('Water 7 Cola Bottles', 'Beverage', 'each', 3.00),
('Whole Cake Island Honey', 'Sweetener', 'jar', 8.00),
('Dressrosa Sake Grapes', 'Fruit', 'lb', 4.50),
('Zou Mink Tribe Milk', 'Dairy', 'gallon', 5.00),
('Thousand Sunny Tangerines', 'Fruit', 'lb', 3.00);

INSERT INTO customer (first_name, last_name, email, phone) VALUES
('Edward', 'Newgate', 'edward@whitebeard.com', '518-555-1201'),
('Boa', 'Hancock', 'boa@kuja.com', '347-462-9602'),
('Law', 'Trafalgar D.', 'law@water.com', '646-985-3256'),
('Eustass', 'Kid', 'kid@punkbison.com', '929-549-3035'),
('Jinbe', 'Kyojun', 'jinbe@sun.com', '800-265-5895'),
('Marco', 'Phoenix', 'marco@whitebeard.com', '347-111-1206'),
('Doflamingo', 'Donquixote', 'joker@celestial.com', '929-300-1658'),
('Garp', 'Monkey D.', 'garp@marine.com', '712-005-5974'),
('Mihawk', 'Dracule', 'mihawk@hawkeyes.com', '646-777-9191'),
('Buggy', 'Rocks', 'buggy@buggycircus.com', '555-333-1010');

INSERT INTO transaction (customer_id, total_amount, transaction_date) VALUES
(1, 45.50, '2024-01-15 10:30:00'), 
(2, 28.00, '2024-01-16 14:15:00'), 
(3, 67.25, '2024-01-17 09:45:00'),
(4, 33.50, '2024-01-18 16:20:00'), 
(5, 52.00, '2024-01-19 11:10:00'), 
(6, 19.75, '2024-01-20 13:30:00'), 
(7, 84.00, '2024-01-21 10:00:00'), 
(8, 41.50, '2024-01-22 15:45:00'), 
(9, 93.00, '2024-01-23 12:00:00'), 
(10, 27.50, '2024-01-24 17:30:00');

INSERT INTO transaction_per_item (quantity, price_at_sale, transaction_id, product_id, farmer_id) VALUES

(2.5, 3.50, 1, 1, 5), 
(1, 15.00, 1, 4, 1), 
(3, 8.00, 1, 7, 6), 

(5, 3.00, 2, 10, 3), 
(2, 5.00, 2, 9, 9), 

(3, 12.00, 3, 3, 8), 
(1, 4.00, 3, 2, 7), 
(2.5, 15.00, 3, 4, 1), 
(4, 2.50, 3, 5, 10),

(3, 4.50, 4, 8, 2), 
(6, 3.00, 4, 6, 9), 

(4, 5.00, 5, 9, 4), 
(2, 8.00, 5, 7, 6), 
(3, 3.50, 5, 1, 5), 

(2, 12.00, 6, 3, 8), 
(1.5, 4.50, 6, 8, 2), 


(5, 2.50, 7, 5, 10), 
(4, 3.00, 7, 10, 3), 
(2, 15.00, 7, 4, 1), 
(3, 4.00, 7, 2, 7), 


(2.5, 3.50, 8, 1, 5), 
(4, 8.00, 8, 7, 6), 


(3, 15.00, 9, 4, 1), 
(2, 12.00, 9, 3, 8), 
(5, 5.00, 9, 9, 4), 


(4, 3.00, 10, 6, 9), 
(2.5, 4.50, 10, 8, 2); 

select * from product order by price;

select * from farmer order by farm_name;

select * from transaction order by transaction_date;
select * from transaction order by total_amount;

select * from customer order by first_name;

select * from transaction_per_item limit 10;
select * from transaction_per_item order by farmer_id limit 14;

SELECT 
    transaction_per_item.item_id,
    transaction.transaction_id,
    product.product_name,
    transaction_per_item.quantity,
    transaction_per_item.price_at_sale
FROM transaction_per_item
JOIN product ON transaction_per_item.product_id = product.product_id
JOIN transaction ON transaction_per_item.transaction_id = transaction.transaction_id;

