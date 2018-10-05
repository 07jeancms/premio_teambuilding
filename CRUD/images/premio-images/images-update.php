<?php

function premio_images_update() {
    global $wpdb;

    $table_name = $wpdb->prefix . "premio_image";

    $image_type_table = $wpdb->prefix . "premio_image_type";
    $general_image_type_table = $wpdb->prefix . "premio_general_image_type";

    $image_types = $wpdb->get_results("SELECT * from $image_type_table");
    $general_image_types = $wpdb->get_results("SELECT * from $general_image_type_table");    

    $image_id = $_GET["image_id"];
    $resource_id = $_POST["resource_id"];
    $url = $_POST["url"];
    $post_image_type_id = $_POST['imageTypeDpw'];
    $post_general_image_type_id = $_POST['generalImageTypeDpw'];

    $selected_image_type = $wpdb->get_row($wpdb->prepare(
        "CALL show_selected_image_type('{$image_id}')"
    ));

    $selected_general_image_type = $wpdb->get_results($wpdb->prepare(
        "CALL show_selected_general_image_type('{$image_id}')"
    ));  

    //update
    if (isset($_POST['update'])) {
        $wpdb->query("CALL update_image( '{$image_id}', '{$resource_id}', '{$url}', '{$post_image_type_id}', '{$post_general_image_type_id}' )");
    }
    //delete
    else if (isset($_POST['delete'])) {
        $wpdb->query("CALL delete_image('{$image_id}')");
    } else {
        //selecting value to update	
        $images = $wpdb->get_results($wpdb->prepare("SELECT * from $table_name where image_id=%s", $image_id));
        foreach ($images as $image) {
            $resource_id = $image->resource_id;
            $url = $image->url;
        }
    }
    ?>
    <link type="text/css" href="<?php echo plugins_url(); ?>/premio-products/style-admin.css" rel="stylesheet" />
    <div class="wrap">
        <h2>Image</h2>

        <?php if ($_POST['delete']) { ?>
            <div class="updated"><p>Image deleted</p></div>
            <a href="<?php echo admin_url('admin.php?page=premio_images_list') ?>">&laquo; Back to images list</a>

        <?php } else if ($_POST['update']) { ?>
            <div class="updated"><p>Image updated</p></div>
            <a href="<?php echo admin_url('admin.php?page=premio_images_list') ?>">&laquo; Back to images list</a>

        <?php } else { ?>

            <form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
                <table class='wp-list-table widefat fixed'>
                    <tr>
                        <th>RESOURCE_ID</th>
                        <td><input type="text" name="resource_id" value="<?php echo $resource_id; ?>"/></td>
                    </tr>
                    <tr>
                        <th>URL</th>
                        <td><textarea name="url" rows="5" cols="20"><?php echo $url; ?></textarea></td>
                    </tr>
                    <tr>
                        <th>IMAGE TYPE</th>
                        <td>
                            <select name="imageTypeDpw">
                                <?php foreach ($image_types as $image_type) { ?>
                                    <option value="<?php echo $container->product_container_id; ?>" 
                                        <?php 
                                            if($image_type->id_image_type == $selected_image_type->id){
                                                echo "selected";
                                            } 
                                        ?>>
                                        <?php echo $image_type->name; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>GENERAL IMAGE TYPE</th>
                        <td>
                            <select name="generalImageTypeDpw">
                                <?php foreach ($general_image_types as $general_image_type) { ?>
                                    <option value="<?php echo $general_image_type->id_general_image_type; ?>" 
                                        <?php 
                                            if($general_image_type->id_general_image_type == $selected_general_image_type->id){
                                                echo "selected";
                                            } 
                                        ?>>
                                        <?php echo $general_image_type->name; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                </table>
                <input type='submit' name="update" value='Save' class='button'> &nbsp;&nbsp;
                <input type='submit' name="delete" value='Delete' class='button' onclick="return confirm('&iquest;Est&aacute;s seguro de borrar este elemento?')">
            </form>

        <?php } ?>

    </div>
    <?php
}