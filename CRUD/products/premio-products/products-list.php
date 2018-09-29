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

        $products = $wpdb->get_results($wpdb->prepare(
            "CALL show_product_info()"
        ));

        ?>
        <table class='wp-list-table widefat fixed striped posts'>
            <tr>
                <th class="manage-column ss-list-width">ID</th>
                <th class="manage-column ss-list-width">PRODUCT</th>
                <th class="manage-column ss-list-width">DESCRIPTION</th>
                <th class="manage-column ss-list-width">CONTAINER</th>
                <th class="manage-column ss-list-width">PROGRAMS</th>
                <th class="manage-column ss-list-width">ACTION</th>
                <th>&nbsp;</th>
            </tr>
            <?php foreach ($products as $product) { ?>
                <tr>
                    <td class="manage-column ss-list-width"><?php echo $product->product_id; ?></td>
                    <td class="manage-column ss-list-width"><?php echo $product->product_name; ?></td>
                    <td class="manage-column ss-list-width">
                        <textarea products="5" cols="20" readonly><?php echo $product->product_description; ?></textarea>
                    </td>
                    <td class="manage-column ss-list-width"><?php echo $product->container_name; ?></td>
                    <td>
                    <?php 
                        $programs_by_product = $wpdb->get_results($wpdb->prepare(
                            "CALL show_product_programs('{$product_id}')"
                        ));
                    ?>
                        <?php foreach ($programs_by_product as $program) { ?>
                            <input name="checkbox[]" type="checkbox" value="<?php echo $program->program_id; ?>" disabled> <?php echo $program->program_name; ?> <br>
                        <?php } ?>
                    </td>
                    <td><a href="<?php echo admin_url('admin.php?page=premio_products_update&product_id=' . $product->product_id); ?>">Update</a></td>
                </tr>
            <?php } ?>
        </table>
    </div>
    <?php
}