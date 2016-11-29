<?php
/*
 * Page Setup
 */
require_once("../../includes/init.php");
echo $template->header();

/*
 * Init schedule class and get required info
 */

?>
    <div class="row">
        <div class="table-padding">
            <table id="dt" class="table table-striped table-bordered table-condensed table-list" cellspacing="0" width="100%">
                <thead>
                <tr>
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
                </tr>
                </thead>
                <tfoot>
                <tr>
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
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
<?php
/*
 * Page footer and notifications
 */
echo $template->footer();
echo $template->notify();
?>
<script src="/assets/js/datatables.min.js"></script>
<script>
    var editor; // use a global for the submit and return data rendering in the examples

    $(document).ready(function() {
        editor = new $.fn.dataTable.Editor( {
            ajax: "/includes/queries/inspection.table.php",
            table: "#dt",
            fields: [ {
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
            }, {
                label: "Job Status:",
                name: "admin_jobs.overall_status"
            }, {
                label: "District:",
                name: "admin_jobs.district"
            },{
                label: "Client:",
                name: "admin_jobs.client_contact_email"
            },{
                label: "Contractor:",
                name: "admin_jobs.contractor_contact_email"
            }, {
                label: "Report Status:",
                name: "admin_jobs.report_status"
            }, {
                label: "Closeout Status:",
                name: "admin_jobs.closeout_status"
            }, {
                label: "Punch Status:",
                name: "admin_jobs.inspection_status"
            }, {
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
            ]
        } );

        $('#dt tfoot th').each( function () {
            var title = $(this).text();
            $(this).html( '<input id="'+title+'" type="text" placeholder="Filter '+title+'" />' );
        } );

        var dt = $('#dt').DataTable( {
            dom:
            "<'row'<'col-sm-3'l><'col-sm-6 text-center'B><'col-sm-3'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            ajax: {
                url: "/includes/queries/inspection.table.php",
                type: "POST"
            },
            serverSide: true,
            lengthMenu: [[20, 50, 100, 250, 500], [20, 50, 100, 250, 500]],
            columns: [
                { data: "admin_jobs.sgs_num" },
                { data: "admin_jobs.site_name" },
                { data: "admin_jobs.site_num" },
                { data: "admin_jobs.job_type" },
                { data: "admin_jobs.overall_status" },
                { data: "admin_jobs.district" },
                { data: "admin_jobs.client_contact_email" },
                { data: "admin_jobs.contractor_contact_email" },
                { data: "admin_jobs.report_status" },
                { data: "admin_jobs.closeout_status" },
                { data: "admin_jobs.inspection_status" },
                { data: "admin_jobs.closeout_missing" },
                { data: "admin_jobs.inspection_missing" },
                { data: "admin_jobs.atc_origin" },
                { data: "admin_jobs.status_notes", "width": "15%" }
            ],
            select: true,
            responsive: true,
            buttons: [
                { extend: "edit",   editor: editor },
                'copy', 'csv', 'excel', 'pdf',
                'colvis'
            ],
            initComplete: function ()
            {
                var r = $('#dt tfoot tr');
                r.find('th').each(function(){
                    $(this).css('padding', 8);
                });
                $('#dt thead').append(r);
                $('#search_0').css('text-align', 'center');
            }
        } );
        dt.columns().every( function () {
            var that = this;

            $( 'input', this.footer() ).on( 'keyup change', function () {
                if ( that.search() !== this.value ) {
                    that
                        .search( this.value )
                        .draw();
                }
            } );
        } );

    } );
</script>