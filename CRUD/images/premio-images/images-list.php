<?php

function premio_images_list() {
    ?>
    <link type="text/css" href="<?php echo plugins_url(); ?>/premio-images/style-admin.css" rel="stylesheet" />
    <div class="wrap">
        <h2>Images</h2>
        <div class="tablenav top">
            <div class="alignleft actions">
                <a href="<?php echo admin_url('admin.php?page=premio_images_create'); ?>">Add New</a>
            </div>
            <br class="clear">
        </div>
        <?php
        global $wpdb;

        $images = $wpdb->get_results($wpdb->prepare(
            "CALL show_images_info()"
        ));

        ?>
        <table class='wp-list-table widefat fixed striped posts'>
            <tr>
                <th class="manage-column ss-list-width">ID</th>
                <th class="manage-column ss-list-width">RESOURCE_ID</th>
                <th class="manage-column ss-list-width">URL</th>
                <th class="manage-column ss-list-width">IMAGE TYPE</th>
                <th class="manage-column ss-list-width">GENERAL IMAGE TYPE</th>
                <th class="manage-column ss-list-width">ACTION</th>
                <th>&nbsp;</th>
            </tr>
            <?php foreach ($images as $image) { ?>
                <tr>
                    <td class="manage-column ss-list-width"><?php echo $image->image_id; ?></td>
                    <td class="manage-column ss-list-width"><?php echo $image->resource_id; ?></td>
                    <td class="manage-column ss-list-width">
                        <textarea images="5" cols="20" readonly><?php echo $image->url; ?></textarea>
                    </td>
                    <td class="manage-column ss-list-width"><?php echo $image->image_type; ?></td>
                    <td class="manage-column ss-list-width"><?php echo $image->general_image_type; ?></td>
                    <td><a href="<?php echo admin_url('admin.php?page=premio_images_update&image_id=' . $image->image_id); ?>">Update</a></td>
                </tr>
            <?php } ?>
        </table>
    </div>
    <?php
}