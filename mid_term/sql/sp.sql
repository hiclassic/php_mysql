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
