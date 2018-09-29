<?php

function premio_products_update() {
    global $wpdb;

    $table_name = $wpdb->prefix . "premio_product";

    $product_container_table = $wpdb->prefix . "premio_product_container";
    $program_table = $wpdb->prefix . "premio_program";

    $product_containers = $wpdb->get_results("SELECT * from $product_container_table");
    $programs = $wpdb->get_results("SELECT * from $program_table");    

    $product_id = $_GET["product_id"];
    $name = $_POST["name"];
    $product_description = $_POST["product_description"];
    $post_product_container_id = $_POST['productContainerDpw'];
    $post_program_id = $_POST['programDpw'];

    $selected_container = $wpdb->get_row($wpdb->prepare(
        "CALL show_selected_container('{$product_id}')"
    ));

    $selected_programs = $wpdb->get_results($wpdb->prepare(
        "CALL show_product_programs('{$product_id}')"
    ));

    $missing_programs_for_product = $wpdb->get_results($wpdb->prepare(
        "CALL show_missing_programs_for_product('{$product_id}')"
    ));    

    //update
    if (isset($_POST['update'])) {
        $wpdb->query("CALL update_product( '{$product_id}', '{$name}', '{$product_description}', '{$post_product_container_id}', '{$post_program_id}' )");

        $wpdb->query("CALL delete_products_by_program( '{$product_id}' )");

        if(!empty($_POST['checkbox'])) {
            foreach($_POST["checkbox"] as $v) {
                $program_id_to_int = (int)$v;

                $wpdb->insert(
                    $wpdb->prefix.'premio_product_by_program', 
                    array(
                        'product_by_program_id' => NULL,
                        'program_id_fk' => $program_id_to_int, 
                        'product_id_fk' => $product_id)
                );
            }
        }

    }
    //delete
    else if (isset($_POST['delete'])) {
        $wpdb->query("CALL delete_product('{$product_id}')");
    } else {
        //selecting value to update	
        $products = $wpdb->get_results($wpdb->prepare("SELECT * from $table_name where product_id=%s", $product_id));
        foreach ($products as $product) {
            $name = $product->name;
            $product_description = $product->description;
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
                        <th>Description</th>
                        <td><textarea name="product_description" rows="5" cols="20"><?php echo $product_description; ?></textarea></td>
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
                    <tr>
                        <th>Programs</th>
                        <td>
                            <?php foreach ($selected_programs as $program) { ?>
                                <input name="checkbox[]" type="checkbox" value="<?php echo $program->program_id; ?>" checked> <?php echo $program->program_name; ?> <br>
                            <?php } ?>

                            <?php foreach ($missing_programs_for_product as $program) { ?>
                                <input name="checkbox[]" type="checkbox" value="<?php echo $program->program_id; ?>"> <?php echo $program->name; ?> <br>
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