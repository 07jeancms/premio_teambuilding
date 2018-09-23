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
    $video_url = $_POST["video_url"];
    //insert
    if (isset($_POST['insert'])) {
        global $wpdb;
        $table_name = $wpdb->prefix . "premio_program";

        $wpdb->query("CALL create_program('{$name}', '{$description}', '{$location}', '{$participants}', '{$duration}', '{$participation_type}', 
                                        '{$top_outcomes}', '{$icon_labels}', '{$video_url}'
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
                    <td><textarea name="name" rows="5" cols="40"><?php echo $name; ?></textarea></td>
                </tr>
                <tr>
                    <th class="ss-th-width">DESCRIPTION</th>
                    <td><textarea name="description" rows="5" cols="40"><?php echo $description; ?></textarea></td>
                </tr>
                <tr>
                    <th class="ss-th-width">LOCATION</th>
                    <td><textarea name="location" rows="5" cols="40"><?php echo $location; ?></textarea></td>
                </tr>
                <tr>
                    <th class="ss-th-width">PARTICIPANTS</th>
                    <td><textarea name="participants" rows="5" cols="40"><?php echo $participants; ?></textarea></td>
                </tr>
                <tr>
                    <th class="ss-th-width">DURATION</th>
                    <td><textarea name="duration" rows="5" cols="40"><?php echo $duration; ?></textarea></td>
                </tr>
                <tr>
                    <th class="ss-th-width">PARTICIPATION</th>
                    <td><textarea name="participation_type" rows="5" cols="40"><?php echo $participation_type; ?></textarea></td>
                </tr> 
                <tr>
                    <th class="ss-th-width">TOP OUTCOMES</th>
                    <td><textarea name="top_outcomes" rows="5" cols="40"><?php echo $top_outcomes; ?></textarea></td>
                </tr>     
                <tr>
                    <th class="ss-th-width">ICON LABELS</th>
                    <td><textarea name="icon_labels" rows="5" cols="40"><?php echo $icon_labels; ?></textarea></td>
                </tr>
                <tr>
                    <th class="ss-th-width">VIDEO URL</th>
                    <td><textarea name="video_url" rows="3" cols="40"><?php echo $video_url; ?></textarea></td>
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