<?php

function premio_programs_list() {
    ?>
    <link type="text/css" href="<?php echo plugins_url(); ?>/premio-programs/style-admin.css" rel="stylesheet" />
    <div class="wrap">
        <h2>Programs</h2>
        <div class="tablenav top">
            <div class="alignleft actions">
                <a href="<?php echo admin_url('admin.php?page=premio_programs_create'); ?>">Add New</a>
            </div>
            <br class="clear">
        </div>
        <?php
        global $wpdb;
        $table_name = $wpdb->prefix . "premio_program";

        $rows = $wpdb->get_results("SELECT * from $table_name");
        ?>
        <table class='wp-list-table widefat fixed striped posts'>
            <tr>
                <th class="manage-column ss-list-width">ID</th>
                <th class="manage-column ss-list-width">Program</th>
                <th class="manage-column ss-list-width">Description</th>
                <th class="manage-column ss-list-width">Location</th>
                <th class="manage-column ss-list-width">Participants</th>
                <th class="manage-column ss-list-width">Duration</th>
                <th class="manage-column ss-list-width">Participation</th>
                <th class="manage-column ss-list-width">Outcomes</th>
                <th class="manage-column ss-list-width">Labels</th>
                <th class="manage-column ss-list-width">Action</th>
                <th>&nbsp;</th>
            </tr>
            <?php foreach ($rows as $row) { ?>
                <tr>
                    <td class="manage-column ss-list-width"><?php echo $row->program_id; ?></td>
                    <td class="manage-column ss-list-width">
                        <textarea name="name" rows="5" cols="10" readonly><?php echo $row->name; ?></textarea>
                    </td>
                    <td class="manage-column ss-list-width">
                        <textarea name="description" rows="5" cols="10" readonly><?php echo $row->description; ?></textarea>
                    </td>
                    <td class="manage-column ss-list-width">
                        <textarea name="location" rows="5" cols="10" readonly><?php echo $row->location; ?></textarea>
                    </td>
                    <td class="manage-column ss-list-width">
                        <textarea name="amount_of_participants" rows="5" cols="10" readonly><?php echo $row->amount_of_participants; ?></textarea>
                    </td>
                    <td class="manage-column ss-list-width">
                        <textarea name="duration" rows="5" cols="10" readonly><?php echo $row->duration; ?></textarea>
                    </td>
                    <td class="manage-column ss-list-width">
                        <textarea name="participation_type" rows="5" cols="10" readonly><?php echo $row->participation_type; ?></textarea>
                    </td>
                    <td class="manage-column ss-list-width">
                        <textarea name="top_outcomes" rows="5" cols="10" readonly><?php echo $row->top_outcomes; ?></textarea>
                    </td>
                    <td class="manage-column ss-list-width">
                        <textarea name="icon_labels" rows="5" cols="10" readonly><?php echo $row->icon_labels; ?></textarea>
                    </td>
                    <td><a href="<?php echo admin_url('admin.php?page=premio_programs_update&program_id=' . $row->program_id); ?>">Update</a></td>
                </tr>
            <?php } ?>
        </table>
    </div>
    <?php
}