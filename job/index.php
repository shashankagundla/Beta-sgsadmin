<?php
/*
 * Page Setup
 */
require_once("../includes/init.php");
//Page Variables
$sgs = $_GET["sgs"];
/*
 * Init job class and get info
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
if ($j['priority']){
    $page .= '  <span class="label label-danger">Priority Job</span>';
}

$form = new Form();
$allSelect = $form->allSelectFields();
echo $template->header($page);
?>
    <div class="row">
        <div class="col-xs-12 col-md-12 col-lg-7 col-lg-push-2">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="panel-title">Edit</div>
                </div>
                <div class="panel-content">
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Status</a></li>
                        <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Revisions</a></li>
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Files
                                <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="javascript:window.open('/fm/?root=<?=filePath('quick',$j['sgs_num'],$j['site_num'],$j['state'])?>','QV - <?=$j['sgs_num']?>','width=750,height=750')")">Quick View</a></li>
                                <li><a href="<?=filePath('server',$j['sgs_num'],$j['site_num'],$j['state'])?>">Office/VPN Server</a></li>
                                <li><a href="javascript:window.open('<?=filePath('box',$j['sgs_num'],$j['site_num'],$j['state'])?>','SGS Box - <?=$j['sgs_num']?>','width=750,height=750')")">SGS Box</a></li>
                            </ul>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="home" style="padding: 5px;">
                            <form method="post" action="/includes/class/form.class.php">
                                <div class="row">
                                    <div class="col-sm-6 col-md-3 col-lg-3">
                                        <div class="form-group">
                                            <div>
                                                <label for="sgs">Crew</label>
                                                <span class="pull-right">
                                            </div>
                                            <select class="form-control input-sm" id="crew" name="crew" autocomplete="off">
                                                <option value="">Select</option>
                                                <?php
                                                foreach($form->selectCrew() as $key => $val){ ?>
                                                    <option value="<?php echo $val['id']; ?>" <?php if ($val['id'] === $j['crew_1']){ echo 'selected'; } ?>>
                                                        <?php echo $val['name']; ?></option><?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-3 col-lg-3">
                                        <div class="form-group">
                                            <label for="followUpDate">Est Date on Site</label>
                                            <input type="date" class="form-control input-sm" id="edos" name="edos" value="<?=$j['date_eos']?>">
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="col-sm-6 col-md-3 col-lg-3">
                                        <div class="form-group">
                                            <div>
                                                <label for="sgs">Job Status</label>
                                                <span class="pull-right">
                                            </div>
                                            <select class="form-control input-sm" id="jobStatus" name="jobStatus" autocomplete="off" <?php if($j['overall_status'] === 'Cancel' || $j['overall_status'] === 'Paid' || $j['overall_status'] === 'Pending' AND $_SESSION['user']['role'] > '4'){echo 'disabled';}?>>
                                                <?php
                                                foreach($allSelect as $key => $val){
                                                    if ($val['field'] === 'overallStatus'){;
                                                        ?>
                                                    <option value="<?php echo $val['selectID']; ?>" <?php if ($val['selectID'] === $j['overall_status']){ echo 'selected'; } ?>
                                                        <?php if($val['selectID'] === 'Pending' || $val['selectID'] === 'Cancel' || $val['selectID'] === 'Paid' AND $_SESSION['user']['role'] > '4'){ echo 'disabled'; }?>>
                                                        <?php echo $val['selectField']; ?></option><?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <?php if($_SESSION['user']['role'] === '7'){}else{?>
                                    <div class="col-sm-6 col-md-3 col-lg-3">
                                        <div class="form-group">
                                            <div>
                                                <label for="sgs">Closeout Status</label>
                                                <span class="pull-right">
                                            </div>
                                            <select class="form-control input-sm" id="closeoutStatus" name="closeoutStatus" autocomplete="off">
                                                <?php
                                                foreach($allSelect as $key => $val){
                                                    if ($val['field'] === 'closeoutStatus'){;
                                                        ?>
                                                    <option value="<?php echo $val['selectID']; ?>" <?php if ($val['selectID'] === $j['closeout_status']){ echo 'selected'; } ?>>
                                                        <?php echo $val['selectField']; ?></option><?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-3 col-lg-3">
                                        <div class="form-group">
                                            <div>
                                                <label for="sgs">Punch Status</label>
                                                <span class="pull-right">
                                            </div>
                                            <select class="form-control input-sm" id="punchStatus" name="punchStatus" autocomplete="off">
                                                <?php
                                                foreach($allSelect as $key => $val){
                                                    if ($val['field'] === 'inspectionStatus'){;
                                                        ?>
                                                    <option value="<?php echo $val['selectID']; ?>" <?php if ($val['selectID'] === $j['inspection_status']){ echo 'selected'; } ?>>
                                                        <?php echo $val['selectField']; ?></option><?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-3 col-lg-3">
                                        <div class="form-group">
                                            <div>
                                                <label for="sgs">Report Status</label>
                                                <span class="pull-right">
                                            </div>
                                            <select class="form-control input-sm" id="reportStatus" name="reportStatus" autocomplete="off">
                                                <?php
                                                foreach($allSelect as $key => $val){
                                                    if ($val['field'] === 'reportStatus'){;
                                                        ?>
                                                    <option value="<?php echo $val['selectID']; ?>" <?php if ($val['selectID'] === $j['report_status']){ echo 'selected'; } ?>>
                                                        <?php echo $val['selectField']; ?></option><?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-4 col-lg-4">
                                        <div class="form-group">
                                            <label for="appID">Missing Closeout #:</label>
                                            <input type="text" class="form-control input-sm" id="closeoutMissing" name="closeoutMissing" value="<?=$j['closeout_missing']?>">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-4 col-lg-4">
                                        <div class="form-group">
                                            <label for="appID">Waiting on Punch #:</label>
                                            <input type="text" class="form-control input-sm" id="punchMissing" name="punchMissing" value="<?=$j['inspection_missing']?>">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-3 col-lg-4">
                                        <div class="form-group">
                                            <div>
                                                <label for="sgs">Report Level</label>
                                                <span class="pull-right">
                                            </div>
                                            <select class="form-control input-sm" id="reportLevel" name="reportLevel" autocomplete="off">
                                                <option value="NULL">Select</option>
                                                <?php
                                                foreach($allSelect as $key => $val){
                                                    if ($val['field'] === 'reportLevel'){;
                                                        ?>
                                                    <option value="<?php echo $val['selectID']; ?>" <?php if ($val['selectID'] === $j['report_level']){ echo 'selected'; } ?>>
                                                        <?php echo $val['selectField']; ?></option><?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <?php } ?>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="form-group">
                                            <label for="comment">Status Notes</label>
                                            <textarea class="form-control input-sm" rows="4" id="statusNotes" name="statusNotes" <?php if($_SESSION['user']['role'] === '7'){ echo 'disabled';}?>><?=$j['status_notes']?></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="pull-right" style="padding-right: 20px;">
                                        <input type="hidden" name="id" value="<?=$j['id']?>">
                                        <button type="submit" class="btn btn-primary btn-sm" name="submit" value="updateJobStatus">Update</button>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </form>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="profile">...</div>
                        <div role="tabpanel" class="tab-pane" id="profile">...</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-md-6 col-lg-2 col-lg-pull-7">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="panel-title">Details</div>
                </div>
                <div class="panel-content">
                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                        <div class="panel panel-default panel-no-pad">
                            <div class="panel-heading text-center" role="tab" id="headingOne">
                                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    General
                                </a>
                            </div>
                            <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                                <div class="panel-body panel-no-pad small">
                                    <ul class="list-group ul-job">
                                        <li class="list-group-item">
                                            <strong>SGS#</strong>
                                            <span class="pull-right"><?=$j['sgs_num']?></span>
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Job Type</strong>
                                            <span class="pull-right"><?=$j['job_type']?></span>
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Revisit</strong>
                                            <span class="pull-right"><?=$j['revisit_num']?></span>
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Site #</strong>
                                            <span class="pull-right"><?=$j['site_num']?></span>
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Site Name</strong>
                                            <span class="pull-right"><?=$j['site_name']?></span>
                                        </li>
                                        <li class="list-group-item">
                                            <strong>District</strong>
                                            <span class="pull-right"><?=$j['district']?></span>
                                        </li>
                                        <li class="list-group-item">
                                            <strong>App ID</strong>
                                            <span class="pull-right"><?=$j['app_id']?></span>
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Drawing #</strong>
                                            <span class="pull-right"><?=$j['drawings_num']?></span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default panel-no-pad">
                            <div class="panel-heading text-center" role="tab" id="headingTwo">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    Tower
                                </a>
                            </div>
                            <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                                <div class="panel-body panel-no-pad small">
                                    <ul class="list-group ul-job">
                                        <li class="list-group-item">
                                            <strong>Latitude</strong>
                                            <span class="pull-right"><?=$j['latitude']?></span>
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Longitude</strong>
                                            <span class="pull-right"><?=$j['longitude']?></span>
                                        </li>
                                        <li class="list-group-item">
                                            <strong>State</strong>
                                            <span class="pull-right"><?=$j['state']?></span>
                                        </li>
                                        <li class="list-group-item">
                                            <strong>City</strong>
                                            <span class="pull-right"><?=$j['city']?></span>
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Tower Type</strong>
                                            <span class="pull-right"><?=$j['tower_type']?></span>
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Tower Height</strong>
                                            <span class="pull-right"><?=$j['tower_height']?></span>
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Tower Manufacturer</strong>
                                            <span class="pull-right"><?=$j['tower_man']?></span>
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Tower Owner</strong>
                                            <span class="pull-right"><?=$j['tower_owner']?></span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default panel-no-pad">
                            <div class="panel-heading text-center" role="tab" id="headingThree">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    Client/Contractor
                                </a>
                            </div>
                            <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                                <div class="panel-body panel-no-pad small">
                                    <ul class="list-group ul-job">
                                        <li class="list-group-item">
                                            <strong>Client Name</strong>
                                            <span class="pull-right"><?=$j['client_contact_email']?></span>
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Client Company</strong>
                                            <span class="pull-right"><?=$j['client_company']?></span>
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Contractor Name</strong>
                                            <span class="pull-right"><?=$j['contractor_contact_email']?></span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default panel-no-pad">
                            <div class="panel-heading text-center" role="tab" id="headingThree">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseThree">
                                    Finance/Billing
                                </a>
                            </div>
                            <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                                <div class="panel-body panel-no-pad small">
                                    <ul class="list-group ul-job">
                                        <li class="list-group-item">
                                            <strong>Budget</strong>
                                            <span class="pull-right">$<?=$j['budget']?></span>
                                        </li>
                                        <li class="list-group-item">
                                            <strong>PO #</strong>
                                            <span class="pull-right"><?=$j['po_num']?></span>
                                        </li>
                                        <li class="list-group-item">
                                            <strong>PO Line #</strong>
                                            <span class="pull-right"><?=$j['po_line']?></span>
                                        </li>
                                        <li class="list-group-item">
                                            <strong>WO #</strong>
                                            <span class="pull-right"><?=$j['wo_num']?></span>
                                        </li>
                                        <li class="list-group-item">
                                            <strong>JDE #</strong>
                                            <span class="pull-right"><?=$j['jde_num']?></span>
                                        </li>
                                        <li class="list-group-item">
                                            <strong>County</strong>
                                            <span class="pull-right"><?=$j['county']?></span>
                                        </li>
                                        <li class="list-group-item">
                                            <strong>SOE Entered</strong>
                                            <span class="pull-right"><? if ($j['soe'] != 1){ echo 'No'; }else{ echo 'Yes'; }?></span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xs-12 col-md-6 col-lg-3">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="panel-title">Comments</div>
                </div>
                <div class="actionBox">
                    <ul class="commentList">
                        <?php foreach($jobComments as $c){ ?>
                        <li>
                            <?php if (!$_SESSION['mobile']){?>
                            <div class="commenterImage">
                                <img src="https://lh4.googleusercontent.com/-oUozwkil0JM/AAAAAAAAAAI/AAAAAAAABoA/ShUKvKu0akQ/photo.jpg" />
                            </div>
                            <div class="commentText">
                            <?php } ?>
                                <p><?=nl2br($c['comment'])?></p>
                                <span class="date sub-text">By <?=$c['user']?> - <?=timeAgo(strtotime($c['date'])) ?></span>
                            <?php if (!$_SESSION['mobile']){?>
                            </div>
                            <?php } ?>
                        </li>
                        <hr>
                        <?php } ?>
                    </ul>
                    <form class="form-inline" role="form" method="post" action="/includes/class/form.class.php">
                        <div class="form-group">
                            <textarea class="form-control input-sm" rows="1" name="comment" placeholder="Quick Add Comment"></textarea>
                        </div>
                        <div class="form-group">
                            <input type="hidden" name="admin_id" value="<?=$j['id']?>">
                            <button type="submit" class="btn btn-primary btn-sm" name="submit" value="addCommentForm">Add</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

<?php
if ($_SESSION['user']['debug'] != 0) {
    echo '<pre>Job Info<br>' . var_export($j, true) . '<br>Job Comments<br>' .var_export($jobComments, true) . '</pre>';
}
/*
 * Page footer and notifications
 */
echo $template->footer();
echo $template->notify();
if ($_SESSION['mobile']){
    echo '<script> $("#collapseOne").collapse("hide"); </script>';
}
?>
