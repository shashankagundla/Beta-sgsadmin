<?php
/*
 * Page Setup
 */
require_once("../../includes/init.php");
/*
 * Init dashboard class and get required select field info
 */
$dash = New Dashboard();
$dashTable = $dash->dashEngineering();

$page = 'Engineering Dashboard <span class="pull-right small"><span class="label label-default hidden-sm hidden-xs">PO: '.$dashTable['poTotal'].'</span><span class="label label-success hidden-sm hidden-xs">GO: '.$dashTable['goTotal'].' </span><span class="label label-primary hidden-sm hidden-xs">FWC: '.$dashTable['fwcTotal'].'</span></span>';
$subtitle = '';
echo $template->header($page,$subtitle);
?>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
            <div class="panel panel-primary panel-no-border">
                <div class="panel-heading">
                    <div class="panel-title">Go</div>
                </div>
                <div class="panel-content">
                    <table class="table table-condensed table-dash table-hover table-bordered small">
                        <thead>
                            <tr>
                                <th class="col-xs-2">SGS#</th>
                                <th class="col-xs-3">Site</th>
                                <th class="col-xs-2">Job Type</th>
                                <th class="col-xs-3">Crew</th>
                                <th class="col-xs-2">TS-Go</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($dashTable['go'] as $row){?>
                                <tr class="clickable-row <?php if ($row['priority'] != 0){ echo 'danger'; } ?>" data-href="/job/?sgs=<?=$row['sgs_num']?>">
                                    <td><?=$row['sgs_num']?></td>
                                    <td><?=substr($row['site_name'],0,15)?></td>
                                    <td><?=$row['job_type']?></td>
                                    <td><?=$row['crew_1']?></td>
                                    <td><?=timeAgo(strtotime($row['overall_status_date']))?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
            <div class="panel panel-primary panel-no-border">
                <div class="panel-heading">
                    <div class="panel-title">FWC</div>
                </div>
                <div class="panel-content">
                    <table class="table table-condensed table-dash table-hover table-bordered small">
                        <thead>
                            <tr>
                                <th class="col-xs-2">SGS#</th>
                                <th class="col-xs-3">Site</th>
                                <th class="col-xs-2">Job Type</th>
                                <th class="col-xs-3">Assigned To</th>
                                <th class="col-xs-2">Due Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($dashTable['fwc'] as $row){?>
                                <tr class="clickable-row <?php if ($row['priority'] != 0){ echo 'danger'; } ?>" data-href="/job/?sgs=<?=$row['sgs_num']?>">
                                    <td><?=$row['sgs_num']?></td>
                                    <td><?=substr($row['site_name'],0,15)?></td>
                                    <td><?=$row['job_type']?></td>
                                    <td><?=$row['eng_assigned']?></td>
                                    <td><?=$row['date_due']?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
            <div class="panel panel-primary panel-no-border">
                <div class="panel-heading">
                    <div class="panel-title">Reports</div>
                </div>
                <div class="panel-content">
                    <table class="table table-condensed table-dash table-hover table-bordered small">
                        <thead>
                            <tr>
                                <th colspan="5" class="text-center">Reports being Written <?php if ($dashTable['reportsWritten']!= false){ echo '('. count($dashTable['reportsWritten']). ')'; } ?></th>
                            </tr>
                            <tr>
                                <th class="col-xs-2">SGS#</th>
                                <th class="col-xs-3">Site</th>
                                <th class="col-xs-2">Job Type</th>
                                <th class="col-xs-3">Assigned To</th>
                                <th class="col-xs-2">Due Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($dashTable['reportsWritten'] as $row){?>
                                <tr class="clickable-row <?php if ($row['priority'] != 0){ echo 'danger'; } ?>" data-href="/job/?sgs=<?=$row['sgs_num']?>">
                                    <td><?=$row['sgs_num']?></td>
                                    <td><?=substr($row['site_name'],0,15)?></td>
                                    <td><?=$row['job_type']?></td>
                                    <td><?=$row['eng_assigned']?></td>
                                    <td><?=$row['date_due']?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <br>
                    <table class="table table-condensed table-dash table-hover table-bordered small">
                        <thead>
                            <tr>
                                <th colspan="5" class="text-center">Reports in Review <?php if ($dashTable['reportsReview']!= false){ echo '('. count($dashTable['reportsReview']). ')'; } ?></th>
                            </tr>
                            <tr>
                                <th class="col-xs-2">SGS#</th>
                                <th class="col-xs-3">Site</th>
                                <th class="col-xs-2">Job Type</th>
                                <th class="col-xs-3">Assigned To</th>
                                <th class="col-xs-2">Due Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($dashTable['reportsReview'] as $row){?>
                                <tr class="clickable-row <?php if ($row['priority'] != 0){ echo 'danger'; } ?>" data-href="/job/?sgs=<?=$row['sgs_num']?>">
                                    <td><?=$row['sgs_num']?></td>
                                    <td><?=substr($row['site_name'],0,15)?></td>
                                    <td><?=$row['job_type']?></td>
                                    <td><?=$row['eng_assigned']?></td>
                                    <td><?=$row['date_due']?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <br>
                    <table class="table table-condensed table-dash table-hover table-bordered small">
                        <thead>
                            <tr>
                                <th colspan="5" class="text-center">All SGS Jobs Ready for Seal <?php if ($dashTable['sealReady']!= false){ echo '('. count($dashTable['sealReady']). ')'; } ?></th>
                            </tr>
                            <tr>
                                <th class="col-xs-2">SGS#</th>
                                <th class="col-xs-3">Site</th>
                                <th class="col-xs-2">State</th>
                                <th class="col-xs-3">Job Type</th>
                                <th class="col-xs-2">Size</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($dashTable['sealReady'] as $row){?>
                                <tr class="clickable-row <?php if ($row['priority'] != 0){ echo 'danger'; } ?>" data-href="/job/?sgs=<?=$row['sgs_num']?>">
                                    <td><?=$row['sgs_num']?></td>
                                    <td><?=substr($row['site_name'],0,15)?></td>
                                    <td><?=$row['state']?></td>
                                    <td><?=$row['job_type']?></td>
                                    <td><?=$row['-']?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <br>
                    <table class="table table-condensed table-dash table-hover table-bordered small">
                        <thead>
                            <tr>
                                <th colspan="5" class="text-center">Sealed in Box <?php if ($dashTable['sealed']!= false){ echo '('. count($dashTable['sealed']). ')'; } ?></th>
                            </tr>
                            <tr>
                                <th class="col-xs-2">SGS#</th>
                                <th class="col-xs-3">Site</th>
                                <th class="col-xs-2">Job Type</th>
                                <th class="col-xs-3">Assigned To</th>
                                <th class="col-xs-2">State</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($dashTable['sealed'] as $row){?>
                                <tr class="clickable-row <?php if ($row['priority'] != 0){ echo 'danger'; } ?>" data-href="/job/?sgs=<?=$row['sgs_num']?>">
                                    <td><?=$row['sgs_num']?></td>
                                    <td><?=substr($row['site_name'],0,15)?></td>
                                    <td><?=$row['job_type']?></td>
                                    <td><?=$row['eng_assigned']?></td>
                                    <td><?=$row['state']?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

<?php
if ($_SESSION['user']['debug'] != 0) {
    echo '<pre>' . var_export($dashTable, true) . '</pre>';
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
