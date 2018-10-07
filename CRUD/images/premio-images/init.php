<?php
/*
Plugin Name: Images
Description: This plugin will allow us to perform CRUD operations over 'wp_premio_image' table
Version: 1
Author: LEAPP Corporation
*/
// function to create the DB / Options / Defaults					
function ss_options_install_images() {

    global $wpdb;

    $table_name = $wpdb->prefix . "wp_premio_image";
    $charset_collate = $wpdb->get_charset_collate();
    $sql = "CREATE TABLE $table_name (
            `image_id` INT NOT NULL AUTO_INCREMENT,
            `resource_id` INT NOT NULL,
            `url` TEXT NOT NULL,
            `image_type_fk` INT NOT NULL,
            `general_image_type_fk` INT NOT NULL,
            PRIMARY KEY (`image_id`),
			UNIQUE INDEX `image_ID_UNIQUE` (`image_id` ASC),
			INDEX `fk_wp_premio_image_wp_premio_image_type1_idx` (`image_type_fk` ASC),
            INDEX `fk_wp_premio_image_wp_general_image_type1_idx` (`general_image_type_fk` ASC)
          ) $charset_collate; ";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta($sql);

}

// run the install scripts upon plugin activation
register_activation_hook(__FILE__, 'ss_options_install_products');

//menu items
add_action('admin_menu','premio_images_modifymenu');
function premio_images_modifymenu() {
	
	//this is the main item for the menu
	add_menu_page('Images', //page title
	'Images', //menu title
	'manage_options', //capabilities
	'premio_images_list', //menu slug
	'premio_images_list' //function
	);
	
	//this is a submenu
	add_submenu_page('premio_images_list', //parent slug
	'Add New Image', //page title
	'Add New', //menu title
	'manage_options', //capability
	'premio_images_create', //menu slug
	'premio_images_create'); //function
	
	//this submenu is HIDDEN, however, we need to add it anyways
	add_submenu_page(null, //parent slug
	'Update Image', //page title
	'Update', //menu title
	'manage_options', //capability
	'premio_images_update', //menu slug
	'premio_images_update'); //function
}
define('ROOTDIR', plugin_dir_path(__FILE__));
require_once('images-create.php');
require_once('images-list.php');
require_once('images-update.php');
