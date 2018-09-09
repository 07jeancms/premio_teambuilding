<?php
/*
Plugin Name: Products
Description: This plugin will allow us to perform CRUD operations over premio products table
Version: 1
Author: LEAPP Corporation
*/
// function to create the DB / Options / Defaults					
function ss_options_install_products() {

    global $wpdb;

    $table_name = $wpdb->prefix . "premio_product";
    $charset_collate = $wpdb->get_charset_collate();
    $sql = "CREATE TABLE $table_name (
            `product_id` INT NOT NULL AUTO_INCREMENT,
            `name` VARCHAR(50) NOT NULL,
            PRIMARY KEY (`product_id`),
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
	add_menu_page('Products', //page title
	'Products', //menu title
	'manage_options', //capabilities
	'premio_products_list', //menu slug
	'premio_products_list' //function
	);
	
	//this is a submenu
	add_submenu_page('premio_products_list', //parent slug
	'Add New Product', //page title
	'Add New', //menu title
	'manage_options', //capability
	'premio_products_create', //menu slug
	'premio_products_create'); //function
	
	//this submenu is HIDDEN, however, we need to add it anyways
	add_submenu_page(null, //parent slug
	'Update Product', //page title
	'Update', //menu title
	'manage_options', //capability
	'premio_products_update', //menu slug
	'premio_products_update'); //function
}
define('ROOTDIR', plugin_dir_path(__FILE__));
require_once('products-create.php');
require_once('products-list.php');
require_once('products-update.php');
