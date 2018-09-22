<?php

function premio_programs_create() {
    $name = $_POST["name"];
    $description = $_POST["description"];
    $location = $_POST["location"];
    $participants = $_POST["participants"];
    $duration = $_POST["duration"];
    $participation_type = $_POST["name"];
    $top_outcomes = $_POST["top_outcomes"];
    $icon_labels = $_POST["icon_labels"];
    //insert
    if (isset($_POST['insert'])) {
        global $wpdb;
        $table_name = $wpdb->prefix . "premio_program";

        $wpdb->query("CALL create_program('{$name}', '{$description}', '{$location}', '{$participants}', '{$duration}', '{$participation_type}', 
                                        '{$top_outcomes}', '{$icon_labels}'
                    )");
        $message.="Program inserted";
    }
    ?>
    <link type="text/css" href="<?php echo plugins_url(); ?>/premio-programs/style-admin.css" rel="stylesheet" />
    <div class="wrap">
        <h2 class="new-program">Add New Program</h2>
        <?php if (isset($message)): ?><div class="updated"><p><?php echo $message; ?></p></div><?php endif; ?>
        <form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
            <table class='wp-list-table widefat fixed'>
                <tr>
                    <th class="ss-th-width">PROGRAM</th>
                    <td><input type="text" name="name" value="<?php echo $name; ?>" class="ss-field-width" /></td>
                </tr>
                <tr>
                    <th class="ss-th-width">DESCRIPTION</th>
                    <td><input type="text" name="description" value="<?php echo $description; ?>" class="ss-field-width" /></td>
                </tr>
                <tr>
                    <th class="ss-th-width">LOCATION</th>
                    <td><input type="text" name="location" value="<?php echo $location; ?>" class="ss-field-width" /></td>
                </tr>
                <tr>
                    <th class="ss-th-width">PARTICIPANTS</th>
                    <td><input type="text" name="participants" value="<?php echo $participants; ?>" class="ss-field-width" /></td>
                </tr>
                <tr>
                    <th class="ss-th-width">DURATION</th>
                    <td><input type="text" name="duration" value="<?php echo $duration; ?>" class="ss-field-width" /></td>
                </tr>
                <tr>
                    <th class="ss-th-width">PARTICIPATION</th>
                    <td><input type="text" name="participation_type" value="<?php echo $participation_type; ?>" class="ss-field-width" /></td>
                </tr> 
                <tr>
                    <th class="ss-th-width">TOP OUTCOMES</th>
                    <td><input type="text" name="top_outcomes" value="<?php echo $top_outcomes; ?>" class="ss-field-width" /></td>
                </tr>     
                <tr>
                    <th class="ss-th-width">ICON LABELS</th>
                    <td><input type="text" name="icon_labels" value="<?php echo $icon_labels; ?>" class="ss-field-width" /></td>
                </tr>                                                
            </table>
            <input type='submit' name="insert" value='Save' class='button'>
        </form>
        <div class="tablenav top">
            <div class="alignleft actions">
                <a href="<?php echo admin_url('admin.php?page=premio_programs_list'); ?>">Back to Programs</a>
            </div>
            <br class="clear">
        </div>
    </div>
    <?php
}