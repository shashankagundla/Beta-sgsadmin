<?php
/*
 * Page Setup
 */
require_once("../../includes/init.php");
/*
 * Init dashboard class and get required select field info
 */
$dash = New Dashboard();
$dashTable = $dash->dashATC();
$page = 'ATC Dashboard <span class="pull-right small"><span class="label label-default hidden-xs">PO: '.$dashTable['poTotal'].'</span><span class="label label-success hidden-xs">GO: '.$dashTable['goTotal'].' </span><span class="label label-primary hidden-xs">FWC: '.$dashTable['fwcTotal'].'</span></span>';
$subtitle = '';
echo $template->header($page,$subtitle);
?>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
            <div class="panel panel-primary panel-no-border">
                <div class="panel-heading">
                    <div class="panel-title">FWC</div>
                </div>
                <div class="panel-content">
                    <table class="table table-condensed table-dash table-hover table-bordered small">
                        <thead>
                            <tr>
                                <th colspan="5" class="text-center">Field Work Complete <?php if ($dashTable['fwc']!= false){ echo '('. count($dashTable['fwc']). ')'; } ?></th>
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
                                <tr class="clickable-row <?php if ($row['priority'] != 0){ echo 'danger'; } ?>" data-href="/job/?sgs=<?=$row['sgs_num']?>">
                                    <td><?=$row['sgs_num']?></td>
                                    <td><?=substr($row['site_name'],0,15)?></td>
                                    <td><?=timeAgo(strtotime($row['overall_status_date']))?></td>
                                    <td><?=$row['fname']?> <?=$row['lname']?></td>
                                    <td><?=$row['job_type']?> / <?=$row['tower_type']?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <br>
                    <table class="table table-condensed table-dash table-hover table-bordered small">
                        <thead>
                            <tr>
                                <th colspan="5" class="text-center">Reports Not Started <?php if ($dashTable['reportNotStarted']!= false){ echo '('. count($dashTable['reportNotStarted']). ')'; } ?></th>
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
                                <tr class="clickable-row <?php if ($row['priority'] != 0){ echo 'danger'; } ?>" data-href="/job/?sgs=<?=$row['sgs_num']?>">
                                    <td><?=$row['sgs_num']?></td>
                                    <td><?=substr($row['site_name'],0,15)?></td>
                                    <td><?=timeAgo(strtotime($row['overall_status_date']))?></td>
                                    <td><?=$row['fname']?> <?=$row['lname']?></td>
                                    <td><?=$row['job_type']?> / <?=$row['tower_type']?></td>
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
                    <div class="panel-title">Reports in Progress</div>
                </div>
                <div class="panel-content">
                    <table class="table table-condensed table-dash table-hover table-bordered small">
                        <thead>
                            <tr>
                                <th colspan="4" class="text-center">Reports Being Written <?php if ($dashTable['reportWritten']!= false){ echo '('. count($dashTable['reportWritten']). ')'; } ?></th>
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
                            <tr class="clickable-row <?php if ($row['priority'] != 0){ echo 'danger'; } ?>" data-href="/job/?sgs=<?=$row['sgs_num']?>">
                                <td><?=$row['sgs_num']?></td>
                                <td><?=substr($row['site_name'],0,15)?></td>
                                <td><?=$row['report_status']?></td>
                                <td><?=$row['fname']?> <?=$row['lname']?></td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                    <br>
                    <table class="table table-condensed table-dash table-hover table-bordered small">
                        <thead>
                            <tr>
                                <th colspan="4" class="text-center">In Review <?php if ($dashTable['reportReview']!= false){ echo '('. count($dashTable['reportReview']). ')'; } ?></th>
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
                            <tr class="clickable-row <?php if ($row['priority'] != 0){ echo 'danger'; } ?>" data-href="/job/?sgs=<?=$row['sgs_num']?>">
                                <td><?=$row['sgs_num']?></td>
                                <td><?=substr($row['site_name'],0,15)?></td>
                                <td><?=$row['report_status']?></td>
                                <td><?=timeAgo(strtotime($row['report_status_date']))?></td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                    <br>
                    <table class="table table-condensed table-dash table-hover table-bordered small">
                        <thead>
                            <tr>
                                <th colspan="4" class="text-center">Reports Started <?php if ($dashTable['reportStarted']!= false){ echo '('. count($dashTable['reportStarted']). ')'; } ?></th>
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
                            <tr class="clickable-row <?php if ($row['priority'] != 0){ echo 'danger'; } ?>" data-href="/job/?sgs=<?=$row['sgs_num']?>">
                                <td><?=$row['sgs_num']?></td>
                                <td><?=substr($row['site_name'],0,15)?></td>
                                <td><?=$row['job_type']?> / <?=$row['tower_type']?></td>
                                <td><?=timeAgo(strtotime($row['report_status_date']))?></td>

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
                    <div class="panel-title">Reports Completed</div>
                </div>
                <div class="panel-content">
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
                            <tr class="<?php if ($row['priority'] != 0){ echo 'danger'; } ?>" data-href="/job/?sgs=<?=$row['sgs_num']?>">
                                <td class="clickable-row" data-href="/job/?sgs=<?=$row['sgs_num']?>"><?=$row['sgs_num']?></td>
                                <td class="clickable-row" data-href="/job/?sgs=<?=$row['sgs_num']?>"><?=substr($row['site_name'],0,15)?></td>
                                <td class="clickable-row" data-href="/job/?sgs=<?=$row['sgs_num']?>"><?=$row['state']?></td>
                                <td class="clickable-row" data-href="/job/?sgs=<?=$row['sgs_num']?>"><?=$row['job_type']?> / <?=$row['tower_type']?></td>
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
                            <th colspan="4" class="text-center">Sealed in Box <?php if ($dashTable['sealed']!= false){ echo '('. count($dashTable['sealed']). ')'; } ?></th>
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
                                <td><?=$row['job_type']?> / <?=$row['tower_type']?></td>
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
