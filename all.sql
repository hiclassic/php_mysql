-- ✅ 1️⃣ Database তৈরি
CREATE DATABASE IF NOT EXISTS exm_db;
USE exm_db;

-- ✅ 2️⃣ Manufacturer টেবিল তৈরি
CREATE TABLE IF NOT EXISTS Manufacturer (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(50) NOT NULL,
  address VARCHAR(100),
  contact_no VARCHAR(50)
) ENGINE=InnoDB;

-- ✅ 3️⃣ Product টেবিল তৈরি (FK সহ)
CREATE TABLE IF NOT EXISTS Product (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(50) NOT NULL,
  price INT(5) NOT NULL,
  manufacturer_id INT,
  FOREIGN KEY (manufacturer_id) REFERENCES Manufacturer(id)
  ON DELETE CASCADE
) ENGINE=InnoDB;

-- ✅ 4️⃣ Stored Procedure (Manufacturer Insert করার জন্য)
DELIMITER $$

CREATE PROCEDURE insert_manufacturer(
  IN p_name VARCHAR(50),
  IN p_address VARCHAR(100),
  IN p_contact_no VARCHAR(50)
)
BEGIN
  INSERT INTO Manufacturer (name, address, contact_no)
  VALUES (p_name, p_address, p_contact_no);
END$$

DELIMITER ;

-- ✅ 5️⃣ After DELETE Trigger (Manufacturer delete হলে Product ও delete হবে)
DELIMITER $$

CREATE TRIGGER after_manufacturer_delete
AFTER DELETE ON Manufacturer
FOR EACH ROW
BEGIN
  DELETE FROM Product WHERE manufacturer_id = OLD.id;
END$$

DELIMITER ;

-- ✅ 6️⃣ ExpensiveProducts View (Price > 5000)
CREATE OR REPLACE VIEW ExpensiveProducts AS
SELECT * FROM Product WHERE price > 5000;

-- Insert 10 Manufacturers
INSERT INTO Manufacturer (name, address, contact_no) VALUES
('Samsung', 'Dhaka, Bangladesh', '017xxxxxxxx'),
('Apple', 'California, USA', '+1-408-xxx-xxxx'),
('Sony', 'Tokyo, Japan', '+81-3-xxxx-xxxx'),
('LG', 'Seoul, South Korea', '+82-2-xxx-xxxx'),
('Huawei', 'Shenzhen, China', '+86-755-xxx-xxxx'),
('Dell', 'Texas, USA', '+1-512-xxx-xxxx'),
('HP', 'Palo Alto, USA', '+1-650-xxx-xxxx'),
('Lenovo', 'Beijing, China', '+86-10-xxx-xxxx'),
('Asus', 'Taipei, Taiwan', '+886-2-xxx-xxxx'),
('Acer', 'New Taipei, Taiwan', '+886-2-xxx-xxxx');

-- Insert 10 Products
INSERT INTO Product (name, price, manufacturer_id) VALUES
('Galaxy S22', 95000, 1),
('iPhone 14 Pro', 135000, 2),
('PlayStation 5', 70000, 3),
('LG OLED TV', 120000, 4),
('Huawei P50', 75000, 5),
('Dell XPS 13', 140000, 6),
('HP Spectre x360', 125000, 7),
('Lenovo ThinkPad X1', 115000, 8),
('Asus ROG Phone', 80000, 9),
('Acer Predator Laptop', 95000, 10);



