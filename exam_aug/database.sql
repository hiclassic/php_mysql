-- ✅ Create DB
CREATE DATABASE IF NOT EXISTS webapp;
USE webapp;

-- ✅ Clean old tables
DROP TABLE IF EXISTS product;
DROP TABLE IF EXISTS manufacturer;

-- ✅ Manufacturer table
CREATE TABLE manufacturer (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50),
    address VARCHAR(100),
    contact_no VARCHAR(50)
);

-- ✅ Product table (NO FK!)
CREATE TABLE product (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50),
    price INT(5),
    manufacturer_id INT
);

-- ✅ AFTER DELETE TRIGGER
DELIMITER //
CREATE TRIGGER after_manufacturer_delete
AFTER DELETE ON manufacturer
FOR EACH ROW
BEGIN
    DELETE FROM product WHERE manufacturer_id = OLD.id;
END //
DELIMITER ;

-- ✅ Stored Procedures
DELIMITER //

CREATE PROCEDURE insert_manufacturer (
    IN pname VARCHAR(50),
    IN paddress VARCHAR(100),
    IN pcontact VARCHAR(50)
)
BEGIN
    INSERT INTO manufacturer (name, address, contact_no)
    VALUES (pname, paddress, pcontact);
END //

CREATE PROCEDURE delete_manufacturer_by_id (
    IN mid INT
)
BEGIN
    DELETE FROM manufacturer WHERE id = mid;
END //

CREATE PROCEDURE insert_product (
    IN pname VARCHAR(50),
    IN pprice INT,
    IN pmid INT
)
BEGIN
    INSERT INTO product (name, price, manufacturer_id)
    VALUES (pname, pprice, pmid);
END //

CREATE PROCEDURE get_all_manufacturers()
BEGIN
    SELECT * FROM manufacturer;
END //

CREATE PROCEDURE get_all_products()
BEGIN
    SELECT p.id, p.name, p.price, p.manufacturer_id, m.name AS manufacturer_name
    FROM product p
    LEFT JOIN manufacturer m ON p.manufacturer_id = m.id;
END //

CREATE PROCEDURE get_expensive_products()
BEGIN
    SELECT p.id, p.name, p.price, p.manufacturer_id, m.name AS manufacturer_name
    FROM product p
    LEFT JOIN manufacturer m ON p.manufacturer_id = m.id
    WHERE p.price > 5000;
END //

DELIMITER ;

-- ✅ View for expensive products
CREATE OR REPLACE VIEW expensive_products AS
SELECT p.id, p.name, p.price, p.manufacturer_id, m.name AS manufacturer_name
FROM product p
LEFT JOIN manufacturer m ON p.manufacturer_id = m.id
WHERE p.price > 5000;

-- ✅ Dummy Data
CALL insert_manufacturer('TechMakers Ltd.', 'Dhaka', '01711-123456');
CALL insert_manufacturer('Global Supplies', 'Chittagong', '01819-654321');
CALL insert_manufacturer('Prime Electronics', 'Sylhet', '01912-777888');

CALL insert_product('Laptop X200', 4500, 1);
CALL insert_product('High-End Laptop X300', 7500, 1);
CALL insert_product('Wireless Mouse', 1200, 1);
CALL insert_product('Industrial Printer', 10500, 2);
CALL insert_product('Smartphone Z5', 8500, 2);
CALL insert_product('Basic Phone B1', 3000, 2);
CALL insert_product('Air Conditioner', 9500, 3);
CALL insert_product('LED TV 50"', 15000, 3);
CALL insert_product('Small Fan', 1800, 3);
