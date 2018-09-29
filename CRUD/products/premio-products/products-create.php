<?php

function premio_products_create() {
    // Set Product Containers values
    global $wpdb;
    $product_container_table = $wpdb->prefix . "premio_product_container";
    $program_table = $wpdb->prefix . "premio_program";
    $product_containers = $wpdb->get_results("SELECT * from $product_container_table");
    $programs = $wpdb->get_results("SELECT * from $program_table");

    $name = $_POST["name"];
    $description = $_POST["description"];
    $product_container_id = $_POST['productContainerDpw'];

    //insert
    if (isset($_POST['insert'])) {
        $table_name = $wpdb->prefix . "premio_product";

        $wpdb->query("CALL create_product('{$name}', '{$description}', '{$product_container_id}')");

        if(!empty($_POST['checkbox'])) {
            foreach($_POST["checkbox"] as $v) {
                $program_id_to_int = (int)$v;

                $last_inserted_product_id = $wpdb->get_row($wpdb->prepare(
                    "SELECT product_id as last_inserted_product_id FROM wp_premio_product ORDER BY product_id DESC LIMIT 1"
                ));

                $wpdb->insert(
                    $wpdb->prefix.'premio_product_by_program', 
                    array(
                        'product_by_program_id' => NULL,
                        'program_id_fk' => $program_id_to_int, 
                        'product_id_fk' => $last_inserted_product_id->last_inserted_product_id)
                );
            }
        }
        
        $message.="Product inserted";
    }
    ?>
    <link type="text/css" href="<?php echo plugins_url(); ?>/premio-products/style-admin.css" rel="stylesheet" />
    <div class="wrap">
        <h2 class="testJC">Add New Product</h2>
        <?php if (isset($message)): ?><div class="updated"><p><?php echo $message; ?></p></div><?php endif; ?>
        <form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
            <table class='wp-list-table widefat fixed'>
                <tr>
                    <th class="ss-th-width">Name</th>
                    <td><input type="text" name="name" value="<?php echo $name; ?>" class="ss-field-width" /></td>
                </tr>
                <tr>
                    <th class="ss-th-width">Description</th>
                    <td><textarea name="description" rows="5" cols="40" class="ss-field-width" /><?php echo $description; ?></textarea></td>
                </tr>
                <tr>
                    <th class="ss-th-width">Container</th>
                    <td>
                        <select name="productContainerDpw">
                            <?php foreach ($product_containers as $container) { ?>
                                <option value="<?php echo $container->product_container_id; ?>"><?php echo $container->name; ?></option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th class="ss-th-width">Programs</th>
                    <td>
                        <?php foreach ($programs as $program) { ?>
                            <input name="checkbox[]" type="checkbox" id="checkbox[]" value="<?php echo $program->program_id; ?>"> <?php echo $program->name; ?> <br>
                        <?php } ?>
                    </td>
                </tr>
            </table>
            <input type='submit' name="insert" value='Save' class='button'>
        </form>
        <div class="tablenav top">
            <div class="alignleft actions">
                <a href="<?php echo admin_url('admin.php?page=premio_products_list'); ?>">Back to Products</a>
            </div>
            <br class="clear">
        </div>
    </div>
    <?php
}