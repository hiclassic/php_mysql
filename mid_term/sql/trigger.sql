DELIMITER $$

CREATE TRIGGER after_manufacturer_delete
AFTER DELETE ON Manufacturer
FOR EACH ROW
BEGIN
  DELETE FROM Product WHERE manufacturer_id = OLD.id;
END$$

DELIMITER ;
