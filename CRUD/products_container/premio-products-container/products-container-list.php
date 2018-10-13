<?php

function premio_products_container_list() {
    ?>
    <link type="text/css" href="<?php echo plugins_url(); ?>/premio-products-container/style-admin.css" rel="stylesheet" />
    <div class="wrap">
        <h2>Product Containers</h2>
        <div class="tablenav top">
            <div class="alignleft actions">
                <a href="<?php echo admin_url('admin.php?page=premio_products_container_create'); ?>">Add New</a>
            </div>
            <br class="clear">
        </div>
        <?php
        global $wpdb;
        $table_name = $wpdb->prefix . "premio_product_container";

        $rows = $wpdb->get_results("SELECT product_container_id, name from $table_name");
        ?>
        <table class='wp-list-table widefat fixed striped posts'>
            <tr>
                <th class="manage-column ss-list-width">ID</th>
                <th class="manage-column ss-list-width">Container</th>
                <th class="manage-column ss-list-width">Products</th>
                <th class="manage-column ss-list-width">Action</th>
                <th>&nbsp;</th>
            </tr>
            <?php foreach ($rows as $row) { ?>
                <tr>
                    <td class="manage-column ss-list-width"><?php echo $row->product_container_id; ?></td>
                    <td class="manage-column ss-list-width"><?php echo $row->name; ?></td>
                    <td>
                    <?php 
                        $products_by_container = $wpdb->get_results($wpdb->prepare(
                            "CALL show_products_by_container('{$row->product_container_id}')"
                        ));
                    ?>
                        <?php foreach ($products_by_container as $product) { ?>
                            <input name="checkbox[]" type="checkbox" value="<?php echo $product->product_id; ?>" disabled> <?php echo $product->product_name; ?> <br>
                        <?php } ?>
                    </td>
                    <td><a href="<?php echo admin_url('admin.php?page=premio_products_container_update&product_container_id=' . $row->product_container_id); ?>">Update</a></td>
                </tr>
            <?php } ?>
        </table>
    </div>
    <?php
}