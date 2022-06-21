<?php
defined( 'ABSPATH' ) || exit;
?>
<div aria-label="Main content" tabindex="0">        
    <div class="wrap">
        <form name="export_date_from" id="csvexport" method="post" action="<?php esc_html_e($actionUrl);?>">
            <div class="detail_wrap">
                <h3><?php _e('Export Data','sample-data-export'); ?></h3>
                <div style="clear: both;">&nbsp;</div>
                <input name="startdate" autocomplete="off" class="input-text date" id="startdate" type="text" value="" placeholder="From" /> -
                <input name="enddate" autocomplete="off" class="input-text date" id="enddate" type="text" value="" placeholder="To" />
                <input class="button alt csvdata" name="exportdata" id="exportdata" value="Export" type="submit" >
                <input type="reset" class="btn btn-light resetdata" name="resetdata" id="resetdata" value="Reset">
            </div>
            <span class="errormsg"></span>
        </form>
    </div>
</div>
<table id="dtlist" class="table table-striped table-bordered">
    <thead>
        <tr>
        <th><?php _e('Name','sample-data-export'); ?></th>
        <th><?php _e('Email','sample-data-export'); ?></th>
        <th><?php _e('Registered Date','sample-data-export'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php 
            $dataDetails = $wpdb->get_results("SELECT * FROM $table_name");
            foreach($dataDetails as $dataDetailKey => $dataDetailVal){ 
            ?>
                <tr>
                    <td><?php esc_html_e($dataDetailVal->user_nicename); ?></td>
                    <td><?php esc_html_e($dataDetailVal->user_email); ?></td>
                    <td><?php esc_html_e(date('Y-m-d', strtotime($dataDetailVal->user_registered))); ?></td>
                </tr>
        <?php    } 
        ?>
    </tbody>
</table>