
--    _____               _            _       
--   |  __ \             | |          | |      
--   | |__) | __ ___   __| |_   _  ___| |_ ___ 
--   |  ___/ '__/ _ \ / _` | | | |/ __| __/ __|
--   | |   | | | (_) | (_| | |_| | (__| |_\__ \
--   |_|   |_|  \___/ \__,_|\__,_|\___|\__|___/
--                                             
--                                             


DROP PROCEDURE IF EXISTS create_product;

DELIMITER //
    CREATE PROCEDURE create_product (IN pName VARCHAR(50), IN pDescription TEXT, IN pProductContainerID INT, IN pProgramID INT)
    BEGIN
        DECLARE last_inserted_product_id INT;
        INSERT INTO wp_premio_product VALUES(NULL, pName, pDescription);
        SET last_inserted_product_id = LAST_INSERT_ID();
        INSERT INTO wp_products_by_container VALUE(NULL, last_inserted_product_id, pProductContainerID);
        INSERT INTO wp_premio_product_by_program VALUE(NULL, pProgramID, last_inserted_product_id);
    END //
DELIMITER ;

/*================================================*/

DROP PROCEDURE IF EXISTS show_product_info;

DELIMITER //
    CREATE PROCEDURE show_product_info ()
    BEGIN
        SELECT product.`product_id`, product.`name` as product_name, product.`description` as product_description, container.`name` as container_name,
                program.`name` as program_name
        FROM `wp_premio_product` as product
        INNER JOIN `wp_products_by_container` as products_by_container ON product.`product_id` = products_by_container.`product_product_id_fk`
        INNER JOIN `wp_premio_product_container` as container ON products_by_container.`product_container_id_fk` = container.`product_container_id`
        INNER JOIN `wp_premio_product_by_program` as product_by_program ON product.`product_id` = product_by_program.`product_id_fk`
        INNER JOIN `wp_premio_program` as program ON product_by_program.`program_id_fk` = program.`program_id`;
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
    CREATE PROCEDURE update_product (IN pProductID INT, IN pProductName VARCHAR(50), IN pProductDescription TEXT, IN pProductContainerID INT, 
                                    IN pProductProgramID INT)
    BEGIN
        UPDATE `wp_premio_product` SET name = pProductName, description = pProductDescription WHERE product_id = pProductID;
        UPDATE `wp_products_by_container` SET product_container_id_fk = pProductContainerID where product_product_id_fk = pProductID;
        UPDATE `wp_premio_product_by_program` SET program_id_fk = pProductProgramID where product_id_fk = pProductID;
    END //
DELIMITER ;

/*================================================*/

DROP PROCEDURE IF EXISTS delete_product;

DELIMITER //
    CREATE PROCEDURE delete_product (IN pProductID INT)
    BEGIN
        DELETE FROM `wp_products_by_container` WHERE product_product_id_fk = pProductID; 
        DELETE FROM `wp_premio_product_by_program` WHERE product_id_fk = pProductID;
        DELETE FROM `wp_premio_product` WHERE product_id = pProductID;
    END //
DELIMITER ;


--    _____                                         
--   |  __ \                                        
--   | |__) | __ ___   __ _ _ __ __ _ _ __ ___  ___ 
--   |  ___/ '__/ _ \ / _` | '__/ _` | '_ ` _ \/ __|
--   | |   | | | (_) | (_| | | | (_| | | | | | \__ \
--   |_|   |_|  \___/ \__, |_|  \__,_|_| |_| |_|___/
--                     __/ |                        
--                    |___/                         


DROP PROCEDURE IF EXISTS create_program;

DELIMITER //
    CREATE PROCEDURE create_program (IN pName VARCHAR(60), IN pDescription TEXT, IN pLocation VARCHAR(60), IN pAmountOfParticipants VARCHAR(60),
                                    IN pDuration VARCHAR(60), IN pParticipationType VARCHAR(60), IN pTopOutcomes VARCHAR(400), IN pIconLabels VARCHAR(400),
                                    IN pVideoURL TEXT)
    BEGIN
        INSERT INTO `wp_premio_program` VALUES(NULL, pName, pDescription, pLocation, pAmountOfParticipants, pDuration, pParticipationType, 
                                                pTopOutcomes, pIconLabels, pVideoURL);
    END //
DELIMITER ;

/*================================================*/

DROP PROCEDURE IF EXISTS update_program;

DELIMITER //
    CREATE PROCEDURE update_program (IN pProgramID INT, IN pProgramName VARCHAR(60), IN pDescription TEXT, IN pLocation VARCHAR(60),
                                    IN pAmountOfParticipants VARCHAR(60), IN pDuration VARCHAR(60), IN pParticipationType VARCHAR(60),
                                    IN pTopOutcomes VARCHAR(400), IN pIconLabels VARCHAR(400))
    BEGIN
        UPDATE `wp_premio_program` SET name = pProgramName, description = pDescription, location = pLocation, amount_of_participants = pAmountOfParticipants,
                                    duration = pDuration, participation_type = pParticipationType, top_outcomes = pTopOutcomes, icon_labels = pIconLabels 
                                    WHERE program_id = pProgramID;
    END //
DELIMITER ;

/*================================================*/

DROP PROCEDURE IF EXISTS show_selected_program;

DELIMITER //
    CREATE PROCEDURE show_selected_program (IN pProductID INT)
    BEGIN
        SELECT program.`program_id` as program_id, container.`name` as container_name
        FROM `wp_premio_product` as product
        INNER JOIN `wp_premio_product_by_program` as products_by_program ON product.`product_id` = products_by_program.`product_id_fk`
        INNER JOIN `wp_premio_program` as program ON products_by_program.`program_id_fk` = program.`program_id`
        WHERE product.`product_id` = pProductID;
    END //
DELIMITER ;

/*================================================*/

DROP PROCEDURE IF EXISTS show_selected_program;

DELIMITER //
    CREATE PROCEDURE show_selected_program (IN pProductID INT)
    BEGIN
        SELECT program.`program_id` as program_id, program.`name` as program_name
        FROM `wp_premio_product` as product
        INNER JOIN `wp_premio_product_by_program` as products_by_program ON product.`product_id` = products_by_program.`product_id_fk`
        INNER JOIN `wp_premio_program` as program ON products_by_program.`program_id_fk` = program.`program_id`
        WHERE product.`product_id` = pProductID;
    END //
DELIMITER ;











