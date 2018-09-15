DROP PROCEDURE IF EXISTS create_product;

DELIMITER //
    CREATE PROCEDURE create_product (IN pName VARCHAR(50), IN pProductContainer INT)
    BEGIN
        INSERT INTO wp_premio_product VALUES(NULL, pName);
        INSERT INTO wp_products_by_container VALUE(NULL, LAST_INSERT_ID(), pProductContainer);
    END //
DELIMITER ;