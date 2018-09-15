DROP PROCEDURE IF EXISTS create_product;

DELIMITER //
    CREATE PROCEDURE create_product (IN pName VARCHAR(50))
    BEGIN
        INSERT INTO wp_premio_product VALUES(NULL, pName);
    END //
DELIMITER ;