<?php

function premio_products_update() {
    global $wpdb;

    $table_name = $wpdb->prefix . "premio_product";
    $product_id = $_GET["product_id"];

    $product_container_table = $wpdb->prefix . "premio_product_container";
    $product_containers = $wpdb->get_results("SELECT * from $product_container_table");

    $selected_container = $wpdb->get_row($wpdb->prepare(
        "CALL show_selected_container('{$product_id}')"
    ));

    $name = $_POST["name"];
    //update
    if (isset($_POST['update'])) {
        $wpdb->update(
                $table_name, //table
                array('name' => $name), //data
                array('product_id' => $product_id), //where
                array('%s'), //data format
                array('%s') //where format
        );
    }
    //delete
    else if (isset($_POST['delete'])) {
        $wpdb->query($wpdb->prepare("DELETE FROM $table_name WHERE product_id = %s", $product_id));
    } else {//selecting value to update	
        $products = $wpdb->get_results($wpdb->prepare("SELECT product_id,name from $table_name where product_id=%s", $product_id));
        foreach ($products as $product) {
            $name = $product->name;
        }
    }
    ?>
    <link type="text/css" href="<?php echo plugins_url(); ?>/premio-products/style-admin.css" rel="stylesheet" />
    <div class="wrap">
        <h2>Products</h2>

        <?php if ($_POST['delete']) { ?>
            <div class="updated"><p>Product deleted</p></div>
            <a href="<?php echo admin_url('admin.php?page=premio_products_list') ?>">&laquo; Back to products list</a>

        <?php } else if ($_POST['update']) { ?>
            <div class="updated"><p>Product updated</p></div>
            <a href="<?php echo admin_url('admin.php?page=premio_products_list') ?>">&laquo; Back to products list</a>

        <?php } else { ?>

            <form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
                <table class='wp-list-table widefat fixed'>
                    <tr>
                        <th>Name</th>
                        <td><input type="text" name="name" value="<?php echo $name; ?>"/></td>
                    </tr>
                    <tr>
                        <th>Container</th>
                        <td>
                            <select name="productContainerDpw">
                                <?php foreach ($product_containers as $container) { ?>
                                    <option value="<?php echo $container->product_container_id; ?>" 
                                        <?php 
                                            if($container->product_container_id == $selected_container->container_id){
                                                echo "selected";
                                            } 
                                        ?>>
                                        <?php echo $container->name; ?>
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