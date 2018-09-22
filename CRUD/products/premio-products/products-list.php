<?php

function premio_products_list() {
    ?>
    <link type="text/css" href="<?php echo plugins_url(); ?>/premio-products/style-admin.css" rel="stylesheet" />
    <div class="wrap">
        <h2>Products</h2>
        <div class="tablenav top">
            <div class="alignleft actions">
                <a href="<?php echo admin_url('admin.php?page=premio_products_create'); ?>">Add New</a>
            </div>
            <br class="clear">
        </div>
        <?php
        global $wpdb;

        $rows = $wpdb->get_results($wpdb->prepare(
            "CALL show_product_info()"
        ));

        ?>
        <table class='wp-list-table widefat fixed striped posts'>
            <tr>
                <th class="manage-column ss-list-width">ID</th>
                <th class="manage-column ss-list-width">PRODUCT</th>
                <th class="manage-column ss-list-width">CONTAINER</th>
                <th class="manage-column ss-list-width">ACTION</th>
                <th>&nbsp;</th>
            </tr>
            <?php foreach ($rows as $row) { ?>
                <tr>
                    <td class="manage-column ss-list-width"><?php echo $row->product_id; ?></td>
                    <td class="manage-column ss-list-width"><?php echo $row->product_name; ?></td>
                    <td class="manage-column ss-list-width"><?php echo $row->container_name; ?></td>
                    <td><a href="<?php echo admin_url('admin.php?page=premio_products_update&product_id=' . $row->product_id); ?>">Update</a></td>
                </tr>
            <?php } ?>
        </table>
    </div>
    <?php
}