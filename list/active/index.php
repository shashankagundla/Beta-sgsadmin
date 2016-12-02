<?php
/*
 * Page Setup
 */
$page = 'Active Jobs';
require_once("../../includes/init.php");
echo $template->header($page,$subtitle);
$form = new Form();
$allSelect = $form->allSelectFields();
$clientSelect = $form->selectClients();
$contractorSelect = $form->selectContractors();
/*
 * Init schedule class and get required info
 */
?>
    <div class="row">
        <div class="table-padding">
            <table id="dt" class="table table-striped table-bordered table-condensed table-list" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th></th>
                    <th>SGS#</th>
                    <th>Site Name</th>
                    <th>Site#</th>
                    <th>Job Type</th>
                    <th>Status</th>
                    <th>District</th>
                    <th>Client</th>
                    <th>Contractor</th>
                    <th>Report</th>
                    <th>Closeout</th>
                    <th>Punch</th>
                    <th>Missing Closeout#</th>
                    <th>Waiting on Punch#</th>
                    <th>ATC Origin</th>
                    <th>Notes</th>
                    <th>Crew</th>
                    <th>Assigned To</th>
                    <th>Date Due</th>
                    <th>WO#</th>
                    <th>JDE#</th>
                    <th>PO#</th>
                    <th>PO Line#</th>
                    <th>Budget</th>
                    <th>Latitude</th>
                    <th>Longitude</th>
                    <th>State</th>
                    <th>City</th>
                    <th>County</th>
                    <th>T Type</th>
                    <th>T Height</th>
                    <th>T Man</th>
                    <th>T Owner</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
    <div class="modal" id="filterColumns" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Filter Columns</h4>
                </div>
                <div class="modal-body">
                    <div class="col-6-sm">
                        <table class="table table-striped table-bordered table-condensed table-list">
                            <thead>
                            <tr>
                                <th>Column Name</th>
                                <th>Filter Text</th>
                                <th>Display</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr id="filter_col1" data-column="1">
                                <td>SGS#</td>
                                <td align="center"><input type="text" class="column_filter" id="col1_filter"></td>
                                <td><input type="checkbox" name="checkbox1" id="checkbox1" class="toggle-vis" data-column="1" disabled></td>
                            </tr>
                            <tr id="filter_col2" data-column="2">
                                <td>Site Name</td>
                                <td align="center"><input type="text" class="column_filter" id="col2_filter"></td>
                                <td><input type="checkbox" name="checkbox2" id="checkbox2" class="toggle-vis" data-column="2"></td>
                            </tr>
                            <tr id="filter_col3" data-column="3">
                                <td>Site#</td>
                                <td align="center"><input type="text" class="column_filter" id="col3_filter"></td>
                                <td><input type="checkbox" name="checkbox3" id="checkbox3" class="toggle-vis" data-column="3"></td>
                            </tr>
                            <tr id="filter_col4" data-column="4">
                                <td>Job Type</td>
                                <td align="center">
                                    <select class="column_filter" id="col4_filter" autocomplete="off">
                                        <option value=""></option>
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
                                <td><input type="checkbox" name="checkbox4" id="checkbox4" class="toggle-vis" data-column="4"></td>
                            </tr>
                            <tr id="filter_col5" data-column="5">
                                <td>Status</td>
                                <td align="center">
                                    <select class="column_filter" id="col5_filter" autocomplete="off">
                                        <option value=""></option>
                                        <?php
                                        foreach($allSelect as $key => $val){
                                            if ($val['field'] === 'overallStatus'){;
                                                ?>
                                            <option value="<?php echo $val['selectID']; ?><?php ?>">
                                                <?php echo $val['selectField']; ?></option><?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </td>
                                <td><input type="checkbox" name="checkbox5" id="checkbox5" class="toggle-vis" data-column="5"></td>
                            </tr>
                            <tr id="filter_col6" data-column="6">
                                <td>District</td>
                                <td align="center"><input type="text" class="column_filter" id="col6_filter"></td>
                                <td><input type="checkbox" name="checkbox6" id="checkbox6" class="toggle-vis" data-column="6"></td>
                            </tr>
                            <tr id="filter_col7" data-column="7">
                                <td>Client</td>
                                <td align="center"><input type="text" class="column_filter" id="col7_filter"></td>
                                <td><input type="checkbox" name="checkbox7" id="checkbox7" class="toggle-vis" data-column="7"></td>
                            </tr>
                            <tr id="filter_col8" data-column="8">
                                <td>Contractor</td>
                                <td align="center"><input type="text" class="column_filter" id="col8_filter"></td>
                                <td><input type="checkbox" name="checkbox8" id="checkbox8" class="toggle-vis" data-column="8"></td>
                            </tr>
                            <tr id="filter_col9" data-column="9">
                                <td>Report</td>
                                <td align="center">
                                    <select class="column_filter" id="col9_filter" autocomplete="off">
                                        <option value=""></option>
                                        <?php
                                        foreach($allSelect as $key => $val){
                                            if ($val['field'] === 'reportStatus'){;
                                                ?>
                                            <option value="<?php echo $val['selectID']; ?><?php ?>">
                                                <?php echo $val['selectField']; ?></option><?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </td>
                                <td><input type="checkbox" name="checkbox9" id="checkbox9" class="toggle-vis" data-column="9"></td>
                            </tr>
                            <tr id="filter_col10" data-column="10">
                                <td>Closeout</td>
                                <td align="center">
                                    <select class="column_filter" id="col10_filter" autocomplete="off">
                                        <option value=""></option>
                                        <?php
                                        foreach($allSelect as $key => $val){
                                            if ($val['field'] === 'closeoutStatus'){;
                                                ?>
                                            <option value="<?php echo $val['selectID']; ?><?php ?>">
                                                <?php echo $val['selectField']; ?></option><?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </td>
                                <td><input type="checkbox" name="checkbox10" id="checkbox10" class="toggle-vis" data-column="10"></td>
                            </tr>
                            <tr id="filter_col11" data-column="11">
                                <td>Punch</td>
                                <td align="center">
                                    <select class="column_filter" id="col11_filter" autocomplete="off">
                                        <option value=""></option>
                                        <?php
                                        foreach($allSelect as $key => $val){
                                            if ($val['field'] === 'inspectionStatus'){;
                                                ?>
                                            <option value="<?php echo $val['selectID']; ?><?php ?>">
                                                <?php echo $val['selectField']; ?></option><?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </td>
                                <td><input type="checkbox" name="checkbox11" id="checkbox11" class="toggle-vis" data-column="11"></td>
                            </tr>
                            <tr id="filter_col12" data-column="12">
                                <td>Missing Closeout#</td>
                                <td align="center"><input type="text" class="column_filter" id="col12_filter"></td>
                                <td><input type="checkbox" name="checkbox12" id="checkbox12" class="toggle-vis" data-column="12"></td>
                            </tr>
                            <tr id="filter_col13" data-column="13">
                                <td>Waiting on Punch#</td>
                                <td align="center"><input type="text" class="column_filter" id="col13_filter"></td>
                                <td><input type="checkbox" name="checkbox13" id="checkbox13" class="toggle-vis" data-column="13"></td>
                            </tr>
                            <tr id="filter_col14" data-column="14">
                                <td>ATC Origin</td>
                                <td align="center"><input type="text" class="column_filter" id="col14_filter"></td>
                                <td><input type="checkbox" name="checkbox14" id="checkbox14" class="toggle-vis" data-column="14"></td>
                            </tr>
                            <tr id="filter_col15" data-column="15">
                                <td>Notes</td>
                                <td align="center"><input type="text" class="column_filter" id="col15_filter"></td>
                                <td><input type="checkbox" name="checkbox15" id="checkbox15" class="toggle-vis" data-column="15"></td>
                            </tr>
                            <tr id="filter_col16" data-column="16">
                                <td>Crew</td>
                                <td align="center"><input type="text" class="column_filter" id="col16_filter"></td>
                                <td><input type="checkbox" name="checkbox16" id="checkbox16" class="toggle-vis" data-column="16"></td>
                            </tr>
                            <tr id="filter_col16" data-column="17">
                                <td>Assigned To</td>
                                <td align="center"><input type="text" class="column_filter" id="col17_filter"></td>
                                <td><input type="checkbox" name="checkbox17" id="checkbox17" class="toggle-vis" data-column="17"></td>
                            </tr>
                            <tr id="filter_col15" data-column="18">
                                <td>Date Due</td>
                                <td align="center"><input type="text" class="column_filter" id="col18_filter"></td>
                                <td><input type="checkbox" name="checkbox18" id="checkbox18" class="toggle-vis" data-column="18"></td>
                            </tr>
                            <tr id="filter_col15" data-column="19">
                                <td>WO#</td>
                                <td align="center"><input type="text" class="column_filter" id="col19_filter"></td>
                                <td><input type="checkbox" name="checkbox19" id="checkbox19" class="toggle-vis" data-column="19"></td>
                            </tr>
                            <tr id="filter_col15" data-column="20">
                                <td>JDE#</td>
                                <td align="center"><input type="text" class="column_filter" id="col20_filter"></td>
                                <td><input type="checkbox" name="checkbox20" id="checkbox20" class="toggle-vis" data-column="20"></td>
                            </tr>
                            <tr id="filter_col15" data-column="21">
                                <td>PO#</td>
                                <td align="center"><input type="text" class="column_filter" id="col21_filter"></td>
                                <td><input type="checkbox" name="checkbox21" id="checkbox21" class="toggle-vis" data-column="21"></td>
                            </tr>
                            <tr id="filter_col15" data-column="22">
                                <td>PO Line#</td>
                                <td align="center"><input type="text" class="column_filter" id="col22_filter"></td>
                                <td><input type="checkbox" name="checkbox22" id="checkbox22" class="toggle-vis" data-column="22"></td>
                            </tr>
                            <tr id="filter_col15" data-column="23">
                                <td>Budget</td>
                                <td align="center"><input type="text" class="column_filter" id="col23_filter"></td>
                                <td><input type="checkbox" name="checkbox23" id="checkbox23" class="toggle-vis" data-column="23"></td>
                            </tr>
                            <tr id="filter_col15" data-column="24">
                                <td>Latitude</td>
                                <td align="center"><input type="text" class="column_filter" id="col24_filter"></td>
                                <td><input type="checkbox" name="checkbox24" id="checkbox24" class="toggle-vis" data-column="24"></td>
                            </tr>
                            <tr id="filter_col15" data-column="25">
                                <td>Longitude</td>
                                <td align="center"><input type="text" class="column_filter" id="col25_filter"></td>
                                <td><input type="checkbox" name="checkbox25" id="checkbox25" class="toggle-vis" data-column="25"></td>
                            </tr>
                            <tr id="filter_col15" data-column="26">
                                <td>State</td>
                                <td align="center"><input type="text" class="column_filter" id="col26_filter"></td>
                                <td><input type="checkbox" name="checkbox26" id="checkbox26" class="toggle-vis" data-column="26"></td>
                            </tr>
                            <tr id="filter_col15" data-column="27">
                                <td>City</td>
                                <td align="center"><input type="text" class="column_filter" id="col27_filter"></td>
                                <td><input type="checkbox" name="checkbox27" id="checkbox27" class="toggle-vis" data-column="27"></td>
                            </tr>
                            <tr id="filter_col15" data-column="28">
                                <td>County</td>
                                <td align="center"><input type="text" class="column_filter" id="col28_filter"></td>
                                <td><input type="checkbox" name="checkbox28" id="checkbox28" class="toggle-vis" data-column="28"></td>
                            </tr>
                            <tr id="filter_col15" data-column="29">
                                <td>Tower Type</td>
                                <td align="center"><input type="text" class="column_filter" id="col29_filter"></td>
                                <td><input type="checkbox" name="checkbox29" id="checkbox29" class="toggle-vis" data-column="29"></td>
                            </tr>
                            <tr id="filter_col15" data-column="30">
                                <td>Tower Height</td>
                                <td align="center"><input type="text" class="column_filter" id="col30_filter"></td>
                                <td><input type="checkbox" name="checkbox30" id="checkbox30" class="toggle-vis" data-column="30"></td>
                            </tr>
                            <tr id="filter_col15" data-column="31">
                                <td>Tower Manufacturer</td>
                                <td align="center"><input type="text" class="column_filter" id="col31_filter"></td>
                                <td><input type="checkbox" name="checkbox31" id="checkbox31" class="toggle-vis" data-column="31"></td>
                            </tr>
                            <tr id="filter_col15" data-column="32">
                                <td>Tower Owner</td>
                                <td align="center"><input type="text" class="column_filter" id="col32_filter"></td>
                                <td><input type="checkbox" name="checkbox32" id="checkbox32" class="toggle-vis" data-column="32"></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


<?php
if ($_SESSION['user']['debug'] != 0) {
    echo '<pre>Select Array<br>' . var_export($allSelect, true) . '</pre>';
}
/*
 * Page footer and notifications
 */
echo $template->footer();
echo $template->notify();
?>
<script src="/assets/js/datatables.min.js"></script>
<script>
    function filterColumn ( i ) {
        $('#dt').DataTable().column( i+':name' ).search(
            $('#col'+i+'_filter').val()
        ).draw();
    }
    var editor; // use a global for the submit and return data rendering in the examples
    $(document).ready(function() {
        editor = new $.fn.dataTable.Editor( {
            ajax: "/includes/queries/active.table.php",
            table: "#dt",
            fields: [
                    {
                        type: "hidden",
                        name: "admin_jobs.updated",
                        def: 0
                    },
                    {
                        type: "hidden",
                        name: "admin_jobs.updated_by",
                        def: 0
                    },
                    {
                    label: "Job Status:",
                    name: "admin_jobs.overall_status",
                    type: "select2",
                    options: [
                        <?php
                        foreach ($allSelect as $key => $val) {
                            if ($val['field'] === 'overallStatus') {
                                echo '{ label: "' . $val['selectField'] . '"' . ', value: "' . $val['selectID'] . '"},';
                            }
                        }
                        ?>
                    ]
                    },
                    {
                    label: "Report Status:",
                    name: "admin_jobs.report_status",
                    type: "select2",
                    options: [
                        <?php
                        foreach ($allSelect as $key => $val) {
                            if ($val['field'] === 'reportStatus') {
                                echo '{ label: "' . $val['selectField'] . '"' . ', value: "' . $val['selectID'] . '"},';
                            }
                        }
                        ?>
                    ]
                    }, {
                        label: "Closeout Status:",
                        name: "admin_jobs.closeout_status",
                        type: "select2",
                        options: [
                            <?php
                            foreach ($allSelect as $key => $val) {
                                if ($val['field'] === 'closeoutStatus') {
                                    echo '{ label: "' . $val['selectField'] . '"' . ', value: "' . $val['selectID'] . '"},';
                                }
                            }
                            ?>
                        ]
                    }, {
                        label: "Punch Status:",
                        name: "admin_jobs.inspection_status",
                        type: "select2",
                        options: [
                            <?php
                            foreach ($allSelect as $key => $val) {
                                if ($val['field'] === 'inspectionStatus') {
                                    echo '{ label: "' . $val['selectField'] . '"' . ', value: "' . $val['selectID'] . '"},';
                                }
                            }
                            ?>
                        ]
                    },
                    {
                        label: "Client:",
                        name: "admin_jobs.client_contact_email",
                        type: "select2",
                        options: [
                            <?php
                            foreach ($clientSelect as $key => $val) {
                                echo '{ label: "' . $val['display_name'] . '"' . ', value: "' . $val['ID'] . '"},';
                            }
                            foreach ($contractorSelect as $key => $val) {
                                echo '{ label: "' . $val['display_name'] . '"' . ', value: "' . $val['ID'] . '"},';
                            }
                            ?>
                        ]

                    },{
                        label: "Contractor:",
                        name: "admin_jobs.contractor_contact_email",
                    type: "select2",
                    options: [
                        <?php
                        foreach ($contractorSelect as $key => $val) {
                            echo '{ label: "' . $val['display_name'] . '"' . ', value: "' . $val['ID'] . '"},';
                        }
                        ?>
                    ]
                    }
                <?php
                //Super Admins Only
                if($_SESSION['user']['role'] === '1'){?>
                    ,{
                        label: "District:",
                        name: "admin_jobs.district"
                    },
                    {
                        label: "SGS#:",
                        name: "admin_jobs.sgs_num"
                    }, {
                        label: "Site Name:",
                        name: "admin_jobs.site_name"
                    }, {
                        label: "Site#:",
                        name: "admin_jobs.site_num"
                    }, {
                        label: "Job Type:",
                        name: "admin_jobs.job_type"
                    },
                    {
                        label: "M-C#:",
                        name: "admin_jobs.closeout_missing"
                    }, {
                        label: "M-P#",
                        name: "admin_jobs.inspection_missing"
                    }, {
                        label: "ATC Origin:",
                        name: "admin_jobs.atc_origin"
                    }, {
                        label: "Status Notes:",
                        name: "admin_jobs.status_notes"
                    }
                <?php }?>
            ]
        } );
        editor
            .on( 'open', function () {
                interval = setInterval( function () {
                    editor.field('admin_jobs.updated').val('<?=date('Y-m-d H:i:s',time())?>');
                    editor.field('admin_jobs.updated_by').val(<?=$_SESSION['user']['id']?>);
                })
        });

        var dt = $('#dt').DataTable( {
            dom:
            "<'row'<'col-sm-3'l><'col-sm-6 text-center'B><'col-sm-3'i>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            ajax: {
                url: "/includes/queries/active.table.php",
                type: "POST"
            },
            serverSide: true,
            stateSave: true,
            stateDuration: 221198760,
            lengthMenu: [[20, 50, 100, 250, 500], [20, 50, 100, 250, 500]],
            columnDefs: [{
                orderable: false,
                searchable: false,
                className: 'select-checkbox',
                data: null,
                defaultContent: '',
                targets: 0
                },
                {   name: "1",
                    data: "admin_jobs.sgs_num",
                    targets: 1,
                    render: function ( data, type, full, meta ) {
                        return '<a href="/job/?sgs='+data+'">'+data+'</a>';
                    }
                },
                { name: "2", data: "admin_jobs.site_name", targets: 2 },
                { name: "3", data: "admin_jobs.site_num", targets: 3 },
                { name: "4", data: "admin_jobs.job_type", targets: 4 },
                { name: "5", data: "admin_jobs.overall_status", targets: 5 },
                { name: "6", data: "admin_jobs.district", targets: 6 },
                { name: "7", data: "client.display_name", targets: 7 },
                { name: "8", data: "contractor.display_name", targets: 8 },
                { name: "9", data: "admin_jobs.report_status", targets: 9 },
                { name: "10", data: "admin_jobs.closeout_status", targets: 10 },
                { name: "11", data: "admin_jobs.inspection_status", targets: 11 },
                { name: "12", data: "admin_jobs.closeout_missing", visible: false, targets: 12 },
                { name: "13", data: "admin_jobs.inspection_missing", visible: false, targets: 13 },
                { name: "14", data: "admin_jobs.atc_origin", visible: false, targets: 14 },
                { name: "15", data: "admin_jobs.status_notes", "width": "15%", targets: 15 },
                { name: "16", data: "crew.display_name", visible: false, targets: 16 },
                { name: "17", data: "assigned.display_name", visible: false, targets: 17 },
                { name: "18", data: "admin_jobs.date_due", visible: false, targets: 18 },
                { name: "19", data: "admin_jobs.wo_num", visible: false, targets: 19 },
                { name: "20", data: "admin_jobs.jde_num", visible: false, targets: 20 },
                { name: "21", data: "admin_jobs.po_num", visible: false, targets: 21 },
                { name: "22", data: "admin_jobs.po_line", visible: false, targets: 22 },
                { name: "23", data: "admin_jobs.budget", visible: false, targets: 23 },
                { name: "24", data: "admin_jobs.latitude", visible: false, targets: 24 },
                { name: "25", data: "admin_jobs.longitude", visible: false, targets: 25 },
                { name: "26", data: "admin_jobs.state", visible: false, targets: 26 },
                { name: "27", data: "admin_jobs.city", visible: false, targets: 27 },
                { name: "28", data: "admin_jobs.county", visible: false, targets: 28 },
                { name: "29", data: "admin_jobs.tower_type", visible: false, targets: 29 },
                { name: "30", data: "admin_jobs.tower_height", visible: false, targets: 30 },
                { name: "31", data: "admin_jobs.tower_man", visible: false, targets: 31 },
                { name: "32", data: "admin_jobs.tower_owner", visible: false, targets: 32 }
            ],
            select: {
                style:    'multi',
                selector: 'td:first-child'
            },
            responsive: false,
            colReorder: true,
            fixedColumns: {
                leftColumns: 2
            },
            order: [[ 1, "desc" ]],
            buttons: [
                {
                    text: 'Filter / Display',
                    action: function () {
                        $('#filterColumns').modal('show')
                    }
                },
                { extend: "edit",   editor: editor },
                'copy', 'csv', 'excel', 'pdf',
                {
                    text: 'Reset',
                    action: function () {
                        dt.state.clear();
                        window.location.reload();
                    }
                }
            ]
        } );
        var state = dt.state.loaded();
        if ( state ) {
            dt.columns().eq( 0 ).each( function ( colIdx ) {
                var colSearch = state.columns[colIdx].search;
                if ( colSearch.search ) {
                    $('#col'+colIdx+'_filter').val( colSearch.search );
                }
                if ( dt.column( colIdx ).visible() ){
                    $('#checkbox'+colIdx).prop("checked", true);
                }
            } );
        }
        $('.column_filter').on( 'keyup click change', function () {
            filterColumn( $(this).parents('tr').attr('data-column') );
        } );
        $('input.toggle-vis').on( 'click', function (e) {
            var column = dt.column( $(this).attr('data-column') );
            column.visible( ! column.visible() );

        } );
    } );
</script>