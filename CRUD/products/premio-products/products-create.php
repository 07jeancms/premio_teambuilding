<?php

function premio_products_create() {
    $name = $_POST["name"];
    //insert
    if (isset($_POST['insert'])) {
        global $wpdb;
        $table_name = $wpdb->prefix . "premio_product";

        $wpdb->insert(
                $table_name, //table
                array('name' => $name), //data
                array('%s') //data format			
        );
        $message.="Product inserted";
    }
    ?>
    <link type="text/css" href="<?php echo WP_PLUGIN_URL; ?>/premio-products/style-admin.css" rel="stylesheet" />
    <div class="wrap">
        <h2>Add New Product</h2>
        <?php if (isset($message)): ?><div class="updated"><p><?php echo $message; ?></p></div><?php endif; ?>
        <form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
            <table class='wp-list-table widefat fixed'>
                <tr>
                    <th class="ss-th-width">Product</th>
                    <td><input type="text" name="name" value="<?php echo $name; ?>" class="ss-field-width" /></td>
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