<?php

function premio_products_container_create() {
    global $wpdb;
    $product_table = $wpdb->prefix . "premio_product";
    $name = $_POST["name"];
    $products = $wpdb->get_results("SELECT * from $product_table");
    //insert
    if (isset($_POST['insert'])) {
        $table_name = $wpdb->prefix . "premio_product_container";

        $wpdb->insert(
                $table_name, //table
                array('name' => $name), //data
                array('%s') //data format			
        );

        if(!empty($_POST['checkbox'])) {
            foreach($_POST["checkbox"] as $v) {
                $product_id_to_int = (int)$v;

                $last_inserted_product_container_id = $wpdb->get_row($wpdb->prepare(
                    "SELECT product_container_id as last_inserted_product_container_id FROM wp_premio_product_container ORDER BY product_container_id DESC LIMIT 1"
                ));

                $wpdb->insert(
                    $wpdb->prefix.'products_by_container', 
                    array(
                        'id_products_by_container' => NULL,
                        'product_product_id_fk' => $product_id_to_int, 
                        'product_container_id_fk' => $last_inserted_product_container_id->last_inserted_product_container_id)
                );
            }
        }

        $message.="Container inserted";
    }
    ?>
    <link type="text/css" href="<?php echo plugins_url(); ?>/premio-products-container/style-admin.css" rel="stylesheet" />
    <div class="wrap">
        <h2 class="testJC">Add New Container</h2>
        <?php if (isset($message)): ?><div class="updated"><p><?php echo $message; ?></p></div><?php endif; ?>
        <form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
            <table class='wp-list-table widefat fixed'>
                <tr>
                    <th class="ss-th-width">Container name</th>
                    <td><input type="text" name="name" value="<?php echo $name; ?>" class="ss-field-width" /></td>
                </tr>
                <tr>
                    <th class="ss-th-width">Products</th>
                    <td>
                        <?php foreach ($products as $product) { ?>
                            <input name="checkbox[]" type="checkbox" id="checkbox[]" value="<?php echo $product->product_id; ?>"> <?php echo $product->name; ?> <br>
                        <?php } ?>
                    </td>
                </tr>
            </table>
            <input type='submit' name="insert" value='Save' class='button'>
        </form>
        <div class="tablenav top">
            <div class="alignleft actions">
                <a href="<?php echo admin_url('admin.php?page=premio_products_container_list'); ?>">Back to Product Containers</a>
            </div>
            <br class="clear">
        </div>
    </div>
    <?php
}