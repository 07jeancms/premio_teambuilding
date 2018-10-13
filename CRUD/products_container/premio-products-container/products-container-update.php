<?php

function premio_products_container_update() {
    global $wpdb;
    $table_name = $wpdb->prefix . "premio_product_container";
    $product_table = $wpdb->prefix . "premio_product";
    
    $product_container_id = $_GET["product_container_id"];
    $name = $_POST["name"];

    $products = $wpdb->get_results("SELECT * from $product_table");

    $selected_products = $wpdb->get_results($wpdb->prepare(
        "CALL show_products_by_container('{$product_container_id}')"
    ));

    $missing_products_for_container = $wpdb->get_results($wpdb->prepare(
        "CALL missing_products_for_container('{$product_container_id}')"
    ));    


    //update
    if (isset($_POST['update'])) {
        $wpdb->update(
                $table_name, //table
                array('name' => $name), //data
                array('product_container_id' => $product_container_id), //where
                array('%s'), //data format
                array('%s') //where format
        );

        $wpdb->query("CALL delete_products_by_container( '{$product_container_id}' )");

        if(!empty($_POST['checkbox'])) {
            foreach($_POST["checkbox"] as $v) {
                $product_id_to_int = (int)$v;

                $wpdb->insert(
                    $wpdb->prefix.'products_by_container', 
                    array(
                        'id_products_by_container' => NULL,
                        'product_product_id_fk' => $product_id_to_int, 
                        'product_container_id_fk' => $product_container_id)
                );
            }
        }
    }
    //delete
    else if (isset($_POST['delete'])) {
        $wpdb->query("CALL delete_product_container('{$product_container_id}')");
    } else {//selecting value to update	
        $products = $wpdb->get_results($wpdb->prepare("SELECT product_container_id,name from $table_name where product_container_id=%s", $product_container_id));
        foreach ($products as $product) {
            $name = $product->name;
        }
    }
    ?>
    <link type="text/css" href="<?php echo plugins_url(); ?>/premio-products/style-admin.css" rel="stylesheet" />
    <div class="wrap">
        <h2>Product Containers</h2>

        <?php if ($_POST['delete']) { ?>
            <div class="updated"><p>Container deleted</p></div>
            <a href="<?php echo admin_url('admin.php?page=premio_products_container_list') ?>">&laquo; Back to Product containers</a>

        <?php } else if ($_POST['update']) { ?>
            <div class="updated"><p>Container updated</p></div>
            <a href="<?php echo admin_url('admin.php?page=premio_products_container_list') ?>">&laquo; Back to Product containers</a>

        <?php } else { ?>
            <form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
                <table class='wp-list-table widefat fixed'>
                    <tr><th>Container name</th><td><input type="text" name="name" value="<?php echo $name; ?>"/></td></tr>
                    <tr>
                        <th>Products</th>
                        <td>
                            <?php foreach ($selected_products as $product) { ?>
                                <input name="checkbox[]" type="checkbox" value="<?php echo $product->product_id; ?>" checked> <?php echo $product->product_name; ?> <br>
                            <?php } ?>

                            <?php foreach ($missing_products_for_container as $product) { ?>
                                <input name="checkbox[]" type="checkbox" value="<?php echo $product->product_id; ?>"> <?php echo $product->name; ?> <br>
                            <?php } ?>
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