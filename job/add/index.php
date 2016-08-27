<?php
/*
 * Page Setup
 */
$page = 'Add Job';
$subtitle = 'Fields marked with <span class="label label-danger">R</span> are required to create a new job.';
require_once("../../includes/init.php");
echo $template->header($page,$subtitle);

/*
 * Init form class and get required select field info
 */

$form = new Form();
$allSelect = $form->allSelectFields();
$clientSelect = $form->selectClients();
$contractorSelect = $form->selectContractors();
?>
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">Next SGS Number: </h3>
        </div>
        <form method="post" action="/includes/class/form.class.php">
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-6 col-md-3 col-lg-2">
                    <div class="form-group">
                        <div>
                            <label for="sgs">SGS #</label>
                            <span class="pull-right">
                                <span class="label label-danger">R</span>
                            </span>
                        </div>
                        <input type="number" min=140000 max=170000 step="any" class="form-control input-sm" id="sgs" name="sgs" autocomplete="off" required>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3 col-lg-2">
                    <div class="form-group">
                        <div>
                            <label for="sgs">Site Name</label>
                            <span class="pull-right">
                                <span class="label label-danger">R</span>
                            </span>
                        </div>
                        <input type="text" class="form-control input-sm" id="siteName" name="siteName" autocomplete="off" required>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3 col-lg-2">
                    <div class="form-group">
                        <div>
                            <label for="sgs">Site #</label>
                            <span class="pull-right">
                                <span class="label label-danger">R</span>
                            </span>
                        </div>
                        <input type="text" class="form-control input-sm" id="siteNumber" name="siteNumber" autocomplete="off" required>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3 col-lg-2">
                    <div class="form-group">
                        <label for="clientCompany">Client Company</label>
                        <input type="text" class="form-control input-sm" id="clientCompany" name="clientCompany" autocomplete="off">
                    </div>
                </div>
                <div class="col-sm-6 col-md-3 col-lg-2">
                    <div class="form-group">
                        <label for="clientContact">Client Contact</label>
                        <div class="input-group">
                        <span class="input-group-addon" id="basic-addon1"><a href="" tabindex="-1"><i class="fa fa-user-plus"></i></a></span>
                        <select class="form-control input-sm" id="clientContact" name="clientContact" autocomplete="off">
                            <option value="NULL">Select</option>
                            <option value="NULL" disabled>Only Client Users</option>
                            <?php
                            foreach($clientSelect as $key => $val){?>
                                <option value="<?php echo $val['ID']; ?><?php ?>">
                                <?php echo $val['display_name']; ?></option><?php
                            }
                            ?>
                            <option value="NULL" disabled>Contractors</option>
                            <?php
                            foreach($contractorSelect as $key => $val){?>
                            <option value="<?php echo $val['ID']; ?><?php ?>">
                                <?php echo $val['display_name']; ?></option><?php
                            }
                            ?>
                        </select>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3 col-lg-2">
                    <div class="form-group">
                        <div>
                            <label for="sgs">Job Status</label>
                            <span class="pull-right">
                                <span class="label label-danger">R</span>
                            </span>
                        </div>
                        <select class="form-control input-sm" id="overallStatus" name="overallStatus" autocomplete="off" required>
                            <option value="">Select</option>
                            <?php
                            foreach($allSelect as $key => $val){
                                if ($val['field'] === 'overallStatus'){;
                            ?>
                                <option value="<?php echo $val['selectID']; ?>" <?php if($val['selectID'] === 'Pending' || $val['selectID'] === 'Paid' || $val['selectID'] === 'Cancel' || $val['selectID'] === 'Pending' ){echo 'disabled';} ?>>
                                <?php echo $val['selectField']; ?></option><?php
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3 col-lg-2">
                    <div class="form-group">
                        <div>
                            <label for="sgs">Budget</label>
                            <span class="pull-right">
                                <span class="label label-danger">R</span>
                            </span>
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon" id="basic-addon1">$</span>
                            <input type="text" class="form-control input-sm" id="budget" name="budget" autocomplete="off" required>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3 col-lg-2">
                    <div class="form-group">
                        <div>
                            <label for="sgs">State</label>
                            <span class="pull-right">
                                <span class="label label-danger">R</span>
                            </span>
                        </div>
                        <select class="form-control input-sm" id="state" name="state" autocomplete="off" required>
                            <option value="">Select</option>
                            <?php
                            foreach($allSelect as $key => $val){
                                if ($val['field'] === 'state'){;
                                    ?>
                                <option value="<?php echo $val['selectID']; ?><?php ?>">
                                    <?php echo $val['selectField']; ?></option><?php
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3 col-lg-2">
                    <div class="form-group">
                        <label for="city">City</label>
                        <input type="text" class="form-control input-sm" id="city" name="city" autocomplete="off">
                    </div>
                </div>
                <div class="col-sm-6 col-md-3 col-lg-2">
                    <div class="form-group">
                        <div>
                            <label for="sgs">Job Type</label>
                            <span class="pull-right">
                                <span class="label label-danger">R</span>
                            </span>
                        </div>
                        <select class="form-control input-sm" id="jobType" name="jobType" autocomplete="off" required>
                            <option value="">Select</option>
                            <?php
                            foreach($allSelect as $key => $val){
                                if ($val['field'] === 'jobType'){;
                                    ?>
                                <option value="<?php echo $val['selectID']; ?><?php ?>">
                                    <?php echo $val['selectField']; ?></option><?php
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3 col-lg-2">
                    <div class="form-group">
                        <label for="visit">Visit #</label>
                        <select class="form-control input-sm" id="visit" name="visit" autocomplete="off">
                            <option value="NULL">Select</option>
                            <?php
                            foreach($allSelect as $key => $val){
                                if ($val['field'] === 'visit'){;
                                    ?>
                                <option value="<?php echo $val['selectID']; ?><?php ?>">
                                    <?php echo $val['selectField']; ?></option><?php
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3 col-lg-2">
                    <div class="form-group">
                        <label for="towerType">Tower Type</label>
                        <select class="form-control input-sm" id="towerType" name="towerType" autocomplete="off">
                            <option value="NULL">Select</option>
                            <?php
                            foreach($allSelect as $key => $val){
                                if ($val['field'] === 'towerType'){;
                                    ?>
                                <option value="<?php echo $val['selectID']; ?><?php ?>">
                                    <?php echo $val['selectField']; ?></option><?php
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3 col-lg-2">
                    <div class="form-group">
                        <label for="towerHeight">Height</label>
                        <input type="text" class="form-control input-sm" id="towerHeight" name="towerHeight" autocomplete="off">
                    </div>
                </div>
                <div class="col-sm-6 col-md-3 col-lg-2">
                    <div class="form-group">
                        <label for="towerManufacturer">Tower Manufacturer</label>
                        <input type="text" class="form-control input-sm" id="towerManufacturer" name="towerManufacturer" autocomplete="off">
                    </div>
                </div>
                <div class="col-sm-6 col-md-3 col-lg-2">
                    <div class="form-group">
                        <label for="towerOwner">Tower Owner</label>
                        <select class="form-control input-sm" id="towerOwner" name="towerOwner" autocomplete="off">
                            <option value="NULL">Select</option>
                            <?php
                            foreach($allSelect as $key => $val){
                                if ($val['field'] === 'towerOwner'){;
                                    ?>
                                <option value="<?php echo $val['selectID']; ?><?php ?>">
                                    <?php echo $val['selectField']; ?></option><?php
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3 col-lg-2">
                    <div class="form-group">
                        <label for="district">District</label>
                        <input type="text" class="form-control input-sm" id="district" name="district" autocomplete="off">
                    </div>
                </div>
                <div class="col-sm-6 col-md-3 col-lg-2">
                    <div class="form-group">
                        <label for="po">PO #</label>
                        <input type="text" class="form-control input-sm" id="po" name="po" autocomplete="off">
                    </div>
                </div>
                <div class="col-sm-6 col-md-3 col-lg-2">
                    <div class="form-group">
                        <label for="poLine">PO Line #</label>
                        <input type="text" class="form-control input-sm" id="poLine" name="poLine" autocomplete="off">
                    </div>
                </div>
                <div class="col-sm-6 col-md-3 col-lg-2">
                    <div class="form-group">
                        <label for="latitude">Latitude</label>
                        <input type="text" class="form-control input-sm" id="latitude" name="latitude" autocomplete="off">
                    </div>
                </div>
                <div class="col-sm-6 col-md-3 col-lg-2">
                    <div class="form-group">
                        <label for="longitude">Longitude</label>
                        <input type="text" class="form-control input-sm" id="longitude" name="longitude" autocomplete="off">
                    </div>
                </div>
                <div class="col-sm-6 col-md-3 col-lg-2">
                    <div class="form-group">
                        <label for="contractor">Contractor</label>
                        <select class="form-control input-sm" id="contractor" name="contractor" autocomplete="off">
                            <option value="NULL">Select</option>
                            <?php
                            foreach($contractorSelect as $key => $val){?>
                            <option value="<?php echo $val['ID']; ?><?php ?>">
                                <?php echo $val['display_name']; ?></option><?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3 col-lg-2">
                    <div class="form-group">
                        <label for="wo">WO #</label>
                        <input type="text" class="form-control input-sm" id="wo" name="wo" autocomplete="off">
                    </div>
                </div>
                <div class="col-sm-6 col-md-3 col-lg-2">
                    <div class="form-group">
                        <label for="jde">JDE #</label>
                        <input type="text" class="form-control input-sm" id="jde" name="jde" autocomplete="off">
                    </div>
                </div>
                <div class="col-sm-6 col-md-3 col-lg-2">
                    <div class="form-group">
                        <label for="drawing">Drawing #</label>
                        <input type="text" class="form-control input-sm" id="drawing" name="drawing" autocomplete="off">
                    </div>
                </div>
                <div class="col-sm-6 col-md-3 col-lg-2">
                    <div class="form-group">
                        <label for="dueDate">Job Due Date</label>
                        <select class="form-control input-sm" id="dueDate" name="dueDate" autocomplete="off">

                            <?php
                            /*
                             * TODO: OMG, Please fix this shitty shit.
                             */
                            $t = new DateTime('NOW');
                            ?>
                            <option value="<?php echo $t->format('D, M j '); ?>"><?php echo $t->format('D, M j '); ?></option>
                            <?php $t->modify('+1 weekday'); ?>
                            <option value="<?php echo $t->format('D, M j '); ?>"><?php echo $t->format('D, M j '); ?></option>
                            <?php $t->modify('+1 weekday'); ?>
                            <option value="<?php echo $t->format('D, M j '); ?>"><?php echo $t->format('D, M j '); ?></option>
                            <?php $t->modify('+1 weekday'); ?>
                            <option value="<?php echo $t->format('D, M j '); ?>"><?php echo $t->format('D, M j '); ?></option>
                            <?php $t->modify('+1 weekday'); ?>
                            <option value="<?php echo $t->format('D, M j '); ?>"><?php echo $t->format('D, M j '); ?></option>
                            <?php $t->modify('+1 weekday'); ?>
                            <option value="<?php echo $t->format('D, M j '); ?>"><?php echo $t->format('D, M j '); ?></option>
                            <?php $t->modify('+1 weekday'); ?>
                            <option value="<?php echo $t->format('D, M j '); ?>"><?php echo $t->format('D, M j '); ?></option>
                            <?php $t->modify('+1 weekday'); ?>
                            <option value="<?php echo $t->format('D, M j '); ?>"><?php echo $t->format('D, M j '); ?></option>
                            <?php $t->modify('+1 weekday'); ?>
                            <option value="<?php echo $t->format('D, M j '); ?>"><?php echo $t->format('D, M j '); ?></option>
                            <?php $t->modify('+1 weekday'); ?>
                            <option value="<?php echo $t->format('D, M j '); ?>"><?php echo $t->format('D, M j '); ?></option>
                            <?php $t->modify('+1 weekday'); ?>
                            <option value="<?php echo $t->format('D, M j '); ?>"><?php echo $t->format('D, M j '); ?></option>
                            <?php $t->modify('+1 weekday'); ?>
                            <option value="<?php echo $t->format('D, M j '); ?>"><?php echo $t->format('D, M j '); ?></option>
                            <?php $t->modify('+1 weekday'); ?>
                            <option value="<?php echo $t->format('D, M j '); ?>"><?php echo $t->format('D, M j '); ?></option>
                            <?php $t->modify('+1 weekday'); ?>
                            <option value="<?php echo $t->format('D, M j '); ?>" selected="selected"><?php echo $t->format('D, M j '); ?></option>
                            <?php $t->modify('+1 weekday'); ?>
                            <option value="<?php echo $t->format('D, M j '); ?>" selected="selected"><?php echo $t->format('D, M j '); ?></option>
                            <?php $t->modify('+1 weekday'); ?>
                            <option value="<?php echo $t->format('D, M j '); ?>" selected="selected"><?php echo $t->format('D, M j '); ?></option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <div class="form-group">
                        <label for="comment">Add Comment to Job</label>
                        <textarea class="form-control input-sm" rows="2" id="comment" name="comment" autocomplete="off"></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel-footer">
            <div class="pull-left">
                <button type="reset" class="btn btn-default btn-sm" name="submit" value="addJob">Clear Form</button>
            </div>
            <div class="pull-right">
                <button type="submit" class="btn btn-primary btn-sm" name="submit" value="addJob">Create Job</button>
            </div>
            <div class="clearfix"></div>
        </div>
        </form>
    </div>
<?php
echo $template->footer();
echo $template->notify();
?>