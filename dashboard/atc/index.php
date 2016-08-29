<?php
/*
 * Page Setup
 */
$page = 'ATC Dashboard';
$subtitle = '';
require_once("../../includes/init.php");
echo $template->header($page,$subtitle);

/*
 * Init dashboard class and get required select field info
 */
$dash = New Dashboard();
$dashTable = $dash->dashATC();

?>
    <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-4">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="panel-title">FWC</div>
                </div>
                <div class="panel-content">
                    <table class="table table-condensed table-dash table-striped table-bordered small">
                        <thead>
                            <tr>
                                <th colspan="5" class="text-center">Field Work Complete</th>
                            </tr>
                            <tr>
                                <th class="col-xs-2">SGS#</th>
                                <th class="col-xs-3">Site</th>
                                <th class="col-xs-2">TS-FWC</th>
                                <th class="col-xs-3">Crew</th>
                                <th class="col-xs-2">Job Type</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($dashTable['fwc'] as $row){?>
                                <tr <?php if ($row['priority'] != 0){ echo 'class="danger"'; } ?>>
                                    <td><?=$row['sgs_num']?></td>
                                    <td><?=substr($row['site_name'],0,15)?></td>
                                    <td><?=$dash->timeAgo(strtotime($row['overall_status_date']))?></td>
                                    <td><?=$row['overall_status_id']?></td>
                                    <td><?=$row['job_type']?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <br>
                    <table class="table table-condensed table-dash table-striped table-bordered small">
                        <thead>
                            <tr>
                                <th colspan="5" class="text-center">Reports Not Started</th>
                            </tr>
                            <tr>
                                <th class="col-xs-2">SGS#</th>
                                <th class="col-xs-3">Site</th>
                                <th class="col-xs-2">TS-FWC</th>
                                <th class="col-xs-3">Crew</th>
                                <th class="col-xs-2">Job Type</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($dashTable['reportNotStarted'] as $row){?>
                                <tr <?php if ($row['priority'] != 0){ echo 'class="danger"'; } ?>>
                                    <td><?=$row['sgs_num']?></td>
                                    <td><?=substr($row['site_name'],0,15)?></td>
                                    <td><?=$dash->timeAgo(strtotime($row['overall_status_date']))?></td>
                                    <td><?=$row['overall_status_id']?></td>
                                    <td><?=$row['job_type']?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-4">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="panel-title">Reports in Progress</div>
                </div>
                <div class="panel-content">
                    <table class="table table-condensed table-dash table-striped table-bordered small">
                        <thead>
                            <tr>
                                <th colspan="4" class="text-center">Reports Being Written</th>
                            </tr>
                            <tr>
                                <th class="col-xs-2">SGS#</th>
                                <th class="col-xs-3">Site</th>
                                <th class="col-xs-3">Current Status</th>
                                <th class="col-xs-4">Author</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach($dashTable['reportWritten'] as $row){?>
                            <tr <?php if ($row['priority'] != 0){ echo 'class="danger"'; } ?>>
                                <td><?=$row['sgs_num']?></td>
                                <td><?=substr($row['site_name'],0,15)?></td>
                                <td><?=$row['report_status']?></td>
                                <td><?=$row['report_status_id']?></td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                    <br>
                    <table class="table table-condensed table-dash table-striped table-bordered small">
                        <thead>
                            <tr>
                                <th colspan="4" class="text-center">In Review</th>
                            </tr>
                            <tr>
                                <th class="col-xs-2">SGS#</th>
                                <th class="col-xs-3">Site</th>
                                <th class="col-xs-3">Current Status</th>
                                <th class="col-xs-4">Last Status Change</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach($dashTable['reportReview'] as $row){?>
                            <tr <?php if ($row['priority'] != 0){ echo 'class="danger"'; } ?>>
                                <td><?=$row['sgs_num']?></td>
                                <td><?=substr($row['site_name'],0,15)?></td>
                                <td><?=$row['report_status']?></td>
                                <td><?=$dash->timeAgo(strtotime($row['report_status_date']))?></td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                    <br>
                    <table class="table table-condensed table-dash table-striped table-bordered small">
                        <thead>
                            <tr>
                                <th colspan="4" class="text-center">Reports Started</th>
                            </tr>
                            <tr>
                                <th class="col-xs-2">SGS#</th>
                                <th class="col-xs-3">Site</th>
                                <th class="col-xs-3">Job Type</th>
                                <th class="col-xs-4">Last Status Change</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach($dashTable['reportStarted'] as $row){?>
                            <tr <?php if ($row['priority'] != 0){ echo 'class="danger"'; } ?>>
                                <td><?=$row['sgs_num']?></td>
                                <td><?=substr($row['site_name'],0,15)?></td>
                                <td><?=$row['job_type']?></td>
                                <td><?=$dash->timeAgo(strtotime($row['report_status_date']))?></td>

                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-4">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="panel-title">Reports Completed</div>
                </div>
                <div class="panel-content">
                    <table class="table table-condensed table-dash table-striped table-bordered small">
                        <thead>
                        <tr>
                            <th colspan="5" class="text-center">Ready for Seal</th>
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
                            <tr <?php if ($row['priority'] != 0){ echo 'class="danger"'; } ?>>
                                <td><?=$row['sgs_num']?></td>
                                <td><?=substr($row['site_name'],0,15)?></td>
                                <td><?=$row['state']?></td>
                                <td><?=$row['job_type']?></td>
                                <td>-</td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                    <br>
                    <table class="table table-condensed table-dash table-striped table-bordered small">
                        <thead>
                        <tr>
                            <th colspan="4" class="text-center">Sealed in Box</th>
                        </tr>
                        <tr>
                            <th class="col-xs-2">SGS#</th>
                            <th class="col-xs-3">Site</th>
                            <th class="col-xs-3">State</th>
                            <th class="col-xs-4">Job Type</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($dashTable['sealed'] as $row){?>
                            <tr <?php if ($row['priority'] != 0){ echo 'class="danger"'; } ?>>
                                <td><?=$row['sgs_num']?></td>
                                <td><?=substr($row['site_name'],0,15)?></td>
                                <td><?=$row['state']?></td>
                                <td><?=$row['job_type']?></td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>





<?php
if ($debug === 1) {
    echo '<pre>' . var_export($dashTable, true) . '</pre>';
}
/*
 * Page footer and notifications
 */
echo $template->footer();
echo $template->notify();
?>