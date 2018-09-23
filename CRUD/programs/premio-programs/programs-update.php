<?php

function premio_programs_update() {
    global $wpdb;
    $table_name = $wpdb->prefix . "premio_program";
    $program_id = $_GET["program_id"];

    $name = $_POST["name"];
    $description = $_POST["description"];
    $location = $_POST["location"];
    $participants = $_POST["participants"];
    $duration = $_POST["duration"];
    $participation_type = $_POST["name"];
    $top_outcomes = $_POST["top_outcomes"];
    $icon_labels = $_POST["icon_labels"];
    $video_url = $_POST["video_url"];

    //update
    if (isset($_POST['update'])) {
        $wpdb->query("CALL update_program('{$program_id}', '{$name}', '{$description}', '{$location}', '{$participants}', '{$duration}', 
                                            '{$participation_type}', '{$top_outcomes}', '{$icon_labels}', '{$video_url}')");
    }
    //delete
    else if (isset($_POST['delete'])) {
        $wpdb->query($wpdb->prepare("DELETE FROM $table_name WHERE program_id = %s", $program_id));
    } else {
        //selecting value to update	
        $programs = $wpdb->get_results($wpdb->prepare("SELECT * from $table_name where program_id=%s", $program_id));
        foreach ($programs as $program) {
            $name = $program->name;
            $description = $program->description;
            $location = $program->location;
            $participants = $program->amount_of_participants;
            $duration = $program->duration;
            $participation_type = $program->participation_type;
            $top_outcomes = $program->top_outcomes;
            $icon_labels = $program->icon_labels;
            $video_url = $program->video_url;
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
                    <tr><th>PROGRAM</th><td><textarea name="name" rows="5" cols="10"><?php echo $name; ?></textarea></td></tr>
                    <tr><th>DESCRIPTION</th><td><textarea name="description" rows="5" cols="10"><?php echo $description; ?></textarea></td></tr>
                    <tr><th>LOCATION</th><td><textarea name="location" rows="5" cols="10"><?php echo $location; ?></textarea></td></tr>
                    <tr><th>Participants</th><td><textarea name="participants" rows="5" cols="10"><?php echo $participants; ?></textarea></td></tr>
                    <tr><th>Duration</th><td><textarea name="duration" rows="5" cols="10"><?php echo $duration; ?></textarea></td></tr>
                    <tr><th>Participation</th><td><textarea name="participation_type" rows="5" cols="10"><?php echo $participation_type; ?></textarea></td></tr>
                    <tr><th>Outcomes</th><td><textarea name="top_outcomes" rows="5" cols="10"><?php echo $top_outcomes; ?></textarea></td></tr>
                    <tr><th>Labels</th><td><textarea name="icon_labels" rows="5" cols="10"><?php echo $icon_labels; ?></textarea></td></tr>
                    <tr><th>Video URL</th><td><textarea name="video_url" rows="5" cols="10"><?php echo $video_url; ?></textarea></td></tr>
                </table>
                <input type='submit' name="update" value='Save' class='button'> &nbsp;&nbsp;
                <input type='submit' name="delete" value='Delete' class='button' onclick="return confirm('&iquest;Est&aacute;s seguro de borrar este elemento?')">
            </form>
        <?php } ?>

    </div>
    <?php
}