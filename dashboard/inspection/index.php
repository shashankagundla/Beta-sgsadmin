<?php
/*
 * Page Setup
 */
require_once("../../includes/init.php");
/*
 * Init dashboard class and get required select field info
 */
$dash = New Dashboard();
$dashTable = $dash->dashInspections();

$page = 'Inspection Dashboard <span class="pull-right small"><span class="label label-default hidden-xs">PO: '.$dashTable['poTotal'].'</span><span class="label label-success hidden-xs">GO: '.$dashTable['goTotal'].' </span><span class="label label-primary hidden-xs">FWC: '.$dashTable['fwcTotal'].'</span></span>';
$subtitle = '';
echo $template->header($page,$subtitle);



?>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
            <div class="panel panel-primary panel-no-border">
                <div class="panel-heading">
                   <div class="panel-title">Closeouts</div>
                </div>
                <div class="panel-content">
                    <table class="table table-condensed table-dash table-hover table-bordered small">
                        <thead>
                            <tr>
                                <th colspan="5" class="text-center">Received - Waiting for Review <?php if ($dashTable['closeoutReceived']!= false){ echo '('. count($dashTable['closeoutReceived']). ')'; } ?></th>
                            </tr>
                            <tr>
                                <th class="col-xs-2">SGS#</th>
                                <th class="col-xs-3">Site</th>
                                <th class="col-xs-3">TS-R</th>
                                <th class="col-xs-4">Closeouts Missing</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach($dashTable['closeoutReceived'] as $row){?>
                            <tr class="clickable-row <?php if ($row['priority'] != 0){ echo 'danger'; } ?>" data-href="/job/?sgs=<?=$row['sgs_num']?>">
                                <td><?=$row['sgs_num']?></td>
                                <td><?=substr($row['site_name'],0,15)?></td>
                                <td><?=timeAgo(strtotime($row['closeout_status_date']))?></td>
                                <td><?=$row['closeout_missing']?></td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                    <br>
                    <table class="table table-condensed table-dash table-hover table-bordered small">
                        <thead>
                            <tr>
                                <th colspan="5" class="text-center">In Review <?php if ($dashTable['closeoutReview']!= false){ echo '('. count($dashTable['closeoutReview']). ')'; } ?></th>
                            </tr>
                            <tr>
                                <th class="col-xs-2">SGS#</th>
                                <th class="col-xs-3">Site</th>
                                <th class="col-xs-3">Reviewer</th>
                                <th class="col-xs-4">Closeouts Missing</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach($dashTable['closeoutReview'] as $row){?>
                            <tr class="clickable-row <?php if ($row['priority'] != 0){ echo 'danger'; } ?>" data-href="/job/?sgs=<?=$row['sgs_num']?>">
                                <td><?=$row['sgs_num']?></td>
                                <td><?=substr($row['site_name'],0,15)?></td>
                                <td><?=$row['fname']?> <?=$row['lname']?></td>
                                <td><?=$row['closeout_missing']?></td>
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
                    <div class="panel-title">Punch</div>
                </div>
                <div class="panel-content">
                    <table class="table table-condensed table-dash table-hover table-bordered small">
                        <thead>
                            <tr>
                                <th colspan="5" class="text-center">Received - Waiting for Review <?php if ($dashTable['punchReceived']!= false){ echo '('. count($dashTable['punchReceived']). ')'; } ?></th>
                            </tr>
                            <tr>
                                <th class="col-xs-2">SGS#</th>
                                <th class="col-xs-3">Site</th>
                                <th class="col-xs-3">TS-R</th>
                                <th class="col-xs-4">Punch Missing</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach($dashTable['punchReceived'] as $row){?>
                            <tr class="clickable-row <?php if ($row['priority'] != 0){ echo 'danger'; } ?>" data-href="/job/?sgs=<?=$row['sgs_num']?>">
                                <td><?=$row['sgs_num']?></td>
                                <td><?=substr($row['site_name'],0,15)?></td>
                                <td><?=timeAgo(strtotime($row['inspection_status_date']))?></td>
                                <td><?=$row['inspection_missing']?></td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                    <br>
                    <table class="table table-condensed table-dash table-hover table-bordered small">
                        <thead>
                            <tr>
                                <th colspan="5" class="text-center">In Review <?php if ($dashTable['punchReview']!= false){ echo '('. count($dashTable['punchReview']). ')'; } ?></th>
                            </tr>
                            <tr>
                                <th class="col-xs-2">SGS#</th>
                                <th class="col-xs-3">Site</th>
                                <th class="col-xs-3">Reviewer</th>
                                <th class="col-xs-4">Punch Missing</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach($dashTable['punchReview'] as $row){?>
                            <tr class="clickable-row <?php if ($row['priority'] != 0){ echo 'danger'; } ?>" data-href="/job/?sgs=<?=$row['sgs_num']?>">
                                <td><?=$row['sgs_num']?></td>
                                <td><?=substr($row['site_name'],0,15)?></td>
                                <td><?=$row['fname']?> <?=$row['lname']?></td>
                                <td><?=$row['inspection_missing']?></td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                    <br>
                    <table class="table table-condensed table-dash table-hover table-bordered small">
                        <thead>
                            <tr>
                                <th colspan="5" class="text-center">Needs Punch List Sent <?php if ($dashTable['needsPunch']!= false){ echo '('. count($dashTable['needsPunch']). ')'; } ?></th>
                            </tr>
                            <tr>
                                <th class="col-xs-2">SGS#</th>
                                <th class="col-xs-3">Site</th>
                                <th class="col-xs-3">TS-FWC</th>
                                <th class="col-xs-4">Job Type</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach($dashTable['needsPunch'] as $row){?>
                            <tr class="clickable-row <?php if ($row['priority'] != 0){ echo 'danger'; } ?>" data-href="/job/?sgs=<?=$row['sgs_num']?>">
                                <td><?=$row['sgs_num']?></td>
                                <td><?=substr($row['site_name'],0,15)?></td>
                                <td><?=timeAgo(strtotime($row['overall_status_date']))?></td>
                                <td><?=$row['job_type']?></td>
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
                            <th colspan="5" class="text-center">Reports Being Written <?php if ($dashTable['reportWritten']!= false){ echo '('. count($dashTable['reportWritten']). ')'; } ?></th>
                        </tr>
                        <tr>
                            <th class="col-xs-2">SGS#</th>
                            <th class="col-xs-3">Site</th>
                            <th class="col-xs-3">TS-AA</th>
                            <th class="col-xs-3">Author</th>
                            <th class="col-xs-1">Level</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($dashTable['reportWritten'] as $row){?>
                            <tr class="clickable-row <?php if ($row['priority'] != 0){ echo 'danger'; } ?>" data-href="/job/?sgs=<?=$row['sgs_num']?>">
                                <td><?=$row['sgs_num']?></td>
                                <td><?=substr($row['site_name'],0,15)?></td>
                                <td>
                                    <?php if (strtotime($row['closeout_status_date']) > strtotime($row['inspection_status_date'])) {
                                        echo timeAgo(strtotime($row['closeout_status_date']));
                                    }else{
                                        echo timeAgo(strtotime($row['inspection_status_date']));
                                    }
                                    ?>
                                </td>
                                <td><?=$row['fname']?> <?=$row['lname']?></td>
                                <td><?php if ($row['report_level'] != ''){ ?><i class="fa fa-shield"></i> <?php echo ' ' . $row['report_level']; } ?></td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                    <br>
                    <table class="table table-condensed table-dash table-hover table-bordered small">
                        <thead>
                            <tr>
                                <th colspan="5" class="text-center">Closeout & Punch Approved <?php if ($dashTable['approved']!= false){ echo '('. count($dashTable['approved']). ')'; } ?></th>
                            </tr>
                            <tr>
                                <th class="col-xs-2">SGS#</th>
                                <th class="col-xs-3">Site</th>
                                <th class="col-xs-3">TS-AA</th>
                                <th class="col-xs-3">Status</th>
                                <th class="col-xs-1">Level</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach($dashTable['approved'] as $row){?>
                            <tr class="clickable-row <?php if ($row['priority'] != 0){ echo 'danger'; } ?>" data-href="/job/?sgs=<?=$row['sgs_num']?>">
                                <td><?=$row['sgs_num']?></td>
                                <td><?=substr($row['site_name'],0,15)?></td>
                                <td>
                                <?php if (strtotime($row['closeout_status_date']) > strtotime($row['inspection_status_date'])) {
                                    echo timeAgo(strtotime($row['closeout_status_date']));
                                }else{
                                    echo timeAgo(strtotime($row['inspection_status_date']));

                                }
                                ?>
                                </td>
                                <td><?=$row['report_status']?></td>
                                <td><?php if ($row['report_level'] != ''){ ?><i class="fa fa-shield"></i> <?php echo ' ' . $row['report_level']; } ?></td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                    <br>
                    <table class="table table-condensed table-dash table-hover table-bordered small">
                        <thead>
                            <tr>
                                <th colspan="5" class="text-center">Ready for Seal <?php if ($dashTable['sealReady']!= false){ echo '('. count($dashTable['sealReady']). ')'; } ?></th>
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
                                <td class="clickable-row" data-href="/job/?sgs=<?=$row['sgs_num']?>"><?=$row['sgs_num']?></td>
                                <td class="clickable-row" data-href="/job/?sgs=<?=$row['sgs_num']?>"><?=substr($row['site_name'],0,15)?></td>
                                <td class="clickable-row" data-href="/job/?sgs=<?=$row['sgs_num']?>"><?=$row['state']?></td>
                                <td class="clickable-row" data-href="/job/?sgs=<?=$row['sgs_num']?>"><?=$row['job_type']?></td>
                                <td>
                                    <a href="/download/report/?sgs=<?=$row['sgs_num']?>&site=<?=$row['site_num']?>&state=<?=$row['state']?>" target="_blank"><i class="fa fa-download"></i></a>
                                    <?=reportSize($row['sgs_num'],$row['site_num'],$row['state'])?>
                                </td>
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
                                <th class="col-xs-3">State</th>
                                <th class="col-xs-4">Job Type</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach($dashTable['sealed'] as $row){?>
                            <tr class="clickable-row <?php if ($row['priority'] != 0){ echo 'danger'; } ?>" data-href="/job/?sgs=<?=$row['sgs_num']?>">
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
