<?php
/*
Plugin Name: Products
Description: This plugin will allow us to perform CRUD operations over premio products table
Version: 1
Author: LEAPP Corporation
*/
// function to create the DB / Options / Defaults					
function ss_options_install_products_container() {

    global $wpdb;

    $table_name = $wpdb->prefix . "premio_product_container";
    $charset_collate = $wpdb->get_charset_collate();
    $sql = "CREATE TABLE $table_name (
            `product_container_id` INT NOT NULL AUTO_INCREMENT,
            `name` VARCHAR(80) NOT NULL,
            PRIMARY KEY (`product_container_id`),
			UNIQUE INDEX `wp_premio_premio_container_id_UNIQUE` (`product_container_id` ASC) VISIBLE,
			UNIQUE INDEX `name_UNIQUE` (`name` ASC) VISIBLE)
          ) $charset_collate; ";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta($sql);

}

// run the install scripts upon plugin activation
register_activation_hook(__FILE__, 'ss_options_install_products');

//menu items
add_action('admin_menu','premio_products_modifymenu');
function premio_products_modifymenu() {
	
	//this is the main item for the menu
	add_menu_page('Product Containers', //page title
	'Product Containers', //menu title
	'manage_options', //capabilities
	'premio_product_container_list', //menu slug
	'premio_product_container_list' //function
	);
	
	//this is a submenu
	add_submenu_page('premio_product_container_list', //parent slug
	'Add New Container', //page title
	'Add New', //menu title
	'manage_options', //capability
	'premio_product_container_create', //menu slug
	'premio_product_container_create'); //function
	
	//this submenu is HIDDEN, however, we need to add it anyways
	add_submenu_page(null, //parent slug
	'Update Container', //page title
	'Update', //menu title
	'manage_options', //capability
	'premio_product_container_update', //menu slug
	'premio_product_container_update'); //function
}
define('ROOTDIR', plugin_dir_path(__FILE__));
require_once('products-container-create.php');
require_once('products-container-list.php');
require_once('products-container-update.php');
