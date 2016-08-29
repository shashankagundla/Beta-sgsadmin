<?php
/*
 * Page Setup
 */
require_once("../includes/init.php");
//Page Variables
$sgs = $_GET["sgs"];
/*
 * Init job class and get required info
 */
$job = new Job();
$j = $job->queryJob($sgs)[0];
//If job not found redirect back
if (!$j) {
    //notify end-user of failure
    $_SESSION['notify']['message'] = 'SGS# ' .$_GET['sgs']. ' was not found!';
    $_SESSION['notify']['type'] = 'danger';
    //redirect back & exit
    header('Location: /');
    exit;
}
$jobComments = $job->queryJobComments($j['id']);
$page = 'Job: '.$j['sgs_num'].' - '.$j['site_name'].' - '.$j['site_num'];

echo $template->header($page);
?>
    <div class="row">
        <div class="col-xs-12 col-md-6 col-lg-3">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="panel-title">Details</div>
                </div>
                <div class="panel-content">
                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingOne">
                                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    General
                                </a>
                            </div>
                            <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                                <div class="panel-body panel-nopad">
                                    <ul class="list-group ul-job">
                                        <li class="list-group-item">
                                            SGS#
                                            <span class="badge"><?=$j['sgs_num']?></span>
                                        </li>
                                        <li class="list-group-item">
                                            Job Type
                                            <span class="badge"><?=$j['job_type']?></span>
                                        </li>
                                        <li class="list-group-item">
                                            Revisit
                                            <span class="badge"><?=$j['revisit_num']?></span>
                                        </li>
                                        <li class="list-group-item">
                                            Site #
                                            <span class="badge"><?=$j['site_num']?></span>
                                        </li>
                                        <li class="list-group-item">
                                            Site Name
                                            <span class="badge"><?=$j['site_name']?></span>
                                        </li>
                                        <li class="list-group-item">
                                            District
                                            <span class="badge"><?=$j['district']?></span>
                                        </li>
                                        <li class="list-group-item">
                                            App ID
                                            <span class="badge"><?=$j['app_id']?></span>
                                        </li>
                                        <li class="list-group-item">
                                            Drawing #
                                            <span class="badge"><?=$j['drawings_num']?></span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingTwo">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    Tower
                                </a>
                            </div>
                            <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                                <div class="panel-body">
                                    <ul class="list-group ul-job">
                                        <li class="list-group-item">
                                            Latitude
                                            <span class="badge"><?=$j['latitude']?></span>
                                        </li>
                                        <li class="list-group-item">
                                            Longitude
                                            <span class="badge"><?=$j['longitude']?></span>
                                        </li>
                                        <li class="list-group-item">
                                            State
                                            <span class="badge"><?=$j['state']?></span>
                                        </li>
                                        <li class="list-group-item">
                                            City
                                            <span class="badge"><?=$j['city']?></span>
                                        </li>
                                        <li class="list-group-item">
                                            Tower Type
                                            <span class="badge"><?=$j['tower_type']?></span>
                                        </li>
                                        <li class="list-group-item">
                                            Tower Height
                                            <span class="badge"><?=$j['tower_height']?></span>
                                        </li>
                                        <li class="list-group-item">
                                            Tower Manufacturer
                                            <span class="badge"><?=$j['tower_man']?></span>
                                        </li>
                                        <li class="list-group-item">
                                            Tower Owner
                                            <span class="badge"><?=$j['tower_owner']?></span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingThree">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    Client/Contractor
                                </a>
                            </div>
                            <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                                <div class="panel-body">
                                    <ul class="list-group ul-job">
                                        <li class="list-group-item">
                                            Client Name
                                            <span class="badge"><?=$j['client_contact_email']?></span>
                                        </li>
                                        <li class="list-group-item">
                                            Client Company
                                            <span class="badge"><?=$j['client_company']?></span>
                                        </li>
                                        <li class="list-group-item">
                                            Contractor Name
                                            <span class="badge"><?=$j['contractor_contact_email']?></span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingThree">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseThree">
                                    Finance/Billing
                                </a>
                            </div>
                            <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                                <div class="panel-body panel-nopad">
                                    <ul class="list-group ul-job">
                                        <li class="list-group-item">
                                            Budget
                                            <span class="badge">$<?=$j['budget']?></span>
                                        </li>
                                        <li class="list-group-item">
                                            PO #
                                            <span class="badge"><?=$j['po_num']?></span>
                                        </li>
                                        <li class="list-group-item">
                                            PO Line #
                                            <span class="badge"><?=$j['po_line']?></span>
                                        </li>
                                        <li class="list-group-item">
                                            WO #
                                            <span class="badge"><?=$j['wo_num']?></span>
                                        </li>
                                        <li class="list-group-item">
                                            JDE #
                                            <span class="badge"><?=$j['jde_num']?></span>
                                        </li>
                                        <li class="list-group-item">
                                            County
                                            <span class="badge"><?=$j['county']?></span>
                                        </li>
                                        <li class="list-group-item">
                                            SOE Entered
                                            <span class="badge"><? if ($j['soe'] != 1){ echo 'No'; }else{ echo 'Yes'; }?></span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-md-6 col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="panel-title">Edit</div>
                </div>
                <div class="panel-content">
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Status</a></li>
                        <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Folder</a></li>
                        <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Revisions</a></li>
                    </ul>
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="home">...</div>
                        <div role="tabpanel" class="tab-pane" id="profile">...</div>
                        <div role="tabpanel" class="tab-pane" id="profile">...</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-md-6 col-lg-3">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="panel-title">Comments</div>
                </div>
                <? foreach($jobComments as $c){?>
                <div class="panel panel-default">
                    <div class="panel-body">
                        Panel content
                    </div>
                    <div class="panel-footer">
                        By <?=$c['user'] ?> on <?=$c['date'] ?>
                    </div>
                </div>
                <? } ?>
            </div>
        </div>
    </div>





<?php
if ($debug === 1) {
    echo '<pre>Job Info<br>' . var_export($j, true) . '<br>Job Comments<br>' .var_export($jobComments, true) . '</pre>';
}
/*
 * Page footer and notifications
 */
echo $template->footer();
echo $template->notify();
?>