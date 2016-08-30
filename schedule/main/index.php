<?php
/*
 * Page Setup
 */
$page = 'Schedule - Main';
require_once("../../includes/init.php");
echo $template->header($page);

/*
 * Init schedule class and get required info
 */
$schedule = New Schedule();

$mainTable = $schedule->mainTable();

?>
    <div class="row">
        <table class="table table-condensed table-dash table-hover table-bordered table-responsive small">
            <thead>
            <tr>
                <th>SGS#</th>
                <th>Site Name</th>
                <th>Site#</th>
                <th>Job Type</th>
                <th>Status</th>
                <th>State</th>
                <th>Crew</th>
                <th>Est Date on Site</th>
                <th>Latitude</th>
                <th>Longitude</th>
                <th>DSG</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($mainTable as $row){?>
                <tr class="clickable-row <?php if ($row['priority'] != 0){ echo 'danger'; } ?>" data-href="/job/?sgs=<?=$row['sgs_num']?>">
                    <td><?=$row['sgs_num']?></td>
                    <td><?=substr($row['site_name'],0,15)?></td>
                    <td><?=$row['site_num']?></td>
                    <td><?=$row['job_type']?></td>
                    <td><?=$row['overall_status']?></td>
                    <td><?=$row['state']?></td>
                    <td><?=$row['crew_1']?></td>
                    <td><?=$row['date_eos']?></td>
                    <td><?=$row['latitude']?></td>
                    <td><?=$row['longitude']?></td>
                    <td>-</td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>

<?php
if ($_SESSION['user']['debug'] != 0) {
    echo '<pre>' . var_export($mainTable, true) . '</pre>';
}
/*
 * Page footer and notifications
 */
echo $template->footer();
echo $template->notify();
?>
<script>
    jQuery(document).ready(function($) {
        $(".clickable-row").click(function() {
            window.document.location = $(this).data("href");
        });
    });
</script>
