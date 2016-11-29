<?php
/*
 * Page Setup
 */
$page = 'Custom Job Query';
require_once("../../includes/init.php");
echo $template->header($page);

/*
 * Init form class and get required select field info
 */

$form = new Form();
$allSelect = $form->allSelectFields();
$clientSelect = $form->selectClients();
$contractorSelect = $form->selectContractors();
$nextSGSNumb = $form->nextSGSNum();
?>
    <div class="row">
        <div class="col-sm-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Columns</h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-12 col-md-6 col-lg-4">
                            <div class="form-group">
                                <label for="clientContact">Column 1</label>
                                <div class="input-group">
                                    <select class="form-control input-sm" id="clientContact" name="clientContact" autocomplete="off">
                                        <option value="NULL"></option>
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
                        <div class="col-xs-12 col-md-6 col-lg-4">
                            <div class="form-group">
                                <label for="clientContact">Column 1</label>
                                <div class="input-group">
                                    <select class="form-control input-sm" id="clientContact" name="clientContact" autocomplete="off">
                                        <option value="NULL"></option>
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
                        <div class="col-xs-12 col-md-6 col-lg-4">
                            <div class="form-group">
                                <label for="clientContact">Column 1</label>
                                <div class="input-group">
                                    <select class="form-control input-sm" id="clientContact" name="clientContact" autocomplete="off">
                                        <option value="NULL"></option>
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
                        <div class="col-xs-12 col-md-6 col-lg-4">
                            <div class="form-group">
                                <label for="clientContact">Column 1</label>
                                <div class="input-group">
                                    <select class="form-control input-sm" id="clientContact" name="clientContact" autocomplete="off">
                                        <option value="NULL"></option>
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
                        <div class="col-xs-12 col-md-6 col-lg-4">
                            <div class="form-group">
                                <label for="clientContact">Column 1</label>
                                <div class="input-group">
                                    <select class="form-control input-sm" id="clientContact" name="clientContact" autocomplete="off">
                                        <option value="NULL"></option>
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
                        <div class="col-xs-12 col-md-6 col-lg-4">
                            <div class="form-group">
                                <label for="clientContact">Column 1</label>
                                <div class="input-group">
                                    <select class="form-control input-sm" id="clientContact" name="clientContact" autocomplete="off">
                                        <option value="NULL"></option>
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
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Query Terms</h3>
                </div>
                <div class="panel-body">

                </div>

            </div>
        </div>
        <div class="panel-footer">
            <div class="pull-right">
                <button type="submit" class="btn btn-primary btn-sm" name="submit" value="addJob">Run Query</button>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>

<?php
if ($_SESSION['user']['debug'] != 0) {
    echo '<pre>' . var_export($allSelect, true) . '</pre>';
}
/*
 * Page footer and notifications
 */
echo $template->footer();
echo $template->notify();
?>