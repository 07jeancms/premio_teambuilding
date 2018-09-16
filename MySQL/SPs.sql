DROP PROCEDURE IF EXISTS create_product;

DELIMITER //
    CREATE PROCEDURE create_product (IN pName VARCHAR(50), IN pProductContainer INT)
    BEGIN
        INSERT INTO wp_premio_product VALUES(NULL, pName);
        INSERT INTO wp_products_by_container VALUE(NULL, LAST_INSERT_ID(), pProductContainer);
    END //
DELIMITER ;

/*================================================*/

DROP PROCEDURE IF EXISTS show_product_info;

DELIMITER //
    CREATE PROCEDURE show_product_info ()
    BEGIN
        SELECT product.`product_id`, product.`name` as product_name, container.`name` as container_name
        FROM `wp_premio_product` as product
        INNER JOIN `wp_products_by_container` as products_by_container ON product.`product_id` = products_by_container.`product_product_id_fk`
        INNER JOIN `wp_premio_product_container` as container ON products_by_container.`product_container_id_fk` = container.`product_container_id`;
    END //
DELIMITER ;

/*================================================*/

DROP PROCEDURE IF EXISTS show_selected_container;

DELIMITER //
    CREATE PROCEDURE show_selected_container (IN pProductID INT)
    BEGIN
        SELECT container.`product_container_id` as container_id, container.`name` as container_name
        FROM `wp_premio_product` as product
        INNER JOIN `wp_products_by_container` as products_by_container ON product.`product_id` = products_by_container.`product_product_id_fk`
        INNER JOIN `wp_premio_product_container` as container ON products_by_container.`product_container_id_fk` = container.`product_container_id`
        WHERE product.`product_id` = pProductID;
    END //
DELIMITER ;

/*================================================*/

DROP PROCEDURE IF EXISTS update_product;

DELIMITER //
    CREATE PROCEDURE update_product (IN pProductID INT, IN pProductName VARCHAR(50), IN pProductContainerID INT)
    BEGIN
        UPDATE `wp_premio_product` SET name = pProductName WHERE product_id = pProductID;
        UPDATE `wp_products_by_container` SET product_container_id_fk = pProductContainerID; 
    END //
DELIMITER ;