<?php

function premio_images_create() {
    // Set images values
    global $wpdb;

    $resource_id = $_POST["resource_id"];
    $url = $_POST["url"];
    $image_type_id = $_POST["imageTypeDpw"];
    $general_image_type_id = $_POST["generalImageTypeDpw"];

    $image_types_table = $wpdb->prefix . "premio_image_type";
    $image_types = $wpdb->get_results("SELECT * from $image_types_table");

    $general_image_types_table = $wpdb->prefix . "premio_general_image_type";
    $general_image_types = $wpdb->get_results("SELECT * from $general_image_types_table");

    //insert
    if (isset($_POST['insert'])) {
        $table_name = $wpdb->prefix . "premio_image";

        $wpdb->query("CALL create_image( '{$resource_id}', '{$url}', '{$image_type_id}', '{$general_image_type_id}' )");

        $message.="Image inserted";
    }
    ?>
    <link type="text/css" href="<?php echo plugins_url(); ?>/premio-products-container/style-admin.css" rel="stylesheet" />
    <div class="wrap">
        <h2 class="newImage">Add New Image</h2>
        <?php if (isset($message)): ?><div class="updated"><p><?php echo $message; ?></p></div><?php endif; ?>
        <form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
            <table class='wp-list-table widefat fixed'>
                <tr>
                    <th class="ss-th-width">Resource ID</th>
                    <td><input type="number" name="resource_id" value="<?php echo $resource_id; ?>" class="ss-field-width" /></td>
                </tr>
                <tr>
                    <th class="ss-th-width">URL</th>
                    <td><input type="text" name="url" value="<?php echo $url; ?>" class="ss-field-width" /></td>
                </tr>
                <tr>
                    <th class="ss-th-width">Image Type</th>
                    <td>
                        <select name="imageTypeDpw">
                            <?php foreach ($image_types as $image_type) { ?>
                                <option value="<?php echo $image_type->id_image_type; ?>"><?php echo $image_type->name; ?></option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th class="ss-th-width">General Image Type</th>
                    <td>
                        <select name="generalImageTypeDpw">
                            <?php foreach ($general_image_types as $general_image_type) { ?>
                                <option value="<?php echo $general_image_type->id_general_image_type; ?>"><?php echo $general_image_type->name; ?></option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>
            </table>
            <input type='submit' name="insert" value='Save' class='button'>
        </form>
        <div class="tablenav top">
            <div class="alignleft actions">
                <a href="<?php echo admin_url('admin.php?page=premio_images_list'); ?>">Back to Images</a>
            </div>
            <br class="clear">
        </div>
    </div>
    <?php
}