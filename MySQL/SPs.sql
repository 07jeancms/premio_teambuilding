
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
    CREATE PROCEDURE create_product (IN pName VARCHAR(50), IN pDescription TEXT, IN pProductContainerID INT)
    BEGIN
        DECLARE last_inserted_product_id INT;
        INSERT INTO wp_premio_product VALUES(NULL, pName, pDescription);
        SET last_inserted_product_id = LAST_INSERT_ID();
        INSERT INTO wp_products_by_container VALUE(NULL, last_inserted_product_id, pProductContainerID);
    END //
DELIMITER ;

/*================================================*/

DROP PROCEDURE IF EXISTS show_product_info;

DELIMITER //
    CREATE PROCEDURE show_product_info ()
    BEGIN
        SELECT product.`product_id`, product.`name` as product_name, product.`description` as product_description, container.`name` as container_name
        FROM `wp_premio_product` as product
        INNER JOIN `wp_products_by_container` as products_by_container ON product.`product_id` = products_by_container.`product_product_id_fk`
        INNER JOIN `wp_premio_product_container` as container ON products_by_container.`product_container_id_fk` = container.`product_container_id`;
    END //
DELIMITER ;

/*================================================*/

DROP PROCEDURE IF EXISTS show_product_programs;

DELIMITER //
    CREATE PROCEDURE show_product_programs (IN pPoductID INT)
    BEGIN
        SELECT product.`product_id` as product_id, program.`program_id` as program_id, program.`name` as program_name
        FROM `wp_premio_product` as product
        INNER JOIN `wp_premio_product_by_program` as product_by_program ON product.`product_id` = product_by_program.`product_id_fk`
        INNER JOIN `wp_premio_program` as program ON product_by_program.`program_id_fk` = program.`program_id`
        where product.`product_id` = pPoductID;
    END //
DELIMITER ;

/*================================================*/

DROP PROCEDURE IF EXISTS show_missing_programs_for_product;

DELIMITER //
    CREATE PROCEDURE show_missing_programs_for_product (IN pProductID INT)
    BEGIN
    SELECT * FROM wp_premio_program p WHERE p.program_id NOT IN 
    (
            SELECT program.`program_id` as program_id
            FROM `wp_premio_product` as product
            INNER JOIN `wp_premio_product_by_program` as product_by_program ON product.`product_id` = product_by_program.`product_id_fk`
            INNER JOIN `wp_premio_program` as program ON product_by_program.`program_id_fk` = program.`program_id`
            WHERE product.`product_id` = pProductID
    );
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

/*================================================*/

DROP PROCEDURE IF EXISTS delete_products_by_program;

DELIMITER //
    CREATE PROCEDURE delete_products_by_program (IN pProductID INT)
    BEGIN
        DELETE FROM `wp_premio_product_by_program` WHERE product_id_fk = pProductID;
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
                                    IN pTopOutcomes VARCHAR(400), IN pIconLabels VARCHAR(400), IN pVideoURL TEXT)
    BEGIN
        UPDATE `wp_premio_program` SET name = pProgramName, description = pDescription, location = pLocation, amount_of_participants = pAmountOfParticipants,
                                    duration = pDuration, participation_type = pParticipationType, top_outcomes = pTopOutcomes, icon_labels = pIconLabels,
                                    video_url = pVideoURL 
                                    WHERE program_id = pProgramID;
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


--    _____                                 
--   |_   _|                                
--     | |  _ __ ___   __ _  __ _  ___  ___ 
--     | | | '_ ` _ \ / _` |/ _` |/ _ \/ __|
--    _| |_| | | | | | (_| | (_| |  __/\__ \
--   |_____|_| |_| |_|\__,_|\__, |\___||___/
--                           __/ |          
--                          |___/           


DROP PROCEDURE IF EXISTS create_image;

DELIMITER //
    CREATE PROCEDURE create_image (IN pResourceID INT, IN pURL TEXT, IN pImageType INT, IN pGeneralImageType INT)
    BEGIN
        INSERT INTO wp_premio_image VALUES(NULL, pResourceID, pURL, pImageType, pGeneralImageType);
    END //
DELIMITER ;

/*================================================*/

DROP PROCEDURE IF EXISTS show_images_info;

DELIMITER //
    CREATE PROCEDURE show_images_info()
    BEGIN
        SELECT image.`image_id`, image.`resource_id`, image.`url`, image_type.`name` as image_type, general_image_type.`name` as general_image_type
        FROM `wp_premio_image` as image
        INNER JOIN `wp_premio_image_type` as image_type ON image.`image_type_fk` = image_type.`id_image_type`
        INNER JOIN `wp_premio_general_image_type` as general_image_type ON image.`general_image_type_fk` = general_image_type.`id_general_image_type`;
    END //
DELIMITER ;

/*================================================*/

DROP PROCEDURE IF EXISTS show_selected_image_type;

DELIMITER //
    CREATE PROCEDURE show_selected_image_type (IN pImageID INT)
    BEGIN
        SELECT image_type.`id_image_type` as id, image_type.`name` as name
        FROM `wp_premio_image` as image
        INNER JOIN `wp_premio_image_type` as image_type ON image.`image_type_fk` = image_type.`id_image_type`
        WHERE image.`image_id` = pImageID;
    END //
DELIMITER ;

/*================================================*/

DROP PROCEDURE IF EXISTS show_selected_general_image_type;

DELIMITER //
    CREATE PROCEDURE show_selected_general_image_type (IN pImageID INT)
    BEGIN
        SELECT general_image_type.`id_general_image_type` as id, general_image_type.`name` as name
        FROM `wp_premio_image` as image
        INNER JOIN `wp_premio_general_image_type` as general_image_type ON image.`general_image_type_fk` = general_image_type.`id_general_image_type`
        WHERE image.`image_id` = pImageID;
    END //
DELIMITER ;

/*================================================*/

DROP PROCEDURE IF EXISTS update_image;

DELIMITER //
    CREATE PROCEDURE update_image (IN pImageID INT, IN pResourceID INT, IN pURL TEXT, IN pImageTypeFK INT, IN pGeneralImageTypeFK INT)
    BEGIN
        UPDATE `wp_premio_image` SET resource_id = pResourceID, url = pURL, image_type_fk = pImageTypeFK, 
                                        general_image_type_fk = pGeneralImageTypeFK WHERE image_id = pImageID;
    END //
DELIMITER ;

/*================================================*/

DROP PROCEDURE IF EXISTS delete_image;

DELIMITER //
    CREATE PROCEDURE delete_image (IN pImageID INT)
    BEGIN
        DELETE FROM `wp_premio_image` WHERE image_id = pImageID;
    END //
DELIMITER ;

--    _____               _            _      _____            _        _                     
--   |  __ \             | |          | |    / ____|          | |      (_)                    
--   | |__) | __ ___   __| |_   _  ___| |_  | |     ___  _ __ | |_ __ _ _ _ __   ___ _ __ ___ 
--   |  ___/ '__/ _ \ / _` | | | |/ __| __| | |    / _ \| '_ \| __/ _` | | '_ \ / _ \ '__/ __|
--   | |   | | | (_) | (_| | |_| | (__| |_  | |___| (_) | | | | || (_| | | | | |  __/ |  \__ \
--   |_|   |_|  \___/ \__,_|\__,_|\___|\__|  \_____\___/|_| |_|\__\__,_|_|_| |_|\___|_|  |___/
--                                                                                            
--                                                                                            

DROP PROCEDURE IF EXISTS show_products_by_container;

DELIMITER //
    CREATE PROCEDURE show_products_by_container (IN pContainerID INT)
    BEGIN
        SELECT product.`product_id` as product_id, product_container.`product_container_id` as product_container_id, product.`name` as product_name
        FROM `wp_premio_product` as product
        INNER JOIN `wp_products_by_container` as product_by_container ON product.`product_id` = product_by_container.`product_product_id_fk`
        INNER JOIN `wp_premio_product_container` as product_container ON product_by_container.`product_container_id_fk` = product_container.`product_container_id`
        where product_container.`product_container_id` = pContainerID;
    END //
DELIMITER ;

/*================================================*/

DROP PROCEDURE IF EXISTS missing_products_for_container;

DELIMITER //
    CREATE PROCEDURE missing_products_for_container (IN pContainerID INT)
    BEGIN
    SELECT * FROM wp_premio_product p WHERE p.product_id NOT IN 
    (
            SELECT product.`product_id` as product_id
            FROM `wp_premio_product` as product
            INNER JOIN `wp_products_by_container` as product_by_container ON product.`product_id` = product_by_container.`product_product_id_fk`
            INNER JOIN `wp_premio_product_container` as product_container ON product_by_container.`product_container_id_fk` = product_container.`product_container_id`
            WHERE product_container.`product_container_id` = pContainerID
    );
    END //
DELIMITER ;

/*================================================*/

DROP PROCEDURE IF EXISTS delete_products_by_container;

DELIMITER //
    CREATE PROCEDURE delete_products_by_container (IN pContainerID INT)
    BEGIN
        DELETE FROM `wp_products_by_container` WHERE product_container_id_fk = pContainerID;
    END //
DELIMITER ;

/*================================================*/

DROP PROCEDURE IF EXISTS delete_product_container;

DELIMITER //
    CREATE PROCEDURE delete_product_container (IN pContainerID INT)
    BEGIN
        DELETE FROM `wp_products_by_container` WHERE product_container_id_fk = pContainerID; 
        DELETE FROM `wp_premio_product_container` WHERE product_container_id = pContainerID;
    END //
DELIMITER ;