<?php

function premio_programs_update() {
    global $wpdb;
    $table_name = $wpdb->prefix . "premio_program";
    $program_id = $_GET["program_id"];
    $name = $_POST["name"];
//update
    if (isset($_POST['update'])) {
        $wpdb->update(
                $table_name, //table
                array('name' => $name), //data
                array('program_id' => $program_id), //where
                array('%s'), //data format
                array('%s') //where format
        );
    }
//delete
    else if (isset($_POST['delete'])) {
        $wpdb->query($wpdb->prepare("DELETE FROM $table_name WHERE program_id = %s", $program_id));
    } else {//selecting value to update	
        $programs = $wpdb->get_results($wpdb->prepare("SELECT program_id,name from $table_name where program_id=%s", $program_id));
        foreach ($programs as $program) {
            $name = $program->name;
        }
    }
    ?>
    <link type="text/css" href="<?php echo plugins_url(); ?>/premio-programs/style-admin.css" rel="stylesheet" />
    <div class="wrap">
        <h2>Program</h2>

        <?php if ($_POST['delete']) { ?>
            <div class="updated"><p>Program deleted</p></div>
            <a href="<?php echo admin_url('admin.php?page=premio_programs_list') ?>">&laquo; Back to programs list</a>

        <?php } else if ($_POST['update']) { ?>
            <div class="updated"><p>Program updated</p></div>
            <a href="<?php echo admin_url('admin.php?page=premio_programs_list') ?>">&laquo; Back to programs list</a>

        <?php } else { ?>
            <form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
                <table class='wp-list-table widefat fixed'>
                    <tr><th>Name</th><td><input type="text" name="name" value="<?php echo $name; ?>"/></td></tr>
                </table>
                <input type='submit' name="update" value='Save' class='button'> &nbsp;&nbsp;
                <input type='submit' name="delete" value='Delete' class='button' onclick="return confirm('&iquest;Est&aacute;s seguro de borrar este elemento?')">
            </form>
        <?php } ?>

    </div>
    <?php
}