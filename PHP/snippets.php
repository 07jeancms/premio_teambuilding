#    _____  _           _                 _____                                         
#   |  __ \(_)         | |               |  __ \                                        
#   | |  | |_ ___ _ __ | | __ _ _   _    | |__) | __ ___   __ _ _ __ __ _ _ __ ___  ___ 
#   | |  | | / __| '_ \| |/ _` | | | |   |  ___/ '__/ _ \ / _` | '__/ _` | '_ ` _ \/ __|
#   | |__| | \__ \ |_) | | (_| | |_| |   | |   | | | (_) | (_| | | | (_| | | | | | \__ \
#   |_____/|_|___/ .__/|_|\__,_|\__, |   |_|   |_|  \___/ \__, |_|  \__,_|_| |_| |_|___/
#                | |             __/ |_____                __/ |                        
#                |_|            |___/______|              |___/                         

global $wpdb;
	$programs = $wpdb->get_results('SELECT *FROM `webtoffee_premio_program` program inner join `webtoffee_premio_product_by_program`  pbp on program.program_id = pbp.program_id_fk;');
    $images = $wpdb->get_results('SELECT * FROM `webtoffee_premio_image` image  WHERE general_image_type_fk = 2 AND image_type_fk =1;');
	echo("<script type=\"text/javascript\"> 
    	console.log(".json_encode($programs).");
     onProgramsFetch(".json_encode($programs).",".json_encode($images).") 
     </script>");

#    _      _     _   _____               _            _       
#   | |    (_)   | | |  __ \             | |          | |      
#   | |     _ ___| |_| |__) | __ ___   __| |_   _  ___| |_ ___ 
#   | |    | / __| __|  ___/ '__/ _ \ / _` | | | |/ __| __/ __|
#   | |____| \__ \ |_| |   | | | (_) | (_| | |_| | (__| |_\__ \
#   |______|_|___/\__|_|   |_|  \___/ \__,_|\__,_|\___|\__|___/
#                                                              
#           
global $wpdb;

$rows = $wpdb->get_results("SELECT product_id, name from `webtoffee_premio_product`");

foreach($rows as $row) {
  echo('Product Name: ' . $row->name);
}

#    _____  _           _             _____               _            _       
#   |  __ \(_)         | |           |  __ \             | |          | |      
#   | |  | |_ ___ _ __ | | __ _ _   _| |__) | __ ___   __| |_   _  ___| |_ ___ 
#   | |  | | / __| '_ \| |/ _` | | | |  ___/ '__/ _ \ / _` | | | |/ __| __/ __|
#   | |__| | \__ \ |_) | | (_| | |_| | |   | | | (_) | (_| | |_| | (__| |_\__ \
#   |_____/|_|___/ .__/|_|\__,_|\__, |_|   |_|  \___/ \__,_|\__,_|\___|\__|___/
#                | |             __/ |                                         
#                |_|            |___/                                          
global $wpdb;
	$programs = $wpdb->get_results('SELECT *FROM `webtoffee_premio_program` program inner join `webtoffee_premio_product_by_program`  pbp on program.program_id = pbp.program_id_fk;');
	$rows = $wpdb->get_results('SELECT * from `webtoffee_premio_product`  product LEFT JOIN webtoffee_premio_image image ON product.product_id =image.resource_id WHERE image.image_type_fk = 2 ;');
    $images = $wpdb->get_results('SELECT * FROM `webtoffee_premio_image` image  WHERE general_image_type_fk = 2 AND image_type_fk =1;');
	echo("<script type=\"text/javascript\"> 
    	console.log(".json_encode($programs).");
     onProductsFetch(".json_encode($rows).",".json_encode($programs).",".json_encode($images).") 
     </script>");

