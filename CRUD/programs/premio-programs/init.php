<?php
/*
Plugin Name: Programs
Description: This plugin will allow us to perform CRUD operations over premio Programs table
Version: 1
Author: LEAPP Corporation
*/
// function to create the DB / Options / Defaults					
function ss_options_install_programs() {

    global $wpdb;

    $table_name = $wpdb->prefix . "premio_program";
    $charset_collate = $wpdb->get_charset_collate();
    $sql = "CREATE TABLE $table_name (
            `program_id` INT NOT NULL AUTO_INCREMENT,
            `name` VARCHAR(60) NOT NULL,
			`description` TEXT NOT NULL,
			`location` VARCHAR(60) NOT NULL,
			`amount_of_participants` VARCHAR(60) NOT NULL,
			`duration` VARCHAR(60) NOT NULL,
			`participation_type` VARCHAR(60) NOT NULL,
            PRIMARY KEY (`program_id`),
			UNIQUE INDEX `program_id_UNIQUE` (`program_id` ASC) VISIBLE,
			UNIQUE INDEX `name_UNIQUE` (`name` ASC) VISIBLE)
          ) $charset_collate; ";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta($sql);
}

// run the install scripts upon plugin activation
register_activation_hook(__FILE__, 'ss_options_install_programs');

//menu items
add_action('admin_menu','premio_programs_modifymenu');
function premio_programs_modifymenu() {
	
	//this is the main item for the menu
	add_menu_page('Programs', //page title
	'Programs', //menu title
	'manage_options', //capabilities
	'premio_programs_list', //menu slug
	'premio_programs_list' //function
	);
	
	//this is a submenu
	add_submenu_page('premio_programs_list', //parent slug
	'Add New Program', //page title
	'Add New', //menu title
	'manage_options', //capability
	'premio_programs_create', //menu slug
	'premio_programs_create'); //function
	
	//this submenu is HIDDEN, however, we need to add it anyways
	add_submenu_page(null, //parent slug
	'Update Program', //page title
	'Update', //menu title
	'manage_options', //capability
	'premio_programs_update', //menu slug
	'premio_programs_update'); //function
}
define('ROOTDIR', plugin_dir_path(__FILE__));
require_once('programs-create.php');
require_once('programs-list.php');
require_once('programs-update.php');
